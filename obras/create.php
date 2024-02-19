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

  <title>Cadastro Obra</title>
</head>

<body>
  <?php
    include_once('../config/db/connection.php');
    include_once('../includes/navbar.php');
    include_once('../includes/toast.php');
  ?>
  <main class="container d-flex justify-content-center align-items-center my-5">
    <div class="wrapper p-4 my-1 w-75 fs-4">
      <h1 class="text-center fs-1">Obra</h1>
      <form action="./controller.php?action=register" method="post">
        <input type="hidden" name="acao" value="cadastrar">
        <div class="row  mt-2">
          <div class="col">
            <label for="nome ">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" placeholder="Atmosphere">
          </div>

          <div class="col">
            <label for="situacao">Status da Obra</label>
            <input type="text" name="situacao" id="situacao" class="form-control" placeholder="Em construção">
          </div>
        </div>

        <div class="col mt-2">
          <label for="cliente_id">Cliente</label>
          <select name="cliente_id" id="cliente_id" class="form-select">
            <option value="0" selected>Selecione...</option>
            <?php
            $clientes = $conn->query("SELECT * FROM clientes ORDER BY nome ASC");
            while ($cliente = $clientes->fetch_object()) {
              print "<option value='$cliente->id'> $cliente->nome </option>";
            }
            ?>
          </select>
        </div>

        <div class="col mt-2">
          <label for="endereco">Rua</label>
          <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Paissandu, 931">
        </div>

        <div class="row mt-2">
          <div class="col">
            <label for="cidade_id">Cidade</label>
            <select name="cidade_id" id="cidade_id" class="form-select">
              <option value="0" selected>Selecione...</option>
              <?php
              $cidades = $conn->query("SELECT * FROM cidades ORDER BY nome");
              while ($cidade = $cidades->fetch_object()) {
                print "<option value='$cidade->id'> $cidade->nome </option>";
              }
              ?>
            </select>
          </div>

          <div class="col">
            <label for="estado_id">Estado</label>
            <select name="estado_id" id="estado_id" class="form-select">
              <option value="0" selected>Selecione...</option>
              <?php
              $estados = $conn->query("SELECT * FROM estados ORDER BY nome");
              while ($estado = $estados->fetch_object()) {
                print "<option value=\"$estado->id\"> $estado->nome </option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="col mt-2">
          <label for="cep">CEP</label>
          <input type="text" name="cep" id="cep" class="form-control" placeholder="87050-130">
        </div>

        <div class="col mt-2">
          <label for="observacoes">Observações</label>
          <textarea class="form-control" name="observacoes" id="observacoes" cols="50" rows="3" placeholder="Se necessário"></textarea>
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
  <footer></footer>
  <script>
    function clearData() {
      document.getElementById('nome').value = '';
      document.getElementById('situacao').value = '';
      document.getElementById('website').value = '';
      document.getElementById('cliente_id').value = '';
      document.getElementById('endereco').value = '';
      document.getElementById('cidade_id').value = '';
      document.getElementById('estado_id').value = '';
      document.getElementById('cep').value = '';
      document.getElementById('observacoes').value = '';
    }
  </script>
</body>

</html>