<?php
    class DB{
        private $host = 'localhost';
        private $db = 'php_com_pdo';
        private $login = 'root';
        private $senha = '';
        private $conection;

        public function conectarDB(){
            try{
                $this->conection = new PDO("mysql:host=$this->host;dbname=$this->db",$this->login,$this->senha);
            }catch(PDOException $e){
                echo 'Erro: '. $e->getMessage();
            }
            

            return $this->conection;
        }




    }

    class Crud{
        private $db;
        private $tabela;

        public function __construct(){
            $this->db = new DB();
            $this->db = $this->db->conectarDB();
            
        }

        public function executarQuery($query,$tratar,$qnt = 0){
            try{
                $stmt = $this->db->prepare($query);
                foreach($tratar as $i => $dado){ //A query passada como parametro podera conter "variaveis", e relação variavel/valor sera passada como segundo parametro, tendo o nome da "variavel" ocupando o indice e seu respectivo valor  no posição correspondente(caso não exista variavel na query basta passar como parametro uma array vazia)
                $stmt->bindValue($i,$dado);
                } 
                
                $stmt->execute();
                if($qnt == 1){ //podemos decidir se vamos retornar 1 ou todos os registros
                    $registros = $stmt->fetch();
                }else{
                    $registros = $stmt->fetchAll();
                }
            }catch(PDOException $e){
                echo 'Erro: '. $e->getMessage();
            }
            
            return $registros; //retorna os registros que passaram pelo filtro
        }


    }
    
    class Usuario{
        private $id = null;
        private $nome = null;
        private $email = null;
        private $senha = null;

        public function __construct($email,$senha){
            $this->email = $email;
            $this->senha = $senha;
        }
        //verifica se o usuario esta cadastrado no banco
        public function verificarUsuario(){
            $crud= new Crud();
            $verificar = $crud->executarQuery("SELECT * FROM tb_usuarios WHERE email = '$this->email' AND senha =  '$this->senha' ",[],1);
            if(!(empty($verificar))){
                $this->id = $verificar['id_usuario'];
                $this->nome = $verificar['nome'];
                return 1;
            }else{
                return 0;
            }
        }

        public function getId(){
            return $this->id;
        }

    }       

    class Tarefa{
        private $nome = null;
        private $status;
        private $crud;
        private $id = null;
        public function __construct($nome = null,$id = null){
            $this->nome = $nome;
            $this->id = $id;
            $this->crud = new Crud();
        }
        public function setStatus($status){
            if($status == 1 || $status == 2){
                $status = $status == 1? 2 : 1;
                $this->status = $status;
            }
        }

        public function registrarTarefa($id){
            $query = "INSERT INTO tb_tarefas(tarefa,id_usuario)VALUES('$this->nome',$id)";
            $this->crud->executarQuery($query,[]);
        }
        public function apagarTarefa($id_usuario){
            $query = "
                DELETE FROM
                    tb_tarefas
                WHERE 
                    id_usuario = :id AND id= $this->id;
            ";
            $this->crud->executarQuery($query,[':id' => $id_usuario]);
        }
        public function concluirTarefa($id_usuario){
            $query = "
                UPDATE
                    tb_tarefas
                SET
                    id_status = $this->status
                WHERE 
                    id_usuario = :id AND id= $this->id;
            ";
            $this->crud->executarQuery($query,[':id' => $id_usuario]);
        }

    }


    


?>