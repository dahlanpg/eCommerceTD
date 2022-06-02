<?php
	session_start();
	require_once "scripts/autentication.php";
	require_once "scripts/connectionMysql.php";
	$conn = connectionToMySQL();
	if(!checkUserIsLoggedOrDie($conn))
		header("Location: login.php?for=1");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Favorites - T&G</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesFavorites.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesFooter.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesHeaderBasic.css?v=15">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
		<?php include "headerBasic.php"; ?>

		<div class="container containerCartSubtitles"  style="margin-top: 5%;">
		<div class="row">
			<div class="col-9" style="padding-left: 15%;"><span>Produto</span></div> 
			<div class="col-2"><span>Preço/unidade</span></div> 
			<div class="col-1"><span>Operações</span></div>
		</div>
	</div>

	<div class = "container cartContainer" style="margin-top: 2%;">
		
		<?php 
			try{
				require_once "scripts/connectionMysql.php";
				require_once "scripts/products.php";


				$conn = connectionToMySQL();
				$idClient = $_SESSION["id"];
				$sql = "select idproduct from tdfavorites
						where iduser = $idClient;";

				$result = $conn->query($sql);
				if(!$result)
					throw new Exception("Erro ao resgatar produtos");
				while($row = $result->fetch_assoc()){
					$idProduct = $row["idproduct"];
					$product = getProductById($conn, $idProduct);
					echo "<div class='row'>
					<div class='col-1 cartPart1'> 
						<img class='productCart' src='images/products/$product->category/$product->image1'>
					</div>
					<div class='col-8 cartPart2'> 
						<p>$product->offerTitle</p>
					</div>
					<div class='col-2 cartPart3'> ";
					if(isset($product->oldprice))
						echo"<p class='strikedPrice'>R$$product->oldprice<br></p>";
					else
						echo"<p class='strikedPrice'><br></p>";
					echo"<p class='truePrice'>R$$product->price</p>
					</div>
					<div class='col-1 cartPart6'>
						<p><a href='#'><img src='images/cart/edit.png' alt='Editar'></a></p>
						<p><a id='addCartIconF' style='cursor:pointer;' onclick='addToCartFromFavorites($product->id, this.parentElement.parentElement.parentElement)'><img src='images/cart.png' alt='Adicionar ao carrinho'></a></p>
						<p><a data-toggle='modal' data-target='#confirm' href='#'>
						<img onclick='recordId($idProduct, this.parentElement.parentElement)' src='images/cart/trash.png' alt='Remover'></a></p>
					</div>
				</div>";
				}

			}catch(Exception $e){
				echo $e->getMessage();
			}finally{
				if($conn != null)
				 	$conn->close();
			}
			
			
		?>
	</div>
	<script src="scripts/addToCart.js"></script>
	<script src="scripts/removeFromFavorites.js"></script>
	<div class="modal" id="confirm" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Remover dos Favoritos</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p>Tem certesa que deseja remover?</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" onclick="removeFavorite()" class="btn btn-primary" data-dismiss="modal">Sim</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
		      </div>
		    </div>
		  </div>
		</div>
	<script type="text/javascript"> //Carousel Border on Hover
		var productsCarousel = document.querySelectorAll('.rowCarouselCartPage div');
		for(var i = 0; i < productsCarousel.length ; ++i){
			productsCarousel[i].onmouseover = function(){
				this.style.borderRight = "1px solid #edeef0";
				this.style.borderLeft = "1px solid #edeef0";
			}
			productsCarousel[i].onmouseout = function(){
				this.style.borderRight = "none";
				this.style.borderLeft = "none";
			}
		}

		function addToCartFromFavorites(productId, row){
			addToCart(productId, row);
			currentIdProduct = productId;
			currentProductRow = row;
			removeFavorite();
		}
	</script>

		<?php
			include "footer.php";
		?>
</body>
</html>