<?php

/**
 * Template Name: Dashboard
 *
 */

get_header();

global $current_user; 
$userID = $current_user->ID;

?>

<section class="dashboard-sec">

    

        <?php 

            if(is_user_logged_in()){
                ?>
                <div class="default-sec">
                    <div class="container">

                        <div class="row top-heading">
                            <?php 
                                if(is_user_logged_in()){
                                    ?>
                                        <h3>Hello, <?php echo $current_user->user_login; ?></h3>
                                        <p>If you have any questions or need help with your next strategy, feel free to contact me in the chat, by phone or email.</p>
                                    <?php
                                }
                            ?>
                        </div>


                        <?php 

                            $sale_person = get_field('sales_person', 'user_'. $userID);
                            //print_r($sale_person);
                            $sale_person_id= $sale_person['0']->ID;
                            $person_name = get_the_title($sale_person_id);
                            $person_img = get_post_thumbnail_id( $sale_person_id );
                           
                            $sale_person_position = get_field('position', $sale_person_id);
                            $sale_person_email_id = get_field('email_id', $sale_person_id);
                            $sale_person_phone = get_field('phone_no', $sale_person_id);
                            $skype_id = get_field('skype_id', $sale_person_id);
                            $skype_text = get_field('skype_text', $sale_person_id) ;


                      ?>
                        <div class="row">
                            <?php 

                                if(!empty($sale_person)){
                                    ?>
                                        <div class="col-md-7">
                                            <div class="contact-box-wrap">
                                            
                                                <div class="bottom-user">
                                                    
                                                    <div class="person-img">
                                                        <?php 
                                                            if(!empty($person_img)){

                                                                $person_img_url = wp_get_attachment_image_url($person_img,'large');
                                                                $person_img_srcset = wp_get_attachment_image_srcset($person_img,'large');
                                                                $person_img__sizes = wp_get_attachment_image_sizes($person_img,'large');
                                                                $person_img__alt = get_post_meta($person_img, '_wp_attachment_image_alt', TRUE);


                                                                ?>
                                                                  <img src="<?php echo $person_img_url; ?>" 
                                                                       srcset="<?php echo $person_img_srcset; ?>"
                                                                       sizes="<?php echo $person_img__sizes; ?>"
                                                                       alt="<?php echo $person_img__alt; ?>">
                                                                <?php
                                                            }
                                                        ?>
                                                        <h4><?php echo $person_name; ?></h4>
                                                        <p class="designation"><?php echo $sale_person_position; ?></p>
                                                    </div>
                                                    <div class="right-details">
                                                        

                                                        <div class="contact-no">
                                                            <?php 
                                                                if(!empty($sale_person_phone)){
                                                                    ?>
                                                                    <a href="tel:<?php echo $sale_person_phone; ?>">
                                                                        <span><i class="fas fa-mobile-alt"></i></span>
                                                                        <?php echo $sale_person_phone; ?>
                                                                    </a>
                                                                    <?php
                                                                }

                                                                if(!empty($sale_person_email_id)){
                                                                    ?>
                                                                    <a href="mailto:<?php echo $sale_person_email_id; ?>">
                                                                        <span><i class="fas fa-envelope"></i></span>
                                                                        <?php echo $sale_person_email_id; ?>
                                                                    </a>
                                                                    <?php
                                                                }

                                                                if(!empty($skype_id)){
                                                                    ?>
                                                                    <a href="skype:<?php echo $skype_id; ?>?chat:">
                                                                        <span><i class="fab fa-skype"></i></span>
                                                                        <?php echo $skype_text; ?>
                                                                    </a>
                                                                    <?php
                                                                }
                                                            ?>
                                                            

                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                

                                            </div>
                                           
                                        </div>
                                    <?php
                                }

                            ?>
                            

                            <div class="col-md-5">
                                <?php 
                                    $all_products = get_all_products();
                                    $all_products->found_posts;
                                ?>
                                
                                    <div class="total-box-wrap">
                                        <div class="icon-marketplace"><i class="fal fa-building"></i></div>
                                        <div class="total-marketplace">
                                            <h3><span>Marketplace</span>

                                                <?php echo $all_products->found_posts; ?>+ Media
                                            </h3>
                                            <!-- <a href="<?php  echo get_the_permalink(26) ?>"><i class="fal fa-arrow-right"></i></a> -->
                                        </div>
                                    </div>    
                                
                            </div>
                            
                        </div>

                        <div class="row">
                            
                            <div class="col-md-12 text-center">
                                <div class="offer-table">
                                    <?php echo do_shortcode('[special_offer_dashboard]'); ?>
                                </div>
                            </div>
                    
                            <!-- <div class="col-md-6">
                                <?php 
                                    echo do_shortcode('[show_woo_order]');
                                ?>
                            </div> -->
                        </div>

                    </div>    
                </div>

                <?php        
            }else{
                  ?>
                    <section class="login-wrap default-sec bg-gradient-img">
                         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building" class="nologin-bg" />
                         <div class="nologin-text site-btn-2 c-btn text-center">
                             <div class="container">
                                <h1>Please login to View Dashboard</h1>
                                <a href="<?php echo get_the_permalink(20); ?>">Login</a>
                            </div>
                         </div>
                       
                    </section>
                <?php
            }

        ?>

</section>

<?php 
    get_footer();
?>