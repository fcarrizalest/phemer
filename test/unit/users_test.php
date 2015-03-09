<?php
use Symfony\Component\Yaml\Parser;

class TestOfUsers extends WebTestCase{

	private $_INETROOT;
	private $_LOCALURL_ROOT;
	private $_csrf_token;

	public function __construct(){
		$yaml = new Parser();
		$value = $yaml->parse(file_get_contents(dirname(__FILE__) .'/../../phinx.yml'));

		$this->_INETROOT = $value['INETROOT'];
		$this->_LOCALURL_ROOT = $value['LOCALURL_ROOT'];

	}


	public function setUp() {
 		

		$res = $this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/index.php" );

		$parameters['username'] = "admin";
		$parameters['password'] = "00";

		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/login"   );

		$browser = $this->getBrowser();
		$csrf_token = $browser->getFieldByName("csrf_token");

		$parameters['csrf_token'] = $csrf_token ;

		$this->_csrf_token = $csrf_token ;
		
		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/login" , $parameters  );
	

	}

	public function tearDown() {
  

		
		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/logout");

	}



	public function TestOfL(){

		

		$this->get(  $this->_LOCALURL_ROOT.$this->_INETROOT."/people"  );

		$this->assertPattern("/.*admin@.*/");
		
		// Comprobamos que tenemos seteado el $csrf_token 

		if ( !isset( $this->_csrf_token )) {
			$this->assertTrue( false , "El token de validacion no esta correctamente seteado" );

			return "";
		}

		$this->assertTrue( isset( $this->_csrf_token ) , "El token de validación no esta seteado.");

		// Vamos a crear un nuevo usuario.
		$data['username'] = "user1";
		$data['password'] = "wwwww";
		$data['email'] = "f@a.com";
		 //$data['csrf_token'] = $this->_csrf_token;
		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/people" , $data  );

		$this->assertPattern("/.*missing CSRF.*/");
		$data['csrf_token'] = $this->_csrf_token;

		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/people" , $data  );
		

		$this->assertPattern("/user1/");

		// Obtenemos la Lista de Usuarios.
		$listaU = $this->get(  $this->_LOCALURL_ROOT.$this->_INETROOT."/api/people"  );
		$listaU = json_decode( $listaU , true  );
		$encontrado = false;
		$idNuevoUsuaro = "0";
		if($listaU )
			foreach ($listaU as $key => $value) {
				# code...
				if( $value['username'] == "user1" ){
					$encontrado = true;
					$idNuevoUsuaro = $value['id'];
				}
			}

		$this->assertTrue($encontrado , "No encontre a mi nuevo usuario");
		unset($data);
		$data['csrf_token'] = $this->_csrf_token;
		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/people/".$idNuevoUsuaro."/	delete" , $data  );


		// Errores

		// Error Username Unico
		unset($data);
		$data['username'] = "admin";
		$data['password'] = "wwwww";
		$data['email'] = "f@a.com";
		$data['csrf_token'] = $this->_csrf_token;
		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/people" , $data  );

		$this->assertPattern("/Error/");
		
		// Error  longitud Pass
		unset($data);
		$data['username'] = "adminaaaa";
		$data['password'] = "q";
		$data['email'] = "f@as.com";
		$data['csrf_token'] = $this->_csrf_token;
		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/people" , $data  );

		$this->assertPattern("/Error/");

		// Error Email Valido
		unset($data);
		$data['username'] = "user2";
		$data['password'] = "wwww";
		$data['email'] = "fasdf";
		$data['csrf_token'] = $this->_csrf_token;
		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/people" , $data  );

		$this->assertPattern("/Error/");

		
	}


}


?>