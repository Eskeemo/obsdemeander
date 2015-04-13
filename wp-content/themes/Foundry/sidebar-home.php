<!-- for now let's just include the dynamic sidebar on home -->
<?php if ( is_active_sidebar( 'home' ) ) : ?>
	<?php dynamic_sidebar( 'home' ); ?>
<?php else : ?>
<?php endif; ?>