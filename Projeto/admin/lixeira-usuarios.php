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
  <title>Usuários</title>
</head>

<body>
  <?php include "../components/navbar.php" ?>

    <!--Tabela Usuários -->
    <div class="row">
        <div id="man" class="col s12">
          <div class="card material-table">
            <div class="table-header">
              <span class="table-title valign-wrapper"><i class="fas fa-user-circle fa-5x left"></i>Lixeira - Usuários</span>
              <div class="actions">
                <a href="/tcc/admin/usuarios.php" class="waves-effect btn-flat nopadding"><i class="material-icons">arrow_back</i>Voltar</a>
                <a class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i>Pesquisar</a>
              </div>
            </div>
    <table id="tabela-usuarios" class="centered highlight display compact">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOME</th>
          <th>CPF</th>
          <th>TIPO</th>
          <th>DEPARTAMENTO</th>
          <th>TELEFONE</th>
          <th>AÇÃO</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM usuario JOIN departamento ON fk_id_departamento=id_departamento WHERE status_usuario = 'I'") or die(mysqli_connect_error());
        while ($usuario = mysqli_fetch_array($query)) {
        ?>
          <tr>
            <td><?php echo $usuario['id_usuario']; ?></td>
            <td><?php echo $usuario['nome']; ?></td>
            <td><?php echo $usuario['cpf']; ?></td>
            <td>
              <?php 
                if($usuario['tipo'] == "A"){
                  echo "ADMIN";
                }else{
                  echo "COMUM";
                }
              ?>
            </td>
            <td><?php echo $usuario['departamento']; ?></td>
            <td><?php echo $usuario['telefone']; ?></td>
            <td></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    </div>
    </div>
  </div>

  <?php include ("../components/scripts.php") ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="../scripts/dataTables.js"></script>
  <script src="../scripts/lixeira/usuarios.js"></script>
</body>
</html>
