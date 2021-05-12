<?php
/**
 * jobber job board platform
 *
 * @author     Filip C.T.E. <http://www.filipcte.ro> <me@filipcte.ro>
 * @license    You are free to edit and use this work, but it would be nice if you always referenced the original author ;)
 *             (see license.txt).
 * 
 * Misc functions
 */

function add_single_quotes($arg) 
{
	/* single quote and escape single quotes and backslashes */ 
	return "'" . addcslashes($arg, "'\\") . "'"; 
}

function get_cities_cloud()
{
	global $db;
	$city_array = array();
 
	$sql = 	'SELECT c.id, c.name, c.ascii_name, COUNT(*) AS nr
			 FROM '.DB_PREFIX.'cities c 
			 INNER JOIN '.DB_PREFIX.'jobs j ON (j.city_id = c.id ) 
			 WHERE j.is_active = 1 
			 GROUP BY c.name';
 
	$cities = $db->QueryArray($sql);
 
	foreach ($cities as $city)
	{
		$numberOfJobs = $city['nr'];
 
		$city_array[] = array('name' => $city['name'],
		                     'varname' => $city['ascii_name'],
		                     'count' => $numberOfJobs,
		                     'tag_height' => get_cloud_tag_height($numberOfJobs));
	}
 
	return $city_array;
}

function get_cloud_tag_height($numberOfItems)
{
	if ($numberOfItems < 2)
	{
		$tag_height = 1;
	}
	else if ($numberOfItems >= 2 && $numberOfItems < 3)
	{
		$tag_height = 2;
	}
	else if ($numberOfItems >= 3 && $numberOfItems < 4)
	{
		$tag_height = 3;
	}
	else if ($numberOfItems >= 4 && $numberOfItems < 5)
	{
		$tag_height = 4;
	}
	else if ($numberOfItems >= 5 && $numberOfItems < 6)
	{
		$tag_height = 5;
	}
	else if ($numberOfItems >= 6)
	{
		$tag_height = 6;
	}
	
	return $tag_height;
}

function get_categories()
{
    global $db;
    $categories = array();
    $sql = 'SELECT *
                   FROM '.DB_PREFIX.'categories
                   ORDER BY category_order ASC';
    $result = $db->query($sql);
    while ($row = $result->fetch_assoc())
    {
        $categories[] = array('id' => $row['id'], 'name' => $row['name'], 'var_name' => $row['var_name'], 'title' => $row['title'], 'description' => $row['description'], 'keywords' => $row['keywords']);
    }
    return $categories;
}

function get_articles()
{
	global $db;
	$articles = array();
	$sql = 'SELECT id, title, page_title, url 
	               FROM '.DB_PREFIX.'pages
	               ORDER BY title ASC';
	$result = $db->query($sql);
	while ($row = $result->fetch_assoc())
	{
		$articles[$row['url']] = $row;
	}
	return $articles;
}

function get_navigation($menu = false)
{
	global $db;
	
	$conditions = '';
	
	if (isset($menu) && ($menu == 'primary' || $menu == 'secondary' || $menu == 'footer1' || $menu == 'footer2' || $menu == 'footer3'))
		$conditions = ' WHERE menu = \''.$menu.'\'';
	
	$navigation = array();

	$sql = 'SELECT id, url, name, title, menu
				FROM '.DB_PREFIX.'links
				' . $conditions . '
				ORDER BY link_order ASC';

	$result = $db->query($sql);
	while ($row = $result->fetch_assoc())
	{
		$url_check = substr($row['url'], 0, 4);
		if ($url_check == 'http' || $url_check == 'www.') $outside = 1; else $outside = 0; 
		
		$navigation[$row['menu']][] = array(
								'id' => $row['id'],
								'url' => $row['url'],
								'name' => $row['name'],
								'title' => $row['title'],
								'menu' => $row['menu'],
								'outside' => $outside);
	}
	return $navigation;
}

