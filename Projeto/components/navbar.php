<nav>
  <div class="nav-wrapper indigo">
    <ul class="quick-access">
      <li>
        <a href="#" data-target="slide-out" class="sidenav-trigger show-on-large btn-floating btn-flat waves-effect waves-light nopadding"><i class="material-icons">menu</i></a>
      </li>
      <li>
        <a href="/tcc/veiculos.php" class="waves-effect waves-light btn-flat white-text reservar hide-on-med-and-down"><i class="material-icons right">local_shipping</i>Reservar</a>
      </li>
    </ul>
    <div class="usuario hide-on-small-only">
      <span class="nome"><?php echo $_SESSION['nome']; ?></span>
      <i class="material-icons account-circle">account_circle</i>
      <a data-target="nav-dropdown" class="dropdown-trigger">
        <i class="material-icons">keyboard_arrow_down</i>
      </a>
    </div>
  </div>
</nav>

<ul id="slide-out" class="sidenav">
  <div>
    <li class="center top-header">
      <i class="medium material-icons">directions_car</i>
      <i class="small material-icons sidenav-close hide-on-med-and-up">close</i>
    </li>
    <li class="hide-on-med-and-up"><div class="divider"></div></li>
    <li class="hide-on-med-and-up"><a class="subheader">Conta</a></li>
    <li class="hide-on-med-and-up">
      <div class="info-user valign-wrapper">
        <i class="material-icons">account_circle</i>
        <div>
          <span><?php echo $_SESSION['nome']?></span>
          <br>
          <span>
            <?php 
              $telefone = $_SESSION['telefone'];
              $telefone = substr_replace($telefone, '(', 0, 0);
              $telefone = substr_replace($telefone, ')', 3, 0);
              $telefone = substr_replace($telefone, ' ', 4, 0);
              $telefone = substr_replace($telefone, '-', 10, 0);
              echo $telefone;
            ?>
          </span>
        </div>
      </div>
    </li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Acesso Rápido</a></li>
    <li><a href="/tcc/veiculos.php" class="waves-effect"><i class="material-icons">add</i>Reservas</a></li>
    <li><a href="/tcc/historico.php" class="waves-effect"><i class="material-icons">history</i>Histórico</a></li>
    <?php if ($_SESSION['tipo'] === "A") { ?>
      <li><div class="divider"></div></li>
      <li><a class="subheader">Admin</a></li>
      <li><a href="/tcc/admin/usuarios.php" class="waves-effect"><i class="material-icons">person</i>Usuários</a></li>
      <li><a href="/tcc/admin/veiculos.php" class="waves-effect"><i class="material-icons">local_shipping</i>Veículos</a></li>
      <li><a href="/tcc/admin/departamentos.php" class="waves-effect"><i class="material-icons">business</i>Departamentos</a></li>
    <?php } ?>
  </div>
  <div class="hide-on-med-and-up">
    <li><a href="/tcc/config/sair.php"><i class="material-icons">logout</i>Sair</a></li>
  </div>
</ul>

<!-- Dropdown -->
<ul id="nav-dropdown" class="dropdown-content">
  <li>
    <a href="/tcc/config/sair.php"><i class="material-icons left">logout</i>Sair</a>
  </li>
</ul>

<script>
$(document).ready(function(){
  $('.sidenav').sidenav();
  $('.dropdown-trigger').dropdown();
});
</script>