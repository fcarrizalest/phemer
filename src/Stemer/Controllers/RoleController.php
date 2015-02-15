<?php
namespace Stemer\Controllers;

class RoleController{


	public function Roles(){
        return function(){
            $app = \Slim\Slim::getInstance();
            
            $roles =  \Role::all();
            $app->render('roles' , array(
                "roles" => $roles
               
            ) );
        };
    }

     public function PostDeleteRol(){

        return function($id){
            $app = \Slim\Slim::getInstance();

            try {
                 $model = \Role::findOrFail($id);
                 $model->forceDelete();

                

            } catch (\Exception $e) {
            

            }
            $app->redirect( $app->INETROOT.'/people/roles');
        }; 
    }


    public function NewRol( ){
        return function(){
            $app = \Slim\Slim::getInstance();
            
            


            $app->render('formRole' , array( ) );
        };
    }

     public function EditRol(){

        return function($id){

            $app = \Slim\Slim::getInstance();

            try {
                
                $app->log->debug("Mira estoy por editar ");
               

                $model = \Role::findOrFail($id);


               	

                $app->render('formRole' , array( 'role' => $model  ) );

            } catch (\Exception $e) {
                
            }


          
        };
    }

    public function PostEditRol(){

        return function($id){
            $app = \Slim\Slim::getInstance();

            try {



                $data['name'] = $app->request->post('name');
                $rules['name'] = "required|unique:role";

                $app->log->debug("Ok Por editar");

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

                $model = \Role::findOrFail($id);
               
                $model->name = $app->request->post('name');
                
                

                $model->save();

               
                    
                
            } catch (\Exception $e) {
            	$app->flash("error", " " . $e->getMessage());
                
                $app->log->error( $e->getMessage()) ;
                
            }

             $app->redirect( $app->INETROOT.'/people/roles');
        };
    }

    public function PostNewRol(){
        return function(){
            $app = \Slim\Slim::getInstance();

            try {


            	$app->log->alert("Oj vamos a agrega nuevo Rol");
                

                $data['name'] = $app->request->post('name');
                $rules['name'] = "required|unique:role";

                
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
                $array['name'] = $app->request->post('name');
                


                $rol = new \Role( $array );

                $rol->save();


                


                
            } catch (\Exception $e) {

            	$app->flash("error", " " . $e->getMessage());
                
                $app->log->error( $e->getMessage()) ;
            }


            $app->redirect( $app->INETROOT.'/people/roles');

            




        };
    }



    public function Permissions(){

        return function(){
            $app = \Slim\Slim::getInstance();

            $roles = \Role::all();

            $namePerm[] = "administer permissions";
            $namePerm[] = "administer users";
            $namePerm[] = "view user profiles";

            $app->render("permissions", array( 'namePerm' => $namePerm,   'roles' => $roles ));

        };

    }

    public function PostPermissions(){
        return function (){
            $app = \Slim\Slim::getInstance();

            $post = $app->request->post( );
            unset( $post['csrf_token'] );

            foreach ($post  as $adminName => $ArrayPerm) {
                
                $rol = \Role::where('name', '=',  $adminName )->get();


                $rol[0]->permission()->forceDelete() ;
                    
                //$tm = $rol[0]->permission->toArray();
                
                foreach ($ArrayPerm as $key => $value) {
                    

                    $Permission = new \Permission(  array(
                            "rid" => $rol[0]->id,
                            "permission" => $value

                        ));

                    $Permission->save();

                }
                //$rol[0]->permission()->attach( $ArrayPerm );
                


            }


            $app->redirect( $app->INETROOT.'/people/permissions');


        };
    }



}

