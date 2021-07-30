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
    <title>SRV | Departamentos</title>
</head>
<body>
    <?php include "../components/navbar.php" ?>

    <!--Tabela Departamentos-->
    <div class="row">
        <div id="man" class="col s12">
          <div class="card material-table">
            <div class="table-header">
              <span class="table-title valign-wrapper"><i class="material-icons fa-5x left">store</i>Departamentos</span>
              <div class="actions">
                <a href="/tcc/admin/departamentos.php" class="waves-effect btn-flat nopadding"><i class="material-icons">arrow_back</i>Voltar</a>
                <a class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i>Pesquisar</a>
              </div>
            </div>
            <table id="tabela-departamentos" class="centered highlight display compact">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>DEPARTAMENTO</th>
                  <th>AÇÃO</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $departamentos = mysqli_query($conn, "SELECT * FROM departamento WHERE status_departamento = 'I'") or die(mysqli_connect_error());
                while ($departamento = mysqli_fetch_array($departamentos)) {
                ?>
                  <tr>
                    <td><?php echo $departamento['id_departamento']; ?></td>
                    <td><?php echo $departamento['departamento']; ?></td>
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
    </div>
 
    
  <?php include ("../components/scripts.php")?>
  <script src="../scripts/dataTables.js"></script>
  <script src="../scripts/lixeira/departamentos.js"></script>
</body>
</html>