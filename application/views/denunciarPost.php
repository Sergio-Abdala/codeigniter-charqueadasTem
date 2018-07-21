<?php  
$this->post->setId($_GET['idPost']);
		echo "<script type='text/javascript'>
				alert(`".$this->post->denuciarPost($this->db, 'denunciado')."`);
				window.location = './';
			  </script>";
?>