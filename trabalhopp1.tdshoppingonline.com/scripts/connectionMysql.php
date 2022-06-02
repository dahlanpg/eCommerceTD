<?php
define("HOST", "localhost"); 
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "td");

function connectionToMySQL()
{
	$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
  $conn->set_charset('utf8');
	if ($conn->connect_error)
		throw new Exception('Falha na conexão com o MySQL: ' . $conn->connect_error);
	return $conn;   
}

function filtraEntrada($data) 
{
	$data = trim($data);               // remove espaços no inicio e no final da string
	$data = stripslashes($data);       // remove contra barras: "cobra d\'agua" vira "cobra d'agua"
	$data = htmlspecialchars($data);   // caracteres especiais do HTML (como < e >) são codificados

	return $data;
}
	
?>