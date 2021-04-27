$(document).ready(function(){
  //Materialize
  $('select').formSelect();
  $('.modal').modal();
  $('.sidenav').sidenav();
 
  //DataTables
  TabelaUsuarios = $('#tabela-usuarios').DataTable({
    "columnDefs":[
      { className: "hide-on-small-only", targets: 0 },
      { className: "hide-on-med-and-down", targets: 5 },
      { className: "hide-on-med-and-down", targets: 4 },
      {
        "targets": -1,
        "data":null,
        "defaultContent": "<a href='#modal1' data-target='modal1' class='btnEdit modal-trigger btn orange darken-1 waves-effect waves-light' type='submit' name='action'><i class='material-icons right'>edit</i>EDITAR</a><a href='#modal2' data-target='modal2' class='btnDelete modal-trigger red darken-1 btn waves-effect waves-light type='submit' name='action' ><i class='material-icons right'>delete</i>EXCLUIR</a>"
      }
    ],
    "language":{
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
    }
  });

  //Jquery Mask
  $('#cpf').mask("000.000.000-00");
  $('#telefone').mask("(00) 00000-0000");
});

var linhaTabelaUsuario;

//Botão Novo Usuário
$(document).on("click", "#btn-novo-usuario", function() {
  id= "";
  nome = "";
  cpf = "";
  departamento = "";
  telefone = "";
  ver_cpf="";
  senha= "";
  $("#nome").val(nome);
  $("#cpf").val(cpf);
  $("#departamento").val(departamento); 
  $("#telefone").val(telefone);
  $("#senha").val(senha);
  option = 1;
  cpf_real = null;
});

//Botão EDITAR
$(document).on("click", ".btnEdit", function(){
  linhaTabelaUsuario = $(this).closest('tr');
  id=parseInt(linhaTabelaUsuario.find('td').eq(0).text());
  option=4;

  //Trazer todos os dados para o modal de atualização
  $.ajax({
    url: "../config/crud-usuarios.php",
    type: 'POST',
    dataType: 'json',
    data:{id:id, option:option},
    success:function(data){
      $('#nome').val(data[1]);
      $("#cpf").val(data[2]).trigger('input');
      $("#senha").val(data[3]);
      $("#tipo-usuario").val(data[4]).formSelect();
      $("#departamento").val(data[5]); 
      $("#telefone").val(data[6]).trigger('input');
      M.updateTextFields();
      option=2;
    },error(x, y, z){
      console.log(x);
      console.log(y);
      console.log(z);
    }
  });
  
  cpf_real = linhaTabelaUsuario.find('td').eq(2).text();
});

//Botão EXCLUIR
$(document).on("click", ".btnDelete", function(){
  linhaTabelaUsuario = $(this);
  id=parseInt(linhaTabelaUsuario.closest('tr').find('td').eq(0).text());
  nome = linhaTabelaUsuario.closest('tr').find('td').eq(1).text();
  cpf =  linhaTabelaUsuario.closest('tr').find('td').eq(2).text();
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
  departamento =$("#departamento").val().trim(); 
  telefone = $("#telefone").val().replace(/[^\d]+/g,"");
  senha = $("#senha").val().trim();
  
  $("#btn-salvar").attr("disabled", true);
  if(!$('#cpf').hasClass("invalid")){
    $.ajax({
      url: "../config/crud-usuarios.php",
      type: 'POST',
      dataType: 'json',
      data:{option:option, nome:nome, tipo:tipo, cpf:cpf, departamento:departamento,telefone:telefone, senha,senha,id:id},
      success:function(data){
        id = data[0];
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
      }
    });
  }else{ //Msg erro
    var msg = '<span>Preencha os campos Corretamente</span>';
    M.toast({html: msg, classes: 'rounded #ef5350 red lighten-1'})
    $("#btn-salvar").attr("disabled", false); 
  }

  
});

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

//Verifica CPF repetido
span_cpf = $("#span_cpf");
cpf_msg = {successo: "CPF válido", erro: "CPF ja cadastrado"};

$(document).on("input", "#cpf", function(){
  cpf = $("#cpf");
  cpf_dados = {validation_option: "cpf", cpf: cpf.val().replace(/[^\d]+/g,"") , cpf_real: cpf_real};

  if(cpf.val().replace(/[^\d]+/g,"").length == 11){
    validarInput(cpf_dados, span_cpf, cpf, cpf_msg);
  }else{
    span_cpf.attr("data-error" , "Minimo de caracteres é 11");
    cpf.removeClass("valid").addClass("invalid");
  }
});

//Validar Input
function validarInput(dados, span, input, msg) {
  $.ajax({
    url: "../config/verifica-usuario.php",
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