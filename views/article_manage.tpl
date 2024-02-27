{extends file="views/layout.tpl"}

{block name="js_head"}
	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css" />
	<script src="https://code.jquery.com/jquery-3.7.1.js"> </script>
	<script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js" ></script>
{/block}

{block name="contenu"}
	<table id="list_article">
		<thead>
			<tr>
				<th>id</th>
				<th>img</th>
				<th>titre</th>
				<th>contenu</th>
				<th>validé</th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
			{* mode PHP fonctionne aussi :D *}
			{foreach $arrArticlesToDisplay as $objArticle}
			<tr>
				<td>{$objArticle->getId()}</td>
				<td><img class="img-thumbnail" src="uploads/{$objArticle->getImg()}" alt="{$objArticle->getTitle()}" ></td>
				<td>{$objArticle->getTitle()}</td>
				<td>{$objArticle->getContent()}</td>
				<td>{if $objArticle->getValid()}oui{else}non{/if}</td>
				<td>
					<a class="btn btn-primary" href="article/addedit?id={$objArticle->getId()}" alt="Modifier l'article"><i class="fa fa-edit"></i></a>
					{if (isset($smarty.session.user.user_id) && $smarty.session.user.user_role == "modo")}
					<a class="btn btn-secondary" href="article/read?id={$objArticle->getId()}" alt="Modérer l'article">Modérer l'article</a>
					{/if}
					<a class="btn btn-danger" href="article/delete?id={$objArticle->getId()}" alt="Supprimer l'article"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/block}

{block name="js_footer"}
	<script>
		new DataTable('#list_article');
	</script>
{/block}