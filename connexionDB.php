<?php

define("DB_USER", "root");
define("DB_PASS", "");
define("DB_HOST", "localhost");
define("DB_NAME", "extranetdb");

$message = "";
$bdd = null;
try{
    // connexion à la bdd
    $bdd = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . '',
                 '' . DB_USER . '',
                 '' . DB_PASS . '',
                 array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    // pour afficher les erreurs lors du développement
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    $message = 'Erreur : '.$e->getMessage();
}
	


