<?php
// O seu código PHP está correto para coletar os dados do gráfico
include("conexão.php");

// Consulta agregada para gráfico de médicos
$sql_grafico = "SELECT c.nome_medico AS nome_medico, COUNT(*) AS total 
                 FROM consulta c 
                 GROUP BY c.nome_medico 
                 ORDER BY total DESC";
$resultado_grafico = $conexao->query($sql_grafico);

$medicos = [];
$totais = [];

while($linha = $resultado_grafico->fetch_assoc()){
    $medicos[] = $linha["nome_medico"];
    $totais[] = (int)$linha["total"];
}
// Fechar a conexão
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Consultas por Médico</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* 🎨 Variáveis de Cores (Copiadas do seu código principal) */
        :root {
            --primary: #00b4d8;
            --primary-dark: #0077b6;
            --accent: #38b000;
            --background-gradient: linear-gradient(135deg, #caf0f8, #e0f7fa, #f0fff4);
            --card-bg: #ffffffcc;
            --text: #023047;
            --header-bg: #fff;
            --footer-bg: #f5f5f5;
            --shadow-color: rgba(0, 0, 0, 0.15);
            --text-light: #444;
            --canvas-bg: #ffffff; /* Fundo do container do gráfico */
        }

        /* 🌙 Dark Mode Overrides (Copiadas do seu código principal) */
        body.dark-mode {
            --background-gradient: linear-gradient(135deg, #1f2833, #0b1c2b, #132a41);
            --card-bg: #222f3e;
            --text: #e8ecef;
            --header-bg: #1f2833;
            --footer-bg: #1f2833;
            --primary: #48cae4;
            --primary-dark: #00b4d8;
            --shadow-color: rgba(0, 0, 0, 0.5);
            --text-light: #aaa;
            --canvas-bg: #1e1e1e; /* Fundo escuro para o container do gráfico */
        }

        /* ⚙️ Estilos Globais */
        body {
            font-family: "Poppins", sans-serif;
            background: var(--background-gradient);
            display: flex;
            flex-direction: column; 
            min-height: 100vh;
            margin: 0;
            color: var(--text);
            transition: all 0.5s ease;
            overflow-x: hidden; 
        }

        /* 🔝 Cabeçalho (Estilos da Página Inicial) */
        header {
            width: 100%;
            background-color: var(--header-bg);
            box-shadow: 0 2px 10px var(--shadow-color);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: background-color 0.5s ease;
        }

        header .title-group {
            display: flex;
            align-items: center;
        }

        header h2 {
            margin: 0;
            color: var(--primary-dark);
            font-size: 1.5rem;
            font-weight: 700;
            margin-left: 10px;
        }

        .header-actions {
            display: flex;
            gap: 15px; 
            align-items: center;
        }

        /* Classes de ícones do header */
        .dark-mode-toggle, .login-icon {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--text);
            transition: color 0.3s ease;
            padding: 0.5rem;
            border-radius: 50%;
            display: flex; 
            align-items: center;
            justify-content: center;
            text-decoration: none; 
        }

        .dark-mode-toggle:hover, .login-icon:hover {
            color: var(--primary);
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        /* Contêiner e Gráfico */
        #chart-container {
            width: 90%;
            max-width: 800px;
            height: 400px; /* Aumentado para melhor visualização */
            margin: 50px auto;
            background: var(--canvas-bg);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 12px var(--shadow-color);
            transition: all 0.5s ease;
        }
        
        /* Rodapé */
        footer {
            width: 100%;
            background-color: var(--footer-bg);
            padding: 1.5rem 0;
            text-align: center;
            margin-top: auto; 
            font-size: 0.85rem;
            color: var(--text-light);
            box-shadow: 0 -2px 10px var(--shadow-color);
            transition: background-color 0.5s ease, color 0.5s ease;
        }

    </style>
</head>
<body>


   <header>
        <div class="title-group">
            <i class="fas fa-hospital-alt" style="color: var(--primary-dark);"></i>
            <h2>Gestão Clínica - Saúde+</h2>
        </div>
        
        <div class="header-actions">
            <a href="pagina inicial e menu.html" class="login-icon" aria-label="Voltar ao Menu Principal">
                 <i class="fas fa-home"></i> 
            </a>

            <a href="cadastro_secretaria.html" class="login-icon" aria-label="Fazer Login">
                <i class="fas fa-user-circle"></i>
            </a>
            
            <button id="darkModeToggle" class="dark-mode-toggle" aria-label="Alternar modo escuro">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </header>


<div style="text-align: center; margin-top: 20px;">
    <h1>📊 Gráfico: Consultas por Médico</h1>
</div>

<div id="chart-container">
    <canvas id="grafico"></canvas>
</div>

<footer>
    <p>© 2025 Clínica Saúde+ — Todos os direitos reservados</p>
    <div class="social-links">
        </div>
</footer>

<script>
    const labels = <?php echo json_encode($medicos); ?>;
    const dados = <?php echo json_encode($totais); ?>;
    
    const body = document.body;
    const toggle = document.getElementById('darkModeToggle');
    const icon = toggle.querySelector('i');
    let chartInstance; // Variável para armazenar a instância do Chart.js

    // Cores padrão para o gráfico no Light Mode
    const lightColors = {
        primary: '#00b4d8',
        text: '#023047',
        grid: 'rgba(0, 0, 0, 0.1)',
        bar: '#0077b6'
    };

    // Cores para o gráfico no Dark Mode
    const darkColors = {
        primary: '#48cae4',
        text: '#e8ecef',
        grid: 'rgba(255, 255, 255, 0.1)',
        bar: '#00b4d8'
    };

    // Função para criar/atualizar o gráfico
    function createChart(mode) {
        const colors = mode === 'dark' ? darkColors : lightColors;

        if (chartInstance) {
            chartInstance.destroy();
        }

        const ctx = document.getElementById('grafico').getContext('2d');
        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Consultas',
                    data: dados,
                    backgroundColor: colors.bar,
                    borderColor: colors.primary,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: colors.text // Cor da legenda
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: {
                            color: colors.text // Cor dos ticks do eixo Y
                        },
                        grid: {
                            color: colors.grid // Cor da grade do eixo Y
                        }
                    },
                    x: {
                        ticks: {
                            color: colors.text, // Cor dos ticks do eixo X
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            color: colors.grid // Cor da grade do eixo X
                        }
                    }
                }
            }
        });
    }

    // Lógica do Modo Escuro (Copiada e adaptada)
    const userPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    let currentMode = localStorage.getItem('theme') || (userPrefersDark ? 'dark' : 'light');

    function applyMode(mode) {
        if (mode === 'dark') {
            body.classList.add('dark-mode');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        } else {
            body.classList.remove('dark-mode');
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        }
        localStorage.setItem('theme', mode);
        createChart(mode); // Recria/Atualiza o gráfico
    }

    // Aplica o modo inicial e cria o gráfico
    applyMode(currentMode);

    // Evento de clique para alternar o modo
    toggle.addEventListener('click', () => {
        currentMode = body.classList.contains('dark-mode') ? 'light' : 'dark';
        applyMode(currentMode);
    });
</script>

</body>
</html>



