<?php
use Symfony\Component\Yaml\Parser;

class TestOfUsers extends WebTestCase{

	private $_INETROOT;
	private $_LOCALURL_ROOT;

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

		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/login" , $parameters  );
	

	}

	public function tearDown() {
  

		
		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/logout");

	}



	public function TestOfL(){

		

		$this->get(  $this->_LOCALURL_ROOT.$this->_INETROOT."/people"  );

		$this->assertPattern("/.*admin@.*/");
		
		

	}


}


?>