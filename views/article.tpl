<article class="col-md-6">
	<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
		<div class="col p-4 d-flex flex-column position-static">
			<h3 class="mb-0">{$objArticle->getTitle()}</h3>
			<div class="mb-1 text-body-secondary">
				{$objArticle->getCreatedateFr()}
				({$objArticle->getCreator()})
			</div>
			<p class="mb-auto">
				{$objArticle->getContentSummary(ArticleCtrl::MAX_CONTENT)}
			</p>
			<a href="#" class="icon-link gap-1 icon-link-hover stretched-link">Lire la suite</a>
		</div>
		<div class="col-auto d-none d-lg-block">
			<img class="bd-placeholder-img" width="200" height="250" 
				alt="{$objArticle->getTitle()}" 
				src="assets/images/{$objArticle->getImg()}">
		</div>
	</div>
</article>
