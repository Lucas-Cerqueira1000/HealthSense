<?php
// 1. A SESSÃO E O PROCESSAMENTO DE LOGIN DEVEM FICAR NO TOPO ABSOLUTO
session_start();

$host = 'tcc_bd35.mysql.dbaas.com.br';
$dbname = 'tcc_bd35';
$username = 'tcc_bd35';
$password = "ROSA123456a#";

try
{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) 
{
    die("Erro na conexão com o banco: " . $e->getMessage());
}

$erroLogin = null;

// Verifica se os campos foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // O trim remove espaços acidentais antes ou depois do texto digitado
    $usuario = trim($_POST['email']);
    $senha = trim($_POST['senha']); 

    // 1º PASSO: Tenta buscar na tabela de Hospitais
    $stmt = $pdo->prepare("SELECT ID, nome, email, senha, 'hospital' AS tipo FROM tabHospitais WHERE email = :usuario");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2º PASSO: Se não achou nos hospitais, busca na tabela de Pacientes
    if (!$user) {
        $stmt = $pdo->prepare("SELECT ID, nome, email, senha, 'paciente' AS tipo FROM tabPacientes WHERE email = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3º PASSO: Valida o usuário encontrado
    if ($user) {
        // Valida se a senha bate por password_verify OU por igualdade direta (para aceitar os IDs de 2 a 7 em texto limpo)
        if (password_verify($senha, $user['senha']) || $senha === $user['senha']) {
            
            // Autenticação bem-sucedida, cria as variáveis de sessão
            $_SESSION['usuario_id']   = $user['ID'];
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['usuario_tipo'] = $user['tipo'];

            // Redireciona para a página correspondente
            header("Location: inicio.php");
            exit();
        } else {
            $erroLogin = "Senha incorreta.";
        }
    } else {
        $erroLogin = "E-mail não cadastrado.";
    }
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <link rel="icon" href="img/logo1.png">
        <title>Formulário de Login</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="src/main-style.css">
        
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap');
            #nome, #senha, #email, #mostrar, #titulo, #confirmarsenha {
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
            main 
            {
                font-size: large;
                /* background: url(img/gif.gif); */
                
            }
            #imagem 
            {
                position: relative;
                /* height: 40px; */
                background-size: cover;          /* Faz a imagem cobrir toda a área */
                background-position: center;     /* Centraliza a imagem na tela */
                background-repeat: no-repeat;    /* Evita que a imagem se repita */
                background-attachment: fixed;    /* Mantém a imagem fixa ao rolar a página */
                height: 100vh;                   /* Ocupa 100% da altura da tela */
                margin: 0;                       /* Remove a margem padrão do navegador */
                padding: 0;                      /* Remove o padding padrão do navegador */
            }
            #for {
                background-color: var(--verde);
                color: white;
                border-radius: 20px;
            }
            footer {
                background-color: var(--verde);
            }

            /* --- ESTILOS ADICIONADOS PARA FUNCIONAMENTO DO SPINNER --- */
            #btnEntrar.ativo .texto-botao {
                visibility: hidden;
                opacity: 0;
            }
            #btnEntrar.ativo .spinner {
                visibility: visible !important;
                opacity: 1 !important;
            }
            .spinner {
                visibility: hidden;
                opacity: 0;
                width: 20px;
                height: 20px;
                border: 4px solid rgba(255, 255, 255, 0.3);
                border-top-color: white;
                border-radius: 50%;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -10px;
                margin-left: -10px;
                animation: girar 1s linear infinite;
            }
            @keyframes girar {
                to { transform: rotate(360deg); }
            }
            
            /* --- ESTILOS DO EFEITO INPUT FLUTUANTE --- */
            .input-container {
                position: relative;
                width: 100%;
                margin: 25px 0;
                color: white;
            }

            .input-container input {
                width: 100%;
                color: white;
                padding: 15px;
                font-size: 16px;
                border: 1px solid #dadce0;
                border-radius: 4px;
                outline: none;
                transition: border-color 0.3s, box-shadow 0.3s;
                background-color: transparent;
                color: white; /* Garante que o texto digitado fique visível no fundo escuro */
            }

            /* Efeito ao clicar no input (Bordas azuis) */
            .input-container input:focus {
                border-color: #1a73e8;
                box-shadow: 0 0 0 1px #1a73e8;
            }

            .input-container label {
                position: absolute;
                left: 15px;
                top: 50%;
                color: white;
                transform: translateY(-50%);
                color: #80868b;
                font-size: 16px;
                background-color: var(--verde, #ffffff); /* Adapta ao fundo do card */
                padding: 0 5px;
                pointer-events: none;
                transition: all 0.2s ease-out;
            }

            /* Animação: Quando o input está em foco OU preenchido */
            .input-container input:focus ~ label,
            .input-container input:not(:placeholder-shown) ~ label {
                top: 0;
                transform: translateY(-50%) scale(0.85);
                color: #1a73e8;
            }

            /* Mantém a label cinza quando não está em foco e está vazia */
            .input-container input:placeholder-shown ~ label {
                color: #80868b;
            }
            #exampleInputPassword1, #exampleInputEmail1
            {
                color: white;
                font-weight: bold;
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
                    <li><a href="index.html" id="inicio">Início</a></li>
                    <li><a href="contato.php" class="botoes" id="contato1">Contato</a></li>
                    <li><a href="login.php" class="fw-bold text-decoration-underline botoes" id="entre">Entre</a></li>
                </ul>
                <div class="menu-toggle" id="mobile-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>  
        </header>

        <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 d-flex justify-content-center">
                        
                        <div class="card" style="width: 38rem;" id="for">
                            <div class="card-body">
                                <h5 class="card-title text-center" id="titulo">Login</h5>
                                <hr>
                                
                                <?php if(isset($erroLogin)): ?>
                                    <div class="alert alert-danger p-2 text-center" style="font-size: 14px;">
                                        <?php echo $erroLogin; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="" id="formlogin">
                                    
                                    <div class="input-container">
                                        <input type="email" id="exampleInputEmail1" placeholder=" " name="email" required>
                                        <label for="exampleInputEmail1" >Digite seu e-mail</label>
                                    </div>
                                    
                                    <div class="input-container">  
                                        <input type="password" id="exampleInputPassword1" name="senha" required placeholder=" ">
                                        <label for="exampleInputPassword1">Digite sua senha</label>
                                    </div>

                                    <div class="mb-3 form-check"> 
                                        <input type="checkbox" class="form-check-input" id="mostrar">
                                        <label class="form-check-label text-white fw-bold" for="mostrar" id="label-mostrar">Mostrar senha.</label>
                                    </div>
                                    
                                    <a href="Cadastro.php" class="text-center text-decoration-underline fw-bold d-block mb-3">Não possui login?</a>
                                    
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success btn-lg w-100 mb-2 position-relative" id="btnEntrar">
                                            <span class="texto-botao">Entrar</span>
                                            <span class="spinner"></span>
                                        </button>                                        
                                        <button type="reset" class="btn btn-danger btn-lg w-100">Cancelar</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>

        <footer class="mt-auto text-white text-center w-100 py-3">
            <div class="container">
              <h3 class="text-center container" id="copy">&copy; HealthSense Systems</h3>
            </div>
        </footer>

        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>
        <script>
            // Script do checkbox de ocultar/mostrar senha
            $(document).ready(function() {
                $("#mostrar").on('change', function() {
                    if ($(this).is(':checked')) {
                        $("#exampleInputPassword1").attr("type", "text");
                    } else {
                        $("#exampleInputPassword1").attr("type", "password");
                    }
                });
            });
        </script>
        <script>
        const formlogin = document.getElementById("formlogin");
        const botaosalvar = document.getElementById("btnEntrar");
            
        formlogin.addEventListener("submit", function(e) {
            // 1. Ativa a classe de carregamento visual
            botaosalvar.classList.add("ativo");
            
            // 2. Para não travar o envio do formulário, usamos o setTimeout 
            // para desabilitar o botão um milissegundo depois do clique
            setTimeout(function() {
                botaosalvar.disabled = true;
            }, 10);
        });
        </script>
    </body>
</html>