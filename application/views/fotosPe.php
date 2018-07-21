<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" >
	<div class="painel"> 
		<?php if(isset($idPost)): ?>
			<a href="<?php echo base_url('/?idPost='.$idPost[$val]); ?>">
				<img title="imagem de alguma das postagens" alt="imagem de alguma das postagens" src="<?php echo base_url('assets/fotos/postagens/'.$img[$val]) ?>" alt="imagem de alguma postagem">
			</a> 
		<?php else: ?>
			<p>sem imagem</p>
		<?php endif; ?>
	</div>
</div>