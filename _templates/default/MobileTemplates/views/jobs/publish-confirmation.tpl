{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
    <div class="content">
        <section class="main">
            <div class="post-step3-page">
                <ul class="breadcrumb">
                    <li>Step 1: Write</li>
                    <li>Step 2: Verify</li>
                    <li class="active">Step 3: Confirm</li>
                </ul>
                <div class="container">
                    <h3>Job ID :</h3>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-confirm">
                                <p>この度は、当協会のJobBoardへのご投稿有難うございます。<br>
                                    ご投稿頂きました内容は、当協会で一度確認をさせて頂きますので、掲載開始まで今しばらくお待ちください。<br>
                                    （通常、内容確認には３-４営業日を要します。）<br>
                                    お手数をお掛け致しますが、どうぞ宜しくお願い致します。</p>
                                <p>We need to check contents and sentences of your ad,
                                    so it will take about 3 to 4 business days before your ad will be published.
                                    When your ad is published, we will send you an e-mail!</p>
                                <p>Thank you for using our service!</p>
                            </div>
                            <a class="btn bgf1ae47" href="{$baseUrl}"><i class="fa fa-angle-double-left"></i> Go back to category</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
{/block}