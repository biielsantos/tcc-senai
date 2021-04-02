<?php
$servername = "localhost";
$database = "reserva_veiculo";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $database);

if (!$conn) {
  die(mysqli_connect_error());
}
?>