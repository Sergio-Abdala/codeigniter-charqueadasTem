<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>	
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="charqueadasTem site para fins academicos..."/>
    <meta name="author" content="Sérgio Abdala..."/>
	<meta charset="utf-8"/>
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/desenhando.png'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/estilo.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/grid.css'); ?>"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<body>
	<div class="row">
		<div class="col-">
			<h1><?php echo $titulo; ?></h1>
			<p><?php echo $paragrafo; ?></p>	
		</div>
	</div>
	<div class="row" style="position: absolute; bottom: 0;">
		<?php $this->load->view('footer'); ?>
	</div>			
</body>
</html>