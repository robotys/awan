<?php

require_once('import.php');

// print_r($argv);

$command = $argv[1];

if($command == 'serve')
{
	// Turn off output buffering
    ini_set('output_buffering', 'off');
    // Turn off PHP output compression
    ini_set('zlib.output_compression', false);
    // Disable Apache output buffering/compression
    if (function_exists('apache_setenv')) {
        apache_setenv('no-gzip', '1');
        apache_setenv('dont-vary', '1');
    }

    $exp = explode('//', env('base_url'));
    $address = $exp[1];
    
    // system("cd ../public | php -S ".$address);
    chdir('../public');
    system("php -S ".$address);
	// dd('Run the server!');
}

if($command == 'make:migration')
{
	if(!ISSET($argv[2])) dd('Please include migration filename (i.e. create-user-table)');

	$name = $argv[2];

	$filename = date('YmdHis').'-'.$name.'.php';

	$content = '<?php

namespace App;

use Awan\DB;

return new class
{
	function up()
	{
		
	}

	function down()
	{
		
	}
};';

	file_put_contents(APPDIR.'/migration/'.$filename, $content);

	print_r("Done create migration ".$filename."!\n");
}

if($command == 'migrate')
{
	\Awan\Migration::migrate();
}

if($command == 'rollback')
{
	\Awan\Migration::rollback();
}

