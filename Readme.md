## Twitter Rest Api (Laravel - Mongo)

Para correr este proyecto necesitamos:

-Para laravel

	-PHP = 7.1
	-OpenSSL PHP Extension
	-PDO PHP Extension
	-Mbstring PHP Extension
	-Tokenizer PHP Extension
	-XML PHP Extension

-Para mongo
	[http://php.net/manual/en/mongodb.installation.php](http://php.net/manual/en/mongodb.installation.php)

-Para instalar Laravel en cualquier plataforma:
	[https://laravel.com/docs/5.4/homestead](https://laravel.com/docs/5.4/homestead)	

-Para instalar Laravel en Mac:
	[https://laravel.com/docs/5.4/valet](https://laravel.com/docs/5.4/valet)
    
-Una vez que esté clonado el proyecto y estén satisfechas todas las dependencias, en la raiz deñ proyecto hay que correr:

	$composer install (Esto descargará todas las dependencias de la aplicación)

-Se debe configurar en la raíz un .env, adjunto un ejemplo en el archivo env de la raiz

	MONGO_DB_DATABASE=nombreDB
    
-Y también podemos cambiar puerto y host en el archivo app/config/database.php

	MONGO_DB_HOST= -> host de la bd de mongo (default: 'localhost')
	MONGO_DB_PORT= -> puerto de mongo (default: 27017)
	MONGO_DB_DATABASE= -> nombre de la base de datos (REQUERIDO)
	MONGO_DB_USERNAME= -> usuario de la bd (default: vacío), no declarar en caso de no ser necesario
	MONGO_DB_PASSWORD= -> passsword de la bd (default: vacío), 
(no hay necesidad de declarar todas esas variables en el .env)	


-Las urls para acceder a los endpoints son:

-Endpoint1: http://hostname/api/twitter/search/[searchId]?start_date=[fechaUTC]&end_date=[fechaUTC]

-Endpoint2: http://hostname/api/twitter/search/[searchId]/user?start_date=[fechaUTC]&end_date=[fechaUTC]

-Endpoint3: http://hostname/api/twitter/search/[searchId]/hashtag?start_date=[fechaUTC]&end_date=[fechaUTC]

-Endpoint4: http://hostname/api/twitter/search/[searchId]/percents?start_date=[fechaUTC]&end_date=[fecha UTC]

-Ejemplo:
	http://dev.twitter/api/twitter/search/566a29efc49574777a4c9e6e/percents?start_date=2016-12-30 01:50:00.000Z&end_date=2016-03-31 21:30:00.000Z

-En la carpeta imagenes adjunto algunas pruebas.

