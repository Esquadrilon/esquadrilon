<!doctype html>
<html lang="en">

<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="/esquadrilon/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/esquadrilon/node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <script src="/esquadrilon/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="/esquadrilon/css/global.css">

  <title>Detalhes</title>
</head>

<body>
  <?php
    include_once('../config/db/connection.php');
    include_once('../includes/navbar.php');
    include_once('../includes/toast.php');

    $obra = isset($_GET['obra']) ? $_GET['obra'] : null;
    $perfil = isset($_GET['perfil']) ? $perfil = $_GET['perfil'] : null;
    $tamanho = isset($_GET['tamanho']) ? $_GET['tamanho'] : null;
    $cor = isset($_GET['cor']) ? $_GET['cor'] : null;
  ?>
  <div class="container-fluid">
    <div class="mt-3">
      <h2 class="text-center">Entrada</h2>
      <div class="wrapper p-3">
        <div class="row d-flex justify-content-center align-items-center p-1 rounded w-100">
          <div class="col fs-4 fw-bold">Obra</div>
          <div class="col fs-4 fw-bold">Perfil</div>
          <div class="col fs-4 fw-bold">Tamanho</div>
          <div class="col fs-4 fw-bold">Cor</div>
          <div class="col fs-4 fw-bold">Quantidade</div>
          <div class="col fs-4 fw-bold">Data</div>
          <div class="col-2 fs-4 fw-bold">Origem</div>
          <div class="col fs-4 fw-bold">Nota</div>
          <div class="col-1 fs-4 fw-bold"></div>
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
          WHERE 
          o.nome like '%$obra%'
          AND (e.perfil_codigo like '%$perfil%')
          AND (c.nome like '%$cor%')
          AND (e.tamanho like '%$tamanho%') ";

          $res = $conn->query($sql);

          if ($res->num_rows > 0) {
            $entradas = $res->fetch_all(MYSQLI_ASSOC);

            foreach ($entradas as $entrada) {

              echo '
              <div class="row row-cols-8 mt-2 d-flex justify-content-center align-items-center p-1 rounded w-100">
                <div class="col fw-semibold"> ' . $entrada['obra'] . ' </div>
                <div class="col fw-semibold"> ' . $entrada['perfil'] . ' </div>
                <div class="col fw-semibold"> ' . $entrada['tamanho'] . ' </div>
                <div class="col fw-semibold"> ' . $entrada['cor'] . ' </div>
                <div class="col fw-semibold"> ' . $entrada['quantidade'] . ' </div>
                <div class="col fw-semibold"> ' . date("d/m/Y", strtotime($entrada['criado'])) . ' </div>
                <div class="col-2 fw-semibold"> ' . $entrada['origem'] . ' </div>
                <div class="col fw-semibold"> ' . $entrada['nota'] . ' </div>
                <div class="col-1 fw-semibold d-flex justify-content-center align-items-center">
                  <a href="./pages/Entradas/update.php?id=' . $entrada['id'] . '" class="btn btn-primary">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                </div>
              </div>';
            };
          } else {
            echo "<p class='alert alert-danger'>Nenhum resultado foi encontrado!</p>";
          }
        ?>
      </div>
    </div>

    <div class="mt-3">
      <h2 class="text-center">Reservas</h2>
      <div class="wrapper p-3">
        <div class="row d-flex justify-content-center align-items-center p-1 rounded w-100">
          <div class="col fs-4 fw-bold">Obra</div>
          <div class="col fs-4 fw-bold">Perfil</div>
          <div class="col fs-4 fw-bold">Tamanho</div>
          <div class="col fs-4 fw-bold">Cor</div>
          <div class="col fs-4 fw-bold">Quantidade</div>
          <div class="col fs-4 fw-bold">Romaneio</div>
          <div class="col-1 fs-4 fw-bold"></div>
        </div>
        <?php
          $sql = 
          "SELECT 
            r.id,
            o.nome as obra,
            r.perfil_codigo as perfil,
            r.tamanho,
            c.nome as cor,
            r.quantidade,
            r.reserva_id as romaneio
          from 
            itens_reserva r
          left join
            obras o 
          on
          r.obra_id = o.id
          left join
            cores c 
          on
          r.cor_id  = c.id
          WHERE 
          o.nome like '%$obra%'
          AND (r.perfil_codigo like '%$perfil%')
          AND (c.nome like '%$cor%')
          AND (r.tamanho like '%$tamanho%') ";

          $res = $conn->query($sql);

          if ($res->num_rows > 0) {
            $reservas = $res->fetch_all(MYSQLI_ASSOC);
            
            foreach ($reservas as $reserva) {
              echo '
              <div class="row mt-2 d-flex justify-content-center align-items-center p-1 rounded w-100">
                <div class="col fw-semibold"> ' . $reserva['obra'] . '</div>
                <div class="col fw-semibold"> ' . $reserva['perfil'] . ' </div>
                <div class="col fw-semibold"> ' . $reserva['tamanho'] . ' </div>
                <div class="col fw-semibold"> ' . $reserva['cor'] . ' </div>
                <div class="col fw-semibold"> ' . $reserva['quantidade'] . ' </div>
                <div class="col fw-semibold"> ' . $reserva['romaneio'] . ' </div>
                <div class="col-1 fw-semibold d-flex justify-content-center align-items-center">
                  <a href="#" class="btn btn-primary">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                </div>
              </div>';
            };
          } else {
            echo "<p class='alert alert-danger'>Nenhum resultado foi encontrado!</p>";
          }
        ?>
      </div>
    </div>

    <div class="mt-3">
      <h2 class="text-center">Saída</h2>
      <div class="wrapper p-3">
        <div class="row d-flex justify-content-center align-items-center p-1 rounded w-100">
          <div class="col fs-4 fw-bold">Obra</div>
          <div class="col fs-4 fw-bold">Perfil</div>
          <div class="col fs-4 fw-bold">Tamanho</div>
          <div class="col fs-4 fw-bold">Cor</div>
          <div class="col fs-4 fw-bold">Quantidade</div>
          <div class="col fs-4 fw-bold">Data</div>
          <div class="col-2 fs-4 fw-bold">Destino</div>
          <div class="col fs-4 fw-bold">Romaneio</div>
          <div class="col-1 fs-4 fw-bold"></div>
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
          WHERE 
          o.nome like '%$obra%'
          AND (s.perfil_codigo like '%$perfil%')
          AND (c.nome like '%$cor%')
          AND (s.tamanho like '%$tamanho%') ";

          $res = $conn->query($sql);

          if ($res->num_rows > 0) {
            $saidas = $res->fetch_all(MYSQLI_ASSOC);
            
            foreach ($saidas as $saida) {
              echo '
              <div class="row mt-2 d-flex justify-content-center align-items-center p-1 rounded w-100">
                <div class="col fw-semibold"> ' . $saida['obra'] . '</div>
                <div class="col fw-semibold"> ' . $saida['perfil'] . ' </div>
                <div class="col fw-semibold"> ' . $saida['tamanho'] . ' </div>
                <div class="col fw-semibold"> ' . $saida['cor'] . ' </div>
                <div class="col fw-semibold"> ' . $saida['quantidade'] . ' </div>
                <div class="col fw-semibold"> ' . date("d/m/Y", strtotime($saida['criado'])) . ' </div>
                <div class="col-2 fw-semibold"> ' . $saida['destino'] . ' </div>
                <div class="col fw-semibold"> ' . $saida['romaneio'] . ' </div>
                <div class="col-1 fw-semibold d-flex justify-content-center align-items-center">
                  <a href="./pages/Saidas/update.php?id=' . $saida['id'] . '" class="btn btn-primary">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                </div>
              </div>';
            };
          } else {
            echo "<p class='alert alert-danger'>Nenhum resultado foi encontrado!</p>";
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>