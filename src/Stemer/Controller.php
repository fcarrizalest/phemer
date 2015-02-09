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

    public function PostDeleteUser(){

        return function($id){
            $app = \Slim\Slim::getInstance();

            try {
                 $model = \User::findOrFail($id);
                 $model->forceDelete();

                

            } catch (\Exception $e) {
                
            }
            $app->redirect($app->LOCALURL_ROOT . $app->INETROOT.'/people');
        }; 
    }


    public function NewUser( ){
        return function(){
            $app = \Slim\Slim::getInstance();

            $app->render('formUser' , array(
              
               
            ) );
        };
    }

    public function EditUser(){

        return function($id){

            $app = \Slim\Slim::getInstance();

            try {
                
                $model = \User::findOrFail($id);

                $app->render('formUser' , array( 'user' => $model ) );

            } catch (\Exception $e) {
                
            }


          
        };
    }

    public function PostEditUser(){

        return function($id){
            $app = \Slim\Slim::getInstance();

            try {
                $model = \User::findOrFail($id);
                $salt = $app->salt ;
                $model->username = $app->request->post('username');
                
                if($app->request->post('password')  )
                    $model->password = sha1( $salt.$app->request->post('password'));

                $model->email = $app->request->post('email');
                $model->active  = true;

                $model->save();

                
            } catch (\Exception $e) {
                
            }

             $app->redirect($app->LOCALURL_ROOT . $app->INETROOT.'/people');
        };
    }

    public function PostNewUser(){
        return function(){
            $app = \Slim\Slim::getInstance();

            try {

                $salt = $app->salt ;
                // @TODO Validar los datos de entrada..
                $array['username'] = $app->request->post('username');
                $array['password'] = sha1( $salt.$app->request->post('password'));

                $array['email'] = $app->request->post('email');
                $array['active'] = true;


                $user = new \User( $array );

                $user->save();

                
            } catch (\Exception $e) {


                
            }


            $app->redirect($app->LOCALURL_ROOT . $app->INETROOT.'/people');

            




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
				$app->redirect($app->LOCALURL_ROOT . $app->INETROOT.'/login'); 
			}else
				$app->redirect($app->LOCALURL_ROOT . $app->INETROOT.'/');
		    
		  

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

           
    		$app->redirect($app->LOCALURL_ROOT . $app->INETROOT.'/login');

    	};
    }


}
?>