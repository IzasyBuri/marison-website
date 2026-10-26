<?php
/**
 * Title: Marison Article Archive Content
 * Slug: marison/article-archive-content
 * Description: Native Article archive structure with localized introduction, Query Loop, pagination, and housing discovery CTA.
 * Categories: marison-articles
 * Inserter: true
 */
?>
<!-- wp:group {"align":"full","className":"marison-article-archive marison-surface--cream","layout":{"type":"constrained"}} -->
<main class="wp-block-group alignfull marison-article-archive marison-surface--cream">
	<!-- wp:group {"align":"wide","className":"marison-article-archive__intro-wrap","layout":{"type":"constrained"}} -->
	<section class="wp-block-group alignwide marison-article-archive__intro-wrap">
		<!-- wp:marison/article-archive-copy {"variant":"intro"} /-->
	</section>
	<!-- /wp:group -->

	<!-- wp:query {"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":true},"displayLayout":{"type":"flex","columns":3}} -->
	<div class="wp-block-query">
		<!-- wp:post-template -->
			<!-- wp:marison/article-card /-->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:marison/article-archive-copy {"variant":"empty"} /-->
		<!-- /wp:query-no-results -->

		<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
		<nav class="wp-block-query-pagination">
			<!-- wp:query-pagination-previous /-->
			<!-- wp:query-pagination-numbers /-->
			<!-- wp:query-pagination-next /-->
		</nav>
		<!-- /wp:query-pagination -->
	</div>
	<!-- /wp:query -->

	<!-- wp:marison/article-archive-copy {"variant":"cta"} /-->
</main>
<!-- /wp:group -->
