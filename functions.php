<?php 
/* Theme setup
 * Enqueue scripts and styles
 * Add Typekit code to header
 * Content Width
 * Register widget area
 * Create custom posts
 * Create user role
 * Add capability to existing role - on theme activation
 * Create custom taxonomy
 * Remove the taxonomy UIs
 * Options settings page
 * Shortcode generic function
 * Add cmb2 options page
 * Reorder and rename Contact Form 7 Admin menu
 * Excerpt with custom word count
 * Form ajax callback function
 * Cross domain for ajax. CORS
 * Lazy Load - Infinite Scroll
 * Shows a google map
 * Admin login image & css
 * Admin login image link to home page
 * Admin login image link message
 * Admin Css
 * Soliloquy White Label
 * Restrict Soliloquy to admin only
 * Remove Soliloquy add slider button
 * Hides Soliloquy header in admin
 * Envira Gallery White Label
 * Hide envira gallery content buttons
 * Facebok share button
 * Show latest posts
 * Returns content by its post ID
 * Custom Post Admin list columns Header
 * Custom Post Admin list column content
 * Custom Post Admin list sort column
 * User list column header
 * User list column content
 * User list sort column
 * Remove Menu Items
 * Remove Sub Menu Items
 * Hide acf menu item
 * Login / logout menu item
 * Disable admin bar on the frontend of your website for subscribers
 * Redirect back to homepage and not allow access to WP admin for Subscribers
 * Change the email address that gets sent by wordpress
 * Change the Email name that gets sent from wordpress
 * Hides Monster insight side banners
 * Remove Dashboard Widgets
 * Remove Rev Slider Metabox
 * Output footer links from options
 * Call function from another plugin
 * Pre get posts example
 * Get all values for a meta field
 * Translate text in _()
 * Form Postback example
 */


require('inc/wp_bootstrap_navwalker.php');
//require('inc/wsr_nav_submenus.php');
//require('inc/WC_product_subcategories.php');
//require('woocommerce/wsr_woocommerce.php');

/***********************************************************
 * Theme setup
 */
add_action( 'after_setup_theme', 'wsr_theme_setup' );
function wsr_theme_setup() {

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wsr' ),
		'footer' => esc_html__( 'Footer', 'wsr' )
	) );

	//add_theme_support( 'title-tag' );
	//add_theme_support( 'custom-logo' );

	//add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size(630, 480, true);
	//add_image_size( 'post-thumb', 200, 200, true );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

 	//ACF Rates Options Page
	if( function_exists('acf_add_options_page') ) {
		$ACF_options_args = array(
			'page_title'	=> 'wsr Options',
			'menu_title' 	=> 'wsr Options',
			'menu_slug' 	=> 'wsr-options',
			//'parent_slug'	=> 'edit.php?post_type=wsr_converter',
			'icon_url' 		=> 'dashicons-admin-settings',
			'capability' 	=> 'edit_posts',
		);
		//acf_add_options_page($ACF_options_args);
	}
}



/***********************************************************
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'wsr_enqueue_scripts');
function wsr_enqueue_scripts(){
	if (!is_admin()) {
		//global $wp_query;  //** for Lazy Load - Infinite Scroll
		//css
    	wp_enqueue_style('bootstrap_style', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', false, '3.3.7');
    	wp_enqueue_style( 'style', get_stylesheet_uri(), array('bootstrap_style') ,'1.0'); 
      
    	//jquery - if want to load in footer instead
    	//wp_deregister_script('jquery');   
    	//wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false, '1.12.4', true);
    	//Bootstrap
    	wp_register_script( 'bootstrap_script', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true);
    	//wp_register_script( 'wsr_scrollreveal', 'https://cdn.jsdelivr.net/scrollreveal.js/3.3.1/scrollreveal.min.js', array( 'jquery' ), '1.0.0', true );
    	//wp_enqueue_script( 'wsr_scrollreveal' ); 

    	//masonry - add to wsr_script dependancies
    	//wp_enqueue_script('masonry');
    	wp_enqueue_script( 'wsr_script', get_stylesheet_directory_uri() . '/js/wsr.js', array('bootstrap_script'), '1.0', true );

		//passing vars to javascript
		//wp_localize_script('wsr_script', 'wsr_ajax', array(	
				//"ajaxurl" => admin_url('admin-ajax.php'),
				//	"ajax_nonce" => wp_create_nonce('any_value_here'),
				//	"siteurl" => get_bloginfo('url'),
				//	"themeUrl" => get_template_directory_uri(),
				//	"query" => $wp_query->query  //** for Lazy Load - Infinite Scroll
		//));


		//register fonts
		//wp_enqueue_script( 'wsr_typekit', 'https://use.typekit.net/');  //*** Uncomment function: wsr_typekit_inline
		//wp_register_script( 'wsr_edge', 'http://use.edgefonts.net/black-ops-one.js', array( 'jquery' ), '1.0', true  );
		//wp_enqueue_script( 'wsr_edge' );
        //wp_enqueue_style( 'gfonts',  "http://fonts.googleapis.com/css?family=Open+Sans:400,300");
	}
}


/***********************************************************
 * Add Typekit code to header
 */
