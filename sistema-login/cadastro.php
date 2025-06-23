<?php
require_once 'Auth.php';

$nomeCompleto = '';
$respostaCadastro = '';
$cadastroFeito = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $auth = new Auth("localhost", "root", "&tec77@info!", "sistema_login");

    $nome  = $auth->sanitizar($_POST['nome'] ?? '');
    $email = $auth->sanitizar($_POST['email'] ?? '');
    $senha = $auth->sanitizar($_POST['senha'] ?? '');

    if (!$auth->validarEmail($email)) {
        $respostaCadastro = "E-mail inválido.";
    } elseif (strlen($senha) < 6) {
        $respostaCadastro = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $respostaCadastro = $auth->cadastrar($nome, $email, $senha);
        $nomeCompleto = $nome;
        $cadastroFeito = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://i.pinimg.com/736x/be/5b/4f/be5b4f30a114b0d55f6435b5d3cb650a.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            background: #98f5b437;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: black;
        }
        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            text-align: left;
        }
        input, button {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #007acc;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #005b99;
        }
        .mensagem {
            margin-top: 20px;
            background-color: #e3ffe3;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
            color: #2e7d32;
        }
        .erro {
            background-color: #ffe3e3;
            color: #b30000;
        }
        .voltar {
            margin-top: 20px;
            display: inline-block;
            background-color: #ff9cdb;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .voltar:hover {
            background-color: #974579;
        }
    </style>
</head>
<body>

<div class="form-container">
    <?php if ($cadastroFeito): ?>
        <h2>Cadastro Concluído</h2>
        <div class="mensagem">
            Bem-vindo(a), <strong><?php echo $nomeCompleto; ?></strong>!
        </div>
        <a class="voltar" href="cadastro.php">Voltar para a Página Inicial</a>
    <?php else: ?>
        <h2>Cadastro de Usuário</h2>
        <form method="POST" action="">
            <label for="nome">Nome completo:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required minlength="6">

            <button type="submit">Cadastrar</button>
        </form>
        <?php if ($respostaCadastro): ?>
            <div class="mensagem erro"><?php echo $respostaCadastro; ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
