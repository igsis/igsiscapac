<?php
	// Conex�o de Banco MySQLi 
	function bancoMysqli()
	{
		$servidor = 'localhost';
		$usuario = 'root';
		$senha = '';
		$banco = 'capac';
		$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
		mysqli_set_charset($con,"utf8");
		return $con;
	}
	// Conex�o de Banco com PDO
	function bancoPDO()
	{
		$host = 'localhost';
		$user = 'root';
		$pass = '';
		$db = 'capac';
		$charset = 'utf8';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset;";

		try { 
			$conn = new PDO($dsn, $user, $pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
			$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $conn;
		}
		catch(PDOException $e)
		{
			echo "Erro " . $e->getMessage();
		}
	}
	// Cria conexao ao banco de CEPs.
	function bancoMysqliCep()
	{
		$servidor = 'localhost';
		$usuario = 'root';
		$senha = '';
		$banco = 'cep';
		$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
		mysqli_set_charset($con,"utf8");
		return $con;
	}
?>
