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
        initialView: 'timeGridWeek',
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
        height: 700,
        nowIndicator: true,
        headerToolbar: {
          start: "today prev,next",
          center: "title",
          end: "dayGridMonth timeGridWeek timeGridDay listWeek"
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
    <h1>Consultar veículos</h1>
    <div id='calendar'></div>
  </div>
</body>
<?php include ("./components/scripts.php") ?>
</html>