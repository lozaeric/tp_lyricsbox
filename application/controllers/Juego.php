<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  /**
  * Esta clase representa los Juegos
  */
class Juego extends CI_Controller {
	/**
    * @ignore
    */
	public function __construct () {
		parent::__construct ();
		$this->load->model ('juego_model');
		$this->load->helper('ssl');
		force_ssl ();
	}
	  /**
	  * Este metodo muestra en formato JSON los datos (fragmento, cancion, artista, anio, disco) de un nuevo juego creado.
	  *
	  * Un ejemplo de uso es : .../juegos/  . Utiliza el verbo HTTP POST. Por lo menos, un parametro de los siguientes debe enviarse.
	  *
	  * @param string $tag tag de la cancion
	  * @param string $anio anio de la cancion
	  * @param string $artista artista de la cancion
	  *
	  * @api
	  * @return void
	  */
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
		  /**
	  * Este metodo guarda un juego y despues muestra en formato JSON sus datos (idUsuario, idFragmento, tiempo, dificultad, puntaje, tiempoJuego).
	  *
	  * Un ejemplo de uso es : .../juegos/guardar  . Utiliza el verbo HTTP POST. Todos los parametros son obligatorios
	  *
	  * @param string $idUsuario id del usuario
	  * @param string $idFragmento id del fragmento
	  * @param string $tiempoJuego tiempo en segundos del juego
	  * @param string $dificultad dificultad del juego (medio o dificil)
	  *
	  * @api
	  * @return void
	  */
	public function guardar () { //permite subir un juego ya terminado 
		$idUsuario=$this->input->post('idUsuario');
		$idFragmento=$this->input->post('idFragmento');
		$tiempoJuego=$this->input->post('tiempoJuego');
		$dificultad=$this->input->post('dificultad');
		if ($idUsuario==null || $idFragmento==null || $tiempoJuego==null || $dificultad==null)
			show_404();
		$puntaje = calculoPuntaje ($dificultad, $tiempoJuego); //falta incluir la cantidad de respuestas parciales 
		
		$data['datos'] = $this->juego_model->guardar($idUsuario, $idFragmento, $tiempoJuego, $dificultad, $puntaje);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('juego/index', $data);
	}
	/**
    * @ignore
    */	
	public function calcularPuntaje ($dificultad, $tiempoJuego) {	
		$modificador = 1;
		if ($dificultad=='dificil')
			$modificador = 2;
		else if ($dificultad=='medio')
			$modificador = 1;
		if ($tiempoJuego>=300)
			return 0;
		else 
			return (15+(300-$tiempoJuego))*$modificador; 
	}
}
?>