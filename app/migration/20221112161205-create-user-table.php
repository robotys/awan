<?php

namespace App;

use Awan\DB;

return new class
{
	function up()
	{
		$db = new DB;

		// create table
		$sql = "CREATE TABLE users (
	id INTEGER(40) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	email_verification_key VARCHAR(255) NOT NULL,
	uuid VARCHAR(255) NOT NULL
);";
		$db->query($sql);

		// create index uuid
		$sql = "CREATE INDEX uuid ON users (uuid)";
		$db->query($sql);

		// create index email
		$sql = "CREATE INDEX email ON users (email)";
		$db->query($sql);

		// create index email_verification_key
		$sql = "CREATE INDEX email_verification_key ON users (email_verification_key)";
		$db->query($sql);

	}

	function down()
	{
		$db = new DB;

		// drop index
		$sql = "ALTER TABLE users
DROP INDEX email;";
		
		$db->query($sql);

		// drop table
		$sql = "DROP TABLE users";

		$db->query($sql);
	}
};