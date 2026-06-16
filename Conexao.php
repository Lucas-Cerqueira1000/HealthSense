<?php
// Correção do Host (sem https) e ajuste da ordem dos parâmetros
$con = mysqli_connect('tcc_bd35.mysql.dbaas.com.br', 'tcc_bd35', 'ROSA123456a#', 'tcc_bd35');
// Logo após o mysqli_connect:
mysqli_set_charset($con, "utf8mb4");

if (!$con) 
{
    die('Erro ao conectar: ' . mysqli_connect_error());
}
?>