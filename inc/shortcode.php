<?php


add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment', 10 );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
?>
	<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'linkbuilding'); ?>"><i class="fal fa-cart-plus">
        <span class="cart-count" style="opacity: 1;"><?php echo WC()->cart->get_cart_contents_count(); ?></span></i>
    </a>
<?php
	
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;

}


//header mini cart
function custom_mini_cart() { 

	if(is_user_logged_in()){
		?>
		<div class="mini-cart-header">
			<div class="header_cart">
				<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'linkbuilding'); ?>"><i class="fal fa-cart-plus">
			        <span class="cart-count" style="opacity: 1;"><?php echo WC()->cart->get_cart_contents_count(); ?></span></i>
			    </a>
			</div>
			<div class="cart-dropdown">
				
				<ul class="dropdown-menu dropdown-menu-mini-cart">
					<li> 
						<div class="widget_shopping_cart_content">
								<?php echo woocommerce_mini_cart(); ?>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<?php
	}


}
add_shortcode( 'custom_mini_cart', 'custom_mini_cart' );

//right fixed sticky cart
function sticky_mini_cart() { 

?>
	
	<div class="mini-cart-header">

		<div class="fixed-cart">
			<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'linkbuilding'); ?>"><i class="fal fa-cart-plus">
		        <span class="cart-count" style="opacity: 1;"><?php echo WC()->cart->get_cart_contents_count(); ?></span></i>
		    </a>
			<div class="place-order-btn">
				<a href="<?php echo wc_get_checkout_url(); ?>"><span><i class="fal fa-credit-card"></i></span> Place Order</a>
			</div>
		</div>
	</div>

<?php

}
add_shortcode( 'sticky_mini_cart', 'sticky_mini_cart' );


//special offer product

function special_offer_dashboard(){
  	
  	$args = array(
        'posts_per_page' => 5, //No of product to be fetched
        'post_type' => 'product',
	'meta_query'  => array(

	    array(
			'key' => 'special_offer_enable',
			'value' => 'Yes',
			'compare' => '='
		)

	                
	 ),
        'order' => 'DESC',
        'orderby' => 'name',
        'post_status' => 'publish'   
    );

    $qry = new WP_Query($args);
    
        if($qry->have_posts()) {
        	?>
        	<div class="top-box">
				<h2>Special offers this week</h2>
					<div class="c-btn site-btn-2">
						<a href="<?php  echo get_the_permalink(26) ?>">Go to marketplace <i class="fas fa-arrow-right"></i></a>
					</div>
				</div>
				<div class="table-content-wrap">
					<div class="offer-top-heading top-heading-divs">
		                <div class="offer_div_tag_1 table-heading-div">Name</div>
		                <div class="offer_div_tag_2 table-heading-div">DR</div>
		                <div class="offer_div_tag_3 table-heading-div">OT</div>
		                <div class="offer_div_tag_4 table-heading-div">RD</div>
		                <div class="offer_div_tag_5 table-heading-div">Price</div>
	            	</div>
	            	<div class="bottom-product-divs">

	        	<?php

			        while($qry->have_posts()) {

			        		$qry->the_post();

			        		$product = wc_get_product(get_the_ID());
			        		$productID = get_the_ID();

			        		$product_title = get_the_title();
			                $product_price = $product->get_price();
			                
			                $domain_rating_dr = get_field('domain_rating_dr', get_the_ID());
			                $organic_traffic = get_field('organic_traffic', get_the_ID());
			                $domain_age = get_field('domain_age', get_the_ID());
			                

			        		?>
			        		<div class="product-offer-wrap product_offer_<?php echo $productID; ?>">
			        			

			        				<div class="offer-item_1 table-data-div">
				                        <p><?php echo $product_title; ?></p>
				                    </div>
				                    <div class="offer-item_2 table-data-div">
				                    	<!-- <span class="label-name">DR</span> -->
					                    <p><?php echo $domain_rating_dr; ?></p>
					                </div>
					                <div class="offer-item_3 table-data-div">
				                    	<!-- <span class="label-name">OT</span> -->
					                    <p><?php echo number_format((int)$organic_traffic); ?></p>
					                </div>
					                <div class="offer-item_4 table-data-div">
					                	<!-- <span class="label-name">RD</span> -->
					                    <p><?php echo $domain_age; ?></p>       
					                </div>

					                 <div class="offer-item_5 add-to-cart offer-cart">
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
			        		<?php 

			        }	

		        ?>
		    </div> <!-- end bottom-product-divs -->
			</div>
			
			<?php
        }

}

add_shortcode('special_offer_dashboard', 'special_offer_dashboard');