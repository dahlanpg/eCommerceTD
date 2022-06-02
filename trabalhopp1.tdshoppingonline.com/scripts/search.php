    <?php
        require "connectionMysql.php";
        require "products.php";
        $conn = connectionToMySQL();
        if(!isset($_GET["keywords"])){
            header("location: home.php");
            die();
        }
        $search = $_GET["keywords"];
        $SQL = "select * from tdproducts where category like '%$search%' and quantity > 0 or offerTitle like '%$search%' and quantity > 0 or manufacturer like '%$search%' and quantity > 0;";

        $arrayProducts = getProducts($conn, $SQL);
		$cont = sizeof($arrayProducts);
		if($search != ""){
			if($cont>1){
				echo "<div class='results'>
							<p>$cont resultados para '$search'</p>
						</div>";
				}
			else{
				echo "<div class='results'>
						<p>$cont resultado para '$search'</p>
					</div>";
			}
		}else{
			echo "<div class='results'>
						<p>Mostrando todos os produtos</p>
					</div>";
		}
        echo "<br>";
        echo '<div class="wrapper">';
		foreach ($arrayProducts as $product) {
			$belongsToTheCart = false; //reset
			if(isset($_COOKIE["cart"])){
				$arrayIds = json_decode($_COOKIE["cart"]);
				if(in_array($product->id, $arrayIds)) 
					$belongsToTheCart = true;
			}
			if($belongsToTheCart == false){
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
			}
		}
		echo '</div>';
    ?>