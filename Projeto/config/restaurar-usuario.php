<?php
  include "./conexao.php";

  $id = $_POST['id'];
  $query = "SELECT * FROM usuario WHERE id_usuario = $id";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);

  mysqli_query($conn, "UPDATE usuario SET status_usuario = 'A' WHERE id_usuario = $id");

  print json_encode($data);
  mysqli_close($conn);
?>