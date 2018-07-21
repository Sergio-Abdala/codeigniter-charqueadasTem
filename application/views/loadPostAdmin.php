<?php  
	$query = $this->db->query("SELECT * FROM postagem WHERE id = '".$id."';");
		if ($query) {
			$con = $query->row();
			if ($con->titulo != NULL || $con->texto != NULL) {
				$this->post->contLike($this->db);
				$foto = array();
				$query2 = $this->db->query("SELECT * FROM imagens WHERE idpost = '".$con->id."';");
				if ($query2) {
					foreach ($query2->result() as $consulta) {
						$foto[] = $consulta->img;
					}
				}
				?>
					<section class="col-">
						<h2><?= $con->titulo; ?></h2>
						<?php if(isset($foto[0])): ?>
							<img title="<?= $con->titulo; ?>" alt="<?= $con->titulo; ?>" src="<?php echo base_url('assets/fotos/postagens/'.$foto[0]); ?>" class="foto col- col-md-6 col-lg-3" alt="imagem referente a outra postagem">
						<?php endif; ?>
						<p class="cor-txt"><?= $con->texto; ?></p>
						<footer class="col-">
							<?php  
								//usu = new Usuario($_COOKIE['id'], '');
								$this->usu->setId($_COOKIE['id']);
								$this->usu->load($_COOKIE['id']);
							?>
							publicado por: <?= $this->usu->getNome(); ?> <small style="font-size: 12px;">em <?= $con->data; ?></small>
						</footer>
						<?php if (isset($botoesEditarExcluir)) {
							echo $botoesEditarExcluir;
						} 
						$dados['idPostagem'] = $id;
						$this->load->view('btnLike', $dados);
						?>
						
					</section>
				<?php
			}
		}else{
			echo mysqli_error($this->db);
		}
?>