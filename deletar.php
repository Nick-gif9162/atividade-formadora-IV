<?php
include("conexão.php");

$mensagem = "";
$tipo = "";

if (isset($_POST["id_consulta"])) {
    $id_consulta = intval($_POST["id_consulta"]);

    // Usando prepared statement para evitar SQL Injection
    $stmt = $conexao->prepare("DELETE FROM consulta WHERE id_consulta = ?");
    $stmt->bind_param("i", $id_consulta);

    if ($stmt->execute()) {
        $mensagem = "🗑️ Consulta excluída com sucesso!";
        $tipo = "sucesso";
    } else {
        $mensagem = "❌ Erro ao excluir consulta: " . htmlspecialchars($stmt->error);
        $tipo = "erro";
    }

    $stmt->close();
} else {
    $mensagem = "⚠ Nenhuma consulta informada.";
    $tipo = "aviso";
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Exclusão</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mensagem {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px 40px;
            text-align: center;
            max-width: 400px;
        }

        .mensagem h2 {
            margin-bottom: 15px;
        }

        .sucesso h2 {
            color: #2e7d32;
        }

        .erro h2 {
            color: #c62828;
        }

        .aviso h2 {
            color: #f9a825;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            transition: background-color 0.3s;
        }

        .btn-voltar {
            background-color: #1976d2;
            color: #fff;
        }

        .btn-voltar:hover {
            background-color: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="mensagem <?= $tipo ?>">
        <h2><?= $mensagem ?></h2>
        <a href="consultar todos.php" class="btn btn-voltar">⬅ Voltar para Consultas</a>
    </div>
</body>
</html>
