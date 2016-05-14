<?php

	class Cancion_model extends CI_Model {
		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}

		public function get_canciones() {
			$this->db->select('codigo,nombre,anio,disco,artista');
			$this->db->from('cancion');
			$this->db->order_by("nombre");
			$query = $this->db->get ();
			return $query->result_array ();		
		}		
        
        public function get_fragmentos($id) {
			$this->db->select('fragmento.codigo, usuario.nombre, cancion.nombre, tiempo, contenido');
			$this->db->from('fragmento');
			$this->db->join('cancion', 'fragmento.codigo_cancion = cancion.codigo');
			$this->db->join('usuario', 'fragmento.codigo_usuario = usuario.codigo');
			$this->db->where('fragmento.codigo_cancion', $id);
			$this->db->order_by('cancion.nombre');
			$query = $this->db->get ();
			return $query->result_array ();	            
        }
        
        public function get_cancion($id) {
  			$this->db->select('codigo,nombre,anio,disco,artista');
			$this->db->from('cancion');
			$this->db->where('codigo', $id);
			$this->db->order_by("nombre");
			$query = $this->db->get();
			return $query->row_array ();	          
        }
		
		public function guardar($nombre, $anio, $disco, $artista, $contenido) {
            $data = array ("nombre"=>$nombre, "anio"=>$anio, "disco"=>$disco, "artista"=>$artista);
			$this->db->insert('cancion', $data);
			
			//logica fragmento
			
			$query = $this->db->get_where ('cancion', $data);
			return $query->row_array ();
        }
	}

?>
