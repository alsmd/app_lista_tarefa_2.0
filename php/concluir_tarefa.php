<?php 
    require "../classes/classes.php";
    session_start();
    $tarefa = new Tarefa();
    $tarefa->id = $_GET['tarefa_id'];
    $tarefa->id_status = $_GET['status_id'];
    $tarefa->id_usuario = $_SESSION['id'];
    $tarefa->trocarStatus();
    $tarefa->atualizar();

    if($_GET['pag'] == 'todas'){
        header("Location: ../todas_tarefas.php");
    }else{
    header("Location: ../pendentes.php");
    }

?>