<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<section class="default-sec">

	<div class="top-cart-process">
		
		<div class="step-wrapper">
			<div class="step-heading">
				<h1>Your Order</h1>
			</div>
			<ul>
				<li class="active">
					<span class="step-no">1</span>
					<a href="<?php echo wc_get_cart_url() ?>"><span><i class="fal fa-cart-arrow-down"></i></span>
					Your Cart</a>
				</li>
				<li>
					<span class="step-no">2</span>
					<a href="<?php echo wc_get_checkout_url(); ?>"><span><i class="fal fa-bags-shopping"></i></span>
					Checkout</a>
				</li>
				<li>
					<span class="step-no">3</span>
					<div class="last-order-step"><span><i class="fal fa-ballot-check"></i></span>
					Your Order</div>
				</li>
			</ul>	
		</div>

	</div>

	<div class="cart-wrapper">
		
		<div class="row">
			<div class="col-md-8">

				<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
					<?php do_action( 'woocommerce_before_cart_table' ); ?>

					<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
						<thead>
							<tr>
								<th class="product-remove">&nbsp;</th>
								<th class="product-thumbnail hide">&nbsp;</th>
								<th class="product-name"><?php esc_html_e( 'Media', 'woocommerce' ); ?></th>
								<th class="product-niche hide"><?php esc_html_e( 'Restricted Niche', 'woocommerce' ); ?></th>
								<th class="product-cart-option"><?php esc_html_e( 'Select Product Options', 'woocommerce' ); ?></th>

								<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
								<th class="product-quantity hide"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
								<th class="product-subtotal hide"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php do_action( 'woocommerce_before_cart_contents' ); ?>

							<?php
							foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

								// echo '<pre>';

								// print_r($cart_item);
								// echo '</pre>';

								$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

								if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
									$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
									?>
									<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

										<td class="product-remove">
											<?php
												echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													'woocommerce_cart_item_remove_link',
													sprintf(
														'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fal fa-minus-circle"></i></a>',
														esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
														esc_html__( 'Remove this item', 'woocommerce' ),
														esc_attr( $product_id ),
														esc_attr( $_product->get_sku() )
													),
													$cart_item_key
												);
											?>
										</td>

										<td class="product-thumbnail hide">
											<?php
											$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

											if ( ! $product_permalink ) {
												echo $thumbnail; // PHPCS: XSS ok.
											} else {
												printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
											}
											?>
										</td>

										<td class="product-name doc_<?php echo $cart_item_key; ?>" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
										<?php
										if ( ! $product_permalink ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
										} else {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
										}

										do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

										// Meta data.
										echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

										// Backorder notification.
										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
										}
										?>
										</td>

										<td class="product-niche hide" data-title="<?php esc_attr_e( 'Restricted Niche', 'woocommerce' ); ?>">
											
											<div>
												<select class="prefix-cart-notes" id="cart_notes_<?php  echo $cart_item_key; ?>" data-cart-id="<?php  echo $cart_item_key; ?>" data-productid ="<?php echo $cart_item['product_id']; ?>" >
													<option value="None" <?php  if($cart_item['niche'] == "None"){ echo "selected"; } ; ?> >None</option>
													<option value="casino"<?php  if($cart_item['niche'] == "casino"){ echo "selected"; } ; ?> >Casino </option>
													<option value="loan" <?php  if($cart_item['niche'] == "loan"){ echo "selected"; } ; ?>>Loan</option>
													<option value="erotic" <?php  if($cart_item['niche'] == "erotic"){ echo "selected"; } ; ?>>Erotic</option>
													<option value="dating" <?php  if($cart_item['niche'] == "dating"){ echo "selected"; } ; ?>>Dating</option>
													<option value="cbd" <?php  if($cart_item['niche'] == "cbd"){ echo "selected"; } ; ?>>cbd</option>
													<option value="crypto" <?php  if($cart_item['niche'] == "crypto"){ echo "selected"; } ; ?>>Crypto</option>
												</select>
											</div>	
										</td>

										<?php 

											
											$bannerSelection = get_field('document_option', $product_id);

											$banner_widget_price = get_field('banner_widget_price', $product_id);
										    $article_price = get_field('article_price', $product_id);
										    $price_24_month = get_field('price_24_month', $product_id);
										    $price_for_permanent = get_field('price_for_permanent', $product_id);

										    if(!empty($banner_widget_price) && $banner_widget_price != 0){
									            $banner_widget_price_text = '+ $'.$banner_widget_price;    
									        }

									        if(!empty($article_price) && $article_price != 0){
									            $articlePriceText = '+ $'.$article_price;
									        }
									        if(!empty($price_24_month) && $price_24_month != 0){
									            $price_24_month_text = '+ $'.$price_24_month;
									        }
									        if(!empty($price_for_permanent) && $price_for_permanent != 0){
									            $price_for_permanent_text = '+ $'.$price_for_permanent;
									        }

										?>

										<td class="product-cart-option" data-title="<?php esc_attr_e( 'Product Cart options', 'woocommerce' ); ?>">
											
											<button type="button" class="blue-btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#popup_<?php  echo $cart_item_key; ?>">
											  Select Options
											</button>

											<!-- Modal -->
											<div class="modal fade key_<?php  echo $cart_item_key; ?>" id="popup_<?php  echo $cart_item_key; ?>" tabindex="-1" aria-labelledby="popup_<?php  echo $cart_item_key; ?>" aria-hidden="true">
											  <div class="modal-dialog">
											    <div class="modal-content">
											      <div class="modal-header">
											        <h5 class="modal-title" id="exampleModalLabel">Select Product option</h5>
											        <h6 class="hide">Cart Key : <?php  echo $cart_item_key; ?></h6>
											        <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close">X</button>
											      </div>
											      <div class="modal-body">
											        <section id="product-cart-options-<?php echo $cart_item_key; ?>" class="product-cart-options">
														
											        	<input type="hidden" name="cart_product_id" id="cart_product_id" value="<?php echo $product_id; ?>">
											        	<input type="hidden" name="custom_modal_id" id="custom_modal_id" value="popup_<?php  echo $cart_item_key; ?>">

														<div class="cart-form-field c-show-hide">
															<label>What you prefer to upload?</label>
															<select class="cart-select doc_upload" id="doc_upload" name="doc_upload" data-dockey="<?php echo $cart_item_key; ?>">
													           	<option value="">Select options</option>
													           	<?php 
													           		if($bannerSelection[0] === "banner"){
													           			?>
													           				<option value="banner">Yes, put our backlinks in the side widget for an extra <?php echo $banner_widget_price_text; ?></option>
													           			<?php
													           		}
													           	?>
													           
													           	<option value="article">I prefer an article with our backlink published</option>
													        </select>

														</div>

														<div class="cart-form-field c-show-hide hidden" data-show="article" data-hide="banner">
															<label>Who provide article/content ?</label>
															<select class="cart-select who_provide_article" id="who_provide_article" name="who_provide_article" data-dockey="<?php echo $cart_item_key; ?>">
													           	<option value="">Select options</option>
													           	<option value="own_article">You have your own article/content (Please upload File)</option>
													           	<option value="write_content">We provide Article/Content for you (Please provide Anchor text, Article suggestions & requirements) <?php echo $articlePriceText; ?></option>
													        </select>
														</div>

														<div class="article-write-field c-show-hide hidden" data-show="write_content" data-hide="own_article">
															<div class="cart-form-field">
																<label>Anchor text</label>
																<input type="text" name="article_anchor_text" id="article_anchor_text">
															</div>
															<div class="cart-form-field">
																<label>Article suggestions & requirements</label>
																<input type="text" name="article_req" id="article_req">
															</div>
														</div>

														<div class="cart-form-field">
															<label>Choose Publish period</label>
															<select class="cart-select" id="publish_period" name="publish_period">
													           	<option value="">Select options</option>
													           	<option value="12Month">12 Month (Included in default Price )</option>
													           	<option value="24Month">24 Month <?php echo $price_24_month_text; ?></option>
													           	<option value="permanent">Permanent <?php echo $price_for_permanent_text; ?></option>
													        </select>
														</div>

														<div class="cart-form-field">
															<label>Internal Reference </label>
															<textarea class="cart-textarea" id="internal_ref" name="internal_ref"></textarea>
														</div>

													

													</section>
											      </div>
											      <div class="modal-footer">

											      	<button class="submit-cart-data blue-btn" data-cartkey="<?php  echo $cart_item_key; ?>" >Submit and close</button>
											       <!--  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
											      </div>
											    </div>
											  </div>
											</div>

										</td>

										<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
											<?php
												echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
											?>
										</td>

										<td class="product-quantity hide" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
										<?php
										if ( $_product->is_sold_individually() ) {
											$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
										} else {
											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $_product->get_max_purchase_quantity(),
													'min_value'    => '0',
													'product_name' => $_product->get_name(),
												),
												$_product,
												false
											);
										}

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
										?>
										</td>

										<td class="product-subtotal hide" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
											<?php
												echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
											?>
										</td>
									</tr>
									<?php
								}
							}
							?>

							<?php do_action( 'woocommerce_cart_contents' ); ?>

							<tr>
								<td colspan="6" class="actions">

									<?php if ( wc_coupons_enabled() ) { ?>
										<div class="coupon">
											<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
											<?php do_action( 'woocommerce_cart_coupon' ); ?>
										</div>
									<?php } ?>

									<button type="submit" class="button xhide trigger-total" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

									<?php do_action( 'woocommerce_cart_actions' ); ?>

									<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
								</td>
							</tr>

							<?php do_action( 'woocommerce_after_cart_contents' ); ?>
						</tbody>
					</table>
					<?php do_action( 'woocommerce_after_cart_table' ); ?>

					
				</form>

				<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
			    
				<div class="add-more-site">
					<a href="<?php echo get_the_permalink(26); ?>" class="white">Add more site <span><i class="fal fa-long-arrow-right"></i></span></a>
				</div>
				
			</div>
			<div class="col-md-4">
				

				<div class="cart-collaterals">
					<?php
						/**
						 * Cart collaterals hook.
						 *
						 * @hooked woocommerce_cross_sell_display
						 * @hooked woocommerce_cart_totals - 10
						 */
						do_action( 'woocommerce_cart_collaterals' );
					?>
				</div>

			</div>
		</div>
	</div>


</section>

<?php do_action( 'woocommerce_after_cart' ); ?>
