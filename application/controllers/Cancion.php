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
        $data['canciones'] = $this->cancion_model->get_canciones();
        if( empty($data['canciones'])||$data['canciones']==null )
            show_404();
        $this->load->view('cancion/index', $data);
	}
	
	public function ver($id) //muestra la cancion id
	{
        $data['cancion'] = $this->cancion_model->get_cancion($id);
        if( empty($data['cancion'])||$data['cancion']==null )
            show_404();
        $this->load->view('cancion/index', $data);
	}
	
	public function verFragmentos ($id)  //devuelve los fragmentos de la cancion id
    {
        $data['fragmentos'] = $this->cancion_model->get_fragmentos($id);
        if( empty($data['fragmentos'])||$data['fragmentos']==null )
            show_404();
        $this->load->view('cancion/index', $data);
	}
}
?>