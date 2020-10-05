<?php
    require '../classes/classes.php';
    $usuario = new Usuario($_POST['email'],$_POST['senha']);
    $acesso = $usuario->verificarUsuario();
    

    if($acesso == 1){
        session_start();
        $_SESSION['id'] = $usuario->getId();
        header('Location: ../pendentes.php');

    }else if($acesso == 0){
        header('Location: ../index.php?acesso=negado');
    }
   
    

?>