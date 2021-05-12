
<div style="maring-top:5px;">
    <table><tr>
            <td style="vertical-align:top;">
                <div class="fb-like" data-send="false" data-layout="button_count" data-width="110" data-show-faces="false" data-font="arial"></div>
            </td>
            <td style="vertical-align:top;">
                <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="GoStudyEnglish">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
            </td>
            <td style="vertical-align:top;">
                <g:plusone></g:plusone>
            </td>
        </tr></table>
</div>

<div id="job-details">
    {if $smarty.session.apply_successful AND $smarty.session.apply_successful eq 1}
        <div class="apply-status-ok">
            {$translations.apply.success}
        </div>
    {/if}

    {if $job.application_expired}
        <div class="application-expired-notice">
            {$translations.jobs.application_expired_notice}
        </div>
        {/if}

    <div id="job-upper">

        <div id="number-views">Job ID : {$job.id}</div>
    </div>
    {if ($job.days_old > $smarty.const.OLD_JOB_NOTIFY) && ($smarty.const.OLD_JOB_NOTIFY > 0)}
        <div id="old-ad">
            {$translator->translate("apply.old_ad", $smarty.const.OLD_JOB_NOTIFY)}
        </div>
    {/if}
    {if $CURRENT_PAGE == $URL_JOB}
        <div id="applied-to-job">
            {$job.applied_count}
            {if $job.applied_count != 1}
                <p>{$translations.homepage.applicants}</p>
            {else}
                <p>{$translations.homepage.applicant}</p>
            {/if}
        </div>
    {/if}
    <h2>
        <img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" /> {$job.title}
    </h2>
    <p>
        <span class="fading">{$translations.jobs.preposition_at}</span>
        {if $job.url && $job.url != 'http://'}
            <a href="{$job.url}">{$job.company}</a>
        {else}
            <strong>{$job.company}</strong>
        {/if}
    </p>

    <table style="margin:0 0 10px 0;">
        {if $job.nationality}<tr><th style="background-color:navy; color:white;">Nationality of an applicant</th><td style="border:1px solid navy;">{$job.nationality}</td></tr>{/if}
        {if $job.details}<tr><th style="background-color:navy; color:white;">Details of the job</th><td style="border:1px solid navy;">{$job.details}</td></tr>{/if}
        {if $job.address}<tr><th style="background-color:navy; color:white;">Working address</th><td style="border:1px solid navy;">{$job.address}</td></tr>{/if}
        {if $job.requ}<tr><th style="background-color:navy; color:white;">Requirements</th><td style="border:1px solid navy;">{$job.requ}</td></tr>{/if}
        {if $job.wage}<tr><th style="background-color:navy; color:white;">Wage</th><td style="border:1px solid navy;">{$job.wage}</td></tr>{/if}
    </table>
    <!-- Nam Cap nhat -->
    <div class="image_job" style="text-align:center">
        {if $job.image1 !="NULL" && $job.image1}<a class="example-image-link" href="{$BASE_URL}{$job.root_image1}" data-lightbox="example-set" data-title="{$job.title}"><img src="{$BASE_URL}{$job.image1}"  alt="" /></a>{/if}
        {if $job.image2 !="NULL" && $job.image2}<a class="example-image-link" href="{$BASE_URL}{$job.root_image2}" data-lightbox="example-set" data-title="{$job.title}"><img src="{$BASE_URL}{$job.image2}"  alt="" /></a>{/if}
        {if $job.image3 !="NULL" && $job.image3}<a class="example-image-link" href="{$BASE_URL}{$job.root_image3}" data-lightbox="example-set" data-title="{$job.title}"><img src="{$BASE_URL}{$job.image3}"  alt="" /></a>{/if}
    </div>
    <!-- Nam Cap nhat -->

    <div id="job-description">
        {$job.description}
    </div>
    <br />
    {if $job.apply_online == 1 && $CURRENT_PAGE != 'verify'}
        {if !$job.application_expired}
            <div id="apply_online_now"><a class="btnApplynow" href="#" onclick="$('#apply-online').toggle(); window.location.href = '#apply'; return false;">
                    {$translations.apply.apply_message}
                </a></div>
        {/if}

        {if $smarty.session.apply_successful AND $smarty.session.apply_successful eq -1}
            <div class="validation-failure">
                <img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />
                {if $smarty.session.apply_allowed AND $smarty.session.apply_allowed eq -1}
                    {$translator->translate("apply.error_apply_timeout_not_passed", $smarty.const.MINUTES_BETWEEN_APPLY_TO_JOBS_FROM_SAME_IP)}
                {elseif $smarty.session.apply_mail_sent AND $smarty.session.apply_mail_sent eq -1}
                    {$translations.apply.error_sending_mail}
                {elseif $smarty.session.apply_errors.apply_cv}
                    {$smarty.session.apply_errors.apply_cv}
                {else}
                    {$translations.apply.errro_apply_data_invalid}
                {/if}
            </div>
        {/if}

        <div id="apply-online" {if $smarty.session.apply_successful AND $smarty.session.apply_successful eq -1}style="display: block;"{else}style="display: none;"{/if}>
            <form id="frm-apply-online" method="post" enctype="multipart/form-data" action="{$BASE_URL}apply-online/">
                <table>
                    <tr>
                        <td><label for="apply_name">{$translations.apply.name_label}:</label></td>
                        <td>
                            <input {if $smarty.session.apply_errors.apply_name}class="error"{/if} type="text" name="apply_name" id="apply_name" maxlength="50" size="30" value="{$smarty.session.apply_fields.apply_name}" />
                            <span class="validation-error">{if $smarty.session.apply_errors.apply_name}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{/if}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="apply_email">{$translations.apply.email_label}:</label></td>
                        <td>
                            <input {if $smarty.session.apply_errors.apply_email}class="error"{/if} type="text" name="apply_email" id="apply_email" maxlength="50" size="30" value="{$smarty.session.apply_fields.apply_email}" />
                            <span class="validation-error">{if $smarty.session.apply_errors.apply_email}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{/if}</span>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top"><label for="apply_msg">{$translations.apply.message_label}:</label></td>
                        <td>
                            <textarea {if $smarty.session.apply_errors.apply_msg}class="error"{/if} name="apply_msg" id="apply_msg" cols="60" rows="15">{$smarty.session.apply_fields.apply_msg}</textarea>
                            <span class="validation-error">{if $smarty.session.apply_errors.apply_msg}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{/if}</span>
                        </td>
                    </tr>
                    {if isset($smarty.session.attachment)}
                        <tr>
                            <td>Your Resume/CV:</td>
                            <td>{$smarty.session.attachment.name}</td>
                        </tr>
                    {/if}

                    <tr>
                        <td valign="top"><label for="apply_cv">{$translations.apply.cv_label}:</label></td>
                        <td>
                            <input type="file" name="apply_cv" id="apply_cv" />
                            <span class="validation-error">{if $smarty.session.apply_errors.apply_cv}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" title="{$smarty.session.apply_errors.apply_cv}" />{/if}</span>
                            <div class="suggestion">{$translations.apply.cv_info}</div>
                        </td>
                    </tr>
                    {if $ENABLE_RECAPTCHA}
                        <tr>
                            <td valign="top"><label>Anti-Spam</label></td>
                            <td>
                                {literal}
                                    <script type="text/javascript">
                                        var RecaptchaOptions = {
                                            theme : 'white',
                                            tabindex : 9
                                        };
                                    </script>
                                {/literal}
                                {$the_captcha} <span class="validation-error">{if $smarty.session.apply_errors.captcha}
											<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /> {$smarty.session.apply_errors.captcha}{/if}</span>
                            </td>
                        </tr>
                    {/if}
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" id="submit" value="{$translations.apply.submit}" /> {$translations.apply.or}
                            <a href="#" onclick="$('#apply-online').toggle(); return false;">{$translations.apply.cancel}</a>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="job_id" id="job_id" value="{$job.id}" />
            </form>
        </div><!-- #apply-online -->
    {/if}

    {if $job.address}
        <div id="map1" style="width: 500px; height: 320px;"></div>
        <script>
            var address = '{$job.address}';
        </script>
    {literal}
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=en"></script>
        <script type="text/javascript">
            function drawMap1()	{
                var geocoder;
                geocoder = new google.maps.Geocoder();
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var map_tag = document.getElementById('map1');
                        var map_location = new google.maps.LatLng(35.693165, 139.698817);
                        var map_options =
                        {
                            zoom: 16,
                            center: map_location,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                        };
                        var map = new google.maps.Map(map_tag, map_options);

                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            zoom: 16,
                            map: map,
                            position: results[0].geometry.location
                        });
                    } else {
                        document.getElementById('map1').style.display = 'none';
                    }
                });
            }
            google.maps.event.addDomListener(window, 'load', drawMap1);

        </script>
    {/literal}

    {/if}

    <br />{include file="company-posts-loop.tpl"}
</div><!-- #job-details -->
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        {/literal}
        {if $smarty.session.apply_successful AND $smarty.session.apply_successful eq -1}
        {literal}
        if (document.getElementById("apply_name"))
        {
            window.location.href = "#apply";
            document.getElementById("apply_name").focus();
        }
        {/literal}
        {/if}
        {literal}
        $("#frm-apply-online").validate({
            rules: {
                apply_name: { required: true },
                apply_email: { required: true, email: true },
                apply_msg: { required: true },
                apply_cv: { accept: "pdf|rtf|doc|odt" }
            },
            messages: {
                apply_name: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
                apply_email: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
                apply_msg: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
                apply_cv: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />'
            }
        });
    });
</script>
{/literal}