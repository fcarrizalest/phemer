
INSTALL
Ejecutar desde la consola  el siguiente comando para
la instalación de composer

		curl -s https://getcomposer.org/installer | php

Una vez que composer esta instalado instalar las dependencias.

php composer.phar install


Editar el .htacces si es necesario modificar el basepath


Instalación de las Tablas....

1.- Editar el archivo phinx.yml

2.- En la seccion de production, ingresar los datos necesarios para la conexion a la base de datos.

3.- Cambiar defaul_databases de development a production.

4.- Ejecutar el siguiente comando 


	 php ./vendor/bin/phinx  test

	 php ./vendor/bind/phinx migrate

Referencias: 

		http://phinx.readthedocs.org/

		http://www.simpletest.org/en/unit_test_documentation.html


Utilerias

		http://pythonhosted.org//watchdog/


		watchmedo shell-command --patterns="*.php;*.js;*.html"  --recursive --command 'php ./test/bootstrap.php '
		




ChangeLog
