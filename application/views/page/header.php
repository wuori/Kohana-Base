<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="Content-Type"  content="text/html; charset=ISO-8859-1">
	<meta name="robots" content="all" />
	<title><?=$page_title;?> | Rock Hill, SC</title>
	<link rel="stylesheet" type="text/css" media="screen" href="/public/css/screen.css">
	<? if(is_array($meta)): ?>
	<? foreach($meta as $m): ?>
	<?=$m;?>
	<? endforeach; ?>
	<? endif; ?>		
	<script src="/public/js/js.compress.php"></script>
	<? if($_SERVER['HTTP_HOST'] == 'rh.studiobanks.com'): ?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAEo4HAZy9MWtI0x8ZXqliGhThekUgwwD5089YpNqieooUqpQMORTzxPdhslQQT0z7lnzZ4F_if3WPSA" type="text/javascript"></script>
	<? else: ?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAEo4HAZy9MWtI0x8ZXqliGhTI6yn64c-uVLNfNL7M_TUFHaYTXhSQ6XY6GFtnUfqiOfAylff5m62tdw" type="text/javascript"></script>
	<? endif; ?>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="/public/css/screen_ie_lt_7.css" />
		<script type="text/javascript" src="/public/js/unitpngfix.js"></script>
	<![endif]-->
</head>
<body>
	<div id="header">
		<h3>
			<a href="http://www.onlyinoldtown.com">Old Town Lifestyle Guide</a>
			<a href="http://www.rockhillusa.com" class="onit">Rock Hill for Business</a>
			<a href="/home/newsletter" class="nl" id="newsletter_signup">Join Our Newsletter</a>
		</h3>
		<ol>
			<li><a href="/contact">Contact Us</a></li>
			<li><a href="/resources">Resources</a></li>
		</ol>
		<div class="menu">
			<h1><a href="http://www.rockhillusa.com" class="unitPng"><img src="/public/assets/images/logo.png" class="unitPng" alt="Only in Old Town, Rock Hill"></a></h1>
			<ul>
				<li><a href="/rockhill" <?=($section=='rockhill')?'class="onit"':'';?>>about the city</a></li>
				<li><a href="/why" <?=($section=='why')?'class="onit"':'';?>>why Rock Hill</a></li>
				<li><a href="/properties" <?=($section=='properties')?'class="onit"':'';?>>properties</a></li>
				<li><a href="/news" <?=($section=='news')?'class="onit"':'';?>>news</a></li>
				<li class="last <?=($section=='about')?' onit':'';?>"><a href="/about">about us</a></li>
			</ul>
		</div>
	</div>
