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
    * @ignore
    */
    private function checktag($data)
    {
        $etagHeader = ( isset( $_SERVER["HTTP_IF_NONE_MATCH"] ) ? trim( $_SERVER["HTTP_IF_NONE_MATCH"] ) : false );

        $tag = md5(serialize($data['datos']));

        header("Etag: ". $tag );

        if( $tag === $etagHeader)
        {
            header( "HTTP/1.1 304 Not Modified" );
            $data['datos'] = "";
        }
    }

        /**
	  * Devuelve una lista de los usuarios existentes
      * @param string $campo campo por el cual ordenar - OPCIONAL
      * @param string $orden ordenamiento (ASCendente|DESCendente) - OPCIONAL
      * @param int $limite cantidad a mostrar (default 15) - OPCIONAL
	  * @api
	  * @return void
	  */
	
	public function index() //muestra datos de todos los usuarios - se puede filtrar para traer mejores N puntajes
	{
        if( $this->validador()  )
        {
            $ordpor = $this->input->get('campo');
            $ordtipo = $this->input->get('orden');
            $mejores = $this->input->get('limite');

            if($mejores==null)
                $mejores = 15;

            $data['datos'] = $this->usuario_model->get_usuarios($mejores, $ordpor, $ordtipo);
            if( empty($data['datos'])||$data['datos']==null )
                show_404();
            else
            {
                $this->checktag($data);
            }
        }
		else
			$data['datos'] = "rechazado";


        $this->load->view('usuario/index', $data);
	}
	
    /**
    * Devuelve los datos de un usuario especifico de codigo id
    * @param string $id codigo del usuario
    * @api
    * @return void
    */
    
	public function ver($id) //muestra datos del usuario con ese id
	{
        if( $this->validador()  )
        {
            $data['datos'] = $this->usuario_model->get_usuario($id);
            if( empty($data['datos'])||$data['datos']==null )
                show_404();
        }
		else
			$data['datos'] = "rechazado";

        $this->load->view('usuario/index', $data);
	}
    
    /**
    * Devuelve las canciones subidas por el usuario ID
    * @param string $id codigo del usuario
    * @param string $campo campo por el cual ordenar - OPCIONAL
    * @param string $orden ordenamiento (ASCendente|DESCendente) - OPCIONAL
    * @param int $limite cantidad a traer (default 5) - OPCIONAL
    * @api
    * @return void
    */
	
	public function verCanciones($id) //todas las canciones subidas de un usuario
	{
        if( $this->validador()  )
        {
            $ordpor = $this->input->get('campo');
            $ordtipo = $this->input->get('orden');
            $data['datos'] = $this->usuario_model->get_canciones($id, $ordpor, $ordtipo);
            if( empty($data['datos'])||$data['datos']==null )
                show_404();
            else
            {
                $this->checktag($data);
            }
        }
		else
			$data['datos'] = "rechazado";

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
        if( $this->validador()  )
        {
            $nombre=$this->input->post('nombre'); 
            $apellido=$this->input->post('apellido');
            $email=$this->input->post('email');
            
            $data['datos'] = $this->usuario_model->guardar($nombre, $apellido, $email);
            if( empty($data['datos'])||$data['datos']==null )
                show_404();
        }
		else
			$data['datos'] = "rechazado";

        $this->load->view('usuario/index', $data);
	}	

        
    /**
    * Devuelve un listado de las partidas jugadas por el usuario.
    * @param string $id codigo del usuario
    * @param string $campo campo por el cual ordenar - OPCIONAL
    * @param string $orden ordenamiento (ASCendente|DESCendente) - OPCIONAL
    * @api
    * @return void
    */

	public function verJuegos($id) //todos los juegos de un usuario
	{
        if( $this->validador()  )
        {
            $ordpor = $this->input->get('campo');
            $ordtipo = $this->input->get('orden');
                
            $data['datos'] = $this->usuario_model->get_juegos($id, $ordpor, $ordtipo);
            if( empty($data['datos'])||$data['datos']==null )
                show_404();
            else
            {
                $this->checktag($data);
            }
        }
		else
			$data['datos'] = "rechazado";

        $this->load->view('usuario/index', $data);
	}		
}
?>