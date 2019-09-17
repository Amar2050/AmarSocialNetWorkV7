<?php
$uri = $_SERVER['REQUEST_URI'];
var_dump($uri);

if(match($uri, "/")){
    header("Location: ./welcome");
    die;
}

if(match($uri,"/welcome")){
    require("../controller/welcomeController.php");
    die;
}

if(match($uri,"/login")){
    require("../controller/loginController.php");
    die;
}
if(match($uri,"/logout")){
    require("../controller/logoutController.php");
    die;
}
if(match($uri, "/articles/author/:id")){
    $id= explode($uri,"/");
    require("../controller/displayArticlesByAuthorIdController.php");
    die;
}
if(match($uri,"/login")){
    require("../controller/loginController.php");
    die;
}
if(match($uri,"/protected")){
    require("../controller/protectedController.php");
    die;
}

echo "Cette page n'existe pas";


function match($url, $route){
    $path = preg_replace('#:([\w]+)#', '([^/]+)', $route);
    $regex = "#^$path$#i";
    if(!preg_match($regex, $url, $matches)){
        return false;
    }
    return true;
}

