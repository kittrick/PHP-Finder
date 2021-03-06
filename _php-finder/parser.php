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
	if(strstr($request['ajax'],'..')) die('CANNOT NAVIGATE ABOVE FILE ROOT'); // Verrry basic security measure
	($request['ajax'] == true) ? $ajax = $request['ajax'] : $ajax = './';
	$files = $file->directoryObject($ajax,$request['sort'],$request['asc']);
	
	/* Format File Names, Dates, Links, etc. */
	$file->formatLinks($ajax);
	$file
		->formatFileSize()
		->formatFileKind()
		->formatFileNames($request['width'],$request['sortArray'])
		->formatFileDates();
	
	/* Render Document */
	$doc->newDocument(
		array('body'=> $doc->XMLTable($files,$request['sortArray'])),
		array(
			'_php-finder/assets/styles/style.css'),
		array(
			'_php-finder/assets/scripts/jQuery-1.4.4.js',
			'_php-finder/assets/scripts/scripts.js')
	);