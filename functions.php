<?php
/**
 * Title: Function
 *
 * Description: Defines theme specific functions including actions and filters.
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category Cyber Chimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v3.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

// Load text domain.
function cyberchimps_text_domain() {
	load_theme_textdomain( 'fine', get_template_directory() . '/inc/languages' );
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'cyberchimps_text_domain' );

// Load Core
require_once( get_template_directory() . '/cyberchimps/init.php' );
require( get_template_directory() . '/inc/admin-about.php' );

// Set the content width based on the theme's design and stylesheet.
if( !isset( $content_width ) ) {
	$content_width = 640;
} /* pixels */

// Define site info
function cyberchimps_add_site_info() {
	?>
	<p>&copy; Company Name</p>
<?php
}

add_action( 'cyberchimps_site_info', 'cyberchimps_add_site_info' );

if( !function_exists( 'cyberchimps_comment' ) ) :

// Template for comments and pingbacks.
// Used as a callback by wp_list_comments() for displaying the comments.
	function cyberchimps_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="post pingback">
				<p><?php _e( 'Pingback:', 'fine' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'fine' ), ' ' ); ?></p>
				<?php
				break;
			default :
				?>
					<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment hreview">
						<footer>
							<div class="comment-author reviewer vcard">
								<?php echo get_avatar( $comment, 40 ); ?>
								<?php printf( '%s <span class="says">' . __( 'says:', 'fine' ) . '</span>', sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
							</div>
							<!-- .comment-author .vcard -->
							<?php if( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'fine' ); ?></em>
								<br/>
							<?php endif; ?>

							<div class="comment-meta commentmetadata">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="dtreviewed">
									<time pubdate datetime="<?php comment_time( 'c' ); ?>">
										<?php
										/* translators: 1: date, 2: time */
										printf( __( '%1$s at %2$s', 'fine' ), get_comment_date(), get_comment_time() ); ?>
									</time>
								</a>
								<?php edit_comment_link( __( '(Edit)', 'fine' ), ' ' );
								?>
							</div>
							<!-- .comment-meta .commentmetadata -->
						</footer>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div>
						<!-- .reply -->
					</article><!-- #comment-## -->

				<?php
				break;
		endswitch;
	}
endif; // ends check for cyberchimps_comment()

// set up next and previous post links for lite themes only
function cyberchimps_next_previous_posts() {
	if( get_next_posts_link() || get_previous_posts_link() ): ?>
		<div class="more-content">
			<div class="row-fluid">
				<div class="span6 previous-post">
					<?php previous_posts_link(); ?>
				</div>
				<div class="span6 next-post">
					<?php next_posts_link(); ?>
				</div>
			</div>
		</div>
	<?php
	endif;
}

add_action( 'cyberchimps_after_content', 'cyberchimps_next_previous_posts' );

// core options customization Names and URL's
//Pro or Free
function cyberchimps_theme_check() {
	$level = 'free';

	return $level;
}

//Theme Name
function cyberchimps_options_theme_name() {
	$text = 'Fine Free';

	return $text;
}

//Theme Pro Name
function cyberchimps_upgrade_bar_pro_title() {
	$text = 'Fine Pro';

	return $text;
}

//Upgrade link
function cyberchimps_upgrade_bar_pro_link() {
	$url = 'http://cyberchimps.com/store/fine-pro/';

	return $url;
}

//Doc's URL
function cyberchimps_options_documentation_url() {
	$url = 'http://cyberchimps.com/guides/c/';

	return $url;
}

// Support Forum URL
function cyberchimps_options_support_forum() {
	$url = 'http://cyberchimps.com/forum/free/fine/';

	return $url;
}

add_filter( 'cyberchimps_current_theme_name', 'cyberchimps_options_theme_name', 1 );
add_filter( 'cyberchimps_upgrade_pro_title', 'cyberchimps_upgrade_bar_pro_title' );
add_filter( 'cyberchimps_upgrade_link', 'cyberchimps_upgrade_bar_pro_link' );
add_filter( 'cyberchimps_documentation', 'cyberchimps_options_documentation_url' );
add_filter( 'cyberchimps_support_forum', 'cyberchimps_options_support_forum' );

// Help Section
function cyberchimps_options_help_header() {
	$text = 'Fine Free';

	return $text;
}

function cyberchimps_options_help_sub_header() {
	$text = __( 'Fine Free Professional Responsive WordPress Theme', 'fine' );

	return $text;
}

