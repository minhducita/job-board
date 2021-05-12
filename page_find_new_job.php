<?php
$start_page = isset($_GET['p']) ? $_GET['p'] : 1;
$smarty->assign('categories', get_categories());
$smarty->assign('types', get_types());
// record search keywords
$request_params = $_POST;
$smarty->assign('keywords','');
$smarty->assign('jobs', array());
$has_request = false;

if ($request_params) {
    $request_params = $_SESSION['REQUEST_POST'] = $_POST;
    $smarty->assign('keywords', $_POST['keyword']);
    $smarty->assign('jobs', $job->AdvancedSeach($request_params, $start_page));
    $has_request = true;
} elseif ($id != '' || isset($_GET['p'])) {
    $request_params = $_SESSION['REQUEST_POST'];
    $smarty->assign('keywords', stripslashes(htmlentities(urldecode($id), ENT_QUOTES, 'UTF-8')));
    $smarty->assign('jobs', $job->AdvancedSeach($request_params, $start_page));
    $has_request = true;
}
if (!isset($_SESSION['reseach'])) {
    $_SESSION['reseach'] = 0;
}
if (isset($_GET['research'])) {
    $_SESSION['reseach']++;
    if ($_SESSION['reseach'] == 1) {
        $request_params = $_SESSION['REQUEST_POST'];
    }
} else {
    $_SESSION['reseach'] = 0;
}
$smarty->assign('request_post',$request_params);
$smarty->assign('is_home', false);
$smarty->assign('no_categ', 0);
if ($has_request) {
    $smarty->assign('continents', get_continents());
    $smarty->assign('area', get_japan_area());
    $template = !$isMobile ? 'find-new-job-result.tpl':'MobileTemplates/views/jobs/find-new-job-result.tpl';
} else {
    $template = !$isMobile ? 'find-new-job.tpl':'MobileTemplates/views/jobs/find-new-job.tpl';
}


if (isset($_SESSION['search_pagination']))
{
    $smarty->assign('pages', $_SESSION['search_pagination']);
}
$total_jobs = isset($_SESSION['total_jobs']) ? $_SESSION['total_jobs']: 0;
$smarty->assign('total_jobs', $total_jobs);
?>