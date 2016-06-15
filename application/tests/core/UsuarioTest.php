<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once(__DIR__.'/../CITestCase.php');

class UsuarioTest extends CITestCase {
	public function setUp()
    {
		$this->requireController('Usuario'); 
		$this->CI = new Usuario();		
    }
	public function testIndex() {
		$todos = $this->CI->usuario_model->get_usuarios();

		
        $this->CI->usuario_model->guardar("Roberto", "Perez", "cmar@speedy.com.ar");
        $usus = $this->CI->usuario_model->get_usuarios(1, 'codigo', 'DESC');
        
        $lastElement = array_slice($usus, -1)[0];
        $cod = $lastElement['codigo'];
        $this->assertEquals( $lastElement['email'], "cmar@speedy.com.ar" );
        
        $this->assertEmpty( $this->CI->usuario_model->get_canciones($cod) );
        $this->assertEmpty( $this->CI->usuario_model->get_juegos($cod) );
        
        
        $this->CI->usuario_model->delete_usuario($lastElement['codigo']);
        
        //$this->get_canciones( $id );
        
	}
}

?>