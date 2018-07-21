<meta charset="utf-8">
<?php  
	if (isset($_COOKIE['id']) && $_COOKIE['id'] != 0) {
		$this->usu->load($_COOKIE['id']);
		?>
		<a href="painelControle"><i class="fa fa-address-card-o">&nbsp;&nbsp;<?= $this->usu->getNome(); ?></i></a><!--small><a href="php/destroiCookieId.php">sair...</a></small-->&nbsp;&nbsp;<small style="font-size: 12px; color: red;"> logado</small>
		<?php
	}else{
		?>
		<label for="modal_" onclick="tempoInfinitoCarrossel();">
			<div id="gr-social">
				<i class="fa fa-user-circle-o"></i>
				<i class="fa fa-facebook-square"></i>
				<i class="fa fa-google-plus-official"></i>
				<i class="fa fa-instagram"></i>
			</div>
		</label>
		<?php
	}	
?>