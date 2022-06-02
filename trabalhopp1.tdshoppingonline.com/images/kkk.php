<?php
	//session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Minha Conta - T&D</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/stylesMyAccount.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesCart.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesFooter.css?v=15">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
</head>
<body>
	<?php 
		if(isset($_SESSION["name"]))
			$name = explode(" ",$_SESSION["name"])[0];
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
			    <a href="../../../../xampp/htdocs/eCommerce/home.html">Sair</a>
			</div>
		</div>
	</nav>
	<div class="finishOrder flap currentFlap"><!--  Order Completion Tab -->
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
				<div class="col-4" style="padding-left: 15%;"><span>Produto</span></div> 
				<div class="col-2"><span>Preço/unidade</span></div> 
				<div class="col-3"><span>Quantidade</span></div>
				<div class="col-2" style="padding-left: 4%;"><span>Subtotal</span></div>
				<div class="col-1" style="margin-left: -2%;"><span>Operações</span></div>
			</div>
		</div>
		<div class="container">
			<div class = "container cartContainer" style="margin-top: 2%;">
			    <div class="row">
			        <div class="col-1 cartPart1"> 
			        	<img class="productCart" src="images/sale/item1.jpg">
			        </div>
			        <div class="col-3 cartPart2"> 
			        	<p>Celular bla bla bla bla</p>
			        </div>
			        <div class="col-2 cartPart3"> 
			        	<p class="strikedPrice">R$1161.45<br></p>
						<p class="truePrice">R$983.96</p>
			        </div>
			        <div class="col-3 cartPart4">
			        	<div class="buttons-change-stock">
			        		<button value="+" name="+">-</button>
			        		<input type="text" name="wishNumber" value="0">
			        		<button value="-" name="-">+</button>
	        			</div>
			         </div>
			        <div class="col-2 cartPart5"> 
			        	<p class="Sub-total-Value">R$180,00</p>
			        </div>
			        <div class="col-1 cartPart6">
			        	<p><a href="#"><img src="images/cart/edit.png" alt="Editar"></a></p>
			        	<p><a href="#"><img src="images/heart.png" alt="Favoritar"></a></p>
			        	<p><a href="#"><img src="images/cart/trash.png" alt="Remover"></a></p>
			         </div>
			    </div>
			    <div class="row">
			        <div class="col-1 cartPart1"> 
			        	<img class="productCart" src="images/sale/item1.jpg">
			        </div>
			        <div class="col-3 cartPart2"> 
			        	<p>Celular bla bla bla bla</p>
			        </div>
			        <div class="col-2 cartPart3"> 
			        	<p class="strikedPrice">R$1161.45<br></p>
						<p class="truePrice">R$983.96</p>
			        </div>
			        <div class="col-3 cartPart4">
			        	<div class="buttons-change-stock">
			        		<button value="+" name="+">-</button>
			        		<input type="text" name="wishNumber" value="0">
			        		<button value="-" name="-">+</button>
	        			</div>
			         </div>
			        <div class="col-2 cartPart5"> 
			        	<p class="Sub-total-Value">R$180,00</p>
			        </div>
			        <div class="col-1 cartPart6">
			        	<p><a href="#"><img src="images/cart/edit.png" alt="Editar"></a></p>
			        	<p><a href="#"><img src="images/heart.png" alt="Favoritar"></a></p>
			        	<p><a href="#"><img src="images/cart/trash.png" alt="Remover"></a></p>
			         </div>
			    </div>
			</div>
		</div>
		<script src="scripts/buttonsQuantity.js"></script>
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
		        	<p class="subtotalPurchase" style="font-size: 2.5vh;">R$180,00</p>
		        	<p class="discountPurchase" style="border-bottom: 1px solid grey; font-size: 2.5vh;">-R$0,00</p>
		        	<p class="totalPurchase" style="font-size: 3vh;">R$180,00</p>
		        	<button id="btn-buy" style="display: none;"><img src="images/botao-comprar.png"></button>
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
  				<button type="button" class="btn btn-success btn-getTicket">Gerar boleto</button>
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
					  <button type="submit" class="btn btn-success">Finalizar compra</button>
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
					  <button type="submit" class="btn btn-success">Finalizar compra</button>
					</form>
  				</div>
  			</div>
  		</div>
	</div>  <!-- Order Completion Tab END-->

	<script type="text/javascript">

		var paymentDisplay = document.getElementsByClassName('payment');
		var paymentOptions = document.getElementsByClassName('optionPayment');
		var activeOption, activePayment;

		paymentOptions[0].onclick = function(){
			activePayment = document.getElementsByClassName('activePayment')[0];
			activePayment.classList.remove('activePayment');
			paymentDisplay[0].classList.add('activePayment');
		}
		paymentOptions[1].onclick = function(){
			activePayment = document.getElementsByClassName('activePayment')[0];
			activePayment.classList.remove('activePayment');
			paymentDisplay[1].classList.add('activePayment');
		}
		paymentOptions[2].onclick = function(){
			activePayment = document.getElementsByClassName('activePayment')[0];
			activePayment.classList.remove('activePayment');
			paymentDisplay[2].classList.add('activePayment');
		}
	</script>

	<div class="myOrders flap">
		<div class="container containerCartSubtitles"  style="margin-top: 5%;">
			<div class="row">
				<div class="col-5" style="padding-left: 15%;"><span>Produtos</span></div> 
				<div class="col-2"></div> 
				<div class="col-3"><span>Data da compra</span></div>
				<div class="col-2" style="padding-left: 4%;"><span>Valor total</span></div>
			</div>
		</div>
		<div class="container">
			<div class = "container ordersContainer" style="margin-top: 2%;">
			    <div class="row">
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
			    </div>
			    <div class="row">
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
			    </div>
			</div>
		</div>
	</div>

	<div class="myData flap">
		<div class="container">
			<div class = "container datesTop" style="margin-top: 2%; background-color: white;">
			    <div class="row">
			        <div class="col-sm-4 mt-3 mb-5 ordersPart1"> 
			        	<img id="avatarImage" class="avatar" src="images/myAccount/Bruna.jpg">
			        	<input type="file" name="selectPhoto" onchange="readURL(this);">
			        </div>
			        <div class="col-sm-7 mt-5 mb-5 ordersPart2 col-sm-offset-2" style="border: 1px solid grey; border-radius: 5px"> 
			        		<p><label class="btn btn-defaut" style="font-weight: bold">NOME:</label><span>Bruna Marquezine</span>
			        			<a data-toggle="modal" data-target="#myModal" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
			        		<hr id="infoBar">
			        		<p><label class="btn btn-defaut" style="font-weight: bold">ENDEREÇO:</label><span>Av. Joaõ Naves de Ávila, 2121</span>
			        		<hr id="infoBar">
			        		<p><label class="btn btn-defaut" style="font-weight: bold">E-MAIL:</label><span>brunamarqueza@globo.com</span>
			        		<a data-toggle="modal" data-target="#myModal" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
			        		<hr id="infoBar">
			        		<p><label class="btn btn-defaut" style="font-weight: bold">TELEFONE:</label><span>+00 00 00000-0000</span>
			        		<a data-toggle="modal" data-target="#myModal" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
			        		<hr id="infoBar">
			        		<p><label class="btn btn-defaut" style="font-weight: bold">EMPRESA:</label><span>Globo</span>
			        		<a data-toggle="modal" data-target="#myModal" class="changeCamp">Alterar</a><i class="fa fa-pencil ml-3"></i></p>
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
	        <h1 class="target-nome" ></h1>
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
		$(".changeCamp").click(function(){
			objetoCorrente=this;
			currentLabel = objetoCorrente.previousElementSibling.previousElementSibling.innerHTML;
			document.getElementsByClassName('target-nome')[0].innerHTML = currentLabel;
		});

		$('.btn-save').click(function alteraCampo(){
			field = objetoCorrente.previousElementSibling;
			if(currentLabel != "TELEFONE:"){
				if(document.getElementById('inputText').value != null &&  document.getElementById('inputText').value != '')
					field.innerHTML = document.getElementById('inputText').value;
				else
					alert('Campo inválido');
			}
			else{
				if(document.getElementById('inputText').value != null &&  document.getElementById('inputText').value != '' && !isNaN(parseInt(document.getElementById('inputText').value))){
					field.innerHTML = document.getElementById('inputText').value;
				}
				else
					alert('Campo inválido');
			}
		});
		
	</script>
