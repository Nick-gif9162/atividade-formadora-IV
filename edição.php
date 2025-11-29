<?php
include("conexão.php");

if (isset($_POST["id_consulta"])) {
    $id = intval($_POST["id_consulta"]);

    // Buscar consulta pelo ID
    $stmt = $conexao->prepare("SELECT * FROM consulta WHERE id_consulta = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $consulta = $resultado->fetch_assoc();
    } else {
        echo "<script>
            alert('Consulta não encontrada.');
            window.location.href = 'consultar_consultas.html';
        </script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Nenhuma consulta informada.');
        window.location.href = 'consultar_consultas.html';
    </script>";
    exit;
}

function e($txt) {
    return htmlspecialchars($txt ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Consulta</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px 40px;
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #1565c0;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #0d47a1;
        }

        input[type=text], input[type=date], input[type=time] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #90caf9;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #1976d2;
            box-shadow: 0 0 6px rgba(25, 118, 210, 0.3);
            outline: none;
        }

        button {
            display: inline-block;
            background-color: #1976d2;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0d47a1;
        }

        .voltar {
            display: inline-block;
            background-color: #e0e0e0;
            color: #333;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .voltar:hover {
            background-color: #bdbdbd;
        }

        footer {
            text-align: center;
            color: #777;
            font-size: 13px;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Consulta</h2>

        <form method="post" action="atualizar.php">
            <input type="hidden" name="id_consulta" value="<?= e($consulta['id_consulta']) ?>">

            <label>Nome do Paciente:</label>
            <input type="text" name="nome_paciente" value="<?= e($consulta['nome_paciente']) ?>" required>

            <label>Telefone:</label>
            <input type="text" name="telefone" value="<?= e($consulta['telefone']) ?>" required>

            <label>Data da Consulta:</label>
            <input type="date" name="data_consulta" value="<?= e($consulta['data_consulta']) ?>" required>

            <label>Horário:</label>
            <input type="time" name="hora" value="<?= e($consulta['hora']) ?>" required>

            <label>Nome do Médico:</label>
            <input type="text" name="nome_medico" value="<?= e($consulta['nome_medico']) ?>" required>

            <label>Descrição:</label>
            <input type="text" name="descricao" value="<?= e($consulta['descricao']) ?>">

            <button type="submit">💾 Salvar Alterações</button>
        </form>

        <div style="text-align:center; margin-top:20px;">
            <a href="consultar todos.php" class="voltar">⬅ Voltar para a página inicial</a>
        </div>

        <footer>
            Clínica Vida Saudável © 2025
        </footer>
    </div>
</body>
</html>



