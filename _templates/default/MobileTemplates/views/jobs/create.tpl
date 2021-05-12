{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
    <div class="content">
        <section class="main">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-right" style="padding: 10px;">
                        {if isset($job) && $job.auth && $job.is_active}
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="deleteConfirm('{$baseUrl}delete/{$job.id}/{$job.auth}')">delete</a>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="post-step1-page">
                <ul class="breadcrumb">
                    <li class="active">{$translations.publish.step1}</li>
                    <li>{$translations.publish.step2}</li>
                    <li>{$translations.publish.step3}</li>
                </ul>
                <form id="publish_form" method="post" action="{$baseUrl}post/" enctype="multipart/form-data">
                    <h2 class="main-title"><i class="fa fa-chevron-circle-right"></i> {$translations.publish.job_details}</h2>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <p><a href="{$baseUrl}for_employer" target="_blank" class="btn">{$translations.publish.term_title}</a></p>
                            </div>
                        </div>
                        <p class="required-status notice-require"></p>
                    </div>
                    <section class="section-zero">
                        <h2 class="title"><i class="fa fa-chevron-circle-right"></i> 利用規約<!-- 　/　Terms and conditions --></h2>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="term">
                                        <h2 class="pt0">Terms and conditions</h2>
                                        <div class="clearfix"></div>
                                        <div class="content-terms">
                                            <ul>
                                                <li>Please read the terms and conditions of this service before you post.</li>
                                                <li>The terms and conditions is written in Japanese. Even Japanese is not user's primary language, it is the user’s responsibilities to read and understand the terms and conditions of the user agreement.</li>
                                                <li>In the event of any inconsistency, conflict, ambiguity or discrepancy between the Japanese version and any other version in other languages of these terms and conditions, the Japanese version shall prevail at all times.</li>
                                                <li><strong>By using our Service, you shall be deemed to have agreed to the Terms and Conditions.</strong></li>
                                            </ul>
                                            <p>以下の利用規約を必ず確認してください。<br>
                                                <strong>この掲示板に投稿された場合、本規約に同意したものとみなします。</strong></p>
                                            <p>【JobBoard（求人掲示板）利用規約】</p>
                                            <ul class="num">
                                                <li>投稿者は、掲載内容についての一切の責任をお持ちください。<br>
                                                    掲載内容の変更・修正が必要な場合は必ず掲載者が行い、その情報掲載が不要となった場合は、すみやかに削除をお願いします。</li>
                                                <li>代理人による投稿及び、コンピュータプログラムなどによる自動投稿は禁止します。<br>
                                                    また、同一内容を投稿する場合は、以前の掲載を一度削除された上で、再度の投稿をお願いします。</li>
                                                <li>このサービスは、ワーキングホリデーの活性化の為に提供するものであるため、以下の様な掲載は禁止します。<br>
                                                    　・　公序良俗に反する内容
                                                    　・　アダルト関係、ネットワークビジネス関係の内容
                                                    　・　求職者に一方的に不利益な内容
                                                    　・　その他、当協会が不当と判断する内容
                                                </li>
                                            </ul>

                                            <ul class="num">
                                                <li>掲載内容の表示位置、順位、方法などについては投稿者が指定することは出来ません。</li>
                                                <li>当協会は求人情報に関する掲示板を運営するのみであり、実際の面談、採用に関する手続き等の斡旋、代行等は行いません。<br>
                                                    求職者との連絡、雇用に関する手続き等は、投稿者又は投稿者に準ずる者の責任において実施してください。</li>
                                                <li>当協会は、当協会の判断により掲載停止及び削除する権利を有します。<br>
                                                    また、この掲示板の全部又は一部の機能を適宜変更・廃止できるものとします。<br>
                                                    これらの事象により投稿者など、全ての利用者に生じた損害は、理由のいかんを問わず、一切の責任を負わないものとします。
                                                </li>
                                                <li>この利用規約は、当協会の判断により事前の予告なく追加・変更・削除できるものとします。<br>
                                                    また、この利用規約は日本語で作成され、日本語のみによって解釈されるものとします。
                                                </li>
                                            </ul>
                                            <p>【重要】<br>
                                                2012年2月27日より投稿された全ての掲載情報は、当協会にて内容を確認の後、Jobboard上で閲覧可能となります。<br>
                                                確認作業にお時間を頂戴する場合がありますのでご了承ください。</p>

                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <a href="#" class="btn w80p bgf1ae47 btnNextStep1 mt15">Next <i class="fa fa-angle-double-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="section-one">
                        <div class="container">
                            <div class="block clearfix notBold">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for=""><strong>Nationality of an applicant</strong></label>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label><input type="radio" name="nationality" value="2" {if isset($job) && $job.nationality == 2 || !isset($job)}checked{/if}> <span class="line-height">Either</span></label>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <label><input type="radio" name="nationality" value="0" {if isset($job) && $job.nationality == 0}checked{/if}> <span class="line-height">Japanese</span></label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                            <label><input type="radio" name="nationality" value="1" {if isset($job) && $job.nationality == 1}checked{/if}> <span class="line-height">Not Japanese</span></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="block clearfix notBold">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for=""><strong>Work type</strong></label>
                                    </div>
                                    {section name=tmp2 loop=$types}
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label>
                                                    <input class="no-border" type="radio" name="type_id" id="type_id_{$types[tmp2].id}" value="{$types[tmp2].id}" {if isset($job) && $job.type_id == $types[tmp2].id || !isset($job) && $types[tmp2].id == 1}checked{/if} />
                                                    <span class="btn2 lb{$types[tmp2].name}">{$types[tmp2].name}</span>
                                                </label>
                                            </div>
                                        </div>
                                    {/section}
                                </div>

                            </div>
                            <div class="row mb10">
                                <div class="col-xs-12">
                                    <label for="">Category</label>
                                </div>
                                <div class="col-xs-12">
                                    <select name="category_id" id="category_id" tabindex="1">
                                        {section name=tmp1 loop=$categories}
                                            <option value="{$categories[tmp1].id}" {if isset($default_categ_id) && $default_categ_id != '' && $default_categ_id == $categories[tmp1].id}selected="selected"{else}{if isset($job) && $categories[tmp1].id == $job.category_id}selected="selected"{/if}{if isset($smarty.post.category_id) && $categories[tmp1].id == $smarty.post.category_id}selected="selected"{/if}{/if}>{$categories[tmp1].name}</option>
                                        {/section}
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input data-validationField onkeyup="checkValidation();"  placeholder="{$translations.publish.title_label} *" class="form-control {if isset($errors.title) && $errors.title}error"{/if} type="text" name="title" id="title" tabindex="2" size="50" value="{if isset($job) && $job.company}{$job.title|escape}{elseif isset($smarty.post.title)}{$smarty.post.title|escape}{/if}" />
                                        {if isset($errors.title) && $errors.title}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
                                        <p>{$translations.publish.title_info}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input placeholder="{$translations.publish.details_label}" class="form-control {if $errors.details}error"{/if} type="text" name="details" id="details" tabindex="2" size="50" value="{if isset($job) && $job.company}{$job.details|escape}{elseif isset($smarty.post.detail)}{$smarty.post.details|escape}{/if}" />
                                        {if isset($errors) && $errors.details}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
                                        <p>{$translations.publish.details_info}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input data-validationField onkeyup="hasMap=false;checkValidation();" placeholder="{$translations.publish.address_label} *" class="form-control {if isset($errors) && $errors.address}error"{/if} type="text" name="address" id="address" tabindex="2" value="{if isset($job) && $job.company}{$job.address|escape}{elseif isset($smarty.post.address)}{$smarty.post.address|escape}{/if}" required/>
                                        <p>{$translations.publish.address_info}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb10">
                                <div class="col-xs-12">
                                    <div id="map-canvas" class="box-map">
                                        <p>Please click button and Check the map.</p>
                                        <a id="check_address" class="btn btnMap"><i class="fa fa-map-marker"></i> Show the map</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input placeholder="{$translations.publish.requ_label}" class="form-control {if isset($errors) && $errors.requ}error"{/if} type="text" name="requ" id="requ" tabindex="2" size="50" value="{if isset($job) && $job.company}{$job.requ|escape}{elseif isset($smarty.post.requ)}{$smarty.post.requ|escape}{/if}" />
                                        {if isset($errors) && $errors.requ}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
                                        <p>{$translations.publish.requ_info}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input placeholder="{$translations.publish.wage_label}" class="form-control {if isset($errors) && $errors.wage}error"{/if} type="text" name="wage" id="wage" tabindex="2" size="50" value="{if isset($job) && $job.company}{$job.wage|escape}{elseif isset($smarty.post.wage)}{$smarty.post.wage|escape}{/if}" />
                                        {if isset($errors) && $errors.wage}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
                                        <p>{$translations.publish.wage_info}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input placeholder="{$translations.jquery.date_end}" class="form-control" type="text" name="date_end" readonly  id="datepicker" value="{if isset($job) && $job.date_end !='0000-00-00 00:00:00' && $job.date_end }{$job.date_end|escape}{elseif isset($smarty.post.date_end)}{$smarty.post.date_end|escape}{/if}"/>
                                        <img id="delete_img" src="{$BASE_URL}_templates/{$THEME}/img/x.png" onclick="jQuery('#datepicker').val('')" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <textarea placeholder="{$translations.publish.description_label} *" class="mceEditor form-control {if isset($errors) && $errors.description}error"{/if} tabindex="4" name="description" id="description" cols="80" rows="15">{if isset($job) && $job.company}{$job.description}{elseif isset($smarty.post.description)}{$smarty.post.description}{/if}</textarea>
                                        {if isset($errors) && $errors.description}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
										<div class='regulative_des'>
											<p> 【求人投稿時の注意】 </p>
											<p> 
												Description等に連絡用メールアドレスや電話番号を記載されますと、無断転用される恐れがあります。個人・法人に関わらず、メールアドレスや電話番号等の情報はDescription等には記載しないようお願致します。
												次ページの「Allow Online Applications」にチェックを入れて頂くと、メールアドレスを公開することなくオンライン上で応募を受けることができます。ご活用ください。
											</p>
											<p>【Caution about description】 </p>
											<p>	
												Do not place your e-mail address, phone number or any personal information on description. It might cause leak or divert of　your private information.
												If you check “Allow Online Applications” at next, you will receive applications online via Job Board without publishing your e-mail address.
											</p>
										</div>
									</div>
                                </div>
                            </div>
							
                        </div>
                        <div class="container borb">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <a href="#" class="btn w80p bgf1ae47 btnPrevious-sectionZero"><i class="fa fa-angle-double-left"></i> Previous</a>
                                </div>

                                <div class="col-xs-6 text-center">
                                    <a href="#" class="btn w80p bgf1ae47 btnNext" {if !isset($job)}disabled{/if}>Next <i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="section-two">
                        <h2 class="title"><i class="fa fa-chevron-circle-right"></i> Images</h2>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    - {$translations.upload.note_maxsize} <br>
                                    - {$translations.upload.note_width_height}<br>
                                    - {$translations.upload.note_typeimg}<br>
                                    <hr>
                                    <p class="validation-error clear">{if isset($errors) && $errors.file}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{$errors.file}{/if}</p>
                                    <div id="upload_image">
                                        <input type="hidden" name="delete_img" value="">
                                        {if isset($job) && $job.image1 && $job.image1 != "NULL"}
                                            <div id="filediv" class="iupload {$job.class_image}">
                                                <div id="abcd1" class="abcd" del="image1">
                                                    <img id="previewimg1" src="{$BASE_URL}{$job.image1}" alt="delete">
                                                    <input name="file[]" type="file" id="file" class="valid" style="display: none;">
                                                </div>
                                            </div>
                                        {/if}
                                        {if isset($job) && $job.image2 && $job.image2 != "NULL"}
                                            <div id="filediv" class="iupload {$job.class_image}">
                                                <div id="abcd2" class="abcd" del="image2" >
                                                    <img id="previewimg2" src="{$BASE_URL}{$job.image2}" alt="delete">
                                                    <input name="file[]" type="file" id="file" class="valid" style="display: none;">
                                                </div>
                                            </div>
                                        {/if}
                                        {if isset($job) && $job.image3 && $job.image3 != "NULL"}
                                            <div id="filediv" class="iupload {$job.class_image}">
                                                <div id="abcd3" class="abcd" del="image3">
                                                    <img id="previewimg3" src="{$BASE_URL}{$job.image3}" alt="delete">
                                                    <input name="file[]" type="file" id="file" class="valid" style="display: none;">
                                                </div>
                                            </div>
                                        {/if}
                                        {if isset($job) && !$job.image1 && !$job.image2 && !$job.image3 }
                                            <div id="filediv" class="iupload {$job.class_image}"><input name="file[]" type="file" id="file"/></div>
                                        {/if}
                                        <div class="clear add_more"></div>
                                        <p id="psubmit_upload"> <input type="button" {if isset($job) && $job.count_image >= 3} style="display:none" {/if}  id="add_more" class="upload clear" value="{$translations.jquery.add_image}"/> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2 class="title"><i class="fa fa-chevron-circle-right"></i> {$translations.publish.company}</h2>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input placeholder="{$translations.publish.name_label} *" class="form-control {if isset($errors) && $errors.company}error"{/if} tabindex="6" type="text" name="company" id="company" value="{if isset($job) && $job.company}{$job.company|escape}{elseif isset($smarty.post.company)}{$smarty.post.company|escape}{/if}" />
                                        <span class="validation-error">{if isset($errors) && $errors.company}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{/if}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="{$translations.publish.website_label} http://" tabindex="7" type="text" name="url" id="url" value="{if isset($job) && $job.company}{$job.url}{elseif isset($smarty.post.url)}{$smarty.post.url}{/if}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group mb0">
                                        <input placeholder="{$translations.publish.email_label} *" class="form-control {if isset($errors) && $errors.poster_email}error"{/if} tabindex="8" type="text" name="poster_email" id="poster_email" size="40" value="{if isset($job) && $job.poster_email}{$job.poster_email}{elseif isset($smarty.post.poster_email)}{$smarty.post.poster_email}{/if}" />
                                        <span class="validation-error">{if isset($errors) && $errors.poster_email}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{/if}</span>
                                        <p class="mb0">{$translations.publish.email_info2}</p>
                                    </div>
                                </div>
                            </div>
							<div class="box-allow">
								<label><input type="checkbox" name="apply_online" id="apply_online" class="no-border" {if isset($job) && $job.apply_online == 1 || isset($is_apply) && $is_apply == 1}checked="checked"{/if}{if !isset($job) && !isset($is_apply)}checked="checked"{/if} /> <strong>{$translations.publish.apply_online}</strong></label>
							</div>
                            <div class="row">
                                <div class="col-xs-12">
                                    {if $ENABLE_RECAPTCHA}
                                    {literal}
                                        <script type="text/javascript">
                                            var RecaptchaOptions = {
                                                theme : 'custom',
                                                custom_theme_widget: 'responsive_recaptcha'
                                            };
                                        </script>
                                    {/literal}
                                        {$the_captcha} <span class="validation-error">{if isset($errors.captcha)}
					                        <img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /> {$errors.captcha}{/if}</span>
                                    {/if}
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="container borb">
                            <div class="row">
                                <div class="col-xs-6 mb15">
                                    <a class="btn w80p bgf1ae47 btnPrevious"><i class="fa fa-angle-double-left"> Previous</i></a>
                                </div>
                                <div class="col-xs-6">
                                    <input class="btn w80p bgf1ae47" type="submit" name="submit" id="submit" value="{$translations.publish.step1_submit}" />
                                </div>
                            </div>
                        </div>
                    </section>

                    <input type="hidden" name="action" {if isset($job) && $job.id }value="edit"{else}value="publish"{/if} />
                    <input type='hidden' name='continents' value="{(isset($job)) ? $job.continents_id:''}">
                    <input type='hidden' name='country' value="{(isset($job)) ? $job.country_id:''}">
                    <input type='hidden' name='area' value="{(isset($job)) ? $job.area_id:''}">
                    <input type='hidden' name='prefectures' value="{(isset($job)) ? $job.prefectures:''}">
                    {if isset($smarty.section.later_edit) && $smarty.session.later_edit}<input type="hidden" name="auth" value="{$smarty.session.later_edit}" />{/if}
                    {if isset($job) && $job.id}<input type="hidden" name="job_id" value="{$job.id}" />{/if}
                </form>
            </div>
        </section>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry,places&language=en"></script>
    <script src="{$BASE_URL}js/continents.js" type="text/javascript"></script>
{literal}
    <style>
        .error_b{border: 1px solid #ff0000}.ui-datepicker-year,.ui-datepicker-month{color:#333;}
        .ui-datepicker-trigger{
            position: absolute;
            top: 5px;
            right: 45px;
        }
        #delete_img{
            position: absolute;
            top: 7px;
            right: 18px;
            cursor: pointer;
        }
    </style>
    <script>

        function deleteConfirm(url){
            if(confirm("DO YOU WANT TO DELETE THIS JOB?"))
            {
                window.location.href = url;
            }
            else
                return false;
        }

        var hasMap = false;

        function enableElement(el){

            $(el).attr('disabled',false);

        }

        function disableElement(el){
            $(el).attr('disabled',true);
        }
        function checkValidation(){
            var validationFields = $('input[data-validationField]');
            var step1IsValidation = false;
            var count =0;
            $.each(validationFields,function(key, el){
                if(el.value !='')
                    count++;
                else{
                    count--;
                }
            });

            var content = tinyMCE.activeEditor.getContent();
            if(content !=''){
                count++;
            }else{
                count--;
            }

            if(hasMap)
                count++;
            else
                count--;
            console.log(count);
            if(count == 4){
                enableElement('.btnNext');
            }else {
                disableElement('.btnNext');
            }
        }

        function hideNoticeRequireFieldOnFirstStep(display) {
            var noticeRequire = $('p.notice-require');
            var sectionZerro   = $('section.section-zero');
            if (sectionZerro.is(':visible')) {
                noticeRequire.html('');
            } else if (display === true){
                noticeRequire.html('<strong>Fields marked with asterisk (*) are mandatory</strong>');
            }
        }
        //when customer change their mine when posting a job
        {/literal}
        {if isset($job) }
        $('.section-zero').hide();
        $('.section-one').slideToggle();
        $('.section-two').hide();
        hideNoticeRequireFieldOnFirstStep(true);
        scrollToTop();

        {/if}
        {literal}
        //show the step when errors appear

        switch ({/literal}{$errorsStep}{literal}){

            case 0:
                break;
            case 1:
                hideNoticeRequireFieldOnFirstStep(true);
                break;
            case 2:
                $('.section-one').hide();
                $('.section-zero').hide();
                $('.section-two').slideToggle();
                hideNoticeRequireFieldOnFirstStep(true);
                scrollToTop();
                break;
        }

        $('.btnNextStep1').click(function (e) {
            e.preventDefault();
            $('.section-one').slideToggle();
            $('.section-zero').hide();
            $('.section-two').hide();
            hideNoticeRequireFieldOnFirstStep(true);
            scrollToTop();
        });

        $('.btnPrevious-sectionZero').click(function (e) {
            e.preventDefault();
            $('.section-zero').slideToggle();
            $('.section-one').hide();
            $('.section-two').hide();
            hideNoticeRequireFieldOnFirstStep(false);
            scrollToTop();
        });
        $('.btnPrevious').click(function (e) {
            e.preventDefault();
            $('.section-zero').hide();
            $('.section-one').slideToggle();
            $('.section-two').hide();
            hideNoticeRequireFieldOnFirstStep(true);
            scrollToTop();
        });
        $('.btnNext').click(function (e) {
            e.preventDefault();
            $('.section-one').hide();
            $('.section-zero').hide();
            $('.section-two').slideToggle();
            hideNoticeRequireFieldOnFirstStep(true);
            scrollToTop();

        });

        function scrollToTop(){
            $("html, body").animate({ scrollTop: 0 }, 200);
        }

        var $url_img_delete = "{/literal}{$BASE_URL}{literal}/_templates/default/img/x.png";
        function initialize() {
            // Create the search box and link it to the UI element.
            var input = (document.getElementById('address'));
            var searchBox = new google.maps.places.SearchBox((input));
            var job_id = "{/literal}{if !empty($job.id)}{$job.id}{/if}{literal}";
            var post_error = "{/literal}{if !empty($errors)}1{/if}{literal}";
            if (job_id != ''|| post_error != '') {
                var address = (document.getElementById('address').value);
                displayMapAddress(address);
            }
        }
        google.maps.event.addDomListener(window, 'load', initialize);
        /*Checker display Map*/
        function displayMapAddress(address) {
            $('#map-canvas').removeClass('map-error');
            var nextEl = $('#map-canvas').next();
            if(nextEl.hasClass('validation-error'))
                nextEl.remove();
            var localSearch = new google.maps.Geocoder();
            localSearch.geocode({ 'address': address },
                    function(results, status) {
                        console.log(results);
                        if (results.length > 0) {
                            hasMap = true;
                            var nextEl = $('#map-canvas').next();
                            if(nextEl.hasClass('validation-error'))
                                nextEl.remove();
                            checkValidation();

                            var places = results;
                            var markers = [];
                            var map_location = new google.maps.LatLng(35.693165, 139.698817);
                            var mapOptions = {
                                zoom: 16,
                                center: map_location,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            };
                            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions );
                            if (places.length == 0) {
                                return;
                            }


                            for (var i = 0, marker; marker = markers[i]; i++) {
                                marker.setMap(null);
                            }
                            // For each place, get the icon, place name, and location.
                            markers = [];
                            var bounds = new google.maps.LatLngBounds();
                            for (var i = 0, place; place = places[i]; i++) {

                                // Create a marker for each place.
                                var marker = new google.maps.Marker({
                                    zoom: 16,
                                    map: map,
                                    title: place.formatted_address,
                                    position: place.geometry.location
                                });

                                markers.push(marker);
                                bounds.extend(place.geometry.location);
                            }
                            google.maps.event.addListener(map,'center_changed',function() {
                                window.setTimeout(function() {
                                    map.panTo(marker.getPosition());
                                },3000);
                            });
                            google.maps.event.addListenerOnce(map, 'zoom_changed', function() {
                                map.setZoom(16); //Or whatever
                                map.initialZoom = false;
                            });
                            map.fitBounds(bounds);

                            /*get info address*/
                            if (results[0].address_components != undefined && $.isArray(results[0].address_components)) {
                                var address_components = results[0].address_components;

                                var continents = '', country = '', area = '', prefectures = '';
                                for (var i = 0, components; components = address_components[i]; i++) {
                                    var types = components.types;
                                    if (compareArray(types , ["country", "political"])) {
                                        continents =continents_list[components.short_name];
                                        country = components.long_name;
                                    }
                                    if (compareArray(types, ["administrative_area_level_1", "political"])) {
                                        area = components.short_name ;
                                    }
                                    if (compareArray(types, ["locality", "political"])) {
                                        prefectures = components.long_name ;
                                    }


                                }
                                $('input[name="continents"]').val(continents);
                                $('input[name="country"]').val(country);
                                $('input[name="area"]').val(area);
                                $('input[name="prefectures"]').val(prefectures);

                            }
                            $('#map-canvas').removeClass('map-error');

                        }
                        else
                        {
                            var html = '<div class="showmap"><p>Please click button and Check the map.</p>'
                                    + '<a id="check_address" class="btn btnMap"><i class="fa fa-map-marker"></i> Show the map</a></div>';
                            $('#map-canvas').addClass('map-error').html(html);
                            hasMap = false;
                            $('#map-canvas').after(errorMessages('Your map does not exist, please check again!'));
                            checkValidation();

                        }
                    });


        }

        function compareArray(array1, array2)
        {
            if (!array1 && !array2) {
                return false;
            }
            if (array1.length !== array2.length) {
                return false;
            }
            if (array1.join('|') === array2.join('|')) {
                return true;
            } else {
                return false;
            }

        }

        $('#address').keyup(function() {
            var html = '<p>Please click button and Check the map.</p>'
                    + '<a id="check_address" class="btn btnMap"><i class="fa fa-map-marker"></i> Show the map</a>';
            $('#map-canvas').removeClass('map-error').html(html);
        });
        $('body').on('click', '#check_address', function(){
            var loading = '<div class="loading">'
                    + '<img src="{/literal}{$BASE_URL}{literal}_templates/{/literal}{$THEME}{literal}/img/loading.gif"/>'
                    + '<p>Please wait...</p>'
                    + '</div>';
            $('#map-canvas').html(loading);
            var address = document.getElementById('address').value;
            setTimeout(function(){
                displayMapAddress(address);
            },1200);



        });


    </script>
    <script type="text/javascript" src="{/literal}{$BASE_URL}{literal}js/tinymce/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="{/literal}{$BASE_URL}{literal}js/tinymce-placeholder.js"></script>
    <script language="javascript" type="text/javascript">
        tinymce.init({
            mode : "textareas",
            editor_selector : "mceEditor",
            plugins: [ "placeholder" ],
            toolbar: false,
            menubar: false,
            statusbar: false,
            height: "200px",
            width: "100%",
            setup : function(ed) {
                ed.on('focus', function(e) {
                    $('#ui-datepicker-div').css('display','none');
                });
                ed.on('keyUp', function(e) {
                    checkValidation();
                });
            }
        });

    </script>
    <script type="text/javascript">
        function errorMessages(msg){
            return '<span class="validation-error"><img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />'+msg+'</span>';
        }

        $(document).ready(function()
        {
            var $active_cap     = 1;
            $('#datepicker').click(function() {
                $('#ui-datepicker-div').css('display','block');
            });
            $( "#datepicker" ).datepicker({
                dateFormat:'d MM yy',
                showOn: "both",
                buttonImageOnly: true,
                buttonImage: "{/literal}{BASE_URL}{literal}_templates/default/img/icon_date_picker_24.gif",
                buttonText: "Calendar",
                changeMonth: true,
                changeYear:true,
                currentText: "Now",
                minDate: "today"
            });
            $('#title').focus();

            $('#submit').click(function()
            {
                tinyMCE.triggerSave();
            });
            jQuery("#publish_form").submit(function(){
                RemoveError();
                var $img_error      = '<span class="validation-error"><img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" /></span>';
                var $active_error   = 1;
                var $title          = $("input[name='title']").val();
                var $description    = $("textarea[name='description']").val();
                var $company        = $("input[name='company']").val();
                var $poster_email   = $("input[name='poster_email']").val();
                /*var $tym = window.parent.tinymce.get('description').getContent();*/
                if($title == "" || $title == null){
                    $("input[name='title']").addClass("error");
                    $("input[name='title']").after($img_error);
                    $active_error = 0;
                }
                if($description == "" || $description == null){
                    $("input[name='description']").addClass("error");
                    $("input[name='description']").after($img_error);

                    $("#tinymce-0").addClass("error_b");
                    $("#tinymce-0").after($img_error);
                    $active_error = 0;
                }
                if($company == "" || $company == null){
                    $("input[name='company']").addClass("error");
                    $("input[name='company']").after(errorMessages('Company name field is required'));
                    $active_error = 0;
                }

                if($poster_email == "" || $poster_email == null){
                    $("input[name='poster_email']").addClass("error");
                    $("input[name='poster_email']").after(errorMessages('Email field is required'));
                    $active_error = 0;
                }else if(!isValidEmailAddress($poster_email)){
                    $("input[name='poster_email']").addClass("error");
                    $("input[name='poster_email']").after(errorMessages('Invalid email'));
                    $active_error = 0;
                }

                if($active_error == 1) {
                    if($active_cap == 1) {
                        var $ajax = null;
                        if($ajax != null)
                            $ajax.abort();
                        $ajax = $.ajax({
                            url: $(this).attr("action"),
                            type: "POST",
                            data: {
                                recaptcha_response_field: $('#recaptcha_response_field').val(),
                                recaptcha_challenge_field: $('#recaptcha_challenge_field').val()
                            },
                            success: function (result) {
                                if (result != 'null') {
                                    $(".capcha").addClass("error");
                                    $(".capcha").after(errorMessages(result));
                                    $(".validation-error").css("color","#F51010").css('margin-bottom','10px').css('display','block');
                                    $active_error = 0;
                                    $active_cap = 1;
                                    Recaptcha.reload();
                                } else {
                                    $active_error = 1;
                                    $active_cap = 0;
                                    jQuery("#submit").trigger('click');
                                }
                            }
                        });
                    }
                    if($active_cap == 0){
                    return true;
                    }else{
                        return false;
                    }
                }
                else {
                    $(".validation-error").css("color","#F51010").css('margin-bottom','10px').css('display','block');
                    return false;
                }
            });
            function RemoveError(){
                $("input[name='title']").removeClass("error");
                $("textarea[name='description']").removeClass("error");
                $("input[name='company']").removeClass("error");
                $("input[name='poster_email']").removeClass("error");
                $("#tinymce-0").removeClass("error_b");
                $(".validation-failure").remove();
                $(".validation-error").remove();
            }
            function isValidEmailAddress(emailAddress) {
                var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
                // alert( pattern.test(emailAddress) );
                return pattern.test(emailAddress);
            }
        });
    </script>
    <link rel="stylesheet" href="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}MobileTemplates/css/jquery_upload.css">
    <script src="{/literal}{$BASE_URL}{literal}js/jquery_upload.js"></script>
{/literal}
{/block}