<?php
session_start();

if(isset($_COOKIE["cart"])){
	$cartIds = json_decode($_COOKIE["cart"]);
}

try{
	require_once "scripts/connectionMysql.php";
	$conn = connectionToMySQL();
	$result = "";
	$sql = "select image1, image2, image3, image4 from tdbannershome;";
	$result = $conn->query($sql);
	if(!$result)
		throw new Exception("Nao foi possivel resgatar os banners");

	$row = $result->fetch_assoc();
	$banner1 = $row["image1"];
	$banner2 = $row["image2"];
	$banner3 = $row["image3"];
	$banner4 = $row["image4"];

	$conn->close();
}catch(Exception $e){
	echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>T&D - O maior eCommerce</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesHome.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesHeader.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesFooter.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesHeaderFull.css?v=15">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include "headerFull.php" ?>
	<script>
		document.getElementById('btn-search').onclick = function(){
			var keywords = document.getElementById('searchBar').value;
			window.location.href = "search.php?searchBar=" + keywords;
		}
		document.formSearchBar.action = "search.php";

	</script>
	<nav class="left-menu-side">
		<ul>
			<li id="category-menu">CATEGORIAS</li>
			<li><a href="search.php?searchBar=Celular">Celular</a></li>
			<li><a href="search.php?searchBar=Relogio">Relógio</a></li>
			<li><a href="search.php?searchBar=Vestuario">Vestuário</a></li>
			<li><a href="search.php?searchBar=Joia">Jóia</a></li>
			<li><a href="search.php?searchBar=Esporte">Esporte</a></li>
			<li><a href="search.php?searchBar=Domestico">Doméstico</a></li>
			<li><a href="search.php?searchBar=Eletronico">Eletrônico<a></li>
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
	<nav id="offers">
		<ul id="offers-ul">
			<li id="offers-bar"><a href="#">OFERTAS</a></li>
		</ul>
		<a style="height: 8vh; margin-left:6%;"><img src="images/home/menu.png" id="menuBtnIcon"></a>
		<div class="carousel">
			<ul class="carousel-track">
				<div class="indicator_nav">
					<button class="hover_indicator1 hover_indicator current-indicator"></button>
					<button class="hover_indicator2 hover_indicator"></button>
					<button class="hover_indicator3 hover_indicator"></button>
					<button class="hover_indicator4 hover_indicator"></button>
				</div>
				<span class="carousel-button next"></span>
				<?php
				echo "
				<li class='carousel-slide current-slide'>
					<img src='images/sale/$banner1' />
				</li>
				<li class='carousel-slide'>
					<img src='images/sale/$banner2' />
				</li>
				<li class='carousel-slide'>
					<img src='images/sale/$banner3' />
				</li>
				<li class='carousel-slide'>
					<img src='images/sale/$banner4' />
				</li>";
				?>
				<span class="carousel-button prev"></span>
			</ul>
		</div>
	</nav>
	<script type="text/javascript" src="scripts/carouselHome.js"></script>
	<script type="text/javascript">
		var menuBtn = document.getElementById('menuBtnIcon').parentNode;
		var leftMenuSide = document.querySelector('.left-menu-side');
		var menuSideActive = document.querySelector('.left-menu-active');
		var activated = false;
		var menuSide = document.querySelector('.left-menu-side');
		var hoverIndicator1 = document.querySelector('.hover_indicator1');
		var hoverIndicator2 = document.querySelector('.hover_indicator2');
		var hoverIndicator3 = document.querySelector('.hover_indicator3');
		var hoverIndicator4 = document.querySelector('.hover_indicator4');

		menuBtn.onclick = function() {
			if (!activated) {
				menuSide.classList.add('left-menu-active');
				$(menuSide).animate({
					height: 'toggle'
				});
			} else {
				$(menuSide).animate({
					height: 'toggle'
				}, function() {
					menuSide.classList.remove('left-menu-active')
				});
			}
				activated = !activated;
		}

		document.body.onresize = function() {
			var carousel = document.querySelector('.carousel');
			if (document.body.clientWidth < 700) {
				if (!activated) {
					$(menuBtn).show(700);
					$(leftMenuSide).hide(500, function() {
						$('#offers').width('100%')
					});
					hoverIndicator1.style.marginLeft = "72%";
					hoverIndicator2.style.marginLeft = "75%";
					hoverIndicator3.style.marginLeft = "78%";
					hoverIndicator4.style.marginLeft = "81%";
				}
			} else {
				if (menuSide.classList.contains("left-menu-active")) {
					menuSideActive = document.querySelector('.left-menu-active');
					$(menuSideActive).fadeOut(700, function() {
						menuSide.classList.remove('left-menu-active')
					});
				}
				$('#offers').width('76%')
				menuSide.classList.remove('left-menu-active')
				$(leftMenuSide).show(500);
				$(menuBtn).hide(700);
				hoverIndicator1.style.marginLeft = "76%";
				hoverIndicator2.style.marginLeft = "78%";
				hoverIndicator3.style.marginLeft = "80%";
				hoverIndicator4.style.marginLeft = "82%";
				if (activated)
					activated = !activated;
			}
		};

		if ($(window).width() < 700) {
			$(leftMenuSide).hide(function() {
				$('#offers').width('100%')
			});
			hoverIndicator1.style.marginLeft = "72%";
			hoverIndicator2.style.marginLeft = "75%";
			hoverIndicator3.style.marginLeft = "78%";
			hoverIndicator4.style.marginLeft = "81%";
		} else {
			$(menuBtn).hide();
			if (menuSide.classList.contains("left-menu-active")) {
				$(menuSide).fadeOut(700, function() {
					menuSide.classList.remove('left-menu-active')
				});
			}
			$(leftMenuSide).fadeIn(500, function() {
				$('#offers').width('76%')
			});
			hoverIndicator1.style.marginLeft = "76%";
			hoverIndicator2.style.marginLeft = "78%";
			hoverIndicator3.style.marginLeft = "80%";
			hoverIndicator4.style.marginLeft = "82%";
		}
	</script>
	<div class="container recommendedList">
			<h3 id="recommendedH3" style="font-family: fantasy; border-bottom: 1px solid black">RECOMENDADOS PARA VOCÊ</h3>
		<?php
		require_once "scripts/connectionMysql.php";
		require_once "scripts/products.php";
		$conn = connectionToMySQL();
		$SQL = "
				SELECT *
				FROM tdproducts order by sold desc LIMIT 40;
			";
		$arrayProducts = getProducts($conn, $SQL);

		echo '<div class="wrapper">';
		$cont = 0;
		foreach ($arrayProducts as $product) {
			$belongsToTheCart = false; //reset
			if(isset($_COOKIE["cart"])){
				$arrayIds = json_decode($_COOKIE["cart"]);
				if(in_array($product->id, $arrayIds)) 
					$belongsToTheCart = true;
			}
			if($belongsToTheCart == false && $product->quantity > 0){
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
				$cont++;
			}
			if($cont == 30)
				break;
		}
		echo '</div>';
		?>
	</div>

	<script src="scripts/addToCart.js"></script>
	<script src="scripts/addToFavorites.js"></script>

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

	<!-- Footer -->
	<?php
		include "footer.php";
	?>

</body>

</html>