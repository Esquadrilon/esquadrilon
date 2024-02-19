<?php
  include_once('../config/db/connection.php');

  $data = array(
    'os',
    'obra_id',
    'tipo',
    'previsto',
    'peso',
    'perfil',
    'componente',
    'esteira',
    'vidro',
    'corte',
    'usinagem',
    'montagem'
  );

  foreach ($data as $input_name) {
    ${$input_name} = isset($_POST[$input_name])
      ? $_POST[$input_name]
      : "";
  };

  $sql = 
  "SELECT 
  p.*,
  o.nome as obra,
  dp.*
  FROM 
  processos p
  LEFT JOIN
  datas_processo dp
  ON
  p.id = dp.processo_id
  LEFT JOIN
  obras o 
  ON
  p.obra_id = o.id
  ORDER BY
  p.previsto ASC";

  $res = $conn->query($sql);

  if ($res) {
    $processos = $res->fetch_all(MYSQLI_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($processos);
  } else {
    echo json_encode([]);
  }
?>
