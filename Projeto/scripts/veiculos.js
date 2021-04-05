$(document).ready(function(){
  //Modal-cadastro
  $('.modal').modal();
  $('#placa').characterCounter();

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
});

var linhaTabelaVeiculo;

//Botão Novo Veículo
$(document).on("click", "#btn-novo-veiculo", function() {
  id="";
  modelo="";
  placa="";
  proprietario="";
  ver_placa="";
  $('#modelo').val(modelo);
  $('#placa').val(placa);
  $('#proprietario').val(proprietario);
  option=1;
  validation=1;
  console.log('Verificação ao INSERIR');
  console.log('ADICIONAR: ',validation);
});

//Botão EDITAR
$(document).on("click", ".btnEdit", function(){
  linhaTabelaVeiculo=$(this).closest('tr');
  id=parseInt(linhaTabelaVeiculo.find('td').eq(0).text());
  option=4;

  //Trazer todos os dados para o form de atualização
  $.ajax({
    url: "../config/crud-veiculos.php",
    type: 'POST',
    dataType: 'json',
    data:{id:id, option:option},
    success:function(data){
      $("#modelo").val(data[1]);
      M.textareaAutoResize($('#modelo'));
      $('#placa').val(data[2]);
      $('#proprietario').val(data[3]);
      option=2;
    },error(x, y, z){
      console.log(x);
      console.log(y);
      console.log(z);
    }
  });

  ver_placa = linhaTabelaVeiculo.find('td').eq(2).text();
  validation=2;
});


//Botão EXCLUIR
$(document).on("click", ".btnDelete", function(){
  linhaTabelaVeiculo=$(this);
  id=parseInt(linhaTabelaVeiculo.closest('tr').find('td').eq(0).text());
  option=3;

  $.ajax({
    url: "../config/crud-veiculos.php",
    type: 'POST',
    dataType: 'json',
    data:{option:option, id:id},
    success:function(data){
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
  placa = $('#placa').val().toUpperCase();
  proprietario = $('#proprietario').val().trim();
  
  $.ajax({
    url: "../config/crud-veiculos.php",
    type: 'POST',
    dataType: 'json',
    data:{option:option, modelo:modelo, placa:placa, proprietario:proprietario, id:id},
    success:function(data){
      id=data[0];
      //Inserir
      if (option==1){
        console.log(data);
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

  var elem = document.getElementById("modal1");
  var instance = M.Modal.getInstance(elem);
  instance.close();

});

//Bloqueia caracteres especiais
var input = document.querySelector("#placa");
input.addEventListener("keypress", function(e) {
    if(!checkChar(e)) {
      e.preventDefault();
  }
});
function checkChar(e) {
    var char = String.fromCharCode(e.keyCode);
    var pattern = '[a-zA-Z0-9]';
    if (char.match(pattern)) {
      return true;
  }
}

//Validação placa repetida ao INSERIR
//if(placa.lenght == 7){ 
  const form = document.querySelector("#form-veiculo");
  const verifica = document.getElementById('placa');
  verifica.addEventListener('change', function(){
  placa = $('#placa').val().toUpperCase();
  console.log('valor mudado: ',placa);
      $.ajax({
        url: "../config/verifica-veiculo.php",
        type: 'POST',
        dataType: 'json',
        data:{validation:validation, placa:placa, ver_placa:ver_placa},
        success:function(data){
          console.log(data);
        },error(x,y,z){
          console.log(x);
          console.log(y);
          console.log(z);
        }
      });
  });
