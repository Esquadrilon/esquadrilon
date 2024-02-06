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

  <title>Consultar Lista</title>
</head>

<body>
  <?php
    include_once('../../config/db/connection.php');
    include_once('../../includes/navbar.php');
    include_once('../../includes/toast.php');
  ?>
  <main class="container-fluid d-flex justify-content-center align-items-center my-3 w-100 flex-column">
    <div class="wrapper p-3 my-1 w-25 fs-4">
      <h1 class="text-center fs-1">Lista</h1>
      <form action="./resultado.php" method="post" id="form">
        <div class="mt-4" id="lista">

        </div>
        <div class="d-flex justify-content-end mt-4">
          <button class="btn btn-primary text-white fs-6 fw-bold">
            <i class="bi bi-search"></i> Pesquisar
          </button>
        </div>
      </form>
    </div>
  </main>
  <footer>

  </footer>
  <script>
    var lista = document.getElementById("lista");
    function newRow() {
      var row = document.createElement("div");
      row.className = "row my-2";
      row.innerHTML = `
        <div class="col">
          <label for="perfil[]">Perfil</label>
          <select name="perfil[]" class="form-select" onfocus="newRow()">
            <option value="" selected>Selecione...</option>
          </select>
        </div>
      `;

      lista.appendChild(row);

      var select = row.querySelector("select[name='perfil[]']");
      fetch('../Perfis/listar_perfis.php')
        .then(response => response.json())
        .then(data => {
          console.log(data);
          
          data.forEach(perfil => {
            var option = document.createElement('option');
            option.value = perfil['codigo'];
            option.textContent = perfil['codigo'];
            select.appendChild(option);
          });
        })
        .catch(error => console.error('Erro ao buscar os perfis: ' + error));
    }

    newRow();
  </script>
</body>

</html>