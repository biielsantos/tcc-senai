$(document).ready(function(){
  $('select').formSelect();
  $('.modal').modal();
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
      calendar.addEvent({
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