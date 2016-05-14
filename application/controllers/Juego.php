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
		$tag=$this->input->post('tag');
		$anio=$this->input->post('anio');
		$artista=$this->input->post('artista');
		
		if ($tag==null && $anio==null && $artista==null)
			show_404();
		$data['datos'] = $this->juego_model->get_juego($tag, $anio, $artista);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('juego/index', $data);
	}
	
	public function guardar () { //permite subir un juego ya terminado 
		$idUsuario=$this->input->post('idUsuario');
		$idFragmento=$this->input->post('idFragmento');
		$tiempoJuego=$this->input->post('tiempoJuego');
		$dificultad=$this->input->post('dificultad');
		//$puntaje=$this->input->post('puntaje');    --->>>   hay que calcularlo del lado del servidor
		
		if ($idUsuario==null || $idFragmento==null || $tiempoJuego==null || $dificultad==null)
			show_404();
		$data['datos'] = $this->juego_model->guardar($idUsuario, $idFragmento, $tiempoJuego, $dificultad);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('juego/index', $data);
	}
}
?>