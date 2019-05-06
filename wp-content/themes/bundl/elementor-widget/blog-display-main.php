<?php
/* Elementor category register */
function blogdisplay_add_elementor_widget( $elements_manager ) {
  $elements_manager->add_category(
    'bundl',
    [
      'title' => __( 'BUNDL', 'elementor' ),
      'icon' => 'fa fa-plug',
    ]
  );
}
add_action( 'elementor/elements/categories_registered', 'blogdisplay_add_elementor_widget' );

/* Blogdisplay widget register */
ElementorSustainableElement::get_instance()->init();
class ElementorSustainableElement {
    private static $instance = null;
        public static function get_instance() {
            if ( ! self::$instance )
            self::$instance = new self;
            return self::$instance;
    }
    public function init(){
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
    }
    public function widgets_registered() {
        if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){
          $widget_file = 'plugins/elementor/my-widget.php';
          $template_file = locate_template($widget_file);
          if ( !$template_file || !is_readable( $template_file ) ) {
              $template_file = get_stylesheet_directory().'/elementor-widget/elementor/blog-display-callback.php';
          }
          if ( $template_file && is_readable( $template_file ) ) {
              require_once $template_file;
          }
        }
    }
}


/* Home services widget register */
ElementorHomeServicesElement::get_instance()->init();
class ElementorHomeServicesElement {
    private static $instance = null;
        public static function get_instance() {
            if ( ! self::$instance )
            self::$instance = new self;
            return self::$instance;
    }

    public function init(){
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
    }

    public function widgets_registered() {
        if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){
          $widget_file = 'plugins/elementor/my-widget.php';
          $template_file = locate_template($widget_file);
          if ( !$template_file || !is_readable( $template_file ) ) {
              $template_file = get_stylesheet_directory().'/elementor-widget/elementor/home-service-callback.php';
          }
          if ( $template_file && is_readable( $template_file ) ) {
              require_once $template_file;
          }
        }
    }
}

add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');
function load_posts_by_ajax_callback() {
    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['page'];
    $post_limit = $_POST['post_limit'];
    $found_posts = $_POST['found_posts'];
    $full_width_blog = $_POST['full_width_blog'];
    $cat = $_POST['cat'];
    

    $ajax_data = array();
    $ajax_data['hide_load_more'] = 'no';

    ob_start();
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $post_limit,
        'paged' => $paged,
    );

    if($cat != 'all'){
      $args['cat'] = $cat;
    }

    $my_posts = new WP_Query( $args );
    if ( $my_posts->have_posts() ) :
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
                
    endif;
    $ajax_data['post_data'] = ob_get_clean();

    if($paged * $post_limit >= $found_posts)
      $ajax_data['hide_load_more'] = 'yes';

    echo json_encode($ajax_data);
    wp_die();
}
?>