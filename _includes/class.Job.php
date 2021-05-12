<?php
/**
 * jobber job board platform
 *
 * @author     Filip C.T.E. <http://www.filipcte.ro> <me@filipcte.ro>
 * @license    You are free to edit and use this work, but it would be nice if you always referenced the original author ;)
 *             (see license.txt).
 * 
 * Job class is the backbone of this site and handles (almost) everything related to a job
 */

// a user's visit on a job post is only counted once per hour
define('MAX_VISITS_PER_HOUR', 1);

class Job
{
	var $mId = false;
	var $mTypeId = false;
	var $mTypeVarName = false;
	var $mTypeName = false;
	var $mCategoryId = false;
	var $mTitle = false;
	var $mDescription = false;
	var $mCompany = false;
	var $mLocation = false;
	var $mUrl = false;
	var $mApply = false;
	var $mCreatedOn = false;
	var $mSpotlightStartDate = false;
	var $mSpotlightEndDate = false;
	var $mIsTemp = false;
	var $mIsActive = false;
	var $mViewsCount = false;
	var $mAuth = false;
	var $mCityId = false;
    var $mContinentsId = false;
    var $mCountryId = false;
    var $mAreaId = false;
	var $mNationality = false;
	var $mLocationOutsideRo = false;
	var $mPosterEmail = false;
	var $mUrlTitle = false;
	var $mApplyOnline = false;
	var $mCategoryName = false;
	var	$mClosedOn = false;
	var	$mDaysOld = false;
	var $mIsSpotlight = false;
	var $mMySqlDate = false;
	
	var $mOccupation = false;
	var $mDetails = false;
	var $mAddress = false;
	var $mRequ = false;
	var $mWage = false;

    var $image1     = false;
    var $image2     = false;
    var $image3     = false;
    var $date_end   = false;
    var $mApplicationExpired   = false;

	function __construct($job_id = false)
	{
		global $db;
		if (is_numeric($job_id))
		{
			$sanitizer = new Sanitizer;
			$sql = 'SELECT a.type_id AS type_id,
			a.category_id AS category_id,
			a.title AS title,
			a.description AS description,
			               a.company AS company,
			               a.url AS url,
			               a.apply AS apply,
			               DATE_FORMAT(a.created_on, "' . DATE_FORMAT . '") AS created_on,
			               a.created_on AS mysql_date,
			               DATE_FORMAT(spotlight_udate, "%d-%b") AS spotlight_start_date,
			               DATE_FORMAT(DATE_ADD(spotlight_udate, INTERVAL 14 DAY),"%d-%b") AS spotlight_end_date,
			               a.is_temp AS is_temp,
			               a.is_active AS is_active,
			               a.spotlight AS spotlight,
			               a.views_count AS views_count,
			               a.auth AS auth,
			               a.nationality AS nationality,
			               a.continents_id AS continents_id,
			               a.country_id AS country_id,
			               a.area_id AS area_id,
			               a.city_id AS city_id,
			               a.outside_location AS outside_location,
			               a.poster_email AS poster_email,
			               a.apply_online AS apply_online,
			               b.name AS category_name,
			               c.var_name as type_var_name,
			               c.name as type_name,
					a.occupation AS occupation,
					a.details AS details,
					a.address AS address,
					a.requ AS requ,
					a.wage AS wage,
					a.image1 AS image1,
					a.image2 AS image2,
					a.image3 AS image3,
					a.date_end AS date_end,
					a.application_expired AS application_expired,
						   DATE_ADD(created_on, INTERVAL 30 DAY) AS closed_on, DATEDIFF(NOW(), created_on) AS days_old, cit.name AS city_name
			               FROM '.DB_PREFIX.'jobs a LEFT JOIN '.DB_PREFIX.'cities cit on a.city_id = cit.id, '.DB_PREFIX.'categories b, '.DB_PREFIX.'types c
			               WHERE a.category_id = b.id AND c.id = a.type_id AND a.id = ' . $job_id;
			
			$result = $db->query($sql);
			$row = $result->fetch_assoc();
			
			if (!empty($row))
			{
				$this->mId = $job_id;
				$this->mTypeId = $row['type_id'];
				$this->mCategoryId = $row['category_id'];
				$this->mCategoryName = $row['category_name'];
				$this->mTitle = str_replace('&', '&amp;', $row['title']);
				$this->mDescription = $row['description'];
				$this->mCompany = $row['company'];
				$this->mUrl = $row['url'];
				$this->mApply = $row['apply'];
				$this->mSpotlightStartDate = $row['spotlight_start_date'];
				$this->mSpotlightEndDate = $row['spotlight_end_date'];
				$this->mCreatedOn = $row['created_on'];
				$this->mClosedOn = $row['closed_on'];
				$this->mIsTemp = $row['is_temp'];
				$this->mIsActive = $row['is_active'];
				$this->mViewsCount = $row['views_count'];
				$this->mAuth = $row['auth'];
                $this->mContinentsId = $row['continents_id'];
                $this->mCountryId = $row['country_id'];
                $this->mAreaId  = $row['area_id'];
				$this->mCityId = $row['city_id'];
				$this->mNationality = $row['nationality'];
				$this->mMySqlDate = $row['mysql_date'];
				$this->mLocation = $this->GetLocation($row);
				$this->mLocationOutsideRo = $row['outside_location'];
				$this->mPosterEmail = trim($row['poster_email']);
				$this->mUrlTitle = $sanitizer->sanitize_title_with_dashes($this->mTitle . ' at ' . $this->mCompany);
				$this->mApplyOnline = $row['apply_online'];
				$this->mDaysOld = $row['days_old'];
				$this->mIsSpotlight = $row['spotlight'];
				$this->mTypeName = $row['type_name'];
				$this->mTypeVarName = $row['type_var_name'];
				
				$this->mOccupation = $row['occupation'];
				$this->mDetails = $row['details'];
				$this->mAddress = $row['address'];
				$this->mRequ = $row['requ'];
				$this->mWage = $row['wage'];
				$this->mApplicationExpired = $row['application_expired'];
				/*Nam cap nhat*/
				$this->image1 = $row['image1'];
				$this->image2 = $row['image2'];
				$this->image3 = $row['image3'];
				$this->date_end = $row['date_end'];
				/*Nam cap nhat*/
			}
		}
	}
	
