<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(!isset($_POST["gridCheck"])){
			echo "Você nao aceitou os termos";
			die();
		}

		require_once "connectionMysql.php";

		$name = $email = $cpf = $gender = $maritalStatus = $birthdayDate = $password1 
		= $password2 = $zipcode = $street = $district = $number = $city = $state = $ddi 
		= $ddd = $phone = $complement = "";

			$name              = filtraEntrada($_POST["nameRegister"]);
			$gender            = filtraEntrada($_POST["genderRegister"]);     
			$email             = filtraEntrada($_POST["emailRegister"]);
			$cpf               = filtraEntrada($_POST["cpfRegister"]);
			$maritalStatus     = filtraEntrada($_POST["maritalStatus"]);
			$birthdayDate      = filtraEntrada($_POST["birthdayDate"]);
			$password1         = filtraEntrada($_POST["passwordRegister"]);
			$password2         = filtraEntrada($_POST["password2Register"]);
			$zipcode           = filtraEntrada($_POST["zipcodeRegister"]);
			$street            = filtraEntrada($_POST["publicAreaRegister"]);
			$district          = filtraEntrada($_POST["districtRegister"]);
			$number            = filtraEntrada($_POST["numberHouseRegister"]);
			$complement        = filtraEntrada($_POST["complementRegister"]);
			$city              = filtraEntrada($_POST["cityRegister"]);
			$state             = filtraEntrada($_POST["stateRegister"]);
			$ddi               = filtraEntrada($_POST["ddiRegister"]);
			$ddd               = filtraEntrada($_POST["dddRegister"]);
			$phone             = filtraEntrada($_POST["phoneRegister"]);

			try{ //verificações
				if(!isset($name, $gender, $email, $cpf, $maritalStatus, $birthdayDate, $password1, 
						  $password2, $zipcode, $street, $district, $number, $city, $state, $ddi, $ddd,
						  $ddd, $phone)){
							  throw new Exception("Dados inválidos<br>");
						  }

				if($name == "" ||$gender == "" || $email == "" || $cpf == "" || $maritalStatus == "" || $birthdayDate == "" ||
				   $birthdayDate == "" || $password1 == "" || $password2 == "" || $zipcode == "" || $street == "" ||
				   $district == "" || $number == "" || $city == "" || $state == "" || $ddi == "" || $ddd == "" || $phone == ""){
					throw new Exception("Campos inválidos<br>");
				   }
				
				if($gender != "M" && $gender != "F" && $gender != "O"){
					throw new Exception("Campo de gênero inválidos<br>");
				}

				if(!strstr($email, "@") || !strstr($email, "."))
					throw new Exception("Email inválido<br>");
				
				if(strlen($cpf) != 11 || !is_numeric($cpf)) 
					throw new Exception("Cpf inválido<br>");

				if($maritalStatus != "Solteiro" && $maritalStatus != "Casado" && $maritalStatus != "Divorciado" && $maritalStatus != "Viuvo" && $maritalStatus != "Separado"){
					throw new Exception("Estado civil<br>");
				}

				$d = DateTime::createFromFormat('d/m/Y', $birthdayDate);
				if($d && $d->format('d/m/Y') != $birthdayDate){
					throw new Exception("Data de nascimento inválida<br>");
				}

				$date = new DateTime($birthdayDate); 
				$interval = $date->diff( new DateTime( date('Y-m-d') ) ); 
				$age = $interval->format( '%Y' );
				$age = intval($age);
				
				if($age < 16)
					throw new Exception("Sua idade não atende à mínima requerida<br>");
					if($password1 != $password2)
						throw new Exception("As senhas digitadas não correspondem<br>");
						//echo "<script language='javascript' type='text/javascript'>alert('Os campos de senha nao se correspondem');window.location.href='../login.php';</script>";
				
				if(strlen($password1) < 6 || strlen($password1) > 12)
					throw new Exception("A senha deve ter no mínimo 6 digitos e no máximo 12<br>");
				
				if(strlen($zipcode) < 8 || !is_numeric($zipcode)) //|| !is_nan($zipcode)
					throw new Exception("Cep inválido<br>");
				
				if(strlen($street) > 32)
					throw new Exception("Rua inválida, máximo 32 digitos<br>");
				
				if(!is_numeric($number))
					throw new Exception("Número da rua inválido<br>");

				if(strlen($state) > 2)
					throw new Exception("Estado inválido<br>");
				
				if(!is_numeric($ddi) || strlen($ddi) != 2)
					throw new Exception("DDI inválido<br>");

				if(!is_numeric($ddd) || strlen($ddd) != 2)
					throw new Exception("DDD inválido<br>");
				
				if(!is_numeric($phone) || strlen($phone) != 9)
					throw new Exception("Número de telefone inválido<br>");
 
	
					$conn = connectionToMySQL();
					$conn->begin_transaction();
					$sql = "select name from tdclient where email = '$email' or cpf = '$cpf';";

					$result = $conn->query($sql);
					if(!$result){
						throw new Exception("Campos invalidos<br>", 1);
					}
					if($result->num_rows > 0){
						//echo "<script language='javascript' type='text/javascript'>alert('Ja existe cadastro com esse email/cpf');</script>";
						throw new Exception("Registro com esse email já existe<br>");
					}else{
						$sql = "INSERT INTO tdclient (name, gender, birthdayDate, email, maritalStatus, cpf)
						  VALUES (?, ?, ? , ?, ?, ?)";
						if(!$stmt = $conn->prepare($sql)){
							throw new Exception("Falha na operacao prepare: " . $conn->error);
						}

						if(!$stmt->bind_param("ssssss", $name, $gender, $birthdayDate, $email, $maritalStatus, $cpf)){
							throw new Exception("Falha na operacao bind_param: " . $stmt->error);
						}
						if (!$stmt->execute())
      						throw new Exception("Falha na operacao execute: " . $stmt->error);
      					$result = $conn->query("SELECT id from tdclient WHERE name = '$name';");
      					$row = $result->fetch_assoc();
      					$idClient = $row["id"];
      					$idClient = intval($idClient);
						$number = intval($number);
						
						$sql = "
						  INSERT INTO tduser (idUser, idclient, login, password)
						  VALUES (null,?,?,?)
						";

						if(!$stmt = $conn->prepare($sql)){
							throw new Exception("Falha na operacao prepare: " . $conn->error);
						}
						$passwordHash = password_hash($password1, PASSWORD_DEFAULT);
						if(!$stmt->bind_param("iss", $idClient ,$email, $passwordHash))
							throw new Exception("Falha na operacao bind_param: " . $stmt->error);

						if (! $stmt->execute())
      						throw new Exception("Falha na operacao execute: " . $stmt->error);

						$sql = "
						  INSERT INTO tdaddress (id_address,ad_street, ad_numberStreet, ad_district, 
						  						ad_city, ad_state, ad_zipcode, ad_complement, idclient)
						  						VALUES (null,?,?,?,?,?,?,?,?)
						";

						if(!$stmt = $conn->prepare($sql)){
							throw new Exception("Falha na operacao prepare: " . $conn->error);
						}

						if(!$stmt->bind_param("sisssssi",$street,$number, $district, $city, $state, $zipcode, $complement, $idClient))
							throw new Exception("Falha na operacao bind_param: " . $stmt->error);

						if (! $stmt->execute())
							  throw new Exception("Falha na operacao execute: " . $stmt->error);
							  
						$sql = "
							  INSERT INTO tdphone (ddi, ddd, phone, idclient)
							  VALUES (?,?,?,?)
						";

						if(!$stmt = $conn->prepare($sql)){
							throw new Exception("Falha na operacao prepare: " . $conn->error);
						}

						if(!$stmt->bind_param("iisi",$ddi,$ddd, $phone, $idClient))
							throw new Exception("Falha na operacao bind_param: " . $stmt->error);

						if (! $stmt->execute())
							  throw new Exception("Falha na operacao execute: " . $stmt->error);


						$conn->commit();
						echo "ok";
					}
				}
				catch (Exception $e){
					echo $e->getMessage();
					if(isset($conn))
						$conn->rollback();
					http_response_code(400);
				}finally{
					if(isset($stmt))
						$stmt->close();
					if(isset($conn))
						$conn->close();
						
			}
		
	}
?>