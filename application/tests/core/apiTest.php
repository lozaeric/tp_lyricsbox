<?php

require(__DIR__.'/../../../vendor/autoload.php');

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once(__DIR__.'/../CITestCase.php');
    // src/KnpU/CodeBattle/Tests/ProgrammerControllerTest.php

    class ProgrammerControllerTest extends \PHPUnit_Framework_TestCase
    {

        protected $client;

        public function setUp()
        {
            $this->client = new GuzzleHttp\Client([
                'base_uri' => 'http://localhost/index.php/'
            ]);
        }


        public function testIndex()
        {
            $response = $this->client->get('canciones', [
                'auth' => [
                    'juan', '123'
                ],

                'auth' => [
                    'juan', '123'
                ]
            ]);

            $this->assertEquals(200, $response->getStatusCode());

            $data = json_decode($response->getBody(), true);

            $cantidad = count($data);

            
            $response = $this->client->post('canciones', [
                'form_params' => [
                    'nombre' => 'Espejo',
                    'anio'     => '1990',
                    'artista' => 'Pedrito',
                    'disco' => 'Viento',
                    'contenido' => 'Mucho contenido por aca blalbasldas muchas palabras para agregar bla bla bla oracion, oracion, esto es muy largo.',
                    'tags' => 'rock.80s',
                    'usuario' => '1'
                ],
                'auth' => [
                    'juan', '123'
                ]
            ]);

            $this->assertEquals(200, $response->getStatusCode());

            $response = $this->client->get('canciones', [
                'auth' => [
                    'juan', '123'
                ]
            ]);

            $this->assertEquals(200, $response->getStatusCode());

            $data = json_decode($response->getBody(), true);

            $this->assertEquals($cantidad+1, count($data) );

        }

    }

?>