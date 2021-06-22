<?php
include ("conexao.php");

if(isset($_POST['nome']) && isset($_POST['tipo']) && isset($_POST['cpf']) && isset($_POST['departamento']) && isset($_POST['telefone']) && isset($_POST['senha'])){
	$nome = $_POST['nome'];
	$tipo = $_POST['tipo'];
	$cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $departamento = $_POST['departamento'];
	$senha = base64_encode($_POST['senha']);
	$cnh = $_POST['cnh'];
	$validade_cnh = $_POST['validade'];
}

if(isset($_POST['id'])){
	$id = $_POST['id'];
}

$option = $_POST['option'];

switch ($option) {
	case 1:
		$query = "INSERT INTO usuario (nome, cpf, tipo, telefone, senha, cnh, validade_cnh, status_usuario, fk_id_departamento) VALUES ('$nome', '$cpf', '$tipo', '$telefone', '$senha', '$cnh', '$validade_cnh', 'A', $departamento)";
		mysqli_query($conn, $query);

		$query = "SELECT * FROM usuario JOIN departamento ON fk_id_departamento=id_departamento ORDER BY id_usuario DESC LIMIT 1";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
	case 2:
		$query = "UPDATE usuario SET nome='$nome', cpf='$cpf', fk_id_departamento=$departamento, tipo='$tipo', telefone='$telefone',senha='$senha', cnh='$cnh', validade_cnh='$validade_cnh' WHERE id_usuario = $id";
		mysqli_query($conn, $query);

		$query = "SELECT * FROM usuario JOIN departamento ON fk_id_departamento=id_departamento WHERE id_usuario = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
	case 3:
		$query = "SELECT * FROM usuario WHERE id_usuario = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);

		mysqli_query($conn, "UPDATE usuario SET status_usuario = 'I' WHERE id_usuario = $id");
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