//add_action( 'wp_head', 'wsr_typekit_inline' );
function wsr_typekit_inline() {
  if ( wp_script_is( 'wsr_typekit', 'done' ) ) { ?>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php }
}


/***********************************************************
 * Content Width - For use with Elementor to set the content width
 */
//dd_action( 'after_setup_theme', 'wsr_content_width', 0 );
function wsr_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wsr_content_width', 950 );
}




/***********************************************************
 * Register widget area.
 */
//add_action( 'widgets_init', 'wsr_widgets_init' );
function wsr_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wsr' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wsr' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}




/***********************************************************
 * Create custom posts
 */
//add_action('init', 'wsr_custom_post');
function wsr_custom_post(){

	$capabilities = array(
		'publish_posts' 		=> 'publish_portfolio',
		'edit_posts' 			=> 'edit_portfolio',
		'edit_others_posts' 	=> 'edit_others_portfolio',
		'delete_posts' 			=> 'delete_portfolio',
		'delete_others_posts' 	=> 'delete_others_portfolio',
		'read_private_posts' 	=> 'read_private_portfolio',
		'read_post' 			=> 'read_portfolio',
	);

	$labels = array(
		'name'	=> 'Portfolios',
		'singular_name'	=> 'Portfolio',
		'add_new_item'	=> 'Add New Portfolio',
		'edit_item'	=> 'Edit Portfolio',
		'new_item'	=> 'New Portfolio',
		'view_item'	=> 'View Portfolio',
		'search_items'	=> 'Search Portfolios',
		'not_found'	=> 'No Portfolios found',
		'not_found_in_trash' => 'No Portfolios found in trash',
		'all_items' => 'All Portfolios',
		'archives' => 'Portfolio Archives',
		'insert_into_item' => 'Insert into Portfolio',
		'uploaded_to_this_item' => 'Upload into this Portfolio'
	);

	register_post_type( 'wsr_portfolio', array(
		'label'		=> 'Portfolios',
		'labels'	=> $labels,
		'description'	=> 'Portfolio entries',
		'public'	=> true,
		'has_archive'	=> true,
		'show_ui' => true,
		'show_in_nav_menus'	=> true,
		'show_in_rest' => true,
		'menu_icon'	=> 'dashicons-admin-home',
		'taxonomies'	=> array('wsr_custom_tax'),
		'rewrite'	=> array('slug' => 'wsr-portfolio'),
		'capability_type' => 'portfolio',
		'capabilities'=>$capabilities,
		'supports'	=> array('title','editor','comments','revisions','thumbnail','author','page-attributes'),
	));

	flush_rewrite_rules(false);
}



/***********************************************************
 * Create user role
 */
//add_action('init', 'wsr_user_role');
function wsr_user_role(){
	add_role('portfolio_author', 'Portfolio Author', array (
		'publish_portfolio' => true,
		'edit_portfolio' => true,
		'edit_others_portfolio' => true,
		'delete_portfolio' => true,
		'delete_others_portfolio' => true,
		'read_private_portfolio' => true,
		'read_portfolio' => true,
		'read' => true,
	));
}



/***********************************************************
 * Add capability to existing role - on theme activation
 */
add_action("after_switch_theme", "viva_after_switch_theme"); 
function viva_after_switch_theme(){
    add_action( 'admin_init', 'vivs_add_theme_caps');
    function vivs_add_theme_caps() {
      $role = get_role( 'administrator' );
      $role->add_cap( 'publish_portfolio' ); 
      $role->add_cap( 'edit_portfolio' ); 
      $role->add_cap( 'edit_others_portfolio' ); 
      $role->add_cap( 'delete_portfolio' ); 
      $role->add_cap( 'delete_others_portfolio' ); 
      $role->add_cap( 'read_private_portfolio' ); 
      $role->add_cap( 'read_portfolio' ); 
    }
}



