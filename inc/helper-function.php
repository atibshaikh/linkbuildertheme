<?php


//show global file path

function file_path(){
    global $template;
    echo $template;
}
//add_action('wp_head','file_path');

//register sales person posttype
function salesperson_post_type() {

    /**
     * Post Type: Sales Person.
     */

    $labels = [
        "name" => __( "Account Manager", "linkbuilding" ),
        "singular_name" => __( "Account Manager", "linkbuilding" ),
    ];

    $args = [
        "label" => __( "Account Manager", "linkbuilding" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => [ "slug" => "salesperson", "with_front" => true ],
        "query_var" => true,
        "menu_icon" => "dashicons-admin-users",
        "supports" => [ "title", "editor", "thumbnail", "page-attributes" ],
        "show_in_graphql" => false,
    ];

    register_post_type( "salesperson", $args );
}

add_action( 'init', 'salesperson_post_type' );


//save filter post type
function cptui_register_my_cpts_save_filter() {

    /**
     * Post Type: Saved Form filters.
     */

    $labels = [
        "name" => __( "Saved Form filters", "linkbuilding" ),
        "singular_name" => __( "Form filter", "linkbuilding" ),
    ];

    $args = [
        "label" => __( "Saved Form filters", "linkbuilding" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => [ "slug" => "save_filter", "with_front" => true ],
        "query_var" => true,
        "menu_icon" => "dashicons-filter",
        "supports" => [ "title", "author", "page-attributes" ],
        "show_in_graphql" => false,
    ];

    register_post_type( "save_filter", $args );
}

add_action( 'init', 'cptui_register_my_cpts_save_filter' );


if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Theme Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    
}

function acf_select_col_show_hide_field( $field ) {
    
    // reset choices
    $field['choices'] = array();

    $field['choices'][ 'dr' ] = 'DR';
    $field['choices'][ 'ot' ] = 'OT';
    $field['choices'][ 'rd' ] = 'RD';
    $field['choices'][ 'da' ] = 'DA';
    $field['choices'][ 'lang' ] = 'Language';
    $field['choices'][ 'niches' ] = 'NICHES';
    $field['choices'][ 'category' ] = 'Category';



    $allGroupField = acf_get_fields_by_id(183);
                                                
    $all_sub_field = $allGroupField[0]['sub_fields'];

        
    foreach ($all_sub_field as $field_items) {

        $field_label = $field_items['label'];
        $extra_fields_name = $field_items['_name'];

        $field['choices'][ $extra_fields_name ] = $field_label;
    }

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=control_marketplace_col', 'acf_select_col_show_hide_field');




//get all product query

function get_all_products($day='',$month='',$year='') {

     $product_args = array(
            'posts_per_page' => -1, 
            'post_type' => 'product',
            'order' => 'DESC',
            'orderby' => 'ID',
            'post_status' => 'publish'
    );

     if(!empty($day) || !empty($month) || !empty($year)){

        $product_args['date_query'][] =  array(
                    'year'  => $year,
                    'month' => $month,
                    'day'   => $day,
              );
     }

    // 'date_query' => array(
    //     array(
    //         'year'  => 2012,
    //         'month' => 12,
    //         'day'   => 12,
    //     ),
    // ),

    $product_query = new Wp_Query ($product_args);

    return $product_query;
}



//order_shortcode you can use this shorcode anywhere to show woocommerce order table
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
  
    if( in_array( 'admin-columns-pro/admin-columns-pro.php', array_keys( $plugins ) ) ) {
        unset( $plugins['admin-columns-pro/admin-columns-pro.php'] );
    }
     // let's hide akismet
    if( in_array( 'ac-addon-acf/ac-addon-acf.php', array_keys( $plugins ) ) ) {
        unset( $plugins['ac-addon-acf/ac-addon-acf.php'] );
    }
    return $plugins;
}

add_filter( 'all_plugins', 'hide_plugin_from_list' );


//disable plugin update
function disable_plugin_update( $value ) {

    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response[ 'yith-woocommerce-uploads-premium/init.php' ] );
    }

    return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_update' );


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
        'prev_text' => '<span class="prev-page pagination-btn">Prev</span>',
        'next_text' => '<span class="next-page pagination-btn">Next</span>'
    ]);

    if ($query->max_num_pages > 1) : ?>
        <ul class="pagination marketplace-pagination">
            <?php foreach ( $paginate as $page ) :?>
                <li><?php echo $page; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif;
}


//action to Save filter from marketplace search form using ajax 
add_action('wp_ajax_save_filter_ajax', 'save_filter_ajax');
add_action('wp_ajax_nopriv_save_filter_ajax', 'save_filter_ajax');

