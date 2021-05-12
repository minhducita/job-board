{if $spotlight_jobs}
    <h2 id="favorite">
        {$translations.homepage.spotlight_jobs}
        {if $current_category_name != ''}, {$current_category_name}{/if}
    </h2>
    <div class="list">

        {foreach item=job from=$spotlight_jobs}
            <div class="row row-spot">
                <div class="icons">
                    {$job.created_on}

                    <a href="{$BASE_URL_ADMIN}edit-post/{$job.id}/" title="Edit this job"><img src="{$BASE_URL_ADMIN}_templates/img/pencil.png" alt="edit" /></a>

                    {if $job.is_active == 0}
                    <a id="activateLink{$job.id}" href="javascript:void(0);" onclick="Jobber.Activate('{$BASE_URL_ADMIN}activate/', {$job.id}, {if $CURRENT_PAGE == ''}1{else}0{/if});" title="Active this job"><img src="{$BASE_URL_ADMIN}_templates/img/switch_off.png" alt="activate" /></a>
                    {else}
                    <a id="deactivateLink{$job.id}" href="javascript:void(0);" onclick="Jobber.Deactivate('{$BASE_URL_ADMIN}deactivate/', {$job.id});" title="Deactive this job"><img src="{$BASE_URL_ADMIN}_templates/img/switch.png" alt="deactivate" /></a>
                    {/if}&nbsp;
                    <a href="javascript:void(0);" onclick="Jobber.Delete('{$BASE_URL_ADMIN}delete/', {$job.id});" title="Delete this job"><img src="{$BASE_URL_ADMIN}_templates/img/bin.png" alt="delete" /></a>
                    <a href="javascript:void(0);" onclick="Jobber.SendConfirmationEmail('{$BASE_URL_ADMIN}send-confirmation-email', {$job.id});" title="Send an email for client"><img src="{$BASE_URL_ADMIN}_templates/img/icon-email.png" class="icon" alt="email" /></a>

                    <div>
                        {if $job.is_spotlight == 0}
                        <a id="activateSpotlight{$job.id}" href="javascript:void(0);" onclick="Jobber.SpotlightActivate('{$BASE_URL_ADMIN}activate-spotlight/', {$job.id});" title="Turn spotlight on"><img src="{$BASE_URL_ADMIN}_templates/img/star_off.png" alt="activate" /></a>
                        {else}
                        <a id="deactivateSpotlight{$job.id}" href="javascript:void(0);" onclick="Jobber.SpotlightDeactivate('{$BASE_URL_ADMIN}deactivate-spotlight/', {$job.id});" title="Turn spotlight off"><img src="{$BASE_URL_ADMIN}_templates/img/star_on.png" alt="deactivate" /></a>
                        {$job.spotlight_start_date} - {$job.spotlight_end_date}
                        {/if}&nbsp;
                    </div>
                </div>


                <img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" />
                <a href="{$BASE_URL_ADMIN}{$URL_JOB}/{$job.id}/{$job.url_title}/" title="{$job.title}">{$job.title}</a> <span class="light">at</span> {$job.company}
                <div>viewed {$job.views_count} times{if $statisticalData[$job.id]}, {$statisticalData[$job.id].numberOfApplications} applicants, last application on {$statisticalData[$job.id].lastApplicationOn}{/if}{if $spamReportStatisticalData[$job.id]},<span class="spam"> reported as spam {$spamReportStatisticalData[$job.id].numberOfSpamReports} times, last time on {$spamReportStatisticalData[$job.id].lastSpamReportOn}</span>{/if}</div>

            </div>
        {/foreach}
    </div>
    <br />
    <div class="pagination">{$pages}</div>
{/if}