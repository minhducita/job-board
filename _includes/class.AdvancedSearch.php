<?php
/**
 * jobber job board platform
 *
 * @author     Based on RedJumpsuit <myredjumpsuit@gmail.com> first coding,  Modified by AntoineMichael
 * @web        www.redjump.co.cc
 *
 * Advanced Search is used for more extensive searching
 */
 
class AdvancedSearch
{
    function __construct()
    { }
 
    public function filterjobs($filter, $startIndex, $numberOfJobsToGet=50, $catid)
    {
        global $db;
        $jobs = array();
  
        //filter treatment
		switch($filter)
		{
			case 'day' : $condition = ' AND created_on >= DATE_SUB(NOW(),INTERVAL 1 DAY) ';
				break;
			
			case 'week' : $condition = ' AND created_on >= DATE_SUB(NOW(), INTERVAL 1 WEEK ) ';
				break;
			
			case 'month' :
			case 'supmonth' : $condition = ' AND created_on >= DATE_SUB(NOW(),INTERVAL 1 MONTH ) ';
				break;
				
			case 'infmonth' : $condition = ' AND created_on <= DATE_SUB(NOW(),INTERVAL 1 MONTH ) ';
				break;
				
			case 'nofilter' : $condition = '';
				break;
			
			default: $condition = '';
		}
		 
         $sql = 'SELECT id
                    FROM '.DB_PREFIX.'jobs
                    WHERE is_temp = 0 AND is_active = 1';
		
		if($catid != 0)
			$sql .= ' AND category_id = ' . $catid;
			 
		$sql .= $condition . ' ORDER BY created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
 
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc())
        {
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
        }
 
        if ($jobs)
        {
            return $jobs;
        }
 
    }
	
	public function CountJobsFilter($catid , $filter)
	{
		global $db;
		$condition = '';
		
        //filter treatment
		switch($filter)
		{
			case 'day' : $condition = ' AND created_on >= DATE_SUB(NOW(),INTERVAL 1 DAY) ';
				break;
			
			case 'week' : $condition = ' AND created_on >= DATE_SUB(NOW(), INTERVAL 1 WEEK ) ';
				break;
			
			case 'month' :
			case 'supmonth' : $condition = ' AND created_on >= DATE_SUB(NOW(),INTERVAL 1 MONTH ) ';
				break;
				
			case 'infmonth' : $condition = ' AND created_on <= DATE_SUB(NOW(),INTERVAL 1 MONTH ) ';
				break;
				
			case 'nofilter' : $condition = '';
				break;
			
			default: $condition = '';
		}

         $sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1';
		
		if($catid != 0)
			$sql .= ' AND category_id = ' . $catid;
			 
		$sql .= $condition;

		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];	
	}

}

?>