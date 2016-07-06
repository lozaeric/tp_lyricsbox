<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'ControladorBase.php';

class Cancion extends Controlador_Base {
    /**
    * @ignore
    */
	public function __construct () {
		parent::__construct ();
		$this->load->model ('cancion_model');
		$this->load->helper('ssl');
		force_ssl ();
	}

    /**
    * Este metodo muestra en formato JSON las canciones guardadas en el sistema.
    * @param string $campo campo por el cual ordenar - OPCIONAL
    * @param string $orden ordenamiento (ASCendente|DESCendente) - OPCIONAL
    * @param string $filtrar campo por el cual filtrar - OPCIONAL
    * @param string $valor valor por el cual filtrar (dejar pasar) - OPCIONAL
    * @api
    * @return void
    */
	public function index() //muestra datos de todos las canciones
	{
        if( $this->estaAutorizado()  )
        {
            $data['datos'] = $this->cancion_model->get_canciones();
            if( empty($data['datos'])||$data['datos']==null )
                show_404();
            else
            {
                $this->chequearTAG($data);
            }

            $this->load->view('cancion/index', $data);
        }

	}
    
      /**
	  * Este metodo muestra en formato JSON los datos de una cancion en particular (anio, disco, artista, nombre)
      * @param int $id codigo de la cancion
	  * @api
	  * @return void
	  */
	
	public function ver($id) //muestra la cancion id
	{
        if( $this->estaAutorizado() )
        {
            $data['datos'] = $this->cancion_model->get_cancion($id);
            if( empty($data['datos'])||$data['datos']==null )
                show_404();

            $this->load->view('cancion/index', $data);
        }
        
	}
	
          /**
	  * Este metodo muestra en formato JSON los fragmentos de la cancion con codigo id
      *
      * @param int $id codigo de la cancion
        * @param string $campo campo por el cual ordenar
  	    * @param string $orden ordenamiento (ASCendente|DESCendente)
	  * @api
	  * @return void
	  */
    
	public function verFragmentos ($id)  //devuelve los fragmentos de la cancion id
    {
        if( $this->estaAutorizado() )
        {
            $data['datos'] = $this->cancion_model->get_fragmentos($id);
            if( empty($data['datos'])||$data['datos']==null )
                show_404();
            else
            {
                $this->chequearTAG($data);
            }

            $this->load->view('cancion/index', $data);
            //$this->load->view('cancion/index', $data);
        }

	}
    
    /**
    * @ignore
    */
    
    public function partir($contenido)
    {
        $fragmentos = array();
        $pedazos = explode('.', $contenido); // Lista de oraciones.
		$oraciones = count ($pedazos);
        $fragmentito = ""; // Acumulado de texto
        $acum = 0; // Palabras acumuladas
        
        for($x=0; $x<$oraciones; $x++)
        {
            $acum += count (explode(' ', $pedazos[$x]));
            $fragmentito = $fragmentito.$pedazos[$x].'.'; // Explode le saca el delimitador.
            
            if($acum >= 15) // Si paso 15 guardar el fragmento.
            {
                $acum = 0;
                $fragmentos[] = $fragmentito;
                $fragmentito = "";
            }
        }
		return  $fragmentos;
    }
        
    /**
    * Este metodo guarda una cancion y genera los fragmentos correspondientes. La cancion guardada será devulta en JSON.
    * @param string $nombre nombre de la cancion
    * @param int $anio anio de la cancion
    * @param string $disco disco al que pertenece
    * @param string $artista quien la interpreta
    * @param string $contenido letra de la cancion
    * @param string $tag tags de la cancion separador por '.'
    * @param int $idUsuario usuario que sube la cancion
    * @api
    * @return void
    */
	
	public function guardar ()  //guarda una nueva cancion subida por un usuario
    {
        if( $this->estaAutorizado() )
        {
            $nombre=$this->input->post('nombre'); 
            $anio=$this->input->post('anio');
            $disco=$this->input->post('disco');
            $artista=$this->input->post('artista');
            $contenido=$this->input->post('contenido');
            $tags=explode('.', $this->input->post('tag'));
            $usuario=$this->input->post('usuario');
            $fragmentos = $this->partir ($contenido);
            
            $data['datos'] = $this->cancion_model->guardar($nombre, $anio, $disco, $artista, $fragmentos, $tags, $usuario);
            if( empty($data['datos'])||$data['datos']==null )
                show_404();

            $this->load->view('cancion/index', $data);
        }
            
	}
}
?>