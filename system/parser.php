<?php
	
	// PARSER
	/////////////////////////
	
	/* Defaults */
	$request = array(
		'ajax' => false,
		'width' => 800,
		'sortArray' => array('name','created','modified','size','kind'),
		'sort' => 'name',
		'asc' => false
	);
	
	/* Replace Defaults with $_GET */
	$url = parse_url($_SERVER['REQUEST_URI']);
	if(isset($url['query'])) parse_str($url['query'],$url);
	foreach($url as $key => $val){
		$request[$key] = $val;
	}
	
	/* Turn Strings into Bools */
	($request['asc'] == 'false') ? $request['asc'] = false : $request['asc'] = true;
	
	/* Instantiate Classes */
	$file = new Files;
	$doc = new Render;
	
	/* Create Directory Object */
	($request['ajax'] == true) ? $ajax = $request['ajax'] : $ajax = './';
	$files = $file->directoryObject($ajax,$request['sort'],$request['asc']);
	$columnCount = count($request['sortArray']);
	
	/* Handles AJAX Requests */
	$file->formatLinks($ajax);
	
	/* Format File Names, Dates, Links, etc. */
	$file
		->formatFileSize()
		->formatFileKind()
		->formatFileNames($request['width'],$request['sortArray'])
		->formatFileDates();
	
	/* Render Document */
	$doc->newDocument(
		array('body'=> $doc->XMLTable($files,$request['sortArray'])),
		array(
			LIBRARY_LOCATION.'/assets/styles/style.php?requestWidth='.$request['width'].'&columnCount='.$columnCount,
			LIBRARY_LOCATION.'/assets/styles/jquery-ui-1.8.8.custom.css'),
		array(
			LIBRARY_LOCATION.'/assets/scripts/jQuery-1.4.4.js',
			LIBRARY_LOCATION.'/assets/scripts/jquery-ui-1.8.8.custom.min.js',
			LIBRARY_LOCATION.'/assets/scripts/jquery.disable.text.select.js',
			LIBRARY_LOCATION.'/assets/scripts/jquery.arrowclick.js',
			LIBRARY_LOCATION.'/assets/scripts/scripts.js')
	);