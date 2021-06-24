<?php
session_start();

if ($_SESSION["status"] != "ok") {
  header('location: ../index.php');
}

include("conexao.php");

if(isset($_POST['modelo']) && isset($_POST['placa']) && isset($_POST['proprietario'])){
	$modelo = $_POST['modelo'];
	$placa = $_POST['placa'];
	$proprietario = $_POST['proprietario'];
}

if(isset($_POST['id'])){
	$id = $_POST['id'];
}

$option = $_POST['option'];

switch ($option) {
	case 1:
		$query = "INSERT INTO veiculo (modelo, placa, proprietario, status_veiculo) VALUES ('$modelo', '$placa', '$proprietario', 'A')";
		mysqli_query($conn, $query);

		$query = "SELECT * FROM veiculo ORDER BY id_veiculo DESC LIMIT 1";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
	case 2:
		$query = "UPDATE veiculo SET modelo='$modelo', placa='$placa', proprietario='$proprietario' WHERE id_veiculo = $id";
		mysqli_query($conn, $query);

		$query = "SELECT * FROM veiculo WHERE id_veiculo = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
	case 3:
		$query = "SELECT * FROM veiculo WHERE id_veiculo = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);

		mysqli_query($conn, "UPDATE veiculo SET status_veiculo = 'I' WHERE id_veiculo = $id");
		break;
	case 4:
		$query = "SELECT * FROM veiculo WHERE id_veiculo = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
}

print json_encode($data);


mysqli_close($conn);
?>