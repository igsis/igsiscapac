<?php
    require_once 'funcoesConecta.php';
    // require "../funcoes/";

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: *');
	header('Content-Type: application/json');

	$conn = bancoPDO();

	if(isset($_GET['linguagem_id'])){
		$id = $_GET['linguagem_id'];

		$sql = "SELECT id, sublinguagem FROM oficina_sublinguagens WHERE idLinguagem = :linguagem order by sublinguagem";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':linguagem', $id);
		$stmt->execute();
		$res = $stmt->fetchAll();

		$sublinguagens =  json_encode($res);

		print_r($sublinguagens);

	}
