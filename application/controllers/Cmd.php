<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cmd extends CI_Controller {

	function __construct(){
		parent:: __construct();
		$this->load->helper('url');
	}
	public function index(){
		$txt['title'] = 'cmd - index...';
		$txt['titulo'] = 'classe cmd';
		$txt['paragrafo'] = 'cmd index...';
		$this->load->view('msg', $txt);
	}
	public function teste(){
		echo "<a href='".base_url("assets/includes/trabalho.txt")."'>".base_url("assets/includes/trabalho.txt")."</a><br />";

		$f = fopen(base_url("assets/includes/trabalho.txt"), "r");
		var_dump($f);
		echo "<pre>";
		while (!feof($f)) { 
		     //$arrM = explode(";",fgets($f)); 
			echo "<br>".fgets($f);
		}
		echo "</pre>";
		fclose($f);

	}
	public function exModel(){
		$this->load->model('Ex_model', 'ex');
		$this->ex->exemplo();
	}
	public function numero(){
		// redirect('end/url', 'refresh');
		echo "numero ok...";
		echo "<br />numero: ". $this->uri->segment(2);
		if ($this->uri->segment(3)) {
			echo "<br />existe mais um numero ". $this->uri->segment(3);
		}else{
			echo "<br />sem segment 3";
		}
	}
	//utilizados no site as vera
	public function url(){
		echo $_SERVER['SERVER_NAME']." => ".$_SERVER['PHP_SELF'];
	}
	public function thanos(){
		$this->load->view('404.php');
	}
	public function ovini(){
		$this->load->view('404_ovini.php');
	}
	public function fotosSemPost(){
		$txt['paragrafo'] = '';
		//deletar postagens sem titulo & texto...
		$query = $this->db->query("SELECT id FROM postagem WHERE titulo IS NULL and texto is null;");
		$txt['titulo'] = $query->num_rows()." ";
		if ($query) {
			foreach ($query->result() as $postagem) {
				$txt['paragrafo'] .= '<br />post id: '.$postagem->id."<br />";
				$queryFt = $this->db->query("SELECT id, img FROM imagens WHERE idpost = '".$postagem->id."';");
				if ($queryFt and $queryFt->num_rows()) {					
					foreach ($queryFt->result() as $ft) {
						$txt['paragrafo'] .=  '<img style="max-width: 50px;" src = '.base_url("assets/fotos/postagens/".$ft->img).'> <br />
						<b>url :</b>'.base_url("assets/fotos/postagens/".$ft->img)."<hr>";
					}
				}else{
					$queryDel = $this->db->query("DELETE FROM postagem WHERE id = ".$postagem->id);
					if($queryDel){
						$txt['paragrafo'] .= 'Deletada postagem id: '.$postagem->id;
					}else{
						$txt['paragrafo'] .= 'devia ter deletado essa bagaça....';
					}

				}					
			}
		}else{
			var_dump($query);
		}

		$txt['title'] = 'fotos sem postagem...';
		$txt['titulo'] .= 'fotos sem postagem... <small style="font-size: 50%;"> adicionar botão deletar foto e allfotos</small>';
				
		$this->load->view('msg', $txt);

	}
	public function trabalho(){
		echo "<a href='".base_url("assets/includes/trabalho_lpw.pdf")."'>".base_url("assets/includes/trabalho.txt")."</a><br />";
		redirect(base_url("assets/includes/trabalho_lpw.pdf"),'refresh');
	}
	public function listarUsuarios(){
		$query = $this->db->get('usuario');
		if ($query->num_rows() > 0) {
			echo "lista de usuarios:<br /><table><thead><tr><td> id </td><td> login </td><td> apelido </td><td> nivel </td></tr></thead>";
			foreach ($query->result() as $usu) {
				$this->db->where('idusu', $usu->id);
				$busca = $this->db->get('usunivel', 1);
				foreach ($busca->result() as $resultBusca) {
					echo "<tr><td>".$usu->id."</td><td>".$usu->login."</td><td>".$usu->apelido."</td><td>".$resultBusca->nivel."</td></tr>";
				}
				//echo "<tr><td>".$usu->id."</td><td>".$usu->login."</td><td>".$usu->apelido."</td><td>".$resultBusca->nivel."</td></tr>";
			}
			echo "</table>";
		}else{
			echo "ninguem...";
		}
	}
}