/***********************************************************
 * Create custom taxonomy
 */
//add_action('init', 'wsr_custom_taxonomy');
function wsr_custom_taxonomy(){

	//Register Size taxonomy
		$taxonomy_object_types = array(
	    	'wsr_portfolio'
	     );

		$taxonomy_args = array(
	    	'show_ui' 		=> true,
	    	'show_in_rest' => true,
	    	'rest_base'    => 'portfolio',
	    	'show_admin_column' => true,
	      	'hierarchical' 	=> true,
	       	'label' 		=> 'Size',
	       	'rewrite'	=> array('slug' => 'size')
	       );

    register_taxonomy('wsr_custom_tax', $taxonomy_object_types, $taxonomy_args);
}




/***********************************************************
 * Remove the taxonomy UIs
 */
function remove_taxonomies_ui() {
    //remove_meta_box( 'wsr_custom_tax', $this->settings['postName'], 'side' );
}



/***********************************************************
 * Options settings page
 */
//add_action('admin_menu', 'wsr_settings_page_menu');
function wsr_settings_page_menu() {
	//create new top-level menu
	add_menu_page('Contact Info', 'Contact Info', 'administrator', 'contact-info', 'wsr_settings_page' , 'dashicons-admin-settings');
	//call register settings function
	add_action( 'admin_init', 'wsr_settings_page_settings' );
}


function wsr_settings_page_settings() {
	register_setting( 'wsr-settings-page-group', 'phone_number' );
	register_setting( 'wsr-settings-page-group', 'business_address' );
	register_setting( 'wsr-settings-page-group', 'contact_email' );
}


function wsr_settings_page() { ?>
<div class="wrap">
<h1>Contact Info</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'wsr-settings-page-group' ); ?>
    <?php do_settings_sections( 'wsr-settings-page-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Phone Number</th>
        <td><input type="text" name="phone_number" size="35" value="<?php echo esc_attr( get_option('phone_number') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Business Address</th>
        <td><input type="text" name="business_address" size="35" value="<?php echo esc_attr( get_option('business_address') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Contact Email</th>
        <td><input type="text" name="contact_email" size="35" value="<?php echo esc_attr( get_option('contact_email') ); ?>" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>
<?php } 



/***********************************************************
 * Shortcode generic function
 */
//add_shortcode('wsr_shortcode', 'wsr_shortcode_query');
function wsr_shortcode_query(){
	//Enqueue any scripts needed    	
	//wp_enqueue_script( 'thickbox');

	//output html
		ob_start(); ?> 
		<p>html goes here</p>
		<!-- add lightbox -->
		<script> jQuery(document).ready(function(){ jQuery("a").nivoLightbox(); });</script>
	<?php return ob_get_clean();
}





/***********************************************************
 * Add cmb2 options page and menu item
 */
