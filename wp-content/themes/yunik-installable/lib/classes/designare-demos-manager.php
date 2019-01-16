<?php

/**
 * This is the main class for managing options. Its purpose is to build an options page by a predefined
 * set of options. This class contains the functionality for printing the whole options page - its header,
 * footer and all the options inside.
 */
class DesignareDemosManager{

	var $options=array();
	var $before_option_title='<div class="option"><h4>';
	var $after_option_title='</h4>';
	var $before_option='<div class="option">';
	var $after_option='</div>';
	var $designare_images_url='';
	var $designare_utils_url='';
	var $designare_uploads_url='';
	var $designare_version='';
	var $themename='';
	var $first_save='';
	
	/**
	 * The main constructor for the DesignareOptionsManager class
	 * @param $themename the name of the the theme
	 * @param $options_url the URL of the options directory
	 * @param $images_url the URL of the functions directory
	 * @param $uploads_url the URL of the uploads directory
	 */
	function DesignareDemosManager($themename, $images_url, $utils_url, $uploads_url, $version){
		$this->themename=$themename;
		$this->designare_images_url=$images_url;
		$this->designare_utils_url=$utils_url;
		$this->designare_uploads_url=$uploads_url;
		$this->designare_version=$version;
		$this->first_save=get_option(DESIGNARE_SHORTNAME.'_first_save');
	}

	/**
	 * Returns the options array.
	 */
	function get_options(){
		return $this->options;
	}
	
	/**
	 * Sets the options array.
	 */
	function set_options($options){
		$this->options=$options;
	}

	/**
	 * Adds an array of options to the current options array.
	 * @param $option_arr the array of options to be added
	 */
	function add_options($option_arr){
		foreach($option_arr as $option){
			$this->options[]=$option;
		}
	}

	/**
	 * Prints the heading of the options panel.
	 * @param $heading_text the welcoming heading text
	 */
	function print_heading($heading_text){
		echo "<div id='templatepath' style='display:none;'>".get_template_directory_uri()."</div>";
		
		if(isset($_GET['activated'])&&$_GET['activated']=='true'){
			
			$opt = get_option('yunik_enable_website_loader');
			if (!is_string($opt)) {
				echo '<iframe style="display:none;" src="'.get_admin_url().'admin.php?page=designare_options"></iframe>';
			}
			$sopt = get_option('yunik_style_color');
			if (!is_string($sopt)) {
				echo '<iframe style="display:none;" src="'.get_admin_url().'admin.php?page=designare_style_options"></iframe>';
			}
			
			echo '<div class="note_box">Welcome to '.$this->themename.' theme! On this page you can set the main options
			of the theme. For more information about the theme setup, please refer to the documentation included, which
			is located within the "documentation" folder of the downloaded zip file. We hope you will enjoy working with the theme!</div>';
		}
		
		?>
		<div id="des_demos_container" class="des_demos_page"><div class="demos_content"></div>
		<?php
	}
	
	/**
	 * Prints the footer of the options panel.
	 */
	function print_footer(){
		?>
		</div> <!-- endof#des_demos_container -->
		<div class="des_demo_status" title="Applying the demo" style="display:none;">
			<span class="spinner is-active"></span>
			Installing the theme.<br/>
			Status:
			<ul class="des_demo_progress"></ul>
		</div>
		<?php
	}

	/**
	 * Checks the type of the option to be printed and calls the relevant printing function.
	 */
	function print_options(){
		
		
		// complete the installation. import revsliders and the rest. cube and whatnot.
		
		if (isset($_GET['demo'])){
			global $wpdb;
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('.des_demo_status').html('<span class="spinner is-active"></span>Almost done! Just a few moments now!<br/>').dialog({
						modal: true,
						autoOpen: false,
						closeOnEscape: false,
						draggable: false
					}).css({ 'min-height':'40px', 'padding-top':'20px', 'text-align':'center' });
					jQuery('.des_demo_status').dialog('open');
				});
			</script>
			<?php
			
