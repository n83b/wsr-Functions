<?php
/*
 * Enqueue woo scripts and styles
 * Woocommerce Declare theme template support
 * Cart AJAX update fragments
 * Mobile breakpoint
 * Remove sidebar and breadcrumbs
 * Custom product meta fields
 * Related products column count
 * Move product description out of tabs into summary
 * Custom setting page fields
 * Outputs members price to non members - percentage only 
 * Add to cart ajax on single product page
 * Remove WooCommerce Updater
 * Reduce the strength requirement on the woocommerce password
 * Hide Price if zero
 * Check if User has an active Membership 
 * Hide shipping rates when free shipping is available
 * Product search 
 */


/***********************************************************
 * Enqueue woo scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'wsr_woo_scripts');
function wsr_woo_scripts(){
	if (!is_admin()) {
		//(is_woocommerce() || (is_woocommerce() && is_archive())) {
		//     add_thickbox();
		//} 
	}
}



/***********************************************************
 * Woocommerce Declare theme template support
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
function my_theme_wrapper_start() {
  echo '<div class="container"><div class="row"><div class="col-xs-12">';
}

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
function my_theme_wrapper_end() {
  echo '</div></div></div>';
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}



/***********************************************************
 * Cart AJAX update fragments
 */
//add_filter( 'woocommerce_add_to_cart_fragments', 'wsr_add_to_cart_fragment' );
function wsr_add_to_cart_fragment( $fragments ) {
    ob_start();
    $count = WC()->cart->cart_contents_count; ?>
    <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><span class="cart-contents-count"><?php echo (($count > 0) ? esc_html( $count ) : 'Cart' ) ; ?></span></a>
    <?php $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}



/***********************************************************
 * Mobile breakpoint
 */
//add_filter('woocommerce_style_smallscreen_breakpoint','woo_custom_breakpoint');
function woo_custom_breakpoint($px) {
  $px = '992px';
  return $px;
}



/***********************************************************
 * Remove sidebar and breadcrumbs
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
//remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );



/************************************************************
 * Custom product meta fields - http://www.remicorson.com/mastering-woocommerce-products-custom-fields/
 */
//add_action( 'woocommerce_product_options_general_product_data', 'wsr_add_custom_general_fields' );
function wsr_add_custom_general_fields() {
	global $woocommerce, $post;
	$value = get_post_meta( $post->ID, '_unit_field', true );
	$value =  (empty($value) ? 'per bottle' : $value);

	echo '<div class="options_group">';
		woocommerce_wp_text_input(
			array(
				'id'          => '_unit_field',
				'label'       => __( 'Unit Text', 'woocommerce' ),
				'placeholder' => 'per bottle',
				'desc_tip'    => 'true',
				'description' => __( 'Enter the unit text here.', 'woocommerce' ),
				'value'		  => $value
			)
		);
	echo '</div>';
}

// Save woocommerce custom fields
//add_action( 'woocommerce_process_product_meta', 'wsr_add_custom_general_fields_save' );
function wsr_add_custom_general_fields_save( $post_id ){
	$woocommerce_text_field = $_POST['_unit_field'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, '_unit_field', esc_attr( $woocommerce_text_field ) );
}

//Output custom textfield after price
//add_filter( 'woocommerce_get_price_html', 'wsr_custom_price_message' );
function wsr_custom_price_message( $price ) {
	global $post;
	$unit = get_post_meta( $post->ID, '_unit_field', true );
	$memberslink = get_home_url() . '/wine-club';
	return $price . ' ' . $unit;
}



/***********************************************************
 * Related products column count
 */
// function woocommerce_output_related_products() {
// 	woocommerce_related_products(array('posts_per_page' => 3, 'columns' => 3, 'orderby' => false ));       // Display 4 products in 3 columns
// }



/***********************************************************
 * Move product description out of tabs into summary
 */
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_product_description', 20 );
function woocommerce_template_product_description() {
	echo '<div class="wsr-single-product-content">';
	woocommerce_get_template( 'single-product/tabs/description.php' );
	echo '</div>';
}



/***********************************************************
 * Custom setting page fields
 *
 * https://www.skyverge.com/blog/add-custom-options-to-woocommerce-settings/
 * Filters:
 * woocommerce_general_settings
 * woocommerce_catalog_settings
 * woocommerce_page_settings
 * woocommerce_inventory_settings
 * woocommerce_tax_settings
 * woocommerce_shipping_settings
 * woocommerce_payment_gateways_settings
 * woocommerce_email_settings
 *
 * Below example adds shipping note field to shipping options page
 */
