<?php
class Auth {
    private $conn;

    public function __construct($host, $user, $pass, $db) {
        $this->conn = new mysqli($host, $user, $pass, $db);
        if ($this->conn->connect_error) {
            die("Erro de conexão: " . $this->conn->connect_error);
        }
    }
    public function buscarUsuario($email) {
        $stmt = $this->conn->prepare("SELECT nome, senha FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nome, $senha_hash);
            $stmt->fetch();
            return ['nome' => $nome, 'senha_hash' => $senha_hash];
        }
    
        return null;
    }
    public function sanitizar($dado) {
        return htmlspecialchars(strip_tags(trim($dado)));
    }

    public function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function login($email, $senha) {
        $stmt = $this->conn->prepare("SELECT senha FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($senhaHash);
            $stmt->fetch();
            return password_verify($senha, $senhaHash);
        }

        return false;
    }

    public function emailExiste($email) {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function cadastrar($nome, $email, $senha) {
        if ($this->emailExiste($email)) {
            return "E-mail já cadastrado.";
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senhaHash);

        if ($stmt->execute()) {
            return "Cadastro realizado com sucesso!";
        } else {
            return "Erro ao cadastrar: " . $stmt->error;
        }
    }
}




?>
