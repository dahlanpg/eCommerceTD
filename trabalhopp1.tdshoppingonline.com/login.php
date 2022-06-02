<?php
	session_start();
	require_once "scripts/connectionMysql.php";
	require_once "scripts/autentication.php";
	$conn = connectionToMySQL();
	if(checkUserIsLoggedOrDie($conn))
		header("location: home.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
	
<head>
	<title>Faça seu login! T&D</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesLogin.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="scripts/validateLogin.js"></script>
	<script src="scripts/validateRegister.js"></script>
	<script src="scripts/searchAddress.js"></script>
	<script src="scripts/passwordVerify.js"></script>
</head>

<body>
	<?php
	require_once "scripts/client.php";
	if(isset($_GET["for"]))
		$indexRedirect = $_GET["for"];
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_GET["for"]))
			$indexRedirect = $_GET["for"];
		try {
			$email = $password = $passwordHash = "";
			$email             = filtraEntrada($_POST["emailLogin"]);
			$password          = filtraEntrada($_POST["passwordLogin"]);

			$conn = connectionToMySQL();
			$sql = "select password from tduser where login = ? LIMIT 1";
			if (!$stmt = $conn->prepare($sql))
				throw new Exception("Falha na operacao prepare: " . $conn->error);
			if (!$stmt->bind_param("s", $email))
				throw new Exception("Falha na operacao bind_param: " . $stmt->error);
			// Executa a consulta
			if (!$stmt->execute())
				throw new Exception("Falha na operacao execute: " . $stmt->error);
			$stmt->store_result();
			if (!$stmt->bind_result($passwordHash)) {
				throw new Exception("Falha na operacao bind_result: " . $stmt->error);
			}
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				if (password_verify($password, $passwordHash)) {
					$stmt->close();
					$client = getClient($conn, $email);

					$_SESSION["id"]           = $client->id;
					$_SESSION["name"]         = $client->name;
					$_SESSION["email"]        = $client->email;
					$_SESSION["gender"]       = $client->gender;
					$_SESSION["ddi"]          = $client->ddi;
					$_SESSION["ddd"]          = $client->ddd;
					$_SESSION["phone"]        = $client->phone;
					$_SESSION["login"]        = $client->login;
					$_SESSION["street"]       = $client->street;
					$_SESSION["numberStreet"] = $client->numberStreet;
					$_SESSION["state"]        = $client->state;
					$_SESSION["zipcode"]      = $client->zipcode;
					$_SESSION["city"]         = $client->city;
					$_SESSION["district"]     = $client->district;
					$_SESSION["complement"]   = $client->complement;
					$_SESSION["avatar"]       = $client->avatar;
					$_SESSION['loginString']  = hash('sha512', $passwordHash . $_SERVER['HTTP_USER_AGENT']);

					if(isset($indexRedirect) && $indexRedirect == 1){ //usuario queria entrar nos favoritos
						echo "<script language='javascript' type='text/javascript'>
						alert('Seu login foi efetuado com sucesso');window.location.href='favorites.php';</script>";
					}elseif(isset($indexRedirect) && $indexRedirect == 2){ //usuario queria entrar na myAccount
						echo "<script language='javascript' type='text/javascript'>
							alert('Seu login foi efetuado com sucesso');window.location.href='myAccount.php';
						</script>";
					}else{ //login normal com redirecionamento para home
						echo "<script language='javascript' type='text/javascript'>
							alert('Seu login foi efetuado com sucesso');window.location.href='home.php';
						</script>";
					}
				}else{ //nao encontrou registro na tabela
					echo "<script language='javascript' type='text/javascript'>alert('Dados não correspondem a nenhum registro');window.location.href='login.php';</script>";
					$stmt->close();
				}
			} else {
				echo "<script language='javascript' type='text/javascript'>alert('Dados não correspondem a nenhum registro');window.location.href='login.php';</script>";
				$stmt->close();
			}
		} catch (Exception $e) {
			echo "<script language='javascript' type='text/javascript'>alert('Aconteceu um erro inesperado, tente novamente');window.location.href='login.php';</script>";
		}
	}
	?>
	<header>
		<a href="home.php"><img src="images/logo.png" alt="T&D - A Revolução do E-Commerce" style="margin-left: 4%;"></a>
		<span>Thiago & Dahlan Store</span>
	</header>
	<div id="loginBody">
		<div id="loginBox">
			<div class="container" style="margin-top: 8%;padding-bottom: 18%;">
				<span><a href="#" class="loginLabel">Login</a></span>
				<span style="margin-left: 10%;"><a href="#" class="registerLabel">Registro</a></span>
				<?php 
					if(isset($_GET["for"])){
						$indexRedirect = $_GET["for"];
						echo "<form name='formLogin' action='login.php?for=$indexRedirect' onSubmit='return validateLogin()' method='post'>";
					}
					else{
						echo "<form name='formLogin' action='login.php' onSubmit='return validateLogin()' method='post'>";
					}
				?>
					<div class="form-group">
						<input type="text" class="form-control" id="nome" name="emailLogin" placeholder="Email" required>
					</div>

					<div class="form-group">
						<input type="password" class="form-control" id="pwd" name="passwordLogin" placeholder="Senha" required>
					</div>
					<span style="float: right; font-size: 0.9em;"><a href="#">Esqueceu sua senha?</a></span>
					<button id="btn-login">Logar</button>
				</form>
			</div>
		</div>
	</div>
	<div id="registerBody">
		<div id="registerBox">
			<div class="container" style="margin-top: 8%; padding-bottom: 10%;">
				<span><a href="#" class="loginLabel">Login</a></span>
				<span style="margin-left: 10%;"><a href="#" class="registerLabel">Registro</a></span>
				<form name="formRegister" id="formRegister" action="" method="post" >
					<div class="form-group">
						<input type="text" maxlength="64" class="form-control" id="nameRegister" name="nameRegister" placeholder="Nome completo" style="width: 82%; float: left;" required>
						<select id="genderRegister" name="genderRegister" style="width: 18%;" required>
							<option value="" disabled selected>Sexo</option>
							<option value="M">M</option>
							<option value="F">F</option>
							<option vlaue="O">Outro</option>
						</select>
					</div>

					<div class="form-group">
						<input type="email" maxlength="64" class="form-control" id="emailRegister" name="emailRegister" placeholder="Email" required style="width: 40%; float: left;">
						<input type="date" class="form-control" name="birthdayDate" id="birthdayDate" placeholder="Data de nascimento" required style="width: 60%;">
					</div>

					<div class="form-group">
						<input type="text" maxlength="11" class="form-control" id="cpfRegister" name="cpfRegister" placeholder="CPF" required style="width: 60%; float: left;" onkeypress="return onlyNumbers(event);" /> 
						<select class="form-control" id="maritalStatus" name="maritalStatus" required style="width: 40%; height:100%;">
							<option class="form-control" value="" disabled selected>Estado civil</option>
							<option class="form-control" value="Solteiro">Solteiro</option>
							<option class="form-control" value="Casado">Casado</option>
							<option class="form-control" value="Separado">Separado</option>
							<option class="form-control" value="Divorciado">Divorciado</option>
							<option class="form-control" value="Viuvo">Viuvo</option>
						</select>
					</div>

					<div class="form-group">
						<input type="password" maxlength="12" class="form-control" id="passwordRegister" name="passwordRegister" onkeyup="passwordVerify()" placeholder="Senha" required>
					</div>

					<div class="form-group">
						<input type="password" maxlength="12" class="form-control" id="password2Register" name="password2Register" onkeyup="passwordVerify()" placeholder="Repita a senha" required>
					</div>
					<h6 id="labelPassword"></h6>
					<label style="color: grey;">Endereço:</label>
					<div class="form-group">
						<input maxlength="8" type="text" class="form-control" id="zipcodeRegister" onkeyup="searchAddress(this.value)" name="zipcodeRegister" placeholder="CEP" required>
					</div>

					<div class="form-group">
						<input type="text" maxlength="32" class="form-control" id="publicAreaRegister" name="publicAreaRegister" placeholder="Logradouro" required>
					</div>

					<div class="form-group">
						<input type="text" maxlength="32" class="form-control" id="districtRegister" name="districtRegister" placeholder="Bairro" required>
						<input type="text" maxlength="5" class="form-control" id="numberHouseRegister" name="numberHouseRegister" placeholder="N°" style="width: 28%;" required onkeypress="return onlyNumbers(event);"/>
					</div>
					<div class="form-group">
						<input type="text" maxlength="32" class="form-control" id="complementRegister" name="complementRegister" placeholder="Complemento">
					</div>

					<div class="form-group">
						<input type="text" class="form-control" id="cityRegister" name="cityRegister" placeholder="Cidade" required>
						<select id="stateRegister" name="stateRegister" class="form-control" required>
							<option value="" disabled selected>Estado</option>
							<option value="AC">Acre</option>
							<option value="AL">Alagoas</option>
							<option value="AP">Amapá</option>
							<option value="AM">Amazonas</option>
							<option value="BA">Bahia</option>
							<option value="CE">Ceará</option>
							<option value="DF">Distrito Federal</option>
							<option value="ES">Espírito Santo</option>
							<option value="GO">Goiás</option>
							<option value="MA">Maranhão</option>
							<option value="MT">Mato Grosso</option>
							<option value="MS">Mato Grosso do Sul</option>
							<option value="MG">Minas Gerais</option>
							<option value="PA">Pará</option>
							<option value="PB">Paraíba</option>
							<option value="PR">Paraná</option>
							<option value="PE">Pernambuco</option>
							<option value="PI">Piauí</option>
							<option value="RJ">Rio de Janeiro</option>
							<option value="RN">Rio Grande do Norte</option>
							<option value="RS">Rio Grande do Sul</option>
							<option value="RO">Rondônia</option>
							<option value="RR">Roraima</option>
							<option value="SC">Santa Catarina</option>
							<option value="SP">São Paulo</option>
							<option value="SE">Sergipe</option>
							<option value="TO">Tocantins</option>
							<option value="EO">Estrangeiro</option>
						</select>
					</div>
				
					<label style="color: grey;">Telefone:</label>
					<div class="form-group">
						<input type="text" maxlength="2" class="form-control" id="ddiRegister" name="ddiRegister" placeholder="DDI" required style="width: 20%;float:left;" onkeypress="return onlyNumbers(event);"/> 
						<input type="text" maxlength="2" class="form-control" id="dddRegister" name="dddRegister" placeholder="DDD" required style="width: 27%;float:left;margin-left:3%;" onkeypress="return onlyNumbers(event);" />
						<input type="text" maxlength="9" class="form-control" id="phoneRegister" name="phoneRegister" placeholder="Numero" required style="width:47%;float:right;" onkeypress="return onlyNumbers(event);"/>
					</div>
					<br><br>
					<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" name="gridCheck" type="checkbox" id="gridCheck" required>
								<label class="form-check-label" for="gridCheck">
									Declaro ter idade superior à 16 anos e aceitar todos os termos do site.
								</label>
							</div>
						</div>
					<button id="btn-login" class="btn-register" type="button" onclick="registerClient();">Registrar</button>
					<div class="alert alert-success" id="divSuccessMsg" style="display: none; margin-top: 10px;">
						<strong>Cadastro realizado com sucesso </strong><span id="successMsg"></span>
					</div>

					<div class="alert alert-danger" id="divErrorMsg" style="display: none; margin-top: 10px;">
						<strong>A operação não pode ser realizada: </strong><span id="errorMsg"></span>
					</div>
				</form>
				<script>
					var btnAtivacted = false;
					document.getElementsByClassName('btn-register')[0].disabled = true;
					var grid = document.getElementById('gridCheck');
					grid.onclick = function(){
						if(!btnAtivacted)
							document.getElementsByClassName('btn-register')[0].disabled = false;
						else
							document.getElementsByClassName('btn-register')[0].disabled = true;
						btnAtivacted = !btnAtivacted;
					}
				</script>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var loginBody = document.getElementById('loginBody');
		var registerBody = document.getElementById('registerBody');
		var loginLabel = document.getElementsByClassName('loginLabel');
		var registerLabel = document.getElementsByClassName('registerLabel');
		var loginBodyDisplay = loginBody.style.display;

		for (var i = 0; i < 2; ++i) {
			registerLabel[i].onclick = function() {
				loginBody.style.display = "none";
				registerBody.style.display = "block";
				registerLabel[0].style.borderBottom = "3px solid #9ed696";
				registerLabel[1].style.borderBottom = "3px solid #9ed696";
				loginLabel[0].style.borderBottom = "none";
				loginLabel[1].style.borderBottom = "none";
				registerBody.style.height = "150vh";
			}

			loginLabel[i].onclick = function() {
				registerBody.style.display = "none";
				loginBody.style.display = "block";
				loginLabel[0].style.borderBottom = "3px solid #9ed696";
				loginLabel[1].style.borderBottom = "3px solid #9ed696";
				registerLabel[0].style.borderBottom = "none";
				registerLabel[1].style.borderBottom = "none";
				loginBody.style.height = "150vh";
			}
		}

		function onlyNumbers(e) {
		var key = event.keyCode;
			if (key > 47 && key < 58 || key == 8 || key == 0) 
				return true;
			else
				return false;
		}
		


	</script>
	<script src="scripts/registerClient.js"></script>
</body>

</html>