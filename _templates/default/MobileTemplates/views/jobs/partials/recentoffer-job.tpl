<div class="row">
    <a class="item clearfix" href="{$baseUrl}{$URL_JOB}/{$job.id}/{$job.url_title}/" title="{$job.title}">
        <div class="col-xs-12">
            <p><span class="btn btn{$job.type_var_name}">{$job.type_name}</span></p>
            <p class="date"><i class="fa fa-clock-o"></i> {$job.created_on}</p>
            <p class="company-name">
                {$job.company} <br>
            </p>
            <p class="job-title">
                {$job.title}
            </p>
        </div>

    </a>
</div>