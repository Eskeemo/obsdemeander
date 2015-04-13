<!-- first we reset the query to original page query -->
<?php wp_reset_query(); ?>

<!-- and we assign the title of the current page to a variable -->
<?php $page_title = get_the_title($post); ?>

<!-- then we start with the calendar, but only with events relevent for this group -->
<article id="calendar" class="row widget">
	<h4 class="widget-title">Agenda <?php echo $page_title ?></h4>
	<div id="evcal_widget">
		<?php
		if( function_exists('add_eventon')) {
		        $args = array(
					'event_count'		=>	3,
					'show_upcoming'		=>	0,		// show upcoming list or regular calendar
					'number_of_months'	=>	0,		// must be used if show_upcoming => 1
					'event_type_2'		=>	5,
					'ux_val'			=>	'X',
		        );
				add_eventon($args); 
			}
		?>
	</div>
</article>

<!-- we also want to show who the teachers of the group are -->
<!-- so we run a new query on the CPT medewerkers, getting only results for the correct group -->
<?php $args = array(
	'post_type'			=> 'medewerkers',
	'posts_per_page'	=> '-1',
	'meta_query'		=> array(
		array(
			'key'		=> 'group',
			'value'		=> $page_title,
			'compare'	=> 'LIKE',
		),
	),
);
$my_query = new WP_Query($args); ?>

<!-- folllowed by showing the results of this query, but only if there are any -->
<?php if ($my_query->have_posts()) : ?>
	<article id="teachers" class="row widget">
		<h4 class="widget-title">Wie geeft les</h4>
		<ul>
			<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<li>
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail('admin-thumb'); } 
					?>
					<?php echo get_post_meta($post->ID, 'firstname', true); ?>
					<?php echo get_post_meta($post->ID, 'lastname', true); ?>
				</li>
			<?php endwhile; ?>
		</ul>
	</article>
<?php endif; ?>

<!-- next we want to show bookmarks with a category the same as the page title -->
<?php
	$bookmarks = array();
	$bookmarks = get_bookmarks("category_name=$page_title");
	if ($bookmarks[0] != '') { ?>

	<article id="links" class="row widget">
	    <h4 class="widget-title">Leuke Linkjes</h4>
		<ul>
			<?php foreach ( $bookmarks as $bookmark ) { ?>
				<li>
					<a title="<?php echo $bookmark->link_name; ?>" href="<?php echo clean_url($bookmark->link_url); ?>" target="_blank"><?php echo $bookmark->link_name; ?></a>
				</li>
			<? } ?>
		</ul>
	</article>
<?php } ?>

<!-- and we like to include an archive, but only if enough posts are available -->
<!-- so we first need to reset the original query (yup, again) -->
<?php wp_reset_query(); ?>

<!-- followed by querying the posts from the correct category (yup, again) -->
<?php $post_data = get_post($post->ID, ARRAY_A); $slug = $post_data['post_name']; ?>
<?php query_posts( 'offset=3&category_name=' . $slug ); ?>

<?php if (have_posts()) : ?>
	<article id="archive" class="row widget">
		<h4 class="widget-title">Archief</h4>
		<ul>
			<?php while (have_posts()) : the_post(); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
		</ul>
	</article>
<?php endif; ?>
