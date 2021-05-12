            {if $CURRENT_PAGE != ''}
			<a href="{$BASE_URL}" title="{$translations.header.title}">&laquo; {$translations.header.home}</a><br />
			{/if}
            
            {if isset($current_category) && $current_category != 'home' && $current_category !=''}
            <h4>{$translations.header.filter_jobs}</h4>
            <ul>
                <li>
                    {if $filter != 'day'}
                        <a href="{$BASE_URL}{$URL_JOBS}/{$current_category}/day/">{$translations.filter.day}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.day}</a></strong>
                    {/if}
                </li>
                <li>
                    {if $filter != 'week'}
                        <a href="{$BASE_URL}{$URL_JOBS}/{$current_category}/week/">{$translations.filter.week}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.week}</a></strong>
                    {/if}
                </li>
                <li>
                    {if $filter != 'month'}
                        <a href="{$BASE_URL}{$URL_JOBS}/{$current_category}/month/">{$translations.filter.month}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.month}</a></strong>
                    {/if}
                </li>
                <li>
                    {if $filter != 'nofilter'}
                        <a href="{$BASE_URL}{$URL_JOBS}/{$current_category}/nofilter/">{$translations.filter.nofilter}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.nofilter}</a></strong>
                    {/if}
                </li>
            </ul>
            {/if}
            
			{if !empty($navigation.secondary)}
			<h4>{$translations.sidebar.menu_title}</h4>
			<ul>
				{section name=tmp loop=$navigation.secondary}
					{if $smarty.const.ENABLE_NEW_JOBS || (!$smarty.const.ENABLE_NEW_JOBS && $navigation.secondary[tmp].url != 'post')}
						<li><a href="{if $navigation.secondary[tmp].outside != 1}{$BASE_URL}{/if}{$navigation.secondary[tmp].url}/" title="{$navigation.secondary[tmp].title}" >{$navigation.secondary[tmp].name}</a></li>
					{/if}
				{/section}
			{/if}
			</ul>
			
			{if $smarty.session.last_viewed_jobs}
			<h4>{$translations.header.seen_recently}</h4>
			<ul>
				{section name=last loop=$smarty.session.last_viewed_jobs}
				<li><a href="{$smarty.session.last_viewed_jobs[last].url}">&raquo; {$smarty.session.last_viewed_jobs[last].title}</a></li>
				{/section}
			</ul>
			{/if}
			
			{if $CURRENT_PAGE == ''}
			<dl id="supportEmp">
    	<dt>Employment support content in Japan</dt>
    	<dd>
        <ul>
        	<li><a href="/job_in_Japan/">Work in Japan</a></li>
        	<li><a href="/interviewing/">Strategy for interview</a></li>
        	<li><a href="/business_manner/">Businessmanner</a></li>
        	<li><a href="/laborlaw_insurancesystem/">Labor law and insurance system</a></li>
        </ul>
      </dd>
    </dl><!-- / #supportEmp -->

			<div id="stats">
				<strong>{$jobs_count_all} {$translations.homepage.sidebar_totaljobs}</strong>
				<br />
				{if $smarty.const.SIDEBAR_SHOW_WHAT == 'categories'}
					{foreach item=job from=$jobs_count_all_categs}
					<strong>{$job.categ_count}</strong> {$translations.homepage.sidebar_for} <a href="{$BASE_URL}{$URL_JOBS}/{$job.categ_varname}/">{$job.categ_name}</a><br />
					{/foreach}
				{else}
					{foreach item=job from=$jobs_count_per_city}
					<strong>{$job.jobs_in_city}</strong> {$translations.jobscity.sidebar_jobs_in} <a href="{$BASE_URL}{$URL_JOBS_IN_CITY}/{$job.city_ascii_name}/">{$job.city_name}</a><br />
					{/foreach}
					{if !$hide_other_cities_in_sidebar}
					<strong>{$jobs_count_in_other_cities}</strong> {$translations.jobscity.sidebar_jobs_in} <a href="{$BASE_URL}jobs-in-other-cities/">{$translations.sidebar.other_cities}</a>
					{/if}
				{/if}
			</div><!-- #stats -->
			{/if}
            <br /><br />
{defineOnSidebar}


{displayAds}

