<?php

namespace Awan;

class Controller
{
	function __construct($request)
	{
		$this->request = $request;
	}

	function __destruct()
	{
		// do all tear down stuff here
		// maybe catch all logging and benchmark
		// and also DB 

		global $dbconn;
		
	}
}