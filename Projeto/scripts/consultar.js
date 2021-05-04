$(document).ready(function(){
  $('select').formSelect();
  $('.modal').modal();
});

// Submit form reservas
// $("#form-reserva").submit(function(e) {
//   e.preventDefault();
//   let dataSaida = $("#dataSaida").val().trim();
//   let dataRetorno = $("#dataRetorno").val().trim();
//   let horarioSaida = $("#horarioSaida").val().trim();
//   let horarioRetorno = $("#horarioRetorno").val().trim();
//   let veiculo = $("#select-veiculo option:selected").val();
//   let destino = $("#destino").val().trim();
//   let responsavel = $("#responsavel").val().trim();
//   let condutor = $("#condutor").val().trim();
//   let option = "CREATE";

//   $ajax({
//     url: "./config/crud-reservas.php",
//     type: "POST",
//     dataType: "json",
//     data: {
//       dataSaida,
//       dataRetorno,
//       horarioSaida,
//       horarioRetorno,
//       veiculo,
//       destino,
//       responsavel,
//       condutor,
//       option,
//     },
//     success: function(data) {
//       console.log(data);
//     },
//     error: function(error) {
//       console.log(error);
//     }
//   })
// });