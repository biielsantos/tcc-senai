$(document).ready(function(){
  //Modal-cadastro
  $('.modal').modal();

  //DataTables
  TabelaVeiculos = $('#tabela-veiculos').DataTable({
    "columnDefs":[{
      "targets": -1,
      "data":null,
      "defaultContent": "<a href='#modal1' data-target='modal1' class='btnEdit modal-trigger btn deep-purple darken-1 waves-effect waves-light' type='submit' name='action'>EDITAR</a><button id='btnDelete' class='btnDelete red darken-1 btn waves-effect waves-light type='submit' name='action'>EXCLUIR</button>"
    }],
    "language":{
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
    }
});

var linhaTabelaVeiculo;

//Botão Novo Veículo
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

//Botão EDITAR
$(document).on("click", ".btnEdit", function(){
  linhaTabelaVeiculo=$(this).closest('tr');
  id=parseInt(linhaTabelaVeiculo.find('td').eq(0).text());
  modelo=linhaTabelaVeiculo.find('td').eq(1).text();
  placa=linhaTabelaVeiculo.find('td').eq(2).text()
  $("#modelo").val(modelo);
  $('#placa').val(placa);
  option=2;
  console.log(option);


  //Trazer todos os dados para o form de atualização
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
})

//Botão EXCLUIR
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

//Submit -> Form de veículos
$("#form-veiculo").submit(function(e){
  e.preventDefault();
  modelo = $('#modelo').val().trim();
  placa = $('#placa').val().trim();
  proprietario = $('#proprietario').val().trim();
  

  $.ajax({
    url: "../config/crud-veiculos.php",
    type: 'POST',
    dataType: 'json',
    data:{option:option, modelo:modelo, placa:placa, proprietario:proprietario, id:id},
    success:function(data){
      console.log(data)
      id=data[0];
      //Inserir
      if (option==1){
        TabelaVeiculos.row.add([id, modelo, placa]).draw();
        modelo='';
        placa='';
        proprietario='';
        $('#modelo').val(modelo);
        $('#placa').val(placa);
        $('#proprietario').val(proprietario);
      }
      //Atualizar
      else if(option==2){
        TabelaVeiculos.row(linhaTabelaVeiculo).data([id, modelo, placa]);
      }
  
    },error(x,y,z){
      console.log(x);
      console.log(y);
      console.log(z);

    }
  });
});