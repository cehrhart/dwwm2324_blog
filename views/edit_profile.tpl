{extends file="views/layout.tpl"}

{block name="contenu"}
	<form action="user/edit_profile" method="post" >
		<fieldset>
			<legend>Informations personnelles</legend>
			<p>
				<label for="name">Nom</label>
				<input type="text" name="name" id="name" value="{$objUser->getName()}">
			</p>
			<p>
				<label for="firstname">Prénom</label>
				<input type="text" name="firstname" id="firstname" value="{$objUser->getFirstname()}">
			</p>
			<p>
				<label for="mail">Email</label>
				<input type="email" name="mail" id="mail" value="{$objUser->getMail()}">
			</p>
			<p>
				<label for="pseudo">Pseudo</label>
				<input type="text" name="pseudo" id="pseudo" value="{if isset($smarty.cookies.pseudo)}{$smarty.cookies.pseudo}{/if}">
			</p>
		</fieldset>
		<fieldset>
			<legend>Informations de connexion</legend>
			<p>
				<label for="password_old">Mot de passe actuel</label>
				<input type="password" name="oldpwd" id="password_old">
			</p>
			<p>
				<label for="password">Nouveau mot de passe</label>
				<input type="password" name="pwd" id="password">
			</p>
			<p>
				<label for="passwd_confirm">Confirmation du mot de passe</label>
				<input type="password" name="passwd_confirm" id="passwd_confirm">
			</p>
		</fieldset>
		<p>
			<input type="submit" />
		</p>		
	</form>
{/block}