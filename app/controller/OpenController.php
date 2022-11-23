<?php

namespace App;

use Awan\Controller;
use Awan\Response;
use Awan\DB;

class OpenController extends Controller
{
	function index()
	{
		$data['title'] = 'Welcome to '.env('app_name').'!';

		view('/open/home', $data);
	}
}