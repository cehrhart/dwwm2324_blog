{extends file="views/layout.tpl"}

{block name="contenu"}
	<form action="user/doResetPwd" method="post" >
		<p>
			<label for="password">Nouveau mot de passe</label>
			<input type="password" name="pwd" id="password">
		</p>
		<p>
			<label for="passwd_confirm">Confirmation du mot de passe</label>
			<input type="password" name="passwd_confirm" id="passwd_confirm">
		</p>
		<p>
			<input type="submit" />
		</p>		
	</form>
{/block}