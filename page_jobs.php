<?php

	define('NUMBER_OF_SPOTLIGHT_JOBS_TO_GET', $settings['spotlight_jobs']);

	$uri = '';
	
	if ($id)
	{
		$uri = $id;
	}
	
	$allJobsRequested = false;
	$jobsPerCategoryRequested = false;
	$jobsPerFilters = false;
	
	if ($uri == '')
	{
		$allJobsRequested = true;
	}
	else
	{
		$category = get_category_by_var_name($uri);
		
		if ($category)
		{
			$jobsPerCategoryRequested = true;
		}
		else
		{
			if($id == 'all')
				$type_id = get_type_id_by_varname($extra);
			else
				$type_id = get_type_id_by_varname($uri);
			
			if ($type_id)
			{
				$allJobsRequested = true;
			}
		}
	}
	
	//filter search arrays
	$advanced_search_array = array('nofilter','infmonth','supmonth','month','week','day');
	
	if(in_array($extra, $advanced_search_array))
		$jobsPerFilters = true;
		
	
	if($jobsPerFilters)
	{
		if($isMobile)
			redirect_to($baseUrl . 'page-unavailable/');
		require_once 'page_advancedsearch.php';
	}
	elseif ($allJobsRequested)
	{
		require_once 'page_all_jobs.php';
	}
	elseif ($jobsPerCategoryRequested)
	{
		require_once 'page_category.php';
	}
	else
	{
		redirect_to(BASE_URL . 'page-unavailable/');
		exit;
	}
?>