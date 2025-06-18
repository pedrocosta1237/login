<?php
require_once 'Auth.php';

$auth = new Auth("localhost", "root", "&tec77@info!", "sistema_login");

$mensagem = '';
$nome = '';
$logado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $auth->sanitizar($_POST['email'] ?? '');
    $senha = $auth->sanitizar($_POST['senha'] ?? '');

    if ($auth->login($email, $senha)) {
        $usuario = $auth->buscarUsuario($email);
        $nome = $usuario['nome'] ?? '';
        $logado = true;
    } else {
        $mensagem = "E-mail ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #8fffb6;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            background: rgb(4, 181, 28);
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color: white;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 16px;
            background-color: #ff643d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #d90000;
        }
        .mensagem {
            margin-top: 15px;
            background-color: #fff3f3;
            color: #900;
            padding: 10px;
            border-radius: 4px;
        }
        .bem-vindo {
            background-color: #e3ffe3;
            color: #0c4a1b;
            padding: 15px;
            border-radius: 6px;
        }
        .sair {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff643d;
            text-decoration: none;
            color: white;
            border-radius: 4px;
        }
        .sair:hover {
            background-color: #d90000;
        }
    </style>
</head>
<body>

<div class="form-container">
    <?php if ($logado): ?>
        <h2>Bem-vindo(a)!</h2>
        <div class="bem-vindo">
            Olá, <strong><?php echo htmlspecialchars($nome); ?></strong>. Você está logado com sucesso!
        </div>
        <a class="sair" href="login.html">Sair</a>
    <?php else: ?>
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
        <?php if ($mensagem): ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
