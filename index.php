<?php
	
	// LOADER
	/////////////////////////
	
	/* Error Reporting */
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
	
	/* Library Location, no trailing Slash */
	define('LIBRARY_LOCATION','system');
	
	/* Load and Away we Go! */
	require_once(LIBRARY_LOCATION.'/classes.php');
	require_once(LIBRARY_LOCATION.'/parser.php');