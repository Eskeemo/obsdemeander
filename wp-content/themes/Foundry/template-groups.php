<?php
/* Template Name: Groepen template */
?>

<?php get_header(); ?>

		<div class="row">

			<!-- make way for the breadcrumbs ! -->
			<div class="small-12 columns" role="navigation">
				<?php if ( function_exists( 'breadcrumb_trail' ) ) breadcrumb_trail( $args = array( show_browse => false ) ); ?>
			</div>

			<!-- loading correct sized hero-images for different screensizes, using foundation's interchange -->
			<div class="small-12 columns post-thumbnail" role="main">
				<?php eskeemo_responsive_thumbnails(); ?>
			</div>			
			
		</div>

		<div class="row">

			<!-- then we serve them some general introduction text about the class -->
			<div class="large-9 columns" role="main">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
						<header>
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header>
						<section class="entry-content">
							<?php the_content(); ?>
						</section>
						<footer>
						</footer>
					</article>
				<?php endwhile; endif; ?>

				<!-- followed by only the posts with same category as the page-title -->
				<?php $post_data = get_post($post->ID, ARRAY_A); $slug = $post_data['post_name']; ?>
				<?php query_posts( 'showposts=3&category_name=' . $slug ); ?>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
						<header>
							<h3 class="entry-title"><?php the_title(); ?></h3>
						</header>
						<section class="entry-content">
							<?php the_content(); ?>
						</section>
						<footer>
						</footer>
					</article>
				<?php endwhile; endif; ?>
			</div>

			<!-- and finally we want to include the groups sidebar -->
			<aside class="large-3 columns" role="complementary">
				<?php get_sidebar( 'groups' ); ?>
			</aside>

		</div>

<?php get_footer(); ?>