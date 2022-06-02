<?php
	session_start();

	require_once "scripts/autentication.php";
	require_once "scripts/connectionMysql.php";
	$conn = connectionToMySQL();
	if(!checkUserIsLoggedOrDie($conn))
		header("Location: login.php?for=2");

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Minha Conta - T&D</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesMyAccount.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesCart.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesFooter.css?v=15">
	<script src="scripts/jquery.min.js"></script>
	<script src="scripts/refreshOrders.js"></script>
	<script type="text/javascript" src="scripts/jquery.form.min.js"></script>
	<link rel="stylesheet" href="scripts/bootstrap.min.css">
	<script src="scripts/popper.min.js"></script>
	<script src="scripts/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
	<?php
	if(isset($_SESSION["id"]))
		$name = explode(" ", $_SESSION["name"])[0];
	?>
	<header>
		<a href="home.php"><img src="images/logo.png" alt="T&D - A Revolução do E-Commerce" style="margin-left: 4%;"></a>
		<span>Thiago & Dahlan Store</span>
		<span style=" float: right; margin-top: 3%; padding-right: 6%; font-size: 2.4vh;"><a href="myAccount.php">Olá, <?php echo $name; ?></a></span>
		<span style=" float: right; margin-top: 2%;"><a href="#"><img style="height: 7vh;" src="images/cart/header/boss.png"></a></span>

	</header>
	<nav class="container menuMyAccount">
		<div class="row rowMyAccountPage">
			<div class="col-4 colMyAccountPage">
				<a href="#" class="selected">Concluir pedido em andamento</a>
			</div>
			<div class="col-3 colMyAccountPage">
				<a href="#">Meus Pedidos</a>
			</div>
			<div class="col-3 colMyAccountPage">
				<a href="#">Meus Dados</a>
			</div>
			<div class="col-2 colMyAccountPage">
				<?php echo "<a href='scripts/logout.php'>Sair</a>" ?>
			</div>
		</div>
	</nav>
	<div class="finishOrder flap currentFlap">
		<!--  Order Completion Tab -->
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

		<div class="container containerCartSubtitles" style="margin-top: 5%;">
			<div class="row">
				<div class="col-4" style="padding-left: 15%;"><span>Produto</span></div>
				<div class="col-2"><span>Preço/unidade</span></div>
				<div class="col-3"><span>Quantidade</span></div>
				<div class="col-2" style="padding-left: 4%;"><span>Subtotal</span></div>
				<div class="col-1" style="margin-left: -2%;"><span>Operações</span></div>
			</div>
		</div>
		<div class="container">
			<div class="container cartContainer" style="margin-top: 2%;">
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
					<div class='row'>
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
								<button onclick='subtractQuantity(this,$idProduct, $product->price);' class='btn btn-danger' value='+' name='+'>-</button>
								<input class='form-control inputQtd' type='text' max=$product->quantity name='wishNumber' value='$quantityCart'>
								<button onclick='sumQuantity(this,$idProduct, $product->price);' class='btn btn-success' value='-' name='-'>+</button>
						</div>
						</div>
						<div class='col-2 cartPart5'> 
							<p class='Sub-total-Value'>R$$product->price</p>
						</div>
						<div class='col-1 cartPart6'>
							<p><a href='#'><img src='images/cart/edit.png' alt='Editar'></a></p>
							<p><a><img style='cursor:pointer;' src='images/heart.png' alt='Favoritar' class='favoriteIcon' onclick='addToFavoritesFromCart($idProduct, this.parentElement.parentElement.parentElement.parentElement)'></a></p>
							<p><a data-toggle='modal' data-target='#confirm' class='teste' href='#'><img src='images/cart/trash.png' alt='Remover'></a></p>
						</div>
					</div>";
				}
			}
	?>
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
		<!-- <script src="scripts/buttonsQuantity.js"></script> -->
		<script>
			 var buttons = document.getElementsByClassName('buttons-change-stock');
		    for(var i = 0; i < buttons.length ; ++i){
					if(buttons[i].children[1].value == '1'){
							buttons[i].children[0].style.opacity = "0.4";
					}
					if(buttons[i].children[1].value == buttons[i].children[1].max){
							buttons[i].children[2].style.opacity = "0.4";
					}
				}
		</script>
		<script src="scripts/saveCart.js"></script>
		<div class="container proceedToPurchase" style="margin-top: 4%;">
			<div class="row">
				<div class="col-1"></div>
				<div class="col-3"></div>
				<div class="col-2"></div>
				<div class="col-2"></div>
				<div class="col-2">
					<p style="color: black; font-size: 2.5vh;">Subtotal:</p>
					<p style="color: black; font-size: 2.5vh;">Desconto:</p>
					<p style="color: black; font-weight: bold; font-size: 3vh;">Total:</p>
				</div>
				<div class="col-2">
					<p class="subtotalPurchase" style="font-size: 2.5vh;">R$0,00</p>
					<p class="discountPurchase" style="border-bottom: 1px solid grey; font-size: 2.5vh;">-R$0,00</p>
					<p class="totalPurchase" style="font-size: 3vh;">R$0,00</p>
				</div>
			</div>
		</div>
		<div class="container checkOut">
			<div class="paymentOptions">
				<label style="font-weight: bold;">Selecione a forma de pagamento:</label>
				<div class="radio-inline">
					<label><input type="radio" class="ticketOption optionPayment" name="optradio" checked>Boleto</label>
				</div>
				<div class="radio-inline">
					<label><input type="radio" class="creditOption optionPayment" name="optradio">Cartão de Crédito</label>
				</div>
				<div class="radio-inline">
					<label><input type="radio" class="debitOption optionPayment" name="optradio">Débito</label>
				</div>
			</div>
			<div class="payment ticketPayment activePayment">
				<img id="ticketImg" src="images/myAccount/ticket.png">
				<div id="ticketPaymentText">
					<h3>Boleto Bancário<br></h3>
					<p>Você está economizando R$ 84,43 no pagamento em boleto</p>
					<p>Boleto tem até 15% de desconto na compra e é a forma de pagamento que recebe o maior desconto sob o valor total da compra. Esta é a forma mais vantajosa para quem deseja pagar à vista. Você poderá efetuar o pagamento do boleto em qualquer Banco ou Casa Lotérica em qualquer lugar do Brasil, sem necessidade de confirmação do pagamento.</p>
				</div>
				<button type="button" onclick="makeOrder();" class="btn btn-success btn-getTicket btn-buy">Gerar boleto</button>
			</div> <!-- END TICKET PAYMENT -->

			<div class="payment creditPayment" style="display: none;">
				<img id="creditImg" src="images/myAccount/credit.jpg">
				<div id="creditPaymentDatas">
					<h3>Cartão de Crédito<br></h3>
					<form>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="inputNameCredit">Forma de pagamento:</label>
								<select id="inputFormPayment" class="form-control">
									<option>À vista - Até 10% de desconto - R$ 180,00</option>
									<option>2x - 5% de desconto - R$ 180,00</option>
									<option>3x - sem juros - R$ 180,00</option>
									<option>4x - sem juros - R$ 180,00</option>
									<option>5x - sem juros - R$ 180,00</option>
									<option>6x - sem juros - R$ 180,00</option>
									<option>7x - sem juros - R$ 180,00</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="inputNameCredit">Nome completo:</label>
								<input type="text" class="form-control" id="inputNameCredit" placeholder="Nome completo" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-10">
								<label for="inputNumberCard">Numero do cartão:</label>
								<input type="text" class="form-control" id="inputNumberCard" placeholder="4245 4245 4245 4245" required>
							</div>
							<div class="form-group col-md-2">
								<label for="validate">Validade:</label>
								<input type="text" class="form-control" id="validate" placeholder="mm/aa" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-2">
								<label for="inputCode">Código:</label>
								<input type="text" class="form-control" id="inputCode" placeholder="123" required>
							</div>
							<div class="form-group col-md-6">
								<label for="inputCPF">CPF do proprietário</label>
								<input type="text" class="form-control" id="inputCPF" placeholder="312.254.173.73" required>
							</div>
							<div class="form-group col-md-4">
								<label for="inputDate">Data de nascimento</label>
								<input type="date" class="form-control" id="inputDate" required>
							</div>
						</div>
						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="gridCheck" required>
								<label class="form-check-label" for="gridCheck">
									Clique em mim
								</label>
							</div>
						</div>
						<button type="" onclick="makeOrder();" class="btn btn-success btn-buy">Finalizar compra</button>
					</form>
				</div>
			</div> <!-- END CREDIT PAYMENT -->

			<div class="payment debitPayment">
				<img id="debitImg" src="images/myAccount/debit.jpg">
				<div id="debitPaymentDatas">
					<h3>Débito em conta<br></h3>
					<form>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="inputName">Nome completo:</label>
								<input type="text" class="form-control" id="inputName" placeholder="Nome completo" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="inputCPF">CPF do proprietário:</label>
								<input type="text" class="form-control" id="inputCPF" placeholder="312.254.173.73" required>
							</div>
							<div class="form-group col-md-4">
								<label for="inputDate">Data de nascimento:</label>
								<input type="date" class="form-control" id="inputDate" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="bankName">Nome do banco:</label>
								<input type="text" class="form-control" id="bankName" placeholder="ex: 'Banco do Brasil'" required>
							</div>
							<div class="form-group col-md-2">
								<label for="agencyBank">Agencia:</label>
								<input type="text" class="form-control" id="agencyBank" placeholder="1234" required>
							</div>
							<div class="form-group col-md-4">
								<label for="accountBank">Conta:</label>
								<input type="text" class="form-control" id="accountBank" placeholder="123456" required>
							</div>
						</div>
						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="gridCheck">
								<label class="form-check-label" for="gridCheck">
									Clique em mim
								</label>
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-buy">Finalizar compra</button>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- Order Completion Tab END-->

	<script type="text/javascript">
		var paymentDisplay = document.getElementsByClassName('payment');
		var paymentOptions = document.getElementsByClassName('optionPayment');
		var activeOption, activePayment;

		paymentOptions[0].onclick = function() {
			activePayment = document.getElementsByClassName('activePayment')[0];
			activePayment.classList.remove('activePayment');
			paymentDisplay[0].classList.add('activePayment');
		}
		paymentOptions[1].onclick = function() {
			activePayment = document.getElementsByClassName('activePayment')[0];
			activePayment.classList.remove('activePayment');
			paymentDisplay[1].classList.add('activePayment');
		}
		paymentOptions[2].onclick = function() {
			activePayment = document.getElementsByClassName('activePayment')[0];
			activePayment.classList.remove('activePayment');
			paymentDisplay[2].classList.add('activePayment');
		}
	</script>
	<script src="scripts/makeOrder.js"></script>
	<div class="myOrders flap">
		<div class="container containerCartSubtitles" style="margin-top: 5%;">
			<div class="row">
				<div class="col-5" style="padding-left: 15%;"><span>Produtos</span></div>
				<div class="col-2"></div>
				<div class="col-3"><span>Data da compra</span></div>
				<div class="col-2" style="padding-left: 4%;"><span>Valor total</span></div>
			</div>
		</div>
		 <div class="container">                        
			<div class="container ordersContainer" style="margin-top: 2%;"><!--   comeca aqui -->
				<!-- <div class="row">
					<div class="col-2 ordersPart1">
						<img class="productCart" src="images/myAccount/shopping-bag.png">
					</div>
					<div class="col-3 ordersPart2">
						<p><span class="amount">1x</span> iPhone 8 Gold</p>
						<p><span class="amount">2x</span> CPU i7 7700k</p>
						<p><span class="amount">3x</span> GTX 1060ti 4gb</p>
					</div>
					<div class="col-2 ordersPart3">

					</div>
					<div class="col-3 ordersPart4">
						<p class="date">06/04/2019</p>
					</div>
					<div class="col-2 ordersPart5">
						<p class="totalValue">R$180,00</p>
					</div>
				</div> -->
				<!-- <div class="row">
					<div class="col-2 cartPart1">
						<img class="productCart" src="images/myAccount/shopping-bag.png">
					</div>
					<div class="col-3 cartPart2">
						<p><span class="amount">1x</span> iPhone 8 Gold</p>
						<p><span class="amount">2x</span> CPU i7 7700k</p>
					</div>
					<div class="col-2 cartPart3">

					</div>
					<div class="col-3 cartPart4">
						<p class="date">10/04/2019</p>
					</div>
					<div class="col-2 cartPart5">
						<p class="Sub-total-Value">R$180,00</p>
					</div>
				</div> -->
			</div><!--   termina aqui -->
		</div> 
	</div>
		<script src="scripts/removeCart.js"></script>
		<script src="scripts/refreshOrders.js"></script>
		<script>
			refreshPageValues();
		</script>	
	<div class="myData flap">
		<div class="container">
			<div class="container datesTop" style="margin-top: 2%; background-color: white;">
				<div class="row">
					<div class="col-sm-4 mt-3 mb-5 ordersPart1">
						<div id="avatarProfile">
							<?php
							if (isset($_SESSION["avatar"]) && $_SESSION["avatar"] != "") {
								$avatar = $_SESSION["avatar"];
								echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/$avatar'>";
							} else if ($_SESSION["gender"] == 'M')
								echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarM.jpg'>";
							else if ($_SESSION["gender"] == 'F')
								echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarF.jpg'>";
							else if ($_SESSION["gender"] == 'O')
								echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarO.png'>";

							?>
						</div>
						<form name="formAvatar" enctype="multipart/form-data" id="formAvatar" action="scripts/uploadFiles.php" method="post">
							<label for="avatarImg">Selecione uma foto</label>
							<input type="file" name="avatarImg" id="avatarImg">
						</form>
						<div id="teste"></div>
						<script type="text/javascript">
							$(document).ready(function() {
								$('#avatarImg').on('change', function() {
									$('#avatarImage').html('<img src="images/ajax-loader.gif" alt="Enviando..."/> Enviando...');
									$('#formAvatar').ajaxForm({
										target: '#avatarProfile'
									}).submit();
								});
							})
						</script>
					</div>
					<div class="col-sm-7 mt-5 mb-5 ordersPart2 col-sm-offset-2">
						<p><label class="btn btn-defaut" style="font-weight: bold">NOME:</label><span><?php echo $_SESSION["name"] ?></span>
							<a data-toggle="modal" data-target="#myModal" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
						<hr id="infoBar">
						<p><label class="btn btn-defaut" style="font-weight: bold">ENDEREÇO:</label><span><?php echo  $_SESSION["street"] . ", " . $_SESSION["numberStreet"] . ", " . $_SESSION["district"] . ", " . $_SESSION["city"] . ", " . $_SESSION["zipcode"]; ?></span>
							<hr id="infoBar">
							<p><label class="btn btn-defaut" style="font-weight: bold">E-MAIL:</label><span><?php echo $_SESSION["email"] ?></span>
								<a data-toggle="modal" data-target="#myModal" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
							<hr id="infoBar">
							<p><label class="btn btn-defaut" style="font-weight: bold">TELEFONE:</label><span><?php echo "+" . $_SESSION["ddi"] . " " . $_SESSION["ddd"] . " " . $_SESSION["phone"] ?></span>
								<a data-toggle="modal" data-target="#myModalPhone" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
							<!-- <hr id="infoBar">
							<p><label class="btn btn-defaut" style="font-weight: bold">EMPRESA:</label><span>Globo</span>
								<a data-toggle="modal" data-target="#myModal" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p> -->
					</div>
					<!-- Modal -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
									</button>
									<!-- <h4 class="modal-title" id="myModalLabel">Modal title</h4> -->
								</div>
								<div class="modal-body">
									<h1 class="target-nome"></h1>
									<input id="inputText" type="text">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn closebtn" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary btn-save" id="changeInfo" data-dismiss="modal">Salvar Alterações</button>
								</div>
							</div>
						</div>
					</div>

					<div class="modal fade" id="myModalPhone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                                <div class="modal-body">
                                    <h3 class="target-phone">DDI:</h3>
                                    <input id="inputText" type="text">
                                    <h3 class="target-phone">DDD:</h3>
                                    <input id="inputText" type="text">
                                    <h3 class="target-phone">NÚMERO:</h3>
                                    <input id="inputText" type="text">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn closebtn" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary btn-save" id="changeInfo" data-dismiss="modal">Salvar Alterações</button>
                                </div>
                            </div>
                        </div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!--pega os valores e altera de acordo com o input do Modal  -->


	<script type="text/javascript">
		var objetoCorrente, texto, y, field, currentLabel;
		$(".changeCamp").click(function() {
			objetoCorrente = this;
			currentLabel = objetoCorrente.previousElementSibling.previousElementSibling.innerHTML;
			document.getElementsByClassName('target-nome')[0].innerHTML = currentLabel;
		});

		$('.btn-save').click(function alteraCampo() {
			field = objetoCorrente.previousElementSibling;
			if (currentLabel != "TELEFONE:") {
				if (document.getElementById('inputText').value != null && document.getElementById('inputText').value != '') {
					field.innerHTML = document.getElementById('inputText').value;

				} else
					alert('Campo inválido');
			} else {
				if (document.getElementById('inputText').value != null && document.getElementById('inputText').value != '' && !isNaN(parseInt(document.getElementById('inputText').value))) {
					field.innerHTML = document.getElementById('inputText').value;
				} else
					alert('Campo inválido');
			}
		});
	</script>
	<script>
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
					document.getElementById('avatarImage').src = e.target.result;
				}
				reader.readAsDataURL(input.files[0]);
			}
		};
	</script>

	<script type="text/javascript">
		var flaps = document.getElementsByClassName('flap');
		var cols = document.querySelectorAll('.colMyAccountPage a');

		function switchTab(e, i) {
			var currentFlap = document.getElementsByClassName('currentFlap')[0];
			var currentCol = document.getElementsByClassName('selected')[0];
			currentFlap.classList.remove('currentFlap');
			currentCol.classList.remove('selected');
			e.classList.add('selected');
			flaps[i].classList.add('currentFlap');
		}

		cols[0].onclick = function() {
			switchTab(this, 0);
		}
		cols[1].onclick = function() {
			switchTab(this, 1);
			refreshOrders();
		}
		cols[2].onclick = function() {
			switchTab(this, 2);
		}

		var cart = document.getElementsByClassName('cartPart1');
		if(cart.length != 0){
			document.querySelector('.circleProgress2').style.backgroundColor = "black";
			document.querySelector('#secondProgressLine').style.backgroundColor = "black";
		}
	</script>
	<!-- Footer -->
	<?php
		include "footer.php";
	?>
</body>

</html>