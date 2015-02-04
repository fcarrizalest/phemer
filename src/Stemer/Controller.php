<?php

namespace Stemer;

class Controller {


	 public function DashBoard(){

        return function() {

            $app = \Slim\Slim::getInstance();
    

            $app->render('home');

        };

    }


    public function PostLogin(){
    	return function(){
    		$app = \Slim\Slim::getInstance();
		    $username =  $app->request->post('username');
		    $password = $app->request->post('password');
		    $model = \User::where('username', '=', $username)->firstOrFail();
		    $salt = $app->salt ;
		    if( $model->password == sha1( $salt. $password ) ) {
		        $secure = new \Stemer\Security();
		        $secure->doLogin($model);
		        $app->redirect('./');
		    }
		    
		    $app->redirect('./login');

    	};
    }

    public function LoginForm(){
    	return function(){
    		$app = \Slim\Slim::getInstance();
    		$salt = $app->salt ;
    		$app->render('login');


    	};
    }


    public  function LogOut(){
    	return function (){
    		$app = \Slim\Slim::getInstance();

    		if( isset( $_SESSION['stemer_ticket'] )){
       			unset( $_SESSION['stemer_ticket'] );
    		}


    		$app->redirect('./login');

    	};
    }


}
?>