{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
    {assign var="adSlot" value="4196621042"}

    <div class="content">
        <section class="main">
            {if $spotlight_jobs}
                <div class="spotlight">
                    <div class="container">
                        <h2>{$translations.homepage.spotlight_jobs}{if $current_category_name != ''}, {$current_category_name}{/if}</h2>
                        {foreach item=job from=$spotlight_jobs}
                            {include file="../jobs/partials/spotlight-job.tpl"}
                        {/foreach}
                    </div>
                </div>
            {/if}
            <div class="google-ad">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8112755181417377" data-ad-slot="1243154642" data-ad-format="auto"></ins>
                            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                        </div>
                    </div>
                </div>
            </div>
            {if $jobs}
                <div class="mostView">
                    <div class="container">
                        <h2>{if $current_category == 'all'}
                                {$translations.alljobs.all_jobs}
                            {else}
                                {$translations.category.jobs_for} {$current_category_name}
                            {/if}</h2>
                        {foreach item=job from=$jobs}
                                {include file="../jobs/partials/recentoffer-job.tpl"}
                        {/foreach}
                    </div>
                    <div class="container">
                        <div class="row wrap-pagination">
                            <div class="col-xs-12">
                                {$pages}
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        </section>
    </div>
{/block}