
<!DOCTYPE html>
<html>
<head>
	<title>404 Ops...</title><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="charqueadasTem site para fins academicos..."/>
    <meta name="author" content="Sérgio Abdala..."/>
	<meta charset="utf-8"/>
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/desenhando.png'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/estilo.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/grid.css'); ?>"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<style type="text/css">
		body{
			background: #fff;
		}
		.divum{
			text-align: center;
		}
		h1{
			color: #4f8a83;
			font-size: 169px;
			margin-bottom: -35px; 
			margin-top: -20px;
			position: relative;
			z-index: 5;
		}
		small#abduzida{
			color: #4f8a83;
			position: absolute;
			font-size: 50px;
			margin-top: 75px;
		}
		img{
			margin-top: -100px;
		}
		.rodape{
			text-align: right;
			margin-top: -100px;
		}
		footer#footer-principal{
			width: 99%;
			background-color: #fff;

		}
	</style>
</head>
<body>
	<div class="row">
		<div class="col- divum">
			<h1>404 </h1>
			<small id="abduzida">Pagina abduzida...</small>
			<img title="gif ovni abduzindo pagina web" alt="gif ovni abduzindo pagina web" src="<?php echo base_url('assets/img/ft404.gif'); ?>"><br />
			<div class="rodape">
				<!-- php/footer.php -->
				<?php $this->load->view('footer'); ?>			
			</div>				
		</div>		
	</div>
</body>
</html>