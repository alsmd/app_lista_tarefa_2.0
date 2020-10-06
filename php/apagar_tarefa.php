<?php
    require "../classes/classes.php";
    session_start();
    $tarefa = new Tarefa();
    $tarefa_service = new TarefaService();


    $tarefa->id = $_GET['tarefa_id'];
    $tarefa->id_usuario = $_SESSION['id'];

    $query = "
        DELETE FROM
            tb_tarefas
        WHERE 
            id_usuario = :id AND id= $tarefa->id;
    ";

    $tarefa_service->remover($query,[':id' => $tarefa->id_usuario]);
    header("Location: ../todas_tarefas.php");
?>