<?php

namespace Awan;

class Log
{
	static function dd($multi, $location)
	{
		$dir = APPDIR.'/log';
		// save to log files
		$file = $dir.'/dd-'.date('Y-m-d').'.log';

		// if(is_file($file) === FALSE) file_put_contents($file, null);

		$fp = fopen($file, 'a');

		$str = "\n".timestamp()."\n";

		if(is_string($multi) !== FALSE) $str .= $multi;
		elseif(is_object($multi) OR is_array($multi)) $str .= json_encode($multi, JSON_PRETTY_PRINT);

		$str .= "\n$location\n";

		fputs($fp, $str);
	}
}