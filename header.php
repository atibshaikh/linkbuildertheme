<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package apptology
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); 

	if(!is_front_page() && !is_page(107)){
		$headerClass = "innerPages";
	}else{
		$headerClass = "";
	}
?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'apptology' ); ?></a>

	<div class="mob-menu">

		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building Platform" class="top-shadow">

		<div class="mob-menu-wrapper">

			<div class="menu-detail-1">

				<a href="<?php echo site_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-mob.png"></a>
				<div class="menu-trigger">
					<a href="javascript:void(0)"><i class="fal fa-times"></i></a>
				</div>
				
			</div>
			<div class="menu-detail-2">
				<div class="top-mob-menu">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
					?>
				</div>

				<div class="bottom-contact-info">
					<div class="footer-contact">
						<span><i class="fal fa-mobile"></i></span>
						<a href="#">0845 165 7106</a>
					</div>
					<div class="footer-contact">
						<span><i class="fal fa-envelope"></i></span>
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

		
	</div>
	<header id="masthead" class="site-header <?php echo $headerClass; ?>">
			<div class="container-fluid">

				<div class="row mobile-menu align-items-center desktop-hide justify-content-between">
					<div class="col mob-left-part">
						<a href="<?php echo site_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-mob.png"></a>
					</div>
					<div class="col mob-right-part">
						
						<div class="login-signup-part">
							<?php 
								echo do_shortcode('[custom_mini_cart]');
							?>
							<ul class="login-singup-ul">
							<?php 
								if(!is_user_logged_in()){
									?>
									<li><a href="<?php echo get_the_permalink(21); ?>"><i class="fal fa-user-plus"></i></a></li>
									<li><a href="<?php echo get_the_permalink(20); ?>"><i class="fal fa-sign-in-alt"></i></a></li>

									<?php
								}else{
									?>
									<li><a href="<?php echo get_the_permalink(23); ?>"><i class="fal fa-sign-out"></i> Logout</a></li>
									<?php									
								}
							?>
							</ul>
						</div>
						<div class="menu-trigger">
							<a href="javascript:void(0)"><i class="fal fa-bars"></i></a>
						</div>
					</div>
				</div>	

				<div class="row align-items-center desktop-show">
					
					<div class="xcol-md-8 col header-left-col">
						<div class="left-logo-menu-wrap">
								<div class="site-branding">

									<a href="<?php echo site_url(); ?>">
										 <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-builder-logo.png"> 
										<!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 972.486 143.485">
										  <g id="logo-group" transform="translate(-153.555 -324.382)">
										    <g id="logo-center" transform="translate(8 306)">
										      <g id="title" transform="translate(145.555 18.382)">
										        <path id="path107857" d="M694.52,28.729h26.39V-112.134L694.52-103.4Z" transform="translate(-694.52 113.532)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107859" d="M730.028,22.013h26.39V-78.828l-26.39,8.738Z" transform="translate(-672.796 120.249)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107861" d="M839.813-61.238A44.2,44.2,0,0,0,808.7-74a42.577,42.577,0,0,0-17.652,3.67v-6.466H764.838v42.818a30.942,30.942,0,0,0-.175,4.02h.175V21.6h26.215V-32.576a17.746,17.746,0,0,1,17.652-15.2,17.9,17.9,0,0,1,17.826,17.826V21.6h26.215V-29.954a44.465,44.465,0,0,0-12.933-31.284Z" transform="translate(-651.248 120.659)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107863" d="M908.406,28.729H939.34l-35.828-55.4,37.925-41.944H907.882L874.851-31.566v-80.568h-26.39V28.729h26.39V3.912l10.486-11.36Z" transform="translate(-619.786 113.532)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107865" d="M1022.919-19.622a48.8,48.8,0,0,0-4.02-19.4,48.951,48.951,0,0,0-10.661-15.9A48.224,48.224,0,0,0,992.51-65.586a49.886,49.886,0,0,0-19.4-3.845,48.66,48.66,0,0,0-19.4,3.845,23.474,23.474,0,0,0-4.194,2.1V-113.3L923.3-104.559v84.937a49.266,49.266,0,0,0,3.845,19.4,48.222,48.222,0,0,0,10.661,15.729,46.339,46.339,0,0,0,15.9,10.661,48.8,48.8,0,0,0,19.4,4.02,50.089,50.089,0,0,0,19.4-4.02,50.135,50.135,0,0,0,15.729-10.661A48.224,48.224,0,0,0,1018.9-.223a50.089,50.089,0,0,0,4.02-19.4Zm-26.215,0A23.72,23.72,0,0,1,973.11,3.972a23.607,23.607,0,0,1-23.594-23.594A23.5,23.5,0,0,1,973.11-43.216,23.607,23.607,0,0,1,996.7-19.622Z" transform="translate(-590.13 113.298)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107867" d="M1054.734,22.65a43.486,43.486,0,0,0,30.934-12.758,43.486,43.486,0,0,0,12.758-30.934V-75.92h-26.215v54.877a17.528,17.528,0,0,1-17.477,17.477,17.528,17.528,0,0,1-17.477-17.477V-75.92h-26.215v54.877A43.485,43.485,0,0,0,1023.8,9.892a43.485,43.485,0,0,0,30.934,12.758Z" transform="translate(-557.873 120.835)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107869" d="M1095.616,22.013h26.39V-78.828l-26.39,8.738Z" transform="translate(-526.255 120.249)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107871" d="M1131.123,28.729h26.39V-112.134l-26.39,8.738Z" transform="translate(-504.531 113.532)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107873" d="M1164.949-.252a51.888,51.888,0,0,0,10.661,15.9,50.876,50.876,0,0,0,15.9,10.661,49.267,49.267,0,0,0,19.4,3.845,49.267,49.267,0,0,0,19.4-3.845,50.881,50.881,0,0,0,15.9-10.661,51.889,51.889,0,0,0,10.661-15.9,48.658,48.658,0,0,0,3.845-19.4v-84.763l-26.215-8.738v49.634a44.662,44.662,0,0,0-4.194-1.922,48.659,48.659,0,0,0-19.4-3.845,49.267,49.267,0,0,0-19.4,3.845,50.878,50.878,0,0,0-15.9,10.661,51.888,51.888,0,0,0-10.661,15.9,51.675,51.675,0,0,0-3.845,19.225A51.881,51.881,0,0,0,1164.949-.252Zm45.964-42.993a23.72,23.72,0,0,1,23.594,23.594,23.607,23.607,0,0,1-23.594,23.594,23.607,23.607,0,0,1-23.594-23.594A23.72,23.72,0,0,1,1210.913-43.245Z" transform="translate(-483.921 113.327)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107875" d="M1297.693,22.213a48.3,48.3,0,0,0,19.749-4.194,49.3,49.3,0,0,0,16.079-11.185l-18.526-17.477a23.277,23.277,0,0,1-17.3,7.515,24.026,24.026,0,0,1-20.273-11.185H1346.8V-27.071a48.909,48.909,0,0,0-14.331-34.779,49.076,49.076,0,0,0-34.779-14.506,49.482,49.482,0,0,0-34.954,14.506,48.909,48.909,0,0,0-14.331,34.779,48.909,48.909,0,0,0,14.331,34.779,49.481,49.481,0,0,0,34.954,14.506ZM1277.42-39.655a23.785,23.785,0,0,1,20.273-11.36,24.238,24.238,0,0,1,20.273,11.36Z" transform="translate(-451.752 120.747)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										        <path id="path107877" d="M1361.558,21.837h0V-21.156a30.618,30.618,0,0,1,30.584-30.584V-77.956a56.652,56.652,0,0,0-22.2,4.544,56.727,56.727,0,0,0-18,12.234,55.717,55.717,0,0,0-12.234,18,55.648,55.648,0,0,0-4.369,22.021V21.837Z" transform="translate(-419.657 120.425)" fill="#06de92" stroke="#06de92" stroke-miterlimit="2" stroke-width="0"/>
										      </g>
										    </g>
										  </g>
										</svg> -->
									</a>
								</div><!-- .site-branding -->

								<nav id="site-navigation" class="main-navigation">
									<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'apptology' ); ?></button>
									<?php
									wp_nav_menu(
										array(
											'theme_location' => 'menu-1',
											'menu_id'        => 'primary-menu',
										)
									);
									?>
								</nav><!-- #site-navigation -->
						</div>
						
					</div>
					<div class="xcol-md-4 col header-right-col">
						<div class="header-right-part">
							<?php 
								echo do_shortcode('[custom_mini_cart]');
							?>
							<div class="right-btns">
								<?php 

									 wp_nav_menu( array(

				                        'menu'            => 'right-menu',
				                        'container'       => null,
				                        'menu_class'      => 'right-menu',
				                        'menu_id'         => 'right-menu',
				                        'walker'          => null,
				                        
				                    ) );
								?>
							</div>
						</div>

						
					</div>
				</div>
					
			</div>
		
	</header><!-- #masthead -->

