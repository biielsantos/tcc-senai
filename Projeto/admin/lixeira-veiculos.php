<?php
session_start();

if ($_SESSION["status"] != "ok") {
  header('location: ../index.php');
}

if ($_SESSION["tipo"] != "A") {
  header('location: ../index.php');
}

include("../config/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include "../components/head.php" ?>
  <link rel="stylesheet" href="../styles/dataTables.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
  <link rel="stylesheet" href="../styles/crud.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <title>Gerenciar veículos</title>
</head>

<body>
  <?php include "../components/navbar.php" ?>
  
  <!--Tabela Veiculos-->
    <div class="row">
        <div id="man" class="col s12">
          <div class="card material-table">
            <div class="table-header">
              <span class="table-title valign-wrapper"><i class="fas fa-car fa-5x left"></i>Lixeira - Veículos</span>
              <div class="actions">
                <a href="/tcc/admin/veiculos.php" class="waves-effect btn-flat nopadding"><i class="material-icons">arrow_back</i>Voltar</a>
                <a class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i>Pesquisar</a>
              </div>
            </div>
            <table id="tabela-veiculos" class="centered highlight display compact">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>MODELO</th>
                  <th>PLACA</th>
                  <th>AÇÃO</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM veiculo WHERE status_veiculo = 'I'") or die(mysqli_connect_error());
                while ($veiculo = mysqli_fetch_array($query)) {
                ?>
                  <tr>
                    <td><?php echo $veiculo['id_veiculo']; ?></td>
                    <td><?php echo $veiculo['modelo']; ?></td>
                    <td><?php echo $veiculo['placa']; ?></td>
                    <td></td>
                  </tr>
                <?php
                }
                mysqli_close($conn);
                ?>
              </tbody>
            </table>
        </div>
      </div>
              </div>

  
  <?php include ("../components/scripts.php")?>
  <script src="../scripts/dataTables.js"></script>
  <script src="../scripts/lixeira/veiculos.js"></script>
</body>

</html>