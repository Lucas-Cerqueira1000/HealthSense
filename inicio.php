<?php 
session_start();

if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Configurações do Banco de Dados
$host = 'tcc_bd35.mysql.dbaas.com.br';
$dbname = 'tcc_bd35';
$username = 'tcc_bd35';
$password = 'ROSA123456a#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Busca as informações atualizadas do hospital logado
    $stmt = $pdo->prepare("SELECT * FROM `tabHospitais` WHERE ID = :id");
    $stmt->bindParam(':id', $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt->execute();
    $dadosHospital = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$dadosHospital) {
        echo "Dados do hospital não encontrados.";
        exit;
    }
    
    // Força a atualização do nome da sessão com o dado real vindo do banco
    $_SESSION['usuario_nome'] = $dadosHospital['nome'];

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Seus Dados</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cloudflare.com">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="src/main-style.css">
    </head>
    <style>
        #email {
            width: 60vw;
        }
        .form-control {
            border: 10px var(--verde);
        }
        form {
          background-color: var(--verde);
          color: white;
          padding-right: 30px;
          padding-left: 30px;
          border-radius:60px;
        }
        .btn-editar {
            width: 40px;
            height: 40px;
        }
        /* O visual básico do botão */
button {
  position: relative;
  padding: 12px 24px;
  cursor: pointer;
  border: none;
  background-color: #007bff;
  color: white;
  border-radius: 5px;
}

/* Esconde o texto e mostra o spinner quando o botão tem a classe 'ativo' */
button.ativo .texto-botao {
  visibility: hidden;
  opacity: 0;
}

button.ativo .spinner {
  visibility: visible;
  opacity: 1;
}

/* O formato do ícone de carregamento (Spinner) */
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
  transform: translate(-50%, -50%);
  animation: girar 1s linear infinite;
}

