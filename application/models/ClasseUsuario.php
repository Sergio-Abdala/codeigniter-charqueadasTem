<?php 
	/**
	 * classe principal 
	 */
	class ClasseUsuario extends CI_Model {		
		// atributos
			protected $id;
			protected $nome;
			protected $nomee;
			protected $apelido;
			protected $nivel;
			protected $login;
			protected $senha;
			protected $data;

		function __construct(){
			parent:: __construct();
		}		
		// GET's
			function getId(){
				return $this->id;
			}
			function getNome(){
				return $this->nome;
			}
			function getNomee(){
				return $this->nomee;
			}
			function getApelido(){
				return $this->apelido;
			}
			function getLogin(){
				return $this->login;
			}
			function getSenha(){
				return $this->senha;
			}
			function getData(){
				return $this->data;
			}
			function getNivel(){
				return $this->nivel;
			}
		// SET's
			public function setId($id){
				$this->id = $id;
			}
			public function setNome($nome){
				$this->nome = $nome;
			}
		function novoUsu($login, $senha){
			//codeigniter
				$this->db->where('login', $login); // WHERE login = $login
				$temUsu = $this->db->get('usuario', 1); // SELECT * FROM usuario LIMIT 1
				if ($temUsu->num_rows() == 1) { // tá obvio demais...
					$rowUsu = $temUsu->row(); // 
					//return "<br />usu id :=>".$rowUsu->id."<br />login :=>".$rowUsu->login."<br />senha :=>".$rowUsu->senha;
					if ($rowUsu->senha == $senha) {						
						setcookie('id', $rowUsu->id, time() + (86400 * 30), "/"); // 86400 = 1 dia * 30 = 1 mes
						$this->load($rowUsu->id);
						return 'usuario já cadastrado, logado como: '.$rowUsu->login;

					}else{
						return 'usuario já cadastrado, senha incorreta, entre com a senha correta...';
					}
				}else{
					$query = $this->db->query("INSERT INTO usuario (login, senha, data) VALUES ('".$login."', '".$senha."', now());");
					if($query){
						$idusu = $this->db->insert_id();
						setcookie('id', $idusu, time() + (86400 * 30), "/"); // 86400 = 1 dia * 30 = 1 mes
						return 'novo usuario '.$login.' cadastrado com sucesso...';
					}else{
						return 'falha no cadastro de novo usuario';
					}
					
				}			
		}
		function logar($login, $senha){
			$this->db->where('login', $login);
			$dados = $this->db->get('usuario', 1);
			if ($dados->num_rows() == 1) { // tá obvio demais...
				$usu = $dados->row();
				if ($usu->senha == $senha) {
					setcookie('id', $usu->id, time() + (86400 * 30), "/"); // 86400 = 1 dia * 30 = 1 mes
					$this->id = $usu->id;
					$this->load($this->id);
					return "logado como ".$this->getNome();
				}else{
					return "você ñ é um usuario cadastrado...";
				}
			}else{
				return 'erro no login';
			}
		}
		function load($id){
				$this->db->where('id', $id); // WHERE login = $login
				$temId = $this->db->get('usuario', 1); // SELECT * FROM usuario LIMIT 1
				if ($temId->num_rows() == 1) { // tá obvio demais...
					$usu = $temId->row(); // 
					if ($usu->apelido != '') {
					$this->nome = $usu->apelido;
					}elseif ($usu->nome != '' && $usu->nome != NULL) {
						$this->nome = $usu->nome;
					}else{
						$this->nome = $usu->login;
					}
					//
						$this->nomee = $usu->nome;
						$this->apelido = $usu->apelido;
						$this->login = $usu->login;
						$this->senha = $usu->senha;
						$this->data = $usu->data;
					$this->loadNivel();
				}
		}
		function loadNivel(){
			$this->nivel = 'usuario';
			if (isset($_COOKIE['id'])) {
				$this->db->where('idusu', $_COOKIE['id']);
				$query = $this->db->get('usuNivel', 1);
				if ($query->num_rows() == 1) {
					$resp = $query->row();
					$this->nivel = $resp->nivel;
				}
			}				
		}
	}

?>