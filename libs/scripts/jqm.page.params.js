// jqm.page.params.js - version 0.1
// Copyright (c) 2011, Kin Blas
// All rights reserved.
// 
// Redistribution and use in source and binary forms, with or without
// modification, are permitted provided that the following conditions are met:
//     * Redistributions of source code must retain the above copyright
//       notice, this list of conditions and the following disclaimer.
//     * Redistributions in binary form must reproduce the above copyright
//       notice, this list of conditions and the following disclaimer in the
//       documentation and/or other materials provided with the distribution.
//     * Neither the name of the <organization> nor the
//       names of its contributors may be used to endorse or promote products
//       derived from this software without specific prior written permission.
// 
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
// ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
// WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
// DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
// DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
// (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
// LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
// ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
// (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
// SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

!function(a,e,o){a(document).bind("pagebeforechange",(function(e,o){if("string"==typeof o.toPage){var t=a.mobile.path.parseUrl(o.toPage);if(a.mobile.path.isEmbeddedPage(t)){var i=a.mobile.path.parseUrl(t.hash.replace(/^#/,""));i.search&&(o.options.dataUrl||(o.options.dataUrl=o.toPage),o.options.pageData=function(a){var e,o,t,i,p={},n=(a||"").replace(/^\?/,"").split(/&/);for(e=0;e<n.length;e++){var r=n[e];r&&(t=(o=r.split(/=/))[0],i=o[1],void 0===p[t]?p[t]=i:("object"!=typeof p[t]&&(p[t]=[p[t]]),p[t].push(i)))}return p}(i.search),o.toPage=t.hrefNoHash+"#"+i.pathname)}}}))}(jQuery,window),$(document).bind("pagebeforechange",(function(a,e){$.mobile.pageData=e&&e.options&&e.options.pageData?e.options.pageData:{},$.mobile.pageData.active=e.toPage[0].id}));