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
				ajax = href.split('/');
				ajax = ajax.slice(0,-1);
				dir = ajax;
				ajax = ajax.join('/');
				sort = $('th.active').attr('id');
				$('td>ol').each(function(){
					li = $(this).find('li');
					column = $(this).attr('class');
					ol = $('<ol/>').addClass('child');
					$(ol).load(href+'&ajax='+encodeURIComponent(ajax)+'&sort='+sort+' ol.'+column+' li',function(response, status, xhr) {
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