<?php
  include_once('../config/global.php');

  $data = array(
    'nome',
    'email',
    'telefone',
    'cpf_cnpj',
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
    'email' => $email,
    'telefone' => $telefone,
    'cpf_cnpj' => $cpf_cnpj,
    'endereco' => $endereco,
    'cidade' => $cidade_id,
    'estado' => $estado_id,
    'cep' => $cep,
    'observacoes' => $observacoes
  );

  switch ($_REQUEST["action"]) {
    case 'register':
      CadastrarCliente($sqlData);
      break;

    case 'update':
      AtualizarCliente($_REQUEST['id'], $sqlData);
      break;

    case 'delete':
      DeletarCliente($_REQUEST['id']);
      break;

    default:
      Redirect("./index", false, "Ocorreu um erro, ação desconhecida");
  }

  function CadastrarCliente($data) {
    try{
      // SQL para cadastrar o cliente
      $sql = "INSERT INTO clientes 
      (nome, email, telefone, cpf_cnpj, endereco, cidade_id, estado_id, cep, observacoes) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

      // Parametros para inserir no SQL
      $params = array($data['nome'], $data['email'], $data['telefone'], $data['cpf_cnpj'], $data['endereco'], $data['cidade'], $data['estado'], $data['cep'], $data['observacoes']);

      // Executa o SQL
      Query($sql, $params);

      // Define a mensagem de sucesso
      $message = "Cliente ({$data['nome']}) foi cadastrado com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage() 
        : "Ocorreu um erro ao tentar cadastrar cliente ({$data['nome']}).";

      // Redireciona para a pagina de listagem, alertando o erro
      Redirect('./index.php', false, $message);
    }
    
    // Redireciona para a pagina de listagem
    Redirect('./index.php', true, $message);
  }

  function AtualizarCliente($id, $data) {
    try{
      // Busca o cliente
      $search = Query("SELECT * FROM estoque.clientes WHERE id = ?", array($id));
      echo "<br>--------------<br>Buscando cliente... <br>--------------<br>";

      if($search['num_rows'] <= 0) {
        // se não existir redireciona para o seguinte erro
        echo "<br>--------------<br>cliente não foi encontrado... <br>--------------<br>";
        throw new Exception("Ocorreu um erro ao buscar cliente ({$data['nome']})!");
      }
      
      // SQL para atualizar o cliente
      $sql = "UPDATE clientes 
      SET nome=?, email=?, telefone=?, cpf_cnpj=?, endereco=?, cidade_id=?, estado_id=?, cep=?, observacoes=? WHERE  id=?";

      // Parametros para inserir no SQL
      $params = array($data['nome'], $data['email'], $data['telefone'], $data['cpf_cnpj'], $data['endereco'], $data['cidade'], $data['estado'], $data['cep'], $data['observacoes'], $id);

      // Executa o SQL
      Query($sql, $params);

      // Define a mensagem de sucesso
      $message = "Cliente ({$data['nome']}) foi atualizado com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage() 
        : "Ocorreu um erro ao tentar atualizar cliente ({$data['nome']}).";

      // Redireciona para a pagina de listagem, alertando o erro
      Redirect('./index.php', false, $message);
    }
    
    // Redireciona para a pagina de listagem
    Redirect('./index.php', true, $message);
  }

  function DeletarCliente($id) {
    try {
      echo "ID do cliente: " . $id;
      // busca o id do cliente, para ver se ela existe
      $search = Query("SELECT id FROM estoque.clientes WHERE id=?", array($id));

      if($search['num_rows'] <= 0) {
        // se não existir redireciona para o seguinte erro
        throw new Exception("Erro ao buscar cliente ({$id})!");
      }

      // SQL para deletar o cliente
      $req = Query("DELETE FROM estoque.clientes WHERE id=?", array($id));

      // Define a mensagem de sucesso
      $message = "Cliente deletado com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage()
        : "Erro ao tentar deletar cliente";

        // Redireciona para a pagina de listagem, alertando o erro
        Redirect('./index.php', false, $message); 
      }
      
      // Redireciona para a pagina de listagem
      Redirect('./index.php', true, $message); 
  }
?>