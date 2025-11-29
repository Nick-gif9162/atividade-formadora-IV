<?php
include("conexão.php");

// Coleta os dados do formulário
$nome  = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$status_message = "";
$redirect_page  = "";

// 🔎 Verifica se já existe email igual
$sql_check_email = "SELECT COUNT(*) FROM login WHERE email = ?";
$stmt_email = $conexao->prepare($sql_check_email);
$stmt_email->bind_param("s", $email);
$stmt_email->execute();
$stmt_email->bind_result($email_count);
$stmt_email->fetch();
$stmt_email->close();

// 🔎 Verifica se já existe nome igual
$sql_check_nome = "SELECT COUNT(*) FROM login WHERE nome = ?";
$stmt_nome = $conexao->prepare($sql_check_nome);
$stmt_nome->bind_param("s", $nome);
$stmt_nome->execute();
$stmt_nome->bind_result($nome_count);
$stmt_nome->fetch();
$stmt_nome->close();

// 🔎 Verifica se já existe senha igual (comparando hash)
$sql_check_senha = "SELECT COUNT(*) FROM login WHERE senha = ?";
$stmt_senha = $conexao->prepare($sql_check_senha);
$stmt_senha->bind_param("s", $senha_hash);
$stmt_senha->execute();
$stmt_senha->bind_result($senha_count);
$stmt_senha->fetch();
$stmt_senha->close();

if ($email_count > 0) {
    $status_message = "
    <div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
    font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
        ❌ Este email já está cadastrado! Redirecionando para o cadastro novamente...
    </div>";
    $redirect_page = "cadastro_login.html";
} elseif ($nome_count > 0) {
    $status_message = "
    <div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
    font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
        ❌ Este nome já está cadastrado! Redirecionando para o cadastro novamente...
    </div>";
    $redirect_page = "cadastro_login.html";
} elseif ($senha_count > 0) {
    $status_message = "
    <div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
    font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
        ❌ Esta senha já está cadastrada! Redirecionando para o cadastro novamente...
    </div>";
    $redirect_page = "cadastro_login.html";
} else {
    // ✅ Insere novo usuário
    $sql = "INSERT INTO login (nome,email,senha) VALUES (?,?,?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if ($stmt->execute()) {
        $status_message = "
        <div style='background-color:#4CAF50;color:white;padding:15px;margin:20px auto;border-radius:8px;
        font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
            ✅ Cadastro realizado com sucesso! Redirecionando...
        </div>";
        $redirect_page = "pagina inicial e menu.html";
    } else {
        $status_message = "
        <div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
        font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
            ❌ Erro ao cadastrar: " . htmlspecialchars($stmt->error) . "
        </div>";
        $redirect_page = "cadastro_login.html";
    }

    $stmt->close();
}

$conexao->close();

// Imprime a mensagem estilizada e o código HTML básico
echo "<!DOCTYPE html><html><head><title>Status</title></head><body>";
echo $status_message;

// Script JavaScript para redirecionar após 2 segundos
echo "<script> 
    setTimeout(function(){
        window.location.href = '$redirect_page';
    }, 2000); 
</script>";

echo "</body></html>";
?>
