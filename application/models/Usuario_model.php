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

        public function delete_usuario($id){
            $this->db->where('codigo', $id);
            $this->db->delete('USUARIO');
        }
        
        public function actualizar_usuario($id){
            $nom = $this->input->get('nombre');
            $ema = $this->input->get('email');
            $ape = $this->input->get('apellido');
            $datos = array('nombre' => $nom, 'apellido' => $ape, 'email' => ema);
            
            $this->db->where('codigo', $id);
            $this->db->update('USUARIO', $datos);
        }

		public function get_usuarios ($nMejores=-1, $ordpor = null, $ordtipo = null) {
            
            $this->db->select('*');
            $this->db->from('USUARIO');
            
            if($ordpor == null)
                $ordpor = 'puntos';
            if($ordtipo == null)
                $ordtipo = 'DESC';
                
            if($nMejores > 0)
                $this->db->limit($nMejores);
                
            $this->db->order_by($ordpor, $ordtipo);

            
            return $this->db->get()->result_array();
		}
		
		public function get_usuario ($id) {

            $this->db->select('*');
            $this->db->from('USUARIO');
            $this->db->where('codigo', $id);

            $fila = $this->db->get()->row_array();

            if($fila != null)
                $fila['canciones'] = $this->get_canciones($id);

            return $fila;
		}
		
		public function get_canciones ($id, $ordpor=null, $ordtipo=null) {
            $limitar = $this->input->get('limite');

            if($limitar == null)
                $limitar = 5;

            $this->db->select('CANCION.codigo, CANCION.nombre, CANCION.anio, CANCION.disco, CANCION.artista, FRAGMENTO.tiempo');
            $this->db->from('CANCION');
            $this->db->join('FRAGMENTO', 'FRAGMENTO.codigo_cancion = CANCION.codigo');
            //$this->db->join('USUARIO', 'USUARIO.codigo = CANCION.codigo');
            $this->db->where('FRAGMENTO.codigo_usuario', $id);
            $this->db->group_by('CANCION.codigo');
            $this->db->limit($limitar);
            
            if($ordpor != null && $ordtipo != null)
                $this->db->order_by( $ordpor, $ordtipo );
            else
                $this->db->order_by('FRAGMENTO.tiempo', 'DESC');

            
            return $this->db->get()->result_array();
		}
		
		public function get_juegos ($id, $ordpor=null, $ordtipo=null) {
            $this->db->select('codigo_fragmento, tiempo, dificultad, puntaje');
            $this->db->from('JUEGO');
            //$this->db->join('USUARIO', 'USUARIO.codigo = JUEGO.codigo_usuario');
            $this->db->where('JUEGO.codigo_usuario', $id);
            
            if($ordpor != null && $ordtipo != null)
                $this->db->order_by( $ordpor, $ordtipo );
            
            return $this->db->get()->result_array();
		}
	}

?>
