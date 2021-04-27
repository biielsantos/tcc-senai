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
    <table id="tabela-usuarios" class="centered highlight display compact">
      <thead>
        <tr>
          <th >ID</th>
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
        $query = mysqli_query($conn, "SELECT * FROM usuario") or die(mysqli_connect_error());
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
        mysqli_close($conn);
        ?>
      </tbody>
    </table>
    </div>
  </div>
    
  <a id="btn-novo-usuario" class="#0277bd light-blue darken-3 btn-floating btn-large waves-effect waves-light btn modal-trigger" href="#modal1">
    <i class="material-icons right">add</i>
  </a>
  <!-- Modal-Cadastro -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="container">
        <h3 class="center">Usuário</h3>
        <p class="center"><i class="material-icons medium">account_circle</i></p>
        <div class="row">
          <form id="form-usuario" class="col s12">
            <div class="input-field">
              <input id="nome" type="text"  name="nome" required>
              <label for="nome">Nome</label>
            </div>
            <div class="input-field col-s12">
                <input id="departamento" type="text" name="departamento" required>
                <label for="departamento">Departamento</label>
            </div>
            <div class="row">
              <div class="input-field col l6 m6 s12">
                <select id="tipo-usuario" required>
                <option value="" disabled selected>Selecione</option>
                <option value="U">COMUM</option>
                <option value="A">ADMIN</option>
                </select>
                <label>Tipo de usuario</label>
              </div>
              <div class="input-field col l6 m6 s12">
                <input id="cpf" type="text" name="cpf" minlength="11" maxlength="11" autocomplete="off" required>
                <label class="active" for="cpf">CPF</label>
                <span id="span_cpf"class="helper-text"></span>
              </div>
              <div class="input-field col l6 m6 s12">
                <input id="telefone" type="text" name="telefone" data-length="11" minlength="11" maxlength="11" autocomplete="off" required>
                <label for="telefone">Telefone</label>
                <span id="span_telefone" class="helper-text"></span>
              </div>
              <div class="input-field col l6 m6 s12">
                <input id="senha" type="password"  name="senha" required>
                <label class="active" for="senha">Senha</label>
              </div>
            </div>
            <div class="button-container">
              <button type="button" class="modal-close btn waves-effect red darken-1">Cancelar
                <i class="material-icons left">cancel</i>
              </button>
              <button id="btn-salvar" class="btn waves-effect right" type="submit" >Salvar
                <i class="material-icons right">send</i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Confirmação Excluir-->
  <div id="modal2" class="modal">
    <div class="modal-content">
      <i class="modal-close material-icons right">close</i>
      <h4>Você tem certeza?</h4>
      <p id="confirm-delete"></p>
    </div>
    <div class="row">
      <form id="form-delete" class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input id="confirm" type="text" name="confirm">
            <label for="confirm">Confirmar</label>
          </div>
          <button id="submitDelete" class="disabled btn red darken-1 waves-effect center center-align" type="submit" name="submitDelete">
          Eu entendo as consequências, exclua este usuário
        </button>
        </div> 
      </form>
    </div>
  </div>

  <?php include ("../components/scripts.php") ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="../scripts/usuarios.js"></script>
</body>
</html>
