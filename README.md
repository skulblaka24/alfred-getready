##############################################

				AlfredBrain

##############################################

	Liens utiles:
		- Get docker conteneur's ip: 
		http://networkstatic.net/10-examples-of-how-to-get-docker-container-ip-address/

	Cmd utiles:
		$ docker-compose up -d
		$ mysqlshow -h localhost -u root -p alfdb
		$ mysql -h localhost -u root -p < /dump/dump_mysql.sql
		DROP DATABASE alfdb;
		CREATE DATABASE alfdb;
		SHOW TABLES;
		USE alfdb;
		FLUSH PRIVILEGES;
		SELECT * FROM alf_users;

		docker ps
		docker ps -a
		docker stop $(docker ps -a -q)
		docker rm $(docker ps -a -q)
		docker rmi $(docker images)
		docker logs 96771aff5310

##############################################
A faire:

- Conteneur pour le service ping du site avec lancement de script en background
	--> https://openclassrooms.com/courses/reprenez-le-controle-a-l-aide-de-linux/executer-des-programmes-en-arriere-plan

- Support de l'ARM: -- CHECK
	--> /src/pour_modif_les_images
	--> https://github.com/cmoro-deusto/docker-rpi-mysql

- ARM: Problème d'images dans le site: pas un problème de permission -- CHECK
- ARM: Problème de auth db dans settings à corriger -- CHECK




Commit: 
02/12/16 : Vérification des versions x86 et arm -- Tri effectué et mise en place de la version principale.
15/11/16 : Création user admin on arm et modification authDB -- Connexion à l'interface fonctionne !!
	   J’ai changé le propriétaire et le groupe dans le container sql, pour le dossier de table sql avec chown -R mysql:mysql. Il trouve la bonne table
	   J’ai changé hash(sha1($password)) to hash (sha1, $password) Il affichait l’erreur: Uncaught Error: Call to a member function fetch() on boolean   

07/10/16 : Création du docker-compose et des images pour arm

26/09/16 : Création du docker-compose et dépendances pour X86

##############################################

				Composition

##############################################

Encrypted:

<pre><code>./docker-compose_arm.yml
./docker-compose_x86.yml
./src/keys/server.*
./src/mysql/dump/dump_*
./src/www_rpi/auth/authDB.php 
./src/www/auth/authDB.php 
./src/mysql/data_rpi/dump_mysql.sql
./src/mysql/data_rpi/alfdb/alf_users.frm 
./src/mysql/data/alfdb/alf_users.frm 
./src/mysql/data/alfdb/alf_users.ibd 
</pre></code>

APACHE 2:
	
	- mods-enabled: dossier pour loader le module ssl d'apache après $ a2enmod

	- sites-available: dossier pour les virtualhosts disponible

	- sites-enabled: dossier pour les virtualhosts disponible après $ a2ensite

KEYS:
	
	Ce sont les clés pour le support du ssl


PHP:

	conf: Correspond à /usr/local/etc/php/conf.d
		  Dossier avec les fichiers de conf pour les extensions de php.ini (ex: ssh2.ini)

	conf_rpi: Correspond à /usr/local/etc/php/conf.d
		  Dossier avec les fichiers de conf pour les extensions de php.ini (ex: ssh2.ini)
		  Mais avec mysql.ini de desactivé car php n'est a pas besoin dans ma conf arm.

	modules: Correspond à /usr/local/lib/php/extensions/no-debug-non-zts-20151012
			 Dossier avec les modules disponible pour php (ex: ssh2.so)

	modules_rpi: Correspond à /usr/local/lib/php/extensions/no-debug-non-zts-20151012
			 Dossier avec les modules disponible pour php (ex: ssh2.so)
			 mais compilé sur arm.

MYSQL:

	data: Correspond à /var/lib/mysql/
		  Configuration du serveur mysql

	data_rpi: Correspond à /var/lib/mysql/ pour le container arm
		  Configuration du serveur mysql
		  Owner: messagebus

	dump: Correspond à /dump
		  Premier dump injecté dans la base

WWW:

	Correspond à /var/www/html/
	Dossier avec le site internet

	En caché: .htaccess pour rediriger le serveur http --> https

WWW_rpi:

	Correspond à /var/www/html/
	Dossier avec le site internet

	En caché: .htaccess pour rediriger le serveur http --> https

	Avec des access différents pour la BDD.

################################################

				Prerequis ARM

################################################

The volume destinated for the db (/var/lib/mysql) should have one db only (alfdb). The permissions should be messagebus:messagebus pour tous.
You need to keep in the folder: alfdb  dump_mysql.sql  ibdata1  ib_logfile0  ib_logfile1.

Dans le conteneur, il est necessaire que messagebus devienne mysql

$ chown -R messagebus:messagebus /var/lib/mysql/*
