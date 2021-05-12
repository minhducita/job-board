<?php

$the_jobs = array();

$jobCount = $job->getActiveJobsCount();

$paginator = new Paginator($jobCount, JOBS_PER_PAGE, @$_REQUEST['p']);
$paginator->setLink(BASE_URL.'get-jobs');
$paginator->paginate();

$firstLimit = $paginator->getFirstLimit();
$lastLimit = $paginator->getLastLimit();

$the_jobs = $job->GetActiveJobs($firstLimit, JOBS_PER_PAGE);


$smarty->assign("pages",$paginator->pages_link);

$smarty->assign('jobs', $the_jobs);

$smarty->assign('placeholder', 'Search for a job');


$template = 'jobs.tpl';
