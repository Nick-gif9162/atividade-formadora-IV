<?php
include("conexão.php");

$mensagem = "";
$tipo = "";

if (isset($_POST["id_consulta"])) {
    $id = intval($_POST["id_consulta"]);
    $nome_paciente = trim($_POST["nome_paciente"]);
    $telefone = trim($_POST["telefone"]);
    $data_consulta = trim($_POST["data_consulta"]);
    $hora = trim($_POST["hora"]);
    $nome_medico = trim($_POST["nome_medico"]);
    $descricao = trim($_POST["descricao"]);

    // Atualiza os dados da consulta
    $stmt = $conexao->prepare("UPDATE consulta 
                               SET nome_paciente = ?, telefone = ?, data_consulta = ?, hora = ?, nome_medico = ?, descricao = ? 
                               WHERE id_consulta = ?");
    $stmt->bind_param("ssssssi", $nome_paciente, $telefone, $data_consulta, $hora, $nome_medico, $descricao, $id);

    if ($stmt->execute()) {
        $mensagem = "✅ Consulta atualizada com sucesso!";
        $tipo = "sucesso";
    } else {
        $mensagem = "❌ Erro ao atualizar consulta.";
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
    <title>Resultado da Atualização</title>
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
        <h2><?= htmlspecialchars($mensagem) ?></h2>
        <a href="consultar_consultas.php" class="btn btn-voltar">⬅ Voltar para Consultas</a>
    </div>
</body>
</html>
