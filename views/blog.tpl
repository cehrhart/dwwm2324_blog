{extends file="views/layout.tpl"}

{block name="js_head" append}
	<script src="assets/js/period.js"></script>
{/block}

{block name="js_footer" append}
<script>
	changePeriod();
</script>	
{/block}

{block name="contenu"}
<div class="row mb-2">
	{if isset($user.user_id) && $user.user_id != ''}
	<a href="article/addedit" alt="Ajouter un article">Ajouter un article</a>
	{/if}
	<form name="formSearch" method="post" action="#">
		<fieldset>
			<legend>Rechercher des articles</legend>
			<p><label for="keywords">Mots clés</label>
				<input id="keywords" type="text" name="keywords" value="{$strKeywords}" />
			</p>
			<p>	<input type="radio" name="period" {if ($intPeriod) == 0}checked{/if} value="0" onclick="changePeriod()" /> Par date exacte
				<input type="radio" name="period" {if ($intPeriod) == 1}checked{/if} value="1" onclick="changePeriod()" /> Par période
			</p>
			<p id="uniquedate">
				<label for="date">Date</label>
				<input id="date" type="date" name="date" value="{$strDate}" />
			</p>
			<p id="period">
				<label for="startdate">Date de début</label>
				<input id="startdate" type="date" name="startdate" value="{$strStartDate}" />
				<label for="enddate">Date de fin</label>
				<input id="enddate" type="date" name="enddate" value="{$strEndDate}" />
			</p>
			<p>
				<label for="author">Auteur</label>
				<select id="author" name="author">
					<option value="" >--</option>
					{foreach from=$arrUsersToDisplay item=objUser}
					<option {if ($intAuthor) == $objUser->getId()}selected{/if} value="{$objUser->getId()}" >{$objUser->getFirstname()}</option>
					{/foreach} 					
				</select>
			</p>
			<p><input type="submit" value="Rechercher" /> <input type="reset" value="Réinitialiser" /></p>
		</fieldset>
	</form>
			
	{foreach from=$arrArticlesToDisplay item=objArticle}
		{include file="views/article.tpl"}
	{foreachelse}
		<p>Pas de résultat</p>
	{/foreach} 
			</div>
{/block}			
