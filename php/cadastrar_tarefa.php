<?php
    require '../classes/classes.php';
    session_start();
    $tarefa = new tarefa();
    $tarefa->nome = $_POST['nome'];
    $tarefa->id_usuario = $_SESSION['id'];
    $tarefa->inserir();
    header('Location: ../nova_tarefa.php?tarefa=cadastrada');
?>

