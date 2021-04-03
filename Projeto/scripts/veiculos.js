$(document).ready(function(){
  //Modal-cadastro
  $('.modal').modal();

  //DataTables
  $('#tabela-veiculos').DataTable({
    "language":{
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
    }
  });
});