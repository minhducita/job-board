<?php
$job = new Job($id);
if ($extra != '' && $extra == $job->GetAuth())
{
	$later_edit = true;
	$_SESSION['later_edit'] = $extra;
}
else
{
	$later_edit = false;
	$_SESSION['later_edit'] = '';
}

if ($_SESSION['referer'] != $baseUrl . 'post/')
{
	if (!$_SESSION['later_edit'])
	{
		redirect_to($baseUrl . URL_JOB .'/' . $id . '/');
		exit;
	}
}

$jobInfo = $job->GetInfo();

$jobInfo["root_image1"] = str_replace("uploads/job","uploads/job/root",$jobInfo["image1"]);
$jobInfo["root_image2"] = str_replace("uploads/job","uploads/job/root",$jobInfo["image2"]);
$jobInfo["root_image3"] = str_replace("uploads/job","uploads/job/root",$jobInfo["image3"]);

$nationalities = array('Japanese','Not Japanese', 'Not set','Not set');
$jobInfo['nationality'] = $nationalities[$jobInfo['nationality']];
if (strstr($jobInfo['description'], '*'))
{
	$jobInfo['description'] = $textile->TextileThis($jobInfo['description']);
}
else
{
	$jobInfo['description'] = str_replace(array("\r\n", "\r", "\n"), "", $jobInfo['description']);
}
$smarty->assign('job', $jobInfo);
$html_title = stripslashes($jobInfo['title']) . ' at ' . stripslashes($jobInfo['company']);

/* check show arrow slider*/
$active_arrow = 0;
if($jobInfo['image1'] && $jobInfo['image1'] != 'NULL') $active_arrow++;
if($jobInfo['image2'] && $jobInfo['image2'] != 'NULL') $active_arrow++;
if($jobInfo['image3'] && $jobInfo['image3'] != 'NULL') $active_arrow++;
$smarty->assign('active_arrow',$active_arrow);

$template = !$isMobile ? 'publish-verify.tpl' : 'MobileTemplates/views/jobs/verify.tpl';
