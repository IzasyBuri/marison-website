<?php
/**
 * Title: Marison Contact Content
 * Slug: marison/contact-content
 * Description: Editable corporate Contact introduction, channels, general inquiry, and housing next action.
 * Categories: marison-contact
 * Inserter: true
 */
?>
<!-- wp:group {"align":"full","className":"marison-contact-page marison-surface--cream","layout":{"type":"constrained"}} -->
<main class="wp-block-group alignfull marison-contact-page marison-surface--cream">
	<!-- wp:group {"align":"wide","className":"marison-contact-hero","layout":{"type":"constrained"}} -->
	<section class="wp-block-group alignwide marison-contact-hero">
		<!-- wp:heading {"level":1,"fontSize":"display"} -->
		<h1 class="wp-block-heading has-display-font-size">Hubungi Marison</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size">Temukan saluran kontak korporat Marison atau kirim pertanyaan umum melalui formulir yang tersedia.</p>
		<!-- /wp:paragraph -->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"marison-contact-section","layout":{"type":"constrained"}} -->
	<section class="wp-block-group alignwide marison-contact-section">
		<!-- wp:marison/corporate-contact /-->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"marison-contact-section","layout":{"type":"constrained"}} -->
	<section class="wp-block-group alignwide marison-contact-section">
		<!-- wp:paragraph -->
		<p>Jika Anda memiliki pertanyaan umum tentang Marison, sampaikan kebutuhan Anda secara singkat. Kami tidak memerlukan pilihan Project untuk inquiry umum.</p>
		<!-- /wp:paragraph -->

		<!-- wp:marison/general-contact-form /-->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"align":"full","className":"marison-contact-guidance marison-surface--sage","layout":{"type":"constrained"}} -->
	<section class="wp-block-group alignfull marison-contact-guidance marison-surface--sage">
		<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:heading {"level":2,"fontSize":"h2"} -->
			<h2 class="wp-block-heading has-h-2-font-size">Mencari informasi tentang Project tertentu?</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Mulailah dari halaman perumahan untuk memahami Project yang relevan. Jalur kontak Project tersedia di halaman detail Project tersebut.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:marison/navigation-link {"label_key":"search","path":"/perumahan/","variant":"button"} /-->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</section>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
