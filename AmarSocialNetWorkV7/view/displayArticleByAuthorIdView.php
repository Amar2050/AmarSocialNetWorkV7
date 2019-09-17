
<form method='post'>
    <label for='author_id'>Id du author</label>
    <select id='author_id' name='author_id' required>";
<?php
	// On crée la liste déroulante dynamiquement
	foreach($users as $user)
	{
		if(isset($selectedUserId) && $selectedUserId == $user->getId()){
			echo "<option value='" . $user->getId() . "'selected>". $user->getFirstname() . "</option>";		
		}else{
			echo "<option value='". $user->getId() ."'>". $user->getFirstname() ."</option>";
		}
	}
?>

    </select> 
    <br>
    <br>
	<input type='submit'>
</form>
            

<?php
foreach($articles as $article){
    echo "ArticleId : " . $article->getId() . "<br>
                    Created_at : " . $article->getCreatedAt()->format('Y-m-d H:i:s') . "<br>
                    message_content : " . $article->getContent() . "<br>
                    author_id : " . $article->getAuthorId() . "<br>" .
                    "<br> <br>"
                    ;

}


