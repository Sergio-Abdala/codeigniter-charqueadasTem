<?php  
	/**
	 * 
	 */
	class Admin extends Usuario
	{
		protected $idPost;
		function __construct($id, $nome){
			parent::__construct($id, $nome);
		}
		function formEditarUsu($conex){
			parent::load($conex);
			if ($this->login == $this->senha) {
				echo "<p class='info'>logado pelo facebook...</p>";
			}else{
				?>
					<p class="info">logado como: <?php echo $this->nome; ?>
					<form action="php/editarUsuario.php" method="GET">
						<label>nome</label><input type="text" name="nome" value="<?= $this->nomee; ?>"><br />
						<label>apelido</label><input type="text" name="apelido" value="<?= $this->apelido; ?>"><br />
						<label>login</label><input type="text" name="login" value="<?= $this->login; ?>"><br />
						<label>senha</label><input type="password" name="senha" value="<?= $this->senha; ?>"><br />
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
		function formPost($conex){
			//id da postagem??
			$query = $conex->query("INSERT INTO postagem(idusu, data) VALUES('".$this->id."', now());");
			if ($query) { // foi preciso criar a postagem para ter o id da mesma...
				$this->idPost = $conex->insert_id;
				setcookie('idPost', $this->idPost, time() + (86400), "/"); // 86400 = 1 dia
			}
			?>
				<form method="POST" action="php/exeEditPost.php" class="col-">
					<!--input type="number" name="idPost" value="<?= $this->idPost; ?>"><br /-->
					<input type="text" name="titulo" placeholder="Titulo da postagem (opcional)" class="col-"><br /><br />
					<textarea name="texto" placeholder="digite seu texto aqui..." rows="7" class="col-"></textarea><br />
					<input type="submit" name="btnPostar" value="Postar" class="btn col- col-md-4 col-md-4">
				</form>
				<iframe src="download_img/" scrolling="no" class="col-"></iframe>
			<?php
		}
		function formEditPost($conex){
			//id da postagem??
			$query = $conex->query("SELECT * FROM postagem WHERE id = '".$_GET['idPost']."';");
			if ($query) { // foi preciso criar a postagem para ter o id da mesma...
				$this->idPost = $_GET['idPost'];
				setcookie('idPost', $this->idPost, time() + (86400), "/"); // 86400 = 1 dia
				$table = $query->fetch_object();
				?>
					<form method="POST" action="php/exeEditPost.php">
						<!--input type="number" name="idPost" value="<?= $this->idPost; ?>"><br /-->
						<input type="text" name="titulo" placeholder="Titulo da postagem (opcional)" class="col-" value="<?= $table->titulo; ?>"><br /><br />
						<textarea name="texto" placeholder="digite seu texto aqui..." rows="7" class="col-"><?= $table->texto; ?></textarea><br />
						<input type="submit" name="btnPostar" value="Postar" class="btn col- col-md-4 col-md-4">
					</form>
					<div class="col- row">
						<?php  
							$query2 = $conex->query("SELECT * FROM imagens WHERE idpost = '".$this->idPost."';");
							if ($query2 && $query2->num_rows > 0) {
								while ($foto = $query2->fetch_object()) {
									echo "<div class='col- col-xs-6 col-md3- col-lg-2'> <img src='fotos/postagens/".$foto->img."' class='col-' alt='imagem da postagem'><button class='btn col-' onclick='excluirFoto(`".$foto->id."`);'>excluir</button><small id='respExcluir".$foto->id."' style='padding: 5px;'></small></div><div style='min-width:20px;'></div>";
								}
							}
						?>
					</div>
					<iframe src="download_img/" scrolling="no" class="col-"></iframe>
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
		function editPost($conex, $titulo, $texto){
			$query = $conex->query("UPDATE postagem SET titulo = '".$titulo."', texto = '".$texto."' WHERE id = '".$_COOKIE['idPost']."';")or die(mysqli_error($conex));
			if ($query) {
				require 'classePostagem.php';
				$post = new Postagem($_COOKIE['idPost']);
				$post->like($conex, 'like');
				return 'Postagem bem sucedida...';
			}else{
				return 'Falha na postagem';
			}
		}
	}
?>