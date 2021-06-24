$(document).ready(function(){
  //Materialize
  $('.modal').modal({
    onCloseEnd(){
      $("#btn-salvar").attr("disabled", false);
      $("#submitDelete").attr("disabled", true);
      $('#btn-salvar').children().eq(0).addClass('hide');
      $('#btn-salvar').children().eq(1).removeClass('hide');
      $('#btn-salvar').children().eq(2).removeClass('hide');
    },
  });
  $('select').formSelect();

  //DataTables
  TabelaDepartamento= $('#tabela-departamentos').DataTable({
    "columnDefs":[
    { className: "hide-on-small-only", targets: 0},
    {
      "targets": -1,
      "data":null,
      "defaultContent": "<a data-target='modal2' id='restaurar' class='btnDelete modal-trigger btn-floating btn-flat waves-effect waves-light'><i class='material-icons'>restore</i></a>"
    }],
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

$(document).on("click", "#restaurar", function() {
  linhaTabelaDepartamento = $(this);
  id=parseInt(linhaTabelaDepartamento.closest('tr').find('td').eq(0).text());

  $.ajax({
    url: "../config/restaurar-departamento.php",
    type: 'POST',
    async: false,
    dataType: 'json',
    data: {
      id
    },
    success: function(){
      TabelaDepartamento.row(linhaTabelaDepartamento.parents('tr')).remove().draw();
      M.toast({html: "Restaurado com sucesso", classes: 'rounded #66bb6a green lighten-1'});
    }
  });
});
