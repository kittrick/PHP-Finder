/**
 * .disableTextSelect - Disable Text Select Plugin
 *
 * Version: 1.1
 * Updated: 2007-11-28
 *
 * Used to stop users from selecting text
 *
 * Copyright (c) 2007 James Dempster (letssurf@gmail.com, http://www.jdempster.com/category/jquery/disabletextselect/)
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 **/

/**
 * Requirements:
 * - jQuery (John Resig, http://www.jquery.com/)
 **/
(function($) {
    if ($.browser.mozilla) {
        $.fn.disableTextSelect = function() {
            return this.each(function() {
                $(this).css({
                    'MozUserSelect' : 'none'
                });
            });
        };
        $.fn.enableTextSelect = function() {
            return this.each(function() {
                $(this).css({
                    'MozUserSelect' : ''
                });
            });
        };
    } else if ($.browser.msie) {
        $.fn.disableTextSelect = function() {
            return this.each(function() {
                $(this).bind('selectstart.disableTextSelect', function() {
                    return false;
                });
            });
        };
        $.fn.enableTextSelect = function() {
            return this.each(function() {
                $(this).unbind('selectstart.disableTextSelect');
            });
        };
    } else {
        $.fn.disableTextSelect = function() {
            return this.each(function() {
                $(this).bind('mousedown.disableTextSelect', function() {
                    return false;
                });
            });
        };
        $.fn.enableTextSelect = function() {
            return this.each(function() {
                $(this).unbind('mousedown.disableTextSelect');
            });
        };
    }
})(jQuery);

/* ArrowCLick */
(function( $ ){
	$.fn.arrowClick = function( active ) {
		this.live('click',function(ev){
			ev.preventDefault();
			li = $(this).parent().parent();
			current = 0;
			i = 0;
			$('ol.name li').each(function(){
				if($(this).html() === $(li).html()){
					current = i++;
				}else{
					i++;
				}
			});
			if($(this).parent().parent().find('ol.child').is(':visible')){
				$(this).removeClass('clicked');
				$(this).parent().parent().find('ol.child').remove();
				$('ol').not('.child').each(function(){
					li = $(this).find('li');
					$(li[current]).find('ol.child').remove();
				});
			}else{
				$(this).addClass('clicked');
				href = $(this).parent().attr('href');
				sort = $('th.active').attr('id');
				$('td>ol').each(function(){
					li = $(this).find('li');
					column = $(this).attr('class');
					ol = $('<ol/>').addClass('child');
					$(ol).load(href+'&sort='+sort+' ol.'+column+' li',function(response, status, xhr) {
						if (status == "error") {
							description = 'Directory either did not exists or created an error. (May contain an .htaccess file)';
							error = $('<li/>')
								.addClass('error')
								.html('<a title="'+description+'">'+xhr.statusText+'</a>');
							$(this).append(error);
						}
					});
					$(li[current]).append(ol);
				});
			}	
		});
	};
})( jQuery );

/* Program */
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