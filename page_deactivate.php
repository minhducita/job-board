<?php
	//mobile
	$j = new Job($id);
	// if auth code used, check it and allow editing
	if ((isset($_SESSION['later_edit']) && $_SESSION['later_edit'] == $j->GetAuth()) || ($extra != '' && $extra == $j->GetAuth()))
	{
		$j->Deactivate();
		$_SESSION['status'] = $translations['jobs']['delete_success'];
		redirect_to($baseUrl);
		exit;
	}

	if ($_SERVER['HTTP_REFERER'] == $baseUrl .'verify/' . $id . '/' && $id != 0 && $_SERVER['REMOTE_ADDR'] == $_SESSION['user_ip'])
	{
		$job = new Job($id);
		if ($job->GetTempStatus() == 1 || $job->GetActiveStatus() == 0)
		{
			$job->Deactivate();
			$_SESSION['status'] = $translations['jobs']['confirmation_error'];
			redirect_to($baseUrl);
			exit;
		}
		else
		{
			redirect_to($baseUrl);
			exit;
		}
	}
	else
	{
		redirect_to($baseUrl . URL_JOB .'/' . $id . '/');
		exit;
	}
?>