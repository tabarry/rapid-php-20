<?php

/*
 * SULATA FRAMEWORK
 * Version: #VERSION#
 * Date: Nove 01, 2014
 */

//Include the language file
include('language.php');
//MISC SETTINGS
define('LOCAL_URL', 'http://localhost/#SITE_FOLDER#/');
define('WEB_URL', 'http://localhost/#SITE_FOLDER#/');
define('SESSION_PREFIX', '#SESSION_PREFIX#');
define('UID_LENGTH', 14);
define('OPENID_DOMAIN', $_SERVER['HTTP_HOST']);
define('GOOGLE_LOGOUT_URL', 'https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=');
//URLs and db settings
//Other settings are in sulata_settings table
//If local
if (!strstr($_SERVER['HTTP_HOST'], ".")) {
    define('DEBUG', TRUE);
    define('BASE_URL', LOCAL_URL);
    define('ADMIN_URL', BASE_URL . '_admin/');
    define('PING_URL', BASE_URL . 'static/ping.html');
    define('NOSCRIPT_URL', BASE_URL . 'sulata/static/no-script.html');
    define('ACCESS_DENIED_URL', BASE_URL . 'sulata/static/access-denied.html');
    define('ADMIN_UPLOAD_PATH', '../files/');
    define('PUBLIC_UPLOAD_PATH', 'files/');
    define('LOCAL', TRUE);
    //MySQL DB Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', '#DB_NAME#');
    define('DB_USER', '#DB_USER#');
    define('DB_PASSWORD', '#DB_PASSWORD#');
} else {
    define('DEBUG', FALSE);
    define('BASE_URL', WEB_URL);
    define('ADMIN_URL', BASE_URL . '_admin/');
    define('PING_URL', BASE_URL . 'sulata/ping.html');
    define('NOSCRIPT_URL', BASE_URL . 'sulata/static/no-script.html');
    define('ACCESS_DENIED_URL', BASE_URL . 'sulata/static/access-denied.html');
    define('ADMIN_UPLOAD_PATH', '../files/');
    define('PUBLIC_UPLOAD_PATH', 'files/');
    define('LOCAL', FALSE);
    //MySQL Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'incidentboard3');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
}
//Edit delete download access
$editAccess = TRUE;
$deleteAccess = TRUE;
$addAccess = TRUE;
$downloadAccess = TRUE;
