<?php

include ("conexao.php");

if(isset($_POST['validation'])){
	$validation = $_POST['validation'];
    $placa = $_POST['placa'];

    switch ($validation) {
        case 1:
            $query = "SELECT * FROM veiculo WHERE placa = '$placa'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0){
                $data = 2; //Placa ja cadastrada
            }else{
                $data = 1; //Placa disponivel
            }
            break;
        case 2:
            $ver_placa = $_POST['ver_placa'];
            $ver = false;
            $query = "SELECT * FROM veiculo WHERE placa != '$ver_placa'";
            $result = mysqli_query($conn, $query);
            
                while($veiculo = mysqli_fetch_array($result)){
                    if($placa == $veiculo['placa']){
                        $ver = true;
                    }
                }
            
                if($ver == true){
                    $data = 2; //Placa ja cadastrada
                }else if($placa == $ver_placa){
                    $data = 3; //Não mudou
                }else{
                    $data = 1; //Placa disponivel
                }
            
            break;
    }
}



print json_encode($data);
mysqli_close($conn);


?>