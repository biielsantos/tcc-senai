<script>
  const events = [];
  var calendar;
  $.ajax({
    url: "./config/crud-reservas.php",
    type: 'POST',
    dataType: 'json',
    data:{option: "SELECT ALL"},
    success: function(reservas) {
      reservas.forEach(reserva => {
        events.push({
          title: reserva.modelo,
          start: reserva.data_saida,
          end: reserva.data_retorno,
          extendedProps: {
            usuario: reserva.nome,
            destino: reserva.destino,
          }
        })
      })
    },
    error: function(x, y, z) {
      console.log(x);
      console.log(y);
      console.log(z);
    }
  })

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'listWeek',
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
  });
</script>