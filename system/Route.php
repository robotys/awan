<?php

namespace Awan;

// to manage all the routing for current request

class Route
{
	function __construct()
	{
		// init all the things
		global $route;
		$this->config = $route;

		if(array_key_exists('default_controller', $this->config) === FALSE)
		{
			$this->config['default_controller'] = null;
		}

		$this->uri = $_SERVER['REQUEST_URI'];
		$this->uri_segment = explode('/', $this->uri);
		$this->controller = $this->uriSegment(1);
		$this->method = $this->uriSegment(2);
		$this->go();
	}

	function uriSegment($position = null)
	{
		if($position == null)
		{
			return $this->uri_segment;
		}
		elseif(
			array_key_exists($position, $this->uri_segment) !== FALSE
			AND $this->uri_segment[$position] != ''
		)
		{
			return $this->uri_segment[$position];
		}
		else
		{
			return null;
		}
	}

	function go()
	{
		// change according to defined route
		// dd($_SERVER['REQUEST_URI']);

		// load the controller for current route
		$controller = $this->uriSegment(1);
		$method = $this->uriSegment(2);

		$method = str_replace('-', '_', $method);
		
		if($method == '') $method = 'index';
		
		if($controller == null)
		{
			// use default
			$def = $this->config['default_controller'];

			if($def == null) show404('<code>default_controller</code> route was not found in <code>config/web.php</code>');

			$exp = explode('/',$def);

			if(array_key_exists(0, $exp) !== FALSE) $controller = $exp[0];
			if(array_key_exists(1, $exp) !== FALSE) $method = $exp[1];
		}

		global $request;
		global $app_namespace;

		$class = $app_namespace.'\\'.$controller.'Controller';

		if(class_exists($class) == false) show404();

		$this->controller = new $class($request);
		
		$this->controller->$method();		
		
	}
}