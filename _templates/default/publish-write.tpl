<!-- Nam cap nhat -->{include file="header_jquery_update.tpl"}<!-- Nam cap nhat -->
<div id="content">
	<div id="job-listings"></div><!-- #job-listings -->
	<div class="steps">
		<div id="step-1" class="step-active">
			{$translations.publish.step1}
		</div>
		<div id="step-2">
			{$translations.publish.step2}
		</div>
		<div id="step-3">
			{$translations.publish.step3}
		</div>
		<div class="clear"></div>
	</div>
	<br />
	{if $filter_error}
		<div class="validation-failure">
			<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />
			{$filter_error}
		</div>
	{/if}
	{if $errors}
		<div class="validation-failure">
			<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />
			{$translations.publish.form_error}
		</div>
	{/if}
	{php}
		global $message;

		if(!empty($message))
		{ {/php}
	<div class="validation-failure">
		<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />
		{php} echo $message; {/php}
	</div>
	{php}
		}
	{/php}
	{if $job.auth && $job.is_active}
	<div>
		<a class="btn-danger btn " href="javascript:void(0);" onclick="deleteConfirm('{$baseUrl}delete/{$job.id}/{$job.auth}')">delete</a>
	</div>
	{/if}
	<form id="publish_form" method="post" action="{$BASE_URL}post/" enctype="multipart/form-data">
		<fieldset>
			<legend>{$translations.publish.job_details}</legend>

			<div style="text-align:right; margin-right:10px;">
				<a href="/for_employer/" target="_blank">登録方法の説明などはこちら</a>
                <p style="font-weight: bold;color:red;">Fields marked with asterisk (<span class="required-status">*</span>) are mandatory</p>
			</div>

			<table border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td>Nationality of an applicant</td>
					<td>
						{foreach from=$nationalities key=index item=nationality}
							<input class="no-border" type="radio" name="nationality" id="nationality" value="{$index}" {if isset($job) && $index == $job.nationality || !isset($job)} checked {/if}> {$nationality}
						{/foreach}
					</td>

				</tr>
				<tr>
					<td>Work type</td>
					<td>
						{section name=tmp2 loop=$types}
					<input class="no-border" type="radio" name="type_id" id="type_id_{$types[tmp2].id}" value="{$types[tmp2].id}" {if !$job.type_id && !$smarty.post.type_id}{if $smarty.section.tmp2.first}checked="checked"{/if}{else}{if $types[tmp2].id == $job.type_id}checked="checked"{/if}{if $types[tmp2].id == $smarty.post.type_id}checked="checked"{/if}{/if} />
						<label for="type_id_{$types[tmp2].id}"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$types[tmp2].var_name}.png" alt="{$types[tmp2].name}" /></label>
						{/section}&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td>Category</td>
					<td>
						<select name="category_id" id="category_id" tabindex="1">
							{section name=tmp1 loop=$categories}
								<option value="{$categories[tmp1].id}" {if $default_categ_id != '' && $default_categ_id == $categories[tmp1].id}selected="selected"{else}{if $categories[tmp1].id == $job.category_id}selected="selected"{/if}{if $categories[tmp1].id == $smarty.post.category_id}selected="selected"{/if}{/if}>{$categories[tmp1].name}</option>
							{/section}
						</select>
					</td>
				</tr>
				<tr>
					<td class="publish-label" valign="top">{$translations.publish.title_label}<span class="required-status">*</span>:</td>
					<td>
						<input onkeyup="removeErrorElement(this);" {if $errors.title}class="error"{/if} type="text" name="title" id="title" tabindex="2" size="50" value="{if $job.company}{$job.title|escape}{else}{$smarty.post.title|escape}{/if}" />
						{if $errors.title}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
						<div class="">{$translations.publish.title_info}</div>
					</td>
				</tr>
				<tr>
					<td class="publish-label" valign="top">{$translations.publish.details_label}:</td>
					<td>
						<input {if $errors.details}class="error"{/if} type="text" name="details" id="details" tabindex="2" size="50" value="{if $job.company}{$job.details|escape}{else}{$smarty.post.details|escape}{/if}" />
						{if $errors.details}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
						<div class="">{$translations.publish.details_info}</div>
					</td>
				</tr>
				<tr>
					<td class="publish-label" valign="top">{$translations.publish.address_label} <span class="required-status">*</span>:</td>
					<td>
						<input onkeyup="removeErrorElement(this);" {if $errors.address}class="error"{/if} type="text" name="address" id="address" tabindex="2" size="70" value="{if $job.company}{$job.address|escape}{else}{$smarty.post.address|escape}{/if}"/>

						{if $errors.address}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
						<div class="">{$translations.publish.address_info}</div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>

						<div id="map-canvas">
                            <div class="showmap">
                            <p>Please click button and Check the map.</p>
                            <span id="check_address" class="btn-showmap">Ｓｈｏｗ　ｔｈｅ　Ｍａｐ</span>
                            </div>
                        </div>
					</td>
				</tr>
				<tr>
					<td class="publish-label" valign="top">{$translations.publish.requ_label}:</td>
					<td>
						<input {if $errors.requ}class="error"{/if} type="text" name="requ" id="requ" tabindex="2" size="50" value="{if $job.company}{$job.requ|escape}{else}{$smarty.post.requ|escape}{/if}" />
						{if $errors.requ}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
						<div class="">{$translations.publish.requ_info}</div>
					</td>
				</tr>
				<tr>
					<td class="publish-label" valign="top">{$translations.publish.wage_label}:</td>
					<td>
						<input {if $errors.wage}class="error"{/if} type="text" name="wage" id="wage" tabindex="2" size="50" value="{if $job.company}{$job.wage|escape}{else}{$smarty.post.wage|escape}{/if}" />
						{if $errors.wage}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
						<div class="">{$translations.publish.wage_info}</div>
					</td>
				</tr>
				<!-- Nam cap nhat -->
				<tr>
					<td class="publish-label" valign="top">{$translations.jquery.date_end}:</td>
					<td>
						<input type="text" name="date_end" size="50" readonly  id="datepicker" value="{if $job.date_end !='0000-00-00 00:00:00' && $job.date_end }{$job.date_end|escape}{else}{$smarty.post.date_end|escape}{/if}"/> <img id="delete_img" src="{$BASE_URL}_templates/{$THEME}/img/x.png" onclick="jQuery('#datepicker').val('')" >
					</td>

				</tr>
				<!-- Nam cap nhat -->

				<tr>
					<td valign="top">{$translations.publish.description_label} <span class="required-status">*</span>:</td>
					<td><textarea {if $errors.description}class="error"{/if} tabindex="4" name="description" id="description" class="mceEditor" cols="80" rows="15">{if $job.company}{$job.description}{else}{$smarty.post.description}{/if}</textarea>
						{if $errors.description}<span class="validation-error"><img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /></span>{/if}
					</td>
				</tr>
				<tr>
					<td></td>
					<td >
						<div class='regulative_des'>
							<p> 【求人投稿時の注意】 </p>
							<p> 
								Description等に連絡用メールアドレスや電話番号を記載されますと、無断転用される恐れがあります。個人・法人に関わらず、メールアドレスや電話番号等の情報はDescription等には記載しないようお願致します。
								下記の「Allow Online Applications」にチェックを入れて頂くと、メールアドレスを公開することなくオンライン上で応募を受けることができます。ご活用ください。
							</p>
							<p> 【Caution about description】 </p>
							<p> 
								Do not place your e-mail address, phone number or any personal information on description. It might cause leak or divert of　your private information.
								If you check “Allow Online Applications” below, you will receive applications online via Job Board without publishing your e-mail address.
							</p>
						</div>
					</td>
				</tr>
			</table>
		</fieldset>
		<!-- Nam cap nhat -->
		<fieldset id="upload_image">
			<legend>{$translations.jquery.images}</legend>
			<table border="0" cellspacing="2" cellpadding="2">
				<tr><td>
						<form enctype="multipart/form-data" action="" method="post">
							<ul>
								<li> {$translations.upload.note_maxsize} </li>
								<li> {$translations.upload.note_width_height} </li>
								<li> {$translations.upload.note_typeimg} </li>
							</ul>
							<hr/>
							<p class="validation-error clear">{if $errors.file}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{$errors.file}{/if}</p>
                            <input type="hidden" name="delete_img" value="">
                            {if $job.image1 && $job.image1 != "NULL"}
                                <div id="filediv" class="iupload {$job.class_image}">
                                    <div id="abcd1" class="abcd" del="image1">
                                        <img id="previewimg1" src="{$BASE_URL}{$job.image1}" alt="delete">
                                        <input name="file[]" type="file" id="file" class="valid" style="display: none;">
                                    </div>
                                </div>
                            {/if}
                            {if $job.image2 && $job.image2 != "NULL"}
                                <div id="filediv" class="iupload {$job.class_image}">
                                    <div id="abcd2" class="abcd" del="image2" >
                                        <img id="previewimg2" src="{$BASE_URL}{$job.image2}" alt="delete">
                                        <input name="file[]" type="file" id="file" class="valid" style="display: none;">
                                    </div>
                                </div>
                            {/if}
                            {if $job.image3 && $job.image3 != "NULL"}
                                <div id="filediv" class="iupload {$job.class_image}">
                                    <div id="abcd3" class="abcd" del="image3">
                                        <img id="previewimg3" src="{$BASE_URL}{$job.image3}" alt="delete">
                                        <input name="file[]" type="file" id="file" class="valid" style="display: none;">
                                    </div>
                                </div>
                            {/if}
                            {if !$job.image1 && !$job.image2 && !$job.image3 }
                                <div id="filediv" class="iupload {$job.class_image}"><input name="file[]" type="file" id="file"/></div>
                            {/if}
							<div class="clear add_more"></div>
							<p id="psubmit_upload"> <input type="button" {if $job.count_image >= 3} style="display:none" {/if}  id="add_more" class="upload clear" value="{$translations.jquery.add_image}"/> </p>
						</form>
					</td></tr>
			</table>
		</fieldset>
		<!-- Nam cap nhat -->
		<fieldset>
			<legend>{$translations.publish.company}</legend>
			<table border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td class="publish-label">{$translations.publish.name_label} <span class="required-status">*</span>:</td>
					<td><input onkeyup="removeErrorElement(this);" {if $errors.company}class="error"{/if} tabindex="6" type="text" name="company" id="company" size="40" value="{if $job.company}{$job.company|escape}{else}{$smarty.post.company|escape}{/if}" />
						<span class="validation-error">{if $errors.company}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{/if}</span>
					</td>
				</tr>
				<tr>
					<td valign="top">{$translations.publish.website_label}:</td>
					<td>http://<input tabindex="7" type="text" name="url" id="url" size="35" value="{if $job.company}{$job.url}{else}{$smarty.post.url}{/if}" />
						<div class="suggestion">{$translations.publish.website_info}</div>
					</td>
				</tr>
				<tr>
					<td class="publish-label">{$translations.publish.email_label} <span class="required-status">*</span><br /><strong>({$translations.publish.email_info1})</strong>:</td>
					<td>
						<input onkeyup="removeErrorElement(this);" {if $errors.poster_email}class="error"{/if} tabindex="8" type="text" name="poster_email" id="poster_email" size="40" value="{if $job.poster_email}{$job.poster_email}{else}{$smarty.post.poster_email}{/if}" />
						<span class="validation-error">{if $errors.poster_email}<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" />{/if}</span>
						<div class="suggestion">
							{$translations.publish.email_info2}
						</div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="checkbox" name="apply_online" id="apply_online" class="no-border" {if $job.apply_online == 1 || $is_apply == 1}checked="checked"{/if}{if !isset($job.apply_online) && !isset($is_apply)}checked="checked"{/if} /><label for="apply_online">{$translations.publish.apply_online}</label>
					</td>
				</tr>
			</table>
		</fieldset>

		<fieldset>
			<legend>利用規約　/　Terms and conditions</legend>

			{literal}
			<ul>
				<li>Please read the terms and conditions of this service before you post.</li>
				<li>The terms and conditions are written in Japanese. Even Japanese is not user's primary language, it is the user’s responsibilities to read and understand the terms and conditions of the user agreement.</li>
				<li>In the event of any inconsistency, conflict, ambiguity or discrepancy between the Japanese version and any other version in other languages of these terms and conditions, the Japanese version shall prevail at all times.</li>
				<li><b>By using our Service, you shall be deemed to have agreed to the Terms and Conditions.</b></li>
				&nbsp;<br/>	
				</ul>
				<style>
				
					.content2 li{list-style-type:decimal;line-height:18px;margin-bottom:5px;}
					.pmargin{ margin-top:10px !important;margin-bottom:5px !important }
					.content3 td{padding-left:15px;}
				</style>
				<ul class='content2'>
					<li>
						利用者は、本規約に同意し、自らの責任に基づき本サービスを利用するものとし、本サービスの利用に関する一切の責任を負うものとします。
					</li>
					<li >
						利用者は、Job Boardが利用者と求人者の間の仲介を行うものではないことを認識し、応募採用に関するすべての問い合わせは、各広告主に直接連絡するものとします。
					</li>
					<li >
						利用者は、当社および求人者に対し、個人情報を不備・齟齬のないよう正確に提供するものとします。利用者が提供した個人情報が正確でなかった場合等、利用者が当社および求人者に対して提供した情報内容に起因して、求人者、その他の第三者との間で紛争等が生じた場合には、利用者自身の責任においてこれに対処するものとし、当社に一切の迷惑をかけないことを保証します。
					</li>
					<li >
						利用者は、労働条件待遇等について、自らの責任に基づき、各広告主に十分な確認を行った上で応募するものとします。
					</li>
					<li >
						当社は、利用者が本サービスを利用したことにより利用者に生じた一切の精神的、財産的損害につき、何らの責任も負わないものとします。
					</li>
					<li >
						当社は、利用者と求人者との間のトラブル等について、何らの責任も負わないものとします。
					</li>
					<li >
						当社は、利用者に提供する情報のうち、企業情報等の第三者に関する情報、企業広告、求人広告その他第三者より提供される情報内容の正確性につき保証するものではありません。
					</li>
					<li >
						当社は、利用者による本サービスの利用によって、就業が成功することを保証するものではありません。
					</li>
				</ul>
				<p style="maring-top:8px;">
					以下の利用規約を必ず確認してください。<br/>
					<b>この掲示板に投稿された場合、本規約に同意したものとみなします。</b><br/>
				</p>
				【JobBoard（求人掲示板）利用規約】<br/>
				<table style="font-size:10pt; margin-left:10px; margin-top:0px;">
					<tr>
						<td style="vertical-align:top;">１．</td>
						<td>
							投稿者は、掲載内容についての一切の責任をお持ちください。掲載内容の変更・修正が必要な場合は必ず掲載者が行い、その情報掲載が不要となった場合は、すみやかに削除をお願いします。
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;">２．</td>
						<td>
							代理人による投稿及び、コンピュータプログラムなどによる自動投稿は禁止します。また、同一内容を投稿する場合は、以前の掲載を一度削除された上で、再度の投稿をお願いします。
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;">３．</td>
						<td>
							このサービスは、ワーキングホリデーの活性化の為に提供するものです。利用者は、本サービスの利用に際し、以下の行為や内容を含む広告の掲載を行ってはならないものとします。掲載されている広告が以下各号のどれか一つでも満たしていると当社が判断した場合、広告主への事前の通知なく、広告の変更・削除ができるものとします。
							<p class='pmargin'> 【不適切な内容】 </p>
							<table class='content3'>
								<tr><td style="vertical-align:top;">(1)</td><td> 虚偽または不正確な情報を含む内容</td></tr>
								<tr><td style="vertical-align:top;">(2)</td><td> 公序良俗に反する内容</td></tr>
								<tr><td style="vertical-align:top;">(3)</td><td> アダルト関係、ネットワークビジネス関係の内容</td></tr>
								<tr><td style="vertical-align:top;">(4)</td><td> 求職者に対し、一方的に不利益な内容</td></tr>
								<tr><td style="vertical-align:top;">(5)</td><td> その他、当協会が不当と判断する内容</td></tr>
							</table>
							<p class='pmargin'> 【不適切な行為】 </p>
							<table class='content3'>
								<tr><td style="vertical-align:top;">(1)</td><td> 個人や団体を誹謗、中傷、脅迫する行為、またはそのおそれのある行為</td></tr>
								<tr><td style="vertical-align:top;">(2)</td><td> 著作権、商標権、その他の知的財産権を含む他人の権利を侵害する行為、またはそのおそれのある行為</td></tr>
								<tr><td style="vertical-align:top;">(3)</td><td> 本サービスを通じて入手した情報を、複製、販売、出版その他方法の如何を問わず、私的利用の範囲を超えて利用する行為、または第三者に開示、提供する行為</td></tr>
								<tr><td style="vertical-align:top;">(4)</td><td> 本サービスを通じて入手した情報を利用して、当社もしくは第三者に対して金銭等を要求する行為、または不利益もしくは損害を与える行為</td></tr>
								<tr><td style="vertical-align:top;">(5)</td><td> 本サービスの円滑な運営を妨げる行為、または当社および求人者の信用または名誉を毀損する行為、もしくはそれらのおそれのある行為</td></tr>
								<tr><td style="vertical-align:top;">(6)</td><td> 犯罪行為、または法令に反する行為等公序良俗に反する行為、もしくはそれらのおそれのある行為</td></tr>
								<tr><td style="vertical-align:top;">(7)</td><td> 反社会的勢力等に関連する組織に属する行為、反社会的勢力に利益を与え、または利用する等不適切な関係を持つ行為、もしくはそれらのおそれのある行為</td></tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;">４．</td>
						<td>
							掲載内容の表示位置、順位、方法などについては投稿者が指定することは出来ません。
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;">５．</td>
						<td>
							当協会は求人情報に関する掲示板を運営するのみであり、実際の面談、採用に関する手続き等の斡旋、代行等は行いません。求職者との連絡、雇用に関する手続き等は、投稿者又は投稿者に準ずる者の責任において実施してください。
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;">６．</td>
						<td>
							当協会は、当協会の判断により掲載停止及び削除する権利を有します。また、この掲示板の全部又は一部の機能を適宜変更・廃止できるものとします。これらの事象により投稿者など、全ての利用者に生じた損害は、理由の如何を問わず、一切の責任を負わないものとします。
						</td>
					</tr>
				</table>
				<p style="margin-top:12px;">
					【重要】<br/>
					2012年2月27日より投稿された<b>全ての掲載情報は、当協会にて内容を確認の後、Jobboard上で閲覧可能となります。</b><br/>
					確認作業にお時間を頂戴する場合がありますのでご了承ください。<br/>
				</p>
				{/literal}
		</fieldset>

		{if $ENABLE_RECAPTCHA}
			<fieldset>
				<legend>{$translations.captcha.captcha_title}</legend>
				{literal}
					<script type="text/javascript">
						var RecaptchaOptions = {
							theme : 'white',
							tabindex : 9
						};
					</script>
				{/literal}
				{$the_captcha} <span class="validation-error">{if $errors.captcha}
					<img src="{$BASE_URL}_templates/{$THEME}/img/icon-delete.png" alt="" /> {$errors.captcha}{/if}</span>
			</fieldset>
		{/if}
		<fieldset><input type="submit" name="submit" id="submit" value="{$translations.publish.step1_submit}" /></fieldset>
		<fieldset class="hidden">
			<input type="hidden" name="action" {if $job.id }value="edit"{else}value="publish"{/if} />
			<input type='hidden' name='continents' value="{$job.continents_id}">
			<input type='hidden' name='country' value="{$job.country_id}">
			<input type='hidden' name='area' value="{$job.area_id}">
            <input type='hidden' name='prefectures' value="{$job.prefectures}">
			{if $smarty.session.later_edit}<input type="hidden" name="auth" value="{$smarty.session.later_edit}" />{/if}
			{if $job.id}<input type="hidden" name="job_id" value="{$job.id}" />{/if}
		</fieldset>
	</form>
