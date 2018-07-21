<ul><!--a href='#idPost=<?= $resp->id; ?>'-->
	<li onclick="carregarPostAdmin('<?= $resp->id; ?>');" class="listaDenuncias">
		<p class="resul-busca-tit" style="margin-bottom: -15px;"><?php echo $resp->titulo; ?></p>
		<p class="resul-busca-cor"><?php echo substr($resp->texto, 0, 200); ?></p>
	</li><!--/a-->
</ul>