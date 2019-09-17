<?php
require_once("../repository/userRepository.php");

function login($pseudo=null, $password=null){
	if($pseudo == null && $password == null){
		return cookiesLogin();
	}

	if($user = getUserByPseudoAndPassword($pseudo, $password)){
		setcookie("user", $user->getEmail(), time()+365*24*3600, null, null,false, true);
		setcookie("password", $user->getPassword(), time()+365*24*3600, null, null,false, true);
	
		//$serializedUser = serialize($user);
		// var_dump($serializedUser);die;
		$_SESSION['user']=$user;
		return true;
	}
	return false;
}

function cookiesLogin(){
	if(isset($_COOKIE['user']) && isset($_COOKIE['password'])){
		$pseudo = $_COOKIE['user'];
		$password = $_COOKIE['password'];

		if(login($pseudo, $password)){
			return true;
		}else{
			//Delete cookies
			unset($_COOKIE['user']);
			unset($_COOKIE['password']);
		}
	}

	return false;
}

function isConnected(){
	if(isset($_SESSION['user'])){
		return true;
	}
	return false;
}

function logout(){
	if(isConnected()){
		unset($_SESSION);
		session_destroy();
		setcookie('user','', time() - 3600);	
	}
}

function getConnectedUser(){
	if(isConnected()){
		return $_SESSION['user'];
	}

	return null;
}
