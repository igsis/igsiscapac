<?php
	// Conexão de Banco MySQLi 
	// 
	function bancoMysqli()
	{
		$servidor = 'localhost:3307';
		$usuario = 'root';
		$senha = '';
		$banco = 'capac';
		$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
		mysqli_set_charset($con,"utf8");
		return $con;
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
