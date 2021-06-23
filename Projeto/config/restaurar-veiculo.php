<?php
  include "./conexao.php";

  $id = $_POST['id'];
  $query = "SELECT * FROM veiculo WHERE id_veiculo = $id";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);

  mysqli_query($conn, "UPDATE veiculo SET status_veiculo = 'A' WHERE id_veiculo = $id");

  print json_encode($data);
  mysqli_close($conn);
?>