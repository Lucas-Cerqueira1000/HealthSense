<!doctype html>
<html lang="pt-br">
    <head>
        <title>Cadastrar Médicos</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <!-- Link Tailwind -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <!-- <script src="../Tailwind/Tailwind.txt"></script> -->
        <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.css">
        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>
    
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
            ></script>

            <!-- main style -->
             <link rel="stylesheet" href="src/main-style.css">
             <!-- <link rel="stylesheet" href="src/estilos.css"> -->
    </head>
    <body>
        <header>
      <!-- place navbar here -->
      <nav class="navbar">
        <div class="overlay"></div>
        <div class="logo fs-3">
            <img src="img/Logo.png" alt="" class="img-fluid ms-5" width="190px" height="150px" id="logo1">
        </div>
        <div class="theme-switch-wrapper">
                <span id="mode-label" class="fw-bold text-white">Modo Escuro</span>
                <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox" />
                    <div class="slider round"></div>
                </label>
            </div>
        <ul class="nav-links fs-3">
            <li><a href="inicio.php">Início</a></li>
            <li><a href="SeusDados.php">Seus dados</a></li>
            <li><a href="Medicos.php">Médicos</a></li>
            <li><a href="CadastrarMedicos" class="fw-bold text-decoration-underline">Cadastrar Médicos</a></li>
            <li><a href="DeletarMedicos.php">Deletar Médicos</a></li>
            <li><a href="AlterarDadosMedicos.php">Alterar Dados Médicos</a></li>
            <a href="Index.html">Deslogar</a>
        </ul>
        

        <div class="menu-toggle bg-" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </nav>  
        </header>
        <main class="flex flex-col min-h-screen vw-100 p-0">
           
            
        </main>
        <footer class="mt-auto container-fluid vw-100 text-center">
            <!-- place footer here -->
             <div class="text-center container">
              <h3 class="text-center container" id="copy">&copy HealthSense Systems</h3>
             </div>
             
        </footer>
        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>