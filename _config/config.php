<?php
/**
 * Config - jobber job board platform
 *
 * @author     Filip C.T.E. <http://www.filipcte.com> <filipcte@gmail.com>
 * @license    You are free to edit and use this work, but it would be nice if you always referenced the original author ;)
 *             (see license.txt).
 */
session_start();

define('APP_PATH', str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, str_replace('_config', '', dirname(__FILE__)) . DIRECTORY_SEPARATOR));

// Environments setup
require_once APP_PATH . '_config/config.envs.php';


if(isset($_SERVER['SCRIPT_NAME']))
{
	# on Windows _APP_MAIN_DIR becomes \ and abs url would look something like HTTP_HOST\/restOfUrl, so \ should be trimed too
	# @modified Chis Florinel <chis.florinel@candoo.ro>

	$app_main_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']),'/\\');
	define('_APP_MAIN_DIR', $app_main_dir);
}
else
{
	die('[config.php] Cannot determine APP_MAIN_DIR, please set manual and comment this line');
}


// Function and classes includes
require_once APP_PATH . '_includes/Mobile_Detect.php';
require_once APP_PATH . '_includes/class.Translator.php';
require_once APP_PATH . '_includes/class.EmailTranslator.php';
require_once APP_PATH . '_includes/function.validate_email.php';
require_once APP_PATH . '_includes/function.redirect_to.php';
require_once APP_PATH . '_includes/function.printr.php';
require_once APP_PATH . '_includes/function.escape.php';
require_once APP_PATH . '_includes/functions.php';
require_once APP_PATH . '_includes/recaptchalib.php';
require_once APP_PATH . '_includes/class.phpmailer.php';
require_once APP_PATH . '_includes/class.Postman.php';
require_once APP_PATH . '_includes/class.Textile.php';
require_once APP_PATH . '_includes/class.Sanitizer.php';
require_once APP_PATH . '_includes/class.Db.php';
// comment the previous line and uncomment the next line if you get a Class 'mysqli' not found error
// require_once APP_PATH . '_includes/class.Db.MySql.php';
require_once APP_PATH . '_includes/class.Job.php';
require_once APP_PATH . '_includes/class.Paginator.php';
require_once APP_PATH . '_includes/class.Feed.php';
require_once APP_PATH . '_includes/class.SpamReport.php';
require_once APP_PATH . '_includes/class.Api.php';
require_once APP_PATH . '_includes/class.JobApplication.php';
require_once APP_PATH . '_includes/class.SearchKeywords.php';
require_once APP_PATH . '_includes/class.JobberSettings.php';
require_once APP_PATH . '_includes/class.FormValidator.php';



if( !isset($_SESSION['mobileView']))
{

	$_SESSION['mobileView'] = true;
	//check mobile device on the first visit time
	$detect = new Mobile_Detect;
	$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

	if($deviceType == 'phone'){
		$_SESSION['mobileView'] = true;
		header('location: http://local.jobboard/mobile');
	}else{
		$_SESSION['mobileView'] = false;
	}

}else{
	$currentUrl = APP_URL;//http://jobboard.app/
	$version = !isset($_GET['version'])? '': $_GET['version'];
	if(!$_SESSION['mobileView'] && $version == 'phone'){
		$mobileUrl = $currentUrl.'mobile'.$_SERVER['REQUEST_URI'];
		$mobileUrl = str_replace('/?version=phone','',$mobileUrl);
		$_SESSION['mobileView'] = true;
		header('location: ' .$mobileUrl);//http://jobboard.app/mobile/blablabla
        exit;
	}
	else
		if( $_SESSION['mobileView'] && $version == 'desktop'){
			$desktopUrl = str_replace('/mobile','',$currentUrl . $_SERVER['REQUEST_URI']);
			$desktopUrl = str_replace('?version=desktop','',$desktopUrl);
			$_SESSION['mobileView'] = false;
			header('location:'.$desktopUrl);//http://jobboard.app/blablabla
            exit;
		}
}

$isMobile = $_SESSION['mobileView'];
define('IS_MOBILE', $isMobile);

$baseUrl = !$isMobile ? APP_URL : APP_URL . 'mobile/';