add_filter( 'cyberchimps_help_heading', 'cyberchimps_options_help_header' );
add_filter( 'cyberchimps_help_sub_heading', 'cyberchimps_options_help_sub_header' );

// Branding images and defaults

// Banner default
function cyberchimps_banner_default() {
	$url = '/images/branding/banner.jpg';

	return $url;
}

add_filter( 'cyberchimps_banner_img', 'cyberchimps_banner_default' );

//theme specific skin options in array. Must always include option default
function cyberchimps_skin_color_options( $options ) {
	// Get path of image
	$imagepath = get_template_directory_uri() . '/inc/css/skins/images/';

	$options = array(
		'default' => $imagepath . 'default.png'
	);

	return $options;
}

add_filter( 'cyberchimps_skin_color', 'cyberchimps_skin_color_options' );

// theme specific background images
function cyberchimps_background_image( $options ) {
	$imagepath = get_template_directory_uri() . '/cyberchimps/lib/images/';
	$options   = array(
		'none'  => $imagepath . 'backgrounds/thumbs/none.png',
		'noise' => $imagepath . 'backgrounds/thumbs/noise.png',
		'blue'  => $imagepath . 'backgrounds/thumbs/blue.png',
		'dark'  => $imagepath . 'backgrounds/thumbs/dark.png',
		'space' => $imagepath . 'backgrounds/thumbs/space.png'
	);

	return $options;
}

add_filter( 'cyberchimps_background_image', 'cyberchimps_background_image' );

// theme specific typography options
function cyberchimps_typography_sizes( $sizes ) {
	$sizes = array( '8', '9', '10', '12', '14', '16', '20' );

	return $sizes;
}

function cyberchimps_typography_faces( $orig ) {

	$new = array(
		'"Noto Sans", Arial, sans-serif'          => 'Noto Sans',
		'"Imprima", Helvetica, Arial, sans-serif' => 'Imprima'
	);

	$new = array_merge( $new, $orig );

	return $new;
}

function cyberchimps_typography_styles( $styles ) {
	$styles = array( 'normal' => 'Normal', 'bold' => 'Bold' );

	return $styles;
}

function cyberchimps_typography_defaults() {
	$default = array(
		'size'  => '14px',
		'face'  => '"Noto Sans", Arial, sans-serif',
		'style' => 'normal',
		'color' => '#555555'
	);

	return $default;
}

function cyberchimps_typography_heading_defaults() {
	$default = array(
		'size'  => '',
		'face'  => '"Imprima", Helvetica, Arial, sans-serif',
		'style' => '',
		'color' => '',

	);

	return $default;
}

add_filter( 'cyberchimps_typography_sizes', 'cyberchimps_typography_sizes' );
add_filter( 'cyberchimps_typography_styles', 'cyberchimps_typography_styles' );
add_filter( 'cyberchimps_typography_faces', 'cyberchimps_typography_faces' );
add_filter( 'cyberchimps_typography_defaults', 'cyberchimps_typography_defaults' );
add_filter( 'cyberchimps_typography_heading_defaults', 'cyberchimps_typography_heading_defaults' );

// Default for twitter bar handle
function cyberchimps_twitter_handle_filter() {
	return 'WordPress';
}

add_filter( 'cyberchimps_twitter_handle_filter', 'cyberchimps_twitter_handle_filter' );

/**
 * Adds option for header image
 *
 * @param $original array
 *
 * @return array
 */
function cyberchimps_add_theme_options( $original ) {
	$new_field[][1] = array(
		'name'    => __( 'Header Image', 'fine' ),
		'id'      => 'header_image',
		'std'     => '',
		'type'    => 'upload',
		'desc'    => __( 'The image used for the header needs to be a large image. We recommend a minimum width of 1000px and a maximum height of 550px', 'fine' ),
		'std'     => get_template_directory_uri() . '/images/header.jpg',
		'section' => 'cyberchimps_header_options_section',
		'heading' => 'cyberchimps_header_heading'
	);
	$new_fields     = cyberchimps_array_field_organizer( $original, $new_field );

	return $new_fields;
}

add_filter( 'cyberchimps_field_filter', 'cyberchimps_add_theme_options', 10 );

/**
 * Removes unwanted fields
 *
 * @param $orig array field options
 *
 * @return array
 */
function cyberchimps_remove_default_options( $orig ) {

	$remove = array(
		'searchbar'
	);

	$new_options = cyberchimps_remove_options( $orig, $remove );

	return $new_options;
}

