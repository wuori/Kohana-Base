<?

	/*
	 
	Script: Combine-javascript.php
		Dynamically concatenate source javascript files during development. 
	 
	Example:
		<script type="text/javascript" src="scripts/source/combine-javascript.php"></script>
	 
	*/
	 
	// Array of files to merge
	$aFiles = array(
		'public/js/jquery.js',
		'public/js/jquery.date.js',
		'public/js/jquery.datepicker.js',
		'public/js/swfobject.js',
		'public/js/fb_connect.js',
		'public/js/jquery.facebox.js',
		'public/js/common.js'
	);
	
	 
	// Get the path to your web directory
	$sDocRoot = $_SERVER['DOCUMENT_ROOT'];
	 
	// Merge code
	$sCode = '';
	foreach ($aFiles as $sFile) {
		$sCode .= file_get_contents("$sDocRoot/$sFile");
	}
	 
	$file = "tnnas.js";
	 
	// Send HTTP headers
	header("Cache-Control: must-revalidate");
	header("Content-Type: text/javascript");
	header('Content-Length: '.strlen($sCode));
	header("Content-Disposition: inline; filename=$file");	
	 
	// Output merged code
	echo $sCode;
	
?>