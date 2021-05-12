{foreach item=job from=$jobs}
	<div class="{cycle values='row,row-alt'}">
		<span class="row-info">
			<img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" />
			<a href="{$BASE_URL}{$URL_JOB}/{$job.id}/{$job.url_title}/" title="{$job.title}">{$job.title}</a> <span class="la">{$translations.homepage.at}</span> {$job.company}
		</span>
		<span class="time-posted"><img src="{$BASE_URL}_templates/{$THEME}/img/clock.gif" alt="" /> {$job.created_on}</span>			
	</div>
{/foreach}
<br/>
<div class="row-pagin">
{$pages}
</div>