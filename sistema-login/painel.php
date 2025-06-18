<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.html");
    exit;
}

$nome = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e8f0ff;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .painel {
            background: white;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #ff3333;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="painel">
    <h2>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</h2>
    <p>Você está logado com sucesso.</p>
    <a href="logout.php">Sair</a>
</div>

</body>
</html>
