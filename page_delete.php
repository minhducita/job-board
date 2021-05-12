<?php

	$j = new Job($id);
	// if auth code used, check it and allow editing
	if ((isset($_SESSION['later_edit']) && $_SESSION['later_edit'] == $j->GetAuth()) || ($extra != '' && $extra == $j->GetAuth()))
	{
		if($j->DeleteJobAdmin())
			$_SESSION['status'] = $translations['jobs']['remove_from_database_success'];
		else
			$_SESSION['status'] = $translations['jobs']['remove_from_database_error'];
		
		redirect_to(BASE_URL);
		exit;
	}
	else
		redirect_to(BASE_URL);
