<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>
		<header id="masthead" class="site-header" role="banner">
			<div class="site-header-top">
				<div class="logo">
					<?php twentysixteen_the_custom_logo(); ?>					
				</div><!-- .site-branding -->
				<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) ) : ?>
					<div id="triplebars">
						<svg data-name="4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 41 35">
							<title>Menu</title><path fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5" d="M2.5 17.5h36M2.5 2.5h36M2.5 32.5h36"></path>
						</svg>
					</div>							
					<div id="site-header-menu" class="header-menu-right site-header-menu">
						<div id="crossed" class="close"></div>
						<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'twentysixteen' ); ?>">
								<?php
									wp_nav_menu(
										array(
											'theme_location' => 'primary',
											'menu_class' => 'primary-menu',
										)
									);
								?>
							</nav><!-- .main-navigation -->
						<?php endif; ?>
							<div class="btn-wrapper-mobile">								
								<a class="btn btn-green btn-map shake-trigger" title="Maps" href="https://www.google.be/maps/dir//Bundl,+Stoofstraat+9,+2000+Antwerpen/@51.219144,4.3948811,17z/data=!4m16!1m7!3m6!1s0x47c3f6f43b4abfc1:0xd4120855d51ca87!2sBundl!3b1!8m2!3d51.2191407!4d4.3970698!4m7!1m0!1m5!1m1!1s0x47c3f6f43b4abfc1:0xd4120855d51ca87!2m2!1d4.3970698!2d51.2191407" target="_blank">
									<span class="shake"></span>Maps</a>
							</div>
						<div class="social-links-mobile">
							<?php dynamic_sidebar( 'sidebar-4' ); ?>
						</div>
					</div><!-- .site-header-menu -->
				<?php endif; ?>
			</div><!-- .site-header-main -->
			<div class="category-menu">
				<div class="site-inner">
					<button id="categorymenu" class="dropbtn blogfilterbtn"><span>All</span>
						<svg data-name="4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 41 35">
							<title>Filter</title><path fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5" d="M2.5 17.5h36M2.5 2.5h36M2.5 32.5h36"></path>
						</svg>
					</button>
				<?php if ( has_nav_menu( 'category_menu' ) ) : ?>
					<nav class="categorymenu category-menuopen" role="navigation" aria-label="<?php esc_attr_e( 'Category Menu', 'twentysixteen' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'category_menu',
									'menu_class' => 'categorymenu',
								)
							);
						?>
					</nav><!-- .main-navigation -->
				<?php endif; ?>				
			</div>
			</div>	
		</header><!-- .site-header -->
		<div class="site-inner-box">
		<div id="content" class="site-content">
