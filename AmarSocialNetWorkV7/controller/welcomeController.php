<?php
require_once("../model/User.php");
session_start();
require_once("../manager/userManager.php");

$user = getConnectedUser();

include("../view/welcomeView.php");