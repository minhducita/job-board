			<div id="job-details" style="position: relative">
				<div class="job-details-id">
					<span class="job-id-label">Job ID</span> <span class="job-id">{$job.id}</span>
				</div>
				{if $job.days_old > 40}
				<div id="old-ad">
					This job ad has been posted over 40 days ago...
				</div>
				{/if}
				{if $CURRENT_PAGE == $URL_JOB}
				<div id="applied-to-job">
					{$job.applied_count}
					{if $job.applied_count != 1}
					<p>applicants</p>
					{else}
					<p>applicant</p>
					{/if}
				</div>
				{/if}
				<h2>
					<img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" /> {$job.title}
				</h2>

				<p>
					<span class="fading">at</span>
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
                <br>
				<div class="image_job" style="text-align:center">
					{if $job.image1 !="NULL" && $job.image1}<a class="example-image-link" href="{$BASE_URL}{$job.image1}" data-lightbox="example-set" data-title="{$job.title}"><img src="{$BASE_URL}{$job.image1}"  alt="" /></a>{/if}
					{if $job.image2 !="NULL" && $job.image2}<a class="example-image-link" href="{$BASE_URL}{$job.image2}" data-lightbox="example-set" data-title="{$job.title}"><img src="{$BASE_URL}{$job.image2}"  alt="" /></a>{/if}
					{if $job.image3 !="NULL" && $job.image3}<a class="example-image-link" href="{$BASE_URL}{$job.image3}" data-lightbox="example-set" data-title="{$job.title}"><img src="{$BASE_URL}{$job.image3}"  alt="" /></a>{/if}
				</div>
				<div id="job-description">
				{$job.description|highlight_keywords:$smarty.session.keywords_array}
				</div><br />
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

			</div><!-- #job-details -->
