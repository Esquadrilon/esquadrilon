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

  <title>Lista Entradas</title>
</head>

<body>
  <?php
    include_once('../../config/db/connection.php');
    include_once('../../includes/navbar.php');
    include_once('../../includes/toast.php');
  ?>
  <main class="container-fluid px-5 my-3 w-100">
    <div class="text-center mb-4">
      <a href="./create.php" class="btn btn-success">
        <i class="bi bi-clipboard2-plus-fill"></i> Cadastrar Entrada
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
          <div class="col">Origem</div>
          <div class="col">Nota</div>
          <div class="col">Responsável</div>
          <div class="col-1"></div>
        </div>
      <?php
      $sql = 
        "SELECT 
          e.id,
          o.nome as obra,
          e.perfil_codigo as perfil,
          e.tamanho,
          c.nome as cor,
          e.origem,
          e.quantidade,
          e.nota,
          e.responsavel,
          e.criado
        from 
          entradas e
        left join
          obras o 
        on
        e.obra_id = o.id
        left join
          cores c 
        on
        e.cor_id  = c.id
        order by
        e.criado";

      $res = $conn->query($sql);

      if ($res->num_rows > 0) {
        $entradas = $res->fetch_all(MYSQLI_ASSOC);

        foreach ($entradas as $entrada) {

          echo '
          <div class="row row-cols-10 fs-5 fw-medium my-2 d-flex align-items-center p-1 rounded" style="background-color: rgba(3, 3, 3, 0.25)">
            <div class="col">' . $entrada['obra'] . '</div>
            <div class="col">' . $entrada['perfil'] . '</div>
            <div class="col">' . $entrada['tamanho'] . '</div>
            <div class="col">' . $entrada['cor'] . '</div>
            <div class="col">' . $entrada['quantidade'] . '</div>
            <div class="col">' . date("d/m/Y", strtotime($entrada['criado'])) . '</div>
            <div class="col">' . $entrada['origem'] . '</div>
            <div class="col">' . $entrada['nota'] . '</div>
            <div class="col">' . $entrada['responsavel'] . '</div>
            <div class="col-1 text-end">
              <a href="./update.php?id=' . $entrada['id'] . '" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem">
                <i class="bi bi-pencil-fill"></i>
              </a>
              <a href="./controller.php?id=' . $entrada['id'] . '&acao=deletar" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem" onclick="return confirm(\'Tem certeza que deseja excluir essa entrada?\');">
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