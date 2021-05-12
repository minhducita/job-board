<?php

$category_var_name = $id;
$category = get_category_by_var_name($category_var_name);

if($category == '')
	$category_id = 0;
else
	$category_id = $category['id'];

$type_filter = $extra;

$list = new AdvancedSearch();

$jobsCount = 0;
$jobsCount =  $list->CountJobsFilter($category_id, $type_filter);

$paginatorLink = BASE_URL . URL_JOBS;
$paginatorLink .= "/$category_var_name";

if (isset($type_filter))
	$paginatorLink .= "/$type_filter";

$paginator = new Paginator($jobsCount, JOBS_PER_PAGE, @$_REQUEST['p']);
$paginator->setLink($paginatorLink);
$paginator->paginate();

$firstLimit = $paginator->getFirstLimit();
$lastLimit = $paginator->getLastLimit();

 
$the_jobs = array();
 
$the_jobs = $list->filterjobs($type_filter, $firstLimit, JOBS_PER_PAGE, $category_id);

$smarty->assign("pages", $paginator->pages_link);
 
$smarty->assign('jobs', $the_jobs);
$smarty->assign('jobs_count', $jobsCount);
$smarty->assign('types', get_types());
$smarty->assign('current_category', $category_var_name);
$smarty->assign('current_category_name', $category['name']);

$smarty->assign('filter', $type_filter);
 
$smarty->assign('seo_title', $category['title']);
$smarty->assign('seo_desc', $category['description']);
$smarty->assign('seo_keys', $category['keywords']);

$smarty->assign('spotlight_jobs', $job->GetJobs(0, $category_id, NUMBER_OF_SPOTLIGHT_JOBS_TO_GET, 1, 0, 0, 0, 0, 1));

$template = 'category.tpl';


?>