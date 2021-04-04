$(document).ready(function(){
  //Modal-cadastro
  $('.modal').modal();

  //DataTables
  TabelaVeiculos = $('#tabela-veiculos').DataTable({
    "columnDefs":[{
      "targets": -1,
      "data":null,
      "defaultContent": "<a href='#modal1' data-target='modal1' class='btnEdit modal-trigger btn deep-purple darken-1 waves-effect waves-light' type='submit' name='action'>UPDATE</a><button id='btnDelete' class='btnDelete red darken-1 btn waves-effect waves-light type='submit' name='action'>DELETE</button>"
    }],
    "language":{
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
    }
});

var linhaTabelaVeiculo;

$(document).on("click", "#btn-novo-veiculo", function() {
  id="";
  modelo="";
  placa="";
  proprietario="";
  $('#modelo').val(modelo);
  $('#placa').val(placa);
  $('#proprietario').val(proprietario);
  option=1;
});

});

$(document).on("click", ".btnEdit", function(){
  linhaTabelaVeiculo=$(this).closest('tr');
  id=parseInt(linhaTabelaVeiculo.find('td').eq(0).text());
  modelo=linhaTabelaVeiculo.find('td').eq(1).text();
  placa=linhaTabelaVeiculo.find('td').eq(2).text()
  $("#modelo").val(modelo);
  $('#placa').val(placa);


  //Trazer dados para o modal de atualização
  $.ajax({
    url: "../config/verifica-veiculo.php",
    type: 'POST',
    dataType: 'json',
    data:{id:id},
    success:function(data){
      $("#modelo").val(data[1]);
      $('#placa').val(data[2]);
      $('#proprietario').val(data[3]);
    },error(x, y, z){
      console.log(x);
      console.log(y);
      console.log(z);
    }
  });
  
  option=2;
})

//terminado -- fazer msg de comfirmação
$(document).on("click", ".btnDelete", function(){
  linhaTabelaVeiculo=$(this);
  id=parseInt(linhaTabelaVeiculo.closest('tr').find('td').eq(0).text());
  console.log(id);
  option=3;

  $.ajax({
    url: "../config/crud-veiculos.php",
    type: 'POST',
    dataType: 'json',
    data:{option:option, id:id},
    success:function(data){
      console.log(data)
      TabelaVeiculos.row(linhaTabelaVeiculo.parents('tr')).remove().draw();
    },error(x,y,z){
      console.log(x);
      console.log(y);
      console.log(z);

    }
  });
});

$("#form-veiculo").submit(function(e){
  e.PreventDefault();
  modelo = $.trim($("modelo").val());
  placa = $.trim($("placa").val());
  proprietario = $.trim($("proprietario").val());
});