	// Get a job post's information
	public function GetInfo()
	{
		$job = array('id' => $this->mId,
		             'type_id' => $this->mTypeId,
		             'category_id' => $this->mCategoryId,
		             'category_name' => $this->mCategoryName,
					 'company' => stripslashes($this->mCompany),
					 'url' => stripslashes($this->mUrl),
					 'title' => stripslashes($this->mTitle),
					 'url_title' => stripslashes($this->mUrlTitle),
					 'location' => $this->mLocation,
					 'location_outside_ro' => $this->mLocationOutsideRo,
					 'is_location_anywhere' => $this->IsLocationAnywhere(),
					 'description' => stripslashes($this->mDescription),
					 'created_on' => stripslashes($this->mCreatedOn),
					 'closed_on' => stripslashes($this->mClosedOn),
					 'apply' => stripslashes($this->mApply),
			'spotlight_start_date' => stripslashes($this->mSpotlightStartDate),
			'spotlight_end_date' => stripslashes($this->mSpotlightEndDate),
					 'views_count' => $this->mViewsCount,
					 'auth' => $this->mAuth,
                     'continents_id' => $this->mContinentsId,
                     'country_id' => $this->mCountryId,
                     'area_id' => $this->mAreaId,
					 'city_id' => $this->mCityId,
					 'nationality' => $this->mNationality,
					 'mysql_date' => $this->mMySqlDate,
					 'poster_email' => trim($this->mPosterEmail),
					 'apply_online' => $this->mApplyOnline,
					 'is_active' => $this->mIsActive,
					 'days_old' => $this->mDaysOld,
					 'is_spotlight' => $this->mIsSpotlight,
					 'type_name' => $this->mTypeName,
					'occupation' => $this->mOccupation,
					'details' => $this->mDetails,
					'address' => $this->mAddress,
					'requ' => $this->mRequ,
					'wage' => $this->mWage,
					'application_expired' => $this->mApplicationExpired,
			'image1'=>$this->image1,
			'image2'=>$this->image2,
			'image3'=>$this->image3,
			'date_end'=>$this->date_end,
					 'type_var_name' => $this->mTypeVarName);
		
		return $job;
	}
	
	// Get a job post's basic information for admin
	public function GetBasicInfoAdmin()
	{
		$job = array('id' => $this->mId,
			         'type_id' => $this->mTypeId,
			         'category_id' => $this->mCategoryId,
 			         'category_name' => $this->mCategoryName,
					 'company' => stripslashes($this->mCompany),
					 'url' => stripslashes($this->mUrl),
					 'title' => stripslashes($this->mTitle),
					 'url_title' => stripslashes($this->mUrlTitle),
					 'location' => $this->mLocation,
					 'location_outside_ro' => $this->mLocationOutsideRo,
					 'is_location_anywhere' => $this->IsLocationAnywhere(),
					 'description' => stripslashes($this->mDescription),
			'spotlight_start_date' => stripslashes($this->mSpotlightStartDate),
			'spotlight_end_date' => stripslashes($this->mSpotlightEndDate),
					 'created_on' => stripslashes($this->mCreatedOn),
					 'closed_on' => stripslashes($this->mClosedOn),
					 'apply' => stripslashes($this->mApply),
					 'city_id' => $this->mCityId,
					 'nationality' => $this->mNationality,
					 'mysql_date' => $this->mMySqlDate,
					 'days_old' => $this->mDaysOld,
					 'is_active' => $this->mIsActive,
					 'views_count' => $this->mViewsCount,
					 'is_spotlight' => $this->mIsSpotlight,
					 'type_name' => $this->mTypeName,
					 'type_var_name' => $this->mTypeVarName);
		
		return $job;
	}
	
	private function GetLocation($resultSetRow)
	{
		$location = '';
		
		if ($resultSetRow['city_id'] != NULL) 
		{
			$location = $resultSetRow['city_name'];
		}	
		elseif ($resultSetRow['outside_location'] != '')
		{
			$location = $resultSetRow['outside_location'];
		}
		
		return $location;
	}
	
	private function IsLocationAnywhere()
	{
		return $this->mCityId == 0 && $this->mLocationOutsideRo == '';
	}
	
	// Get all job posts (optionally from a specific type and/or category)
	// $type_id: freelance/fulltime/parttime
	// $categ_id: programatori/designeri/etc.
	// $limit: (int) how many results
	// $random: (1/0) randomize results?
	// $days_behind: (int) only get results from last N days
	// $for_feed: (boolean) is this request from rss feed?
	public function GetJobs($type_id = false, $categ_id = false, $limit = false, $random, $days_behind, $for_feed = false, $city_id = false, $type_id = false, $spotlight = false)
	{
		global $db;
		$jobs = array();
		$conditions = '';
		
		// if $categ_id is, in fact, the category's var_name, 
		// get the categs id
		if (!is_numeric($categ_id))
		{
			$categ_id = $this->GetCategId($categ_id);
		}
		// if $type_id is, in fact, the type's var_name, 
		// get the type's id
		if (!is_numeric($type_id))
		{
			$type_id = $this->GetTypeId($type_id);
		}
		
		if (is_numeric($type_id) && $type_id != 0)
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}
		if (is_numeric($categ_id) && $categ_id != 0)
		{
			$conditions .= ' AND category_id = ' . $categ_id;
		}
		
		if ($days_behind > 0)
		{
			$conditions .=' AND created_on >= DATE_SUB(NOW(), INTERVAL ' . $days_behind . ' DAY)';
		}
		
		if ($for_feed)
		{
			// job was posted more than 10 minutes ago
			$conditions .= ' AND DATE_SUB(NOW(), INTERVAL 10 MINUTE) > created_on';
		}
		
		if ($city_id && is_numeric($city_id))
		{
			$conditions .= ' AND city_id = ' . $city_id;
		}
		
