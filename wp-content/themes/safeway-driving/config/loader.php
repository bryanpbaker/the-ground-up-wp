<?php

$function_path = pathinfo(__FILE__);

// Import all files in '/config'
foreach ( glob($function_path['dirname'] . '/*.php') as $file) {
	if ( basename($file) !== 'loader.php' ) {
		include $file;
	}
}

// Import all files one directory deep in '/config'
foreach ( glob($function_path['dirname'] . '/**/*.php') as $file) {
	if ( basename($file) !== 'loader.php' ) {
		include $file;
	}
}

?>
