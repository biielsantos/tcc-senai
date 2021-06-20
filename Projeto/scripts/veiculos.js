$(document).ready(function(){
  //Materialize
  $('.modal').modal({
    onCloseEnd(){
      $('#btn-salvar').children().eq(0).addClass('hide');
      $('#btn-salvar').children().eq(1).removeClass('hide');
      $('#btn-salvar').children().eq(2).removeClass('hide');
    },
    onCloseStart(){
      
    }
  });
  $('.tooltipped').tooltip();
  $('#placa').characterCounter();
  $('select').formSelect();

  //DataTables
  TabelaVeiculos = $('#tabela-veiculos').DataTable({
    "columnDefs":[
    { className: "hide-on-med-and-down", targets: 0},
    { className: "hide-on-small-only", targets: 2},
    {
      "targets": -1,
      "data":null,
      "defaultContent": "<a href='#modal1' data-target='modal1' class='btnEdit modal-trigger btn-floating btn-flat waves-effect waves-yellow' type='submit' name='action'><i class='material-icons'>edit</i></a><a href='#modal2' data-target='modal2' class='btnDelete modal-trigger btn-floating btn-flat waves-effect waves-red' type='submit' name='action' ><i class='material-icons right'>delete</i></a>"
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


var linhaTabelaVeiculo;

//Botão Novo Veículo
$(document).on("click", "#btn-novo-veiculo", function() {
  $('#titulo-modal').html('Inserir Veículo');
  id="";
  $('#form-veiculo').trigger('reset');
  option=1;
  placaAtual = null;
});

//Botão EDITAR
$(document).on("click", ".btnEdit", function(){
  $('#titulo-modal').html('Editar Veículo');
  linhaTabelaVeiculo=$(this).closest('tr');
  id=parseInt(linhaTabelaVeiculo.find('td').eq(0).text());
  option=4;
  $('#form-veiculo').trigger('reset');

  //Trazer todos os dados para o form de atualização
  $.ajax({
    url: "../config/crud-veiculos.php",
    type: 'POST',
    dataType: 'json',
    data:{
      id:id,
      option:option
    },
    async: false,
    success:function(data){
      placaAtual = data.placa;
      $("#modelo").val(data[1]);
      $('#placa').val(data[2]);
      $('#proprietario').val(data[3]);
      option=2;
      M.updateTextFields();
    },error(x){
      console.log(x);
    }
  });
 
});

//Botão EXCLUIR
$(document).on("click", ".btnDelete", function(){
  linhaTabelaVeiculo=$(this);
  id = parseInt(linhaTabelaVeiculo.closest('tr').find('td').eq(0).text());
  modelo = linhaTabelaVeiculo.closest('tr').find('td').eq(1).text();
  placa =  linhaTabelaVeiculo.closest('tr').find('td').eq(2).text();
  option=3;
  $('#confirm-delete').html(`Esta ação não pode ser desfeita.<br>Isso excluirá permanentemente o veículo <b>${modelo}</b> cujo a placa é <b>${placa}</b><br><br>Digite <b>${placa}</b> para confirmar.`);
  $('#confirm').val("");
  $("#submitDelete").addClass("disabled");
});

//Submit -> Form de veículos
$("#form-veiculo").submit(function(e){
  e.preventDefault();
  modelo = $('#modelo').val().trim();
  placa = $('#placa').val().toUpperCase();
  proprietario = $('#proprietario').val().trim();
  let empty = false;
  let valid = true;

  if(!modelo){
    msg = 'Preencha o campo Modelo'
    empty = true;
    $('#modelo').addClass('invalid').focus();
  }else if(!placa){
    msg = 'Preencha o campo Placa';
    empty = true;
    $('#placa').addClass('invalid').focus();
  }else if(!proprietario){
    empty = true;
    msg = 'Preencha o campo Proprietário'
    $('#proprietario').addClass('invalid').focus();
  }

  if(!empty){
    if(placa != placaAtual){
      if(verificaDadosRepetidos("placa", placa)){
        msg = "Ja existe um veiculo com essa Placa"
        $('#placa').addClass('invalid');
        valid = false;
      }
    } 
  }
  
  $("#btn-salvar").attr("disabled", true);
  if(valid && !empty){
    $('#btn-salvar').children().eq(0).removeClass('hide');
    $('#btn-salvar').children().eq(1).addClass('hide');
    $('#btn-salvar').children().eq(2).addClass('hide');
    $.ajax({
      url: "../config/crud-veiculos.php",
      type: 'POST',
      dataType: 'json',
      data:{
        option:option,
        modelo:modelo,
        placa:placa,
        proprietario:proprietario,
        id:id
      },
      success:function(data){
        $("#carregando").empty();
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
    M.toast({
      html: msg,
      classes: 'rounded #ef5350 red lighten-1'
    });
    $("#btn-salvar").attr("disabled", false);
  }
});

function verificaDadosRepetidos(validationOption, value){
  let valid;
  $.ajax({
    url: "../config/validar-veiculo.php",
    type: 'POST',
    async: false,
    dataType: 'json',
    data: {
      validationOption: validationOption,
      value: value,
    },
    success: function(data){
      valid = data;
    }
  });
  return valid
};

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

//Verifica placa enquanto digita
validarInput("placa");

function validarInput(input){
  let currentValue;
  $(document).on("input", "#"+input, function(){
    let span = $("#span-"+input);
    let element = $(this);
    let value = element.val();
    console.log(value);
    if(value.length == 7){
      switch (input) {
        case "placa":
          currentValue = placaAtual;
          break;
      }
      if(currentValue != value){
        if(verificaDadosRepetidos(input, value)){
          element.addClass("invalid");
          span.attr("data-error", input.toUpperCase() + " ja cadastrada")
        }else{
          span.attr("data-success", input.toUpperCase() + " valida")
          element.removeClass('invalid').addClass('valid');
        }
      }else{
        element.removeAttr("class")
      }
    }else{
      console.log(value.length)
      span.attr("data-error", "Minimo de caracteres é 7");
      element.addClass("invalid")
    }
  });
};

//Verifica confirmação ao Excluir
$(document).on("input", "#confirm", function(){
  if($('#confirm').val().toUpperCase().trim() == placa){
    $("#submitDelete").removeClass("disabled");
  }else{
    $("#submitDelete").addClass("disabled");
  }
});
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