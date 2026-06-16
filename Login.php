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
            main {
                font-size: large;
            }
            #for {
                background-color: var(--verde);
                color: white;
                border-radius: 20px;
            }
            footer {
                background-color: var(--verde);
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
                    <!-- <li><a href="News.php">Newsletter</a></li> -->
                    <li><a href="login.php" class="fw-bold text-decoration-underline">Entre</a></li>
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
                        
                        <div class="card" style="width: 18rem;" id="for">
                            <div class="card-body">
                                <h5 class="card-title text-center" id="titulo">Login</h5>
                                <hr>
                                
                                <?php if(isset($erroLogin)): ?>
                                    <div class="alert alert-danger p-2 text-center" style="font-size: 14px;">
                                        <?php echo $erroLogin; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label" id="email">E-mail:</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label" id="senha">Senha:</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="senha" required>
                                    </div>

                                    <div class="mb-3 form-check"> 
                                        <input type="checkbox" class="form-check-input" id="mostrar">
                                        <label class="form-check-label" for="mostrar" id="label-mostrar">Mostrar senha.</label>
                                    </div>
                                    <a href="Cadastro.php" class="text-center text-decoration-underline fw-bold">Não possui login?</a>
                                    
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success btn-lg w-100 mb-2">Entrar</button>
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
    </body>
</html>