<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start(); 
        if($_SESSION['user_id']){
            $user_id = $_SESSION['user_id'];
        } else {
            header('Location: /');
            exit();
        }
    }
    $pageTitle = 'Pedidos';
    require_once __DIR__ . '/_headers.php';
?>