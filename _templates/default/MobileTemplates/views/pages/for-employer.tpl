{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
	<div class="content">
		<section class="main">
			<div class="detail-page">
				<h2 class="main-title">雇用主の方へ(投稿方法)</h2>
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<h3>求人情報掲載に際し、利用料金等は一切かかりません。<br>
								また、以下の利用規約を遵守願います。</h3>
							<div class="box-white">
								<h4>【JobBoad Terms and conditions】</h4>
								<ul class="list-text">
									<li>Please read the terms and conditions of this service before you post.</li>
									<li>The terms and conditions is written in Japanese. Even Japanese is not user's primary language, it is the user’s responsibilities to read and understand the terms and conditions of the user agreement.</li>
									<li>In the event of any inconsistency, conflict, ambiguity or discrepancy between the Japanese version and any other version in other languages of these terms and conditions,
										the Japanese version shall prevail at all times.</li>
									<li>By using our Service, you shall be deemed to have agreed to the Terms and Conditions.</li>
								</ul>
							</div>
							<div class="box-white">
								<h4>【JobBoard（求人掲示板）利用規約】</h4>
								<ul class="list-text">
									<li>投稿者は、掲載内容についての一切の責任をお持ちください。<br>掲載内容の変更・修正が必要な場合は必ず掲載者が行い、その情報掲載が不要となった場合は、すみやかに削除をお願いします。</li>
									<li>代理人による投稿及び、コンピュータプログラムなどによる自動投稿は禁止します。<br>また、同一内容を投稿する場合は、以前の掲載を一度削除された上で、再度の投稿をお願いします。</li>
									<li>このサービスは、ワーキングホリデーの活性化の為に提供するものであるため、以下の様な掲載は禁止します。
										<ul class="list-text">
											<li>公序良俗に反する内容</li>
											<li>アダルト関係、ネットワークビジネス関係の内容</li>
											<li>求職者に一方的に不利益な内容</li>
											<li>その他、当協会が不当と判断する内容</li>
										</ul>
									</li>
									<li>掲載内容の表示位置、順位、方法などについては投稿者が指定することは出来ません。</li>
									<li>当協会は求人情報に関する掲示板を運営するのみであり、実際の面談、採用に関する手続き等の斡旋、代行等は行いません。</li>
									<li>求職者との連絡、雇用に関する手続き等は、投稿者又は投稿者に準ずる者の責任において実施してください。<br>
										当協会は、当協会の判断により掲載停止及び削除する権利を有します。<br>
										また、この掲示板の全部又は一部の機能を適宜変更・廃止できるものとします。<br>
										これらの事象により投稿者など、全ての利用者に生じた損害は、理由のいかんを問わず、一切の責任を負わないものとします。</li>
									<li>この利用規約は、当協会の判断により事前の予告なく追加・変更・削除できるものとします。<br>また、この利用規約は日本語で作成され、日本語のみによって解釈されるものとします。</li>
								</ul>
							</div>
							<h3>来日中の外国人青年の雇用について<br>
								来日中の外国人の雇用に関しては、以下の点に注意する必要があります。</h3>
							<div class="box-gray">
								<ul class="list-text">
									<li>求職者は日本国内において仕事をすることが可能で、有効な在留資格を持っていますか？(※１）</li>
									<li>仕事の内容・期間は、求職者の在留資格に沿ったものですか？（※２）</li>
								</ul>
							</div>
							<p>また、雇用した場合には、いくつかの手続きが必要となります。詳しくは、お近くのハローワーク（公共職業安定所）にお問い合わせください。</p>
							<p>※１	採用決定前に外国人登録証明等の書類の提示を求めることは、公正採用選考の観点から適切ではありません。 採用選考の段階では、外国人求人者が適法に就労できる在留資格を持っているかどうかの確認は、求職者本人に口頭で確認するようにしてください。</p>
							<p>※２	ワーキングホリデー制度は各協定国双方の青少年に相手国の文化及び生活様式を理解することを目的とした制度であり、 その間の旅行資金を補うために付随的に働く事が認められています。 また、風俗営業又は風俗関連営業が営まれる営業所では働くことができません。</p>
							<h3>掲載手順について</h3>
							<p>JobBoard（求人掲示板）のご利用は無料です。</p>
							<p>以下の手順で求人情報の投稿をお願いいたします。</p>
							<ul class="list-number" style="padding-left: 0;">
								<li>JobBoardのWEBサイトを表示し、右上の <a class="btn" href="#" title="">Post a new job</a>をクリックします。</li>
								<li>次の通り、求人内容を入力します。<br>
									なお、ご入力頂いた内容は、求職者が直接閲覧しますので「英語のみ」又は「英語・日本語での兼記」でお願いいたします。</li>
								<img src="{BASE_URL}_templates/default/MobileTemplates/img/post1.jpg" alt="" class="img-responsive mb15">
                                <img src="{BASE_URL}_templates/default/MobileTemplates/img/post2.jpg" alt="" class="img-responsive mb15">
								<li>ご入力頂きましたら、 <a class="btn" href="#">Step 2 verify ad</a>をクリックしてください。確認画面が表示されます。</li>
								<li>確認画面で、入力内容を確認して、<a class="btn" href="#">Step 2 verify ad</a> をクリックすると掲載が開始されます。</li>
							</ul>
							<p>なお、初めて投稿頂いた場合は、次のようなメッセージが表示されます。（この状態では掲載されておりません。<br>
								当協会で、掲載内容を確認させて頂きますので、しばらくお待ちください。<br>
								こちらでの確認作業の後（通常１～２営業日）に掲載を開始いたします。</p>

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
						</div>
					</div>

				</div>
			</div>
		</section>
	</div>
{/block}