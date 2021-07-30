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
              <span class="table-title valign-wrapper"><i class="fas fa-user-circle fa-5x left"></i> Usuários</span>
              <div class="actions">
                <a href="#modal1" id="btn-novo-usuario" class="modal-trigger waves-effect btn-flat nopadding"><i class="material-icons">person_add</i>Cadastrar</a>
                <a class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i>Pesquisar</a>
                <a href="/tcc/admin/lixeira-usuarios.php" class="waves-effect btn-flat nopadding"><i class="material-icons">delete</i>Lixeira</a>
              </div>
            </div>
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
        $query = mysqli_query($conn, "SELECT * FROM usuario JOIN departamento ON fk_id_departamento=id_departamento WHERE status_usuario = 'A'") or die(mysqli_connect_error());
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

  <!-- Modal-Cadastro -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="container">
        <h3 id="titulo-modal" class="center"></h3>
        <p class="center"><i class="material-icons medium">account_circle</i></p>
        <div class="row">
          <form id="form-usuario" class="col s12">
            <div class="input-field">
              <input id="nome" type="text" name="nome" class="validate">
              <label for="nome">Nome</label>
            </div>
            <div class="input-field col-s12">
              <select id="departamento">
                <option value="" disabled selected>Selecione</option>
                <?php
                $query2 = mysqli_query($conn, "SELECT * FROM departamento") or die(mysqli_connect_error());
                while ($departamento = mysqli_fetch_array($query2)){
                echo "<option value=".$departamento['id_departamento'].">".$departamento['departamento']."</option>";
                }
                mysqli_close($conn);
                ?>
              </select>
              <label for="departamento">Departamento</label>
            </div>
            <div class="row">
              <div class="input-field col l6 m6 s12">
                <select id="tipo-usuario">
                <option value="" disabled selected>Selecione</option>
                  <option value="U">COMUM</option>
                  <option value="A">ADMIN</option>
                </select>
                <label>Tipo de usuario</label>
              </div>
              <div class="input-field col l6 m6 s12">
                <input id="cpf" type="text" name="cpf" minlength="11" maxlength="11" autocomplete="off">
                <label class="active" for="cpf">CPF</label>
                <span id="span-cpf"class="helper-text"></span>
              </div>
              <div class="input-field col l6 m6 s12">
                <input id="cnh" type="text" name="cnh" minlength="11" maxlength="11" autocomplete="off">
                <label class="active" for="cnh">CNH</label>
                <span id="span-cnh"class="helper-text"></span>
              </div>
              <div class="input-field col l6 m6 s12">
                <input id="validade_carteira" type="text" class="datepicker validate">
                <label class="active" for="validade_carteira">VALIDADE DA CARTEIRA</label>
                <span id="span-cnh"class="helper-text"></span>
              </div>
              <div class="input-field col l6 m6 s12">
                <input id="telefone" type="text" name="telefone" data-length="11" minlength="11" maxlength="11" autocomplete="off">
                <label for="telefone">Telefone</label>
                <span id="span-telefone" class="helper-text"></span>
              </div>
              <div class="input-field col l6 m6 s12">
                <input id="senha" type="password" name="senha" class="validate">
                <label class="active" for="senha">Senha</label>
              </div>
            </div>
            <div class="buttonContainer">
              <button type="button" class="modal-close btn waves-effect red darken-1">Cancelar
                <i class="material-icons left">cancel</i>
              </button>
              <button id="btn-salvar" class="btn waves-effect" type="submit" >
                <img class="hide" src="../images/loading.gif" style="width: 25px; top: 50%; transform: translate(0, -50%)">
                <span>Salvar</span>
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
      <i class="modal-close material-icons right tooltipped" data-position="bottom" data-tooltip="Fechar">close</i>
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
  <script src="../scripts/dataTables.js"></script>
  <script src="../scripts/usuarios.js"></script>
</body>
</html>
