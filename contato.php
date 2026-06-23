<?php
include ('Conexao.php');

// Variável para armazenar o estado do SweetAlert
$alert_script = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Limpeza padrão para campos normais contra SQL Injection
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $assunto = mysqli_real_escape_string($con, $_POST['assunto']);
    $mensagem = mysqli_real_escape_string($con, $_POST['mensagem']);          

    // Query de inserção
    $query = "INSERT INTO tabContato (nome, email, assunto ,mensagem) 
              VALUES ('$nome', '$email', '$assunto', '$mensagem')";

    $result = mysqli_query($con, $query);

    if($result) 
    {
        $alert_script = "
        <script> 
        Swal.fire({
            title: 'Sucesso!',
            text: 'Mensagem enviada com sucesso!',
            icon: 'success',
        });
        </script>";
    }       
    else 
    {
        $alert_script = "
        <script> 
        Swal.fire({
            title: 'Erro',
            html: 'Não foi possível salvar a mensagem no banco.',
            icon: 'error'
        });
        </script>";
    }
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Formulário de Contato</title>
        <meta charset="utf-8"/>
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

        <style>
        #nossoprojeto {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 20px;
            background-color: var(--verde);
            padding: 40px;
            color: white;
            border-radius: 40px;
            margin: 20px auto;
            max-width: 90%;
        }

        #prints {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        @media(max-width: 1000px) {
            #prints {
                flex-direction: column;
                align-items: center;
            }
            footer, main {
                top: 0;
            }
        }
        #nome
        {
            background-color: var(--verdeescuro);
            width: 600px;
            height: 100px;
            resize: none;
            border-radius: 5px;
            font-size: 20px;
            color: white;
            /* cursor: help; */
        }
        #email
        {
            background-color: var(--verdeescuro);
            width: 600px;
            height: 130px;
            resize: none;
            border-radius: 5px;
            font-size: 20px;
            color: white;
            /* cursor: help; */
        }
        #assunto 
        {
            background-color: var(--verdeescuro);
            width: 600px;
            height: 100px;
            resize: none;
            border-radius: 5px;
            font-size: 20px;
            color: white;
            /* cursor: help; */
        }
        #mensagem 
        {
            background-color: var(--verdeescuro);
            width: 600px;
            height: 370px;
            resize: none;
            border-radius: 5px;
            font-size: 20px;
            color: white;
            /* cursor: help; */
        }
        #contato 
        {
            display: flex;
            flex-direction: column;
            justify-content: baseline;
        }
        #lbl 
        {
            font-size:20px;
            font-weight: bold;
        }
        #mensagem::placeholder
        {
            color: white;
            opacity: 0.7;
            
        }
        #nome::placeholder
        {
            color: white;
            opacity: 0.7;
        }
        #email::placeholder
        {
            color: white;
            opacity: 0.7;
        }
        #assunto::placeholder
        {
            color: white;
            opacity: 0.7;
        }
        </style>
    </head>
    <body>
        <header>
            <nav class="navbar">
                <div class="overlay"></div>
                <div class="logo fs-3">
                    <img src="img/Logo.png" alt="" class="img-fluid ms-5" width="190px" height="150px" id="logo1">
                </div>
                <div class="theme-switch-wrapper">
                    <span id="mode-label" class="fw-bold text-white">Trocar Tema</span>
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" id="checkbox" />
                        <div class="slider round"></div>
                    </label>
                </div>
                <ul class="nav-links fs-3">
                    <li><a href="index.html">Início</a></li>
                    <!-- <li><a href="nosso_projeto.html">Nosso Projeto</a></li>
                    <li><a href="">História</a></li>
                    <li><a href="proposito.html">Propósito  </a></li> -->
                    <li><a href="contato.php" class="botoes fw-bold text-decoration-underline">Contato</a></li>
                    <!-- <li><a href="FAQ.html">Dúvidas</a></li> -->
                    <!-- <li><a href="News.php">Newsletter</a></li> -->
                    <li><a href="login.php" class="botoes" disable>Entre</a></li>
                </ul>

                <div class="menu-toggle" id="mobile-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>  
        </header>

        <main class="flex flex-col min-h-screen vw-100 p-0">
            <section id="projeto">
                <br><br><br><br><br>
                <h1 class="text-center m-4">Formas de contatar-nos:</h1>   
                <p class="text-center container" id="nossoprojeto">Telefone: (11)4125-2288 <br> E-mail: healthsense@gmail.com <br> Endereço: Avenida Pereira Barreto - Baeta Neves - São Bernardo do Campo - CEP: 09751-000</p>
            </section>

            <h3 class="text-center m-6">Utilize o formulário abaixo para enviar suas reclamações, dúvidas e sugestões.</h3>
            <br>
            
            <section id="contato">
                <form action="contato.php" method="POST">
                    <label id="lbl">Nome:</label>
                    <br>
                    <textarea name="nome" id="nome" placeholder="Digite aqui o seu nome completo." required maxlength="200" data-maxlength="200" rows="5"></textarea>
                    <div id="contador">0 / 200</div>
                    <br>
                    <label id="lbl">E-mail:</label>
                    <br>
                    <textarea name="email" id="email" placeholder="Digite aqui o seu e-mail para lhe contatarmos posteriormente." required maxlength="256" data-maxlength="256" rows="5"></textarea>
                    <div id="contador">0 / 256</div>
                    <br>
                    <label id="lbl">Assunto:</label>
                    <br>
                    <textarea name="assunto" id="assunto" placeholder="Digite aqui o assunto da mensagem." required data-maxlength="200"></textarea>
                    <div id="contador">0 / 200</div>
                    <br>
                    <label id="lbl">Mensagem:</label>
                    <br>
                    <textarea name="mensagem" id="mensagem" placeholder="Digite aqui a sua mensagem." required data-maxlength="700"></textarea>
                    <div id="contador">0 / 700</div>
                    <br><br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Enviar Mensagem</button>
                        <!-- <br><br> -->
                        <button type="reset" class="btn btn-danger">Limpar Mensagem</button>
                    </div>
                </form>
            </section>
            <br><br><br><br>
        </main>

        <footer class="mt-auto container-fluid vw-100 text-center">
             <div class="text-center container">
              <h3 class="text-center container" id="copy">&copy; HealthSense Systems</h3>
             </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>
        <script>
        document.querySelectorAll('textarea[data-maxlength]').forEach(textarea => {
  // Pega o limite definido no HTML
  const limite = parseInt(textarea.getAttribute('data-maxlength'), 10);
  const contador = textarea.nextElementSibling; // Assume que o contador está logo abaixo

  textarea.addEventListener('input', () => {
    // Corta o texto caso ultrapasse o limite
    if (textarea.value.length > limite) {
      textarea.value = textarea.value.substring(0, limite);
    }
    
    // Atualiza o texto do contador
    if (contador) {
      contador.textContent = `${textarea.value.length} / ${limite}`;
    }
  });
});
        </script>
        <?php echo $alert_script; ?>
    </body>
</html>