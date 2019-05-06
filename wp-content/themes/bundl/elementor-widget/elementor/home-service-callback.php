<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Team module */
class Widget_Custom_Elementor_HomeServices extends Widget_Base {
   	public function get_name() {
     	return 'team_app';
   	}
   	public function get_title() {
      	return __( 'BUNDL: Home Services', 'elementor-custom-element' );
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
            	'label' => __( 'Home Services', 'elementor' ),
         	]
      	);
      	$team_repeater = new \Elementor\Repeater();
      	
      	$team_repeater->add_control(
			'service_image',
			[
				'label' => __( 'Choose Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$team_repeater->add_control(
			'service_title', [
				'label' => __( 'Title', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Services Title',
			]
		);

		$team_repeater->add_control(
			'service_text', [
				'label' => __( 'Text', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Lorem ipsum sit amet',
			]
		);
      	
		$this->add_control(
			'services_data',
			[
				'label' => __( 'Contents', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $team_repeater->get_controls(),
				'title_field' => '{{{ service_title }}}',
			]
		);
      	$this->end_controls_section();
	}

   	protected function render( $instance = [] ) {
   		/* Get settings value */
      	$settings = $this->get_settings_for_display();
      	?>
      	<!-- Compatible section start -->
      	<section class="pillars-section">
	      	<div class="cykl-pillars-in row">
	      		<?php 
					if ( $settings['services_data'] ) {
						?>
						<div class="section section-pillars">
						    <div class="pillars">
							<?php
							foreach (  $settings['services_data'] as $item ) {
								$service_title = $item['service_title'];
								$service_text = $item['service_text'];
								$service_image = $item['service_image'];
								$service_image_url = $service_image['url'];
							?>
				            <div class="pillar-item">
				                <img src="<?php echo $service_image_url; ?>" alt=" " class="img-responsive">
				                <div class="intro">
					                <h3><?php echo $service_title; ?></h3>
					            	<p><?php echo  $service_text; ?></p>
					            </div>
				        	</div>
							<?php	
							}
							?>
						</div>
					</div>
						<?php
					}
				?>
			</div>
		</section>

		<script type="text/javascript">
			$(window).scroll(function() {    
    			var scroll = $(window).scrollTop();
    			var window_height = $( window ).height();
    			var pillars_height = $('.pillars-section').offset().top;
    			add_class_after_height = pillars_height- window_height/2;
    			//console.log(add_class_after_height);
    			//console.log(scroll + "  "+ pillars_height + "  "+ window_height + "  "+ document_height);
				if (scroll >= add_class_after_height) {
     				$('.pillar-item').addClass('in-view');
    			}
			});
		</script>
      	<?php
   }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_Elementor_HomeServices() );
?>