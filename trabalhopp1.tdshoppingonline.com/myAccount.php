<?php
	session_start();

	require_once "scripts/autentication.php";
	require_once "scripts/connectionMysql.php";
	$conn = connectionToMySQL();
	if(!checkUserIsLoggedOrDie($conn)){
		session_destroy();
		header("Location: login.php?for=2");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Minha Conta - T&D</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesMyAccount.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesFooter.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesCart.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesHeaderBasic.css?v=15">
	<script src="scripts/jquery.min.js"></script>
	<script src="scripts/refreshOrders.js"></script>
	<script src="scripts/refreshPaymentMethods.js"></script>
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
	<?php include "headerBasic.php"; ?>
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
				<div class="col-4 part1" style="padding-left: 15%;"><span>Produto</span></div> 
				<div class="col-2 part2"><span>Preço/unidade</span></div> 
				<div class="col-3 part3"><span>Quantidade</span></div>
				<div class="col-2 part4" style="padding-left: 4%;"><span>Subtotal</span></div>
				<div class="col-1 part5" style="margin-left: -2%;"><span>Operações</span></div>
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
			var url = "myAccount.php";
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
		<!-- <script>refreshPageValues()</script> -->
		<div class="container proceedToPurchase" style="margin-top: 4%;">
			<div class="row">
				<div class="col-1"></div>
				<div class="col-3"></div>
				<div class="col-2"></div>
				<div class="col-2 this"></div>
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
					<p>Você está economizando R$ <span id="ticketDiscount">84,43</span> no pagamento em boleto</p>
					<p>Boleto tem até 15% de desconto na compra e é a forma de pagamento que recebe o maior desconto sob o valor total da compra. Esta é a forma mais vantajosa para quem deseja pagar à vista. Você poderá efetuar o pagamento do boleto em qualquer Banco ou Casa Lotérica em qualquer lugar do Brasil, sem necessidade de confirmação do pagamento.</p>
				</div>
				<button type="button" onclick="makeOrder('Boleto');" class="btn btn-success btn-getTicket btn-buy">Gerar boleto</button>
			</div> <!-- END TICKET PAYMENT -->
			<div class="payment creditPayment">
				<img id="creditImg" src="images/myAccount/credit.jpg">
				<div id="creditPaymentDatas">
					<h3>Cartão de Crédito<br></h3>
					<form>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="inputNameCredit">Forma de pagamento:</label>
								<select id="inputFormPayment" class="form-control">
									<option>À vista - Até 10% de desconto - R$ 0,00</option>
									<option>2x - 5% de desconto - R$ 0,00</option>
									<option>3x - sem juros - R$ 0,00</option>
									<option>4x - sem juros - R$ 0,00</option>
									<option>5x - sem juros - R$ 0,00</option>
									<option>6x - sem juros - R$ 0,00</option>
									<option>7x - sem juros - R$ 0,00</option>
									<option>8x - sem juros - R$ 0,00</option>
									<option>9x - sem juros - R$ 0,00</option>
									<option>10x - sem juros - R$ 0,00</option>
									<option>11x - sem juros - R$ 0,00</option>
									<option>12x - sem juros - R$ 0,00</option>
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
								<input type="text" maxlength="19" minlength="16" class="form-control" id="inputNumberCard" placeholder="4245 4245 4245 4245" required>
							</div>
							<div class="form-group col-md-2">
								<label for="validate">Validade:</label>
								<input type="text" maxlength="5" minlength="5" class="form-control" id="validate" placeholder="mm/aa" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-2">
								<label for="inputCode">Código:</label>
								<input maxlength="3" minlength="3" type="text" class="form-control" id="inputCode" placeholder="123" required>
							</div>
							<div class="form-group col-md-6">
								<label for="inputCPF">CPF do proprietário</label>
								<input maxlength="11" minlength="11" type="text" class="form-control" id="inputCPF" placeholder="312.254.173.73" required>
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
						<button type="button" onclick="makeOrder('Cartão de crédito');" class="btn btn-success btn-buy">Finalizar compra</button>
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
								<input type="text" maxlength="11" minlength="11" class="form-control" id="inputCPF" placeholder="312.254.173.73" required>
							</div>
							<div class="form-group col-md-4">
								<label for="inputDate">Data de nascimento:</label>
								<input type="date" class="form-control" id="inputDate" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="bankName">Nome do banco:</label>
								<input type="text" class="form-control" id="bankName" placeholder="ex: 'Nome do banco'" required>
							</div>
							<div class="form-group col-md-2">
								<label for="agencyBank">Agencia:</label>
								<input type="text" maxlength="4" minlength="4" class="form-control" id="agencyBank" placeholder="1234" required>
							</div>
							<div class="form-group col-md-4">
								<label for="accountBank">Conta:</label>
								<input type="text" maxlength="10" class="form-control" id="accountBank" placeholder="123456" required>
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
						<button type="button" onclick="makeOrder('Débito');" class="btn btn-success btn-buy">Finalizar compra</button>
					</form>
				</div>
			</div>

			<div class="successOrder">
				<img id="successImg" src="images/myAccount/right.gif">
				<div id="ticketPaymentText">
					<h3 style="margin-left:10%;">Pedido concluído<br><br></h3>
					<p>Seu pedido foi realizado com sucesso!
					Em instantes, você<br> receberá um email com as informações do pedido.
					<p>Enquanto isso, aproveite para ver nossas ofertas.<br>
				</div>
				<img id="shoppingGif" src="images/myAccount/shopping.gif">
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

		document.getElementById('shoppingGif').onclick = function(){
			window.location.href = "home.php";
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
			<div id="listOrdersTr" class="container ordersContainer" style="margin-top: 2%;"><!--   comeca aqui -->

			</div><!--   termina aqui -->
		</div> 
	</div>
		<script src="scripts/removeCart.js"></script>
		<script src="scripts/refreshOrders.js"></script>
		<script>
			refreshPageValues();

			var subtotais = document.getElementsByClassName('Sub-total-Value');
			total = 0.0;
			for(var i = 0; i < subtotais.length ; ++i){
				total += parseFloat(subtotais[i].innerText.split("R$")[1]);
				total = parseFloat(total.toFixed(2));
			}
			document.getElementsByClassName('subtotalPurchase')[0].innerText = "R$" + total;
			document.getElementsByClassName('totalPurchase')[0].innerText = "R$" + total;
			refreshTicketPayment(total);
			refreshCreditPayment(total);
			
			var imgsFavorite = document.getElementsByClassName('favoriteIcon');
			for (var i = 0; i < imgsFavorite.length; ++i) {
				imgsFavorite[i].onmouseover = function() {
					this.src = "images/red-heart.png";
				}
				imgsFavorite[i].onmouseout = function() {
					this.src = "images/heart.png";
				}
			}
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
									$('#avatarProfile').html('<img src="images/ajax-loader.gif" alt="Enviando..."/> Enviando...');
									$('#formAvatar').ajaxForm({
										target: '#avatarProfile'
									}).submit();
								});
							})
						</script>
					</div>
					<div class="col-sm-7 mt-5 mb-5 ordersPart2 col-sm-offset-2">
						<p><label class="btn btn-defaut" style="font-weight: bold">NOME:</label><span id="nameClient"><?php echo $_SESSION["name"] ?></span>
							<a data-toggle="modal" data-target="#myModalName" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
						<hr id="infoBar">
						<p><label class="btn btn-defaut" style="font-weight: bold">ENDEREÇO:</label><span id="addressClient"><?php echo  $_SESSION["street"] . ", " 
						. $_SESSION["numberStreet"] . ", " .$_SESSION["complement"] . ", "
						 . $_SESSION["district"] . ", " . $_SESSION["city"] . ", " . $_SESSION["zipcode"]; ?></span>
							<hr id="infoBar">
							<p><label class="btn btn-defaut" style="font-weight: bold">E-MAIL:</label><span id="emailClient"><?php echo $_SESSION["email"] ?></span>
								<a data-toggle="modal" data-target="#myModalMail" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
							<hr id="infoBar">
							<p><label class="btn btn-defaut" style="font-weight: bold">TELEFONE:</label><span id="phoneClient"><?php echo "+" . $_SESSION["ddi"] . " " . $_SESSION["ddd"] . " " . $_SESSION["phone"] ?></span>
								<a data-toggle="modal" data-target="#myModalPhone" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
					</div>
					<!-- Modal -->
					<div class="container">
			<div class="modal" id="myModalName">
				<div class="modal-dialog">
					<div class="modal-content" style="height: 80vh;">
						<div class="modal-header"  style="background-color: #24272d; color: white">
							<h1 class="modal-title" style="margin-left: 15%">Alterar Nome</h1>
							<button type="button" class="close" data-dismiss="modal">×</button>
						</div>
						<div class="modal-body" style="overflow-y: scroll;">
							<div class="form-group">
                                <label for="name">NOME:</label>
                                <input type="text" name="name" id="inputChangeName" placeholder="Ex.: Fulano de tal" class="form-control" required style="border-color: black">
							</div>
							<div class="modal-footer">
								<button onclick="changeMyName()" id="btnChangeName" class="btn btn-success form-control" style="width: 90%;" type="submit">Salvar alterações</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							</div>
							<div class="alert alert-success" id="divSuccessMsg1" style="display: none; margin-top: 10px;">
								<strong>Registro atualizado com sucesso: </strong><span id="successMsg1"></span>
							</div>

							<div class="alert alert-danger" id="divErrorMsg1" style="display: none; margin-top: 10px;">
								<strong>A operação não pode ser realizada: </strong><span id="errorMsg1"></span>
							</div>
					</div>
				</div>
			</div>
		</div>
