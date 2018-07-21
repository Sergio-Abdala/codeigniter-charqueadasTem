<?php  
	/**
	 * 
	 */
	class ClasseAdmin extends CI_Model {
		protected $idPost;
			protected $id;
			protected $nome;
			protected $nomee;
			protected $apelido;
			protected $nivel;
			protected $login;
			protected $senha;
			protected $data;

		function __construct(){
			parent::__construct();
		}
		// set's
			public function setId($id){
				$this->id = $id;
			}
			public function setNome($nome){
				$this->nome = $nome;
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
					//$this->nome = ($usu->apelido != '') ? $usu->apelido : ($usu->nome != '' && $usu->nome != NULL) ? $usu->nome : $usu->login; ;;
					$this->nomee = $usu->nome;
					$this->apelido = $usu->apelido;
					$this->login = $usu->login;
					$this->senha = $usu->senha;
					$this->data = $usu->data;
					$this->loadNivel();
				}
		}
		function loadNivel(){
			$this->db->where('idusu', $this->id);
			$query = $this->db->get('usuNivel', 1);
			if ($query->num_rows() == 1) {
				$resp = $query->row();
				$this->nivel = $resp->nivel;
			}else{
				//sem registro de nivel....
				//$reg = $conex->query("INSERT INTO usuNivel (idusu, nivel, data) VALUES ('".$this->id."', 'usuario', now());");
				$this->nivel = 'usuario';
			}
		}
		function formEditarUsu(){
			$this->load($_COOKIE['id']);
			if ($this->login == $this->senha) {
				echo "<p class='info'>logado pelo facebook...</p>";
			}else{
				?>
					<p class="info">logado como: <?php echo $this->nome; ?>
					<form action="editarUsuario" method="POST">
						<label>nome</label><input type="text" name="nome" value="<?= $this->nomee; ?>"><br />
						<label>apelido</label><input type="text" name="apelido" value="<?= $this->apelido; ?>"><br />
						<label>login</label><input type="text" name="login" value="<?= $this->login; ?>"><br />
						<label>senha</label><input type="password" name="senha" value=""><br /><!-- <?= $this->senha; ?> -->
						<label>repetir senha</label><input type="password" name="senha2" value=""><br />
						<input type="submit" name="btnEditar" class="btn col-xs-12 col-md-4" value="EDITAR...">
					</form>
				<?php
			}
		}
		function editUso($conex, $nome, $apelido, $login, $senha){
			if (isset($_COOKIE['id'])) {
				$query = $conex->query("UPDATE usuario SET nome = '".$nome."', apelido = '".$apelido."', login = '".$login."', senha = '".$senha."' WHERE id = '".$_COOKIE['id']."';")or die(mysqli_error($conex));
				if ($query) {
					return '<script>alert(`informações atualizadas com sucesso...`); window.location=`../paineldecontrole.php`;</script>';
				}else{
					return '<script>alert(`não foi possivel atualizar o cadastro, tente novamente...`); window.location=`../paineldecontrole.php`;</script>';
				}
			}	
		}
		function formPost(){
			$dados = array(
				'idusu' => $this->id,
				'data' => date('Y-m-d H:i:s')
			);
			$this->db->insert('postagem', $dados);
			$this->idPost = $this->db->insert_id();
			setcookie('idPost', $this->idPost, time() + (86400), "/"); // 86400 = 1 dia
			?>
				<?php  
				echo form_open('Pagina/painelControle', array('class' => 'col-'));
				echo form_input('titulo', '', array('class' => 'col-', 'placeholder' => 'Titulo da postagem (opcional)'))."<br />";
				echo form_textarea('texto','', array('rows' => '7', 'class' => 'col-', 'placeholder' => 'digite seu texto aqui...'))."<br />";
				echo form_submit('btnPostar', 'Postar', array('class' => 'btn col- col-md-4 col-md-4'));
				?>					
				<iframe src="<?php echo base_url('assets/download_img/'); ?>" scrolling="no" class="col-"></iframe>
			<?php
		}
		function formEditPost(){
			$query = $this->db->query("SELECT * FROM postagem WHERE id = '".$_GET['idPost']."';");
			if ($query) { // foi preciso criar a postagem para ter o id da mesma...
				$this->idPost = $_GET['idPost'];
				setcookie('idPost', $this->idPost, time() + (86400), "/"); // 86400 = 1 dia
				$table = $query->row();
				?>
					<?php  
					echo form_open('Pagina/exeEditPost');
					echo form_input('titulo', $table->titulo, array('class' => 'col-'))."<br />";
					echo form_textarea('texto', $table->texto, array('rows' => '7', 'class' => 'col-'))."<br />";
					echo form_submit('btnPostar', 'Postar', array('class' => 'btn col- col-md-4 col-md-4'));
					echo form_close(); // esquecer de fechar essa merda me deu maior dor de cabeça....
					?>
					<div class="col- row">
						<?php  
							$query2 = $this->db->query("SELECT * FROM imagens WHERE idpost = '".$this->idPost."';");
							if ($query2->num_rows() > 0) {
								foreach ($query2->result() as $foto) {
									$imgUrl = base_url('assets/fotos/postagens/'.$foto->img);
									echo "<div class='col- col-xs-6 col-md3- col-lg-2'> <img src='".$imgUrl."' class='col-' alt='imagem da postagem'><button class='btn col-' onclick='excluirFoto(`".$foto->id."`, `".$imgUrl."`);'>excluir</button><small id='respExcluir".$foto->id."' style='padding: 5px;'></small></div><div style='min-width:20px;'></div>";
								}
							}
						?>
					</div>
					<iframe src="<?php echo base_url('assets/download_img/'); ?>" scrolling="no" class="col-"></iframe>
				<?php
			}
		}
		function cadImg($conex, $img){
			$query = $conex->query("INSERT INTO imagens(idpost, img) VALUES('".$_COOKIE['idPost']."', '".$img."');")or die(mysqli_error($conex));
			if ($query) {
				return 'arquivo enviado';
			}else{
				return 'falha no envio do arquivo';
			}
		}
		function editPost($titulo, $texto){
			//
			$this->db->set('titulo', $titulo);
			$this->db->set('texto', $texto);
			$this->db->where('id', $_COOKIE['idPost']);
			$this->db->update('postagem');
			if($this->db->affected_rows()){
				$this->post->setId($_COOKIE['idPost']);
				$this->post->like('like');
				return 'Postagem bem sucedida...';
			}else{
				return 'Falha na postagem';
			}
		}
	}
?>