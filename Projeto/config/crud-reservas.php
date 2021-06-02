<?php
  include "./conexao.php";

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $option = "SELECT ALL";
  } else {
    $option = $_POST["option"];
  }

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

      $query = "INSERT INTO reserva (data_saida, data_retorno, status_reserva, destino, condutor, motivo, fk_id_departamento, fk_id_usuario, fk_id_veiculo) VALUES ('$dataSaida', '$dataRetorno', 'A', '$destino', '$condutor', '$motivo', '$departamento', '$usuario', '$veiculo');";
      mysqli_query($conn, $query);

      $query = "SELECT * FROM reserva JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo JOIN usuario ON reserva.fk_id_usuario = usuario.id_usuario JOIN departamento ON reserva.fk_id_departamento = departamento.id_departamento ORDER BY id_reserva DESC LIMIT 1";
      $res = mysqli_query($conn, $query);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
      break;
    case "SELECT ALL":
      $sql = "SELECT id_reserva, data_saida, data_retorno, destino, condutor, motivo, departamento, nome, modelo, data_saida_real, data_retorno_real, km_saida, km_retorno FROM reserva JOIN usuario ON reserva.fk_id_usuario = usuario.id_usuario JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo JOIN departamento ON reserva.fk_id_departamento = departamento.id_departamento";
      $res = mysqli_query($conn, $sql);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
      break;
    case "SELECT ONE":
      $id = $_POST["id"];

      $sql = "SELECT * FROM reserva WHERE id_reserva = $id";
      $res = mysqli_query($conn, $sql);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
      break;
    case "UPDATE":
      $id = $_POST["id"];
      $dataSaida = $_POST["dataSaida"] . " " . $_POST["horarioSaida"] . ":00";
      $dataRetorno = $_POST["dataRetorno"] . " " . $_POST["horarioRetorno"] . ":00";
      $destino = $_POST["destino"];
      $condutor = $_POST["condutor"];
      $motivo = $_POST["motivo"];
      $departamento = $_POST["departamento"];
      $usuario = $_POST["responsavel"];
      $veiculo = $_POST["veiculo"];

      $sql = "UPDATE reserva SET data_saida = '$dataSaida', data_retorno = '$dataRetorno', destino = '$destino', condutor = '$condutor', motivo = '$motivo', fk_id_departamento = '$departamento', fk_id_veiculo = '$veiculo' WHERE id_reserva = $id";
      mysqli_query($conn, $sql);

      $query = "SELECT * FROM reserva JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo JOIN usuario ON reserva.fk_id_usuario = usuario.id_usuario JOIN departamento ON reserva.fk_id_departamento = departamento.id_departamento WHERE id_reserva = $id";
      $res = mysqli_query($conn, $query);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
      break;
    case "DELETE":
      $id = $_POST["id"];

      $query = "SELECT * FROM reserva WHERE id_reserva = $id";
      $res = mysqli_query($conn, $query);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);

      mysqli_query($conn, "DELETE FROM reserva WHERE id_reserva = $id");
      break;
    case "RETIRAR":
      $km = $_POST["km"];
      $data_saida_real = $_POST["data"];
      $id = $_POST["id"];

      mysqli_query($conn, "UPDATE reserva SET km_saida = '$km', data_saida_real = '$data_saida_real' WHERE id_reserva = $id");

      $query = "SELECT * FROM reserva JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo JOIN usuario ON reserva.fk_id_usuario = usuario.id_usuario JOIN departamento ON reserva.fk_id_departamento = departamento.id_departamento WHERE id_reserva = $id";
      $res = mysqli_query($conn, $query);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);

      break;
    case "ENTREGAR":
      $km = $_POST["km"];
      $data_retorno_real = $_POST["data"];
      $id = $_POST["id"];

      mysqli_query($conn, "UPDATE reserva SET km_retorno = '$km', data_retorno_real = '$data_retorno_real' WHERE id_reserva = $id");

      $query = "SELECT * FROM reserva JOIN veiculo ON reserva.fk_id_veiculo = veiculo.id_veiculo JOIN usuario ON reserva.fk_id_usuario = usuario.id_usuario JOIN departamento ON reserva.fk_id_departamento = departamento.id_departamento WHERE id_reserva = $id";
      $res = mysqli_query($conn, $query);
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
      break;
  }

  print json_encode($data);
  mysqli_close($conn);
?>