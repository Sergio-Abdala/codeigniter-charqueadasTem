<?php  
	$query = $this->db->query("SELECT * FROM postagem WHERE id = '".$id."';");
		if ($query) {
			$con = $query->row();
			if ($con->titulo != NULL || $con->texto != NULL) {
				$this->post->contLike($this->db);
				$foto = array();
				$query2 = $this->db->query("SELECT * FROM imagens WHERE idpost = '".$con->id."';");
				if ($query2) {
					
					foreach ($query2->result() as $row) {
						$foto[] = $row->img;
					}
				}
				?>
					<section class="col- col-xs-12 col-md-6" style="position: relative;">
						<h2><?= $con->titulo; ?></h2>
						<?php if(isset($foto[0])): ?>
							<div class="foto col- col-md-6 row">
								<label for="modal_2">
									<div class="label-ft-index">
										<img title="<?= $con->titulo; ?>" alt="<?= $con->titulo; ?>" src="<?php echo base_url('assets/fotos/postagens/'.$foto[0]); ?>" class="col-" id="foto<?= $con->id; ?>" onclick="verFoto(document.getElementById('foto<?= $con->id; ?>').src);" alt="imagem da postagem...">
									</div>
								</label>
								<?php foreach ($foto as $k => $val) {
										?> <div  class="col- col-xs-4 ft-pequena"> <img title="<?= $con->titulo; ?>" alt="<?= $con->titulo; ?>" src="<?php echo base_url('assets/fotos/postagens/'.$foto[$k]); ?>" onclick="document.getElementById('foto<?= $con->id; ?>').src = `<?php echo base_url('assets/fotos/postagens/'.$foto[$k]); ?>`;" class="col-" alt="iamgem da postagem"> </div> <?php
								} ?>
							</div>
						<?php endif; ?>
						<p class="cor-txt tam-txt"><?= substr($con->texto, 0, 600); ?>...<br />
						 <?php if(strlen($con->texto) > 600): ?>
						  <small style="color: green;" onclick="document.getElementById('continua<?= $id; ?>').style.display='block';
						document.getElementById('small<?= $id; ?>').style.display='none';" id="small<?= $id; ?>"> Continuar...</small> <!-- MUDAR ESTE SMALL E O BOTÃO ver / abrir -->
						<?php endif; ?>
						 </p>
						 <p class="cor-txt tam-txt" style="display: none;" id="continua<?= $id; ?>"><?= substr($con->texto, 580); ?><br />
						 	<small style="color: green;" onclick="document.getElementById('continua<?= $id; ?>').style.display='none'; 
						document.getElementById('small<?= $id; ?>').style.display='block';" id="small<?= $id; ?>"> Ocultar...</small></p>						
						<div style="min-height: 100px;"></div>
						<div style="bottom: 0; position: absolute; text-align: center;">
							<p id="respLike<?= $id; ?>" class="respLike"></p>
							<footer class="col-">
								<?php  
									//$usu = new Usuario($con->idusu, '');
									$this->usu->setId($con->idusu);
									$this->usu->load($con->idusu);
								?>
								publicado por: <?= $this->usu->getNome(); ?> <small style="font-size: 12px;">em <?= $con->data; ?></small>
							</footer>							
							<div class="row" id="btnLike<?= $this->post->getId(); ?>">
								<!-- btnLike.php -->
								<!--a href="<?php echo base_url('like?id='.$this->post->getId()); ?>"-->
								 <i onclick="liked('<?php echo $this->post->getId(); ?>')" class="fa fa-thumbs-o-up like" >&nbsp;&nbsp;<?= $lik; ?></i>
								<!--/a-->
								&nbsp;&nbsp;&nbsp; 
								<!--a href="<?php echo base_url('deslike?idPost='.$this->post->getId()); ?>"-->
								 <i onclick="desliked('<?php echo $this->post->getId(); ?>')" class="fa fa-thumbs-o-down deslike" >&nbsp;&nbsp;<?= $deslik; ?></i>
								<!--/a-->
								 &nbsp;&nbsp;
								 <!--a href="<?php echo base_url('denunciarPost?idPost='.$this->post->getId()); ?>"-->
								 <img title="imagem megafone denunciar postagem" alt="imagem megafone denunciar postagem" onclick="denunciar('<?php echo $this->post->getId(); ?>')" src="<?php echo base_url('assets/img/denuncia.png'); ?>" style="max-height: 30px;" alt="imagem da postagem">
								<!--/a-->
								<?php if($this->post->existeDenunciaUsu($this->db)  == 'denunciado'): ?>
									&nbsp;&nbsp;&nbsp;&nbsp;<big><i class="fa fa-medkit" style="color: green;" onclick="denunciarOf('<?= $this->post->getId(); ?>');"></i></big>
								<?php endif; ?>
							</div>
							<a href="<?php echo base_url('/?idPost='.$this->post->getId()); ?>">
								<button class="btn menu">Ver / Abrir</button>
							</a>
						</div>
					</section>
				<?php
			}
		}else{
			//echo mysqli_error($conex);
		}
?>