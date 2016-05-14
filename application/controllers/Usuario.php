<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->load->model ('usuario_model');
		$this->load->helper('ssl');
		force_ssl ();
	}
	
	public function index() //muestra datos de todos los usuarios - se puede filtrar para traer mejores N puntajes
	{
        $data['datos'] = $this->usuario_model->get_usuarios();
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}
	
	public function ver($id) //muestra datos del usuario con ese id y sus ultimas 5 canciones subidas
	{
        $data['datos'] = $this->usuario_model->get_usuario($id);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}
	
	public function verCanciones($id) //todas las canciones subidas de un usuario
	{
        $data['datos'] = $this->usuario_model->get_canciones($id);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}

	public function agregarUsuario()
	{
		$nombre=$this->input->post('nombre'); 
		$apellido=$this->input->post('apellido');
		$email=$this->input->post('email');
		
		$data['datos'] = $this->usuario_model->guardar($nombre, $apellido, $email);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}	

	public function verJuegos($id) //todos los juegos de un usuario
	{
        $data['datos'] = $this->usuario_model->get_juegos($id);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}		
}
?>