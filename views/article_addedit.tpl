{extends file="views/layout.tpl"}

{block name="contenu"}
	<form action="index.php?action=addedit&ctrl=article" method="post" enctype="multipart/form-data" >
		<p>
			<label for="titre">Titre de l'article</label>
			<input id="titre" type="text" name="title" />
		</p>
		<p>
			<label for="contenu">Contenu de l'article</label>
			<textarea id="contenu" name="content" ></textarea>
		</p>
		<p>
			<label for="image">Image de l'article</label>
			<input id="image" type="file" name="image" />
		</p>
		<p>
			<input type="submit" />
		</p>
	</form>
{/block}