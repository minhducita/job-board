{include file="header.tpl"}
		
		<div id="content">
            <h2 id="search-result" style="display:none;">Search Result</h2>
			<div id="job-listings"></div><br /><br />
			<div id="job-listings2">
				<h2 id="inactive">Inactive jobs</h2>
				{include file="posts-loop.tpl"}
			</div><!-- #job-listings -->
            <br />{include file="spotlight.tpl"}
			{*<iframe id="updates" src="http://www.evertsemeijn.nl/help/simplepie/admin.php" height="100" width="100%"></iframe>*}
		</div><!-- #content -->

{include file="footer.tpl"}