<?php 
/**
 * Plugin Name: Affiliate Link
 * Description: Creates nice and neat affiliate links
 * Version:     1.0.0
 * Author:      Larry Ludwig (me@larryludwig.com)
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

if (!defined('IJ_AFFILATE_LINK_VERSION_NUM'))
	define('IJ_AFFILATE_LINK_VERSION_NUM', '1.0.0');


// makes it easier to maintain action buttons
function affiliate_button ($atts) {
	global $post;
	$defaults = array(
		'affiliate' => '',
		'child' => '',
		'text' => 'Sign Up',
	);
	$atts = shortcode_atts( $defaults, $atts );

	# if passed a FQDN then only add the child
	if (preg_match('/^(http|https):\/\//i',$atts['affiliate'])) {
       		$url = ($atts['affiliate'].'-'.strtolower($atts['child']));
	}
	# else just the affiliate id
	else {
		if ($atts['child'] != '') {
			$url = site_url('/go/'.strtolower($atts['affiliate']).'-'.strtolower($atts['child']));
		}
		else {
			$url = site_url('/go/'.strtolower($atts['affiliate']));
		}
	}

        //print_r(var_dump($atts));

        $output='';
	$output='<div class="btn-center"><a class="ww-btn" href="'.$url. '" target="_blank" rel="nofollow" title="'.$atts['text'].'" onclick="DisplayEmailPopup();">'.$atts['text'].'</a></div>';
        return($output);
}
add_shortcode('affiliate_button','affiliate_button');

// makes it easier to maintain action links
function affiliate_link ($atts,$content=null) {
	$class = '';
	$style = '';
	$title = '';
	$defaults = array(
		'affiliate' => '',
		'child' => '',
		'text' => 'Sign Up',
		'class' => '',
		'style' => '',
		'title' => '',
	);
	$atts = shortcode_atts( $defaults, $atts );

	// if no content look for the text variable
	if ($content == '') {
		$content = $atts['text'];
	}
	else {
		$content = do_shortcode($content);
	}

	# if passed a FQDN then only add the child
	if (preg_match('/^(http|https):\/\//i',$atts['affiliate'])) {
		$url = ($atts['affiliate']);
	}
	# else just the affiliate id
	else {
		if ($atts['child'] != '') {
			$url = site_url('/go/'.strtolower($atts['affiliate']).'-'.strtolower($atts['child']));
		}
		else {
			$url = site_url('/go/'.strtolower($atts['affiliate']));
		}
	}
	if ($atts['class'] != '') {
		$class=' class="'.$atts['class'].'"';
	}
	if ($atts['style'] != '') {
		$style=' style="'.$atts['style'].'"';
	}
	if ($atts['title'] != '') {
		$title=' title="'.$atts['title'].'"';
	}

        $output='';
        $output='<a href="'.$url.'" target="_blank" rel="nofollow"'.$class.$style.$title.' onclick="DisplayEmailPopup();">'.$content.'</a>';
        return($output);
}
add_shortcode('affiliate_link','affiliate_link');