<!--  -->
<!-- trocar imagem de acordo com o input tipo file -->
	<script type="text/javascript">
		function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            document.getElementById('avatarImage').src = e.target.result;
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
}
	</script>
<!--  -->
	<script type="text/javascript">
		var flaps = document.getElementsByClassName('flap');
		var cols = document.querySelectorAll('.colMyAccountPage a');
		cols[0].onclick = function(){
			var currentFlap = document.getElementsByClassName('currentFlap')[0];
			var currentCol = document.getElementsByClassName('selected')[0];
			currentFlap.classList.remove('currentFlap');
			currentCol.classList.remove('selected');
			this.classList.add('selected');
			flaps[0].classList.add('currentFlap');
		}
		cols[1].onclick = function(){
			var currentFlap = document.getElementsByClassName('currentFlap')[0];
			var currentCol = document.getElementsByClassName('selected')[0];
			currentFlap.classList.remove('currentFlap');
			currentCol.classList.remove('selected');
			this.classList.add('selected');
			flaps[1].classList.add('currentFlap');
		}
		cols[2].onclick = function(){
			var currentFlap = document.getElementsByClassName('currentFlap')[0];
			var currentCol = document.getElementsByClassName('selected')[0];
			currentFlap.classList.remove('currentFlap');
			currentCol.classList.remove('selected');
			this.classList.add('selected');
			flaps[2].classList.add('currentFlap');
		}
	</script>

			<!-- Footer -->
