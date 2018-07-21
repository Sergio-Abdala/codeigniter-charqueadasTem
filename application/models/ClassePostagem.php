<?php 

/**
 * classe para carregar postagens do banco de dados...
 */
class classePostagem extends CI_Model
{
	protected $id=0;
	protected $likes;
	protected $deslikes;
	function __construct()
	{
		parent::__construct();
	}
	// get's  set's
		function getId(){
			return $this->id;
		}
		function getLikes(){
			return $this->likes;
		}
		function getDeslikes(){
			return $this->deslikes;
		}
		function setId($id){
			$this->id = $id;
		}
		function setLikes($lk){
			$this->likes = $lk;
		}
		function setDeslikes($lk){
			$this->deslikes = $lk;
		}
	function loadPost(){ // conforme $this->id
		$obj['id'] = $this->id;
		$obj['lik'] = $this->likes;
		$obj['deslik'] = $this->deslikes;
		$this->load->view('loadPost', $obj);
	}
	function loadPostUnico(){ // conforme $this->id
		$obj['id'] = $this->id;
		$this->load->view('loadPostUnico', $obj);
	}
	function AdminSetDenuncia($cond){ // denunciado, absolvido, julgado-aval-ok,  julgado-aval-no, 
		if (isset($_COOKIE['id'])) {
			$resp = $this->db->query("SELECT * FROM denuncias WHERE idpost = '".$this->id."';")or die('falha na consulta denuncias');
			if ($resp) {
				$vorta='';
				foreach ($resp->result() as $den) {
					$mudis = $this->db->query("UPDATE denuncias SET cond = '".$cond."' WHERE id = '".$den->id."';");
					if ($mudis) {
						$vorta = 'condição da postagem alterada com sucesso para '.$cond;
						
					}else{
						return 'falha no registro, tente novamente...';
					}
				}				
			}else{
				$denunciado = $this->db->query("INSERT INTO denuncias(idpost, idusu, cond, data) VALUES('".$this->id."', '".$_COOKIE['id']."', '".$cond."', now());");
				if ($denunciado) {
					return 'condição da postagem alterada com sucesso para '.$cond;
				}else{
					return 'falha no registro, tente novamente... ';
				}
			}
			return $vorta;
		}else{
			return 'Você precisa estar logado para acessar este recurso..!';
		}
	}
	function loadPostAdmin(){ // conforme $this->id
		$obj['id'] = $this->id;
		$obj['botoesEditarExcluir'] = '
					<div class="col- row">
						<button onclick="editarPost(`'.$this->getId().'`);" class="btn menu col- col-xs-12 col-md-6 col-lg-3 col-xl-2" style="max-height: 40px;">Editar</button>
						&nbsp;&nbsp;&nbsp;
						<button onclick="excluirPost(`'.$this->getId().'`);" class="btn menu col- col-xs-12 col-md-6 col-lg-3 col-xl-2" style="max-height: 40px;">Excluir</button>
					</div>';
		$this->load->view('loadPostAdmin', $obj);
	}
	function loadPostUsu(){ //pega id das postagens do usuario
		$query = $this->db->query("SELECT id FROM postagem WHERE idusu = '".$_COOKIE['id']."' && (titulo != 'NULL' || texto != 'NULL') ORDER BY id DESC;");
		if ($query) {
			foreach ($query->result() as $con) {
				$this->setId($con->id);	
				$this->loadPostAdmin();				
			}
		}
	}
	function contLike(){
		//LIKE
		$contaLike = $this->db->query("SELECT   idpost, COUNT(idpost) AS Qtd FROM  likes WHERE cond = 'like' && idpost = '".$this->id."' GROUP BY idpost HAVING   COUNT(idpost) > 0 ORDER BY COUNT(idpost) DESC")or die(mysqli_error($this->db));
		if ($contaLike && $contaLike->num_rows > 0) {
			while ($like = $contaLike->fetch_object()) {
				//echo '<br />id post: '.$like->idpost."  Qtd likes: ".$like->Qtd;
				$this->likes = $like->Qtd;
			}
		}else{
			//echo "<br />id post: ".$this->id." 0 likes...";
			$this->likes = 0;
		}
		//DESLIKE
		$contaDeslike = $this->db->query("SELECT   idpost, COUNT(idpost) AS Qtd FROM  likes WHERE cond = 'deslike' && idpost = '".$this->id."' GROUP BY idpost HAVING   COUNT(idpost) > 0 ORDER BY COUNT(idpost) DESC")or die('erro database... ao ClassePostagem/contLike');
		if ($contaDeslike && $contaDeslike->num_rows > 0) {
			while ($deslike = $contaDeslike->fetch_object()) {
				//echo '<br />id post: '.$deslike->idpost."  Qtd deslikes: ".$deslike->Qtd;
				$this->deslike = $deslike->Qtd;
			}
		}else{
			//echo "<br />id post: ".$this->id." 0 deslikes...";
			$this->deslikes = 0;
		}
	}
	function avaliaIdPost($idpost){
		$query = $this->db->query("SELECT   idpost, COUNT(idpost) AS Qtd FROM  denuncias WHERE cond = 'julgado-aval-no' && idpost = '".$idpost."' GROUP BY idpost HAVING   COUNT(idpost) > 0 ;");
		if ($query->num_rows() > 0) {
			return 0;
		}else{
			return $idpost;
		}
	}
	function indexPost($total){
		$totalExcesso20 = $total + 20;
		$conta = $this->db->query("SELECT   idpost, COUNT(idpost) AS Qtd FROM  likes WHERE cond = 'like' GROUP BY idpost HAVING   COUNT(idpost) > 0 ORDER BY COUNT(idpost) DESC LIMIT ".$totalExcesso20)or die(mysqli_error($this->db));
		if ($conta) {
			$cont=0;
			foreach ($conta->result() as $like) {
				//echo '<br />id post: '.$like->idpost."  Qtd likes: ".$like->Qtd;
				$this->setLikes($like->Qtd);
				if ($cont < $total) {// gambiarra folga na busca para poder suprimir os post julgado-aval-no
					if ($this->avaliaIdPost($like->idpost)) {
						$this->setId($this->avaliaIdPost($like->idpost));
						//DESLIKE
						$contades = $this->db->query("SELECT   idpost, COUNT(idpost) AS Qtd FROM  likes WHERE cond = 'deslike' && idpost = '".$this->id."' GROUP BY idpost HAVING   COUNT(idpost) > 0 ORDER BY COUNT(idpost) DESC LIMIT ".$total)or die('erro na contagem deslike...');
						if ($contades) {
							foreach ($contades->result() as $deslike) {
								//echo '<br />id post: '.$like->idpost."  Qtd likes: ".$like->Qtd;
								if (is_null($deslike->Qtd)) {
									$this->setDeslikes(0);
								}else{
									$this->setDeslikes($deslike->Qtd);
								}
							}
						}else{
							$this->setDeslikes(0);
						}
						$this->loadPost();
						$cont++;
					}
				}
			}
		}else{
			echo "falha na conexão sql...";
		}
	}
	function like($cond){
		if (isset($_COOKIE['id'])) {
			//$resp = $conex->query("SELECT * FROM likes WHERE idpost = '".$this->id."' && idusu = '".$_COOKIE['id']."';");

			$resp = $this->db->query("SELECT * FROM likes WHERE idpost = '".$this->id."' && idusu = '".$_COOKIE['id']."';");

			if ($resp->num_rows() > 0) {
				$lik = $resp->row();
				$mudis = $this->db->query("UPDATE likes SET cond = '".$cond."' WHERE id = '".$lik->id."';");
				if ($mudis) {
					return 'Preferencia alterada...';
				}else{
					return 'falha na alteração, tente novamente...';
				}
			}else{
				$liked = $this->db->query("INSERT INTO likes(idpost, idusu, cond, data) VALUES('".$this->id."', '".$_COOKIE['id']."', '".$cond."', now());");
				if ($liked) {
					return 'preferencia registrada...';
				}else{
					return 'falha no registro, tente novamente... '.mysqli_error($this->db);
				}
			}
		}else{
			return 'Você precisa estar logado para acessar este recurso..!';
		}
	}
	function refreshLike(){
		//LIKE
		$conta = $this->db->query("SELECT   idpost, COUNT(idpost) AS Qtd FROM  likes WHERE cond = 'like' && idpost = '".$this->id."' GROUP BY idpost HAVING   COUNT(idpost) > 0 ORDER BY COUNT(idpost) DESC")or die(mysqli_error($this->db));
		if ($conta->num_rows() > 0) {
			foreach ($conta->result() as $like) {
				//echo '<br />id post: '.$like->idpost."  Qtd likes: ".$like->Qtd;
				$this->likes = $like->Qtd;
			}
		}else{
			$this->likes = 0;
		}
		//DESLIKE
		$contades = $this->db->query("SELECT   idpost, COUNT(idpost) AS Qtd FROM  likes WHERE cond = 'deslike' && idpost = '".$this->id."' GROUP BY idpost HAVING   COUNT(idpost) > 0 ORDER BY COUNT(idpost) DESC")or die(mysqli_error($this->db));
		if ($contades && $contades->num_rows() > 0) {
			foreach ($contades->result() as $deslike) {
				//echo '<br />id post: '.$like->idpost."  Qtd likes: ".$like->Qtd;
				$this->deslikes = $deslike->Qtd;
			}
		}else{
			$this->deslikes = 0;
		}
	}
	function excluirFoto($idFoto){
		$query = $this->db->query("DELETE FROM imagens WHERE id = '".$idFoto."';");
		if ($query) {
			return "foto excluida..!";
		}else{
			return "falha na exclusão da foto...";
		}
	}
	function excluirPost(){
		$likes = $this->db->query("DELETE FROM likes WHERE idPost = '".$this->id."';");
		if ($likes) {
			$img = $this->db->query("DELETE FROM imagens WHERE idPost = '".$this->id."';");
			if ($img) {
				$post = $this->db->query("DELETE FROM postagem WHERE id = '".$this->id."';");
				if ($post) {
					return 'Postagem excluida com sucesso..!';
				}else{
					return 'erro na exclusão da postagem';
				}
			}else{
				return 'erro na exclusão de imagens..!';
			}
		}else{
			return 'erro na exclusão da tabela likes';
		}
	}
	function menuUltimosPost($qtd){
		$qtd2 = $qtd;
		$qtd2 += 20; //folga na busca para suprimir post julgado-aval-no
		$query = $this->db->query("SELECT * FROM postagem WHERE titulo != 'NULL' ORDER BY id DESC LIMIT ".$qtd2.";");
		if ($query->num_rows() > 0) {
			$cont=0;
			foreach ($query->result() as $post) {
				if($cont < $qtd){
					if ($this->avaliaIdPost($post->id)) {
						$cont++;
						$txt['post'] = $post;
						$this->load->view('botao', $txt);
					}
				}					
			}
		}else{
			echo '<li class="btn cor-txt menu-txt" style="overflow: hidden;">
 					SEM POSTAGEM...
 				 </li>';
		}
	}
	function fotosPe(){
		$query = $this->db->query("SELECT * FROM imagens ORDER BY id DESC LIMIT 30;");
		$img = array();
		$idPost = array();
		if($query && $query->num_rows() > 0){
			foreach ($query->result() as $foto) {				
				if ($this->avaliaIdPost($foto->idpost)) {
					$idPost[] = $foto->idpost;
					$img[] = $foto->img;
				}				
			}
			$txt['img'] = $img;
			$txt['idPost'] = $idPost;
			
			$total = count($img);
			for ($i=0; $i < 4; $i++) { 
				$ort[$i] = rand(0, $total-1);
			}
			foreach ($ort as $k => $val) {
				$txt['val'] = $val;
				$this->load->view('fotosPe', $txt);
			}
		}else{
			echo "sem fotos...";
		}
	}
	function buscar($parametro){
		$query = $this->db->query("SELECT id, titulo, texto, data FROM postagem WHERE titulo LIKE '%".$parametro."%' OR texto LIKE '%".$parametro."%';");
		if ($query) {
			echo "<ul>";
			foreach ($query->result() as $resp) {
				//$resp->id;
				$txt['resp'] = $resp;
				if ($this->avaliaIdPost($resp->id)) {
					$this->load->view('resultadoBusca', $txt);
				}else{
					//link para admin ver post bloqueado fica oculto para uso ???
					echo "<li><p> Bloqueado pelo moderador...</p></li>";
				}	
			}
			echo "</ul>";
		}else{
			//busca vazia...
			echo "<p>Nenhuma postagem corresponde a sua pesquisa...</p>";
		}
	}
	function denunciarPost($cond){ // denunciado, absolvido, julgado-aval-ok,  julgado-aval-no, 
		if (isset($_COOKIE['id'])) {
			$resp = $this->db->query("SELECT * FROM denuncias WHERE idpost = '".$this->id."' && idusu = '".$_COOKIE['id']."';");
			if ($resp) {
				$den = $resp->fetch_object();
				if ($den->cond == 'julgado-aval-no' || $den->cond == 'julgado-aval-ok') {
					return 'Postagem já avaliada por um de nossos moderadores...';
				}else{
					$mudis = $this->db->query("UPDATE denuncias SET cond = '".$cond."' WHERE id = '".$den->id."';");
					if ($mudis) {
						if ($cond == 'absolvido') {
							return 'Postagem foi absolvida, denuncia cancelada...';
						}else{
							return 'Você JÁ denunciou esta postagem para que seja avaliada por um de nossos moderadores...';
						}
						
					}else{
						return 'falha no registro, tente novamente...';
					}
				}
			}else{
				$denunciado = $this->db->query("INSERT INTO denuncias(idpost, idusu, cond, data) VALUES('".$this->id."', '".$_COOKIE['id']."', '".$cond."', now());");
				if ($denunciado) {
					return 'Você denunciou esta postagem para que seja avaliada por um de nossos moderadores......';
				}else{
					return 'falha no registro, tente novamente... ';
				}
			}
		}else{
			return 'Você precisa estar logado para acessar este recurso..!';
		}
	}
	function existeDenunciaUsu(){
		if (isset($_COOKIE['id'])) {
			$resp = $this->db->query("SELECT * FROM denuncias WHERE idpost = '".$this->id."' && idusu = '".$_COOKIE['id']."';")or die('erro na consulta sql...');
			if ($resp) {
				foreach($resp->result() as $den){
					return $den->cond;
				}				
			}
		}else{
			return 'sem registro';
		}
	}
	function contDenunciasPorCond($cond){
		$queryContCond = $this->db->query("SELECT idpost, COUNT(idpost) AS Qtd FROM  denuncias WHERE cond = '".$cond."' GROUP BY idpost HAVING   COUNT(idpost) > 0 ORDER BY COUNT(idpost) DESC");
		if ($queryContCond) {
			$vorta=array();
			foreach ($queryContCond->result() as $reg) {
				$vorta[] = $reg->idpost;
			}
			return "<small class='alerta'> ".count($vorta)." </small>";
		}else{
			return "<small class='verde'> 0 </small>";
		}
	}
	function listDenunciasPorCond($cond){
		$queryContCond = $this->db->query("SELECT idpost, COUNT(idpost) AS Qtd FROM  denuncias WHERE cond = '".$cond."' GROUP BY idpost HAVING   COUNT(idpost) > 0 ORDER BY COUNT(idpost) DESC");
		if ($queryContCond) {
			$vorta=array();
			foreach ($queryContCond->result() as $reg) {
				//echo "<br />".$reg->idpost." ".$reg->Qtd;
				$query = $this->db->query("SELECT id, titulo, texto, data FROM postagem WHERE id = '".$reg->idpost."';");
				if ($query) {
					foreach ($query->result() as $resp) {
						$resp->id;
						$txt['resp'] = $resp;
						$this->load->view('listaDenuncias', $txt);
					}
				}else{
					//busca vazia...
					echo "<p>Nenhuma postagem corresponde a sua pesquisa...</p>";
				}
			}
			//return "<small class='alerta'> ".count($vorta)." </small>";
		}else{
			//return "<small class='verde'> 0 </small>";
		}
	}
} ?>