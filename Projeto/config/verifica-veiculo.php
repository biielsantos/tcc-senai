<?php

include ("conexao.php");
$data = '';
if(isset($_POST['validation'])){
	$validation = $_POST['validation'];
    $placa = $_POST['placa'];

    switch ($validation) {
        case 1:
            $ver = false;
            $query = "SELECT * FROM veiculo";
            $result = mysqli_query($conn, $query);
            while($veiculo = mysqli_fetch_array($result)){
                if($placa == $veiculo['placa']){
                    $ver = true;
                }
            }
        
            if($ver == true){
                $data = 'placa ja cadastrada';
            }else{
                $data = 'placa disponivel';
            }
            break;
        case 2:
            $ver_placa = $_POST['ver_placa'];
            $ver = false;
            $query = "SELECT * FROM veiculo WHERE placa != '$ver_placa'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0){
                while($veiculo = mysqli_fetch_array($result)){
                    if($placa == $veiculo['placa']){
                        $ver = true;
                    }
                }
            
                if($ver == true){
                    $data = 'placa ja cadastrada, Edit';
                }else if($placa == $ver_placa){
                    $data = 'Não Alterou o numero da Placa';
                }else{
                    $data = 'Placa disponivel, Edit';
                }
            }else{
                $data = 'Placa Disponivel';
            }
            break;
    }
}



print json_encode($data);
mysqli_close($conn);


?>