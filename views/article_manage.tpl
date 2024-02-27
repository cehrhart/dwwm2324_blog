{extends file="views/layout.tpl"}

{block name="js_head"}
	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" />
	<script src="https://code.jquery.com/jquery-3.7.1.js"> </script>
	<script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js" ></script>
	<script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
	
	<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
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
				<td><img class="img-thumbnail convertTo64" src="uploads/{$objArticle->getImg()}" alt="{$objArticle->getTitle()}" ></td>
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
	{literal}
	<script>
	var table = new DataTable('#list_article', {
		layout: {
			topStart: {
				buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
			}
		},
		language: {
			url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/fr-FR.json',
		},
		columns: [{width: '5%'}, {width: '10%'}, {width: '35%'}, {width: '35%'}, {width: '5%'}, {width: '10%'}],
		ordering:  false,
		
	});
	</script>
	{/literal}
{/block}