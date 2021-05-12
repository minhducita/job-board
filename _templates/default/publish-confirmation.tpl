{include file="header.tpl"}
		
		<div id="content">
			<div id="job-listings"></div><!-- #job-listings -->
			<div class="steps">
				<div id="step-1">
					{$translations.publish.step1}
				</div>
				<div id="step-2">
					{$translations.publish.step2}
				</div>
				<div id="step-3" class="step-active">
					{$translations.publish.step3}
				</div>
				<div class="clear"></div>
			</div>
			<br />
            <div id="job-upper"><div id="number-views">Job ID : {$jobId}</div></div>
			{if $smarty.session.later_edit}
				<div class="posted-ok">
					{$translations.publish.edit_success}: <a href="{$job_url}">{$job_url}</a>
					{php}
						unset($_SESSION['later_edit']);
						unset($_SESSION['referer']);
					{/php}
				</div>
				<br />
				<p>
					<a href="{$BASE_URL}">&laquo; {$translations.notfound.back}</a>
				</p>
			{else}
					<div class="posted-pending">
						{$translations.publish.success_message}
					</div>
					<br />
					<p>
						<a href="{$BASE_URL}">&laquo; {$translations.notfound.back}</a>
					</p>
			{/if}
		</div><!-- /content -->

{include file="footer.tpl"}