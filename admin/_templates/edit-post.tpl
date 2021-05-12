{include file="header_jquery_update.tpl"}

<div id="content">
	<h2 id="search-result" style="display:none;">Search Result</h2>
	<div id="job-listings"></div><!-- #job-listings --><br />
	<h2 id="edit_job">{if $job.id == 0}Post a job{else}Edit a job{/if}</h2>

	{if $filter_error}
		<div class="fail">
			{$filter_error}
		</div>
	{/if}
	{if $errors}
		<div class="fail">
			{$translations.publish.form_error}
		</div>
	{/if}

	{if $show_preview}
		{include file="edit-post-preview.tpl"}
	{/if}

	<form id="publish_form" method="post" action="{$BASE_URL_ADMIN}edit-post/{if $job.id neq 0}{$job.id}/{/if}" enctype="multipart/form-data">

		<div class="clearfix">
			<div class="left span2 block">
				<h3>Job Details</h3>
				<div id="job_details" class="block_inner">
					<div class="group">
						<label for="">Nationality of an applicant</label>
						{foreach from=$nationalities key=index item=nationality}
							<input class="no-border" type="radio" name="nationality" id="nationality" value="{$index}" {if isset($job) && $index == $job.nationality} checked {/if}> {$nationality}
						{/foreach}
					</div>
					<div class="group clearfix category">
						<label>Job Type</label>
						{section name=tmp2 loop=$types}
							<div>
								<label for="type_id_{$types[tmp2].id}">
									<input class="no-border" type="radio" name="type_id" id="type_id_{$types[tmp2].id}" value="{$types[tmp2].id}" {if !$job.type_id && !$smarty.post.type_id}{if $types[tmp2].id == 1}checked="checked"{/if}{else}{if $types[tmp2].id == $job.type_id}checked="checked"{/if}{if $types[tmp2].id == $smarty.post.type_id}checked="checked"{/if}{/if} />
									<img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$types[tmp2].var_name}.png" alt="{$types[tmp2].name}" />
								</label>
							</div>
						{/section}
					</div>
					<div class="group">
						<label>Category</label>
						<select name="category_id" id="category_id" class="ml1">
							{section name=tmp1 loop=$categories}
								<option value="{$categories[tmp1].id}" {if $default_categ_id != '' && $default_categ_id == $categories[tmp1].id}selected="selected"{else}{if $categories[tmp1].id == $job.category_id}selected="selected"{/if}{if $categories[tmp1].id == $smarty.post.category_id}selected="selected"{/if}{/if}>{$categories[tmp1].name}</option>
							{/section}
						</select>
					</div>
					<div class="group{if $errors.title} error{/if}">
						<label for="title">{$translations.publish.title_label}</label>
						<input type="text" name="title" id="title" size="50" value="{if $job.title}{$job.title|escape}{else}{$smarty.post.title|escape}{/if}" />
						<div class="">{$translations.publish.title_info}</div>
					</div>

					<div class="group{if $errors.details} error{/if}">
						<label for="details">{$translations.publish.details}</label>
						<input type="text" name="details" id="details" size="50" value="{if $job.details}{$job.details|escape}{else}{$smarty.post.details|escape}{/if}" />
						<div class="">{$translations.publish.details_info}</div>
					</div>
					<div class="group{if $errors.address} error{/if}">
						<label for="address">{$translations.publish.address}</label>
						<input type="text" style="width: 500px;" name="address" id="address" size="100" value="{if $job.address}{$job.address|escape}{else}{$smarty.post.address|escape}{/if}" />
						<div class="">{$translations.publish.address_info}</div>
					</div>
                    <div class="group">
                        <div id="map-canvas">
                            <div class="showmap">
                                <p>Please click button and Check the map.</p>
                                <span id="check_address" class="btn-showmap">Ｓｈｏｗ　ｔｈｅ　Ｍａｐ</span>
                            </div>
                        </div>
                    </div>
					<div class="group{if $errors.requ} error{/if}">
						<label for="requ">{$translations.publish.requ}</label>
						<input type="text" name="requ" id="requ" size="50" value="{if $job.requ}{$job.requ|escape}{else}{$smarty.post.requ|escape}{/if}" />
						<div class="">{$translations.publish.requ_info}</div>
					</div>
					<div class="group{if $errors.wage} error{/if}">
						<label for="wage">{$translations.publish.wage}</label>
						<input type="text" name="wage" id="wage" size="50" value="{if $job.wage}{$job.wage|escape}{else}{$smarty.post.wage|escape}{/if}" />
						<div class="">{$translations.publish.wage_info}</div>
					</div>
                    <div class="group{if $errors.date_end} error{/if}">
                        <label for="wage">{$translations.jquery.date_end}</label>
                        <input type="text" name="date_end" size="50" readonly  id="datepicker" value="{if $job.date_end}{$job.date_end|escape}{else}{$smarty.post.date_end|escape}{/if}"/> <img id="delete_img" src="{$BASE_URL}_templates/{$THEME}/img/x.png" onclick="jQuery('#datepicker').val('')" >
                    </div>
					<div class="group{if $errors.description} error{/if}">
						<label for="description">{$translations.publish.description_label}</label>
						<textarea name="description" id="description" class="mceEditor" cols="80" rows="15">{if $job.description}{$job.description}{else}{$smarty.post.description}{/if}</textarea>
						<div class="suggestion">
							<a target="_blank" href="http://www.textism.com/tools/textile/" onclick="$('#textile-suggestions').toggle(); return false;">{$translations.publish.description_info}</a>
						</div>
						<div id="textile-suggestions" style="display: none;">
							<table>
								<thead>
								<tr class="odd">
									<th>{$translations.publish.syntax}</th>
									<th>{$translations.publish.result}</th>
								</tr>
								</thead>
								<tbody>
								<tr class="even">
									<td>That is _incredible_</td>
									<td>That is <em>incredible</em></td>

								</tr>
								<tr class="odd">
									<td>*Indeed* it is</td>
									<td><strong>Indeed</strong> it is</td>
								</tr>
								<tr class="even">
									<td>"Wikipedia":http://www.wikipedia.org</td>

									<td><a href="http://www.wikipedia.org">Wikipedia</a></td>
								</tr>
								<tr class="odd">
									<td>* apples<br />* oranges<br />* pears</td>
									<td>

										<ul>
											<li>apples</li>
											<li>oranges</li>
											<li>pears</li>
										</ul>
									</td>
								</tr>

								<tr class="even">
									<td># first<br /># second<br /># third</td>
									<td>
										<ol>
											<li>first</li>
											<li>second</li>

											<li>third</li>
										</ol>
									</td>
								</tr>
								</tbody>
							</table>
						</div><!-- #textile-suggestions -->
                        <div class="group{if $errors.file} error{/if}" id="upload_image">
                            <label>{$translations.jquery.images} </label>
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
                            <p id="psubmit_upload"> <input type="button"  id="add_more" num="" class="upload clear" value="{$translations.jquery.add_image}"/> </p>
                        </div>
					</div>
				</div>
			</div>

			<div id="company_info" class="left span1 block last">
				<h3>{$translations.publish.company}</h3>
				<div class="block_inner">
					<div class="group{if $errors.company} error{/if}">
						<label for="company">{$translations.publish.name_label}</label>
						<input type="text" name="company" id="company" size="30" value="{if $job.company}{$job.company|escape}{else}{$smarty.post.company|escape}{/if}" />
					</div>

					<div class="group">
						<label for="url">{$translations.publish.website_label}</label>
						<em>http://</em><input type="text" name="url" id="url" size="25" value="{if $job.company}{$job.url}{else}{$smarty.post.url}{/if}" />
						<div class="suggestion">{$translations.publish.website_info}</div>
					</div>

					<div class="group{if $errors.poster_email} error{/if}">
						<label for="poster_email">{$translations.publish.email_label} <span class="light">({$translations.publish.email_info1})</span></label>
						<input type="text" name="poster_email" id="poster_email" size="30" value="{if $job.poster_email}{$job.poster_email}{else}{$smarty.post.poster_email}{/if}" />
						<div class="suggestion">{$translations.publish.email_info2}</div>
					</div>

					<div class="group">
						<label for="apply_online">Allow online applications
							<input type="checkbox" name="apply_online" id="apply_online" class="no-indent" {if $job.apply_online == 1 || $job.id == 0}checked="checked"{/if}{if !isset($job.apply_online)}checked="checked"{/if} /></label><span class="suggestion">If you are unchecking this, then add a description on how to apply online!</span>
					</div>

					<div class="group_submit">
						<button type="button" id="preview" class="gray"><span>Preview</span></button>
                        <input type='hidden' name='continents' value="{$job.continents_id}">
                        <input type='hidden' name='country' value="{$job.country_id}">
                        <input type='hidden' name='area' value="{$job.area_id}">
                        <input type='hidden' name='prefectures' value="{$job.prefectures}">
						<button type="submit" id="save"><span>{if $job.id == 0}Post job{else}Save changes{/if}</span></button>
						<input type="hidden" name="show_preview" id="show_preview" value="false" />
						<input type="hidden" name="job_id" value="{$job.id}" />
					</div>
				</div>
			</div>
	</form>
