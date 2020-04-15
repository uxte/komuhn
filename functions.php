<?php
define("THEME_DIR", get_template_directory_uri());

/*--- REMOVE GENERATOR META TAG ---*/
remove_action('wp_head', 'wp_generator');

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//Remove Gutenberg Block Library CSS from loading on the frontend
// function smartwp_remove_wp_block_library_css(){
//     wp_dequeue_style( 'wp-block-library' );
//     wp_dequeue_style( 'wp-block-library-theme' );
// }
// add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css' );

// Disable REST API link tag
remove_action('wp_head', 'rest_output_link_wp_head', 10);

// Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

// Disable REST API link in HTTP headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

// Remove the links to xmlrpc.php and wlwmanifest.xml
function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
//Remove blocks library css
function wpassist_remove_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );

//
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

//This code will limit WordPress to only save your last 4 revisions of each post or page, and discard older revisions automatically.
define( 'WP_POST_REVISIONS', 4 );

function theme_slug_setup() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );

// /**
//  * Add custom CSS and JS
//  */
// function my_load_scripts($hook) {
//
//     // create my own version codes
//     //$my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/custom.js' ));
//     //$my_css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'style.css' ));
//
//     wp_enqueue_script( 'custom_js', get_template_directory_uri() . '/js/min/custom-min.js', array(), '1.0.0', true );
//     //wp_enqueue_script( 'custom_js', plugins_url( 'js/custom.js', __FILE__ ), array(), $my_js_ver );
//     //wp_register_style( 'my_css',    plugins_url( 'style.css',    __FILE__ ), false,   $my_css_ver );
//     //wp_enqueue_style ( 'my_css' );
//
// }
// add_action('wp_enqueue_scripts', 'my_load_scripts');

// SHORTCODES

function show_portfolio_post( $atts ) {

	$title = $atts[title];
	$post = get_page_by_title( $title, OBJECT, 'portfolio' );
	$post_title = $post->post_title;
	$post_link = get_permalink( $post );
	$post_image = get_the_post_thumbnail( $post );

	$return_string = 	'<article class="project">';
	$return_string .= 		'<h1>' . $post_title . '</h1>';
	$return_string .= 		'<a class="button" href="' . $post_link . '">Learn more</a>';
	$return_string .= 		'<figure>' . $post_image . '</figure>';
	$return_string .= 	'</article>';

	wp_reset_query();
	return $return_string;

}
add_shortcode('portfolio-post','show_portfolio_post');



// Add classes to body
add_filter( 'body_class','my_body_classes' );
function my_body_classes( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    // Check if there's a custom body-color from post custom-fields
    if ( $body_color = get_post_meta( $post->ID, 'body-color', true ) ) {
        $classes[] = $body_color;
    }

    return $classes;
}

//Enable SVG upload
function add_svg_to_upload_mimes( $upload_mimes ) {
	$upload_mimes['svg'] = 'image/svg+xml';
	$upload_mimes['svgz'] = 'image/svg+xml';
	return $upload_mimes;
}
add_filter( 'upload_mimes', 'add_svg_to_upload_mimes', 10, 1 );

//Enable thumbnails for CPT - featured image
add_theme_support( 'post-thumbnails' );

//CPT Portfolio
add_action( 'init', 'portfolio_post_type' );
function portfolio_post_type() {
    register_post_type( 'portfolio',
        array(
            'labels' => array(
                'name' => __( 'Portfolio' ),
                'singular_name' => __( 'Project' ),
                'add_new_item' => __( 'Add New Project' )
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
            'menu_position' => 5,
            'menu_icon' => 'dashicons-image-filter'
        )
    );
}

//PORTFOLIO PROJECT META
add_action("admin_init", "admin_init");

function admin_init(){
    add_meta_box("client_meta", "Client/Project", "client_meta", "portfolio", "side", "high");
    add_meta_box("display_meta", "Display", "display_meta", "portfolio", "side", "high");
    add_meta_box("color_meta", "Color (hex)", "color_meta", "portfolio", "side", "low");
}

function client_meta(){
    global $post;
    $custom = get_post_custom($post->ID);
    $client_meta = $custom["client_meta"][0];
    ?>
        <input name="client_meta" value="<?php echo $client_meta; ?>" style="width:100%;" />
    <?php
}
function display_meta(){
    global $post;
    $custom = get_post_custom($post->ID);
    $display_meta = $custom["display_meta"][0];
    ?>
        <label><input type="checkbox" name="display_meta" <?php if( $display_meta == true ) { ?>checked="checked"<?php } ?> /> 1/2 screen</label>
    <?php
}
function color_meta(){
    global $post;
    $custom = get_post_custom($post->ID);
    $color_meta = $custom["color_meta"][0];
    ?>
        <input name="color_meta" value="<?php echo $color_meta; ?>" />
    <?php
}

add_action('save_post', 'save_details');
    function save_details(){
        global $post;

        update_post_meta($post->ID, "client_meta", $_POST["client_meta"]);
        update_post_meta($post->ID, "display_meta", $_POST["display_meta"]);
        update_post_meta($post->ID, "color_meta", $_POST["color_meta"]);
    }
?>
