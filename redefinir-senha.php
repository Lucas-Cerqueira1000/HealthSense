<!doctype html>
<html lang="pt-br">
    <head>
        <title>Home</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <link rel="stylesheet" href="sweetalert2.min.css">
        <script src="https://jsdelivr.net"></script>
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
    <style>
        #nome, #senha, #email, #mostrar, #titulo, #confirmarsenha
    {
      color: white;
      font-weight: bold;
    }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh; /* Garante que o corpo ocupe a tela toda */
      background-color: var(--bege);
      font-family: Comfortaa;
    }
    
    main {
      font-size: large;
      /* Removeu-se o top: 60px e position relative que quebravam o layout */
    }

    #for {
      background-color: var(--verde);
      color: white;
      border-radius: 20px;
      /* Removeu-se o top: -90px; a centralização agora é feita pelo Bootstrap */
    }
    footer
    {
      background-color: var(--verde);
    }
    </style>
    <body>
<?php
include('Conexao.php');

$token = $_GET['token'] ?? '';

if (!empty($token)) {
    // Busca token válido e que não tenha expirado
    $agora = date("Y-m-d H:i:s");
    $query = "SELECT * FROM usuarios WHERE reset_token = '$token' AND reset_expira > '$agora'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Token é válido! Exiba aqui o formulário HTML para o usuário digitar a nova senha
    } else {
        echo "Link inválido ou expirado.";
    }
}
?>
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
        <!-- <ul class="nav-links fs-3">
            <li><a href="index.html">Início</a></li>
            <li><a href="nosso_projeto.html">Nosso Projeto</a></li>
            <li><a href="historia.html">História</a></li>
            <li><a href="proposito.html">Propósito</a></li>
            <li><a href="contato.html">Contato</a></li>
            <li><a href="FAQ.html">Dúvidas</a></li>
            <li><a href="News.php" class="fw-bold text-decoration-underline">Newsletter</a></li>
            <li><a href="login.php">Entre</a></li>
        </ul> -->
        

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
                                
                                <form method="POST" action="News.php">
                                    <div class="mb-3">
                                        <label for="txtSenha" class="form-label estilo-label">Senha:</label>
                                        <input type="password" class="form-control classe-senha" id="txtSenha" name="senha" minlength="8" placeholder="Mínimo de 8 caracteres" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="txtConfirmSenha" class="form-label estilo-label">Confirmar Senha:</label>
                                        <input type="password" class="form-control classe-senha" id="txtConfirmSenha" name="comfsenha" minlength="8" placeholder="Mínimo de 8 caracteres" required>
                                        <div id="senhaFeedback" class="form-text text-warning fw-bold" style="display:none;">As senhas não são iguais.</div>
                                    </div>
                                    
                                    <div class="mb-3 form-check"> 
                                        <input type="checkbox" class="form-check-input" id="chkMostrar">
                                        <label class="form-check-label text-white fw-bold " for="chkMostrar">Mostrar senhas</label>
                                    </div>
                                    <div class="text-center mt-3">
                                          <button type="submit" id="btnCadastrar" name="btnCadastrar" class="btn btn-success btn-lg w-100 mb-2 position-relative" disabled>
                                            <span class="texto-botao">Alterar</span>
                                            <span class="spinner"></span>
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
        <footer class="mt-auto container-fluid vw-100 text-center">
            <!-- place footer here -->
             <div class="text-center container">
              <h3 class="text-center container" id="copy">&copy HealthSense Systems</h3>
             </div>
             
        </footer>
        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>
        <script src="sweetalert2.min.js"></script>
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

                // Limpa o formulário caso o CEP não seja encontrado
                function limpa_formulario_cep() {
                    $("#txtRua, #txtBairro, #txtCidade, #txtEstado").val("");
                }
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

                if(senha === confSenha && senha.length >= 8) {
                    botaoCadastrar.disabled = false;
                    feedback.style.display = "none";
                } else {
                    botaoCadastrar.disabled = true;
                    if(confSenha.length > 0) {
                        feedback.style.display = "block";
                    }
                }
            }

            campoSenha.addEventListener('input', verificaCampos);
            campoConfirmarSenha.addEventListener('input', verificaCampos);

            function mascaraCNPJ(elemento) {
                let valor = elemento.value.replace(/\D/g, "");

                if (valor.length > 14) {
                    valor = valor.substring(0, 14);
                }

                valor = valor.replace(/^(\d{2})(\d)/, "$1.$2");
                valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
                valor = valor.replace(/\.(\d{3})(\d)/, ".$1/$2");
                valor = valor.replace(/(\d{4})(\d{2})$/, "$1-$2");

                elemento.value = valor;
            }
        </script>
        
        <script>
        const formCadastro = document.getElementById("formCadastro");
        const botaosalvar = document.getElementById("btnCadastrar"); // Captura o ID correto
            
        formCadastro.addEventListener("submit", function(e) {
            // 1. Ativa a classe de carregamento visual
            botaosalvar.classList.add("ativo");
            
            // 2. Desabilita o clique logo em seguida
            setTimeout(function() {
                botaosalvar.disabled = true;
            }, 10);
        });
        </script>
    </body>
</html>