add_filter( 'cyberchimps_field_filter', 'cyberchimps_remove_default_options' );

/* Add Header Image in customizer and remove searchbar from header option */

add_action( 'customize_register', 'fine_customize_register', 50 );

    function fine_customize_register( $wp_customize ) {
        $wp_customize->remove_setting( 'cyberchimps_options[searchbar]' );
        $wp_customize->remove_control( 'searchbar' );
        // Add header image
        $wp_customize->add_setting( 'cyberchimps_options[header_image]', array(
            'description' => __( 'The image used for the header needs to be a large image. We recommend a minimum width of 1000px and a maximum height of 550px', 'fine' ),
            'default' => get_template_directory_uri() . '/images/header.jpg',
            'type' => 'option',
            'sanitize_callback' => 'cyberchimps_sanitize_upload'
        ) );

       $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_image', array(
        'label' => __( 'Upload Header Image', 'cyberchimps_core' ),
        'priority' => 4,
        'section' => 'cyberchimps_header_section',
        'settings' => 'cyberchimps_options[header_image]',
        'type' => 'image',
    ) ) );
}

/**
 * Removes the banner section
 *
 * @param $orig array
 *
 * @return array
 */
function cyberchimps_header_drag_and_drop_defaults( $orig ) {
	// Just remove banner as there is no styling for this
	unset( $orig['cyberchimps_banner'] );

	return $orig;
}

add_filter( 'header_drag_and_drop_options', 'cyberchimps_header_drag_and_drop_defaults', 20 );

/* BEGIN  Added by Swapnil - on 19-Oct 2016 for adding new feature for menu coloer change */

add_action( 'customize_register', 'fine_add_custmozier_field', 20 );
function fine_add_custmozier_field( $wp_customize ) {

$wp_customize->add_setting( 'cyberchimps_options[menu_background_colorpicker]', array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'cyberchimps_text_sanitization'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_background_colorpicker', array(
        'label' => __( 'Menu Background Color', 'fine' ),
        'section' => 'cyberchimps_design_section',
        'settings' => 'cyberchimps_options[menu_background_colorpicker]',
    ) ) );


$wp_customize->add_setting( 'cyberchimps_options[menu_hover_colorpicker]', array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'cyberchimps_text_sanitization'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_hover_colorpicker', array(
        'label' => __( 'Menu Hover Color', 'fine' ),
        'section' => 'cyberchimps_design_section',
        'settings' => 'cyberchimps_options[menu_hover_colorpicker]',
    ) ) );

$wp_customize->add_setting( 'cyberchimps_options[menu_text_colorpicker]', array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'cyberchimps_text_sanitization'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_text_colorpicker', array(
        'label' => __( 'Menu Text Color', 'fine' ),
        'section' => 'cyberchimps_design_section',
        'settings' => 'cyberchimps_options[menu_text_colorpicker]',
    ) ) );
}


add_filter( 'cyberchimps_field_list', 'fine_add_field' , 30 , 1 );
function fine_add_field($fields_list){
$fields_list[] = array(
		'name'    => __( 'Menu Background Color', 'fine' ),
		'desc'    => __( 'Select menu background color', 'fine' ),
		'id'      => 'menu_background_colorpicker',
		'std'     => '',
		'type'    => 'color',
		'section' => 'cyberchimps_custom_colors_section',
		'heading' => 'cyberchimps_design_heading'
	);

$fields_list[] = array(
		'name'    => __( 'Menu Hover Color', 'fine' ),
		'desc'    => __( 'Select menu hover color', 'fine' ),
		'id'      => 'menu_hover_colorpicker',
		'std'     => '',
		'type'    => 'color',
		'section' => 'cyberchimps_custom_colors_section',
		'heading' => 'cyberchimps_design_heading'
	);

$fields_list[] = array(
		'name'    => __( 'Menu Text Color', 'fine' ),
		'desc'    => __( 'Select color for menu text', 'fine' ),
		'id'      => 'menu_text_colorpicker',
		'std'     => '',
		'type'    => 'color',
		'section' => 'cyberchimps_custom_colors_section',
		'heading' => 'cyberchimps_design_heading'
	);

return $fields_list;

}

