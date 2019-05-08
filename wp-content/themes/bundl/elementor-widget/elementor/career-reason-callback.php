<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Team module */
class Widget_Custom_Elementor_CareerReasons extends Widget_Base {
   	public function get_name() {
     	return 'career_reasons_app';
   	}
   	public function get_title() {
      	return __( 'BUNDL: Career Reasons', 'elementor-custom-element' );
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
            	'label' => __( 'Career Reasons', 'elementor' ),
         	]
      	);
      	$team_repeater = new \Elementor\Repeater();
      	
      	$team_repeater->add_control(
			'career_reason_image',
			[
				'label' => __( 'Choose Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$team_repeater->add_control(
			'career_reason_title', [
				'label' => __( 'Title', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Career Reason Title',
			]
		);

		$team_repeater->add_control(
			'career_reason_text', [
				'label' => __( 'Text', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Lorem ipsum sit amet',
			]
		);
      	
		$this->add_control(
			'career_reasons_data',
			[
				'label' => __( 'Contents', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $team_repeater->get_controls(),
				'title_field' => '{{{ career_reason_title }}}',
			]
		);
      	$this->end_controls_section();
	}

   	protected function render( $instance = [] ) {
   		/* Get settings value */
      	$settings = $this->get_settings_for_display();
      	?>
      	<!-- Compatible section start -->
      	<section class="section-reasons-full">
	      	<div class="reasons1">
	      		<?php 
					if ( $settings['career_reasons_data'] ) {
						?>
						<div class="section section-reasons">
						    <div class="reasons">
							<?php
							foreach (  $settings['career_reasons_data'] as $item ) {
								$career_reason_title = $item['career_reason_title'];
								$career_reason_text = $item['career_reason_text'];
								$career_reason_image = $item['career_reason_image'];
								$career_reason_image_url = $career_reason_image['url'];
							?>
				            <div class="reason-item">
				                <img src="<?php echo $career_reason_image_url; ?>" alt=" " class="img-responsive">
				                <div class="intro">
					                <h3><?php echo $career_reason_title; ?></h3>
					            	<p><?php echo  $career_reason_text; ?></p>
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
    			var pillars_height = $('.pillars-section,.section-reasons').offset().top;
    			add_class_after_height = pillars_height- window_height/2;
    			//console.log(add_class_after_height);
    			//console.log(scroll + "  "+ pillars_height + "  "+ window_height + "  "+ document_height);
				if (scroll >= add_class_after_height) {
     				$('.pillar-item,.reason-item').addClass('in-view');
    			}
			});
		</script>
      	<?php
   }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_Elementor_CareerReasons() );
?>