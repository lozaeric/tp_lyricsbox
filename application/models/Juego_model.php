<?php

	class Juego_model extends CI_Model {
		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}


		public function get_juego ($tag, $anio, $artista) {
			
			$this->db->select('fragmento.contenido, cancion.nombre, cancion.artista, cancion.anio, cancion.disco, tag.nombre');
			$this->db->from('fragmento');
			$this->db->join('cancion', 'fragmento.codigo_cancion = cancion.codigo');
			$this->db->join('tag', 'cancion.codigo = tag.codigo_cancion');
			if ($tag!=null)
				$this->db->where('tag.contenido', $tag);
			if ($anio!=null)
				$this->db->where('cancion.anio', $anio);
			if ($artista!=null)
				$this->db->where('cancion.artista', $artista);	
			$this->db->limit(1);			
			$this->db->order_by(2, 'RANDOM');
			$query = $this->db->get ();
			return $query->result_array ();	   
		}
		
		public function guardar ($idUsuario, $idFragmento, $tiempoJuego, $dificultad, $puntaje) {
			$data = array ("codigo_usuario"=>$idUsuario, "codigo_fragmento"=>$idFragmento, "tiempoJuego"=>$tiempoJuego, "dificultad"=>$dificultad, "puntaje"=>$puntaje);
			$this->db->insert('juego', $data);
			$query = $this->db->get_where ('juego', $data);
			return $query->row_array ();
		}
	}

?>
