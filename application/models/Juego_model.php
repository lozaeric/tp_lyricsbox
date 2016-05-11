<?php

	class Juego_model extends CI_Model {
		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}


		public function get_juego ($tag, $anio, $artista) {
			
		}
		
		public function guardar ($idUsuario, $idFragmento, $tiempo, $dificultad, $puntaje) {
			$data = array ("codigo_usuario"=>$idUsuario, "codigo_fragmento"=>$idFragmento, "tiempo"=>$tiempo, "dificultad"=>$dificultad, "puntaje"=>$puntaje);
			$this->db->insert('juego', $data);
			$query = $this->db->get_where ('jugador', $data);
			return $query->row_array ();
		}
	}

?>
