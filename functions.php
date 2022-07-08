<?php
/**
 * apptology functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package apptology
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function apptology_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on apptology, use a find and replace
		* to change 'apptology' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'apptology', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'apptology' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'apptology_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'apptology_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function apptology_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'apptology_content_width', 640 );
}
add_action( 'after_setup_theme', 'apptology_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function apptology_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'apptology' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'apptology' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'apptology_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function apptology_scripts() {
	wp_enqueue_style( 'apptology-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'apptology-style', 'rtl', 'replace' );

	wp_enqueue_script( 'apptology-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'apptology_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


add_action( 'wp_enqueue_scripts', 'linkbuild_style_script', 10 );
add_action( 'wp_enqueue_scripts', 'linkbuild_style_script_force',20);


function linkbuild_style_script() {

    //wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
   

    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' );
    
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', array(), false);
    
    wp_enqueue_style('fa-pro-css', get_stylesheet_directory_uri(). '/assets/css/all-min.css', array(), false);   

    //wp_enqueue_style('fontawesome-css', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css', array(), false);
     wp_enqueue_script('fa-pro-js',  get_stylesheet_directory_uri() .'/assets/js/pro.min.js', array('jquery'), true);
    wp_enqueue_script('bootstrap-js',  'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array(),false);
    
    wp_enqueue_script('jqueryformalist-js',  get_stylesheet_directory_uri() .'/assets/js/jquery.formalist.min.js', array(),false);


   

}


function linkbuild_style_script_force(){
    
   
    wp_enqueue_style('main', get_stylesheet_directory_uri(). '/assets/css/main.css', array(), false);   
    wp_enqueue_style('responsive', get_stylesheet_directory_uri(). '/assets/css/responsive.css', array(), false);    

    wp_enqueue_script('main-js',  get_stylesheet_directory_uri() .'/assets/js/main.js', array('jquery-blockui','jquery'), true);

    wp_localize_script( 'main-js', 'linkbuild', array(
        'nonce'    => wp_create_nonce( 'linkbuild' ),
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));

     wp_localize_script('main-js','prefix_vars',array('ajaxurl' => admin_url( 'admin-ajax.php' )) );

     wp_enqueue_script( 'prefix-script' );
}


/**
 * Enqueue our JS file (Not Used)
 */
function prefix_enqueue_scripts() {

 wp_register_script( 'prefix-script', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'update-cart-item-ajax.js', array( 'jquery-blockui' ), time(), true );

 wp_localize_script('prefix-script','prefix_vars',array('ajaxurl' => admin_url( 'admin-ajax.php' )) );

 wp_enqueue_script( 'prefix-script' );

}

//add_action( 'wp_enqueue_scripts', 'prefix_enqueue_scripts' );

// Include helper function files
require get_stylesheet_directory() . '/inc/shortcode.php';
require get_stylesheet_directory() . '/inc/helper-function.php';
require get_stylesheet_directory() . '/inc/woo-api.php';


// woocommerce count same product as another product
// -------------------
// 2. Force add to cart quantity to 1 and disable +- quantity input
// Note: product can still be added multiple times to cart

function product_individual_cart_items( $cart_item_data, $product_id ){
  $unique_cart_item_key = uniqid();
  $cart_item_data['unique_key'] = $unique_cart_item_key;
  return $cart_item_data;
}
 
add_filter( 'woocommerce_add_cart_item_data', 'product_individual_cart_items', 10, 2 );

//add_filter( 'woocommerce_is_sold_individually', '__return_true' );

 
// -------------------
// 2. Force add to cart quantity to 1 and disable +- quantity input
// Note: product can still be added multiple times to cart
 
//add_filter( 'woocommerce_is_sold_individually', '__return_true' );


/**
 * Add a select field (Niche) to each cart item
 * 
 * THIS FUNCTION NOT USED. IT REPLACE WITH OPTION PUT IN cart.php file
 */