function get_cities()
{
	global $db;
	
	$cities = array();
	
	$sql = 'SELECT id, name, ascii_name
	               FROM '.DB_PREFIX.'cities
	               ORDER BY name ASC';
	
	$result = $db->query($sql);
	
	while ($row = $result->fetch_assoc())
	{
		$cities[] = array('id' => $row['id'], 'name' => $row['name'], 'ascii_name' => $row['ascii_name']);
	}
	
	return $cities;
}

function get_categ_id_by_varname($var_name)
{
	global $db;
	$sql = 'SELECT id FROM '.DB_PREFIX.'categories WHERE var_name = "' . $var_name . '"';
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	return $row['id'];
}

function get_categ_name_by_varname($var_name)
{
    global $db;
    $sql = 'SELECT name FROM '.DB_PREFIX.'categories WHERE var_name = "' . $var_name . '"';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row['name'];
}

function get_city_id_by_asciiname($ascii_name)
{
	global $db;
	
	$city = null;
	
	$sql = 'SELECT id, name
	               FROM '.DB_PREFIX.'cities
	               WHERE ascii_name = "' . $ascii_name . '"';

	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		$city = array('id' => $row['id'], 'name' => $row['name']);
		
	return $city;
}

/**
* Converts the multidimensional array that results after calling parse_ini_file (filePath, processSections = true)
* to a JSON string.
* The resulting JSON string will look something like this:
* {"sectionOne": {"messageKeyOne": "messageTextOne", "messageKeyTwo": "messageTextTwo"}, "sectionTwo": {....},....}
*
* @author putypuruty
*/
function iniSectionsToJSON($iniSections)
{
	$translationsJson = "{";
	$sectionsCount = 0;
		
	foreach ($iniSections as $section => $sectionMessages)
	{
		$translationsJson = $translationsJson . "\"" . $section . "\": {";
		$sectionMessagesCount = 0;
		
		foreach ($sectionMessages as $messageKey => $messageText)
		{
			$translationsJson = $translationsJson . "\"".$messageKey . "\":\"" . preg_replace("/\r?\n/", "\\n", addslashes($messageText)) . "\"";
			
			$sectionMessagesCount++;
			
			if ($sectionMessagesCount < count($sectionMessages))
				$translationsJson .= ",";
		}
		$translationsJson .= "}";
		
		$sectionsCount++;

		if ($sectionsCount < count($iniSections))
			$translationsJson .= ",";
	}
	
	$translationsJson = $translationsJson."}";
	
	return $translationsJson;
}

/**
 * Returns the city with the specified ID or null
 * if the city was not found.
 *
 * @param $cityID
 * @return 
 */
function get_city_by_id($cityID)
{
	global $db;
	
	$city = null;
	
	$sql = 'SELECT id, name
	               FROM '.DB_PREFIX.'cities
	               WHERE id = ' . $cityID;
	$result = $db->query($sql);
	
	$row = $result->fetch_assoc();
	
	if ($row)
		$city = array('id' => $row['id'], 'name' => $row['name']);
		
	return $city;  
}

function get_types()
{
	global $db;
	$sql = 'SELECT id, name, var_name 
		FROM '.DB_PREFIX.'types ';
	$result = $db->query($sql);
	$types = array();
	while($row = $result->fetch_assoc())
	{
		$types[] = array('id' => $row['id'], 'name' => $row['name'], 'var_name' => $row['var_name']);
	}
	return $types;
}

function get_type_id_by_varname($var_name)
{
	global $db;
	$sql = 'SELECT id FROM '.DB_PREFIX.'types WHERE 
		var_name = "'.$var_name.'"';
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		return $row['id'];
	return false;
}

function get_type_varname_by_id($id)
{
	global $db;
	$sql = 'SELECT var_name FROM '.DB_PREFIX.'types WHERE 
		id = '.$id;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		return $row['var_name'];
	return false;
}

