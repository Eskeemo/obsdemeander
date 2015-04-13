<?php
/* Template Name: Home template */
?>

<?php get_header(); ?>

		<div class="row">

			<div class="large-12 columns">
				<!--<?php echo get_new_royalslider(1); ?>-->
			</div>

		</div>

		<div class="row">

			<div class="large-9 columns" role="main">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
						<header>
							<h1 class="entry-title">Welkom bij OBS De Meander</h1>
							<h2 class="sub-title">openbare basisschool in Amersfoort</h2>
						</header>
						<section class="entry-content">
							<?php the_content(); ?>
						</section>
						<footer>
						</footer>
					</article>
				<?php endwhile; endif; ?>
			</div>

			<aside class="large-3 columns" role="complementary">
				<?php get_sidebar('home'); ?>
			</aside>

		</div>

<?php get_footer(); ?>