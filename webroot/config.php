<?php

/* Config file!

*/ 

error_reporting(-1);
ini_set('display_errors', 1);
ini_set('output_buffering', 0); // Do not buffer outputs, write directly

/* 

Define triton paths
*/
define('TRITON_INSTALL_PATH', __DIR__ . '/..');
define('TRITON_THEME_PATH', TRITON_INSTALL_PATH . '/theme/render.php');

/*
include bootstrapping funtions.
*/
include(TRITON_INSTALL_PATH . '/src/bootstrap.php');

/* 

Start the session */

session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();

/*
*
* Create callback function to check if logged in
*/


function checkLogin() {
	if(isset($_SESSION['user'])) {
		return true;
	} else {
		return false;
	}
}

/* 

Create the triton variable. 
*/ 

$triton = array();

/*

Site wide settings. 
*/
$triton['lang']			= 'en';
$triton['title_append'] = ' | Project &lt; tube &gt;';

/* 
* Settings for the database 
*/
$dbpath = realpath(TRITON_INSTALL_PATH.'/db/.htsqlite.db');
$triton['database']['dsn']               = 'sqlite:'.$dbpath; // 'mysql:host=localhost;dbname=maof14;
// $triton['database']['verbose'] 			 = false;
// $triton['database']['username']       = 'root'; // maof14
// $triton['database']['password']       = ''; // 
// $triton['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

/* Theme related settings

*/

$triton['stylesheet'] = 'style/style.less';
$triton['stylesheets'][] = 'style/font-awesome-4.3.0/css/font-awesome.min.css';
// $triton['favicon'] = 'favicon.ico';

// custom for project - array of above and below javascript files. 
$triton['js']['above'][] = 'js/modernizr.js';
$triton['js']['above'][] = 'js/less.min.js?ts=<?=time()?>'; // forcing download. FAIL! function as string... 
$triton['js']['below'][] = 'js/jquery.min.js'; // jQuery before using jQuery.. :) 
$triton['js']['below'][] = 'js/main.js';
$triton['js']['below'][] = 'js/mediaplayer.js';
$triton['js']['below'][] = 'js/videosliderplugin.js';

$triton['header'] = <<<EOD
<span class='sitetitle'>Project &lt; tube &gt;</span>
<span class='siteslogan'>Video upload tools with PHP, JavaScript and jQuery</span>
EOD;

$menu = array(
	'start' => [
		'text' => 'Start',
		'url' => 'start.php'
	],
	'upload' => [
		'text' => checkLogin() == true ? 'Upload' : null,
		'url' => checkLogin() == true ? 'upload.php' : null
	],
	'page' => [
		'text' => checkLogin() == true ? ' My profile' : null,
		'url' => checkLogin() == true ? 'profile.php' : null
	],
	'plugin' => [
		'text' => 'Plugin', 
		'url' => 'plugin.php'
	],
	'about' => [
		'text' => 'About', 
		'url' => 'about.php'
	],
	'signin' => [
		'text' => checkLogin() == false ? 'Log in' : 'Log out',
		'url' => 'login.php'
	],
	'register' => [
		'text' => checkLogin() == true ? null : 'Register',
		'url' => checkLogin() == true ? null : 'register.php'
	],
);

$triton['navmenu'] = CNavigation::GenerateMenu($menu, 'navmenu');

$triton['footer'] = <<<EOD
<footer>
<span class='sitefooter'>Copyright &copy; Mattias Olsson 2015. Powered by Triton.</span>
</footer>
EOD;
