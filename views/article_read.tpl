{extends file="views/layout.tpl"}

{block name="contenu"}
	{*assigner des variables en direct*}
	{assign var="modo" value=(isset($user.user_role) 
			&& ($user.user_role == "modo" || $user.user_role == "admin") )}

	<div class="row">
		<div class="col-{if ($modo) }6{else}12{/if}">
			<h2>{$objArticle->getTitle()}</h2>
			<p>{$objArticle->getContent()}</p>
			<img src="uploads/{$objArticle->getImg()}" alt="{$objArticle->getTitle()}" >
		</div>
		{if ($modo) }
		<div class="col-6">
			<h2>Modération</h2>
			<form method="post" action="article/read?id={$objArticle->getId()}">
				<p>
					<label>Accepté</label>
					<input type="radio" name="moderation" value="1" {if ($objArticle->getValid() == 1) } checked {/if} > Oui
					<input type="radio" name="moderation" value="0" {if ($objArticle->getValid() == 0) } checked {/if} > Non
				</p>
				<p>
					<label>Commentaire</label>
					<textarea name="comment">{$objArticle->getComment()}</textarea>
				</p>
				<input type="submit" >
			</form>
		</div>
		{/if}
{/block}