//add_action( 'admin_menu', 'add_cmb_options_page' );
function add_cmb_options_page() {
	$options_page = add_menu_page( 'Options', 'Options', 'edit_posts', 'wsr_options', 'admin_page_display');
	// Include CMB CSS in the head to avoid FOUC
	add_action( "admin_print_styles-{$options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
}




/***********************************************************
 * Add CMB2 metabox to option page.
 * Got to Resources/cmb2 to add extra fields to this page.
 */
function admin_page_display() { ?>
	<div class="wrap cmb2-options-page wsr_options">
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		<?php cmb2_metabox_form( 'wsr_option_metabox' , 'wsr_options' ); ?>
	</div>
	<?php 
}



/***********************************************************
 * Reorder and rename Contact Form 7 Admin menu
 */
//add_action('admin_menu', 'wsr_change_post_links');
function wsr_change_post_links() {
	global $menu;
	$menu[104] = $menu[27];
	$menu[104][0] = 'Contact Form';
	unset($menu[27]);
}



/***********************************************************
 * Excerpt with custom word count
 */
function wsr_trim_excerpt($limit) {
    echo wp_trim_words(get_the_excerpt(), $limit);
}



/***********************************************************
 *  Form ajax callback function
 */	
//add_action( 'wp_ajax_wsr_action', array($this, 'wsr_ajax_callback' ));
//add_action( 'wp_ajax_nopriv_wsr_action', array($this, 'wsr_ajax_callback' ));
function wsr_ajax_callback(){
	check_ajax_referer( 'any_value_here', 'security' );
	$postdata = $_POST['mydata'];
	$result = 'Returned data is ' . $postdata;
	wp_send_json_success($result);
	wp_die();
}



/******************************************************************
 * Cross domain for ajax. CORS
 * Allows ajax to connect from a differnt domain
 */
add_filter( 'allowed_http_origins', 'add_allowed_origins' );
function add_allowed_origins( $origins ) {
    $origins[] = 'https://site1.example.com';
    $origins[] = 'https://site2.example.com';
    return $origins;
}



/******************************************************************
* Lazy Load - Infinite Scroll
*/
//add_action( 'wp_ajax_wsr_ajax_load_more', 'wsr_ajax_load_more' );
//add_action( 'wp_ajax_nopriv_wsr_ajax_load_more', 'wsr_ajax_load_more' );
function wsr_ajax_load_more() {
	check_ajax_referer( 'any_value_here', 'security' );
	$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
	$args['paged'] = esc_attr( $_POST['page'] );
	$args['post_status'] = 'publish';
	$args['orderby'] = isset( $_POST['orderby'] ) ? esc_attr( $_POST['orderby'] ) : 'title';
	$args['order'] = isset( $_POST['order'] ) ? esc_attr( $_POST['order'] ) : 'DESC';

	if ( $_POST['catid'] > 0 ){
		$args['tax_query'][0]['taxonomy'] = 'product_cat';
		$args['tax_query'][0]['field'] = 'term_id';
		$args['tax_query'][0]['terms'] = $_POST['catid'];	
	}	

	ob_start();
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
		wc_get_template_part( 'content', 'product' );
	endwhile; endif; wp_reset_postdata();
	$data = ob_get_clean();

	wp_send_json_success( $data );
	wp_die();
}



/******************************************************************
 * Shows a google map based on address.  Uses jquery.geocomplete.min
 * https://github.com/ubilabs/geocomplete
 */
function get_gmap($address){ ?>
	<form>
		<input id="geocomplete" type="hidden" placeholder="Type in an address" value="" size="90" />
	</form>
	<div class="map_canvas"></div>
	
	<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
	<script src="<?php echo get_stylesheet_directory_uri();?>/js/jquery.geocomplete.min.js"></script>
	<script>
	  jQuery(function(){
	    
	    var options = {
	    	map: ".map_canvas",
	     	location: "<?php echo $address ?>",
	     	mapOptions: {
  	  			zoom: 1
  			}
	    };
	    jQuery("#geocomplete").geocomplete(options);
	    
	  });
	</script>
	<?php
}



/******************************************************************
 * Admin login image & css
 * image to be 80 x 80 pixels
 */
//add_action( 'login_enqueue_scripts', 'wsr_login_logo' );
function wsr_login_logo() { ?>
    <style type="text/css">
        .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-login-logo.png);
            padding-bottom: 0px!important;
        }
    </style>
<?php }




/******************************************************************
 * Admin login image link to home page
 *  
 */
//add_filter( 'login_headerurl', 'wsr_login_logo_url' );
function wsr_login_logo_url() {
    return home_url();
}




/******************************************************************
 * Admin login image link message
 *  
 */
//add_filter( 'login_headertitle', 'wsr_login_logo_url_title' );
function wsr_login_logo_url_title() {
    return 'Your Site Name and Info';
}



/******************************************************************
 * Admin Css
 */
//add_action('admin_head', 'admin_css');
function admin_css() {
  echo '<style>
    body, td, textarea, input, select {
      font-family: "Lucida Grande";
      font-size: 12px;
    } 
  </style>';
}


/******************************************************************
 *  Soliloquy White Label
 */
//add_filter( 'gettext', 'tgm_soliloquy_whitelabel', 10, 3 );
function tgm_soliloquy_whitelabel( $translated_text, $source_text, $domain ) {
    
    // If not in the admin, return the default string.
    if ( ! is_admin() ) {
        return $translated_text;
    }
 
    if ( strpos( $source_text, 'Soliloquy Slider' ) !== false ) {
        return str_replace( 'Soliloquy Slider', 'Slider', $translated_text );
    }
 
    if ( strpos( $source_text, 'Soliloquy Sliders' ) !== false ) {
        return str_replace( 'Soliloquy Sliders', 'Sliders', $translated_text );
    }
 
    if ( strpos( $source_text, 'Soliloquy slider' ) !== false ) {
        return str_replace( 'Soliloquy slider', 'slider', $translated_text );
    }
 
    if ( strpos( $source_text, 'Soliloquy' ) !== false ) {
        return str_replace( 'Soliloquy', 'Sliders', $translated_text );
    }
    
    return $translated_text;
    
}



