$(document).ready(function(){
  //Materialize
  $('select').formSelect();
  $('.modal').modal();
  $('.sidenav').sidenav();

  //DataTables
  TabelaUsuarios = $('#tabela-usuarios').DataTable({
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

var linhaTabelaUsuario;

//Botão Novo Usuário
$(document).on("click", "#btn-novo-usuario", function() {
  id="";
  nome = "";
  cpf = "";
  departamento = "";
  telefone = "";
  ver_cpf="";
  senha="";
  $("#nome").val(nome);
  $("#cpf").val(cpf);
  $("#departamento").val(departamento); 
  $("#telefone").val(telefone);
  $("#senha").val(senha);
  option = 1;
  validation=1;
  document.getElementById('cpf').removeAttribute("class");
});

//Botão EDITAR
$(document).on("click", ".btnEdit", function(){
  linhaTabelaUsuario = $(this).closest('tr');
  id=parseInt(linhaTabelaUsuario.find('td').eq(0).text());
  option=4;
  document.getElementById('cpf').removeAttribute("class");

  //Trazer todos os dados para o modal de atualização
  $.ajax({
    url: "../config/crud-usuarios.php",
    type: 'POST',
    dataType: 'json',
    data:{id:id, option:option},
    success:function(data){
      console.log("Objeto -> editar\n", data);
      $('#nome').val(data[1]);
      $("#cpf").val(data[2]);
      $("#senha").val(data[3]);
      $("#tipo-usuario").val(data[4]);
      $("#departamento").val(data[5]); 
      $("#telefone").val(data[6]);
      option=2;
    },error(x, y, z){
      console.log(x);
      console.log(y);
      console.log(z);
    }
  });
  
  ver_cpf = linhaTabelaUsuario.find('td').eq(2).text();
  validation=2;
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


//Verifica confirmação ao Excluir
const verifica_delete = document.getElementById('confirm');

verifica_delete.addEventListener('input', function(){
  if($('#confirm').val().toUpperCase().trim() == cpf){
    $("#submitDelete").removeClass("disabled");
  }else{
    $("#submitDelete").addClass("disabled");
  }
});

//Submit -> Form Cadastrar/Atualizar Usuário
$("#form-usuario").submit(function(e){
  e.preventDefault();
  nome = $("#nome").val().trim();
  tipo = $("#tipo-usuario").val();
  cpf = $("#cpf").val().trim();
  departamento =$("#departamento").val().trim(); 
  telefone = $("#telefone").val().trim();
  senha = $("#senha").val().trim();
  
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
        TabelaUsuarios.row.add([id, nome, cpf, tipo]).draw();
        $('#nome').val(nome);
        //$('#placa').val(placa);
        //s$('#proprietario').val(proprietario);
        var msg = '<span>Usuário inserido com Sucesso</span>';
        M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
      }
      //Atualizar
      else if(option == 2){
        TabelaUsuarios.row(linhaTabelaUsuario).data([id, nome, cpf, tipo]);
        var msg = '<span>Usuário atualizado com Sucesso</span>';
        M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
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

//Submit -> Form Deletar Usuário
$("#form-delete").submit(function(e){
  e.preventDefault();
  $.ajax({
    url: "../config/crud-usuarios.php",
    type: 'POST',
    dataType: 'json',
    data:{option:option, id:id},
    success:function(data){
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