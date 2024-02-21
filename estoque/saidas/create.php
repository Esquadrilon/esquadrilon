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

  <title>Cadastro Saída</title>
</head>

<body>
  <?php
    include_once('../../config/db/connection.php');
    include_once('../../includes/navbar.php');
    include_once('../../includes/toast.php');
  ?>
  <main class="container d-flex justify-content-center align-items-center my-5">
    <div class="wrapper p-4 my-1 w-100 fs-4">
      <h1 class="text-center fs-1">Saída</h1>
      <form action="./controller.php" method="post" id="form">
        <input type="hidden" name="acao" value="cadastrar">

        <div class="row mt-2">
          <div class="col">
            <label for="obra_id">Obra</label>
            <select name="obra_id" id="obra_id" class="form-select" required>
              <option value="" selected>Selecione...</option>
              <?php
              $obras = $conn->query("SELECT * FROM obras ORDER BY nome ASC");
              while ($obra = $obras->fetch_object()) {
                print "<option value='$obra->id'> $obra->nome </option>";
              }
              ?>
            </select>
          </div>

          <div class="col">
            <label for="cor_fixa">Cor</label>
            <select name="cor_fixa" id="cor_fixa" onblur="newRow()" class="form-select" required>
              <option value="" selected>Selecione...</option>
              <?php
              $cores = $conn->query("SELECT * FROM cores ORDER BY nome ASC");
              while ($cor = $cores->fetch_object()) {
                print "<option value=\"$cor->id\"> $cor->nome </option>";
              }
              ?>
            </select>
          </div>
        </div>
        
        <div class="row mt-2">
          <div class="col">
            <label for="origem">Origem</label>
            <input type="text" name="origem" id="origem" class="form-control" placeholder="Perfil Aluminio">
          </div>

          <div class="col">
            <label for="destino">Destino</label>
            <input type="text" name="destino" id="destino" class="form-control" placeholder="1 Lote Torre" required>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <label for="romaneio">Romaneio</label>
            <input type="text" name="romaneio" id="romaneio" class="form-control" placeholder="3698">
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

        <div id="itens">
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
  <div id="modals">

  </div>
  <script>
    document.getElementById("form").addEventListener("keydown", function (event) {
      event.keyCode === 13
        ?event.preventDefault()
        : null;
      
    });

    var data = document.getElementById("itens");
    function newRow() {
      data.className = "wrapper bg-dark p-3 mt-3";

      var newRow = document.createElement("div");
      newRow.className = "row my-2 d-flex justify-content-center align-items-center";

      newRow.innerHTML = `
        <div class="col">
          <label for="perfil[]">Perfil</label>
          <select name="perfil[]" class="form-select" onchange="updateModal(this)">
            <option value="" selected>Selecione...</option>
          </select>
        </div>

        <div class="col">
          <label for="tamanho[]">Tamanho</label>
          <input type="number" name="tamanho[]" min="1000" max="9999" value="6000" class="form-control" placeholder="6000mm">
        </div>

        <div class="col">
          <label for="cor[]">Cor</label>
          <select name="cor[]" class="form-select" onchange="updateModal(this)">
          </select>
        </div>

        <div class="col">
          <label for="quantidade[]">Quantidade</label>
          <input type="number" name="quantidade[]" min="1" class="form-control" placeholder="1" onfocus="newRow()">
        </div>

        <div class="col col-auto myButton">
        </div>
      `;
      data.appendChild(newRow);
      var perfilSelect = newRow.querySelector("select[name='perfil[]']");
      fetch('../perfis/search.php')
        .then(response => response.json())
        .then(data => {
          console.log(data);
          
          data.forEach(codigo => {
            var option = document.createElement('option');
            option.value = codigo['codigo'];
            option.textContent = codigo['codigo'];
            perfilSelect.appendChild(option);
          });
        })
        .catch(error => console.error('Erro ao buscar os perfis: ' + error));

      var corSelect = newRow.querySelector("select[name='cor[]']");
      var corFixa = document.getElementById("cor_fixa");
      for (var i = 0; i < corFixa.options.length; i++) {
        var option = document.createElement("option");
        option.value = corFixa.options[i].value;
        option.text = corFixa.options[i].text;

        if (corFixa.options[i].value == corFixa.value) {
          option.selected = true;
        }

        corSelect.appendChild(option);
      }
    }

    function updateModal(e){
      const div = e.parentElement.parentElement;
      const btn = div.querySelector(".myButton");

      var perfil = div.querySelector('select[name="perfil[]"]');
      var cor = div.querySelector('select[name="cor[]"]');
      cor = cor.options[cor.selectedIndex].text;

      btn.innerHTML = `
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-${perfil.value}-${cor.replace(/ /g, "-")}">
        <i class="bi bi-binoculars-fill"></i>
      </button>
      `;
      
      createModal(perfil.value, cor);
    }

    function createModal(perfil, cor){
      const modal = document.createElement("div");
      modal.className = "modal fade";
      modal.id = `modal-${perfil}-${cor.replace(/ /g, "-")}`;
      modal.tabIndex = -1;
      modal.innerHTML = `
      <div class="modal-dialog">
          <div class="modal-content text-dark">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">${perfil} - ${cor}</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="d-flex justify-content-center align-items-center">
                      <img src="http://192.168.0.111:3001/_next/image?url=%2Fapi%2FprofileImage%2F${perfil}.bmp&w=128&q=100" class="card-img-top w-50 h-50" alt="Imagem do perfil ${perfil}">
                  </div>
                  <div class="row mt-3">
                      <div class="col">Obra</div>
                      <div class="col">Tamanho</div>
                      <div class="col">Saldo</div>
                  </div>
                  <div id="content">
                  </div>
              </div>
          </div>
      </div>
      `;

      var URL = `/estoque/search.php?perfil=${perfil}&cor=${cor}`;
      fetch(URL)
        .then(response => response.json())
        .then(data => {
          console.log(data);
          document.querySelector(`#modal-${perfil}-${cor.replace(/ /g, "-")} #content`).innerHTML = "";
          data.forEach(res => {
            if(res.saldo != 0 && res.perfil == perfil){
              const row = document.createElement("div");
              row.className = "row rounded mt-2 py-2";
              row.style.backgroundColor = "rgba(3, 3, 3, 0.3)";
          
              row.innerHTML = `
                <div class="col">${res.obra}</div>
                <div class="col">${res.tamanho}</div>
                <div class="col">${res.saldo}</div>
              `;
              document.querySelector(`#modal-${perfil}-${cor.replace(/ /g, "-")} #content`).appendChild(row);
            }
          });
        })
        .catch(error => console.error('Erro ao buscar os perfis: ' + error));

      document.getElementById("modals").appendChild(modal);
    }

    function clearData() {
      document.getElementById('obra_id').value = '';
      document.getElementById('cor_fixa').value = '';
      document.getElementById('origem').value = '';
      document.getElementById('destino').value = '';
      document.getElementById('nota').value = '';
      document.getElementById('responsavel').value = '';
      document.getElementById('caminhao').value = '';
      document.getElementById('motorista').value = '';
      document.getElementById('observacoes').value = '';
    }
  </script>
</body>

</html>