		if ($type_id && is_numeric($type_id))
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}
		
		if ($spotlight &&  is_numeric($spotlight))
    	{
  			$conditions .= ' AND spotlight = ' . $spotlight;
		}

		if ($random == 1)
		{
			$order = ' ORDER BY RAND() ';
		}
		else
		{
			$order = ' ORDER BY created_on DESC ';
		}
		
		if ($limit != false && $limit > 0)
		{
			$sql_limit = 'LIMIT ' . $limit;
		}
		else
		{
			$sql_limit = '';
		}
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE 1 ' . $conditions . ' AND is_temp = 0 AND is_active = 1
		               ' . $order . ' ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		return $jobs;
	}
	
	public function GetPaginatedJobsForCategory($categoryID, $startIndex, $numberOfJobsToGet, $jobTypeID)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE category_id = ' . $categoryID . ' AND is_temp = 0 AND is_active = 1';
		
		if ($jobTypeID != 0)
		{
			$sql .= ' AND type_id = ' . $jobTypeID;
		}
		
		$sql .= ' ORDER BY created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;
	}
	
	public function GetPaginatedJobsForCity($cityID, $startIndex, $numberOfJobsToGet, $jobTypeID)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE city_id = ' . $cityID . ' AND is_temp = 0 AND is_active = 1';
		
		if ($jobTypeID != 0)
		{
			$sql .= ' AND type_id = ' . $jobTypeID;
		}
		
		$sql .= ' ORDER BY created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;
	}
	
	public function GetPaginatedJobs($startIndex, $numberOfJobsToGet, $jobTypeID = 0)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE is_temp = 0 AND is_active = 1';
		
		if ($jobTypeID != 0)
		{
			$sql .= ' AND type_id = ' . $jobTypeID;
		}
		
		$sql .= ' ORDER BY created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;
	}
	
	//Get all inactive jobs for admin 
	public function GetInactiveJobs($offset, $rowCount)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE 1 AND is_temp = 0 AND is_active = 0
		               ORDER BY created_on DESC LIMIT ' . $offset .' , ' . $rowCount;
		
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetBasicInfoAdmin();
		}
		return $jobs;
	}
	
	public function getInactiveJobCount()
	{
		global $db;
		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 0';
	
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];	
	}

	// bluecloud functions
	/**
	 * count active jobs
	 *
	 * @return mixed
	 */
	public function getActiveJobsCount()
	{
		global $db;
		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_active = 1';

		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}

	/**
	 * get all active jobs
	 *
	 * @param $offset
	 * @param $rowCount
	 * @return array
	 */
	public function GetActiveJobs($offset, $rowCount)
	{
		global $db;
		$jobs = array();

		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE is_active = 1
		               ORDER BY created_on DESC LIMIT ' . $offset .' , ' . $rowCount;

		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetBasicInfoAdmin();
		}
		return $jobs;
	}

	/**
	 * get all spotlight jobs
	 *
	 * @param $offset
	 * @param $rowCount
	 * @return array $jobs
	 */
	public function getSpotlightJobs($offset, $rowCount)
	{
		global $db;
		$jobs = array();

		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE spotlight = 1
		               ORDER BY created_on DESC LIMIT ' . $offset .' , ' . $rowCount;

		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetBasicInfoAdmin();
		}
		return $jobs;
	}

	/**
	 * Get the number of spotlight jobs
	 *
	 * @return int
	 */
	public function getInActiveSpotlightJobCount()
	{
		global $db;
		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE spotlight = 1';

		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}
	//end bluecloud functions

	//Get all inactive/active jobs for a specific category for admin
	// $type_id: freelance/fulltime/parttime
	// $categ_id: programatori/designeri/etc.
	// $limit: (int) how many results
	public function GetAllForCategoryJobsAdmin($type_id, $categ_id = false, $limit = false)
	{
		global $db;
		$jobs = array();
		$conditions = '';
		
		// if $categ_id is, in fact, the category's var_name, 
		// get the categs id
		if (!is_numeric($categ_id))
		{
			$categ_id = $this->GetCategId($categ_id);
		}
		// if $type_id is, in fact, the type's var_name, 
		// get the type's id
		if (!is_numeric($type_id))
		{
			$type_id = $this->GetTypeId($type_id);
		}
		
		if (is_numeric($type_id) && $type_id != 0)
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}
		if (is_numeric($categ_id) && $categ_id != 0)
		{
			$conditions .= ' AND category_id = ' . $categ_id;
		}

		if ($type_id && is_numeric($type_id))
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}

		$sql_limit = 'LIMIT ' . $limit;
			
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE 1 ' . $conditions . ' AND is_temp = 0 
		               ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetBasicInfoAdmin();
		}
		return $jobs;
	}
	
	
	// get jobs for API
	public function ApiGetJobs($type_id = false, $categ_id = false, $limit = false, $random, $days_behind, $for_feed = false, $city_id = false)
	{
		global $db;
		
		$jobs = array();
		$conditions = '';
		
		// if $categ_id is, in fact, the category's var_name, 
		// get the categs id
		if (!is_numeric($categ_id))
		{
			$categ_id = $this->GetCategId($categ_id);
		}
		// if $type_id is, in fact, the type's var_name, 
		// get the type's id
		if (!is_numeric($type_id))
		{
			$type_id = $this->GetTypeId($type_id);
		}
		
		if (is_numeric($type_id) && $type_id != 0)
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}
		if (is_numeric($categ_id) && $categ_id != 0)
		{
			$conditions .= ' AND category_id = ' . $categ_id;
		}
		
		if ($days_behind > 0)
		{
			$conditions .=' AND created_on >= DATE_SUB(NOW(), INTERVAL ' . $days_behind . ' DAY)';
		}
		
		if ($for_feed)
		{
			// job was posted more than 10 minutes ago
			$conditions .= ' AND DATE_SUB(NOW(), INTERVAL 10 MINUTE) > created_on';
		}
		
		if ($city_id && is_numeric($city_id))
		{
			$conditions .= ' AND city_id = ' . $city_id;
		}

		if ($random == 1)
		{
			$order = ' ORDER BY RAND() ';
		}
		else
		{
			$order = ' ORDER BY created_on DESC ';
		}

		if($limit > 0)
			$sql_limit = 'LIMIT ' . $limit;
		else
			$sql_limit = '';
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE 1 ' . $conditions . ' AND is_temp = 0 AND is_active = 1  AND created_on > DATE_SUB(NOW(), INTERVAL 31 DAY)
		               ' . $order . ' ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$job = $current_job->GetInfo();
			unset($job['poster_email']);
			unset($job['auth']);
			$jobs[] = $job;
		}
		return $jobs;
	}

	// Get all jobs published by a company
	public function ApiGetJobsByCompany($company = false, $limit = false, $for_feed = false)
	{
		global $db;
		
		$jobs = array();
		$conditions = '';
		
		if ($company)
		{
			$conditions .= ' AND company LIKE "' . $db->real_escape_string($company) . '"';
		}
		
		if ($for_feed)
		{
			// job was posted more than 10 minutes ago
			$conditions .= ' AND DATE_SUB(NOW(), INTERVAL 10 MINUTE) > created_on';
		}
		
		if($limit > 0)
			$sql_limit = 'LIMIT ' . $limit;
		else
			$sql_limit = '';
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE 1 ' . $conditions . ' AND is_temp = 0 AND is_active = 1
		               ORDER BY created_on DESC ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$job = $current_job->GetInfo();
			unset($job['poster_email']);
			unset($job['auth']);
			$jobs[] = $job;
		}
		return $jobs;
	}
	
	public function GetMostAppliedToJobs($limit = false)
	{
		global $db;
		
		$jobs = array();
		
		$sql_limit = 'LIMIT ' . $limit;
					
		$i = 0;
		$sql = 'SELECT ja.job_id, COUNT(ja.id) as nr FROM '.DB_PREFIX.'job_applications ja, '.DB_PREFIX.'jobs jbs WHERE ja.job_id = jbs.id 
		               and jbs.is_temp = 0 AND jbs.is_active = 1 GROUP BY ja.job_id ORDER BY nr DESC ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['job_id']);
			$jobs[$i] = $current_job->GetInfo();
			$jobs[$i]['apps'] = $row['nr'];
			$i++;
		}
		return $jobs;
	}
		
    public function GetAccessRankingJobs($limit = false) {
        global $db;
	
        $jobs = array();

        $sql_limit = 'LIMIT ' . $limit;

        $i = 0;

        $sql = ' SELECT jbs.id, SUM(ar.preview) as preview, MAX(ar.date) as `date`'
                . ' FROM ' . DB_PREFIX . 'access_ranking ar, ' . DB_PREFIX . 'jobs jbs '
                . ' WHERE jbs.id = ar.job_id and jbs.is_temp = 0 AND jbs.is_active = 1 and `date` >= subdate(now(), interval 30 day)'
                . ' GROUP BY ar.job_id '
                . ' ORDER BY preview DESC '
                . $sql_limit;

        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $current_job = new Job($row['id']);
            $jobs[$i] = $current_job->GetInfo();
            $jobs[$i]['apps'] = $row['preview'];
            $i++;
        }
        return $jobs;
    }

	// Search for jobs
	public function Search($keywords, $url_query, $start_page = 1)
	{
		global $db;
		$jobs = array();
		$conditions = '';
		$_SESSION['keywords_array'] = array();
 
		if (SEARCH_METHOD == 'classic')
		{

			$kw1 = $kw2 = $extra_conditions = '';
			$found_city = false;
			
			if (strstr($keywords, ',') || strstr($keywords, ', '))
			{
				$tmp = explode(',', $keywords);
				$kw1 = trim($tmp[0]);
				$kw2 = trim($tmp[1]);
				if ($kw1 == '')
				{
					$kw1 = $kw2;
					$kw2 = '';
				}

			}
			else if (strstr($keywords, ' ') || strstr($keywords, '  '))
			{

				// filter out empty strings (can happen if there are many whitespaces between two words in the search string)
				$tmp = array_filter(explode(' ', $keywords));
				foreach ($tmp as $word)
				{
					// try to find city based on city_id
					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $word . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						if ($found_city)
						{
							$conditions .= ' OR';
						}
 
						$conditions .= ' city_id = ' . $row['id'];
						$found_city = true;
						$keywords = trim(str_replace($word, '', $keywords));
					}
 
					// try to find city based on postcode or location_details
					$sql = 'SELECT id FROM '.DB_PREFIX.'jobs WHERE outside_location LIKE "%' . $word . '%"';
					$results = $db->QueryArray($sql);
					if ($db->affected_rows > 0)
					{
						if ($found_city)
						{
							$conditions .= ' OR ';
						}
						$conditions .= ' id IN (';
						foreach ($results as $j)
						{
							$conditions .= $j['id'] . ',';
							$found_city = true;
						}	
						$conditions = rtrim($conditions, ',');
						$conditions .= ') ';
						$keywords = trim(str_replace($word, '', $keywords));
					}
				}
				if ($found_city)
				{
					$conditions .= ' AND (title LIKE "%' . $keywords . '%" OR company LIKE "%' . $keywords . '%"' .  ' OR description LIKE "%' . $keywords . '%"' .  ' OR poster_email LIKE "%' . $keywords . '%")';	
				}
			}

			if (!$found_city)
			{
				if ($kw1 != '')
				{
					$conditions .= ' (title LIKE "%' . $kw1 . '%" OR description LIKE "%' . $kw1 . '%" OR id = "' . $kw1 . '")';
					$_SESSION['keywords_array'][] = $kw1;
				}
				if ($kw2 != '')
				{
					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $kw2 . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						$extra_conditions .= ' OR city_id = ' . $row['id'];
					}
					$conditions .= ' AND (outside_location LIKE "%' . $kw2 . '%" ' . $extra_conditions . ' OR id = "' . $kw2 . '")';
					$_SESSION['keywords_array'][] = $kw2;
				}
				if ($kw1 == '' && $kw2 == '')
				{
					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $keywords . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						$extra_conditions .= ' OR city_id = ' . $row['id'];
					}
					$conditions = 'title LIKE "%' . $keywords . '%" OR company LIKE "%' . $keywords . '%"' .  ' OR description LIKE "%' . $keywords . '%"' . ' OR poster_email LIKE "%' . $keywords . '%" OR outside_location LIKE "%' . $keywords . '%" OR id = "' . $keywords . '" ' . $extra_conditions;
 
					$_SESSION['keywords_array'][] = $keywords;
				}
			}
 
			$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE is_temp = 0 AND is_active = 1 AND (' . $conditions . ')
		               ORDER BY created_on DESC';
			$result = $db->query($sql);

		}
		else
		{

			$cities = array();
			$check_cities = '';
 
		    $keywords = str_replace(","," ", $keywords);
		    $keywords = str_replace("  "," ", $keywords);
		    $keywords = rtrim($keywords);
 
		    $keywords_a = preg_split( "/[\s,]*\\'([^\\\"]+)\\'[\s,]*|[\s,]+/", $keywords, 0, PREG_SPLIT_DELIM_CAPTURE );
		    function array_trim($a) { $j = 0; for ($i = 0; $i < count($a); $i++) { if ($a[$i] != "") { $b[$j++] = $a[$i]; } } return $b; }
		    $keywords_r = array_trim($keywords_a);
 
		    //Search in Cities
		    for ($i=0; $i < count($keywords_r); $i++)
		    {
		      $sql = 'SELECT id
		                     FROM '.DB_PREFIX.'cities
		                     WHERE name LIKE "%'. $keywords_r[$i] .'%"
		                     ORDER BY ID ASC';
		      $result = $db->query($sql);
		      $cities_line = '';
 
		      while ($row = $result->fetch_assoc())
		      {
		        $cities_line .= $row['id'].' ';
		      }
		      $cities[$i] = $cities_line;
		    }
 
		    //Search in Jobs
		    for ($i=0; $i < count($keywords_r); $i++)
		    {
		        if ($cities[$i] != "") {
		          $cities[$i] = rtrim($cities[$i]);
		          $cities_r = explode(' ', $cities[$i]);
 
		          for ($a=0; $a < count($cities_r); $a++)
		          {
		            $check_cities .= 'OR city_id = "'.$cities_r[$a].'" ';
		          }
		        }
		        $conditions .= 'AND (title LIKE "%' . $keywords_r[$i] . '%" OR description LIKE "%' . $keywords_r[$i] . '%" OR poster_email LIKE "%' . $keywords[$i] . '%" OR outside_location LIKE "%' . $keywords_r[$i] . '%" '.$check_cities.' ) ';
		    }
 
			$sql = 'SELECT id
					FROM '.DB_PREFIX.'jobs
					WHERE is_temp = 0 AND is_active = 1 '. $conditions .'
					ORDER BY created_on DESC';
			$result = $db->query($sql);			
		}//
 
		$pages = '';
		$id_array = '';
		$max_loop = SEARCH_RESULTS_PER_PAGE;
		$max_visible_pages = SEARCH_AMOUNT_PAGES;
 
		while ($row = $result->fetch_assoc()) $id_array[] = $row['id'];
 
		$start_count = (($start_page - 1) * $max_loop) ;
		$current_loop = 0;
 
		$total_results = count($id_array);
		$total_loop = ($total_results ) - $start_count;
 
		$total_pages = ceil($total_results / $max_loop);
 
		if ($total_pages > 1)
		{
 
			$pagination_loop = $start_page - ($max_visible_pages / 2);
 
			if ($pagination_loop < 1) $pagination_loop = 1;
			elseif (($pagination_loop - 1) > 0) $pages .= "&nbsp;<a href='".BASE_URL."search/".$url_query."/?p=".($pagination_loop - 1)."'>&laquo;</a>&nbsp;";
 
			$pagination_top = $pagination_loop + $max_visible_pages + 1;
 
			while (($pagination_loop < ($total_pages+1)) && ($pagination_loop < $pagination_top))
			{
				if ($pagination_loop == $start_page) $pages .= "&nbsp;<a class='current_page'>$pagination_loop</a>&nbsp;";
				else $pages .= "&nbsp;<a href='".BASE_URL."search/".$url_query."/?p=$pagination_loop'>$pagination_loop</a>&nbsp;";
				$pagination_loop++;	
			}
 
			if ($pagination_loop == $pagination_top) $pages .= "&nbsp;<a href='".BASE_URL."search/".$url_query."/?p=".($pagination_loop)."'>&raquo;</a>&nbsp;";
 
		}
 
		if ($id_array != '')
		{
			while (($current_loop < $total_loop) && ($current_loop < ($max_loop )))
			{
				$current_job = new Job($id_array[$start_count]);
				$jobs[] = $current_job->GetInfo();
				$current_loop++;
				$start_count++;
			}
		}
 
		$_SESSION['search_results'] = $jobs;
		$_SESSION['search_pagination'] = $pages;
		return $jobs;
	}


    /*
     *@desc Search job advance
     *@params array $params, $start_page
     * Auth Sinh Nguyen
     */
    public function AdvancedSeach(array $params, $start_page = 1)
    {
        global $db;
        $jobs = array();
        if (empty($params)) {
            return;
        }

        $sql = 'SELECT id FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1';
        if (isset($params['nationality'])) {
            $sql .= ' AND nationality = '. intval($params['nationality']);
        }
        if (!empty($params['type_id'])) {
            $sql .= ' AND type_id IN('.implode(',',$params['type_id']).')';
        }
        if (!empty($params['category_id'])) {
            $sql .= ' AND category_id IN('.implode(',',$params['category_id']).')';
        }
        if (isset($params['workaddress_type'])) {
            if ($params['workaddress_type'] === 'japan') {
                $sql.= ' AND country_id = 114';
                if (!empty($params['area_id'])) {
                    $sql .= ' AND area_id IN('.implode(',',$params['area_id']).')';
                }
            } else {
                $sql.= ' AND country_id NOT IN (0,114)';
                if (!empty($params['continents_id'])) {
                    $sql .= ' AND continents_id IN('.implode(',',$params['continents_id']).')';
                }
            }
        }

        if (isset($params['keyword']) && ($keyword = trim($params['keyword'])) != '') {
            $keyword = str_replace(',', ' ', urldecode($keyword));
            $keyword = str_replace('  ', ' ', urldecode($keyword));
            $keyword = str_replace('"', '', urldecode($keyword));

            $keywords = explode(' ', $keyword);
            $arrKeyword = array();

            foreach ($keywords as $key) {
                $arrKeyword[] = 'title LIKE "%' . $key . '%" OR description LIKE "%' . $key . '%" OR poster_email LIKE "%' . $key . '%" OR outside_location LIKE "%' . $key . '%"';
            }
            $sql.= ' AND (('.implode(') OR (', $arrKeyword).'))';

        }
        $sql .= ' ORDER BY created_on DESC';
        $queryResult = $db->query($sql);

        $pages = '';
        $id_array = array();
        $max_loop = SEARCH_RESULTS_PER_PAGE;
        $max_visible_pages = SEARCH_AMOUNT_PAGES;

        while ($row = $queryResult->fetch_assoc()) $id_array[] = $row['id'];
        $start_count = (($start_page - 1) * $max_loop) ;
        $current_loop = 0;

        $total_results = count($id_array);
        $total_loop = ($total_results ) - $start_count;

        $total_pages = ceil($total_results / $max_loop);

        if ($total_pages > 1)
        {
            $baseUrl = !IS_MOBILE ? BASE_URL : BASE_URL.'mobile/';
            $pagination_loop = $start_page - ($max_visible_pages / 2);
            $keyword = $keyword != '' ? '/'.$keyword : '';
            if ($pagination_loop < 1) {
                $pagination_loop = 1;
            } elseif (($pagination_loop - 1) > 0) {
                $pages .= "&nbsp;<a href='".$baseUrl."find-new-job".$keyword."/?p=".($pagination_loop - 1)."'>&laquo;</a>&nbsp;";
            }

            $pagination_top = $pagination_loop + $max_visible_pages + 1;

            while (($pagination_loop < ($total_pages+1)) && ($pagination_loop < $pagination_top))
            {

                if ($pagination_loop == $start_page) {
                    $pages .= "&nbsp;<a class='current_page'>$pagination_loop</a>&nbsp;";
                } else {
                    $pages .= "&nbsp;<a href='".$baseUrl."find-new-job".$keyword."/?p=$pagination_loop'>$pagination_loop</a>&nbsp;";
                }

                $pagination_loop++;
            }

            if ($pagination_loop == $pagination_top) $pages .= "&nbsp;<a href='".$baseUrl."find-new-job".$keyword."/?p=".($pagination_loop)."'>&raquo;</a>&nbsp;";

        }

        if ($id_array != '')
        {
            while (($current_loop < $total_loop) && ($current_loop < ($max_loop )))
            {
                $current_job = new Job($id_array[$start_count]);
                $jobs[] = $current_job->GetInfo();
                $current_loop++;
                $start_count++;
            }
        }

        $_SESSION['search_results'] = $jobs;
        $_SESSION['search_pagination'] = $pages;
        $_SESSION['total_jobs'] = $total_results;
        return $jobs;


    }

	
	public function GetCategId($var_name)
	{
		global $db;
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'categories
		               WHERE var_name = "' . $var_name . '"';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['id'];
	}
	
	public function GetTypeId($var_name)
	{
		global $db;
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'types
		               WHERE var_name = "' . $var_name . '"';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['id'];
	}
	
	public function GetTempStatus()
	{
		return $this->mIsTemp;
	}
	
	public function GetActiveStatus()
	{
		return $this->mIsActive;
	}
	
	public function GetAuth()
	{
		return $this->mAuth;
	}
	
	public function IncreaseViewCount()
	{
		global $db;
		// check if user has hit this page in the past hour
		$ip = $_SERVER['REMOTE_ADDR'];
    //extract number of hits on last hour
    $sql = 'SELECT count(*) AS hits_last_hour '.
           'FROM '.DB_PREFIX.'hits WHERE job_id = ' . $this->mId . ' AND ip = "' . $ip . '" AND '.
           'created_on >= DATE_ADD(NOW(),INTERVAL -1 HOUR)';
		$result = $db->QueryItem($sql);
		
		// ok to increase view count
		if ($result < MAX_VISITS_PER_HOUR)
		{
			// update hits table
			$sql = 'INSERT INTO '.DB_PREFIX.'hits (job_id, created_on, ip)
			                    VALUES (' . $this->mId . ', NOW(), "' . $ip . '")';
			$db->query($sql);
			
			// update jobs table
			$sql = 'UPDATE '.DB_PREFIX.'jobs SET views_count = views_count + 1
										 WHERE id = ' . $this->mId;
			$db->query($sql);	
		}
	}
	
    public function UpdateRanking() {
        global $db;

        $date = date('Y-m-d H:i:s');

        $sql = ' SELECT * '
                . ' FROM ' . DB_PREFIX . 'access_ranking '
                . ' WHERE job_id = ' . $this->mId . ' AND DATE_FORMAT(date, "%Y-%m-%d") LIKE DATE_FORMAT(NOW(), "%Y-%m-%d") ';
        $result = $db->queryRow($sql);

        if ($result == NULL) {
            $sql = ' INSERT INTO ' . DB_PREFIX . 'access_ranking (`job_id`, `date`, `preview`) VALUES '
                    . ' (' . $this->mId . ', "' . $date . '", 1) ';
            $db->query($sql);
        } else {
            $current = strtotime($date);
            $timestamp = strtotime($result['date']);
            // 300 (s) = 60 * 5 (s) => 5 min
            // 60 (s) = 60 * 1 (s) => 1 min
            if (($current - $timestamp) < 60) {
                // valid
            } else {
                // expired
                $sql = ' UPDATE ' . DB_PREFIX . 'access_ranking '
                        . ' SET `date` = "' . $date . '", preview =  preview + 1 '
                        . ' WHERE id = ' . $result['id'];

                $db->query($sql);
            }
        }
    }

	//compress text, 
	//		eg: FROM <p>We are<br /> \"champion\" &amp; , I'm&nbsp; happy <img src=\"/jobberbase/uploads/Penguins.jpg\" alt=\"\" width=\"428\" height=\"321\" /> 私はイタリア人　です。</p> 
	// 		=>  TO wearechampionampimhappy私はイタリア人です
	
	private function format_text ($text)
	{
		//remove tags
		$format_text = strip_tags($text);
		
		//remove japanese punctuation
		$jp_punctuation = array(' 　','、','。','，','．','・','：','；','？','！','゛','゜','´','｀','¨','＾','￣','＿','ヽ','ヾ','ゝ','ゞ','〃','仝','々','〆','〇','ー','―','‐','／','＼','～','∥','｜','…','‥','"','"','（','）','〔','〕','［',' ］','｛','｝','〈','〉','《','》','「','」','『','』','【','】','＋','－','±','×','÷','＝','≠','＜','＞','≦','≧','∞','∴','♂','♀','°','′','″','℃','￥','＄','￠','￡','％','＃','＆','＊','＠','§','☆','★','○','●','◎','◇','◆','□','■','△','▽','▼','※','〒','→','←','↑','↓','≪','≫');
		
		$format_text = str_replace($jp_punctuation,'',$format_text);

		//remove return to line
		$format_text = str_replace("\\r\\n",'',$format_text);
		
		//remove some special caracteres ' " \ &nbsp;
		$format_text = str_replace(array("\\","'","\"","&nbsp;"),'',$format_text);
		
		//remove all spaces
		$format_text = preg_replace('/\s+/', '', trim($format_text));
		
		//set to lowercase
		$format_text = mb_strtolower($format_text);
		
		//remove all punctuation
		$format_text = preg_replace('/[^a-z0-9あ-んア-ンぁ-んァ-ヶ亜-腕０-９ａ-ｚ]+/i', '', $format_text);
		return $format_text;
		

	}
	
	//Check if the post already exist
	public function ExistJob($params, $id_edit = 0)
	{
		global $db;
		
		//set id rule, you while editing post 
		if( $id_edit != 0 &&  $id_edit!= '' )
		{
			$id_rule='AND id <> "'.$id_edit.'"';
		}
		else
			$id_rule='';
				
		//set description
		$description_send = $this->format_text($params['description']);
					
		//first, check if we got same existing data for title, posteremail, category
		$sql = 'SELECT count(id) as number
		               FROM '.DB_PREFIX.'jobs
		               WHERE LOWER(LTRIM(RTRIM(title))) = "' . strtolower(trim($params['title'])) . '" and poster_email ="' . $params['poster_email'] . '" and category_id ="' . $params['category_id'] . '" and is_active = 1 '.$id_rule.' ';
					   
		$result = $db->query($sql);
		
		$exist='';
		$period=31;
		
		while ($row = $result->fetch_assoc())
		{			
			//if we've got data compare description
			if($row['number'] >0)
			{
				$sql_desc = 'SELECT description, created_on
						     FROM '.DB_PREFIX.'jobs
				  			 WHERE  LOWER(LTRIM(RTRIM(title))) = "' . strtolower(trim($params['title'])) . '" and poster_email ="' . $params['poster_email'] . '" and category_id ="' . $params['category_id'] . '" and is_active = 1 '.$id_rule.' ';
				$result_desc = $db->query($sql_desc);
		
				while ($rows = $result_desc->fetch_assoc())
				{
					$desc = $this->format_text($rows['description']);
					
					if($desc == $description_send)
					{
						//check time period
						list($date,$time)=explode(' ',$rows['created_on']);
						list($year,$month,$day)=explode('-',$date);
					
					
						$end_of_waiting_period = date("Y-m-d", mktime(0, 0, 0, $month, ($day+$period), $year));
					
						if(date('Y-m-d') > $end_of_waiting_period)
							$exist .= 'no';
						else
						{
							$exist .= 'yes';
							$waiting_until = $end_of_waiting_period;
						}
						
					}
					else
						$exist .= 'no';
				}
				
				if(!isset($waiting_until))
					$waiting_until=0;
					
				//if yes we set variable to true
				if(substr_count($exist, 'yes') > 0)
					$exist=true;
				else
					$exist=false;
				
			}
			else
			{
				$waiting_until=0;
				$exist=false;
			}
		}
		
		return array( 	'exist' 		 => $exist,
						'waiting-period' => $waiting_until	
					);
				
	}

	// Create a new job post
	public function Create($params)
	{
		global $db;


		if ($params['apply_online'] == 1)
		{
			$params['apply_online'] = 1;
		}
		else
		{
			$params['apply_online'] = 0;
		}
		$sql = 'INSERT INTO '.DB_PREFIX.'jobs (nationality,type_id, category_id, title, description, company,continents_id, country_id, area_id, city_id, url, apply, created_on, is_temp, is_active,
			                       views_count, auth, poster_email, apply_online, spotlight, details, address, requ, wage,image1,image2,image3,date_end,application_expired)
								 VALUES (
								 ' . $params['nationality'] . ',
								 ' . $params['type_id'] . ',
										 ' . $params['category_id'] . ',
										 "' . $params['title'] . '",
										 "' . $params['description'] . '",
										 "' . $params['company'] . '",
										 ' . $params['continents_id'] . ',
										 ' . $params['country_id'] . ',
										 ' . $params['area_id'] . ',
										 ' . $params['city_id'] . ',
										 "' . $params['url'] . '",
										 "' . $params['apply'] . '",
										 NOW(), ' . $params['is_temp'] . ', '. $params['is_active'] .', 0, "' . $this->GenerateAuthCode() . '",
										 "' . $params['poster_email'] . '
										 ", ' . $params['apply_online'] . '
		                                 , ' . $params['spotlight'] . ',
		                                 "'. $params['details']. '",
		                                 "'. $params['address']. '",
		                                 "'. $params['requ']. '",
		                                 "'. $params['wage']. '",
		                                 "'.$params["image1"].'",
		                                 "'.$params["image2"].'",
		                                 "'.$params["image3"].'",
		                                 "'.$params["date_end"].'",
										  "'.$params["application_expired"].'")';
		$result = $db->query($sql);
		
		return $db->insert_id;
	}
	
	// Edit an existing job post
	public function Edit($params)
	{
		global $db;

		if ($params['city_id'] == '' || $params['city_id'] == 0)
		{
			$params['city_id'] = 0;
		}

		if ($params['apply_online'] == 1)
		{
			$params['apply_online'] = 1;
		}
		else
		{
			$params['apply_online'] = 0;
		}
        $params['country_id'] = (empty($params['country_id']))?0:$params['country_id'];

        $update_image = "";
        if(!empty($params["image1"])) $update_image .= ", image1= '".$params["image1"]."'";
        if(!empty($params["image2"])) $update_image .= ", image2= '".$params["image2"]."'";
        if(!empty($params["image3"])) $update_image .= ", image3= '".$params["image3"]."'";

		$sql = 'UPDATE '.DB_PREFIX.'jobs SET type_id = ' . $params['type_id'] . ',
        										category_id = ' . $params['category_id'] . ',
										        title = "' . $params['title'] . '",
										        description = "' . $params['description'] . '",
										        company = "' . $params['company'] . '",
										        continents_id = ' . $params['continents_id'] . ',
										        country_id = ' . $params['country_id'] . ',
										        area_id = ' . $params['area_id'] . ',
										        city_id = ' . $params['city_id'] . ',
										        nationality = ' . $params['nationality'] . ',
										        url = "' . $params['url'] . '",
											details = "'. $params['details'] .'",
											address = "'. $params['address'] .'",
											requ = "'. $params['requ'] .'",
											date_end = "'. $params['date_end'] .'",
											wage = "'. $params['wage'] .'",
										        apply = "' . $params['apply'] . '",
												application_expired = "' . $params['application_expired'] . '",
														poster_email = "' . $params['poster_email'] . '",
														apply_online = "' . $params['apply_online'] . '"
                                                '.$update_image.'
										        WHERE id = ' . $this->mId;

        $result = $db->query($sql);
	}
	
	// Publishes a newly created job post (is_temp => 0)
	public function Publish()
	{
		global $db;
		
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_temp = 0 WHERE id = ' . $this->mId;
		
		$db->query($sql);
	}
	
	// Activate an inactive job post
	public function Activate()
	{
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_active = 1 WHERE id = ' . $this->mId;
		$db->query($sql);
	}
	
	// Deactivate an active job post
	public function Deactivate()
	{
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_active = 0 WHERE id = ' . $this->mId;
		$db->query($sql);
	}
	
	// Activate spotlight-feature for a job post
    public function SpotlightActivate()
    {
        global $db;
        $sql = 'UPDATE ' . DB_PREFIX . 'jobs SET spotlight = 1, spotlight_udate = NOW() WHERE id = ' . $this->mId;
        $db->query($sql);
    }
    
    // Deactivate spotlight-feature for a job post
    public function SpotlightDeactivate()
    {
        global $db;
        $sql = 'UPDATE '.DB_PREFIX.'jobs SET spotlight = 0 WHERE id = ' . $this->mId;
        $db->query($sql);
    }
	
    public function SpotlightCronUpdate() {
        global $db;

        $sql = ' UPDATE ' . DB_PREFIX . 'jobs '
                . ' SET spotlight = 0 '
                . ' WHERE spotlight = 1 AND spotlight_udate IS NOT NULL '
                . ' AND spotlight_udate <= subdate(now(), interval 2 week) ';
        
        $db->query($sql);
    }

	// Extend a post for 30 days
	public function Extend()
	{
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET created_on = NOW(), is_active = 1 WHERE id = ' . $this->mId;
		if ($db->query($sql))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// Make a post temporary
	public function MarkTemporary()
	{
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_temp = 1 WHERE id = ' . $this->mId;
		$db->query($sql);
	}
	
	// Delete a job post
	public function Delete()
	{
		global $db;
		$sql = 'DELETE FROM '.DB_PREFIX.'jobs WHERE id = ' . $this->mId;
		$db->query($sql);
	}
	
	// Delete a job post and all aditional information
	public function DeleteJobAdmin()
	{
		global $db;
			
		$sql = 'DELETE FROM '.DB_PREFIX.'hits WHERE job_id  = ' . $this->mId;
		$res = $db->query($sql);	
		
		$sql = 'DELETE FROM '.DB_PREFIX.'job_applications WHERE job_id  = ' . $this->mId;
		$res = $res && $db->query($sql);
		
		$sql = 'DELETE FROM '.DB_PREFIX.'spam_reports WHERE job_id  = ' . $this->mId;
		$res = $res && $db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'jobs WHERE id  = ' . $this->mId;
		$res = $res && $db->query($sql);
		
		return ($res==false)?$res:true;
	}
	public function MakeValidUrl($string)
	{
		$string = urlencode($string);
		return $string;
	}
	
	public function Exists()
	{
		if ($this->mCreatedOn != '')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function GenerateAuthCode()
	{
		$auth = md5($this->mId . uniqid() . time());
		return $auth;
	}
	
	public function CountJobs($categ = false, $type = false)
	{
		global $db;
		$condition = '';
	 	
		if ($type)
		{
			if (!is_numeric($type))
			{
				$type_id = $this->GetTypeId($type);
			}
			else
			{
				$type_id = $type;
			}
			
			$condition .= ' AND type_id = ' . $type_id;
		}
		
		if ($categ)
		{
			if (!is_numeric($categ))
			{
				$categ_id = $this->GetCategId($categ);
			}
			else
			{
				$categ_id = $categ;
			}
			
			$condition .= ' AND category_id = ' . $categ_id;
		}

		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1' . $condition;
		
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];	
	}
	
	public function CountJobsOfType($type_id)
	{
		global $db;

		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1 AND type_id = ' . $type_id;
		
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}
	
	public function GetJobsCountForAllCategs()
	{
		global $db;
		$jobsCountPerCategory = array();
		
		$sql = 'SELECT category_id, COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1 GROUP BY category_id'; 
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
			$jobsCountPerCategory[$row['category_id']] = $row['total'];
			
		$categs = get_categories();
		$result = array();
		foreach ($categs as $categ)
		{
			$count = 0;
			
			// this check is needed because we don't have an entry if there are no jobs for a category
			if (isset($jobsCountPerCategory[$categ['id']]))
				$count = $jobsCountPerCategory[$categ['id']];
				
			$result[] = array('categ_name' => $categ['name'], 'UTF-8', 'categ_count' => $count, 'categ_varname' => $categ['var_name']);
		}
		return $result;
	}
	
	public function GetJobsCountPerCity()
	{
		global $db;
		$jobsCountPerCity = array();
		
		$sql = 'SELECT city_id, COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1 and city_id IS NOT NULL GROUP BY city_id'; 
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
			$jobsCountPerCity[$row['city_id']] = $row['total'];
			
		$cities = get_cities();
		$result = array();

		foreach ($cities as $city)
		{
			$numberOfJobsInCity = 0;
			
			// this check is needed because we don't have an entry if there are no jobs for a city
			if (isset($jobsCountPerCity[$city['id']]))
				$numberOfJobsInCity = $jobsCountPerCity[$city['id']];

			$result[] = array('city_name' => $city['name'], 'jobs_in_city' => $numberOfJobsInCity, 'city_ascii_name' => $city['ascii_name']);
		}
		
		return $result;
	}
	
	public function GetJobsCountForCity($city_id, $type)
	{
		global $db;
		
		$condition = '';
		
		if ($city_id)
		{
			$condition = ' AND city_id = ' . $city_id;
		}
		else
		{
			$condition = ' AND city_id IS NULL';
		}
		
		if ($type)
		{
			if (!is_numeric($type))
			{
				$type_id = $this->GetTypeId($type);
			}
			else
			{
				$type_id = $type;
			}
			
			$condition .= ' AND type_id = ' . $type_id;
		}
		
		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1'. $condition;

		$result = $db->query($sql);
		
		$row = $result->fetch_assoc();
		
		return $row['total'];
	}
	
	public function GetNumberOfJobsInOtherCities()
	{
		global $db;
		
		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1 AND city_id IS NULL';

		$result = $db->query($sql);
		
		$row = $result->fetch_assoc();
		
		return $row['total'];
	}
	
	public function GetPaginatedJobsForOtherCities($type_id = false, $firstLimit = false, $lastLimit = false)
	{
		global $db;
		$jobs = array();
		$conditions = '';
		
		// if $type_id is, in fact, the type's var_name, 
		// get the type's id
		if (!is_numeric($type_id))
		{
			$type_id = $this->GetTypeId($type_id);
		}
		
		if (is_numeric($type_id) && $type_id != 0)
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}

		if ($firstLimit >= 0 && $lastLimit >= 0)
		{
			$sql_limit = 'LIMIT ' . $firstLimit .', ' . $lastLimit;
		}
		else
		{
		        $sql_limit = '';        
		}
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE city_id IS NULL' . $conditions . ' AND is_temp = 0 AND is_active = 1
		               ORDER BY created_on DESC ' . $sql_limit;
		
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		return $jobs;
	}
	
	// Check if the poster of this post has posted before with this e-mail address
	public function IsApprovedPosterEmail()
	{
		global $db;
		$sql = 'SELECT poster_email FROM '.DB_PREFIX.'jobs 
		                  WHERE poster_email = "' . strtolower($this->mPosterEmail) . '" AND id <> ' . $this->mId . ' AND is_temp = 0
 		                        AND (is_active = 1 OR (is_active = 0 AND created_on < DATE_SUB(NOW(), INTERVAL 30 DAY)))';

		$result = $db->query($sql);
				
		$row = $result->fetch_assoc();
		if (!empty($row['poster_email']))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function GetApplicationsStatistics($jobIDs)
	{
		global $db;

		$statisticalData = array();
		
		$sql = 'SELECT job_id, count(id) numberOfApplications, DATE_FORMAT(max(created_on), "' . DATE_TIME_FORMAT . '") lastApplicationOn
				FROM '.DB_PREFIX.'job_applications j 
				WHERE job_id in (' . $this->buildCommaSeparatedIDsString($jobIDs) . ') GROUP BY job_id'; 
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
			$statisticalData[$row['job_id']] = $row;
			
		return $statisticalData;
	}
	
	public function GetSpamReportStatistics($jobIDs)
	{
		global $db;
		
		$statisticalData = array();
		
		$sql = 'SELECT job_id, count(id) numberOfSpamReports, DATE_FORMAT(max(the_time), "' . DATE_TIME_FORMAT . '") lastSpamReportOn 
				FROM '.DB_PREFIX.'spam_reports 
				WHERE job_id in (' . $this->buildCommaSeparatedIDsString($jobIDs) . ') GROUP BY job_id'; 
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
			$statisticalData[$row['job_id']] = $row;
			
		return $statisticalData;
	}
	
	private function buildCommaSeparatedIDsString($numbersArray)
	{
		$string = '';
		
		for ($i = 0; $i < count($numbersArray); $i++)
		{
			$string .= $numbersArray[$i];

			if ($i < count($numbersArray) - 1)
				$string .= ',';
		}
		
		return $string;
	}

	public static function GetPostDateend(){ // get post date end < now
		global $db;
		$sanitizer = new Sanitizer;
		$sql = "SELECT id,poster_email,auth,title,company FROM jobs WHERE date_end != '0000-00-00 00:00:00' AND date_end < '".date("Y-m-d H:i:s")."' AND date_end IS NOT NULL AND application_expired = 0";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$list = array();
		while ($row = $result->fetch_assoc()){
			$mTitle = str_replace('&', '&amp;', $row['title']);
			$mCompany = $row['company'];
			$row["url_title"] = $sanitizer->sanitize_title_with_dashes($mTitle . ' at ' . $mCompany);
			$row['poster_email'] = trim($row['poster_email']);
			$list[] =  $row;
		}

		return $list;

	}
	public function UpdatePostDateEnd($ids){ // update status sendmail
		global $db;
		foreach($ids as $id){
			$sql = "UPDATE jobs SET application_expired=1 WHERE id = $id";
			$db->query($sql);
		}
	}
}
?>