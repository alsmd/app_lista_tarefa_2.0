<?php 
    require "../classes/classes.php";
    session_start();
    $tarefa = new Tarefa();
    $tarefa_service = new TarefaService();


    $tarefa->id = $_GET['tarefa_id'];
    $tarefa->id_status = $_GET['status_id'];
    $tarefa->id_usuario = $_SESSION['id'];
    $tarefa->trocarStatus();
    $query = "
        UPDATE
            tb_tarefas
        SET
            id_status = $tarefa->id_status
        WHERE 
            id_usuario = :id AND id= $tarefa->id;
    ";

    $tarefa_service->atualizar($query,[':id' => $tarefa->id_usuario]);

    if($_GET['pag'] == 'todas'){
        header("Location: ../todas_tarefas.php");
    }else{
    header("Location: ../pendentes.php");
    }

?>