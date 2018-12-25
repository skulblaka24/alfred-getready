<?php
// Is PDO installed?
if (!defined('PDO::ATTR_DRIVER_NAME')) {
echo 'PDO is unavailable<br/>';
}
elseif (defined('PDO::ATTR_DRIVER_NAME')) {
echo 'PDO is available<br/>';
}

const SERVER = "172.17.0.2";
const USER = "root";
const PASSWORD = "password";
const NAME = "alfdb";

//Connexion à la base de données
$pdo = new PDO('mysql:host='.SERVER.';dbname='.NAME, USER, PASSWORD);
//$pdo = new PDO('mysql:host=localhost;dbname=alfdb','root','password');
/*
function connect($server,$user,$mdp,$db,&$bdd)
{
try
{
    $bdd = new PDO('mysql:host='.$server.';dbname='.$db.'', $user, $mdp);
}
catch (Exception $e)
{
        die('Erreur  : ' . $e->getMessage());
}
}
$bdd='';
connect('localhost','root','','password',$bdd);
*/
phpinfo();

?>