/******************************************************************
 * Restrict Soliloquy to admin only
 */
//add_action( 'init', 'tgm_soliloquy_restrict_admin_access', -1 );
function tgm_soliloquy_restrict_admin_access() {
 
    if ( ! is_admin() ) {
        return;
    }
 
    if ( class_exists( 'Soliloquy' ) ) {
        if ( ! current_user_can( 'update_core' ) ) {
            remove_action( 'init', array( Soliloquy::get_instance(), 'init' ), 0 );
            remove_action( 'widgets_init', array( Soliloquy::get_instance(), 'widget' ) );
        }
    }
}



/******************************************************************
 * Remove Soliloquy add slider button
 */
//add_filter( 'soliloquy_media_button', 'remove_soliloquy_media_button' );
function remove_soliloquy_media_button( $button ) {
	return '';
}


/******************************************************************
* Hides Soliloquy header in admin
*/
//add_action('admin_head', 'soliquy_admin_css');
function soliquy_admin_css(){	
    echo '<style>#soliloquy-header{display:none;}</style>';
}



/******************************************************************
 * Envira Gallery White Label
 */
//add_filter( 'gettext', 'tgm_envira_whitelabel', 10, 3 );
function tgm_envira_whitelabel( $translated_text, $source_text, $domain ) {
    
    // If not in the admin, return the default string.
    if ( ! is_admin() ) {
        return $translated_text;
    }

    if ( strpos( $source_text, 'an Envira' ) !== false ) {
        return str_replace( 'an Envira', '', $translated_text );
    }
    
    if ( strpos( $source_text, 'Envira' ) !== false ) {
        return str_replace( 'Envira', 'Image', $translated_text );
    }
    
    return $translated_text;
}



/******************************************************************
* Hide envira gallery content buttons
*/
//add_action('admin_head', 'envira_admin_css');
function envira_admin_css() {
  echo '<style>
    #envira-media-modal-button,
    #envira-media-modal-button{
        display: none;
    } 
  </style>';
}





/******************************************************************
 * Facebok share button
 */
function outputFacebookShare(){ ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<!-- Your share button code -->
	<div class="fb-share-button" 
		data-href="<?php echo get_home_url();?>" 
		data-layout="button">
	</div>
<?php
}


/******************************************************************
 * Show latest posts
 */
function show_latest_posts(){
    $posts = get_posts( "post_type=post&numberposts=3" );
    if( $posts ) :
        foreach( $posts as $post ) : setup_postdata( $post ); ?>
            <div class="post">
                <a href="<?php echo get_permalink($post->ID); ?>"> <h3> <?php echo $post->post_title; ?> </h3></a>
                <?php the_excerpt(); ?>
            </div>
        <?php 
        endforeach;
    endif; 
}


/***********************************************************
 * Returns content by its post ID
 */
function get_the_content_by_id($post_id) {
	$page_data = get_post($post_id);
	$output  = '';
	if ($page_data) {
		$output = '<h2 class="entry-title">' . apply_filters('the_title', $page_data->post_title) . '</h2>';
		$output .= apply_filters('the_content', $page_data->post_content);
	return $output;
	}	
	return false;
}


/******************************************************************
 * Custom Post Admin list columns Header
 */
//add_filter('manage_{$post_type}_posts_columns' , 'add_wsr_resources_columns');
function add_wsr_resources_columns($columns) {
	//add to column
    unset($columns['author']);
    return array_merge($columns, 
              array('myfield' => __('My Field')
          ));
    
    //replace all columns
    return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title'),
        'myfield' => __('My Field'),
        'date' => __('Date')
    );

}



/******************************************************************
 * Custom Post Admin list column content
 */
//add_action( 'manage_{$post_type}_posts_custom_column' , 'custom_columns', 10, 2 );
function custom_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'myfield':
			echo 'xxx';
		break;
	}
}



