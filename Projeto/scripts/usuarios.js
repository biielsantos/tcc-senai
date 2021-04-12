$(document).ready(function(){
  $('select').formSelect();
  $('.modal').modal();

  //DataTables
  $('#tabela-usuarios').DataTable({
    "language":{
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
    }
  });
});