add_action( 'wp_head', 'fine_css_styles', 50 );
function fine_css_styles(){
	$menu_background = cyberchimps_get_option( 'menu_background_colorpicker' );
	$menu_text = cyberchimps_get_option( 'menu_text_colorpicker' );
	$menu_hover = cyberchimps_get_option( 'menu_hover_colorpicker' );
?>
	<style type="text/css" media="all">
		<?php if ( !empty( $menu_background ) ) : ?>
			.main-navigation .navbar-inner {
			background-color: <?php echo $menu_background; ?>;
			}

			#header_nav_container .row-fluid {
			background-color: <?php echo $menu_background; ?>;
			}
		<?php endif; ?>

		<?php if ( !empty( $menu_hover ) ) : ?>
			.main-navigation .navbar-inner div > ul > li > a:hover {
			background-color: <?php echo $menu_hover; ?>;
			}
			header#cc-header.row-fluid {
			background-color: <?php echo $menu_hover; ?>;
			}
		<?php endif; ?>

		<?php if ( !empty( $menu_text ) ) : ?>
			.main-navigation .nav > li > a, .main-navigation .nav > li > a:hover {
			color: <?php echo $menu_text; ?>;
			}

		<?php endif; ?>
	</style>
<?php
}

/* END  Added by Swapnil - on 19-Oct 2016 for adding new feature for menu coloer change */


function fine_customize_edit_links( $wp_customize ) {


   $wp_customize->selective_refresh->add_partial( 'blogname', array(
'selector' => '.site-title a'
) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.top-head-description'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[custom_logo]', array(
		'selector' => '#logo'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[theme_backgrounds]', array(
		'selector' => '#social'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[searchbar]', array(
		'selector' => '#navigation #searchform'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[footer_show_toggle]', array(
		'selector' => '#footer_wrapper'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[footer_copyright_text]', array(
		'selector' => '#copyright'
	) );

	$wp_customize->selective_refresh->add_partial( 'nav_menu_locations[primary]', array(
		'selector' => '#navigation .nav'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[header_image]', array(
		'selector' => '#header_nav_container'
	) );
	
	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[contact_form_heading]', array(
		'selector' => '#contact_form_container h2'
	) );
	
	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[contact_form_shortcode]', array(
		'selector' => '.contact_box'
	) );
	
	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[custom_back_image_uploader]', array(
		'selector' => '.contact-full-width .container'
	) );	

}
add_action( 'customize_register', 'fine_customize_edit_links' );
add_theme_support( 'customize-selective-refresh-widgets' );

add_action( 'admin_notices', 'fine_rating_notice' );
function fine_rating_notice()
{
	$check_screen = get_admin_page_title();

	if ( $check_screen == 'Theme Options Page' )
	{
	?>
    <div class="notice notice-success is-dismissible">
        <b><p>Liked this theme? <a href="https://wordpress.org/support/theme/fine/reviews/#new-post" target="_blank">Leave us</a> a ***** rating. Thank you! </p></b>
    </div>
    <?php
	}
}

// Contact Form Heading for Theme Options
function cyberchimps_contact_form_heading( $headings_list ) {
	$headings_list[] = array(
		'id'    => 'cyberchimps_contact_heading',
		'title' => __( 'Contact Form', 'cyberchimps_core' ),
	);

	return $headings_list;
}

add_filter( 'cyberchimps_headings_filter', 'cyberchimps_contact_form_heading', 20, 1 );

add_filter( 'cyberchimps_section_list', 'cyberchimps_contact_form_sections', 20 );
function cyberchimps_contact_form_sections( $sections_list ) {

$sections_list[] = array(
	'id'      => 'cyberchimps_contact_section',
	'label'   => __( 'Contact Form Options', 'cyberchimps_core' ),
	'heading' => 'cyberchimps_contact_heading'
);

return apply_filters( 'cyberchimps_sections_filter', $sections_list );
}

