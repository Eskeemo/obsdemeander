<?php
/* Template Name: Ouderraad template */
?>

<?php get_header(); ?>

	<div class="row">

		<!-- first a left sidebar to show the side-nav and some widgets -->
		<aside class="medium-3 column sidebar show-for-medium-up" role="complementary">
			<?php get_sidebar('nav'); ?>
			<?php get_sidebar('or'); ?>
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
							<h1 class="entry-title"><?php the_title(); ?></h1>
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

	<div class="row">

		<div class="small-12 columns page-content" role="main">
			<ul class="medium-block-grid-2">

				<!-- Show the custom post types for "ouderraad", if any -->
				<!-- first create a query to retrieve the correct custom post type -->
				<?php $my_query = new WP_Query( array ( 
					'post_type' => 'ouderraad',
					'posts_per_page' => '-1',
					'order' => 'ASC' ) );
					if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>

					<!-- then show the correct content for the ouderraad posts -->
					<li>
						<div class="outerbox">
							<article class="innerbox lightshadow" id="post-<?php the_ID(); ?>">
								<?php if(has_post_thumbnail()) :?>
									<div class="post-thumbnail">
										<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
									</div>
								<?php endif; ?>
								<header>
									<h4 class="entry-title"><?php the_title(); ?></h4>
								</header>
								<section class="entry-content">
									<?php the_excerpt(); ?>
								</section>
								<footer>
									<p><?php the_tags(); ?></p>
								</footer>
							</article>
						</div>
					</li>
				<?php endwhile; endif; ?>
			</ul>
		</div>
	</div>
		
<?php get_footer(); ?>