<footer class="page-footer font-small" style="background-color: #f2eada; margin-top: 4%;">

    <div style="background-color: #1eb4ff;">
      <div class="container">

        <!-- Grid row-->
        <div class="row py-0.8 d-flex align-items-center">

          <!-- Grid column -->
          <div class="col-md">
            <span id="socialMediaText" style="color: #323749;">Conecte-se conosco pelas mídias sociais!</span>
            <a class="btn btn-twitter iconeTwitter">
   				 <span class="fa fa-twitter"></span>
   				 <span style="color: #323749;">Twitter</span>
  			</a>
  			<a class="btn btn-facebook inconefacebook">
   				 <span class="fa fa-facebook"></span>
   				 <span style="color: #323749;">Facebook</span>
  			</a>
  			<a class="btn btn-google iconeGoogle">
   				 <span class="fa fa-google"></span>
   				 <span style="color: #323749;">Google</span>
  			</a>
  			
          </div>
          <!-- Grid column -->

        </div>
        <!-- Grid row-->

      </div>
    </div>

    <!-- Footer Links -->
    <div class="container text-center text-md-left mt-3">

      <!-- Grid row -->
      <div class="row mt-0.5">

        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

          <!-- Content -->
          <h6 class="text-uppercase font-weight-bold companyH6" style="margin-left: 23.4%">Companhia</h6>

                <div id="logoFooter">
					<a href="#"><img id = "logoImg" src="images/logo.png"/></a>
				</div>

          <p>Melhor E-comerce disponível!</p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Informações</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <a data-toggle="modal" data-target="#myPolitics" href="#!">Política de privacidade</a>
          </p>
         
          <p>
            <a data-toggle="modal" data-target="#aboutTD" href="#!">Sobre nós</a>
          </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Links úteis</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <a href="../../../../xampp/htdocs/eCommerce/myAccount.html">Sua Conta</a>
          </p>
          <p>
            <a href="../../../../xampp/htdocs/eCommerce/favorites.html">Favoritos</a>
          </p>
          <p>
            <a href="#!">Ajuda</a>
          </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Contatos</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <i class="fa fa-home mr-3"></i> Uberlândia-MG, BR</p>
          <p>
            <i class="fa fa-envelope mr-3"></i> TD.ecomerce@gmail.com</p>
          <p>
            <i class="fa fa-phone mr-3"></i> +55 34 99879-9366</p>
          <p>
            <i class="fa fa-phone mr-3"></i> +55 38 99128-9688</p>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row -->

    </div>

    <!-- Copyright -->
    <div class="footer-copyright text-center py-1" style="margin-right: 3.35%; background-color: #ffc711; width: 100%">© 2019 Copyright:
     	<a href="#"> T&D </a> - Thiago & Dahlan Store
    </div>
    <!-- Copyright -->

    <!--Modal-->
