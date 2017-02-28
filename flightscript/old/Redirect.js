//
// "delay" is delay of redirect in milliseconds.
// "toURL" is the URL to redirect to.
// If "toURL" is empty, then refresh to same page.
//
function delayedRedirect(delay, toUrl) {
	if (toUrl == "") {
		toUrl = unescape(window.location.pathname);
	}
	
	setTimeout( "redirect('" + toUrl + "')", delay );
}

function redirect(sURL) {
	//  This version does NOT cause an entry in the browser's
	//  page view history.  Most browsers will always retrieve
	//  the document from the web-server whether it is already
	//  in the browsers page-cache or not.
	//  
	window.location.replace( sURL );
}

