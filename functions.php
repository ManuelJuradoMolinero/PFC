<?php
/* -----------------------------------------------------------------------------------
  Here we have all the custom functions for the theme
  Please be extremely cautious editing this file,
  When things go wrong, they tend to go wrong in a big way.
  You have been warned!
  ----------------------------------------------------------------------------------- */
/*
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
  ----------------------------------------------------------------------------------- */
define('CAPITAL_THEME_PATH', get_template_directory_uri());
define('CAPITAL_FILEPATH', trailingslashit(get_template_directory()));
/* -------------------------------------------------------------------------------------
  Load Translation Text Domain
  ----------------------------------------------------------------------------------- */
add_action('after_setup_theme', 'capital_theme_setup');
function capital_theme_setup() {
    load_theme_textdomain('capital', CAPITAL_FILEPATH . '/language');
}
/* -------------------------------------------------------------------------------------
  Menu option
  ----------------------------------------------------------------------------------- */
function capital_register_menu() {
    register_nav_menu('primary-menu', esc_html__('Primary Menu', 'capital'));
    register_nav_menu('topbar-menu', esc_html__('Topbar Menu', 'capital'));
	register_nav_menu('footer-menu', esc_html__('Footer Menu', 'capital'));
}
add_action('init', 'capital_register_menu');
/* -------------------------------------------------------------------------------------
  Set Max Content Width (use in conjuction with ".entry-content img" css)
  ----------------------------------------------------------------------------------- */
if (!isset($content_width))
    $content_width = 680;
/* -------------------------------------------------------------------------------------
  Configure WP2.9+ Thumbnails & gets the current post type in the WordPress Admin
  ----------------------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'capital_theme_support_setup' );

if ( !function_exists( 'capital_theme_support_setup' ) ) {
	function capital_theme_support_setup() {
		add_theme_support('post-formats', array(
			'video', 'image', 'gallery', 'audio'
		));
		add_theme_support('post-thumbnails');
		add_theme_support('woocommerce');
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		set_post_thumbnail_size(958, 9999);
		add_image_size('capital-600x400', 600, 400, true);
	}
}
/* -------------------------------------------------------------------------------------
  Load Theme Options
  ----------------------------------------------------------------------------------- */
require_once( CAPITAL_FILEPATH. '/framework/includes.php' );
require_once CAPITAL_FILEPATH. '/framework/barebones-config.php';

/* -------------------------------------------------------------------------------------
  Excerpt More and length
  ----------------------------------------------------------------------------------- */
if (!function_exists('capital_excerpt')) {
    function capital_excerpt($limit = 50, $closing =' ') {
		if ( get_the_content()!="" || get_the_excerpt()!="" ) {
        return '<p>' . wp_trim_words(get_the_excerpt(), $limit).$closing.'</p>';
		} else {
        return '';
		}
    }
}
/* -------------------------------------------------------------------------------------
  For Pagination
  ----------------------------------------------------------------------------------- */
if (!function_exists('capital_pagination')) {
    function capital_pagination() {
		$pages = get_the_posts_pagination( array(
		'prev_text'	=> '<i class="fa fa-chevron-left"></i>',
		'next_text'	=> '<i class="fa fa-chevron-right"></i>',
		'type'      => 'list',
    ));
   	echo '<div class="pagination-wrap">'.$pages.'</div>'; 
    }
}
/* 	Comment Styling
  /*----------------------------------------------------------------------------------- */
if (!function_exists('capital_comment')) {
    function capital_comment($comment, $args, $depth) {
        $isByAuthor = false;
        if ($comment->comment_author_email == get_the_author_meta('email')) {
            $isByAuthor = true;
        }
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div class="post-comment-block">
                <div id="comment-<?php comment_ID(); ?>">
                    <?php echo get_avatar($comment, $size = '80','', '',  array('class'=>'img-thumbnail')); ?>
                    <div class="post-comment-content">
						<?php
						 echo preg_replace('/comment-reply-link/', 'comment-reply-link pull-right btn btn-primary btn-xs', get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => 'REPLY'))), 1);
					   echo '<h5 class="comment-author"><span class="comment-type">'.get_comment_type('', 'trackback', 'pingback').' </span><a href="'.get_comment_author_url().'">' . get_comment_author() .'</a><span class="comment-author">'.esc_html__(' says','capital').'</span></h5>';
						?>            
						<span class="meta-data">
							<?php
							echo get_comment_date();
							esc_html_e(' at ', 'capital');
							echo get_comment_time();
							?>
						</span>
						<?php if ($comment->comment_approved == '0') : ?>
							<em class="moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'capital') ?></em>
							<br />
						<?php endif; ?>
						<div class="comment-text post-content">
							<?php comment_text() ?>
						</div>
                	</div>
            	</div>
			</div>
        <?php
        }
    }
// Custom One Pager Menu
class Capital_Walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' data-id="'. esc_attr( $item->object_id        ) .'"';
        $attributes .= ' data-slug="'. esc_attr(  basename(get_permalink($item->object_id )) ) .'"';
        $attributes .= ' data-home-url=""';



        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>'; /* This is where I changed things. */
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
//Add custom class on body tag
function capital_add_body_class( $classes ) {
	$options = get_option('capital_options');
    /** Theme layout design * */
	if(is_home()){
		$id = get_option('page_for_posts');
	} else {
		$id = get_the_ID();
	}
	$page_layout = get_post_meta($id,'capital_page_layout', true);
	if($page_layout != ''){
		$bodyClass = $page_layout;
	} else {
		$bodyClass = (isset($options['site_layout'])&&$options['site_layout'] == 'boxed') ? ' boxed' : '';
	}
	$header_style = (isset($options['header_layout']))?$options['header_layout']:'1';
    $classes[] = $bodyClass;
	$classes[] = 'header-style'.$header_style;
    return $classes;
}
add_filter( 'body_class', 'capital_add_body_class', 10, 3 );


// Ajaxify header cart module
add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>
    <span class="cart-contents">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>
    <?php $fragments['span.cart-contents'] = ob_get_clean();
    return $fragments;
} );

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>
    <div class="header-quickcart">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php $fragments['div.header-quickcart'] = ob_get_clean();
    return $fragments;
} );

?>

<?php
function custom_filter_wpcf7_is_tel( $result, $tel ) {
  $result = preg_match( '/^[679][0-9]{8}+$/', $tel );
  return $result;
}
add_filter( 'wpcf7_is_tel', 'custom_filter_wpcf7_is_tel', 10, 2 );

?>


			
				 
