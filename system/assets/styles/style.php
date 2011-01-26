<?php 
	header("Content-type: text/css");
	$totalWidth = $_GET['requestWidth']-16;
	$columnCount = $_GET['columnCount'];
	$columnWidth = ceil($totalWidth/$columnCount+.6);
?>
/* <style type="text/css"> */ /* Allows Syntax Highlighting in Code Editor */

@import url(reset.css);

@media print {
	* { overflow: visible !important }
	
	table thead tr th#name h1 a {
		padding-left: 10px !important;
	}
	
	span.arrow:before {
		content: '';
		display: inline;
		float: left;
		height: 0 !important;
		width: 0 !important;
		margin: 0 !important;
		border-left: 6px solid #767676;
		border-top: 3px solid transparent;
		border-bottom: 3px solid transparent;
	}
	
	.arrow.clicked:before {
		border-top: 6px solid #767676;
		border-left: 3px solid transparent;
		border-right: 3px solid transparent;
	}
	
	span.icon {
		width: 0 !important;
		height: 0 !important;
		margin: 0 !important;
	}
}

html {
	height: 100%;
}

html:before {
	display: block;
	content: '';
	width: 100%;
	height: 15px;
	float: right;
	position: absolute;
	top: 0;
	background: -webkit-gradient(
	    linear,
	    left bottom,
	    left top,
	    color-stop(0, rgb(255,255,255)),
	    color-stop(0.5, rgb(232,232,232)),
	    color-stop(1, rgb(255,255,255))
	);
	background: -moz-linear-gradient(
	    center bottom,
	    rgb(255,255,255) 0%,
	    rgb(232,232,232) 50%,
	    rgb(255,255,255) 100%
	);
	border-bottom: 1px solid #c0c0c0;
}

	body{
		overflow-x: auto;
		overflow-y: hidden;
		height: 100%;
		background: url(../images/column.gif) center 16px repeat;
	}
		
		#wrapper {
			width: 100%;
			height: 100%;
			width: <?php echo $totalWidth; ?>px;
		}
	
			table{
				border-collapse: collapse;
				height: 100%;
			}
				
				table thead tr {
					position: relative;
					display: block;
				}
				
					table thead tr th {
						width: <?php echo $columnWidth; ?>px;
						background: -webkit-gradient(
						    linear,
						    left bottom,
						    left top,
						    color-stop(0, rgb(255,255,255)),
						    color-stop(0.5, rgb(232,232,232)),
						    color-stop(1, rgb(255,255,255))
						);
						background: -moz-linear-gradient(
						    center bottom,
						    rgb(255,255,255) 0%,
						    rgb(232,232,232) 50%,
						    rgb(255,255,255) 100%
						);
						border-bottom: 1px solid #c0c0c0;
						border-right: 1px solid #c0c0c0;
					}
					
					table thead tr th.click {
						background: -webkit-gradient(
						    linear,
						    left bottom,
						    left top,
						    color-stop(0, rgb(241,241,241)),
						    color-stop(0.5, rgb(212,212,212)),
						    color-stop(1, rgb(241,241,241))
						);
						background: -moz-linear-gradient(
						    center bottom,
						    rgb(241,241,241) 0%,
						    rgb(212,212,212) 50%,
						    rgb(241,241,241) 100%
						);
					}
					
					table thead tr th.active {
						background: -webkit-gradient(
					    linear,
						    left bottom,
						    left top,
						    color-stop(0, rgb(187,237,255)),
						    color-stop(0.5, rgb(117,180,239)),
						    color-stop(1, #cbe1f7)
						);
						background: -moz-linear-gradient(
						    center bottom,
						    rgb(203,225,247) 0%,
						    rgb(117,180,239) 50%,
						    rgb(187,237,255) 100%
						);
						border-bottom: 1px solid #90b8e0;
						border-right: 1px solid #6D9CD8;
					}
						
					th.active:before, th.active:after {
						display: block;
						content: 'text';
						width: 10px;
						height: 10px;
						left: 50%;
						display: block;
						width: 0;
						height: 0;
						float: right;
						border-top: 6px solid #767676;
						margin:5px 0 0 0;
						border-left: 3px solid transparent;
						border-right: 3px solid transparent;
						content: '';
					}
					
					th.active.asc:before, th.active.asc:after  {
						border-bottom: 6px solid #767676;
						border-top: none !important;
					}
					
					th.active:before {
						margin-right: 5px;
						border-top: 7px solid rgba(90, 90, 90, .2);
						border-left: 4px solid transparent;
						border-right: 4px solid transparent;
					}
					
					th.active.asc:before {
						margin-right: 5px;
						border-bottom: 7px solid rgba(90, 90, 90, .2) !important;
						border-left: 4px solid transparent;
						border-right: 4px solid transparent;
					}
					
					th.active:after{
						margin: -10px 6px 0 0 ;
					}
					
					th:active {
						background: -webkit-gradient(
						    linear,
						    left bottom,
						    left top,
						    color-stop(0, rgb(241,241,241)),
						    color-stop(0.5, rgb(212,212,212)),
						    color-stop(1, rgb(241,241,241))
						);
						background: -moz-linear-gradient(
						    center bottom,
						    rgb(241,241,241) 0%,
						    rgb(212,212,212) 50%,
						    rgb(241,241,241) 100%
						);
					}
					
					th:last-child{
						width: <?php echo $columnWidth-16; ?>px;
					}
							
						table thead tr th h1 {
							font-family: "Lucida Grande", sans-serif;
							font-size: 11px;
							font-weight: normal;
							text-transform: capitalize;
							line-height: 14px;
							padding: 0 16px 1px;
							cursor: default;
						}
						
							table thead tr th h1 a {
								text-transform: capitalize;
								color: black;
								display: block;
								text-decoration: none;
								cursor: default;
								word-break: none;
							}
						
							table thead tr th#name h1 a {
								padding-left: 33px;
							}
							
							table thead tr th.size h1 a {
								text-align: right;
							}
				
				table tbody {
					background: url(../images/column.gif);
					background-attachment: local;
					width: 100%;
					height: 100%;
					display: block;
					overflow-y: auto;
					overflow-x: hidden;
				}
				
					table tbody tr td {
						width: <?php echo $columnWidth ?>px;
					}
					table tbody tr td:last-child {
						width: <?php echo $columnWidth-16 ?>px;
					}
				
					table tbody tr td ol li {
						font-family: "Lucida Grande", sans-serif;
						font-size: 12px;
						line-height: 18px;
						overflow: hidden;
						cursor: default;
					}
					
						table tbody tr td ol.name ol.child {
							padding-left: 20px;
						}
						
						li.error a{
							color: red;
						}
						
						ol.name li.error {
							padding-left: 2px;
						}
					
						table tbody tr td ol li a {
							white-space: nowrap;
							padding: 1px 16px 0 16px;
							overflow: hidden;
							color: black;
							text-decoration: none;
							cursor: default;
							display: block;
							width: <?php echo $columnWidth-31; ?>px;
						}
						
						table tbody tr td ol.name li a {
							padding-left: 26px;
							padding-right: 16px;
							width: <?php echo $columnWidth-42; ?>px;
						}
						
						table tbody tr td:last-child ol li a {
							width: <?php echo $columnWidth-31-16; ?>px;
						}
						
						table tbody tr td ol.name li a.dir {
							padding-left: 4px;
							width: <?php echo $columnWidth-19; ?>px;
						}
						
						table tbody tr td ol.size li a{
							text-align: right;
						}
						
							table tbody tr td ol li a span.arrow {
								display: inline;
								float: left;
								height: 8px;
								width: 8px;
								background: url(../images/arrow-sprite.png) top left no-repeat;
								margin: 5px 10px 4px 4px;
								font-size: 0;
							}
							
							.arrow:hover, .arrow:focus {
								background-position: 0 -8px;
							}
							
							.arrow.clicked{
								background-position: -8px 0;
							}
							
							.arrow.clicked:hover, .arrow.clicked:focus {
								background-position: -8px -8px !important;
							}

							/*----------------------------------------
							# 
							# FileExtension Icons
							# 
							----------------------------------------*/
							span.icon {
								width: 16px;
								height: 16px;
								margin-right: 7px;
								display: block;
								float: left;
								background: url(../images/page_white.png);
							}
							
							span.icon.folder {
								background: url(../images/folder.png);
							}
							
							span.icon.css {
								background: url(../images/css.png);
							}
							
							span.icon.html {
								background: url(../images/html.png);
							}
							
							span.icon.js {
								background: url(../images/script.png);
							}
							
							span.icon.php {
								background: url(../images/page_white_php.png);
							}
							
							span.icon.txt {
								background: url(../images/page_white_text.png);
							}
							
							span.icon.swf {
								background: url(../images/page_white_flash.png);
							}
							
							span.icon.jpg, span.icon.jpeg, span.icon.png, span.icon.gif, span.icon.ico {
								background: url(../images/picture.png);
							}
							
							span.icon.mp3, span.icon.m4a {
								background: url(../images/music.png);
							}