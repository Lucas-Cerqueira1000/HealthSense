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
        <link rel="icon" href="img/X.png">
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
                <h1 class="text-center m-4">Nossa Produto</h1>   
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
                        <img src="img/5.png" class="img-fluid rounded img-thumbnail shadow text-center" alt="Tela de entrada do médico." height="400px" width="430px">
                        <figcaption class="fw-bold">Tela de entrada do médico.</figcaption>
                    </figure>
                </div>
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
