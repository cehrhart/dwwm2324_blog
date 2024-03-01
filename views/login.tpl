{extends file="views/layout.tpl"}

{block name="contenu"}

	<form action="{$base_url}user/login" method="post" >
		<input type="hidden" name="csrf" value="{$csrf}">
		<p>
			<label for="email">E-mail</label>
			<input id="email" type="email" name="email" value="{$email}" >
		</p>
		<p>
			<label for="password">Password</label>
			<input id="password" type="password" name="password">
		</p>
		<p>
			<input type="submit" value="Se connecter">
		</p>
	</form>
	
	<p><a href="{$base_url}user/forgetPwd">Mot de passe oublié</a></p>
{/block}