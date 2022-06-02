<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>T&D - A Revolução do E-Commerce</title>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="css/stylesCart.css?v=15">
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
	<div id="cartBody">
		<div id="progressBar">
			<span style="color: #f2f2f2;"> .</span>
			<span id="textFirstProgress">Carrinho</span>
			<span id="textSecondProgress">Pedido em Andamento</span>
			<span id="textThirdProgress">Pagamento</span>
			<ul>
				<li id="firstProgressLine"></li>
				<div class="circleProgress circleProgress1"></div>
				<li id="secondProgressLine"></li>
				<div class="circleProgress circleProgress2"></div>
				<li id="thirdProgressLine"></li>
				<div class="circleProgress circleProgress3"></div>
				<li id="fourthProgressLine"></li>
			</ul>
		</div>
	</div>

	<div class="container containerCartSubtitles"  style="margin-top: 5%;">
		<div class="row">
			<div class="col-4 part1" style="padding-left: 15%;"><span>Produto</span></div> 
			<div class="col-2 part2"><span>Preço/unidade</span></div> 
			<div class="col-3 part3"><span>Quantidade</span></div>
			<div class="col-2 part4" style="padding-left: 4%;"><span>Subtotal</span></div>
			<div class="col-1 part5" style="margin-left: -2%;"><span>Operações</span></div>
		</div>
	</div>

	<div class = "container cartContainer" style="margin-top: 2%;">

			<?php
			require_once "scripts/connectionMysql.php";
			require_once "scripts/products.php";

			if (isset($_COOKIE["cart"])) {
				$cartQtds = null;
				$cartIds  = json_decode($_COOKIE["cart"]);
				$existQtd = false;
				if(isset($_COOKIE["qtd"])){
					$cartQtds = json_decode($_COOKIE["qtd"]);
					$existQtd = true;
				}
				if (!is_array($cartIds))
					die();
				$conn = connectionToMySQL();
				for ($i = 0; $i < sizeof($cartIds); ++$i) {
					$product = getProductById($conn, $cartIds[$i]);
					$idProduct = $cartIds[$i];
				
					if(isset($cartQtds) && is_array($cartQtds) && $existQtd && isset($cartQtds[$i])){
						$quantityCart = $cartQtds[$i];
					}else{
						$quantityCart = 1;
					}
					echo "
					<div class='row rowCart'>
					<span style='display:hide;'></span>
						<div class='col-1 cartPart1'> 
							<a href='product.php?idProduct=$idProduct'><img class='productCart' src='images/products/$product->category/$product->image1'></a>
						</div>
						<div class='col-3 cartPart2'> 
							<a href='product.php?idProduct=$idProduct'><p>$product->offerTitle</p></a>
						</div>
						<div class='col-2 cartPart3'>";
						if(isset($product->oldprice)) 
							echo "<p class='strikedPrice'>R$$product->oldprice<br></p>";
						else
							echo "<br>";
						echo "	
							<p class='truePrice'>R$$product->price</p>
						</div>
						<div class='col-3 cartPart4'>
							<div class='buttons-change-stock'>
								<button onclick='subtractQuantity(this,$idProduct, $product->price);' class='btn btn-danger' value='+' name='+'><span class='btn-span'>-</span></button>
								<input class='form-control inputQtd' type='text' max=$product->quantity name='wishNumber' value='$quantityCart'>
								<button onclick='sumQuantity(this,$idProduct, $product->price);' class='btn btn-success' value='-' name='-'><span class='btn-span'>+</span></button>
						</div>
						</div>
						<div class='col-2 cartPart5'> 
							<p class='Sub-total-Value'>R$$product->price</p>
						</div>
						<div class='col-1 cartPart6'>
							<p><a href='#'><img class='editIcon' src='images/cart/edit.png' alt='Editar'></a></p>
							<p><a><img style='cursor:pointer;' src='images/heart.png' alt='Favoritar' class='favoriteIcon' onclick='addToFavoritesFromCart($idProduct, this.parentElement.parentElement.parentElement.parentElement)'></a></p>
							<p><a data-toggle='modal' data-target='#confirm' class='teste' href='#'><img src='images/cart/trash.png' class='trashIcon' alt='Remover'></a></p>
						</div>
					</div>";
				}
			}
	?>
	<!-- <button id='btnClear' class="btn btn-default">
		<img src="images/cart/clean.png" id="clearCartIcon"><span>Remover tudo</span>
	</button> -->
	<img src="images/cart/btn.jpg" id="btnClear" onclick="removeAllOfCart()">
	</div>
	<script>
		var url = "cart.php";
		function removeAllOfCart(){
		var xmlhttp = new XMLHttpRequest();

		var method = 'GET';
		var url = "scripts/removeAllOfCart.php";
		xmlhttp.open(method, url, true);
		xmlhttp.onload = function () {
			if (xmlhttp.status == 200) {
				$(".rowCart").hide(300, function(){
					document.getElementsByClassName('subtotalPurchase')[0].innerHTML = "R$0,00";
					document.getElementsByClassName('totalPurchase')[0].innerHTML = "R$0,00";
				});
				document.getElementById('btnClear').style.opacity = "0.4";
				document.getElementById('btnClear').style.cursor = "not-allowed";
				document.querySelector('.circleProgress1').style.backgroundColor = "#e0e0e0";
				document.querySelector('#firstProgressLine').style.backgroundColor = "#e0e0e0";
				document.getElementsByClassName('btn-buy')[0].disabled = true;
			}
			else {
				 alert("Nao foi possivel completar a operação");
			}
		};

		xmlhttp.onerror = function () {
			alert("Ocorreu um erro ao processar a requisição");
		};

		xmlhttp.send();
}
	</script>
	<div class="container proceedToPurchase">
		<div class="row">
	        <div class="col-1"> 
	        </div>
	        <div class="col-3"> 
	        </div>
	        <div class="col-2"> 
	        </div>
	        <div class="col-2 this">
	         </div>
	        <div class="col-2"> 
	        	<p style="color: black; font-size: 2.5vh;" id="subtotalEnd">Subtotal:</p>
	        	<p style="color: black; font-size: 2.5vh;" id="discountEnd">Desconto:</p>
	        	<p style="color: black; font-weight: bold; font-size: 3vh;" id="totalEnd">Total:</p>
	        </div>
	        <div class="col-2">
	        	<p class="subtotalPurchase" style="font-size: 2.5vh;"></p>
	        	<p class="discountPurchase" style="border-bottom: 1px solid grey; font-size: 2.5vh;">-R$0,00</p>
	        	<p class="totalPurchase" style="font-size: 3vh;"></p>
	        	<button type="button" onclick="window.location.href='myAccount.php'" class="btn btn-success btn-buy"><span id="spanBtnBuy">Comprar</span></button>
	         </div>
	    </div>
	</div>

		<div class="modal" id="confirm" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Remover do Carrinho</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p>Tem certesa que deseja remover?</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<script>
			var products = document.querySelectorAll('.wrapper div');
			var imgsFavorite = document.getElementsByClassName('favoriteIcon');
			for (var i = 0; i < imgsFavorite.length; ++i) {
				imgsFavorite[i].onmouseover = function() {
					this.src = "images/red-heart.png";
				}
				imgsFavorite[i].onmouseout = function() {
					this.src = "images/heart.png";
				}
			}

			function removeFromCartToFavorites(idProduct, row){
				var xmlhttp = new XMLHttpRequest();

				var method = 'GET';
				var url = "scripts/removeFromCart.php?idProduct=" + idProduct;
				xmlhttp.open(method, url, true);
				xmlhttp.onload = function () {
					if (xmlhttp.status == 200) {
						$(row).fadeOut(700, function () {
							row.parentNode.removeChild(row)
							refreshPrice();
						});
						var cart = document.getElementsByClassName('productCart');
						if(cart.length != 0){
							document.querySelector('.circleProgress1').style.backgroundColor = "black";
							document.querySelector('#firstProgressLine').style.backgroundColor = "black";
						}
					}
					else {
						alert("Nao foi possivel remover");
					}
				};

				xmlhttp.onerror = function () {
					alert("Ocorreu um erro ao processar a requisição");
				};

				xmlhttp.send();
			}

			function addToFavoritesFromCart(idProduct, wrapper){
				var xmlhttp = new XMLHttpRequest();
				var method = 'GET';
				var url = "scripts/addToFavorites.php?idProduct=" + idProduct;

				xmlhttp.open(method, url, true);
				xmlhttp.onload = function () {
					if (xmlhttp.status == 200) {
						if(xmlhttp.responseText == "ok"){
							removeFromCartToFavorites(idProduct, wrapper)
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

	<script src="scripts/saveCart.js"></script>
	<script>
		refreshPageValues();
	</script>	

	<script src="scripts/removeCart.js"></script>
			<!-- Footer -->
	<?php
		include "footer.php";
	?>
		
</body>
</html>