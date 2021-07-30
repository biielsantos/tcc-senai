var defaultOption = "CREATE";
var option = defaultOption;
var editing = false;

$(document).ready(function(){
  // Inicializar componentes
  $('select').formSelect();
  $('.modal').modal();
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

  $('.timepicker').timepicker({
    defaultTime: 'now',
    twelveHour: false,
    vibrate: true,
    autoClose: true
  });
});

// Checar reservas no botão de finalizar reserva
$(document).on("click", "#finalizar-reserva", function() {
  M.Toast.dismissAll();

  let dataSaida = $("#dataSaida").val().trim().split("/");
  let dataRetorno = $("#dataRetorno").val().trim().split("/");
  let horarioSaida = $("#horarioSaida").val().trim();
  let horarioRetorno = $("#horarioRetorno").val().trim();
  let veiculo = $("#veiculo option:selected").text();

  let dataSaidaStr = dataSaida + " " + horarioSaida + ":00";
  let dataRetornoStr = dataRetorno + " " + horarioRetorno + ":00";

  let dataSaidaInput = new Date(dataSaidaStr.replace(/ /g,'T'));
  let dataRetornoInput = new Date(dataRetornoStr.replace(/ /g,'T'));

  let valid = true;
  let msg = "";

  // Verificar se os campos estão vazios
  if (!dataSaida || !dataRetorno || !horarioSaida || !horarioRetorno || veiculo === "Selecione um veículo") {
    valid = false;
    msg = "Preencha todos os campos";
  }

  // Verificar tempo mínimo de reserva (15 min)
  if (dataRetornoInput < new Date(dataSaidaInput.getTime() + 15*60000)) {
    valid = false;
    msg = "Reserva deve conter no mínimo 15 minutos";
  }

  // Verificar se existem viajantes do tempo (tolerância de 5 min)
  if (new Date(dataSaidaInput.getTime() + 5*60000) < new Date() || new Date(dataRetornoInput.getTime() + 5*60000) < new Date()) {
    valid = false;
    msg = "Data de reserva inferior a data atual";
  }

  // Verificar se a data de retorno é anterior a data de saída
  if (dataRetornoInput < dataSaidaInput) {
    valid = false;
    msg = "Data de retorno inferior a data de saída";
  }
  
  // Verificar se ja existe uma reserva no mesmo horário
  if (!editing) {
    events.forEach(event => {
      let startDate = new Date(event.start);
      let endDate = new Date(event.end);
  
      if (event.title === veiculo) {
        if (dataSaidaInput.getTime() >= startDate.getTime() && dataSaidaInput.getTime() <= endDate.getTime()) {
          valid = false;
          msg = "Já existe uma reserva nesse horário";
        }
        if (dataRetornoInput.getTime() >= startDate.getTime() && dataRetornoInput.getTime() <= endDate.getTime()) {
          valid = false;
          msg = "Já existe uma reserva nesse horário";
        }
      }
    })
  }

  if (valid) {
    $("#modal-reserva").modal('open');
  } else {
    M.toast({html: msg, classes: 'rounded #ef5350 red lighten-1'})
  }
});