/******************************************************************
 * Custom Post Admin list sort column
 */
//add_filter( 'manage_edit-wsr_resources_sortable_columns', 'wsr_resources_sortable_columns' );
function wsr_resources_sortable_columns( $columns ) {
	$columns['type'] = 'type';
	return $columns;
}


/* Only run our customization on the 'edit.php' page in the admin. */
//add_action( 'load-edit.php', 'edit_wsr_resources_load' );
function edit_wsr_resources_load() {
	add_filter( 'request', 'sort_wsr_resources' );
}

/* Sorts the movies. */
function sort_wsr_resources( $vars ) {
	/* Check if we're viewing the 'resources' post type. */
	if ( isset( $vars['post_type'] ) && 'wsr_resources' == $vars['post_type'] ) {
		/* Check if 'orderby' is set to 'duration'. */
		if ( isset( $vars['orderby'] ) && 'type' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'resource_type',
					'orderby' => 'meta_value'
				)
			);
		}
	}
	return $vars;
}



/******************************************************************
* User list column header
*/
//add_filter('manage_users_columns', 'wsr_add_user_id_column');
function wsr_add_user_id_column($columns) {
	//adds this custom colum at 3rd postition
    $newColumns = array_slice($columns, 0, 3, true) +
    array("column_id" => "Name to Display") +
    array_slice($columns, 3, count($columns) - 1, true) ;

    return $newColumns;
}



/******************************************************************
 * User list column content
 */
add_action('manage_users_custom_column',  'wsr_show_user_id_column_content', 10, 3);
function wsr_show_user_id_column_content($value, $column_name, $user_id) {
    $custom_field = get_field('custom_field', 'user_' . $user_id );
    if ( 'column_id' == $column_name )
        return $custom_field;
    return $value;
}



/******************************************************************
 * User list sort column
 */
//add_filter( 'manage_users_sortable_columns', 'wsr_make_registered_column_sortable' );
function wsr_make_registered_column_sortable( $columns ) {
    return wp_parse_args( array( 'column_id' => 'custom_field' ), $columns );
}



/******************************************************************
 * Remove Menu Items
 * https://premium.wpmudev.org/forums/topic/remove-menu-in-backend
 */

//add_action( 'admin_menu', 'remove_menus' );
function remove_menus(){
  remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'jetpack' );                    //Jetpack* 
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'plugins.php' );                //Plugins
  remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'options-general.php' );        //Settings
  
}


/******************************************************************
 * Remove Sub Menu Items
 * https://premium.wpmudev.org/forums/topic/remove-menu-in-backend
 */
//add_action( 'admin_menu', 'wsr_menu_page_removing' );
function wsr_menu_page_removing() {
    remove_submenu_page( 'themes.php', 'nav-menus.php' );
}



/******************************************************************
 * Hide acf menu item
 */
//add_filter('acf/settings/show_admin', '__return_false');



/******************************************************************
 * Login / logout menu item
 */
//add_filter('wp_nav_menu_items','wsr_login_func', 10, 2);
function wsr_login_func($nav, $args) {
          ob_start();
          wp_loginout('index.php');
          $loginoutlink = ob_get_contents();
          ob_end_clean();
     
          if( $args->theme_location == 'top-menu' ) {
                  $nav .= '<li>'. $loginoutlink .'</li>';
          }
     
          return $nav;
 }



/******************************************************************
 * Disable admin bar on the frontend of your website for subscribers.
 */
//add_action( 'after_setup_theme', 'wsr_disable_admin_bar' );
function wsr_disable_admin_bar() { 
	if ( ! current_user_can('edit_posts') ) {
		add_filter('show_admin_bar', '__return_false');	
	}
}



/******************************************************************
 * Redirect back to homepage and not allow access to WP admin for Subscribers.
 */
//add_action( 'admin_init', 'wsr_redirect_admin' );
function wsr_redirect_admin(){
	if ( ! defined('DOING_AJAX') && ! current_user_can('edit_posts') ) {
		wp_redirect( site_url() );
		exit;		
	}
}



/******************************************************************
 * Redirect to another page if logged in
 */
//add_action( 'template_redirect', 'wsr_page_template_redirect' );
function wsr_page_template_redirect(){
	if (is_user_logged_in() && is_page(1182)) {
		wp_redirect( home_url('/otherpage'));
		exit();
	}
}


/******************************************************************
 * Change the email address that gets sent by wordpress.  Change from wordpress@domain.com
 */
