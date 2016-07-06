<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Controlador_Base extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->load->helper('ssl');
        $this->load->model ('autenticacion_model');

		force_ssl ();
	}

        /**
        * @ignore
        */
        protected function esValido($username, $password)
        {
            return $this->autenticacion_model->ingresoValido($username, $password);
        }

        /**
        * @ignore
        */
        protected function estaAutorizado()
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

            if( ($username == null and $password == null) or $this->esValido($username, $password) == false )
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
        protected function chequearTag($data)
        {
            $etagHeader = ( isset( $_SERVER["HTTP_IF_NONE_MATCH"] ) ? trim( $_SERVER["HTTP_IF_NONE_MATCH"] ) : false );

            $tag = md5(serialize($data['datos']));

            header("Etag: ". $tag );

            if( $tag === $etagHeader)
            {
                header( "HTTP/1.1 304 Not Modified" );
            }
        }
    }
?>