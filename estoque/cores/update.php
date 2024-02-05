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

  <title>Editar Cor</title>
</head>

<body>
  <?php
    include_once('../../config/db/connection.php');
    include_once('../../includes/navbar.php');
    include_once('../../includes/toast.php');
    
    if (isset($_GET['id'])) {
      $sql = "SELECT * FROM cores WHERE id = " . $_REQUEST['id'];

      $res = $conn->query($sql);

      $row = $res->fetch_object();
    }
  ?>
  <main class="container d-flex justify-content-center align-items-center my-5">
    <div class="wrapper p-4 my-1 w-75 fs-4">
      <h1 class="text-center fs-1">Cor</h1>
      <form action="./controller.php?id='<?php echo $_GET['id'] ?>'" method="post">
        <input type="hidden" name="acao" value="editar">

        <div class="row">
          <div class="col mt-2">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php print $row->nome ?>" class="form-control" placeholder="Cinza Epristinta">
          </div>

          <div class="col mt-2">
            <label for="codigo">Código</label>
            <input type="text" name="codigo" id="codigo" value="<?php print $row->codigo ?>" class="form-control" placeholder="W2635">
          </div>
        </div>

        <div class="row mt-4">
          <div class="col w-50">
            <button type="button" class="btn btn-danger w-100 fs-5 fw-semibold" onclick="window.location.href = './read.php'">Cancelar</button>
          </div>

          <div class="col w-50">
            <button type="submit" class="btn btn-success w-100 fs-5 fw-bold">Atualizar</button>
          </div>
        </div>

      </form>
    </div>
  </main>
  <footer></footer>
</body>

</html>