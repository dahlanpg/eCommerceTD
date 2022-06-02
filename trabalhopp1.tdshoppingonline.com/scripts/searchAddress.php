<?php

require_once "connectionMysql.php";

class Address 
{
	public $publicArea;
	public $district;
	public $city;
}

try
{
	$conn = connectionToMySQL();

	$zipcode = "";
	if (isset($_GET["zipcode"]))
		$zipcode = $_GET["zipcode"];

	$SQL = "
		SELECT ad_street, ad_district, ad_city
		FROM tdaddress
		WHERE ad_zipcode = '$zipcode';
	";
	
	if (! $result = $conn->query($SQL))
		throw new Exception('Ocorreu uma falha ao buscar o endereco: ' . $conn->error);
	
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();

		$address = new Address();

		$address->publicArea    = $row["ad_street"];
		$address->district      = $row["ad_district"];
        $address->city          = $row["ad_city"];	
        
		if (! $jsonStr = json_encode($address))
			throw new Exzipcodetion("Falha na funcao json_encode do PHP");
		
		echo $jsonStr;
	} 
}
catch (Exzipcodetion $e)
{
	echo $e->getMessage();
}

if ($conn != null)
	$conn->close();

?>