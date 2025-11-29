<?php
    // O arquivo 'conexão.php' deve conter a lógica de conexão com o banco de dados
    include("conexão.php");

    // Prepara e executa a consulta para selecionar todos os registros da tabela 'consulta'
    $consultar_todos = "SELECT * FROM consulta";
    $resultado2 = $conexao->query($consultar_todos);

    // Certifique-se de fechar a conexão no final do script se 'conexão.php' não o fizer
    // $conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Marcadas - Clínica do Saber</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.12.1/html2pdf.bundle.min.js"></script>

    <style>
        /* Estilos Globais e Sticky Footer */
        html, body {
            height: 100%; /* Essencial para o sticky footer */
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #dfe9f3, #ffffff);
            color: #333;
            text-align: center;
            display: flex; /* Habilita flexbox para o layout vertical */
            flex-direction: column;
            min-height: 100vh; /* Garante que o corpo ocupa a altura total da viewport */
            transition: background 0.5s ease, color 0.5s ease;
        }
        
        /* Conteúdo Principal (cresce para empurrar o rodapé) */
        .main-content {
            flex: 1; /* Ocupa o espaço restante */
            width: 100%;
        }

        /* Cabeçalho */
        header {
            background-color: #2a628f;
            color: white;
            padding: 20px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative; /* Necessário para posicionar o toggle */
            display: flex;
            justify-content: center; /* Centraliza o H1 */
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.2em;
            letter-spacing: 1px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* Dark Mode Toggle Position */
        #darkToggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: white; /* Cor padrão para o cabeçalho claro */
            transition: color 0.3s ease;
        }

        /* Título da Página */
        h2 {
            margin-top: 40px;
            color: #2a628f;
            text-shadow: 1px 1px 2px #aac4dc;
            font-size: 1.8em;
        }

        /* Tabela */
        table {
            margin: 30px auto;
            border-collapse: collapse;
            width: 90%;
            max-width: 1200px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            font-size: 0.9em;
        }
        th {
            background-color: #2a628f;
            color: white;
            padding: 15px 10px;
            font-size: 1em;
        }
        td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        tr:nth-child(even) {
            background-color: #f4f8fb;
        }
        tr:hover {
            background-color: #e0edf7;
            transition: 0.3s;
        }

        /* Botões */
        .area-botoes {
            padding: 20px;
        }
        .botao-acao {
            background-color: #2a628f;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            margin: 0 10px;
            text-decoration: none;
            display: inline-block;
        }
        .botao-acao:hover {
            background-color: #1b4566;
            transform: scale(1.03);
        }
        #gerar-pdf {
            background-color: #3498db;
        }
        #gerar-pdf:hover {
            background-color: #2980b9;
        }

        /* Rodapé */
        footer {
            /* Garantido que fique no final da página devido ao flexbox no body */
            background-color: #2a628f;
            padding: 15px 0;
            color: #e2e8f0;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            width: 100%;
            margin-top: auto; /* Empurra o rodapé para baixo */
        }
        footer a {
            line-height: 0;
        }
        footer a img {
            width: 28px;
            height: 28px;
            vertical-align: middle;
            transition: opacity 0.3s;
        }
        footer a img:hover {
            opacity: 0.7;
        }
        .foto-paciente-tabela {
            width: 100px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        /* Dark mode */
        body.dark {
            background: #1a202c;
            color: #e2e8f0;
        }
        body.dark header {
            background-color: #4a5568;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }
        body.dark #darkToggle {
             color: #e2e8f0; /* Ícone claro no modo escuro */
        }
        body.dark h2 {
            color: #90cdf4;
            text-shadow: 1px 1px 2px #2d3748;
        }
        body.dark table {
            background-color: #2d3748;
            color: #e2e8f0;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }
        body.dark th {
            background-color: #4a5568;
        }
        body.dark td {
             border-bottom: 1px solid #4a5568;
        }
        body.dark tr:nth-child(even) {
            background-color: #3b4252;
        }
        body.dark tr:hover {
            background-color: #434c5e;
        }
        body.dark .botao-acao {
            background-color: #4a5568;
        }
        body.dark .botao-acao:hover {
             background-color: #5d6c82;
        }
        body.dark #gerar-pdf {
            background-color: #63b3ed;
        }
        body.dark #gerar-pdf:hover {
            background-color: #4299e1;
        }
        body.dark footer {
            background-color: #111827;
            color: #e5e7eb;
        }
    </style>
</head>
<body>

<header>
    <h1>Clínica do Saber</h1>
    <button id="darkToggle">🌙</button>
</header>

