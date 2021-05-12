<?php
/**
 * @author putypuruty
 *
 * Business logic for editing a post.
 */

	//Note: $id is a job ID

if ($id != 0)
	{
		$job = new Job($id);
	}
	else
	{
		$job = new Job();
	}

	$jobToEdit = $job->GetInfo();
    $jobToEdit["count_image"] = 0;
    for($i=1;$i<=3;$i++){
        if($jobToEdit["image".$i]){
            $jobToEdit["count_image"] += 1;
        }
    }
    $jobToEdit["class_image"] = "div_upload".$jobToEdit["count_image"];
    $jobToEdit["date_end"] = ($jobToEdit['date_end'] !='0000-00-00 00:00:00' && $jobToEdit['date_end']) ? date("d M Y",strtotime($jobToEdit["date_end"])) : null;

	$nationalities = array('Japanese','Not Japanese','Either');

	$smarty->assign('nationalities', $nationalities);



	$smarty->assign('show_preview', false);

	if (!empty($_POST))
	{
		// validation
		$errors = array();

        if (!isset($_POST['type_id']) || !is_numeric($_POST['type_id']))
        {
            $errors['input_id'] = $translations['jobs']['type_error']; $_POST['type_id'] = 0;
        }
        if ($_POST['company'] == '')
			$errors['company'] = $translations['jobs']['name_error'];

		if ($_POST['title'] == '')
			$errors['title'] = $translations['jobs']['title_error'];

		if ($_POST['description'] == '')
			$errors['description'] = $translations['jobs']['description_error'];

		if ($_POST['poster_email'] == '')
			$errors['poster_email'] = $translations['jobs']['email_error'];

		if (!validate_email($_POST['poster_email']))
			$errors['poster_email'] = $translations['jobs']['email_invalid'];

		if (isset($_POST['apply_online']) && $_POST['apply_online'] == 'on')
		{
			$_POST['apply_online'] = 1;
		}
		else
		{
			$_POST['apply_online'] = 0;
		}

		$isCitySelected = false;

		// we didn't receive a city (when the cities combo is disabled)
		if (!isset($_POST['city_id']))
			$city_id = 0;
		else
		{
			$city_id = $_POST['city_id'];
			$isCitySelected = true;
		}
        $continents_id = !is_numeric($_POST['continents']) ? (($continents_id = get_continents_primaryKey_byName($_POST['continents'])) ? $continents_id : 0) : $_POST['continents'];
        $country_id    = !is_numeric($_POST['country']) ? (($country_id = get_country_primaryKey_byName($_POST['country'])) ? $country_id : 0) : $_POST['country'];
        $area_id     = !is_numeric($_POST['area']) ? (($area_id = get_japan_area_by_name_or_prefectures_name($_POST['area'], $_POST['prefectures'])) ? $area_id : 0) : $_POST['area'];

		$jobToEdit['company'] = $_POST['company'];
		$jobToEdit['url'] = $_POST['url'];
		$jobToEdit['title'] = $_POST['title'];
        $jobToEdit['continents_id'] = $continents_id;
        $jobToEdit['country_id'] = $country_id;
        $jobToEdit['area_id'] = $area_id;
		$jobToEdit['city_id'] = $city_id;
		$jobToEdit['category_id'] = $_POST['category_id'];
		$jobToEdit['type_id'] = $_POST['type_id'];
		$jobToEdit['description'] = $_POST['description'];
		$jobToEdit['apply'] = '';
		$jobToEdit['poster_email'] = $_POST['poster_email'];
		$jobToEdit['apply_online'] = $_POST['apply_online'];
		$jobToEdit['type_var_name'] = get_type_varname_by_id($_POST['type_id']);
		$jobToEdit['type_id'] = $_POST['type_id'];

		$jobToEdit['details'] = $_POST['details'];
		$jobToEdit['address'] = $_POST['address'];
		$jobToEdit['requ'] = $_POST['requ'];
		$jobToEdit['wage'] = $_POST['wage'];


		$jobToEdit['textiledDescription'] = $textile->TextileThis($_POST['description']);

		$is_location_anywhere = $jobToEdit['city_id'] == 0 && $jobToEdit['location_outside_ro'] == '';
		$jobToEdit['is_location_anywhere'] = $is_location_anywhere;

		if (!$is_location_anywhere)
		{
			if ($isCitySelected)
			{
				$city = get_city_by_id($city_id);

				$jobToEdit['location'] = $city['name'];
			}
			else
				$jobToEdit['location'] = $jobToEdit['location_outside_ro'];
		}
        /* Nam cap nhat */
        $list_col_img = array("image1","image2","image3");
        $list_not_keep= array();
        if(!empty($_POST["delete_img"])){
            $delete_img = explode(",",trim($_POST["delete_img"],","));
            foreach($delete_img as $v){
                @unlink("../".$jobToEdit[$v]);
                @unlink("../".str_replace("uploads/job","uploads/job/root",$jobToEdit[$v]));
                $data_image[$v] = "NULL";
                $list_not_keep[] = $v;
            }
        }


        if(!empty($_FILES["file"])){ // upload file image
            $upload = new Upload;
            $resize = new ResizeImage;
            // config umage upload
            $config['upload_path'] 	 = "../uploads/job/root";
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
                    list($width, $height, $type, $attr)	= @getimagesize($_FILES['file']['tmp_name'][$i]);
                    if(!in_array($file_type,$check_type_img)){
                        $errors['file'] = $translations['upload']['error_type_img']." (".$_FILES['file']['name'][$i].")";
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
                        $list_image[$i] = $upload->do_upload("userfile");
                        //if($list_image[$i][0] === 0 and ($list_image[$i][1]["width"] > $config_thumb['width'] or $list_image[$i][1]["height"] > $config_thumb['height'])){
                        $config_thumb['new_image'] 		= '../uploads/job/'.$list_image[$i][1]["images"];
                        $config_thumb['source_image']	= '../uploads/job/root/'.$list_image[$i][1]["images"];
                        $resize->clear();
                        $resize->initialize($config_thumb);
                        $resize->resize();
                        //}
                        if(!empty($list_not_keep)) { // co delte image
                            foreach ($list_col_img as $v) {
                                if (in_array($v,$list_not_keep) and !in_array($v,$keep_img)) {
                                    $data_image[$v] = str_replace("../", "", $config_thumb['new_image']);
                                    $keep_img[] = $v;
                                    break;
                                }
                                elseif((empty($jobToEdit[$v]) || $jobToEdit[$v] == "NULL")and !in_array($v,$keep_img)){
                                    $data_image[$v] = str_replace("../", "", $config_thumb['new_image']);
                                    $keep_img[] = $v;
                                    break;
                                }
                            }
                        }
                        else{ // not delete image
                            for($ik=1;$ik<=3;$ik++){
                                if((empty($jobToEdit["image".$ik]) || $jobToEdit["image".$ik] == "NULL") and !in_array("image".$ik,$keep_img)){
                                    $data_image["image".$ik] = str_replace("../", "", $config_thumb['new_image']);
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
		// no errors
		if (empty($errors))
		{
			if ($_POST['show_preview'] == 'true')
				$smarty->assign('show_preview', true);
			else
			{
				escape($_POST);

				$data = array('company' => $company,
				          	  'url' => $url,
				              'title' => $title,
                               'continents_id' => $continents_id,
                               'country_id' => $country_id,
                               'area_id' => $area_id,
                               'city_id' => $city_id,
				              'category_id' => $category_id,
				              'type_id' => $type_id,
				              'description' => $description,
				              'apply' => '',
				              'poster_email' => $poster_email,
						'details' => $details,
						'address' => $address,
						'requ' => $requ,
						'wage' => $wage,
                        'apply_online' => $apply_online,
                        'nationality' => $nationality,
                        'date_end'   => (empty($date_end))?null:date("Y-m-d",strtotime($date_end)),
                        'apply_online' => $apply_online);

                if(!empty($data_image))
                    $data += $data_image;

				if ($id != 0){
                    $date_post =  strtotime($date_end);
                    $date_db   =  time();//strtotime($jobToEdit['date_end']);
                    if($date_db < $date_post)
                        $data["application_expired"] = 0;
					$job->Edit($data);

				}
				else
				{
					// a job posted by the admin is active from the beginning
					$data['is_temp'] = 0;
					$data['is_active'] = 1;
					$data['spotlight'] = 0;

					$job->Create($data);
				}

				$category = get_category_by_id($category_id);

				redirect_to(BASE_URL . URL_JOBS . '/' . $category['var_name'] . '/');
				exit;
			}
		}
		else
			$smarty->assign('errors', $errors);
	}
	$smarty->assign('categories', get_categories());
	$smarty->assign('types', get_types());
	$smarty->assign('cities', get_cities());
    $smarty->assign_by_ref('job', $jobToEdit);

	$html_title = $translations['jobs']['title_edit'] . ' / ' . SITE_NAME;

	$template = 'edit-post.tpl';
?>