function get_category_by_var_name($var_name)
{
	global $db;
	$category = null;
	
	$sql = 'SELECT *
	               FROM '.DB_PREFIX.'categories
	               WHERE var_name = "' . $var_name . '"';
	
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		$category = build_category_from_result_set_row($row);
	
	return $category;
}

function get_category_by_id($id)
{
	global $db;
	$category = null;
	
	$sql = 'SELECT *
	               FROM '.DB_PREFIX.'categories
	               WHERE id = ' . $id;
	
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		$category = build_category_from_result_set_row($row);
	
	return $category;
}

function build_category_from_result_set_row($row)
{
	return array('id' => $row['id'], 'name' => $row['name'], 'var_name' => $row['var_name'], 
			     'title' => $row['title'], 'description' => $row['description'],
			     'keywords' => $row['keywords'], 'category_order' => $row['category_order']);
}

function generate_sitemap($type)
{
    global $db;
    $sanitizer = new Sanitizer;

    // Get all links
    $result = $db->query('SELECT url FROM '.DB_PREFIX.'links');
    while ($row = $result->fetch_assoc()) if (!strstr($row['url'], 'http://')) $sitemap[BASE_URL . $row['url'] . '/'] = 1;
    
    // Get all custom pages
    $result = $db->query('SELECT url FROM '.DB_PREFIX.'pages');
    while ($row = $result->fetch_assoc()) $sitemap[BASE_URL . $row['url'] . '/'] = 1; 
    
    // Get all categories
    $categories = get_categories();
    $i = 0; while($i < count($categories)) { $sitemap[BASE_URL . URL_JOBS . '/' . $categories[$i]['var_name'] . '/'] = 1; $i++; }
    
    // Get all cities
    $cities = get_cities();
    $i = 0; while($i < count($cities)) { $sitemap[BASE_URL . URL_JOBS_IN_CITY . '/' . $cities[$i]['ascii_name'] . '/'] = 1; $i++; }

    // Get all companies
    $result = $db->query('SELECT company FROM '.DB_PREFIX.'jobs WHERE is_temp = 0 AND is_active = 1 GROUP BY company');
    while ($row = $result->fetch_assoc()) $sitemap[BASE_URL . URL_JOBS_AT_COMPANY . '/' . $sanitizer->sanitize_title_with_dashes($row['company']) . '/'] = 1;
        
    // Get all active Jobs
    $result = $db->query('SELECT id, title, company FROM '.DB_PREFIX.'jobs WHERE is_active = 1 AND is_temp = 0');
    while ($row = $result->fetch_assoc()) $sitemap[BASE_URL . URL_JOB . '/' . $row['id'] . '/' . $sanitizer->sanitize_title_with_dashes($row['title'])] = 1;
    
    // Generate output
    if ($type == 'xml')
    {
        header('Content-Type: text/xml; charset="utf-8"');
        
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($sitemap as $url => $value)
        {
            echo '<url><loc>'.$url.'</loc></url>';
        }
        echo '</urlset>';
    }
    else
    {
        foreach ($sitemap as $url => $value)
        {
            echo $url.'<br />';
        }        
    }

}

