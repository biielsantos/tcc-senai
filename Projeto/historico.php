<?php
session_start();

if ($_SESSION["status"] != "ok") {
  header('location: ./index.php');
}

include("./config/conexao.php");

// Verificar se o usuario é admin ou comum
if ($_SESSION["tipo"] == "A"){

  $sql = "SELECT nome, cidade, rua, estado, modelo, data_saida, data_retorno FROM usuario JOIN reserva ON usuario.id_usuario = reserva.fk_id_usuario INNER JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo";
  $result = mysqli_query($conn, $sql);
  $reservas = mysqli_fetch_all($result, MYSQLI_ASSOC);

} else if ($_SESSION["tipo"] == "U") {
  
  $id = $_SESSION["id"];

  $sql = "SELECT nome, cidade, rua, estado, modelo, data_saida, data_retorno FROM usuario JOIN reserva ON usuario.id_usuario = reserva.fk_id_usuario INNER JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo WHERE id_usuario = '$id'";
  $result = mysqli_query($conn, $sql);
  $reservas = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

mysqli_close($conn);

?>
<html lang="pt-br">
<!DOCTYPE html>
<head>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <?php include "./components/head.php"; ?>
  <link rel="stylesheet" href="./styles/navbar.css">
  <link rel="stylesheet" href="./styles/historico.css">
  <title>SRV | Histórico</title>
  
</head>
<body>
  <?php include "./components/navbar.php" ?>
  <div class="container">
    <header>
      <i class="material-icons" style="font-size: 70px;">watch_later</i>
      <h1 class="titulo">Histórico</h1>
    </header>
    <table id="historico">
      <thead>
        <tr>
          <th>Usuários</th>
          <th>Destino</th>
          <th>Veículos</th>
          <th>Data Saída</th>
          <th>Data Entrada</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($reservas as $reserva) { ?>
          <tr>
            <td><?php echo $reserva['nome']; ?></td>
            <td><?php echo $reserva['cidade']; ?></td>
            <td><?php echo $reserva['modelo']; ?></td>
            <td><?php echo $reserva['data_saida']; ?></td>
            <td><?php echo $reserva['data_retorno']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php include ("./components/scripts.php")?>
  <script src="./scripts/historico.js"></script>
</body>
</html>