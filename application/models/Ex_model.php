<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ex_model extends CI_Model {

	function __construct(){
		parent:: __construct();
		$this->load->helper('url');
	}
	
	public function exemplo(){
		$txt['title'] = 'EXEMPLO MODEL';
		$txt['titulo'] = 'EXEMPLO MODEL';
		$txt['paragrafo'] = 'executado metodo exemplo do model Ex_model...';
		$this->load->view('msg', $txt);
	}
}
