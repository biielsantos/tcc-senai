<script>
  var events = [];
  var calendar;
  function getEvents(callback) {
    $.ajax({
      url: "./config/crud-reservas.php",
      type: 'POST',
      dataType: 'json',
      data:{option: "SELECT ALL"},
      success: function(reservas) {
        reservas.forEach(reserva => {
          events.push({
            id: reserva.id_reserva,
            title: reserva.modelo,
            start: reserva.data_saida,
            end: reserva.data_retorno,
            extendedProps: {
              usuario: reserva.nome,
              condutor: reserva.condutor,
              destino: reserva.destino,
              motivo: reserva.motivo,
              departamento: reserva.departamento
            }
          })
        });
        callback();
      },
      error: function(error) {
        console.log(error);
      }
    });
  }

  function setupCalendar() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'listWeek',
      eventClick: function(info) {
        $("#modal-detalhes").modal("open");
        document.getElementById("det-veiculo").innerText = info.event.title;
        document.getElementById("det-destino").innerText = info.event.extendedProps.destino;
        document.getElementById("det-motivo").innerText = info.event.extendedProps.motivo;
        document.getElementById("det-data-saida").innerText = info.event.start.toLocaleString();
        document.getElementById("det-data-retorno").innerText = info.event.end.toLocaleString();
        document.getElementById("det-condutor").innerText = info.event.extendedProps.condutor;
        document.getElementById("det-usuario").innerText = info.event.extendedProps.usuario;
        document.getElementById("det-departamento").innerText = info.event.extendedProps.departamento;

        document.getElementById("det-id").value = info.event.id;
      },
      locale: 'pt-br',
      events: events,
      noEventsContent: "Não há nenhuma reserva hoje",
      height: 550,
      expandRows: true,
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
  }

  document.addEventListener('DOMContentLoaded', function() {
    getEvents(setupCalendar);
  });
</script>