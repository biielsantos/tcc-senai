<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php include "./components/head.php" ?>
  <link rel="stylesheet" href="./styles/navbar.css">
  <link rel='stylesheet' href='./lib/main.css' />
  <link rel="stylesheet" href="./styles/consultar.css" />
  <script src='./lib/main.js'></script>
  <title>SRV | Veículos</title>

  <script>
    <?php
      include "./config/conexao.php";
      $sql = "SELECT id_reserva, data_saida, data_retorno, status_reserva, estado, cidade, rua, nome, modelo FROM reserva JOIN usuario ON reserva.fk_id_usuario = usuario.id_usuario JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo";
      $res = mysqli_query($conn, $sql);
      $reservas = mysqli_fetch_all($res, MYSQLI_ASSOC);

      mysqli_free_result($res);
      mysqli_close($conn);
    ?>
    const reservas = <?php echo json_encode($reservas) ?>;
    console.log(reservas);
    const events = [];
    reservas.forEach(reserva => {
      events.push({
        title: reserva.modelo,
        start: reserva.data_saida,
        end: reserva.data_retorno,
        extendedProps: {
          usuario: reserva.nome,
          destino: `${reserva.rua} (${reserva.cidade} ${reserva.estado})`,
          estado: reserva.estado,
          cidade: reserva.cidade,
          rua: reserva.rua,
        }
      })
    })

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'listWeek',
        locale: 'pt-br',
        events: events,
        eventContent: function(arg) {
          return {
            html: `
              <div class="event">
                <p class="eventTag"><strong>${arg.timeText}</strong></p>
                <p class="eventTag"><strong>Veículo</strong>: ${arg.event.title}</p>
                <p class="eventTag"><strong>Usuário</strong>: ${arg.event.extendedProps.usuario}</p>
                <p class="eventTag"><strong>Destino</strong>: ${arg.event.extendedProps.destino}</p>
              </div>
            `
          }
        },
        noEventsContent: "Não há nenhuma reserva hoje",
        height: 550,
        nowIndicator: true,
        headerToolbar: {
          start: "today prev,next",
          center: "title",
          end: "listWeek dayGridMonth timeGridWeek timeGridDay"
        },
        slotLabelFormat: {
          hour: 'numeric',
          minute: '2-digit',
          omitZeroMinute: false,
          meridiem: 'short'
        },
        views: {
          dayGridMonth: {
            titleFormat: {
              day: '2-digit',
              month: 'long',
              year: 'numeric'
            }
          },
        },
        buttonText: {
          today: 'Hoje',
          month: 'Mês',
          week: 'Semana',
          day: 'Dia',
          list: 'Lista'
        }
      });
      calendar.render();
    });
  </script>
</head>
<body>
  <?php include "./components/navbar.php" ?>
  <div class="container">
    <h2>Consultar veículos</h2>
    <div id='calendar'></div>
    <form class="reserva">
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
          <select required>
            <option value="" disabled selected>Selecione um veículo</option>
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
        <a class="btn waves-effect waves-light modal-trigger" href="#modal-reserva">Reservar
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
            <div class="input-field">
              <input id="destino" type="text" name="destino" required>
              <label for="destino">Destino</label>
            </div>
            <div class="input-field">
              <input id="responsavel" type="text" name="responsavel" required>
              <label for="responsavel">Responsável</label>
            </div>
            <div class="input-field">
              <input id="usuario" type="text" name="usuario" required>
              <label for="usuario">Usuário</label>
            </div>
          </div>
          </div>
        <div class="modal-footer">
          <button type="submit" class="waves-effect waves-light btn">
            Confirmar
          </button>
        </div>
      </div>
    </form>
  </div>
</body>
<?php include ("./components/scripts.php") ?>
<script src="./scripts/consultar.js"></script>
</html>