<div class="container">
  <!-- The Modal -->
  <div class="modal" id="myPolitics">
    <div class="modal-dialog">
      <div class="modal-content" style="height: 80vh;">
      
        <!-- Modal Header -->
        <div id="mhResponsive" class="modal-header bg-info">
          <h1 class="modal-title">Política de privacidade</h1>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y: scroll;">
      
          <p style="text-align: justify;">
          	<span style="font-weight: bold;">SEÇÃO 1 - O QUE FAREMOS COM ESTA INFORMAÇÃO?</span><br>

Quando você realiza alguma transação com nossa loja, como parte do processo de compra e venda, coletamos as informações pessoais que você nos dá tais como: nome, e-mail e endereço.

Quando você acessa nosso site, também recebemos automaticamente o protocolo de internet do seu computador, endereço de IP, a fim de obter informações que nos ajudam a aprender sobre seu navegador e sistema operacional.

Email Marketing será realizado apenas caso você permita. Nestes emails você poderá receber notícia sobre nossa loja, novos produtos e outras atualizações.

<br><br><span style="font-weight: bold;">SEÇÃO 2 - CONSENTIMENTO:</span><br>

Como vocês obtêm meu consentimento?

Quando você fornece informações pessoais como nome, telefone e endereço, para completar: uma transação, verificar seu cartão de crédito, fazer um pedido, providenciar uma entrega ou retornar uma compra. Após a realização de ações entendemos que você está de acordo com a coleta de dados para serem utilizados pela nossa empresa.

Se pedimos por suas informações pessoais por uma razão secundária, como marketing, vamos lhe pedir diretamente por seu consentimento, ou lhe fornecer a oportunidade de dizer não.

E caso você queira retirar seu consentimento, como proceder?

Se após você nos fornecer seus dados, você mudar de ideia, você pode retirar o seu consentimento para que possamos entrar em contato, para a coleção de dados contínua, uso ou divulgação de suas informações, a qualquer momento, entrando em contato conosco em TD.ecomerce@gmail.com ou nos enviando uma correspondência em: T&D - Thiago e Dahlan Store Av. João Naves de Ávila, 2121 - Bairro Santa Mônica

<br><br><span style="font-weight: bold;">SEÇÃO 3 - DIVULGAÇÃO:</span><br>


Podemos divulgar suas informações pessoais caso sejamos obrigados pela lei para fazê-lo ou se você violar nossos Termos de Serviço.

<br><br><span style="font-weight: bold;">SEÇÃO 4 - SERVIÇOS DE TERCEIROS:</span><br>

No geral, os fornecedores terceirizados usados por nós irão apenas coletar, usar e divulgar suas informações na medida do necessário para permitir que eles realizem os serviços que eles nos fornecem.

Entretanto, certos fornecedores de serviços terceirizados, tais como gateways de pagamento e outros processadores de transação de pagamento, têm suas próprias políticas de privacidade com respeito à informação que somos obrigados a fornecer para eles de suas transações relacionadas com compras.

Para esses fornecedores, recomendamos que você leia suas políticas de privacidade para que você possa entender a maneira na qual suas informações pessoais serão usadas por esses fornecedores.

