<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div class="join-single-full">
	<main id="main" class="site-main" role="main">

		<?php 
			while ( have_posts() ) : the_post();
				the_content(); 
			endwhile;
		?>

	</main><!-- .site-main -->

	<?php //get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php//get_sidebar(); ?>
<?php get_footer(); ?>
