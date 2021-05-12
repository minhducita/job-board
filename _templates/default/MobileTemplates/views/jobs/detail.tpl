{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
    {assign var="adSlot" value="5673354241"}

    <div class="content">
        <section class="main">
            <div class="detail-page">
                <h2 class="main-title">Job ID : {$job.id}</h2>
                <div class="container">
                    <div class="row mb15">
                        {if isset($job) && !$job.application_expired && $job.apply_online == 1 && $CURRENT_PAGE != 'verify'}
                        <div class="col-xs-12 text-center">
                            <a href="" class="btn bgf1ae47 mt15 w80p btnApplyNow">Apply Now - 応募する</a>
                        </div>
                        {/if}
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            {if $smarty.session.apply_successful AND $smarty.session.apply_successful eq 1}
                                <div class="alert alert-success">
                                    {$translations.apply.success}
                                </div>
                            {/if}

                            {if isset($job) && $job.application_expired}
                                <div class="alert alert-warning">
                                    {$translations.jobs.application_expired_notice}
                                </div>
                            {/if}
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <p><a class="btn btn{$job.type_var_name}">{$job.type_name}</a> {$job.title}<br>
                                <span class="gray">{$translations.homepage.at}</span> {$job.company}</p>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                        {if $job.nationality}
                            <tr>
                                <td class="c4cb3ad">Nationality of an applicant	</td>
                                <td>{$job.nationality}</td>
                            </tr>
                        {/if}
                        {if $job.details}
                            <tr>
                                <td class="c4cb3ad">Detail of the job</td>
                                <td>{$job.details}</td>
                            </tr>
                        {/if}
                        {if $job.address}
                            <tr>
                                <td class="c4cb3ad">Working address</td>
                                <td>{$job.address}</td>
                            </tr>
                        {/if}
                        {if $job.requ}
                            <tr>
                                <td class="c4cb3ad">Requirements</td>
                                <td>{$job.requ}</td>
                            </tr>
                        {/if}
                        {if $job.wage}
                            <tr>
                                <td class="c4cb3ad">Wage</td>
                                <td>{$job.wage}</td>
                            </tr>
                        {/if}
                        </tbody>
                    </table>
                    {if $job.image1}
                        <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
                            <!-- Wrapper for carousel items -->
                            <div class="carousel-inner">
                                {if $job.image1 !="NULL" && $job.image1}
                                    <div class="active item">
                                        <img src="{$BASE_URL}{$job.image1}" class="img-responsive"  alt="" />
                                    </div>
                                {/if}
                                {if $job.image2 !="NULL" && $job.image2}
                                    <div class="item {if !$job.image1 && $job.image2}active{/if}">
                                        <img src="{$BASE_URL}{$job.image2}" class="img-responsive"  alt="" />
                                    </div>
                                {/if}
                                {if $job.image3 !="NULL" && $job.image3}
                                    <div class="item {if (!$job.image1 && !$job.image2) && $job.image3}active{/if}">
                                        <img src="{$BASE_URL}{$job.image3}" class="img-responsive"  alt="" />
                                    </div>
                                {/if}
                            </div>
                            <!-- Carousel controls -->

                            {if $active_arrow > 1}
                                <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="carousel-control right" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            {/if}
                        </div>
                    {/if}
                    <div class="detail-content">
                        {$job.description}
                    </div>
                    <div class="i-map">
                        {if $job.address}
                            <div id="map1" style="width: 100%; height: 320px;"></div>
                            <script>
                                var address = '{$job.address}';
                            </script>
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
                        {/if}
                    </div>
                    {if $job.apply_online == 1 && $CURRENT_PAGE != 'verify'}
                    <div class="row"  id="apply">
                        <div class="col-xs-12 text-center">
                            {if !$job.application_expired}
                                <a href="#" class="btn bgf1ae47 mt15 btnApplyNow">{$translations.apply.apply_title}</a>
                            {/if}
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-xs-12">
                                {if isset($smarty.session.apply_successful) AND $smarty.session.apply_successful eq -1}
                                    <div class="validation-failure">
                                        <img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />
                                        {if isset($smarty.section) && $smarty.session.apply_allowed AND $smarty.session.apply_allowed eq -1}
                                            {$translator->translate("apply.error_apply_timeout_not_passed", $smarty.const.MINUTES_BETWEEN_APPLY_TO_JOBS_FROM_SAME_IP)}
                                        {elseif isset($smarty.section) && $smarty.session.apply_mail_sent AND $smarty.session.apply_mail_sent eq -1}
                                            {$translations.apply.error_sending_mail}
                                        {elseif isset($smarty.section) && $smarty.session.apply_errors.apply_cv}
                                            {$smarty.session.apply_errors.apply_cv}
                                        {else}
                                            {$translations.apply.errro_apply_data_invalid}
                                        {/if}
                                    </div>
                                {/if}
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="apply-now-form" class="frmApplyNow" style="{if !empty($smarty.session.apply_errors)}display:block;{/if}">
                                <form id="frm-apply-online" method="post" enctype="multipart/form-data" action="{$baseUrl}apply-online/">
                                    <input type="hidden" name="job_id" id="job_id" value="{$job.id}" />
                                    <div class="form-group">
                                        <label for="apply_name">{$translations.apply.name_label} <span class="required-status">*</span>:</label>
                                        <input class="form-control {if isset($smarty.section.apply_errors.apply_name) && $smarty.session.apply_errors.apply_name}error"{/if} type="text" name="apply_name" id="apply_name" maxlength="50" size="30" value="{(isset($smarty.session.apply_fields)) ? $smarty.session.apply_fields.apply_name:''}" />
                                        <span class="validation-error">{if isset($smarty.session.apply_errors.apply_name)}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{$smarty.session.apply_errors.apply_name}{/if}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="apply_email">{$translations.apply.email_label} <span class="required-status">*</span>:</label>
                                        <input class="form-control {if  $smarty.session.apply_errors.apply_email}error"{/if} type="text" name="apply_email" id="apply_email" maxlength="50" size="30" value="{(isset($smarty.session.apply_fields))?$smarty.session.apply_fields.apply_email:''}" />
                                        <span class="validation-error">{if  isset($smarty.session.apply_errors.apply_email)}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{$smarty.session.apply_errors.apply_email}{/if}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="apply_msg">{$translations.apply.message_label} <span class="required-status">*</span>:</label>
                                        <textarea name="apply_msg" class="form-control {if $smarty.session.apply_errors.apply_msg}error"{/if}  id="apply_msg" cols="60" rows="15">{(isset($smarty.session.apply_fields)) ? $smarty.session.apply_fields.apply_msg:''}</textarea>
                                        <span class="validation-error">{if isset($smarty.session.apply_errors.apply_msg)}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{$smarty.session.apply_errors.apply_msg}{/if}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="apply_cv">{$translations.apply.cv_label}</label>
                                        <input class="input-type" type="file" name="apply_cv" id="apply_cv"/>
                                        <span class="validation-error">{if  $smarty.session.apply_errors.apply_cv}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" title="{$smarty.session.apply_errors.apply_cv}" />{$smarty.session.apply_errors.apply_cv}{/if}</span>
                                        <p class="f12 gray">{$translations.apply.cv_info}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="apply_cv">Anti-Spam <span class="required-status">*</span></label>
                                        {literal}
                                            <script type="text/javascript">
                                                var RecaptchaOptions = {
                                                    theme : 'custom',
                                                    custom_theme_widget: 'responsive_recaptcha'
                                                };
                                            </script>
                                        {/literal}
                                        {$the_captcha} <span class="validation-error">{if isset($smarty.session.apply_errors.captcha)}
											<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /> {$smarty.session.apply_errors.captcha}{/if}</span>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" id="submit" class="btn bg4cb3ad" value="{$translations.apply.submit}" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {/if}
                </div>
            </div>
        </section>
    </div>
    <style>
        #apply_cv-error{
            color: red;
        }
    </style>
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <script>

        $( "#frm-apply-online" ).validate({
            rules: {
                apply_cv: {
                    required: false,
                    extension: "pdf|rtf|doc|odt"
                }
            }
        });
    </script>

    <script>

        $.fn.scrollView = function () {
            return this.each(function () {
                $('html, body').animate({
                    scrollTop: $(this).offset().top - 150
                }, 1000);
            });
        };
        //Apply form
        $('.btnApplyNow').click(function (e) {
            e.preventDefault();
            $('.frmApplyNow').slideToggle();
            $('#apply-now-form').scrollView();
        });
        //
        $(".carousel-control").on('click', function () {
            $('#myCarousel').carousel("pause");
        });

            {if isset($smarty.session.apply_successful) AND $smarty.session.apply_successful eq -1}
            if (document.getElementById("apply_name"))
            {
                $('#apply-now-form').scrollView();
                document.getElementById("apply_name").focus();
            }
            {/if}

    </script>
{/block}