<?php
/**
 * The sidebar containing the four widget areas, displays on posts and pages.
 * If no active widgets in this sidebar, it will be hidden completely.
 */

if ( !is_active_sidebar( 'sidebar-1' ) && !is_active_sidebar( 'sidebar-2' ) && !is_active_sidebar( 'sidebar-3' ) && !is_active_sidebar( 'sidebar-4' ) )
	return; ?>
<div class="supplementary" role="complementary">
	<div class="grid">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="one-fourth">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div class="one-fourth">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
		<div class="one-fourth">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
		<div class="one-fourth">
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
		</div>
	<?php endif; ?>
	</div><!-- .grid -->
</div><!-- .supplementary -->