!$isMobile ? require_once APP_PATH . '_includes/smarty/libs/Smarty.class.php' : require_once APP_PATH . '_includes/smarty-3/libs/Smarty.class.php';


// advanced search
require_once APP_PATH . '_includes/class.AdvancedSearch.php';

/*Nam cap nhat*/
require_once APP_PATH . '_includes/class.Upload.php';
require_once APP_PATH . '_includes/class.ResizeImage.php';
/*Nam cap nhat*/

// Setup database connection
try
{
	$db = new Db(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$db->Execute('SET NAMES UTF8');
}
catch(ConnectException $exception)
{
	if (ENVIRONMENT == 'dev')
	{
		echo "Database Connection Error:<br />";
		printr($exception->getMessage());
	}
}


// Load the Site-Specific Settings
$jobber_settings = new JobberSettings();
$settings = $jobber_settings->GetSettings();
if(isset($isMobile) && $isMobile){
	$settings['jobs_per_page']= $settings['jobs_per_page_mobile'];
	$settings['jobs_per_search']= $settings['jobs_per_search_mobile'];
	$settings['spotlight_jobs']= $settings['spotlight_jobs_mobile'];
	$settings['latest_jobs']= $settings['latest_jobs_mobile'];
	$settings['most_applied_jobs']= $settings['most_applied_jobs_mobile'];
}
require_once APP_PATH . '_config/config.settings.php';
// Setup Smarty
$smarty = new Smarty();
$smarty->template_dir = APP_PATH . '_templates' . DIRECTORY_SEPARATOR . THEME . DIRECTORY_SEPARATOR;
$smarty->compile_dir = APP_PATH .'_templates' . DIRECTORY_SEPARATOR . THEME . DIRECTORY_SEPARATOR . '_cache';
$smarty->assign('baseUrl',$baseUrl);
if (!$isMobile) {
$smarty->register_function('header404','header404');
$smarty->register_function('defineOnSidebar','defineOnSidebar');
$smarty->register_function('displayAds','displayAds');
$smarty->register_function('footerUnsetsession','footerUnsetsession');
} else {
$smarty->registerPlugin("function","header404", "header404");
$smarty->registerPlugin("function","defineOnSidebar", "defineOnSidebar");
$smarty->registerPlugin("function","displayAds", "displayAds");
$smarty->registerPlugin("function","footerUnsetsession", "footerUnsetsession");
}
// Create Textile object
$textile = new Textile;


// Split URL - get parameters
$_app_info['params'] = array();

if (isset($_SERVER['HTTP_X_ORIGINAL_URL']))
{
	$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
}
if (isset($_SERVER['HTTP_X_REWRITE_URL']))
{
	$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
}
// if server is Apache:
if(REWRITE_MODE == 'apache_mod_rewrite' || REWRITE_MODE == 'iis_isapi_rewrite')
{
	$newUrl = str_replace('/', '\/', _APP_MAIN_DIR);
	$pattern = '/'.$newUrl.'/';
	$_url = preg_replace($pattern, '', $_SERVER['REQUEST_URI'], 1);
	$_tmp = explode('?', $_url);
	$_url = $_tmp[0];

	if ($_url = explode('/', $_url))
	{
		foreach ($_url as $tag)
		{
			if ($tag)
			{
				$_app_info['params'][] = $tag;
			}
		}
	}
}
elseif(REWRITE_MODE == 'iis_url_rewrite')
{
	if(isset($_GET['page']))
		$_app_info['params'][]  = $_GET['page'];
	if(isset($_GET['id']))
		$_app_info['params'][]  = $_GET['id'];
	if(isset($_GET['extra']))
		$_app_info['params'][]  = $_GET['extra'];
}

$page = (isset($_app_info['params'][0]) ? $db->real_escape_string($_app_info['params'][0]) : '');
$id = (isset($_app_info['params'][1]) ? $db->real_escape_string($_app_info['params'][1]) : 0);
$extra = (isset($_app_info['params'][2]) ? $db->real_escape_string($_app_info['params'][2]) : '');


date_default_timezone_set('Europe/London');
header('Content-Type: text/html; charset=UTF-8');
?>