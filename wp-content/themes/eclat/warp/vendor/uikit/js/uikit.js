!function (t) {
    if ("function" == typeof define && define.amd && define("uikit", function () {
            var i = window.UIkit || t(window, window.jQuery, window.document);
            return i.load = function (t, e, n, o) {
                var s, a = t.split(","), r = [], c = (o.config && o.config.uikit && o.config.uikit.base ? o.config.uikit.base : "").replace(/\/+$/g, "");
                if (!c)throw new Error("Please define base path to UIkit in the requirejs config.");
                for (s = 0; s < a.length; s += 1) {
                    var l = a[s].replace(/\./g, "/");
                    r.push(c + "/components/" + l)
                }
                e(r, function () {
                    n(i)
                })
            }, i
        }), !window.jQuery)throw new Error("UIkit requires jQuery");
    window && window.jQuery && t(window, window.jQuery, window.document)
}(function (t, i, e) {
    "use strict";
    var n = {}, o = t.UIkit ? Object.create(t.UIkit) : void 0;
    if (n.version = "2.20.3", n.noConflict = function () {
            return o && (t.UIkit = o, i.UIkit = o, i.fn.uk = o.fn), n
        }, n.prefix = function (t) {
            return t
        }, n.$ = i, n.$doc = n.$(document), n.$win = n.$(window), n.$html = n.$("html"), n.support = {}, n.support.transition = function () {
            var t = function () {
                var t, i = e.body || e.documentElement, n = {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "oTransitionEnd otransitionend",
                    transition: "transitionend"
                };
                for (t in n)if (void 0 !== i.style[t])return n[t]
            }();
            return t && {end: t}
        }(), n.support.animation = function () {
            var t = function () {
                var t, i = e.body || e.documentElement, n = {
                    WebkitAnimation: "webkitAnimationEnd",
                    MozAnimation: "animationend",
                    OAnimation: "oAnimationEnd oanimationend",
                    animation: "animationend"
                };
                for (t in n)if (void 0 !== i.style[t])return n[t]
            }();
            return t && {end: t}
        }(), function () {
            var i = 0;
            t.requestAnimationFrame = t.requestAnimationFrame || t.webkitRequestAnimationFrame || function (e) {
                var n = (new Date).getTime(), o = Math.max(0, 16 - (n - i)), s = t.setTimeout(function () {
                    e(n + o)
                }, o);
                return i = n + o, s
            }, t.cancelAnimationFrame || (t.cancelAnimationFrame = function (t) {
                clearTimeout(t)
            })
        }(), n.support.touch = "ontouchstart"in document || t.DocumentTouch && document instanceof t.DocumentTouch || t.navigator.msPointerEnabled && t.navigator.msMaxTouchPoints > 0 || t.navigator.pointerEnabled && t.navigator.maxTouchPoints > 0 || !1, n.support.mutationobserver = t.MutationObserver || t.WebKitMutationObserver || null, n.Utils = {}, n.Utils.str2json = function (t, i) {
            try {
                return i ? JSON.parse(t.replace(/([\$\w]+)\s*:/g, function (t, i) {
                    return '"' + i + '":'
                }).replace(/'([^']+)'/g, function (t, i) {
                    return '"' + i + '"'
                })) : new Function("", "var json = " + t + "; return JSON.parse(JSON.stringify(json));")()
            } catch (e) {
                return !1
            }
        }, n.Utils.debounce = function (t, i, e) {
            var n;
            return function () {
                var o = this, s = arguments, a = function () {
                    n = null, e || t.apply(o, s)
                }, r = e && !n;
                clearTimeout(n), n = setTimeout(a, i), r && t.apply(o, s)
            }
        }, n.Utils.removeCssRules = function (t) {
            var i, e, n, o, s, a, r, c, l, u;
            t && setTimeout(function () {
                try {
                    for (u = document.styleSheets, o = 0, r = u.length; r > o; o++) {
                        for (n = u[o], e = [], n.cssRules = n.cssRules, i = s = 0, c = n.cssRules.length; c > s; i = ++s)n.cssRules[i].type === CSSRule.STYLE_RULE && t.test(n.cssRules[i].selectorText) && e.unshift(i);
                        for (a = 0, l = e.length; l > a; a++)n.deleteRule(e[a])
                    }
                } catch (h) {
                }
            }, 0)
        }, n.Utils.isInView = function (t, e) {
            var o = i(t);
            if (!o.is(":visible"))return !1;
            var s = n.$win.scrollLeft(), a = n.$win.scrollTop(), r = o.offset(), c = r.left, l = r.top;
            return e = i.extend({
                topoffset: 0,
                leftoffset: 0
            }, e), l + o.height() >= a && l - e.topoffset <= a + n.$win.height() && c + o.width() >= s && c - e.leftoffset <= s + n.$win.width() ? !0 : !1
        }, n.Utils.checkDisplay = function (t, e) {
            var o = n.$("[data-uk-margin], [data-uk-grid-match], [data-uk-grid-margin], [data-uk-check-display]", t || document);
            return t && !o.length && (o = i(t)), o.trigger("display.uk.check"), e && ("string" != typeof e && (e = '[class*="uk-animation-"]'), o.find(e).each(function () {
                var t = n.$(this), i = t.attr("class"), e = i.match(/uk\-animation\-(.+)/);
                t.removeClass(e[0]).width(), t.addClass(e[0])
            })), o
        }, n.Utils.options = function (t) {
            if (i.isPlainObject(t))return t;
            var e = t ? t.indexOf("{") : -1, o = {};
            if (-1 != e)try {
                o = n.Utils.str2json(t.substr(e))
            } catch (s) {
            }
            return o
        }, n.Utils.animate = function (t, e) {
            var o = i.Deferred();
            return t = n.$(t), e = e, t.css("display", "none").addClass(e).one(n.support.animation.end, function () {
                t.removeClass(e), o.resolve()
            }).width(), t.css("display", ""), o.promise()
        }, n.Utils.uid = function (t) {
            return (t || "id") + (new Date).getTime() + "RAND" + Math.ceil(1e5 * Math.random())
        }, n.Utils.template = function (t, i) {
            for (var e, n, o, s, a = t.replace(/\n/g, "\\n").replace(/\{\{\{\s*(.+?)\s*\}\}\}/g, "{{!$1}}").split(/(\{\{\s*(.+?)\s*\}\})/g), r = 0, c = [], l = 0; r < a.length;) {
                if (e = a[r], e.match(/\{\{\s*(.+?)\s*\}\}/))switch (r += 1, e = a[r], n = e[0], o = e.substring(e.match(/^(\^|\#|\!|\~|\:)/) ? 1 : 0), n) {
                    case"~":
                        c.push("for(var $i=0;$i<" + o + ".length;$i++) { var $item = " + o + "[$i];"), l++;
                        break;
                    case":":
                        c.push("for(var $key in " + o + ") { var $val = " + o + "[$key];"), l++;
                        break;
                    case"#":
                        c.push("if(" + o + ") {"), l++;
                        break;
                    case"^":
                        c.push("if(!" + o + ") {"), l++;
                        break;
                    case"/":
                        c.push("}"), l--;
                        break;
                    case"!":
                        c.push("__ret.push(" + o + ");");
                        break;
                    default:
                        c.push("__ret.push(escape(" + o + "));")
                } else c.push("__ret.push('" + e.replace(/\'/g, "\\'") + "');");
                r += 1
            }
            return s = new Function("$data", ["var __ret = [];", "try {", "with($data){", l ? '__ret = ["Not all blocks are closed correctly."]' : c.join(""), "};", "}catch(e){__ret = [e.message];}", 'return __ret.join("").replace(/\\n\\n/g, "\\n");', "function escape(html) { return String(html).replace(/&/g, '&amp;').replace(/\"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');}"].join("\n")), i ? s(i) : s
        }, n.Utils.events = {}, n.Utils.events.click = n.support.touch ? "tap" : "click", t.UIkit = n, n.fn = function (t, e) {
            var o = arguments, s = t.match(/^([a-z\-]+)(?:\.([a-z]+))?/i), a = s[1], r = s[2];
            return n[a] ? this.each(function () {
                var t = i(this), s = t.data(a);
                s || t.data(a, s = n[a](this, r ? void 0 : e)), r && s[r].apply(s, Array.prototype.slice.call(o, 1))
            }) : (i.error("UIkit component [" + a + "] does not exist."), this)
        }, i.UIkit = n, i.fn.uk = n.fn, n.langdirection = "rtl" == n.$html.attr("dir") ? "right" : "left", n.components = {}, n.component = function (t, e) {
            var o = function (e, s) {
                var a = this;
                return this.UIkit = n, this.element = e ? n.$(e) : null, this.options = i.extend(!0, {}, this.defaults, s), this.plugins = {}, this.element && this.element.data(t, this), this.init(), (this.options.plugins.length ? this.options.plugins : Object.keys(o.plugins)).forEach(function (t) {
                    o.plugins[t].init && (o.plugins[t].init(a), a.plugins[t] = !0)
                }), this.trigger("init.uk.component", [t, this]), this
            };
            return o.plugins = {}, i.extend(!0, o.prototype, {
                defaults: {plugins: []}, boot: function () {
                }, init: function () {
                }, on: function (t, i, e) {
                    return n.$(this.element || this).on(t, i, e)
                }, one: function (t, i, e) {
                    return n.$(this.element || this).one(t, i, e)
                }, off: function (t) {
                    return n.$(this.element || this).off(t)
                }, trigger: function (t, i) {
                    return n.$(this.element || this).trigger(t, i)
                }, find: function (t) {
                    return n.$(this.element ? this.element : []).find(t)
                }, proxy: function (t, i) {
                    var e = this;
                    i.split(" ").forEach(function (i) {
                        e[i] || (e[i] = function () {
                            return t[i].apply(t, arguments)
                        })
                    })
                }, mixin: function (t, i) {
                    var e = this;
                    i.split(" ").forEach(function (i) {
                        e[i] || (e[i] = t[i].bind(e))
                    })
                }, option: function () {
                    return 1 == arguments.length ? this.options[arguments[0]] || void 0 : void(2 == arguments.length && (this.options[arguments[0]] = arguments[1]))
                }
            }, e), this.components[t] = o, this[t] = function () {
                var e, o;
                if (arguments.length)switch (arguments.length) {
                    case 1:
                        "string" == typeof arguments[0] || arguments[0].nodeType || arguments[0]instanceof jQuery ? e = i(arguments[0]) : o = arguments[0];
                        break;
                    case 2:
                        e = i(arguments[0]), o = arguments[1]
                }
                return e && e.data(t) ? e.data(t) : new n.components[t](e, o)
            }, n.domready && n.component.boot(t), o
        }, n.plugin = function (t, i, e) {
            this.components[t].plugins[i] = e
        }, n.component.boot = function (t) {
            n.components[t].prototype && n.components[t].prototype.boot && !n.components[t].booted && (n.components[t].prototype.boot.apply(n, []), n.components[t].booted = !0)
        }, n.component.bootComponents = function () {
            for (var t in n.components)n.component.boot(t)
        }, n.domObservers = [], n.domready = !1, n.ready = function (t) {
            n.domObservers.push(t), n.domready && t(document)
        }, n.on = function (t, i, e) {
            return t && t.indexOf("ready.uk.dom") > -1 && n.domready && i.apply(n.$doc), n.$doc.on(t, i, e)
        }, n.one = function (t, i, e) {
            return t && t.indexOf("ready.uk.dom") > -1 && n.domready ? (i.apply(n.$doc), n.$doc) : n.$doc.one(t, i, e)
        }, n.trigger = function (t, i) {
            return n.$doc.trigger(t, i)
        }, n.domObserve = function (t, i) {
            n.support.mutationobserver && (i = i || function () {
            }, n.$(t).each(function () {
                var t = this, e = n.$(t);
                if (!e.data("observer"))try {
                    var o = new n.support.mutationobserver(n.Utils.debounce(function () {
                        i.apply(t, []), e.trigger("changed.uk.dom")
                    }, 50));
                    o.observe(t, {childList: !0, subtree: !0}), e.data("observer", o)
                } catch (s) {
                }
            }))
        }, n.init = function (t) {
            t = t || document, n.domObservers.forEach(function (i) {
                i(t)
            })
        }, n.on("domready.uk.dom", function () {
            n.init(), n.domready && n.Utils.checkDisplay()
        }), i(function () {
            n.$body = n.$("body"), n.ready(function () {
                n.domObserve("[data-uk-observe]")
            }), n.on("changed.uk.dom", function (t) {
                n.init(t.target), n.Utils.checkDisplay(t.target)
            }), n.trigger("beforeready.uk.dom"), n.component.bootComponents(), setInterval(function () {
                var t, i = {x: window.pageXOffset, y: window.pageYOffset}, e = function () {
                    (i.x != window.pageXOffset || i.y != window.pageYOffset) && (t = {
                        x: 0,
                        y: 0
                    }, window.pageXOffset != i.x && (t.x = window.pageXOffset > i.x ? 1 : -1), window.pageYOffset != i.y && (t.y = window.pageYOffset > i.y ? 1 : -1), i = {
                        dir: t,
                        x: window.pageXOffset,
                        y: window.pageYOffset
                    }, n.$doc.trigger("scrolling.uk.document", [i]))
                };
                return n.support.touch && n.$html.on("touchmove touchend MSPointerMove MSPointerUp pointermove pointerup", e), (i.x || i.y) && e(), e
            }(), 15), n.trigger("domready.uk.dom"), n.support.touch && navigator.userAgent.match(/(iPad|iPhone|iPod)/g) && n.$win.on("load orientationchange resize", n.Utils.debounce(function () {
                var t = function () {
                    return i(".uk-height-viewport").css("height", window.innerHeight), t
                };
                return t()
            }(), 100)), n.trigger("afterready.uk.dom"), n.domready = !0
        }), n.$html.addClass(n.support.touch ? "uk-touch" : "uk-notouch"), n.support.touch) {
        var s, a = !1, r = "uk-hover", c = ".uk-overlay, .uk-overlay-hover, .uk-overlay-toggle, .uk-animation-hover, .uk-has-hover";
        n.$html.on("touchstart MSPointerDown pointerdown", c, function () {
            a && i("." + r).removeClass(r), a = i(this).addClass(r)
        }).on("touchend MSPointerUp pointerup", function (t) {
            s = i(t.target).parents(c), a && a.not(s).removeClass(r)
        })
    }
    return n
}), function (t) {
    function i(t, i, e, n) {
        return Math.abs(t - i) >= Math.abs(e - n) ? t - i > 0 ? "Left" : "Right" : e - n > 0 ? "Up" : "Down"
    }

    function e() {
        l = null, h.last && (h.el.trigger("longTap"), h = {})
    }

    function n() {
        l && clearTimeout(l), l = null
    }

    function o() {
        a && clearTimeout(a), r && clearTimeout(r), c && clearTimeout(c), l && clearTimeout(l), a = r = c = l = null, h = {}
    }

    function s(t) {
        return t.pointerType == t.MSPOINTER_TYPE_TOUCH && t.isPrimary
    }

    if (!t.fn.swipeLeft) {
        var a, r, c, l, u, h = {}, d = 750;
        t(function () {
            var f, p, g, m = 0, v = 0;
            "MSGesture"in window && (u = new MSGesture, u.target = document.body), t(document).on("MSGestureEnd gestureend", function (t) {
                var i = t.originalEvent.velocityX > 1 ? "Right" : t.originalEvent.velocityX < -1 ? "Left" : t.originalEvent.velocityY > 1 ? "Down" : t.originalEvent.velocityY < -1 ? "Up" : null;
                i && (h.el.trigger("swipe"), h.el.trigger("swipe" + i))
            }).on("touchstart MSPointerDown pointerdown", function (i) {
                ("MSPointerDown" != i.type || s(i.originalEvent)) && (g = "MSPointerDown" == i.type || "pointerdown" == i.type ? i : i.originalEvent.touches[0], f = Date.now(), p = f - (h.last || f), h.el = t("tagName"in g.target ? g.target : g.target.parentNode), a && clearTimeout(a), h.x1 = g.pageX, h.y1 = g.pageY, p > 0 && 250 >= p && (h.isDoubleTap = !0), h.last = f, l = setTimeout(e, d), !u || "MSPointerDown" != i.type && "pointerdown" != i.type && "touchstart" != i.type || u.addPointer(i.originalEvent.pointerId))
            }).on("touchmove MSPointerMove pointermove", function (t) {
                ("MSPointerMove" != t.type || s(t.originalEvent)) && (g = "MSPointerMove" == t.type || "pointermove" == t.type ? t : t.originalEvent.touches[0], n(), h.x2 = g.pageX, h.y2 = g.pageY, m += Math.abs(h.x1 - h.x2), v += Math.abs(h.y1 - h.y2))
            }).on("touchend MSPointerUp pointerup", function (e) {
                ("MSPointerUp" != e.type || s(e.originalEvent)) && (n(), h.x2 && Math.abs(h.x1 - h.x2) > 30 || h.y2 && Math.abs(h.y1 - h.y2) > 30 ? c = setTimeout(function () {
                    h.el.trigger("swipe"), h.el.trigger("swipe" + i(h.x1, h.x2, h.y1, h.y2)), h = {}
                }, 0) : "last"in h && (isNaN(m) || 30 > m && 30 > v ? r = setTimeout(function () {
                    var i = t.Event("tap");
                    i.cancelTouch = o, h.el.trigger(i), h.isDoubleTap ? (h.el.trigger("doubleTap"), h = {}) : a = setTimeout(function () {
                        a = null, h.el.trigger("singleTap"), h = {}
                    }, 250)
                }, 0) : h = {}, m = v = 0))
            }).on("touchcancel MSPointerCancel", o), t(window).on("scroll", o)
        }), ["swipe", "swipeLeft", "swipeRight", "swipeUp", "swipeDown", "doubleTap", "tap", "singleTap", "longTap"].forEach(function (i) {
            t.fn[i] = function (e) {
                return t(this).on(i, e)
            }
        })
    }
}(jQuery), function (t) {
    "use strict";
    var i = [];
    t.component("stackMargin", {
        defaults: {cls: "uk-margin-small-top"}, boot: function () {
            t.ready(function (i) {
                t.$("[data-uk-margin]", i).each(function () {
                    var i, e = t.$(this);
                    e.data("stackMargin") || (i = t.stackMargin(e, t.Utils.options(e.attr("data-uk-margin"))))
                })
            })
        }, init: function () {
            var e = this;
            this.columns = this.element.children(), this.columns.length && (t.$win.on("resize orientationchange", function () {
                var i = function () {
                    e.process()
                };
                return t.$(function () {
                    i(), t.$win.on("load", i)
                }), t.Utils.debounce(i, 20)
            }()), t.$html.on("changed.uk.dom", function () {
                e.columns = e.element.children(), e.process()
            }), this.on("display.uk.check", function () {
                e.columns = e.element.children(), this.element.is(":visible") && this.process()
            }.bind(this)), i.push(this))
        }, process: function () {
            return t.Utils.stackMargin(this.columns, this.options), this
        }, revert: function () {
            return this.columns.removeClass(this.options.cls), this
        }
    }), t.ready(function () {
        var i = [], e = function () {
            i.forEach(function (t) {
                if (t.is(":visible")) {
                    var i = t.parent().width(), e = t.data("width"), n = i / e, o = Math.floor(n * t.data("height"));
                    t.css({height: e > i ? o : t.data("height")})
                }
            })
        };
        return t.$win.on("resize", t.Utils.debounce(e, 15)), function (n) {
            t.$("iframe.uk-responsive-width", n).each(function () {
                var e = t.$(this);
                !e.data("responsive") && e.attr("width") && e.attr("height") && (e.data("width", e.attr("width")), e.data("height", e.attr("height")), e.data("responsive", !0), i.push(e))
            }), e()
        }
    }()), t.Utils.stackMargin = function (i, e) {
        e = t.$.extend({cls: "uk-margin-small-top"}, e), e.cls = e.cls, i = t.$(i).removeClass(e.cls);
        var n = !1, o = i.filter(":visible:first"), s = o.length ? o.position().top + o.outerHeight() - 1 : !1;
        s !== !1 && i.each(function () {
            var i = t.$(this);
            i.is(":visible") && (n ? i.addClass(e.cls) : i.position().top >= s && (n = i.addClass(e.cls)))
        })
    }
}(UIkit), function (t) {
    "use strict";
    function i(i, e) {
        e = t.$.extend({
            duration: 1e3, transition: "easeOutExpo", offset: 0, complete: function () {
            }
        }, e);
        var n = i.offset().top - e.offset, o = t.$doc.height(), s = window.innerHeight;
        n + s > o && (n = o - s), t.$("html,body").stop().animate({scrollTop: n}, e.duration, e.transition).promise().done(e.complete)
    }

    t.component("smoothScroll", {
        boot: function () {
            t.$html.on("click.smooth-scroll.uikit", "[data-uk-smooth-scroll]", function () {
                var i = t.$(this);
                if (!i.data("smoothScroll")) {
                    {
                        t.smoothScroll(i, t.Utils.options(i.attr("data-uk-smooth-scroll")))
                    }
                    i.trigger("click")
                }
                return !1
            })
        }, init: function () {
            var e = this;
            this.on("click", function (n) {
                n.preventDefault(), i(t.$(t.$(this.hash).length ? this.hash : "body"), e.options)
            })
        }
    }), t.Utils.scrollToElement = i, t.$.easing.easeOutExpo || (t.$.easing.easeOutExpo = function (t, i, e, n, o) {
        return i == o ? e + n : n * (-Math.pow(2, -10 * i / o) + 1) + e
    })
}(UIkit), function (t) {
    "use strict";
    var i = t.$win, e = t.$doc, n = [], o = function () {
        for (var t = 0; t < n.length; t++)window.requestAnimationFrame.apply(window, [n[t].check])
    };
    t.component("scrollspy", {
        defaults: {
            target: !1,
            cls: "uk-scrollspy-inview",
            initcls: "uk-scrollspy-init-inview",
            topoffset: 0,
            leftoffset: 0,
            repeat: !1,
            delay: 0
        }, boot: function () {
            e.on("scrolling.uk.document", o), i.on("load resize orientationchange", t.Utils.debounce(o, 50)), t.ready(function (i) {
                t.$("[data-uk-scrollspy]", i).each(function () {
                    var i = t.$(this);
                    if (!i.data("scrollspy")) {
                        t.scrollspy(i, t.Utils.options(i.attr("data-uk-scrollspy")))
                    }
                })
            })
        }, init: function () {
            var i, e = this, o = this.options.cls.split(/,/), s = function () {
                var n = e.options.target ? e.element.find(e.options.target) : e.element, s = 1 === n.length ? 1 : 0, a = 0;
                n.each(function () {
                    var n = t.$(this), r = n.data("inviewstate"), c = t.Utils.isInView(n, e.options), l = n.data("ukScrollspyCls") || o[a].trim();
                    !c || r || n.data("scrollspy-idle") || (i || (n.addClass(e.options.initcls), e.offset = n.offset(), i = !0, n.trigger("init.uk.scrollspy")), n.data("scrollspy-idle", setTimeout(function () {
                        n.addClass("uk-scrollspy-inview").toggleClass(l).width(), n.trigger("inview.uk.scrollspy"), n.data("scrollspy-idle", !1), n.data("inviewstate", !0)
                    }, e.options.delay * s)), s++), !c && r && e.options.repeat && (n.data("scrollspy-idle") && clearTimeout(n.data("scrollspy-idle")), n.removeClass("uk-scrollspy-inview").toggleClass(l), n.data("inviewstate", !1), n.trigger("outview.uk.scrollspy")), a = o[a + 1] ? a + 1 : 0
                })
            };
            s(), this.check = s, n.push(this)
        }
    });
    var s = [], a = function () {
        for (var t = 0; t < s.length; t++)window.requestAnimationFrame.apply(window, [s[t].check])
    };
    t.component("scrollspynav", {
        defaults: {
            cls: "uk-active",
            closest: !1,
            topoffset: 0,
            leftoffset: 0,
            smoothscroll: !1
        }, boot: function () {
            e.on("scrolling.uk.document", a), i.on("resize orientationchange", t.Utils.debounce(a, 50)), t.ready(function (i) {
                t.$("[data-uk-scrollspy-nav]", i).each(function () {
                    var i = t.$(this);
                    if (!i.data("scrollspynav")) {
                        t.scrollspynav(i, t.Utils.options(i.attr("data-uk-scrollspy-nav")))
                    }
                })
            })
        }, init: function () {
            var e, n = [], o = this.find("a[href^='#']").each(function () {
                n.push(t.$(this).attr("href"))
            }), a = t.$(n.join(",")), r = this.options.cls, c = this.options.closest || this.options.closest, l = this, u = function () {
                e = [];
                for (var n = 0; n < a.length; n++)t.Utils.isInView(a.eq(n), l.options) && e.push(a.eq(n));
                if (e.length) {
                    var s, u = i.scrollTop(), h = function () {
                        for (var t = 0; t < e.length; t++)if (e[t].offset().top >= u)return e[t]
                    }();
                    if (!h)return;
                    l.options.closest ? (o.closest(c).removeClass(r), s = o.filter("a[href='#" + h.attr("id") + "']").closest(c).addClass(r)) : s = o.removeClass(r).filter("a[href='#" + h.attr("id") + "']").addClass(r), l.element.trigger("inview.uk.scrollspynav", [h, s])
                }
            };
            this.options.smoothscroll && t.smoothScroll && o.each(function () {
                t.smoothScroll(this, l.options.smoothscroll)
            }), u(), this.element.data("scrollspynav", this), this.check = u, s.push(this)
        }
    })
}(UIkit), function (t) {
    "use strict";
    var i = [];
    t.component("toggle", {
        defaults: {target: !1, cls: "uk-hidden", animation: !1, duration: 200}, boot: function () {
            t.ready(function (e) {
                t.$("[data-uk-toggle]", e).each(function () {
                    var i = t.$(this);
                    if (!i.data("toggle")) {
                        t.toggle(i, t.Utils.options(i.attr("data-uk-toggle")))
                    }
                }), setTimeout(function () {
                    i.forEach(function (t) {
                        t.getToggles()
                    })
                }, 0)
            })
        }, init: function () {
            var t = this;
            this.aria = -1 !== this.options.cls.indexOf("uk-hidden"), this.getToggles(), this.on("click", function (i) {
                t.element.is('a[href="#"]') && i.preventDefault(), t.toggle()
            }), i.push(this)
        }, toggle: function () {
            if (this.totoggle.length) {
                if (this.options.animation && t.support.animation) {
                    var i = this, e = this.options.animation.split(",");
                    1 == e.length && (e[1] = e[0]), e[0] = e[0].trim(), e[1] = e[1].trim(), this.totoggle.css("animation-duration", this.options.duration + "ms"), this.totoggle.hasClass(this.options.cls) ? (this.totoggle.toggleClass(this.options.cls), this.totoggle.each(function () {
                        t.Utils.animate(this, e[0]).then(function () {
                            t.$(this).css("animation-duration", ""), t.Utils.checkDisplay(this)
                        })
                    })) : this.totoggle.each(function () {
                        t.Utils.animate(this, e[1] + " uk-animation-reverse").then(function () {
                            t.$(this).toggleClass(i.options.cls).css("animation-duration", ""), t.Utils.checkDisplay(this)
                        }.bind(this))
                    })
                } else this.totoggle.toggleClass(this.options.cls), t.Utils.checkDisplay(this.totoggle);
                this.updateAria()
            }
        }, getToggles: function () {
            this.totoggle = this.options.target ? t.$(this.options.target) : [], this.updateAria()
        }, updateAria: function () {
            this.aria && this.totoggle.length && this.totoggle.each(function () {
                t.$(this).attr("aria-hidden", t.$(this).hasClass("uk-hidden"))
            })
        }
    })
}(UIkit), function (t) {
    "use strict";
    t.component("alert", {
        defaults: {fade: !0, duration: 200, trigger: ".uk-alert-close"}, boot: function () {
            t.$html.on("click.alert.uikit", "[data-uk-alert]", function (i) {
                var e = t.$(this);
                if (!e.data("alert")) {
                    var n = t.alert(e, t.Utils.options(e.attr("data-uk-alert")));
                    t.$(i.target).is(n.options.trigger) && (i.preventDefault(), n.close())
                }
            })
        }, init: function () {
            var t = this;
            this.on("click", this.options.trigger, function (i) {
                i.preventDefault(), t.close()
            })
        }, close: function () {
            var t = this.trigger("close.uk.alert"), i = function () {
                this.trigger("closed.uk.alert").remove()
            }.bind(this);
            this.options.fade ? t.css("overflow", "hidden").css("max-height", t.height()).animate({
                height: 0,
                opacity: 0,
                "padding-top": 0,
                "padding-bottom": 0,
                "margin-top": 0,
                "margin-bottom": 0
            }, this.options.duration, i) : i()
        }
    })
}(UIkit), function (t) {
    "use strict";
    t.component("buttonRadio", {
        defaults: {target: ".uk-button"}, boot: function () {
            t.$html.on("click.buttonradio.uikit", "[data-uk-button-radio]", function (i) {
                var e = t.$(this);
                if (!e.data("buttonRadio")) {
                    var n = t.buttonRadio(e, t.Utils.options(e.attr("data-uk-button-radio"))), o = t.$(i.target);
                    o.is(n.options.target) && o.trigger("click")
                }
            })
        }, init: function () {
            var i = this;
            this.find(i.options.target).attr("aria-checked", "false").filter(".uk-active").attr("aria-checked", "true"), this.on("click", this.options.target, function (e) {
                var n = t.$(this);
                n.is('a[href="#"]') && e.preventDefault(), i.find(i.options.target).not(n).removeClass("uk-active").blur(), n.addClass("uk-active"), i.find(i.options.target).not(n).attr("aria-checked", "false"), n.attr("aria-checked", "true"), i.trigger("change.uk.button", [n])
            })
        }, getSelected: function () {
            return this.find(".uk-active")
        }
    }), t.component("buttonCheckbox", {
        defaults: {target: ".uk-button"}, boot: function () {
            t.$html.on("click.buttoncheckbox.uikit", "[data-uk-button-checkbox]", function (i) {
                var e = t.$(this);
                if (!e.data("buttonCheckbox")) {
                    var n = t.buttonCheckbox(e, t.Utils.options(e.attr("data-uk-button-checkbox"))), o = t.$(i.target);
                    o.is(n.options.target) && o.trigger("click")
                }
            })
        }, init: function () {
            var i = this;
            this.find(i.options.target).attr("aria-checked", "false").filter(".uk-active").attr("aria-checked", "true"), this.on("click", this.options.target, function (e) {
                var n = t.$(this);
                n.is('a[href="#"]') && e.preventDefault(), n.toggleClass("uk-active").blur(), n.attr("aria-checked", n.hasClass("uk-active")), i.trigger("change.uk.button", [n])
            })
        }, getSelected: function () {
            return this.find(".uk-active")
        }
    }), t.component("button", {
        defaults: {}, boot: function () {
            t.$html.on("click.button.uikit", "[data-uk-button]", function () {
                var i = t.$(this);
                if (!i.data("button")) {
                    {
                        t.button(i, t.Utils.options(i.attr("data-uk-button")))
                    }
                    i.trigger("click")
                }
            })
        }, init: function () {
            var t = this;
            this.element.attr("aria-pressed", this.element.hasClass("uk-active")), this.on("click", function (i) {
                t.element.is('a[href="#"]') && i.preventDefault(), t.toggle(), t.trigger("change.uk.button", [t.element.blur().hasClass("uk-active")])
            })
        }, toggle: function () {
            this.element.toggleClass("uk-active"), this.element.attr("aria-pressed", this.element.hasClass("uk-active"))
        }
    })
}(UIkit), function (t) {
    "use strict";
    var i, e = !1;
    t.component("dropdown", {
        defaults: {
            mode: "hover",
            remaintime: 800,
            justify: !1,
            boundary: t.$win,
            delay: 0,
            hoverDelayIdle: 250
        }, remainIdle: !1, boot: function () {
            var i = t.support.touch ? "click" : "mouseenter";
            t.$html.on(i + ".dropdown.uikit", "[data-uk-dropdown]", function (e) {
                var n = t.$(this);
                if (!n.data("dropdown")) {
                    var o = t.dropdown(n, t.Utils.options(n.attr("data-uk-dropdown")));
                    ("click" == i || "mouseenter" == i && "hover" == o.options.mode) && o.element.trigger(i), o.element.find(".uk-dropdown").length && e.preventDefault()
                }
            })
        }, init: function () {
            var n = this;
            this.dropdown = this.find(".uk-dropdown"), this.centered = this.dropdown.hasClass("uk-dropdown-center"), this.justified = this.options.justify ? t.$(this.options.justify) : !1, this.boundary = t.$(this.options.boundary), this.flipped = this.dropdown.hasClass("uk-dropdown-flip"), this.boundary.length || (this.boundary = t.$win), this.element.attr("aria-haspopup", "true"), this.element.attr("aria-expanded", this.element.hasClass("uk-open")), "click" == this.options.mode || t.support.touch ? this.on("click.uikit.dropdown", function (i) {
                var e = t.$(i.target);
                e.parents(".uk-dropdown").length || ((e.is("a[href='#']") || e.parent().is("a[href='#']") || n.dropdown.length && !n.dropdown.is(":visible")) && i.preventDefault(), e.blur()), n.element.hasClass("uk-open") ? (e.is("a:not(.js-uk-prevent)") || e.is(".uk-dropdown-close") || !n.dropdown.find(i.target).length) && n.hide() : n.show()
            }) : this.on("mouseenter", function () {
                n.remainIdle && clearTimeout(n.remainIdle), i && clearTimeout(i), e && e == n || (i = e && e != n ? setTimeout(function () {
                    i = setTimeout(n.show.bind(n), n.options.delay)
                }, n.options.hoverDelayIdle) : setTimeout(n.show.bind(n), n.options.delay))
            }).on("mouseleave", function () {
                i && clearTimeout(i), n.remainIdle = setTimeout(function () {
                    e && e == n && n.hide()
                }, n.options.remaintime)
            }).on("click", function (i) {
                var e = t.$(i.target);
                n.remainIdle && clearTimeout(n.remainIdle), (e.is("a[href='#']") || e.parent().is("a[href='#']")) && i.preventDefault(), n.show()
            })
        }, show: function () {
            t.$html.off("click.outer.dropdown"), e && e != this && e.hide(), i && clearTimeout(i), this.checkDimensions(), this.element.addClass("uk-open"), this.element.attr("aria-expanded", "true"), this.trigger("show.uk.dropdown", [this]), t.Utils.checkDisplay(this.dropdown, !0), e = this, this.registerOuterClick()
        }, hide: function () {
            this.element.removeClass("uk-open"), this.remainIdle && clearTimeout(this.remainIdle), this.remainIdle = !1, this.element.attr("aria-expanded", "false"), this.trigger("hide.uk.dropdown", [this]), e == this && (e = !1)
        }, registerOuterClick: function () {
            var n = this;
            t.$html.off("click.outer.dropdown"), setTimeout(function () {
                t.$html.on("click.outer.dropdown", function (o) {
                    i && clearTimeout(i);
                    var s = t.$(o.target);
                    e != n || !s.is("a:not(.js-uk-prevent)") && !s.is(".uk-dropdown-close") && n.dropdown.find(o.target).length || (n.hide(), t.$html.off("click.outer.dropdown"))
                })
            }, 10)
        }, checkDimensions: function () {
            if (this.dropdown.length) {
                this.justified && this.justified.length && this.dropdown.css("min-width", "");
                var i = this, e = this.dropdown.css("margin-" + t.langdirection, ""), n = e.show().offset(), o = e.outerWidth(), s = this.boundary.width(), a = this.boundary.offset() ? this.boundary.offset().left : 0;
                if (this.centered && (e.css("margin-" + t.langdirection, -1 * (parseFloat(o) / 2 - e.parent().width() / 2)), n = e.offset(), (o + n.left > s || n.left < 0) && (e.css("margin-" + t.langdirection, ""), n = e.offset())), this.justified && this.justified.length) {
                    var r = this.justified.outerWidth();
                    if (e.css("min-width", r), "right" == t.langdirection) {
                        var c = s - (this.justified.offset().left + r), l = s - (e.offset().left + e.outerWidth());
                        e.css("margin-right", c - l)
                    } else e.css("margin-left", this.justified.offset().left - n.left);
                    n = e.offset()
                }
                o + (n.left - a) > s && (e.addClass("uk-dropdown-flip"), n = e.offset()), n.left - a < 0 && (e.addClass("uk-dropdown-stack"), e.hasClass("uk-dropdown-flip") && (this.flipped || (e.removeClass("uk-dropdown-flip"), n = e.offset(), e.addClass("uk-dropdown-flip")), setTimeout(function () {
                    (e.offset().left - a < 0 || !i.flipped && e.outerWidth() + (n.left - a) < s) && e.removeClass("uk-dropdown-flip")
                }, 0)), this.trigger("stack.uk.dropdown", [this])), e.css("display", "")
            }
        }
    })
}(UIkit), function (t) {
    "use strict";
    var i = [];
    t.component("gridMatchHeight", {
        defaults: {target: !1, row: !0}, boot: function () {
            t.ready(function (i) {
                t.$("[data-uk-grid-match]", i).each(function () {
                    var i, e = t.$(this);
                    e.data("gridMatchHeight") || (i = t.gridMatchHeight(e, t.Utils.options(e.attr("data-uk-grid-match"))))
                })
            })
        }, init: function () {
            var e = this;
            this.columns = this.element.children(), this.elements = this.options.target ? this.find(this.options.target) : this.columns, this.columns.length && (t.$win.on("load resize orientationchange", function () {
                var i = function () {
                    e.match()
                };
                return t.$(function () {
                    i()
                }), t.Utils.debounce(i, 50)
            }()), t.$html.on("changed.uk.dom", function () {
                e.columns = e.element.children(), e.elements = e.options.target ? e.find(e.options.target) : e.columns, e.match()
            }), this.on("display.uk.check", function () {
                this.element.is(":visible") && this.match()
            }.bind(this)), i.push(this))
        }, match: function () {
            var i = this.columns.filter(":visible:first");
            if (i.length) {
                var e = Math.ceil(100 * parseFloat(i.css("width")) / parseFloat(i.parent().css("width"))) >= 100;
                return e ? this.revert() : t.Utils.matchHeights(this.elements, this.options), this
            }
        }, revert: function () {
            return this.elements.css("min-height", ""), this
        }
    }), t.component("gridMargin", {
        defaults: {cls: "uk-grid-margin"}, boot: function () {
            t.ready(function (i) {
                t.$("[data-uk-grid-margin]", i).each(function () {
                    var i, e = t.$(this);
                    e.data("gridMargin") || (i = t.gridMargin(e, t.Utils.options(e.attr("data-uk-grid-margin"))))
                })
            })
        }, init: function () {
            t.stackMargin(this.element, this.options)
        }
    }), t.Utils.matchHeights = function (i, e) {
        i = t.$(i).css("min-height", ""), e = t.$.extend({row: !0}, e);
        var n = function (i) {
            if (!(i.length < 2)) {
                var e = 0;
                i.each(function () {
                    e = Math.max(e, t.$(this).outerHeight())
                }).each(function () {
                    var i = t.$(this), n = e - ("border-box" == i.css("box-sizing") ? 0 : i.outerHeight() - i.height());
                    i.css("min-height", n + "px")
                })
            }
        };
        e.row ? (i.first().width(), setTimeout(function () {
            var e = !1, o = [];
            i.each(function () {
                var i = t.$(this), s = i.offset().top;
                s != e && o.length && (n(t.$(o)), o = [], s = i.offset().top), o.push(i), e = s
            }), o.length && n(t.$(o))
        }, 0)) : n(i)
    }
}(UIkit), function (t) {
    "use strict";
    function i(i, e) {
        return e ? ("object" == typeof i ? (i = i instanceof jQuery ? i : t.$(i), i.parent().length && (e.persist = i, e.persist.data("modalPersistParent", i.parent()))) : i = t.$("<div></div>").html("string" == typeof i || "number" == typeof i ? i : "UIkit.modal Error: Unsupported data type: " + typeof i), i.appendTo(e.element.find(".uk-modal-dialog")), e) : void 0
    }

    var e, n = !1, o = t.$html;
    t.component("modal", {
        defaults: {keyboard: !0, bgclose: !0, minScrollHeight: 150, center: !1},
        scrollable: !1,
        transition: !1,
        init: function () {
            if (e || (e = t.$("body")), this.element.length) {
                var i = this;
                this.paddingdir = "padding-" + ("left" == t.langdirection ? "right" : "left"), this.dialog = this.find(".uk-modal-dialog"), this.element.attr("aria-hidden", this.element.hasClass("uk-open")), this.on("click", ".uk-modal-close", function (t) {
                    t.preventDefault(), i.hide()
                }).on("click", function (e) {
                    var n = t.$(e.target);
                    n[0] == i.element[0] && i.options.bgclose && i.hide()
                })
            }
        },
        toggle: function () {
            return this[this.isActive() ? "hide" : "show"]()
        },
        show: function () {
            if (this.element.length) {
                if (!this.isActive())return n && n.hide(!0), this.element.removeClass("uk-open").show(), this.resize(), n = this, this.element.addClass("uk-open"), o.addClass("uk-modal-page").height(), this.element.attr("aria-hidden", "false"), this.element.trigger("show.uk.modal"), t.Utils.checkDisplay(this.dialog, !0), this
            }
        },
        hide: function (i) {
            if (this.isActive()) {
                if (!i && t.support.transition) {
                    var e = this;
                    this.one(t.support.transition.end, function () {
                        e._hide()
                    }).removeClass("uk-open")
                } else this._hide();
                return this
            }
        },
        resize: function () {
            var t = e.width();
            if (this.scrollbarwidth = window.innerWidth - t, e.css(this.paddingdir, this.scrollbarwidth), this.element.css("overflow-y", this.scrollbarwidth ? "scroll" : "auto"), !this.updateScrollable() && this.options.center) {
                var i = this.dialog.outerHeight(), n = parseInt(this.dialog.css("margin-top"), 10) + parseInt(this.dialog.css("margin-bottom"), 10);
                this.dialog.css(i + n < window.innerHeight ? {top: window.innerHeight / 2 - i / 2 - n} : {top: ""})
            }
        },
        updateScrollable: function () {
            var t = this.dialog.find(".uk-overflow-container:visible:first");
            if (t.length) {
                t.css("height", 0);
                var i = Math.abs(parseInt(this.dialog.css("margin-top"), 10)), e = this.dialog.outerHeight(), n = window.innerHeight, o = n - 2 * (20 > i ? 20 : i) - e;
                return t.css("height", o < this.options.minScrollHeight ? "" : o), !0
            }
            return !1
        },
        _hide: function () {
            this.element.hide().removeClass("uk-open"), this.element.attr("aria-hidden", "true"), o.removeClass("uk-modal-page"), e.css(this.paddingdir, ""), n === this && (n = !1), this.trigger("hide.uk.modal")
        },
        isActive: function () {
            return n == this
        }
    }), t.component("modalTrigger", {
        boot: function () {
            t.$html.on("click.modal.uikit", "[data-uk-modal]", function (i) {
                var e = t.$(this);
                if (e.is("a") && i.preventDefault(), !e.data("modalTrigger")) {
                    var n = t.modalTrigger(e, t.Utils.options(e.attr("data-uk-modal")));
                    n.show()
                }
            }), t.$html.on("keydown.modal.uikit", function (t) {
                n && 27 === t.keyCode && n.options.keyboard && (t.preventDefault(), n.hide())
            }), t.$win.on("resize orientationchange", t.Utils.debounce(function () {
                n && n.resize()
            }, 150))
        }, init: function () {
            var i = this;
            this.options = t.$.extend({target: i.element.is("a") ? i.element.attr("href") : !1}, this.options), this.modal = t.modal(this.options.target, this.options), this.on("click", function (t) {
                t.preventDefault(), i.show()
            }), this.proxy(this.modal, "show hide isActive")
        }
    }), t.modal.dialog = function (e, n) {
        var o = t.modal(t.$(t.modal.dialog.template).appendTo("body"), n);
        return o.on("hide.uk.modal", function () {
            o.persist && (o.persist.appendTo(o.persist.data("modalPersistParent")), o.persist = !1), o.element.remove()
        }), i(e, o), o
    }, t.modal.dialog.template = '<div class="uk-modal"><div class="uk-modal-dialog" style="min-height:0;"></div></div>', t.modal.alert = function (i, e) {
        t.modal.dialog(['<div class="uk-margin uk-modal-content">' + String(i) + "</div>", '<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-button-primary uk-modal-close">Ok</button></div>'].join(""), t.$.extend({
            bgclose: !1,
            keyboard: !1
        }, e)).show()
    }, t.modal.confirm = function (i, e, n) {
        e = t.$.isFunction(e) ? e : function () {
        };
        var o = t.modal.dialog(['<div class="uk-margin uk-modal-content">' + String(i) + "</div>", '<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-button-primary js-modal-confirm">Ok</button> <button class="uk-button uk-modal-close">Cancel</button></div>'].join(""), t.$.extend({
            bgclose: !1,
            keyboard: !1
        }, n));
        o.element.find(".js-modal-confirm").on("click", function () {
            e(), o.hide()
        }), o.show()
    }, t.modal.prompt = function (i, e, n, o) {
        n = t.$.isFunction(n) ? n : function () {
        };
        var s = t.modal.dialog([i ? '<div class="uk-modal-content uk-form">' + String(i) + "</div>" : "", '<div class="uk-margin-small-top uk-modal-content uk-form"><p><input type="text" class="uk-width-1-1"></p></div>', '<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-button-primary js-modal-ok">Ok</button> <button class="uk-button uk-modal-close">Cancel</button></div>'].join(""), t.$.extend({
            bgclose: !1,
            keyboard: !1
        }, o)), a = s.element.find("input[type='text']").val(e || "");
        s.element.find(".js-modal-ok").on("click", function () {
            n(a.val()) !== !1 && s.hide()
        }), s.show(), setTimeout(function () {
            a.focus()
        }, 100)
    }, t.modal.blockUI = function (i, e) {
        var n = t.modal.dialog(['<div class="uk-margin uk-modal-content">' + String(i || '<div class="uk-text-center">...</div>') + "</div>"].join(""), t.$.extend({
            bgclose: !1,
            keyboard: !1
        }, e));
        return n.content = n.element.find(".uk-modal-content:first"), n.show(), n
    }
}(UIkit), function (t) {
    "use strict";
    function i(i) {
        var e = t.$(i), n = "auto";
        if (e.is(":visible"))n = e.outerHeight(); else {
            var o = {position: e.css("position"), visibility: e.css("visibility"), display: e.css("display")};
            n = e.css({position: "absolute", visibility: "hidden", display: "block"}).outerHeight(), e.css(o)
        }
        return n
    }

    t.component("nav", {
        defaults: {toggle: ">li.uk-parent > a[href='#']", lists: ">li.uk-parent > ul", multiple: !1},
        boot: function () {
            t.ready(function (i) {
                t.$("[data-uk-nav]", i).each(function () {
                    var i = t.$(this);
                    if (!i.data("nav")) {
                        t.nav(i, t.Utils.options(i.attr("data-uk-nav")))
                    }
                })
            })
        },
        init: function () {
            var i = this;
            this.on("click.uikit.nav", this.options.toggle, function (e) {
                e.preventDefault();
                var n = t.$(this);
                i.open(n.parent()[0] == i.element[0] ? n : n.parent("li"))
            }), this.find(this.options.lists).each(function () {
                var e = t.$(this), n = e.parent(), o = n.hasClass("uk-active");
                e.wrap('<div style="overflow:hidden;height:0;position:relative;"></div>'), n.data("list-container", e.parent()), n.attr("aria-expanded", n.hasClass("uk-open")), o && i.open(n, !0)
            })
        },
        open: function (e, n) {
            var o = this, s = this.element, a = t.$(e);
            this.options.multiple || s.children(".uk-open").not(e).each(function () {
                var i = t.$(this);
                i.data("list-container") && i.data("list-container").stop().animate({height: 0}, function () {
                    t.$(this).parent().removeClass("uk-open")
                })
            }), a.toggleClass("uk-open"), a.attr("aria-expanded", a.hasClass("uk-open")), a.data("list-container") && (n ? (a.data("list-container").stop().height(a.hasClass("uk-open") ? "auto" : 0), this.trigger("display.uk.check")) : a.data("list-container").stop().animate({height: a.hasClass("uk-open") ? i(a.data("list-container").find("ul:first")) : 0}, function () {
                o.trigger("display.uk.check")
            }))
        }
    })
}(UIkit), function (t) {
    "use strict";
    var i = {x: window.scrollX, y: window.scrollY}, e = (t.$win, t.$doc, t.$html), n = {
        show: function (n) {
            if (n = t.$(n), n.length) {
                var o = t.$("body"), s = n.find(".uk-offcanvas-bar:first"), a = "right" == t.langdirection, r = s.hasClass("uk-offcanvas-bar-flip") ? -1 : 1, c = r * (a ? -1 : 1);
                var too = o.find('.tm-toolbar');
                var foo = t.$('#footer');
                i = {
                    x: window.pageXOffset,
                    y: window.pageYOffset
                }, n.addClass("uk-active"), o.css({
                    width: window.innerWidth,
                    height: window.innerHeight
                }).addClass("uk-offcanvas-page"), o.css(a ? "margin-right" : "margin-left", (a ? -1 : 1) * s.outerWidth() * c).width(), e.css("margin-top", -1 * i.y), s.addClass("uk-offcanvas-bar-show"), this._initElement(n), s.trigger("show.uk.offcanvas", [n, s]), n.attr("aria-hidden", "false")

                if(too.length && too.hasClass('tm-navbar-attached') ) {
                    too.css(a ? "margin-right" : "margin-left", (a ? -1 : 1) * s.outerWidth() * c);
                }

                if(foo.length){
                    foo.css(a ? "margin-right" : "margin-left", (a ? -1 : 1) * s.outerWidth() * c);
                }
            }
        }, hide: function (n) {
            var o = t.$("body"), s = t.$(".uk-offcanvas.uk-active"), a = "right" == t.langdirection, r = s.find(".uk-offcanvas-bar:first"), c = function () {
                o.removeClass("uk-offcanvas-page").css({
                    width: "",
                    height: "",
                    "margin-left": "",
                    "margin-right": ""
                }), s.removeClass("uk-active"), r.removeClass("uk-offcanvas-bar-show"), e.css("margin-top", ""), window.scrollTo(i.x, i.y), r.trigger("hide.uk.offcanvas", [s, r]), s.attr("aria-hidden", "true")
            };
            s.length && (t.support.transition && !n ? (o.one(t.support.transition.end, function () {
                c()
            }).css(a ? "margin-right" : "margin-left", ""), setTimeout(function () {
                r.removeClass("uk-offcanvas-bar-show")
            }, 0)) : c());
            var too = o.find('.tm-toolbar');
            if(too.length && too.hasClass('tm-navbar-attached') ) {
                too.css(a ? "margin-right" : "margin-left", 0);
            }
            var foo = t.$('#footer');
            if(foo.length){
                foo.css(a ? "margin-right" : "margin-left", 0);
            }
        }, _initElement: function (i) {
            i.data("OffcanvasInit") || (i.on("click.uk.offcanvas swipeRight.uk.offcanvas swipeLeft.uk.offcanvas", function (i) {
                var e = t.$(i.target);
                if (!i.type.match(/swipe/) && !e.hasClass("uk-offcanvas-close")) {
                    if (e.hasClass("uk-offcanvas-bar"))return;
                    if (e.parents(".uk-offcanvas-bar:first").length)return
                }
                i.stopImmediatePropagation(), n.hide()
            }), i.on("click", "a[href^='#']", function () {
                var i = t.$(this), e = i.attr("href");
                "#" != e && (t.$doc.one("hide.uk.offcanvas", function () {
                    var n;
                    try {
                        n = t.$(e)
                    } catch (o) {
                        n = ""
                    }
                    n.length || (n = t.$('[name="' + e.replace("#", "") + '"]')), n.length && i.attr("data-uk-smooth-scroll") && t.Utils.scrollToElement ? t.Utils.scrollToElement(n, t.Utils.options(i.attr("data-uk-smooth-scroll") || "{}")) : window.location.href = e
                }), n.hide())
            }), i.data("OffcanvasInit", !0))
        }
    };
    t.component("offcanvasTrigger", {
        boot: function () {
            e.on("click.offcanvas.uikit", "[data-uk-offcanvas]", function (i) {
                i.preventDefault();
                var e = t.$(this);
                if (!e.data("offcanvasTrigger")) {
                    {
                        t.offcanvasTrigger(e, t.Utils.options(e.attr("data-uk-offcanvas")))
                    }
                    e.trigger("click")
                }
            }), e.on("keydown.uk.offcanvas", function (t) {
                27 === t.keyCode && n.hide()
            })
        }, init: function () {
            var i = this;
            this.options = t.$.extend({target: i.element.is("a") ? i.element.attr("href") : !1}, this.options), this.on("click", function (t) {
                t.preventDefault(), n.show(i.options.target)
            })
        }
    }), t.offcanvas = n
}(UIkit), function (t) {
    "use strict";
    function i(i, e, n) {
        var o, s = t.$.Deferred(), a = i, r = i;
        return n[0] === e[0] ? (s.resolve(), s.promise()) : ("object" == typeof i && (a = i[0], r = i[1] || i[0]), o = function () {
            e && e.hide().removeClass("uk-active " + r + " uk-animation-reverse"), n.addClass(a).one(t.support.animation.end, function () {
                n.removeClass("" + a).css({opacity: "", display: ""}), s.resolve(), e && e.css({
                    opacity: "",
                    display: ""
                })
            }.bind(this)).show()
        }, n.css("animation-duration", this.options.duration + "ms"), e && e.length ? (e.css("animation-duration", this.options.duration + "ms"), e.css("display", "none").addClass(r + " uk-animation-reverse").one(t.support.animation.end, function () {
            o()
        }.bind(this)).css("display", "")) : (n.addClass("uk-active"), o()), s.promise())
    }

    var e;
    t.component("switcher", {
        defaults: {connect: !1, toggle: ">*", active: 0, animation: !1, duration: 200},
        animating: !1,
        boot: function () {
            t.ready(function (i) {
                t.$("[data-uk-switcher]", i).each(function () {
                    var i = t.$(this);
                    if (!i.data("switcher")) {
                        t.switcher(i, t.Utils.options(i.attr("data-uk-switcher")))
                    }
                })
            })
        },
        init: function () {
            var i = this;
            if (this.on("click.uikit.switcher", this.options.toggle, function (t) {
                    t.preventDefault(), i.show(this)
                }), this.options.connect) {
                this.connect = t.$(this.options.connect), this.connect.find(".uk-active").removeClass(".uk-active"), this.connect.length && (this.connect.children().attr("aria-hidden", "true"), this.connect.on("click", "[data-uk-switcher-item]", function (e) {
                    e.preventDefault();
                    var n = t.$(this).attr("data-uk-switcher-item");
                    if (i.index != n)switch (n) {
                        case"next":
                        case"previous":
                            i.show(i.index + ("next" == n ? 1 : -1));
                            break;
                        default:
                            i.show(parseInt(n, 10))
                    }
                }).on("swipeRight swipeLeft", function (t) {
                    t.preventDefault(), window.getSelection().toString() || i.show(i.index + ("swipeLeft" == t.type ? 1 : -1))
                }));
                var e = this.find(this.options.toggle), n = e.filter(".uk-active");
                if (n.length)this.show(n, !1); else {
                    if (this.options.active === !1)return;
                    n = e.eq(this.options.active), this.show(n.length ? n : e.eq(0), !1)
                }
                e.not(n).attr("aria-expanded", "false"), n.attr("aria-expanded", "true"), this.on("changed.uk.dom", function () {
                    i.connect = t.$(i.options.connect)
                })
            }
        },
        show: function (n, o) {
            if (!this.animating) {
                if (isNaN(n))n = t.$(n); else {
                    var s = this.find(this.options.toggle);
                    n = 0 > n ? s.length - 1 : n, n = s.eq(s[n] ? n : 0)
                }
                var a = this, s = this.find(this.options.toggle), r = t.$(n), c = e[this.options.animation] || function (t, n) {
                        if (!a.options.animation)return e.none.apply(a);
                        var o = a.options.animation.split(",");
                        return 1 == o.length && (o[1] = o[0]), o[0] = o[0].trim(), o[1] = o[1].trim(), i.apply(a, [o, t, n])
                    };
                o !== !1 && t.support.animation || (c = e.none), r.hasClass("uk-disabled") || (s.attr("aria-expanded", "false"), r.attr("aria-expanded", "true"), s.filter(".uk-active").removeClass("uk-active"), r.addClass("uk-active"), this.options.connect && this.connect.length && (this.index = this.find(this.options.toggle).index(r), -1 == this.index && (this.index = 0), this.connect.each(function () {
                    var i = t.$(this), e = t.$(i.children()), n = t.$(e.filter(".uk-active")), o = t.$(e.eq(a.index));
                    a.animating = !0, c.apply(a, [n, o]).then(function () {
                        n.removeClass("uk-active"), o.addClass("uk-active"), n.attr("aria-hidden", "true"), o.attr("aria-hidden", "false"), t.Utils.checkDisplay(o, !0), a.animating = !1
                    })
                })), this.trigger("show.uk.switcher", [r]))
            }
        }
    }), e = {
        none: function () {
            var i = t.$.Deferred();
            return i.resolve(), i.promise()
        }, fade: function (t, e) {
            return i.apply(this, ["uk-animation-fade", t, e])
        }, "slide-bottom": function (t, e) {
            return i.apply(this, ["uk-animation-slide-bottom", t, e])
        }, "slide-top": function (t, e) {
            return i.apply(this, ["uk-animation-slide-top", t, e])
        }, "slide-vertical": function (t, e) {
            var n = ["uk-animation-slide-top", "uk-animation-slide-bottom"];
            return t && t.index() > e.index() && n.reverse(), i.apply(this, [n, t, e])
        }, "slide-left": function (t, e) {
            return i.apply(this, ["uk-animation-slide-left", t, e])
        }, "slide-right": function (t, e) {
            return i.apply(this, ["uk-animation-slide-right", t, e])
        }, "slide-horizontal": function (t, e) {
            var n = ["uk-animation-slide-right", "uk-animation-slide-left"];
            return t && t.index() > e.index() && n.reverse(), i.apply(this, [n, t, e])
        }, scale: function (t, e) {
            return i.apply(this, ["uk-animation-scale-up", t, e])
        }
    }, t.switcher.animations = e
}(UIkit), function (t) {
    "use strict";
    t.component("tab", {
        defaults: {
            target: ">li:not(.uk-tab-responsive, .uk-disabled)",
            connect: !1,
            active: 0,
            animation: !1,
            duration: 200
        }, boot: function () {
            t.ready(function (i) {
                t.$("[data-uk-tab]", i).each(function () {
                    var i = t.$(this);
                    if (!i.data("tab")) {
                        t.tab(i, t.Utils.options(i.attr("data-uk-tab")))
                    }
                })
            })
        }, init: function () {
            var i = this;
            this.current = !1, this.on("click.uikit.tab", this.options.target, function (e) {
                if (e.preventDefault(), !i.switcher || !i.switcher.animating) {
                    var n = i.find(i.options.target).not(this);
                    n.removeClass("uk-active").blur(), i.trigger("change.uk.tab", [t.$(this).addClass("uk-active"), i.current]), i.current = t.$(this), i.options.connect || (n.attr("aria-expanded", "false"), t.$(this).attr("aria-expanded", "true"))
                }
            }), this.options.connect && (this.connect = t.$(this.options.connect)), this.responsivetab = t.$('<li class="uk-tab-responsive uk-active"><a></a></li>').append('<div class="uk-dropdown uk-dropdown-small"><ul class="uk-nav uk-nav-dropdown"></ul><div>'), this.responsivetab.dropdown = this.responsivetab.find(".uk-dropdown"), this.responsivetab.lst = this.responsivetab.dropdown.find("ul"), this.responsivetab.caption = this.responsivetab.find("a:first"), this.element.hasClass("uk-tab-bottom") && this.responsivetab.dropdown.addClass("uk-dropdown-up"), this.responsivetab.lst.on("click.uikit.tab", "a", function (e) {
                e.preventDefault(), e.stopPropagation();
                var n = t.$(this);
                i.element.children("li:not(.uk-tab-responsive)").eq(n.data("index")).trigger("click")
            }), this.on("show.uk.switcher change.uk.tab", function (t, e) {
                i.responsivetab.caption.html(e.text())
            }), this.element.append(this.responsivetab), this.options.connect && (this.switcher = t.switcher(this.element, {
                toggle: ">li:not(.uk-tab-responsive)",
                connect: this.options.connect,
                active: this.options.active,
                animation: this.options.animation,
                duration: this.options.duration
            })), t.dropdown(this.responsivetab, {mode: "click"}), i.trigger("change.uk.tab", [this.element.find(this.options.target).filter(".uk-active")]), this.check(), t.$win.on("resize orientationchange", t.Utils.debounce(function () {
                i.element.is(":visible") && i.check()
            }, 100)), this.on("display.uk.check", function () {
                i.element.is(":visible") && i.check()
            })
        }, check: function () {
            var i = this.element.children("li:not(.uk-tab-responsive)").removeClass("uk-hidden");
            if (i.length) {
                var e, n, o = i.eq(0).offset().top + Math.ceil(i.eq(0).height() / 2), s = !1;
                if (this.responsivetab.lst.empty(), i.each(function () {
                        t.$(this).offset().top > o && (s = !0)
                    }), s)for (var a = 0; a < i.length; a++)e = t.$(i.eq(a)), n = e.find("a"), "none" == e.css("float") || e.attr("uk-dropdown") || (e.addClass("uk-hidden"), e.hasClass("uk-disabled") || this.responsivetab.lst.append('<li><a href="' + n.attr("href") + '" data-index="' + a + '">' + n.html() + "</a></li>"));
                this.responsivetab[this.responsivetab.lst.children("li").length ? "removeClass" : "addClass"]("uk-hidden")
            }
        }
    })
}(UIkit), function (t) {
    "use strict";
    t.component("cover", {
        defaults: {automute: !0}, boot: function () {
            t.ready(function (i) {
                t.$("[data-uk-cover]", i).each(function () {
                    var i = t.$(this);
                    if (!i.data("cover")) {
                        t.cover(i, t.Utils.options(i.attr("data-uk-cover")))
                    }
                })
            })
        }, init: function () {
            if (this.parent = this.element.parent(), t.$win.on("load resize orientationchange", t.Utils.debounce(function () {
                    this.check()
                }.bind(this), 100)), this.on("display.uk.check", function () {
                    this.element.is(":visible") && this.check()
                }.bind(this)), this.check(), this.element.is("iframe") && this.options.automute) {
                var i = this.element.attr("src");
                this.element.attr("src", "").on("load", function () {
                    this.contentWindow.postMessage('{ "event": "command", "func": "mute", "method":"setVolume", "value":0}', "*")
                }).attr("src", [i, i.indexOf("?") > -1 ? "&" : "?", "enablejsapi=1&api=1"].join(""))
            }
        }, check: function () {
            this.element.css({width: "", height: ""}), this.dimension = {
                w: this.element.width(),
                h: this.element.height()
            }, this.element.attr("width") && !isNaN(this.element.attr("width")) && (this.dimension.w = this.element.attr("width")), this.element.attr("height") && !isNaN(this.element.attr("height")) && (this.dimension.h = this.element.attr("height")), this.ratio = this.dimension.w / this.dimension.h;
            var t, i, e = this.parent.width(), n = this.parent.height();
            e / this.ratio < n ? (t = Math.ceil(n * this.ratio), i = n) : (t = e, i = Math.ceil(e / this.ratio)), this.element.css({
                width: t,
                height: i
            })
        }
    })
}(UIkit);