/* A animação de rotação */
@keyframes girar {
  to { transform: translate(-50%, -50%) rotate(360deg); }
}
#formHospital
{
    width: 80vw;
    /* height: 80vh; */
    gap: 40px;
}
#email
{
    width: 100vw;
}
    </style>
    <body>
        <header>
            <nav class="navbar text-center">
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
                <ul class="nav-links fs-3 text-center" id="links">
                    <li><a href="inicio.php" class="botoes1">Início</a></li>
                    <li><a href="Medicos.php" class="botoes1">Médicos</a></li>
                    <li><a href="CadastrarMedicos" class="botoes1">Cadastrar Médicos</a></li>
                    <li><a href="DeletarMedicos.php" class="botoes1">Deletar Médicos</a></li>
                    <li><a href="AlterarDadosMedicos.php" class="botoes1">Alterar Dados Médicos</a></li>
                    <a href="Index.html" class="botoes2">Deslogar</a>
                </ul>
                <div class="menu-toggle" id="mobile-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>  
        </header>
        
        <main class="flex flex-col min-h-screen vw-100 p-0">
            <br>
            <h1 class="fw-bold text-center">Bem vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>:</h1>
            <br><br>
            
            <form method="POST" action="atualizar_dados.php" id="formHospital">
                <br>
                <h1 class="fw-bold text-center">Suas informações:</h1>
                
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Endereço de e-mail:</label>
                    <div class="d-flex align-items-center">
                        <input type="email" class="form-control me-2" id="email" name="email" readonly value="<?php echo htmlspecialchars($dadosHospital['email']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('email')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label fw-bold">Nome do seu hospital:</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="nome" name="nome" readonly value="<?php echo htmlspecialchars($dadosHospital['nome']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('nome')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label fw-bold">Telefone:</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="telefone" name="telefone" maxlength="15" readonly value="<?php echo htmlspecialchars($dadosHospital['telefone']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('telefone')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="cep" class="form-label fw-bold">CEP:</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="cep" name="cep" maxlength="9" readonly value="<?php echo htmlspecialchars($dadosHospital['cep']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('cep')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="rua" class="form-label fw-bold">Rua:</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="rua" name="rua" readonly value="<?php echo htmlspecialchars($dadosHospital['rua']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('rua')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="cidade" class="form-label fw-bold">Cidade:</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="cidade" name="cidade" readonly value="<?php echo htmlspecialchars($dadosHospital['cidade']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('cidade')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bairro" class="form-label fw-bold">Bairro:</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="bairro" name="bairro" readonly value="<?php echo htmlspecialchars($dadosHospital['bairro']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('bairro')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label fw-bold">Estado(Digite apenas a sigla):</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="estado" name="estado" readonly value="<?php echo htmlspecialchars($dadosHospital['estado']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('estado')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="cnpj" class="form-label fw-bold">CNPJ:</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="cnpj" name="cnpj" readonly oninput="mascaraCNPJ(this)" maxlength="18" value="<?php echo htmlspecialchars($dadosHospital['cnpj']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('cnpj')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="cnes" class="form-label fw-bold">CNES:</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="cnes" name="cnes"  maxlength="7" readonly value="<?php echo htmlspecialchars($dadosHospital['cnes']); ?>">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInput('cnes')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label fw-bold">Senha:</label>
                    <div class="d-flex align-items-center">
                        <input type="password" class="form-control me-2" id="senha" name="senha" minlength="8" readonly value="********">
                        <img src="lapis.png" alt="Editar" class="btn-editar" style="cursor:pointer;" onclick="ativarInputSenha('senha')">
                    </div>
                </div>

                <div class="mb-3 d-none" id="confirmar">
                    <label for="txtConfirmSenha" class="form-label estilo-label">Confirmar Senha:</label>
                    <input type="password" class="form-control classe-senha" id="txtConfirmSenha" name="comfsenha" minlength="8" placeholder="Mínimo de 8 caracteres">
                    <div id="senhaFeedback" class="form-text text-warning fw-bold" style="display:none;">As senhas não são iguais.</div>
                    <div class="mb-3 form-check"> 
                        <input type="checkbox" class="form-check-input" id="mostrar">
                        <label class="form-check-label" for="mostrar" id="label-mostrar">Mostrar senha.</label>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary d-none" id="btn-salvar">
                        <span class="texto-botao">Salvar Alterações</span>
                        <span class="spinner"></span>    
                    </button>
                    <button type="button" class="btn btn-danger d-none" id="btn-deletar" onclick="resetarFormulario()">Deletar Alterações</button>
                </div>
                <br><br>
            </form>
            <br><br><br>  
        </main>
        
        <footer class="mt-auto container-fluid vw-100 text-center">
             <div class="text-center container">
              <h3 class="text-center container" id="copy">&copy HealthSense Systems</h3>
             </div>
        </footer>
        
        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>
        
        <script>
        // Função unificada para gerenciar a visibilidade dos botões Salvar/Deletar dinamicamente
        function gerenciarBotoesGlobais() {
            var form = document.getElementById('formHospital');
            var inputs = form.querySelectorAll('input:not([type="checkbox"]):not([type="hidden"])');
            var algumDisponivel = false;

            inputs.forEach(function(input) {
                if (!input.hasAttribute('readonly') && input.id !== 'txtConfirmSenha') {
                    algumDisponivel = true;
                }
            });

            var btnSalvar = document.getElementById('btn-salvar');
            var btnDeletar = document.getElementById('btn-deletar');

            if (algumDisponivel) {
                btnSalvar.classList.remove('d-none');
                btnDeletar.classList.remove('d-none');
            } else {
                btnSalvar.classList.add('d-none');
                btnDeletar.classList.add('d-none');
            }
        }

        // Função para resetar e voltar tudo ao readonly ocultando botões
        function resetarFormulario() {
            var form = document.getElementById('formHospital');
            form.reset(); // Restaura valores originais
            
            var inputs = form.querySelectorAll('input');
            inputs.forEach(function(input) {
                if(input.id !== 'txtConfirmSenha' && input.id !== 'mostrar') {
                    input.setAttribute('readonly', 'readonly');
                }
            });

            document.getElementById('confirmar').classList.add('d-none');
            document.getElementById('senhaFeedback').style.display = "none";
            gerenciarBotoesGlobais();
        }

        $(document).ready(function() {
            // Correção da funcionalidade Mostrar Senha (Mapeado para os IDs existentes correspondentes)
            $("#mostrar").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#senha").attr("type", "text");
                    $("#txtConfirmSenha").attr("type", "text");
                } else {
                    $("#senha").attr("type", "password");
                    $("#txtConfirmSenha").attr("type", "password");
                }
            });
        });

        // Correção do Lápis: Ativar / Desativar dinamicamente ao clicar várias vezes consecutivas
        function ativarInput(idInput) 
        {
            var input = document.getElementById(idInput);
            
            if (input) {
                if (input.hasAttribute('readonly')) {
                    input.removeAttribute('readonly');
                    input.focus();
                } else {
                    input.setAttribute('readonly', 'readonly');
                }
                gerenciarBotoesGlobais();
            }
        }

        function ativarInputSenha(idInput) 
        {
            var input = document.getElementById(idInput);
            var confirmarDiv = document.getElementById('confirmar');
            var txtConfirm = document.getElementById('txtConfirmSenha');
            
            if (input) {
                if (input.hasAttribute('readonly')) {
                    input.removeAttribute('readonly');
                    if(input.value === '********') input.value = ''; // limpa máscara provisória de senha antiga
                    input.focus();
                    confirmarDiv.classList.remove('d-none');
                    txtConfirm.setAttribute('required', 'required');
                } else {
                    input.setAttribute('readonly', 'readonly');
                    input.value = '********';
                    txtConfirm.value = '';
                    txtConfirm.removeAttribute('required');
                    confirmarDiv.classList.add('d-none');
                }
                gerenciarBotoesGlobais();
            }
        }
        </script>

        <script type="text/javascript">
            // Correção da validação de igualdade de senhas (IDs sincronizados com o HTML)
            const campoSenha = document.getElementById('senha');
            const campoConfirmarSenha = document.getElementById('txtConfirmSenha');
            const botaoSalvar = document.getElementById('btn-salvar');
            const feedback = document.getElementById('senhaFeedback');

            function verificaCampos() {
                // Se o input de senha ainda estiver bloqueado (readonly), ignora validação provisória
                if(campoSenha.hasAttribute('readonly')) {
                    botaoSalvar.disabled = false;
                    feedback.style.display = "none";
                    return;
                }

                const senha = campoSenha.value;
                const confSenha = campoConfirmarSenha.value;

                if(senha === confSenha && senha.length >= 8) {
                    botaoSalvar.disabled = false;
                    feedback.style.display = "none";
                } else {
                    botaoSalvar.disabled = true;
                    if(confSenha.length > 0 || senha.length > 0) {
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

            // Corrigido aqui o ID alvo de 'txtCep' para 'cep'
            const inputCep = document.getElementById('cep');
            inputCep.addEventListener('input', (e) => {
                let valor = e.target.value.replace(/\D/g, '');
                if (valor.length > 8) valor = valor.slice(0, 8);
                if (valor.length > 5) {
                    valor = valor.replace(/^(\d{5})(\d{3})$/, '$1-$2');
                }
                e.target.value = valor;
            });
        </script>
<script>
    const formHospital = document.getElementById("formHospital");
    const botaoSalvar = document.getElementById("btn-salvar");

    formHospital.addEventListener("submit", function(e) {
        // Ativa a animação visual do spinner
        botaoSalvar.classList.add("ativo");
        
        // Desabilita ligeiramente depois para permitir que o navegador envie os dados
        setTimeout(function() {
            botaoSalvar.disabled = true;
        }, 10);
    });
</script>
<script>
    // Verifica se existem parâmetros de resposta vindos do atualizar_dados.php
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('sucesso') === '1') {
        Swal.fire({
            title: 'Dados alterados!',
            text: 'Dados alterados com sucesso!',
            icon: 'success',
            confirmButtonColor: '#007bff'
        });
        // Limpa o parâmetro da URL para não repetir o alerta ao atualizar a página
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (urlParams.get('erro') === '1') {
        Swal.fire({
            title: 'Não foi possível alterar os dados!',
            text: 'Infelizmente ocorreu um erro ao salvar as informações.',
            icon: 'error',
            confirmButtonColor: '#dc3545'
        });
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>
    </body>
</html>