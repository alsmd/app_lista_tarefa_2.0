<?php 
    require "../classes/classes.php";
    session_start();
    $tarefa = new Tarefa('',$_GET['tarefa_id']);
    $tarefa->setStatus($_GET['status_id']);
    $tarefa->concluirTarefa($_SESSION['id']);
    header("Location: ../todas_tarefas.php");

?>