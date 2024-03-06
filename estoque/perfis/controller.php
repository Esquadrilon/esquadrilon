<?php
  include_once('../../config/global.php');

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

  $sqlData = array(
    'codigo' => $codigo,
    'descricao' => $descricao,
    'peso' => $peso,
    'nativo' => $nativo,
    'linha' => $linha,
    'referencia' => $referencia
  );

  switch ($_REQUEST["action"]) {
    case 'register':
      CadastrarPerfil($sqlData);
      break;

    case 'update':
      
      AtualizarPerfil($_REQUEST['perfil'], $sqlData);
      break;
      
    case 'delete':
      DeletarPerfil($_REQUEST['perfil']);
      break;

    default:
      Redirect("./index", false, "Ocorreu um erro, ação desconhecida");
  }

  function CadastrarPerfil($data) {
    try{
      // SQL para cadastrar o perfil
      $sql = "INSERT INTO perfis 
      (codigo, descricao, peso, nativo, linha, referencia) 
      VALUES (?, ?, ?, ?, ?', ?)";

      // Parametros para inserir no SQL
      $params = array($data['codigo'], $data['descricao'], $data['peso'], $data['nativo'], $data['linha'], $data['referencia']);

      // Executa o SQL
      Query($sql, $params);

      // Define a mensagem de sucesso
      $message = "Perfil ({$data['codigo']}) foi cadastrado com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage() 
        : "Ocorreu um erro ao tentar cadastrar perfil ({$data['codigo']}).";

      // Redireciona para a pagina de listagem, alertando o erro
      Redirect('./index.php', false, $message);
    }
    
    // Redireciona para a pagina de listagem
    Redirect('./index.php', true, $message);
  }

  function AtualizarPerfil($codigo, $data) {
    try{
      // Busca o perfil
      $search = Query("SELECT * FROM estoque.perfis WHERE codigo = ?", array($codigo));
      echo "<br>--------------<br>Buscando perfil... <br>--------------<br>";

      if($search['num_rows'] <= 0) {
        // se não existir redireciona para o seguinte erro
        echo "<br>--------------<br>Perfil não foi encontrado... <br>--------------<br>";
        throw new Exception("Ocorreu um erro ao buscar perfil ({$codigo})!");
      }
      
      // SQL para atualizar o perfil
      $sql = "UPDATE estoque.perfis 
      SET descricao=?, peso=?, nativo=?, linha=?, referencia=? WHERE codigo=?";

      // Parametros para inserir no SQL
      $params = array($data['descricao'], $data['peso'], $data['nativo'], $data['linha'], $data['referencia'], $codigo);

      // Executa o SQL
      Query($sql, $params);

      // Define a mensagem de sucesso
      $message = "Perfil ({$codigo) foi atualizado com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage() 
        : "Ocorreu um erro ao tentar atualizar perfil ({$codigo}).";

      // Redireciona para a pagina de listagem, alertando o erro
      Redirect('./index.php', false, $message);
    }
    
    // Redireciona para a pagina de listagem
    Redirect('./index.php', true, $message);
  }

  function DeletarPerfil($codigo) {
    try {
      echo "Codigo do perfil: " . $codigo;
      // busca o codigo do perfil, para ver se ela existe
      $search = Query("SELECT codigo FROM estoque.perfis WHERE codigo=?", array($codigo));

      if($search['num_rows'] <= 0) {
        // se não existir redireciona para o seguinte erro
        throw new Exception("Erro ao buscar perfil ({$codigo})!");
      }

      // SQL para deletar o perfil
      $req = Query("DELETE FROM estoque.perfis WHERE codigo=?", array($codigo));

      // Define a mensagem de sucesso
      $message = "Perfil deletado com sucesso!";
    } catch (Exception $error) {
      // Define a mensagem de erro
      $message = $error
        ? $error->getMessage()
        : "Erro ao tentar deletar perfil";

        // Redireciona para a pagina de listagem, alertando o erro
        Redirect('./index.php', false, $message); 
      }
      
      // Redireciona para a pagina de listagem
      Redirect('./index.php', true, $message); 
  }

?>