<?php

namespace Stemer;

class Security {

    public  function isLogin(){

        return function(){
            $app = \Slim\Slim::getInstance();
            if ( !isset($_SESSION['stemer_ticket'] ) ) {
                
                //$app->flash('error', 'Login required');
                
                $app->redirect( $app->INETROOT.'/login');

                //echo "Login MAL Security";
            }

            $secure = new \Stemer\Security();
            
            $user =  $secure->CheckTicket();

            $app->_user = $user;
            $app->_permission = $user->getPermissionArray();
            

            $app->view->set("username" , $user->username );
            $app->view->set("permission" , $app->_permission );

            // Tenemos el ticket Comprobamos.



        };

    }

    public function checkPermission( $key ){

        return function( ) use ($key ){
            $app = \Slim\Slim::getInstance();
            if( !in_array($key, $app->_permission ) )
                $app->halt(403, 'You shall not pass!');

        };

    }
    public function doLogin( $model ){

        require_once dirname( __FILE__ ).'/Models/Ticket.php';

        $ticket = $this->RandomString();
        $app = \Slim\Slim::getInstance();
        $req = $app->request;
    
   
        $ti = new \Ticket(array(
                "ticketid" => $ticket,
                "uid" => $model->id,
                "clientip" =>  $req -> getIp()
            ));

        $app->log->error("Creamos un ticket: " .  $ticket );
        $ti->save() ;
        $_SESSION['stemer_ticket'] =  $ticket ;

           

        


  
    }

    public function CheckTicket( ){
        $app = \Slim\Slim::getInstance();
        $req = $app->request;

        
        $ticket = $_SESSION['stemer_ticket'] ;

        try {
            
            $ticketO = \Ticket::where('ticketid', '=', $ticket  )->where('clientip','=',$req -> getIp() )->firstOrFail();
            $ticketO->touch(); 
            $ticketO->save();
            $app->log->alert( $ticketO->user );
            
            $ticketD = \Ticket::where('uid', '=', $ticketO->user->id  )
                                ->where('ticketid', '!=', $ticket );
            
            if(count($ticketD) > 0)
                $ticketD->forceDelete();
            
            return $ticketO->user;

        } catch (\Exception $e) {
             unset($_SESSION['stemer_ticket'] );
             $app->log->error( "Ocurrio un error. " );
             $app->log->error( $e );
              $app->flash("error", " " . $e->getMessage());
                
               
        }
        $app->redirect( $app->INETROOT.'/login');
        
    }

    private function RandomString(){
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randstring = ' ';
        for ($i = 0; $i < 20; $i++) {
            $randstring .= $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    
    }

}


?>