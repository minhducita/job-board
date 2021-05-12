	</div><!-- #container -->
	<div class="clear"></div>
	<div class="footer">
		<div id="footer-contents">
			<div id="footer-col1">
				Use:<br />
				<a href="{$BASE_URL}post/" title="Post a new job for free!" >Post a new job</a><br />
				<a href="{$BASE_URL}rss/" title="An overview of all our available RSS Feeds." >RSS Feeds</a><br />
			</div>
			<div id="footer-col2">
				Find out more:<br />
				<a href="{$BASE_URL}about/" title="More information about us." >About Us</a><br />
				<a href="{$BASE_URL}contact/" title="Don't hesitate to contact us!" >Contact（お問い合わせ）</a><br />
				<a href="{$BASE_URL}privacypolicy/" title="Our privacy policy." >Privacy Policy</a><br />
			</div>
			<div id="footer-col3">
				Misc:<br />
				<a href="{$BASE_URL}companies/" title="An overview of all available companies." >Companies</a><br />
				<a href="{$BASE_URL}cities/" title="An overview of all available cities." >Cities</a><br />
				<a href="{$BASE_URL}sitemap/" title="Sitemap." >Sitemap</a><br />
			</div>
			<div id="footer-copyright">
				このサイトは、<a href="www.jawhm.or.jp" target="_blank">日本ワーキングホリデー協会</a>が運営しています。<br/>
				This site is operated by <a href="www.jawhm.or.jp/eng" target="_blank">JAWHM</a>.<br/>
			</div>
			<div class="clear"></div>
		</div><!-- #footer-contents -->
	</div><!-- .footer -->
	{literal}
	<script type="text/javascript">
		//<![CDATA[
		
 		$(document).ready(function()
		{
		   var keywords = $('#keywords');
			// setup search box
			keywords.bind('click', function() {
				if (this.value == '{/literal}{$translations.search.default}{literal}')
				{
					keywords.clearFields();
				}
			});

			keywords.bind('blur', function() {  
				if (this.value == '{/literal}{$translations.search.default}{literal}' || this.value == '')
				{
					this.value = '{/literal}{$translations.search.default}{literal}';
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
					window.search_timer = setTimeout(function(){Jobber.PerformSearch('{/literal}{$BASE_URL}{literal}search/{/literal}{$current_category}{literal}|', searchKeywords)}, 800);
			    }
			});
		});
		Jobber.jobber_url = "{/literal}{$BASE_URL}{literal}";
		//]]>
	</script>
	{/literal}
	{footerUnsetsession}
    {literal}

    {/literal}
    {literal}
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
    {/literal}

</body>
</html>