function prefix_after_cart_item_name( $cart_item, $cart_item_key ) {

 $notes = isset( $cart_item['niche'] ) ? $cart_item['niche'] : '';

 printf(
 '<div><select class="%s" id="cart_notes_%s" data-cart-id="%s"><option value="None">None</option><option value="casino">Casino </option><option value="loan">Loan</option><option value="erotic">Erotic</option><option value="dating">Dating</option><option value="cbd">cbd</option><option value="crypto">Crypto</option></select></div>',
 'prefix-cart-notes',
 $cart_item_key,
 $cart_item_key,
 $notes
 );
}
//add_action( 'woocommerce_after_cart_item_name', 'prefix_after_cart_item_name', 10, 2 );


//update product cart option ajax function
function update_niche_on_cart() {

 	// Do a nonce check

	if( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'woocommerce-cart' ) ) {
	     wp_send_json( array( 'nonce_fail' => 1 ) );
	     exit;
	 }

 	 // Save the niche to the cart meta
     $cart = WC()->cart->cart_contents;
     $cart_id = $_POST['cart_id'];
     // $niche = $_POST['niche'];

     $custom_product_id = $_POST['custom_product_id'];
     $doc_upload = $_POST['doc_upload'];
     $who_provide_article = $_POST['who_provide_article'];
     $article_anchor_text = $_POST['article_anchor_text'];
     $article_req = $_POST['article_req'];
     $publish_period = $_POST['publish_period'];
     $internal_ref = $_POST['internal_ref'];

     //$product_default_price = $_POST['product_default_price'];

     $_product = wc_get_product( $custom_product_id );
     $product_default_price = $_product->get_regular_price();



     //get product fields from admin
     $banner_widget_price = get_field('banner_widget_price', $custom_product_id);
     $article_price = get_field('article_price', $custom_product_id);
     $price_24_month = get_field('price_24_month', $custom_product_id);
     $price_for_permanent = get_field('price_for_permanent', $custom_product_id);

     $cart_item = $cart[$cart_id];

     


     if(!empty($article_anchor_text)){
        $cart_item['article_anchor_text'] = $article_anchor_text;
     }else{
        $cart_item['article_anchor_text'] = "";
     }

     if(!empty($article_req)){
        $cart_item['article_req'] = $article_req;
     }else{
        $cart_item['article_req'] = "";
     }

     if(!empty($internal_ref)){
        $cart_item['internal_ref'] = $internal_ref;
     }else{
        $cart_item['internal_ref'] = "";
     }

     if($doc_upload === "banner"){

     	$doc_upload_price = intval($banner_widget_price);

        if(!empty($banner_widget_price) && $banner_widget_price != 0){
            $banner_widget_price_text = '+ $'.$banner_widget_price;    
        }

        $cart_item['doc_upload'] = 'Yes, put our backlinks in the side widget for an extra  '.$banner_widget_price_text;

     }else{

     	$doc_upload_price = 0;
        $cart_item['doc_upload'] = 'I prefer an article with our backlink published';
     }

     if($who_provide_article === "write_content"){

     	$who_provide_article_price = $article_price;
        if(!empty($article_price) && $article_price != 0){
            $articlePriceText = '+ $'.$article_price;
        }

        $cart_item['who_provide_article_price'] = 'We provide Article/Content for you '.$articlePriceText;

     }else if($who_provide_article === "own_article"){

     	$who_provide_article_price = 0;
        $cart_item['who_provide_article_price'] = 'You have your own article/content (Please upload File)';

     }else{

        $who_provide_article_price = 0;
        $cart_item['who_provide_article_price'] = "";

     }

     if( $publish_period === "24Month" ){

     	$publish_period_price = $price_24_month;

        if(!empty($price_24_month) && $price_24_month != 0){
            $price_24_month_text = '+ $'.$price_24_month;
        }

        $cart_item['publish_period_price'] = '24 Month '. $price_24_month_text;

     }else if( $publish_period === "permanent" ){

     	$publish_period_price = $price_for_permanent;

        if(!empty($price_for_permanent) && $price_for_permanent != 0){
            $price_for_permanent_text = '+ $'.$price_for_permanent;
        }

        $cart_item['publish_period_price'] = 'Permanent ' .$price_for_permanent_text;

     }else{
        $publish_period_price = '';
        $cart_item['publish_period_price'] = '12 Month';
     }


     // echo 'Default' .$product_default_price; 
     // echo 'Upload' .$doc_upload_price;
     // echo 'article write' .$who_provide_article_price;
     // echo 'publish period' .$publish_period_price;

    
     //calculat total product price based on product form selection
     $product_total_price = $product_default_price + $doc_upload_price + $who_provide_article_price + $publish_period_price;
    

    $cart_item['product_total_price'] = $product_total_price;

    $cart_content = WC()->cart->cart_contents;

    $cart_content[$cart_id] = $cart_item;
    WC()->cart->set_cart_contents($cart_content);
    WC()->cart->set_session();

    wp_send_json( array( 'success' => 1 ) );
    exit;
}

