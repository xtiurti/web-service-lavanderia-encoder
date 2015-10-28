/*
 * jQuery Cryptography Plug-in
 * version: 1.0.0 (24 Sep 2008)
 * copyright 2008 Scott Thompson http://www.itsyndicate.ca - scott@itsyndicate.ca
 * http://www.opensource.org/licenses/mit-license.php
 *
 * A set of functions to do some basic cryptography encoding/decoding
 * I compiled from some javascripts I found into a jQuery plug-in.
 * Thanks go out to the original authors.
 *
 * Also a big thanks to Wade W. Hedgren http://homepages.uc.edu/~hedgreww
 * for the 1.1.1 upgrade to conform correctly to RFC4648 Sec5 url save base64
 *
 * Changelog: 1.1.0
 * - rewrote plugin to use only one item in the namespace
 *
 * Changelog: 1.1.1
 * - added code to base64 to allow URL and Filename Safe Alphabet (RFC4648 Sec5) 
 *
 * --- Base64 Encoding and Decoding code was written by
 *
 * Base64 code from Tyler Akins -- http://rumkin.com
 * and is placed in the public domain
 *
 *
 * --- MD5 and SHA1 Functions based upon Paul Johnston's javascript libraries.
 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
 * Digest Algorithm, as defined in RFC 1321.
 * Version 2.1 Copyright (C) Paul Johnston 1999 - 2002.
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License
 * See http://pajhome.org.uk/crypt/md5 for more info.
 *
 * xTea Encrypt and Decrypt
 * copyright 2000-2005 Chris Veness
 * http://www.movable-type.co.uk
 *
 *
 * Examples:
 *
 var md5 = $().crypt({method:"md5",source:$("#phrase").val()});
 var sha1 = $().crypt({method:"sha1",source:$("#phrase").val()});
 var b64 = $().crypt({method:"b64enc",source:$("#phrase").val()});
 var b64dec = $().crypt({method:"b64dec",source:b64});
 var xtea = $().crypt({method:"xteaenc",source:$("#phrase").val(),keyPass:$("#passPhrase").val()});
 var xteadec = $().crypt({method:"xteadec",source:xtea,keyPass:$("#passPhrase").val()});
 var xteab64 = $().crypt({method:"xteab64enc",source:$("#phrase").val(),keyPass:$("#passPhrase").val()});
 var xteab64dec = $().crypt({method:"xteab64dec",source:xteab64,keyPass:$("#passPhrase").val()});
 
 You can also pass source this way.
 var md5 = $("#idOfSource").crypt({method:"md5"});
 *
 */
