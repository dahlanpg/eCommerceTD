<?php
ini_set('default_charset', 'UTF-8');
	class TDPRODUCTS
	{
		public $id;
		public $offerTitle;
		public $name;
		public $category;
		public $manufacturer;
        public $oldprice;
		public $price;
		public $quantity;
        public $description;
		public $image1;
		public $image2;
		public $attributes;
	}

	class product{
		public static $product;
		static function setProduct($TDproduct){
			self::$product = $TDproduct;
		}
	}

	function getProducts($conn, $sql)
	{
		$arrayProducts = [];
		
		$result = $conn->query($sql);
		if (! $result)
			throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $conn->error);

		if ($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc())
			{
				$TDPRODUCTS = new TDPRODUCTS();

				$TDPRODUCTS->id                = $row["idproduct"];
				$TDPRODUCTS->offerTitle        = $row["offertitle"];
				$TDPRODUCTS->name              = $row["name"];
				$TDPRODUCTS->category          = $row["category"];
				$TDPRODUCTS->manufacturer      = $row["manufacturer"];
                $TDPRODUCTS->oldprice          = $row["oldprice"];
				$TDPRODUCTS->price             = $row["price"];
                $TDPRODUCTS->quantity          = $row["quantity"];
                $TDPRODUCTS->description       = $row["description"];
				$TDPRODUCTS->image1            = $row["image1"];
				$TDPRODUCTS->image2            = $row["image2"];
				$TDPRODUCTS->attributes        = $row["attributes"];
                
				$arrayProducts[] = $TDPRODUCTS;
			}
		}
		return $arrayProducts;
	}

	function getProductById($conn, $id){
		$sql = "select * from tdproducts where idproduct = '$id';";
		$result = $conn->query($sql);
		if(!$result){
			throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $conn->error);
		}
		if($result->num_rows == 1){
				$row = $result->fetch_assoc();
				$TDPRODUCTS = new TDPRODUCTS();

				$TDPRODUCTS->id                = $row["idproduct"];
				$TDPRODUCTS->offerTitle        = $row["offertitle"];
				$TDPRODUCTS->name              = $row["name"];
				$TDPRODUCTS->category          = $row["category"];
				$TDPRODUCTS->manufacturer      = $row["manufacturer"];
				$TDPRODUCTS->price             = $row["price"];
				$TDPRODUCTS->oldprice          = $row["oldprice"];
                $TDPRODUCTS->quantity          = $row["quantity"];
				$TDPRODUCTS->description       = $row["description"];
				$TDPRODUCTS->image1            = $row["image1"];
				$TDPRODUCTS->image2            = $row["image2"];
				$TDPRODUCTS->attributes        = $row["attributes"];
				return $TDPRODUCTS;
		}
	}
?>