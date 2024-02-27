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

      <section id="Table">

      </section>
    </main>

    <script>
      document.querySelector("form").addEventListener("keydown", function (event) {
        event.keyCode === 13
        ? filtrar(event)
        : null;
        
      });

      async function search() {
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

        await fetch(URL)
          .then(response => response.json())
          .then(data => {
            console.log("Data: ", data);
            res = data;
          })
          .catch(error => console.error('Ocorreu um erro ao buscar os processos das ordens de serviço 😡'));
        
        return res;
      }

      function dataValidator(promised, ended, interval) {
        let limit_date = new Date(promised);
        limit_date.setDate(limit_date.getDate() - interval);

        if(ended != null) {
          bg = "bg-success";
          message = "Finalizado";
          data = new Date(ended).toLocaleDateString('pt-BR');
        } else {
          if(Date.now() < limit_date) {
            bg = "bg-info";
            data = "Pendente";
            message = "Pendente";
          } else {
            bg = "bg-danger";
            data = "Atrasado";
            message = "Atrasado";
          }
        }

        return `<div class="col ${bg} m-0 p-0" title='${data}'>${message}</div>`;
      }

      function render(data) {
        let row = document.createElement("div");
        row.className = "row fs-5 fw-medium my-2 d-flex align-items-center p-1 rounded";
        row.style.backgroundColor = "rgba(2, 2, 2, 0.25)";

        row.innerHTML = `
          <div class="col-1">${data.id}</div>
          <div class="col">${data.obra}</div>
          <div class="col">${data.peso}Kg </div>
          <div class="col">${new Date(data.previsto).toLocaleDateString('pt-BR')}</div>
          <div class="col m-0 p-0">${dataValidator(data.previsto, data.perfil, 15)}</div>
          ${data.tipo == "Esquadria" ? dataValidator(data.previsto, data.componente, 15) : '<div class="col m-0 p-0"> N / A </div>'}
          ${data.tipo == "Esquadria" ? dataValidator(data.previsto, data.esteira, 5) : '<div class="col m-0 p-0"> N / A </div>'}
          ${data.tipo == "Esquadria" ? dataValidator(data.previsto, data.vidro, 21) : '<div class="col m-0 p-0"> N / A </div>'}
          <div class="col m-0 p-0">${dataValidator(data.previsto, data.corte, 5)}</div>
          ${data.tipo == "Esquadria" ? dataValidator(data.previsto, data.usinagem, 3) : '<div class="col m-0 p-0"> N / A </div>'}
          <div class="col m-0 p-0">${dataValidator(data.previsto, data.montagem, 1)}</div>
          <div class="col-1 text-end">
            <a href="./update.php?os=${data.id}" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem">
              <i class="bi bi-pencil-fill"></i>
            </a>
            <a href="./controller.php?os=${data.id}&action=delete" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem" onclick="return confirm('Tem certeza que deseja excluir essa O.S? (${data.id})')">
              <i class="bi bi-trash-fill"></i>
            </a>
          </div>
        `;

        return row;
      }

      async function filtrar(event) {
        event.preventDefault();

        let div = document.getElementById("Table");
        
        while (div.children.length > 1) {
          div.removeChild(div.lastChild);
        }

        req = await search();
        console.log(req);
        
        if(req.length > 0) {
          div.className = "wrapper w-100 fs-4 my-1 px-4";
          div.innerHTML = `
          <div class="row fs-4 fw-bold d-flex align-items-center p-1 border-bottom border-2 border-white">
            <div class="col-1">O.S</div>
            <div class="col">Obra</div>
            <div class="col">Status</div>
            <div class="col">Previsto</div>
            <div class="col m-0 p-0">Perfil</div>
            <div class="col m-0 p-0">Componente</div>
            <div class="col m-0 p-0">Esteira</div>
            <div class="col m-0 p-0">Vidro</div>
            <div class="col m-0 p-0">Corte</div>
            <div class="col m-0 p-0">Usinagem</div>
            <div class="col m-0 p-0">Montagem</div>
            <div class="col-1"></div>
          </div>`;

          req.map(element => div.appendChild(render(element)));
        } else {
          div.className = "w-75 fs-4 my-3";
          div.innerHTML = "<p class='alert alert-danger'>Nenhum resultado foi encontrado!</p>";
        }

      }
    </script>
  </body>
</html>
