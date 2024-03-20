<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="/esquadrilon/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/esquadrilon/node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <script src="/esquadrilon/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="/esquadrilon/css/global.css">

  <title>Lista Obras</title>
</head>

<body>
  <?php
    include_once('../config/db/connection.php');
    include_once('../includes/navbar.php');
    include_once('../includes/toast.php');

    $sql = 
    "SELECT
      o.id,
      o.nome,
      o.situacao,
      o.endereco,
      cl.nome as cliente,
      ci.nome as cidade,
      o.observacoes 
    FROM 
      obras o
    LEFT JOIN
      clientes cl 
    ON
      o.cliente_id = cl.id
    LEFT JOIN
      cidades ci
    ON
      o.cidade_id = ci.id
    ORDER BY
      o.nome";
    
    $res = $conn->query($sql);
  ?>
  <main class="container-fluid px-5 my-3 w-100">
    <div class="text-center mb-4">
      <a href="./create.php" class="btn btn-success">
        <i class="bi bi-building-fill-add"></i> Cadastrar Obra
      </a>
    </div>
    <div class="wrapper px-4 py-1">
      <div class="row fs-3 fw-bold d-flex align-items-center p-1 border-bottom border-2 border-white">
        <div class="col-3">Nome</div>
        <div class="col-2">Cliente</div>
        <div class="col">Cidade</div> 
        <div class="col">Status</div>
        <div class="col-1">Observações</div>
        <div class="col-1"></div>
      </div>
      
      <?php

      if ($res->num_rows > 0) {
        $obras = $res->fetch_all(MYSQLI_ASSOC);
        
        foreach ($obras as $obra) {
          $clientes = $conn->query("SELECT * FROM clientes")->fetch_all(MYSQLI_ASSOC);
          echo '
          <div class="row fs-5 fw-medium my-2 d-flex align-items-center p-1 rounded" style="background-color: rgba(3, 3, 3, 0.25)">
            <div class="col-3">' . $obra['nome'] . '</div>
            <div class="col-2">' . $obra['cliente'] . '</div>
            <div class="col">' . $obra['cidade'] . '</div>
            <div class="col">' . $obra['situacao'] . '</div>
            <div class="col-1">' . $obra['observacoes'] . '</div>
            <div class="col-1 text-end">
              <a href="./update.php?id=' . $obra['id'] . '" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem">
                <i class="bi bi-pencil-fill"></i>
              </a>
              <a href="./controller.php?id=' . $obra['id'] . '&action=delete" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem" onclick="return confirm(\'Tem certeza que deseja excluir essa obra?\');">
                <i class="bi bi-trash-fill"></i>
              </a>
            </div>
          </div>';
        };
      } else {
        echo "<p class='alert alert-danger'>Nenhum resultado foi encontrado!</p>";
      }
      ?>


    </div>
  </main>
  <footer></footer>
</body>

</html>