</div><!-- /content -->

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry,places&language=en"></script>
<script src="{$BASE_URL}js/continents.js" type="text/javascript"></script>
{literal}
    <style> .error_b{border: 1px solid #ff0000}</style>
	<script>
		function deleteConfirm(url){
			if(confirm("DO YOU WANT TO DELETE THIS JOB?"))
			{
				window.location.href = url;
			}
			else
				return false;
		}

        var $url_img_delete = "{/literal}{$BASE_URL}{literal}/_templates/default/img/x.png";
		function initialize() {
			// Create the search box and link it to the UI element.
			var input = (document.getElementById('address'));
			var searchBox = new google.maps.places.SearchBox((input));
            var job_id = "{/literal}{if !empty($job.id)}{$job.id}{/if}{literal}";
			var post_error = "{/literal}{if !empty($errors)}1{/if}{literal}";
			if (job_id != '' || post_error != '') {
                var address = (document.getElementById('address').value);
                displayMapAddress(address);
            }
		}
		google.maps.event.addDomListener(window, 'load', initialize);

		/*Checker display Map*/
		function displayMapAddress(address) {

			var localSearch = new google.maps.Geocoder();
			localSearch.geocode({ 'address': address },
					function(results, status) {
                        console.log(results);
						if (results.length > 0) {
							hasMap = true;
							var places = results;
							var markers = [];
                            var map_location = new google.maps.LatLng(35.693165, 139.698817);
							var mapOptions = {
                                zoom: 16,
								center: map_location,
								mapTypeId: google.maps.MapTypeId.ROADMAP
							}
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
							var nextEl = $('#map-canvas').next();
							if(nextEl.hasClass('validation-error'))
								nextEl.remove();
						}
						else
						{
                            var html = '<div class="showmap"><p>Please click button and Check the map.</p>'
                                     + '<span id="check_address" class="btn-showmap">Ｓｈｏｗ　ｔｈｅ　Ｍａｐ</span></div>';
                            $('#map-canvas').addClass('map-error').html(html);
							$('#map-canvas').after(errorMessages('Your map does not exist, please check again!'));
							hasMap = false;

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
			hasMap = false;
            var html = '<div class="showmap"><p>Please click button and Check the map.</p>'
                     + '<span id="check_address" class="btn-showmap">Ｓｈｏｗ　ｔｈｅ　Ｍａｐ</span></div>';
            $('#map-canvas').removeClass('map-error').html(html);
			$('#map-canvas').removeClass('map-error');
			var nextEl = $('#map-canvas').next();
			if(nextEl.hasClass('validation-error'))
				nextEl.remove();
        });
        $('body').on('click', '#check_address', function(){
			$('#map-canvas').removeClass('map-error');
			var nextEl = $('#map-canvas').next();
			if(nextEl.hasClass('validation-error'))
				nextEl.remove();
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
	<script language="javascript" type="text/javascript">
		tinymce.init({
			mode : "textareas",
			editor_selector : "mceEditor",
			toolbar: false,
			menubar: false,
			statusbar: false,
			height: "200px",
			width: "100%",
			setup : function(ed) {
				ed.on('keyUp', function(e) {
					var content = tinyMCE.activeEditor.getContent();
					$("#tinymce-0").removeClass("error_b");
					var nextEl = $("#tinymce-0").next();
					if(nextEl.hasClass('validation-error'))
						nextEl.remove();
					if(content ==''){
						$("#tinymce-0").addClass("error_b");
						$("#tinymce-0").after(errorMessages('This field is required'));
					}
				});
			}
		});

	</script>
<script type="text/javascript">
	var hasMap = false;
	function errorMessages(msg){
		return '<span class="validation-error"><img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />'+msg+'</span>';
	}
	function removeErrorElement(elm){
		var el = $(elm);
		$(el).removeClass("error");
		var nextEl = $(el).next();
		if(nextEl.hasClass('validation-error'))
			nextEl.remove();
		if($(el).val() ==''){
			$(el).addClass("error");
			$(el).after(errorMessages('This field is required'));
		}
	}
	$(document).ready(function()
	{
        var $active_cap     = 1;
		$('#title').focus();

		$('#publish_form').click(function()
		{
			tinyMCE.triggerSave();
		});

        jQuery("#publish_form").on('submit',function(e){
            RemoveError();
            var $img_error      = '<span class="validation-error"><img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" /></span>';
            var $active_error   = 1;
            var $title          = $("input[name=title]").val();
            var $address          = $("input[name='address']").val();
			var $description = tinyMCE.activeEditor.getContent();
            var $company        = $("input[name='company']").val();
            var $poster_email   = $("input[name='poster_email']").val();
            var $captcha   = $("#recaptcha_response_field").val();
			var queue = [];
           /*var $tym = window.parent.tinymce.get('description').getContent();*/
            if($title == "" || $title == null){
				var el = $("input[name='title']");
                el.addClass("error");
                el.after(errorMessages('This field is required'));
                $active_error = 0;

				queue.push(el);

			}
			if($address == "" || $address == null){

				var el = $("input[name='address']");
				el.addClass("error");
				el.after(errorMessages('This field is required'));
				$active_error = 0;
				queue.push(el);
			}

			if(!hasMap){

				var el = $("#map-canvas");
				el.addClass("map-error");
				$active_error = 0;
				queue.push(el);
			}

            if($description == "" || $description == null){

				var el = $("#tinymce-0");
				el.addClass("error_b");
				el.after(errorMessages('This field is required'));
				$active_error = 0;
				queue.push(el);

            }
            if($company == "" || $company == null){

				var el = $("input[name='company']");
				el.addClass("error");
				el.after(errorMessages('This field is required'));
				$active_error = 0;
				queue.push(el);
            }

			if($captcha == "" || $captcha == null){

				var el = $("#recaptcha_widget_div");
				el.addClass("error");
				el.after(errorMessages('Incorrect captcha'));
				$active_error = 0;
				queue.push(el);
			}
            if($poster_email == "" || $poster_email == null){
				var el = $("input[name='poster_email']");
				el.addClass("error");
				el.after(errorMessages('This field is required'));
				$active_error = 0;
				queue.push(el);

            }else if(!isValidEmailAddress($poster_email)){
				var el = $("input[name='poster_email']");
				el.addClass("error");
				el.after(errorMessages('Invalid email, please check again'));
				$active_error = 0;
				queue.push(el);
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
                                var el = $("#recaptcha_widget_div");
                                el.addClass("error");
                                el.after(errorMessages(result));
                                $active_error = 0;
                                queue.push(el);
                                $active_error = 0;
                                $active_cap = 1;
                                $("#recaptcha_reload").trigger("click");
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
                $(".steps").after('<div class="validation-failure" style="margin-top:15px;"><img src="{/literal}{$BASE_URL}{literal}_templates/{/literal}{$THEME}/{literal}img/icon-delete.png" alt="" /> Please revise the form...</div>');
                var el = queue.shift();
                $('body').animate({scrollTop: el.position().top - 50});
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
        };
		/*jQuery("#publish_form").validate({
			rules: {
				type_id: { required: true },
				company: { required: true },
				title: { required: true },
				description: { required: true },
				poster_email: { required: true, email: true }
			},
			messages: {
				type_id: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
				company: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
				title: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
				location: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
				description: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
				poster_email: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />'
			}
		});*/
	});

						$( "#datepicker" ).datepicker({
							dateFormat:'d MM yy',
							showOn: "both",
							buttonImageOnly: true,
							buttonImage: "{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon_date_picker_24.gif",
							buttonText: "Calendar",
							changeMonth: true,
                            changeYear:true,
                            currentText: "Now",
                            minDate: "today"
						});
</script>
{/literal}

{include file="footer.tpl"}