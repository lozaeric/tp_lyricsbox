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
			$this->db->select('fragmento.codigo, usuario.nombre as usuario, cancion.nombre as cancion, tiempo, contenido');
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
        
        public function guardar_fragmento($texto, $cod_can, $cod_usu){
            $data = array( "contenido"=>$texto, "codigo_cancion"=>$cod_can, "codigo_usuario"=>$cod_usu );
            $this->db->insert('fragmento', $data);
            
            $query = $this->db->get_where ('fragmento', $data);
			$fragmento = $query->row_array ();
            
            return $fragmento==null || empty($fragmento);
        }
		
		public function guardar($nombre, $anio, $disco, $artista, $fragmentos, $tag, $tag2, $usuario) {
			//inserto cancion
            $data = array ("nombre"=>$nombre, "anio"=>$anio, "disco"=>$disco, "artista"=>$artista);
			$query = $this->db->get_where ('cancion', $data);
			$consulta = $query->row_array ();
			if (empty ($consulta))
				$this->db->insert('cancion', $data);
			//inserto tags
			$query = $this->db->get_where ('cancion', $data);
			$cancion = $query->row_array ();
			$data = array ("codigo_cancion"=>$cancion['codigo'], "nombre"=>$tag);
			$query = $this->db->get_where ('tag', $data);
			$consulta = $query->row_array ();
			if (empty ($consulta))
				$this->db->insert('tag', $data);
			$data = array ("codigo_cancion"=>$cancion['codigo'], "nombre"=>$tag2);
			$query = $this->db->get_where ('tag', $data);
			$fragmento = $query->row_array ();
			if (empty ($consulta))
				$this->db->insert('tag', $data);		
			
			//inserto fragmentos 
			$n = count ($fragmentos);
			for ($i=0; $i<$n; $i++) 
				$this->guardar_fragmento ($fragmentos[$i], $data['codigo_cancion'], $usuario);
			
			return $cancion;
        }
		
		public function eliminar ($id) {
			$this->db->where('codigo', $id);
			$this->db->delete('Cancion');
			$this->db->where('codigo_cancion', $id);
			$this->db->delete('Tag');
			$this->db->where('codigo_cancion', $id);
			$this->db->delete('Fragmento');
		}
	}

?>
