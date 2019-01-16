<?php
	$path = dirname(__FILE__);
	$os = ((strpos(strtolower(PHP_OS), 'win') === 0) || (strpos(strtolower(PHP_OS), 'cygwin') !== false)) ? 'win' : 'other';
	$abspath = ($os === "win") ? substr($path, 0, strpos($path, "\wp-content"))."\wp-load.php" : substr($path, 0, strpos($path, "/wp-content"))."/wp-load.php";
	require_once($abspath);
	$errors = 'false';
	
	global $wpdb;
	if (isset($_POST['xmlPath'])){
			$xml = false;
			if (function_exists('curl_exec')){
				$conn = curl_init($_POST['xmlPath']);
				curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
				curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
				curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
				$xml = (curl_exec($conn));
				curl_close($conn);
			} else if (function_exists('file_get_contents')){
				$xml = file_get_contents($_POST['xmlPath']);
			} else if (function_exists('fopen') && function_exists('stream_get_contents')){
				$handle = fopen($_POST['xmlPath'], "r");
				$xml = stream_get_contents($handle);
				fclose($handle);
			} else {
				$xml = false;
			}

			if ($xml != false){
				$contents = json_decode(json_encode((array)simplexml_load_string($xml)),1);
				foreach($contents['option'] as $opt){
					if ($opt['id'] == 'ultimate_selected_google_fonts' && is_string($opt['value']) && $opt['value'] != ""){
						update_option($opt['id'], unserialize(stripslashes($opt['value'])),true);
					} else {
						if ($opt['id'] == 'page_on_front'){
							update_option('show_on_front','page', true);
							update_option('page_on_front', $opt['value'], true);
						}
						update_option($opt['id'], $opt['value'], true);
					}
				}
			} else {
				//echo "there was a problem with your server.";
			}
	}
	
	if (isset($_POST['xmlStylePath'])) {
		$xml = false;
		if ( function_exists( 'curl_exec' ) ) {
			$conn = curl_init( $_POST['xmlStylePath'] );
			curl_setopt( $conn, CURLOPT_SSL_VERIFYPEER, true );
			curl_setopt( $conn, CURLOPT_FRESH_CONNECT, true );
			curl_setopt( $conn, CURLOPT_RETURNTRANSFER, 1 );
			$xml = ( curl_exec( $conn ) );
			curl_close( $conn );
		} else if ( function_exists( 'file_get_contents' ) ) {
			$xml = file_get_contents( $_POST['xmlStylePath'] );
		} else if ( function_exists( 'fopen' ) && function_exists( 'stream_get_contents' ) ) {
			$handle = fopen( $_POST['xmlStylePath'], "r" );
			$xml = stream_get_contents( $handle );
			fclose($handle);
		} else {
			$xml = false;
		}

		if ( $xml != false ) {
			$contents = json_decode( json_encode( (array) simplexml_load_string( $xml ) ), 1 );
			foreach ( $contents['option'] as $opt ) {
				update_option( $opt['id'], $opt['value'], true );
			}
		} else {
			//echo "there was something wrong with your server.";
		}
	}
	echo json_encode($errors);

?>