<?php

include ("conexao.php");

$validation_option = $_POST['validation_option'];

switch ($validation_option) {
    case "cpf":
        $cpf = $_POST['cpf'];
        $cpf_real = $_POST['cpf_real'];
        $query = "SELECT * FROM usuario WHERE cpf = '$cpf'";
        $result = mysqli_query($conn, $query);
        
        if($cpf == $cpf_real){
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