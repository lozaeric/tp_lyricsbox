<?php

	class Juego_model extends CI_Model {
		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}


		public function get_juego ($tag, $anio, $artista) {
			
		}
		
		public function guardar ($idUsuario, $idFragmento, $tiempo, $dificultad, $puntaje) {
			
		}
	}

?>