Em particular, lembre-se que certos fornecedores podem ser localizados em ou possuir instalações que são localizadas em jurisdições diferentes que você ou nós. Assim, se você quer continuar com uma transação que envolve os serviços de um fornecedor de serviço terceirizado, então suas informações podem tornar-se sujeitas às leis da(s) jurisdição(ões) nas quais o fornecedor de serviço ou suas instalações estão localizados.

Como um exemplo, se você está localizado no Canadá e sua transação é processada por um gateway de pagamento localizado nos Estados Unidos, então suas informações pessoais usadas para completar aquela transação podem estar sujeitas a divulgação sob a legislação dos Estados Unidos, incluindo o Ato Patriota.

Uma vez que você deixe o site da nossa loja ou seja redirecionado para um aplicativo ou site de terceiros, você não será mais regido por essa Política de Privacidade ou pelos Termos de Serviço do nosso site.

Links

Quando você clica em links na nossa loja, eles podem lhe direcionar para fora do nosso site. Não somos responsáveis pelas práticas de privacidade de outros sites e lhe incentivamos a ler as declarações de privacidade deles.


<br><br><span style="font-weight: bold;">SEÇÃO 5 - SEGURANÇA:</span><br>

Para proteger suas informações pessoais, tomamos precauções razoáveis e seguimos as melhores práticas da indústria para nos certificar que elas não serão perdidas inadequadamente, usurpadas, acessadas, divulgadas, alteradas ou destruídas.

Se você nos fornecer as suas informações de cartão de crédito, essa informação é criptografada usando tecnologia "secure socket layer" (SSL) e armazenada com uma criptografia AES-256. Embora nenhum método de transmissão pela Internet ou armazenamento eletrônico é 100% seguro, nós seguimos todos os requisitos da PCI-DSS e implementamos padrões adicionais geralmente aceitos pela indústria.

<br><br><span style="font-weight: bold;">SEÇÃO 6 - ALTERAÇÕES PARA ESSA POLÍTICA DE PRIVACIDADE:</span><br>

Reservamos o direito de modificar essa política de privacidade a qualquer momento, então por favor, revise-a com frequência. Alterações e esclarecimentos vão surtir efeito imediatamente após sua publicação no site. Se fizermos alterações de materiais para essa política, iremos notificá-lo aqui que eles foram atualizados, para que você tenha ciência sobre quais informações coletamos, como as usamos, e sob que circunstâncias, se alguma, usamos e/ou divulgamos elas.

Se nossa loja for adquirida ou fundida com outra empresa, suas informações podem ser transferidas para os novos proprietários para que possamos continuar a vender produtos para você.
          </p>
          
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>

<div class="container">
  <!-- The Modal -->
  <div class="modal" id="aboutTD">
    <div class="modal-dialog modal-lg"> 
      <div class="modal-content" style="height: 80vh;">
      
        <!-- Modal Header -->
        <div id="mhResponsive" class="modal-header bg-info">
          <h1 class="modal-title">Sobre nós</h1>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body"  style="overflow-y: scroll;">
          <div class="container">
          	<hr>
          	<div class="row">
          		<h5>Alta qualidade!</h5>
          		<hr>
          		<div class="col">
          			<img class="aboutUsIMG" id="highQualityIMG" src="images/qualidade.png" alt="favoritos">
          		</div>
          </div>
          <hr>
          <h5>Melhores Precos!</h5>
          <hr>
          <div class="row">
          		<div class="col">
          			<img class="aboutUsIMG" id="goodPricesIMG" src="images/preçoAcessivel.png" alt="favoritos">
          		</div>
          </div>
          <hr>
          <div class="row">
          	<h5>Pagamento seguro é garantido!</h5>
          	<hr>
          		<div class="col">
          			<img class="aboutUsIMG" id="securePaymentIMG" src="images/pagamentoSeguro.png" alt="favoritos">
          		</div>
          </div>
          <hr>
          <div class="row">
          	<h5>Variedades!</h5>
          	<hr>
          		<div class="col">
          			<img class="aboutUsIMG" id="variousBrandsIMG" src="images/variasMarcas.png" alt="favoritos">
          		</div>
          </div>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
 </div>
</div>
</body>
</html>