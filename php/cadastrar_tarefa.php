<?php
    require '../classes/classes.php';
    session_start();
    $tarefa = new Tarefa();
    $tarefa_service = new TarefaService();

    $tarefa->nome = $_POST['nome'];
    $tarefa->id_usuario = $_SESSION['id'];

    $tarefa_service->inserir("INSERT INTO tb_tarefas(tarefa,id_usuario)VALUES('$tarefa->nome',$tarefa->id_usuario)",[]);

    header('Location: ../nova_tarefa.php?tarefa=cadastrada');
?>

