<!-- first show the list of related documents for the ouderraad -->
<div class="outerbox">
	<div class="innerbox">
		<h4 class="widgettitle">Notulen OR</h4>
		<?php echo do_shortcode( '[prettyfilelist type="pdf" tags="ouderraad" orderdir="ASC" hidesearch="true" hidefilter="true" hidesort="true" openinnew="true" filesPerPage="5"]' ); ?>
	</div>
</div>

<!-- then let's see if any widgets are selected for the ouderraad page -->
<?php if ( is_active_sidebar( 'ouderraad' ) ) : ?>
	<?php dynamic_sidebar( 'ouderraad' ); ?>
<?php else : ?>
<?php endif; ?>