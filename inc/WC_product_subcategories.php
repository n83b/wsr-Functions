<?php
/***********************************************************
 * Woocoomerce custom categories
 * Overrides the core woocommerce_product_subcategories function to dynamically output the product categories
 */
if ( ! function_exists( 'woocommerce_product_subcategories' ) ) {

	/**
	 * Display product sub categories as thumbnails.
	 *
	 * @subpackage	Loop
	 * @param array $args
	 * @return null|boolean
	 */
	function woocommerce_product_subcategories( $args = array() ) {

		global $wp_query;

		$defaults = array(
			'before'        => '',
			'after'         => '',
			'force_display' => false
		);

		$args = wp_parse_args( $args, $defaults );

		extract( $args );

		// Main query only
		if ( ! is_main_query() && ! $force_display ) {
			return;
		}

		// Don't show when filtering, searching or when on page > 1 and ensure we're on a product archive
		if ( is_search() || is_filtered() || is_paged() || ( ! is_product_category() && ! is_shop() ) ) {
			return;
		}

		// Check categories are enabled
		if ( is_shop() && '' === get_option( 'woocommerce_shop_page_display' ) ) {
			return;
		}

		// Find the category + category parent, if applicable
		$term 			= get_queried_object();
		$post_term_id 		= empty( $term->term_id ) ? 0 : $term->term_id;

		if ( is_product_category() ) {
			$display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

			switch ( $display_type ) {
				case 'products' :
					return;
				break;
				case '' :
					if ( '' === get_option( 'woocommerce_category_archive_display' ) ) {
						return;
					}
				break;
			}
		}

		// NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( https://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work
		$product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
			'parent'       => 0,
			'menu_order'   => 'ASC',
			'hide_empty'   => 0,
			'hierarchical' => 1,
			'taxonomy'     => 'product_cat',
			'pad_counts'   => 1
		) ) );

		if ( ! apply_filters( 'woocommerce_product_subcategories_hide_empty', false ) ) {
			$product_categories = wp_list_filter( $product_categories, array( 'count' => 0 ), 'NOT' );
		}

		if ( $product_categories ) {
			echo $before;
			//Top level Categories
			echo '<ul class="product-cats nav nav-tabs" role="tablist">';
				echo '<li class="browseby">Browse by:</li>';
				echo '<li class="category ' . (($post_term_id == 0) ? 'active' : '') . '"><a class="all-wines" href="' . get_permalink( woocommerce_get_page_id( 'shop' )) . '" >All Wines</a></li>';
				foreach ( $product_categories as $category ) {
					echo '<li class="category ' . ((term_is_ancestor_of($category->term_id, $post_term_id, "product_cat" )) ? 'active' : "") . '" role="presentation">';                 
		                    echo '<a class="' . $category->slug . '" href="#' . $category->slug .'-cat" aria-controls="' . $category->slug .'-cat" role="tab" data-toggle="tab">';
		                        echo $category->name;
		                    echo '</a>';           
		            echo '</li>';
				}
			echo '</ul>';

			//Sub Categories
			echo '<div class="tab-content">';
			echo '<div id="all-wines-cat" class="tab-pane ' . (($post_term_id == 0) ? 'active' : '') . '" role="tabpanel"><ul class="product-sub-cats"><li class="subcategory"></li></ul></div>';
				foreach ( $product_categories as $category ) {
					//echo print_r($category, true);
					$sub_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
						'parent'       => $category->term_id,
						'menu_order'   => 'ASC',
						'hide_empty'   => 1,
						'hierarchical' => 1,
						'taxonomy'     => 'product_cat',
						'pad_counts'   => 1
					) ) );
					

					echo '<div id="' . $category->slug .'-cat" class="tab-pane ' . ((term_is_ancestor_of($category->term_id, $post_term_id, "product_cat" )) ? 'active' : "") . '" role="tabpanel">';
						echo '<ul class="product-sub-cats">';
						foreach ( $sub_categories as $subcategory ) {
							echo '<li class="subcategory">';                 
				                    echo '<a href="' .  esc_url( get_term_link( $subcategory ) ) . '" class="' . $subcategory->slug . ' ' . (($post_term_id == $subcategory->term_id ) ? 'active' : '') .'">';
				                        echo $subcategory->name;
				                    echo '</a>';           
				            echo '</li>';
						}
						echo '</ul>';
					echo '</div>';
				}
			echo '</div>';


			// If we are hiding products disable the loop and pagination
			if ( is_product_category() ) {
				$display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

				switch ( $display_type ) {
					case 'subcategories' :
						$wp_query->post_count    = 0;
						$wp_query->max_num_pages = 0;
					break;
					case '' :
						if ( 'subcategories' === get_option( 'woocommerce_category_archive_display' ) ) {
							$wp_query->post_count    = 0;
							$wp_query->max_num_pages = 0;
						}
					break;
				}
			}

			if ( is_shop() && 'subcategories' === get_option( 'woocommerce_shop_page_display' ) ) {
				$wp_query->post_count    = 0;
				$wp_query->max_num_pages = 0;
			}

			echo $after;

			return true;
		}
	}
}