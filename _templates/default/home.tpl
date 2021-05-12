{if $spotlight_jobs}
	<h2>{$translations.homepage.spotlight_jobs}</h2>
	
	{foreach item=job from=$spotlight_jobs}
		<div class="row-spot">
			<span class="row-info">
				<img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" />
				<a href="{$BASE_URL}{$URL_JOB}/{$job.id}/{$job.url_title}/" title="{$job.title}">{$job.title}</a> <span class="la">{$translations.homepage.at}</span> {$job.company}
			</span>
			<span class="spotlight-image"></span>
		</div>
	{/foreach}
{/if}
{php}
echo '<br/>[PR]<br/>';
echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
echo '<ins class="adsbygoogle"';
echo '     style="display:inline-block;width:728px;height:90px"';
echo '     data-ad-client="ca-pub-8112755181417377"';
echo '     data-ad-slot="2185195440"></ins>';
echo '<script>';
echo '(adsbygoogle = window.adsbygoogle || []).push({});';
echo '</script>';
{/php}
{if $latest_jobs}
	<br />
	<h2>{$translations.homepage.recent_jobs}</h2>
	
	{foreach item=job from=$latest_jobs}
		<div class="{cycle values='row,row-alt'}">
			<span class="row-info">
				<img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" />
				<a href="{$BASE_URL}{$URL_JOB}/{$job.id}/{$job.url_title}/" title="{$job.title}">{$job.title}</a> <span class="la">{$translations.homepage.at}</span> {$job.company}
			</span>
			<span class="time-posted"><img src="{$BASE_URL}_templates/{$THEME}/img/clock.gif" alt="" /> {$job.created_on}</span>
		</div>
	{/foreach}
	
	<div id="view_all">
		<a href="{$BASE_URL}{$URL_JOBS}/">{$translations.homepage.view_all_jobs}</a>
	</div>
{/if}
{php}
//<!--/* OpenX Local Mode Tag v2.8.8 */-->
// The MAX_PATH below should point to the base of your OpenX installation
define('MAX_PATH', '/var/www/html/ad');
if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
    if (!isset($phpAds_context)) {
        $phpAds_context = array();
    }
    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
    $phpAds_raw = view_local('', 167, 0, 0, '', '', '0', $phpAds_context, '');
}

echo $phpAds_raw['html'];
{/php}
{if $most_previewed_jobs}
	<br />
	<h2>{$translations.homepage.access_ranking}</h2>
	
	{foreach item=job from=$most_previewed_jobs}
		<div class="{cycle values='row,row-alt'}">
			<span class="row-info">
				<img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" />
				<a href="{$BASE_URL}{$URL_JOB}/{$job.id}/{$job.url_title}/" title="{$job.title}">{$job.title}</a> <span class="la">{$translations.homepage.at}</span> {$job.company}
			</span>
			<span class="time-posted"><strong>{$job.apps}</strong> {$translations.homepage.viewed}</span>			
		</div>
	{/foreach}
{/if}

{if !$latest_jobs && !$most_applied_to_jobs}
	<br />
	<p>
		{$translations.homepage.no_jobs}.<br />
		<a href="{$BASE_URL}post/" title="{$translations.footer.new_job_title}">{$translations.footer.new_job}</a>?
	</p>
{/if}

<div id="topSupportBox">
  <h2><img src="/_templates/default/img/h2_top_support.gif" alt="Employment support content in Japan" /></h2>
  <ul>
    <li><a href="{$BASE_URL}job_in_Japan/"><img src="/_templates/default/img/btn_topsupport1.png" alt="Work in Japan" /></a></li>
    <li><a href="{$BASE_URL}interviewing/"><img src="/_templates/default/img/btn_topsupport2.png" alt="Message from senior" /></a></li>
    <li><a href="/business_manner/"><img src="/_templates/default/img/btn_topsupport3.png" alt="Businessmanner" /></a></li>
    <li class="last"><a href="/laborlaw_insurancesystem/"><img src="/_templates/default/img/btn_topsupport4.png" alt="Labor law and insurance system" /></a></li>
  </ul>
</div><!-- / #topSupportBox -->
