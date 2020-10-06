<?php 
    require '../classes/classes.php';

    //INSERIR TAREFA
    function inserir(){

            session_start();
            $tarefa = new Tarefa();
            $tarefa->nome = $_POST['nome'];
            $tarefa->id_usuario = $_SESSION['id'];
        
            $tarefa_service = new TarefaService($tarefa);
            $tarefa_service->inserir('',[]);
        
            header('Location: ../nova_tarefa.php?tarefa=cadastrada');
    }

    //DELETAR TAREFA
    
    function apagar(){
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
        if($_GET['pag'] == 'todas'){
            header("Location: ../todas_tarefas.php");
        }else{
        header("Location: ../pendentes.php");
        }
    }

    //CONCLUIR TAREFA

    function concluir(){
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
    }

    //ENCERRAR SESSÃO

    function sair(){
        session_start();
        unset($_SESSION['id']);
    
       header('Location: ../index.php');
    }


    //VALIDAR LOGIN
    function valida_login(){
        $usuario = new Usuario($_POST['email'],$_POST['senha']);
        $acesso = $usuario->verificarUsuario();
        
    
        if($acesso == 1){
            session_start();
            $_SESSION['id'] = $usuario->getId();
            header('Location: ../pendentes.php');
    
        }else if($acesso == 0){
            header('Location: ../index.php?acesso=negado');
        }
    }


        //ATUALIZAR TAREFA

    function atualizar(){
        $tarefa = new Tarefa();
        $tarefa->nome = $_POST['tarefa'];
        $tarefa->id = $_POST['id'];
        $tarefa_service = new TarefaService($tarefa);
        $tarefa_service->atualizar("UPDATE tb_tarefas SET tarefa = '$tarefa->nome' WHERE id = $tarefa->id",[]);
        if(isset($_GET['src']) && $_GET['src'] == 'pendentes'){
            header("Location: ../pendentes.php");
        }else{
            header("Location: ../todas_tarefas.php");
        }
    }
    //executa a função correspondente com a acao desejada
    switch($_GET['acao']){
        case 'inserir':
            inserir();
        break;
        case 'apagar':
            apagar();
        break;
        case 'concluir':
            concluir();
        break;
        case 'sair':
            sair();
        break;
        case 'logar':
            valida_login();
        break;
        case 'atualizar':
            atualizar();
        break;
    }

?>
