{extends file="views/layout.tpl"}

{block name="contenu"}
	<div class="alert alert-info">
		Saisissez votre mail pour recevoir un lien de génération de mot de passe
	</div>

	<form action="{$base_url}user/forgetPwd" method="post" >
		<p>
			<label for="email">E-mail</label>
			<input id="email" type="email" name="email" value="" >
		</p>
		<p>
			<input type="submit" value="Envoyer">
		</p>
	</form>
{/block}