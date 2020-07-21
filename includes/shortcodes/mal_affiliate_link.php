<?php 
// affiliate_link shortcode
function mal_affiliate_link ($atts, $content=null) {
	$class = '';
	$style = '';
	$title = '';
        $output='';

	$defaults = array(
		'merchant' => '',
		'child' => '',
		'text' => 'Learn More',
		'encode' => true,
		'class' => '',
		'style' => '',
		'title' => '',
	);
	$atts = shortcode_atts( $defaults, $atts );

	// if no content look for the text variable
	if ($content == '') {
		if ($atts['encode']) {
			$contentout = esc_attr($atts['text']);
		}
		else {
			$contentout = $atts['text'];
		}
	}
	else {
		$contentout = do_shortcode($content);
	}

	// build the URL
	# if passed a FQDN then only add the child
	if (preg_match('/^(http|https):\/\//i',$atts['merchant'])) {
		$url = ($atts['merchant']);
	}
	# else just the merchant id
	else {
		if ($atts['child'] != '') {
			$merchanttag=strtolower(esc_attr($atts['merchant'])).get_option('my-affiliate-link-childsep').strtolower(esc_attr($atts['child']));
		}
		else {
			$merchanttag=strtolower(esc_attr($atts['merchant']));
		}
	}
	// add trailing slash if enabled
 	if (get_option('my-affiliate-link-trailingslash')) {
		$trailingslash='/';
	}
	// build url
	$url = get_option('my-affiliate-link-siteurl').get_option('my-affiliate-link-prefix').$merchanttag.$trailingslash;

	// enable/disable options
	// add target
 	if (get_option('my-affiliate-link-target') != '') {
		$target=' target="'.get_option('my-affiliate-link-target').'"';
	}
	else {
		$target=' target="_blank"';
	}

	if (get_option('my-affiliate-link-cssclass') != '' ) {
		$cssclass=get_option('my-affiliate-link-cssclass').' ';
	}

	if ($atts['class'] != '' && $merchanttag != '') {
		$class=' class="'.$cssclass.esc_attr($atts['class']).' mal-'.$merchanttag.'"';
	}
	elseif ($atts['class'] != '' && $merchanttag == '') {
		$class=' class="'.$cssclass.esc_attr($atts['class']).'"';
	}
	else {
		$class=' class="'.$cssclass.'mal-'.$merchanttag.'"';
	}
	if ($atts['style'] != '') {
		$style=' style="'.esc_attr($atts['style']).'"';
	}
	if ($atts['title'] != '') {
		$title=' title="'.esc_attr($atts['title']).'"';
	}
	// don't follow links by default
 	if (get_option('my-affiliate-link-nofollow')) {
		$rel=' rel="nofollow sponsored noopener"';
	}
	// add onclick if set
 	if (get_option('my-affiliate-link-onclick') != '') {
		$onclick=' onclick="'.get_option('my-affiliate-link-onclick').'"';
	}

	// construct link
        $output='<a href="'.$url.'"'.$target.$rel.$class.$style.$title.$onclick.'>'.$contentout.'</a>';
        return($output);
}
add_shortcode('mal_affiliate_link','mal_affiliate_link');
add_shortcode('mal_link','mal_affiliate_link');

