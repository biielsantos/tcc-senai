<?php
  include "./conexao.php";

  $id = $_POST['id'];
  $query = "SELECT * FROM departamento WHERE id_departamento = $id";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);

  mysqli_query($conn, "UPDATE departamento SET status_departamento = 'A' WHERE id_departamento = $id");

  print json_encode($data);
  mysqli_close($conn);
?>