<?php

namespace Awan;

use Awan\DB;

class Migration
{
	static function migrate()
	{
		$db = new DB;

		if(!$db->isTableExists('migration'))
		{
			$sql = "CREATE TABLE migration(
id INTEGER(40) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
filename VARCHAR(255) NOT NULL,
batch INTEGER(40) NOT NULL)";

			$db->query($sql);
			// create table migration!
		}

		$sql = "SELECT * FROM migration";

		$res = $db->query($sql)->result();
		$dones = [];
		$last_batch = 0;

		if(!empty($res))
		{
			$dones = array_column($res, 'filename');

			$last = array_pop($res);
			$last_batch = $last->batch;
		}

		// get all files to migrate
		$dir = APPDIR.'/migration';
		
		$files = scandir($dir);
		
		unset($files[0]); // .
		unset($files[1]); // ..

		foreach($files as $filename)
		{
			$is_done = array_search($filename, $dones) !== FALSE;

			if(!$is_done)
			{
				$batch = $last_batch + 1;
				
				$mig = require_once($dir.'/'.$filename);
				$mig->up();

				$db = new DB;
				
				$res = $db->insert('migration', ['filename' => $filename, 'batch' => $batch]);

				if($res) print_r('Done '.$filename."\n");
			}
		}

		print_r("Done all migration!\n");

		// compare with what has been migrate

		// do migration one by one
	}

	static function rollback()
	{
		$db = new DB;

		$last_batch = null;

		$row = $db->select('max(batch) as last_batch')
		   		  ->get('migration')
		   		  ->row();

		if($row->last_batch != null)
		{
			$last_batch = $row->last_batch;
			// dd($last_batch);
			// rollback last_batch
			$result = $db->where('batch', $last_batch)
						 ->get('migration')
						 ->result();

			$ids = [];
			foreach($result as $row)
			{
				$ids[] = $row->id;

				$mig = require_once(APPDIR.'/migration/'.$row->filename);
				$mig->down();
			}

			$db->where_in('id', $ids)->delete('migration');
			print_r("Rollback ".$row->filename."\n");	
		}

		print_r("Done rollback!\n");


	}
}