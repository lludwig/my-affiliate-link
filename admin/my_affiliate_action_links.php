<?php 
function my_affiliate_action_links( $actions, $plugin_file ) {
	static $plugin;

	if (!isset($plugin))
		$plugin = MY_AFFILATE_LINK_PLUGIN;
	if ($plugin == $plugin_file) {
		$settings = array('settings' => '<a href="options-general.php?page=my-affiliate-link">' . __('Settings', 'General') . '</a>');
		$site_link = array('docs' => '<a href="https://larryludwig.com/plugins/my-affiliate-link/?utm_source=wpplugin&utm_medium=link&utm_campaign=pluginpage" target="_blank">Docs</a>');
		$actions = array_merge($site_link, $actions);
		$actions = array_merge($settings, $actions);
	}
	return $actions;
}
add_filter( 'plugin_action_links_' . MY_AFFILATE_LINK_PLUGIN, 'my_affiliate_action_links', 10, 5);
