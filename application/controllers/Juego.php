<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->load->model ('juego_model');
		$this->load->helper('ssl');
		force_ssl ();
	}
	
	public function index() // trae un juego nuevo
	{
	}
	
	public function subir ($id) { //permite subir el juego id?
		
	}
}
?>