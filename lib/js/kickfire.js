/* Kickfire */
function vs_readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

var DID=205132;

var identity = vs_readCookie( 'identity' );
if( typeof identity != 'undefined' && null != identity && '' != identity ){
  var MyID = identity;
}
document.writeln('<scr'+'ipt src="//stats.sa-as.com/live.js" type="text\/javascript"><\/scr'+'ipt>');