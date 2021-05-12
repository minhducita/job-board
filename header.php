<?php
// config
if(!file_exists('../_config/config.php'))
{
	die('[index.php] _config/config.php not found');
}

require_once '../_config/config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php echo @$cns_title; ?> | <?php echo $settings['html_title']?></title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="generator" content="Jobberbase v1.9" />
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo APP_URL;?>favicon.ico" type="image/x-icon" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo APP_URL;?>rss/all/" />
	<link rel="stylesheet" href="<?php echo APP_URL;?>_templates/default/css/screen.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo APP_URL;?>_templates/default/css/print.css" media="print" type="text/css" />
	<script src="<?php echo APP_URL;?>js/jquery.js" type="text/javascript"></script>
	<!--[if !IE]><script src="<?php echo APP_URL;?>js/jquery.history.js" type="text/javascript"></script><![endif]-->
	<script src="<?php echo APP_URL;?>js/jquery.form.js" type="text/javascript"></script>
	<script src="<?php echo APP_URL;?>js/cmxforms.js" type="text/javascript"></script>
	<script src="<?php echo APP_URL;?>js/jquery.metadata.js" type="text/javascript"></script>
	<script src="<?php echo APP_URL;?>js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="<?php echo APP_URL;?>js/functions.js" type="text/javascript"></script>
	<script type="text/javascript">
		Jobber.I18n = {"js": {"location_pick_from_list":"Pick one from the list","location_other":"other","send_to_friend_successful":"Your message was sent. Let\'s hope it doesn\'t get marked as spam!","send_to_friend_unsuccessful":"Your message could not be sent. Did you enter both addresses?","report_spam_successful":"Thank you, your vote was registered and is highly appreciated!","report_spam_unsuccessful":"Thank you for your intention, but your vote could not be registered.","delete_job_confirmation_question":"Are you sure you want to delete this post?"}};
	</script>


	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-20563699-5']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>
</head>

<body>
<div id="container">
	<div id="header">
		<h1 id="logo">日本ワーキングホリデー協会のお仕事掲示板<br/><a href="<?php echo APP_URL;?>" title="IT jobs">jobber</a></h1>
		<ul id="top">
			<li><a href="<?php echo APP_URL;?>for_employer/" title="ForEmployer" >雇用主の方へ(投稿方法)</a></li>
			<li>&bull;</li>
			<li><a href="<?php echo APP_URL;?>faq/" title="FAQ" >FAQ（よくある質問）</a></li>
			<li>&bull;</li>
			<li><a href="<?php echo APP_URL;?>privacypolicy/" title="Privacy Policy" >Privacy Policy</a></li>
			<li>&bull;</li>
			<li><a href="<?php echo APP_URL;?>contact/" title="Contact" >Contact（お問い合わせ）</a></li>
		</ul>
		<div id="the_feed">
			<a href="<?php echo APP_URL;?>rss/all/" title="Subscribe to the RSS feed"><img src="<?php echo APP_URL;?>_templates/default/img/bt-rss.png" alt="RSS" /></a>
		</div>
	</div><!-- #header -->
	<div id="box">
		<div id="search">
			<form id="search_form" method="post" action="<?php echo APP_URL;?>search/">
				<fieldset>
					<div>
						<a href="?version=phone" class="jobboard-mobile"><img src="<?php echo APP_URL;?>_templates/default/img/btnSmartphone.png" alt="" /></a>

						<input type="text" name="keywords" id="keywords" maxlength="30" value="Search for a job" />
						<span id="indicator" style="display: none;"><img src="<?php echo APP_URL;?>_templates/default/img/ajax-loader.gif" alt="" /></span>
					</div>
					<div><label class="suggestionTop">(e.g. &quot;ajax&quot;, &quot;designer, london&quot;, &quot;php, chicago&quot;)</label></div>
				</fieldset>
			</form>
		</div><!-- #search -->
		<div class="addJob">
			<a class="btnFindJob" href="{$BASE_URL}find-new-job/">Find a new job</a>
			<a href="{$BASE_URL}post/" title="{$translations.search.submit_title}" class="add">{$translations.search.submit}</a>

			<a style="display: block; text-align: right;margin-right: 85px;" href="/for_employer/">投稿方法について</a>

		</div><!-- .addJob -->

		<div class="addJob">

			<a  href="<?php echo APP_URL;?>find-new-job/" title="Find a job" class="btnFindJob">Find a new job</a>
			<a href="<?php echo APP_URL;?>post/" title="Post a new job" class="add">Post a new job</a>
			<a style="display: block; text-align: right;margin-right: 85px;" href="/for_employer/" title="Privacy Policy">投稿方法について</a>
		</div><!-- .addJob -->
	</div><!-- #box -->

	<div id="categs-nav">
		<ul>
			<li id="Restaurant" ><a href="<?php echo APP_URL;?>jobs/Restaurant/" title="Restaurant"><span>Restaurant</span><span class="cnr">&nbsp;</span></a></li>
			<li id="Shop" ><a href="<?php echo APP_URL;?>jobs/Shop/" title="Shop"><span>Shop</span><span class="cnr">&nbsp;</span></a></li>
			<li id="Teacher" ><a href="<?php echo APP_URL;?>jobs/Teacher/" title="Teacher"><span>Teacher</span><span class="cnr">&nbsp;</span></a></li>
			<li id="Translation" ><a href="<?php echo APP_URL;?>jobs/Translation/" title="Translation"><span>Translation</span><span class="cnr">&nbsp;</span></a></li>
			<li id="Nanny-AuPair" ><a href="<?php echo APP_URL;?>jobs/Nanny-AuPair/" title="Nanny/AuPair"><span>Nanny/AuPair</span><span class="cnr">&nbsp;</span></a></li>
			<li id="Office_Worker" ><a href="<?php echo APP_URL;?>jobs/Office_Worker/" title="Office Worker"><span>Office Worker</span><span class="cnr">&nbsp;</span></a></li>
			<li id="Event_Staff" ><a href="<?php echo APP_URL;?>jobs/Event_Staff/" title="Event Staff"><span>Event Staff</span><span class="cnr">&nbsp;</span></a></li>
			<li id="Other" ><a href="<?php echo APP_URL;?>jobs/Other/" title="Other"><span>Other</span><span class="cnr">&nbsp;</span></a></li>
		</ul>
	</div><!-- #categs-nav -->
	<div class="clear"></div>