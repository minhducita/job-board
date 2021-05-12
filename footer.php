	<div class="footer">
		<div id="footer-contents">
			<div id="footer-col1">
				Use:<br />
				<a href="<?php echo APP_URL;?>find-new-job/" title="Find a new job for free!" >Find a new job</a><br />
				<a href="<?php echo APP_URL;?>rss/" title="An overview of all our available RSS Feeds." >RSS Feeds</a><br />
			</div>
			<div id="footer-col2">
				Find out more:<br />
				<a href="<?php echo APP_URL;?>about/" title="More information about us." >About Us</a><br />
				<a href="<?php echo APP_URL;?>contact/" title="Don't hesitate to contact us!" >Contact（お問い合わせ）</a><br />
				<a href="<?php echo APP_URL;?>privacypolicy/" title="Our privacy policy." >Privacy Policy</a><br />
			</div>
			<div id="footer-col3">
				Misc:<br />
				<a href="<?php echo APP_URL;?>companies/" title="An overview of all available companies." >Companies</a><br />
				<a href="<?php echo APP_URL;?>cities/" title="An overview of all available cities." >Cities</a><br />
				<a href="<?php echo APP_URL;?>sitemap/" title="Sitemap." >Sitemap</a><br />
			</div>
			<div id="footer-copyright">
				このサイトは、<a href="http://www.jawhm.or.jp" target="_blank">日本ワーキングホリデー協会</a>が運営しています。<br/>
				This site is operated by <a href="http://www.jawhm.or.jp/eng" target="_blank">JAWHM</a>.<br/>
			</div>
			<div class="clear"></div>
		</div><!-- #footer-contents -->
	</div><!-- .footer -->
	
	<script type="text/javascript">
		//<![CDATA[
		
 		$(document).ready(function()
		{
		   var keywords = $('#keywords');
			// setup search box
			keywords.bind('click', function() {
				if (this.value == 'Search for a job')
				{
					keywords.clearFields();
				}
			});

			keywords.bind('blur', function() {  
				if (this.value == 'Search for a job' || this.value == '')
				{
					this.value = 'Search for a job';
				}
			});

			// setup live search
			keywords.keyup(function(key) {
				var searchKeywords = jQuery.trim(this.value);
				var len = searchKeywords.length;
				
			    if (key.keyCode != 9 && len >= 3)
				{
					$("#indicator").show();	
					clearTimeout(window.search_timer);	
					window.search_timer = setTimeout(function(){Jobber.PerformSearch('<?php echo APP_URL;?>search/|', searchKeywords)}, 800);
			    }
			});
		});
		Jobber.jobber_url = "<?php echo APP_URL;?>";
		//]]>
	</script>
	
	    
    <script type="text/javascript" src="<?php echo APP_URL;?>js/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript">
        tinyMCE.init({
            mode : "textareas",
            editor_selector : "mceEditor",
            theme: "advanced",
			plugins : "safari,lists,advimage,advlink,inlinepopups,contextmenu,fullscreen,jbimages",
					
            theme_advanced_toolbar_align: "left",
            theme_advanced_toolbar_location: "top",
			theme_advanced_statusbar_location : "bottom",

            theme_advanced_buttons1: "bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,fontsizeselect,forecolor,backcolor,separator,bullist,numlist,separator,undo,redo,separator,link,unlink,image,separator,jbimages,separator,fullscreen",
		 	theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			height: "500px",
            width: "420px",
			
			//  options
			relative_urls:false
			
        });
		
    </script>
    
    
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=158074594262625";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
      { lang: 'ja' }
    </script>