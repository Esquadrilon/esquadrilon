<header class="w-100">
  <nav class="navbar bg-black rounded">
    <div class="container-fluid d-flex justify-content-around align-items-center">
      <button class="btn fs-3 text-custom-1" id="btn-volta-pagina">
        <i class="bi bi-arrow-left"></i>
      </button>

      <button class="navbar-toggler m-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#NavBar" aria-controls="NavBar" aria-label="Toggle navigation">
        <img src="/esquadrilon/assets/img/Logo.svg" alt="Logo Esquadrilon" style="width: 40px">
      </button>

      <button class="btn fs-3 text-custom-1" id="btn-avanca-pagina">
        <i class="bi bi-arrow-right"></i>
      </button>

      <div class="offcanvas offcanvas-start" tabindex="-1" id="NavBar" aria-labelledby="NavBarLabel">
        <div class="offcanvas-header bg-black">
          <h2 class="offcanvas-title fs-4 text-white" id="NavBarLabel">
            Esquadrilon
          </h2>
          <button type="button" class="btn-close bg-white rounded" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 fs-5 fw-bold">
            <li class="nav-item">
              <a class="nav-link" href="\esquadrilon\">
                <i class="fs-4 bi bi-house"></i> • Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="\esquadrilon\clientes\">
                <i class="fs-4 bi bi-person"></i> • Clientes
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="\esquadrilon\obras\">
                <i class="fs-4 bi bi-building"></i> • Obras
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fs-4 bi bi-truck"></i> • Estoque
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="\esquadrilon\estoque\">
                    <i class="fs-4 bi bi-house"></i> • Estoque
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <a class="dropdown-item" href="\esquadrilon\estoque\entradas\">
                    <i class="fs-4 bi bi-plus"></i> • Entradas
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="\esquadrilon\estoque\reservas\">
                    <i class="fs-4 bi bi-box-seam"></i> • Reservas
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="\esquadrilon\estoque\saidas\">
                    <i class="fs-4 bi bi-dash"></i> • Saídas
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <a class="dropdown-item" href="\esquadrilon\estoque\perfis\">
                    <i class="fs-4 bi bi-slash"></i> • Perfis
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="\esquadrilon\estoque\cores\"> 
                    <i class="fs-4 bi bi-palette"></i> • Cores
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fs-4 bi bi-list-check"></i> • Processos
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="\esquadrilon\processos\">
                    <i class="fs-4 bi bi-hourglass"></i> • Pendentes
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="\esquadrilon\processos\list.php">
                  <i class="fs-4 bi bi-calendar"></i> • Geral
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <a class="dropdown-item" href="\esquadrilon\processos\create.php">
                    <i class="fs-4 bi bi-calendar-event"></i> • Cadastrar Processo
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://192.168.0.112:9090/tst.php">
                <i class="fs-4 bi bi-box-arrow-right"></i> • Sair
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <script>
    document.getElementById('btn-volta-pagina').addEventListener('click', function() {
      window.history.back();
    });

    document.getElementById('btn-avanca-pagina').addEventListener('click', function() {
      window.history.forward();
    });
  </script>
</header>