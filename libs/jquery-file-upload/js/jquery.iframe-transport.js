/*
 * jQuery Iframe Transport Plugin 1.4
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2011, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint unparam: true, nomen: true */
/*global define, window, document */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):e(window.jQuery)}((function(e){"use strict";var a=0;e.ajaxTransport("iframe",(function(n){var t,r;if(n.async&&("POST"===n.type||"GET"===n.type))return{send:function(o,i){t=e('<form style="display:none;"></form>'),r=e('<iframe src="javascript:false;" name="iframe-transport-'+(a+=1)+'"></iframe>').bind("load",(function(){var a,o=e.isArray(n.paramName)?n.paramName:[n.paramName];r.unbind("load").bind("load",(function(){var a;try{if(!(a=r.contents()).length||!a[0].firstChild)throw new Error}catch(e){a=void 0}i(200,"success",{iframe:a}),e('<iframe src="javascript:false;"></iframe>').appendTo(t),t.remove()})),t.prop("target",r.prop("name")).prop("action",n.url).prop("method",n.type),n.formData&&e.each(n.formData,(function(a,n){e('<input type="hidden"/>').prop("name",n.name).val(n.value).appendTo(t)})),n.fileInput&&n.fileInput.length&&"POST"===n.type&&(a=n.fileInput.clone(),n.fileInput.after((function(e){return a[e]})),n.paramName&&n.fileInput.each((function(a){e(this).prop("name",o[a]||n.paramName)})),t.append(n.fileInput).prop("enctype","multipart/form-data").prop("encoding","multipart/form-data")),t.submit(),a&&a.length&&n.fileInput.each((function(n,t){var r=e(a[n]);e(t).prop("name",r.prop("name")),r.replaceWith(t)}))})),t.append(r).appendTo(document.body)},abort:function(){r&&r.unbind("load").prop("src","javascript".concat(":false;")),t&&t.remove()}}})),e.ajaxSetup({converters:{"iframe text":function(a){return e(a[0].body).text()},"iframe json":function(a){return e.parseJSON(e(a[0].body).text())},"iframe html":function(a){return e(a[0].body).html()},"iframe script":function(a){return e.globalEval(e(a[0].body).text())}}})}));