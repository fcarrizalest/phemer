<?php
namespace Stemer;

class Controller {


	public function DashBoard(){

        return function() {

            $app = \Slim\Slim::getInstance();
            
        
            $app->render('home' );

        };

    }


    public function People(){
        return function(){
            $app = \Slim\Slim::getInstance();
            
            $users =  \User::all();
            $app->render('people' , array(
                "users" => $users
               
            ) );
        };
    }





    public function PostLogin(){
    	return function(){
    		$app = \Slim\Slim::getInstance();
    		$error = false;

    		try {

    			$username =  $app->request->post('username');
			    $password = $app->request->post('password');
			    $app->log->debug("Usuario:  " . $username);
			    $app->log->debug("Pass: " . $password);
			    
			    $model = \User::where('username', '=', $username)->firstOrFail();

			    $salt = $app->salt ;
			    if( $model->password == sha1( $salt. $password ) ) {

			        $secure = new \Stemer\Security();
			        $secure->doLogin($model);
 
			    } 
    			
    		} catch (\Exception $e) {

    			unset( $_SESSION);
                $error = TRUE;  
    			$app->log->debug("Ocurrio un error ".time());

    			$app->log->debug( $e ->getMessage());
    			
    			
    		}
			
			if( $error ){
                $app->log->debug("Redireccionado al login ");
				$app->redirect('./login'); 
			}else
				$app->redirect('./');
		    
		  

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
                //Necesitamos borrar el ticket actual.
                $t = $_SESSION['stemer_ticket'];

                
       			unset( $_SESSION['stemer_ticket']  );
                try {
                    $ticket = \Ticket::where('ticketid', '=', $t  )->firstOrFail();
                    if($ticket )    
                        $ticket ->forceDelete(); 
                } catch (\Exception $e) {
                    $app->log->error( "Error al borrar el ticket " ); 

                    $app->log->error( $e );
                }
                
    		}

           
    		$app->redirect('./login');

    	};
    }


}
?>