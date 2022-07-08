<?php

/**
 * Template Name: Marketplace
 *
 */

get_header(); 


global $current_user; 
$userID = $current_user->ID;

$link_language = "field_624ea6da6e10b";
$link_language_select = get_field_object($link_language);

$filterQuery = get_author_save_filter_post($userID);
$total_post = $filterQuery->found_posts;
$from_domain_rating_dr = $from_organic_traffic = $from_domain_age = $from_domain_authority_da  = '0';


include_once get_stylesheet_directory() . '/inc/marketplace-get-data.php';

// get theme option col field to check on frontside
$control_marketplace_col = get_field('control_marketplace_col', 'option');



if( is_user_logged_in() ){
    ?>
    <main data-paged="8" id="ajax-posts-filter">

        <section class="page-section filter-sec">

            <div class="container-fluid px-5">

                <div class="top-text">
                    
                    <div class="left-text">
                        <h1>Marketplace</h1>
                        <p>Fringilla nostrud facilisi suscipit delectus litora doloremque eros, ratione hymenaeos</p>
                    </div>

                    <div class="right-filter-part">

                        <div class="filter-action">
                            <div class="wishlist-btn">
                                <a href="<?php echo get_the_permalink(249); ?>">Wishlist</a>
                            </div>
                             <div class="filter-trigger">

                                <?php 

                                    if($total_post < 3){
                                        ?>
                                        <a href="#" class="showTrigger" data-send="submit" data-showtarget="save-filter-box" title="You can save upto 3 favorite filter" data-page="1"><i class="yith-wcwl-icon fa fa-heart-o"></i> Save Filter</a>

                                        <div class="save-filter-box commonTrigger" id="">
                                            <div class="close-box"><i class="fas fa-times-circle"></i></div>
                                            <div class="fav-wishlst-title">

                                                <div class="save-name">
                                                    <label> Enter Filter Name </label>
                                                    <input type="text" name="add_filter_name" id="add_filter_name" value="" placeholder="eg: domain rating upto 75">
                                                </div>
                                                
                                                <div class="save-btn"><a href="#" id="save-filter" data-send="submit" title="You can save upto 3 favorite filter">Save</a></div>

                                            </div>
                                            
                                        </div>

                                        <?php
                                    }else{
                                        echo '<p class="filter-note">You can save only 3 fav filter</p>';
                                        
                                    }
                                ?>
                               
                            </div> 
                            <?php 
                                if($total_post > 0){
                                    ?>
                                    <div class="Recent-filter">
                                        <a href="#" title="Show Recent Saved filtes" data-showtarget="save-filter-list" class="showTrigger"><i class="fal fa-filter"></i>Fav Filters</a>
                                    </div>
                                    <?php
                                }
                            ?>
                            <div class="col-adjustment">
                                 <a href="#" title="show hide table column" data-showtarget="showHideCol" class="showTrigger">
                                    <i class="fal fa-line-columns"></i>
                                    <span><i class="fal fa-angle-down"></i></span>
                                </a>
                            </div>
                            
                             <div id="show-ajax-msg" class="filter-note"></div>
                        </div>

                        <div class="commonTrigger showHideCol" id="showHideCol">
                            <p>Pin/Unpin Col</p>
                           
                            

                            <?php 

                                if( !in_array('lang', $control_marketplace_col) ){
                                    ?>
                                    <div class="col-checkbox triggerColCheck">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="check_lang" id="check_lang" checked>
                                          <label class="form-check-label" for="check_lang">
                                            language
                                          </label>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if( !in_array('dr', $control_marketplace_col) ){
                                    ?>
                                     <div class="col-checkbox triggerColCheck">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="check_dr" id="check_dr" checked>
                                          <label class="form-check-label" for="check_dr">
                                            DR
                                          </label>
                                        </div>
                                    </div>
                                    <?php
                                }

                                if( !in_array('ot', $control_marketplace_col) ){
                                    ?>
                                    <div class="col-checkbox triggerColCheck">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="check_ot" id="check_ot" checked>
                                          <label class="form-check-label" for="check_ot">
                                            OT
                                          </label>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if( !in_array('rd', $control_marketplace_col) ){
                                    ?>
                                    <div class="col-checkbox triggerColCheck">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="check_rd" id="check_rd" checked>
                                          <label class="form-check-label" for="check_rd">
                                            RD
                                          </label>
                                        </div>
                                    </div>
                                    <?php
                                }

                                if( !in_array('da', $control_marketplace_col) ){
                                    ?>
                                    <div class="col-checkbox triggerColCheck">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="check_da" id="check_da" checked>
                                          <label class="form-check-label" for="check_da">
                                            Domain Authority
                                          </label>
                                        </div>
                                    </div>
                                    <?php  
                                }

                                if( !in_array('niches', $control_marketplace_col) ){
                                   ?>
                                   <div class="col-checkbox triggerColCheck">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="check_niches" id="check_niches" checked>
                                          <label class="form-check-label" for="check_niches">
                                            Niches
                                          </label>
                                        </div>
                                    </div>
                                   <?php     
                                }

                                if( !in_array('category', $control_marketplace_col) ){
                                    ?>
                                     <div class="col-checkbox triggerColCheck">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="check_category" id="check_category" checked>
                                          <label class="form-check-label" for="check_category">
                                            Category
                                          </label>
                                        </div>
                                    </div>
                                    <?php
                                }

                                


                                $allGroupField = acf_get_fields_by_id(183);
                                                
                                $all_sub_field = $allGroupField[0]['sub_fields'];

                                $efc = 10;
                                foreach ($all_sub_field as $field_items) {

                                    $field_label = $field_items['label'];
                                    $extra_fields_name = $field_items['_name'];

                                    if( !in_array($extra_fields_name, $control_marketplace_col) ){

                                         ?>

                                         <div class="col-checkbox triggerColCheck">
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" value="check_<?php echo $extra_fields_name; ?>" id="check_<?php echo $extra_fields_name; ?>" checked>
                                              <label class="form-check-label" for="check_<?php echo $extra_fields_name; ?>">
                                                <?php echo $field_label; ?>
                                              </label>
                                            </div>
                                        </div>

                                        <?php
                                    }

                                   
                                    $efc++;
                                }

                            ?>

                        </div>

                        <div class="save-filter-list commonTrigger" id="save-filter-list">
                        
                            <div class="close-box"><i class="fas fa-times-circle"></i></div>

                            <div class="search-drop-down">
                                <?php 

                                    if($filterQuery->have_posts()){

                                        while($filterQuery->have_posts()){

                                            $filterQuery->the_post();

                                            $filterID = get_the_ID();
                                            $filter_title = get_the_title();

                                            $jsonFilter = get_field('form_json', $filterID);

                                            $jsonToPhp = json_decode($jsonFilter);

                                            $data2 = http_build_query($jsonToPhp[0]);
                                            $query_url = site_url()."/marketplace/?". $data2;
                                            $admin_role_set = get_role( 'customer' )->capabilities;

                                            ?>
                                            <div class="saved-filter-data-list">
                                            <?php
                                                if( current_user_can( 'delete_post' ) ) { ?>
                                                <div class="delete-btn">
                                                    <a href="#" data-id="<?php echo $filterID; ?>" data-nonce="<?php echo wp_create_nonce('my_delete_post_nonce') ?>" class="delete-post"><i class="fal fa-trash-alt"></i></a>

                                                    <?php } ?>
                                                </div>
                                                <div class="save-filter-title">
                                                    <a href="<?php echo $query_url; ?>"><?php echo $filter_title; ?></a>
                                                </div>
                                            </div>
                                            
                                            <?php }
                                        wp_reset_postdata();
                                    }


                                ?>
                                
                            </div>

                        </div>
                       

                    </div>

                    

                    
                </div>

                <div class="mob-showhide-filter">
                    <div class="filter-btn">
                        <i class="fal fa-filter"></i> Show/Hide Filter
                    </div>
                </div>

                <div class="form-filters">

                    
                     
                    <div class="filter-top-part">

                      <input type="hidden" name="sort_field" id="sort_field" value="">
                      <input type="hidden" name="sort_order" id="sort_order" value="">

                       
                        <div class="f-category m-filter">
                            
                            <?php

                                $terms  = get_terms('product_cat');

                                    ?>
                                        <select class="custom-select common-filter" id="product_cat" name="product_cat">
                                                <option value="all-terms">Category</option>
                                              <?php foreach ($terms as $term) : ?>

                                                    <option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
                                                    
                                                <?php endforeach; ?>   
                                            
                                        </select>
                                    <?php
                                   
                            ?>
                        </div>

                        <div class="f-language m-filter">
                            <!-- Select Language -->
                            <div class="select-field">
                                
                                <?php 
                                    if( $link_language_select ){
                                            echo '<select class="custom-select common-filter" id="link_language" name="link_language">';
                                            echo  '<option selected value="">Language</option>';
                                                foreach( $link_language_select['choices'] as $k => $v )
                                                {
                                                    echo '<option value="' . $k . '">' . $v . '</option>';
                                                }
                                            echo '</select>';
                                    }
                                ?>

                            </div>
                        </div>

                        <div class="show-hide-filter filter-1 m-filter">

                              <button  type="button" class="show-popover filter-btn common-filter" data-target="domain-rating">
                                   <div class="filter-text">Domain Rating</div>
                                   <div class="from-to-text"><span class="dr-from">0</span> - <span class="dr-to">100</span></div>
                              </button>


                                <div class="popover-content domain-rating common-box" style="display:none;">
                                  <div class="card border-0">
                                    <div class="card-body">
                                      
                                      <div class="hidden-content show-div">

                                        <div class="from-div"> 
                                            <label> From </label>
                                            <input type="number" name="from_domain_rating_dr" id="from_domain_rating_dr" value="<?php echo $from_domain_rating_dr; ?>" placeholder="0">
                                        </div>
                                        <div class="to-div"> 
                                            <label> to </label>
                                            <input type="number" name="to_domain_rating_dr" id="to_domain_rating_dr" value="<?php echo $to_domain_rating_dr; ?>" placeholder="0">
                                        </div>
                                        
                                        
                                      </div>

                                    </div>
                                  </div>
                                </div>

                        </div>

                        <div class="show-hide-filter filter-2 m-filter">
                              <button type="button" class="show-popover filter-btn common-filter" data-target="domain-trafiic">
                                   <div class="filter-text">Domain Traffic</div>
                                   <div class="from-to-text"><span class="dt-from">0</span> - <span class="dt-to">100</span></div>
                              </button>


                                <div class="popover-content domain-trafiic common-box" style="display:none;">
                                  <div class="card border-0">
                                    <div class="card-body">
                                      
                                      <div class="hidden-content show-div">

                                        <div class="from-div"> 
                                            <label> From </label>
                                            <input type="number" name="from_organic_traffic" id="from_organic_traffic" value="<?php echo $from_organic_traffic; ?>" placeholder="0">
                                        </div>
                                        <div class="to-div"> 
                                            <label> to </label>
                                            <input type="number" name="to_organic_traffic" id="to_organic_traffic" value="<?php echo $to_organic_traffic; ?>" placeholder="0">
                                        </div>
                                        
                                        
                                      </div>

                                    </div>
                                  </div>
                                </div>

                        </div>

                        <div class="show-hide-filter filter-3 m-filter">
                              <button type="button" class="show-popover filter-btn common-filter" data-target="domain-age">
                                   <div class="filter-text">Referring Domains</div>
                                   <div class="from-to-text"><span class="age-from">0</span> - <span class="age-to">100</span></div>
                              </button>


                                <div class="popover-content domain-age common-box" style="display:none;">
                                  <div class="card border-0">
                                    <div class="card-body">
                                      
                                      <div class="hidden-content show-div">

                                        <div class="from-div"> 
                                            <label> From </label>
                                            <input type="number" name="from_domain_age" id="from_domain_age" value="<?php echo $from_domain_age; ?>"  placeholder="0">
                                        </div>
                                        <div class="to-div"> 
                                            <label> to </label>
                                            <input type="number" name="to_domain_age" id="to_domain_age" value="<?php echo $to_domain_age; ?>" placeholder="0">
                                        </div>
                                        
                                        
                                      </div>

                                    </div>
                                  </div>
                                </div>

                        </div>

                        <div class="show-hide-filter filter-4 m-filter">
                              <button type="button" class="show-popover filter-btn common-filter" data-target="domain-authority">
                                   <div class="filter-text">Domain Authority</div>
                                   <div class="from-to-text"><span class="authority-from">0</span> - <span class="authority-to">100</span></div>
                              </button>


                                <div class="popover-content domain-authority common-box" style="display:none;">
                                  <div class="card border-0">
                                    <div class="card-body">
                                      
                                      <div class="hidden-content show-div">

                                        <div class="from-div"> 
                                            <label> From </label>
                                            <input type="number" name="from_domain_authority_da" id="from_domain_authority_da" value="<?php echo $from_domain_authority_da; ?>"  placeholder="0">
                                        </div>
                                        <div class="to-div"> 
                                            <label> to </label>
                                            <input type="number" name="to_domain_authority_da" id="to_domain_authority_da" value="<?php echo $to_domain_authority_da; ?>"  placeholder="0">
                                        </div>
                                        
                                        
                                      </div>

                                    </div>
                                  </div>
                                </div>

                        </div>

                    </div>

                    <div class="filter-bottom-part m-filter">
                        
                        
                        <div class="select-niche-wrap">

                            <label class="niche-lable">
                                Select Niches
                            </label>

                            <div class="form-check">
                              <input class="form-check-input" name="domain_casino" type="checkbox" value="yes" id="domain_casino">
                              <label class="form-check-label" for="domain_casino">
                                Casino
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" name="domain_loan" type="checkbox" value="yes" id="domain_loan">
                              <label class="form-check-label" for="domain_loan">
                                Loan
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" name="domain_erotic" type="checkbox" value="yes" id="domain_erotic">
                              <label class="form-check-label" for="domain_erotic">
                                Erotic
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" name="domain_dating" type="checkbox" value="yes" id="domain_dating">
                              <label class="form-check-label" for="domain_dating">
                                Dating
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" name="domain_cbd" type="checkbox" value="yes" id="domain_cbd">
                              <label class="form-check-label" for="domain_cbd">
                                CBD
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" name="domain_crypto" type="checkbox" value="yes" id="domain_crypto">
                              <label class="form-check-label" for="domain_crypto">
                                Crypto
                              </label>
                            </div>

                        </div>


                        
                        <div class="right-btn-part">

                             <div class="search-product-box">
                                <input type="search" name="seatch_product" id="seatch_product" placeholder="Search ...">
                            </div>    
                            <button id="search-now" data-send="submit" data-page="1">Search Now</button>
                            
                        </div>
                        


                    </div>
                    

                </div>

            </div>    


            
        </section>

        <section class="bottom-product-data">
            
                <div class="container-fluid px-5">
                    <div class="status"></div>
                    <!-- <div class="search-product-box">
                        <input type="search" name="seatch_product" id="seatch_product" placeholder="Search ...">
                    </div> -->
                    <div class="content not-found-msg"></div>

                    
                </div>    

        </section>

        </main>
    <?php
}else{

    ?>
    <section class="login-wrap default-sec bg-gradient-img">
         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/top-bg.png" alt="The Leading High-End Link Building" class="nologin-bg" />
         <div class="nologin-text site-btn-2 c-btn text-center">
             <div class="container">
                <h1>Please login to View Marketplace</h1>
                <a href="<?php echo get_the_permalink(20); ?>">Login</a>
            </div>
         </div>
       
    </section>
    <?php
}




    get_footer();
?>
<script type="text/javascript">
    

(function($) {
    $doc = $(document);

    $numberDiv = $('.product-quantity-no');

    jQuery( document ).ready( function($) {

        $('#show-ajax-msg').hide();

        function reload() {
            window.location = window.location.href.split("?")[0];
        }

        //delete filter-post
        $(document).on( 'click', '.delete-post', function() {
            console.log('Delete Post');
            var id = $(this).data('id');
            var nonce = $(this).data('nonce');
            var post = $(this).parents('.post:first');
            $.ajax({
                type: 'post',
                url: linkbuild.ajax_url,
                dataType: 'json',
                data: {
                    action: 'my_delete_post',
                    nonce: nonce,
                    id: id
                },
                success: function( data, textStatus, XMLHttpRequest ) {
                  
                    console.log(data);
                    console.log(textStatus);

                    $('#show-ajax-msg').show();
                    $('#show-ajax-msg').text(data.message);

                    setTimeout(function(){
                        $('#show-ajax-msg').hide();
                    }, 3000);

                    setTimeout(function(){
                         reload();
                    }, 2000);

                     // location.reload(true);
                     


                }
            })
            return false;
        });

    });

     $(document).on( 'click', '.remove-minus', function(e) {

                e.preventDefault();
                $(".remove-minus").prop('disabled', true);
                productID = $(this).data('removeproduct');
                console.log('remove product : '+ productID);
                // var loadingClass = $(this).next().find('.productQtyCart');
                $(this).next().find('.productQtyCart').addClass('loading');

                $.ajax({
                    url: linkbuild.ajax_url,
                    data: {
                        action: 'remove_product_qty',
                        product_id: productID
                    },
                    type: 'post',
                    dataType: 'json',
                        success: function(data, textStatus, XMLHttpRequest) {
                            
                            //console.log('success :' + data);
                            // console.log('success :' + JSON.stringify(data));
                            if(data.cartQty == null){
                                $('#cartQty_' + productID + ' span').text('0');
                            }else{
                                $('#cartQty_' + productID + ' span').text(data.cartQty);
                            }   
                            
                            $( document.body ).trigger( 'wc_fragment_refresh' );

                            
                           
                     },
                     error: function(MLHttpRequest, textStatus, errorThrown) {

                        console.log("error :"  + textStatus);

                        //$status.html(textStatus);
                    
                     },
                    complete: function(data, textStatus) {

                           $('.productQtyCart').removeClass('loading');

                           
                           $(".remove-minus").prop('disabled', false);
                            
                            // loadingClass.removeClass('loading');
                            //console.log("complete :" + textStatus);
                        
                    }
                });

                return false;


          });


   //ajax to get cart item count for specific product id after product added to cart
    $( document.body ).on( 'added_to_cart', function(event, fragments, cart_hash, $button){
        
        event.preventDefault()
        // if(event.preventDefault) { event.preventDefault(); }

        $this = $(this);

        //var product_id =  $this.attr("data-product_id");
        var product_id =  $($button[0]).data('product_id');
        
        $($button[0]).addClass('loading');
        // console.log(product_id);

        $.ajax({
                url: linkbuild.ajax_url,
                data: {
                    action: 'check_product_quantity',
                    product_id: product_id
                },
                type: 'post',
                dataType: 'json',
                success: function(data, textStatus, XMLHttpRequest) {
                    
                    // console.log('success' + data.content);
                    // console.log('success' + JSON.stringify(data));
                    console.log('#cartQty_' + product_id);

                    $('#cartQty_' + product_id).empty();
                    $('#cartQty_' + product_id).html(data.content);
                    $('#new_cart_' + product_id).css("display", "flex");
                    $('.hide-cart_' + product_id).hide();
                    
                    // if (data.status === 200) {
                    //     $content.html(data.content);
                    // }
                    // else if (data.status === 201) {
                    //     $content.html(data.message);    
                    // }
                    // else {
                    //     $status.html(data.message);
                    // }
             },
             error: function(MLHttpRequest, textStatus, errorThrown) {

                console.log("error" + textStatus);

                //$status.html(textStatus);
            
             },
            complete: function(data, textStatus) {
            
                    console.log("complete" + textStatus);
                    $($button[0]).removeClass('loading');

                    // msg = textStatus;

                    // if (textStatus === 'success') {
                    //     msg = data.responseJSON.found;
                    // }

                    //$status.text('Posts found: ' + msg);
                
            }
         });

        return false;
        
    });

    $doc.ajaxComplete(function() {


      

        
    });

})(jQuery);

</script>
