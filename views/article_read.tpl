{extends file="views/layout.tpl"}

{block name="contenu"}
	<div class="row">
		<div class="col-6">
			<h2>{$objArticle->getTitle()}</h2>
			<p>{$objArticle->getContent()}</p>
			<img src="uploads/{$objArticle->getImg()}" alt="{$objArticle->getTitle()}" >
		</div>
		<div class="col-6">
		{if (isset($smarty.session.user.user_role) 
			&& ($smarty.session.user.user_role == "modo" || $smarty.session.user.user_role == "admin") ) }
		<h2>Modération</h2>
		<form method="post" action="article/read?id={$objArticle->getId()}">
			<p>
				<label>Accepté</label>
				<input type="radio" name="moderation" value="1"> Oui
				<input type="radio" name="moderation" value="0"> Non
			</p>
			<p>
				<label>Commentaire</label>
				<textarea name="comment"></textarea>
			</p>
			<input type="submit" >
		</form>
		{/if}
		</div>
{/block}