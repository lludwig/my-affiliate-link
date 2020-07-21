<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// remove these options since we are uninstalled
unregister_setting('my-affiliate-link', 'my-affiliate-link-class');
unregister_setting('my-affiliate-link', 'my-affiliate-link-onclick');
unregister_setting('my-affiliate-link', 'my-affiliate-link-nofollow');
unregister_setting('my-affiliate-link', 'my-affiliate-link-target');
unregister_setting('my-affiliate-link', 'my-affiliate-link-prefix');
unregister_setting('my-affiliate-link', 'my-affiliate-link-trailingslash');
unregister_setting('my-affiliate-link', 'my-affiliate-link-childsep');
// delete the options from the database
delete_option('my-affiliate-link-class');
delete_option('my-affiliate-link-onclick');
delete_option('my-affiliate-link-nofollow');
delete_option('my-affiliate-link-target');
delete_option('my-affiliate-link-prefix');
delete_option('my-affiliate-link-trailingslash');
delete_option('my-affiliate-link-childsep');
