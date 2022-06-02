<?php
	session_start();
	session_destroy();
	echo "<script language='javascript' type='text/javascript'>alert('Deslogado com sucesso');window.location.href='../home.php';</script>";
?>