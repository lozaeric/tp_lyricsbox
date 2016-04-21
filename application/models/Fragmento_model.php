<?php

	class Fragmento_model extends CI_Model {
		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}


		public function post_artista ($artista, $disco, $anio, $tags, $usuario, $timestamp, $fragmento) {
			
		}
		
		public function get_fragmentoAleatorio () {
			
		}		
	}

?>
