<?php

	class Cancion_model extends CI_Model {
		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}

		public function get_canciones() {
            $ordpor = $this->input->get('campo');
            $ordtipo = $this->input->get('orden');
			$filtrar = $this->input->get('filtrar');
			$como = $this->input->get('valor');
            
            if($ordpor == null)
                $ordpor = 'nombre';
            if($ordtipo == null)
                $ordtipo = 'DESC';

                
			$this->db->select('codigo,nombre,anio,disco,artista');
			$this->db->from('cancion');
            $this->db->order_by($ordpor, $ordtipo);

			if($filtrar != null && $como != null)
				$this->db->where($filtrar, $como);
            
			$query = $this->db->get ();
			return $query->result_array ();		
		}		
        
        public function get_fragmentos($id) {
            $ordpor = $this->input->get('campo');
            $ordtipo = $this->input->get('orden');
            
            if($ordpor == null)
                $ordpor = 'nombre';
            if($ordtipo == null)
                $ordtipo = 'DESC';
            
			$this->db->select('fragmento.codigo, usuario.nombre as usuario, cancion.nombre as cancion, tiempo, contenido');
			$this->db->from('fragmento');
			$this->db->join('cancion', 'fragmento.codigo_cancion = cancion.codigo');
			$this->db->join('usuario', 'fragmento.codigo_usuario = usuario.codigo');
			$this->db->where('fragmento.codigo_cancion', $id);
			$this->db->order_by('cancion.'+$ordpor, $ordtipo);
            
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
		
		public function guardar($nombre, $anio, $disco, $artista, $fragmentos, $tags, $usuario) {
			//inserto cancion
            $data = array ("nombre"=>$nombre, "anio"=>$anio, "disco"=>$disco, "artista"=>$artista);
			$query = $this->db->get_where ('cancion', $data);
			$consulta = $query->row_array ();
			if (empty ($consulta))
				$this->db->insert('cancion', $data);
			//inserto tags
			$query = $this->db->get_where ('cancion', $data);
			$cancion = $query->row_array ();
			foreach ($tags as $tag) {
				$data = array ("codigo_cancion"=>$cancion['codigo'], "nombre"=>$tag);
				$query = $this->db->get_where ('tag', $data);
				$consulta = $query->row_array ();
				if (empty ($consulta))
					$this->db->insert('tag', $data);
			}
			//inserto fragmentos 
			foreach ($fragmentos as $f)
				$this->guardar_fragmento ($f, $data['codigo_cancion'], $usuario);
			
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