//add_filter("wp_mail_from", "wsr_filter_wp_mail_from");
function wsr_filter_wp_mail_from($email){
	return "hosting@webector.com.au";
}


/******************************************************************
 * Change the Email name that gets sent from wordpress
 */
//add_filter("wp_mail_from_name", "wsr_filter_wp_mail_from_name");
function wsr_filter_wp_mail_from_name($from_name){
	return "Web Sector";
}


/******************************************************************
* Hides Monster insight side banners
*/
//add_action('admin_head', 'insights_admin_css');
function insights_admin_css(){ 
    echo '<style>.yoast-ga-banners{display:none;}</style>';
}


/******************************************************************
* Remove Dashboard Widgets
*/
//add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
function remove_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
remove_action( 'welcome_panel', 'wp_welcome_panel' );


/******************************************************************
 * Remove Rev Slider Metabox
 */
add_action( 'do_meta_boxes', 'remove_revolution_slider_meta_boxes' );
function remove_revolution_slider_meta_boxes() {
	if ( is_admin() ) {
		remove_meta_box( 'mymetabox_revslider_0', 'page', 'normal' );
		remove_meta_box( 'mymetabox_revslider_0', 'post', 'normal' );
		remove_meta_box( 'mymetabox_revslider_0', 'portfolio', 'normal' );
	}
}


/******************************************************************
 * Output footer links from options
 */
function get_footer_link($linkname, $class){
	$alink = get_field($linkname, 'options');
	$output = '';
	if ($alink){
	    $output = '<a target="blank" href="' . $alink . '"><div class="' . $class . '"></div></a>';
	}
	return $output;
}


/******************************************************************
* Call function from another plugin
*/
//add_action( 'wp', 'wsr_setup_gallery_archives', 30 );
function wsr_setup_gallery_archives(){
	global $WC_Product_Gallery_slider;
	if (isset($WC_Product_Gallery_slider)){
		remove_action('woocommerce_before_shop_loop_item', array($WC_Product_Gallery_slider, 'show_product_gallery_archive'), 10);
		add_action('woocommerce_after_shop_loop_item_title', array($WC_Product_Gallery_slider, 'show_product_gallery_archive'), 30);
	}
}


/******************************************************************
* Pre get posts example
*/
//add_action('pre_get_posts', 'wsr_product_filter_query', 1000);
function wsr_product_filter_query($query) {
    if($query->is_search() && isset($_GET['wsr-query'])) {
    	//search
    	if (isset($_GET['s']) && !empty($_GET['s'])) {
			if (trim($_GET['s']) == ''){
				$query->set('s', '');
			}
		}
       	//meta 
       	if (isset($_GET['meta']) && !empty($_GET['meta'])){
       		$meta_query = $query->get('meta_query');
    		$meta_query[] = array(
		        'key' => 'key',
		        'value' => 'value',
		        'compare' => '='
		   	);
    		$query->set('meta_query', $meta_query);  
    	}

		$query->set('order', 'DESC');
		$query->set('orderby', 'date');
    }
    return $query;
}


/******************************************************************
* Get all values for a meta field
*/
function wsr_get_meta_values( $key = '', $type = 'post', $status = 'publish', $order = 'DESC' ) {
    global $wpdb;
    if( empty( $key ) )
        return;

    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'
        ORDER BY pm.meta_value {$order}
    ", $key, $status, $type ) );

    return $r;
}


/******************************************************************
* Translate text in _()
*/
//add_filter( 'gettext', 'wsr_change_translate_text', 20 );
function wsr_change_translate_text( $translated_text ) {
	if ( $translated_text == 'Old Text' ) {
		$translated_text = 'New Translation';
	}
	return $translated_text;
}


/******************************************************************
 * Form Postback example
 * Use admin-post.php as the postback url, and use a hidden action variable
 * After processing form, use re-direct
 * on the front end form:
 * <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ) ?>" >
 *	 <input type="hidden" name="action" value="register">
 *	 <input type="submit" >
 * </form>
 */
//guest user
add_action( 'admin_post_nopriv_register', 'wsr_register_function' );
//registered user
add_action( 'admin_post_register', 'wsr_register_function' );

function wsr_register_function{
	//redirect after processing
	$error = 'error message';
	wp_safe_redirect( site_url('/register' . '?regerr=' . rawurlencode($error)));
} 





