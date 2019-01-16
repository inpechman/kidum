<?php
	
	$path = dirname(__FILE__);
	$os = ((strpos(strtolower(PHP_OS), 'win') === 0) || (strpos(strtolower(PHP_OS), 'cygwin') !== false)) ? 'win' : 'other';
	$abspath = ($os === "win") ? substr($path, 0, strpos($path, "\wp-content"))."\wp-load.php" : substr($path, 0, strpos($path, "/wp-content"))."/wp-load.php";
	require_once($abspath);
	
	global $wp;
	
	$uploaddir = wp_upload_dir();
	$filename = ($os === "win") ? $uploaddir['basedir']."\style_options.xml" : $uploaddir['basedir']."/style_options.xml";
	//echo $filename;
	header('Content-Disposition: attachment;filename=style_options.xml');
    header("Content-Type: application/force-download");

	$xml = fopen($filename, "r");
	$contents = fread($xml, filesize($filename));
	fclose($xml);
	print $contents;

?>
