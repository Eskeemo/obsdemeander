<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- a clean wordpress title -->
		<title>
			<?php if ( is_category() ) {
			echo 'Archief voor de categorie &quot;'; single_cat_title(); echo '&quot; | '; bloginfo( 'name' );
			} elseif ( is_tag() ) {
			echo 'Archief voor de tag &quot;'; single_tag_title(); echo '&quot; | '; bloginfo( 'name' );
			} elseif ( is_archive() ) {
			wp_title(''); echo ' Archief | '; bloginfo( 'name' );
			} elseif ( is_search() ) {
			echo 'Zoekresultaten voor &quot;'.esc_html($s).'&quot; | '; bloginfo( 'name' );
			} elseif ( is_home() || is_front_page() ) {
			bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
			}  elseif ( is_404() ) {
			echo 'Error 404 Not Found | '; bloginfo( 'name' );
			} elseif ( is_single() ) {
			wp_title('');
			} else {
			echo wp_title( ' | ', 'false', 'right' ); bloginfo( 'name' );
			} ?>			
		</title>

		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/library/css/app.css" />
		<link rel="icon" href="<?php echo get_template_directory_uri() ; ?>/favicon.ico" type="image/x-icon">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<!-- foundation 5 off-canvas menu wrapper -->
		<div class="off-canvas-wrap" data-offcanvas aria-hidden="true">
			<div class="inner-wrap">

				<!-- foundation 5 top-bar for mobile devices -->
				<nav class="tab-bar show-for-small-only" role="navigation">
					<section class="left-small">
						<a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
					</section>
					<section class="middle tab-bar-section">
						<h1 class="title"><?php bloginfo( 'name' ); ?></h1>
					</section>
				</nav>

				<!-- foundation 5 off-canvas menu -->
				<aside class="left-off-canvas-menu">
				    <?php eskeemo_mobile_off_canvas(); ?>
				</aside>

				<!-- foundation 5 top-bar for tablets and up -->
				<div class="nav-container contain-to-grid show-for-medium-up">
				    <nav class="top-bar transparent darkshadow" data-topbar role="navigation">
						<section class="title-area">
							<a href="<?php bloginfo ('home');?>"><div class="logo lightshadow"></div></a>
						</section>
				        <section class="top-bar-section transparent">
				            <?php eskeemo_top_bar_l(); ?>
				            <?php eskeemo_top_bar_r(); ?>
				        </section>
				    </nav>
				</div>

				<section class="container header-waypoint" data-animate-down="header-small" data-animate-up="header-large" role="document">
