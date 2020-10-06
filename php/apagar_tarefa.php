<?php
    require "../classes/classes.php";
    session_start();
    $tarefa = new Tarefa();
    $tarefa->id = $_GET['tarefa_id'];
    $tarefa->id_usuario = $_SESSION['id'];
    $tarefa->remover();
    header("Location: ../todas_tarefas.php");
?>