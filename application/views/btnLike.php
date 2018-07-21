<?php
	if (isset($_GET['idPost'])) {
		# code...
	}else{
		$_GET['idPost'] = $idPostagem;
	}
	$this->post->setId($_GET['idPost']);
	$this->post->refreshLike();
	//echo "<br />".$_GET['idPost'];
?>

<i  class="fa fa-thumbs-o-up like" onclick="liked('<?= $this->post->getId(); ?>');">&nbsp;&nbsp;<?= $this->post->getLikes(); ?></i>&nbsp;&nbsp;&nbsp; <i class="fa fa-thumbs-o-down deslike" onclick="desliked('<?= $this->post->getId(); ?>');">&nbsp;&nbsp;<?= $this->post->getDeslikes(); ?></i>&nbsp;&nbsp;<img title="imagem de um megafone para denunciar postagem" alt="imagem de um megafone para denunciar postagem" src="<?php echo base_url('assets/img/denuncia.png'); ?>" class="denuncia" onclick="denunciar('<?= $this->post->getId(); ?>');">

<?php if($this->post->existeDenunciaUsu($this->db)  == 'denunciado'): ?>	
	&nbsp;&nbsp;&nbsp;&nbsp;<big><i class="fa fa-medkit medikity" onclick="denunciarOf('<?= $this->post->getId(); ?>');"></i></big>
<?php endif; ?>
