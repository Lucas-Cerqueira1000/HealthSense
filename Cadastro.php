<!doctype html>
<html lang="pt-br">
    <head>
        <title>Formulário Cadastro Hospitais</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="src/main-style.css">
        
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap');
            
            .estilo-label {
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
include ('Conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Limpeza padrão para campos normais contra SQL Injection
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $telefone = mysqli_real_escape_string($con, $_POST['telefone']);
    $cep = mysqli_real_escape_string($con, $_POST['cep']);
    $rua = mysqli_real_escape_string($con, $_POST['rua']);
    $cidade = mysqli_real_escape_string($con, $_POST['cidade']);
    $bairro = mysqli_real_escape_string($con, $_POST['bairro']);
    $estado = mysqli_real_escape_string($con, $_POST['estado']);
    
    // CORREÇÃO 1: Pegando a variável correta vinda do POST ($_POST['senha'])
    // CORREÇÃO 2: Não use mysqli_real_escape_string aqui para não corromper os caracteres especiais do hash
    $senhaCrua = $_POST['senha']; 
    $senha = password_hash($senhaCrua, PASSWORD_DEFAULT);            

    // Query de inserção
    $query = "INSERT INTO tabHospitais(email, nome, telefone, cep, rua, cidade, bairro, estado, senha) 
              VALUES ('$email', '$nome', '$telefone', '$cep', '$rua', '$cidade', '$bairro', '$estado', '$senha')";

    $result = mysqli_query($con, $query);

    if ($result) {
        echo '<script> 
        Swal.fire({
            title: "Sucesso!",
            text: "Hospital cadastrado com sucesso! Clique no botão para ser redirecionado.",
            icon: "success",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "Login.php";
            }
        });
        </script>';
        exit; 
    }       
    else 
    {
        echo '<script> 
        Swal.fire({
            title: "Erro",
            html: "Não foi possível salvar os dados no banco.",
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
                        
                        <div class="card" style="width: 40rem;" id="for">
                            <div class="card-body">
                                <h5 class="card-title text-center text-white fw-bold" id="titulo-card">Cadastro P/Hospitais</h5>
                                <hr>
                                
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="txtEmail" class="form-label estilo-label">E-mail:</label>
                                        <input type="email" class="form-control" id="txtEmail" name="email" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="txtNome" class="form-label estilo-label">Nome da Instituição:</label>
                                        <input type="text" class="form-control" id="txtNome" name="nome" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="telefone" class="form-label estilo-label">Telefone:</label>
                                        <input type="tel" class="form-control" id="telefone" placeholder="(XX) 9XXXX-XXXX" maxlength="15" name="telefone" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="txtCep" class="form-label estilo-label">CEP:</label>
                                        <input type="text" class="form-control" id="txtCep" placeholder="" maxlength="9" name="cep" required>
                                    </div>
                                    
                                    <div class="mb-3 text-center">
                                        <button type="button" id="btnPesquisar" class="btn btn-primary w-100 fw-bold">Pesquisar CEP</button>
                                    </div>

                                    <div class="mb-3">
                                        <label for="txtRua" class="form-label estilo-label">Rua:</label>
                                        <input type="text" class="form-control" placeholder="Preenchimento automático" id="txtRua" name="rua" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="txtCidade" class="form-label estilo-label">Cidade:</label>
                                        <input type="text" class="form-control" id="txtCidade" name="cidade" readonly placeholder="Preenchimento automático">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="txtBairro" class="form-label estilo-label">Bairro:</label>
                                        <input type="text" class="form-control" id="txtBairro" name="bairro" readonly placeholder="Preenchimento automático">
                                    </div>

                                    <div class="mb-3">
                                        <label for="txtEstado" class="form-label estilo-label">Estado:</label>
                                        <input type="text" class="form-control" id="txtEstado" name="estado" readonly placeholder="Preenchimento automático">
                                    </div>

                                    <div class="mb-3">
                                        <label for="txtSenha" class="form-label estilo-label">Senha:</label>
                                        <input type="password" class="form-control classe-senha" id="txtSenha" name="senha" minlength="8" placeholder="Mínimo de 8 caracteres" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="txtConfirmSenha" class="form-label estilo-label">Confirmar Senha:</label>
                                        <input type="password" class="form-control classe-senha" id="txtConfirmSenha" name="comfsenha" minlength="8" placeholder="Mínimo de 8 caracteres" required>
                                        <div id="senhaFeedback" class="form-text text-warning fw-bold" style="display:none;">As senhas não batem ou possuem menos de 8 caracteres.</div>
                                    </div>
                                    
                                    <div class="mb-3 form-check"> 
                                        <input type="checkbox" class="form-check-input" id="chkMostrar">
                                        <label class="form-check-label text-white fw-bold " for="chkMostrar">Mostrar senhas</label>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <a href="Login.php" class="text-center text-decoration-underline">Possui login?</a>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" id="btnCadastrar" name="btnCadastrar" class="btn btn-success btn-lg w-100 mb-2" disabled>Cadastrar</button>
                                        <button type="reset" class="btn btn-danger btn-lg w-100">Cancelar</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>

        <footer class="py-3 mt-auto text-white text-center w-100">
            <div class="container">
                <h3 class="text-center container" id="copy">&copy; HealthSense Systems</h3>
            </div>
        </footer>

        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>
        
        <script>
            $(document).ready(function() {
                // Lógica para Mostrar/Ocultar Senhas
                $("#chkMostrar").on('change', function() {
                    let camposSenha = $(".classe-senha");
                    if ($(this).is(':checked')) {
                        camposSenha.attr("type", "text");
                    } else {
                        camposSenha.attr("type", "password");
                    }
                });

                // REQUISIÇÃO VIA JAVASCRIPT (AJAX/JQUERY)
                $("#btnPesquisar").on('click', function() {
                    let cep = $("#txtCep").val().replace(/\D/g, '');

                    if (cep.length === 8) {
                        $("#txtRua, #txtBairro, #txtCidade, #txtEstado").val("Buscando...");
                        let url = "https://viacep.com.br/ws/" + cep + "/json/";

                        $.getJSON(url, function(dados) {
                            if (!("erro" in dados)) {
                                $("#txtRua").val(dados.logradouro);
                                $("#txtBairro").val(dados.bairro);
                                $("#txtCidade").val(dados.localidade);
                                $("#txtEstado").val(dados.uf);
                            } else {
                                limpa_formulario_cep();
                                Swal.fire({
                                    title: "Atenção:",
                                    text: "O CEP informado não foi encontrado.",
                                    icon: "info"
                                });
                            }
                        }).fail(function() {
                            limpa_formulario_cep();
                            Swal.fire({
                                title: "Erro:",
                                text: "Erro ao conectar com o serviço de busca de CEP.",
                                icon: "error"
                            });
                        });
                    } else {
                        Swal.fire({
                            title: "Erro:",
                            text: "Por favor, digite um CEP válido com 8 dígitos.",
                            icon: "error"
                        });
                    }
                });

                function limpa_formulario_cep() {
                    $("#txtRua, #txtBairro, #txtCidade, #txtEstado").val("");
                }
            });
        </script>
        
        <script>
            // Máscaras de Input (Telefone e CEP)
            const inputCelular = document.getElementById('telefone');
            inputCelular.addEventListener('input', (e) => {
                let valor = e.target.value.replace(/\D/g, ''); 
                if (valor.length > 11) valor = valor.slice(0, 11);
                if (valor.length > 6) {
                    valor = valor.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
                } else if (valor.length > 2) {
                    valor = valor.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
                } else if (valor.length > 0) {
                    valor = valor.replace(/^(\d*)$/, '($1');
                }
                e.target.value = valor;
            });

            const inputCep = document.getElementById('txtCep');
            inputCep.addEventListener('input', (e) => {
                let valor = e.target.value.replace(/\D/g, '');
                if (valor.length > 8) valor = valor.slice(0, 8);
                if (valor.length > 5) {
                    valor = valor.replace(/^(\d{5})(\d{3})$/, '$1-$2');
                }
                e.target.value = valor;
            });
        </script>

        <script type="text/javascript">
            const campoSenha = document.getElementById('txtSenha');
            const campoConfirmarSenha = document.getElementById('txtConfirmSenha');
            const botaoCadastrar = document.getElementById('btnCadastrar');
            const feedback = document.getElementById('senhaFeedback');

            function verificaCampos() {
                const senha = campoSenha.value;
                const confSenha = campoConfirmarSenha.value;

                // Verifica se as senhas batem e têm tamanho mínimo de 8 caracteres
                if(senha === confSenha && senha.length >= 8) {
                    botaoCadastrar.disabled = false;
                    feedback.style.display = "none";
                } else {
                    botaoCadastrar.disabled = true;
                    // Só exibe o aviso se o usuário já tiver começado a digitar a confirmação
                    if(confSenha.length > 0) {
                        feedback.style.display = "block";
                    }
                }
            }

            // Ouve as mudanças em tempo real em ambos os campos
            campoSenha.addEventListener('input', verificaCampos);
            campoConfirmarSenha.addEventListener('input', verificaCampos);
        </script>
    </body>
</html>