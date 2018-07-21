
<!DOCTYPE html>
<head>
	<html lang="pt-BR">
	<title><?= $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="charqueadasTem site para fins academicos..."/>
    <meta name="author" content="Sérgio Abdala..."/>
	<meta charset="utf-8"/>
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/desenhando.png'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/estilo.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/grid.css'); ?>"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<style type="text/css">
		
	</style>
</head>
<body onload="animeLogin();">
<script>
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    if (response.status === 'connected') {
      testAPI(response.authResponse.userID);
    } else {
      document.getElementById('status').innerHTML = 'entre com sua conta do FACEBOOK';
    }
  }
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '2021059334841626',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };
  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/pt_BR/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  function testAPI(userID) {
    console.log('Bem vindo!  Forneça suas informações de login.... ');
    FB.api('/me', function(response) {
      console.log('Logado como: ' + response.name);
      document.getElementById('status').innerHTML = 'Logado ao FACEBOOK como,  ' + response.name + '!';
      <?php if(!isset($_COOKIE['id'])): ?>
        if (confirm('logado como '+response.name+' pelo seu login do facebook, PERMANECER logado???')) {
        	window.location = 'fbLogar?nome='+response.name+'&id='+userID;
        }
      <?php endif; ?>
    });
  }
</script>
	<div class="row">
		
			<header class="row">
				<div class="col-xs-2"><img title="logotipo da cidade de charqueadas" alt="logotipo da cidade de charqueadas" src="<?php echo base_url('assets/img/logo.png'); ?>" class="logotipo" alt="logotipo..."></div>				
				<div id="tamanhoTela"></div>
				<div class="col-xs-10">
					<?php 
						if ($formError) {
							echo "<p>".$formError."</p>";
						}
						echo form_open('#',array('class' => 'dir col-'));
						echo form_input('busca', '', array('class' => 'campo-busca'));
						echo form_label('&#128269;', 'busca', array('class' => 'lupa'));
						echo form_submit('enviar', '', array('class' => 'lupa'));
						echo form_close();
					?>
					<!--form class="dir col-">
						<input type="text" name="busca" class="campo-busca" onclick="tempoInfinitoCarrossel()">
						<button class="lupa">&#128269;</button>
					</form-->
					<div class="login dir col-" id="statusLogin">
						<!-- statusLogin.php -->
						<?php $this->load->view('statusLogin'); ?>
					</div>
				</div>					
			</header>
			<aside class="carroussel col-md-12 col-lg-12">
				  <span id="target-item-1"></span>
				  <span id="target-item-2"></span>
				  <span id="target-item-3"></span>
				  
				  <div class="carousel-item item-1 row">
				  	<div class="col-xs-1"></div>
				  	<img title="foto do municipio de charqueadas" alt="foto do municipio de charqueadas" src="<?php echo base_url('assets/img/charqueadas1.jpg'); ?>" class="col-xs-10" alt="imagem municipio de charqueadas">
				  	<div class="col-xs-1"></div>
				  </div>			  
					 
				 <div class="carousel-item item-2 light row">
				 	<div class="col-xs-1"></div>
				    <img title="foto do municipio de charqueadas" alt="foto do municipio de charqueadas" src="<?php echo base_url('assets/img/charqueadas2.jpg'); ?>" class="col-xs-10" alt="imagem municipio de charqueadas">
				    <div class="col-xs-1"></div>
				 </div>				 

				  <div class="carousel-item item-3 row">
				  	<div class="col-xs-1"></div>
				    <img title="foto aerea do campus IFsul no municipio de charqueadas" alt="foto aerea do campus IFsul no municipio de charqueadas" src="<?php echo base_url('assets/img/ifsulcharqueadas.jpg') ?>" class="col-xs-10" alt="imagem ifsul campus charqueadas">
				    <div class="col-xs-1"></div>
				  
				  </div>
				  <div style="position: absolute; bottom: 0; width: 100%; z-index: 5; text-align: center;">
				  	<input type="radio" name="carroussel" id="radio-item-1" onclick="radioUm();">
				  	<input type="radio" name="carroussel" id="radio-item-2" onclick="radioDois();">
				  	<input type="radio" name="carroussel" id="radio-item-3"><!-- addEventListener -->
				  </div>

				<div style="position: absolute; bottom: -70px; margin-left: -30px; width: 100%; z-index: 5; text-align: right;">
					<div ><!-- MENU CIRCULAR -->
						 <?php $this->load->view('menuCircular'); ?>
					</div> 		
				</div>
			</aside>
				
			<div class="corpo">	
				<div class="col-xs-12 col-md-3 col-lg-3"><!-- MENU -->
					<nav class="container-menu">
						<ul>
							<li class="cor-txt" style="text-align: right;"><strong>Ultimas Postagens...</strong></li>
							<?php 
								//$post = new Postagem(0);
								$this->post->menuUltimosPost(10); 
							?>						
							<!--li class="btn"><a href="#" class="cor-txt">link</a></li-->
						</ul>
					</nav>
				</div>
				<div class="col-xs-12 col-md-9 col-lg-9 row">				
					<div class="col- row" id="postagens"><!-- CONTEUDO -->
						<?php 
							if(isset($busca)){
								$this->post->buscar($busca['busca']);
							}else{
								if (isset($_GET['idPost'])) {
									//echo "idPost = ".$_GET['idPost'];
									$this->post->setId($_GET['idPost']);
									$this->post->loadPostUnico($this->db);
								}else{
									$this->post->indexPost(4);
								}
							}
						?>			
					</div>				
				</div>
				<aside class="col- row">
					<?php $this->post->fotosPe($this->db); ?>
					<!--img src="img/img.jpg" class="foto-pe col-xs-12 col-md-4 col-lg-4"-->				
				</aside>
			</div>
		
		<!-- php/footer.php -->
		<?php $this->load->view('footer'); ?>		
	</div>
	<div id="container-modal">
		<input type="checkbox" id="modal_">
		<div class="modal">
		  <div class="modal-content dir" style="overflow: hidden;">
		  	<img title="foto antigo bar charqueadas" alt="foto antigo bar charqueadas" src="<?php echo base_url('assets/img/charqueadabar_background_login.jpg') ?>" class="img-opacity" alt="foto detalhe bar charqueadas">		  	 
		    <h4>faça login...</h4>
		    <?php  
		    	echo form_open('logar', array('class' => 'dir'));
		    	echo form_label('login: ', 'log');
		    	echo form_input('log', '', array('class' => 'campo-input'))."<br />";
		    	echo form_label('senha: ', 'sen');
		    	echo form_password('sen', '', array('class' => 'campo-input'))."<br />";
		    	?>
		    	<i class="fa fa-facebook-square"></i>
				<i class="fa fa-google-plus-official"></i>
				<i class="fa fa-instagram"></i>
		    	<?php
		    	echo form_submit('btn-submit', 'Entrar...', array('class' => 'btn'));
		    	echo form_close();
		    ?><br>
		    <!-- FACEBOOK -->				
				<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
				</fb:login-button>	<div id="status"></div>
			<!--/ -->
		    <h4>ou cadastre-se...</h4>
		    <?php  
		    	echo form_open('cadastrar', array('class' => 'dir'));
		    	echo form_label('email: ', 'log2');
		    	echo form_input('log2', '', array('class' => 'campo-input'))."<br />";
		    	echo form_label('senha: ', 'sen2');
		    	echo form_input('sen2', '', array('class' => 'campo-input'))."<br />";
		    	echo form_label('repetir senha: ', 'sen3');
		    	echo form_input('sen3', '', array('class' => 'campo-input'))."<br />";
		    	echo form_submit('btn-submit', 'cadastrar', array('class' => 'btn'));
		    	echo form_close();
		    ?>
		  </div>
		  <label class="modal-close" for="modal_"></label>
		</div>
	</div>
	<div id="container-modal2">
		<input type="checkbox" id="modal_2">
		<div class="modal">
		  <div class="modal-content" style="width: 80%; height: 80%;">      
		    <!--h4>foto</h4-->
		    <img title="foto de alguma postagem" alt="foto de alguma postagem" src="" id="fotoModal" >
		  </div>
		  <label class="modal-close" for="modal_2"></label>
		</div>
	</div>
	<script src="<?php echo base_url('assets/js/ajax.js'); ?>"></script>
	<script>		
    	function tamanhos(){
    		let janelaWidth = window.innerWidth;
    		let janelaHeight = window.innerHeight;
    		document.getElementById('tamanhoTela').innerHTML = janelaWidth+" x "+janelaHeight;
    	}
    	tamanhos();
    	window.addEventListener('resize', function(){
	        tamanhos();
	    });

		

		function reloadIndex(){
			ajaxTagidUrl("postagens", "indexPostagens?total=4");
		}
		
		function refreshPost(){
			ajaxTagidUrl("postagens", "indexPostagens?total="+document.getElementById('totPost').value);
		}
		function politica(){
			ajaxTagidUrl("postagens", "politica");
		}
		function loadPost(id){
			ajaxTagidUrl("postagens", `<?php echo base_url('/?idPost=`+id+`'); ?>`);
		}

		function denunciarOf(id){
			if (confirm('Você deseja cancelar a denuncia feita a esta postagem??')) {
				window.location = 'php/denunciarPostOf.php?idPost='+id;
			}else{
				alert('Denuncia mantida...');
			}
		}
		document.getElementById('radio-item-3').addEventListener('click', function(){ radioTres(); });
		carroussel();
	</script>
	<noscript> Navegador ñ suporta javascript...</noscript>
</body>
</html>