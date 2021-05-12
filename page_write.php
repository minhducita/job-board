<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
   //check ajax captcha
    $resp = recaptcha_check_answer(CAPTCHA_PRIVATE_KEY,
        $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);
    if (!$resp->is_valid){
        $_SESSION['active_capcha'] = 0;
        echo $translations['captcha']['captcha_error'];
    }
    else{
       $_SESSION['active_capcha'] = 1;
       echo 'null';
    }
    exit;
}
$captcha_enabled = ENABLE_RECAPTCHA && ENABLE_CAPTCHA_ON_POST_PAGE;
$smarty->assign('ENABLE_RECAPTCHA', $captcha_enabled);
if ($captcha_enabled)
{
	$smarty->assign('the_captcha', recaptcha_get_html(CAPTCHA_PUBLIC_KEY));
}

$later_edit = false;
$smarty->assign('errorsStep',0);
if ($id != 0)
{
	$j = new Job($id);
}

$nationalities = array('Japanese','Not Japanese','Either');

$smarty->assign('nationalities', $nationalities);

// if auth code used, check it and allow editing
if ($id != 0 && $extra != '' && $extra == $j->GetAuth()){
	$later_edit = true;
	$_SESSION['later_edit'] = $extra;
}
else
{
	if ($id != 0 && isset($_SESSION['later_edit']) && $_SESSION['later_edit'] == $j->GetAuth() && $j->GetAuth() != '')
	{
		$later_edit = true;
	}
}

// security: prevent later editing, by forced redirection
if (!$later_edit && $id != 0)
{
	$j = new Job($id);
	if ($j->GetTempStatus() != 1 || $j->GetActiveStatus() != 0)
	{
		redirect_to($baseUrl . URL_JOB .'/' . $id . '/');
		exit;
	}
}

// this branch executes when returning to edit a post

