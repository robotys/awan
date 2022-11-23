<?php

namespace Awan;

use Awan\Route;

class Request
{
	// to hold all the information for current request cycle

	// request cycle: Route -> controller <-> model -> view -> response

	function __construct()
	{
		$this->route = null;
		$this->response = null;
		$this->body = null;
		$this->post = false;
		$this->get = null;
		$this->file = null;
		$this->cookie = null;
	}

	function run()
	{
		$this->route = new Route;
		// echo 'Hello world!';
	}

	function post($key = null)
	{
		
		if(!empty($_POST)) $this->post = $_POST;

		if($key == null) return $this->post;
		elseif(array_key_exists($key, $this->post) !== FALSE) return $this->post[$key];
		else return null; 
	}
}