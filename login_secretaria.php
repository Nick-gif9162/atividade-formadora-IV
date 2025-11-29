<?php
session_start();
include("conexão.php");

// Coleta os dados do formulário
$email = $_POST["email"];
$senha = $_POST["senha"];

// Prepara consulta para buscar secretária pelo email
$sql = "SELECT id_login, nome, email, senha FROM login WHERE email = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $linha = $resultado->fetch_assoc();

    // Verifica a senha usando password_verify
    if (password_verify($senha, $linha["senha"])) {
        // ✅ Login bem-sucedido
        $_SESSION["id_login"] = $linha["id_login"];
        $_SESSION["nome_secretaria"] = $linha["nome"];

        echo "<div style='background-color:#4CAF50;color:white;padding:15px;margin:20px auto;border-radius:8px;
        font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
            ✅ Login realizado com sucesso! Redirecionando...
        </div>";

        echo "<script>
            setTimeout(function(){
                window.location.href = 'pagina inicial e menu.html';
            }, 2000);
        </script>";
    } else {
        // ❌ Senha incorreta
        echo "<div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
        font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
            ❌ Senha incorreta! Tente novamente.
        </div>";

        echo "<script>
            setTimeout(function(){
                window.location.href = 'login_secretaria.html';
            }, 2000);
        </script>";
    }
} else {
    // ❌ Email não encontrado
    echo "<div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
    font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
        ❌ Email não encontrado! Cadastre-se primeiro.
    </div>";

    echo "<script>
        setTimeout(function(){
            window.location.href = 'cadastro_secretaria.html';
        }, 2000);
    </script>";
}

$stmt->close();
$conexao->close();
?>
