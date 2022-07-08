<?php

/**
 * Template Name: Contact Us
 *
 */

get_header(); ?>


<section class="contact-heading inner-title">
     <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building Platform" class="top-shadow">
    <div class="container">
        <div class="row">
            <div class="title-wrap">
                <h1>Contact Us</h1>
                <p>Accusamus molestias volutpat suspendisse, suspendisse ipsa atque unde. Maiores</p>
            </div>
        </div>
    </div>
</section>
<!-- <section class="default-sec">
    
    <div class="container">
        <div class="row contact-row">
            <div class="col-md-4">
                <div class="contact-wrap">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>02 Street 2714 Don</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-wrap">
                    <i class="fas fa-mobile-alt"></i>
                    <p>+02 1234 567</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-wrap">
                    <i class="fas fa-envelope"></i>
                    <p>hello@linkbuilding.com</p>
                </div>
            </div>
        </div>
        
    </div>
</section> -->

<section class="contact-form">
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <div class="headings form-heading">
                    <h2>Contact Us</h2>  
                    <p>Aute nesciunt totam aliquam ipsum praesentium? Odit quis at, tempore eius voluptate erat</p>
                </div>
                <?php echo do_shortcode('[contact-form-7 id="106" title="Contact form 1"]'); ?>
            </div>

            <div class="col-md-6">
                <div class="our-map-sec">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2601109.1495946404!2d-2.385560216933625!3d52.556008424880204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C%20UK!5e0!3m2!1sen!2sin!4v1652440276025!5m2!1sen!2sin" width="600" height="480" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

        </div>
         <div class="row contact-row">
                        
            <div class="col-md-3">
                <div class="contact-wrap">
                    <div class="contact-info">
                        <h3>Address</h3>
                        <!-- <i class="fas fa-map-marker-alt"></i> -->
                        <p>6 Coltman St, Hull, Humberside <br>HU3 2SG</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="contact-wrap">
                    <div class="contact-info">
                        <!-- <i class="fas fa-mobile-alt"></i> -->
                        <h3>Phone</h3>
                        <p>+02 1234 567</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-wrap">
                    <div class="contact-info">
                        <!-- <i class="fas fa-envelope"></i> -->
                        <h3>Email</h3>
                        <p>hello@linkbuilding.com</p>
                    </div>
                </div>
            </div>
             <div class="col-md-3">
                <div class="contact-wrap">
                    <div class="contact-info">
                        <!-- <i class="fas fa-envelope"></i> -->
                        <h3>Sales</h3>
                        <p>hello@linkbuilding.com</p>
                    </div>
                </div>
            </div>
                    
                 
        </div>


    </div>
</section>



<?php 

    get_footer();
?>