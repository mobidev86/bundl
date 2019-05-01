<?php
get_header();
	if(is_category()){
   		$cat = get_query_var('cat');
   		$category = get_category ($cat);
   		//echo '<h1>'.$category->cat_name.'</h1>';
   		//echo do_shortcode('[ajax_load_more category="'.$category->slug.'" cache="true" cache_id="cache-'.$category->slug.'"]');
   ?>

   <section class="team-section category-full">
   	<div class="site-inner-in">
	      	<div class="cykl-team-in row">
	      		<?php

	      	global $wpdb;		
	      		$post_limit = 7;
				$args = array(
			        'post_type' => 'post',
			        'post_status' => 'publish',
			        'posts_per_page' => $post_limit,
			        'paged' => 1,
			        'cat' => $category->term_id,
		    	);

		    $full_width_blog = 'full_width_blog';

		    $my_posts = new WP_Query( $args );
		    $found_posts =  $my_posts->found_posts; 

		    if ( $my_posts->have_posts() ) : 
		    		?>
		        <div class="my-posts">
		    		<?php 
		            $counter = 0;
		            $default_image = esc_url(get_template_directory_uri())."/elementor-widget/images/no-image.png";
		            while ( $my_posts->have_posts() ) : $my_posts->the_post(); 
		            $counter++;
		           	?>
		            	<div class="<?php if($counter == 1){ echo $full_width_blog; }else{echo 'small-box';} ?>">
		            		<div class="post_image">

			            		<?php $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
			            		<?php if(!empty($image_url)) {?>
			            			<?php if($counter == 1 && $full_width_blog == 'full_width_blog'){ ?>
			            				<a href="<?php echo get_the_permalink()?>" ><div class="image-box"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/timthumb.php?src=<?php echo $image_url;?>&w=750&h=401&zc=1" alt="" /></div></a>
			            			<?php }else{ ?>
			            			<a href="<?php echo get_the_permalink()?>" ><div class="image-box"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/timthumb.php?src=<?php echo $image_url;?>&w=420&h=330&zc=1" alt="" /></div></a>
			            			<?php }?>
			            		<?php }else{ ?>
					                <?php if($counter == 1 && $full_width_blog == 'full_width_blog'){ ?>
			            				<a href="<?php echo get_the_permalink()?>" ><div class="image-box"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/timthumb.php?src=<?php echo $default_image;?>&w=750&h=401&zc=1" alt="" /></div></a>
			            			<?php }else{ ?>
			            			<a href="<?php echo get_the_permalink()?>" ><div class="image-box"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/timthumb.php?src=<?php echo $default_image;?>&w=420&h=330&zc=1" alt="" /></div></a>
			            			<?php }?>
					            <?php }?>
			            	</div>
			            			
			            	<div class="post_content">		
			            		<div class="post_category">
			            			<span>
						            <?php
						            	$categories = get_the_category();
										$separator = ' ';
										$output = '';
										if ( ! empty( $categories ) ) {
										    foreach( $categories as $category ) {
										        $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
										    }
										    echo trim( $output, $separator );
										}
									?></span>
									<span><?php echo get_field('duration');?> min </span>
								</div>	
					            
					            <h2><a href="<?php echo get_the_permalink()?>" ><?php the_title(); ?></a></h2>
					            
					            <div class="post_excerpt">
					            	<?php //the_excerpt();  ?>
					            	<?php echo wp_trim_words( get_the_excerpt(), 50 ); ?>
					        	</div>

					        	<div class="post_author">
									<?php echo get_the_author(); ?>
								</div>
					        </div>    
				        </div>    	
	            	<?php
	            	endwhile; 
	            	?>

		        </div>
		    <?php endif; 
		    	
		    	if($found_posts > $post_limit){ 
			    	?>
			    	<div class="loadmore">Load More</div>
					<?php 
				}
				
			?>

			</div>
		</div>
		</section>
<?php
}
get_footer();
?>
<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
		var page = 2;
		jQuery(function($) {
		    $('body').on('click', '.loadmore', function() {
		        var data = {
		            'action': 'load_posts_by_ajax',
		            'page': page,
		            'post_limit': '<?php echo $post_limit ?>',
		            'found_posts': '<?php echo $found_posts ?>',
		            'full_width_blog': '<?php echo $full_width_blog ?>',
		            'cat': '<?php echo $category->term_id ?>',
		            'security': '<?php echo wp_create_nonce("load_more_posts"); ?>'
		        };
		        $.post(ajaxurl, data, function(response) {
		        	var data;
		        	data = JSON.parse(response);
		            $('.my-posts').append(data.post_data);
		            console.log(data.hide_load_more);
		            if(data.hide_load_more == 'yes'){
		            	$('.loadmore').hide();
		            }
		            page++;
		        });
		    });
		});
		</script>