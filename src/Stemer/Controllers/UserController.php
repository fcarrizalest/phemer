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

    public function ApiPeople(){
        return function(){
            $app = \Slim\Slim::getInstance();
            $app->response->headers->set('Content-Type', 'application/json');
            $users =  \User::all( array('id', 'username' ) );

            echo $users;

        };
    }

    public function OwnProfile(){
        return function () { 

            $app = \Slim\Slim::getInstance();
            $app->render('profile' );
            


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
            $roles = array();

            try {
                $roles = \Role::all();

            } catch (\Exception $e) {
                
            }
            


            $app->render('formUser' , array(
                "roles" => $roles,
                "useroles" => array()
              
               
            ) );
        };
    }

     public function EditUser(){

        return function($id){

            $app = \Slim\Slim::getInstance();

            try {
                
                $roles = array();
                try {
                    $roles = \Role::all();

                } catch (\Exception $e) {
                
                }

                $model = \User::findOrFail($id);

                $rol =  $model->roles;
                $array = array();
                if($rol)
                    foreach ($rol  as $o ) {
                        $array[ ] = $o->name;

                    }

               

                $app->render('formUser' , array( 'useroles' => $array , 'user' => $model  , 'roles' => $roles ) );

            } catch (\Exception $e) {
                
            }


          
        };
    }

    public function PostEditUser(){

        return function($id){
            $app = \Slim\Slim::getInstance();

            try {



                $data['username'] = $app->request->post('username');
                $rules['username'] = "required";

                if($app->request->post('password')  ){
                     $data['password'] = $app->request->post('password') ;
                     $rules['password'] = "required|min:2";
                }
               
                $data['email'] =  $app->request->post('email') ;
                $rules['email'] = "required|email";


                $validator = $app->Validator->make( $data, $rules ) ;

                if ($validator->fails())
                {
                    // The given data did not pass validation
                    $messages = $validator->messages();
                    $m = " ";
                    foreach ($messages->all('<li>:message</li>') as $message)
                    {
                        $m .= $message;
                    }
                    
                    throw new \Exception($m , 1);
                    
                }

                $model = \User::findOrFail($id);
                $salt = $app->salt ;
                $model->username = $app->request->post('username');
                
                if($app->request->post('password')  )
                    $model->password = sha1( $salt.$app->request->post('password'));

                $model->email = $app->request->post('email');
                $model->active  = true;

                $model->save();

                // necesito quitar las relaciones de roles
                 $rol =  $model->roles;
                $array = array();
                if($rol)
                    foreach ($rol  as $o ) {
                        $model->roles()->detach($o->id);

                    }

                $r = $app->request->post("role");
                
                if( isset( $r) && is_array( $r ) )
                    $model->roles()->attach($r);
                    
                
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

                $data['username'] = $app->request->post('username');
                $rules['username'] = "required|unique:users";

                $data['password'] = $app->request->post('password') ;
                $rules['password'] = "required|min:2";
                
               
                $data['email'] =  $app->request->post('email') ;
                $rules['email'] = "required|email|unique:users";

                $messages = array(
                    'required' => 'El :attribute es obligatorio.',
                    'unique'  => "El :attribute ya existe "
                );
                $validator = $app->Validator->make( $data, $rules  ) ;

                if ($validator->fails())
                {
                    // The given data did not pass validation
                    $messages = $validator->messages();
                    $m = " ";
                    foreach ($messages->all(":message ") as $message)
                    {
                        $m .= $message ;
                    }
                    
                    throw new \Exception($m , 1);
                    
                }

                // @TODO Validar los datos de entrada..
                $array['username'] = $app->request->post('username');
                $array['password'] = sha1( $salt.$app->request->post('password'));

                $array['email'] = $app->request->post('email');
                $array['active'] = true;


                $user = new \User( $array );

                $user->save();


                // Agregamos los roles

                $r = $app->request->post("role");
                
                if( isset( $r) && is_array( $r ) )
                    $user->roles()->attach($r);


                
            } catch (\Exception $e) {

            	$app->flash("error", " " . $e->getMessage());
                
                $app->log->error( $e->getMessage()) ;
            }


            $app->redirect( $app->INETROOT.'/people');

            




        };
    }



}

