<?php
/* Template Name: Team template */
?>

<?php get_header(); ?>

	<div class="row">

		<!-- first a left sidebar to show the side-nav and some widgets -->
		<aside class="medium-3 column sidebar show-for-medium-up" role="complementary">
			<?php get_sidebar('nav'); ?>
		</aside>

		<!-- and we show the intro content of the page itself through the standard loop -->
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
					<article class="innerbox lightshadow" id="post-<?php the_ID(); ?>" >
						<header>
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header>
						<section class="entry-content">
							<?php the_content(); ?>
						</section>
						<footer>
						</footer>
					</article>
				</div>

			<?php endwhile; endif; ?>
		</div>

	</div>

	<div class="row">

		<!-- now we use foundation's blockgrid to create even rows & columns -->
		<div class="medium-12 columns page-content" role="main">
			<ul class="medium-block-grid-2">

				<!-- then we create a query to retrieve the correct custom post type, with the correct ordering -->
				<?php $my_query = new WP_Query( array ( 
					'post_type' => 'medewerkers',
					'posts_per_page' => '-1',
					'orderby' => 'meta_value',
					'meta_key' => 'lastname',
					'order' => 'ASC' ) );
				while ($my_query->have_posts()) : $my_query->the_post(); ?>

					<li>
						<div class="outerbox">
							<article class="innerbox lightshadow" <?php post_class() ?> id="post-<?php the_ID(); ?>">
								<div class="circle">
									<?php if ( has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail'); } 
									?>
								</div>
								<header>
									<h4 class="entry-title">
										<?php echo get_post_meta($post->ID, 'firstname', true); ?> 
										<?php echo get_post_meta($post->ID, 'lastname', true); ?>
									</h4>
									<!-- roles are checkbox-values, so we have to collect all array values -->
									<?php $roles = get_post_meta($post->ID, 'role', true); ?>
									<!-- and then display them, with no comma after the last value -->
									<?php echo implode( $roles, ', '); ?>
								</header>
								<section class="entry-content">
									<?php echo get_post_meta($post->ID, 'bio', true); ?>
								</section>
								<footer>
									<h6>
										<?php echo get_post_meta($post->ID, 'email', true); ?>
									</h6>
								</footer>
							</article>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>
		</div>

	</div>

<?php get_footer(); ?>