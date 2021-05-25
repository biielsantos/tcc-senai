<?php

include ("conexao.php");

$validationOption = $_POST['validationOption'];

switch ($validationOption) {
    case 'cpf':
        $cpf = $_POST['value'];
        $query = "SELECT * FROM usuario WHERE cpf = '$cpf'";
    break;
    case 'cnh':
        $cnh = $_POST['value'];
        $query = "SELECT * FROM usuario WHERE cnh = '$cnh'";
    break;
    case 'telefone':
        $telefone = $_POST['value'];
        $query = "SELECT * FROM usuario WHERE telefone = '$telefone'";
    break;
}
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
    $data = true; //Ja Cadastrado
}else{
    $data = false; //Não cadastrado
}
print json_encode($data);
mysqli_close($conn);
?>
