<?php
	define('NUMBER_OF_SPOTLIGHT_JOBS_TO_GET', $settings['spotlight_jobs']);

	$spotlightJobCount = $job->getInActiveSpotlightJobCount();

	$paginator = new Paginator($spotlightJobCount, NUMBER_OF_SPOTLIGHT_JOBS_TO_GET, @$_REQUEST['p']);
	$paginator->setLink(BASE_URL.'spotlight-jobs');
	$paginator->paginate();

	$firstLimit = $paginator->getFirstLimit();
	$lastLimit = $paginator->getLastLimit();

    $spotlight_jobs = $job->getSpotlightJobs($firstLimit,NUMBER_OF_SPOTLIGHT_JOBS_TO_GET);
	$smarty->assign('spotlight_jobs',$spotlight_jobs);

	$smarty->assign("pages",$paginator->pages_link);

	$template = 'page_spotlight_job.tpl';
?>