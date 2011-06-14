<?php  //by H. Geppl: integration of swfupload

    	global $USER;		
	    $userid = $USER->id;		
		$max_file_size = get_max_upload_file_size($CFG->maxbytes, $course->maxbytes, $modbytes=0)/1024;
		$strupload_files = get_string('fileuploads','install');				
		$strflashupload = get_string('flashupload','flashupload');			
		$strcancel_upload = get_string('cancel_upload','flashupload');			
		?>
		
	    <script type="text/javascript" src="flashupload/swfupload.js"></script>
	    <script type="text/javascript" src="flashupload/swfupload.queue.js"></script>
	    <script type="text/javascript" src="flashupload/fileprogress.js"></script>
	    <script type="text/javascript" src="flashupload/handlers.js"></script>
           <script type="text/javascript">
               var head = document.getElementsByTagName("head")[0];
               var link = document.createElement("link");
               link.rel = "stylesheet";
               link.href = "flashupload/flashupload.css";
               link.type = "text/css";
               link.media = "all";
               head.appendChild(link);
           </script>
		<script type="text/javascript">
                     strflashupload = '<?php echo $strflashupload;?>';
                     strneeded = '<?php echo get_string('required');?>';
                	strflashpix = '<?php echo $CFG->pixpath ?>/f/flash.gif';
			strcomplete = '<?php echo get_string('complete');?>';
	                struploadsuccess = '<?php echo get_string('uploadedfile').'. '.get_string('uploadtime','flashupload').': ';?>';			
			strtimeremain = '<?php echo get_string('timeremain','flashupload');?>';
			strestimating = '<?php echo get_string('estimating','flashupload');?>';
			strof = '<?php echo get_string('of','flashupload');?>';
			strat = '<?php echo get_string('at','flashupload');?>';
			strpending = '<?php echo get_string('pending','flashupload');?>';
			strfile_toobig = '<?php echo get_string('file_too_big','flashupload');?>';
			strzero_byte = '<?php echo get_string('zero_byte','flashupload');?>';					
			strcancelled = '<?php echo get_string('cancelled');?>';		
			
			function refresh_folder() {
					var doc_href = document.location.href;
					var urlend = doc_href.substr(doc_href.length-9,doc_href.length);
					if (urlend=='index.php') {
						location.href = doc_href + '?id=<?php echo $course->id."&wdir=".$wdir; ?>';
					} else {
						location.href = doc_href;
					}			
			}	

			window.onload = function() {
				var tmpupload_url;
				if (navigator.appVersion.indexOf("Win")!=-1 && navigator.appName == "Microsoft Internet Explorer") {	
				    tmpupload_url = "flashupload/upload.php?id=<?php echo $course->id."&sub=".$wdir."&user=".$userid ?>";	// Relative to the SWF file (or you can use absolute paths)					
				} else {    
                            	    tmpupload_url = "./upload.php?id=<?php echo $course->id."&sub=".$wdir."&user=".$userid ?>";	// Relative to the SWF file (or you can use absolute paths)					
				}
							
				var settings = {
					// Backend Settings
					upload_url: tmpupload_url,
					post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},

					// File Upload Settings
					file_size_limit : "<?php echo $max_file_size ?>",
					file_types : "*.*",
					file_types_description : "All Files",
					file_upload_limit : 100,
					file_queue_limit : 0,

					// Event Handler Settings (all my handlers are in the Handler.js file)
					file_dialog_start_handler : fileDialogStart,
					file_queued_handler : fileQueued,
					file_queue_error_handler : fileQueueError,
					file_dialog_complete_handler : fileDialogComplete,
					upload_start_handler : uploadStart,
					upload_progress_handler : uploadProgress,
					upload_error_handler : uploadError,
					upload_success_handler : uploadSuccess,
					upload_complete_handler : uploadComplete,
					
					// Button Settings
					button_image_url : "flashupload/uploadbutton.png",	// Relative to the SWF file
					button_placeholder_id : "spanButtonPlaceholder",
					button_width: 61,
					button_height: 22,
					
					// Flash Settings
					flash_url : "flashupload/swfupload.swf",									

					custom_settings : {
						progressTarget : "fsUploadProgress",
						cancelButtonId : "btnCancel"	
					},
					
					// Debug Settings
					debug: false						
				};
				
			    var swfu;
				swfu = new SWFUpload(settings);				
			 }
			 
		</script>
		<p>
			<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
				<div class="content">
					<table align="center" >						
							<tr valign="top">
							<td>
								<div align="center" id="flashUI">
									<fieldset class="flash" id="fsUploadProgress">
										<legend id="flashupload_legend"><span><?php echo $strflashupload .' (Max. '. $max_file_size/1024 ?> MB)</span></legend>
									</fieldset>
									<div id="swfupload_buttons">
										<span id="spanButtonPlaceholder"></span>
										<input id="btnCancel" type="button" value="<?php echo $strcancel_upload ?>" onclick="cancelQueue(swfu);" disabled="disabled" /><br />
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</form>
		</p>