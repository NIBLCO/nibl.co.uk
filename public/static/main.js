"use strict";function e(e){return function(e){if(Array.isArray(e))return t(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,a){if(!e)return;if("string"==typeof e)return t(e,a);var n=Object.prototype.toString.call(e).slice(8,-1);"Object"===n&&e.constructor&&(n=e.constructor.name);if("Map"===n||"Set"===n)return Array.from(e);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return t(e,a)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function t(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=new Array(t);a<t;a++)n[a]=e[a];return n}var a,n,c,o=function(e){e.classList.remove("hidden"),e.classList.add("block")},r=function(e){e.classList.remove("block"),e.classList.add("hidden")},s=function(e,t){return e.getAttribute("data-".concat(t))},d=(a=document.createElement("label"),(n=document.createElement("textarea")).id="clipboard",a.htmlFor="clipboard",a.innerHTML="Clipboard",a.classList.add("sr-only"),a.style.cssText="position: absolute; left: -99999em",n.style.cssText="position: absolute; left: -99999em",n.setAttribute("readonly",!0),document.body.appendChild(a),document.body.appendChild(n),function(e){n.value=e;var t=document.getSelection().rangeCount>0&&document.getSelection().getRangeAt(0);if(navigator.userAgent.match(/ipad|ipod|iphone/i)){var a=n.contentEditable;n.contentEditable=!0;var c=document.createRange();c.selectNodeContents(n);var o=window.getSelection();o.removeAllRanges(),o.addRange(c),n.setSelectionRange(0,999999),n.contentEditable=a}else n.select();try{var r=document.execCommand("copy");return t&&(document.getSelection().removeAllRanges(),document.getSelection().addRange(t)),r}catch(e){return console.error(e),!1}}),i=function(e){var t=document.getElementById("light-mode-ico"),a=document.getElementById("dark-mode-ico");if(!e)return r(t),void o(a);r(a),o(t)};document.addEventListener("click",(function(t){var a,n,l,m,u,g,h,f,b,y,p;if(t.target.matches(".copy-data")&&(t.preventDefault(),function(t){var a=s(t,"botname"),n=s(t,"botpack"),c=e(document.getElementsByClassName("copy-data")),o=function(e,t){return"/msg ".concat(e," xdcc send #").concat(t)}(a,n);try{d(o),c.forEach((function(e){e.classList.remove("bg-gray-300"),e.classList.add("bg-gray-100"),e.classList.add("cursor-not-allowed")})),t.innerHTML="Copied"}catch(e){t.innerHTML="Error"}setTimeout((function(){c.forEach((function(e){e.classList.add("bg-gray-300"),e.classList.remove("bg-gray-100"),e.classList.remove("cursor-not-allowed")})),t.innerHTML="Copy"}),1e3)}(t.target)),t.target.matches("#clear-selected-batch")&&(t.preventDefault(),e(document.getElementsByClassName("form-tick")).forEach((function(e){return e.checked=!1}))),t.target.matches(".mobile-menu-toggle")&&(t.preventDefault(),a=document.getElementById("mobile-menu"),n=document.getElementById("menu-close"),l=document.getElementById("menu-open"),a.classList.contains("hidden")?(o(a),r(l),o(n)):(r(a),r(n),o(l))),(t.target.matches("#enable-copy-as-batch")||t.target.matches("#disable-copy-as-batch"))&&(t.preventDefault(),m=document.getElementById("enable-copy-as-batch"),u=document.getElementById("disable-copy-as-batch"),g=document.getElementById("clear-selected-batch"),h=document.getElementById("copy-as-batch"),f=e(document.getElementsByClassName("copy-data")),b=e(document.getElementsByClassName("batch-copy-checkbox")),y=e(document.getElementsByClassName("form-tick")),m.classList.contains("hidden")?(m.classList.remove("hidden"),u.classList.add("hidden"),g.classList.add("hidden"),h.classList.add("hidden"),f.forEach((function(e){return e.classList.remove("hidden")})),b.forEach((function(e){e.classList.remove("hidden"),e.classList.add("hidden")})),y.forEach((function(e){return e.checked=!1}))):(m.classList.add("hidden"),u.classList.remove("hidden"),g.classList.remove("hidden"),h.classList.remove("hidden"),f.forEach((function(e){return e.classList.add("hidden")})),b.forEach((function(e){e.classList.remove("hidden"),e.classList.add("flex")})))),t.target.matches("#copy-as-batch")&&(t.preventDefault(),function(){var t=[],a=document.getElementById("copy-as-batch");e(document.getElementsByClassName("form-tick")).forEach((function(e){var a=s(e,"botname"),n=s(e,"botpack"),c=t.findIndex((function(e){return e.bot===a}));-1===c&&!0===e.checked?t.push({bot:a,items:[n]}):-1!==c&&!0===e.checked&&t[c].items.push(n)}));try{var n=function(e){var t=[];return e.forEach((function(e){t.push("/msg ".concat(e.bot," xdcc batch ").concat(e.items.join(",")))})),t.join("\n")}(t);d(n),a.classList.remove("bg-gray-800"),a.classList.add("bg-gray-600"),a.innerHTML="Copied"}catch(e){a.innerHTML="Error"}setTimeout((function(){a.classList.remove("bg-gray-600"),a.classList.add("bg-gray-800"),a.innerHTML="Copy selected"}),1e3)}()),t.target.matches("#toggle-dark-mode")&&(t.preventDefault(),(p=document.documentElement).classList.contains("dark")?(p.classList.remove("dark"),i(!1),localStorage.setItem("darkMode","disabled")):(p.classList.add("dark"),i(!0),localStorage.setItem("darkMode","enabled"))),t.target.matches(".form-tick"))if(t.shiftKey){var v=t.target;null!==c&&function(e,t){for(var a=document.querySelectorAll("div table tbody tr"),n=e.dataset.botpack,c=e.dataset.botname,o=t.dataset.botpack,r=t.dataset.botname,s=!1,d=0;d<a.length;d++){var i=(null==a[d].children[4]?a[d].children[3]:a[d].children[4]).querySelector("label").querySelector("input"),l=i.dataset.botpack,m=i.dataset.botname;(l==n&&m==c||l==o&&m==r)&&(s=!s),s&&(i.checked=!0)}}(c,v)}else c=t.target}),!1),i("enabled"===localStorage.darkMode||!("darkMode"in localStorage)&&window.matchMedia("(prefers-color-scheme: dark)").matches);