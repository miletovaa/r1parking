<?
/* 
* This file uses MobileDetect API to detect what device does the user use
* to set corresponding session settings.
*/
require_once '../mobile_php/Mobile_Detect.php';
$detect = new Mobile_Detect;
$device = ($detect->isMobile()) ? 'mob' : 'pc';
$sess_time = ($detect->isMobile()) ? 60480000 : 28800;

ini_set('session.gc_maxlifetime', $sess_time);
ini_set('session.cookie_lifetime', $sess_time);
ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] .'/sessions_'.$device);

session_start();
?>