function save_filter_ajax() {

    ob_start();

    if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'linkbuild' ) )

    die('Permission denied');
    $tax  = sanitize_text_field($_POST['params']['tax']);
    $term = sanitize_text_field($_POST['params']['term']);

    $filterName = sanitize_text_field($_POST['params']['filterName']);
   

    
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

    $sort_field_data = sanitize_text_field($_POST['params']['sort_field_data']);
    $sort_order_data = sanitize_text_field($_POST['params']['sort_order_data']);


    $data_json = array();
        
    $data_json[] = array(
        'from_domain_rating_dr' => $from_domain_rating_dr,
        'to_domain_rating_dr' => $to_domain_rating_dr,
        'from_organic_traffic' => $from_organic_traffic,
        'to_organic_traffic' => $to_organic_traffic,
        'from_domain_age' => $from_domain_age,
        'to_domain_age' => $to_domain_age,
        'from_domain_authority_da' => $from_domain_authority_da,
        'to_domain_authority_da' => $to_domain_authority_da,
        'link_language' => $link_language,
        'domain_casino' => $domain_casino,
        'domain_loan' => $domain_loan,
        'domain_erotic' => $domain_erotic,
        'domain_dating' => $domain_dating,
        'domain_cbd' => $domain_cbd,
        'domain_crypto' => $domain_crypto,
        'sort_field_data' => $sort_field_data,
        'sort_order_data' => $sort_order_data,
        'term'=> $term
    );

    $dataInToJson = json_encode($data_json);

    if(is_user_logged_in()){
        
        global $current_user; 
        $userID = $current_user->ID;
        $user_login = $current_user->user_login;
        $date = date('Y/m/d H:i:s');


        $filterQuery = get_author_save_filter_post($userID);
        $total_post = $filterQuery->found_posts;
        if(!empty($filterName)){
            $favFilterName = $filterName;
        }else{
            $favFilterName = $user_login;
        }
        $args = array(
            'post_title' => $favFilterName . ' - ' .$date ,
            'post_author' => $userID,
            'post_status' => 'Publish',
            'post_type' => 'save_filter',
            'meta_input' => array(
                'form_json' => $dataInToJson,
            )
        );

        if($total_post < 3){

            $postID = wp_insert_post($args);

            if($postID){
                $postMessage =  "Filter Save successfully!";
            } else {
                $postMessage = "Something went wrong, try again.";
            }

        }else{

            $postMessage = "You can save 3 fav filter only";
        }

    }

    $response = [
        'status'  => 'success',
        'message' =>  $postMessage,
    ];

    die(json_encode($response));

    wp_die();

}


