<?php
/**
 * Title: Marison Design System Foundation Demo
 * Slug: marison/design-system-foundation
 * Description: Development-only demonstration of Marison visual tokens and states.
 * Categories: marison-foundation
 * Inserter: false
 */
?>
<!-- wp:group {"align":"wide","className":"marison-surface--cream","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide marison-surface--cream">
	<!-- wp:heading {"level":1,"fontSize":"h1"} -->
	<h1 class="wp-block-heading has-h-1-font-size">Design System Foundation Demo</h1>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"fontSize":"body"} -->
	<p class="has-body-font-size">Development-only demonstration. This is not production page content.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"marison-foundation-grid","layout":{"type":"constrained"}} -->
	<div class="wp-block-group marison-foundation-grid">
		<!-- wp:group {"className":"marison-card marison-surface--white","layout":{"type":"constrained"}} -->
		<div class="wp-block-group marison-card marison-surface--white">
			<!-- wp:heading {"level":2,"fontSize":"h3"} -->
			<h2 class="wp-block-heading has-h-3-font-size">Color &amp; surfaces</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"marison-surface--sage"} -->
			<p class="marison-surface--sage">Soft Sage surface</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"marison-surface--dark"} -->
			<p class="marison-surface--dark">Deep Green surface</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"marison-card marison-surface--white","layout":{"type":"constrained"}} -->
		<div class="wp-block-group marison-card marison-surface--white">
			<!-- wp:heading {"level":2,"fontSize":"h3"} -->
			<h2 class="wp-block-heading has-h-3-font-size">Actions &amp; links</h2>
			<!-- /wp:heading -->
			<!-- wp:buttons -->
			<div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Primary action</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Secondary action</a></div><!-- /wp:button --></div>
			<!-- /wp:buttons -->
			<!-- wp:paragraph --><p><a href="#demo-link">Recognizable text link</a></p><!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"marison-card marison-surface--white","layout":{"type":"constrained"}} -->
		<div class="wp-block-group marison-card marison-surface--white">
			<!-- wp:heading {"level":2,"fontSize":"h3"} -->
			<h2 class="wp-block-heading has-h-3-font-size">Status labels</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph --><p><span class="marison-status marison-status--project-ongoing">Status Project: Sedang Berjalan</span></p><!-- /wp:paragraph -->
			<!-- wp:paragraph --><p><span class="marison-status marison-status--unit-available">Status Unit: Tersedia</span></p><!-- /wp:paragraph -->
			<!-- wp:paragraph --><p><span class="marison-status marison-status--unit-booked">Status Unit: Terbooking</span></p><!-- /wp:paragraph -->
			<!-- wp:paragraph --><p><span class="marison-status marison-status--unit-sold">Status Unit: Terjual</span></p><!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"marison-card marison-surface--white","layout":{"type":"constrained"}} -->
		<div class="wp-block-group marison-card marison-surface--white">
			<!-- wp:heading {"level":2,"fontSize":"h3"} -->
			<h2 class="wp-block-heading has-h-3-font-size">Form controls</h2>
			<!-- /wp:heading -->
			<!-- wp:html -->
			<div class="marison-field"><label for="marison-demo-input">Example field</label><input id="marison-demo-input" type="text" placeholder="Neutral placeholder" /><span class="marison-field__help">Helper text remains visible.</span></div><div class="marison-field is-error"><label for="marison-demo-error">Example error</label><input id="marison-demo-error" type="text" aria-invalid="true" /><span class="marison-field__error">Example validation message.</span></div>
			<!-- /wp:html -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"marison-card marison-surface--white","layout":{"type":"constrained"}} -->
	<div class="wp-block-group marison-card marison-surface--white">
		<!-- wp:heading {"level":2,"fontSize":"h3"} -->
		<h2 class="wp-block-heading has-h-3-font-size">Image treatment</h2>
		<!-- /wp:heading -->
		<!-- wp:html -->
		<div class="marison-image--hero marison-surface--sage" role="img" aria-label="Neutral image treatment placeholder"></div>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
