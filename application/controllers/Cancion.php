<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cancion extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->load->model ('cancion_model');
		$this->load->helper('ssl');
		force_ssl ();
	}
	
	public function index() //muestra datos de todos las canciones
	{
        $data['datos'] = $this->cancion_model->get_canciones();
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('cancion/index', $data);
	}
	
	public function ver($id) //muestra la cancion id
	{
        $data['datos'] = $this->cancion_model->get_cancion($id);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('cancion/index', $data);
	}
	
	public function verFragmentos ($id)  //devuelve los fragmentos de la cancion id
    {
        $data['datos'] = $this->cancion_model->get_fragmentos($id);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('cancion/index', $data);
	}
    
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