add_filter('woocommerce_shipping_settings', 'wsr_shipping_note');
function wsr_shipping_note($settings){
	$updated_settings = array();

  	foreach ( $settings as $section ) {
	    // at the bottom of the General Options section
	    if ( isset( $section['id'] ) && 'shipping_options' == $section['id'] &&
	       isset( $section['type'] ) && 'sectionend' == $section['type'] ) {

			$updated_settings[] = array(
		        'name'     => __( 'Shipping note', 'wsr' ),
		        'desc_tip' => __( 'Enter the text you want displayed under the Add to cart button on the single product page.', 'wsr' ),
		        'id'       => 'wsr_shipping_note',
		        'type'     => 'textarea',
		        'css'      => 'min-height:300px;min-width:300px;',
		        'std'      => '',  // WC < 2.0
		        'default'  => '',  // WC >= 2.0
		        'desc'     => __( 'Shipping note displayed under the Add to cart button on the single product page.', 'wsr' ),
		      );
 		}
    	$updated_settings[] = $section;
    }
    return $updated_settings;
}



/***********************************************************
 * Outputs members price to non members - percentage only
 */
add_action( 'woocommerce_after_shop_loop_item', 'wsr_members_link', 0, 5 );
add_action( 'woocommerce_single_product_summary', 'wsr_members_link', 25 );
function wsr_members_link(){
	global $product;
	$output = '<span class="price"><a href="#membership-link" class="product-member-link">Become a member</a></span>';
	if (!wc_memberships_user_has_member_discount()){
		//use membership user id here
		$membership = wc_memberships_get_user_membership(666);
		if ($membership){
			$strDiscount = wc_memberships_get_member_product_discount($membership, get_the_id());
			if (strpos($strDiscount, '%') !== false) {
				$fltDiscount = floatval(str_replace('%', '', $strDiscount ));
				$discountAmount = number_format(($product->get_price() / 100) * $fltDiscount, 2);
				$discountOutput = number_format($product->get_price() - $discountAmount, 2);
				$output = "<span class='price'><a href='#membership-link' class='product-member-link'>$" . $discountOutput . " member's <span class='mprice'>price</span></a></span>";
			}
		}
		echo $output;
	}
}



/***********************************************************
 * Add to cart ajax on single producty page (remove normal button and add ajax one)
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_add_to_cart', 30 );
add_action('woocommerce_single_product_summary', 'custom_quantity_field_archive', 25);



/***********************************************************
 * Remove WooCommerce Updater
 */
remove_action('admin_notices', 'woothemes_updater_notice');



/***********************************************************
 * Reduce the strength requirement on the woocommerce password.
 *
 * Strength Settings
 * 3 = Strong (default)
 * 2 = Medium
 * 1 = Weak
 * 0 = Very Weak / Anything
 */
add_filter( 'woocommerce_min_password_strength', 'reduce_woocommerce_min_strength_requirement' );
function reduce_woocommerce_min_strength_requirement( $strength ) {
    return 1;
}



/***********************************************************
 * Hide Price if zero
 */
add_filter( 'woocommerce_get_price_html','custom_free_price_text' );
function custom_free_price_text( $pPrice ) {
    global $product;
    $price = $product->get_price();

    if($price == '0.00') {
		return '<div class="divCallForPrice">Call for price & availability.<br><a href="tel:+0400000000">(08) 8333 1234</a></div>';
    } else {
        return $pPrice;
    }
}



/***********************************************************
/* Check if User has an active Membership 
*/
function is_user_active_member(){
	$isactive = false;
	if ( ! function_exists( 'wc_memberships' ) ) { return; }

	$user_id = get_current_user_id();
	$args = array( 
		'status' => array( 'active', 'complimentary', 'pending' ),
	);
	
	$active_memberships = wc_memberships_get_user_memberships( $user_id, $args );
	if ( !empty( $active_memberships ) ) {
		$isactive = true;
	}

	return $isactive;
}



/***********************************************************
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 */
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}



/***********************************************************
 * Product search - use this on front end
<form role="search" method="get" class="searchform" action="<?php esc_url( home_url( '/'  ) ); ?>">
    <input class="blue-search" placeholder="Search the site..." value="<?php echo get_search_query() ?>" name="s">
    <input type="hidden" name="post_type" value="product" />
</form>
*/

