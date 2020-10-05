<?php
    class DB{
        private $host = 'localhost';
        private $db = 'php_com_pdo';
        private $login = 'root';
        private $senha = '';
        private $conection;

        public function conectarDB(){
            $this->conection = new PDO("mysql:host=$this->host;dbname=$this->db",$this->login,$this->senha);

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

        public function mostrar($query,$tratar,$qnt = 0){
            $stmt = $this->db->query($query);
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
            $verificar = $crud->mostrar("SELECT * FROM tb_usuarios WHERE email = '$this->email' AND senha =  '$this->senha' ",[],1);
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
        public $nome = null;
        public $status = 'pendente';

        public function __construct($nome){
            $this->nome = $nome;
        }
    }


    


?>