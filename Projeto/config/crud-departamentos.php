<?php
include ("conexao.php");

if(isset($_POST['departamento'])){
	$departamento = $_POST['departamento'];
}

if(isset($_POST['id']) && isset($_POST['option'])){
	$id = $_POST['id'];
    $option = $_POST['option'];
}else{
	header('Location: ../veiculos.php');
}

switch ($option) {
	case 1:
		$query = "INSERT INTO departamento (departamento, status_departamento) VALUES ('$departamento', 'A')";
		mysqli_query($conn, $query);

		$query = "SELECT * FROM departamento ORDER BY id_departamento DESC LIMIT 1";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
	case 2:
		$query = "UPDATE departamento SET departamento='$departamento' WHERE id_departamento = $id";
		mysqli_query($conn, $query);

		$query = "SELECT * FROM departamento WHERE id_departamento = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
	case 3:
		$query = "SELECT * FROM departamento WHERE id_departamento = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);

		mysqli_query($conn, "UPDATE departamento SET status_departamento = 'I' WHERE id_departamento = $id");
		break;
	case 4:
		$query = "SELECT * FROM departamento WHERE id_departamento = $id";
		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
		break;
}

print json_encode($data);

mysqli_close($conn);
?>