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
    success: function(data) {
      console.log(data);
      $(".modal").modal('close');
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
                estado: reserva.estado,
                cidade: reserva.cidade,
                rua: reserva.rua,
              }
            })
          })
        },
        error: function(error) {
          console.log(error);
        }
      })
    },
    error: function(error) {
      console.log(error);
    }
  })
});