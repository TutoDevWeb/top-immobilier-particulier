window.onerror = myOnError;

msgArray = new Array();
urlArray = new Array();
lnoArray = new Array();

function myOnError (msg,url,lno) {

  msgArray[msgArray.length] = msg;
  urlArray[urlArray.length] = url;
  lnoArray[lnoArray.length] = lno;

  win2 = window.open('','win2','scrollbars=yes');
	win2.document.writeln('<p><strong>Error report</strong></p>');
	for ( var i = 0 ; i < msgArray.length ; i++ ) {
	
	  win2.document.writeln('<p>Error in file : '+urlArray[i]+'</p>');
	  win2.document.writeln('<p>Line number   : '+lnoArray[i]+'</p>');
	  win2.document.writeln('<p>Message       : '+msgArray[i]+'</p>');
	
	}
	
	return true;

}