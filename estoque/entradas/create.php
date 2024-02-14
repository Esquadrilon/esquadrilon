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

  <title>Cadastro Entrada</title>
</head>

<body>
  <?php
    include_once('../../config/db/connection.php');
    include_once('../../includes/navbar.php');
    include_once('../../includes/toast.php');
  ?>
  <main class="container d-flex justify-content-center align-items-center my-5">
    <div class="wrapper p-4 my-1 w-100 fs-4">
      <h1 class="text-center fs-1">Entrada</h1>
      <form action="./controller.php" method="post" id="form">
        <input type="hidden" name="acao" value="cadastrar">

        <div class="row mt-2">
          <div class="col">
            <label for="obra_id">Obra</label>
            <select name="obra_id" id="obra_id" class="form-select" required>
              <option value="" selected>Selecione...</option>
              <?php
              $obras = $conn->query("SELECT * FROM obras");
              while ($obra = $obras->fetch_object()) {
                print "<option value='$obra->id'> $obra->nome </option>";
              }
              ?>
            </select>
          </div>

          <div class="col">
            <label for="cor_fixa">Cor</label>
            <select name="cor_fixa" id="cor_fixa" onchange="newRow()" class="form-select" required>
              <option value="" selected>Selecione...</option>
              <?php
              $cores = $conn->query("SELECT * FROM cores");
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
            <input type="text" name="origem" id="origem" class="form-control" placeholder="Perfil Aluminio" required>
          </div>

          <div class="col">
            <label for="destino">Destino</label>
            <input type="text" name="destino" id="destino" class="form-control" placeholder="1 Lote Torre">
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <label for="nota">Nota Fiscal</label>
            <input type="text" name="nota" id="nota" class="form-control" placeholder="NF 16341">
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
  <footer>

  </footer>
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
      newRow.className = "row my-2";

      newRow.innerHTML = `
        <div class="col">
          <label for="perfil[]">Perfil</label>
          <select name="perfil[]" class="form-select">
            <option value="" selected>Selecione...</option>
          </select>
        </div>

        <div class="col">
          <label for="tamanho[]">Tamanho</label>
          <input type="number" name="tamanho[]" min="1000" max="9999" value="6000" class="form-control" placeholder="6000mm">
        </div>

        <div class="col">
          <label for="cor_id[]">Cor</label>
          <select name="cor_id[]" class="form-select">
            <option value="" selected>Selecione...</option>
          </select>
        </div>

        <div class="col">
          <label for="quantidade[]">Quantidade</label>
          <input type="number" name="quantidade[]" min="1" class="form-control" placeholder="1" onfocus="newRow()">
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

      var corSelect = newRow.querySelector("select[name='cor_id[]']");
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