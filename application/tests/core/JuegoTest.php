<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once(__DIR__.'/../CITestCase.php');

class JuegoTest extends CITestCase {
	public function setUp()
    {
		$this->requireController('Juego'); 
		$this->CI = new Juego();		
    }
	public function testIndex() {
		$juego = $this->CI->juego_model->get_juego ('classic', '1990', 'dsaff');
		$guardado = $this->CI->juego_model->guardar ('1', '1', '100', 'medio', $this->CI->calcularPuntaje ('medio', '100'));
		
		//No estan vacias
		$this->assertNotEmpty($juego);
		$this->assertNotEmpty($guardado);
		
		//Datos correctos
		$this->assertEquals($guardado['codigo_usuario'], '1');
		$this->assertEquals($guardado['codigo_fragmento'], '1');
		$this->assertEquals($guardado['dificultad'], 'medio');
		$this->assertEquals($guardado['tiempoJuego'], '100');
	}
}

?>