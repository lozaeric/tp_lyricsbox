<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->load->model ('juego_model');
		$this->load->helper('ssl');
		force_ssl ();
	}
	
	public function index() // devuelve un juego nuevo random (se puede filtrar por artista, año y tag)
	{
	}
	
	public function guardar () { //permite subir un juego ya terminado 
		
	}
}
?>