<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use Symfony\Component\Yaml\Parser;


$yaml = new Parser();

$value = $yaml->parse(file_get_contents('./phinx.yml'));

$db['driver'] = $value['environments'][$value['environments']['default_database'] ]['adapter']; 
$db['host'] = $value['environments'][$value['environments']['default_database'] ]['host']; 
$db['database'] = $value['environments'][$value['environments']['default_database'] ]['name']; 
$db['username'] = $value['environments'][$value['environments']['default_database'] ]['user']; 
$db['password'] = $value['environments'][$value['environments']['default_database'] ]['pass']; 
$db['charset'] = 'utf8';
$db['collation'] = 'utf8_general_ci';

$salt = $value['salt'];


$capsule = new Capsule();

$capsule->addConnection( $db);


// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$app = new \Slim\Slim(array(
         'view' => new \Slim\Views\Blade(),
         'templates.path' => './templates'
    ));


$app->salt = $salt ;

$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => 'cha',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));

$view = $app->view();
$view->parserOptions = array(
    'debug' => $value['debug'],
    'cache' => dirname(__FILE__) . '/cache'
);

?>