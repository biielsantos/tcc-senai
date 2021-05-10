$(document).ready(function(){
  // Inicializar componentes
  $('select').formSelect();
  $('.modal').modal();
});



// Checar reservas no botão de finalizar reserva
$(document).on("click", "#finalizar-reserva", function() {
  console.log("click event");
  M.Toast.dismissAll();

  let dataSaida = $("#dataSaida").val().trim();
  let dataRetorno = $("#dataRetorno").val().trim();
  let horarioSaida = $("#horarioSaida").val().trim();
  let horarioRetorno = $("#horarioRetorno").val().trim();
  let veiculo = $("#veiculo option:selected").text();

  let dataSaidaInput = new Date(dataSaida + " " + horarioSaida + ":00");
  let dataRetornoInput = new Date(dataRetorno + " " + horarioRetorno + ":00");

  // Verificações dos campos
  let valid = true;
  let msg = "";

  // Verificar se os campos estão vazios
  if (!dataSaida || !dataRetorno || !horarioSaida || !horarioRetorno || veiculo === "Selecione um veículo") {
    console.log("vazio");
    valid = false;
    msg = "Preencha todos os campos";
  }
  
  // Verificar se ja existe uma reserva no mesmo horário
  events.forEach(event => {
    let startDate = new Date(event.start);
    let endDate = new Date(event.end);

    if (event.title === veiculo) {
      if (dataSaidaInput.getTime() >= startDate.getTime() && dataSaidaInput.getTime() <= endDate.getTime()) {
        valid = false;
        msg = "Já existe uma reserva nesse horário";
      }
      if (dataRetornoInput.getTime() >= startDate.getTime() && dataRetornoInput.getTime() <= endDate.getTime()) {
        valid = false;
        msg = "Já existe uma reserva nesse horário";
      }
    }
  })

  if (valid) {
    $(".modal").modal('open');
  } else {
    M.toast({html: msg, classes: 'rounded #ef5350 red lighten-1'})
  }
});

// Submit form reservas
$("#form-reserva").submit(function(e) {
  e.preventDefault();
  
  let dataSaida = $("#dataSaida").val().trim();
  let dataRetorno = $("#dataRetorno").val().trim();
  let horarioSaida = $("#horarioSaida").val().trim();
  let horarioRetorno = $("#horarioRetorno").val().trim();
  let veiculo = $("#veiculo option:selected").val();
  let destino = $("#destino").val().trim();
  let condutor = $("#condutor").val().trim();
  let responsavel = $("#responsavel").val().trim();
  let departamento = $("#departamento option:selected").val();
  let motivo = $("#motivo").val().trim();
  let option = "CREATE";

  $.ajax({
    url: "./config/crud-reservas.php",
    type: "POST",
    dataType: "json",
    data: {
      dataSaida,
      dataRetorno,
      horarioSaida,
      horarioRetorno,
      veiculo,
      destino,
      condutor,
      responsavel,
      departamento,
      motivo,
      option
    },
    success: function(reserva) {
      $(".modal").modal('close');
      $("#form-reserva").trigger("reset");  

      // Atualizar dados no calendário
      calendar.addEvent({
        title: reserva[0].modelo,
        start: reserva[0].data_saida,
        end: reserva[0].data_retorno,
        extendedProps: {
          usuario: reserva[0].nome,
          destino: reserva[0].destino
        }
      });
      events.push({
        title: reserva[0].modelo,
        start: reserva[0].data_saida,
        end: reserva[0].data_retorno,
        extendedProps: {
          usuario: reserva[0].nome,
          destino: reserva[0].destino
        }
      });
    },
    error: function(error) {
      console.log(error);
    }
  })
});