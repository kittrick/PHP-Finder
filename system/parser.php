<?php
	
	// PARSER
	/////////////////////////
	
	/* Defaults */
	$request = array(
		'ajax' => false,
		'width' => 800,
		'format' => 'XMLTable',
		'sortArray' => array('name','created','modified','size','kind'),
		'sort' => 'name',
		'echo' => 'html',
		'asc' => false
	);
	
	/* Replace Defaults with $_GET */
	$url = parse_url($_SERVER['REQUEST_URI']);
	if(isset($url['query'])) parse_str($url['query'],$url);
	foreach($url as $key => $val){
		$request[$key] = $val;
	}
	$urlArray = explode('/',$_SERVER['REQUEST_URI']);
	array_pop($urlArray);
	$urlString = implode('/',$urlArray);
	define('BROWSE',$_SERVER['DOCUMENT_ROOT'].$urlString.'/');
	$count = substr_count($urlString,'/');
	$ladder = '';
	for ($i = 0; $i <= $count; $i++) {
    	$ladder .= '../';
	}
	define('LADDER',$ladder);
	
	/* Turn Strings into Bools */
	($request['asc'] == 'false') ? $request['asc'] = false : $request['asc'] = true;
	
	/* Instantiate Classes */
	$file = new Files;
	$doc = new Render;
	
	/* Create Directory Object */
	$files = $file->directoryObject(BROWSE,$request['sort'],$request['asc']);
	$columnCount = count($request['sortArray']);
	
	/* Handles AJAX Requests */
	if($request['ajax'] == true) $file->formatLinks($request['ajax']);
	
	/* Format File Names, Dates, Links, etc. */
	$file
		->formatFileSize()
		->formatFileKind()
		->formatFileNames($request['width'],$request['sortArray'])
		->formatFileDates();
	
	/* Render Document */
	$doc->newDocument(
		array('body'=> $doc->$request['format']($files,$request['sortArray'])),
		$request['echo'],
		array(
			LADDER.LIBRARY_LOCATION.'/assets/styles/style.php?requestWidth='.$request['width'].'&columnCount='.$columnCount,
			LADDER.LIBRARY_LOCATION.'/assets/styles/jquery-ui-1.8.8.custom.css'),
		array(
			LADDER.LIBRARY_LOCATION.'/assets/scripts/jQuery-1.4.4.js',
			LADDER.LIBRARY_LOCATION.'/assets/scripts/jquery-ui-1.8.8.custom.min.js',
			LADDER.LIBRARY_LOCATION.'/assets/scripts/jquery.disable.text.select.js',
			LADDER.LIBRARY_LOCATION.'/assets/scripts/jquery.arrowclick.js',
			LADDER.LIBRARY_LOCATION.'/assets/scripts/scripts.js')
	);