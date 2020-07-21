<?php 
/**
 * Plugin Name: My Affiliate Link
 * Description: Generate affiliate links for use with any link cloaking service or plugin via shortcodes.
 * Version:     1.0.7
 * Author:      Ludwig Media
 * Author URI:	https://larryludwig.com/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

if (!defined('MY_AFFILATE_LINK_VERSION_NUM'))
	define('MY_AFFILATE_LINK_VERSION_NUM', '1.0.7');

if ( ! defined( 'MY_AFFILATE_LINK_PATH' ) ) {
        define( 'MY_AFFILATE_LINK_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'MY_AFFILATE_LINK_PLUGIN' ) ) {
        define( 'MY_AFFILATE_LINK_PLUGIN', plugin_basename(__FILE__) );
}

// admin files
require_once( MY_AFFILATE_LINK_PATH . 'admin/class-my-affiliate-link-admin.php' );
require_once( MY_AFFILATE_LINK_PATH . 'admin/my_affiliate_action_links.php' );

// Shortcodes
require_once( MY_AFFILATE_LINK_PATH . 'includes/shortcodes/mal_affiliate_button.php' );
require_once( MY_AFFILATE_LINK_PATH . 'includes/shortcodes/mal_affiliate_link.php' );
require_once( MY_AFFILATE_LINK_PATH . 'includes/shortcodes/mal_amazon_link.php' );
