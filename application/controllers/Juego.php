<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->load->model ('juego_model');
		$this->load->helper('ssl');
		$this->load->helper('input');
		force_ssl ();
	}
	
	public function index() // devuelve un juego nuevo random (se puede filtrar por artista, año y tag)
	{
		var $tag=$this->input->post('tag'), $anio=$this->input->post('anio'), $artista=$this->input->post('artista');
		
		if ($tag==null && $anio==null && $artista==null)
			show_404();
		$data['datos'] = $this->juego_model->get_juego($tag, $anio, $artista);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('juego/index', $data);
	}
	
	public function guardar () { //permite subir un juego ya terminado 
		var $idUsuario=$this->input->post('idUsuario'), $idFragmento=$this->input->post('idFragmento'), $tiempo=$this->input->post('tiempo'), $dificultad=$this->input->post('dificultad'), $puntaje=$this->input->post('puntaje');
		
		if ($idUsuario==null || $idFragmento==null || $tiempo==null || $dificultad==null || $puntaje==null)
			show_404();
		$data['datos'] = $this->juego_model->guardar($idUsuario, $idFragmento, $tiempo, $dificultad, $puntaje);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('juego/index', $data);
	}
}
?>