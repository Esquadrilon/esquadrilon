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

  <title>Editar Obra</title>
</head>

<body>
  <?php
    include_once('../config/db/connection.php');
    include_once('../includes/navbar.php');
    include_once('../includes/toast.php');

    if (isset($_GET['id'])) {
      $sql = "SELECT * FROM obras WHERE id = " . $_REQUEST['id'];

      $res = $conn->query($sql);

      $row = $res->fetch_object();
    }
  ?>
  <main class="container d-flex justify-content-center align-items-center my-5">
    <div class="wrapper p-4 my-1 w-75 fs-4">
      <h1 class="text-center fs-1">Obra</h1>
      <form action="./controller.php?id='<?php echo $_GET['id'] ?>'" method="post">
        <input type="hidden" name="acao" value="editar">

        <div class="col mt-2">
          <label for="nome ">Nome</label>
          <input type="text" name="nome" id="nome" value="<?php print $row->nome ?>" class="form-control" placeholder="Atmosphere">
        </div>

        <div class="row  mt-2">
          <div class="col">
            <label for="situacao">Situacao</label>
            <input type="text" name="situacao" id="situacao" value="<?php print $row->situacao ?>" class="form-control" placeholder="Em construção">
          </div>

          <div class="col">
            <label for="website">Site</label>
            <input type="text" name="website" id="website" value="<?php print $row->website ?>" class="form-control" placeholder="https://exemplo.com.br/exemplo">
          </div>
        </div>

        <div class="col">
          <label for="cliente_id">Cliente</label>
          <select name="cliente_id" id="cliente_id" class="form-select">
            <option value="0" selected>Selecione...</option>
            <?php
            $clientes = $conn->query("SELECT * FROM clientes");
            while ($cliente = $clientes->fetch_object()) {
              $cliente->id == $row->cliente_id
                ? print "<option value=\"$cliente->id\" selected> $cliente->nome </option>"
                : print "<option value=\"$cliente->id\"> $cliente->nome </option>";
            }
            ?>
          </select>
        </div>

        <div class="col mt-2">
          <label for="endereco">Rua</label>
          <input type="text" name="endereco" id="endereco" value="<?php print $row->endereco ?>" class="form-control" placeholder="Paissandu, 931">
        </div>

        <div class="row mt-2">
          <div class="col">
            <label for="cidade_id">Cidade</label>
            <select name="cidade_id" id="cidade_id" class="form-select">
              <option value="0" selected>Selecione...</option>
              <?php
              $cidades = $conn->query("SELECT * FROM cidades");
              while ($cidade = $cidades->fetch_object()) {
                $cidade->id == $row->cidade_id
                  ? print "<option value=\"$cidade->id\" selected> $cidade->nome </option>"
                  : print "<option value=\"$cidade->id\"> $cidade->nome </option>";
              }
              ?>
            </select>
          </div>

          <div class="col">
            <label for="estado_id">Estado</label>
            <select name="estado_id" id="estado_id" class="form-select">
              <option value="0" selected>Selecione...</option>
              <?php
              $estados = $conn->query("SELECT * FROM estados");
              while ($estado = $estados->fetch_object()) {
                $estado->id == $row->estado_id
                  ? print "<option value=\"$estado->id\" selected> $estado->nome </option>"
                  : print "<option value=\"$estado->id\"> $estado->nome </option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="col mt-2">
          <label for="cep">CEP</label>
          <input type="text" name="cep" id="cep" value="<?php print $row->cep ?>" class="form-control" placeholder="87050-130">
        </div>

        <div class="col mt-2">
          <label for="observacoes">Observações</label>
          <textarea class="form-control" name="observacoes" id="observacoes" cols="50" rows="3" placeholder="Se necessário"><?php print $row->observacoes ?></textarea>
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