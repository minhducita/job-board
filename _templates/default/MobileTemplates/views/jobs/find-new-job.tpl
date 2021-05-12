{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
    <div class="findNewJob mt15">
        <div class="container">
            <form action="{$BASE_URL}mobile/find-new-job/" method="post">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="w-option only-one">
                            <h3>Nationality of an aplicant</h3>
                            {if !isset($request_post.nationality)}
                                <a class="btn bn single active" href="#">
                                    <span><i class="fa fa-check"></i>&nbsp;</span>Either
                                    <input type="radio" class="hidden" name="nationality" value="2" checked="checked">
                                </a>
                            {else}
                                <a class="btn bn single{if isset($request_post.nationality) && $request_post.nationality == 2 } active{/if}" href="#">
                                    <span>{if isset($request_post.nationality) && $request_post.nationality == 2 } <i class="fa fa-check"></i>&nbsp;{/if}</span>Either
                                    <input type="radio" class="hidden" name="nationality" value="2" {if isset($request_post.nationality) && $request_post.nationality == 2 } checked="checked" {/if}>
                                </a>
                            {/if}
                            <a class="btn bn single{if isset($request_post.nationality) && $request_post.nationality == 0 } active{/if}" href="#">
                                <span>{if isset($request_post.nationality) && $request_post.nationality == 0 } <i class="fa fa-check"></i>&nbsp;{/if}</span>Japanese
                                <input type="radio" class="hidden" name="nationality" value="0"  {if isset($request_post.nationality) && $request_post.nationality == 0 } checked="checked" {/if}>
                            </a>
                            <a class="btn bn single{if isset($request_post.nationality) && $request_post.nationality == 1 } active{/if}" href="#">
                                <span>{if isset($request_post.nationality) && $request_post.nationality == 1 } <i class="fa fa-check"></i>&nbsp;{/if}</span>Not Japanese
                                <input type="radio" class="hidden" name="nationality" value="1"  {if isset($request_post.nationality) && $request_post.nationality == 1 } checked="checked" {/if}>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="w-option clearfix">
                            <h3>Work type</h3>
                            {section name=tmp2 loop=$types}
                            <a class="btn bn{if isset($request_post.type_id) && in_array($types[tmp2].id, $request_post.type_id)} active {/if}" href="#">
                                <input class="no-border hidden" type="checkbox" name="type_id[]" id="type_id_{$types[tmp2].id}" value="{$types[tmp2].id}" {if isset($request_post.type_id) && in_array($types[tmp2].id, $request_post.type_id)} checked="checked" {/if}/>
                                <span>{if isset($request_post.type_id) && in_array($types[tmp2].id, $request_post.type_id)}<i class="fa fa-check"></i>&nbsp;{/if}</span>&nbsp;{$types[tmp2].name}

                            </a>
                            {/section}&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="w-option clearfix">
                            <h3>Category</h3>
                            {section name=tmp1 loop=$categories}
                                <a class="btn bn{if isset($request_post.category_id) && in_array($categories[tmp1].id, $request_post.category_id)} active {/if}" href="#">
                                    <span>{if isset($request_post.category_id) && in_array($categories[tmp1].id, $request_post.category_id)}<i class="fa fa-check"></i>&nbsp;{/if}</span>{$categories[tmp1].name}
                                    <input class="hidden" type="checkbox" name="category_id[]" value="{$categories[tmp1].id}" {if isset($request_post.category_id) && in_array($categories[tmp1].id, $request_post.category_id)} checked="checked" {/if}>
                                </a>
                            {/section}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="w-option w-optionMap clearfix">
                            <h3>Working Address</h3>
                            <a class="btn-Japan {if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'japan'}active{elseif !isset($request_post.workaddress_type)}active{/if}" href="#">
                                <span>{if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'japan'}<i class="fa fa-check"></i>{elseif !isset($request_post.workaddress_type)}<i class="fa fa-check"></i>{/if}</span>&nbsp;Japan
                                <input class="hidden" type="radio" name="workaddress_type" value="japan" {if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'japan'} checked="checked" {elseif !isset($request_post.workaddress_type)} checked="checked"{/if}>
                            </a>
                            <a class="btn-World {if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'not-japan'}active{/if}" href="#">
                                <span>{if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'not-japan'}<i class="fa fa-check"></i>{/if}</span>&nbsp;Not Japanese
                                <input class="hidden" type="radio" name="workaddress_type" value="not-japan" {if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'not-japan'} checked="checked" {/if}>
                            </a>
                            <div class="clearfix"></div>
                            <div class="w-map clearfix">
                                <div class="map-japan {if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'japan'}show{elseif !isset($request_post.workaddress_type)}show{else}hidden{/if}">
                                    <button class="clear-btn green{if isset($request_post.area_id) && in_array(1, $request_post.area_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> HOKKAIDO TOHOKU
                                        <input class="hidden" type="checkbox" name="area_id[]" value="1"{if isset($request_post.area_id) && in_array(1, $request_post.area_id) } checked="checked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.area_id) && in_array(2, $request_post.area_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> KANTO
                                        <input class="hidden" type="checkbox" name="area_id[]" value="2"{if isset($request_post.area_id) && in_array(2, $request_post.area_id) } checked="checked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.area_id) && in_array(3, $request_post.area_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> TOKAI HOKURIKU
                                        <input class="hidden" type="checkbox" name="area_id[]" value="3"{if isset($request_post.area_id) && in_array(3, $request_post.area_id) } checked="checked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.area_id) && in_array(4, $request_post.area_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> KANSAI
                                        <input class="hidden" type="checkbox" name="area_id[]" value="4"{if isset($request_post.area_id) && in_array(4, $request_post.area_id) } checked="checked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.area_id) && in_array(5, $request_post.area_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> CHUGOKU SHIKOKU
                                        <input class="hidden" type="checkbox" name="area_id[]" value="5"{if isset($request_post.area_id) && in_array(5, $request_post.area_id) } checked="checked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.area_id) && in_array(6, $request_post.area_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> KYUSHU OKINAWA
                                        <input class="hidden" type="checkbox" name="area_id[]" value="6"{if isset($request_post.area_id) && in_array(6, $request_post.area_id) } checked="checked" {/if}>
                                    </button>

                                </div>
                                <div class="map-world {if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'not-japan'}show{/if}">
                                    <button class="clear-btn green{if isset($request_post.continents_id) && in_array(1, $request_post.continents_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> ASIA
                                        <input class="hidden" type="checkbox" name="continents_id[]" value="1"{if isset($request_post.continents_id) && in_array(1, $request_post.continents_id) } checked="cheked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.continents_id) && in_array(3, $request_post.continents_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> EUROPE
                                        <input class="hidden" type="checkbox" name="continents_id[]" value="3"{if isset($request_post.continents_id) && in_array(3, $request_post.continents_id) } checked="cheked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.continents_id) && in_array(4, $request_post.continents_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> AFRICA
                                        <input class="hidden" class="hidden" type="checkbox" name="continents_id[]" value="4"{if isset($request_post.continents_id) && in_array(4, $request_post.continents_id) } checked="cheked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.continents_id) && in_array(5, $request_post.continents_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> AMERICAS
                                        <input class="hidden" type="checkbox" name="continents_id[]" value="5"{if isset($request_post.continents_id) && in_array(5, $request_post.continents_id) } checked="cheked" {/if}>
                                    </button>
                                    <button class="clear-btn green{if isset($request_post.continents_id) && in_array(2, $request_post.continents_id) } active{/if}">
                                        <i class="fa fa-map-marker fa-lg"></i> OCEAN
                                        <input class="hidden" type="checkbox" name="continents_id[]" value="2"{if isset($request_post.continents_id) && in_array(2, $request_post.continents_id) } checked="cheked" {/if}>
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="w-option clearfix">
                            <label for="" class="black">KeyWord </label>
                            <input name="keyword" class="input" type="text" value="{if isset($request_post.keyword)}{$request_post.keyword}{/if}">
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <button class="btn-submit btnSearch bgf1ae47" type="submit"><i class="fa fa-search"></i> SEARCH</button>
                </div>
                <div class="row mt15">
                    <div class="col-xs-12">
                        <div class="alert alert-warning">
                            <h4><strong>ご注意</strong></h4>
                            <p>２０１５年９月２３日以前に登録されたお仕事情報のうち、一部の情報は、この検索機能に対応できていない為、検索が正しく行えません。
                                ご利用の皆様には大変ご迷惑をお掛けしますが、何卒、ご容赦ください。なお、一覧では、全てのお仕事情報が表示されますので、そちらも併せてご利用ください。</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>




{literal}
    <script type="text/javascript">
        function activeValueBtn(e)
        {
            var type = $(e).find('input').attr('type');
            if (type === 'checkbox') {
                $(e).toggleClass("active");
                $(e).find('input[type="checkbox"]').attr('checked', !$(e).find('input[type="checkbox"]').attr('checked'));
                if ($(e).hasClass('active')) {
                    $(e).find('span').html('<i class="fa fa-check"></i>&nbsp;');
                } else {
                    $(e).find('span').html('');
                }

            } else if (type === 'radio') {
                $('.single').removeClass('active');
                $('.single').find('input[type="radio"]').attr('checked',false);
                $('.single').find('i').hide();
                $(e).addClass('active');
                $(e).find('input[type="radio"]').attr('checked',true);
                $(e).find('span').html('<i class="fa fa-check"></i>&nbsp;');
            }
        }

        $('.map-world').hide();

        $(document).ready(function() {
            $(".bn, .btn-point").click(function(e) {
                e.preventDefault();
                activeValueBtn(this);
            });



            $('.btn-Japan').click(function(e) {
                e.preventDefault();
                $(this).find('input[type="radio"]').attr('checked',true);
                $('.btn-World').find('input[type="radio"]').attr('checked',false);
                $(".btn-World").removeClass("active");
                $(".btn-World").find('span').html('');
                $(this).addClass("active");
                $(this).find('span').html('<i class="fa fa-check"></i>&nbsp;');
                $('.map-japan').removeClass('hidden').show(1000);
                $('.map-world').removeClass('show').hide();
            });

            $('.btn-World').click(function(e) {
                e.preventDefault();
                $(this).find('input[type="radio"]').attr('checked',true);
                $('.btn-Japan').find('input[type="radio"]').attr('checked',false);
                $(".btn-Japan").removeClass("active");
                $(".btn-Japan").find('span').html('');
                $(this).addClass("active");
                $(this).find('span').html('<i class="fa fa-check"></i>&nbsp;');
                $('.map-world').removeClass('hidden').show(1000);
                $('.map-japan').removeClass('show').hide();
            });
            $('svg').click(function(e) {
                var boxArea = $(this).data('class');
                $('.'+boxArea).toggleClass('active2');
                $('.'+boxArea).find('input[type="checkbox"]').attr('checked', !$('.'+boxArea).find('input[type="checkbox"]').attr('checked'));
            });
            $('button.clear-btn').click(function(e){
                $(this).toggleClass('active');
                $(this).find('input[type="checkbox"]').attr('checked', !$(this).find('input[type="checkbox"]').attr('checked'));
                e.preventDefault();
            });

        });

    </script>
{/literal}
{/block}