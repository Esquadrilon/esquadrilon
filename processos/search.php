<?php
  include_once('../config/db/connection.php');

  $whereParams = "";
  $orderParams = "p.previsto ASC";

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

  if (isset($_GET['os'])) {
    $whereParams .= "p.id LIKE '%{$_GET['os']}%' AND ";
  }

  if (isset($_GET['previsto'])) {
    $whereParams .= "p.previsto = '{$_GET['previsto']}' AND ";
  }

  if (isset($_GET['obra'])) {
    $whereParams .= "o.nome LIKE '%{$_GET['obra']}%' AND ";
  }

  if (isset($_GET['tipo'])) {
    $whereParams .= "p.tipo LIKE '%{$_GET['tipo']}%' AND ";
  }

  if (isset($_GET['perfil'])) {
    $whereParams .= "dp.perfil IS NOT NULL AND ";
  }

  if (isset($_GET['vidro'])) {
    $whereParams .= "dp.vidro IS NOT NULL AND ";
  }

  if (isset($_GET['componente'])) {
    $whereParams .= "dp.componente IS NOT NULL AND ";
  }

  if (isset($_GET['corte'])) {
    $whereParams .= "dp.corte IS NOT NULL AND ";
  }

  if (isset($_GET['usinagem'])) {
    $whereParams .= "dp.usinagem IS NOT NULL AND ";
  }

  if (isset($_GET['montagem'])) {
    $whereParams .= "dp.montagem IS NOT NULL AND ";
  } else {
    $whereParams .= "dp.montagem IS NULL AND ";
  }

  if (isset($_GET['esteira'])) {
    $whereParams .= "dp.esteira IS NOT NULL AND ";
  }

  $whereParams = rtrim($whereParams, ' AND ');

  if (isset($_GET['peso'])) {
    $orderParams = "p.peso {$_GET['peso']}, " . $orderParams;
  }

  // Adiciona a cláusula WHERE
  $sql .= " WHERE $whereParams";

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
