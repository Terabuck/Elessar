/*
 * jQuery XDomainRequest Transport Plugin 1.1.2
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2011, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 *
 * Based on Julian Aubourg's ajaxHooks xdr.js:
 * https://github.com/jaubourg/ajaxHooks/
 */

/*jslint unparam: true */
/*global define, window, XDomainRequest */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery"],t):t(window.jQuery)}((function(t){"use strict";window.XDomainRequest&&!t.support.cors&&t.ajaxTransport((function(o){var e;if(o.crossDomain&&o.async)return o.timeout&&(o.xdrTimeout=o.timeout,delete o.timeout),{send:function(n,u){function r(o,n,r,i){e.onload=e.onerror=e.ontimeout=t.noop,e=null,u(o,n,r,i)}e=new XDomainRequest,"DELETE"===o.type?(o.url=o.url+(/\?/.test(o.url)?"&":"?")+"_method=DELETE",o.type="POST"):"PUT"===o.type&&(o.url=o.url+(/\?/.test(o.url)?"&":"?")+"_method=PUT",o.type="POST"),e.open(o.type,o.url),e.onload=function(){r(200,"OK",{text:e.responseText},"Content-Type: "+e.contentType)},e.onerror=function(){r(404,"Not Found")},o.xdrTimeout&&(e.ontimeout=function(){r(0,"timeout")},e.timeout=o.xdrTimeout),e.send(o.hasContent&&o.data||null)},abort:function(){e&&(e.onerror=t.noop(),e.abort())}}}))}));