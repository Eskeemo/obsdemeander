<?php get_header(); ?>

	<div class="row">

		<!-- first a left sidebar to show the side-nav and some widgets -->
		<aside class="medium-3 column sidebar show-for-medium-up" role="complementary">
			<?php get_sidebar('nav'); ?>
		</aside>
		
		<!-- show the intro content of the page itself through the standard loop -->
		<div class="medium-12 columns page-content" role="main">
			<div class="page-thumbnail">
				<?php if(has_post_thumbnail()) :?>
					<div class="thumb">
						<?php eskeemo_responsive_thumbnails(); ?>
						<?php eskeemo_image_caption(); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="outerbox">
					<article class="innerbox lightshadow" id="post-<?php the_ID(); ?>">
						<header>
							<h2 class="entry-title"><?php the_title(); ?></h2>
						</header>
						<section class="entry-content">
							<?php the_content(); ?>
						</section>
						<footer>
							<p><?php the_tags(); ?></p>
						</footer>
					</article>
				</div>
			<?php endwhile; endif; ?>
		</div>
	</div>

<?php get_footer(); ?>