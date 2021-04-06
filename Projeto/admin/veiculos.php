<?php
include("../config/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <?php include "../components/head.php" ?>
  <link rel="stylesheet" href="../styles/veiculos.css">
  <title>SRV | Gerenciar veículos</title>
</head>

<body>
  <div class="container">
    <p class="left car-icon"><i class="fas fa-car fa-5x"></i></p>
    <h3 class="left">Veículos</h3>

    <!--Tabela Veiculos-->
    <table id="tabela-veiculos" class="centered highlight">
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
        $query = mysqli_query($conn, "SELECT * FROM veiculo") or die(mysqli_connect_error());
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
    <br><br>
    <a id="btn-novo-veiculo" class="#0277bd light-blue darken-3 waves-effect waves-light btn modal-trigger right" href="#modal1">Novo Veículo
      <i class="material-icons right">add</i>
    </a>
  </div>

  <!-- Modal-Veiculo -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="container">
        <h3 class="center">Veículo</h3>
        <p class="center"><i class="material-icons medium">directions_car</i></p>
        <div class="row">
          <form id="form-veiculo" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <input id="modelo" type="text" name="modelo" required>
                <label for="modelo">Modelo</label>
              </div>
              <div class="input-field col s6">
                <input id="placa" type="text"  name="placa" data-length="7" minlength="7" maxlength="7" autocomplete="off" required>
                <label for="placa">Placa</label>
                <span id="validate" class="helper-text" data-success="Sucesso"></span>
              </div>
            </div>
            <div class="input-field">
              <input id="proprietario" type="text"  name="proprietario" required>
              <label for="proprietario">Proprietario</label>
            </div>
            <div class="button-container">
              <button type="button" class="modal-close btn waves-effect red darken-1">Cancelar
                <i class="material-icons left">cancel</i>
              </a>
              <button class="btn waves-effect right" type="submit" name="submit">Salvar
                <i class="material-icons right">send</i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <?php include ("../components/scripts.php")?>
  <script src="../scripts/veiculos.js"></script>
</body>

</html>