<?php
#
# redirect to clickmeter to track the link
# 

$primary_domain='bizexpert.com';

require_once ( './lib/woopra_tracker.php');

function array_to_http_get($params) {
        $query = '?';
        foreach( $params as $key => $value ) {
		if ($value != '' ) {
			$query .= urlencode($key) . '=' . urlencode($value) . '&';
		}
	}
        $query = rtrim($query, '& ');
        return($query);
}

function set_cookie($name,$value) {
	setcookie('_uc_'.$name, urlencode($value), strtotime('+30 days'), '/', '.'.$primary_domain, false, false);
}

// make sure page isn't cached or stored
// nor indexed by the search engines
header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
header('X-Robots-Tag: nofollow');

$debug=0;

$outboundurl='https://go.'.$primary_domain.'/';
$clickurl='https://'.$primary_domain.'/go/';

// get this info to pass to click meter
$referer=$_SERVER['HTTP_REFERER'];
# Sanitize the links to make sure nothing evil is passed
$affiliate=preg_replace('/[^a-zA-Z0-9]/','',strtolower($_GET['affiliate']));
$child=preg_replace('/[^a-zA-Z0-9]/','',strtolower($_GET['child']));
# get utm parameters 
$utm_source=$_GET['utm_source'];
$utm_medium=$_GET['utm_medium'];
$utm_term=$_GET['utm_term'];
$utm_content=$_GET['utm_content'];
$utm_campaign=$_GET['utm_campaign'];
$gclid=$_GET['gclid'];
$adpos=$_GET['adpos'];
$place=$_GET['place'];
$net=$_GET['net'];
$match=$_GET['match'];
$acid=$_GET['acid'];

// get the cookies for UTM
$c_utm_source=$_COOKIE['_uc_utm_source'];
$c_utm_medium=$_COOKIE['_uc_utm_medium'];
$c_utm_term=$_COOKIE['_uc_utm_term'];
$c_utm_content=$_COOKIE['_uc_utm_content'];
$c_utm_campaign=$_COOKIE['_uc_utm_campaign'];
$c_gclid=$_COOKIE['_uc_gclid'];
$c_adpos=$_COOKIE['_uc_adpos'];
$c_place=$_COOKIE['_uc_place'];
$c_net=$_COOKIE['_uc_net'];
$c_match=$_COOKIE['_uc_match'];

// if UTM codes don't exist in the url use cookies
if (empty($utm_source) && empty($utm_medium) && empty($utm_term) && empty($utm_content) && empty($utm_campaign)) { 
	$utm_source=$c_utm_source;
	$utm_medium=$c_utm_medium;
	$utm_term=$c_utm_term;
	$utm_content=$c_utm_content;
	$utm_campaign=$c_utm_campaign;
	$gclid=$c_gclid;
	$adpos=$c_adpos;
	$place=$c_place;
	$net=$c_net;
	$match=$c_match;
}
// set cookies for these to record the last click
else {
	set_cookie('utm_source',$utm_source);
	set_cookie('utm_medium',$utm_medium);
	set_cookie('utm_term',$utm_term);
	set_cookie('utm_content',$utm_content);
	set_cookie('utm_campaign',$utm_campaign);
	set_cookie('gclid',$gclid);
	set_cookie('adpos',$adpos);
	set_cookie('place',$place);
	set_cookie('net',$net);
	set_cookie('match',$match);
}

// Track using Woopra
$woopra = new WoopraTracker(array('domain' => $primary_domain, 'cookie_name' => 'ijt', 'cookie_domain' => '.'.$primary_domain, 'outgoing_tracking' => true));
// if we have their acid lets set it
if ($acid != '') {
	$woopra->identify(array('active_campaign.id' => $acid))->push(true);
}
$woopra->track('click', array('affiliate' => $affiliate, 'child' => $child), true);
$woopra->set_woopra_cookie();

// then see if we have a cookie to use
$ijt=$woopra->current_config['cookie_value'];

// 
// append to the URL to pass whatever parameters needed for clickmeter
//
$cmparams = array(
	'pd00' => $child,
	'pd01' => $ijt,
	'pd02' => $utm_source,
	'pd03' => $utm_medium,
	'pd04' => $utm_term,
	'pd05' => $utm_content,
	'pd06' => $utm_campaign,
	'pd07' => $gclid,
	'pd08' => $referer,
	'pd10' => $adpos,
	'pd11' => $place,
	'pd12' => $net,
	'pd13' => $match
);

// redirection URL to clickmeter
$redirect=$outboundurl.$affiliate.array_to_http_get($cmparams);