function StrRewrite($str=''){
    if($str != ''){
        $arr = array("?","_","__", "  "," ","--", "\"", ".", "&quot;", "'", "&#039;","''","`","\'","\"","\\","\/","/","+","--","*","%","$","~","!","@","#","^","&","(",")","|",",",">","<", ":");
        $str = str_replace($arr, "-", $str);
        #---------------------------------a
        $arr = array("á", "à", "ả", "ã", "ạ", "â", "ậ","ầ","ấ","ẩ","ẫ", "ă", "ặ", "ắ", "ằ", "ặ","ẳ","ẵ","Á", "À", "Ả", "Ã", "Ạ", "Â", "Ậ","Ấ","Ầ","Ẩ","Ẫ","Ă","Ắ","Ằ","Ẳ","Ẵ","Ặ");
        $str = str_replace($arr, "a", $str);
        #---------------------------------d
        $arr = array("đ","Đ","");
        $str = str_replace($arr, "d", $str);
        #---------------------------------d
        $arr = array("ç","Ç");
        $str = str_replace($arr, "c", $str);
        #---------------------------------e
        $arr = array("é", "è", "ẻ", "ẽ", "ẹ", "ê", "ể","ế", "ề", "ệ","ễ","E","É","È","Ẻ","Ẽ","Ẹ","Ê","Ế","Ề","Ể","Ễ","Ệ");
        $str = str_replace($arr, "e", $str);
        #---------------------------------i
        $arr = array("í", "ì", "ỉ", "ĩ", "ị","Í","Ì","Ỉ","Ĩ","Ị","İ");
        $str = str_replace($arr, "i", $str);
        #---------------------------------o
        $arr = array("ó", "ò", "ỏ", "õ", "ọ", "ô", "ố","ồ","ổ","ỗ","ộ","ơ","ớ","ờ","ở","ỡ","ợ","O","Ó","Ò","Ỏ","Õ","Ọ","Ô","Ố","Ồ","Ổ","Ỗ","Ộ","Ơ","Ớ","Ờ","Ở","Ỡ","Ợ","Ö","ö","ō","Ō");
        $str = str_replace($arr, "o", $str);
        #---------------------------------u
        $arr = array("ú", "ù", "ủ", "ũ", "ụ", "U","Ú","Ù","Ủ","Ũ","Ụ","ư","ứ","ừ","ử","ữ","ự","Ư","Ứ","Ừ","Ử","Ữ","Ự","Ü","ü","ū");
        $str = str_replace($arr, "u", $str);
        #---------------------------------y
        $arr = array("ý", "ỳ", "ỷ", "ỹ", "ỵ","Y","Ý","Ỳ","Ỷ","Ỹ","Ỵ");
        $str = str_replace($arr, "y", $str);
        #---------------------------------y
        $arr = array("Ş", "ş");
        $str = str_replace($arr, "s", $str);
        #---------------------------------y
        $arr = array("Ğ", "ğ");
        $str = str_replace($arr, "g", $str);



        #---------------------------------
        $str = preg_replace('/[^A-Za-z0-9 _\-\+\&]/','',$str);
        $str = str_replace("--","-",$str);
    }
    return strtolower($str);
}

/**
 * @desc get primary_key for continents
 */
function get_continents_primaryKey_byName($name)
{
	global $db;
	$sql = 'SELECT `id` FROM '.DB_PREFIX.'continents WHERE `name`="'.$name.'"';
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	return $row['id'];
}

/**
 * @desc get primary_key for country
 */
function get_country_primaryKey_byName($name)
{
	global $db;
	$sql = 'SELECT `id` FROM '.DB_PREFIX.'country WHERE `name`="'.$name.'"';
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	return $row['id'];
}

function get_japan_area_by_name_or_prefectures_name($area_name = '', $prefectures_name = '')
{
    global $db;
    if ($area_name) {
        $area_name = StrRewrite($area_name);
        $pos = strpos($area_name, '-');
        $area_name = $pos !== false ?  substr($area_name, 0 , $pos) : $area_name;
        $sql = 'SELECT `id` FROM '.DB_PREFIX.'area WHERE `ascii_name` LIKE "%'.$area_name.'%"';
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        if ($row) {
            return $row['id'];
        }
        $sql = 'SELECT `area_id` FROM '.DB_PREFIX.'prefectures WHERE `ascii_name` LIKE "%'.$area_name.'%"';
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['area_id'];
    }

    if ($prefectures_name) {
        $prefectures_name = StrRewrite($prefectures_name);
        $pos = strpos($area_name, '-');
        $prefectures_name = $pos !== false ? substr($prefectures_name, 0, $pos) : $prefectures_name;

        $sql = 'SELECT `area_id` FROM '.DB_PREFIX.'prefectures WHERE `ascii_name` LIKE "%'.$prefectures_name.'%"';
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['area_id'];
    }
    return null;
}

