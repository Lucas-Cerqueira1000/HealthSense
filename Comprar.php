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
        <title>Comprar Produto</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <link rel="icon" href="img/logo1.png">
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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/f2c06f6363.js" crossorigin="anonymous"></script>
        <!-- main style -->
        <link rel="stylesheet" href="src/main-style.css">
        <!-- <link rel="stylesheet" href="src/estilos.css"> -->
    </head>
    <style>
        body
        {
            color:white;
        }
        main
        {
            gap:20px;
        }
        #principal
        {
            background-color: var(--verde);
            width: 50vw;
            /* height: 80vh; */
            gap: 40px;
            color: white;
            border-radius: 50px;
        }
/* ALTERAÇÕES DO CARROSSEL CUSTOMIZADO AQUI */
.carousel-container {
    position: relative;
    max-width: 800px;
    margin: auto;
    overflow: hidden; 
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.carousel-slide {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: 100%;
}

.custom-carousel-item {
    min-width: 100%;
    width: 100%;
    position: relative;
    display: block; 
}

.custom-carousel-item img {
    width: 100%;
    height: auto;
    display: block;
}

.caption {
    position: absolute;
    bottom: 0;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    color: #f2f2f2;
    text-align: center;
    padding: 15px 0;
    font-size: 18px;
    z-index: 2;
}

.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -35px;
    color: white;
    font-weight: bold;
    font-size: 24px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
    background-color: rgba(0,0,0,0.4);
    border: none;
    z-index: 10;
}

.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

.prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
}
@media(max-width: 845px)
{
    .carousel-container
    {
        transform: scale(0.8);
    }
}
#prints
{
    display: flex;
    flex-direction: row;
    justify-content: center;
    /* gap: 10px; */
    flex-wrap: wrap;
    border-radius: 150px;
}
#produto
{
    font-size: 20px;
}

    </style>
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
            <li><a href="inicio.php" class="botoes1">Início</a></li>
            <li><a href="Comprar.php" class="fw-bold text-decoration-underline botoes1">Comprar Pulseira</a></li>
            <li><a href="Medicos.php" class="botoes1">Médicos</a></li>
            <li><a href="CadastrarMedicos" class="botoes1">Cadastrar Médicos</a></li>
            <li><a href="DeletarMedicos.php" class="botoes1">Deletar Médicos</a></li>
            <li><a href="AlterarDadosMedicos.php" class="botoes1">Alterar Dados Médicos</a></li>
            <a href="Index.html" class="botoes2">Deslogar</a>
        </ul>
        

        <div class="menu-toggle bg-" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </nav>  
        </header>
        <main class="flex flex-col min-h-screen vw-100 p-0">
            <h1 class="fw-bold text-center">Bem vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
            <h2>Aqui você pode adquirir o produto da Health Sense Services.</h2>
           <section id="principal">
            <h1></h1>

            <section id="produto">
                <h1 class="text-center m-4">Nosso Produto</h1>   
                <p class="text-center container" id="produto">Este produto foi totalmente desenvolvido em território nacional e com uma combinação de programação em C++ e a utilização do <i>software</i> Arduino.</p>
                
                <div class="carousel-container">
                    <div class="carousel-slide">
                        <div class="custom-carousel-item">
                            <img src="img/1.png" alt="Imagem da pulseira" class="rounded img-thumbnail shadow">
                            <div class="caption">Imagem da pulseira.</div>
                        </div>
                        
                        <div class="custom-carousel-item">
                            <img src="img/2.png" alt="Imagem da pulseira no braço do paciente" class="rounded img-thumbnail shadow">
                            <div class="caption">Imagem da pulseira no braço do paciente.</div>
                        </div>

                        <div class="custom-carousel-item">
                            <img src="img/3.png" alt="Imagem da pulseira no braço do paciente e visualização do aplicativo com eletrocardiograma" class="rounded img-thumbnail shadow">
                            <div class="caption">Imagem da pulseira no braço do paciente e visualização do aplicativo com eletrocardiograma.</div>
                        </div>

                        <div class="custom-carousel-item">
                            <img src="img/4.png" alt="Imagem apenas do aplicativo com eletrocardiograma"class="rounded img-thumbnail shadow">
                            <div class="caption">Imagem apenas do aplicativo com eletrocardiograma.</div>
                        </div>
                    </div>

                    <button class="prev" onclick="prevSlide()">&#10094;</button>
                    <button class="next" onclick="nextSlide()">&#10095;</button>
                </div>
            </section>
            <br>
            <section class="text-center" id="prints">
                <div class="text-center">
                    <figure class="text-center">
                        <img src="img/6.png" class="img-fluid rounded img-thumbnail shadow text-center" alt="Tela de entrada do médico." height="400px" width="430px">
                        <figcaption class="fw-bold">Tela de SOS do médico.</figcaption>
                    </figure>
                </div>
            </section>
            <section id="tecnicas" class="container">
                <h1 class="text-center">Especifiçãoes Técnicas</h1>
                <!-- <h4 class="text-center">Especificações Físicas</h4> -->
            <table style="width:100%; border-collapse: collapse;">
  <!-- <caption>Lista de Produtos em Estoque</caption> -->
  <thead>
    <tr style="background-color: var(--verdeescuro);" class="text-center">
      <th style="border: 1px solid #ddd; padding: 8px;">Característica</th>
      <th style="border: 1px solid #ddd; padding: 8px;">Especificação</th>
      <!-- <th style="border: 1px solid #ddd; padding: 8px;">Categoria</th>
      <th style="border: 1px solid #ddd; padding: 8px;">Preço</th>
      <th style="border: 1px solid #ddd; padding: 8px;">Estoque</th> -->
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Modelo</td>
      <td style="border: 1px solid #ddd; padding: 8px;">HSEG-01</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 49,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">120</td> -->
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Material Externo</td>
      <td style="border: 1px solid #ddd; padding: 8px;">Polímero médico hipoalergênico</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
    <!-- Adicione mais linhas <tr> conforme necessário -->
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Cor</td>
      <td style="border: 1px solid #ddd; padding: 8px;">Branco Hospitalar</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Acabamento</td>
      <td style="border: 1px solid #ddd; padding: 8px;">Antimicrobiano</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Peso</td>
      <td style="border: 1px solid #ddd; padding: 8px;">38 gramas</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Diâmetro Interno</td>
      <td style="border: 1px solid #ddd; padding: 8px;">65 milimetros</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Espessura</td>
      <td style="border: 1px solid #ddd; padding: 8px;">18 milimetros</td>
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Resistência</td>
      <td style="border: 1px solid #ddd; padding: 8px;">IP68</td>
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Temperatura de Operação</td>
      <td style="border: 1px solid #ddd; padding: 8px;">-10°C a 60°C</td>
    </tr>
  </tbody>
  <tfoot>
    <tr style="background-color: var(--verdeescuro); color=transparent" class="text-center">
      <td colspan="9" style="border: 1px solid #ddd; padding: 20px; text-align: right; height=30px;" ></td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">5</td> -->
    </tr>
  </tfoot>
