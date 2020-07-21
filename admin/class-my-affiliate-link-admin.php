<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://larryludwig.com
 * @since      1.0.0
 *
 * @package    my-affiliate-link
 * @subpackage my-affiliate-link/admin
 * @author     Ludwig Media <plugin@larryludwig.com>
 */

class My_Affiliate_Link_Admin {
        public $settings_slug = 'my-affiliate-link';

        public function __construct() {
                $this->init();
        }

        public function init() {
                // create and set defaults for the options
                add_option( 'my-affiliate-link-siteurl' , site_url());
                add_option( 'my-affiliate-link-prefix' , '/go/' );
                add_option( 'my-affiliate-link-cssclass' , 'aflink');
                add_option( 'my-affiliate-link-onclick' , null );
                add_option( 'my-affiliate-link-nofollow' , true );
                add_option( 'my-affiliate-link-target' , '_blank' );
                add_option( 'my-affiliate-link-trailingslash' , false );
                add_option( 'my-affiliate-link-childsep' , '-' );
                add_option( 'my-affiliate-link-amazontrackingid' , null );

                // register the option types
                register_setting( 'my-affiliate-link', 'my-affiliate-link-siteurl', array ('type' => 'string', 'description' => 'Base URL for all affiliate links.' ));
                register_setting( 'my-affiliate-link', 'my-affiliate-link-prefix', array ('type' => 'string', 'description' => 'What prefix should be used by default for links if not a full URL (/go/ is default).' ) );
                register_setting( 'my-affiliate-link', 'my-affiliate-link-cssclass', array ('type' => 'string', 'description' => 'Default CSS for all links.' ));
                register_setting( 'my-affiliate-link', 'my-affiliate-link-onclick', array ('type' => 'string', 'description' => 'Javascript for when link is clicked.' ) );
                register_setting( 'my-affiliate-link', 'my-affiliate-link-nofollow', array ('type' => 'string', 'description' => 'Nofollow and noopener links (which should be the default).' ) );
                register_setting( 'my-affiliate-link', 'my-affiliate-link-target', array ('type' => 'string', 'description' => 'Target what browser window (_blank is default) ' ) );
                register_setting( 'my-affiliate-link', 'my-affiliate-link-trailingslash', array ('type' => 'string', 'description' => 'Should trailing / be used for local domains? (default is no).' ) );
                register_setting( 'my-affiliate-link', 'my-affiliate-link-childsep', array ('type' => 'string', 'description' => 'Should the child separator be a \'-\' (dash) or a \'/\' (forward slash). Dash is the default.' ) );
                register_setting( 'my-affiliate-link', 'my-affiliate-link-amazontrackingid', array ('type' => 'string', 'description' => 'Default Amazon Tracking ID to use for links' ) );

                add_action( 'admin_menu', array( $this, 'admin_menu' ) );
                add_action( 'admin_init', array( $this, 'settings' ) );
        }

        public function admin_menu() {
                add_options_page(
                        __('My Affiliate Link Settings', 'my-affiliate-link'),
                        __('My Affiliate Link', 'my-affiliate-link'),
                        'manage_options',
                        'my-affiliate-link',
                        array($this, 'settings_page')
                );
        }

