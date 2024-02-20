<?php
  include_once('../config/db/connection.php');

  $whereParams = "";
  $orderParams = "";

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
  p.obra_id = o.id";


  if (!empty($whereParams)) {
    $sql .= " WHERE $whereParams";
  }

  // Adiciona a cláusula ORDER BY
  $sql .= " ORDER BY $orderParams";
  

  $res = $conn->query($sql);

  if ($res) {
    $processos = $res->fetch_all(MYSQLI_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($processos);
  } else {
    echo json_encode([]);
  }
?>
