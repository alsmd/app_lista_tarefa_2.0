<?php
    require "../classes/classes.php";
    session_start();
    $tarefa = new Tarefa('',$_GET['tarefa_id']);
    $tarefa->apagarTarefa($_SESSION['id']);
    header("Location: ../todas_tarefas.php");
?>