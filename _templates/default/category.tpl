{include file="header.tpl"}
		
		<div id="content">
			<div id="job-listings">
               {include file="spotlight.tpl"}

{php}
echo '[PR]<br/>';
echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
echo '<ins class="adsbygoogle"';
echo '     style="display:inline-block;width:728px;height:90px"';
echo '     data-ad-client="ca-pub-8112755181417377"';
echo '     data-ad-slot="9214961049"></ins>';
echo '<script>';
echo '(adsbygoogle = window.adsbygoogle || []).push({});';
echo '</script>';
echo '<br/>';
{/php}

				{if $jobs}
				<div id="sort-by-type">
				{$translations.category.display_only}&nbsp; 
					{section name=tmp loop=$types}
						<a href="{$BASE_URL}{$URL_JOBS}/{$current_category}/{$types[tmp].var_name}/" title="{$current_category} {$types[tmp].name}"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$types[tmp].var_name}.png" alt="{$types[tmp].name}" /></a>
					{/section}
				</div><!-- #sort-by-type -->
				{/if}
                <h2>
                {if $current_category == 'all'}
					{$translations.alljobs.all_jobs}
                {else}
					{$translations.category.jobs_for} {$current_category_name}
                {/if}
				</h2>
				{include file="posts-loop.tpl"}
			</div><!-- #job-listings -->
		</div><!-- #content -->

{include file="footer.tpl"}