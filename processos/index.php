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

    <title>Processos</title>
  </head>

  <body>
    <?php
      include_once('../config/db/connection.php');
      include_once('../includes/navbar.php');
      include_once('../includes/toast.php');

      function validateLimit($data, $end, $limit) {
        $limit_date = new DateTime($data['previsto']);
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
    
        return "<div class=\"col $bg rounded-1\" title='$data'>$message</div>";
      } 

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
        ORDER BY
          p.previsto ASC";

      $res = $conn->query($sql);
    ?>
    <main class="container-fluid d-flex flex-column justify-content-center align-items-center my-3 w-100">
      <div class="filter w-75 fs-3">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col mb-3">
            <label for="os" class="form-label">O.S</label>
            <input type="text" class="form-control" id="os" name="os" placeholder="Ordem de serviço">
          </div>

          <div class="col mb-3">
            <label for="obra_id" class="form-label">Obra</label>
            <select name="obra_id" id="obra_id" class="form-select">
              <option value="" selected>Todas as obras</option>
              <?php
              $obras = $conn->query("SELECT * FROM obras ORDER BY nome ASC");
              while ($obra = $obras->fetch_object()) {
                print "<option value=\"$obra->nome\"> $obra->nome </option>";
              }
              ?>
            </select>
          </div>

          <div class="col mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="tipo" id="tipo" class="form-select">
              <option value="" selected>Todos</option>
              <option value="Esquadria" selected>Esquadria</option>
              <option value="Contramarco" selected>Contramarco</option>
              <option value="Arremate" selected>Arremate</option>
              <option value="Acabamento" selected>Acabamento</option>
            </select>
          </div>

          <div class="col mb-3">
            <label for="previsto">Previsto</label>
            <input type="date" name="previsto" id="previsto" class="form-control">
          </div>
        </div>
        

        <div class="row fs-4">
          <div class="col-10">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col mb-3">
                <input class="form-check-input" type="checkbox" value="" id="perfil">
                <label class="form-check-label" for="perfil">
                  Perfil
                </label>
              </div>
              <div class="col mb-3">
                <input class="form-check-input" type="checkbox" value="" id="componente">
                <label class="form-check-label" for="componente">
                  Componente
                </label>
              </div>
              <div class="col mb-3">
                <input class="form-check-input" type="checkbox" value="" id="esteira">
                <label class="form-check-label" for="esteira">
                  Esteira
                </label>
              </div>
              <div class="col mb-3">
                <input class="form-check-input" type="checkbox" value="" id="vidro">
                <label class="form-check-label" for="vidro">
                  Vidro
                </label>
              </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center">
              <div class="col mb-3">
                <input class="form-check-input" type="checkbox" value="" id="corte">
                <label class="form-check-label" for="corte">
                  Corte
                </label>
              </div>
              <div class="col mb-3">
                <input class="form-check-input" type="checkbox" value="" id="usinagem">
                <label class="form-check-label" for="usinagem">
                  Usinagem
                </label>
              </div>
              <div class="col mb-3">
                <input class="form-check-input" type="checkbox" value="" id="montagem">
                <label class="form-check-label" for="montagem">
                  Montagem
                </label>
              </div>
              <div class="col mb-3">
              </div>
            </div>
            
          </div>

          <div class="col-2">
            <div class="col">
              <label class="form-check-label" for="peso">
                Peso
              </label>
            </div>
            <div class="col">
              <input type="radio" class="btn-check" name="peso" id="menor" autocomplete="off">
              <label class="btn btn-secondary" for="menor">Menor</label>

              <input type="radio" class="btn-check" name="peso" id="maior" autocomplete="off">
              <label class="btn btn-secondary" for="maior">Maior</label>
            </div>
          </div>
        </div>


        
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col mb-3">
            <button type="button" class="btn btn-primary" onclick="filtrar(event)">
              <i class="bi bi-filter"></i>
              Aplicar Filtros
            </button>
          </div>
        </div>
      </div>
      
      <?php
        if ($res->num_rows > 0) {
          $processos = $res->fetch_all(MYSQLI_ASSOC);

          echo '
          <div class="wrapper p-4 my-1 w-100 h-1 fs-4">
            <div class="row fs-4 fw-bold d-flex align-items-center p-1 border-bottom border-2 border-white">
              <div class="col">O.S</div>
              <div class="col">Obra</div>
              <div class="col">Peso</div>
              <div class="col">Previsto</div>
              <div class="col">Perfil</div>
              <div class="col">Componente</div>
              <div class="col">Esteira</div>
              <div class="col">Vidro</div>
              <div class="col">Corte</div>
              <div class="col">Usinagem</div>
              <div class="col">Montagem</div>
              <div class="col"></div>
            </div>
          ';

          foreach ($processos as $p) {
            if($p["montagem"] == null) {
              echo '
              <div class="row fs-5 fw-medium my-2 d-flex align-items-center p-1 rounded" style="background-color: rgba(2, 2, 2, 0.25)">
                <div class="col"> ' . number_format($p['id'], 0, ",", ".") . ' </div>
                <div class="col"> ' . $p['obra'] . ' </div>
                <div class="col"> ' . $p['peso'] . ' Kg </div>
                <div class="col"> ' . date('d/m/y', strtotime($p['previsto'])) . ' </div> ';

                echo validateLimit($p, $p['perfil'], 15); // perfil
                echo $p['tipo'] == "Esquadria" ? validateLimit($p, $p['componente'], 15) : '<div class="col"> N / A </div>'; // componente
                echo $p['tipo'] == "Esquadria" ? validateLimit($p, $p['esteira'], 5) : '<div class="col"> N / A </div>';  // esteira
                echo $p['tipo'] == "Esquadria" ? validateLimit($p, $p['vidro'], 21) : '<div class="col"> N / A </div>'; // vidro
                echo validateLimit($p, $p['corte'], 5); // corte
                echo $p['tipo'] == "Esquadria" ? validateLimit($p, $p['usinagem'], 3) : '<div class="col"> N / A </div>';  // usinagem
                echo validateLimit($p, $p['montagem'], 1); // montagem

                echo '
                <div class="col text-end">
                  <a href="./update.php?os=' . $p['id'] . '" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem">
                    <i class="bi bi-pencil-fill"></i>
                  </a>
                  <a href="./controller.php?os=' . $p['id'] . '&action=delete" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem" onclick="return confirm(\'Tem certeza que deseja excluir essa O.S?\');">
                    <i class="bi bi-trash-fill"></i>
                  </a>
                </div>
              </div>';
            }
          };
          
          echo '</div>';
        } else {
          echo "<p class='alert alert-danger m-0 w-75'>Nenhum resultado foi encontrado!</p>";
        }
      ?>
    </main>
  </body>
</html>
