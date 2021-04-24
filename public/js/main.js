"use strict";

function e(e) {
    return function (e) {
        if (Array.isArray(e)) return t(e)
    }(e) || function (e) {
        if ("undefined" != typeof Symbol && Symbol.iterator in Object(e)) return Array.from(e)
    }(e) || function (e, n) {
        if (!e) return;
        if ("string" == typeof e) return t(e, n);
        var a = Object.prototype.toString.call(e).slice(8, -1);
        "Object" === a && e.constructor && (a = e.constructor.name);
        if ("Map" === a || "Set" === a) return Array.from(e);
        if ("Arguments" === a || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)) return t(e, n)
    }(e) || function () {
        throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
    }()
}

function t(e, t) {
    (null == t || t > e.length) && (t = e.length);
    for (var n = 0, a = new Array(t); n < t; n++) a[n] = e[n];
    return a
}

var n, a, c = function (e) {
        e.classList.remove("hidden"), e.classList.add("block")
    }, o = function (e) {
        e.classList.remove("block"), e.classList.add("hidden")
    }, r = function (e, t) {
        return e.getAttribute("data-".concat(t))
    },
    s = (n = document.createElement("label"), (a = document.createElement("textarea")).id = "clipboard", n.htmlFor = "clipboard", n.innerHTML = "Clipboard", n.classList.add("sr-only"), n.style.cssText = "position: absolute; left: -99999em", a.style.cssText = "position: absolute; left: -99999em", a.setAttribute("readonly", !0), document.body.appendChild(n), document.body.appendChild(a), function (e) {
        a.value = e;
        var t = document.getSelection().rangeCount > 0 && document.getSelection().getRangeAt(0);
        if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
            var n = a.contentEditable;
            a.contentEditable = !0;
            var c = document.createRange();
            c.selectNodeContents(a);
            var o = window.getSelection();
            o.removeAllRanges(), o.addRange(c), a.setSelectionRange(0, 999999), a.contentEditable = n
        } else a.select();
        try {
            var r = document.execCommand("copy");
            return t && (document.getSelection().removeAllRanges(), document.getSelection().addRange(t)), r
        } catch (e) {
            return console.error(e), !1
        }
    }), d = function (e) {
        var t = document.getElementById("light-mode-ico"), n = document.getElementById("dark-mode-ico");
        if (!e) return o(t), void c(n);
        o(n), c(t)
    };
document.addEventListener("click", (function (t) {
    var n, a, i, l, m, u, g, h, f, b, y;
    t.target.matches(".copy-data") && (t.preventDefault(), function (t) {
        var n = r(t, "botname"), a = r(t, "botpack"), c = e(document.getElementsByClassName("copy-data")),
            o = function (e, t) {
                return "/msg ".concat(e, " xdcc send #").concat(t)
            }(n, a);
        try {
            s(o), c.forEach((function (e) {
                e.classList.remove("bg-gray-300"), e.classList.add("bg-gray-100"), e.classList.add("cursor-not-allowed")
            })), t.innerHTML = "Copied"
        } catch (e) {
            t.innerHTML = "Error"
        }
        setTimeout((function () {
            c.forEach((function (e) {
                e.classList.add("bg-gray-300"), e.classList.remove("bg-gray-100"), e.classList.remove("cursor-not-allowed")
            })), t.innerHTML = "Copy"
        }), 1e3)
    }(t.target)), t.target.matches("#clear-selected-batch") && (t.preventDefault(), e(document.getElementsByClassName("form-tick")).forEach((function (e) {
        return e.checked = !1
    }))), t.target.matches(".mobile-menu-toggle") && (t.preventDefault(), n = document.getElementById("mobile-menu"), a = document.getElementById("menu-close"), i = document.getElementById("menu-open"), n.classList.contains("hidden") ? (c(n), o(i), c(a)) : (o(n), o(a), c(i))), (t.target.matches("#enable-copy-as-batch") || t.target.matches("#disable-copy-as-batch")) && (t.preventDefault(), l = document.getElementById("enable-copy-as-batch"), m = document.getElementById("disable-copy-as-batch"), u = document.getElementById("clear-selected-batch"), g = document.getElementById("copy-as-batch"), h = e(document.getElementsByClassName("copy-data")), f = e(document.getElementsByClassName("batch-copy-checkbox")), b = e(document.getElementsByClassName("form-tick")), l.classList.contains("hidden") ? (l.classList.remove("hidden"), m.classList.add("hidden"), u.classList.add("hidden"), g.classList.add("hidden"), h.forEach((function (e) {
        return e.classList.remove("hidden")
    })), f.forEach((function (e) {
        e.classList.remove("hidden"), e.classList.add("hidden")
    })), b.forEach((function (e) {
        return e.checked = !1
    }))) : (l.classList.add("hidden"), m.classList.remove("hidden"), u.classList.remove("hidden"), g.classList.remove("hidden"), h.forEach((function (e) {
        return e.classList.add("hidden")
    })), f.forEach((function (e) {
        e.classList.remove("hidden"), e.classList.add("flex")
    })))), t.target.matches("#copy-as-batch") && (t.preventDefault(), function () {
        var t = [], n = document.getElementById("copy-as-batch");
        e(document.getElementsByClassName("form-tick")).forEach((function (e) {
            var n = r(e, "botname"), a = r(e, "botpack"), c = t.findIndex((function (e) {
                return e.bot === n
            }));
            -1 === c && !0 === e.checked ? t.push({
                bot: n,
                items: [a]
            }) : -1 !== c && !0 === e.checked && t[c].items.push(a)
        }));
        try {
            var a = function (e) {
                var t = [];
                return e.forEach((function (e) {
                    t.push("/msg ".concat(e.bot, " xdcc batch ").concat(e.items.join(",")))
                })), t.join("\n")
            }(t);
            s(a), n.classList.remove("bg-gray-800"), n.classList.add("bg-gray-600"), n.innerHTML = "Copied"
        } catch (e) {
            n.innerHTML = "Error"
        }
        setTimeout((function () {
            n.classList.remove("bg-gray-600"), n.classList.add("bg-gray-800"), n.innerHTML = "Copy selected"
        }), 1e3)
    }()), t.target.matches("#toggle-dark-mode") && (t.preventDefault(), (y = document.documentElement).classList.contains("dark") ? (y.classList.remove("dark"), d(!1), localStorage.setItem("darkMode", "disabled")) : (y.classList.add("dark"), d(!0), localStorage.setItem("darkMode", "enabled")))
}), !1), d("enabled" === localStorage.darkMode || !("darkMode" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches);
