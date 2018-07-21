<nav id="circle">
	<input type="checkbox" id="check"> 	
	<label id="central"  for="check">
		<img title="icone de escolha opções configuraçoes da pagina" alt="icone de escolha opções configuraçoes da pagina" src="<?php echo base_url('assets/img/escolha.png'); ?>">
	</label>
	<a onclick="politica();">
		<img title="??" alt="??" class="link" id="link01" src="<?php echo base_url('assets/img/duvida.gif'); ?>">
	</a>
	<!--a href="#"><img class="link" id="link02" src="img/02.png"></a-->	
	<a onclick="refreshPost();"><!-- engrenagem exibir postagens!!! -->
		<img title="icone engrenagem" alt="icone engrenagem" class="link" id="link03" src="<?php echo base_url('assets/img/engrenagem.png'); ?>">
		<input class="link" type="number" name="totPostagens" id="totPost" style="max-width: 30px; max-height: 30px; border: none; background-color: #4f8a83;" value="4">
	</a>
	<!--a href="#"><img class="link"/ id="link04" src="img/04.png"></a-->			 	
</nav>