<?php

if (isset($_POST["cpf"]) && isset($_POST["senha"]) && isset($_POST["option"])) {
	include("./conexao.php");

	$cpf = mysqli_escape_string($conn, $_POST['cpf']);
	$senha = mysqli_escape_string($conn, base64_encode($_POST['senha']));
	$option = $_POST["option"];

	$query = mysqli_query($conn, "SELECT * FROM usuario WHERE cpf = '$cpf' AND senha = '$senha'") or die(mysqli_connect_error());
	
	switch ($option) {
		case "VERIFY":
			if (mysqli_num_rows($query) > 0) {
				$return = "ok";
			} else {
				$return = "invalid";
			}
			break;
		case "LOGIN":
			if (mysqli_num_rows($query) > 0) {
				session_start();

				$usuario = mysqli_fetch_array($query);

				$_SESSION['id'] = $usuario['id_usuario'];
				$_SESSION['nome'] = $usuario['nome'];
				$_SESSION['cpf'] = $usuario['cpf'];
				$_SESSION['telefone'] = $usuario['telefone'];
				$_SESSION["tipo"] = $usuario['tipo'];
				$_SESSION["status"] = "ok";
				
				header('Location: ../veiculos.php');
			}
			break;
	}

	print json_encode($return);
	mysqli_close($conn);
}
?>
