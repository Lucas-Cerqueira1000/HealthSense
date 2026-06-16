<!doctype html>
<html lang="pt-br">
    <head>
        <title>Newsletter</title>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.css">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
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

            <link rel="stylesheet" href="src/main-style.css">
    </head>
    <style>
        #nome, #senha, #email, #mostrar, #titulo, #confirmarsenha
    {
      color: white;
      font-weight: bold;
    }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: var(--bege);
      font-family: Comfortaa;
    }
    
    main {
      font-size: large;
    }

    #for {
      background-color: var(--verde);
      color: white;
      border-radius: 20px;
    }
    footer
    {
      background-color: var(--verde);
    }
    </style>
    <body>
    <?php
    include ('Conexao.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
    
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $query = "INSERT INTO tabEmail(email) VALUES ('$email')";

    $result = mysqli_query($con, $query);

    // Agora o Swal.fire() vai funcionar perfeitamente aqui!
    if ($result) {
        echo '<script> 
        Swal.fire({
            title: "Sucesso!",
            html: "E-mail cadastrado com sucesso(recurso ainda não funcional): ' . $email . ' ",
            icon: "success"
        });
        </script>';
    } else {
        echo '<script> 
        Swal.fire({
            title: "Erro",
            html: "Não foi possível salvar os dados.",
            icon: "error"
        });
        </script>';
    }
}
?>
        <header>
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
            <li><a href="index.html">Início</a></li>
            <li><a href="nosso_projeto.html">Nosso Projeto</a></li>
            <li><a href="historia.html">História</a></li>
            <li><a href="proposito.html">Propósito</a></li>
            <li><a href="contato.php">Contato</a></li>
            <li><a href="FAQ.html">Dúvidas</a></li>
            <li><a href="News.php" class="fw-bold text-decoration-underline">Newsletter</a></li>
            <li><a href="login.php">Entre</a></li>
        </ul>
        

        <div class="menu-toggle bg-" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </nav>  
        </header>
        <main class="flex flex-col min-h-screen vw-100 p-0">
           <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 d-flex justify-content-center">
                        
                        <div class="card" style="width: 50rem;" id="for">
                            <div class="card-body">
                                <h5 class="card-title text-center" id="titulo">Inscrição Newsletter</h5>
                                <hr>
                                
                                <form method="POST" action="News.php">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label" id="email">E-mail:</label>
                                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Recurso não disponível." readonly>
                                    </div>
 
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success btn-lg w-100 mb-2" disabled>Inscrever</button>
                                        <button type="reset" class="btn btn-danger btn-lg w-100" disabled>Cancelar</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
        <footer class="mt-auto container-fluid vw-100 text-center">
             <div class="text-center container">
              <h3 class="text-center container" id="copy">&copy HealthSense Systems</h3>
             </div>
        </footer>
        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>
        </body>
</html>