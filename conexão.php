<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "clinica";
$conexao = new mysqli($servidor,$usuario,$senha, $banco);
if ($conexao ->connect_error){
    die ("erro de conexão:" .$conexao->connect_error);
}
else
    echo "";
?>