function get_japan_area()
{
    global $db;
    $sql = 'SELECT `id`, `name` FROM '.DB_PREFIX.'area';
    $result = $db->query($sql);
    $area = array();
    while($row = $result->fetch_assoc())
    {
        $area[$row['id']] = $row['name'];
    }
    return $area;
}

function get_continents()
{
    global $db;
    $sql = 'SELECT `id`, `name` FROM '.DB_PREFIX.'continents';
    $result = $db->query($sql);
    $continents = array();
    while($row = $result->fetch_assoc())
    {
        $continents[$row['id']] = $row['name'];
    }
    return $continents;
}

function header404()
{
    header("HTTP/1.0 404 Not Found");
}
function defineOnSidebar()
{
    //<!--/* OpenX Local Mode Tag v2.8.8 */-->
    // The MAX_PATH below should point to the base of your OpenX installation
    define('MAX_PATH', '/var/www/html/ad');
    if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
        if (!isset($phpAds_context)) {
            $phpAds_context = array();
        }
        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
        $phpAds_raw = view_local('', 164, 0, 0, '', '', '0', $phpAds_context, '');
        echo $phpAds_raw['html'];
    }


    //<!--/* OpenX Local Mode Tag v2.8.8 */-->
    // The MAX_PATH below should point to the base of your OpenX installation

    if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
        if (!isset($phpAds_context)) {
            $phpAds_context = array();
        }
        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
        $phpAds_raw = view_local('', 165, 0, 0, '', '', '0', $phpAds_context, '');
        echo $phpAds_raw['html'];
    }


    //<!--/* OpenX Local Mode Tag v2.8.8 */-->
    // The MAX_PATH below should point to the base of your OpenX installation

    if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
        if (!isset($phpAds_context)) {
            $phpAds_context = array();
        }
        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
        $phpAds_raw = view_local('', 166, 0, 0, '', '', '0', $phpAds_context, '');
        echo $phpAds_raw['html'];
    }


    //<!--/* OpenX Local Mode Tag v2.8.8 */-->
    // The MAX_PATH below should point to the base of your OpenX installation

    if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
        if (!isset($phpAds_context)) {
            $phpAds_context = array();
        }
        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
        $phpAds_raw = view_local('', 168, 0, 0, '', '', '0', $phpAds_context, '');
        echo $phpAds_raw['html'];
    }

}

function displayAds()
{
    echo '[PR]<br/>';
    echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
    echo '<ins class="adsbygoogle"';
    echo '     style="display:inline-block;width:160px;height:600px"';
    echo '     data-ad-client="ca-pub-8112755181417377"';
    echo '     data-ad-slot="3661928647"></ins>';
    echo '<script>';
    echo '(adsbygoogle = window.adsbygoogle || []).push({});';
    echo '</script>';
}

function footerUnsetsession()
{
    if (isset($_SESSION['status']))
    {
        unset($_SESSION['status']);
    }
    if (isset($_SESSION['apply_mail_sent']))
    {
        unset($_SESSION['apply_mail_sent']);
    }
    if (isset($_SESSION['apply_errors']))
    {
        unset($_SESSION['apply_errors']);
    }
    if (isset($_SESSION['apply_fields']))
    {
        unset($_SESSION['apply_fields']);
    }
    if (isset($_SESSION['apply_allowed']))
    {
        unset($_SESSION['apply_allowed']);
    }
    if (isset($_SESSION['apply_successful']))
    {
        unset($_SESSION['apply_successful']);
    }
    if (isset($_SESSION['contact_msg_sent']))
    {
        unset($_SESSION['contact_msg_sent']);
    }
    if (isset($_SESSION['contact_errors']))
    {
        unset($_SESSION['contact_errors']);
    }
    if (isset($_SESSION['contact_fields']))
    {
        unset($_SESSION['contact_fields']);
    }
}
