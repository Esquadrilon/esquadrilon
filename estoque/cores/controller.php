<?php
include_once('../../config/db/connection.php');

$data = array(
  'nome',
  'codigo'
);

foreach ($data as $input_name) {
  isset($_POST[$input_name])
    ? ${$input_name} = $_POST[$input_name]
    : ${$input_name} = "";
};

$redirect_success = "./index.php";
$redirect_error = "./index.php";

try {
  switch ($_REQUEST["acao"]) {
    case 'cadastrar':
      $sql = "INSERT INTO cores (nome, codigo) VALUES ('$nome', '$codigo')";

      $res = $conn->query($sql);

      $redirect_error = "./create.php";
      $success_message = "Cor cadastrada com sucesso!";
      $error_message = "Erro ao tentar cadastrar cor!";
      break;

    case 'editar':
      $sql = "UPDATE cores SET nome = '$nome', codigo = '$codigo' WHERE id = $_REQUEST[id]";

      $res = $conn->query($sql);

      $redirect_error = "./update.php?id={$_REQUEST['id']}";
      $success_message = "Cor editada com sucesso!";
      $error_message = "Erro ao tentar editar cor!";
      break;

    case 'deletar':
      if (isset($_REQUEST['id'])) {
        $sql = "DELETE FROM cores WHERE id = $_REQUEST[id]";
        
        $res = $conn->query($sql);
        
        $success_message = "Cor deletada com sucesso!";
        $error_message = "Erro ao tentar deletar cor!";
      }
      break;
  }

  $res === true
    ? print "<script>location.href = '$redirect_success?success_message=$success_message'</script>"
    : throw new Exception("Erro na consulta SQL: " . $conn->error);
    
} catch (Exception $e) {
  print "<script>alert('Erro: " . $e->getMessage() . "')</script>";
  print "<script>location.href = '$redirect_error?error_message=$error_message'</script>";
}