// Submit form reservas
$("#form-reserva").submit(function(e) {
  e.preventDefault();
  
  let dataSaida = $("#dataSaida").val().trim();
  let dataRetorno = $("#dataRetorno").val().trim();
  let horarioSaida = $("#horarioSaida").val().trim();
  let horarioRetorno = $("#horarioRetorno").val().trim();
  let veiculo = $("#veiculo option:selected").val();
  let destino = $("#destino").val().trim();
  let condutor = $("#condutor").val().trim();
  let responsavel = $("#responsavel").val().trim();
  let departamento = $("#departamento option:selected").val();
  let motivo = $("#motivo").val().trim();

  if (!condutor) {
    condutor = session.nome;
  }

  let data = {
    dataSaida,
    dataRetorno,
    horarioSaida,
    horarioRetorno,
    veiculo,
    destino,
    condutor,
    responsavel,
    departamento,
    motivo,
    option
  }

  if (editing) {
    data.id = document.getElementById("det-id").value;
  }

  $.ajax({
    url: "./config/crud-reservas.php",
    type: "POST",
    dataType: "json",
    data: data,
    success: function(reserva) {
      $(".modal").modal('close');
      $("#form-reserva").trigger("reset");
      M.toast({html: "Reservado com sucesso", classes: 'rounded #66bb6a green lighten-1'})

      // Atualizar dados no calendário
      if (editing) {
        let id = reserva[0].id_reserva;

        events = events.filter(event => event.id !== id);
        let event = calendar.getEventById(id);
        event.remove();
      }

      calendar.addEvent({
        id: reserva[0].id_reserva,
        title: reserva[0].modelo,
        start: reserva[0].data_saida,
        end: reserva[0].data_retorno,
        extendedProps: {
          usuario: reserva[0].nome,
          condutor: reserva[0].condutor,
          destino: reserva[0].destino,
          motivo: reserva[0].motivo,
          departamento: reserva[0].departamento,
          data_saida_real: reserva[0].data_saida_real,
          data_retorno_real: reserva[0].data_retorno_real,
          km_saida: reserva[0].km_saida,
          km_retorno: reserva[0].km_retorno
        },
        backgroundColor: reserva[0].data_saida_real != null && reserva[0].data_retorno_real == null ? "#EE0000" : ""
      });

      events.push({
        id: reserva[0].id_reserva,
        title: reserva[0].modelo,
        start: reserva[0].data_saida,
        end: reserva[0].data_retorno,
        extendedProps: {
          usuario: reserva[0].nome,
          condutor: reserva[0].condutor,
          destino: reserva[0].destino,
          motivo: reserva[0].motivo,
          departamento: reserva[0].departamento,
          data_saida_real: reserva[0].data_saida_real,
          data_retorno_real: reserva[0].data_retorno_real,
          km_saida: reserva[0].km_saida,
          km_retorno: reserva[0].km_retorno
        },
        backgroundColor: reserva[0].data_saida_real != null && reserva[0].data_retorno_real == null ? "#EE0000" : ""
      });

      option = "CREATE";
      editing = false;
      M.updateTextFields();
    },
    error: function(error) {
      console.log(error);
      M.toast({html: "Houve um problema na operação", classes: 'rounded #ef5350 red lighten-1'});
    }
  })
});

// Botão excluir (modal detalhes)
$(document).on("click", "#det-excluir", function() {
  let id = document.getElementById("det-id").value;
  let option = "DELETE";

  $.ajax({
    url: "./config/crud-reservas.php",
    type: "POST",
    dataType: "json",
    data: {
      id,
      option
    },
    success: function(data) {
      $(".modal").modal('close');
      M.toast({html: "Excluído com sucesso", classes: 'rounded #66bb6a green lighten-1'})
      let id = data[0].id_reserva;

      events = events.filter(event => event.id !== id);
      let event = calendar.getEventById(id);
      event.remove();

      document.getElementById("det-id").value = "";
    },
    error: function(error) {
      console.log(error);
      M.toast({html: "Houve um problema na operação", classes: 'rounded #ef5350 red lighten-1'});
    }
  })
});

// Botão editar (modal detalhes)
$(document).on("click", "#det-editar", function() {
  option = "SELECT ONE";
  editing = true;

  let id = document.getElementById("det-id").value;

  $.ajax({
    url: "./config/crud-reservas.php",
    type: "POST",
    dataType: "json",
    data: {
      id,
      option
    },
    success: function(data) {
      option = "UPDATE";

      let dataSaida = data[0].data_saida.split(" ")[0];
      let horarioSaidaStr = data[0].data_saida.split(" ")[1];
      let horarioSaida = horarioSaidaStr.substr(0, horarioSaidaStr.length - 3);
      let dataRetorno = data[0].data_retorno.split(" ")[0];
      let horarioRetornoStr = data[0].data_retorno.split(" ")[1];
      let horarioRetorno = horarioRetornoStr.substr(0, horarioRetornoStr.length - 3);
      let veiculo = data[0].fk_id_veiculo;
      let destino = data[0].destino;
      let condutor = data[0].condutor;
      let departamento = data[0].fk_id_departamento;
      let motivo = data[0].motivo;

      $("#dataSaida").val(dataSaida);
      $("#dataRetorno").val(dataRetorno);
      $("#horarioSaida").val(horarioSaida);
      $("#horarioRetorno").val(horarioRetorno);
      $("#veiculo").val(veiculo);
      $("#destino").val(destino);
      $("#condutor").val(condutor);
      $("#responsavel").val(session.id);
      $("#nome-responsavel").val(session.nome);
      $("#departamento").val(departamento);
      $("#motivo").val(motivo);

      $(".modal").modal('close');
      // Corrigir campos (Materialize)
      M.updateTextFields();
      $('select').formSelect();
      M.toast({html: "Editado com sucesso", classes: 'rounded #66bb6a green lighten-1'})
    },
    error: function(error) {
      console.log(error);
      M.toast({html: "Houve um problema na operação", classes: 'rounded #ef5350 red lighten-1'});
    }
  })
});

