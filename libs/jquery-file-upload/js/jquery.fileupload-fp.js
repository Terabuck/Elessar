/*
 * jQuery File Upload File Processing Plugin 1.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2012, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, unparam: true, regexp: true */
/*global define, window, document */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","load-image","canvas-to-blob","./jquery.fileupload"],e):e(window.jQuery,window.loadImage)}((function(e,s){"use strict";e.widget("blueimpFP.fileupload",e.blueimp.fileupload,{options:{process:[],add:function(s,i){e(this).fileupload("process",i).done((function(){i.submit()}))}},processActions:{load:function(i,n){var t=this,o=i.files[i.index],r=e.Deferred();return window.HTMLCanvasElement&&window.HTMLCanvasElement.prototype.toBlob&&("number"!==e.type(n.maxFileSize)||o.size<n.maxFileSize)&&(!n.fileTypes||n.fileTypes.test(o.type))?s(o,(function(e){i.canvas=e,r.resolveWith(t,[i])}),{canvas:!0}):r.rejectWith(t,[i]),r.promise()},resize:function(e,i){if(e.canvas){var n=s.scale(e.canvas,i);n.width===e.canvas.width&&n.height===e.canvas.height||(e.canvas=n,e.processed=!0)}return e},save:function(s,i){if(!s.canvas||!s.processed)return s;var n=this,t=s.files[s.index],o=t.name,r=e.Deferred(),a=function(e){e.name||(t.type===e.type?e.name=t.name:t.name&&(e.name=t.name.replace(/\..+$/,"."+e.type.substr(6)))),s.files[s.index]=e,r.resolveWith(n,[s])};return s.canvas.mozGetAsFile?a(s.canvas.mozGetAsFile(/^image\/(jpeg|png)$/.test(t.type)&&o||(o&&o.replace(/\..+$/,"")||"blob")+".png",t.type)):s.canvas.toBlob(a,t.type),r.promise()}},_processFile:function(s,i,n){var t=this,o=e.Deferred().resolveWith(t,[{files:s,index:i}]).promise();return t._processing+=1,e.each(n.process,(function(e,s){o=o.pipe((function(e){return t.processActions[s.action].call(this,e,s)}))})),o.always((function(){t._processing-=1,0===t._processing&&t.element.removeClass("fileupload-processing")})),1===t._processing&&t.element.addClass("fileupload-processing"),o},process:function(s){var i=this,n=e.extend({},this.options,s);return n.process&&n.process.length&&this._isXHRUpload(n)&&e.each(s.files,(function(t,o){i._processingQueue=i._processingQueue.pipe((function(){var o=e.Deferred();return i._processFile(s.files,t,n).always((function(){o.resolveWith(i)})),o.promise()}))})),this._processingQueue},_create:function(){e.blueimp.fileupload.prototype._create.call(this),this._processing=0,this._processingQueue=e.Deferred().resolveWith(this).promise()}})}));