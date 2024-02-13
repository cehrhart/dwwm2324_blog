{extends file="views/layout.tpl"}

{block name="contenu"}
	{if (count($arrErrors) >0) }
		<div class="alert alert-danger">
		{foreach from=$arrErrors item=strError}
			<p>{$strError}</p>
		{/foreach}
		</div>
	{/if}		
	<form action="user/login" method="post" >
		<p>
			<label for="email">E-mail</label>
			<input id="email" type="email" name="email" value="" >
		</p>
		<p>
			<label for="password">Password</label>
			<input id="password" type="password" name="password">
		</p>
		<p>
			<input type="submit" value="Se connecter">
		</p>
	</form>
{/block}