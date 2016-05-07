<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artista extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->load->model ('artista_model');
		$this->load->helper('ssl');
		force_ssl ();
	}
	
	public function index() //muestra la lista de todos los artistas y sus canciones
	{
	}
	
	public function ver ($id) { //permite ver la lista de cancione de un artista
		
	}
}
?>