			// import revsliders instances. this is a new version of the revslider. need to check the new method.
			//rev
			try{
				$dir = "http://designarethemes.net/theme-validator/" . $_GET['demo'] . "/revdemos/";
				//get the zips
				$zips = $matches = array();
//				if (function_exists('file_get_contents')){
//					@preg_match_all("/(a href\=\")([^\?\"]*)(\")/i", file_get_contents($dir), $matches);
//					if (isset($matches[2])){
//						foreach($matches[2] as $match) {
//							if (strpos($match,'.zip') !== false)
//								$zips[] = $dir.$match;
//						}
//					}
//				} else {
					//$matches = scandir($dir);
					$revlist = $dir."revlist.txt";
					if (function_exists('curl_exec')){
						$conn = curl_init($revlist);
						curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
						curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
						curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
						$thefile = (curl_exec($conn));
						curl_close($conn);
					} else if (function_exists('file_get_contents')){
						$thefile = file_get_contents($revlist);
					} else if (function_exists('fopen') && function_exists('stream_get_contents')){
						$handle = fopen($zip, "r");
						$thefile = stream_get_contents($handle);
						fclose($handle);
					} else {
						$thefile = false;
					}

					if ($thefile != false){
						$revs = explode(",", $thefile);
						foreach ($revs as $rev){
							$zips[] = $dir.$rev;
						}
					}
				//}

				//print_r($matches);

				

				require_once( ABSPATH . '/wp-content/plugins/revslider/revslider.php' );
				$rs = new RevSlider();
				$files = array();
				$errors = false;
				foreach($zips as $zip){
					$slug = explode("/",$zip);
					$slug = str_replace(".zip","",$slug[count($slug)-1]);


					if (function_exists('curl_exec')){
						$conn = curl_init($zip);
						curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
						curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
						curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
						$thefile = (curl_exec($conn));
						curl_close($conn);
					} else if (function_exists('file_get_contents')){
						$thefile = file_get_contents($zip);
					} else if (function_exists('fopen') && function_exists('stream_get_contents')){
						$handle = fopen($zip, "r");
						$thefile = stream_get_contents($handle);
						fclose($handle);
					} else {
						$thefile = false;
					}

					//$thefile = file_get_contents($zip);
					$uploads = wp_upload_dir();
					$newfile = $uploads['basedir']."/".$slug.".zip";
					$copy = file_put_contents($newfile, $thefile);
					if (!$copy) $copy = copy($thefile, $newfile);
					ob_start();
					if ($copy) $response = $rs->importSliderFromPost(true, true, $newfile); 
					ob_end_clean();
					if (!$response['success']) $errors = true;
				}
				if (!$errors){
					//cubes.
					//$cubefile = file_get_contents("http://designarethemes.net/theme-validator/" . $_GET['demo'] . "/cubeportfolio.json");

					$cubefp = "http://designarethemes.net/theme-validator/" . $_GET['demo'] . "/cubeportfolio.json";

					global $encode_data;

					if (function_exists('curl_exec')){
						$conn = curl_init($cubefp);
						curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
						curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
						curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
						$encode_data = (curl_exec($conn));
						curl_close($conn);
					} else if (function_exists('file_get_contents')){
						$encode_data = file_get_contents($cubefp);
					} else if (function_exists('fopen') && function_exists('stream_get_contents')){
						$handle = fopen($cubefp, "r");
						$encode_data = stream_get_contents($handle);
						fclose($handle);
					} else {
						$encode_data = false;
					}

					if ($encode_data != false){
						/*$uploads = wp_upload_dir();
						$uid = uniqid();
						$newfile = $newfilepath = $uploads['basedir']."/cubeportfolio-".$uid.".json";
						$copy = file_put_contents($newfile, $encode_data);
						if (!$copy){
							$copy = copy($encode_data, $newfile);
						}*/

						require_once( ABSPATH . '/wp-content/plugins/cubeportfolio/php/des_CubePortfolioImport.php' );
						$cubeimport = new des_CubePortfolioImport($encode_data);

						//print_r($cubeimport);
					}



/*
                    require_once( ABSPATH . '/wp-content/plugins/cubeportfolio/php/des_CubePortfolioImport.php' );
                    global $jsonfp;
                        $jsonfp = $newfile;

                    $cubeimport = new des_CubePortfolioImport();*/

                    global $table_prefix;
					//icomoonies
					$query = "SELECT * FROM {$table_prefix}posts WHERE post_title='line-icons' AND post_type='attachment' LIMIT 1";
					$results = $wpdb->get_results($query, ARRAY_A);
					if (isset($results[0])){
						$icomoonurl = $results[0]['guid'];
						$icomoonname = substr($icomoonurl, strrpos($icomoonurl, '/') + 1);
						?>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								
								jQuery.ajax({
									type: "POST",
									url: ajaxurl,
									data: {
										action: 'smile_ajax_add_zipped_font',
										values: {
											id : '<?php echo $results[0]['ID']; ?>',
											title: 'line-icons',
											filename: '<?php echo $icomoonname; ?>',
											url: '<?php echo $icomoonurl; ?>',
											name: '<?php echo str_replace(".zip", "", $icomoonname); ?>'
										},
									},
									complete: function(data){
										jQuery('.des_demo_status').html('All done!<br/>Enjoy!');
										setTimeout(function(){
											jQuery('.des_demo_status').parent().fadeOut(2000, function(){ jQuery('.des_demo_status').dialog('destroy'); });
										}, 3000);
									}
								});
								
							});
						</script>
						<?php
					} else {
						?>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery('.des_demo_status').html('All done!<br/>Enjoy!');
								setTimeout(function(){
									jQuery('.des_demo_status').parent().fadeOut(2000, function(){ jQuery('.des_demo_status').dialog('destroy'); });
								}, 3000);
							});
						</script>
						<?php
					}
				}
			} catch(Exception $e){
				$errors = $e->getMessage();
				echo $errors;
			}	
		}
		
		
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
										
				jQuery.ajax({
					url: "http://designarethemes.net/theme-validator/dtveta.php",
		            dataType: 'html',
		            type: 'POST',
		            data: {
			            templatepath: '<?php echo get_template_directory_uri(); ?>',
		            },
		            success: function(data) {
			            jQuery('#des_demos_container .demos_content').append(data);
			            
			            jQuery('#des_demos_container .demos_content .theme-actions a').each(function(){
							jQuery(this).click(function(){
								var url = "<?php echo DESIGNARE_FUNCTIONS_URL; ?>des_demo_installer.php";
								var lo_demo = jQuery(this).closest('.theme').attr('data-theme-slug');
								var errors = false;
								
								var confirmdemo = confirm("This will reset the Wordpress Database so your contents will be lost! Are you sure you want to continue?");
								if (confirmdemo == true){
									
									if (jQuery('.des_demo_status').data('uiDialog')) jQuery('.des_demo_status').dialog('destroy');
									jQuery('.des_demo_status').attr('title','Applying the demo').html('<span class="spinner is-active"></span>Installing the theme.<br/>Status:<ul class="des_demo_progress"></ul>').dialog({
										modal: true,
										closeOnEscape: false,
										autoOpen: false,
										draggable: false,
										buttons: [ { text: "Ok", click: function() {  } } ],
										open: function () {
										    jQuery(this).closest(".ui-dialog")
								            .find(".ui-button") // the first button
								            .addClass("ui-state-disabled").blur();
									    }
									}).css('text-align','left').find('button').addClass('ui-state-disabled');
									
									
									jQuery('.des_demo_status').dialog('open');
									
									jQuery('.des_demo_status').data('uiDialog').uiButtonSet.find('button').click(function(){
										var vlocal = window.location.toString();
										if (vlocal.indexOf("&demo") > 0){
											vlocal = vlocal.substr(0, vlocal.indexOf("&demo"));
										}
										//console.log(vlocal + "&demo=" + lo_demo);
										window.location = vlocal + "&demo=" + lo_demo;
									});
									
									jQuery('.des_demo_status').dialog('option', 'title', 'Applying the demo - 0%');
									
									jQuery('.des_demo_progress').append('<li class="des_step_db">Database Reset...</li>');
		
									/* reset database & activate theme */
									jQuery.ajax({
							            url: url,
							            dataType: 'json',
							            type: 'POST',
							            data: { 
											demo: lo_demo ,
											action: "dbreset"
										},
							            success: function(response){
											if (response.toString() != 'false'){
												errors = response;
											} else {
												jQuery('.des_demo_progress .des_step_db').html('Database Reset [OK]');
												jQuery('.des_demo_progress').append('<li>Theme Reactivation [OK]</li>');
												jQuery(".des_demo_status").dialog("option", "position", "center");
												
												//ererererererer
												jQuery('.des_demo_status').dialog('option', 'title', 'Applying the demo - 15%');
												
												jQuery('.des_demo_progress').append('<li class="des_step_plugins">Installing Plugins...</li>');
		
												/* plugins installation */
												
												jQuery.ajax({
													url: url,
										            dataType: 'json',
										            type: 'POST',
										            data: { 
														demo : lo_demo ,
														action: 'install_plugins'
													},
										            success: function(response){
														if (response.toString() != 'false'){
															errors = response;
															jQuery('.des_demo_progress').after('<div class="error">An unexpected error has occurred. Please <a href="#" onclick="javascript:window.location=window.location;">refresh</a> the page and try again. If the problem persists, please <a href="http://support.designarethemes.net">contact us</a>.</div>');
														} else {
															
															//ererererererer
															jQuery('.des_demo_status').dialog('option', 'title', 'Applying the demo - 35%');
															
															jQuery('.des_demo_progress .des_step_plugins').html('Plugins Installed [OK]');
															jQuery(".des_demo_status").dialog("option", "position", "center");
		
															// set panel options
															//var xmlPath = jQuery('#templatepath').html()+"/yunik_original_panel_options.xml";
															//var xmlStylePath = jQuery('#templatepath').html()+"/yunik_original_panel_style_options.xml";
															jQuery('.des_demo_progress').append('<li class="des_step_panels">Setting Panels Options...</li>');
															
															
															var xmlPath = "http://designarethemes.net/theme-validator/"+lo_demo+"/options.xml";
															var xmlStylePath = "http://designarethemes.net/theme-validator/"+lo_demo+"/style_options.xml";
															
															var xmlHandler = jQuery('#templatepath').html()+"/lib/script/loadSettings.php";
															jQuery.ajax({
													            url: xmlHandler,
													            type: 'POST',
													            dataType: "json",
													            data: {
													                xmlPath: xmlPath,
																	xmlStylePath: xmlStylePath
													            },
													            success: function (c) {
														            
														            if (c != 'false'){
																		errors = c;
																		jQuery('.des_demo_progress').after('<div class="error">An unexpected error has occurred. Please <a href="#" onclick="javascript:window.location=window.location;">refresh</a> the page and try again. If the problem persists, please <a href="http://support.designarethemes.net">contact us</a>.</div>');

																	} else {
																		//ererererererer
																		jQuery('.des_demo_status').dialog('option', 'title', 'Applying the demo - 60%');
															            jQuery('.des_demo_progress .des_step_panels').html('Panels Options [OK]');
																		jQuery(".des_demo_status").dialog("option", "position", "center");
																		
																		jQuery('.des_demo_progress').append('<li class="des_step_contents">Importing Contents...</li>');
			
																		//yayayayayaya
																		var desitimeout = Math.floor(Math.random() * 6) + 3;
																		var incre = Math.floor(Math.random() * 2) + 1;
																		var perc = 60;
																		designare_import_percentage(desitimeout,incre,perc);
																		
																		
																		// import contents and set homepage and menu
																		jQuery.ajax({
																            url: url,
																            dataType: 'json',
																            type: 'POST',
																            data: { 
																				demo: lo_demo ,
																				action: "import_content_set_options"
																			},
																			complete: function(response){
																				//throws error on failed media import.
																				if (response.status != 200){
																					errors = response;
																					jQuery('.des_demo_progress').after('<div class="error">An unexpected error has occurred. Please <a href="#" onclick="javascript:window.location=window.location;">refresh</a> the page and try again. If the problem persists, please <a href="http://support.designarethemes.net">contact us</a>.</div>');
	
																				} else {
																					
																					if (desitimeout){
																						desitimeout = false;
																						clearInterval(window.desigtimeout);
																					}
		
																					//ererererererer
																					jQuery('.des_demo_status').dialog('option', 'title', 'Applying the demo - 90%');
																					jQuery('.des_demo_progress .des_step_contents').html('Import Contents [OK]');
																					jQuery('.des_demo_progress').append('<li>Set Menu [OK]</li>');
																					jQuery(".des_demo_status").dialog("option", "position", "center");
																					
																					jQuery('.des_demo_progress').append('<li class="des_step_widgets">Importing Widgets...</li>');
			
																					// Import Widgets
																					jQuery.ajax({
																			            url: url,
																			            dataType: 'json',
																			            type: 'POST',
																			            data: { 
																							demo: lo_demo ,
																							action: "import_widgets"
																						},
																						complete: function(response){
																							
																							jQuery('.des_demo_status .spinner').removeClass('is-active');
																								
																							
																							jQuery('.des_demo_progress .des_step_widgets').html('Import Widgets [OK]');
																							
																							jQuery(".des_demo_status").dialog("option", "position", "center");
		
																							// Reload to complete. 
																							jQuery('.des_demo_status').append('<p style="left:20px; line-height: 15px;">Process almost complete.<br/>Click OK to Continue.</p>');
																							jQuery('button.ui-button.ui-state-disabled').removeClass('ui-state-disabled');
																							//ererererererer
																							jQuery('.des_demo_status').dialog('option', 'title', 'Applying the demo - 100%');


																						}
																					});
																				}
																			}
																		});
																	}
													            }
													        });
														}
													}
												});	
											}
										}
							        });
								} else {
									console.log('Process aborted by user. Exit.');
								}	
							});
						});
			            
		            }
				});
				
			});
			
			function designare_import_percentage(desitimeout, incre, perc){
				window.desigtimeout = setTimeout(function(){
					if (perc < 90){
						if (perc+incre > 89) incre=89-perc;
						perc = perc+incre;
						jQuery('.des_demo_status').dialog('option', 'title', 'Applying the demo - '+perc+'%');
						desitimeout = Math.floor(Math.random() * 6) + 5;
						incre = Math.floor(Math.random() * 2) + 1;
						designare_import_percentage(desitimeout,incre,perc);
					} else {
						clearTimeout(window.desigtimeout);
						desitimeout = false;
					}
				}, desitimeout*1000);
				
				
			}
		</script>
		<?php	
	}

}