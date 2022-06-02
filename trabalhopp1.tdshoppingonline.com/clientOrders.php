<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Minha Conta - T&D</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesCart.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesFooter.css?v=15">
	<link rel="stylesheet" type="text/css" href="css/stylesMyAccount.css?v=15">
	<script src="scripts/jquery.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.form.min.js"></script>
	<link rel="stylesheet" href="scripts/bootstrap.min.css">
	<script src="scripts/popper.min.js"></script>
	<script src="scripts/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
	
	<header>
		<a href="home.php"><img src="images/logo.png" alt="T&D - A Revolução do E-Commerce" style="margin-left: 4%;"></a>
		<span>Thiago & Dahlan Store</span>
		<span style=" float: right; margin-top: 3%; padding-right: 6%; font-size: 2.4vh;"><a href="admin.php">Admin</a></span>
		<span style=" float: right; margin-top: 2%;"><a href="#"><img style="height: 7vh;" src="images/cart/header/boss.png"></a></span>

	</header>
	<div class="container">
			<div class="container datesTop" style="margin-top: 2%; background-color: white; margin-bottom: 4%">
				<div class="row">
					<h3 style="margin: 0 auto;">Cliente/Pedidos:</h3>
				</div>
				<div class="row">
					<div class="col-sm-4 mt-3 mb-5 ordersPart1">
						<div id="avatarProfile">

						<?php 
							require_once "scripts/connectionMysql.php";
							require_once "scripts/client.php";
							require_once "scripts/orders.php";
							$idClient = $_GET["idClient"];
							$conn = connectionToMySQL();
							$client = getClientById($conn, $idClient);
							$arrayOrders = myOrders($idClient, $conn);
							if (isset($idClient) && $client->avatar != null && $client->avatar != "") {
								$avatar = $client->avatar;
								echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/$avatar'>";
							} else if ($client->gender == "M")
								echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarM.jpg'>";
							else if ($client->gender == 'F')
								echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarF.jpg'>";
							else if ($client->gender == 'O')
								echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarO.png'>";
							echo "</div>
							</div>";
							echo "<div class='col-sm-7 mt-5 mb-5 ordersPart2 col-sm-offset-2'>
							<p><label class='btn btn-defaut' style='font-weight: bold'>NOME:</label><span>$client->name</span>
								</p>
							<hr id='infoBar'>
							<p><label class='btn btn-defaut' style='font-weight: bold'>ENDEREÇO:</label><span> $client->street, $client->numberStreet, $client->district, $client->city,$client->zipcode</span>
								<hr id='infoBar'>
								<p><label class='btn btn-defaut' style='font-weight: bold'>E-MAIL:</label><span>$client->email</span>
									</p>
								<hr id='infoBar'>
								<p><label class='btn btn-defaut' style='font-weight: bold'>TELEFONE:</label><span>$client->ddi $client->ddd $client->phone</span>
									</p>	
								</div>	";

								echo "<div class='container containerCartSubtitles' style='margin-top: 5%;'>
								<div class='row'>
									<div class='col-5' style='padding-left: 15%;'><span>Produtos do Cliente</span></div>
									<div class='col-2'></div>
									<div class='col-3'><span>Data da compra</span></div>
									<div class='col-2' style='padding-left: 4%;'><span>Valor total</span></div>
								</div>
							</div>";

							echo "<div class='container'>
							<div class='container ordersContainer' style='margin-top: 2%;'>";

							for($i = 0; $i < sizeof($arrayOrders) ; ++$i){
							echo "
								<div class='row'>
									<div class='col-2 ordersPart1'>
										<img class='productCart' src='images/myAccount/shopping-bag.png'>
									</div>
									<div class='col-3 ordersPart2'>";
									for($j = 0 ; $j < sizeof($arrayOrders[$i]->orderXProducts) ; ++$j){
										$name = $arrayOrders[$i]->orderXProducts[$j]->productName;
										$qtd  = $arrayOrders[$i]->orderXProducts[$j]->quantity;
										echo "
											<p><span class='amount'>$qtd" . "x</span> $name</p>";
									}
									$date = explode(' ', $arrayOrders[$i]->date);
									$timetable = $date[1];
									$date = $date[0];
									$date = implode('/', array_reverse(explode('-', $date)));
									$totalvalue = $arrayOrders[$i]->totalvalue;
									echo" </div>
									<div class='col-2 ordersPart3'>
				
									</div>
									<div class='col-3 ordersPart4'>
										<p class='date'>$date $timetable</p>
									</div>
									<div class='col-2 ordersPart5'>
										<p class='totalValue'>$totalvalue</p>
									</div>
								</div>";
							}
							echo "</div>
						</div>
					</div>";
						?>
									

</body>

</html>