function cyberchimps_contact_form_fields( $fields_list ) {

	$fields_list[] = array(
			'name'    => __( 'Contact Form On/Off', 'cyberchimps_core' ),
			'id'      => 'contact_form_switch',
			'std'     => 0,
			'type'    => 'toggle',
			'section' => 'cyberchimps_contact_section',
			'heading' => 'cyberchimps_contact_heading'
		);

$fields_list[] = array(
	'id'      => 'contact_form_heading',
	'name'    => __( 'Contact Form Heading', 'cyberchimps_core' ),
	'std'     => 'Contact Us',
	'type'    => 'text_html',
	'section' => 'cyberchimps_contact_section',
	'heading' => 'cyberchimps_contact_heading'
);

$fields_list[] = array(
	'id'      => 'contact_form_shortcode',
	'name'    => __( 'Contact Form Shortcode', 'cyberchimps_core' ),
	'type'    => 'text_html',
	'section' => 'cyberchimps_contact_section',
	'heading' => 'cyberchimps_contact_heading'
);

$directory_uri = get_template_directory_uri();

$fields_list[] = array(
	'id'      => 'custom_back_image_uploader',
	'name'    => __( 'Background Image', 'cyberchimps_core' ),
	'desc'    => __( 'Enter URL or upload file', 'cyberchimps_core' ),
	'type'    => 'upload',
	'std'     => apply_filters( 'cyberchimps_default_logo', $directory_uri . '/images/contact_bg.jpg' ),
	'section' => 'cyberchimps_contact_section',
	'heading' => 'cyberchimps_contact_heading'
);

return apply_filters( 'cyberchimps_field_filter', $fields_list );
}

add_filter( 'cyberchimps_field_list', 'cyberchimps_contact_form_fields', 20 );

add_action( 'customize_register', 'fine_contact_form_register', 50 );
function fine_contact_form_register( $wp_customize ) {

	    $wp_customize->add_setting( 'cyberchimps_options[contact_form_switch]', array(
	        'type' => 'option',
	        'sanitize_callback' => 'cyberchimps_sanitize_checkbox'
	    ) );

	    $wp_customize->add_control( 'contact_form_switch', array(
	        'label' => __( 'Contact Form On/Off', 'cyberchimps_core' ),
	        'section' => 'static_front_page',
	        'settings' => 'cyberchimps_options[contact_form_switch]',
	        'type' => 'checkbox'
	    ) );

			$wp_customize->add_setting( 'cyberchimps_options[contact_form_heading]', array(
				'type' => 'option',
				'sanitize_callback' => 'cyberchimps_text_sanitization'
			) );
			$wp_customize->add_control( 'contact_form_heading', array(
				'label' => __( 'Contact Form Heading', 'cyberchimps_core' ),
				'section' => 'static_front_page',
				'settings' => 'cyberchimps_options[contact_form_heading]',
				'type' => 'text'
			) );

			$wp_customize->add_setting( 'cyberchimps_options[contact_form_shortcode]', array(
				'type' => 'option',
				'sanitize_callback' => 'cyberchimps_text_sanitization'
			) );
			$wp_customize->add_control( 'contact_form_shortcode', array(
				'label' => __( 'Contact Form Shortcode', 'cyberchimps_core' ),
				'section' => 'static_front_page',
				'settings' => 'cyberchimps_options[contact_form_shortcode]',
				'type' => 'text'
			) );

			$wp_customize->add_setting( 'cyberchimps_options[custom_back_image_uploader]', array(
					'default' => get_template_directory_uri() . '/images/contact_bg.jpg',
					'type' => 'option',
					'sanitize_callback' => 'cyberchimps_sanitize_upload'
			) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_back_image_uploader', array(
					'label' => __( 'Contact Form Background Image', 'cyberchimps_core' ),
					'section' => 'static_front_page',
					'settings' => 'cyberchimps_options[custom_back_image_uploader]',
					'type' => 'image',
			) ) );
}

add_action( 'admin_notices', 'fine_admin_notices' );
function fine_admin_notices()
{
	$admin_check_screen = get_admin_page_title();

	if( !class_exists('SlideDeckPlugin') )
	{
	$plugin='slidedeck/slidedeck.php';
	$slug = 'slidedeck';
	$installed_plugins = get_plugins();

	 if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
			<?php if( isset( $installed_plugins[$plugin] ) )
			{
			?>
				 <a href="<?php echo admin_url( 'plugins.php' ); ?>">Activate the SlideDeck Lite plugin</a>
			 <?php
			}
			else
			{
			 ?>
			 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the SlideDeck Lite plugin</a>
			 <?php } ?>

		</p>
		</div>
		<?php
	}
	}

	if( !class_exists('WPForms') )
	{
	$plugin = 'wpforms-lite/wpforms.php';
	$slug = 'wpforms-lite';
	$installed_plugins = get_plugins();
	 if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
			<?php if( isset( $installed_plugins[$plugin] ) )
			{
			?>
				 <a href="<?php echo admin_url( 'plugins.php' ); ?>">Activate the WPForms Lite plugin</a>
			 <?php
			}
			else
			{
			 ?>
	 		 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the WP Forms Lite plugin</a>
			 <?php } ?>
		</p>
		</div>
		<?php
	}
	}

}
