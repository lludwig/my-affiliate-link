<?php 
// amazon affiliate links must you direct and cannot be cloaked
function mal_amazon_link ($atts, $content=null) {
	$defaults = array(
                'asin' => '',
                'tid' => get_option('my-affiliate-link-amazontrackingid'),
                'text' => 'Buy On Amazon',
		'class' => '',
		'style' => '',
	);
	// base Amazon URL
	$amazonurl='https://www.amazon.com/exec/obidos/ASIN/';

	$atts = shortcode_atts( $defaults, $atts );
	// if no content look for the text variable
	if ($content == '') {
		$content = esc_attr($atts['text']);
	}
	else {
		$content = do_shortcode($content);
	}

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

	if ($atts['class'] != '') {
		$class=' class="'.$cssclass.esc_attr($atts['class']).' mal-'.esc_attr($atts['asin']).' mal-amazon'.'"';
	}
	else {
		$class=' class="'.$cssclass.'mal-'.esc_attr($atts['asin']).' mal-amazon"';
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

	// build url
	$url=$amazonurl.esc_attr($atts['asin']).'/ref=nosim/'.esc_attr($atts['tid']);

        $output='';
	$output='<a href="'.$url.'"'.$target.$rel.$class.$style.$title.$onclick.'>'.esc_html($content).'</a>';
        return($output);
}
add_shortcode('mal_amazon_link','mal_amazon_link');
add_shortcode('mal_amazon','mal_amazon_link');
