<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagina extends CI_Controller {

	function __construct(){
		parent:: __construct();
		$this->load->helper('url');
	}
	public function index(){		
		$this->load->helper('form');
		$this->load->library('form_validation');
		//minhas classes
		$this->load->model('ClasseUsuario', 'usu');
		$this->load->model('ClassePostagem', 'post');
		//formulario busca validação
		$this->form_validation->set_rules('busca', '--> BUSCA <--', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$txt['formError'] = validation_errors();
		}else{
			$txt['formError'] = NULL;
			$txt['busca'] = $this->input->post();
		}		
		// carregando pagina
		$txt['title'] = 'CharqueadasTEM - DIG';
		$this->load->view('index', $txt);
	}
	public function politica(){
		$this->load->view('politica');
	}
	public function info(){
		echo phpinfo();
	}
	public function like(){		
		$this->load->model('ClassePostagem', 'post');
		//$this->load->view('like');
		$this->post->setId($_GET['idPost']);
		echo $this->post->like('like');
	}
	public function deslike(){	
		//echo $this->uri->segment(1);
		$this->load->model('ClassePostagem', 'post');		
		//$this->load->view('deslike');
		$this->post->setId($_GET['idPost']);
		echo $this->post->like('deslike');
	}
	public function btnLike(){
		$this->load->model('ClassePostagem', 'post');
		$this->load->view('btnLike');
	}
	public function indexPostagens(){
		$this->load->model('ClasseUsuario', 'usu');
		$this->load->model('ClassePostagem', 'post');
		//echo "<br />".$_GET['total'];
		//$this->load->view('indexPostagens');
		if(isset($busca)){
		$this->post->buscar($this->db, $busca['busca']);
		}else{
			if (isset($_GET['idPost'])) {
				//echo "idPost = ".$_GET['idPost'];
				$this->post->setId($_GET['idPost']);
				$this->post->loadPostUnico($this->db);
			}else{
				$this->post->indexPost($_GET['total']);
			}
		}
	}
	public function denunciarPost(){
		$this->load->model('ClassePostagem', 'post');
		$this->post->setId($_GET['idPost']);
		echo $this->post->denunciarPost('denunciado');
	}
	public function logar(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		//minhas classes
		$this->load->model('ClasseUsuario', 'usu');
		$this->load->model('ClassePostagem', 'post');
		// formulario login validação
		$this->form_validation->set_rules('log', '--> LOGIN <--', 'trim|required|valid_email');
		$this->form_validation->set_rules('sen', '--> SENHA <--', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$txt['formError'] = validation_errors();
			echo $txt['formError'];
		}else{
			$txt['formError'] = NULL;
			$txt['dados_log'] = $this->input->post();
			$txt['title'] = 'logado com sucesso';
			$txt['titulo'] = $this->usu->logar($txt['dados_log']['log'], $txt['dados_log']['sen']);
			$txt['paragrafo'] = '<a href="painelControle">Entrar</a>';
			$this->load->view('msg', $txt);
		}
	}
	public function fbLogar(){
		$this->load->model('ClasseUsuario', 'usu');
		$this->usu->setId($_GET['id']);
		$this->usu->novoUsu($_GET['id'], $_GET['id'])."<br />";
		$this->usu->load($_GET['id']);
		echo "<h1>".$this->usu->getNome()."</h1>";
		redirect('painelControle');
	}
	public function cadastrar(){
		//echo "cadastrar<br />";
		$this->load->helper('form');
		$this->load->library('form_validation');
		//minhas classes
		$this->load->model('ClasseUsuario', 'usu');
		$this->load->model('ClassePostagem', 'post');
		// formulario login validação
		$this->form_validation->set_rules('log2', '--> LOGIN <--', 'trim|required|valid_email');
		$this->form_validation->set_rules('sen2', '--> SENHA <--', 'trim|required');
		$this->form_validation->set_rules('sen3', '--> REPETIR SENHA <--', 'trim|required|matches[sen2]');
		if ($this->form_validation->run() == FALSE) {
			$txt['title'] = 'formulario cadastro ERRO...';
			$txt['titulo'] = 'formulario cadastro ERRO...';
			$txt['paragrafo'] = validation_errors().'<br /><a href="painelControle">voltar...</a>';
			$this->load->view('msg', $txt);
		}else{
			$txt['dados_log'] = $this->input->post();
			$txt['title'] = $txt['dados_log']['log2'];
			$txt['titulo'] = '<br />'.$this->usu->novoUsu($txt['dados_log']['log2'], $txt['dados_log']['sen2']); //return......
			$txt['paragrafo'] = '<br /><a href="painelControle">voltar...</a>';
			$this->load->view('msg', $txt);
		}
	}
	public function formEdiartUsu(){
		$this->load->model('ClasseAdmin', 'admin');
		$this->admin->formEditarUsu();
	}
	public function editarUsuario(){
		echo "editar usuario";
		$this->load->helper('form');
		$this->load->library('form_validation');
		//minhas classes
		$this->load->model('ClasseUsuario', 'usu');
		$this->load->model('ClassePostagem', 'post');
		//formulario busca validação
		$this->form_validation->set_rules('nome', '--> NOME <--', 'trim');
		$this->form_validation->set_rules('apelido', '--> APELIDO <--', 'trim');
		$this->form_validation->set_rules('login', '--> LOGIN <--', 'trim|required');
		$this->form_validation->set_rules('senha', '--> SENHA <--', 'trim|required');
		$this->form_validation->set_rules('senha2', '--> REPETIR SENHA <--', 'trim|required|matches[senha]');
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		}else{
			$txt['formError'] = NULL;
			$formulario = $this->input->post();
			$query = $this->db->query("UPDATE usuario SET nome = '".$formulario['nome']."', apelido = '".$formulario['apelido']."', login = '".$formulario['login']."', senha = '".$formulario['senha']."' where id = ".$_COOKIE['id']);
			if ($query) {
				echo "usuario editado com sucesso";
			}else{
				echo "falha na edição do usuario...";
			}
		}
		echo "<br /><p class='voltar'><a href='painelControle'> voltar... </a></p>";
	}
	public function painelControle(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		//minhas classes
		$this->load->model('ClasseUsuario', 'usu');
		$this->load->model('ClassePostagem', 'post');
		$this->load->model('ClasseAdmin', 'admin');
		//formulario busca validação
		$this->form_validation->set_rules('titulo', '--> TITULO <--', 'trim');
		$this->form_validation->set_rules('texto', '--> TEXTO <--', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$txt['formError'] = validation_errors();
		}else{
			$txt['formError'] = NULL;
			$txt['dadosForm'] = $this->input->post();
			//$admin = new Admin($_COOKIE['id'], '');
			$this->admin->setId($_COOKIE['id']);
			$txt['postEditado'] = $this->admin->editPost($txt['dadosForm']['titulo'], $txt['dadosForm']['texto'])." ";
		}
		if (isset($_COOKIE['id'])) {
			$this->load->view('paineldecontrole', $txt);
		}else{
			redirect('Pagina');
		}		
	}
	public function formularioPost(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('ClasseAdmin', 'admin');
		$this->admin->setId($_COOKIE['id']); 
		$this->admin->formPost();
	}
	public function listaPost(){
		$this->load->model('ClassePostagem', 'post');
		$this->load->model('ClasseAdmin', 'admin');
		$this->load->model('ClasseUsuario', 'usu');
		$this->post->setId(0);
		$this->post->loadPostUsu($this->db);
	}
	public function editarPost(){
		// isso tá errado... ñ se deve imprimir nada na tela direto no controler
		echo "<h3>editar post...</h3>"; //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('ClasseAdmin', 'admin');
		$this->admin->setId($_COOKIE['id']); 
		$this->admin->formEditPost();
	}
	public function exeEditPost(){
		//echo "exe edit post....";
		$this->load->helper('form');
		$this->load->library('form_validation');
		//minhas classes
		$this->load->model('ClasseUsuario', 'usu');
		$this->load->model('ClassePostagem', 'post');
		$this->load->model('ClasseAdmin', 'admin');
		//validação formulario formEditPost classeAdmin
		$this->form_validation->set_rules('titulo', '--> TITULO <--', 'trim');
		$this->form_validation->set_rules('texto', '--> TEXTO <--', 'trim|required');

		$txt['title'] = 'MENSAGEM...';
		$txt['titulo'] = '';
		$txt['paragrafo'] = '<a href="painelControle">voltar...</a>';
		if ($this->form_validation->run() == FALSE) {
			//$txt['formError'] = validation_errors();
			$txt['titulo'] =  validation_errors();
		}else{
			//$txt['formError'] = NULL;
			$dados = $this->input->post();
			$query = $this->db->query("UPDATE  postagem  SET  titulo  =  '".htmlspecialchars($dados['titulo'])."' ,  texto  =  '".htmlspecialchars($dados['texto'])." '   WHERE  id  =  ".$_COOKIE['idPost']);
			if ($query) {
				$txt['titulo'] = 'Editado com sucesso...';
			}else{
				$txt['titulo'] = 'Falha na edição...';
			}
		}
		$this->load->view('msg', $txt);
	}
	public function excluirPost(){
		$this->load->model('ClassePostagem', 'post');
		$this->post->setId($_GET['idPost']);
		$txt['title'] = 'EXCLUIR post...';
		$txt['titulo'] = $this->post->excluirPost();
		$txt['paragrafo'] = '<a href="painelControle">voltar...</a>';
		$this->load->view('msg', $txt);
	}
	public function carregaDenuncias(){
		$this->load->model('ClassePostagem', 'post');
		$this->post->setId(0);
		echo $this->post->listDenunciasPorCond('denunciado');
	}
	public function postDenunciado(){
		$this->load->model('ClasseUsuario', 'usu');
		$this->load->model('ClassePostagem', 'post');
		$this->post->setId($_GET['idPost']);
		$this->post->loadPostUnico();
	}
	public function bloquearPost(){
		$this->load->model('ClassePostagem', 'post');
		$this->post->setId($_GET['idPost']);
		echo $this->post->AdminSetDenuncia('julgado-aval-no');
	}
	public function liberarPost(){
		$this->load->model('ClassePostagem', 'post');
		$this->post->setId($_GET['idPost']);
		echo $this->post->AdminSetDenuncia('julgado-aval-ok');
	}
	public function excluirFoto(){
		$this->load->model('ClassePostagem', 'post');
		echo $this->post->excluirFoto($_GET['idFoto']);
	}
	public function destroiCookieId(){
		setcookie('id', 0, time() -1, "/"); // destruir cookie...
		//header("location: ".base_url());
		redirect("pagina", 'refresh');
	}
	public function msg_404(){
		$this->load->view('404');
	}
}
