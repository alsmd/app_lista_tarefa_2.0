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
        private $id = null;
        private $nome = null;
        private $id_status;
        private $id_usuario;
        private $crud;
        public function __construct(){
            $this->crud = new Crud();
        }
        public function trocarStatus(){
            if($this->id_status == 1 || $this->id_status == 2){
                $this->id_status = $this->id_status == 1? 2 : 1;
            }
        }
        public function __get($atr){
            return $this->$atr;
        }
        public function __set($atr,$valor){
            $this->$atr = $valor;
        }
        public function inserir(){
            $query = "INSERT INTO tb_tarefas(tarefa,id_usuario)VALUES('$this->nome',$this->id_usuario)";
            $this->crud->executarQuery($query,[]);
        }
        public function remover(){
            $query = "
                DELETE FROM
                    tb_tarefas
                WHERE 
                    id_usuario = :id AND id= $this->id;
            ";
            $this->crud->executarQuery($query,[':id' => $this->id_usuario]);
        }
        public function atualizar(){
            $query = "
                UPDATE
                    tb_tarefas
                SET
                    id_status = $this->id_status
                WHERE 
                    id_usuario = :id AND id= $this->id;
            ";
            $this->crud->executarQuery($query,[':id' => $this->id_usuario]);
        }
        public function recuperar($query){
            $crud = new Crud();
            $tarefas = $crud->executarQuery($query,[':id' => $this->id]);
            return $tarefas;
        }


    }


    


?>