<?php
	function db_connect()
	{
		$host = "localhost";
		$db_name = "fatec";
		$username = "root";
		$password = "";
		
		try
		{
			$PDO = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
			$PDO->exec("set names utf8");
		}
		catch( PDOException $e)
		{
			echo 'ERRO: ' . $e->getMessage();
		}
		
		return $PDO;
	}

	function ConverteData($data)
	{
    	if (strstr($data, "/"))//verifica se tem a barra
     	{
			$d = explode ("/", $data);//tira a barra
			$rstData = "$d[2]-$d[1]-$d[0]";
			return $rstData;
     	} 
	 	elseif(strstr($data, "-"))
	 	{
			$d = explode ("-", $data);
			$rstData = "$d[2]/$d[1]/$d[0]"; 
			return $rstData;
     	}
		else
	 	{ 
			return "Data inválida";
     	}
    }
?>