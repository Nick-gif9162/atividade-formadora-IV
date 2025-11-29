<?php
header("Content-Type: application/json; charset=UTF-8");
require_once("../db/conexão.php");

$especializacao = $_GET['especializacao'] ?? '';

if (empty($especializacao)) {
    echo json_encode([]);
    exit;
}

$sql = $conn->prepare("SELECT id_medico, nome FROM medico WHERE especializacao = ?");
$sql->bind_param("s", $especializacao);
$sql->execute();
$result = $sql->get_result();

$lista = [];
while ($row = $result->fetch_assoc()) {
    $lista[] = $row;
}

echo json_encode($lista);
