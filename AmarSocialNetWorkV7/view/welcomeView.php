<?php


if(isset($user)){
    echo "Bonjour " . $user->getFirstname();
}else{
    echo "Bonjour";
}