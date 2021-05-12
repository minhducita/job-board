{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
	<div class="content">
		<section class="main">
			{if $spotlight_jobs}
				<div class="spotlight">
					<div class="container">
						<h2>{$translations.homepage.spotlight_jobs}</h2>
						{foreach item=job from=$spotlight_jobs}
							{include file="../jobs/partials/spotlight-job.tpl"}
						{/foreach}
					</div>
				</div>
			{/if}
			<div class="google-ad">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8112755181417377" data-ad-slot="7289688244" data-ad-format="auto"></ins>
							<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
						</div>
					</div>
				</div>
			</div>
			{if $latest_jobs}
				<div class="mostView">
					<div class="container">
						<h2>{$translations.homepage.recent_jobs}</h2>
						{foreach item=job from=$latest_jobs}
							{include file="../jobs/partials/recentoffer-job.tpl"}
						{/foreach}
						<div class="row">
							<a class="btn btnViewAll" href="jobs">View all <i class="fa fa-angle-double-right"></i></a>
						</div>
					</div>
				</div>
			{/if}
		</section>
	</div>
{/block}