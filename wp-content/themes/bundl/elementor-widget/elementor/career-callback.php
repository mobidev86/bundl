<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Sustainable module */
class Widget_Custom_Elementor_Career extends Widget_Base {
   	public function get_name() {
     	return 'career_app';
   	}
   	public function get_title() {
      	return __( 'BUNDL: Career', 'elementor-custom-element' );
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
            	'label' => __( 'BUNDL: Career', 'elementor' ),
         	]
      	);

      	$this->add_control(
			'career_image',
			[
				'label' => __( 'Choose Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'default_career_title', [
				'label' => __( 'Career Title', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Welcome to the bundle Team',
			]
		);

		$this->add_control(
			'default_career_tagline', [
				'label' => __( 'Career Tagline', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'We would love to meet you',
			]
		);

      	$this->add_control(
			'display_default_career',
			[
				'label' => __( 'Display default Career Posts', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$career_categories = get_terms( 
								'career_cat', 
								array(
									    'orderby'    => 'count',
									    'hide_empty' => 0,
									) 
								);

		foreach( $career_categories as  $career_cat ) {
			$this->add_control(
				"display_{$career_cat->name}_career",
				[
					'label' => __( "Display {$career_cat->name} Career", 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'elementor' ),
					'label_off' => __( 'Hide', 'elementor' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
		} 

     	$this->end_controls_section();
      	
	}
   	protected function render( $instance = [] ) {
   		/* Get settings value */
      	global $wpdb;
        $terms_id = array();		
        $career_categories = get_terms( 
								'career_cat', 
								array(
									    'orderby'    => 'date',
									    'hide_empty' => 0,
									) 
								);

      	$settings = $this->get_settings_for_display();
      	if($settings['display_default_career'] == 'yes'){
  			$image_url = $settings['career_image']['url'];
  			$title  = $settings['default_career_title'];
  			$subtitle = $settings['default_career_tagline'];

  			foreach( $career_categories as  $career_cat ) {
	      			$terms_id[] = $career_cat->term_id;
				} 

				$args = array(
		        'post_type' => 'career',
		        'post_status' => 'publish',
		        'tax_query' => array(
					    'relation' => 'AND',
					      array(
					        'taxonomy' => 'career_cat',
					        'field' => 'id',
					        'terms' => $terms_id,
					        'operator' => 'NOT IN'
					      )
					    ),
		    	);
	      	?>
	      	<!-- Compatible section start -->
	      	<section class="bundl-team-section">
				<div class="joincontainer">
					<div class="vacancy-global-bundl-team text-center vacancy-block light">
						<div class="team-logo">
							<img src="<?php echo $image_url; ?>">
						</div>
						<h2 class="title"><?php echo $title; ?></h2>
						<h3 class="subtitle"><?php echo $subtitle; ?></h3>
						<?php
							$career_jobs = new \WP_Query( $args );
						    $found_posts =  $career_jobs->found_posts; 
						    if ( $career_jobs->have_posts() ) :
						    	while ( $career_jobs->have_posts() ) : $career_jobs->the_post(); 
							    	?>
									<div class="row content col-sm-10 col-md-8 col-10">
										<a href="<?php echo get_the_permalink(); ?>">
											<div class="align-self-center column-logo col-sm-2">
												<img src="https://bundl.com/sites/default/files/bundl-logo-small_4_0_0.png">
											</div>
											<div class="align-self-center column-text col-sm-8">
												<div class="position"><?php echo get_the_title(); ?></div>
												<div class="description"><?php echo get_field('location'); ?></div>
											</div>
											<div class="column-link col-sm-2 align-self-center"> <span class="apply">Apply now</span>
											</div>
										</a>
									</div>
								<?php
								endwhile; 
							endif; 
								?>
					</div>
				</div>
			</section>
			<?php 
		} 
		?>


		<section class="bundl-team-section avail-section">
			<div class="vacancy-partner vacancy-block text-center dark">
				<?php			
				foreach( $career_categories as  $career_cat ) {
					if($settings["display_{$career_cat->name}_career"] == 'yes'){
						$logo =  get_field('logo', $career_cat);
						$website_link =  get_field('website_link', $career_cat);
						$job_page_link =  get_field('job_page_link', $career_cat);
						
					?>
						<div class="joincontainer section-<?php echo $career_cat->slug; ?>">
							<div class="row partner-content col-sm-10 col-md-8 col-10">
								<div class="column-partner col-sm-12 col-md-12 col-lg-5 col-xl-7 align-self-center">
									<div class="partner-title"><?php echo $career_cat->name; ?></div>
									<div class="partner-subtitle"><?php echo $career_cat->description; ?></div>
								</div>
								<div class="col-lg-1 col-xl-1"></div>
								<div class="column-link column-link-partner-case  col-sm-6 col-md-6 col-8 col-lg-6 col-xl-2 align-self-center">
									<a href="<?php echo $website_link; ?>">view website</a>
								</div>
								<div class="column-link column-link-partner-website col-sm-6 col-md-6 col-8  col-lg-3 col-xl-2 align-self-center">
									<a href="<?php echo $job_page_link; ?>">apply now</a>
								</div>
							</div>
							<?php 
								$args = array(
							        'post_type' => 'career',
							        'post_status' => 'publish',
							        'tax_query' => array(
										    'relation' => 'AND',
										      array(
										        'taxonomy' => 'career_cat',
										        'field' => 'id',
										        'terms' => array($career_cat->term_id),
										        'operator' => 'IN'
										      )
										    ),
							    );	
							    $career_jobs = new \WP_Query( $args );
			    				$found_posts =  $career_jobs->found_posts; 
			    				if ( $career_jobs->have_posts() ) :
			    					while ( $career_jobs->have_posts() ) : $career_jobs->the_post(); 	
										?>
										<div class="row content col-sm-10 col-md-8 col-10">
											<a href="<?php echo get_field('job_application_link'); ?>">
												<div class="align-self-center column-logo col-sm-2">
													<img src="<?php echo $logo; ?>">
												</div>
												<div class="align-self-center column-text col-sm-8">
													<div class="position"><?php echo get_the_title(); ?></div>
													<div class="description"><?php echo get_field('location'); ?></div>
												</div>
												<div class="column-link col-sm-2 align-self-center"> <span class="apply">apply now</span>
												</div>
											</a>
										</div>
										<?php
									endwhile;
								endif;
								?>
						</div>
					<?php
					}	
				}
				?>
			</div>
		</section>		
		<?php
   }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_Elementor_Career() );
?>