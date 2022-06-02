<?php
	class Client
	{
		public $id;
		public $name;
		public $idClient;
		public $birthdayDate;
		public $maritalStatus;
		public $cpf;
		public $gender;
		public $password;
		public $login;
		public $ddi;
		public $ddd;
		public $phone;
		public $street;
		public $numberStreet;
		public $zipcode;
		public $state;
		public $city;
		public $district;	
		public $avatar;
		public $complement;
	}

	function getClients($conn)
	{
		$arrayClients = [];

		$sql = "SELECT *
		FROM tdclient as c, tdaddress as a,tdphone as p
		WHERE a.idclient = c.id and p.idclient = c.id;";

		$result = $conn->query($sql);
		if (! $result)
			throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $conn->error);

		if ($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc())
			{
				$client = new Client();

				$client->id            = $row["id"];
				$client->name          = $row["name"];
				$client->email         = $row["email"];
				$client->birthdayDate  = $row["birthdaydate"];
				$client->maritalStatus = $row["maritalstatus"];
				$client->cpf           = $row["cpf"];
				$client->gender        = $row["gender"];
				$client->ddi           = $row["ddi"];
				$client->ddd           = $row["ddd"];
				$client->phone         = $row["phone"];
				$client->street        = $row["ad_street"];
				$client->numberStreet  = $row["ad_numberstreet"];
				$client->zipcode       = $row["ad_zipcode"];
				$client->state         = $row["ad_state"];
				$client->city          = $row["ad_city"];
				$client->district      = $row["ad_district"];
				$client->avatar        = $row["avatar"];
				$client->complement    = $row["ad_complement"];

				$arrayClients[] = $client;
			}
		}
		return $arrayClients;
	}

	function getClient($conn, $idClient){
		$sql = "SELECT *
		FROM tdclient as c, tdaddress as a,tdphone as p
		WHERE c.email = '$idClient' and a.idclient = c.id and p.idclient = c.id;";
		$result = $conn->query($sql);

		if(!$result){
			throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $conn->error);
		}
		else{
				$row = $result->fetch_assoc();
				$client = new Client();

				$client->id            = $row["id"];
				$client->name          = $row["name"];
				$client->email         = $row["email"];
				$client->birthdayDate  = $row["birthdaydate"];
				$client->maritalStatus = $row["maritalstatus"];
				$client->cpf           = $row["cpf"];
				$client->gender        = $row["gender"];
				$client->ddi           = $row["ddi"];
				$client->ddd           = $row["ddd"];
				$client->phone         = $row["phone"];
				$client->street        = $row["ad_street"];
				$client->numberStreet  = $row["ad_numberstreet"];
				$client->zipcode       = $row["ad_zipcode"];
				$client->state         = $row["ad_state"];
				$client->city          = $row["ad_city"];
				$client->district      = $row["ad_district"];
				$client->avatar        = $row["avatar"];
				$client->complement    = $row["ad_complement"];
		
				return $client;
		}
	}

	function getClientById($conn, $idClient){
		$sql = "SELECT *
		FROM tdclient as c, tdaddress as a,tdphone as p
		WHERE c.id = '$idClient' and a.idclient = c.id and p.idclient = c.id;";
		$result = $conn->query($sql);

		if(!$result){
			throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $conn->error);
		}
		else{
				$row = $result->fetch_assoc();
				$client = new Client();

				$client->id            = $row["id"];
				$client->name          = $row["name"];
				$client->email         = $row["email"];
				$client->birthdayDate  = $row["birthdaydate"];
				$client->maritalStatus = $row["maritalstatus"];
				$client->cpf           = $row["cpf"];
				$client->gender        = $row["gender"];
				$client->ddi           = $row["ddi"];
				$client->ddd           = $row["ddd"];
				$client->phone         = $row["phone"];
				$client->street        = $row["ad_street"];
				$client->numberStreet  = $row["ad_numberstreet"];
				$client->zipcode       = $row["ad_zipcode"];
				$client->state         = $row["ad_state"];
				$client->city          = $row["ad_city"];
				$client->district      = $row["ad_district"];
				$client->avatar        = $row["avatar"];
				$client->complement    = $row["ad_complement"];
		
				return $client;
		}
	}


?>