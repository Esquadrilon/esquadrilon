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

    <title>Cadastro de O.S.</title>
  </head>

  <body>
    <?php
      include_once('../config/db/connection.php');
      include_once('../includes/navbar.php');
      include_once('../includes/toast.php');
    ?>
    <main class="container d-flex justify-content-center align-items-center my-5">
      <div class="wrapper p-4 my-1 w-75 fs-4">  
        <h1 class="text-center fs-1">Cadastro de O.S</h1>
        <form action="./controller.php?action=register" method="post">
          <div class="col mt-2">
            <label for="obra_id">Obra</label>
            <select name="obra_id" id="obra_id" class="form-select">
              <option value="0" selected>Selecione...</option>
              <?php
              $obras = $conn->query("SELECT * FROM obras ORDER BY nome");
              while ($obra = $obras->fetch_object()) {
                print "<option value='$obra->id'> $obra->nome </option>";
              }
              ?>
            </select>
          </div>

          <div class="row  mt-2">
            <div class="col">
              <label for="os">O.S</label>
              <input type="number" name="os" id="os" class="form-control" placeholder="50123" required>
            </div>

            <div class="col">
              <label for="previsto">Data Prevista</label>
              <input type="date" name="previsto" id="previsto" class="form-control" required>
            </div>
          </div>

          <div class="row  mt-2">
            <div class="col">
              <label for="tipologia">Tipologia</label>
              <input type="text" name="tipologia" id="tipologia" class="form-control" placeholder="JA1" required>
            </div>

            <div class="col">
              <label for="tipo">Tipo</label>
              <select name="tipo" id="tipo" class="form-select" required>
                <option value="" selected>Selecione...</option>
                <option value="Esquadria">Esquadria</option>
                <option value="Arremate">Arremate</option>
                <option value="Contramarco">Contramarco</option>
                <option value="Acabamento">Acabamento</option>
              </select>
            </div>
          </div>

          <div class="row  mt-2">
            <div class="col">
              <label for="lote">Lote</label>
              <input type="text" name="lote" id="lote" class="form-control" placeholder="Extra">
            </div>

            <div class="col">
              <label for="lugar">Lugar</label>
              <input type="text" name="lugar" id="lugar" class="form-control" placeholder="Cobertura">
            </div>
          </div>

          <div class="row  mt-2">
            <div class="col">
              <label for="pecas">Quantidade de peças</label>
              <input type="number" name="pecas" id="pecas" class="form-control" placeholder="1" required>
            </div>

            <div class="col">
              <label for="peso">Peso</label>
              <input type="number" name="peso" id="peso" class="form-control" placeholder="2.058 Kg" step="0.001" required>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col w-50">
              <button type="button" class="btn btn-danger w-100 fs-5 fw-semibold" onclick="clearData()">Limpar</button>
            </div>

            <div class="col w-50">
              <button type="submit" class="btn btn-success w-100 fs-5 fw-bold">Cadastrar</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </body>
</html>
