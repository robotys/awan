<?php

namespace Awan;

class Response
{
	function __construct()
	{

	}

	static function view($path = null, $data = [])
	{

		foreach($data as $key=>$value)
		{
			$$key = $value;
		}

		$view = trim($path, '/');
		
		if(strpos($view, '.php') === FALSE) $view .= '.php';

		$view = APPDIR.'/view/'.$view;

		if(is_file($view) == false) showError('View file not found '.$path);

		// if(is_file(filename))

		require_once($view);
	}

	static function json($data)
	{
		echo json_encode($data, JSON_PRETTY_PRINT);
	}

}