/**
 * ajax to show marketplace product list
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

    $seatch_product = sanitize_text_field($_POST['params']['seatch_product']);

    
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

    $sort_field_data = sanitize_text_field($_POST['params']['sort_field_data']);
    $sort_order_data = sanitize_text_field($_POST['params']['sort_order_data']);


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

            // 'meta_key'   => 'domain_rating_dr',
            // 'orderby' => 'meta_value',
            // 'order' => 'DESC',
            'post_status' => 'publish'
            
        );

        if(!empty($sort_field_data) || !empty($sort_order_data)){
            $args['meta_key'] = $sort_field_data;
            $args['orderby'] = 'meta_value_num';
            $args['order'] = $sort_order_data;
        }else{
            $args['orderby'] = 'ID';
            $args['order'] = 'DESC';
            
        }

        if(!empty($seatch_product)){
                $args['s']  = $seatch_product;
        }
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


        $control_marketplace_col = get_field('control_marketplace_col', 'option');

        //print_r($control_marketplace_col);

                                      


    $qry = new WP_Query($args);
    
        if ($qry->have_posts()) {

            ?>
            <section class="product-table-format">
                <div class="product-table-wrap">

                    <div class="top-heading-divs">

                        <div class="div_tag_1 table-heading-div">Price/Buy</div>
                        <div class="div_tag_wishlist table-heading-div hide">Add to Wishlist</div>

                        <div class="div_tag_2 table-heading-div">Site</div>

                        

                        <?php 

                            if( !in_array('lang', $control_marketplace_col) ){
                                ?>
                                <div class="div_tag_3 table-heading-div check_lang">Language</div>
                                <?php
                            }

                            if( !in_array('dr', $control_marketplace_col) ){

                               ?>
                               <div class="div_tag_4 table-heading-div csort orderby-data check_dr" data-sort="domain_rating_dr" data-order="DESC">DR</div>
                               <?PHP

                            }

                        
                            if( !in_array('ot', $control_marketplace_col) ){

                               ?>
                               <div class="div_tag_5 table-heading-div csort orderby-data check_ot" data-sort="organic_traffic" data-order="DESC">OT</div>
                               <?PHP

                            }

                            if( !in_array('rd', $control_marketplace_col) ){

                               ?>
                               <div class="div_tag_6 table-heading-div csort orderby-data check_rd" data-sort="domain_age" data-order="DESC">RD</div>
                               <?PHP

                            }

                            if( !in_array('da', $control_marketplace_col) ){

                               ?>
                               <div class="div_tag_7 table-heading-div csort orderby-data check_da" data-sort="domain_authority_da" data-order="DESC">Domain Authority</div>
                               <?PHP

                            }

                            if( !in_array('niches', $control_marketplace_col) ){

                               ?>
                               <div class="div_tag_8 table-heading-div check_niches">Niches</div>
                               <?PHP

                            }

                            if( !in_array('category', $control_marketplace_col) ){

                               ?>
                               <div class="div_tag_9 table-heading-div check_category">Category</div>
                               <?PHP

                            }
                        
                     
                        // extraa custom field 
                       

                            $allGroupField = acf_get_fields_by_id(183);
                                            
                            $all_sub_field = $allGroupField[0]['sub_fields'];

                            $efc = 10;
                            foreach ($all_sub_field as $field_items) {

                                $field_label = $field_items['label'];
                                $extra_fields_name = $field_items['_name'];

                                if( !in_array($extra_fields_name, $control_marketplace_col) ){
                                    ?>
                                    <div class="div_tag_<?php echo $efc; ?> table-heading-div extra-field check_<?php echo $extra_fields_name; ?>">
                                         <?php echo $field_label; ?>
                                    </div>
                                    <?php
                                }

                                
                                $efc++;
                            }

                        ?>


                    </div>

                    <div class="bottom-product-divs">
            
                            <?php

                            while ($qry->have_posts()) {

                                $qry->the_post(); 

                                $product = wc_get_product(get_the_ID());

                                $product_title = get_the_title();
                                $product_price = $product->get_price();
                                $shorten_title = get_field('shorten_title',get_the_ID());

                                
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

                                $productInCart = check_product_qty_cart($product->get_ID());
                                ?>

                                <article class="table-loop-item product_<?php echo $product->get_ID(); ?>">

                                        <div class="item_tag_1 table-data-div">

                                            <div class="add-to-cart">
                                                <!-- <a href="<?php echo get_the_permalink(26); ?>?add-to-cart=<?php echo $product->get_ID(); ?>&quantity=1">Buy</a> -->
                                                <?php 

                                                if(!empty($productInCart)){
                                                    $showClass = "show-cart-box";
                                                }else{
                                                    $showClass = "";
                                                } 
                                                ?>
                                                <div class="new-product-addcart <?php echo $showClass; ?>" id="new_cart_<?php echo $product->get_ID(); ?>">
                                                        <button type="submit" data-nonce="<?php echo wp_create_nonce('my_delete_post_nonce') ?>" data-removeproduct="<?php echo $product->get_ID(); ?>" class="remove-minus btn-plus-minus">
                                                                <i class="fal fa-minus-circle"></i>
                                                        </button>

                                                        <p class="product-quantity-no" id="cartQty_<?php echo $product->get_ID(); ?>">
                                                                <?php 
                                                                    echo '<span class="productQtyCart">'.$productInCart.'</span>'; 
                                                                ?>
                                                                    
                                                        </p>

                                                        <button type="submit" data-quantity="1" data-product_id="<?php echo $product->get_ID(); ?>" class="button alt ajax_add_to_cart add_to_cart_button product_type_simple btn-plus-minus">
                                                                <i class="fal fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                    
                                                    <?php 
                                                        if(empty($productInCart)){
                                                            ?>
                                                            <form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart-field cart" method="post" enctype='multipart/form-data'>

                                                               <?php woocommerce_quantity_input(); ?>

                                                                <button type="submit" data-quantity="1" data-product_id="<?php echo $product->get_ID(); ?>"
                                                                class="button alt ajax_add_to_cart add_to_cart_button product_type_simple custom-added-cart hide-cart_<?php echo $product->get_ID(); ?>">
                                                                <?php echo 'Buy'; ?>
                                                                    
                                                                </button>

                                                            </form>
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                
         
                                                <div class="f-price">
                                                    <p><?php echo "$".$product_price; ?></p>
                                                </div>
                         
                                            </div>

                                        </div>

                                        <div class="item_tag_wishlist table-data-div hide">
                                            <?php 
                                                echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                                            ?>
                                        </div>
                                        <div class="item_tag_2 table-data-div">
                                            
                                            <?php 

                                                if($shorten_title == "Yes"){

                                                    $title_hl = ( strlen($product_title) / 2 );
                                                    $trimTitle = substr($product_title, 0, -$title_hl);

                                                    echo '<p> '.$trimTitle.'<span class="half-url-note" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Buy to check full media url"><i class="fas fa-info-circle"></i></span></p>';
                                                }else{
                                                    
                                                    echo '<p>'.$product_title.'</p>';
                                                }
                                            
                                                echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                                            ?>
                                                    
                                           
                                        </div>


                                        
                                        <?php 

                                            if( !in_array('lang', $control_marketplace_col) ){
                                                ?>
                                                <div class="item_tag_3 table-data-div check_lang">
                                            
                                                    <p><?php echo $link_language; ?></p>
                                                        
                                                </div>
                                                <?php   
                                            }

                                            if( !in_array('dr', $control_marketplace_col) ){
                                               ?>
                                               <div class="item_tag_4 table-data-div check_dr">
                                                        <p><?php echo $domain_rating_dr; ?></p>
                                                </div>
                                               <?php 
                                            }

                                            if( !in_array('ot', $control_marketplace_col) ){
                                               ?>
                                                <div class="item_tag_5 table-data-div check_ot">
                                                    <p><?php echo number_format((int)$organic_traffic); ?></p>
                                                </div>
                                               <?php 
                                            }

                                            if( !in_array('rd', $control_marketplace_col) ){
                                               ?>
                                                <div class="item_tag_6 table-data-div check_rd">
                                                     <p><?php echo number_format((int)$domain_age); ?></p>       
                                                </div>
                                               <?php 
                                            }

                                            if( !in_array('da', $control_marketplace_col) ){
                                               ?>
                                                 <div class="item_tag_7 table-data-div check_da">
                                                    <p><?php echo $domain_authority_da; ?></p>
                                                </div>  
                                               <?php 
                                            }

                                            if( !in_array('niches', $control_marketplace_col) ){
                                               ?>
                                                 <div class="item_tag_8 table-data-div check_niches">
                                        
                                                    <ul class="niche-list">
                                                        <li class="<?php echo $domain_casino_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_casino_text; ?>">
                                                            <svg class="w-5 h-5 relative text-gray-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.5 3H7.5C6.30653 3 5.16193 3.47411 4.31802 4.31802C3.47411 5.16193 3 6.30653 3 7.5V16.5C3 17.6935 3.47411 18.8381 4.31802 19.682C5.16193 20.5259 6.30653 21 7.5 21H16.5C17.6935 21 18.8381 20.5259 19.682 19.682C20.5259 18.8381 21 17.6935 21 16.5V7.5C21 6.30653 20.5259 5.16193 19.682 4.31802C18.8381 3.47411 17.6935 3 16.5 3V3ZM19.2 16.5C19.2 17.2161 18.9155 17.9028 18.4092 18.4092C17.9028 18.9155 17.2161 19.2 16.5 19.2H7.5C6.78392 19.2 6.09716 18.9155 5.59081 18.4092C5.08446 17.9028 4.8 17.2161 4.8 16.5V7.5C4.8 6.78392 5.08446 6.09716 5.59081 5.59081C6.09716 5.08446 6.78392 4.8 7.5 4.8H16.5C17.2161 4.8 17.9028 5.08446 18.4092 5.59081C18.9155 6.09716 19.2 6.78392 19.2 7.5V16.5ZM8.4 14.7C8.222 14.7 8.04799 14.7528 7.89999 14.8517C7.75198 14.9506 7.63663 15.0911 7.56851 15.2556C7.50039 15.42 7.48257 15.601 7.51729 15.7756C7.55202 15.9502 7.63774 16.1105 7.7636 16.2364C7.88947 16.3623 8.04984 16.448 8.22442 16.4827C8.399 16.5174 8.57996 16.4996 8.74442 16.4315C8.90887 16.3634 9.04943 16.248 9.14832 16.1C9.24722 15.952 9.3 15.778 9.3 15.6C9.3 15.3613 9.20518 15.1324 9.0364 14.9636C8.86761 14.7948 8.63869 14.7 8.4 14.7V14.7ZM12 11.1C11.822 11.1 11.648 11.1528 11.5 11.2517C11.352 11.3506 11.2366 11.4911 11.1685 11.6556C11.1004 11.82 11.0826 12.001 11.1173 12.1756C11.152 12.3502 11.2377 12.5105 11.3636 12.6364C11.4895 12.7623 11.6498 12.848 11.8244 12.8827C11.999 12.9174 12.18 12.8996 12.3444 12.8315C12.5089 12.7634 12.6494 12.648 12.7483 12.5C12.8472 12.352 12.9 12.178 12.9 12C12.9 11.7613 12.8052 11.5324 12.6364 11.3636C12.4676 11.1948 12.2387 11.1 12 11.1ZM8.4 7.5C8.222 7.5 8.04799 7.55278 7.89999 7.65168C7.75198 7.75057 7.63663 7.89113 7.56851 8.05558C7.50039 8.22004 7.48257 8.401 7.51729 8.57558C7.55202 8.75016 7.63774 8.91053 7.7636 9.0364C7.88947 9.16226 8.04984 9.24798 8.22442 9.28271C8.399 9.31743 8.57996 9.29961 8.74442 9.23149C8.90887 9.16337 9.04943 9.04802 9.14832 8.90001C9.24722 8.75201 9.3 8.578 9.3 8.4C9.3 8.16131 9.20518 7.93239 9.0364 7.7636C8.86761 7.59482 8.63869 7.5 8.4 7.5V7.5ZM15.6 14.7C15.422 14.7 15.248 14.7528 15.1 14.8517C14.952 14.9506 14.8366 15.0911 14.7685 15.2556C14.7004 15.42 14.6826 15.601 14.7173 15.7756C14.752 15.9502 14.8377 16.1105 14.9636 16.2364C15.0895 16.3623 15.2498 16.448 15.4244 16.4827C15.599 16.5174 15.78 16.4996 15.9444 16.4315C16.1089 16.3634 16.2494 16.248 16.3483 16.1C16.4472 15.952 16.5 15.778 16.5 15.6C16.5 15.3613 16.4052 15.1324 16.2364 14.9636C16.0676 14.7948 15.8387 14.7 15.6 14.7ZM15.6 7.5C15.422 7.5 15.248 7.55278 15.1 7.65168C14.952 7.75057 14.8366 7.89113 14.7685 8.05558C14.7004 8.22004 14.6826 8.401 14.7173 8.57558C14.752 8.75016 14.8377 8.91053 14.9636 9.0364C15.0895 9.16226 15.2498 9.24798 15.4244 9.28271C15.599 9.31743 15.78 9.29961 15.9444 9.23149C16.1089 9.16337 16.2494 9.04802 16.3483 8.90001C16.4472 8.75201 16.5 8.578 16.5 8.4C16.5 8.16131 16.4052 7.93239 16.2364 7.7636C16.0676 7.59482 15.8387 7.5 15.6 7.5Z" fill="currentColor"></path></svg>
                                                        </li>
                                                        <li class="<?php echo $domain_loan_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_loan_text; ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="w-5 h-5 relative text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>

                                                        </li>
                                                        <li class="<?php echo $domain_erotic_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_erotic_text; ?>">
                                                            <svg class="w-5 h-5 relative text-gray-800" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.9091 6.27494H17.7272V7.09312C17.7272 7.31011 17.8134 7.51822 17.9669 7.67166C18.1203 7.82509 18.3284 7.9113 18.5454 7.9113C18.7624 7.9113 18.9705 7.82509 19.124 7.67166C19.2774 7.51822 19.3636 7.31011 19.3636 7.09312V6.27494H20.1818C20.3988 6.27494 20.6069 6.18873 20.7603 6.0353C20.9138 5.88186 21 5.67375 21 5.45676C21 5.23976 20.9138 5.03165 20.7603 4.87822C20.6069 4.72478 20.3988 4.63858 20.1818 4.63858H19.3636V3.8204C19.3636 3.6034 19.2774 3.39529 19.124 3.24186C18.9705 3.08842 18.7624 3.00222 18.5454 3.00222C18.3284 3.00222 18.1203 3.08842 17.9669 3.24186C17.8134 3.39529 17.7272 3.6034 17.7272 3.8204V4.63858H16.9091C16.6921 4.63858 16.484 4.72478 16.3305 4.87822C16.1771 5.03165 16.0909 5.23976 16.0909 5.45676C16.0909 5.67375 16.1771 5.88186 16.3305 6.0353C16.484 6.18873 16.6921 6.27494 16.9091 6.27494ZM7.90908 7.9113V16.0931C7.90908 16.3101 7.99528 16.5182 8.14872 16.6716C8.30216 16.8251 8.51027 16.9113 8.72726 16.9113C8.94426 16.9113 9.15237 16.8251 9.3058 16.6716C9.45924 16.5182 9.54544 16.3101 9.54544 16.0931V7.9113C9.54544 7.6943 9.45924 7.48619 9.3058 7.33276C9.15237 7.17932 8.94426 7.09312 8.72726 7.09312C8.51027 7.09312 8.30216 7.17932 8.14872 7.33276C7.99528 7.48619 7.90908 7.6943 7.90908 7.9113ZM19.8545 9.54766C19.7492 9.56912 19.6492 9.61113 19.5601 9.67127C19.471 9.73142 19.3947 9.80852 19.3354 9.89817C19.2761 9.98783 19.2351 10.0883 19.2147 10.1938C19.1943 10.2993 19.1948 10.4078 19.2163 10.5131C19.5358 12.0645 19.3464 13.6776 18.6764 15.1129C18.0064 16.5482 16.8914 17.7292 15.497 18.4806C14.1026 19.232 12.503 19.5137 10.9358 19.2839C9.36855 19.0541 7.9172 18.3251 6.79715 17.205C5.6771 16.085 4.94808 14.6336 4.71829 13.0664C4.4885 11.4992 4.77021 9.89962 5.52158 8.50518C6.27295 7.11075 7.45394 5.99577 8.88924 5.32575C10.3245 4.65573 11.9376 4.4664 13.4891 4.78585C13.7061 4.82925 13.9314 4.78467 14.1155 4.66192C14.2997 4.53917 14.4275 4.3483 14.4709 4.1313C14.5143 3.91431 14.4697 3.68896 14.347 3.50484C14.2242 3.32071 14.0333 3.19289 13.8163 3.14949C13.2176 3.03793 12.6089 2.98858 12 3.00222C10.22 3.00222 8.4799 3.53006 6.99986 4.51899C5.51982 5.50792 4.36627 6.91352 3.68509 8.55805C3.0039 10.2026 2.82567 12.0122 3.17294 13.758C3.5202 15.5038 4.37737 17.1075 5.63604 18.3661C6.89471 19.6248 8.49835 20.482 10.2442 20.8292C11.99 21.1765 13.7996 20.9983 15.4441 20.3171C17.0887 19.6359 18.4943 18.4824 19.4832 17.0023C20.4721 15.5223 21 13.7822 21 12.0022C21.0017 11.3976 20.9414 10.7945 20.82 10.2022C20.8004 10.0954 20.7597 9.99361 20.7004 9.9027C20.641 9.81179 20.5642 9.7336 20.4744 9.67268C20.3845 9.61176 20.2834 9.56933 20.177 9.54787C20.0706 9.5264 19.961 9.52633 19.8545 9.54766ZM11.1818 9.54766V10.3658C11.1854 10.9713 11.4127 11.5541 11.82 12.0022C11.4127 12.4503 11.1854 13.0331 11.1818 13.6386V14.4567C11.1818 15.1077 11.4404 15.732 11.9007 16.1924C12.361 16.6527 12.9854 16.9113 13.6363 16.9113H14.4545C15.1055 16.9113 15.7298 16.6527 16.1901 16.1924C16.6505 15.732 16.9091 15.1077 16.9091 14.4567V13.6386C16.9055 13.0331 16.6782 12.4503 16.2709 12.0022C16.6782 11.5541 16.9055 10.9713 16.9091 10.3658V9.54766C16.9091 8.89667 16.6505 8.27235 16.1901 7.81203C15.7298 7.35172 15.1055 7.09312 14.4545 7.09312H13.6363C12.9854 7.09312 12.361 7.35172 11.9007 7.81203C11.4404 8.27235 11.1818 8.89667 11.1818 9.54766ZM15.2727 14.4567C15.2727 14.6737 15.1865 14.8818 15.0331 15.0353C14.8796 15.1887 14.6715 15.2749 14.4545 15.2749H13.6363C13.4193 15.2749 13.2112 15.1887 13.0578 15.0353C12.9044 14.8818 12.8182 14.6737 12.8182 14.4567V13.6386C12.8182 13.4216 12.9044 13.2135 13.0578 13.06C13.2112 12.9066 13.4193 12.8204 13.6363 12.8204H14.4545C14.6715 12.8204 14.8796 12.9066 15.0331 13.06C15.1865 13.2135 15.2727 13.4216 15.2727 13.6386V14.4567ZM15.2727 9.54766V10.3658C15.2727 10.5828 15.1865 10.7909 15.0331 10.9444C14.8796 11.0978 14.6715 11.184 14.4545 11.184H13.6363C13.4193 11.184 13.2112 11.0978 13.0578 10.9444C12.9044 10.7909 12.8182 10.5828 12.8182 10.3658V9.54766C12.8182 9.33066 12.9044 9.12255 13.0578 8.96911C13.2112 8.81568 13.4193 8.72948 13.6363 8.72948H14.4545C14.6715 8.72948 14.8796 8.81568 15.0331 8.96911C15.1865 9.12255 15.2727 9.33066 15.2727 9.54766Z" fill="currentColor"></path>
                                                            </svg>
                                                        </li>
                                                        <li class="<?php echo $domain_dating_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_dating_text; ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="w-5 h-5 relative text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                                            
                                                        </li>
                                                        <li class="<?php echo $domain_cbd_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_cbd_text; ?>">
                                                            <svg class="w-5 h-5 relative text-gray-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.1026 14.3262C20.0311 14.2914 19.7088 14.1396 19.2029 13.9635C20.4937 12.0573 20.9318 10.2934 20.9559 10.1931C21.0833 9.66537 20.9301 9.10982 20.5499 8.71938C20.2452 8.40669 19.8286 8.23496 19.3991 8.23496C19.2929 8.23496 19.1857 8.24555 19.0795 8.26706C18.9769 8.2879 17.2418 8.64956 15.2952 9.7054C14.8161 6.8661 13.3893 4.78849 13.3169 4.6846C13.0178 4.2561 12.5257 4 12 4C11.4742 4 10.9822 4.2561 10.6834 4.68493C10.6109 4.78882 9.18418 6.8661 8.70506 9.70574C6.75849 8.64989 5.02335 8.2879 4.92078 8.26739C4.81557 8.24607 4.70849 8.23532 4.60115 8.23529C4.17166 8.23529 3.75508 8.40702 3.45034 8.71971C3.06983 9.10982 2.91663 9.66537 3.04402 10.1931C3.06818 10.2934 3.50659 12.0573 4.79703 13.9635C4.29111 14.1396 3.96883 14.2914 3.89736 14.3262C3.34876 14.5925 3.00034 15.1458 3.00001 15.7519C2.99968 16.3581 3.34711 16.9117 3.89538 17.1787C3.96718 17.2135 5.4267 17.9146 7.38485 18.1274C7.36058 18.3566 7.38677 18.5884 7.46159 18.8065C7.53642 19.0246 7.65805 19.2236 7.81797 19.3897C8.12437 19.709 8.54525 19.8824 8.97705 19.8824C9.12495 19.8824 9.27385 19.8618 9.42043 19.8201C9.54186 19.7854 10.2751 19.5631 11.2059 19.0833V20.4118C11.2059 20.7043 11.4428 20.9412 11.7353 20.9412H12.2647C12.5572 20.9412 12.7941 20.7043 12.7941 20.4118V19.0833C13.7249 19.5631 14.4581 19.7854 14.5795 19.8201C14.7258 19.8622 14.875 19.8824 15.0229 19.8824C15.4547 19.8824 15.8756 19.709 16.182 19.3897C16.5099 19.0482 16.6637 18.585 16.6151 18.1274C18.5733 17.9143 20.0328 17.2135 20.1046 17.1787C20.6528 16.9117 21.0003 16.3581 20.9999 15.7519C20.9996 15.1458 20.6512 14.5925 20.1026 14.3262ZM15.5146 16.6C14.9422 16.6 14.4846 16.5715 14.111 16.5229C14.1037 16.5265 14.0978 16.5279 14.0905 16.5318C14.7446 17.4851 15.0229 18.2941 15.0229 18.2941C15.0229 18.2941 13.4347 17.8398 12 16.69C10.5649 17.8398 8.97705 18.2941 8.97705 18.2941C8.97705 18.2941 9.25565 17.4851 9.90947 16.5318C9.90219 16.5282 9.89624 16.5269 9.88896 16.5229C9.51539 16.5712 9.05778 16.6 8.48536 16.6C6.33993 16.6 4.60082 15.7529 4.60082 15.7529C4.60082 15.7529 5.95346 15.0965 7.74319 14.9403C7.71507 14.9148 7.69125 14.8973 7.66279 14.8711C5.29534 12.7029 4.60082 9.82353 4.60082 9.82353C4.60082 9.82353 7.74485 10.4595 10.1123 12.6278C10.1431 12.6559 10.1642 12.6797 10.1944 12.7075C10.1662 12.3492 10.1504 11.9557 10.1504 11.5176C10.1504 8.2429 12 5.58824 12 5.58824C12 5.58824 13.8496 8.2429 13.8496 11.5176C13.8496 11.9554 13.8337 12.3492 13.8056 12.7075C13.8357 12.6797 13.8566 12.6559 13.8877 12.6278C16.2551 10.4595 19.3991 9.82353 19.3991 9.82353C19.3991 9.82353 18.7046 12.7029 16.3372 14.8711C16.3087 14.8973 16.2849 14.9148 16.2568 14.9403C18.0465 15.0961 19.3991 15.7529 19.3991 15.7529C19.3991 15.7529 17.66 16.6 15.5146 16.6Z" fill="currentColor"></path></svg>

                                                        </li>

                                                        <li class="<?php echo $domain_crypto_class; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $domain_crypto_text; ?>">
                                                            
                                                            <svg class="w-5 h-5 relative text-gray-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.1418 7.9032V6.9032M13.1418 16.0968V17.0968M14.4442 9C12 7.5 8.5 8 8.5 12C8.5 16 12 16.0968 14.4442 15M10.1418 8.5V6.90321M10.1418 15.0968V17M21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3C14.3869 3 16.6761 3.94821 18.364 5.63604C20.0518 7.32387 21 9.61305 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>

                                                        </li>
                                                    </ul>
                                                </div> 
                                               <?php 
                                            }

                                            if( !in_array('category', $control_marketplace_col) ){
                                               ?>
                                                <div class="item_tag_9 table-data-div check_category">
                                                        
                                                     <ul class="table-category">
                                                         
                                                         <?php 
                                                            
                                                           foreach ($productCat as $product_cat) {
                                                               echo '<li>'.$product_cat->name.'</li>';
                                                           }
                                                            
                                                         ?>
                                                     </ul>   

                                                </div>  
                                               <?php 
                                            }

                                            
                                            $efc = 10;

                                            foreach ($all_sub_field as $field_items) {
                                                

                                                    //print_r($field_items);
                                                    $field_name = $field_items['name'];
                                                    $field_label = $field_items['label'];
                                                    
                                                    $fieldData = get_field('add_field_below_'.$field_name.'');
                                                    $fieldValue = !empty($fieldData) ? $fieldData : '-';
                                                    $extra_fields_name = $field_items['_name'];

                                                    if( !in_array($extra_fields_name, $control_marketplace_col) ){
                                                        ?>

                                                        <div class="item_tag_<?php echo $efc; ?> table-data-div extra-field check_<?php echo $extra_fields_name; ?>">
                                                            <?php  echo $fieldValue; ?>

                                                        </div>      

                                                        <?php  
                                                    }
                                                   
                                                    $efc++;
                                            }
                                            

                                        ?>
                                        

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



//ajax action to check product quantity after added to cart

add_action('wp_ajax_check_product_quantity', 'check_product_quantity');
add_action('wp_ajax_nopriv_check_product_quantity', 'check_product_quantity');

function check_product_quantity(){

    ob_start();

    $check_product_id = intval($_POST['product_id']);

    $count = 0;

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

        if($cart_item['product_id'] == $check_product_id){
            
           //$cart_item['quantity'] . '<br>';

           $count++;
        }
       
    }

    if($count != ''){
        ?>
        <span class="productQtyCart"><?php echo $count; ?></span>
        <?php
    }
    
    $response['content'] = ob_get_clean();

    die(json_encode($response));
}




//ajax action to check product quantity after added to cart

add_action('wp_ajax_remove_product_qty', 'remove_product_qty');
add_action('wp_ajax_nopriv_remove_product_qty', 'remove_product_qty');

function remove_product_qty(){

    ob_start();

    $check_product_id = intval($_POST['product_id']);

    $product_cart_id = WC()->cart->generate_cart_id( $product_id );
    $cart_item_key1 = WC()->cart->find_product_in_cart( $product_cart_id );

    $count = 0;
    $remove = false;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

        if($cart_item['product_id']  === $check_product_id){
            if($remove === false){
                $remove = true;
                WC()->cart->remove_cart_item( $cart_item_key );
                
                $message = "Remove Product from Cart";
                
                
            }
           
        }else{
            $message = "Failed Cart Item key not found";
        }
       
    }

    $cartQty = check_product_qty_cart($check_product_id);
    
    $response = [
        'status'  => 'success',
        'message' =>  $message,
        'item_key' => $cart_item_key,
        'cartQty' => $cartQty
    ];

    die(json_encode($response));

    
}

// function to check product qty in cart
function check_product_qty_cart($prduct_ID){

    $count = 0;

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

        if($cart_item['product_id'] == $prduct_ID){
            
           $cart_item['quantity'];

           $count++;
        }
       
    }

    if($count != ''){
        return $count;
    }


}


// submit note from order thankyou page using ajax function
add_action( 'wp_ajax_collect_feedback', 'collect_feedback' );
add_action( 'wp_ajax_nopriv_collect_feedback', 'collect_feedback' );

function collect_feedback(){

    if( !isset( $_POST['thankyou_nonce'] ) || !wp_verify_nonce( $_POST['thankyou_nonce'], 'thankyou_note' ) )
        die('Permission denied');

    // security check
    //var_dump($_POST);

    $notedata = sanitize_text_field($_POST['note-form-text']);
    
    if( $order = wc_get_order( $_POST['order_id'] ) ) {
        $note = $notedata;
        $order->add_order_note( $note, 0, true );
    }

}


//Change order note label on checkout page
function change_order_note_label( $fields ) 
{
    $fields['order']['order_comments']['placeholder'] = 'Add any order Notes/Instruction';
    $fields['order']['order_comments']['label'] = 'Order Notes/Instruction';

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'change_order_note_label' );


//register api setting on init and based on that enable ahref api request on product save
add_action('admin_init', 'register_setting_callback');

function register_setting_callback(){

    
    register_setting( 'enableApiOnSavePost', 'enableapi' );

    $enableApi = get_option('enableapi');

    if($enableApi == "Yes"){

        //woocommerce hook ok update post
        add_action('save_post', 'product_update');

    }else{

        remove_action('save_post', 'product_update');
    }

}

//ahref api update data on product save Note : only work when enableapi setting is enable

function product_update($post_id){
    
    global $post; 

    if ($post->post_type != 'product'){
        return;
    }
  

    $ahref_token = 'eaefb9584ab1541994d9d6cace17efa7d2e67b5a';

    $WC_Product = wc_get_product( $post_id);

    $product_title = get_the_title($post_id);


    //Domain Rating Request
    $request_url_dr = 'https://apiv2.ahrefs.com?token='.$ahref_token.'&target='.$product_title.'&mode=subdomains&from=domain_rating&limit=1&output=json&select=domain_rating';

    $ahref_response_dr = json_decode(file_get_contents($request_url_dr));
        
    $domain_rating = $ahref_response_dr->domain->domain_rating;

    update_field( 'domain_rating_dr', $domain_rating, $product_id);

    
    //organic traffic request
    $request_url_ot = 'https://apiv2.ahrefs.com?token='.$ahref_token.'&target='.$product_title.'&mode=subdomains&from=positions_metrics&limit=1&output=json&select=traffic';

    $ahref_response_ot = json_decode(file_get_contents($request_url_ot));
        
    $organic_traffic = (int)$ahref_response_ot->metrics->traffic;

    update_field( 'organic_traffic', $organic_traffic, $product_id);

    
    //Referring  domain request
    $request_url_rd = 'https://apiv2.ahrefs.com?token='.$ahref_token.'&target='.$product_title.'&mode=subdomains&from=refdomains&limit=1&output=json&select=refdomain';

    $ahref_response_rd = json_decode(file_get_contents($request_url_rd));
        
    $ref_domain = $ahref_response_rd->stats->refdomains;

    update_field( 'domain_age', $ref_domain, $product_id);

}




//Action to delete  Save filter custom post from frontend 
add_action( 'wp_ajax_my_delete_post', 'my_delete_post' );
function my_delete_post(){

    $permission = check_ajax_referer( 'my_delete_post_nonce', 'nonce', false );
    if( $permission == false ) {
        $response = [
            'status'  => 'Error',
            'message' =>  'Delete Filter Failed',
        ];

    }
    else {
        wp_delete_post( $_REQUEST['id'] );
        $response = [
            'status'  => 'success',
            'message' =>  'Delete Filter successfully',
        ];
        
    }

    die(json_encode($response));

}