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

  <title>Reserva - <?php echo $_REQUEST['id'] ?></title>
</head>

<body>
  <?php
    include_once('../../config/db/connection.php');
    include_once('../../includes/navbar.php');
    include_once('../../includes/toast.php');

    $reserva = $conn->query("SELECT * FROM reservas WHERE id = ". $_REQUEST['id'])->fetch_assoc();
  ?>
  <main class="container-fluid px-5 my-3 w-75">
    <div class="row fs-3 fw-bold border-bottom border-2 border-white">
      <div class="col-3">Romaneio</div>
      <div class="col">Observacoes</div>
    </div>
    <div class="row fs-5 py-2 border-bottom border-2 border-white">
      <div class="col-3">
        <?php echo $reserva['id'] ?>
      </div>
      <div class="col"> 
        <?php echo $reserva['observacoes'] ?> 
      </div>
    </div>
    
    <div class="row fs-3 fw-bold p-1 mt-3">
      Itens
      <form action="./controller.php?acao=separar&reserva=<?php echo $_REQUEST['id'] ?>" method="post"> 
        <div class="wrapper px-4 py-1">
          <div class="row fs-3 fw-bold d-flex align-items-center p-1 border-bottom border-2 border-white">
            <div class="col">Obra</div>
            <div class="col">Perfil</div>
            <div class="col">Tamanho</div>
            <div class="col">Cor</div>
            <div class="col">Quantidade</div>
            <div class="col-1"></div>
          </div>
          
          <?php
            $sql = 
            "SELECT 
              r.id,
              r.reserva_id,
              o.nome as obra,
              r.perfil_codigo as perfil,
              r.tamanho,
              c.nome as cor,
              r.quantidade
            FROM itens_reserva r
            LEFT JOIN obras o ON o.id = r.obra_id
            LEFT JOIN cores c ON c.id = r.cor_id
            WHERE r.reserva_id = ". $_REQUEST['id'];
            $res = $conn->query($sql);
            foreach ($res as $item){
              echo '
              <div class="row fs-5 fw-medium my-2 d-flex align-items-center p-1 rounded" style="background-color: rgba(3, 3, 3, 0.25)">
                <div class="col"> ' . $item['obra'] . ' </div>
                <div class="col"> ' . $item['perfil'] . ' </div>
                <div class="col"> ' . $item['tamanho'] . ' </div>
                <div class="col"> ' . $item['cor'] . ' </div>
                <div class="col"> ' . $item['quantidade'] . ' </div>
                <div class="col-1 text-end">
                  <a href="./controller.php?id=' . $item['id'] . '&acao=deletar_item" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem" onclick="return confirm(\'Tem certeza que deseja excluir esse item da reserva?\');">
                    <i class="bi bi-trash-fill"></i>
                  </a>
                </div>
              </div>';
            }
          ?>
        </div>

        <div class="row fs-3 fw-bold p-1 mt-3">
          Separar
        </div>

        <div class="wrapper p-4 my-1 w-100 fs-4">
          <div class="row">
            <div class="col">
              <label for="destino">Destino</label>
              <input type="text" name="destino" id="destino" class="form-control" placeholder="1 Lote Torre" required>
            </div>

            <div class="col">
              <label for="responsavel">Responsável</label>
              <input type="text" name="responsavel" id="responsavel" class="form-control" placeholder="Erick" required>
            </div>
          </div>
          
          <div class="row mt-2">
            <div class="col">
              <label for="caminhao">Placa do Caminhão</label>
              <input type="text" name="caminhao" id="caminhao" class="form-control" placeholder="BCP3B29">
            </div>

            <div class="col">
              <label for="motorista">Motorista</label>
              <input type="text" name="motorista" id="motorista" class="form-control" placeholder="Fábio">
            </div>
          </div>

          <div class="col mt-2">
            <label for="observacoes">Observações</label>
            <textarea class="form-control" name="observacoes" id="observacoes" cols="50" rows="3" placeholder="Se necessário"></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary text-white w-25 fs-5 fw-bold">
            <i class="bi bi-send-fill"></i> Enviar 
          </button>
        </div>
      </form>
    </div>
  </main>
  <footer></footer>
</body>

</html>
