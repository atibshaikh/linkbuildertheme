<?php

/**
 * Template Name: Login Page
 *
 */

get_header(); 

?>


 
 <section class="login-reg-form-sec bg-gradient-img">

         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building" class="nologin-bg" />

         <div class="login-form-wrap">

             <div class="container">

                <div class="row align-items-center">
                    
                    <div class="col-md-5">
                        <div class="register-form-left-text h2-f36 white">
                            <h2>Ready to scale your business?</h2>
                            <p>Repellendus alias vel sapiente tellus commodi. Porta habitant cras! Curae nobis convallis</p>
                        </div>
                    </div>

                    <div class="col-md-7">
                        
                        <div class="login-form-wrap h4-f26">
                                

                            <?php 

                                if(!is_user_logged_in()){

                                    echo '<h4>Log in to your account</h4>';
                                    
                                }

                                echo do_shortcode('[ultimatemember form_id="15"]');

                            ?>
                        </div>

                    </div>

                </div>

            </div>

         </div>
       
</section>

<?php  get_footer(); ?>
