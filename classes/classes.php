<?php
    function executarQuery($query,$tratar,$qnt = 0){
        try{
            $conection = new DB();
            $conection = $conection->conectarDB();
            $stmt = $conection->prepare($query);
            foreach($tratar as $i => $dado){ //A query passada como parametro podera conter "variaveis", e relação variavel/valor sera passada como segundo parametro, tendo o nome da "variavel" ocupando o indice e seu respectivo valor  no posição correspondente(caso não exista variavel na query basta passar como parametro uma array vazia)
            $stmt->bindValue($i,$dado);
            } 
            
            $stmt->execute();
            if($qnt == 1){ //podemos decidir se vamos retornar 1 ou todos os registros
                $registros = $stmt->fetch();
            }else{
                $registros = $stmt->fetchAll();
            }

            return $registros; //retorna os registros que passaram pelo filtro

        }catch(PDOException $e){
            echo 'Erro: '. $e->getMessage();
        }
        
    }
    class DB{
        private $host = 'localhost';
        private $db = 'php_com_pdo';
        private $login = 'root';
        private $senha = '';
        private $conection;

        public function conectarDB(){
            try{
                $this->conection = new PDO("mysql:host=$this->host;dbname=$this->db",$this->login,$this->senha);
                return $this->conection;

            }catch(PDOException $e){
                echo 'Erro: '. $e->getMessage();
            }
        }
    }

    class TarefaService{
        private $db;
        private $tarefa;
        public function __construct(Tarefa $tarefa = null){
            $this->db = new DB();
            $this->db = $this->db->conectarDB();
            $this->tarefa = $tarefa;
        }
        public function inserir(){
            $query = "INSERT INTO tb_tarefas(tarefa,id_usuario)VALUES('{$this->tarefa->nome}',{$this->tarefa->id_usuario})";
            executarQuery($query,[]);
        }

        public function atualizar($query,$BL){
            executarQuery($query,$BL);
        }

        public function remover($query,$BL){
            executarQuery($query,$BL);
        }

        public function recuperar($where,$BL){
            $query = "
                SELECT
                    t.id AS tarefa_id ,t.tarefa AS tarefa_nome ,s.id AS status_id
                FROM
                    tb_usuarios AS u RIGHT JOIN tb_tarefas AS t ON (u.id_usuario = t.id_usuario) LEFT JOIN tb_status AS s ON(t.id_status = s.id) 
                WHERE
                $where
                ";
                $tarefas = executarQuery($query,$BL);
            return $tarefas;
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
            $verificar = executarQuery("SELECT * FROM tb_usuarios WHERE email = '$this->email' AND senha =  '$this->senha' ",[],1);
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
    }
?>