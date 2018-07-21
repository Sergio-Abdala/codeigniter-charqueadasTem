<li>
	<a href='<?php echo base_url('/?idPost='.$resp->id); ?>'>
		<p>
			<b class="resul-busca-tit"><?php echo $resp->titulo; ?></b><br />
			&nbsp;&nbsp;&nbsp;<small><?php echo substr($resp->texto, 0, 200); ?>...</small>
		</p>
	</a>
</li>