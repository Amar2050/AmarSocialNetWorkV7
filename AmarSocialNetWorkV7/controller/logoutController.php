<?php
session_start();
require_once("../manager/userManager.php");
logout();
header('Location: ./login');
