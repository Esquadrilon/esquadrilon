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

    <title>Atualizar O.S.</title>
  </head>

  <body>
    <?php
      include_once('../config/db/connection.php');
      include_once('../includes/navbar.php');
      include_once('../includes/toast.php');

      function validateLimit($data, $end, $limit, $title) {
        $limit_date = new DateTime($data->previsto);
        $limit_date->sub(new DateInterval("P{$limit}D"));
    
        $data = date('d/m/Y', $limit_date->getTimestamp());
    
        if($end != null) {
            $bg = "bg-success";
            $message = "Finalizado";
            $data = date('d/m/Y', strtotime($end));
        } else {
            if(new DateTime() < $limit_date) {
                $bg = "bg-info";
                $message = "Pendente";
            } else {
                $bg = "bg-danger";
                $message = "Atrasado";
            }
        }
    
        $result = 
        '
            <div class="row mt-2">
                <div class="col"> 
                  '. ucfirst($title) .'
                </div>
                <div class="col">
                  '. date('d/m/Y', $limit_date->getTimestamp()) .'
                </div>
                <div class="col px-4">
                    <input 
                      type="date" 
                      name="'. $title .'" 
                      id="'. $title .'" 
                      class="form-control w-75 fw-bold" 
                      value="' . (($end !== null) ? date('Y-m-d', strtotime($end)) : null) . '"
                    >
                </div>
                <div class="col">
                  '. $message .'
                </div>
            </div>
        ';

        return $result;
      }
    

      if (isset($_GET['os'])) {
        $sql = 
          "SELECT 
            p.*,
            o.nome as obra,
            dp.*
          FROM 
            processos p
          LEFT JOIN
            datas_processo dp
          ON
            p.id = dp.processo_id
          LEFT JOIN
            obras o 
          ON
            p.obra_id = o.id
          WHERE
            p.id = " . $_REQUEST['os'];

    
        $res = $conn->query($sql);
    
        $row = $res->fetch_object();
      }
    ?>
    <main class="container d-flex justify-content-center align-items-center my-5">
      <div class="w-100">  
        <form action="./controller.php?os=<?php echo $_GET['os'] ?>&action=update" method="post">
          <div class="wrapper px-4 py-3 my-1 w-100 fs-4">  
            <div class="row">
              <div class="col">
                <p class="m-0"><strong class="fs-2">O.S:</strong> <?php echo number_format($row->id, 0, ",", ".") ?></p>
              </div>
              <div class="col">
                <p class="m-0"><strong class="fs-3">Cadastro:</strong> <?php echo date('d/m/y', strtotime($row->criado)) ?></p>
              </div>
              
              <div class="col d-flex">
                <strong class="fs-3">Previsto:</strong> 
                <input type="date" name="previsto" id="previsto" class="mx-4 form-control fw-bold" value="<?php echo date('Y-m-d', strtotime($row->previsto)) ?>" required>
              </div>
            </div>

          </div>

          <div class="wrapper px-4 py-2 my-1 w-100 fs-4 mt-4">
            <div class="row">
              <p class="m-0"><strong class="fs-3">Obra:</strong> <?php echo $row->obra ?></p>
            </div>

            <div class="row">
              <div class="col">
                <p class="m-0"><strong class="fs-3">Tipologia:</strong> <?php echo $row->tipologia ?></p>
              </div>
              <div class="col">
                <p class="m-0"><strong class="fs-3">Tipo:</strong> <?php echo $row->tipo ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <p class="m-0"><strong class="fs-3">Lugar:</strong> <?php echo $row->lugar ?></p>
              </div>
              <div class="col">
                <p class="m-0"><strong class="fs-3">Lote:</strong> <?php echo $row->lote ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col d-flex">
                <strong class="fs-3">Quantidade de peças:</strong>
                <input type="number" name="pecas" id="pecas" class="mx-4 form-control fw-bold w-25" value="<?php echo $row->pecas  ?>" min="0" required>
              </div>
              <div class="col d-flex">
                <strong class="fs-3">Quantidade de peças feitas:</strong> 
                <input type="number" name="pecas_feitas" id="pecas_feitas" class="mx-4 form-control fw-bold w-25" value="<?php echo $row->pecas_feitas  ?>" min="0">
              </div>
            </div>

            <div class="row">
              <div class="col d-flex">
                <strong class="fs-3">Peso:</strong> 
                <input type="number" name="peso" id="peso" class="mx-4 form-control fw-bold w-25" value="<?php echo $row->peso  ?>" step="0.001" required>
              </div>
              <div class="col"></div>
            </div>
          </div>

          <strong class="fs-2 d-flex justify-content-center align-items-center mt-2">Processos</strong>
          <div class="wrapper px-4 py-2 my-1 w-100 fs-4 mt-2">  
            <div class="row fw-bold fs-3 border-bottom border-2 border-white">
              <div class="col">Processos</div>
              <div class="col">Data Limite</div>
              <div class="col">Data Conclusão</div>
              <div class="col">Status</div>
            </div>

            <?php echo validateLimit($row, $row->perfil, 15, "perfil") ?>
            <?php echo validateLimit($row, $row->componente, 15, "componente") ?>
            <?php echo validateLimit($row, $row->esteira, 5, "esteira") ?>
            <?php echo validateLimit($row, $row->vidro, 21, "vidro") ?>
            <?php echo validateLimit($row, $row->corte, 5, "corte") ?>
            <?php echo validateLimit($row, $row->usinagem, 3, "usinagem") ?>
            <?php echo validateLimit($row, $row->montagem, 1, "montagem") ?>
 
          </div>

          <div class="wrapper p-4 my-1 w-100 fs-4 mt-4">  
              <strong class="fs-3">Observações</strong>
              <textarea class="form-control" name="observacoes" id="observacoes" cols="50" rows="3" placeholder="Se necessário"><?php echo $row->observacoes ?></textarea>
          </div>

          <div class="row mt-4">
            <div class="col w-50">
              <a href="./controller.php?os=<?php echo $_GET['os']?>&action=delete" class="btn btn-danger w-100 fs-5 fw-semibold" onclick="return confirm('Tem certeza que deseja excluir essa O.S?')">
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
  </body>
</html>
