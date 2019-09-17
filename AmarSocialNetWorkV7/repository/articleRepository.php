<?php
require_once("../manager/databaseManager.php");
require_once("../model/Article.php");
function getArticleByAuthorId(int $authorId){

	$bdd=dbConnect();
	$articles = [];
	// $getArticlesByAuthorIdRequest = $bdd->prepare(
	//     "SELECT author.id author_id, 
	//     		author.firstname author_name, 
	//   			m.id message_id, 
	//   			m.content message_content,
	//   			m.create_at message_created_at,
	//   			rm.recipient_id recipient_id, 
	//   			recipient.firstname recipient_name

	// 	FROM internaut author 
	// 	INNER JOIN message m
	// 		ON author.id = m.author_id
	// 	INNER JOIN recipient_message rm
	// 		ON m.id = rm.message_id
	// 	INNER JOIN internaut recipient
	// 		ON recipient.id=rm.recipient_id
	// 	WHERE author.id=? || recipient.id=?
	// 	ORDER BY m.id ASC;"); 

	$getArticlesByAuthorIdRequest = $bdd->prepare(
	    "SELECT * FROM article WHERE author_id=?"); 


    $getArticlesByAuthorIdRequestSuccess = $getArticlesByAuthorIdRequest->execute(array($authorId));
    if($getArticlesByAuthorIdRequestSuccess){
    	// On affiche chaque entrée une à une
		while ($article = $getArticlesByAuthorIdRequest->fetch())
		{
			$createdAtArticleDatetime = new DateTime($article['create_at']);
			$articles[] = new Article($article["id"], $article["content"], $createdAtArticleDatetime, $article["author_id"]);

		}
		return $articles;
    }else{
    	//$getArticlesByAuthorIdRequest->debugDumpParams();
    	die("Il y a une une erreur pendant l'execution de la requete : <br>");
    }

}

