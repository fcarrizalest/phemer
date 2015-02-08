<?php
//require_once(dirname(__FILE__).'/../vendor/lastcraft/simpletest/web_tester.php');
use Symfony\Component\Yaml\Parser;

class TestOfLogin extends WebTestCase{

	private $_INETROOT;
	private $_LOCALURL_ROOT;

	public function __construct(){
		$yaml = new Parser();
		$value = $yaml->parse(file_get_contents(dirname(__FILE__) .'/../../phinx.yml'));

		$this->_INETROOT = $value['INETROOT'];
		$this->_LOCALURL_ROOT = $value['LOCALURL_ROOT'];

	}

	public function TestOfL(){


		$res = $this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/index.php" );

		$this->assertTrue( $res);

		$this->assertText('Sign In');

		$parameters['username'] = "admin";
		$parameters['password'] = "00";

		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/login"   );

		$browser = $this->getBrowser();
		$csrf_token = $browser->getFieldByName("csrf_token");

		$parameters['csrf_token'] = $csrf_token ;

		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/login" , $parameters  );
		unset( $parameters );
		sleep(1);
		$this->assertText('Dashboard', "Deberiamos estar logueados");

		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/logout");
		sleep(1);
 		$this->assertText('Sign In');

		$parameters['username'] = "admi";
		$parameters['password'] = "00";
		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/login"   );
		$browser = $this->getBrowser();
		$csrf_token = $browser->getFieldByName("csrf_token");

		$parameters['csrf_token'] = $csrf_token ;


		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/login" , $parameters  );
		sleep(1);

		$this->assertText('Sign In');

		$parameters['username'] = "admin";
		$parameters['password'] = "00";
		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/login"   );
		$browser = $this->getBrowser();
		$csrf_token = $browser->getFieldByName("csrf_token");

		$parameters['csrf_token'] = $csrf_token ;


		$this->post( $this->_LOCALURL_ROOT.$this->_INETROOT."/login" , $parameters  );
		sleep(1);
		unset( $parameters );
		$this->assertText('Dashboard', "Deberiamos estar logueados");


		//  CheckTicket... 

		 


		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/index.php" );
		sleep(1);
		$this->assertText('Dashboard', "Deberiamos estar logueados");


		$this->get( $this->_LOCALURL_ROOT.$this->_INETROOT."/logout");
		
 		$this->assertText('Sign In');
	}

}


?>