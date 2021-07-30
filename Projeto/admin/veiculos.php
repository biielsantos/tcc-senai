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
              <span class="table-title valign-wrapper"><i class="fas fa-car fa-5x left"></i>Veículos</span>
              <div class="actions">
                <a href="#modal1" id="btn-novo-veiculo" class="modal-trigger waves-effect btn-flat nopadding"><img style=" width: 26px; top: 50%;transform: translateY(-65%); " src="../images/add_car.svg">Cadastrar</a>
                <a class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i>Pesquisar</a>
                <a href="/tcc/admin/lixeira-veiculos.php" class="waves-effect btn-flat nopadding"><i class="material-icons">delete</i>Lixeira</a>
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
                $query = mysqli_query($conn, "SELECT * FROM veiculo WHERE status_veiculo = 'A'") or die(mysqli_connect_error());
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

  <!-- Modal-Veiculo -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="container">
        <h3 id="titulo-modal" class="center"></h3>
        <p class="center"><i class="material-icons medium">directions_car</i></p>
        <div class="row">
          <form id="form-veiculo" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <input class="validate" id="modelo" type="text" name="modelo">
                <label for="modelo">Modelo</label>
              </div>
              <div class="input-field col s6">
                <input id="placa" type="text"  name="placa" data-length="7" minlength="7" maxlength="7" autocomplete="off">
                <label for="placa">Placa</label>
                <span id="span-placa" class="helper-text"></span>
              </div>
            </div>
            <div class="input-field">
              <input class="validate" id="proprietario" type="text"  name="proprietario">
              <label for="proprietario">Proprietario</label>
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
                <input id="confirm" type="text" name="confirm">
                <label for="confirm">Confirmar</label>
              </div>
              <button id="submitDelete" class="disabled btn red darken-1 waves-effect center center-align" type="submit" name="submitDelete">
              Eu entendo as consequências, exclua este veículo
            </button>
            </div> 
          </form>
        </div>
  </div>
  
  <?php include ("../components/scripts.php")?>
  <script src="../scripts/dataTables.js"></script>
  <script src="../scripts/veiculos.js"></script>
</body>

</html>