<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once(__DIR__.'/../CITestCase.php');

class CancionTest extends CITestCase {
	public function setUp()
    {
		$this->requireController('Cancion'); 
		$this->CI = new Cancion();		
    }
	public function testIndex() {
		$todas = $this->CI->cancion_model->get_canciones();
		$cancion = $this->CI->cancion_model->get_cancion(1);
		$fragmentos = $this->CI->cancion_model->get_fragmentos(1);
		
		//No estan vacias
		$this->assertNotEmpty($todas);
		$this->assertNotEmpty($cancion);
		$this->assertNotEmpty($fragmentos);		
		
		//crear cancion,fragmento y tags
		$fragmentos = $this->CI->partir('a a a a a a a a a a a a a a a a a a a a.');
		$this->assertNotEmpty($fragmentos);
		$tags = explode ('.', 'prueba4.prueba5');
		$cancion = $this->CI->cancion_model->guardar('prueba', 0, 'prueba2', 'prueba3', $fragmentos, $tags, 1);
		//verificar cancion
		$this->assertEquals($cancion['nombre'], 'prueba');
		$this->assertEquals($cancion['anio'], '0');
		$this->assertEquals($cancion['disco'], 'prueba2');
		$this->assertEquals($cancion['artista'], 'prueba3');
		//verificar fragmento
		$codigo_cancion = $cancion['codigo'];
		$fragmentos = $this->CI->cancion_model->get_fragmentos($codigo_cancion);
		$this->assertEquals($fragmentos[0]['usuario'], 'Test');
		$this->assertEquals($fragmentos[0]['contenido'], 'a a a a a a a a a a a a a a a a a a a a.');
		//eliminarlo
		$this->CI->cancion_model->eliminar($codigo_cancion);
		$cancion = $this->CI->cancion_model->get_cancion($codigo_cancion);
		$this->assertEmpty($cancion);
	}
}

?>