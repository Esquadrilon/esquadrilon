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
    ?>
    <main class="container-fluid d-flex flex-column justify-content-center align-items-center my-3 w-100">
      <form class="w-75 fs-3">
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
              <option value="Esquadria">Esquadria</option>
              <option value="Contramarco">Contramarco</option>
              <option value="Arremate">Arremate</option>
              <option value="Acabamento">Acabamento</option>
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
              <input type="radio" class="btn-check" name="peso" id="menor" value="ASC" autocomplete="off">
              <label class="btn btn-secondary" for="menor">Menor</label>

              <input type="radio" class="btn-check" name="peso" id="maior" value="DESC" autocomplete="off">
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
      </form>
      <p class='alert alert-danger m-0 w-75'>Nenhum resultado foi encontrado!</p>
    </main>

    <script>
      document.querySelector("form").addEventListener("keydown", function (event) {
        event.keyCode === 13
        ? filtrar(event)
        : null;
        
      });

      function filtrar(event) {
        event.preventDefault();

        let res = [];
        let URL = "/esquadrilon/processos/search.php?";

        let os = document.getElementById("os").value;
        let obra = document.getElementById("obra_id").value;
        let tipo = document.getElementById("tipo").value;
        let previsto = document.getElementById("previsto").value;
        let perfil = document.getElementById("perfil");
        let componente = document.getElementById("componente");
        let esteira = document.getElementById("esteira");
        let vidro = document.getElementById("vidro");
        let corte = document.getElementById("corte");
        let usinagem = document.getElementById("usinagem");
        let montagem = document.getElementById("montagem");
        let peso = document.querySelectorAll('input[type=radio]:checked')[0];

        if(os !== '') URL += `os=${os}&`;
        if(obra !== '') URL += `obra=${obra}&`;
        if(tipo !== '') URL += `tipo=${tipo}&`;
        if(previsto !== '') URL += `previsto=${previsto}&`;

        if(perfil.checked) URL += `perfil&`;
        if(componente.checked) URL += `componente&`;
        if(esteira.checked) URL += `esteira&`;
        if(vidro.checked) URL += `vidro&`;
        if(corte.checked) URL += `corte&`;
        if(usinagem.checked) URL += `usinagem&`;
        if(montagem.checked) URL += `montagem&`;
        
        if(peso) URL += `peso=${peso.value}`;

        console.log(URL);

        fetch(URL)
        .then(response => response.json())
        .then(data => {
          console.log("Data: ", data);
          res = data;
        })
        .catch(error => console.error('Ocorreu um erro ao buscar os processos das ordens de serviço 😡'));
        
        return res;
      }
    </script>
  </body>
</html>
