<?php
include("conexão.php");

// Coleta os dados do formulário
$cpf = $_POST["cpf"];
$nome_paciente= $_POST["nome_paciente"];
$email = $_POST["email"];
$telefone = $_POST["telefone"];
$cep = $_POST["cep"];
$data_consulta = $_POST["data_consulta"];
$hora = $_POST["hora"];
$nome_medico = $_POST["nome_medico"];
$descricao = $_POST["descricao"];

// --- Tratamento da imagem ---
$foto_paciente = null;
if(isset($_FILES["foto_paciente"]) && $_FILES["foto_paciente"]["error"] == 0){
    $diretorio = "uploads/";
    if(!is_dir($diretorio)){
        mkdir($diretorio, 0777, true);
    }
    $extensao = pathinfo($_FILES["foto_paciente"]["name"], PATHINFO_EXTENSION);
    $nome_arquivo = uniqid("paciente_", true) . "." . strtolower($extensao);
    $caminho_final = $diretorio . $nome_arquivo;
    $tipos_permitidos = ["jpg","jpeg","png","gif"];
    if(in_array(strtolower($extensao), $tipos_permitidos)){
        if(move_uploaded_file($_FILES["foto_paciente"]["tmp_name"], $caminho_final)){
            $foto_paciente = $caminho_final;
        }
    }
}

// Hash para dados sensíveis
$cpf_hash   = password_hash($cpf, PASSWORD_DEFAULT);
$cep_hash   = password_hash($cep, PASSWORD_DEFAULT);
$email_hash = password_hash($email, PASSWORD_DEFAULT);

// --- Verificação de conflito de data + hora + médico ---
$check = $conexao->prepare("SELECT id_consulta FROM consulta WHERE data_consulta = ? AND hora = ? AND nome_medico = ?");
$check->bind_param("sss", $data_consulta, $hora, $nome_medico);
$check->execute();
$result = $check->get_result();

$status_message = "";

if($result->num_rows > 0){
    // ⚠️ Já existe consulta nesse dia e horário com o mesmo médico
    $status_message = "
    <div style='background-color:#f9a825;color:white;padding:15px;margin:20px auto;border-radius:8px;
    font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
        ⚠️ Já existe uma consulta marcada para este médico neste dia e horário!
    </div>";
} else {
    // --- Inserção da consulta ---
    $sql = "INSERT INTO consulta (cpf,nome_paciente,email,telefone,cep,data_consulta,hora,nome_medico,descricao,foto_paciente)
            VALUES (?,?,?,?,?,?,?,?,?,?)";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssssssss",$cpf_hash,$nome_paciente,$email_hash, $telefone, $cep_hash, $data_consulta, $hora, $nome_medico,$descricao,$foto_paciente);

    if($stmt->execute()){
        $status_message = "
        <div style='background-color:#4CAF50;color:white;padding:15px;margin:20px auto;border-radius:8px;
        font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
            ✅ Cadastro realizado com sucesso! Redirecionando...
        </div>";
    } else {
        $status_message = "
        <div style='background-color:#f44336;color:white;padding:15px;margin:20px auto;border-radius:8px;
        font-family:sans-serif;font-size:1.2em;width:80%;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
            ❌ Erro ao cadastrar: " . htmlspecialchars($stmt->error) . "
        </div>";
    }

    $stmt->close();
}

$check->close();
$conexao->close();

// Imprime mensagem estilizada
echo "<!DOCTYPE html><html><head><title>Status</title></head><body>";
echo $status_message;

// Redireciona SEMPRE para o cadastro, variando tempo conforme situação
if($result->num_rows > 0){
    // Conflito → volta em 4 segundos
    echo "<script> 
        setTimeout(function(){
            window.location.href = 'cadastro.html';
        }, 4000); 
    </script>";
} else {
    // Sucesso ou erro → volta em 3 segundos
    echo "<script> 
        setTimeout(function(){
            window.location.href = 'cadastro.html';
        }, 3000); 
    </script>";
}

echo "</body></html>";
?>
