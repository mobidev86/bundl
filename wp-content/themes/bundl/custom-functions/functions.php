<?php
/*Test*/
add_shortcode('bundl_portfolio', 'bundl_portfolio_callback');
function bundl_portfolio_callback(){
	ob_start();
	echo '<div class="section section-portfolio market"><div class="items clearfix">';
		$args = array(
			'post_type' => array('portfolio'),
	        'post_status' => array('publish'),
	        'order' => 'DESC',
	        'orderby' => 'date',
	    );

	    $the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
		      $the_query->the_post();
	      
				?>
					<a href="<?php echo get_field('link'); ?>" target="_blank" title="<?php echo get_field('title'); ?>" class="item-container">
						<div class="portfolio-item">
							<div class="portfolio-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>')"></div>
							<div class="portfolio-content">
								<img src="<?php echo get_field('logo'); ?>" alt="Floom" class="logo">
								<p><?php echo get_field('description'); ?></p>
							</div>
						</div>
					</a>
				<?php      
		} // end while
	} // endif
	echo '</div></div>';
	// Reset Post Data
	wp_reset_postdata();
	return ob_get_clean();
}

?>