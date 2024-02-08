<?php
  include_once('../../config/db/connection.php');

  $data = array(
    'romaneio',
    'observacoes',
    'obra',
    'perfil',
    'tamanho',
    'cor',
    'quantidade'
  );

  foreach ($data as $input_name) {
    ${$input_name} = isset($_POST[$input_name]) 
      ? $_POST[$input_name] 
      : [];
  }

  $data = [];

  $redirect_success = "./index.php";
  $redirect_error = "./index.php";
  $success_message = "Reserva cadastrada com sucesso!";
  $error_message = "Erro ao tentar cadastrar reserva!";

  
  try{
    switch ($_REQUEST["acao"]) {
      case 'cadastrar':
        if ($romaneio == null) {
          $error_message = "Você deve informar o romaneio, para poder reservar o material!";
          throw new Exception($error_message);
        }
        // valida e formata os dados... para inserir no banco de dados.
        for ($i = 0; $i < count($perfil); $i++) {
          $sql_obra = $conn->query("SELECT id FROM obras WHERE nome = '$obra[$i]'");
          $res_obra = $sql_obra->fetch_assoc();
          
          $sql_perfil = $conn->query("SELECT codigo FROM perfis WHERE codigo = '$perfil[$i]'");
          $res_perfil = $sql_perfil->fetch_assoc();
          
          $sql_cor = $conn->query("SELECT id FROM cores WHERE nome = '$cor[$i]'");
          $res_cor = $sql_cor->fetch_assoc();

          if($obra[$i] == null || $perfil[$i] == null || $tamanho[$i] == null || $cor[$i] == null){
            $error_message = 'Certifique se os campos necessários estão preenchidos corretamente. Nenhum dado foi cadastrado!';
            throw new Exception($error_message);
          };

          if($sql_obra === false || $sql_perfil === false || $sql_cor === false){
            $error_message = 'Alguns dos dados fornecidos não foram encontrados. Verifique se as informações estão corretas e tente novamente.  Nenhum dado foi cadastrado!';
            throw new Exception($error_message);
          }

          if($quantidade[$i] != null){
            $item = array(
              $res_obra['id'],
              $res_perfil['codigo'],
              $tamanho[$i],
              $res_cor['id'],
              $quantidade[$i]
            );
            echo json_encode($item) . "<br>";
            array_push($data, $item);
          }
        };

        $sql_reserva = "INSERT INTO reservas (id, observacoes) VALUES ('$romaneio', '$observacoes')";
        $conn->query($sql_reserva);

        foreach($data as $registro){
          $sql = 
          "INSERT INTO itens_reserva 
            (reserva_id, obra_id, perfil_codigo, tamanho, cor_id, quantidade)
          VALUES
            ('$romaneio', '$registro[0]',  '$registro[1]',  '$registro[2]',  '$registro[3]',  '$registro[4]')
          ";

          $res = $conn->query($sql);
        }
        break;

      case 'editar':
      
        $success_message = "Reserva editada com sucesso!";
        $error_message = "Erro ao tentar editar reserva!";
        break;

      case 'deletar':
        if (isset($_REQUEST['id'])) {
          $conn->query("DELETE FROM itens_reserva WHERE reserva_id = $_REQUEST[id]");
          $res = $conn->query("DELETE FROM reservas WHERE id = $_REQUEST[id]");
          
        }

        $success_message = "Reserva deletada com sucesso!";
        $error_message = "Erro ao tentar deletar reserva!";
        break;
      case 'deletar_item':
        $res = (isset($_REQUEST['id']))
          ? $conn->query("DELETE FROM itens_reserva WHERE id = $_REQUEST[id]")
          : false;

        $success_message = "Item da reserva deletado com sucesso!";
        $error_message = "Erro ao tentar deletar item da reserva!";
        break;
      case 'separar': 
        $reserva = $_REQUEST['reserva'];
        $destino = isset($_POST['destino']) ? $_POST['destino'] : "";
        $caminhao = isset($_POST['caminhao']) ? $_POST['caminhao'] : "";
        $motorista = isset($_POST['motorista']) ? $_POST['motorista'] : "";
        $responsavel = isset($_POST['responsavel']) ? $_POST['responsavel'] : "";
        $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : "";

        $data = $conn->query("SELECT * FROM itens_reserva WHERE reserva_id = $reserva")->fetch_all(MYSQLI_ASSOC);

        foreach($data as $item){
          $sql = 
          "INSERT INTO saidas 
            (obra_id, perfil_codigo, cor_id, tamanho, quantidade, romaneio, destino, caminhao, motorista, responsavel, observacoes)
          VALUES
            ('{$item["obra_id"]}', '{$item["perfil_codigo"]}', '{$item["cor_id"]}', '{$item["tamanho"]}', '{$item["quantidade"]}', '$reserva', '$destino', '$caminhao', '$motorista', '$responsavel', '$observacoes')";

          echo json_encode($item) . "<br>" . $sql . "<br><br><br>";

          $conn->query($sql);
        }

        $conn->query("DELETE FROM itens_reserva WHERE reserva_id = $reserva");
        $conn->query("DELETE FROM reservas WHERE id = $reserva");

        $res = true;
        
        $success_message = "Reserva separada com sucesso!";
        $error_message = "Erro ao tentar separar reserva!";
        break;
    }

    $res === true
    ? print "<script>location.href = '$redirect_success?success_message=$success_message'</script>"
    : throw new Exception("Erro na consulta SQL: " . $conn->error);
    
  } catch (Exception $e) {
    print "<script>alert('Erro: " . $e->getMessage() . "')</script>";
    print "<script>location.href = '$redirect_error?error_message=$error_message '</script>";
  }
?>