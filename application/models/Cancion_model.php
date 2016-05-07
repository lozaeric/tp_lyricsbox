<?php

	class Cancion_model extends CI_Model {
		public function __construct () {
			parent::__construct ();
			$this->load->database();
		}

		public function get_canciones() {
			
		}		
        
        public function get_fragmentos($id) {
            
        }
        
        public function get_cancion($id) {
            
        }
		
		public function guardar($nombre, $anio, $disco, $artista, $contenido) {
            //en este metodo se realiza toda la logica que debe tener el fragmento
        }
	}

?>