// Botão cancelar
$(document).on("click", "#btn-cancelar", function() {
  $("#form-reserva").trigger("reset");
  editing = false;
  option = "CREATE";
  M.updateTextFields();
});

// Botão Retirar/Entregar veículo
$(document).on("click", "#det-btn-retirada", function() {
  let optionText = $("#det-btn-retirada").text();
  let km = $("#km").val().trim();
  let id = document.getElementById("det-id").value;

  let option;
  if (optionText.includes("Retirar")) {
    option = "RETIRAR"
  } else if (optionText.includes("Entregar")) {
    option ="ENTREGAR"
  }

  if (option === "ENTREGAR") {
    let str = document.getElementById("det-data-saida-real").innerText;
    let kmSaida = parseInt(str.split("(")[1].slice(0, 4));
    
    if (km < kmSaida) {
      M.toast({html: "Valor inserido inferior ao Km de saída", classes: 'rounded #ef5350 red lighten-1'});
      return;
    }
  }

  let data = new Date().toISOString();

  $.ajax({
    url: "./config/crud-reservas.php",
    type: "POST",
    dataType: "json",
    data: {
      id,
      km,
      data,
      option
    },
    success: function(reserva) {
      $("#km").val("");
      $(".modal").modal('close');
      M.updateTextFields();
      M.toast({html: "Operação bem sucedida", classes: 'rounded #66bb6a green lighten-1'});

      // Atualizar calendário
      let id = reserva[0].id_reserva;

      events = events.filter(event => event.id !== id);
      let event = calendar.getEventById(id);
      event.remove();

      calendar.addEvent({
        id: reserva[0].id_reserva,
        title: reserva[0].modelo,
        start: reserva[0].data_saida,
        end: reserva[0].data_retorno,
        extendedProps: {
          usuario: reserva[0].nome,
          condutor: reserva[0].condutor,
          destino: reserva[0].destino,
          motivo: reserva[0].motivo,
          departamento: reserva[0].departamento,
          data_saida_real: reserva[0].data_saida_real,
          data_retorno_real: reserva[0].data_retorno_real,
          km_saida: reserva[0].km_saida,
          km_retorno: reserva[0].km_retorno
        },
        backgroundColor: reserva[0].data_saida_real != null && reserva[0].data_retorno_real == null ? "#EE0000" : ""
      });

      events.push({
        id: reserva[0].id_reserva,
        title: reserva[0].modelo,
        start: reserva[0].data_saida,
        end: reserva[0].data_retorno,
        extendedProps: {
          usuario: reserva[0].nome,
          condutor: reserva[0].condutor,
          destino: reserva[0].destino,
          motivo: reserva[0].motivo,
          departamento: reserva[0].departamento,
          data_saida_real: reserva[0].data_saida_real,
          data_retorno_real: reserva[0].data_retorno_real,
          km_saida: reserva[0].km_saida,
          km_retorno: reserva[0].km_retorno
        },
        backgroundColor: reserva[0].data_saida_real != null && reserva[0].data_retorno_real == null ? "#EE0000" : ""
      });
    },
    error: function(error) {
      console.log(error);
      M.toast({html: "Houve um problema na operação", classes: 'rounded #ef5350 red lighten-1'})
    }
  })
});
