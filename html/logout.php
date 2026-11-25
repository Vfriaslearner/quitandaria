<?php
session_start();
require_once '../config/conexao.php';

//Ele sai da sessão e a destrói e ainda mantém esses dados salvos,interessante
if (isset($_SESSION['usuario_id'])) {
    $stmt=$pdo->prepare("INSERT INTO log_logout (id_usuario, ip_acesso) VALUES (:id_usuario,:ip)");
    $stmt->execute([
        ':id_usuario' =>$_SESSION['usuario_id'],
        ':ip'         =>$_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
    ]);
}


//DESTRÓI A SEÇÃO
$_SESSION =[];
session_destroy();

//voltar ao login

header('Location:index.php');
exit;