// redirect if child is ml (meaning mailing list. Skips our redirection page but still tracks the user
if ($child == 'ml') {
	header('Location: '.$redirect, true, 302);
}
else {
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width" />
<title>Please Wait. Redirecting to your offer...</title>
<link rel="shortcut icon" type="image/png" href="/favicon.ico" >
<meta name="referrer" content="always">
<meta name="robots" content="noindex,nofollow,noodp,noarchive"/>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
<style type="text/css">
body {
	font-family: 'Lato',sans-serif;
	font-size: 14px;
	color: #30323b;
}
h1 {
	font-size: 36px;
	font-weight: 600;
}
.loadingpage--logo{
	padding: 50px 0px;
	padding-left: 15px;
	padding-right: 15px;
}
.loadingpage--logo img{
	display: block;
	margin:auto;
	max-width: 200px;
	width: 100%;
}
.loadingpage--box{
	display: block;
	margin:auto;
	max-width: 800px;
	background-color: #ffffff;
	border:2px solid #d9d9d9;
	box-shadow: 0px 5px 40px #cccccc;
	text-align: center;
	padding:30px 15px;
}
.loadingpage--box__p .p2 a{
	color: #1d7395;
	font-size: 16px;
	font-weight: 600;
}

.p-b-50{
	padding-bottom: 50px;
}
.p-t-50{
	padding-top: 50px;
}
.p-50{
	padding: 50px 0px;
}
.loadingpage--footer{
	padding: 50px 0px;
	text-align: center;
}

.loadingpage--footer img{
	max-width: 310px;
	width: 100%;
}
</style>
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1895966237377921');
fbq('track', "PageView");
fbq('track', 'InitiateCheckout', { 
	content_name: '<?php echo $affiliate; ?>',
	content_ids: '<?php echo $affiliate.'-'.$child; ?>',
	num_ids: 1
});
</script>
<noscript>
<img height="1" width="1" border="0" alt="" style="display:none" src="https://www.facebook.com/tr?id=1895966237377921&amp;ev=PageView&amp;noscript=1" />
<img height="1" width="1" border="0" alt="" style="display:none" src="https://www.facebook.com/tr?id=1895966237377921&amp;ev=InitiateCheckout&amp;cd[content_name]=<?php echo $affiliate; ?>&amp;cd[content_ids]=<?php echo $affiliate.'-'.$child; ?>&amp;cd[num_items]=1&amp;noscript=1" />
</noscript>
<script type="text/javascript">
_linkedin_partner_id = "510081";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script><script type="text/javascript">
(function(){var s = document.getElementsByTagName("script")[0];
var b = document.createElement("script");
b.type = "text/javascript";b.async = true;
b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
s.parentNode.insertBefore(b, s);})();
</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://dc.ads.linkedin.com/collect/?pid=510081&fmt=gif" />
</noscript>
</head>
<body>
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NBCZMLW" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NBCZMLW');</script>
<div class="loadingpage">
        <div class="loadingpage--logo">
        </div>

        <div class="loadingpage--box">
	        <h1>Redirecting... Please Wait.</h1>
	        <p>
	        <a href="<?php echo $redirect; ?>&click=true"><img src="https://<?php echo $primary_domain; ?>/wp-content/uploads/2018/11/loading.gif" width="50" class="p-b-50" alt="()" /></a>
		</p>
	        <div class="loadingpage--box__p">
		        <p class="p2"><a href="<?php echo $redirect; ?>&click=true">Your secure application will load in 2 seconds, if not please click here</a></p>
		</div>
	</div>
</div>
<div class="loadingpage--footer">
        <a href="<?php echo $redirect; ?>&click=true"><img src="https://<?php echo $primary_domain; ?>/wp-content/uploads/2018/11/SSL.png" alt="SSL Secure Connection | Protected by RapidSSL" /></a>
</div>
<?php if ( $debug != 1 ) { ?>
<script type="text/javascript">
setTimeout(function(){var a=document.createElement("script");
</script>
<script type="text/javascript">
setTimeout( function() {
            window.location.replace('<?php echo $redirect; ?>');
        }, 1500);
    </script>
<?php } 
# debug testing
if ($debug == 1 ) {
	print "<!--\n";
	print "ijt            : $ijt\n";
	print "acid           : $acid\n";
	print "affiliate      : $affiliate\n";
	print "child          : $child\n";
	print "utm_source     : $utm_source\n";
	print "utm_medium     : $utm_medium\n";
	print "utm_term       : $utm_term\n";
	print "utm_content    : $utm_content\n";
	print "utm_campaign   : $utm_campaign\n";
	print "gclid          : $gclid\n";
	print "adpos          : $adpos\n";
	print "place          : $place\n";
	print "net            : $net\n";
	print "match          : $match\n";
	print "actual_referrer: $referer\n";
	print "source         : $source\n";
	print "Redirect       : $redirect\n";
	print "AC URL         : $acurl\n";
	print "-->\n";
}
?>
</body>
</html>
<?php
}
exit();