<div class="main-content">
    <div id="content">
    <?php
        if ($resultado2->num_rows > 0) {
            echo "<h2>📋 CONSULTAS MARCADAS</h2>";
            echo "<table>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Data da consulta</th>
                        <th>Horario</th>
                        <th>Nome do Médico</th>
                        <th>Descrição</th>
                        <th>Foto do Paciente</th>
                        <th>Ações</th>
                    </tr>";

            while ($linha = $resultado2->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($linha["nome_paciente"]) . "</td>
                        <td>" . htmlspecialchars($linha["telefone"]) . "</td>
                        <td>" . htmlspecialchars($linha["data_consulta"]) . "</td>
                        <td>" . htmlspecialchars($linha["hora"]) . "</td>
                        <td>" . htmlspecialchars($linha["nome_medico"]) . "</td>
                        <td>" . htmlspecialchars($linha["descricao"]) . "</td>
                        <td><img src=\"" . htmlspecialchars($linha["foto_paciente"]) . "\" alt=\"Foto do Paciente\" class=\"foto-paciente-tabela\"></td>
                        <td>
                            <form method='post' action='edição.php' style='display:inline;'>
                                <input type='hidden' name='id_consulta' value='" . htmlspecialchars($linha["id_consulta"]) . "'>
                                <button type='submit'>Editar</button>
                            </form>

                            <form method='post' action='deletar.php' style='display:inline;'>
                                <input type='hidden' name='id_consulta' value='" . htmlspecialchars($linha["id_consulta"]) . "'>
                                <button type='submit' style='background-color:#d63031;'>Excluir</button>
                            </form>
                        </td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p><strong>Nenhum cadastro de consulta encontrado.</strong></p>";
        }
    ?>
    </div>
</div>


    <div class="area-botoes">
        <a href="pagina inicial e menu.html" class="botao-acao">
            ⬅ Voltar para a página inicial
        </a>
        
        <button id="gerar-pdf" class="botao-acao">
            🖨️ Gerar PDF
        </button>
    </div>
</div> <footer>
    <span>© <?php echo date("Y"); ?> Clínica do Saber - Todos os direitos reservados.</span>
    <a href="https://www.instagram.com/nicolashenrique9338?igsh=bWZsbmI0b3piMmVt" target="_blank" title="Siga-nos no Instagram">
        <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram">
    </a>
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const btnGenerate = document.querySelector("#gerar-pdf");

    btnGenerate.addEventListener("click", () => {
        const content = document.querySelector("#content");
        const options = {
            margin: [10, 10, 10, 10],
            filename: 'consultas.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // Oculta botões e dark mode toggle
        document.querySelector('.area-botoes').style.display = 'none';
        document.getElementById('darkToggle').style.display = 'none';

        // Ocultar Coluna Foto
        const fotoTH = document.querySelector("th:nth-child(7)");
        const fotoTDs = document.querySelectorAll("td:nth-child(7)");

        fotoTH.style.display = "none";
        fotoTDs.forEach(td => td.style.display = "none");

        // Ocultar Coluna Ações
        const acaoTH = document.querySelector("th:nth-child(8)");
        const acaoTDs = document.querySelectorAll("td:nth-child(8)");

        acaoTH.style.display = "none";
        acaoTDs.forEach(td => td.style.display = "none");

        // Remover modo escuro temporariamente
        const estavaEscuro = document.body.classList.contains('dark');
        if (estavaEscuro) document.body.classList.remove('dark');

        // Gera o PDF
        html2pdf().set(options).from(content).save().then(() => {

            // Restaurar botões e toggle
            document.querySelector('.area-botoes').style.display = 'block';
            document.getElementById('darkToggle').style.display = 'block';

            // Restaurar colunas
            fotoTH.style.display = "table-cell";
            fotoTDs.forEach(td => td.style.display = "table-cell");

            acaoTH.style.display = "table-cell";
            acaoTDs.forEach(td => td.style.display = "table-cell");

            if (estavaEscuro) document.body.classList.add('dark');
        });
    });

    // 🌙 Dark Mode com LocalStorage
    const toggle = document.getElementById('darkToggle');
    const savedMode = localStorage.getItem('darkMode');

    if (savedMode === 'enabled') {
        document.body.classList.add('dark');
        toggle.textContent = '☀️';
    } else {
        toggle.textContent = '🌙';
    }

    toggle.addEventListener('click', () => {
        document.body.classList.toggle('dark');
        if (document.body.classList.contains('dark')) {
            toggle.textContent = '☀️';
            localStorage.setItem('darkMode', 'enabled');
        } else {
            toggle.textContent = '🌙';
            localStorage.setItem('darkMode', 'disabled');
        }
    });
});
</script>




</body>
</html>