add_action( 'wp_ajax_update_niche_on_cart', 'update_niche_on_cart' );
add_action( 'wp_ajax_nopriv_update_niche_on_cart', 'update_niche_on_cart' );




//set product custom price based on custom form

add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );

function add_custom_price( $cart_object ) {
    $custom_price = 30; // This will be your custom price  
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

    	if(!empty($cart_item['product_total_price'])){
    		$cart_item['data']->set_price($cart_item['product_total_price']);   

    	}

        // echo '<pre>';
        // echo $cart_item_key;
        // echo $cart_item['product_id'];
        // print_r($cart_item);
        // echo '</pre>';
       
    }
}

 
add_filter( 'woocommerce_get_item_data', 'show_custom_cart_data', 10, 2 );
 
function show_custom_cart_data( $data, $cart_item ) {
    
    // echo '<pre>';
    // print_r($cart_item);
    // echo '<pre>';
    
    if ( isset( $cart_item['doc_upload'] ) ){
        
        if(!empty($cart_item['doc_upload'])){
            $data[] = array(
                'name' => 'What you prefer to upload?',
                'value' => sanitize_text_field( $cart_item['doc_upload'] )
            );
        }
        
    }
   
    if ( isset( $cart_item['who_provide_article_price'] ) ){

        if(!empty($cart_item['who_provide_article_price'])){
            $data[] = array(
                'name' => 'Who provide article/content?',
                'value' => sanitize_text_field( $cart_item['who_provide_article_price'] )
            );
        }
        
    }
    if ( isset( $cart_item['article_anchor_text'] ) ){
        if(!empty($cart_item['article_anchor_text'])){
            $data[] = array(
                'name' => 'Anchor text',
                'value' => sanitize_text_field( $cart_item['article_anchor_text'] )
            );
        }
        
    }
    if ( isset( $cart_item['article_req'] ) ){
        if(!empty($cart_item['article_req'])){
            $data[] = array(
                'name' => 'Article suggestions & requirements',
                'value' => sanitize_text_field( $cart_item['article_req'] )
            );
        }
        
    }

     if ( isset( $cart_item['internal_ref'] ) ){

        if(!empty($cart_item['internal_ref'])){
            $data[] = array(
                'name' => 'Internal Ref',
                'value' => sanitize_text_field( $cart_item['internal_ref'] )
            );
        }
        
    }

    if ( isset( $cart_item['publish_period_price'] ) ){
        if(!empty($cart_item['publish_period_price'])){
            $data[] = array(
                'name' => 'Choose Publish period',
                'value' => sanitize_text_field( $cart_item['publish_period_price'] )
            );
        }
        
    }
    return $data;
}


// Save custom input field value into order item meta
 
add_action( 'woocommerce_add_order_item_meta', 'product_add_order_item_meta', 10, 2 );
 
function product_add_order_item_meta( $item_id, $values ) {

    if ( ! empty( $values['article_anchor_text'] ) ) {
        wc_add_order_item_meta( $item_id, 'Anchor text', $values['article_anchor_text'], true );
    }

    if ( ! empty( $values['article_req'] ) ) {
        wc_add_order_item_meta( $item_id, 'Article suggestions & requirements', $values['article_req'], true );
    }

    if ( ! empty( $values['doc_upload'] ) ) {
        wc_add_order_item_meta( $item_id, 'What you prefer to upload?', $values['doc_upload'], true );
    }

    if ( ! empty( $values['internal_ref'] ) ) {
        wc_add_order_item_meta( $item_id, 'Internal Reference', $values['internal_ref'], true );
    }

    if ( ! empty( $values['who_provide_article_price'] ) ) {
        wc_add_order_item_meta( $item_id, 'Who provide article/content?', $values['who_provide_article_price'], true );
    }

    if ( ! empty( $values['publish_period_price'] ) ) {
        wc_add_order_item_meta( $item_id, 'Choose Publish period', $values['publish_period_price'], true );
    }

}

