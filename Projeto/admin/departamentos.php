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
                <a href="#modal1" id="btn-novo-departamento" class="modal-trigger waves-effect btn-flat nopadding"><i class="material-icons">add_business</i>Cadastrar</a>
                <a class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i>Pesquisar</a>
                <a href="/tcc/admin/lixeira-departamentos.php" class="waves-effect btn-flat nopadding"><i class="material-icons">delete</i>Lixeira</a>
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
                $departamentos = mysqli_query($conn, "SELECT * FROM departamento WHERE status_departamento = 'A'") or die(mysqli_connect_error());
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

 <!-- Modal Confirmação excluir-->
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
                <input id="msg-confirm" type="text" name="confirm">
                <label for="msg-confirm">Confirmar</label>
              </div>
              <button id="submitDelete" class="btn red darken-1 waves-effect center center-align" type="submit" name="submitDelete" disabled="true">
              Excluir este departamento
            </button>
            </div> 
          </form>
        </div>
  </div>

   <!-- Modal-Veiculo -->
   <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="container">
        <h3 id="titulo-modal" class="center"></h3>
        <p class="center"><i class="material-icons medium">business</i></p>
        <div class="row">
        <form id="form-departamento" class="col s12">
              <div class="input-field col s12">
                <input class="validate" id="nome-departamento" type="text" name="nome-departamento">
                <label for="nome-departamento">Nome do Departamento</label>
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
 
    
  <?php include ("../components/scripts.php")?>
  <script src="../scripts/dataTables.js"></script>
  <script src="../scripts/departamentos.js"></script>
</body>
</html>