</div><!-- /content -->

<script src="{$BASE_URL}js/continents.js" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry,places&language=en"></script>
{literal}
    <style> .error_b{border: 1px solid #ff0000}</style>
    <script>
        var hasMap = false;
        function errorMessages(msg){
            return '<span class="validation-error"><img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />'+msg+'</span>';
        }
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
	<script type="text/javascript">
		$(document).ready(function()
		{
			$('#type_id_1').focus();
            jQuery("#publish_form").submit(function(){
                RemoveError();
                var $img_error      = '<span class="validation-error"><img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" /></span>';
                var $active_error   = 1;
                var $title          = $("input[name='title']").val();
                var $address          = $("input[name='address']").val();
                var $description    = $("textarea[name='description']").val();
                var $company        = $("input[name='company']").val();
                var $poster_email   = $("input[name='poster_email']").val();
                var $tym = window.parent.tinymce.get('description').getContent();
                if($title == "" || $title == null){
                    $("input[name='title']").addClass("error");
                    $("input[name='title']").after($img_error);
                    $active_error = 0;
                }
                if($address == "" || $address == null){
                    var el = $("input[name='address']");
                    el.addClass("error");
                    el.after($img_error);
                    $active_error = 0;
                }

                if(!hasMap){
                    var el = $("#map-canvas");
                    el.addClass("map-error");
                    $active_error = 0;
                }

                if($tym == "" || $tym == null){
                    $("input[name='description']").addClass("error");
                    $("input[name='description']").after($img_error);

                    $("#tinymce-0").addClass("error_b");
                    $("#tinymce-0").after($img_error);
                    $active_error = 0;
                }
                if($company == "" || $company == null){
                    $("input[name='company']").addClass("error");
                    $("input[name='company']").after($img_error);


                    $active_error = 0;
                }
                if($poster_email == "" || $poster_email == null){
                    $("input[name='poster_email']").addClass("error");
                    $("input[name='poster_email']").after($img_error);
                    $active_error = 0;
                }else if(!isValidEmailAddress($poster_email)){
                    $("input[name='poster_email']").addClass("error");
                    $("input[name='poster_email']").after($img_error);
                    $active_error = 0;
                }
                if($active_error == 1)
                    return true;
                else {
                    $("#edit_job").after('<div class="fail">Please revise the form...</div>');
                    $("body").animate({ scrollTop: 0 }, 1000);
                    return false;
                }
            });
            function RemoveError(){
                $("input[name='title']").removeClass("error");
                $("textarea[name='description']").removeClass("error");
                $("input[name='company']").removeClass("error");
                $("input[name='poster_email']").removeClass("error");
                $("#tinymce-0").removeClass("error_b");
                $(".fail").remove();
                $(".validation-error").remove();
            }
            function isValidEmailAddress(emailAddress) {
                var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
                // alert( pattern.test(emailAddress) );
                return pattern.test(emailAddress);
            };
			/*jQuery("#publish_form").validate({
				rules: {
					company: { required: true },
					title: { required: true },
					description: { required: true },
					poster_email: { required: true, email: true }
				},
				messages: {
					company: '',
					title: '',
					location: '',
					description: '',
					poster_email: ''
				}
			});

			$('#save').bind('click', function()
			{
				$("#publish_form").submit();
			});
			$('#preview').bind('click', function()
			{
				$('#show_preview').val('true');
				$("#publish_form").submit();
			});*/
		});
	</script>
{/literal}

{include file="footer.tpl"}