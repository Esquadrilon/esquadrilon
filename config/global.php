<?php

function Query($sql, $params = array()) {
  $conn = new MySQLi("localhost", "root", "local13@", "estoque", 3306);

  if ($conn->connect_errno) {
    print "<script>alert('Erro ao conectar no banco de dados MySQL!')</script>";
    return false;
  }

  try {
    $stmt = $conn->prepare($sql);

    // Vincular os parâmetros, se houver algum
    if ($params) {
      foreach ($params as &$value) {
        if ($value === '') {
          $value = null;
        }
      }
      
      $types = str_repeat('s', count($params)); // Assume que todos os parâmetros são strings
      $stmt->bind_param($types, ...$params);
    }
    echo $sql;
    echo "<br>";
    print_r($params);
    echo "<br>";
    print_r($stmt);
    echo "<br>";
 
    $stmt->execute();

    $result = $stmt->get_result();
    
    $data = null;
    $num_rows = null;
    // Verifica se a consulta é um SELECT antes de usar get_result
    if ($stmt->field_count > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
      $num_rows = $result->num_rows;
    } 

    print_r($result);
    echo "<br>";
    
    echo "<br> Data: ";
    print_r($data);

    echo "<br> Num Rows: ";
    print_r($num_rows);

    echo "<br>";

    $res = array(
      'data' => $data,
      'num_rows' => $num_rows,
    );

    $stmt->close();
  } catch (Exception $error) {
    // Redirect('./index.php', false, "Error!");
    return false;
  }
  
  return $res;
}


function Redirect($url, $success, $message) {
  $redirect = $url;

  if(isset($message)){
    // Se houver mensagem adiciona o parâmetros à URL de redirecionamento
    $redirect = $url . '?' . ($success ? 'success' : 'error') . '=' . $message;
  }

  if (!$success) {
    // Exibe um alerta JavaScript com a mensagem de erro
    echo "<script>alert('Erro: " . htmlspecialchars($message) . "');</script>";
  }

  // Redirecionar para a nova URL
  echo "<script>window.location.href = '" . $redirect . "';</script>";
}

?>