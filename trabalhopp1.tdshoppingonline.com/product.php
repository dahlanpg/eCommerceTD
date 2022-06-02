<?php
  session_start();
  require "scripts/connectionMysql.php";
  require "scripts/products.php";
  $id = $_GET["idProduct"];
  $conn = connectionToMySQL();
  $product = getProductById($conn, $id);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>T&D - O maior eCommerce</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/stylesHeader.css?v=15">
  <link rel="stylesheet" type="text/css" href="css/stylesProduct.css?v=15">
  <link rel="stylesheet" type="text/css" href="css/stylesFooter.css?v=15">
  <link rel="stylesheet" type="text/css" href="css/stylesZoom.css?v=15">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/xzoom.css">
  <script src="scripts/xzoom.min.js"></script>
</head>

<body>
  <?php
    include "headerFull.php";
  ?>

  <div id="product-body">
    <div class="container-fluid mb-2 mt-2">
      <div class="row">
        <div class="col-md-5 ml-1" style="border: 1px solid #dedede; border-radius: 5px;">
          <div class="container">

            <section id="default" class="padding-top">
              <div class="row ml-2">
                <div class="large-12 column mt-2">
                  <hr style="width: 63vh">
                  <h3 style="margin-left: 25%;">Área de zoom</h3>
                </div>
                <hr style="width: 63vh">
                <div class="large-5 column">
                  <div class="xzoom-container">
                    <?php 
                      echo "<img class='xzoom' src='images/products/$product->category/$product->image1' xoriginal='images/products/$product->category/$product->image1' />";
                      echo "<div class='xzoom-thumbs'>";
                      echo "<a href='images/products/$product->category/$product->image1'>";
                      echo "<img class='xzoom-gallery' width='80' src='images/products/$product->category/$product->image1' xpreview='images/products/$product->category/$product->image1' title='$product->name'>
                            </a>";
                      if(isset($product->image2)){
                        echo "<a href='images/products/$product->category/$product->image2'>";
                        echo "  <img class='xzoom-gallery' width='80' src='images/products/$product->category/$product->image2' title='$product->name'>
                            </a>";
                      }else{
                        echo "<a href='images/products/$product->category/$product->image1'>";
                        echo "  <img class='xzoom-gallery' width='80' src='images/products/$product->category/$product->image1' title='$product->name'>
                            </a>";
                      }
                    ?>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <div class="col-xs-9">
              <ul class="menu-items">
                <li class="active" style="font-size: 1.5em; font-weight: bold">Detalhes do produto</li>
              </ul>
              <div style="width:100%;border-top:1px solid silver;">
                <p style="padding:15px;text-align:justify;">
                  <small>
            
                    <?php 
                      echo $product->description;
                    ?>

                  </small>
                </p>
                <small>
                  <ul>
                    <?php
                        echo $product->attributes;
                    ?>
                  </ul>
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 ml-5" style="border: 1px solid #dedede; border-radius: 5px;">
          <div class="container">
            <div class="row">
              <div class="col-xs-4 item-photo mt-5 mb-5">
                <?php 
                    echo "<img style='max-width:80%;' src='images/products/$product->category/$product->image1'>";
                 ?>
              </div>
              <div class="col-xs-5" style="border:0px solid gray;width:100%;">
                <?php 
                    echo "<h3>$product->offerTitle</h3>";
                    echo "<h5 style='color:#337ab7'>vendido por $product->manufacturer</h5>";
                 ?>
                <h6 class="title-price"><small>PREÇO/OFERTA</small></h6>
                <h3 style="margin-top:0px; text-decoration: line-through;"><?php 
                    if($product->oldprice != null)
                      echo "R$ $product->oldprice";
                 ?></h3>
                <h3 style="margin-top:0px; color: red; font-size: 1.4em; font-weight: bold;"><?php 
                    echo "R$ $product->price";
                 ?></h3>

                <div class="section" style="padding-bottom:20px;">
                  <h6 class="title-attr"><small>Estoque disponível: <?php echo $product->quantity ?> </small>
                  <h6 class="title-attr"><small></small></h6>
                  <div class="buttons-change-stock">
                    <div class="btn btn-danger"><span>-</span></div>
                    <?php
                      echo "<input class='form-control' max='$product->quantity' value='1' />"
                    ?>
                    <div style="width:6%;" class="btn btn-success"><span>+</span></div>
                  </div>
                </div>

                <div class="section" style="padding-bottom:20px;">
                <?php
                  echo "<button class='btn btn-success' onclick='goToCart($product->id)'>";
                  ?>
                    <span style="margin-right:10px" class="fa fa-cart-plus" aria-hidden="true"></span>
                    <span style="margin-right: 3.1%">Comprar</span>
                  </button>
                  <?php 
                    echo "<h6><a href='#' onclick='goToFavorite($product->id)' style='float:right;'>
                    <span class='fa fa-heart' style='cursor:pointer; margin-right:10px'>
                  </span>Adicionar aos favoritos</a></h6>";
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="scripts/buttonsQuantity.js"></script>
    <script type="text/javascript">

      function goToCart(idProduct){
        var xmlhttp = new XMLHttpRequest();
        var method = 'GET';
        var url = "scripts/addToCart.php?idProduct=" + idProduct;

        xmlhttp.open(method, url, true);
        xmlhttp.onload = function () {
            if (xmlhttp.status == 200) {
              if(xmlhttp.responseText != "erro"){
                  document.getElementById("itensCart").innerHTML = parseInt(document.getElementById("itensCart").innerHTML) + 1;
                  window.location.href = "cart.php";
              }
            } else{
                alert('erro ao inserir item no carrinho');
            }
        };
        
        xmlhttp.onerror = function () {
            alert("Ocorreu um erro ao processar a requisição");
        };
        
        xmlhttp.send();
      }

      function goToFavorite(idProduct){
        var xmlhttp = new XMLHttpRequest();
        var method = 'GET';
        var url = "scripts/addToFavorites.php?idProduct=" + idProduct;

        xmlhttp.open(method, url, true);
        xmlhttp.onload = function () {
            if (xmlhttp.status == 200) {
                if(xmlhttp.responseText == "ok"){
                    document.getElementById("itensFavorites").innerHTML =
                    parseInt(document.getElementById("itensFavorites").innerHTML) + 1;
                    window.location.href="favorites.php?for=1";
                }
                else{
                    if(xmlhttp.responseText == "Esse produto já está entre os seus favoritos")
                        alert(xmlhttp.responseText)
                    else
                        window.location.href = "login.php?for=1";
                  }
            } else{
                window.location.href = "login.php?for=1";
            }
        };
        
        xmlhttp.onerror = function () {
            alert("Ocorreu um erro ao processar a requisição");
        };
        
        xmlhttp.send();
      }
    </script>
  </div>
  </div>
  <script type="text/javascript" src="scripts/xzoomIntegration.js"></script>
  </div>
  </div>
  <div class="col-md-4">

  </div>
  </div>

  </div>

  </div>
  <?php
		include "footer.php";
	?>

</html>