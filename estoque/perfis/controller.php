<?php
include_once('../../config/db/connection.php');

$data = array(
  'codigo',
  'descricao',
  'peso',
  'nativo',
  'linha',
  'referencia',
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
      $sql = "INSERT INTO perfis (codigo, descricao, peso, nativo, linha, referencia) VALUES ('$codigo', '$descricao', '$peso', '$nativo', '$linha', '$referencia')";
      
      $res = $conn->query($sql);

      $redirect_error = "./create.php";
      $success_message = "Perfil cadastrado com sucesso!";
      $error_message = "Erro ao tentar cadastrar perfil!";
      break;

    case 'editar':
      $sql = "UPDATE perfis SET descricao = '$descricao', peso = '$peso', nativo = '$nativo', linha = '$linha', referencia = '$referencia' WHERE codigo = '$codigo'";

      $res = $conn->query($sql);

      $success_message = "Perfil editado com sucesso!";
      $error_message = "Erro ao tentar editar perfil!";
      break;
      
    case 'deletar':
      if (isset($_REQUEST['perfil'])) {
        $sql = "DELETE FROM perfis WHERE codigo = '{$_REQUEST['perfil']}'";

        $res = $conn->query($sql);

        $success_message = "Perfil deletado com sucesso!";
        $error_message = "Erro ao tentar deletar perfil!";
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