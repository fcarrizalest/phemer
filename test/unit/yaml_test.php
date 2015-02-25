<?php
use Symfony\Component\Yaml\Parser;

class TestOfYaml extends WebTestCase{


	public function __construct(){
		
		
	}

	public function TestOfL(){

		$yaml = new Parser();
		$value = $yaml->parse(file_get_contents(dirname(__FILE__) .'/../../phinx.yml'));

		$this->assertTrue(  isset( $value['salt'] ) , "No encontre el valor salt en el archivo phinx.yml");
		$this->assertTrue(  isset( $value['INETROOT'] ), "No encontre valor para INETROOT en el archivo phinx.yml" );
		$this->assertTrue(  isset( $value['LOCALURL_ROOT'] ), "No encontre valor para LOCALURL_ROOT en el archivo phinx.yml" );
		$this->assertTrue(  isset( $value['debug'] ), "No encontre la etiquete debug en el archivo de configuración phinx.yml");
		$this->assertTrue(  isset( $value['level'] ), "No encontre la etiquete level en el archivo de configuración phinx.yml");
		

	}

}
?>