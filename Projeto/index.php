<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include "./components/head.php" ?>
  <link rel="stylesheet" href="./styles/index.css">
  <title>SRV | Login</title>

  <style>
    #toast-container {
      top: 10px !important;
      right: auto !important;
      bottom: 10%;
      left: 50%;
      transform: translate(-50%);
      max-height: 250px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h3 class="center">Login</h3>
    <p class="center"><i class="material-icons large">directions_car</i></p>
    <form id="form-login" method="POST">
      <div class="input-field">
        <i class="material-icons prefix">account_circle</i>
        <input type="number" id="cpf" data-length="11" autocomplete="off" />
        <label for="cpf">CPF</label>
      </div>
      <div class="input-field">
        <i class="material-icons prefix">lock</i>
        <input type="password" id="senha" autocomplete="off"/>
        <label for="senha">Senha</label>
      </div>
      <button class="btn waves-effect" type="submit" name="submit">Entrar
        <i class="material-icons right">send</i>
      </button>
    </form>
  </div>
  <form id="submit-form" action="./config/login.php" method="POST">
    <input type="hidden" name="cpf" id="submit-cpf" />
    <input type="hidden" name="senha" id="submit-senha" />
    <input type="hidden" name="option" id="option" />
  </form>
  <?php include "./components/scripts.php"; ?>
  <script>
    M.updateTextFields();
    $(document).ready(function() {
      $("#cpf").characterCounter();
    });

    $("#form-login").submit(function(e) {
      e.preventDefault();
      M.Toast.dismissAll();

      let cpf = $("#cpf").val().trim();
      let senha = $("#senha").val().trim();

      $.ajax({
        url: "./config/login.php",
        type: "POST",
        dataType: "json",
        data: {
          cpf,
          senha,
          option: "VERIFY"
        },
        success: function(response) {
          if (response === "ok") {
            $("#option").val("LOGIN");
            $("#submit-cpf").val(cpf);
            $("#submit-senha").val(senha);
            $("#submit-form").submit();
          } else {
            M.toast({html: "Credenciais inválidas", classes: 'rounded #ef5350 red lighten-1'});
          }
        },
        error: function(error) {
          console.log(error);
        }
      })
    });
  </script>
</body>

</html>