<?php
session_start();
require_once("../model/Article.php");
require_once("../repository/articleRepository.php");
require_once("../repository/userRepository.php");
$selectedUserId = null;
$articles = [];
if(isset($_SESSION['author_id'])){
    $selectedUserId = $_SESSION['author_id'];
}else if (isset($_POST['author_id'])){
    $selectedUserId = $_POST['author_id'];
}

if($selectedUserId != null){
    $articles = getArticleByAuthorId($selectedUserId);
}
$users = getUsers();




include("../view/displayArticleByAuthorIdView.php");