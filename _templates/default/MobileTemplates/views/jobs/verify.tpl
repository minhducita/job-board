{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
    <div class="content">
        <section class="main">
            <div class="post-step2-page">
                <ul class="breadcrumb">
                    <li>Step 1: Write</li>
                    <li class="active">Step 2: Verify</li>
                    <li>Step 3: Confirm</li>
                </ul>
                <div class="container">
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
								
                                    <div class="item">
                                        <img src="{$BASE_URL}{$job.image2}" class="img-responsive"  alt="" />
                                    </div>
                                {/if}
                                {if $job.image3 !="NULL" && $job.image3}
								
                                    <div class="item">
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
                    <div class="row box-allow mt15 mb0">
                        <form name="publish_form" id="publish_form" method="post" action="{$baseUrl}publish/{$job.id}/">
                        <p>
                            {if $smarty.session.later_edit}
                                <input class="btn bg4cb3ad" type="submit" name="submit" id="submit" value="{$translations.publish.save}" />
                            {else}
                                <input class="btn bg4cb3ad" type="submit" name="submit" id="submit" value="{$translations.publish.publish}" />
                            {/if} or <a class="btn bg4cb3ad" href="{$baseUrl}post/{$job.id}/" title="{$translations.publish.edit}">{$translations.publish.edit}</a> {$translations.publish.step2_info} <a href="{$baseUrl}deactivate/{$job.id}" title="{$translations.publish.step2_cancel}">{$translations.publish.step2_cancel}</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(".carousel-control").on('click', function () {
            $('#myCarousel').carousel("pause");
        });
    </script>
{/block}