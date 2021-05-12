<!-- Nam cap nhat -->{include file="header_jquery_update.tpl"}<!-- Nam cap nhat -->
    <div class="findJob clearfix">
        <div class="resultSearch-PC">
            <div class="w-option clearfix">
                <h4><strong>ご注意</strong></h4>
                <p>２０１５年９月２３日以前に登録されたお仕事情報のうち、一部の情報は、この検索機能に対応できていない為、検索が正しく行えません。
                    ご利用の皆様には大変ご迷惑をお掛けしますが、何卒、ご容赦ください。なお、一覧では、全てのお仕事情報が表示されますので、そちらも併せてご利用ください。</p>
            </div>
            <div class="row mb15">
                <div class="container">
                    <h3>
                        {if !empty($jobs)}
                            {$total_jobs} offer(s) found.
                        {else}
                            No offer(s) found.
                        {/if}
                    </h3>
                    <div class="w-resultSearch">
                        <div class="row resultSearch-item">
                            <div class="col-xs-12">
                                <p><span class="label-bold">Nationality of an aplicant</span> :
                                    {if isset($request_post.nationality)}
                                        {if $request_post.nationality == 2}
                                            <span>Either</span>
                                        {elseif $request_post.nationality == 1}
                                            <span>Not Japanese</span>
                                        {elseif $request_post.nationality == 0}
                                            <span>Japanese</span>
                                        {/if}
                                    {/if}
                                </p>
                            </div>
                        </div>
                        {if !empty($request_post.type_id)}
                        <div class="row resultSearch-item">
                            <div class="col-xs-12">
                                <p><span class="label-bold">Work type</span> :
                                    {assign var="type" value=''}
                                    {section name=tmp2 loop=$types}
                                        {if isset($request_post.type_id) && in_array($types[tmp2].id, $request_post.type_id)}
                                            {assign var="type" value=$type|cat:"<span>`$types[tmp2].name`</span>, "}
                                        {/if}
                                    {/section}
                                    {$type|trim:', '}
                                </p>
                            </div>
                        </div>
                       {/if}
                        {if !empty($request_post.category_id)}
                        <div class="row resultSearch-item">
                            <div class="col-xs-12">
                                <p><span class="label-bold">Category</span> :
                                    {assign var="cat" value=''}
                                    {section name=tmp1 loop=$categories}
                                        {if isset($request_post.category_id) && in_array($categories[tmp1].id, $request_post.category_id)}
                                            {assign var="cat" value=$cat|cat:"<span>`$categories[tmp1].name`</span>, "}
                                        {/if}
                                    {/section}
                                    {$cat|trim:', '}
                                </p>
                            </div>
                        </div>
                        {/if}
                        <div class="row resultSearch-item last">
                            <div class="col-xs-12">
                                <p><span class="label-bold">Working Address</span>  :
                                    {if isset($request_post.workaddress_type) && $request_post.workaddress_type == 'japan'}
                                        {if !empty($request_post.area_id)}
                                            {assign var="areas" value=''}
                                            {section name=tmp3 loop=$request_post.area_id}
                                                {assign var="id" value=$request_post.area_id[tmp3]}
                                                {if isset($area[$id])}
                                                    {assign var="areas" value=$areas|cat:"<span>`$area[$id]`</span>, "}
                                                {/if}
                                            {/section}
                                        Japan( {$areas|trim:', '} )
                                        {else}
                                            Japan
                                        {/if}
                                    {else}
                                        {if !empty($request_post.continents_id)}
                                            {assign var="continentss" value=''}
                                            {section name=tmp4 loop=$request_post.continents_id}
                                                {assign var="id" value=$request_post.continents_id[tmp4]}
                                                {if isset($continents[$id])}
                                                    {assign var="continentss" value=$continentss|cat:"<span>`$continents[$id]`</span>, "}
                                                {/if}
                                            {/section}
                                            {$continentss|trim:', '}
                                        {/if}
                                    {/if}
                                </p>
                            </div>
                        </div>
                        <div class="row mt15">
                            <div class="col-xs-12">
                                <a id="research" href="{$BASE_URL}find-new-job/?research=1" class="btn bgf1ae47"><i class="fa fa-pencil"></i> Change Condition</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="job-listings" class="job-listings">
                {include file="posts-loop.tpl"}
            </div><!-- #job-listings -->
        </div>


</div>
    <div class="clearfix"></div>
{include file="footer.tpl"}