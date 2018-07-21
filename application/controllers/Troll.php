<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class troll extends CI_Controller {

	function __construct(){
		parent:: __construct();
		$this->load->helper('url');
	}
	public function index(){
		$txt['title'] = 'TROLL!!!';
		$txt['titulo'] = 'classe TROLL';
		$txt['paragrafo'] = 'pra trolar quem acreditar estar em um framework qualquer...';
		$this->load->view('msg', $txt);
	}
	public function admin(){
		$txt['title'] = 'ISSO Ñ É WORDPRESS';
		$txt['tituloSite'] = 'kkk, si ferrou...';
		$this->load->view('trollAdmin', $txt);
	}
}
