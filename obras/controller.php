<?php
  include_once('../config/global.php');

  $data = array(
    'nome',
    'situacao',
    'cliente_id',
    'endereco',
    'cidade_id',
    'estado_id',
    'cep',
    'observacoes'
  );

  foreach ($data as $input_name) {
    isset($_POST[$input_name])
      ? ${$input_name} = $_POST[$input_name]
      : ${$input_name} = null;
  };

  $sqlData = array(
    'nome' => $nome,
    'situacao' => $situacao,
    'cliente' => $cliente_id,
    'endereco' => $endereco,
    'cidade' => $cidade_id,
    'estado' => $estado_id,
    'cep' => $cep,
    'observacoes' => $observacoes
  );

  switch ($_REQUEST["action"]) {
    case 'register':
      CadastrarObra($sqlData);
      break;

    case 'update':
      AtualizarObra($_REQUEST['id'], $sqlData);
      break;

    case 'delete':
      DeletarObra($_REQUEST['id']);
      break;

    default:
      Redirect("./index", false, "Ocorreu um erro ação desconhecida");
  }

  function CadastrarObra($data) {
    try{
      // SQL para cadastrar a obra
      $sql = "INSERT INTO estoque.obras 
      (nome, situacao, cliente_id, endereco, cidade_id, estado_id, cep, observacoes) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

      // Parametros para inserir no SQL
      $params = array($data['nome'], $data['situacao'], $data['cliente'], $data['endereco'], $data['cidade'], $data['estado'], $data['cep'], $data['observacoes']);

      // Executa o SQL
      Query($sql, $params);

      // Define a mensagem de sucesso
      $message = "Obra ({$data['nome']}) foi cadastrada com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage() 
        : "Ocorreu um erro ao tentar cadastrar Obra ({$data['nome']}).";

      // Redireciona para a pagina de listagem, alertando o erro
      Redirect('./index.php', false, $message);
    }
    
    // Redireciona para a pagina de listagem
    Redirect('./index.php', true, $message);
  }

  function AtualizarObra($id, $data) {
    try{
      // Busca a obra
      $search = Query("SELECT * FROM estoque.obras WHERE id = ?", array($id));
      echo "<br> -------------- <br>";
      echo "Buscando Obra... <br>";
      echo "<br> -------------- <br>";

      if($search['num_rows'] <= 0) {
        // se não existir redireciona para o seguinte erro
        echo "<br> -------------- <br>";
        echo "Obra não foi encontrada <br>";
        echo "<br> -------------- <br>";
        throw new Exception("Ocorreu um erro ao buscar a obra ({$data['nome']})!");
      }

      // SQL para atualizar a obra
      $sql = "UPDATE estoque.obras 
      SET nome=?, situacao=?, cliente_id=?, endereco=?, cidade_id=?, estado_id=?, cep=?, observacoes=? WHERE  id=?";

      // Parametros para inserir no SQL
      $params = array($data['nome'], $data['situacao'], $data['cliente'], $data['endereco'], $data['cidade'], $data['estado'], $data['cep'], $data['observacoes'], $id);

      // Executa o SQL
      Query($sql, $params);

      // Define a mensagem de sucesso
      $message = "Obra ({$data['nome']}) foi atualizada com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage() 
        : "Ocorreu um erro ao tentar atualizar Obra ({$data['nome']}).";

      // Redireciona para a pagina de listagem, alertando o erro
      Redirect('./index.php', false, $message);
    }
    
    // Redireciona para a pagina de listagem
    Redirect('./index.php', true, $message);
  }
    
  function DeletarObra($id) {
    try {
      echo "ID da obra: " . $id;
      // busca o id da obra, para ver se ela existe
      $search = Query("SELECT id FROM estoque.obras WHERE id=?", array($id));

      if($search['num_rows'] <= 0) {
        // se não existir redireciona para o seguinte erro
        throw new Exception("Erro ao buscar obra ({$id})!");
      }

      // SQL para deletar obra
      $req = Query("DELETE FROM estoque.obras WHERE id=?", array($id));

      // Define a mensagem de sucesso
      $message = "Obra foi deletada com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage()
        : "Erro ao tentar deletar obra";

        // Redireciona para a pagina de listagem, alertando o erro
        Redirect('./index.php', false, $message); 
      }
      
      // Redireciona para a pagina de listagem
      Redirect('./index.php', true, $message); 
  }

?>