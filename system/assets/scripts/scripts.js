$(document).ready(function(){
	/* Keep Scrollbar on Right */
	$('tbody').width(function(){
		return $(window).width()+$('body').scrollLeft();
	});
	$(window).resize(function() {
		$('tbody').width(function(){
			return $(window).width()+$('body').scrollLeft();
		});
	});
	$(window).scroll(function(){
		$('tbody').width(function(){
			return $(window).width()+$('body').scrollLeft();
		});
	});
	
	/* Disable Text Selection */
	$('body').disableTextSelect();
	
	/* Load Sorting Links Via AJAX */
	$('h1').find('a').live('click',function(ev){
		ev.preventDefault();
		if(undefined===window.openDirectories){
			openDirectories = [$('span.clicked').parent('a').attr('href')];
		}else{
			openDirectories.length = 0;
			$('span.clicked').parent('a').each(function(){
				openDirectories.push($(this).attr('href'));
			});
		}
		$('body').load($(this).attr('href')+' #wrapper', function(){
				$('tbody').width(function(){
					return $(window).width()+$('body').scrollLeft();
				});
			});
	});
	
	/* Arrow Click */
	$('span.arrow').arrowClick();
	
});