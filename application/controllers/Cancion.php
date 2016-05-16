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
    
    public function guardar_fragmento($texto, $codigo_cancion, $codigo_usuario)
    {
        $data['datitos'] = $this->cancion_model->guardar_fragmento($texto, $codigo_cancion, $codigo_usuario);
        
        if( empty($data['datitos'])||$data['datitos']==null )
            show_404();
    }
    
    public function partir($datos)
    {
        $texto = $datos['contenido'];
        //$tam = strlen($texto);
        
        $partir = '.';
        $oraciones = substr_count($texto, $partir); // Numero de oraciones
        
        $pedazos = explode($partir, $texto); // Lista de oraciones.
        $fragmentito = ""; // Acumulado de texto
        $acum = 0; // Palabras acumuladas
        
        for($x=0; x<$oraciones; x++)
        {
            $palabras = str_word_count($pedazos[$x]);
            $acum += $palabras;
            $fragmentito += ($pedazos[$x]+$partir); // Explode le saca el delimitador.
            
            if($acum > 20) // Si paso 20 guardar el fragmento.
            {
                $acum = 0;
                
                guardar_fragmento($fragmentito, $datos['codigo']);
                
                $fragmentito = "";
            }
            
        }
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
		
		$data['datos'] = $this->cancion_model->guardar($nombre, $anio, $disco, $artista, $contenido, $tag, $tag2);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
            
        $this->partir($data['datos']);
            
        $this->load->view('cancion/index', $data);
	}
}
?>