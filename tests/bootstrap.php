<?php

// set the timezone to avoid spurious errors from PHP
date_default_timezone_set("America/Chicago");
if(file_exists(__DIR__ .'/../vendor/autoload.php')) {
 	require_once(__DIR__ .'/../vendor/autoload.php');
}
else {
	trigger_error("vendor autoloader not found, unit tests will probably fail -- try running 'composer update'");
}


// Handle password compatibility (using "ircmaxell/password-compat")
{
	//handle differences in paths...
	$usePath = dirname(__FILE__) . '/../vendor/ircmaxell/password-compat/version-test.php';
	
	ob_start();
	if(!include_once($usePath)) {
		ob_end_flush();
		print "You must set up the project dependencies, run the following commands:\n
			\twget http://getcomposer.org/composer.phar
			\tphp composer.phar install ircmaxell/password-compat\n";
		exit(1);//
	}
	else {
		$output = ob_get_contents();
		ob_end_clean();
		
		if(preg_match('/Pass/', $output)) {
			require_once(dirname($usePath) .'/lib/password.php');
		}
	}
	
	if (!defined('PASSWORD_DEFAULT')) {
		define('PASSWORD_BCRYPT', 1);
		define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);
	}
}

// set a constant for testing...
define('UNITTEST__LOCKFILE', dirname(__FILE__) .'/files/rw/');

