<div class="nav-scroller py-1 mb-3 border-bottom">
	<nav class="nav nav-underline justify-content-between">
		<a class="nav-item nav-link link-body-emphasis {if ($strPage == "index")} active{/if}" href="{$base_url}">Accueil</a>
		<a class="nav-item nav-link link-body-emphasis {if ($strPage == "about")} active{/if}" href="{$base_url}page/about">A propos</a>
		<a class="nav-item nav-link link-body-emphasis {if ($strPage == "blog")} active{/if}" href="{$base_url}article/blog">Blog</a>
		<a class="nav-item nav-link link-body-emphasis {if ($strPage == "contact")} active{/if}" href="{$base_url}page/contact">Contact</a>
	</nav>
</div>