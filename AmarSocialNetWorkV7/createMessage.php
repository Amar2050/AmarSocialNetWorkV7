<?php
session_start();
require_once("./manager/userManager.php");
require_once("./manager/databaseManager.php");

	// Init variables
$htmlForm = "";
$htmlBody = "";
$user=$_SESSION['user'];
var_dump($_SESSION);
$bdd=dbConnect();

$htmlForm = createHtmlForm($bdd);


if(formSelectAuthorIdIsValid()){
	$authorId = $user['id'];
	$recipienId = $_POST['recipient_id'];
	$content = $_POST['article_content'];

    $getArticlesByAuthorIdRequest = $bdd->prepare(
    "BEGIN;
  		INSERT INTO message(content, author_id) 
    		VALUES (?, ?);
  		INSERT INTO recipient_message(recipient_id, message_id) 
    		VALUES (?, LAST_INSERT_ID());
	COMMIT;"); //' OR 1='1

    $insertMessageRequestSuccess = 
    	$getArticlesByAuthorIdRequest->execute(array($content, $authorId, $recipienId));
    
    if($insertMessageRequestSuccess){
    	// $messageId = $bdd->lastInsertId();
    	// On affiche chaque entrée une à une
    	$_SESSION['author_id'] = "$authorId";
    	header("Location: ./displayMessageByAuthorId.php");
    	die;

    }else{
    	//$getArticlesByAuthorIdRequest->debugDumpParams();
    	die("Il y a une une erreur pendant l'execution de la requete : <br>");
    }
	

}

echo $htmlForm;
echo $htmlBody;

//Valid form
function formSelectAuthorIdIsValid(){
	if(!mandatoriesFieldsAreSet()){
		
		return false;
	}

	return true;
}

function mandatoriesFieldsAreSet(){
	if(isset($_POST['recipient_id']) && isset($_POST['article_content'])){
		return true;
	}

	return false;
}

function createHtmlForm($bdd){
	$htmlForm = "";
	
	// On récupère les possesseurs de jeux vidéo
	$userIdRequest = $bdd->prepare("SELECT id, firstname FROM internaut ORDER BY id");
	$userIdRequestSuccess = $userIdRequest->execute(array());

	if($userIdRequestSuccess){
		$usersArray = $userIdRequest->fetchAll();
		
		$htmlForm .= "	<form method='post'>					
						<label for='recipient_id'>Envoyer un message a :</label>
						<br>
						<select id='recipient_id' name='recipient_id' required>";
		// On crée la liste déroulante de recepteur dynamiquement
		foreach($usersArray as $recipient){
			if(isset($_POST['recipient_id']) && $_POST['recipient_id'] == $recipient['id']){
				$htmlForm .= "<option value='" .$recipient['id']."'selected>". $recipient['firstname'] . "</option>";
				continue;
			}

			$htmlForm .= "<option value='".$recipient['id']."'>". $recipient['firstname']."</option>";
		}

		$htmlForm .= "</select> 
					<br>";

	}else{
		// $authorIdRequest->debugDumpParams();
		die("Il y a une une erreur pendant la requête de création du formulaire : <br>");
	}

	// Form content
	$htmlForm .= "<label for='content'>Contenu du message</label> 
					<br>";

	if(isset($_POST['article_content'])){
		$htmlForm .= "<input id='content' type='textarea' name='article_content' value='" . $_POST['article_content'] . "' </input>";
	}else{
		$htmlForm .= "<input type='textarea' name='article_content'  </input>";
	}
	$htmlForm .= "	<br>
					<input type='submit'>
				</form>";


	return $htmlForm;
}
