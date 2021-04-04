<?php
session_start();
?>

<nav>
  <div class="nav-wrapper" style="padding: 0 1rem;">
    <a href="#" data-target="slide-out" class="sidenav-trigger show-on-large"><i class="material-icons" style="font-size: 32px;">menu</i></a>
    <i class="material-icons" style="font-size: 32px;">account_circle</i>
  </div>
</nav>

<ul id="slide-out" class="sidenav" style="display: flex; flex-direction: column; justify-content: space-between; padding-top: 1rem;">
  <div>
    <li class="center">
      <i class="material-icons" style="font-size: 4rem;">directions_car</i>
    </li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Acesso Rápido</a></li>
    <li><a href="/tcc/veiculos.php" class="waves-effect"><i class="material-icons"">add</i>Reservar Veículo</a></li>
    <li><a href="/tcc/historico.php" class="waves-effect"><i class="material-icons"">history</i>Histórico</a></li>
    <?php if ($_SESSION['tipo'] === "A") { ?>
      <li><div class="divider"></div></li>
      <li><a class="subheader">Admin</a></li>
      <li><a href="/tcc/admin/usuarios.php" class="waves-effect"><i class="material-icons"">account_circle</i>Usuários</a></li>
      <li><a href="/tcc/admin/veiculos.php" class="waves-effect"><i class="material-icons"">local_shipping</i>Veículos</a></li>
    <?php } ?>
  </div>
  <div>
    <li><a href="/tcc/config/sair.php"><i class="material-icons">logout</i>Sair</a></li>
  </div>
</ul>

<script>
$(document).ready(function(){
  $('.sidenav').sidenav();
});
</script>