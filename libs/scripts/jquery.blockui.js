/*!
 * jQuery blockUI plugin
 * Version 2.39 (23-MAY-2011)
 * @requires jQuery v1.2.3 or later
 *
 * Examples at: http://malsup.com/jquery/block/
 * Copyright (c) 2007-2010 M. Alsup
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Thanks to Amir-Hossein Sobhi for some excellent contributions!
 */
!function(e){if(/1\.(0|1|2)\.(0|1|2)/.test(e.fn.jquery)||/^1.1/.test(e.fn.jquery))alert("blockUI requires jQuery v1.2.3 or later!  You are using v"+e.fn.jquery);else{e.fn._fadeIn=e.fn.fadeIn;var o=function(){},t=document.documentMode||0,i=e.browser.msie&&(e.browser.version<8&&!t||t<8),n=e.browser.msie&&/MSIE 6.0/.test(navigator.userAgent)&&!t;e.blockUI=function(e){a(window,e)},e.unblockUI=function(e){d(window,e)},e.growlUI=function(o,t,i,n){var l=e('<div class="growlUI"></div>');o&&l.append("<h1>"+o+"</h1>"),t&&l.append("<h2>"+t+"</h2>"),null==i&&(i=3e3),e.blockUI({message:l,fadeIn:700,fadeOut:1e3,centerY:!1,timeout:i,showOverlay:!1,onUnblock:n,css:e.blockUI.defaults.growlCSS})},e.fn.block=function(o){return this.unblock({fadeOut:0}).each((function(){"static"==e.css(this,"position")&&(this.style.position="relative"),e.browser.msie&&(this.style.zoom=1),a(this,o)}))},e.fn.unblock=function(e){return this.each((function(){d(this,e)}))},e.blockUI.version=2.39,e.blockUI.defaults={message:"<h1>Please wait...</h1>",title:null,draggable:!0,theme:!1,css:{padding:0,margin:0,width:"30%",top:"40%",left:"35%",textAlign:"center",color:"#000",border:"3px solid #aaa",backgroundColor:"#fff",cursor:"wait"},themedCSS:{width:"30%",top:"40%",left:"35%"},overlayCSS:{backgroundColor:"#000",opacity:.6,cursor:"wait"},growlCSS:{width:"350px",top:"10px",left:"",right:"10px",border:"none",padding:"5px",opacity:.6,cursor:"default",color:"#fff",backgroundColor:"#000","-webkit-border-radius":"10px","-moz-border-radius":"10px","border-radius":"10px"},iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank",forceIframe:!1,baseZ:1e3,centerX:!0,centerY:!0,allowBodyStretch:!0,bindEvents:!0,constrainTabKey:!0,fadeIn:200,fadeOut:400,timeout:0,showOverlay:!0,focusInput:!0,applyPlatformOpacityRules:!0,onBlock:null,onUnblock:null,quirksmodeOffsetHack:4,blockMsgClass:"blockMsg"};var l=null,s=[]}function a(t,a){var r=t==window,u=a&&void 0!==a.message?a.message:void 0;(a=e.extend({},e.blockUI.defaults,a||{})).overlayCSS=e.extend({},e.blockUI.defaults.overlayCSS,a.overlayCSS||{});var p=e.extend({},e.blockUI.defaults.css,a.css||{}),h=e.extend({},e.blockUI.defaults.themedCSS,a.themedCSS||{});if(u=void 0===u?a.message:u,r&&l&&d(window,{fadeOut:0}),u&&"string"!=typeof u&&(u.parentNode||u.jquery)){var m=u.jquery?u[0]:u,y={};e(t).data("blockUI.history",y),y.el=m,y.parent=m.parentNode,y.display=m.style.display,y.position=m.style.position,y.parent&&y.parent.removeChild(m)}e(t).data("blockUI.onUnblock",a.onUnblock);var k,g,v=a.baseZ,w=e.browser.msie||a.forceIframe?e('<iframe class="blockUI" style="z-index:'+v+++';display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0" src="'+a.iframeSrc+'"></iframe>'):e('<div class="blockUI" style="display:none"></div>'),I=a.theme?e('<div class="blockUI blockOverlay ui-widget-overlay" style="z-index:'+v+++';display:none"></div>'):e('<div class="blockUI blockOverlay" style="z-index:'+v+++';display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0"></div>');g=a.theme&&r?'<div class="blockUI '+a.blockMsgClass+' blockPage ui-dialog ui-widget ui-corner-all" style="z-index:'+(v+10)+';display:none;position:fixed"><div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(a.title||"&nbsp;")+'</div><div class="ui-widget-content ui-dialog-content"></div></div>':a.theme?'<div class="blockUI '+a.blockMsgClass+' blockElement ui-dialog ui-widget ui-corner-all" style="z-index:'+(v+10)+';display:none;position:absolute"><div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(a.title||"&nbsp;")+'</div><div class="ui-widget-content ui-dialog-content"></div></div>':r?'<div class="blockUI '+a.blockMsgClass+' blockPage" style="z-index:'+(v+10)+';display:none;position:fixed"></div>':'<div class="blockUI '+a.blockMsgClass+' blockElement" style="z-index:'+(v+10)+';display:none;position:absolute"></div>',k=e(g),u&&(a.theme?(k.css(h),k.addClass("ui-widget-content")):k.css(p)),a.theme||a.applyPlatformOpacityRules&&e.browser.mozilla&&/Linux/.test(navigator.platform)||I.css(a.overlayCSS),I.css("position",r?"fixed":"absolute"),(e.browser.msie||a.forceIframe)&&w.css("opacity",0);var U=[w,I,k],x=e(r?"body":t);e.each(U,(function(){this.appendTo(x)})),a.theme&&a.draggable&&e.fn.draggable&&k.draggable({handle:".ui-dialog-titlebar",cancel:"li"});var C=i&&(!e.boxModel||e("object,embed",r?null:t).length>0);if(n||C){if(r&&a.allowBodyStretch&&e.boxModel&&e("html,body").css("height","100%"),(n||!e.boxModel)&&!r)var S=b(t,"borderTopWidth"),O=b(t,"borderLeftWidth"),T=S?"(0 - "+S+")":0,E=O?"(0 - "+O+")":0;e.each([w,I,k],(function(e,o){var t=o[0].style;if(t.position="absolute",e<2)r?t.setExpression("height","Math.max(document.body.scrollHeight, document.body.offsetHeight) - (jQuery.boxModel?0:"+a.quirksmodeOffsetHack+') + "px"'):t.setExpression("height",'this.parentNode.offsetHeight + "px"'),r?t.setExpression("width",'jQuery.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"'):t.setExpression("width",'this.parentNode.offsetWidth + "px"'),E&&t.setExpression("left",E),T&&t.setExpression("top",T);else if(a.centerY)r&&t.setExpression("top",'(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (blah = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"'),t.marginTop=0;else if(!a.centerY&&r){var i="((document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "+(a.css&&a.css.top?parseInt(a.css.top):0)+') + "px"';t.setExpression("top",i)}}))}if(u&&(a.theme?k.find(".ui-widget-content").append(u):k.append(u),(u.jquery||u.nodeType)&&e(u).show()),(e.browser.msie||a.forceIframe)&&a.showOverlay&&w.show(),a.fadeIn){var M=a.onBlock?a.onBlock:o,j=a.showOverlay&&!u?M:o,z=u?M:o;a.showOverlay&&I._fadeIn(a.fadeIn,j),u&&k._fadeIn(a.fadeIn,z)}else a.showOverlay&&I.show(),u&&k.show(),a.onBlock&&a.onBlock();if(c(1,t,a),r?(l=k[0],s=e(":input:enabled:visible",l),a.focusInput&&setTimeout(f,20)):function(e,o,t){var i=e.parentNode,n=e.style,l=(i.offsetWidth-e.offsetWidth)/2-b(i,"borderLeftWidth"),s=(i.offsetHeight-e.offsetHeight)/2-b(i,"borderTopWidth");o&&(n.left=l>0?l+"px":"0");t&&(n.top=s>0?s+"px":"0")}(k[0],a.centerX,a.centerY),a.timeout){var H=setTimeout((function(){r?e.unblockUI(a):e(t).unblock(a)}),a.timeout);e(t).data("blockUI.timeout",H)}}function d(o,t){var i,n=o==window,a=e(o),d=a.data("blockUI.history"),u=a.data("blockUI.timeout");u&&(clearTimeout(u),a.removeData("blockUI.timeout")),t=e.extend({},e.blockUI.defaults,t||{}),c(0,o,t),null===t.onUnblock&&(t.onUnblock=a.data("blockUI.onUnblock"),a.removeData("blockUI.onUnblock")),i=n?e("body").children().filter(".blockUI").add("body > .blockUI"):e(".blockUI",o),n&&(l=s=null),t.fadeOut?(i.fadeOut(t.fadeOut),setTimeout((function(){r(i,d,t,o)}),t.fadeOut)):r(i,d,t,o)}function r(o,t,i,n){o.each((function(e,o){this.parentNode&&this.parentNode.removeChild(this)})),t&&t.el&&(t.el.style.display=t.display,t.el.style.position=t.position,t.parent&&t.parent.appendChild(t.el),e(n).removeData("blockUI.history")),"function"==typeof i.onUnblock&&i.onUnblock(n,i)}function c(o,t,i){var n=t==window,s=e(t);if((o||(!n||l)&&(n||s.data("blockUI.isBlocked")))&&(n||s.data("blockUI.isBlocked",o),i.bindEvents&&(!o||i.showOverlay))){var a="mousedown mouseup keydown keypress";o?e(document).bind(a,i,u):e(document).unbind(a,u)}}function u(o){if(o.keyCode&&9==o.keyCode&&l&&o.data.constrainTabKey){var t=s,i=!o.shiftKey&&o.target===t[t.length-1],n=o.shiftKey&&o.target===t[0];if(i||n)return setTimeout((function(){f(n)}),10),!1}var a=o.data;return e(o.target).parents("div."+a.blockMsgClass).length>0||0==e(o.target).parents().children().filter("div.blockUI").length}function f(e){if(s){var o=s[!0===e?s.length-1:0];o&&o.focus()}}function b(o,t){return parseInt(e.css(o,t))||0}}(jQuery);