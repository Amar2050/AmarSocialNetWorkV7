<?php
session_start();
require_once("../model/User.php");
require_once("../manager/userManager.php");
//Valid form
function formConnexionIsValid(){
	if(!mandatoriesFieldsAreSet()){
		return false;
	}
	$email = $_POST['email'];

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	return false;
    }

    if(strlen($email)>30){
    	return false;
    }

	return true;
}

function mandatoriesFieldsAreSet(){
	if(isset($_POST['email']) && isset($_POST['password'])){
		return true;
	}

	return false;
}


if(isConnected()){
	header('Location: ./welcome');
	die;
}

if(login()){
	$message = "Bravo, vous êtes bien connecté via cookie !";
	echo $message;
	die;
}


if(formConnexionIsValid()){
	// Init variables
	$pseudo = $_POST['email'];
	$password = $_POST['password'];

	if(login($pseudo, $password)){
		if(isset($_SESSION['redirected_uri'])){
			header("Location: " . $_SESSION['redirected_uri']);
			unset($_SESSION['redirected_uri']);
		}else{
			header('Location: ./welcome');
		}
		die;
	}else{
		$message = "Pseudo ou mot de passe incorrect";
		echo $message;
	}

}

if(isset($_SESSION['alert_message'])){
	echo $_SESSION['alert_message'];
	unset($_SESSION['alert_message']);
}

require_once("../view/loginView.php");