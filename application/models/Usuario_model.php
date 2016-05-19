<?php

	class Usuario_model extends CI_Model {
		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}
        
        public function guardar($nombre, $apellido, $email) {
            $data = array ("nombre"=>$nombre, "apellido"=>$apellido, "email"=>$email, "puntos"=>0);
			$this->db->insert('USUARIO', $data);
			$query = $this->db->get_where ('USUARIO', $data);
			return $query->row_array ();
        }


		public function get_usuarios ($nMejores=10) {
            $this->db->select('*');
            $this->db->from('USUARIO');
            $this->db->order_by('puntos');
            $this->db->limit(10);
            
            return $this->db->get()->result_array();
		}
		
		public function get_usuario ($id) {
            $this->db->select('*');
            $this->db->from('USUARIO');
            $this->db->where('codigo', $id);
            return $this->db->get()->row_array();
		}
		
		public function get_canciones ($id) {
            $this->db->select('CANCION.codigo, CANCION.nombre, CANCION.anio, CANCION.disco, CANCION.artista');
            $this->db->from('CANCION');
            $this->db->join('FRAGMENTO', 'FRAGMENTO.codigo_cancion = CANCION.codigo');
            //$this->db->join('USUARIO', 'USUARIO.codigo = CANCION.codigo');
            $this->db->where('FRAGMENTO.codigo_usuario', $id);
            
            return $this->db->get()->result_array();
		}
		
		public function get_juegos ($id) {
            $this->db->select('codigo_fragmento, tiempo, dificultad, puntaje');
            $this->db->from('JUEGO');
            //$this->db->join('USUARIO', 'USUARIO.codigo = JUEGO.codigo_usuario');
            $this->db->where('JUEGO.codigo_usuario', $id);
            
            return $this->db->get()->result_array();
		}
	}

?>
