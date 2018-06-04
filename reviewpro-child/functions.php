
<?php
/*
* ReviewPro Child Theme Function File
*
* Contains all of the Theme's setup functions, custom functions,
* custom hooks and Theme settings.
*
*/
// Load PHP File
require 'inc/template-tags.php';

// Add Back To Top
	add_action( 'wp_footer', 'vhwp_back_to_top_script' );
		function vhwp_back_to_top_script() {
    		echo '<script type="text/javascript">
        		jQuery(document).ready(function($){
            		$(window).scroll(function () {
                		if ( $(this).scrollTop() > 400 )
                   			$("#totop").fadeIn();
                		else
                    		$("#totop").fadeOut();
            			}); 
            		$("#totop").click(function () {
                		$("body,html").animate({ scrollTop: 0 }, 800 );
                			return false;
            				});
        				});
    			</script>';
	}
	add_action( 'wp_footer', 'add_back_to_top' );
		function add_back_to_top() {
    		echo '<a id="totop" href="#"><i class="fa fa-arrow-up"></i>
			</a>';
	}

// Add Comment Counter
	function vhwp_comment_count() {
		global $wpdb;
		$count = $wpdb->get_var('SELECT COUNT(comment_ID) FROM ' . $wpdb->comments. ' WHERE comment_author_email = "' . get_comment_author_email() . '"');
		echo '<a id="counter">'.$count.' Bình Luận</a>';
	}

// Open Link In New Tab
add_filter('widget_text', 'vhwp_open_comment_author_link_in_new_window');
add_filter('get_comment_author_link', 'vhwp_open_comment_author_link_in_new_window');
add_filter('comment_text', 'vhwp_open_comment_author_link_in_new_window');
function vhwp_open_comment_author_link_in_new_window($content) {
$content = preg_replace_callback( '/<a[^>]*href=["|\']([^"|\']*)["|\'][^>]*>([^<]*)<\/a>/i',
function($m) {
	if (strpos($m[1], "https://link-cua-ban.com") === false && strpos($m[1], "https://link-cua-ban.com") === false)
	return '<a href="'.$m[1].'" rel="nofollow" target="_blank">'.$m[2].'</a>';
else
	return '<a href="'.$m[1].'" target="_blank">'.$m[2].'</a>';
},
	$content);
	return $content;
}

// Clean WordPress Header
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head, 10, 0');

// Move JS To Footer
	function remove_head_scripts() { 
		remove_action('wp_head', 'wp_print_scripts'); 
		remove_action('wp_head', 'wp_print_head_scripts', 9); 
		remove_action('wp_head', 'wp_enqueue_scripts', 1);
 
		add_action('wp_footer', 'wp_print_scripts', 5);
		add_action('wp_footer', 'wp_enqueue_scripts', 5);
		add_action('wp_footer', 'wp_print_head_scripts', 5); 
 	} 
	 add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );

// Asynchronous JS
	function async_js($tag){
		$scripts_to_async = array('script-1.js', 'script-2.js', 'script-3.js', 'script-4.js', 'script-5.js');
		foreach($scripts_to_async as $async_script){
			if(true == strpos($tag, $async_script ) )
			return str_replace( ' src', ' async="async" src', $tag );	
		}
		return $tag;
		}
		add_filter( 'script_loader_tag', 'async_js', 10 );

// Remove Query String
	function remove_cssjs_ver( $src ) {
		if( strpos( $src, '?ver=' ) )
		$src = remove_query_arg( 'ver', $src );
		return $src;
   	}
		add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
		add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

// Remove Image Link
	function wpb_imagelink_setup() {
		$image_set = get_option( 'image_default_link_type' );
	
		if ($image_set !== 'none') {
			update_option('image_default_link_type', 'none');
		}
	}
	add_action('admin_init', 'wpb_imagelink_setup', 10);