<?php

define('BASEPATH', '../');
define('APPDIR', '../app');
define('SYSDIR', '../system');

// load the helper first, so that 
// we can use dd anywher in the app
require_once(SYSDIR.'/helper.php');

$env = (object)[];
$config = (object)[];
$route = [];

// load all related files in the directory
// the order is important to maintain
// global variable integrity
$dirs = [
	APPDIR.'/config',
	APPDIR.'/helper',
	SYSDIR,
	APPDIR.'/controller',
	APPDIR.'/model',
	APPDIR.'/route.php',
];

$exclude = [
	'init.php', // already loaded
	'import.php', // already loaded
	'helper.php', // already loaded
	'awan.php', // only for cli
];

foreach($dirs as $dir)
{
	// if php file, immediately load
	// else: assume it is a directory
	if(strpos($dir, '.php'))
	{
		require_once($dir);
	}
	else
	{
		$files = scandir($dir);

		foreach($files as $file)
		{
			// only load php file
			if(strpos($file, '.php') != FALSE)
			{
				$is_exclude = array_search($file, $exclude) !== FALSE;
				
				if(!$is_exclude)
				{
					$path = $dir.'/'.$file;

					require_once($path);
				}
			}
		}
	}
}
