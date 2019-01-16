<?php

	$path = dirname(__FILE__);
	$os = ((strpos(strtolower(PHP_OS), 'win') === 0) || (strpos(strtolower(PHP_OS), 'cygwin') !== false)) ? 'win' : 'other';
	$abspath = ($os === "win") ? substr($path, 0, strpos($path, "\wp-content"))."\wp-load.php" : substr($path, 0, strpos($path, "/wp-content"))."/wp-load.php";
	require_once($abspath);

	function send_email($to, $subject, $name, $msg, $e, $error){
		
		$headers = "From: " . $name . "\r\n";
		$headers .= "Reply-To: ". $e . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		
		$msg = stripslashes($msg);
				
		if(mail($to, $subject, $msg, $headers)){
			return true;
		} else {
			return false;
		}
	}
	
?>