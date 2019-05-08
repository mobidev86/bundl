<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="blogTitel">
			<div class="singlecontainer">
				<div class="single-inside">
					<div class="blogInfo <?php echo get_post_format( get_the_ID() ); ?>">
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
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<h3><?php echo get_field('sub_title');?></h3>	
			</div>
		</div>
	</div>
	<?php twentysixteen_excerpt(); ?>
	<div class="blogImage">
		<?php twentysixteen_post_thumbnail(); ?>
	</div>
	<div class="singlecontainer">
	<div class="blogContent">
		<div class="social-links desctop">
			<script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>
            <ul>
                <li>
                	<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&source=<?php echo site_url(); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                </li>
                <li>
                	<a href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" onclick="return fbs_click()" target="_blank"><i class="fa fa-facebook"></i></a>
                </li>
                <li>
                	<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                </li>
            </ul>
        </div>
        <div class="blogContent-in">        
		<?php
			the_content();

			wp_link_pages(
				array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				)
			);

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}
			?>		
	</div><!-- .entry-content -->
</div>
	</div>	
	<div class="blogFooter">
		<div class="singlecontainer">
			<div class="single-inside">
			<div class="auteur">
			<div class="row">
				<div class="auteur-img">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 128 ); ?>
					<!-- <img src="https://bundl.com/sites/default/files/styles/author/public/auteur.png?itok=5_joqUsv"> -->
				</div>
				<div class="auteur-name">
					<!-- <h3>Thomas Van Halewyck</h3> -->
					<h3><?php echo get_the_author(); ?></h3>
					<p><?php echo get_field('designation', 'user_'.get_the_author_meta( 'ID' )); ?></p>
					<div class="auteur-socials socials">
						<ul>
							<li><a target="_blank" rel="nofollow" href="https://blog.bundl.com/@ThomasVH" title=""><i class="fa fa-medium-m" aria-hidden="true"></i></a>
							</li>
							<li><a target="_blank" rel="nofollow" href="<?php echo get_field('linked_in_profile', 'user_'.get_the_author_meta( 'ID' )); ?>" title=""><i class="fa fa-linkedin" aria-hidden="true"></i></a>
							</li>
							<li><a target="_blank" rel="nofollow" href="<?php echo get_field('instagram_profile', 'user_'.get_the_author_meta( 'ID' )); ?>" title=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<section class="subscribe-cta blognewsletter">
	<div class="singlecontainer">		
		<div class="blognewsletter-in">
			<p>Every month</p>
			<div class="blognewsletter-form">					
				<?php echo do_shortcode('[gravityform id=1]');?>
			</div>
		</div>		
	</div>
</section>
<section class="blogSection relatedItems">
	<div class="singlecontainer">
		<div class="cykl-team-in row related">
			
	      		<?php

	      	$categories = get_the_category(get_the_ID());
			if ($categories) {
			$category_ids = array();
			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
				}

				$args = array(
		        'post_type' => 'post',
		        'post_status' => 'publish',
		        'posts_per_page' => 3,
		        'category__in' => $category_ids,
				'post__not_in' => array($post->ID),
		    	);
	
		    $full_width_blog = ($settings['first_blog_in_full_width'] == 'yes') ? 'full_width_blog' : "";
		    $my_posts = new WP_Query( $args );
		    $found_posts =  $my_posts->found_posts; 
		    if ( $my_posts->have_posts() ) : 
		    ?>
		    <h2 class="related-title">Related articles</h2>
		        <div class="my-posts">
		            <?php 
		            $counter = 0;
		            $default_image = esc_url(get_template_directory_uri())."/elementor-widget/images/no-image.png";
		            while ( $my_posts->have_posts() ) : $my_posts->the_post(); 
		            $counter++;
		           	?>
		            	<div class="<?php if($counter == 1 && !empty($full_width_blog)){ echo $full_width_blog; }else{echo 'small-box';} ?>">
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
		    <?php endif; ?>
			</div>
		</div>
	</section>
</article><!-- #post-## -->
