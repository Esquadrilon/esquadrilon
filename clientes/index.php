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

  <title>Lista Clientes</title>
</head>

<body>
  <?php
    include_once('../config/db/connection.php');
    include_once('../includes/navbar.php');
    include_once('../includes/toast.php');
  ?>
  <main class="container-fluid px-5 my-3 w-100">
    <div class="text-center mb-4">
      <a href="./create.php" class="btn btn-success">
        <i class="bi bi-person-fill-add"></i> Cadastrar Cliente
      </a>
    </div>
    <div class="wrapper px-4 py-1">
      <div class="row fs-3 fw-bold d-flex align-items-center p-1 border-bottom border-2 border-white">
        <div class="col">Nome</div>
        <div class="col">Endereço</div>
        <div class="col">Cidade</div>
        <div class="col-1">Observações</div>
        <div class="col"></div>
      </div>

      <?php
      $sql = 
      "SELECT
        c.id,
        c.nome,
        c.email,
        c.telefone, 
        c.endereco, 
        cidades.nome as cidade,
        c.observacoes 
      from 
        clientes c
      left join
        cidades
      on
        cidades.id  = c.cidade_id
      ORDER BY
        c.nome";
      $res = $conn->query($sql);

      if ($res->num_rows > 0) {
        $clientes = $res->fetch_all(MYSQLI_ASSOC);

        foreach ($clientes as $cliente) {
          echo '
          <div class="row fs-5 fw-medium my-2 d-flex align-items-center p-1 rounded" style="background-color: rgba(3, 3, 3, 0.25)">
            <div class="col"> ' . $cliente['nome'] . ' </div>
            <div class="col"> ' . $cliente['endereco'] . ' </div>
            <div class="col"> ' . $cliente['cidade'] . ' </div>
            <div class="col-1"> ' . $cliente['observacoes'] . ' </div>
            <div class="col text-end">
              <a href="./update.php?id=' . $cliente['id'] . '" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem">
                <i class="bi bi-pencil-fill"></i>
              </a>
              <a href="./controller.php?id=' . $cliente['id'] . '&action=delete" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem" onclick="return confirm(\'Tem certeza que deseja excluir esse cliente?\');">
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