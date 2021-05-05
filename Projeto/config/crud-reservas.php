<?php
  include "./conexao.php";

  $option = $_POST["option"];

  switch ($option) {
    case "CREATE":
      $dataSaida = $_POST["dataSaida"] . " " . $_POST["horarioSaida"] . ":00";
      $dataRetorno = $_POST["dataRetorno"] . " " . $_POST["horarioRetorno"] . ":00";
      $destino = $_POST["destino"];
      $condutor = $_POST["condutor"];
      $motivo = $_POST["motivo"];
      $departamento = $_POST["departamento"];
      $usuario = $_POST["responsavel"];
      $veiculo = $_POST["veiculo"];

      $query = "INSERT INTO reserva (data_saida, data_retorno, status_reserva, destino, condutor, motivo, departamento, fk_id_usuario, fk_id_veiculo) VALUES ('$dataSaida', '$dataRetorno', 'A', '$destino', '$condutor', '$motivo', '$departamento', '$usuario', '$veiculo');";
      mysqli_query($conn, $query);

      $query = "SELECT id_reserva, data_saida, data_retorno, status_reserva, destino, condutor, motivo, reserva.departamento AS departamento, nome, modelo FROM reserva JOIN usuario ON reserva.fk_id_usuario = usuario.id_usuario JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo";
      $res = mysqli_query($conn, $query);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
      break;
    case "SELECT ALL":
      $sql = "SELECT id_reserva, data_saida, data_retorno, status_reserva, destino, condutor, motivo, reserva.departamento AS departamento, nome, modelo FROM reserva JOIN usuario ON reserva.fk_id_usuario = usuario.id_usuario JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo";
      $res = mysqli_query($conn, $sql);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
      break;
  }

  print json_encode($data);
  mysqli_close($conn);
?>