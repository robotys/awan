<?php

use \Awan\Response;

function view($path, $data)
{
	Response::view($path, $data);
}

function timestamp()
{
	return date('Y-m-d H:i:s');
}

function lang($key, $default)
{

}

function uuid($length = 13)
{
	if( function_exists("random_bytes") )
	{
		$bytes = random_bytes(ceil($length / 2));
	}
	elseif( function_exists("openssl_random_pseudo_bytes") )
	{
		$bytes = openssl_random_pseudo_bytes(ceil($length / 2));
	}
	else
	{
		throw new Exception("no cryptographically secure random function available");
	}

	return substr(bin2hex($bytes), 0, $length);
}

function isCli()
{	
	$is_cli = (array_key_exists('SCRIPT_NAME', $_SERVER) !== FALSE 
			  AND $_SERVER['SCRIPT_NAME'] == 'awan.php');

	return $is_cli;
}

function env($key = null)
{
	global $env;
	
	if($key == null) return $env;
	elseif(property_exists($env, $key) !== FALSE) return $env->$key;
	else return null;
}

function dd($multi)
{

	$caller = debug_backtrace()[0];
	$location = $caller['file'].':'.$caller['line'];

	if(isCli())
	{
		print_r("dd:\n");
		print_r($multi);
		print_r("\n> location: ".$location."\n");
	}
	elseif(env('environment') != 'production')
	{
		echo '<pre>';
		if(is_bool($multi)) var_dump($multi);
		elseif(is_null($multi)) echo 'null';
		else var_dump($multi);
		echo $location;
		echo '</pre>';
	}
	elseif(env('environment') == 'production')
	{
		\Awan\Log::dd($multi, $location);
	}

	exit();
}

function showError($message = null)
{
	require(APPDIR.'/view/error/error.php');
	exit;
}

function show404($message = null)
{
	require(APPDIR.'/view/error/404.php');
	exit;
}