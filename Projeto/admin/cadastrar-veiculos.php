<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php include "../components/head.php" ?>
  <title>SRV | Cadastrar veículos</title>

  <link rel="stylesheet" href="../styles/cadastrar-veiculos.css">
</head>
<body>
  <div class="container">
    <h3 class="center">Cadastrar veículos</h3>
    <p class="center"><i class="material-icons large">directions_car</i></p>
    <form>
      <div class="input-field">
        <label for="modelo">Modelo</label>
        <input type="text" name="modelo" id="modelo" autocomplete="off" />
      </div>
      <div class="input-field">
        <label for="placa">Placa</label>
        <input type="text" name="placa" id="placa" autocomplete="off" />
      </div>
      <div class="input-field">
        <label for="proprietario">Proprietário</label>
        <input type="text" name="proprietario" id="proprietario" autocomplete="off" />
      </div>
      <div class="button-container">
        <a href="/tcc"  class="btn waves-effect red darken-1">Cancelar
          <i class="material-icons left">cancel</i>
        </a>
        <button class="btn waves-effect" type="submit" name="submit">Confirmar
          <i class="material-icons right">send</i>
        </button>
      </div>
    </form>
  </div>
</body>
</html>