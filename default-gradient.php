<?php

/**
 * Template Name: Default Gradient Page
 *
 */

get_header(); 

?>

<section class="login-reg-form-sec bg-gradient-img">

         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building" class="nologin-bg" />

         <div class="login-form-wrap">

             <div class="container">

                <div class="row align-items-center">
                    
                   <?php 

                    if(have_posts()){

                        while(have_posts()){

                            the_post();

                            the_content();

                        }

                    }

                   ?>

                </div>

            </div>

         </div>
       
</section>

<?php  get_footer(); ?>