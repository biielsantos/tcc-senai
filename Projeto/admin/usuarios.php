<?php
session_start();
include("../config/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <?php include "../components/head.php" ?>
  <link rel="stylesheet" href="../styles/usuarios.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <title>Usuários</title>
</head>

<body>
  <?php include "../components/navbar.php" ?>
  <div class="container">
    <p class="left user-icon"><i class="fas fa-user-circle fa-5x"></i></p>
    <h3 class="left">Usuários</h3>


    <!--Tabela Usuários -->
    <table id="tabela-usuarios" class="centered highlight">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOME</th>
          <th>CPF</th>
          <th>TIPO</th>
          <th>DEPARTAMENTO</th>
          <th>TELEFONE</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM usuario ORDER BY id_usuario DESC") or die(mysqli_connect_error());
        while ($usuario = mysqli_fetch_array($query)) {
        ?>
          <tr>
            <td><?php echo $usuario['id_usuario']; ?></td>
            <td><?php echo $usuario['nome']; ?></td>
            <td><?php echo $usuario['cpf']; ?></td>
            <td><?php echo $usuario['tipo']; ?></td>
            <td><?php echo $usuario['departamento']; ?></td>
            <td><?php echo $usuario['telefone']; ?></td>
          </tr>
        <?php
        }
        mysqli_close($conn);
        ?>
      </tbody>
    </table>
    <br><br>
    <a class="waves-effect waves-light btn modal-trigger right" href="#modal1">Novo Usuário
      <i class="material-icons right">add</i>
    </a>
  </div>
  </div>

  <!-- Modal-Cadastro -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="container">
        <h3 class="center">Cadastrar Usuário</h3>
        <p class="center"><i class="material-icons medium">account_circle</i></p>
        <div class="row">
          <form action="" method="POST" class="col s12">
            <div class="input-field">
              <label for="nome">Nome</label>
              <input type="text" name="nome" id="nome" autocomplete="off" />
            </div>
            <div class="input-field">
              <label for="cpf">CPF</label>
              <input type="number" name="cpf" id="cpf" autocomplete="off" />
            </div>
            <div class="input-field col s12">
              <select>
                <option value="" disabled selected>Choose your option</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
              </select>
              <div class="button-container">
                <a href="#!" class="modal-close btn waves-effect red darken-1">Cancelar
                  <i class="material-icons left">cancel</i>
                </a>
                <button class="btn waves-effect right" type="submit" name="submit">Confirmar
                  <i class="material-icons right">send</i>
                </button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include ("../components/scripts.php") ?>
  <script src="../scripts/usuarios.js"></script>
</body>
</html>
