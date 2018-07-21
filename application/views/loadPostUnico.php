<div style="text-align: left;">
<?php  
	$query = $this->db->query("SELECT * FROM postagem WHERE id = '".$id."';");
		if ($query) {
			foreach($query->result() as $con){
				if ($con->titulo != NULL || $con->texto != NULL) {
					$this->post->contLike($this->db);
					$foto = array();
					$query2 = $this->db->query("SELECT * FROM imagens WHERE idpost = '".$con->id."';");
					if ($query2) {
						foreach ($query2->result() as $consulta) {
							$foto[] = $consulta->img;
							//var_dump($consulta);
						}
					}
					?>
						<section class="col-">
							<h2><?= $con->titulo; ?></h2>
							<?php if(isset($foto[0])): ?>
								<div class="foto col- col-md-6">
									<div  class="label-ft-index">
										<label for="modal_2"><img title="<?= $con->titulo; ?>" alt="<?= $con->titulo; ?>" src="<?php echo base_url('assets/fotos/postagens/'.$foto[0]); ?>" id="foto<?= $con->id; ?>" onclick="verFoto('<?php echo base_url('assets/fotos/postagens/'.$foto[0]); ?>');" class="col- foto-index" alt="imagem da postagem"></label>
									</div>
									<div class="">
									<?php foreach ($foto as $k => $val) {
										//if ($k != 0) {
											?><img title="<?= $con->titulo; ?>" alt="<?= $con->titulo; ?>" src="<?php echo base_url('assets/fotos/postagens/'.$foto[$k]); ?>" class="col- col-xs-4" onclick="document.getElementById('foto<?= $con->id; ?>').src = `<?php echo base_url('assets/fotos/postagens/'.$foto[$k]); ?>`;" style='padding: 10px 10px 10px 10px;' alt="imagem da postagem"><?php
										//}
									} ?>
									</div>
								</div>
							<?php endif; ?>
							<p class="cor-txt tam-txt"><?= substr($con->texto, 0, 600); ?>...<br />
							 <?php if(strlen($con->texto) > 600): ?>
							  <small style="color: green;" onclick="document.getElementById('continua<?= $id; ?>').style.display='block';
							document.getElementById('small<?= $id; ?>').style.display='none';" id="small<?= $id; ?>"> Continuar...</small> 
							<?php endif; ?>
							 </p>
							 <p class="cor-txt tam-txt" style="display: none;" id="continua<?= $id; ?>"><?= substr($con->texto, 580); ?><br />
							 	<small style="color: green;" onclick="document.getElementById('continua<?= $id; ?>').style.display='none';
							document.getElementById('small<?= $id; ?>').style.display='block';" id="small<?= $id; ?>"> Ocultar...</small></p>
							<footer class="col-">
								<?php  
									//$usu = new Usuario($con->idusu, '');
									$this->usu->setId($con->idusu);
									$this->usu->load($con->idusu);
								?>
								publicado por: <?= $this->usu->getNome(); ?> <small style="font-size: 12px;">em <?= $con->data; ?></small>
							</footer>
							<div id="btnLike<?php echo $_GET['idPost']; ?>">
								<?php $this->load->view('btnLike'); ?>
							</div>
							
							<p id="respLike<?= $id; ?>"></p>
							<?php if(isset($_COOKIE['id'])): ?>
								<?php 
									$this->usu->setId($_COOKIE['id']); 
									$this->usu->load($_COOKIE['id']); 
								?>
								<?php if($this->usu->getNivel() == 'admin'): ?>
									
										<button class='btn col- col-md-6 col-lg-3' onclick="bloquearPost('<?= $id; ?>');"><strong class="alerta">Bloquear</strong></button>
									
										<button class='btn col- col-md-6 col-lg-3' onclick="liberarPost('<?= $id; ?>');"><strong class="alerta">Liberar</strong></button>
									
									<b id="respBlock"></b>
								<?php endif; ?>
							<?php endif; ?>
						</section>
					<?php
				}
			}
			
		}else{
			
		}
?>
</div>