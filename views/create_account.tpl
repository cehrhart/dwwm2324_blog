{extends file="views/layout.tpl"}

{block name="contenu"}
	<form action="user/create_account" method="post" >
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
			<label for="password">Mot de passe</label>
			<input type="password" name="pwd" id="password">
		</p>
		<p>
			<label for="passwd_confirm">Confirmation du mot de passe</label>
			<input type="password" name="passwd_confirm" id="passwd_confirm">
		</p>
		<!--p>
			<label for="newsletter">Inscription newsletter</label>
			<input type="checkbox" name="newsletter" id="newsletter" value="1">
		</p-->
		<p>
			<input type="submit" />
		</p>		
	</form>
{/block}