$(document).ready(function(){
  //Modal-veiculo
  $('.modal').modal();
  $('#placa').characterCounter();
  $('select').formSelect();

  //DataTables
  TabelaVeiculos = $('#tabela-veiculos').DataTable({
    "columnDefs":[{
      "targets": -1,
      "data":null,
      "defaultContent": "<a href='#modal1' data-target='modal1' class='btnEdit modal-trigger btn orange darken-1 waves-effect waves-light' type='submit' name='action'><i class='material-icons right'>edit</i>EDITAR</a><a href='#modal2' data-target='modal2' class='btnDelete modal-trigger red darken-1 btn waves-effect waves-light type='submit' name='action' ><i class='material-icons right'>delete</i>EXCLUIR</a>"
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
  modelo= "";
  placa= "";
  proprietario= "";
  $('#modelo').val(modelo);
  $('#placa').val(placa);
  $('#proprietario').val(proprietario);
  option=1;
  placa_real = null;
  document.getElementById('placa').removeAttribute("class");
});

//Botão EDITAR
$(document).on("click", ".btnEdit", function(){
  linhaTabelaVeiculo=$(this).closest('tr');
  id=parseInt(linhaTabelaVeiculo.find('td').eq(0).text());
  option=4;
  document.getElementById('placa').removeAttribute("class");

  //Trazer todos os dados para o form de atualização
  $.ajax({
    url: "../config/crud-veiculos.php",
    type: 'POST',
    dataType: 'json',
    data:{id:id, option:option},
    success:function(data){
      $("#modelo").val(data[1]);
      $('#placa').val(data[2]);
      $('#proprietario').val(data[3]);
      option=2;
      M.updateTextFields();
    },error(x, y, z){
      console.log(x);
      console.log(y);
      console.log(z);
    }
  });
  
  placa_real = linhaTabelaVeiculo.find('td').eq(2).text();
});


//Botão EXCLUIR
$(document).on("click", ".btnDelete", function(){
  linhaTabelaVeiculo=$(this);
  id=parseInt(linhaTabelaVeiculo.closest('tr').find('td').eq(0).text());
  modelo = linhaTabelaVeiculo.closest('tr').find('td').eq(1).text();
  placa =  linhaTabelaVeiculo.closest('tr').find('td').eq(2).text();
  option=3;
  var confirm = document.getElementById("confirm-delete");
  confirm.innerHTML =  `Esta ação não pode ser desfeita.<br>Isso excluirá permanentemente o veículo <b>${modelo}</b> cujo a placa é <b>${placa}</b><br><br>Digite <b>${placa}</b> para confirmar.`;
  $('#confirm').val("");
  $("#submitDelete").addClass("disabled");
});


//Submit -> Form de veículos
$("#form-veiculo").submit(function(e){
  e.preventDefault();
  modelo = $('#modelo').val().trim();
  placa = $('#placa').val().toUpperCase();
  proprietario = $('#proprietario').val().trim();
  
  $("#btn-salvar").attr("disabled", true);
  if(!$('#placa').hasClass("invalid")){
    $.ajax({
      url: "../config/crud-veiculos.php",
      type: 'POST',
      dataType: 'json',
      data:{option:option, modelo:modelo, placa:placa, proprietario:proprietario, id:id},
      success:function(data){
        id=data[0];
        //Inserir
        if (option==1){
          TabelaVeiculos.row.add([id, modelo, placa]).draw();
          $('#modelo').val(modelo);
          $('#placa').val(placa);
          $('#proprietario').val(proprietario);
          var msg = '<span>Veículo inserido com Sucesso</span>';
          M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
        }
        //Atualizar
        else if(option==2){
          TabelaVeiculos.row(linhaTabelaVeiculo).data([id, modelo, placa]);
          var msg = '<span>Veículo atualizado com Sucesso</span>';
          M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
        }

        var elem = document.getElementById("modal1");
        var instance = M.Modal.getInstance(elem);
        instance.close();
        $('#cpf').removeAttr("class");
        setTimeout(function(){$("#btn-salvar").attr("disabled", false)}, 1000);
      },error(x,y,z){
        console.log(x);
        console.log(y);
        console.log(z);
      }
    });
 
  }else{ //Msg Erro
    var msg = '<span>Preencha os campos Corretamente</span>';
    M.toast({html: msg, classes: 'rounded #ef5350 red lighten-1'});
    $("#btn-salvar").attr("disabled", false);
  }
});

//Verifica placa repetida
span_placa = $("#span_placa");
placa_msg = {successo: "Placa válida", erro: "Placa ja cadastrada"};

$(document).on("input", "#placa", function(){
  placa = $('#placa');
  placa_dados = {validation_option: "placa", placa: placa.val().toUpperCase() , placa_real: placa_real};
  if(placa.val().length == 7){
    console.log("7");
    validarInput(placa_dados, span_placa, placa, placa_msg)
  }else{
    span_placa.attr("data-error" , "Minimo de caracteres é 7");
    placa.removeClass("valid").addClass("invalid");
  }
});


//Verifica confirmação ao Excluir
$(document).on("input", "#confirm", function(){
  if($('#confirm').val().toUpperCase().trim() == placa){
    $("#submitDelete").removeClass("disabled");
  }else{
    $("#submitDelete").addClass("disabled");
  }
});

//Submit -> Form de Deletar Veiculo
$("#form-delete").submit(function(e){
  e.preventDefault();
  $.ajax({
    url: "../config/crud-veiculos.php",
    type: 'POST',
    dataType: 'json',
    data:{option:option, id:id},
    success:function(data){
      TabelaVeiculos.row(linhaTabelaVeiculo.parents('tr')).remove().draw();
      var msg = '<span>Veículo Excluido com Sucesso</span>';
      M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
    },error(x,y,z){
      console.log(x);
      console.log(y);
      console.log(z);
    }
  });

  var elem = document.getElementById("modal2");
  var instance = M.Modal.getInstance(elem);
  instance.close();
});


//Validar Input
function validarInput(dados, span, input, msg) {
  $.ajax({
    url: "../config/verifica-veiculo.php",
    type: 'POST',
    dataType: 'json',
    data: dados,
    success:function(data){
      switch (data) {
        case 1: //Disponivel
          span.attr("data-success" , msg.successo);
          input.removeClass("invalid").addClass("valid");
          
          break;
        case 2: //Indisponivel
          span.attr("data-error" , msg.erro);
          input.addClass("invalid");
        
          break;
        case 3: //Não Alterou
          input.removeAttr("class");
        break;
      }
    },error(x,y,z){
      console.log(x);
      console.log(y);
      console.log(z);
    }
  });
}

//Bloqueia "Enter" form-delete
$(document).on("keypress", '#form-delete', function (e) {
  var code = e.keyCode || e.which;
  if (code == 13) {
      e.preventDefault();
      return false;
  }
});

//Bloqueia caracteres especiais do campo #placa
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
};