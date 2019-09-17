<?php
require_once("../manager/databaseManager.php");
require_once("../model/User.php");
function getUserByPseudoAndPassword($email, $password){
	$bdd = dbConnect();
	$getUserByPseudoAndPasswordRequest = $bdd->prepare(
    "SELECT * FROM internaut WHERE email = ? AND password = ? LIMIT 1;");

    $getUserByPseudoAndPasswordRequestSuccess = 
    	$getUserByPseudoAndPasswordRequest->execute(array($email, $password));

	if($getUserByPseudoAndPasswordRequestSuccess){

		if($getUserByPseudoAndPasswordRequest->rowCount() == 0){
			return null;
		}

		$internaut = $getUserByPseudoAndPasswordRequest->fetchAll()[0];

		//Creer un User à partir d'internaut
		return cursorToObject($internaut);
	

	}else{
		// $authorIdRequest->debugDumpParams();
		die("Il y a une une erreur pendant la requête de connexion <br>");
	}



}

function getUsers(){

	$bdd=dbConnect();
	$users = [];

	$getUsersRequest = $bdd->prepare(
	    "SELECT * FROM internaut"); 


    $getUsersRequestSuccess = $getUsersRequest->execute(array());
    if($getUsersRequestSuccess){
    	// On affiche chaque entrée une à une
		while ($userArray = $getUsersRequest->fetch())
		{
			$users[] = cursorToObject($userArray);
		}
		return $users;
    }else{
    	//$getUsersRequest->debugDumpParams();
    	die("Il y a une une erreur pendant l'execution de la requete : <br>");
	}
	

}

function cursorToObject(array $userArray){
	$user = new User($userArray['firstname'], $userArray['lastname'], $userArray['email'], $userArray['password']);
	$user->setId($userArray['id']);
	$user->setPhone($userArray['phone']);
	$user->setBirthdate($userArray['birthdate']);
	$user->setGender($userArray['gender']);
	return $user;

}