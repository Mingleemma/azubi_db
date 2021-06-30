<?php


define ('DEVMODE', true);

define ('MAINTENANCE', false);


date_default_timezone_set('Europe/London');


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '1200secs');
define('DB_NAME', 'azubi_db');
define('DB_PORT', 3308);

define('APPROOT', dirname(dirname( __FILE__ )));

dirname(dirname( __FILE__ ));

define('URLROOT', 'http://inventory.local/');

define('SITENAME', 'PROJECT PHOENIX');

//define('IMGPATH', dirname(dirname(dirname( __FILE__ ))));
//
//$uploadpath = IMGPATH.'/'.'public/uploads/';
//
//define('UPLOAD_PATH', $uploadpath);

?>