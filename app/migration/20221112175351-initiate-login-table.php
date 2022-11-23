<?php

namespace App;

use Awan\DB;

return new class
{
	function up()
	{
		$sql = "CREATE TABLE login_email(
	id INTEGER(40) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL,
	pass VARCHAR(255) NOT NULL,
	last_login_date DATE,
	last_login_time TIME,
	created_date DATE NOT NULL,
	created_time DATE NOT NULL 
)";
		$db = new DB;

		$db->query($sql);

	}

	function down()
	{
		$sql = "DROP TABLE login_email";

		$db = new DB;

		$db->query($sql);
	}
};