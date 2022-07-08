<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package linkbuilder
 */

?>

	<footer id="site-footer" class="site-footer">
		<?php 

			if(is_user_logged_in()){

				echo '<div class="footer-sticky-cart">';
					 echo do_shortcode('[sticky_mini_cart]'); 
				echo '</div>';
				
			}
		
		?>
		
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building" class="footer-bg" />

		<div class="container-fluid">
			<div class="row">
				
				<div class="col footer-col-1">
					<div class="footer-wrap text-left brand-logo">
						<!-- <span class="footer-icon"><i class="fal fa-bullseye-arrow"></i></span> -->
						<!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-2.svg"> -->
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-builder-logo.png"> 
					</div>
					<h4>© 2022 Linkbuilder Media, Inc.</h4>
					<p>Cras convallis ea penatibus senectus rhoncus wisi lorem, eu? Ligula ut minus eos</p>
				</div>
				<div class="col footer-col-2">
					<h2 class="footer-heading">Helpful Links</h2>
					<ul class="footer-menu">
						<li><a href="#">Faq's</a></li>
						<li><a href="#">Market Place</a></li>
						<li><a href="#">How it Works</a></li>
						<li><a href="#">Contact Us</a></li>
					</ul>
				</div>
				<div class="col footer-col-3">
					<h2 class="footer-heading">Sign up for updates</h2>
					<p>Sollicitudin faucibus sodales, ullamcorper est sequi dis error</p>
					<div class="signUp-Form">
						<?php echo do_shortcode('[contact-form-7 id="208" title="Footer SignUp"]'); ?>
					</div>
				</div>
				<div class="col footer-col-4">
					<h2 class="footer-heading">Get In touch</h2>
						<div class="footer-contact">
							<h4>Address</h4>
							<p>96-100 Gracechurch Shopping Centre
							Sutton Coldfield
							West Midlands
							B72 1PH</p>

						</div>
						<div class="footer-contact">
							<h4 >Phone</h4>
							<a href="#">0845 165 7106</a>
						</div>
						<div class="footer-contact">
							<h4>Email</h4>
							<a href="#">info@linkbuilder.com</a>
						</div>
						<ul class="contact-details">
							<li><a href="#"><i class="fab fa-facebook-f"></i> </a></li>
							<li><a href="#"><i class="fab fa-instagram"></i> </a></li>
							<li><a href="#"><i class="fab fa-twitter"></i> </a></li>

						</ul>
					</div>
					
				</div>
			</div>
			<div class="site-info text-center">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<ul class="footer-legal">
								<li><a href="#">Terms and conditions</a></li>
								<li><a href="#">Privacy Policy</a></li>
							</ul>
						</div>
						<div class="col-md-6 copyRight">
							<p>Develop and Design by <a href="#" class="developBy">Link Builder Team</a></p>
						</div>
					</div>
				</div>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
