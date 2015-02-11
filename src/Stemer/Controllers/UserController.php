<?php
namespace Stemer\Controllers;

class UserController{


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
            $app->redirect( $app->INETROOT.'/people');
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
            	$app->flash("error", " " . $e->getMessage());
                
                $app->log->error( $e->getMessage()) ;
                
            }

             $app->redirect( $app->INETROOT.'/people');
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

            	$app->flash("error", " " . $e->getMessage());
                
                $app->log->error( $e->getMessage()) ;
            }


            $app->redirect( $app->INETROOT.'/people');

            




        };
    }



}

