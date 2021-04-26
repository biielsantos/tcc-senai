<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include "./components/head.php" ?>
  <link rel="stylesheet" href="./styles/index.css">
  <title>SRV | Login</title>
</head>

<body>
  <div class="container">
    <h3 class="center">Login</h3>
    <p class="center"><i class="material-icons large">directions_car</i></p>
    <form action="./config/login.php" method="POST">
      <div class="input-field">
        <i class="material-icons prefix">account_circle</i>
        <label for="cpf"></label>
        <input type="number" name="cpf" id="cpf" autocomplete="off" placeholder="CPF" />
      </div>
      <div class="input-field">
        <i class="material-icons prefix">lock</i>
        <label for="senha"></label>
        <input type="password" name="senha" id="senha" autocomplete="off" placeholder="SENHA"/>
      </div>
      <button class="btn waves-effect" type="submit" name="submit">Entrar
        <i class="material-icons right">send</i>
      </button>
    </form>
  </div>
</body>

</html>