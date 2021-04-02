<?php
include("./conexao.php");

$modelo = $_POST['modelo'];
$placa = $_POST['placa'];
$proprietario = $_POST['proprietario'];
mysqli_query($conn, "INSERT INTO Veiculo (modelo, placa, proprietario) VALUES ('$modelo', '$placa', '$proprietario')");
echo "<script type='text/javascript'>
		alert('Funcionou');
		location.href='../admin/veiculos.php';
		</script>";

mysqli_close($conn);
?>