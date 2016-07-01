<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
    
    /**
    * @ignore
    */
	public function __construct () {
		parent::__construct ();
		$this->load->model ('usuario_model');
		$this->load->helper('ssl');
		force_ssl ();
	}
    
          /**
	  * Devuelve una lista de los usuarios existentes
	  * @api
	  * @return void
	  */
	
	public function index() //muestra datos de todos los usuarios - se puede filtrar para traer mejores N puntajes
	{
        $ordpor = $this->input->get('campo');
        $ordtipo = $this->input->get('orden');
        $data['datos'] = $this->usuario_model->get_usuarios(15, $ordpor, $ordtipo);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}
	
    /**
    * Devuelve los datos de un usuario especifico de codigo id
    * @param string $id codigo del usuario
    * @api
    * @return void
    */
    
	public function ver($id) //muestra datos del usuario con ese id y sus ultimas 5 canciones subidas
	{
        $data['datos'] = $this->usuario_model->get_usuario($id);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}
    
    /**
    * Devuelve las canciones subidas por el usuario ID
    * @param string $id codigo del usuario
    * @api
    * @return void
    */
	
	public function verCanciones($id) //todas las canciones subidas de un usuario
	{
        $ordpor = $this->input->get('campo');
        $ordtipo = $this->input->get('orden');
        $data['datos'] = $this->usuario_model->get_canciones($id, $ordpor, $ordtipo);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}
    
        
    /**
    * Registra un nuevo usuario
    * @param string $nombre nombre de usuario
    * @param string $apellido apellido del usuario
    * @param string $email email del usuario
    * @api
    * @return void
    */

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

        
    /**
    * Devuelve un listado de las partidas jugadas por el usuario.
    * @param string $id codigo del usuario
    * @api
    * @return void
    */

	public function verJuegos($id) //todos los juegos de un usuario
	{
        $ordpor = $this->input->get('campo');
        $ordtipo = $this->input->get('orden');
            
        $data['datos'] = $this->usuario_model->get_juegos($id, $ordpor, $ordtipo);
        if( empty($data['datos'])||$data['datos']==null )
            show_404();
        $this->load->view('usuario/index', $data);
	}		
}
?>