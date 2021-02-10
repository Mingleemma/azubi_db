<?php

// constant to allow additional includes, debug fuctions, whatever only on dev environments...
define ('DEVMODE', true);

// enable disabling of UI during maintenance
define ('MAINTENANCE', false);

// if this is uncommented, request routing changes! See Core.php!
// define('ROUTE_REQUEST',true);

// timezone, different on server
//date_default_timezone_set('Europe/London');

//DB Configuartions
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'prince');
define('DB_NAME', 'microsoft');
define('DB_PORT', 3307);
// Application Root
define('APPROOT', dirname(dirname( __FILE__ )));
define('LOCALPATH',dirname(dirname(dirname( __FILE__ ))));
$uploadpath = LOCALPATH.'/public/uploads';

define('UPLOAD_PATH', $uploadpath);

dirname(dirname( __FILE__ ));
// URL ROOT
define('URLROOT', 'http://mic.local');

define('SITENAME','RL MICRO CREDIT VENTURES');

define('COMPANYNAME', 'RL MICRO CREDIT VENTURES ');

//define('EMAILS_FOR_ERROR_ALERT', ['prince@getinnotized.com']);
