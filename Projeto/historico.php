<?php
session_start();

if ($_SESSION["status"] != "ok") {
  header('location: ./index.php');
}

include("./config/conexao.php");

// Verificar se o usuario é admin ou comum
if ($_SESSION["tipo"] == "A"){

  $sql = "SELECT nome, destino, condutor, motivo, departamento, modelo, data_saida, data_retorno FROM usuario JOIN reserva ON usuario.id_usuario = reserva.fk_id_usuario JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo JOIN departamento ON usuario.fk_id_departamento = departamento.id_departamento";
  $result = mysqli_query($conn, $sql);
  $reservas = mysqli_fetch_all($result, MYSQLI_ASSOC);

} else if ($_SESSION["tipo"] == "U") {
  
  $id = $_SESSION["id"];

  $sql = "SELECT nome, destino, condutor, motivo, departamento, modelo, data_saida, data_retorno FROM usuario JOIN reserva ON usuario.id_usuario = reserva.fk_id_usuario INNER JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo JOIN departamento ON usuario.fk_id_departamento = departamento.id_departamento WHERE id_usuario = '$id'";
  $result = mysqli_query($conn, $sql);
  $reservas = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

mysqli_close($conn);

?>
<html lang="pt-br">
<!DOCTYPE html>
<head>
  <link rel="stylesheet" href="./styles/dataTables.css">
  <?php include "./components/head.php"; ?>
  <link rel="stylesheet" href="./styles/navbar.css">
  <link rel="stylesheet" href="./styles/historico.css">
  <title>Histórico</title>
</head>
<body>
  <?php include "./components/navbar.php" ?>
  <div id="modal1" class="modal">

    <div class="modal-content">
      <h4>Detalhes da Reserva</h4>
      <div id="details"></div>
    </div>
  </div>

    <div class="row">
        <div id="man" class="col s12">
          <div class="card material-table">
            <div class="table-header">
              <span class="table-title valign-wrapper"><i class="material-icons left">watch_later</i>Histórico</span>
              <div class="actions">
                <a class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
              </div>
            </div>
            <table id="historico">
              <thead>
                <tr>
                  <th>Usuário</th>
                  <th>Condutor</th>
                  <th>Veículo</th>
                  <th>Destino</th>
                  <th>Data Saída</th>
                  <th>Data Retorno</th>
                  <th class="center">Detalhes</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($reservas as $reserva) { ?>
                  <tr>
                    <td><?php echo $reserva['nome']; ?></td>
                    <td><?php echo $reserva['condutor']; ?></td>
                    <td><?php echo $reserva['modelo']; ?></td>
                    <td><?php echo $reserva['destino']; ?></td>
                    <td><?php echo $reserva['data_saida']; ?></td>
                    <td><?php echo $reserva['data_retorno']; ?></td>
                    <td><button class="btn-details btn btn-flat waves-effect waves-purple center modal-trigger" href="#modal1" ><i class="material-icons">subject</i></button></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>

  <?php include ("./components/scripts.php")?>
  <script src="./scripts/dataTables.js"></script>
  <script src="./scripts/historico.js"></script>
</body>
</html>