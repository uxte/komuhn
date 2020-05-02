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

//Add custom menu functionality
function new_custom_menu() {
  register_nav_menu('my-custom-menu',__( 'My Custom Menu' ));
}
add_action( 'init', 'new_custom_menu' );

function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);



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
// The portfolio post
function show_portfolio_post( $atts ) {

	$post = $atts[post];
	$post = get_page_by_path( $post, OBJECT, 'portfolio' ); //slug
	if ( $post ) {
		$post_excerpt = $post->post_excerpt;
		$post_link = get_permalink( $post );
		$post_image = get_the_post_thumbnail( $post );
		$post_ID = $post->ID;
		$post_color = get_post_meta( $post_ID, 'color_meta', 1) ;
		$post_size = $atts[size];
		$post_style = '';
		if ( $post_color ) {
			$post_style = 'style="background-color:' . $post_color . '"';
		}
		$post_class = '';
		if ( $post_size ) {
			$post_class = ' ' . $post_size;
		}

		$return_string = 	'<article class="project' . $post_class  . '" ' . $post_style . '>';
		$return_string .=		'<header>';
		$return_string .= 			'<h1>' . $post_excerpt . '</h1>';
		$return_string .= 			'<a class="button white" href="' . $post_link . '">Learn more</a>';
		$return_string .=		'</header>';
		if ( $post_image  ) {
		$return_string .= 		'<figure>' . $post_image . '</figure>';
		}
		$return_string .= 	'</article>';

		wp_reset_query();
		return $return_string;
	}
}
add_shortcode('portfolio-post','show_portfolio_post');

// The testimonial post
function show_testimonial_post( $atts ) {

	$post = $atts[post];
	$post = get_page_by_path( $post, OBJECT, 'testimonial' ); //slug
	if ( $post ) {
		$post_title = $post->post_title;
		$post_excerpt = $post->post_excerpt;
		$post_content = $post->post_content;
		$post_image = get_the_post_thumbnail( $post );

		$return_string = 	'<blockquote class="testimonial">';
		$return_string .=		'<header>';
		$return_string .= 			'<figure>' . $post_image . '</figure>';
		$return_string .= 			'<figcaption><cite>' . $post_title . '</cite><span>' . $post_excerpt . '</span></figcaption>';
		$return_string .=		'</header>';
		$return_string .=		$post_content;
		$return_string .= 	'</blockquote>';

		wp_reset_query();
		return $return_string;
	}
}
add_shortcode('testimonial-post','show_testimonial_post');



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
// function add_svg_to_upload_mimes( $upload_mimes ) {
// 	$upload_mimes['svg'] = 'image/svg+xml';
// 	$upload_mimes['svgz'] = 'image/svg+xml';
// 	return $upload_mimes;
// }
// add_filter( 'upload_mimes', 'add_svg_to_upload_mimes', 10, 1 );

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
//CPT Testimonial
add_action( 'init', 'testimonial_post_type' );
function testimonial_post_type() {
    register_post_type( 'testimonial',
        array(
            'labels' => array(
                'name' => __( 'Testimonials' ),
                'singular_name' => __( 'Testimonial' ),
                'add_new_item' => __( 'Add New Testimonial' )
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
            'menu_position' => 6,
            'menu_icon' => 'dashicons-image-filter'
        )
    );
}

//PORTFOLIO PROJECT META
add_action("admin_init", "admin_init");

function admin_init(){
    add_meta_box("client_meta", "Client/Project", "client_meta", "portfolio", "side", "high");
    add_meta_box("color_meta", "Background color (hex)", "color_meta", "portfolio", "side", "low");
}

function client_meta(){
    global $post;
    $custom = get_post_custom($post->ID);
    $client_meta = $custom["client_meta"][0];
    ?>
        <input name="client_meta" value="<?php echo $client_meta; ?>" style="width:100%;" />
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
