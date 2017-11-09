

<?php //For Woocomerece login and auto update cart **enable wsr_add_to_cart_fragment in functions ?>
 <div class="login-holder">
    <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="members" title="<?php _e('My Account','woothemes'); ?>"><?php _e('My Account','woothemes'); ?></a>

    <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $count = WC()->cart->cart_contents_count; ?>
        <img src="<?php echo get_stylesheet_directory_uri()?>/img/shoppingicon.png" class="img-responsive carticon" />
        <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><span class="cart-contents-count"><?php echo (($count > 0) ? esc_html( $count ) : 'Cart' ) ; ?></span></a>
    <?php } ?>
</div>
            

         