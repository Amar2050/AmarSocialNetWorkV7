<?php
session_start();
require_once("../manager/userManager.php");

if(!isConnected()){
	$_SESSION['alert_message']="Vous devez être co pour accéder à cette page";
	$_SESSION['redirected_uri']=$_SERVER['REQUEST_URI'];
	header('Location: ./login');
	die;	
}

include ("../view/protectedView.php");