<?php

	class Autenticacion_model extends CI_Model {

		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}

        public function ingresoValido($usuario, $password)
        {
            $this->db->select('codigo,nombre,anio,disco,artista');
			$this->db->from('autorizados');
			$this->db->where('usuario', $usuario);
            $this->db->where('password', $password);
			$query = $this->db->get()->result_array();
            
            return ( $query != null and ( empty($query) == false ) );
        }

    }

?>
