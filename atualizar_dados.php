<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$host = 'tcc_bd35.mysql.dbaas.com.br';
$dbname = 'tcc_bd35';
$username = 'tcc_bd35';
$password = "ROSA123456a#";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco: " . $e->getMessage());
}

// Recebe os dados do formulário
$email    = $_POST['email'] ?? '';
$nome     = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$cep      = $_POST['cep'] ?? '';
$rua      = $_POST['rua'] ?? '';
$cidade   = $_POST['cidade'] ?? '';
$bairro   = $_POST['bairro'] ?? '';
$estado   = $_POST['estado'] ?? '';
$cnpj     = $_POST['cnpj'] ?? '';
$senha    = $_POST['senha'] ?? '';

// Monta a Query Base utilizando Prepared Statements
$sql = "UPDATE tabHospitais SET 
            email = :email, 
            nome = :nome, 
            telefone = :telefone, 
            cep = :cep, 
            rua = :rua, 
            cidade = :cidade, 
            bairro = :bairro, 
            estado = :estado, 
            cnpj = :cnpj";

// Verifica se o usuário realmente alterou a senha
$atualizarSenha = ($senha !== '********' && !empty($senha));

if ($atualizarSenha) {
    $sql .= ", senha = :senha";
}

$sql .= " WHERE ID = :id";

try {
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':rua', $rua);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cnpj', $cnpj);
    $stmt->bindParam(':id', $_SESSION['usuario_id'], PDO::PARAM_INT);
    
    if ($atualizarSenha) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->bindParam(':senha', $senhaHash);
    }
    
    $executou = $stmt->execute();

    if ($executou) {
        // Atualiza o nome na sessão para refletir imediatamente no cabeçalho da página inicial
        $_SESSION['usuario_nome'] = $nome;
        header("Location: inicio.php?sucesso=1");
        exit;
    } else {
        header("Location: inicio.php?erro=1");
        exit;
    }
    
} catch (PDOException $e) {
    header("Location: inicio.php?erro=1");
    exit;
}
?>