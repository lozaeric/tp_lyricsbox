<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->load->model ('usuario_model');
		$this->load->helper('ssl');
		force_ssl ();
	}
	
	public function index() //muestra datos de todos los usuarios
	{
	}
	
	public function ver($id) //muestra perfil + ultimas 5 canciones subidas
	{
	}
	
	public function verCanciones($id) //todas las canciones subidas de un usuario
	{
	}	
	
	public function mejoresPuntajes ()  //devuelve datos de 5 o 10 usuarios con mayor puntaje
	{
	}
}
