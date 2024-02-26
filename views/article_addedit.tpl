{extends file="views/layout.tpl"}

{block name="contenu"}
	{if (count($arrErrors) >0) }
		<div class="alert alert-danger">
		{foreach from=$arrErrors item=strError}
			<p>{$strError}</p>
		{/foreach}
		</div>
	{/if}	
	<form action="article/addedit{if (isset($smarty.get.id) && $smarty.get.id != '' )}?id={$smarty.get.id}{/if}" method="post" enctype="multipart/form-data" >
		<p>
			<label for="titre">Titre de l'article</label>
			<input id="titre" type="text" name="title" value="{$objArticle->getTitle()}" />
		</p>
		<p>
			<label for="contenu">Contenu de l'article</label>
			<textarea id="contenu" name="content" >{$objArticle->getContent()}</textarea>
		</p>
		<p>
			<label for="image">Image de l'article</label>
			{if $objArticle->getImg() != ""}
			<img src="uploads/{$objArticle->getImg()}">
			{/if}
			<!-- input id="image" type="file" name="image[]" multiple /-->
			<input id="image" type="file" name="image" />
		</p>
		<p>
			<input type="submit" />
		</p>
	</form>
{/block}