        public function settings() {
                add_settings_section( 'my-affiliate-link-section', null, array ($this, 'settings_section_description'), 'my-affiliate-link' );
                add_settings_field( 'my-affiliate-link-siteurl', 'Site URL', array ($this, 'siteurl_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
                add_settings_field( 'my-affiliate-link-prefix', 'URL prefix', array ($this, 'prefix_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
                add_settings_field( 'my-affiliate-link-trailingslash', 'Trailing Slash', array ($this, 'trailingslash_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
                add_settings_field( 'my-affiliate-link-childsep', 'Child Seperator', array ($this, 'childsep_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
                add_settings_field( 'my-affiliate-link-cssclass', 'CSS Class', array ($this, 'cssclass_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
                add_settings_field( 'my-affiliate-link-onclick', 'Onclick Function', array ($this, 'onclick_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
                add_settings_field( 'my-affiliate-link-nofollow', 'rel="nofollow noopener"', array ($this, 'nofollow_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
                add_settings_field( 'my-affiliate-link-target', 'Browser Target', array ($this, 'target_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
                add_settings_field( 'my-affiliate-link-amazontrackingid', 'Amazon Tracking ID', array ($this, 'amazontrackingid_field'), 'my-affiliate-link', 'my-affiliate-link-section' );
        }

        public function settings_section_description(){
                echo wpautop( "<p><span style=\"font-size: 18px;\">For more documentation on using this plugin, please visit our <a href=\"https://larryludwig.com/plugins/my-affiliate-link/?utm_source=wpplugin&utm_medium=link&utm_campaign=settings\" target=\"_blank\">online manual</a>.</span>
</p>
" );
        }

        public function settings_page() {
?>
<div class="wrap">
        <h1>My Affiliate Link Settings</h1>
        <form method="post" action="options.php">
<?php
            settings_fields( 'my-affiliate-link' );
            do_settings_sections( 'my-affiliate-link' );
            submit_button();
?>
        </form>
</div>
<?php
        }

        public function siteurl_field() {
                $output  = '<input id="my-affiliate-link-siteurl" type="text" name="my-affiliate-link-siteurl" value="'. get_option('my-affiliate-link-siteurl') .'" size="40">';
                $output .= ' <small>Defaults to current domain for your Wordpress installation. No trailing slash (\'/\') and should include http:// or https://</small>';
                echo $output;
        }

        public function prefix_field() {
                $output  = '<input id="my-affiliate-link-prefix" type="text" name="my-affiliate-link-prefix" value="'. get_option('my-affiliate-link-prefix') .'" size="40">';
                $output .= ' <small>What prefix should be used for affiliate links if not a full URL (/go/ is default).</small>';
                echo $output;
        }

        public function cssclass_field() {
                $output  = '<input id="my-affiliate-link-cssclass" type="text" name="my-affiliate-link-cssclass" value="'. get_option('my-affiliate-link-cssclass') .'" size="40">';
                $output .= ' <small>Default CSS class to use for all links.</small>';
                echo $output;
        }

        public function onclick_field() {
                $output  = '<input id="my-affiliate-link-onclick" type="text" name="my-affiliate-link-onclick" value="'. get_option('my-affiliate-link-onclick') .'" size="40">';
                $output .= ' <small>Javascript to use for all links. End with ; to complete your function.</small>';
                echo $output;
        }

        public function amazontrackingid_field() {
                $output  = '<input id="my-affiliate-link-amazontrackingid" type="text" name="my-affiliate-link-amazontrackingid" value="'. get_option('my-affiliate-link-amazontrackingid') .'" size="40">';
                $output .= " <small><strong style=\"color:red;\">(REQUIRED)</strong> Default Amazon Tracking ID to use if 'tid' isn't passed in the shortcode.</small>";
                echo $output;
        }

        public function nofollow_field() {
		$output  = '<input name="my-affiliate-link-nofollow" id="my-affiliate-link-nofollow" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'my-affiliate-link-nofollow' ), false ) . ' />';
                $output .= ' <small>Link should be rel="nofollow sponsored noopener" by default.</small>';
                echo $output;
        }

        public function target_field() {
                $output  = '<input id="my-affiliate-link-target" type="text" name="my-affiliate-link-target" value="'. get_option('my-affiliate-link-target') .'" size="40">';
                $output .= ' <small>What browser target should be used? (_blank should be the default).</small>';
                echo $output;
        }

        public function childsep_field() {
		$output  = '<select name="my-affiliate-link-childsep" id="my-affiliate-link-childsep">
            <option value="-" '.selected( get_option('my-affiliate-link-childsep'), '-', false ).'>-</option>
            <option value="/" '.selected( get_option('my-affiliate-link-childsep'), '/', false ).'>/</option>
        </select>';
                echo $output;
        }

        public function trailingslash_field() {
		$output  = '<input name="my-affiliate-link-trailingslash" id="my-affiliate-link-trailingslash" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'my-affiliate-link-trailingslash' ), false ) . ' />';
                echo $output;
        }
}       
        
$my_affiliate_link_admin = new My_Affiliate_Link_Admin();
