<?php  	
	if (isset($_COOKIE['id'])) {
		$this->usu->load($_COOKIE['id']);
	}	
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
	<title>Painel de controle</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="charqueadasTem site para fins academicos...">
    <meta name="author" content="Sérgio Abdala...">
	<meta charset="utf-8">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/desenhando.png'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/estilo.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/grid.css'); ?>">
	<script src="<?php echo base_url('assets/js/ajax.js'); ?>"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="row">
		<header>
			<div class="dir"><a href="<?php echo base_url('destroiCookieId'); ?>" class="btn"><i class="fa fa-user-secret"></i> &nbsp; <small style="color: red;"><b id="usunivel"></b> sair...</small> </a></div><div id="statusLogin" class="dir"><?php $this->usu->load($_COOKIE['id']); 	echo "logado como: ".$this->usu->getNome(); ?></div>
		</header>	
		<div class="row corpo">
			<nav class="col-xs-12 col-md-3 col-xl-2" ><!-- MENU -->
				<ul>
					<a href="<?php echo base_url(''); ?>"><li class="btn menu" >Pagina inicial</li></a>
					<li class="btn menu" onclick="insFormPost();">Postar</li>
					<li class="btn menu" onclick="editar();"> Postagens <small class="alerta"> editar</small></li>
					<li class="btn menu" onclick="insereFormulario();">Login & Senha <small class="alerta">editar</small></li>
					<?php $this->usu->loadNivel(); ?>
					<?php if(isset($_COOKIE['id']) && $this->usu->getNivel() == 'admin'): ?>
						<div id="menuAdmin">
							<li><h5>Restrito ao administrador <small class="alerta"> e agora</small></h5></li>
							<li class="btn menu" onclick="carregaDenuncias();">denuncias <?php echo $this->post->contDenunciasPorCond('denunciado'); ?> </li>
							<a href="fotosSemPost">fotosSemPost <small class="alerta">beta...</small></a>
						</div>
					<?php endif; ?>
				</ul>
			</nav>
			<div class="col-xs-12 col-md-8 col-xl-10" >
				<div style="float: left;" class="row">
					<?php 
						if (isset($postEditado)) {
							echo "<p>".$postEditado."</p>";
						} 
					?>
					<div id="formularioUsu" class="col-xs-8 col-md-8 col-xl-8">	
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('footer'); ?>
	</div>
	<noscript> Navegador ñ suporta javascript...</noscript>
</body>
</html>