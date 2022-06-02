<?php
	session_start();
	try{
		require_once "scripts/connectionMysql.php";
		$conn = connectionToMySQL();
		$result = "";
		$sql = "select * from tdbannershome;";
		$result = $conn->query($sql);
		if(!$result)
			throw new Exception("Nao foi possivel resgatar os banners");

		$row = $result->fetch_assoc();
		$_SESSION["image1"] = $row["image1"];
		$_SESSION["image2"] = $row["image2"];
		$_SESSION["image3"] = $row["image3"];
		$_SESSION["image4"] = $row["image4"];

		$conn->close();
	}catch(Exception $e){
		echo $e->getMessage();
	}
?>
<html>
<head>
	<title>Admin</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesAdmin.css?v=15">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.form.min.js"></script>
</head>

<body>
	<header>
		<a href="home.php"><img src="images/logo.png" alt="T&D - A Revolução do E-Commerce" style="margin-left: 4%;"></a>
		<span>Thiago & Dahlan Store</span>
	</header>
	<nav class="container menuMyAccount">
		<div class="row rowMyAccountPage">
			<div class="col-1 colMyAccountPage">

			</div>
			<div class="col-2 colMyAccountPage">
				<a href="#" class="selected">Cadastro de produtos</a>
			</div>
			<div class="col-2 colMyAccountPage">
				<a href="#">Listagem dos pedidos</a>
			</div>
			<div class="col-2 colMyAccountPage">
				<a href="#">Listagem dos clientes</a>
			</div>
			<div class="col-2 colMyAccountPage">
				<a href="#">Adicionar Banner</a>
			</div>
			<div class="col-3 colMyAccountPage">
				<a href="#">Atualizar Produto</a>
			</div>

		</div>
	</nav>
	<div class="registerProduct flap currentFlap">
		<!--  Order Completion Tab -->
		<div class="container" style="margin-top: 2%;">
			<div id="registerProduct">
				<form action="" method="POST" name="formProduct" id="formProduct">
					<div class="form-group">
						<input type="text" class="form-control" id="offerTitle" name="offerTitle" placeholder="Titulo da oferta" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="nome" name="name" placeholder="Nome de identificação" required>
					</div>
					<div class="form-group">
						<select name="category" class="form-control">
							<option value="" selected disabled>Categoria</option>
							<option value="Celulares">Celular</option>
							<option value="Relogios">Relógio</option>
							<option value="Vestuarios">Vestuário</option>
							<option value="Joias">Jóia</option>
							<option value="Esportes">Esporte</option>
							<option value="Domesticos">Doméstico</option>
							<option value="Eletronico">Eletrônico</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="pwd" name="manufacturer" placeholder="Fabricante" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="pwd" name="price" placeholder="Preço de venda" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="pwd" name="quantity" placeholder="Estoque" required>
					</div>
					<div class="form-group">
						<textarea type="text" class="form-control" id="pwd" name="description" placeholder="Descrição" rows="6" required></textarea>
					</div>
					<div class="form-group">
						<div class="attributes-form">
							<input type="text" class="form-control attributes" name="attribute" placeholder="Atributo 1">
						</div>
						<button type="button" style="margin-top: 1%; float: right;" class="btn btn-success btn-attribute">Adicionar atributo</button>
					</div>

						<label for="imgRegister1" class="imgRegisterLabel">1ª imagem</label>
						<input type="file" name="imgRegister1" id="imgRegister1" onchange="readURL(this,'imgP1')"/>
						<span class="imgP p1"><img id="imgP1"></span>

						<label for="imgRegister2" class="imgRegisterLabel">2ª imagem</label>
						<input type="file" name="imgRegister2" id="imgRegister2" onchange="readURL(this,'imgP2')"/>
						<span class="imgP p2"><img id="imgP2"></span>

					<button id="btn-register" onclick="sendForm()" class="btn btn-success form-control">Registrar</button>
					<input style="display: none;" type="text" name="attibutesText" id="attributesHidden"/>
					<br>
				</form>		
				<h4 id="successMsg" class="text-success"></h4>
				<h4 id="errorMsg" class="text-danger"></h4>

				<script type="text/javascript">
					var btn = document.getElementsByClassName("btn-attribute")[0];
					var attributsPattern = document.getElementsByClassName("attributes-form")[0];
					var lastInput = btn.previousElementSibling;
					var cont = 2;
					btn.onclick = function() {
						var newInput = document.createElement('input');
						newInput.classList.add('form-control');
						newInput.classList.add('attributes');
						newInput.placeholder = "Atributo " + cont;
						attributsPattern.appendChild(newInput);
						++cont;
					}

					function readURL(input, $nameId) {
						if (input.files && input.files[0]) {
							var reader = new FileReader();
							reader.onload = function(e) {
								document.getElementById($nameId).src = e.target.result;
							}
							reader.readAsDataURL(input.files[0]);
						}
					};
				</script>
			</div>
		</div>

	</div> <!-- Order Completion Tab END-->
	<script src="scripts/addProduct.js"></script>
	<div class="listOrders flap">
		<div class="container" style="margin-top: 2%;">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Número do pedido</th>
						<th>Data do pedido</th>
						<th>Valor total do pedido</th>
						<th>Forma de pagamento</th>
						<th>Ver detalhes</th>
					</tr>
				</thead>
				<tbody id="listOrdersTr">
				</tbody>
			</table>
		</div>
	</div>
			<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header" style="background-color: #7d8da5">
									<h2 style="color: white">Detalhes do pedido:</h2>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="modal-body">
							<tbody id="orderProduct">
								<div class="row" style="border: 1px solid grey;">
									<div class="col-5"><span style="font-size: 3vh">Nome do produto</span></div>
									<div class="col-2"></div>
									<div class="col-5" style="border-left: 1px solid grey;"><span style="font-size: 3vh">Quantidade</span></div>
								</div>
								
								
								<div class="row" style="margin-top: 2%;">
								</div>	
								<div id="orderProduct">
								</div>		
						</tbody>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					
	<script src="scripts/detailsWish.js"></script>
	<div class="listClients flap">
		<div class="container" style="margin-top: 2%;">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>Nome do Cliente</th>
						<th>Ver pedidos do cliente</th>
						<th>Remover Cliente</th>
					</tr>
				</thead>
				<tbody id="listClientsTr">
				</tbody>
			</table>
		</div>
	</div>
	<span id="recordedId" style="display:none;"></span>
	<script>
		function redirect(id){
			window.location.href='clientOrders.php?idClient='+id;
		}
	</script>

	<div class="listBanner flap">
		<div class="container">
			<div class="row" style="height: 50%; margin-top: 2%; margin-bottom: 2%;">
				<div class="col-6 banner1" id="banner1" style="margin-left: 25%;">
				<?php 
					if(isset($_SESSION["image1"])){
						$name = $_SESSION["image1"];
						echo "<img src='images/sale/$name' id='bannerImage' class='banner'>";
					}
					?>
				</div>
			</div>
				<form name="formBanner1" id="formBanner1"  enctype="multipart/form-data" action="scripts/uploadBanners.php?name=bannerInput1" method="post">
					<label for="bannerInput1">Selecionar banner</label>
					<input type="file" name="bannerInput1" id="bannerInput1">
				</form>
		</div>
		<div class="container">
			<div class="row" style="height: 50%; margin-top: 2%; margin-bottom: 2%;">
				<div class="col-6 banner2" id="banner2" style="margin-left: 25%;">
				<?php 
					if(isset($_SESSION["image2"])){
						$name = $_SESSION["image2"];
						echo "<img src='images/sale/$name' id='bannerImage' class='banner'>";
					}
					?>
				</div>
			</div>
			<form name="formBanner2" id="formBanner2"  enctype="multipart/form-data" action="scripts/uploadBanners.php?name=bannerInput2" method="post">
					<label for="bannerInput2">Selecionar banner</label>
					<input type="file" name="bannerInput2" id="bannerInput2">
				</form>
		</div>
		<div class="container">
			<div class="row" style="height: 50%; margin-top: 2%; margin-bottom: 2%;">
				<div class="col-6 banner3" id="banner3" style="margin-left: 25%;">
				<?php 
					//if(isset($_SESSION["image3"])){
						$name = $_SESSION["image3"];
						echo "<img src='images/sale/$name' id='bannerImage' class='banner'>";
					//}
					?>
				</div>
			</div>
			<form name="formBanner3" id="formBanner3"  enctype="multipart/form-data" action="scripts/uploadBanners.php?name=bannerInput3" method="post">
					<label for="bannerInput3">Selecionar banner</label>
					<input type="file" name="bannerInput3" id="bannerInput3"/>
				</form>
		</div>
		<div class="container">
			<div class="row" style="height: 50%; margin-top: 2%; margin-bottom: 2%;">
				<div class="col-6 banner4" id="banner4" style="margin-left: 25%;">
					<?php 
					if(isset($_SESSION["image4"])){
						$name = $_SESSION["image4"];
						echo "<img src='images/sale/$name' id='bannerImage' class='banner'>";
					}
					?>
				</div>
			</div>
			<form name="formBanner4" id="formBanner4"  enctype="multipart/form-data" action="scripts/uploadBanners.php?name=bannerInput4" method="post">
					<label for="bannerInput4">Selecionar banner</label>
					<input type="file" name="bannerInput4" id="bannerInput4"/>
				</form>
		</div>
	</div>
	<script type="text/javascript">
				$(document).ready(function() {
					$('#bannerInput1').on('change', function() {
					$('.banner1').html('<img src="images/ajax-loader.gif" alt="Enviando..."/> Enviando...');
					$('#formBanner1').ajaxForm({
					target: '#banner1'
				}).submit();
			  });
			})

			$(document).ready(function() {
					$('#bannerInput2').on('change', function() {
					$('.banner2').html('<img src="images/ajax-loader.gif" alt="Enviando..."/> Enviando...');
					$('#formBanner2').ajaxForm({
					target: '#banner2'
				}).submit();
			  });
			})

			$(document).ready(function() {
					$('#bannerInput3').on('change', function() {
					$('.banner3').html('<img src="images/ajax-loader.gif" alt="Enviando..."/> Enviando...');
					$('#formBanner3').ajaxForm({
					target: '#banner3'
				}).submit();
			  });
			})

			$(document).ready(function() {
					$('#bannerInput4').on('change', function() {
					$('.banner4').html('<img src="images/ajax-loader.gif" alt="Enviando..."/> Enviando...');
					$('#formBanner4').ajaxForm({
					target: '#banner4'
				}).submit();
			  });
			})

		//refresh banners

	</script>
	<div class="refreshProduct flap">
		<div class="container" style="margin-top: 2%;">
			<div id="registerProduct">
				<form action="/admin.php" method="POST">
						<div class="form-group">
						  Selecione o produto:
					      <input onkeyup="showProducts(this.value)" type="text" class="form-control" id="productName" name="productName" placeholder="Encontrar produto..." required>
					    	</div>
					    	<div class="container" style="margin-top: 2%;">
			<table class="table table-striped table-hover" style="margin-left:-75%;">
    			<thead>
      			<tr>
					<th>Id</th>
					<th>Produto</th>	
					<th>Vendidos</th>
					<th>Preço</th>	
					<th>Estoque</th>	
					<th>Visualizar produto</th>	
					<th>Atualizar preço</th>
					<th>Alterar estoque</th>
					<th>Remover produto</th>	
      		   </tr>
    		</thead>
    	<tbody id="productsList">
			<!-- <tr>	<td>1</td>  <td>Iphone</td> <td></td> <td><img src='images/admin/trash.png' id='trashIcon' data-toggle='modal' data-target='#confirm'></td><td><img id="seeProductIcon" src="images/admin/product.png"></td></tr><tr> -->
			
		</tbody>
  </table>

  </div>
	</form>

  		</div>	
		</div>
	</div>  
 
	<script src="scripts/showProducts.js"></script>
	<div class="modal" id="confirm" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Remover Cliente</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Tem certeza que deseja remover?</p>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="removeClient()" class="btn btn-primary" data-dismiss="modal">Sim</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
				</div>
			</div>
		</div>
	</div>
	<script src="scripts/removeClient.js"></script>
	
	<div class="modal" id="removeProduct" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Remover Produto</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Tem certeza que deseja remover?</p>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="removeProduct()" class="btn btn-primary" data-dismiss="modal">Sim</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
				</div>
			</div>
		</div>
	</div>
	<script src="scripts/removeProduct.js"></script>
	
	<div class="modal" id="modalPrice" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="titleModalPrice">Alterar Preço</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label for="inputPrice" id="labelPrice">Novo preço: </label>
					<input type="text" id="inputPrice" name="inputPrice" class="form-control" placeholder="ex: 1970.99">
				</div>
				<div class="modal-footer">
					<button type="button" onclick="refreshPrice()" class="btn btn-primary" >Alterar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
				<div class="alert alert-success" id="divSuccessMsgPrice" style="display: none; margin-top: 10px;">
					<strong>Preço atualizado com sucesso: </strong><span id="successMsgPrice"></span>
				</div>

				<div class="alert alert-danger" id="divErrorMsgPrice" style="display: none; margin-top: 10px;">
					<strong>A operação não pode ser realizada: </strong><span id="errorMsgPrice"></span>
				</div>
			</div>
		</div>
	</div>

	<div name='modalQtd' class="modal" id="modalQtd" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="titleModalPrice">Alterar Estoque</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label for="inputPrice" id="labelPrice">Novo estoque: </label>
					<input type="text" id="inputQtd" name="inputQtd" class="form-control" placeholder="Quantidade">
				</div>
				<div class="modal-footer">
					<button type="button" onclick="refreshStock()" class="btn btn-primary" >Alterar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
				<div class="alert alert-success" id="divSuccessMsgQtd" style="display: none; margin-top: 10px;">
					<strong>Estoque atualizado com sucesso: </strong><span id="successMsgQtd"></span>
				</div>

				<div class="alert alert-danger" id="divErrorMsgQtd" style="display: none; margin-top: 10px;">
					<strong>A operação não pode ser realizada: </strong><span id="errorMsgQtd"></span>
				</div>
			</div>
		</div>
	</div>
	<script src="scripts/listOrdersAdmin.js"></script>
	<script src="scripts/listClientsAdmin.js"></script>
	<script src="scripts/refreshPrice.js"></script>
	<script src="scripts/refreshStock.js"></script>
	<script type="text/javascript">
		var flaps = document.getElementsByClassName('flap');
		var cols = document.querySelectorAll('.colMyAccountPage a');

		function changeFlap(object, i){
			var currentFlap = document.getElementsByClassName('currentFlap')[0];
			var currentCol = document.getElementsByClassName('selected')[0];
			currentFlap.classList.remove('currentFlap');
			currentCol.classList.remove('selected');
			object.classList.add('selected');
			flaps[i].classList.add('currentFlap');
		}

		cols[0].onclick = function() {
			changeFlap(this, 0);
		}

		cols[1].onclick = function() {
			listOrdersAdmin();
			changeFlap(this, 1);
		}

		cols[2].onclick = function() {
			listClientsAdmin();
			changeFlap(this, 2);
		}

		cols[3].onclick = function() {
			changeFlap(this, 3);
		}
		cols[4].onclick = function() {
			changeFlap(this, 4);
		}

	</script>
</body>

</html>