!function(r){r.fn.crypt=function(e){function t(r){var e,t,n,c,o,u,a,f="",h=0;do e=r.source.charCodeAt(h++),t=r.source.charCodeAt(h++),n=r.source.charCodeAt(h++),c=e>>2,o=(3&e)<<4|t>>4,u=(15&t)<<2|n>>6,a=63&n,isNaN(t)?u=a=64:isNaN(n)&&(a=64),f+=r.b64Str.charAt(c)+r.b64Str.charAt(o)+r.b64Str.charAt(u)+r.b64Str.charAt(a);while(h<r.source.length);return f}function n(r){var e,t,n,c,o,u,a,f="",h=0,i=new RegExp("[^A-Za-z0-9"+r.b64Str.substr(-3)+"]","g");r.source=r.source.replace(i,"");do c=r.b64Str.indexOf(r.source.charAt(h++)),o=r.b64Str.indexOf(r.source.charAt(h++)),u=r.b64Str.indexOf(r.source.charAt(h++)),a=r.b64Str.indexOf(r.source.charAt(h++)),e=c<<2|o>>4,t=(15&o)<<4|u>>2,n=(3&u)<<6|a,f+=String.fromCharCode(e),64!=u&&(f+=String.fromCharCode(t)),64!=a&&(f+=String.fromCharCode(n));while(h<r.source.length);return f}function c(r){function e(e){for(var t=r.hexcase?"0123456789ABCDEF":"0123456789abcdef",n="",c=0;c<4*e.length;c++)n+=t.charAt(e[c>>2]>>c%4*8+4&15)+t.charAt(e[c>>2]>>c%4*8&15);return n}function t(e){for(var t=Array(),n=(1<<r.chrsz)-1,c=0;c<e.length*r.chrsz;c+=r.chrsz)t[c>>5]|=(e.charCodeAt(c/r.chrsz)&n)<<c%32;return t}function n(r,e){return r<<e|r>>>32-e}function c(r,e,t,c,u,a){return o(n(o(o(e,r),o(c,a)),u),t)}function u(r,e,t,n,o,u,a){return c(e&t|~e&n,r,e,o,u,a)}function a(r,e,t,n,o,u,a){return c(e&n|t&~n,r,e,o,u,a)}function f(r,e,t,n,o,u,a){return c(e^t^n,r,e,o,u,a)}function h(r,e,t,n,o,u,a){return c(t^(e|~n),r,e,o,u,a)}function i(r,e){r[e>>5]|=128<<e%32,r[(e+64>>>9<<4)+14]=e;for(var t=1732584193,n=-271733879,c=-1732584194,i=271733878,s=0;s<r.length;s+=16){var d=t,l=n,A=c,v=i;t=u(t,n,c,i,r[s+0],7,-680876936),i=u(i,t,n,c,r[s+1],12,-389564586),c=u(c,i,t,n,r[s+2],17,606105819),n=u(n,c,i,t,r[s+3],22,-1044525330),t=u(t,n,c,i,r[s+4],7,-176418897),i=u(i,t,n,c,r[s+5],12,1200080426),c=u(c,i,t,n,r[s+6],17,-1473231341),n=u(n,c,i,t,r[s+7],22,-45705983),t=u(t,n,c,i,r[s+8],7,1770035416),i=u(i,t,n,c,r[s+9],12,-1958414417),c=u(c,i,t,n,r[s+10],17,-42063),n=u(n,c,i,t,r[s+11],22,-1990404162),t=u(t,n,c,i,r[s+12],7,1804603682),i=u(i,t,n,c,r[s+13],12,-40341101),c=u(c,i,t,n,r[s+14],17,-1502002290),n=u(n,c,i,t,r[s+15],22,1236535329),t=a(t,n,c,i,r[s+1],5,-165796510),i=a(i,t,n,c,r[s+6],9,-1069501632),c=a(c,i,t,n,r[s+11],14,643717713),n=a(n,c,i,t,r[s+0],20,-373897302),t=a(t,n,c,i,r[s+5],5,-701558691),i=a(i,t,n,c,r[s+10],9,38016083),c=a(c,i,t,n,r[s+15],14,-660478335),n=a(n,c,i,t,r[s+4],20,-405537848),t=a(t,n,c,i,r[s+9],5,568446438),i=a(i,t,n,c,r[s+14],9,-1019803690),c=a(c,i,t,n,r[s+3],14,-187363961),n=a(n,c,i,t,r[s+8],20,1163531501),t=a(t,n,c,i,r[s+13],5,-1444681467),i=a(i,t,n,c,r[s+2],9,-51403784),c=a(c,i,t,n,r[s+7],14,1735328473),n=a(n,c,i,t,r[s+12],20,-1926607734),t=f(t,n,c,i,r[s+5],4,-378558),i=f(i,t,n,c,r[s+8],11,-2022574463),c=f(c,i,t,n,r[s+11],16,1839030562),n=f(n,c,i,t,r[s+14],23,-35309556),t=f(t,n,c,i,r[s+1],4,-1530992060),i=f(i,t,n,c,r[s+4],11,1272893353),c=f(c,i,t,n,r[s+7],16,-155497632),n=f(n,c,i,t,r[s+10],23,-1094730640),t=f(t,n,c,i,r[s+13],4,681279174),i=f(i,t,n,c,r[s+0],11,-358537222),c=f(c,i,t,n,r[s+3],16,-722521979),n=f(n,c,i,t,r[s+6],23,76029189),t=f(t,n,c,i,r[s+9],4,-640364487),i=f(i,t,n,c,r[s+12],11,-421815835),c=f(c,i,t,n,r[s+15],16,530742520),n=f(n,c,i,t,r[s+2],23,-995338651),t=h(t,n,c,i,r[s+0],6,-198630844),i=h(i,t,n,c,r[s+7],10,1126891415),c=h(c,i,t,n,r[s+14],15,-1416354905),n=h(n,c,i,t,r[s+5],21,-57434055),t=h(t,n,c,i,r[s+12],6,1700485571),i=h(i,t,n,c,r[s+3],10,-1894986606),c=h(c,i,t,n,r[s+10],15,-1051523),n=h(n,c,i,t,r[s+1],21,-2054922799),t=h(t,n,c,i,r[s+8],6,1873313359),i=h(i,t,n,c,r[s+15],10,-30611744),c=h(c,i,t,n,r[s+6],15,-1560198380),n=h(n,c,i,t,r[s+13],21,1309151649),t=h(t,n,c,i,r[s+4],6,-145523070),i=h(i,t,n,c,r[s+11],10,-1120210379),c=h(c,i,t,n,r[s+2],15,718787259),n=h(n,c,i,t,r[s+9],21,-343485551),t=o(t,d),n=o(n,l),c=o(c,A),i=o(i,v)}return Array(t,n,c,i)}return e(i(t(r.source),r.source.length*r.chrsz))}function o(r,e){var t=(65535&r)+(65535&e),n=(r>>16)+(e>>16)+(t>>16);return n<<16|65535&t}function u(r){function e(r,e){r[e>>5]|=128<<24-e%32,r[(e+64>>9<<4)+15]=e;for(var u=Array(80),a=1732584193,f=-271733879,h=-1732584194,i=271733878,s=-1009589776,d=0;d<r.length;d+=16){for(var l=a,A=f,v=h,g=i,b=s,m=0;80>m;m++){u[m]=16>m?r[d+m]:t(u[m-3]^u[m-8]^u[m-14]^u[m-16],1);var x=o(o(t(a,5),c(m,f,h,i)),o(o(s,u[m]),n(m)));s=i,i=h,h=t(f,30),f=a,a=x}a=o(a,l),f=o(f,A),h=o(h,v),i=o(i,g),s=o(s,b)}return Array(a,f,h,i,s)}function t(r,e){return r<<e|r>>>32-e}function n(r){return 20>r?1518500249:40>r?1859775393:60>r?-1894007588:-899497514}function c(r,e,t,n){return 20>r?e&t|~e&n:40>r?e^t^n:60>r?e&t|e&n|t&n:e^t^n}function u(e){for(var t=r.hexcase?"0123456789ABCDEF":"0123456789abcdef",n="",c=0;c<4*e.length;c++)n+=t.charAt(e[c>>2]>>8*(3-c%4)+4&15)+t.charAt(e[c>>2]>>8*(3-c%4)&15);return n}function a(e){for(var t=Array(),n=(1<<r.chrsz)-1,c=0;c<e.length*r.chrsz;c+=r.chrsz)t[c>>5]|=(e.charCodeAt(c/r.chrsz)&n)<<32-r.chrsz-c%32;return t}return u(e(a(r.source),r.source.length*r.chrsz))}function a(r){function e(r,e){for(var t=r[0],n=r[1],c=2654435769,o=32*c,u=0;u!=o;)t+=(n<<4^n>>>5)+n^u+e[3&u],u+=c,n+=(t<<4^t>>>5)+t^u+e[u>>>11&3];r[0]=t,r[1]=n}var t,n=new Array(2),c=new Array(4),o="";r.source=escape(r.source);for(var t=0;4>t;t++)c[t]=h(r.strKey.slice(4*t,4*(t+1)));for(t=0;t<r.source.length;t+=8)n[0]=h(r.source.slice(t,t+4)),n[1]=h(r.source.slice(t+4,t+8)),e(n,c),o+=i(n[0])+i(n[1]);return s(o)}function f(r){function e(r,e){for(var t=r[0],n=r[1],c=2654435769,o=32*c;0!=o;)n-=(t<<4^t>>>5)+t^o+e[o>>>11&3],o-=c,t-=(n<<4^n>>>5)+n^o+e[3&o];r[0]=t,r[1]=n}for(var t,n=new Array(2),c=new Array(4),o="",t=0;4>t;t++)c[t]=h(r.strKey.slice(4*t,4*(t+1)));for(ciphertext=d(r.source),t=0;t<ciphertext.length;t+=8)n[0]=h(ciphertext.slice(t,t+4)),n[1]=h(ciphertext.slice(t+4,t+8)),e(n,c),o+=i(n[0])+i(n[1]);return o=o.replace(/\0+$/,""),unescape(o)}function h(r){for(var e=0,t=0;4>t;t++)e|=r.charCodeAt(t)<<8*t;return isNaN(e)?0:e}function i(r){var e=String.fromCharCode(255&r,r>>8&255,r>>16&255,r>>24&255);return e}function s(r){return r.replace(/[\0\t\n\v\f\r\xa0'"!]/g,function(r){return"!"+r.charCodeAt(0)+"!"})}function d(r){return r.replace(/!\d\d?\d?!/g,function(r){return String.fromCharCode(r.slice(1,-1))})}var l={b64Str:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",strKey:"123",method:"md5",source:"",chrsz:8,hexcase:0};"undefined"==typeof e.urlsafe?(l.b64Str+="+/=",e.urlsafe=!1):l.b64Str+=e.urlsafe?"-_=":"+/=";var A=r.extend(l,e);if(!A.source){var v=r(this);if(v.html())A.source=v.html();else{if(!v.val())return alert("Please provide source text"),!1;A.source=v.val()}}if("md5"==A.method)return c(A);if("sha1"==A.method)return u(A);if("b64enc"==A.method)return t(A);if("b64dec"==A.method)return n(A);if("xteaenc"==A.method)return a(A);if("xteadec"==A.method)return f(A);if("xteab64enc"==A.method){var g=a(A);return A.method="b64enc",A.source=g,t(A)}if("xteab64dec"==A.method){var b=n(A);return A.method="xteadec",A.source=b,f(A)}}}(jQuery);