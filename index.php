<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="/esquadrilon/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/esquadrilon/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <script src="/esquadrilon/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="/esquadrilon/css/global.css">

    <title>Início</title>
  </head>
  <body>
    <?php
      include_once('./includes/navbar.php');
    ?>
		<section class="container p-5 w-50 mt-5">
      <div class="row">
        <a href="./estoque" class="wrapper col text-center p-2 mx-4 text-light text-decoration-none">
          <img src="./assets/img/estoque.png" alt="Icone de estoque" class="w-50">
          <h2 class="mt-2 fs-1 fw-bold">Estoque</h2>
        </a>
        <a href="./processos" class="wrapper col text-center p-2 mx-2 text-light text-decoration-none">
          <img src="./assets/img/processos.png" alt="Icone de processos" class="w-50">
          <h2 class="mt-2 fs-1 fw-bold">Processos</h2>
        </a>
      </div>
		</section>
  </body>
</html>
