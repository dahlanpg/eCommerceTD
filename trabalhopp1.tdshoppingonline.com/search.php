<?php
session_start();
$search = $_GET["searchBar"];
if (isset($search)) {
    $_SESSION["search"] = $search;
} else
    header("location: home.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>T&D - eCommerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/stylesHeader.css?v=15">
    <link rel="stylesheet" type="text/css" href="css/stylesSearch.css?v=15">
    <link rel="stylesheet" type="text/css" href="css/stylesFooter.css?v=15">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<body>
   <?php 
        include "headerFull.php";
   ?>
    <nav class="left-menu-side">
        <ul>
            <li id="category-menu">CATEGORIAS</li>
            <li><a href="#" onclick='refreshSearch("Celular")'>Celular</a></li>
            <li><a href="#" onclick='refreshSearch("Relogio")'>Relógio</a></li>
            <li><a href="#" onclick='refreshSearch("Vestuario")'>Vestuário</a></li>
            <li><a href="#" onclick='refreshSearch("Joia")'>Jóia</a></li>
            <li><a href="#" onclick='refreshSearch("Esporte")'>Esporte</a></li>
			<li><a href="#" onclick='refreshSearch("Domestico")'>Doméstico</a></li>
			<li><a href="#" onclick='refreshSearch("Eletronico")'>Eletrônico</a></li>
        </ul>
        <script type="text/javascript">
            var liMenu = document.querySelector('#category-menu').nextElementSibling;
            while (liMenu != null) {
                liMenu.onmouseover = function() {
                    this.style.backgroundColor = "white";
                    this.style.fontWeight = "bold";
                }
                liMenu.onmouseout = function() {
                    this.style.backgroundColor = "#edeef0";
                    this.style.fontWeight = "lighter";
                }

                liMenu = liMenu.nextElementSibling;
            }
        </script>
    </nav>
    <a style="height: 8vh; margin-left:6%;"><img src="images/home/menu.png" id="menuBtnIcon"></a>
    <script type="text/javascript">
		var menuBtn = document.getElementById('menuBtnIcon').parentNode;
		var leftMenuSide = document.querySelector('.left-menu-side');
		var menuSideActive = document.querySelector('.left-menu-active');
		var ativado = false;
		var menuSide = document.querySelector('.left-menu-side');

		menuBtn.onclick = function() {
			if (!ativado) {
				menuSide.classList.add('left-menu-active');
				$(menuSide).animate({
					height: 'toggle'
				});
				ativado = !ativado;
			} else {
				$(menuSide).animate({
					height: 'toggle'
				}, function() {
					menuSide.classList.remove('left-menu-active')
				});
				ativado = !ativado;
			}
		}

		document.body.onresize = function() {
			if (document.body.clientWidth < 700) {
				if (!ativado) {
					$(menuBtn).fadeIn(700);
					$(leftMenuSide).fadeOut(500);
				}
			} else {
				$(menuBtn).fadeOut(700);
				if (menuSide.classList.contains("left-menu-active")) {
					menuSideActive = document.querySelector('.left-menu-active');
					$(menuSideActive).fadeOut(700, function() {
						menuSide.classList.remove('left-menu-active')
					});
				}
				menuSide.classList.remove('left-menu-active')
				$(leftMenuSide).fadeIn(500);
				if (ativado)
					ativado = !ativado;
			}
		};

		if ($(window).width() < 700) {
			$(leftMenuSide).fadeOut(500);
		} else {
			$(menuBtn).hide();
			if (menuSide.classList.contains("left-menu-active")) {
				$(menuSide).fadeOut(700, function() {
					menuSide.classList.remove('left-menu-active')
				});
			}
			$(leftMenuSide).fadeIn(500);
        }
		document.getElementById('searchDiv').onsubmit = function(){
			var keywords = document.getElementById('searchBar').value;
			refreshSearch(keywords);
			return false;
		}

    </script>     
    <div id="searchResult">  
        <?php
                require_once "scripts/connectionMysql.php";
                require_once "scripts/products.php";
                $conn = connectionToMySQL();
                $search = $_SESSION["search"];
				$SQL = "select * from tdproducts where category like '%$search%' and quantity > 0 or offerTitle like '%$search%' and quantity > 0 or manufacturer like '%$search%' and quantity > 0;";

                $arrayProducts = getProducts($conn, $SQL);
                $cont = sizeof($arrayProducts);
				if($search != ""){
					if($cont>1){
						echo "<div class='results'>
									<p>$cont resultados para '$search'</p>
								</div>";
						}
					else{
						echo "<div class='results'>
								<p>$cont resultado para '$search'</p>
							</div>";
					}
				}else{
					echo "<div class='results'>
								<p>Mostrando todos os produtos</p>
							</div>";
				}
				echo "<br>";
				echo '<div class="wrapper">';
		foreach ($arrayProducts as $product) {
			$belongsToTheCart = false; //reset
			if(isset($_COOKIE["cart"])){
				$arrayIds = json_decode($_COOKIE["cart"]);
				if(in_array($product->id, $arrayIds)) 
					$belongsToTheCart = true;
			}
			if($belongsToTheCart == false){
				if ($product->oldprice != null) {
					echo "<div>
					<a href='product.php?idProduct=$product->id'><img class='productImg' src='images/products/$product->category/$product->image1' alt='$product->offerTitle'></a>
					<a href='product.php?idProduct=$product->id'>
						<p class='productName'>$product->offerTitle</p>
					</a>
					<span class='strikedPrice'>R$$product->oldprice<br></span>
					<span class='truePrice'>R$$product->price</span><br><br>
					<button onclick='addToCart($product->id, this.parentElement)' class='btn btn-dark btnbuy' style='float:right;margin-right:4%;margin-bottom:4%;'>Comprar</button>
					<a style='cursor:pointer;' onclick='addToFavorites($product->id, this.parentElement);'><img class='favoriteIcon' src='images/heart.png'></a>
				</div>";
				} else {
					echo "<div>
					<a href='product.php?idProduct=$product->id'><img class='productImg' src='images/products/$product->category/$product->image1' alt='$product->offerTitle'></a>
					<a href='product.php?idProduct=$product->id'>
						<p class='productName'>$product->offerTitle</p>
					</a>
					<span class='truePrice'>R$$product->price</span><br><br>
					<button onclick='addToCart($product->id, this.parentElement)' class='btn btn-dark btnbuy' style='float:right;margin-right:4%;margin-bottom:4%;'>Comprar</button>
					<a style='cursor:pointer;' onclick='addToFavorites($product->id, this.parentElement);'><img class='favoriteIcon' src='images/heart.png'></a>
				</div>";
				}
			}
		}
		echo '</div>';
        ?>
    </div> 
    <script type="text/javascript">
		var products = document.querySelectorAll('.wrapper div');
		var imgsFavorite = document.getElementsByClassName('favoriteIcon');
		for (var i = 0; i < imgsFavorite.length; ++i) {
			products[i].onmouseover = function() {
				this.style.border = "0.7px solid #f0e6f4";
				this.style.borderRadius = '3px';
			}
			products[i].onmouseout = function() {
				this.style.border = "none";
			}
			imgsFavorite[i].onmouseover = function() {
				this.src = "images/red-heart.png";
			}
			imgsFavorite[i].onmouseout = function() {
				this.src = "images/heart.png";
			}
		}
	</script>
    <script src="scripts/addToCart.js"></script>
	<script src="scripts/addToFavorites.js"></script>
    <!-- Footer -->
    <?php
		include "footer.php";
    ?>
    <script src="scripts/search.js"></script>
</body>

</html>