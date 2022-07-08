<?php

/**
 * Template Name: Register Page
 *
 */

get_header(); 

?>


 
 <section class="login-reg-form-sec bg-gradient-img">

         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building" class="nologin-bg" />

         <div class="login-form-wrap">

             <div class="container">

                <div class="row align-items-center">
                    
                    <div class="col-md-6">
                        <div class="login-form-left-text h2-f36 white">
                            <h2>Join millions worldwide</h2>
                            <p>Repellendus alias vel sapiente tellus commodi. Porta habitant cras! Curae nobis convallis</p>
                             <ul>
                                    <li><span><i class="fas fa-check-circle"></i></span>Sequi? Alias, beatae hac eiusmod</li>
                                    <li><span><i class="fas fa-check-circle"></i></span>Hic inceptos, euismod urna</li>
                                    <li><span><i class="fas fa-check-circle"></i></span>Repellendus alias vel sapiente</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        
                        <div class="login-form-wrap h4-f26">
                                
                                <h4>Register to your account</h4>
                               

                            <?php 

                                echo do_shortcode('[ultimatemember form_id="14"]');

                            ?>
                        </div>

                    </div>

                </div>

            </div>

         </div>
       
</section>

<?php  get_footer(); ?>
