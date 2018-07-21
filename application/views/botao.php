<!--a href="<?php echo base_url('/?idPost='.$post->id); ?>"-->
 <li onclick="loadPost(`<?php echo $post->id; ?>`);" class="btn cor-txt menu-txt" style="overflow: hidden;">
 	<?= $post->titulo; ?>
 </li> 
<!--/a-->