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
        $data['usuarios'] = $this->usuario_model->get_usuarios();
        if( empty($data['usuarios'])||$data['usuarios']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}
	
	public function ver($id) //muestra perfil + ultimas 5 canciones subidas
	{
        $data['usuario'] = $this->usuario_model->get_usuario($id);
        if( empty($data['usuario'])||$data['usuario']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}
	
	public function verCanciones($id) //todas las canciones subidas de un usuario
	{
        $data['canciones'] = $this->usuario_model->get_canciones($id);
        if( empty($data['canciones'])||$data['canciones']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}	
	
	public function mejoresPuntajes ()  //devuelve datos de 5 o 10 usuarios con mayor puntaje
    {
    
	}
}
?>