<?php
require_once("db/conexão.php");

$especializacao = $_POST['especializacao'];
$id_medico      = $_POST['id_medico'];
$data           = $_POST['data_consulta'];
$hora           = $_POST['hora_consulta'];
$descricao      = $_POST['descricao'];

$sql = $conn->prepare("
    INSERT INTO consultas (especializacao, id_medico, data_consulta, hora_consulta, descricao)
    VALUES (?, ?, ?, ?, ?)
");

$sql->bind_param("sisss", $especializacao, $id_medico, $data, $hora, $descricao);

if ($sql->execute()) {
    echo "Consulta cadastrada com sucesso!";
} else {
    echo "Erro ao cadastrar consulta.";
}
