<?php

use Phinx\Migration\AbstractMigration;
use Symfony\Component\Yaml\Parser;

class Inicial extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */
    
    /**
     * Migrate Up.
     */
    public function up(){


        $table = $this->table('users');
        
        $table->addColumn('username' , 'string', array('limit' => 144 , 'null' => false));
        $table->addColumn('email' , 'string' , array('limit' => 255 ));
        $table->addColumn('password' , 'text'  );
        $table->addColumn('active','boolean' );

        $table->addColumn('created_at' , 'datetime'  );
        $table->addColumn('updated_at' , 'datetime' );
        

        $table->addIndex(array('username', 'email'), array('unique' => true));
   

        $table->save();
        
        $table = $this->table('role');

        $table->addColumn('name', 'string' , array('limit' => 144));

        $table->save();


        $table = $this->table('users_roles');
        $table->addColumn('uid', 'integer')
        ->addColumn('rid', 'integer')
        ->addForeignKey('uid', 'users', 'id')
        ->addForeignKey('rid', 'role', 'id' );


        $table->save();


        $table = $this->table('tickets');

        $table->addColumn('ticketid', 'text' );

        $table->addColumn('uid', 'integer' );

        $table->addColumn('clientip', 'string', array('limit' => 40 , 'null' => false) );


        $table->addColumn('logon', 'datetime' );

        $table->addColumn('created_at' , 'datetime'  );
        $table->addColumn('updated_at' , 'datetime' );
        
        $table ->addForeignKey('uid', 'users', 'id');
       
        $table->save();


        $table = $this->table('role_permission');

        $table->addColumn('rid', 'integer' );
        $table->addColumn('permission', 'string' , array( 'limit' => 128 , 'null' => false ) );

        $table ->addForeignKey('rid', 'role', 'id');

        $table->save();


        


        $yaml = new Parser();

        $value = $yaml->parse(file_get_contents("./phinx.yml"));

        $salt = $value['salt'];

        $pass = sha1( $salt."00" );

        $db = $value['environments'][$value['environments']['default_database'] ]['name']; 


        $sql = "INSERT INTO `".$db."`.`users` (`id`, `username`, `email`, `password`, `active`, `created_at`, `updated_at`) VALUES 

                                            (NULL, 'admin', 'admin@domain.com', '".$pass."', '1', '2015-02-02 00:00:00', '2015-02-02 00:00:00'); " ;
        
        $count = $this->execute( $sql ); // returns the number of affected rows




        $sql = "INSERT INTO `".$db."`.`role` (`id`, `name`) VALUES (NULL, 'admin');";

        $count = $this->execute( $sql ); // returns the number of affected rows

        // Agregamos


        $sql = "INSERT INTO `".$db."`.`users_roles` (`id`, `uid`, `rid`) VALUES (NULL, '1', '1'); ";
        
        $count = $this->execute( $sql ); // returns the number of affected rows



    }

    /**
     * Migrate Down.
     */
    public function down()
    {   
        $this->dropTable('role_permission');
        $this->dropTable('tickets');
        $this->dropTable('users_roles');
        $this->dropTable('users');
        $this->dropTable('role');
    }
}