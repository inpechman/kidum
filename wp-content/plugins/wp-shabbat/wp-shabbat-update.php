<?php
/***********************
 function to auto update the dat file
 *******************/
$options = get_option('wp_shabbat_update_settings');

$lastfiletime = filectime(plugin_dir_path( __FILE__ ).'/GeoLiteCity.dat');

require_once(ABSPATH . "wp-admin" . '/includes/file.php');

// check if week passed since last update
if ( ($options['nextUpdate'] <  current_time('timestamp')) || ( $options['lastUpdate'] == '0' ) ){

		
		$upload_dir = wp_upload_dir();
		$remotefilesize = strlen(file_get_contents('http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz'));
		
		
		$file = download_url('http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz');
		$localfilesize = strlen(file_get_contents($file));
		
		if ( $localfilesize == $remotefilesize) {
			// get contents of a gz-file into a string
			$sfp = gzopen($file, "rb");
			$fp = fopen(plugin_dir_path( __FILE__ ).'/GeoLiteCity.dat', "w");

			while ($string = gzread($sfp, 4096)) {
				fwrite($fp, $string, strlen($string));
			}
			gzclose($sfp);
			fclose($fp);
			
			// check if file download and extracted succefully
			if ( filemtime(plugin_dir_path( __FILE__ ).'/GeoLiteCity.dat') > $lastfiletime ) {
				$updatestatus = __('file downloaded and extracted successfully','WP-Shabbat');
				$today = current_time('timestamp'); 
				$nextUpdate = strtotime('+1 week',$today) ;
			} else {
				$updatestatus = __('problem with file extraction','WP-Shabbat');
			}
		}
		else 
		{
		 $updatestatus = __('problem with file download','WP-Shabbat');
		}
	
	// delete the gz file
	unlink($file);
	
	// check if first time update
	if ( ($options['lastUpdate'] == '0' ) ){ 
			$today = current_time('timestamp'); 
			$nextUpdate = strtotime('+1 week',$today) ;
		}else{
                    $options = get_option('wp_shabbat_settings_hide_classes');
                    if ($options['email_updates'] == 1){
			// send mail to admin about the update status
			function set_html_content_type() {
				return 'text/html';
			}
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			$to =  get_option( 'admin_email' );
			$subject = __('WP-Shabbat plugin DB update status','WP-Shabbat');
			$user_info = get_userdata(1);
			$first_name = $user_info->first_name;
			$adminUrl = admin_url('options-general.php?page=wp_shabbat_admin');
			if (get_locale() == 'he_IL'){ 
				$locale = '<div style="direction: rtl;font-size:20px;">';
			}
			else {
				$locale = '<div style="font-size:20px;">';
			}
			$bodyHtml =	$locale .__('Hello ','WP-Shabbat') . $first_name .',
			<br/>'.__('this email sent to inform you the DB update status','WP-Shabbat').': <strong>'. $updatestatus .'</strong><br/><br/>
			<br/>'.__('and thank you for using WP-Shabbat Plugin this plugin is','WP-Shabbat').' <strong> '.__('free so please support us','WP-Shabbat').'</strong> <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=53KUKZ9KN2YBN">'.__('By helping us with the cost of the plugin','WP-Shabbat').' </a>
			<br/>
			<br/>'.__('and by helping us with your important review at ','WP-Shabbat').'<a href="https://wordpress.org/support/view/plugin-reviews/wp-shabbat"> ' .__('the wordpress.org plugin page','WP-Shabbat').'</a><br/>
			<br/>
			<a style="font-size:20px;" href="http://www.dossihost.net">http://www.DossiHost.net</a>
			</div>';
								
			wp_mail( $to, $subject, $bodyHtml );
			
			// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
                    }    
		}	
	
	/*	
	echo $nextUpdate;
	echo 'DEBUG: <pre>';
	print_r($options);
	echo '</pre>' ;*/
	
	


	
	$new_settings = array(
		'updatestatus' => $updatestatus,
		'lastUpdate' =>  intval($today),
		'nextUpdate' =>  intval($nextUpdate),
		
		
	);
	/*
	echo 'DEBUG: <pre>';
	print_r($new_settings);
	echo '</pre>' ;
	*/
		
	update_option('wp_shabbat_update_settings', $new_settings);
		
}
?>