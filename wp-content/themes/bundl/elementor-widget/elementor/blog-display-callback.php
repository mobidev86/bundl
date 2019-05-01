<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Sustainable module */
class Widget_Custom_Elementor_BlogDisplay extends Widget_Base {
   	public function get_name() {
     	return 'sustainable_app';
   	}
   	public function get_title() {
      	return __( 'BUNDL: Blog Posts', 'elementor-custom-element' );
   	}
   	public function get_icon() {
      	return 'eicon-skill-bar';
   	}
   	public function get_categories() {
      	return [ 'bundl' ];
   	}
   	  	protected function _register_controls() {
      	$this->start_controls_section(
         	'section_title',
         	[
            	'label' => __( 'BUNDL: Blog Posts', 'elementor' ),
         	]
      	);

      	$this->add_control(
			'first_blog_in_full_width',
			[
				'label' => __( 'First blog in full width', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

      	$this->add_control(
			'post_limit', [
				'label' => __( 'Posts per page', 'elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 7,
				'min' => 0,
				'max' => 100,
				'show_label' => true,
			]
		);

		$this->add_control(
			'blog_pagination',
			[
				'label' => __( 'Enable Pagination', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$category_option['all'] = 'All';
		$categories = get_categories( array(
		    'orderby' => 'name',
		    'order'   => 'ASC',
		    //'hide_empty' => false
		) );
 
		foreach( $categories as $category ) {
			$category_option[$category->term_id] = $category->name;
		} 

		$this->add_control(
			'post_category',
			[
				'label' => __( 'Select a category', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' => $category_option
			]
		);

	
     	$this->end_controls_section();
      	
	}
   	protected function render( $instance = [] ) {
   		/* Get settings value */
      	$settings = $this->get_settings_for_display();
      	?>
      	<!-- Compatible section start -->
      	<section class="team-section">
	      	<div class="cykl-team-in row">
	      		<?php
	      		/*
	      		echo $settings['first_blog_in_full_width'];
	      		echo $settings['post_limit'];
	      		echo $settings['blog_pagination'];
	      		echo $settings['post_category'];
	      		*/
	      	global $wpdb;		
				$args = array(
		        'post_type' => 'post',
		        'post_status' => 'publish',
		        'posts_per_page' => $settings['post_limit'],
		        'paged' => 1,
		    	);
		    
		    if($settings['post_category'] != 'all'){
		    	$args['cat'] = $settings['post_category'];
		    }

		    $full_width_blog = ($settings['first_blog_in_full_width'] == 'yes') ? 'full_width_blog' : "";
		    $my_posts = new \WP_Query( $args );
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

		    	if($settings['blog_pagination'] == 'yes'){
		    		if($found_posts > $settings['post_limit']){ 
		    			?>
		    			<div class="loadmore">Load More</div>
						<?php 
					}
				}
			?>

			</div>
		</section>

		<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
		var page = 2;
		jQuery(function($) {
		    $('body').on('click', '.loadmore', function() {
		        var data = {
		            'action': 'load_posts_by_ajax',
		            'page': page,
		            'post_limit': '<?php echo $settings['post_limit'] ?>',
		            'found_posts': '<?php echo $found_posts ?>',
		            'full_width_blog': '<?php echo $full_width_blog ?>',
		            'cat': '<?php echo $settings['post_category'] ?>',
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
      	<!-- Compatible section end -->
      	<?php
   }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_Elementor_BlogDisplay() );
?>