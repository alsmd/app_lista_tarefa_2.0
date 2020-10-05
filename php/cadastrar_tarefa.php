<?php
    require '../classes/classes.php';
    session_start();
    $tarefa = new tarefa($_POST['nome']);
    $tarefa->registrarTarefa($_SESSION['id']);
    header('Location: ../nova_tarefa.php?tarefa=cadastrada');
?>

