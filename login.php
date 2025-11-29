<?php
include("conexão.php");

$email = trim($_POST["email"]);
$senha = trim($_POST["senha"]);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("<script>alert('Email inválido!'); window.history.back();</script>");
}

$sql = "SELECT senha FROM login WHERE email = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    if (password_verify($senha, $usuario["senha"])) {
        session_start();
        $_SESSION["usuario_email"] = $email;
        echo "<script>alert('Login realizado com sucesso!'); window.location.href = 'pagina inicial e menu.html';</script>";
    } else {
        echo "<script>alert('Senha incorreta!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Usuário não encontrado!'); window.history.back();</script>";
}

$stmt->close();
$conexao->close();
?>
