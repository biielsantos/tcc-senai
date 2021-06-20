$(document).ready(function(){
  //Materialize
  $('select').formSelect();
  $('.modal').modal({
    onCloseEnd(){
      $('#btn-salvar').children().eq(0).addClass('hide');
      $('#btn-salvar').children().eq(1).removeClass('hide');
      $('#btn-salvar').children().eq(2).removeClass('hide');
    },
    onCloseStart(){
      
    }
  });
  $('.sidenav').sidenav();
  $('.tooltipped').tooltip();
  $('.datepicker').datepicker({
    i18n: {
      months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
      weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
      weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
      today: 'Hoje',
      clear: 'Limpar',
      cancel: 'Sair',
      done: 'Confirmar',
      labelMonthNext: 'Próximo mês',
      labelMonthPrev: 'Mês anterior',
      labelMonthSelect: 'Selecione um mês',
      labelYearSelect: 'Selecione um ano',
      selectMonths: true,
      selectYears: 15,
    },
    format: 'yyyy-mm-dd',
    container: 'body',
    minDate: new Date(),
    autoClose: true
  });
  
  //DataTables
  TabelaUsuarios = $('#tabela-usuarios').DataTable({
    "columnDefs":[
      { className: "hide-on-small-only", targets: 0 },
      { className: "hide-on-small-only", targets: 2},
      { className: "hide-on-med-and-down", targets: 5 },
      { className: "hide-on-med-and-down", targets: 4 },
      { className: "hide-on-small-only", targets: 3 },
      {
        "targets": -1,
        "data":null,
        "defaultContent": "<a href='#modal1' data-target='modal1' class='btnEdit modal-trigger btn-floating btn-flat waves-effect waves-blue' data-position='bottom' data-tooltip='Editar' type='submit' name='action'><i class='material-icons'>edit</i></a><a href='#modal2' data-target='modal2' class='btnDelete modal-trigger btn-floating btn-flat waves-effect waves-red' type='submit' name='action' ><i class='material-icons'>delete</i></a>"
      }
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

  //Jquery Mask
  $('#cpf').mask("000.000.000-00");
  $('#telefone').mask("(00) 00000-0000");
  $('#cnh').mask("00000000000");
});

var linhaTabelaUsuario;

//Botão Novo Usuário
$(document).on("click", "#btn-novo-usuario", function() {
  id="";
  $("#form-usuario").trigger("reset");
  $("#titulo-modal").html("Inserir Usuário");
  option = 1;
  cpfAtual = null;
  telefoneAtual = null;
  cnhAtual = null;
});

//Botão EDITAR
$(document).on("click", ".btnEdit", function(){
  $("#titulo-modal").html("Editar Usuário");
  linhaTabelaUsuario = $(this).closest('tr');
  id=parseInt(linhaTabelaUsuario.find('td').eq(0).text());
  option=4;
  $("#form-usuario").trigger("reset");

  //Trazer todos os dados para o modal de atualização
  $.ajax({
    url: "../config/crud-usuarios.php",
    type: 'POST',
    dataType: 'json',
    async: false,
    data:{
      id:id,
      option:option
    },
    success:function(data){
      cnhAtual = data.cnh;
      cpfAtual = data.cpf;
      telefoneAtual = data.telefone;
      $('#nome').val(data[1]);
      $("#cpf").val(data[2]).trigger('input');
      $("#senha").val(atob(data[3])); //base64 provisório
      $("#tipo-usuario").val(data[4]).formSelect();
      $("#telefone").val(data[5]).trigger('input');
      $("#validade_carteira").val(data[6]);
      $("#cnh").val(data[7]).trigger('input');
      $("#departamento").val(data[8]).formSelect();
      M.updateTextFields();
      option=2;
    }
  });
});

//Botão EXCLUIR
$(document).on("click", ".btnDelete", function(){
  linhaTabelaUsuario = $(this);
  id=parseInt(linhaTabelaUsuario.closest('tr').find('td').eq(0).text());
  nome = linhaTabelaUsuario.closest('tr').find('td').eq(1).text();
  cpf = linhaTabelaUsuario.closest('tr').find('td').eq(2).text();
  option=3;
  var confirm = document.getElementById("confirm-delete");
  confirm.innerHTML =  "Esta ação não pode ser desfeita.<br>Isso excluirá permanentemente o usuário <b>"+nome+"</b> cujo o CPF é <b>"+cpf+"</b><br><br>"+"Digite <b>"+cpf+" </b>para confirmar." ;
  $('#confirm').val("");
  $("#submitDelete").addClass("disabled");
});

//Submit -> Form Cadastrar/Atualizar Usuário
$("#form-usuario").submit(function(e){
  e.preventDefault();
  nome = $("#nome").val().trim();
  tipo = $("#tipo-usuario").val();
  cpf = $("#cpf").val().replace(/[^\d]+/g,"");
  departamento = $("#departamento").val(); 
  telefone = $("#telefone").val().replace(/[^\d]+/g,"");
  cnh = $("#cnh").val();
  validade_carteira = $("#validade_carteira").val() 
  senha = $("#senha").val();
  let valid = true;
  let empty = false;

  //Verificar campos vazios 
  if(!nome){
    msg = 'Preencha o campo NOME'
    emptyField = $('#nome');
    empty = true;
  }else if(!departamento){
    msg = 'Selecione um departamento';
    emptyField = $('#departamento');
    empty = true;
  }else if(!tipo){
    msg = 'Selecione o TIPO de USUARIO';
    emptyField = $('#tipo-usuario');
    empty = true;
  }else if(!cpf){
    msg = 'Preencha o campo CPF';
    emptyField = $('#cpf');
    empty = true;
  }else if(!cnh){
    msg = 'Preencha o campo CNH';
    emptyField = $('#cnh');
    empty = true;
  }else if(!validade_carteira){
    msg = 'Selecione a data de VALIDADE DA CARTEIRA';
    emptyField = $('#validade_carteira');
    emptyField.click();
    empty = true;
  }else if(!telefone){
    msg = 'Preencha o campo TELEFONE';
    emptyField = $('#telefone');
    empty = true;
  }else if(!senha){
    msg = 'Preencha o campo SENHA';
    emptyField = $('#senha');
    empty = true;
  }
  
  //Verificar data
  let dataAtual = new Date();
  let data = new Date(validade_carteira + ' 23:59:00');
  let dateValid = true;

  if(data.getTime() < dataAtual.getTime()){
    msg = 'Data Inferior a data atual';
    $('#validade_carteira').click();
    dateValid = false;
  }
  
  //Varificar dados repetidos
  if(!empty){
    if(telefone != telefoneAtual){
      if(verificaDadosRepetidos("telefone", telefone)){
        msg = 'Ja existe um Usuario com esse TELEFONE';
        $("#telefone").addClass("invalid")
        valid = false;
      }
    }
    if(cnh != cnhAtual){
      if(verificaDadosRepetidos("cnh", cnh)){
        msg = 'Ja existe um Usuario com esse CNH';
        $("#cnh").addClass("invalid")
        valid = false;
      }
    }
    if(cpf != cpfAtual){
      if(verificaDadosRepetidos("cpf", cpf)){
        msg = 'Ja existe um Usuario com esse CPF';
        $("#cpf").addClass("invalid");
        valid = false;
      }
    }
  }else{
    emptyField.addClass("invalid");
    emptyField.focus();
  }
  
  $("#btn-salvar").attr("disabled", true);
  if(valid && !empty && dateValid){
    $('#btn-salvar').children().eq(0).removeClass('hide');
    $('#btn-salvar').children().eq(1).addClass('hide');
    $('#btn-salvar').children().eq(2).addClass('hide');
    $.ajax({
      url: "../config/crud-usuarios.php",
      type: 'POST',
      dataType: 'json',
      data:{
        option: option,
        nome: nome,
        tipo: tipo,
        cpf: cpf,
        departamento: departamento,
        telefone:telefone,
        senha:senha,
        cnh: cnh,
        validade: validade_carteira,
        id:id
      },  
      success:function(data){
        id = data[0];
        departamento = data.departamento;
        if(tipo == "A"){
          tipo = "ADMIN";
        }else if(tipo == "U"){
          tipo = "COMUM"
        }
        //Inserir
        if (option == 1){
          TabelaUsuarios.row.add([id, nome, cpf, tipo, departamento, telefone]).draw();
          var msg = '<span>Usuário inserido com Sucesso</span>';
          M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
        }
        //Atualizar
        else if(option == 2){
          TabelaUsuarios.row(linhaTabelaUsuario).data([id, nome, cpf, tipo, departamento, telefone]);
          var msg = '<span>Usuário atualizado com Sucesso</span>';
          M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
        }
      
        var modal_usuario = document.getElementById("modal1");
        var usuario = M.Modal.getInstance(modal_usuario);
        usuario.close();
        setTimeout(function(){$("#btn-salvar").attr("disabled", false)}, 1000);
        $('#cpf').removeAttr("class");
      },error(erro){
        console.log(erro)
      }
    });
  }else{ //Msg erro
    M.toast({
      html: msg,
      classes: 'rounded #ef5350 red lighten-1'
    });
    $("#btn-salvar").attr("disabled", false);
  }
});

function verificaDadosRepetidos(validationOption, value){
  let valid = false;
  $.ajax({
    url: "../config/validar-usuario.php",
    type: 'POST',
    async: false,
    dataType: 'json',
    data: {
      validationOption: validationOption,
      value: value,
    },
    success: function(data){
      if(data){
        valid = true;
      }
    }
  });
  return valid
};

//Verifica confirmação ao Excluir
$(document).on("input", "#confirm", function(){
  if($('#confirm').val().toUpperCase().trim() == cpf){
    $("#submitDelete").removeClass("disabled");
  }else{
    $("#submitDelete").addClass("disabled");
  }
});

//Submit -> Form Deletar Usuário
$("#form-delete").submit(function(e){
  e.preventDefault();
  $.ajax({
    url: "../config/crud-usuarios.php",
    type: 'POST',
    dataType: 'json',
    data:{option:option, id:id},
    success:function(){
      TabelaUsuarios.row(linhaTabelaUsuario.parents('tr')).remove().draw();
      var msg = '<span>Usuário Excluido com Sucesso</span>';
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

//Verifica dado repetido enquanto digita
validarInput("cpf");
validarInput("telefone");
validarInput("cnh");

function validarInput(input){
  let currentValue;
  $(document).on("input", "#"+input, function(){
    let span = $("#span-"+input);
    let element = $(this);
    let value = element.val().replace(/[^\d]+/g,"");
    if(value.length == 11){
      switch (input) {
        case "cpf":
          currentValue = cpfAtual;
          break;
        case "cnh":
          currentValue = cnhAtual;
          break;
        case "telefone":
          currentValue = telefoneAtual;
          break;
      }
      if(currentValue != value){
        if(verificaDadosRepetidos(input, value)){
          element.addClass("invalid");
          span.attr("data-error", input.toUpperCase() + " ja cadastrado")
        }else{
          span.attr("data-success", input.toUpperCase() + " valido")
          element.removeClass('invalid').addClass('valid');
        }
      }else{
        element.removeAttr("class")
      }
    }else{
      span.attr("data-error", "Minimo de caracteres é 11");
      element.addClass("invalid")
    }
  });
};

//Bloqueia "Enter" form-delete
$(document).on("keypress", '#form-delete', function (e) {
  var code = e.keyCode || e.which;
  if (code == 13) {
      e.preventDefault();
      return false;
  }
});