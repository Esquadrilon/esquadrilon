<?php

include_once('../../config/db/connection.php');

$result = $conn->query("SELECT codigo FROM perfis");

if ($result) {
    $perfis = [];
    // Obtenha os dados dos perfis
    while ($row = $result->fetch_assoc()) {

        $item[] = $row;

        $perfis = $item;
    }

    header('Content-Type: application/json');
    
    echo json_encode($perfis);
} else {
    echo json_encode([]);
}
?>