</div>
		<div class="container">
			<div class="modal" id="myModalMail">
				<div class="modal-dialog">
					<div class="modal-content" style="height: 80vh;">
						<div class="modal-header"  style="background-color: #24272d; color: white">
							<h1 class="modal-title" style="margin-left: 15%">Alterar E-Mail</h1>
							<button type="button" class="close" data-dismiss="modal">×</button>
						</div>
						<div class="modal-body" style="overflow-y: scroll;">
							<div class="form-group">
                                    	<label for="email" style="margin-top: 2%">E-MAIL:</label>
                                    	<input type="email" id="inputChangeEmail" name="inputChangeEmail" placeholder="Ex.: tdEcommerce@gmail.com" class="form-control" required style="border-color: black">
                                    </div>
						<div class="modal-footer">
							<button onclick="changeMyEmail();" id="btnChangeEmail" class="btn btn-success form-control" style="width: 90%;" type="submit">Salvar alterações</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						</div>
						<div class="alert alert-success" id="divSuccessMsg2" style="display: none; margin-top: 10px;">
							<strong>Registro atualizado com sucesso: </strong><span id="successMsg2"></span>
						</div>

						<div class="alert alert-danger" id="divErrorMsg2" style="display: none; margin-top: 10px;">
							<strong>A operação não pode ser realizada: </strong><span id="errorMsg2"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>

		<div class="container">
			<div class="modal" id="myModalPhone">
				<div class="modal-dialog">
					<div class="modal-content" style="height: 80vh;">
						<div class="modal-header"  style="background-color: #24272d; color: white">
							<h1 class="modal-title" style="margin-left: 15%">Alterar Telefone</h1>
							<button type="button" class="close" data-dismiss="modal">×</button>
						</div>
						<div class="modal-body" style="overflow-y: scroll;">
							<div class="form-group">
                                    	<label for="inputChangeDDI">DDI:</label>
                                    	<input minlength="2" maxlength="3" type="text" id="inputChangeDDI" name="inputChangeDDI" placeholder="Ex.: +55 (Brasil)" class="form-control" required style="border-color: black">
                                    	<label for="inputChangeDDD" style="margin-top: 1%">DDD:</label>
                                    	<input minlength="2" maxlength="2" type="text" id="inputChangeDDD" name="ddd" placeholder="Ex.: 34 (Uberlândia)" class="form-control" required required style="border-color: black">
                                    	<label for="inputChangePhone" style="margin-top: 2%">Número:</label>
                                    	<input minlength="9" maxlength="9" type="text" id="inputChangePhone" name="inputChangePhone" placeholder="Ex.: 999999999" class="form-control" required required style="border-color: black">
                                    </div>
						<div class="modal-footer">
							<button onclick="changeMyPhone();" id="btnChangePhone" class="btn btn-success form-control" style="width: 90%;" type="submit">Salvar alterações</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						</div>
						<div class="alert alert-success" id="divSuccessMsg3" style="display: none; margin-top: 10px;">
							<strong>Registro atualizado com sucesso: </strong><span id="successMsg3"></span>
						</div>

						<div class="alert alert-danger" id="divErrorMsg3" style="display: none; margin-top: 10px;">
							<strong>A operação não pode ser realizada: </strong><span id="errorMsg3"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
					
				</div>
			</div>
		</div>
	</div>
	<!--pega os valores e altera de acordo com o input do Modal  -->

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
	<script src="scripts/myDatas.js"></script>
	<!-- Footer -->
	<?php
		include "footer.php";
	?>
</body>

</html>