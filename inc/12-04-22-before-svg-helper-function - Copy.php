<?php


//show global file path

function file_path(){
    global $template;
    echo $template;
}

//add_action('wp_head','file_path');

//order_shortcode
function show_woo_order() {
    $user_id = get_current_user_id();
    if ($user_id == 0) {
         return do_shortcode('[woocommerce_my_account]'); 
    }else{
        ob_start();
        wc_get_template( 'myaccount/my-orders.php', array(
            'current_user'  => get_user_by( 'id', $user_id),
            'order_count'   => $order_count
         ) );
        return ob_get_clean();
    }

}
add_shortcode('show_woo_order', 'show_woo_order');



// hide plugin from plugin list

function hide_plugin_from_list( $plugins ) {
    // let's hide akismet
    if( in_array( 'ajax-form-for-ultimate-member-master/plugin.php', array_keys( $plugins ) ) ) {
        unset( $plugins['ajax-form-for-ultimate-member-master/plugin.php'] );
    }
    return $plugins;
}

//add_filter( 'all_plugins', 'hide_plugin_from_list' );

/**
 * Pagination
 */
function atib_ajax_pagination( $query = null, $paged = 1 ) {

    if (!$query)
        return;

    $paginate = paginate_links([
        'base'      => '%_%',
        'type'      => 'array',
        'total'     => $query->max_num_pages,
        'format'    => '#page=%#%',
        'current'   => max( 1, $paged ),
        'prev_text' => 'Prev',
        'next_text' => 'Next'
    ]);

    if ($query->max_num_pages > 1) : ?>
        <ul class="pagination">
            <?php foreach ( $paginate as $page ) :?>
                <li><?php echo $page; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif;
}




/**
 * AJAX filter posts by taxonomy term
 */
