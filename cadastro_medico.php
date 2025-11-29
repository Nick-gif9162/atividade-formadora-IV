<?php
    // Inclui a conexão com o banco de dados
    include("conexão.php");
    
    // Coleta os dados do formulário
    $crm = $_POST["crm"];
    $nome_medico= $_POST["nome_medico"];
    $especializacao = $_POST["especializacao"];
    $telefone = $_POST["telefone"];

    $status_message = "";

    
    $sql_check_crm = "SELECT COUNT(*) FROM medico WHERE crm = ?";
    $stmt_check_crm = $conexao->prepare($sql_check_crm);
    $stmt_check_crm->bind_param("s", $crm);
    $stmt_check_crm->execute();
    $stmt_check_crm->bind_result($crm_count);
    $stmt_check_crm->fetch();
    $stmt_check_crm->close();

    
    $sql_check_nome = "SELECT COUNT(*) FROM medico WHERE nome_medico = ?";
    $stmt_check_nome = $conexao->prepare($sql_check_nome);
    $stmt_check_nome->bind_param("s", $nome_medico);
    $stmt_check_nome->execute();
    $stmt_check_nome->bind_result($nome_count);
    $stmt_check_nome->fetch();
    $stmt_check_nome->close();

    if($crm_count > 0){
        
        $status_message = "
        <div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
        font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
            ❌ CRM já cadastrado! Redirecionando para o cadastro novamente...
        </div>";
        $redirect_page = "cadastro_medico.html";
    } elseif($nome_count > 0){
        
        $status_message = "
        <div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
        font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
            ❌ Nome de médico já cadastrado! Redirecionando para o cadastro novamente...
        </div>";
        $redirect_page = "cadastro_medico.html";
    } else {
        
        $sql = "INSERT INTO medico (crm,nome_medico,especializacao,telefone) VALUES (?,?,?,?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss",$crm,$nome_medico,$especializacao,$telefone);

        if($stmt->execute()){
            $status_message = "
            <div style='background-color:#4CAF50;color:white;padding:15px;margin:20px auto;border-radius:8px;
            font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
                ✅ Cadastro do médico realizado com sucesso! Redirecionando...
            </div>";
            $redirect_page = "pagina inicial e menu.html";
        } else {
            $status_message = "
            <div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
            font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
                ❌ Erro ao cadastrar: " . htmlspecialchars($stmt->error) . "
            </div>";
            $redirect_page = "cadastro_medico.html";
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

