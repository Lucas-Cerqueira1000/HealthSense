<!doctype html>
<html lang="pt-br">
    <head>
        <title>Recuperação de Senha</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="src/main-style.css">
        
        <style>
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

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. CARREGAR O PHPMAILER (Descomente o autoload caso use Composer, ou faça o require manual das classes)
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    // Caso tenha baixado o PHPMailer manualmente na pasta 'PHPMailer':
    // require 'PHPMailer/src/Exception.php';
    // require 'PHPMailer/src/PHPMailer.php';
    // require 'PHPMailer/src/SMTP.php';
}

include('Conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
    $email = mysqli_real_escape_string($con, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    // 2. Tabela corrigida para tabHospitais (Ajuste para a tabela correta se for 'usuarios')
    $checkUser = mysqli_query($con, "SELECT id FROM tabHospitais WHERE email = '$email'");

    if (mysqli_num_rows($checkUser) > 0) {
        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $updateQuery = "UPDATE tabHospitais SET reset_token = '$token', reset_expira = '$expira' WHERE email = '$email'";
        mysqli_query($con, $updateQuery);

        $link = "http://localhost/Site-TCC/redefinir-senha.php?token=" . $token;

        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = '8939dc6436106c'; 
            $mail->Password   = '285b81a73013fd'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525;

            $mail->setFrom('suporte@seu-site.com', 'HealthSense Systems');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Recuperação de Senha - HealthSense';
            $mail->Body    = "
                <h3>Solicitação de redefinição de senha</h3>
                <p>Clique no link abaixo para criar uma nova senha. O link é válido por 1 hora:</p>
                <p><a href='$link'>$link</a></p>
            ";

            $mail->send();

            echo '<script> 
            Swal.fire({
                title: "E-mail Enviado!",
                text: "Verifique sua caixa de entrada no Mailtrap para redefinir sua senha.",
                icon: "success"
            });
            </script>';

        } catch (Exception $e) {
            echo '<script> 
            Swal.fire({
                title: "Erro no Envio",
                text: "Não foi possível enviar o e-mail: ' . addslashes($mail->ErrorInfo) . '",
                icon: "error"
            });
            </script>';
        }
    } else {
        echo '<script> 
        Swal.fire({
            title: "Atenção",
            text: "Se o e-mail estiver cadastrado, você receberá o link de recuperação.",
            icon: "info"
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
                                <h5 class="card-title text-center" id="titulo">Recuperação de Senha</h5>
                                <hr>
                                
                                <form method="POST" action="" id="formRecuperacao">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label" id="email">E-mail:</label>
                                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Digite um e-mail válido para lhe enviarmos as orientações." required>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" id="btnEnviar" class="btn btn-success btn-lg w-100 mb-2">
                                            <span id="btnText">Enviar</span>
                                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
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

        <footer class="mt-auto container-fluid vw-100 text-center">
            <div class="text-center container">
                <h3 class="text-center container" id="copy">&copy; HealthSense Systems</h3>
            </div>
        </footer>

        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>

        <script>
            document.getElementById('formRecuperacao').addEventListener('submit', function() {
                const btn = document.getElementById('btnEnviar');
                const btnText = document.getElementById('btnText');
                const btnSpinner = document.getElementById('btnSpinner');

                // Desabilita o botão para evitar múltiplos cliques
                btn.disabled = true;
                btnText.textContent = 'Enviando...';
                btnSpinner.classList.remove('d-none');
            });
        </script>
    </body>
</html>