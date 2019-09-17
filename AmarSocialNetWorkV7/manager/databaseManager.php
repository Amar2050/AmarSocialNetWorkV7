<?php
/* This works too in order to declare const variables */
// define("DB_NAME", "social_network_v4");
// define("DB_HOST", "localhost");
// define("DB_USER", "root");
// define("DB_PASSWORD", "");

const DB_NAME = "social_network_v4";
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASSWORD = "";
dbConnect();

function dbConnect(){
	try
	{
		// On se connecte à MySQL
		$bdd = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";
						charset=utf8", 
						DB_USER, DB_PASSWORD);
	}
	catch(Exception $e)
	{
		// En cas d'erreur, on affiche un message et on arrête tout
	        die('Erreur : '.$e->getMessage());
	}
	return $bdd;
}