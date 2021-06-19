$(document).ready(function(){
    //Materialize
    $('.modal').modal({
      onCloseEnd(){
        $("#btn-salvar").attr("disabled", false);
        $("#submitDelete").attr("disabled", true);
        $('#btn-salvar').children().eq(0).addClass('hide');
        $('#btn-salvar').children().eq(1).removeClass('hide');
        $('#btn-salvar').children().eq(2).removeClass('hide');
      },
    });
    $('select').formSelect();
  
    //DataTables
    TabelaDepartamento= $('#tabela-departamentos').DataTable({
      "columnDefs":[
      { className: "hide-on-small-only", targets: 0},
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
  
var linhaTabelaDepartamento;

//Botão Novo Departamento
$(document).on("click", "#btn-novo-departamento", function() {
  $('#titulo-modal').html('Inserir Departamento');
  id="";
  $('#form-departamento').trigger('reset');
  option=1;
});

//Botão EDITAR
$(document).on("click", ".btnEdit", function(){
  $('#titulo-modal').html('Editar Departamento');
  linhaTabelaDepartamento=$(this).closest('tr');
  id=parseInt(linhaTabelaDepartamento.find('td').eq(0).text());
  option=4;
  $('#form-departamento').trigger('reset');

  //Trazer todos os dados para o form de atualização
  $.ajax({
    url: "../config/crud-departamentos.php",
    type: 'POST',
    dataType: 'json',
    data:{
      id:id,
      option:option
    },
    async: false,
    success:function(data){
      $('#nome-departamento').val(data.departamento);
      option=2;
      M.updateTextFields();
    },error(x){
      console.log(x);
    }
  });
 
});

//Botão EXCLUIR
$(document).on("click", ".btnDelete", function(){
  linhaTabelaDepartamento = $(this);
  id = parseInt(linhaTabelaDepartamento.closest('tr').find('td').eq(0).text());
  departamento = linhaTabelaDepartamento.closest('tr').find('td').eq(1).text();
  option=3;
  $('#msg-confirm').val("");
  $('#confirm-delete').html(`Esta ação não pode ser desfeita.<br>Isso excluirá permanentemente o departamento <b>${departamento}</b><br><br>Digite <b>${departamento}</b> para confirmar.`);
});

//Submit form-departamento
$("#form-departamento").submit(function(e){
  e.preventDefault();
  departamento = $('#nome-departamento').val().trim();
  let empty = false;

  if(!departamento){
    msg = 'Preencha o Departamento'
    empty = true;
    $('#nome-departamento').addClass('invalid').focus();
  }
  
  $("#btn-salvar").attr("disabled", true);
  if(!empty){
    $('#btn-salvar').children().eq(0).removeClass('hide');
    $('#btn-salvar').children().eq(1).addClass('hide');
    $('#btn-salvar').children().eq(2).addClass('hide');
    $.ajax({
      url: "../config/crud-departamentos.php",
      type: 'POST',
      dataType: 'json',
      data:{
        option:option,
        departamento: departamento,
        id:id
      },
      success:function(data){
        $("#carregando").empty();
        id=data[0];
        //Inserir
        if (option==1){
          TabelaDepartamento.row.add([id, departamento]).draw();
          let msg = '<span>Departamento inserido com Sucesso</span>';
          M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
        }
        //Atualizar
        else if(option==2){
          TabelaDepartamento.row(linhaTabelaDepartamento).data([id, departamento]);
          let msg = '<span>Departamento atualizado com Sucesso</span>';
          M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
        }

        var elem = document.getElementById("modal1");
        var instance = M.Modal.getInstance(elem);
        instance.close();
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

//Submit -> Form Deletar Usuário
$("#form-delete").submit(function(e){
  e.preventDefault();
  $.ajax({
    url: "../config/crud-departamentos.php",
    type: 'POST',
    dataType: 'json',
    data:{
      option:option,
      id:id
    },
    success:function(){
      TabelaDepartamento.row(linhaTabelaDepartamento.parents('tr')).remove().draw();
      let msg = '<span>Departamento Excluido com Sucesso</span>';
      M.toast({html: msg, classes: 'rounded #66bb6a green lighten-1'});
    },error(x){
      console.log(x);
    }
  });

  var elem = document.getElementById("modal2");
  var instance = M.Modal.getInstance(elem);
  instance.close();
});

//Verificar msg de delete enquanto digita
$(document).on("input", "#msg-confirm", function(){
  let msgConfirmacao = $(this).val().toUpperCase();
  if(msgConfirmacao === departamento.toUpperCase()){
    $("#submitDelete").attr('disabled', false);
  }else{
    $("#submitDelete").attr('disabled', true);
  }
});