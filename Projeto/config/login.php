<?php
//Iniciar uma sessão
session_start();
include("./conexao.php");
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$query = mysqli_query($conn, "SELECT * FROM usuario WHERE cpf = '$cpf' AND senha = '$senha'") or die(mysqli_connect_error());
if (mysqli_num_rows($query) > 0) {
    $usuario = mysqli_fetch_array($query);
    $_SESSION['id'] = $usuario['id_usuario'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['cpf'] = $usuario['cpf'];
    $_SESSION["tipo"] = $usuario['tipo'];
    $_SESSION["status"] = "OK";
    echo $_SESSION['id'] . '<br>' . $_SESSION['nome'] . '<br>' . $_SESSION['cpf'] . '<br>' . $_SESSION["tipo"];
} else {
    echo 'usuario Invalido';
}
mysqli_close($conn);
?>