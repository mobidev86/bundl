<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
	</div>
		</div><!-- .site-content -->

		<footer id="colophon" class="footer" role="contentinfo">
			<div class="site-inner-in">
				<div class="antwerp-office">
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="site-inner-in">
					<div class="row">
					<div class="footer-left-menu">
						<?php dynamic_sidebar( 'sidebar-3' ); ?>
					</div>
					<div class="social-links">
						<?php dynamic_sidebar( 'sidebar-4' ); ?>
					</div>
				</div>
				</div>
			</div>
		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#triplebars').on('click', function(){
			$('.site-header-menu').slideDown(400);
		});
		$('#crossed').on('click', function(){
			$('.site-header-menu').slideUp(400);
		});

		$("#categorymenu").click(function() {
		$(this).toggleClass("on");
		$(".category-menuopen").slideToggle();
		});

		
		/*For Mobile Device*/
		checkScreenSize();
		$(window).on("resize", function (e) {
	        checkScreenSize();
	    });
	    
	    function checkScreenSize(){
	        var newWindowWidth = $(window).width();
	        if (newWindowWidth < 768) {
	            $("ul.offices1 li").click(function() {
					$(this).toggleClass("on");
					$(".open").slideToggle();
				});
	        }
	    }

	    // Sticky Header
		$(window).scroll(function(){
		  var sticky = $('#masthead'),
		      scroll = $(window).scrollTop();
			  if (scroll > 750 ){
			  	sticky.addClass('sticky');
			  	//$('ul.primary-menu').removeClass('enable_banner');
			  } else {
			  	sticky.removeClass('sticky');
			  	//$('ul.primary-menu').addClass('enable_banner');
			  }	
		});		

		/*ScrollTop Section*/
		if($('#gform_2 div').hasClass('validation_error')){
			if($(".contact-bottom-section").length){
				$('html, body').animate({
			        scrollTop: $(".contact-bottom-section").offset().top
			    }, 2000);
			}
		}

		if($('#gform_1 div').hasClass('validation_error')){
			if($(".join-our-believers-form").length){
				$('html, body').animate({
			        scrollTop: $(".join-our-believers-form").offset().top
			    }, 2000);
			}    
		}
		if($('#gform_1 div').hasClass('validation_error')){
			if($(".blognewsletter-form").length){
				$('html, body').animate({
			        scrollTop: $(".blognewsletter-form").offset().top
			    }, 2000);
			}    
		}
		/*ScrollTop Section End*/
});


		</script>
</body>
</html>
