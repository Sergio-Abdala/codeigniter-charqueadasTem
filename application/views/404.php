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
			flex: 1;
			text-align: center;
		}
		img{
			margin-top: 100px;
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
			<img title="imagem 404 manopla do infinito thanos Vingadores..." alt="imagem 404 manopla do infinito thanos Vingadores..." src="<?php echo base_url('assets/img/404_thanos.png'); ?>"><br />			
		</div>		
		<!-- php/footer.php -->
		<?php $this->load->view('footer'); ?>							
	</div>
</body>
</html>