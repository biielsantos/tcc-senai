<?php
  session_start();

  if ($_SESSION["status"] != "ok") {
    header('location: ./index.php');
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php include "./components/head.php" ?>
  <link rel="stylesheet" href="./styles/navbar.css">
  <link rel="stylesheet" href="./styles/consultar.css" />
  <link rel='stylesheet' href='./lib/main.min.css' />
  <script src='./lib/main.min.js'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  <title>SRV | Veículos</title>

  <?php include "./config/setup-calendario-reservas.php" ?>

  <script>
    var session = <?php echo json_encode($_SESSION); ?>;
  </script>
</head>
<body>
  <?php include "./components/navbar.php" ?>
  <div class="container">
    <div class="title">
      <h2>Reservas de veículos</h2>
      <div class="legenda">
        <span class="dot d-blue">Dentro do estabelecimento</span>
        <span class="dot d-red">Fora do estabelecimento</span>
      </div>
    </div>
    <main>
      <div id='calendar'></div>
      <form id="form-reserva" class="reserva">
        <div class="date-inputs">
          <div class="row">
            <div class="input-field col s6">
              <input id="dataSaida" type="text" class="datepicker validate" autocomplete="off" required>
              <label for="dataSaida">Data saída</label>
            </div>
            <div class="input-field col s6">
              <input id="dataRetorno" type="text" class="datepicker validate" autocomplete="off" required>
              <label for="dataRetorno">Data retorno</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <input id="horarioSaida" type="text" class="timepicker validate" autocomplete="off" required>
              <label for="horarioSaida">Horário Saída</label>
            </div>
            <div class="input-field col s6">
              <input id="horarioRetorno" type="text" class="timepicker validate" autocomplete="off" required>
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
        <!-- Modal reserva -->
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
                    <input id="condutor" type="text" name="condutor">
                    <label for="condutor">Condutor</label>
                    <span class="helper-text">Deixe em branco para reservar em seu nome</span>
                  </div>
                </div>
                <div class="col s6">
                  <div class="input-field">
                    <input type="text" id="nome-responsavel" value="<?php echo $_SESSION["nome"]; ?>" name="responsavel" required disabled>
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
                        $sql = "SELECT * FROM departamento";
                        $res = mysqli_query($conn, $sql);
                        $departamentos = mysqli_fetch_all($res, MYSQLI_ASSOC);
                        mysqli_close($conn);
                      ?>
                      <?php foreach($departamentos as $departamento) { ?>
                        <option value="<?php echo $departamento["id_departamento"]; ?>"><?php echo $departamento["departamento"]; ?></option>
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
                <a id="btn-cancelar" class="modal-close btn waves-effect red darken-2">
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
    </main>
  </div>

  <!-- Modal detalhes reserva -->
  <div id="modal-detalhes" class="modal">
    <div class="modal-content">
      <div class="container">
        <h4>Detalhes da reserva</h4>
        <div class="row">
          <div class="col s6">
            <p><strong>Veículo: <br/></strong><span id="det-veiculo"></span></p>
            <p><strong>Departamento: <br/></strong><span id="det-departamento"></span></p>
            <p><strong>Condutor: <br/></strong><span id="det-condutor"></span> (Reservado por <span id="det-usuario"></span>)</p>
          </div>
          <div class="col s6">
            <p><strong>Destino: <br/></strong><span id="det-destino"></span></p>
            <p><strong>Motivo: <br/></strong><span id="det-motivo"></span></p>
          </div>
        </div>
        <div class="row">
          <div class="col s6">
            <p><strong>Data saída: <br/></strong><span id="det-data-saida"></span></p>
            <p><strong>Data Retorno: <br/></strong><span id="det-data-retorno"></span></p>
          </div>
          <div class="col s6">
            <p><strong>Data saída real: <br/></strong><span id="det-data-saida-real"></span></p>
            <p><strong>Data retorno real: <br/></strong><span id="det-data-retorno-real"></span></p>
          </div>
        </div>
        <div class="det-buttons">
          <input type="hidden" id="det-id" value="" />
          <div class="det-retirada">
            <div class="input-field">
              <input type="number" name="km" id="km" required>
              <label for="km">Km atual</label>
            </div>
            <button id="det-btn-retirada" class="btn waves-effect waves-light"><i class='material-icons right'>check</i>Retirar Veículo</button>
          </div>
          <div class="det-buttons-actions">
            <button id="det-editar" class="btn-floating  orange darken-1 waves-effect waves-light"><i class='material-icons left'>edit</i>EDITAR</button>
            <button id="det-excluir" class="btn-floating   red darken-1 waves-effect waves-light"><i class='material-icons left'>delete</i>EXCLUIR</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="./scripts/consultar.js"></script>
</body>
</html>