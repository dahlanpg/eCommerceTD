<?php
    echo "<span style='font-size: 11px;font-family: arial; margin-left: 40%;'>T&D - Thiago & Dahlan Store - Copyright 2019</span>
	<header>
		<ul>
			<li>
				<div id='logo'>
					<a href='home.php'><img id='logoImg' src='images/logo.png' /></a>
				</div>
			</li>
			<li id='item-search'>
				<form id='searchDiv' action='' method='GET' name='formSearchBar'>
					<input type='text' id='searchBar' name='searchBar' placeholder='Buscar...' />
					<button type='button' id='btn-search'><img src='images/magnifier.png' id='btnSearch' alt='Buscar' /></button>
				</form>
			</li>
			<li>";
				
				if (isset($_SESSION["name"])) {
					$name = explode(" ", $_SESSION["name"])[0];
					echo "<div id='loginBar'>
							<a href='myAccount.php'>
									<img src='images/cart/header/boss.png'>
									<span id='labelMyAccount' style='font-size: 2.3vh;'>Minha Conta</span>
							</a>
									<a href='scripts/logout.php'<span style = 'font-size: 1.6vh; margin-left: 42%;'><br>(Sair)</span>
							</a>
							</div>";
				} else {
					echo "<div id='loginBar'>
							<a href='login.php' style='text-decoration: none; color: black;'>
									<img src='images/login.png'>
									<span style='font-size: 2.3vh;'>Login</span>
							</a>
							</div>";
				}
				echo "
			</li>
			<li>
				<div id='cartBar'>
					<a href='cart.php' style='text-decoration: none; color: black;'>
						<img src='images/cart.png'>
						<span id='itensCart' style='background-color: red; border-radius: 10px;'>";
							
								if(isset($_COOKIE["cart"])){
									$cartIds = json_decode($_COOKIE["cart"]);
									if(is_array($cartIds))
										echo sizeof($cartIds);
									else
										echo "0";
								}else
									echo "0";
							
						echo "</span>
					</a>
				</div>
			</li>
			<li style='margin-left: -2%;'>";
				
					$qtd = 0;
					if(isset($_SESSION["id"])){
						try{
							require_once "scripts/connectionMysql.php";
							$conn = connectionToMySQL();
							$idClient = $_SESSION["id"];
							$sql = "SELECT count(*) as total from tdfavorites
									where iduser = $idClient;";
							$result = $conn->query($sql);
							$row = $result->fetch_assoc();
							$qtd = $row["total"];
							$qtd = intval($qtd);
						}catch(Exception $e){
							$qtd = 0;
						}finally{
							if($conn != null)
								$conn->close();
						}
				}
					echo "<div id='favoritesBar'>
					<a href='favorites.php?for=1' style='text-decoration: none; color: black;'>
						<img src='images/heart.png'>
						<span id='itensFavorites' style='background-color: red; border-radius: 10px;'>$qtd</span>
					</a>
				</div>
				
			</li>
		</ul>
    </header>";
    ?>