if (($_SERVER['HTTP_REFERER'] == $baseUrl .'verify/' . $id . '/' && $id != 0) || $later_edit)
{
	$_SESSION['referer'] = $baseUrl . 'post/';
	$job = new Job($id);
	$jobs = $job->GetInfo();

	$jobs["count_image"] = 0;
	for($i=1;$i<=3;$i++){
		if(!empty($jobs["image".$i]) && $jobs["image".$i] != "NULL" ){
			$jobs["count_image"] += 1;
		}
	}

	$jobs["class_image"] = "div_upload".$jobs["count_image"];
	$jobs["date_end"] = ($jobs['date_end'] !='0000-00-00 00:00:00' && $jobs['date_end']) ? date("d M Y",strtotime($jobs["date_end"])) : null;
	$jobs['description'] = $textile->noTextile($jobs['description']);

	if (strstr($jobs['url'], 'http://'))
	{
		$jobs['url'] = substr($jobs['url'], 7, strlen($jobs['url']));
	}
	$smarty->assign('job', $jobs);
}
// this branch executes after first writing a post and hitting the submit button
if (!empty($_POST['action']) && $_POST['action'] == 'publish')
{
	if(!empty($_POST['email']))
		$_POST['email'] = trim($_POST['email']);
	escape($_POST);
	$errors = array();

	$_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];

	$_SESSION['referer'] = $baseUrl . 'post/';

	// validation
	if ($captcha_enabled && $_SESSION['active_capcha'] == 0)
	{
		$resp = recaptcha_check_answer(CAPTCHA_PRIVATE_KEY,
			$_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
		if (!$resp->is_valid){

			$errors['captcha'] = $translations['captcha']['captcha_error'];
			//in mobile
			$smarty->assign('errorsStep',2);
		}
	}

	if (!isset($type_id) || !is_numeric($type_id))
	{
		$errors['input_id'] = $translations['jobs']['type_error'];
	}

	if ($company == '')
	{
		$errors['company'] = $translations['jobs']['name_error'];
	}
	if ($title == '')
	{
		$errors['title'] = $translations['jobs']['title_error'];
	}
	if ($description == '')
	{
		$errors['description'] = $translations['jobs']['description_error'];
	}
	if ($poster_email == '')
	{
		$errors['poster_email'] = $translations['jobs']['email_error'];
	}


	if (!validate_email($poster_email))
	{
		$errors['poster_email'] = $translations['jobs']['email_invalid'];
	}

	if (isset($apply_online) && $apply_online == 'on')
	{
		$apply_online = 1;
	}
	else
	{
		$apply_online = 0;
	}
	/* Nam cap nhat */
	if(!empty($_FILES["file"])){ // upload file image
		$upload = new Upload;
		$resize = new ResizeImage;
		// config umage upload

		$dir_upload = ($isMobile)?"../uploads/job/":"uploads/job/";
		$config['upload_path'] 	 = $dir_upload."root";
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$check_type_img = explode("|",$config['allowed_types']);
		$config['max_size']	= '2048';
		$count_file = count($_FILES["file"]);
		// check before saving
		for($i=0; $i<$count_file; $i++){
			if(!empty($_FILES['file']['name'][$i])){
				$file_type 			= explode(".",$_FILES['file']['name'][$i]);
				$file_type 			= strtolower($file_type[count($file_type)-1]);
				list($width, $height, $type, $attr)	= @getimagesize($_FILES['file']['tmp_name'][$i]);
				if(!in_array($file_type,$check_type_img)){
					$errors['file'] = $translations['upload']['error_type_img']." (".$_FILES['file']['name'][$i].")";
				}
				$fileSize = $_FILES['file']['size'][$i]/1024;//kbyte

				if($fileSize>$config['max_size'] or $fileSize == 0){
					$errors['file'] = /*$translations['upload']['error_size_img'].*/" Maximum file size is 2M for each file (".$_FILES['file']['name'][$i].")";
				}
			}
		}
		// save image
		if(empty($errors)){
			$_FILES['userfile'] = "";
			//config image thumb
			$config_thumb['image_library'] 	= 'gd2';
			$config_thumb['create_thumb'] 	= TRUE;
			$config_thumb['maintain_ratio'] = TRUE;
			$config_thumb['width']			= 640;
			$config_thumb['height']			= 384;
			for($i=0; $i<$count_file; $i++){
				if(!empty($_FILES['file']['name'][$i])){
					$_FILES['userfile']['name']			= $_FILES['file']['name'][$i];
					$_FILES['userfile']['type']			= $_FILES['file']['type'][$i];
					$_FILES['userfile']['tmp_name']		= $_FILES['file']['tmp_name'][$i];
					$_FILES['userfile']['error']		= $_FILES['file']['error'][$i];
					$_FILES['userfile']['size']			= $_FILES['file']['size'][$i];
					$upload->initialize($config);
					$list_image[$i] = $upload->do_upload("userfile");
					//if($list_image[$i][0] === 0 and ($list_image[$i][1]["width"] > $config_thumb['width'] or $list_image[$i][1]["height"] > $config_thumb['height'])){

                        $config_thumb['new_image'] 		= $dir_upload.$list_image[$i][1]["images"];
                        $config_thumb['source_image']	= $dir_upload.'root/'.$list_image[$i][1]["images"];
                        $resize->clear();
                        $resize->initialize($config_thumb);
                        $resize->resize();
					//}
					$data_image["image".($i+1)] = str_replace("../","",$config_thumb['new_image']) ;
				}
			}

		}
	}
	/* Nam cap nhat */
	// no errors, go to review page
	if (empty($errors))
	{
        unset($_SESSION['active_capcha']);
		if (!strstr($url, 'http://'))
		{
			$url = 'http://' . $url;
		}
		if (!isset($city_id))
		{
			$city_id = 0;
		}
		else
		{
			// if a city is selected, we must clear the 'other' location
			$location_outside_ro_where = '';
		}
		$continents = !is_numeric($continents) ? (($continents_id = get_continents_primaryKey_byName($continents)) ? $continents_id : 0) : $continents;
		$country    = !is_numeric($country) ? (($country_id = get_country_primaryKey_byName($country)) ? $country_id : 0) : $country;
		$area     = !is_numeric($area) ? (($area_id = get_japan_area_by_name_or_prefectures_name($area, $prefectures)) ? $area_id : 0) : $area;

		$data = array('company' => $company,
			'url' => $url,
			'title' => $title,
			'continents_id' => $continents,
			'country_id' => $country,
			'area_id' => $area,
			'city_id' => $city_id,
			'nationality' => $nationality,
			'category_id' => $category_id,
			'type_id' => $type_id,
			'description' => $description,
			'is_temp' => 1,
			'is_active' => 0,
			'apply' => '',
			'poster_email' => $poster_email,
			'apply_online' => $apply_online,
			'details' => $details,
			'address' => $address,
			'requ' => $requ,
			'wage' => $wage,
			'date_end' => $date_end ? date("Y-m-d",strtotime($date_end)): null,
			'spotlight' => 0);

		if(!empty($data_image)) $data += $data_image;
		//set $job_id to control the editing/creating action
		if(isset($_SESSION['edit_id']) && $_SESSION['edit_id'] != '')
			$job_id = $_SESSION['edit_id'];
		else
			$job_id = 0;

		//Data already exist?
		$existjob = $job->ExistJob($data, $job_id);


		if($existjob['exist']){
			$message = 'You\'ve already posted an identical job vacancy within a month!<br />Please change the details or wait for the monthly period to end (until: '.$existjob['waiting-period'].')';
		}
		else
		{
			$message = '';

			//Edit only when error is occuring

			if(isset($_SESSION['edit_id']) && $job_id == $_SESSION['edit_id'] && $job_id != '' && $job_id != 0 ){
				$job = new Job($job_id);

				$job->Edit($data);

				//where is set $auth ?
				if (!empty($auth))
				{
					$add = $auth . '/';
				}
				else
				{
					$add = '';
				}

				$_SESSION['edit_id'] = 0;

				redirect_to($baseUrl . 'verify/' . $job_id . '/' . $add);
				exit;

			}
			else{
				$id = $job->Create($data);
				$_SESSION['edit_id'] = 0;
				redirect_to($baseUrl . 'verify/' . $id . '/');
				exit;
			}
		}

	}
	// if errors exist, go back and edit the post
	else
	{
		$smarty->assign('errors', $errors);
	}
}
else if (!empty($_POST['action']) && $_POST['action'] == 'edit' /*&& $_SERVER['REMOTE_ADDR'] == $_SESSION['user_ip']*/)
{
	$job = new Job($_POST["job_id"]);
	$jobs = $job->GetInfo();
	escape($_POST);
	$errors = array();
	$_SESSION['referer'] = $baseUrl . 'post/';

	// validation
	if ($captcha_enabled && $_SESSION['active_capcha'] == 0)
	{
		$resp = recaptcha_check_answer(CAPTCHA_PRIVATE_KEY,
			$_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
		if (!$resp->is_valid){

			$errors['captcha'] = $translations['captcha']['captcha_error'];
			//in mobile
			$smarty->assign('errorsStep',2);
		}
	}

	if (!isset($type_id) || !is_numeric($type_id))
	{
		$errors['input_id'] = $translations['jobs']['type_error'];
	}
	if ($company == '')
	{
		$errors['company'] = $translations['jobs']['company_error'];
	}
	if ($title == '')
	{
		$errors['title'] = $translations['jobs']['job_title_error'];
	}
	if ($description == '')
	{
		$errors['description'] = $translations['jobs']['job_description_error'];
	}
	if ($poster_email == '')
	{
		$errors['poster_email'] = $translations['jobs']['job_email_error'];
	}

	if (isset($apply_online) && $apply_online == 'on')
	{
		$apply_online = 1;
	}
	else
	{
		$apply_online = 0;
	}
	$list_col_img = array("image1","image2","image3");
	/* Nam cap nhat */
	$list_col_img = array("image1","image2","image3");
	$list_not_keep= array();
	

	
	if(!empty($_FILES["file"])){ // upload file image
		$upload = new Upload;
		$resize = new ResizeImage;
		$dir_upload = ($isMobile)?"../uploads/job/":"uploads/job/";
		// config umage upload

		$config['upload_path'] 	 = $dir_upload."root";
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$check_type_img = explode("|",$config['allowed_types']);
		$config['max_size']	= '2048';
		$count_file = count($_FILES["file"]);
		// check before saving
		for($i=0; $i<$count_file; $i++){
			if(!empty($_FILES['file']['name'][$i])){
				$file_type 			= explode(".",$_FILES['file']['name'][$i]);
				$file_type 			= strtolower($file_type[count($file_type)-1]);
				list($width, $height, $type, $attr)	= @getimagesize($_FILES['file']['tmp_name'][$i]);
				if(!in_array($file_type,$check_type_img)){
					$errors['file'] = $translations['upload']['error_type_img']." (".$_FILES['file']['name'][$i].")";
				}
				$fileSize = $_FILES['file']['size'][$i]/1024;//kbyte

				if($fileSize>$config['max_size'] or $fileSize == 0){
					$errors['file'] = /*$translations['upload']['error_size_img'].*/" Maximum file size is 2M for each file (".$_FILES['file']['name'][$i].")";
				}
			}
		}
		// save image
	}
	if(empty($errors)){
		if(!empty($_POST["delete_img"])){
			$delete_img = explode(",",trim($_POST["delete_img"],","));
			foreach($delete_img as $v){
				@unlink($jobs[$v]);
				@unlink(str_replace("uploads/job","uploads/job/root",$jobs[$v]));
				$data_image[$v] = "NULL";
				$list_not_keep[] = $v;
			}
		}
		
		if(!empty($_FILES["file"])){
			
			$_FILES['userfile'] = "";
			//config image thumb
			$config_thumb['image_library'] 	= 'gd2';
			$config_thumb['create_thumb'] 	= TRUE;
			$config_thumb['maintain_ratio'] = TRUE;
			$config_thumb['width']			= 640;
			$config_thumb['height']			= 384;
			for($i=0; $i<$count_file; $i++){
				if(!empty($_FILES['file']['name'][$i])){
					$_FILES['userfile']['name']			= $_FILES['file']['name'][$i];
					$_FILES['userfile']['type']			= $_FILES['file']['type'][$i];
					$_FILES['userfile']['tmp_name']		= $_FILES['file']['tmp_name'][$i];
					$_FILES['userfile']['error']		= $_FILES['file']['error'][$i];
					$_FILES['userfile']['size']			= $_FILES['file']['size'][$i];
					$upload->initialize($config);
					$list_image[$i] = $upload->do_upload("userfile");
					$list_image[$i] = $upload->do_upload("userfile");
					//if($list_image[$i][0] === 0 and ($list_image[$i][1]["width"] > $config_thumb['width'] or $list_image[$i][1]["height"] > $config_thumb['height'])){

					$config_thumb['new_image'] 		= $dir_upload.$list_image[$i][1]["images"];
					$config_thumb['source_image']	= $dir_upload.'root/'.$list_image[$i][1]["images"];
					$resize->clear();
					$resize->initialize($config_thumb);
					$resize->resize();
					//}
					if(!empty($list_not_keep)) { // co delte image
						foreach ($list_col_img as $v) {
							if (in_array($v,$list_not_keep) and !in_array($v,$keep_img)) {
								$data_image[$v] = str_replace("../","",$config_thumb['new_image']) ;
								$keep_img[] = $v;
								break;
							}
							elseif((empty($jobs[$v]) || $jobs[$v] == "NULL")and !in_array($v,$keep_img)){
								$data_image[$v] = str_replace("../","",$config_thumb['new_image']) ;
								$keep_img[] = $v;
								break;
							}
						}
					}
					else{ // not delete image
						for($ik=1;$ik<=3;$ik++){
							if((empty($jobs["image".$ik]) || $jobs["image".$ik] == "NULL") and !in_array("image".$ik,$keep_img)){
								$data_image["image".$ik] = str_replace("../","",$config_thumb['new_image']) ;
								$keep_img[] = "image".$ik;
								break;
							}
						}
					}
				}
			}
		}
	}
	/* Nam cap nhat */
	// no errors, go to review page
	if (empty($errors))
	{

		//Use $_SESSION['edit_id'] as ID when an error has occured
		if($_SESSION['edit_id'] != 0 || ($_SESSION['edit_id'] != ''))
			$job_id = $_SESSION['edit_id'];

		$job = new Job($job_id);

		if (!strstr($url, 'http://'))
		{
			$url = 'http://' . $url;
		}

		if (!isset($city_id))
		{
			$city_id = 0;
		}
		else
		{
			// if a city is selected, we must clear the 'other' location
			$location_outside_ro_where = '';
		}

		$continents = !is_numeric($continents) ? (($continents_id = get_continents_primaryKey_byName($continents)) ? $continents_id : 0) : $continents;
		$country    = !is_numeric($country) ? (($country_id = get_country_primaryKey_byName($country)) ? $country_id : 0) : $country;
		$area     = !is_numeric($area) ? (($area_id = get_japan_area_by_name_or_prefectures_name($area, $prefectures)) ? $area_id : 0) : $area;


		$job = new Job($_POST["job_id"]);
		$jobs = $job->GetInfo();
		$date_post =  strtotime($date_end);
		$date_db   =  time();//strtotime($jobs['date_end']);
		if($date_db < $date_post)
			$data["application_expired"] = 0;

		$data = array('company' => $company,
			'url' => $url,
			'title' => $title,
			'continents_id' => $continents,
			'country_id' => $country,
			'area_id' => $area,
			'city_id' => $city_id,
			'nationality' => $nationality,
			'category_id' => $category_id,
			'type_id' => $type_id,
			'description' => $description,
			'apply' => '',
			'poster_email' => $poster_email,
			'details' => $details,
			'address' => $address,
			'requ' => $requ,
			'wage' => $wage,

			'date_end' => $date_end ? date("Y-m-d",strtotime($date_end)): null,
			'apply_online' => $apply_online);
		if(!empty($data_image))
			$data += $data_image;
		//Data already exist?
		$existjob = $job->ExistJob($data, $job_id);
		if($existjob['exist'])
		{
			$message = 'You\'ve already posted an identical job vacancy within a month!<br />Please change the details or wait for the monthly period to end (until: '.$existjob['waiting-period'].')';
			//set $_SESSION['edit_id'] for the firsttime
			$_SESSION['edit_id'] = $job_id;
		}
		else
		{
			$message = '';


			$job->Edit($data);

			//where is set $auth ?
			if (!empty($auth))
			{
				$add = $auth . '/';
			}
			else
			{
				$add = '';
			}

			$_SESSION['edit_id'] =0;

			if(empty($error)){
				redirect_to($baseUrl . 'verify/' . $job_id . '/' . $add);
				exit;
			}else{
				$smarty->assign('job', $jobs);
				$smarty->assign('errors', $errors);
			}
			
		}
	}
	// if errors exist, go back and edit the post
	else{
		$smarty->assign('job', $jobs);
		$smarty->assign('errors', $errors);
	}
}

// check referer and set the job category, if exists
if (strstr($_SERVER['HTTP_REFERER'], 'jobs'))
{
	$tmp = explode('/', $_SERVER['HTTP_REFERER']);
	$count = count($tmp);
	$categ = $tmp[$count - 2];
	if ($categ != '')
	{
		$smarty->assign('default_categ_id', get_categ_id_by_varname($categ));
	}
}

$smarty->assign('categories', get_categories());
$smarty->assign('types', get_types());
$smarty->assign('cities', get_cities());

if ($later_edit)
{
	$html_title = $translations['jobs']['title_edit'];
}
else
{
	$html_title = $translations['jobs']['title_new'];
}

if (isset($apply_online))
{
	$smarty->assign('is_apply', $apply_online);
}

$template = !$isMobile ? 'publish-write.tpl' : 'MobileTemplates/views/jobs/create.tpl';
