<?php
/*#########################################################################################
#       Project       : Alfred
#       Author        : Gauthier Donikian
#       Version       : 2.0
#       Commentaire : Pour visualiser les modules comme SSH2 = phpinfo();
##########################################################################################*/
   
    //Démarrage de la session
	session_start();
	include ("./login2.php");

	//Encodage de la page
	date_default_timezone_set("Europe/Paris");
	header('Content-type: text/html; charset=UTF-8');

    //Definition des parametre de connexion la base de donnees
	include ("../../auth/authDB.php");

    //Connexion la base de données
	$pdo = new PDO("mysql:host=".SERVER.";dbname=".NAME, USER, PASSWORD);

	//Définition de l'encodage dans la BDD
	$pdo->exec("SET NAMES 'utf8'");

	$date = date('Y-m-d');
	$date_tmp = explode('-', $date);
	$_SESSION['URL'] = $_SERVER['HTTP_REFERER'];
    
    $reqs = $pdo->query('SELECT * FROM alf_port');
	    	
	while ($data = $reqs->fetch()) {
    

        if (isset($_POST['connexion'])) {
                
                    header('Location: ../portail.php');
        
                    $connection = ssh2_connect(''. $data['ip'] .'', $data['port']);
                                            ssh2_auth_password($connection, ''. $data['login'] .'', ''. $data['password'] .'');
                                            
                                            $stream = ssh2_exec($connection, 'gpio mode 1 out');

                                            $stream = ssh2_exec($connection, 'gpio write 1 1');

                                            sleep(1);

                                            $stream = ssh2_exec($connection, 'gpio write 1 0');


        }
        if (isset($_POST['ouvert'])) {
            
            header('Location: ../portail_cl.php');

            $connection = ssh2_connect(''. $data['ip'] .'', $data['port']);
                                            ssh2_auth_password($connection, ''. $data['login'] .'', ''. $data['password'] .'');

                                            $stream = ssh2_exec($connection, 'gpio mode 1 out');

                                            $stream = ssh2_exec($connection, 'gpio write 1 1');
                                            
                                            
                                            
        }
        if (isset($_POST['fermer'])) {
            
            header('Location: ../portail.php');

            $connection = ssh2_connect(''. $data['ip'] .'', $data['port']);
                                            ssh2_auth_password($connection, ''. $data['login'] .'', ''. $data['password'] .'');    

                                            $stream = ssh2_exec($connection, 'gpio mode 1 out');

                                            $stream = ssh2_exec($connection, 'gpio write 1 0');
                                            
                                            
        }
    }
?>
