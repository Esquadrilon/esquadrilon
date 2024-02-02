<?php
  include_once('../config/global.php');

  $inputs = array(
    'os',
    'obra_id',
    'previsto',
    'tipologia',
    'tipo',
    'lote',
    'lugar',
    'pecas',
    'pecas_feitas',
    'peso',
    'perfil',
    'componente',
    'esteira',
    'vidro',
    'corte',
    'usinagem',
    'montagem',
    'observacoes'
  );

  foreach ($inputs as $input) {
    isset($_POST[$input])
      ? ${$input} = $_POST[$input]
      : ${$input} = null;
  };

  switch ($_REQUEST["action"]) {
    case 'register':
      $data = array(
        'os' => $os,
        'obra_id' => $obra_id,
        'tipologia' => $tipologia,
        'tipo' => $tipo,
        'lote' => $lote,
        'lugar' => $lugar,
        'pecas' => $pecas,
        'peso' => $peso,
        'previsto' => $previsto
      );

      CadastrarOs($data);

      $message = "Ordem de Serviço cadastrada com sucesso!";
      break;

    case 'update':
      $data = array(
        'pecas' => $pecas,
        'pecas_feitas' => $pecas_feitas,
        'peso' => $peso,
        'previsto' => $previsto,
        'observacoes' => $observacoes,
        'perfil' => $perfil,
        'componente' => $componente,
        'esteira' => $esteira,
        'vidro' => $vidro,
        'corte' => $corte,
        'usinagem' => $usinagem,
        'montagem' => $montagem
      );

      AtualizarOs($_GET['os'], $data);
      break;

    case 'delete':
      DeletarOs($_GET['os']);
      break;
    
    default:
      Redirect("./index", false, "Ação desconhecida");
  }

  function CadastrarOs($data) {
    try {
      // Buscar o numero da O.S, para ver se ja existe no sistema
      $search = Query("SELECT * FROM estoque.processos WHERE id = ?", array($data['os']));

      if($search['num_rows'] > 0) {
        // se existir algum cadastro, redireciona para o seguinte erro
        throw new Exception("Já existe uma Ordem de Serviço cadastrada com esse número ({$data['os']})!");
      }

      // SQL para cadastrar a O.S
      $sqlOs = "INSERT INTO estoque.processos
        (id, obra_id, tipologia, tipo, lote, lugar, pecas, peso, previsto)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $paramsOs = array($data['os'], $data['obra_id'], $data['tipologia'], $data['tipo'], $data['lote'], $data['lugar'], $data['pecas'],  $data['peso'], $data['previsto']);

      Query($sqlOs, $paramsOs);

      $message = "Ordem de Serviço ({$data['os']}) foi cadastrada com sucesso!";

    } catch (Exception $error) {
      $message = $error
        ? $error->getMessage() 
        : "Ocorreu um erro ao tentar cadastrar Ordem de Serviço ({$data['os']}).";
      Redirect('./index.php', false, $message);
    }
    
    Redirect('./index.php', true, $message);
  }

  function AtualizarOs($os, $data) {
    try {
      // busca o numero da O.S, para ver se ela existe
      $searchOs = Query("SELECT * FROM estoque.processos WHERE id = ?", array($os));
      echo "<br> -------------- <br>";
      echo "Buscando Os... <br>";
      echo "<br> -------------- <br>";

      if($searchOs['num_rows'] < 0) {
        // se não existir redireciona para o seguinte erro
        echo "<br> -------------- <br>";
        echo "Os nao encontrada <br>";
        echo "<br> -------------- <br>";
        throw new Exception("Ocorreu um erro ao buscar a Ordem de Serviço ({$os})!");
      }

      // SQL para atualizar a O.S
      echo "<br> -------------- <br>";
      echo "Atualizando Os...";
      echo "<br> -------------- <br>";
      $sqlOs = "UPDATE estoque.processos
        SET pecas=?, pecas_feitas=?, peso=?, observacoes=?, previsto=?
        WHERE id = ?";

      $paramsOs = array($data['pecas'], $data['pecas_feitas'], $data['peso'], $data['observacoes'], $data['previsto'], $os);

      $reqOs = Query($sqlOs, $paramsOs);
      
      // busca as datas da O.S, para ver se ela existe
      $searchData = Query("SELECT * FROM estoque.datas_processo WHERE processo_id = ?", array($os));

      if($searchData['num_rows'] > 0) {
        echo "<br> -------------- <br>";
        echo "Atualizando Datas da OS...";
        echo "<br> -------------- <br>";
        // se existir executa o SQL para atualizar as datas da O.S
        $sqlData = "UPDATE estoque.datas_processo
        SET perfil=?, componente=?, esteira=?, vidro=?, corte=?, usinagem=?, montagem=?
        WHERE processo_id=?";

        $paramsData = array($data['perfil'], $data['componente'], $data['esteira'], $data['vidro'], $data['corte'], $data['usinagem'], $data['montagem'], $os);

        $reqData = Query($sqlData, $paramsData);
      } else {
        echo "<br> -------------- <br>";
        echo "Inserindo Datas na OS...";
        echo "<br> -------------- <br>";
        // se não existir executa o SQL para inserir as datas da O.S
        $sqlData = "INSERT INTO estoque.datas_processo
        (processo_id, perfil, componente, esteira, vidro, corte, usinagem, montagem)
        VALUES( ?, ?, ?, ?, ?, ?, ?, ?)";

        $paramsData = array($os, $data['perfil'], $data['componente'], $data['esteira'], $data['vidro'], $data['corte'], $data['usinagem'], $data['montagem']);
        $reqData = Query($sqlData, $paramsData);
      }

      $message = "Ordem de Serviço ({$os}) foi atualizada com sucesso!";

    } catch (Exception $error) {
      $message = $error
        ? $error 
        : "Erro ao tentar atualizar Ordem de Serviço";

        Redirect('./index.php', false, $message); 
      }

      Redirect('./index.php', true, $message); 
  }

  function DeletarOs($os) {
    try {
      echo "Numero da OS: " . $os;
      // busca o numero da O.S, para ver se ela existe
      $search = Query("SELECT id FROM estoque.processos WHERE id = ?", array($os));

      if($search['num_rows'] <= 0) {
        // se não existir redireciona para o seguinte erro
        throw new Exception("Erro ao buscar Ordem de Serviço ({$os})!");
      }

      $searchData = Query("SELECT * FROM estoque.datas_processo WHERE processo_id = ?", array($os));

      if($searchData['num_rows'] > 0) {
        Query("DELETE FROM estoque.datas_processo WHERE processo_id = ?", array($os));
      }

      // SQL para deletar a O.S
      $req = Query("DELETE FROM estoque.processos WHERE id= ?", array($os));

      $message = "Ordem de Serviço ({$os}) foi deletada com sucesso!";
      
    } catch (Exception $error) {
      $message = $error
        ? $error->getMessage()
        : "Erro ao tentar deletar Ordem de Serviço";

        Redirect('./index.php', false, $message); 
      }
      
      Redirect('./index.php', true, $message); 
  }

?>
