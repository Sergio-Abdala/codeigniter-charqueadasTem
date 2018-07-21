<?php 
	/**
	 * classe principal 
	 */
	class Usuario
	{
		protected $id;
		protected $nome;
		protected $nomee;
		protected $apelido;
		protected $nivel;
		protected $login;
		protected $senha;
		protected $data;
		function __construct($id, $nome)
		{
			$this->id = $id;
			$this->nome = $nome;
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
		//
		function novoUsu($conex, $login, $senha){
			//$ = htmlspecialchars(addslashes(trim(str)));
			$query = $conex->query("SELECT * FROM usuario WHERE login = '".htmlspecialchars(addslashes(trim($login)))."' && senha = '".htmlspecialchars(addslashes(trim($senha)))."';");
			if ($query->num_rows) {//USUARIO JÁ ESTA CADASTRADO NO SISTEMA COM ESTA SENHA...
				$usu = $query->fetch_object();
				setcookie('id', $usu->id, time() + (86400 * 30), "/"); // 86400 = 1 dia * 30 = 1 mes
				$this->id = $usu->id;
				$this->load($conex);
				return "logado como ".$this->nome;
			}else{
				$query2 = $conex->query("SELECT * FROM usuario WHERE login = '".htmlspecialchars(addslashes(trim($login)))."';");
				if ($query2->num_rows){
					return "você já é um usuario cadastrado, faça login...";
				}else{
					if(htmlspecialchars(addslashes(trim($login))) == htmlspecialchars(addslashes(trim($senha)))){
						$add = $conex->query("INSERT INTO usuario(apelido, login, senha, data) VALUES('".htmlspecialchars(addslashes(trim($this->nome)))."', '".htmlspecialchars(addslashes(trim($login)))."', '".htmlspecialchars(addslashes(trim($senha)))."', now());");
						$this->id = $conex->insert_id;
					}else{
						$add = $conex->query("INSERT INTO usuario(login, senha, data) VALUES('".htmlspecialchars(addslashes(trim($login)))."', '".htmlspecialchars(addslashes(trim($senha)))."', now());");
					}
					
					if ($add) {
						$cookie_name = "id";
						$cookie_value = $conex->insert_id;
						setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 dia * 30 = 1 mes
						//inserir na tabela
						return "cadastro realizado com sucesso...";
					}else{
						return "Falha no cadastro tente novamente...";
					}
				}
			}				
		}
		function logar($conex, $login, $senha){
			$query = $conex->query("SELECT * FROM usuario WHERE login = '".htmlspecialchars(addslashes(trim($login)))."' && senha = '".htmlspecialchars(addslashes(trim($senha)))."';");
			if ($query->num_rows) {
				$usu = $query->fetch_object();
				setcookie('id', $usu->id, time() + (86400 * 30), "/"); // 86400 = 1 dia * 30 = 1 mes
				$this->id = $usu->id;
				$this->load($conex);
				return "logado como ".$this->getNome();
			}else{
				return "você ñ é um usuario cadastrado...";
			}
		}
		function load($conex){
			$query = $conex->query("SELECT * FROM usuario WHERE id = '".$this->id."';");
			if ($query) {
				$usu = $query->fetch_object();
				if ($usu->apelido != '') {
					$this->nome = $usu->apelido;
				}elseif ($usu->nome != '' && $usu->nome != NULL) {
					$this->nome = $usu->nome;
				}else{
					$this->nome = $usu->login;
				}
				//$this->nome = ($usu->apelido != '') ? $usu->apelido : ($usu->nome != '' && $usu->nome != NULL) ? $usu->nome : $usu->login; ;;
				$this->nomee = $usu->nome;
				$this->apelido = $usu->apelido;
				$this->login = $usu->login;
				$this->senha = $usu->senha;
				$this->data = $usu->data;
				$this->loadNivel($conex);
			}
		}
		function loadNivel($conex){
			$query = $conex->query("SELECT * FROM usuNivel WHERE idusu = '".$this->id."';");
			if ($query && $query->num_rows > 0) {
				$resp = $query->fetch_object();
				$this->nivel = $resp->nivel;
			}else{
				//sem registro de nivel....
				$reg = $conex->query("INSERT INTO usuNivel (idusu, nivel, data) VALUES ('".$this->id."', 'usuario', now());");
				if($reg){
					$this->nivel = 'usuario';
				}
			}
		}
	}

?>