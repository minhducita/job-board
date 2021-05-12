{if $CURRENT_PAGE == 'page-unavailable' || $CURRENT_PAGE == 'job-unavailable'}    {header404}{/if}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head>    <title>{if $seo_title}{$seo_title}{if $current_category != 'home'} | {/if}{else}{$html_title}{if $current_category != 'home'} | {/if}{/if}{if $current_category != 'home'}{$smarty.const.SITE_NAME}{/if}</title>    <meta name="description" content="{if $seo_desc}{$seo_desc}{else}{$meta_description}{/if}" />    <meta name="keywords" content="{if $seo_keys}{$seo_keys}{else}{$meta_keywords}{/if}" />    <meta name="generator" content="Jobberbase v{$smarty.const.JOBBERBASE_VERSION}" />    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />    <link rel="shortcut icon" href="{$BASE_URL}favicon.ico" type="image/x-icon" />    {if $CURRENT_PAGE == '' || $CURRENT_PAGE != 'jobs'}        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="{$BASE_URL}rss/all/" />    {else}        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="{$BASE_URL}rss/{$current_category}/" />    {/if}    <link rel="stylesheet" href="{$BASE_URL}_templates/{$THEME}/css/screen.css" type="text/css" media="screen" />    <link rel="stylesheet" href="{$BASE_URL}_templates/{$THEME}/font-awesome-4.3.0/css/font-awesome.min.css" type="text/css" media="screen" />    <link rel="stylesheet" href="{$BASE_URL}_templates/{$THEME}/css/style.css" type="text/css" media="screen" />    <link rel="stylesheet" href="{$BASE_URL}_templates/{$THEME}/css/print.css" media="print" type="text/css" />    <link rel="stylesheet" href="{$BASE_URL}_templates/{$THEME}/css/jquery-ui.css">    <link rel="stylesheet" href="{$BASE_URL}_templates/{$THEME}/css/jquery_upload.css">    <script src="{$BASE_URL}js/jquery-1.8.js" type="text/javascript"></script>    <!--[if !IE]><script src="{$BASE_URL}js/jquery.history.js" type="text/javascript"></script><![endif]-->    <script src="{$BASE_URL}js/jquery.form.js" type="text/javascript"></script>    <script src="{$BASE_URL}js/cmxforms.js" type="text/javascript"></script>    <script src="{$BASE_URL}js/jquery.metadata.js" type="text/javascript"></script>    <script src="{$BASE_URL}js/jquery.validate.min.js" type="text/javascript"></script>    <script src="{$BASE_URL}js/functions.js" type="text/javascript"></script>    <script src="{$BASE_URL}js/jquery-ui.js"></script>    <script src="{$BASE_URL}js/jquery_upload.js"></script>    <script type="text/javascript">        Jobber.I18n = {$translationsJson};    </script>    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->    <!--[if lt IE 9]>    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>    <![endif]-->    {literal}        <script type="text/javascript">            var _gaq = _gaq || [];            _gaq.push(['_setAccount', 'UA-20563699-5']);            _gaq.push(['_trackPageview']);            (function() {                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);            })();        </script>    {/literal}</head><body><div id="container">    {if $smarty.session.status neq ''}        <div id="status">            {$smarty.session.status}        </div><!-- #status -->    {/if}    <div id="header">        <h1 id="logo">日本ワーキングホリデー協会のお仕事掲示板<br/><a href="{$BASE_URL}" title="IT jobs">jobber</a></h1>        <ul id="top">            <li><a href="{$BASE_URL}for_employer/" title="ForEmployer" >雇用主の方へ(投稿方法)</a></li>            <li>&bull;</li>            <li><a href="{$BASE_URL}faq/" title="FAQ" >FAQ（よくある質問）</a></li>            <li>&bull;</li>            <li><a href="{$BASE_URL}privacypolicy/" title="Privacy Policy" >Privacy Policy</a></li>            <li>&bull;</li>            <li><a href="{$BASE_URL}contact/" title="Contact" >Contact（お問い合わせ）</a></li>        </ul>        <div id="the_feed">            <a href="{$BASE_URL}rss/all/" title="{$translations.header.rss_title}"><img src="{$BASE_URL}_templates/{$THEME}/img/bt-rss.png" alt="{$translations.header.rss_alt}" /></a>        </div>    </div><!-- #header -->    <div id="box">        <div id="search">            <form id="search_form" method="post" action="{$BASE_URL}search/">                <fieldset>                    <div>                        <a href="?version=phone" class="jobboard-mobile"><img src="{$BASE_URL}_templates/{$THEME}/img/btnSmartphone.png" alt="" /></a>                        <input type="text" name="keywords" id="keywords" maxlength="30" value="{if $keywords}{$keywords}{else}{$translations.search.default}{/if}" />                        <span id="indicator" style="display: none;"><img src="{$BASE_URL}_templates/{$THEME}/img/ajax-loader.gif" alt="" /></span>                    </div>                    <div><label class="suggestionTop">{$translations.search.example}</label></div>                </fieldset>            </form>        </div><!-- #search -->        {if $smarty.const.ENABLE_NEW_JOBS}            <div class="addJob">                <a class="btnFindJob" href="{$BASE_URL}find-new-job/">Find a new job</a>                <a href="{$BASE_URL}post/" title="{$translations.search.submit_title}" class="add">{$translations.search.submit}</a>                <a style="display: block; text-align: right;margin-right: 85px;" href="/for_employer/">投稿方法について</a>            </div><!-- .addJob -->        {/if}    </div><!-- #box -->    <div id="categs-nav">        <ul>            {section name=tmp loop=$categories}                <li id="{$categories[tmp].var_name}" {if $current_category == $categories[tmp].var_name}class="selected"{/if}><a href="{$BASE_URL}{$URL_JOBS}/{$categories[tmp].var_name}/" title="{$categories[tmp].name}"><span>{$categories[tmp].name}</span><span class="cnr">&nbsp;</span></a></li>            {/section}        </ul>    </div><!-- #categs-nav -->    <div class="clear"></div>    <div id="sidebar">        {include file="sidebar.tpl"}    </div><!-- #sidebar -->