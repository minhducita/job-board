{include file="header.tpl"}
		
		<div id="content">
        <h2 id="search-result" style="display:none;">Search Result</h2>
        <div id="job-listings"></div><!-- #job-listings -->

		<br />
		<a href="{$back_link}" title="home">&laquo; go back</a><br />
			{include file="job-details.tpl"}
			{if $CURRENT_PAGE == $URL_JOB}
			<div id="job-bottom">
				<div id="job-post-utils">
				
				</div><!-- #job-post-utils -->
				<div id="number-views">
					Published at <strong>{$job.created_on}</strong><br />
					Viewed: <strong>{$job.views_count}</strong> times
				</div><!-- #number-views -->
				<div class="clear"></div>
			</div><!-- #job-bottom -->
			<div id="send-to-friend" style="display: none;">
				
			</div><!-- #send-to-friend -->
			
			{/if}
		</div><!-- /content -->

{include file="footer.tpl"}