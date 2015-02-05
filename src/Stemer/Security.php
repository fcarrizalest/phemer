<?php

namespace Stemer;

class Security {

    public  function isLogin(){

        return function(){
            if ( !isset($_SESSION['stemer_ticket'] ) ) {
                $app = \Slim\Slim::getInstance();
                $app->flash('error', 'Login required');
                $app->redirect('./login');

                //echo "Login MAL Security";
            }


            // Tenemos el ticket Comprobamos.


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

        
        $ticket = $_SESSION['stemer_ticket'] ;

        try {
            
            $ticketO = \Ticket::where('ticketid', '=', $ticket  )->firstOrFail();
            $ticketO->touch();
            $ticketO->save();
            $app->log->alert( $ticketO->user );
            
            return $ticketO->user;

        } catch (\Exception $e) {
             unset($_SESSION['stemer_ticket'] );
             $app->log->error( "Ocurrio un error. " );
             $app->log->error( $e );
        }
        $app->redirect('./login');
        
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