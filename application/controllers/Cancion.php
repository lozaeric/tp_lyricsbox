<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cancion extends CI_Controller {
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
	  * @api
	  * @return void
	  */
    
	public function index() //muestra datos de todos las canciones
	{
        $data['datos'] = $this->cancion_model->get_canciones();
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('cancion/index', $data);
	}
    
      /**
	  * Este metodo muestra en formato JSON los datos de una cancion en particular (anio, disco, artista, nombre)
      * @param string $id codigo de la cancion
	  * @api
	  * @return void
	  */
	
	public function ver($id) //muestra la cancion id
	{
        $data['datos'] = $this->cancion_model->get_cancion($id);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('cancion/index', $data);
	}
	
          /**
	  * Este metodo muestra en formato JSON los fragmentos de la cancion con codigo id
      *
      * @param string $id codigo de la cancion
      *
	  * @api
	  * @return void
	  */
    
	public function verFragmentos ($id)  //devuelve los fragmentos de la cancion id
    {
        $data['datos'] = $this->cancion_model->get_fragmentos($id);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('cancion/index', $data);
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
    * @param string $anio anio de la cancion
    * @param string $disco disco al que pertenece
    * @param string $artista quien la interpreta
    * @param string $contenido letra de la cancion
    * @param string $tag tag de la cancion
    * @param string $usuario usuario que sube la cancion
    * @api
    * @return void
    */
	
	public function guardar ()  //guarda una nueva cancion subida por un usuario
    {
		$nombre=$this->input->post('nombre'); 
		$anio=$this->input->post('anio');
		$disco=$this->input->post('disco');
		$artista=$this->input->post('artista');
		$contenido=$this->input->post('contenido');
		$tag=$this->input->post('tag');
		$tag2=$this->input->post('tag2');
		$usuario=$this->input->post('usuario');
		$fragmentos = $this->partir ($contenido);
		
		$data['datos'] = $this->cancion_model->guardar($nombre, $anio, $disco, $artista, $fragmentos, $tag, $tag2, $usuario);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
            
        $this->load->view('cancion/index', $data);
	}
}
?>