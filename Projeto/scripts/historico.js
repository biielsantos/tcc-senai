$(document).ready(function(){
  $('.modal').modal();
  $('#historico').DataTable({
    "columnDefs":[
      //{ className: "hide-on-med-and-down", targets: 0},
      { className: "hide-on-med-and-down", targets: 3},
      { className: "hide-on-med-and-down", targets: -2},
      { className: "hide-on-med-and-down", targets: -3},
      { className: "hide-on-small-only", targets: 0},
      { className: "hide-on-small-only", targets: 1},
      { className: "hide-on-large-only", targets: -1},
    ],
    "oLanguage": {
      "sStripClasses": "",
      "sSearch": "",
      "sSearchPlaceholder": "Palavra-chave",
      "sInfoFiltered": "",
      "sInfoEmpty": "Sem Resultados",
      "sEmptyTable": "Tabela vazia",
      "sZeroRecords": "Nenhum resultado encontrado",
      "sInfo": "Mostrando _START_-_END_ de _TOTAL_",
      "sLengthMenu": '<span>Linhas por pagina:</span><select class="browser-default">' +
        '<option value="10">10</option>' +
        '<option value="20">20</option>' +
        '<option value="30">30</option>' +
        '<option value="40">40</option>' +
        '<option value="50">50</option>' +
        '<option value="-1">Todos</option>' +
        '</select></div>'
    },
    bAutoWidth: false
  });
});

let line;

$(document).on("click", ".btn-details", function(){
  line = $(this);
  let usuario = line.closest('tr').find('td').eq(0).text()
  let condutor = line.closest('tr').find('td').eq(1).text()
  let veiculo = line.closest('tr').find('td').eq(2).text()
  let destino = line.closest('tr').find('td').eq(3).text()
  let dataSaida = line.closest('tr').find('td').eq(4).text()
  let dataRetorno = line.closest('tr').find('td').eq(5).text()

  $('#details').html(
    `<b>Usuário: </b>${usuario}
    <br>
    <b>Condutor: </b>${condutor}
    <br>
    <b>Veículo: </b>${veiculo}
    <br>
    <b>Destino: </b>${destino}
    <br>
    <b>Data de Saída: </b>${dataSaida}
    <br>
    <b>Data de Retorno: </b>${dataRetorno}
    `
  )
});