//show selected niche on checkout 
function niche_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
    foreach( $item as $cart_item_key=>$cart_item ) {
         if( isset( $cart_item['niche'] ) ) {
            $item->add_meta_data( 'niche', $cart_item['niche'], true );
         }
     }
}
//add_action( 'woocommerce_checkout_create_order_line_item', 'niche_checkout_create_order_line_item', 10, 4 );



//Change Shop Btn link
add_filter( 'woocommerce_return_to_shop_redirect', 'change_return_shop_url' );
 
function change_return_shop_url() {
	
	return get_the_permalink(26);

}


//woocommerce remove not used tab
add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
function misha_remove_my_account_links( $menu_links ){
	
	//unset( $menu_links['edit-address'] ); // Addresses
	//unset( $menu_links['dashboard'] ); // Remove Dashboard
	unset( $menu_links['payment-methods'] ); // Remove Payment Methods
	//unset( $menu_links['orders'] ); // Remove Orders
	unset( $menu_links['downloads'] ); // Disable Downloads
	//unset( $menu_links['edit-account'] ); // Remove Account details tab
	//unset( $menu_links['customer-logout'] ); // Remove Logout link
	
	return $menu_links;
	
}

//woocommerce rediret to home after logout
function redirect_after_logout($logout_url, $redirect) {
    return $logout_url . '&amp;redirect_to=' . home_url();
}
add_filter('logout_url', 'redirect_after_logout', 10, 2);

//change woocommerce lost password url
function reset_pass_url() {
    return $siteURL = get_the_permalink(25);
}
add_filter( 'lostpassword_url', 'reset_pass_url', 11, 0 );

//calculate paypal fees on checkout

//add_action( 'woocommerce_cart_calculate_fees', 'paypal_checkout_fee_for_gateway' );
  
function paypal_checkout_fee_for_gateway() {
    $chosen_gateway = WC()->session->get( 'chosen_payment_method' );
     if ( $chosen_gateway == 'paypal' ) {
      WC()->cart->add_fee( 'PayPal Fee', 5 );
   }
}
 
//add_action( 'woocommerce_after_checkout_form', 'paypal_checkout_on_payment_methods_change' );
   
function paypal_checkout_on_payment_methods_change(){
    wc_enqueue_js( "
       $( 'form.checkout' ).on( 'change', 'input[name^=\'payment_method\']', function() {
           $('body').trigger('update_checkout');
        });
   ");
}



// exclude certain payment methods from automatic pdf creation
//add_filter( 'wpo_wcpdf_custom_attachment_condition', 'wpo_wcpdf_exclude_payment_method', 100, 4 );
function wpo_wcpdf_exclude_payment_method ( $condition, $order, $status, $document ) {
	$excluded_methods = array( 'stripe', 'cod' );
	$payment_method = get_post_meta( $order->id, '_payment_method', true );
	if ( $document == 'invoice' && in_array( $payment_method, $excluded_methods ) ) {
		return false;
	} else {
		return $condition;
	}
}


//change order status for invoice payment method
add_action( 'woocommerce_order_status_changed', 'change_order_status_conditionally', 10, 4 );
function change_order_status_conditionally( $order_id, $status_from, $status_to, $order ) {
    if( $order->get_payment_method() === 'ipgw_invoice_gateway' ) {
        $order->update_status( 'pending' );
    }
}



function get_author_save_filter_post($userID){

    if(is_user_logged_in()){
        
        // global $current_user; 
        // $userID = $current_user->ID;
        // $user_login = $current_user->user_login;
        $date = date('Y/m/d H:i:s');

        $args = array(
            'post_type' => 'save_filter',
            'author' => $userID,
            'post_status' => 'publish'    
        );

       return $query = new WP_Query( $args );
     

    }
        
}



//Redirect after delete post in frontend
add_action('trashed_post','my_trashed_post_handler');
function my_trashed_post_handler($post_id) {
    if(!is_admin()){
         wp_redirect('http://localhost/lbp/marketplace/');
        exit;
    }
   
}

