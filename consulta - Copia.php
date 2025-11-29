<?php
include("conexão.php");

// Evita erro caso o campo não venha preenchido
$consulta = trim($_POST["cpf"] ?? "");

if ($consulta === "") {
    echo "<script>
        alert('Campo de busca vazio. Por favor, insira um título para buscar.');
        window.location.href = 'consulta.html';
    </script>";
    exit;
}


$sql = "SELECT * FROM paciente WHERE cpf LIKE ?";
$stmt = $conexao->prepare($sql);
$like = "%" . $consulta . "%";
$stmt->bind_param("s", $like);
$stmt->execute();
$resultado = $stmt->get_result();

$stmt->close();
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Consulta</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74b9ff, #a29bfe);
            padding: 40px;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            animation: fadeIn 0.8s ease;
        }

        th {
            background: #0984e3;
            color: white;
            padding: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f1f2f6;
        }

        button {
            background-color: #0984e3;
            border: none;
            color: white;
            padding: 6px 12px;
            margin: 3px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #74b9ff;
            transform: scale(1.05);
        }

        .voltar {
            margin-top: 30px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<h2>Resultados da Consulta</h2>

<?php
if ($resultado->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Nome do Médico</th>
                
            </tr>";

    while ($linha = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($linha["nome"]) . "</td>
                <td>" . htmlspecialchars($linha["cpf"]) . "</td>
                <td>" . htmlspecialchars($linha["email"]) . "</td>
                <td>" . htmlspecialchars($linha["telefone"]) . "</td>
                <td>
                    <form method='post' action='edição.php' style='display:inline;'>
                        <input type='hidden' name='nome' value='" . htmlspecialchars($linha["nome"]) . "'>
                        <button type='submit'>Editar</button>
                    </form>

                    <form method='post' action='deletar.php' style='display:inline;'>
                        <input type='hidden' name='nome' value='" . htmlspecialchars($linha["nome"]) . "'>
                        <button type='submit' style='background-color:#d63031;'>Excluir</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<script>
        alert('Nenhuma consulta encontrada.');
        window.location.href = 'consulta.html';
    </script>";
}
?>

<div class="voltar">
    <a href="consulta.html">
        <button>Voltar para a Página Inicial</button>
    </a>
</div>

</body>
</html>
