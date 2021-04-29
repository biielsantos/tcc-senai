<?php
session_start();

if ($_SESSION["status"] != "ok") {
    header('location: ../index.php');
}

include ("conexao.php");

$validation_option = $_POST['validation_option'];

switch ($validation_option) {
    case "placa":
        $placa = $_POST['placa'];
        $placa_real = $_POST['placa_real'];
        $query = "SELECT * FROM veiculo WHERE placa = '$placa'";
        $result = mysqli_query($conn, $query);
        
        if($placa == $placa_real){
            $data = 3; //Não alterou
        }else if(mysqli_num_rows($result) > 0){
            $data = 2; //CPF ja Cadastrado
        }else{
            $data = 1; //CPF válido
        }
        break;
}



print json_encode($data);
mysqli_close($conn);


?>