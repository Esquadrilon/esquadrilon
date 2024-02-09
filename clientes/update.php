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

  <title>Editar Cliente</title>
</head>

<body>
  <?php
    include_once('../config/db/connection.php');
    include_once('../includes/navbar.php');
    include_once('../includes/toast.php');

    if (isset($_GET['id'])) {
      $sql = "SELECT * FROM clientes WHERE id = " . $_REQUEST['id'];

      $res = $conn->query($sql);

      $row = $res->fetch_object();
    }
  ?>
  <main class="container d-flex justify-content-center align-items-center my-5">
    <div class="wrapper p-4 my-1 w-75 fs-4">
      <h1 class="text-center fs-1">Cliente</h1>
      <form action="./controller.php?id=<?php echo $_GET['id'] ?>&action=update" method="post">
        <div class="col mt-2">
          <label for="nome ">Nome</label>
          <input type="text" name="nome" id="nome" value="<?php print $row->nome ?>" class=" form-control" placeholder="Lucas Alves">
        </div>

        <div class="row  mt-2">
          <div class="col">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?php print $row->email ?>" class=" form-control" placeholder="exemplo@exemplo.com">
          </div>

          <div class="col">
            <label for="telefone">Telefone</label>
            <input type="tel" name="telefone" id="telefone" value="<?php print $row->telefone ?>" class=" form-control" placeholder="(43) 91234-5678" minlength="11" maxlength="16">
          </div>
        </div>

        <div class="col mt-2">
          <label for="cpf_cnpj">CPF / CNPJ</label>
          <input type="text" name="cpf_cnpj" id="cpf_cnpj" value="<?php print $row->cpf_cnpj ?>" class=" form-control" placeholder="123.456.789-01 ou 12.345.678/0001-01">
        </div>

        <div class="col mt-2">
          <label for="endereco">Rua</label>
          <input type="text" name="endereco" id="endereco" value="<?php print $row->endereco ?>" class=" form-control" placeholder="Rua Sergipe, 123">
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
                $selected = ($estado->id == $row->estado_id) ? "selected" : "";
                echo "<option value=\"$estado->id\" $selected>$estado->nome</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="col mt-2">
          <label for="cep">CEP</label>
          <input type="text" name="cep" id="cep" value="<?php print $row->cep ?>" class=" form-control" placeholder="12345-678">
        </div>

        <div class="col mt-2">
          <label for="observacoes">Observações</label>
          <textarea class="form-control" name="observacoes" id="observacoes" cols=" 50" rows="3" placeholder="Se necessário"><?php print $row->observacoes ?></textarea>
        </div>

        <div class="row mt-4">
          <div class="col w-50">
            <a href="./controller.php?id=<?php echo $_GET['id'] ?>&action=delete" class="btn btn-danger w-100 fs-5 fw-semibold" onclick="return confirm('Tem certeza que deseja excluir esse cliente?')">
              Deletar
            </a>
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