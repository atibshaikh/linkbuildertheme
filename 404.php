<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package apptology
 */

get_header();
?>

<section class="login-reg-form-sec bg-gradient-img error-404 not-found">
	
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building" class="nologin-bg" />
	<div class="container">
		
		<div class="row white">
			<div class="col-md-12">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'apptology' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'apptology' ); ?></p>
					
					<div class="site-btn-1 c-btn">
			            <a href="<?php echo get_the_permalink(26); ?>">Go to Marketplace<i class="fas fa-arrow-right"></i></a>
			        </div>

				</div><!-- .page-content -->
			</div>
		</div>
	</div>
	

</section>

<?php
get_footer();
