{if isset($is_home) && $is_home == 1}
    <div><a href="{$BASE_URL}">&laquo; home</a></div>
{/if}
{if isset($no_categ) && $no_categ != 1}
    {if $keywords}
        Search results for <strong>{$keywords}</strong>:
    {/if}
    {if $jobs}
        {include file="MobileTemplates/views/jobs/jobs-list.tpl"}
    {else}
        {if !empty($request_post)}
        <div id="no-ads">
            {if $CURRENT_PAGE != 'search'}
                {$translations.jobs.no_job} <strong>{if isset($current_category_name)}{$current_category_name}{/if}</strong>.
            {else}
                {$translations.jobs.no_job_found}<br />
            {/if}
        </div><!-- #no-ads -->
        {/if}
    {/if}
{/if}