{extends file="views/layout.tpl"}

{block name="contenu"}
	<div class="row mb-2">
	{foreach from=$arrArticlesToDisplay item=objArticle}
		{include file="views/article.tpl"}
	{/foreach} 
	
	</div>
{/block}