</table>
<h1 class="text-center">Sensores Integrados</h1>
<br><br>
<h3>Sensor Cardiáco Óptico</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
  <li>Monitoramento contínuo da frequência cardíaca.</li>
  <li>Faixa: 30 a 220 bpm.</li>
  <li>Precisão: ± 1 bpm.</li>
</ul>

<h3>Sensor de Saturação (SpO₂)</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
  <li>Faixa: 70% a 100%.</li>
  <li>Precisão: ± 2%.</li>
</ul>

<h3>Sensor de Temperatur Corporal</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
  <li>Faixa: 30°C a 45°C.</li>
  <li>Precisão: ± 0,1°C.</li>
</ul>

<h3>Sensor de Movimento</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
  <li>Acelerômetro triaxial.</li>
  <li>Detecção de quedas.</li>
  <li>Detecção de inatividade prolongada.</li>
</ul>

<h3>Sensor de Posicionamento Interno</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
  <li>Rastreamento por beacons hospitalares.</li>
  <li>Precisão de localização interna de até 2 metros.</li>
</ul>
<h1 class="text-center">Sistema de Alerta</h1>
<h3>LED Inteligente Frontal</h3>
<table style="width:100%; border-collapse: collapse;">
  <!-- <caption>Lista de Produtos em Estoque</caption> -->
  <thead>
    <tr style="background-color: var(--verdeescuro);" class="text-center">
      <th style="border: 1px solid #ddd; padding: 8px;">Cor</th>
      <th style="border: 1px solid #ddd; padding: 8px;">Situação</th>
      <!-- <th style="border: 1px solid #ddd; padding: 8px;">Categoria</th>
      <th style="border: 1px solid #ddd; padding: 8px;">Preço</th>
      <th style="border: 1px solid #ddd; padding: 8px;">Estoque</th> -->
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Verde</td>
      <td style="border: 1px solid #ddd; padding: 8px;">Parece estável</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 49,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">120</td> -->
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Amarelo</td>
      <td style="border: 1px solid #ddd; padding: 8px;">Necessita atenção</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
    <!-- Adicione mais linhas <tr> conforme necessário -->
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Vermelho</td>
      <td style="border: 1px solid #ddd; padding: 8px;">Emergência detectada</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Azul</td>
      <td style="border: 1px solid #ddd; padding: 8px;">Conectado à central</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
    <tr>
      <td style="border: 1px solid #ddd; padding: 8px;">Branco</td>
      <td style="border: 1px solid #ddd; padding: 8px;">Modo configuração</td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">Vestuário</td>
      <td style="border: 1px solid #ddd; padding: 8px;">R$ 119,90</td>
      <td style="border: 1px solid #ddd; padding: 8px;">85</td> -->
    </tr>
  </tbody>
  <tfoot>
    <tr style="background-color: var(--verdeescuro); color=transparent" class="text-center">
      <td colspan="9" style="border: 1px solid #ddd; padding: 20px; text-align: right; height=30px;" ></td>
      <!-- <td style="border: 1px solid #ddd; padding: 8px;">5</td> -->
    </tr>
  </tfoot>
