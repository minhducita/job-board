{if $spotlight_jobs}
	<h2>{$translations.homepage.spotlight_jobs}{if $current_category_name != ''}, {$current_category_name}{/if}</h2>
	
	{foreach item=job from=$spotlight_jobs}
		<div class="row-spot">
			<span class="row-info">
				<img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" />
				<a href="{$BASE_URL}{$URL_JOB}/{$job.id}/{$job.url_title}/" title="{$job.title}">{$job.title}</a> <span class="la">{$translations.homepage.at}</span> {$job.company}
			</span>
			<span class="spotlight-image"></span>
		</div>
	{/foreach}
    <br />
{/if}
