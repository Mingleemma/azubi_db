<?php

// Constant to secure "cron" jobs
define('JOBSEC', '$2y$10$VLdXLJRsEFF/lgJ2cQPEguWBLvoGSwpKPL.L3A3phIFyhDaDtr4bW');

define('JSVARS',serialize(array(
	'urlroot' => URLROOT
)));

define('CLOCALPATH',dirname(dirname(dirname( __FILE__ ))));
$xmlpath = CLOCALPATH.'/public/xml/';

define('XMLPATH', $xmlpath);

define('ROUTE_REQUEST',true);

define('NGROK_URL','http://inventory.local.ngrok.io');
define('USERNAME', 'yawshadi23@gmail.com');
define('PASSWORD', 'wonderful123456789');
define('EMAIL', 'info@fdaghana.gov');
define('SENDEREMAIL', 'info@fdaghana.gov');




?>