function do_filter_postajax() {
    ob_start();
    if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'linkbuild' ) )
        die('Permission denied');

    /**
     * Default response
     */
    $response = [
        'status'  => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found'   => 0
    ];

    $tax  = sanitize_text_field($_POST['params']['tax']);
    $term = sanitize_text_field($_POST['params']['term']);
    $page = intval($_POST['params']['page']);
    $qty  = intval($_POST['params']['qty']);

    
    $from_domain_rating_dr = intval($_POST['params']['from_domain_rating_dr']);
    $to_domain_rating_dr = intval($_POST['params']['to_domain_rating_dr']);
    
    $from_organic_traffic = intval($_POST['params']['from_organic_traffic']);
    $to_organic_traffic = intval($_POST['params']['to_organic_traffic']);


    $from_domain_age = intval($_POST['params']['from_domain_age']);
    $to_domain_age = intval($_POST['params']['to_domain_age']);

    $from_domain_authority_da = intval($_POST['params']['from_domain_authority_da']);
    $to_domain_authority_da = intval($_POST['params']['to_domain_authority_da']);


    $link_language = sanitize_text_field($_POST['params']['link_language']);

    $domain_casino = sanitize_text_field($_POST['params']['domain_casino']);
    $domain_loan = sanitize_text_field($_POST['params']['domain_loan']);
    $domain_erotic = sanitize_text_field($_POST['params']['domain_erotic']);
    $domain_dating = sanitize_text_field($_POST['params']['domain_dating']);
    $domain_cbd = sanitize_text_field($_POST['params']['domain_cbd']);
    $domain_crypto = sanitize_text_field($_POST['params']['domain_crypto']);


    /**
     * Check if term exists
     */
    if (!term_exists( $term, $tax) && $term != 'all-terms') :
        $response = [
            'status'  => 501,
            'message' => 'Term doesn\'t exist',
            'content' => 0
        ];

        die(json_encode($response));
    endif;

    if ($term == 'all-terms') : 

        $tax_qry[] = [
            'taxonomy' => $tax,
            'field'    => 'slug',
            'terms'    => $term,
            'operator' => 'NOT IN'
        ];

    else :

        $tax_qry[] = [
            'taxonomy' => $tax,
            'field'    => 'slug',
            'terms'    => $term,
        ];

    endif;

    
    /**
     * Setup query
     */
    // $args = [
    //     'paged'          => $page,
    //     'post_type'      => 'post',
    //     'post_status'    => 'publish',
    //     'posts_per_page' => $qty,
    //     'tax_query'      => $tax_qry
    // ];

     $args = array(
            'paged' => $page,
            'posts_per_page' => $qty, //No of product to be fetched
            'post_type' => 'product',
            'tax_query' => $tax_qry,
            'meta_query'  => array(

                'relation' => 'AND',

                    array(
                        'relation' => 'OR',
                    )      
             ),

            'order' => 'ASC',
            'orderby' => 'name',
            'post_status' => 'publish'
            
        );

        //echo $domain_rating_dr."test";
    
        if(!empty($from_domain_rating_dr) || !empty($to_domain_rating_dr)){

             $args['meta_query'][] = array(
                  'key'       => 'domain_rating_dr',
                  'value'     =>  array( $from_domain_rating_dr, $to_domain_rating_dr ),
                  'type'      =>  'numeric',
                  'compare'   =>  'BETWEEN'
              );

      
        }else{

            $args['meta_query'][] = array(
                  'key'       => 'domain_rating_dr',
                  'value'     =>  $from_domain_rating_dr,
                  'type'      =>  'numeric',
                  'compare'   =>  '>='
              );

        }

        if(!empty($from_organic_traffic) || !empty($to_organic_traffic)){

            $args['meta_query'][] = array(
                 'key'       => 'organic_traffic',
                  'value'     =>  array( $from_organic_traffic, $to_organic_traffic ),
                  'type'      =>  'numeric',
                  'compare'   =>  'BETWEEN',
              );
         }else{
            $args['meta_query'][] = array(
                 'key'       => 'organic_traffic',
                  'value'     =>  $from_organic_traffic,
                  'type'      =>  'numeric',
                  'compare'   =>  '>=',
              );
         }

        if(!empty($from_domain_age) || !empty($to_domain_age)){

            $args['meta_query'][] = array(
                 'key'       => 'domain_age',
                  'value'     =>  array( $from_domain_age, $to_domain_age ),
                  'type'      =>  'numeric',
                  'compare'   =>  'BETWEEN',
              );
        }else{

            $args['meta_query'][] = array(
                 'key'       => 'domain_age',
                  'value'     =>  $from_domain_age,
                  'type'      =>  'numeric',
                  'compare'   =>  '>=',
              );

        }

        if(!empty($from_domain_authority_da) || !empty($to_domain_authority_da)){

            $args['meta_query'][] = array(
                 'key'       => 'domain_authority_da',
                  'value'     =>  array( $from_domain_authority_da, $to_domain_authority_da ),
                  'type'      =>  'numeric',
                  'compare'   =>  'BETWEEN',
              );
         }else{

            $args['meta_query'][] = array(
                 'key'       => 'domain_authority_da',
                  'value'     =>  $from_domain_authority_da,
                  'type'      =>  'numeric',
                  'compare'   =>  '>=',
            );

         }


        if(!empty($link_language)){

            $args['meta_query'][] = array(
                 'key'       => 'link_language',
                  'value'    =>  $link_language,
                  //'type'      =>  'numeric',
                  'compare' => 'LIKE'
              );
         }

        if(!empty($domain_casino)){

            $args['meta_query'][][] = array(
                 'key'       => 'domain_casino',
                  'value'    =>  $domain_casino,
                  'compare' => '='
              );
        }

        if(!empty($domain_loan)){

            $args['meta_query'][][] = array(
                 'key'       => 'domain_loan',
                  'value'    =>  $domain_loan,
                  'compare' => '='
              );
        }

        if(!empty($domain_erotic)){

            $args['meta_query'][][] = array(
                 'key'       => 'domain_erotic',
                  'value'    =>  $domain_erotic,
                  'compare' => '='
              );
        }

        if(!empty($domain_dating)){

            $args['meta_query'][][] = array(
                 'key'       => 'domain_dating',
                  'value'    =>  $domain_dating,
                  'compare' => '='
              );
        }

        if(!empty($domain_cbd)){

            $args['meta_query'][][] = array(
                 'key'       => 'domain_cbd',
                  'value'    =>  $domain_cbd,
                  'compare' => '='
              );
        }

        if(!empty($domain_crypto)){

            $args['meta_query'][][] = array(
                 'key'       => 'domain_crypto',
                  'value'    =>  $domain_crypto,
                  'compare' => '='
              );
        }


    $qry = new WP_Query($args);
    
        if ($qry->have_posts()) {

            ?>
            <section class="product-table-format">
                <div class="product-table-wrap">

                    <div class="top-heading-divs">
                        <div class="div_tag_1 table-heading-div">Price/Buy</div>
                        <div class="div_tag_2 table-heading-div">Site</div>
                        <div class="div_tag_3 table-heading-div">Language</div>
                        <div class="div_tag_4 table-heading-div">DR</div>
                        <div class="div_tag_5 table-heading-div">OT</div>
                        <div class="div_tag_6 table-heading-div">DA</div>
                        <div class="div_tag_7 table-heading-div">Domain Authority</div>
                        <div class="div_tag_8 table-heading-div">Niches</div>
                        <div class="div_tag_9 table-heading-div">Category</div>
                    </div>

                    <div class="bottom-product-divs">
            
                            <?php

                            while ($qry->have_posts()) {

                                $qry->the_post(); 

                                $product = wc_get_product(get_the_ID());

                                $product_title = get_the_title();
                                $product_price = $product->get_price();
                                $link_language = get_field('link_language', get_the_ID());
                                $domain_rating_dr = get_field('domain_rating_dr', get_the_ID());
                                $organic_traffic = get_field('organic_traffic', get_the_ID());
                                $domain_age = get_field('domain_age', get_the_ID());
                                $domain_authority_da = get_field('domain_authority_da', get_the_ID());

                                $domain_casino = get_field('domain_casino', get_the_ID());
                                $domain_loan = get_field('domain_loan', get_the_ID());
                                $domain_erotic = get_field('domain_erotic', get_the_ID());
                                $domain_dating = get_field('domain_dating', get_the_ID());
                                $domain_cbd = get_field('domain_cbd', get_the_ID());
                                $domain_crypto = get_field('domain_crypto', get_the_ID());

                                //$productCat = wc_get_product_category_list($product->get_ID());

                                $productCat = get_the_terms( $product->get_ID(), 'product_cat' );



                                if($domain_casino == "Yes"){
                                    $domain_casino_class = "icon-enable";
                                    $domain_casino_text =  "This media accepts casino content.";
                                }else{
                                    $domain_casino_class = "icon-disable";
                                    $domain_casino_text = "This media does not accept casino content";
                                }   

                                if($domain_loan == "Yes"){
                                    $domain_loan_class = "icon-enable";
                                    $domain_loan_text =  "This media accepts loan content.";
                                }else{
                                    $domain_loan_class = "icon-disable";
                                    $domain_loan_text = "This media does not accept loan content";
                                } 

                                if($domain_erotic == "Yes"){
                                    $domain_erotic_class = "icon-enable";
                                    $domain_erotic_text =  "This media accepts erotic content.";
                                }else{
                                    $domain_erotic_class = "icon-disable";
                                    $domain_erotic_text = "This media does not accept erotic content";
                                }

                                if($domain_dating == "Yes"){
                                    $domain_dating_class = "icon-enable";
                                    $domain_dating_text =  "This media accepts dating content.";
                                }else{
                                    $domain_dating_class = "icon-disable";
                                    $domain_dating_text = "This media does not accept dating content";
                                }

                                if($domain_cbd == "Yes"){
                                    $domain_cbd_class = "icon-enable";
                                    $domain_cbd_text =  "This media accepts cbd content.";
                                }else{
                                    $domain_cbd_class = "icon-disable";
                                    $domain_cbd_text = "This media does not accept cbd content";
                                }

                                if($domain_crypto == "Yes"){
                                    $domain_crypto_class = "icon-enable";
                                    $domain_crypto_text =  "This media accepts crypto content.";
                                }else{
                                    $domain_crypto_class = "icon-disable";
                                    $domain_crypto_text = "This media does not accept crypto content";
                                }   


                                ?>

                                <article class="table-loop-item product_<?php echo $product->get_ID(); ?>">

                                        <div class="item_tag_1 table-data-div">

                                            <div class="add-to-cart">
                        
                                                <form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart-field cart" method="post" enctype='multipart/form-data'>

                                                   <?php woocommerce_quantity_input(); ?>

                                                    <button type="submit" data-quantity="1" data-product_id="<?php echo $product->get_ID(); ?>"
                                                    class="button alt ajax_add_to_cart add_to_cart_button product_type_simple">
                                                    <?php echo 'Buy'; ?>
                                                        
                                                    </button>

                                                </form>

                                                <div class="f-price">
                                                    <p><?php echo "$".$product_price; ?></p>
                                                </div>
                         
                                            </div>

                                        </div>
                                        <div class="item_tag_2 table-data-div">
                                            <p><?php echo $product_title; ?></p>
                                        </div>

                                        <div class="item_tag_3 table-data-div">
                                            
                                            <p><?php echo $link_language; ?></p>
                                                
                                        </div>
                                        <div class="item_tag_4 table-data-div">
                                                <p><?php echo $domain_rating_dr; ?></p>
                                        </div>
                                        <div class="item_tag_5 table-data-div">
                                                 <p><?php echo $organic_traffic; ?></p>
                                        </div>
                                        <div class="item_tag_6 table-data-div">
                                             <p><?php echo $domain_age; ?></p>       
                                        </div>
                                        <div class="item_tag_7 table-data-div">
                                            <p><?php echo $domain_authority_da; ?></p>
                                        </div>
                                        <div class="item_tag_8 table-data-div">
                                        
                                            <ul class="niche-list">
                                                <li class="<?php echo $domain_casino_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_casino_text; ?>">
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 463 463" style="enable-background:new 0 0 463 463;" xml:space="preserve">
                                                    <g transform="translate(0 -540.36)">
                                                        <g>
                                                            <g>
                                                                <path d="M357.35,540.36h-253c-21.9,0-40.4,18.3-40.4,39.9v382c0,22.7,18.1,41.1,40.4,41.1h253c23,0,41.7-18.4,41.7-41.1v-382
                                                                    C399.05,558.26,380.35,540.36,357.35,540.36z M384.15,962.26c0,14.6-11.8,26.1-26.7,26.1h-253c-13.8,0-25.4-12-25.4-26.1v-382
                                                                    c0-13.3,11.9-24.9,25.4-24.9h253c14.5,0,26.7,11.4,26.7,24.9V962.26z"/>
                                                                <circle cx="184.45" cy="962.858" r="7.5"/>
                                                                <path d="M155.65,955.36h-34.2c-5,0-8.9-4.3-8.9-9.9v-32.4c0-4.1-3.4-7.5-7.5-7.5c-4.1,0-7.5,3.4-7.4,7.5v32.4
                                                                    c0,13.7,10.7,24.9,23.9,24.9h34.1c4.1,0,7.5-3.4,7.5-7.5S159.75,955.36,155.65,955.36z"/>
                                                                <circle cx="278.65" cy="580.858" r="7.5"/>
                                                                <path d="M341.65,573.36h-34.2c-4.1,0-7.5,3.4-7.5,7.5s3.4,7.5,7.5,7.5h34.2c5,0,8.9,4.3,8.9,9.9v32.4c0,4.1,3.4,7.5,7.5,7.5
                                                                    c4.1,0,7.5-3.4,7.5-7.5v-32.4C365.55,584.56,354.85,573.36,341.65,573.36z"/>
                                                                <path d="M313.45,783.46l-75.9-99.6c-1.4-1.9-3.6-3-6-3c-2.4,0-4.5,1.1-6,3l-75.9,99.6c-1.3,1.7-1.8,3.9-1.4,6.1
                                                                    c0.4,2.1,1.8,4,3.7,5l37.9,21.2c2.3,1.3,5,1.3,7.3,0l19.8-11c-4.8,12.4-10,27.1-10,33.1c0,13.7,10.7,24.9,23.9,24.9
                                                                    c14.4,0,25.2-10.7,25.2-24.9c0-6.1-5.7-21.1-11-33.6l20.7,11.5c1.1,0.6,2.4,0.9,3.7,0.9s2.5-0.3,3.7-0.9l37.9-21.2
                                                                    c1.9-1.1,3.2-2.9,3.7-5S314.75,785.26,313.45,783.46L313.45,783.46z M230.95,847.76c-5,0-8.9-4.4-8.9-9.9
                                                                    c0-3.2,4.1-15.1,9.2-28.1c5.4,12.9,9.9,24.8,10,28.1C241.15,843.66,236.95,847.76,230.95,847.76z M269.45,800.56l-34.3-19.1
                                                                    c-1.1-0.6-2.4-0.9-3.7-0.9c-1.3,0-2.5,0.3-3.7,0.9l-34.3,19.1l-26.7-14.9l64.7-84.8l64.7,84.8L269.45,800.56z"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    </svg>
                                                </li>
                                                <li class="<?php echo $domain_loan_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_loan_text; ?>">
                                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 199.027 199.027" style="enable-background:new 0 0 199.027 199.027;" xml:space="preserve">
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <path style="fill:#010002;" d="M99.514,0.009C44.657,0.009,0,44.648,0,99.522c0,54.853,44.657,99.496,99.514,99.496
                                                                    c54.871,0,99.514-44.643,99.514-99.496C199.027,44.648,154.384,0.009,99.514,0.009z M99.514,189.43
                                                                    c-49.581,0-89.926-40.33-89.926-89.911S49.932,9.593,99.514,9.593s89.926,40.344,89.926,89.926S149.095,189.43,99.514,189.43z"/>
                                                            </g>
                                                            <g>
                                                                <path style="fill:#010002;" d="M104.288,92.54c-13.199-5.604-17.823-9.538-17.823-17.264c0-6.202,3.418-13.184,15.092-13.184
                                                                    c9.699,0,15.901,3.5,19.086,5.307l3.783-9.999c-4.549-2.57-10.747-5.007-19.684-5.29V37.383H95.19v15.156
                                                                    c-13.796,2.29-22.719,11.825-22.719,24.393c0,13.184,9.552,20.296,24.988,26.365c11.227,4.545,16.169,9.702,16.151,18.027
                                                                    c0.018,8.654-6.302,14.856-17.046,14.856c-8.493,0-16.384-3.021-21.674-6.499l-3.633,10.132
                                                                    c5.29,3.783,14.244,6.517,23.016,6.682v15.139h9.552v-15.751c15.6-2.423,23.943-13.646,23.943-25.753
                                                                    C127.772,106.652,119.892,98.921,104.288,92.54z"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    </svg>

                                                </li>
                                                <li class="<?php echo $domain_erotic_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_erotic_text; ?>">
                                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 328.863 328.863" style="enable-background:new 0 0 328.863 328.863;" xml:space="preserve">
                                                    <g id="_x34_4-18Plus_movie">
                                                        <g>
                                                            <path d="M104.032,220.434V131.15H83.392V108.27h49.121v112.164H104.032z"/>
                                                        </g>
                                                        <g>
                                                            <path d="M239.552,137.23c0,9.76-5.28,18.4-14.08,23.201c12.319,5.119,20,15.84,20,28.32c0,20.16-17.921,32.961-45.921,32.961
                                                                c-28.001,0-45.921-12.641-45.921-32.48c0-12.801,8.32-23.682,21.28-28.801c-9.44-5.281-15.52-14.24-15.52-24
                                                                c0-17.922,15.681-29.281,40.001-29.281C224.031,107.15,239.552,118.83,239.552,137.23z M180.51,186.352
                                                                c0,9.441,6.721,14.721,19.041,14.721c12.32,0,19.2-5.119,19.2-14.721c0-9.279-6.88-14.561-19.2-14.561
                                                                C187.23,171.791,180.51,177.072,180.51,186.352z M183.391,138.83c0,8.002,5.76,12.48,16.16,12.48c10.4,0,16.16-4.479,16.16-12.48
                                                                c0-8.318-5.76-12.959-16.16-12.959C189.15,125.871,183.391,130.512,183.391,138.83z"/>
                                                        </g>
                                                        <g>
                                                            <path d="M292.864,120.932c4.735,13.975,7.137,28.592,7.137,43.5c0,74.752-60.816,135.568-135.569,135.568
                                                                S28.862,239.184,28.862,164.432c0-74.754,60.816-135.568,135.569-135.568c14.91,0,29.527,2.4,43.5,7.137V5.832
                                                                C193.817,1.963,179.24,0,164.432,0C73.765,0,0.001,73.764,0.001,164.432s73.764,164.432,164.431,164.432
                                                                S328.862,255.1,328.862,164.432c0-14.807-1.962-29.385-5.831-43.5H292.864z"/>
                                                        </g>
                                                        <g>
                                                            <polygon points="284.659,44.111 284.659,12.582 261.987,12.582 261.987,44.111 230.647,44.111 230.647,66.781 261.987,66.781 
                                                                261.987,98.309 284.659,98.309 284.659,66.781 316.186,66.781 316.186,44.111      "/>
                                                        </g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    </svg>

                                                </li>
                                                <li class="<?php echo $domain_dating_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_dating_text; ?>">
                                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 490.4 490.4" style="enable-background:new 0 0 490.4 490.4;" xml:space="preserve">
                                                    <g>
                                                        <g>
                                                            <path d="M222.5,453.7c6.1,6.1,14.3,9.5,22.9,9.5c8.5,0,16.9-3.5,22.9-9.5L448,274c27.3-27.3,42.3-63.6,42.4-102.1
                                                                c0-38.6-15-74.9-42.3-102.2S384.6,27.4,346,27.4c-37.9,0-73.6,14.5-100.7,40.9c-27.2-26.5-63-41.1-101-41.1
                                                                c-38.5,0-74.7,15-102,42.2C15,96.7,0,133,0,171.6c0,38.5,15.1,74.8,42.4,102.1L222.5,453.7z M59.7,86.8
                                                                c22.6-22.6,52.7-35.1,84.7-35.1s62.2,12.5,84.9,35.2l7.4,7.4c2.3,2.3,5.4,3.6,8.7,3.6l0,0c3.2,0,6.4-1.3,8.7-3.6l7.2-7.2
                                                                c22.7-22.7,52.8-35.2,84.9-35.2c32,0,62.1,12.5,84.7,35.1c22.7,22.7,35.1,52.8,35.1,84.8s-12.5,62.1-35.2,84.8L251,436.4
                                                                c-2.9,2.9-8.2,2.9-11.2,0l-180-180c-22.7-22.7-35.2-52.8-35.2-84.8C24.6,139.6,37.1,109.5,59.7,86.8z"/>
                                                        </g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    </svg>
                                                    
                                                </li>
                                                <li class="<?php echo $domain_cbd_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_cbd_text; ?>">
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                        <g>
                                                            <g>
                                                                <path d="M28.899,419.625h-13.18c-4.199,0-7.604,3.404-7.604,7.604c0,4.2,3.404,7.604,7.604,7.604h13.18
                                                                    c4.199,0,7.604-3.404,7.604-7.604C36.503,423.029,33.098,419.625,28.899,419.625z"/>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M495.615,419.625h-29.749c-4.2,0-7.604,3.404-7.604,7.604c0,4.2,3.403,7.604,7.604,7.604h29.749
                                                                    c4.2,0,7.604-3.404,7.604-7.604C503.219,423.029,499.815,419.625,495.615,419.625z"/>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M509.931,306.387c-4.223-8.957-13.958-13.901-23.679-12.012c-19.742,3.827-40.243,11.165-61.203,21.886
                                                                    c29.326-47.098,55.604-81.421,56.079-82.037c3.334-4.412,5.212-6.784,5.229-6.806c6.16-7.751,6.278-18.668,0.285-26.55
                                                                    c-5.994-7.884-16.546-10.692-25.659-6.82c-22.151,9.394-44.233,23.893-65.929,43.208c21.605-54.219,40.623-90.199,40.814-90.561
                                                                    c4.654-8.74,2.787-19.497-4.538-26.16c-7.323-6.663-18.21-7.505-26.474-2.049c-25.234,16.666-48.887,41.186-70.451,72.996
                                                                    c10.247-51.647,20.677-86.116,20.789-86.482c2.897-9.467-0.796-20.003-9.451-24.811c-10.831-6.015-22.17-0.801-26.377,3.046
                                                                    c-35.738,32.675-62.113,102.385-62.693,103.958c-0.533-1.506-29.82-74.576-60.387-104.014c-7.136-6.873-17.65-8.385-26.043-3.191
                                                                    c-8.247,5.102-12.083,15.242-9.329,24.66c0.114,0.388,11.008,37.994,21.163,93.876c-22.758-35.114-47.942-61.93-74.932-79.755
                                                                    c-8.262-5.46-19.148-4.615-26.473,2.049c-7.324,6.662-9.19,17.42-4.513,26.209c0.39,0.72,20.136,37.483,41.821,91.405
                                                                    c-22.027-19.774-44.459-34.558-66.96-44.101c-9.117-3.867-19.668-1.063-25.661,6.821c-5.993,7.881-5.874,18.798,0.286,26.549
                                                                    c0.263,0.331,36.711,47.169,60.716,88.277c-20.753-10.556-41.057-17.809-60.611-21.6c-9.721-1.895-19.459,3.053-23.68,12.01
                                                                    c-4.222,8.955-1.835,19.609,5.798,25.904c0.327,0.271,33.234,27.568,75.31,71.16c5.123,5.307,10.235,10.719,15.301,16.176H54.92
                                                                    c-4.199,0-7.604,3.403-7.604,7.604s3.404,7.604,7.604,7.604h60.829h0.001c0,0,8.184,0.279,7.774-7.322
                                                                    c-0.338-6.263-20.121-25.003-29.405-34.624c-42.731-44.277-76.233-72.047-76.572-72.326c-2.267-1.871-2.976-5.032-1.722-7.691
                                                                    c1.253-2.657,4.143-4.129,7.029-3.565c25.196,4.885,51.918,16.031,79.433,33.114c17.256,29.558,32.729,59.138,46.167,88.276
                                                                    c1.243,2.693,3.938,4.418,6.905,4.418h23.082c2.183,0,4.26-0.938,5.704-2.575c1.444-1.637,2.114-3.817,1.84-5.982
                                                                    C168.269,286.38,90.317,141.232,89.558,139.832c-1.381-2.594-0.826-5.787,1.348-7.765c2.175-1.978,5.431-2.266,7.857-0.609
                                                                    c47.742,32.61,76.806,78.571,90.097,108.554c7.565,52.066,13.677,118.721,9.849,185.061c-0.066,0.678-0.625,9.438,7.466,9.673
                                                                    l125.31,0.084c3.691,0,6.85-2.65,7.489-6.286c10.3-58.539,27.605-114.371,43.199-157.418
                                                                    c27.835-29.805,56.342-51.033,84.748-63.079c2.703-1.148,5.837-0.315,7.615,2.024c1.779,2.341,1.745,5.581-0.082,7.88
                                                                    c-0.019,0.022-84.287,107.149-123.112,206.446c-0.92,2.351-0.655,4.999,0.759,7.09c1.414,2.092,3.773,3.344,6.298,3.344h80.431
                                                                    c4.2,0,7.604-3.403,7.604-7.604s-3.404-7.604-7.604-7.604h-25.309c5.063-5.452,10.174-10.864,15.301-16.176
                                                                    c41.953-43.463,74.985-70.891,75.304-71.155C511.765,325.996,514.153,315.341,509.931,306.387z M130.549,272.172
                                                                    c0.171,0.185,0.35,0.359,0.534,0.522c16.065,44.315,31.286,95.915,38.658,147.213h-9.529
                                                                    c-17.756-37.985-38.875-76.649-62.816-114.995c-32.828-52.581-59.582-86.342-59.846-86.675c-1.829-2.301-1.863-5.542-0.085-7.881
                                                                    c1.779-2.341,4.91-3.172,7.617-2.025C73.731,220.483,102.487,241.961,130.549,272.172z M214.23,419.578
                                                                    c3.943-81.387-6.385-162.35-15.898-216.543c-10.7-60.956-22.702-102.245-22.821-102.653c-0.841-2.876,0.283-5.944,2.733-7.46
                                                                    c2.307-1.423,5.262-1.052,7.189,0.911c22.084,22.495,40.707,54.158,55.353,94.106c2.716,7.408,5.328,15.218,7.78,23.219
                                                                    c-26.53,84.204-30.659,190.003-30.955,208.434L214.23,419.578z M232.819,419.624c0.293-18.076,1.973-66.181,11.26-121.978
                                                                    c6.857-41.197,16.463-78.11,28.552-109.712c15.253-39.875,34.561-71.448,57.388-93.844c1.208-1.185,4.219-2.85,7.829-0.904
                                                                    c2.587,1.394,3.665,4.554,2.804,7.372c-0.127,0.415-12.751,42.1-23.963,102.56c-10.043,54.155-21.052,135.086-17.379,216.507
                                                                    H232.819z M325.129,419.625h-10.591c-3.129-67.788,4.153-135.419,12.477-187.051c0.214-0.284,41.773-78.388,86.219-101.396
                                                                    c2.613-1.352,5.685-1.371,7.859,0.608c2.175,1.979,2.727,5.171,1.345,7.767C422.239,139.934,357.385,245.177,325.129,419.625z
                                                                     M494.442,320.568c-1.37,1.133-34.023,28.247-76.564,72.319c-8.426,8.729-16.827,17.713-25.005,26.738h-23.087
                                                                    c11.203-26.132,25.104-52.479,39.25-76.79v-0.001c27.754-17.323,54.706-28.604,80.111-33.529c2.878-0.557,5.774,0.906,7.028,3.567
                                                                    C497.428,315.529,496.719,318.691,494.442,320.568z"/>
                                                            </g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                        <g>
                                                        </g>
                                                    </svg>

                                                </li>

                                                <li class="<?php echo $domain_crypto_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_crypto_text; ?>">
                                                    
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 463 463" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 463 463">
                                                      <g>
                                                        <path d="M395.195,67.805C351.471,24.08,293.336,0,231.5,0S111.529,24.08,67.805,67.805S0,169.664,0,231.5   s24.08,119.971,67.805,163.695S169.664,463,231.5,463s119.971-24.08,163.695-67.805S463,293.336,463,231.5   S438.92,111.529,395.195,67.805z M384.589,384.589C343.697,425.48,289.329,448,231.5,448s-112.197-22.52-153.089-63.411   S15,289.329,15,231.5S37.52,119.303,78.411,78.411S173.671,15,231.5,15s112.197,22.52,153.089,63.411S448,173.671,448,231.5   S425.48,343.697,384.589,384.589z"/>
                                                        <path d="M305.426,209.309C318.596,198.386,327,181.907,327,163.5c0-32.809-26.691-59.5-59.5-59.5H231V79.5   c0-4.143-3.357-7.5-7.5-7.5s-7.5,3.357-7.5,7.5V104h-17V79.5c0-4.143-3.357-7.5-7.5-7.5s-7.5,3.357-7.5,7.5V104h-56.5   c-4.143,0-7.5,3.357-7.5,7.5s3.357,7.5,7.5,7.5H144v225h-16.5c-4.143,0-7.5,3.357-7.5,7.5s3.357,7.5,7.5,7.5H184v24.5   c0,4.143,3.357,7.5,7.5,7.5s7.5-3.357,7.5-7.5V359h17v24.5c0,4.143,3.357,7.5,7.5,7.5s7.5-3.357,7.5-7.5V359h60.5   c41.631,0,75.5-33.869,75.5-75.5C367,246.628,340.424,215.865,305.426,209.309z M267.5,119c24.537,0,44.5,19.963,44.5,44.5   S292.037,208,267.5,208H159v-89H267.5z M291.5,344H159V223h108.5h24c33.359,0,60.5,27.141,60.5,60.5S324.859,344,291.5,344z"/>
                                                      </g>
                                                    </svg>

                                                </li>
                                            </ul>
                                        </div>
                                        <div class="item_tag_9 table-data-div">
                                                
                                             <ul class="table-category">
                                                 
                                                 <?php 
                                                    
                                                   foreach ($productCat as $product_cat) {
                                                       echo '<li>'.$product_cat->name.'</li>';
                                                   }
                                                    
                                                 ?>
                                             </ul>   

                                        </div> 

                                   <!--  <a href="<?php echo site_url(); ?>/?add-to-cart=<?php echo get_the_ID(); ?>&quantity=1">Buy Now</a> -->
                                </article>

                            <?php }

                            ?>
                        </div> <!-- end bottom product div -->

                    </div> <!-- end-product-table-wrap -->

                </section> <!-- end-product-table-format -->    
            <?php
            /**
             * Pagination
             */
            atib_ajax_pagination($qry,$page);

            
            $response = [
                'status'=> 200,
                'found' => $qry->found_posts
            ];

            
        }else{

            $response = [
                'status'  => 201,
                'message' => 'No posts found'
            ];

        }

    $response['content'] = ob_get_clean();

    die(json_encode($response));

}
add_action('wp_ajax_do_filter_postajax', 'do_filter_postajax');
add_action('wp_ajax_nopriv_do_filter_postajax', 'do_filter_postajax');




// submit note ajax function

add_action( 'wp_ajax_collect_feedback', 'collect_feedback' );
add_action( 'wp_ajax_nopriv_collect_feedback', 'collect_feedback' );

function collect_feedback(){

    if( !isset( $_POST['thankyou_nonce'] ) || !wp_verify_nonce( $_POST['thankyou_nonce'], 'thankyou_note' ) )
        die('Permission denied');

    // security check
    var_dump($_POST);

    $notedata = sanitize_text_field($_POST['note-form-text']);
   
    
    if( $order = wc_get_order( $_POST['order_id'] ) ) {
        $note = $notedata;
        $order->add_order_note( $note, 0, true );
    }

}