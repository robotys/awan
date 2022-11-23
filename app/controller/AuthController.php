<?php

namespace App;

use Awan\Response;

class AuthController extends \Awan\Controller
{
	function login()
	{
		Response::view('auth/login');
	}

	function signup()
	{
		if($this->request->post())
		{
			// dd($this->request->post('name'));
		}

		Response::view('auth/signup');
	}

	function verify_email()
	{

	}
}