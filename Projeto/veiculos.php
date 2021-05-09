<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php include "./components/head.php" ?>
  <link rel="stylesheet" href="./styles/navbar.css">
  <link rel='stylesheet' href='./lib/main.min.css' />
  <link rel="stylesheet" href="./styles/consultar.css" />

  <title>SRV | Veículos</title>

  <?php include "./config/setup-calendario-reservas.php" ?>
</head>
<body>
  <?php include "./components/navbar.php" ?>
  <div class="container">
    <h2>Reservas de veículos</h2>
    <div id='calendar'></div>
    <form id="form-reserva" class="reserva">
      <div class="date-inputs">
        <div class="row">
          <div class="input-field col s6">
            <input id="dataSaida" type="date" class="validate" required>
            <label for="dataSaida">Data saída</label>
          </div>
          <div class="input-field col s6">
            <input id="dataRetorno" type="date" class="validate" required>
            <label for="dataRetorno">Data retorno</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="horarioSaida" type="time" class="validate" required>
            <label for="horarioSaida">Horário Saída</label>
          </div>
          <div class="input-field col s6">
            <input id="horarioRetorno" type="time" class="validate" required>
            <label for="horarioRetorno">Horário Retorno</label>
          </div>
        </div>
      </div>
      <div class="selecionar-veiculo">
        <div class="input-field">
          <select id="veiculo" required>
            <option disabled selected>Selecione um veículo</option>
            <?php
              include "./config/conexao.php";
              $sql = "SELECT id_veiculo, modelo FROM veiculo";
              $res = mysqli_query($conn, $sql);
              $veiculos = mysqli_fetch_all($res, MYSQLI_ASSOC);
        
              mysqli_free_result($res);
              mysqli_close($conn);
            ?>

            <?php foreach ($veiculos as $veiculo) { ?>
              <option value="<?php echo $veiculo["id_veiculo"] ?>"><?php echo $veiculo["modelo"] ?></option>
            <?php } ?>

          </select>
          <label>Veículo</label>
        </div>
        <a class="btn waves-effect waves-light" href="#modal-reserva" id="finalizar-reserva">Finalizar reserva
          <i class="material-icons left">done</i>
        </a>
      </div>

      <!-- Modal -->
      <div id="modal-reserva" class="modal">
        <div class="modal-content">
          <div class="container">
            <header>
              <h4>Finalizar reserva</h4>
              <i class="material-icons">directions_car</i>
            </header>
            <div class="row">
              <div class="col s12">
                <div class="input-field">
                  <input id="destino" type="text" name="destino" required>
                  <label for="destino">Destino</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s6">
                <div class="input-field">
                  <input id="condutor" type="text" name="condutor" required>
                  <label for="condutor">Condutor</label>
                </div>
              </div>
              <div class="col s6">
                <div class="input-field">
                  <input type="text" value="<?php echo $_SESSION["nome"]; ?>" name="responsavel" required disabled>
                  <input type="hidden" id="responsavel" value="<?php echo $_SESSION["id"]; ?>">
                  <label for="responsavel">Responsável</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12">
                <div class="input-field">
                  <select id="departamento" required>
                    <option disabled selected>Selecione um departamento</option>
                    <?php
                      include "./config/conexao.php";
                      $sql = "SELECT DISTINCT departamento FROM usuario";
                      $res = mysqli_query($conn, $sql);
                      $departamentos = mysqli_fetch_all($res, MYSQLI_ASSOC);

                      mysqli_close($conn);
                    ?>
                    <?php foreach($departamentos as $departamento) { ?>
                      <option value="<?php echo $departamento["departamento"]; ?>"><?php echo $departamento["departamento"]; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12">
                <div class="input-field">
                  <input type="text" name="motivo" id="motivo" required>
                  <label for="motivo">Motivo da reserva</label>
                </div>
              </div>
            </div>
            <div class="buttons">
              <a class="modal-close btn waves-effect red darken-1">
                Cancelar<i class="material-icons left">cancel</i>
              </a>
              <button type="submit" id="btn-confirmar" class="waves-effect waves-light btn right">
                Confirmar<i class="material-icons right">send</i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
  <script src='./lib/main.min.js'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="./scripts/consultar.js"></script>
</body>
</html>