<?php

include ("conexao.php");

$id = $_POST['id'];

$query = "SELECT * FROM veiculo WHERE id_veiculo = $id";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_array($result);

print json_encode($data)


?>