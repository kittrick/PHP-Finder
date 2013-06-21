<?php

	// CLASSES
	/////////////////////////
	
	require_once('library.php');
	
	/* File Sorting */
	class Files{
	
		/* Array of File Objects : Integrated Sorting */
		function directoryObject($directory, $sort = 'name', $asc = true, $hidden = false){
			$this->sortBy = $sort;
			$this->asc = $asc;
			$this->files = scandir($directory);
			foreach($this->files as $file){
				$tempfile = $this->fileObject($file, $directory);
				if($hidden == false && $tempfile->hidden != true){
					$this->fileArray[] = $tempfile;
				}elseif($hidden == true){
					$this->fileArray[] = $tempfile;
				}
			}
			
			/* File Sorting */
			foreach($this->fileArray as $key => $val){
				$sortArray[] = $val->$sort;
			}
			sort($sortArray);
			foreach($sortArray as $key){
				foreach($this->fileArray as $file => $val){
					if($key == $val->$sort){
						$newArray[] = $val;
						unset($this->fileArray[$file]);
					}
				}
			}
			$directoryArray = $newArray;
			if($asc == false){
				$directoryArray = array_reverse($directoryArray);
			}
			$this->fileArray = $directoryArray;
			return $this;
		}
		
		/* Creates File Info Object */
		function fileObject($file, $parent, $calculateFolders = false){
			/* Hidden Files */
			$exceptionArray = array(
				"Icon\r" /* OSX's Icon Alias Files */
			);
			$fileObject->absolutePath = './'.$parent.'/'.$file;
			$fileObject->name = $file;
			$fileObject->href = $file;
			$fileObject->directoryArray = explode('/',$fileObject->absolutePath);
			$fileObject->created = filectime($fileObject->absolutePath);
			$fileObject->modified = filemtime($fileObject->absolutePath);
			$fileObject->type = filetype($fileObject->absolutePath);
			
			if($fileObject->type == 'dir'){
				$fileObject->kind = 'Folder';
			}else{
				$fileObject->extension = end(explode('.',$fileObject->name));
				$fileObject->kind = strtoupper($fileObject->extension).' File';
			}
			
			if($fileObject->type == 'dir' && $calculateFolders == false){
				$fileObject->size = '--';
			}else{
				$fileObject->size = filesize($fileObject->absolutePath);
			}
			$fileObject->mime = mime_content_type($fileObject->absolutePath);
			
			if(substr($fileObject->name,0,1) == '.'){
				$fileObject->hidden = true;
			}elseif(in_array($fileObject->name,$exceptionArray)){
				$fileObject->hidden = true;
			}else{
				$fileObject->hidden = false;
			}
			return $fileObject;
		}
				
		/* Directories Before Files */
		function filesFirst($directoryObject, $first = true){
			if($first == true){
				$newArray = array();
				foreach($directoryObject->fileArray as $key => $val){
					if($val->type == 'dir'){
						$newArray[] = $val;
						unset($directoryObject->fileArray[$key]);
					}
				}
				foreach($directoryObject->fileArray as $key => $val){
					if($val->type != 'dir'){
						$newArray[] = $val;
					}
				}
				$directoryObject->fileArray = $newArray;
				return $directoryObject;
			}else{
				$newArray = array();
				foreach($directoryObject->fileArray as $key => $val){
					if($val->type != 'dir'){
						$newArray[] = $val;
						unset($directoryObject->fileArray[$key]);
					}
				}
				foreach($directoryObject->fileArray as $key => $val){
					if($val->type == 'dir'){
						$newArray[] = $val;
					}
				}
				$directoryObject->fileArray = $newArray;
				return $directoryObject;
			}
		}
		
		/* Format Links */
		function formatLinks($ajax){
			foreach($this->fileArray as $key => $val){
				$href = $this->fileArray[$key]->href;
				$this->fileArray[$key]->href = $ajax.'/'.$href;
			}
			return $this;
		}
		
		/* Format File Dates */
		function formatFileDates($formatArray = array('created'=>'M j, Y g:i A','modified'=>'M j, Y g:i A')){
			if(isset($this->columnWidth) && $this->columnWidth >= 300){
				$formatArray = array('created'=>'l, F j, g:i A','modified'=>'l, F j, g:i A');
			}elseif(isset($this->columnWidth) && $this->columnWidth >= 200){
				$formatArray = array('created'=>'F j, g:i A','modified'=>'F j, g:i A');
			}elseif(isset($this->columnWidth) && $this->columnWidth >= 190){
				$formatArray = array('created'=>'M j, Y g:i A','modified'=>'M j, Y g:i A');
			}elseif(isset($this->columnWidth) && $this->columnWidth >= 160){
				$formatArray = array('created'=>'n/j/y g:i A','modified'=>'n/j/y g:i A');
			}elseif(isset($this->columnWidth) && $this->columnWidth >= 150){
				$formatArray = array('created'=>'n/j/y','modified'=>'n/j/y');
			}
			foreach($this->fileArray as $key => $val){
				foreach($formatArray as $category => $sort){
					$this->fileArray[$key]->$category = date($formatArray[$category],$this->fileArray[$key]->$category);
				}
			}
			return $this;
		}
		
		/* Format File Kind */
		function formatFileKind(){
			foreach($this->fileArray as $key => $val){
				if(isset($this->fileArray[$key]->extension)){
					switch($this->fileArray[$key]->extension){
						case 'html':
						$this->fileArray[$key]->kind = 'HTML document';
						break;
						case 'css':
						$this->fileArray[$key]->kind = 'Cascading Style Sheet';
						break;
						case 'js':
						$this->fileArray[$key]->kind = 'JavaScript source';
						break;
						case 'php':
						$this->fileArray[$key]->kind = 'PHP source';
						break;
						case 'swf':
						$this->fileArray[$key]->kind = 'Shockwave Flash Movie';
						break;
						case 'txt':
						$this->fileArray[$key]->kind = 'Plain text document';
						break;
						case 'jpg':
						$this->fileArray[$key]->kind = 'JPEG Image';
						break;
						case 'png':
						$this->fileArray[$key]->kind = 'Portable Network Graphics Image';
						break;
						case 'gif':
						$this->fileArray[$key]->kind = 'Graphics Interchange Format Image';
						break;
						case 'ico':
						$this->fileArray[$key]->kind = 'Windows Icon Image';
						break;
						case 'mp3':
						$this->fileArray[$key]->kind = 'MP3 Audio File';
						case 'm4a':
						$this->fileArray[$key]->kind = 'MPEG Audio File';
						break;
						case 'pdf':
						$this->fileArray[$key]->kind = 'Portable Document Format (PDF)';
						break;
						case 'doc':
						$this->fileArray[$key]->kind = 'Microsoft Word 97 - 2004 Document';
						break;
						case 'zip':
						$this->fileArray[$key]->kind = 'ZIP archive';
						break;
						default :
						$this->fileArray[$key]->kind = strtoupper($this->fileArray[$key]->extension).' File';
						break;
					}
				}
			}
			return $this;
		}
		
		/* Format File Size */
		function formatFileSize($format = 'auto', $precision = 1){
			function sizeFormat($directoryObject,$format,$bytes,$precision){
				foreach($directoryObject->fileArray as $key => $val){
					if($format !== 'auto'){
						if(is_int($directoryObject->fileArray[$key]->size ))
							$directoryObject->fileArray[$key]->size 
							= round(($directoryObject->fileArray[$key]->size/$bytes),$precision).' '.$format;
					}else{
						if(is_int($directoryObject->fileArray[$key]->size) && $directoryObject->fileArray[$key]->size<1000){
							$directoryObject->fileArray[$key]->size = $directoryObject->fileArray[$key]->size.' B';
						}elseif(is_int($directoryObject->fileArray[$key]->size) && $directoryObject->fileArray[$key]->size<1000*1000){
							$directoryObject->fileArray[$key]->size = round(($directoryObject->fileArray[$key]->size/1000),$precision).' KB';
						}elseif(is_int($directoryObject->fileArray[$key]->size) && $directoryObject->fileArray[$key]->size<1000*1000*1000){
							$directoryObject->fileArray[$key]->size
							= round(($directoryObject->fileArray[$key]->size/1000/1000),$precision).' MB';
						}elseif(is_int($directoryObject->fileArray[$key]->size) && $fileArray[$key]->size<1000*1000*1000*1000){
							$directoryObject->fileArray[$key]->size
							= round(($directoryObject->fileArray[$key]->size/1000/1000/1000),$precision).' GB';
						}
					}
				}
			}
			switch($format){
				case 'GB':
					sizeFormat($this,$format,1000/1000/1000,$precision);
					break;
				case 'MB':
					sizeFormat($this,$format,1000/1000,$precision);
					break;
				case 'KB':
					sizeFormat($this,$format,1000,$precision);
					break;
				case 'B':
					sizeFormat($this,$format,1,$precision);
					break;
				default: /* auto */
					sizeFormat($this,$format,null,$precision);
					break;
			}
			return $this;
		}
		
		/* Format File Names */
		function formatFileNames($requestWidth = 800, $sortArray = array('name','created','modified','size','kind')){
			$columnCount = count($sortArray);
			$this->columnWidth = ceil($requestWidth/$columnCount+.6);
			foreach($this->fileArray as $key => $val){
				if($this->columnWidth <= 200){
					foreach($sortArray as $column){
						$fullName = $this->fileArray[$key]->$column;
						$max = floor($this->columnWidth/10);
						if(is_string($this->fileArray[$key]->$column) && strlen($this->fileArray[$key]->$column) > $max){
							$tempname = str_split($this->fileArray[$key]->$column);
							$third = ceil($max/3);
							$first = array();
							$last = array();
							for($i = 0; $i < $third ; $i++){
								$first[] = $tempname[$i];
								$x = (count($tempname)-1)-$i;
								$last[] = $tempname[$x];
							}
							$last = array_reverse($last);
							$this->fileArray[$key]->shortText[$column] = implode($first).'...'.implode($last);
						}
					}
				}
			}
			return $this;
		}
	}
	
	/* Document */
	class Render{
		
		/* Global $document */
		var $document;
		var $table;
		var $div;
		var $h1;
		var $ol;
		
		/* Creates new DOM Object */
		function __construct(){
			global $document;
			$document = DOMImplementation::createDocument(null, 'html',
				DOMImplementation::createDocumentType("html", 
					"-//W3C//DTD XHTML 1.0 Transitional//EN", 
					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"));
		}
		
		/* Parses DOM Objects into New Document */
		function newDocument($array = array(), $styleArray = array(), $scriptArray = array(), $echo = true){
			global $document;
			global $body;
			
			$document->formatOutput = true;
			$html = $document->documentElement;
			$document->appendChild($html);
			$head = $document->createElement('head');
			$html->appendChild($head);
			
			$title = $document->createElement('title');
			$titleText = parse_url($_SERVER['REQUEST_URI']);
			$titleText = explode('/',$titleText['path']);
			array_pop($titleText);
			$titleText = array_pop($titleText);
			if(strlen($titleText) == 0) $titleText = $_SERVER['HTTP_HOST'];
			$title->appendChild($document->createTextNode($titleText));
			$head->appendChild($title);
			
			$link = $document->createElement('link');
			$rel = $document->createAttribute('rel');
			$rel->appendChild($document->createTextNode('icon'));
			$type = $document->createAttribute('type');
			$type->appendChild($document->createTextNode('image/png'));
			$href = $document->createAttribute('href');
			$href->appendChild($document->createTextNode('/assets/images/folder.png'));
			$link->appendChild($rel);
			$link->appendChild($type);
			$link->appendChild($href);
			$head->appendChild($link);
			
			foreach($styleArray as $key){
				$$key = $document->createElement('link');
				$head->appendChild($$key);
				$rel = $document->createAttribute('rel');
				$rel->appendChild($document->createTextNode('stylesheet'));
				$$key->appendchild($rel);
				$type = $document->createAttribute('type');
				$type->appendChild($document->createTextNode('text/css'));
				$$key->appendchild($type);
				$href = $document->createAttribute('href');
				$href->appendChild($document->createTextNode($key));
				$$key->appendchild($href);
			}
			
			foreach($scriptArray as $key){
				$$key = $document->createElement('script');
				$head->appendChild($$key);
				$type = $document->createAttribute('type');
				$type->appendChild($document->createTextNode('text/javascript'));
				$$key->appendChild($type);
				$type = $document->createAttribute('src');
				$type->appendChild($document->createTextNode($key));
				$$key->appendChild($type);
			}
			
			$body = $document->createElement('body');
			$html->appendChild($body);
			foreach($array as $key => $value){
				if($key == 'head'){
					$head->appendChild($value);
				}elseif($key == 'body'){
					$body->appendChild($value);
				}
			}
			if(is_bool($echo) && $echo == true){
				echo $document->saveXml();
				return $document->saveXml();
			}else{
				global $$echo;
				echo $document->saveXml($$echo);
				return $document->saveXml($$echo);
			}
		}
		
		/* Renders XML Table */
		function XMLTable($directoryObject, $sortArray = array('name','created','modified','size','mime','type')){
			global $document;
			global $div;
			global $table;
			
			$div = $document->createElement('div');
			$id = $document->createAttribute('id');
			$id->appendChild($document->createTextNode('wrapper'));
			$div->appendChild($id);
			
			$table = $document->createElement('table');
			$thead = $document->createElement('thead');
			$tbody = $document->createElement('tbody');
			
			$table->appendChild($thead);
			$table->appendChild($tbody);
			
			$headerGroup = $document->createElement('tr');
			$bodyGroup = $document->createElement('tr');
			$thead->appendChild($headerGroup);
			$tbody->appendChild($bodyGroup);
			
			foreach($sortArray as $category){
			
				$th = $document->createElement('th');
				$h1 = $document->createElement('h1');
				
				$id = $document->createAttribute('id');
				$class = $document->createAttribute('class');
				$th->appendChild($id);
				$th->appendChild($class);
				$id->appendChild($document->createTextNode($category));
				
				if($category == $directoryObject->sortBy){
						$class->appendChild($document->createTextNode('active'));
						if($directoryObject->asc != true){
							$asc = '&asc=true';
							$class->appendChild($document->createTextNode(' asc'));
						}else{
							$asc = '&asc=false';
						}
					}else{
						$asc = '&asc=true';
					}
				$href = $document->createAttribute('href');
				$href->appendChild($document->createTextNode('?sort='.$category.$asc));
				$a = $document->createElement('a');
				
				if($category == 'created' || $category == 'modified'){
					$a->appendChild($document->createTextNode('date '));
				}
				$a->appendChild($document->createTextNode($category));
				
				$h1->appendChild($a);
				$a->appendChild($href);
				
				$th->appendChild($h1);
				$headerGroup->appendChild($th);
				
				$td = $document->createElement('td');
				$bodyGroup->appendChild($td);
				
				$ol = $document->createElement('ol');
				$class = $document->createAttribute('class');
				$class->appendChild($document->createTextNode($category));
				$ol->appendChild($class);
				$td->appendChild($ol);
				
				$counter = 0;
				foreach($directoryObject->fileArray as $key){
					$li = $document->createElement('li');
					if($directoryObject->asc){
						$asc = 'true';
					}else{
						$asc = 'false';
					}
					
					$a = $document->createElement('a');
					
					$href = $document->createAttribute('href');
					$link = $document->createTextNode('?ajax='.$key->href);
					$a->appendChild($href);
					$href->appendChild($link);
					
					if($category == 'name'){
						if($key->type == 'file'){
							$span = $document->createElement('span');
							$class = $document->createAttribute('class');
							$class->appendChild($document->createTextNode('icon '.$key->extension));
						}else{
							
							$span = $document->createElement('span');
							$class = $document->createAttribute('class');
							$class->appendChild($document->createTextNode('arrow'));
							$span->appendChild($class);
							$a->appendChild($span);
							
							$span = $document->createElement('span');
							$class = $document->createAttribute('class');
							$class->appendChild($document->createTextNode('icon folder'));
						}
						$span->appendChild($class);	
						$a->appendChild($span);
					}
					
					if(isset($key->shortText[$category])){
						$title = $document->createAttribute('title');
						$title->appendChild($document->createTextNode($key->$category));
						$a->appendChild($title);
						$a->appendChild($document->createTextNode($key->shortText[$category]));
					}else{
						$a->appendChild($document->createTextNode($key->$category));
					}
					$li->appendChild($a);
					$ol->appendChild($li);
					if($key->type == 'dir'){
						$class = $document->createAttribute('class');
						$class->appendChild($document->createTextNode('dir'));
						$a->appendChild($class);
					}
					if($counter&1){
						$class = $document->createAttribute('class');
						$class->appendChild($document->createTextNode('even'));
						$li->appendChild($class);
					}
					$counter++;
				}
			}
			
			$div->appendChild($table);
			return $div;
		}
	}