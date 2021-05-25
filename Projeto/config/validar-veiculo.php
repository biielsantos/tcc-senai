<?php
session_start();

if ($_SESSION["status"] != "ok") {
    header('location: ../index.php');
}

include ("conexao.php");

$validationOption = $_POST['validationOption'];

switch ($validationOption) {
    case "placa":
        $placa = $_POST['value'];
        $query = "SELECT * FROM veiculo WHERE placa = '$placa'";
        break;
}

$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
    $data = true;
}else{
    $data = false;
}

print json_encode($data);
mysqli_close($conn);


?>