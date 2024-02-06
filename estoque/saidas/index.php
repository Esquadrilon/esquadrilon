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

  <title>Lista Saídas</title>
</head>

<body>
  <?php
    include_once('../../config/db/connection.php');
    include_once('../../includes/navbar.php');
    include_once('../../includes/toast.php');
  ?>
  <main class="container-fluid px-5 my-3 w-100">
    <div class="text-center mb-4">
      <a href="./create.php" class="btn btn-danger">
        <i class="bi bi-clipboard2-minus-fill"></i> Cadastrar Saída
      </a>
    </div>
    <div class="wrapper px-4 py-1">
        <div class="row row-cols-10 fs-3 fw-bold d-flex align-items-center p-1 border-bottom border-2 border-white">
          <div class="col">Obra</div>
          <div class="col">Perfil</div>
          <div class="col">Tamanho</div>
          <div class="col">Cor</div>
          <div class="col">Quantidade</div>
          <div class="col">Data</div>
          <div class="col">Destino</div>
          <div class="col">Romaneio</div>
          <div class="col">Responsável</div>
          <div class="col-1"></div>
        </div>
      <?php
      $sql = 
      "SELECT 
        s.id,
        o.nome as obra,
        s.perfil_codigo as perfil,
        s.tamanho,
        c.nome as cor,
        s.destino,
        s.quantidade,
        s.romaneio,
        s.responsavel,
        s.criado
      from 
        saidas s
      left join
        obras o 
      on
      s.obra_id = o.id
      left join
        cores c 
      on
      s.cor_id  = c.id
      order by
      s.criado";

      $res = $conn->query($sql);

      if ($res->num_rows > 0) {
        $saidas = $res->fetch_all(MYSQLI_ASSOC);
        
        foreach ($saidas as $saida) {
          echo '
          <div class="row row-cols-10 fs-5 fw-medium my-2 d-flex align-items-center p-1 rounded" style="background-color: rgba(3, 3, 3, 0.25)">
            <div class="col">' . $saida['obra'] . '</div>
            <div class="col">' . $saida['perfil'] . '</div>
            <div class="col">' . $saida['tamanho'] . '</div>
            <div class="col">' . $saida['cor'] . '</div>
            <div class="col">' . $saida['quantidade'] . '</div>
            <div class="col">' . date("d/m/Y", strtotime($saida['criado'])) . '</div>
            <div class="col">' . $saida['destino'] . '</div>
            <div class="col">' . $saida['romaneio'] . '</div>
            <div class="col">' . $saida['responsavel'] . '</div>
            <div class="col-1 text-end">
              <a href="./update.php?id=' . $saida['id'] . '" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem">
                <i class="bi bi-pencil-fill"></i>
              </a>
              <a href="./controller.php?id=' . $saida['id'] . '&acao=deletar" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem" onclick="return confirm(\'Tem certeza que deseja excluir essa saída?\');">
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