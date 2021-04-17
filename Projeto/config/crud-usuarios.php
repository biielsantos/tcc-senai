<?php
include("conexao.php");

if(isset($_POST['nome']) && isset($_POST['tipo']) && isset($_POST['cpf']) && isset($_POST['departamento']) && isset($_POST['telefone']) && isset($_POST['senha'])){
	$nome = $_POST['nome'];
	$tipo = $_POST['tipo'];
	$cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $departamento = $_POST['departamento'];
	$senha = $_POST['senha'];
}

if(isset($_POST['id'])){
	$id = $_POST['id'];
}

$option = $_POST['option'];

switch ($option) {
	case 1:
		$query = "INSERT INTO usuario (nome, cpf, departamento, tipo, telefone, senha) VALUES ('$nome', '$cpf', '$departamento', '$tipo', '$telefone', '$senha')";
		mysqli_query($conn, $query);

		$query = "SELECT * FROM usuario ORDER BY id_usuario DESC LIMIT 1";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
	case 2:
		$query = "UPDATE usuario SET nome='$nome', cpf='$cpf', departamento='$departamento', tipo='$tipo', telefone='$telefone',senha='$senha' WHERE id_usuario = $id";
		mysqli_query($conn, $query);

		$query = "SELECT * FROM usuario WHERE id_usuario = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
	case 3:
		$query = "SELECT * FROM usuario WHERE id_usuario = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);

		mysqli_query($conn, "DELETE FROM usuario WHERE id_usuario = $id");
		break;
	case 4:
		$query = "SELECT * FROM usuario WHERE id_usuario = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
}

print json_encode($data);


mysqli_close($conn);
?>