</table>
<br>
<h3>Vibração Tátil</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
  <li>Alertas sileciosos.</li>
  <li>Confirmação de eventos.</li>
  <li>Avisos de medicação.</li>
</ul>
<h3>Comunicação</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
<h5 class="fw-bold">Bluetooth</h5>
  <li>Bluetooth 5.3 BLE.</li>
<h5 class="fw-bold">Wi-Fi</h5>
  <li>Wi-Fi 6.</li>
<h5 class="fw-bold">NFC</h5>
  <li>Identificação rápida do paciente.</li>
<h5 class="fw-bold">Comunicação Proprietária HSN-Link</h5>
<li>Alcance de até 500 metros em ambiente hospitalar.</li>
</ul>
<h1 class="text-center">Funcionalidades Clínicas</h1>
<br>
<h3>Monitoramento em Tempo Real</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
  <li>Frequência cardíaca.</li>
  <li>Saturação de oxigênio.</li>
  <li>Temperatura corporal.</li>
  <li>Mobilidade do paciente.</li>
</ul>

<h3>Sistema SOS</h3>
<ul class="list-disc list-inside text-white ms-4 my-3">
  <li>Acionamento automático em situações críticas.</li>
  <li>Acionamento manual pelo aplicativo.</li>
  <li>Notificação simultânea para:</li>
  <ul>

      <li>Equipe médica.</li>
      <li>Enfermagem.</li>
      <li>Central de monitoramento.</li>
    </ul>
</ul>
            </section>
        </section>   
        <div class="my-5 py-3"></div>
    </main>
    <footer class="mt-auto container-fluid vw-100 text-center">
            <!-- place footer here -->
             <div class="text-center container">
              <h3 class="text-center container" id="copy">&copy HealthSense Systems</h3>
             </div>
             
        </footer>
        <script src="js/main-script.js"></script>
        <script src="js/scripts.js"></script>
<script>

// ==========================================
// CARROSSEL CORRIGIDO
// ==========================================
let slideIndex = 0;
let timer = null;

const carouselSlide = document.querySelector(".carousel-slide");
const slides = document.querySelectorAll(".custom-carousel-item");

showSlides(false); // Inicializa sem transição
startTimer(); 

function startTimer() {
    // Evita acumular múltiplos intervalos limpando antes de criar
    if (timer) clearInterval(timer);
    timer = setInterval(nextSlide, 4000); 
}

function nextSlide() {
    slideIndex++;
    // Se passar da última, vai para a primeira instantaneamente sem transição reversa
    if (slideIndex >= slides.length) {
        slideIndex = 0;
        showSlides(false); 
    } else {
        showSlides(true);
    }
    resetTimer();
}

function prevSlide() {
    slideIndex--;
    // Se for antes da primeira, vai para a última instantaneamente
    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
        showSlides(false);
    } else {
        showSlides(true);
    }
    resetTimer();
}

function showSlides(withTransition = true) {
    if (!carouselSlide || slides.length === 0) return;

    // Controla se o efeito de deslizar deve acontecer ou não
    if (withTransition) {
        carouselSlide.style.transition = "transform 0.5s ease-in-out";
    } else {
        carouselSlide.style.transition = "none";
    }
    
    let offset = -slideIndex * 100;
    carouselSlide.style.transform = `translateX(${offset}%)`;
}

function resetTimer() {
    clearInterval(timer);
    startTimer();
}

// Controladores do Mouse protegidos contra múltiplos intervalos
document.querySelector('.carousel-container').addEventListener('mouseenter', () => {
    clearInterval(timer);
});

document.querySelector('.carousel-container').addEventListener('mouseleave', () => {
    startTimer();
});

</script>
    </body>
</html>
