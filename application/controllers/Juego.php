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
    * @ignore
    */
    private function validador()
    {
        $username = null;
        $password = null;

        // mod_php
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

        // most other servers
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {

            if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']),'basic')===0)
            list($username,$password) = explode(':',base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

        }

        if( ($username == null and $password == null) or ($username != "juan" or $password != "123") )
        {
            header('HTTP/1.0 401 Unauthorized');
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="Lyrics BOX"');

            return false;
        }


        return true;
    }


	  /**
	  * Este metodo muestra en formato JSON los datos (fragmento, cancion, artista, anio, disco) de un nuevo juego creado.
	  *
	  * Un ejemplo de uso es : .../juegos/  . Utiliza el verbo HTTP POST. Por lo menos, un parametro de los siguientes debe enviarse.
	  *
	  * @param string $tag tag de la cancion
	  * @param int $anio anio de la cancion
	  * @param string $artista artista de la cancion
	  *
	  * @api
	  * @return void
	  */
	public function index() // devuelve un juego nuevo random (se puede filtrar por artista, año y tag)
	{
		if( $this->validador()  )
        {
			$tag=$this->input->post('tag');
			$anio=$this->input->post('anio');
			$artista=$this->input->post('artista');
			
			//if ($tag==null && $anio==null && $artista==null)
				//show_404();
			$data['datos'] = $this->juego_model->get_juego($tag, $anio, $artista);
			if( empty($data['datos'])||$data['datos']==null )
				show_404();
		}
		else
			$data['datos'] = "rechazado";
		
        $this->load->view('juego/index', $data);
	}
		  /**
	  * Este metodo guarda un juego y despues muestra en formato JSON sus datos (idUsuario, idFragmento, tiempo, dificultad, puntaje, tiempoJuego).
	  *
	  * Un ejemplo de uso es : .../juegos/guardar  . Utiliza el verbo HTTP POST. Todos los parametros son obligatorios
	  *
	  * @param int $idUsuario id del usuario
	  * @param int $idFragmento id del fragmento
	  * @param int $tiempoJuego tiempo en segundos del juego
	  * @param string $dificultad dificultad del juego (medio o dificil)
	  *
	  * @api
	  * @return void
	  */
	public function guardar () { //permite subir un juego ya terminado 
		if( $this->validador()  )
        {
			$idUsuario=$this->input->post('idUsuario');
			$idFragmento=$this->input->post('idFragmento');
			$tiempoJuego=$this->input->post('tiempoJuego');
			$dificultad=$this->input->post('dificultad');
			if ($idUsuario==null || $idFragmento==null || $tiempoJuego==null || $dificultad==null)
				show_404();
			$puntaje = $this->calcularPuntaje ($dificultad, $tiempoJuego); //falta incluir la cantidad de respuestas parciales 
			
			$data['datos'] = $this->juego_model->guardar($idUsuario, $idFragmento, $tiempoJuego, $dificultad, $puntaje);
			if( empty($data['datos'])||$data['datos']==null )
				show_404();
		}
		else
			$data['datos'] = "rechazado";
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