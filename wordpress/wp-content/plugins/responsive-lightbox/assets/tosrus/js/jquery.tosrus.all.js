! function(t) {
    function i() {
        n = function(t) {
            return e + "-" + t
        }, o = function(t) {
            return e + "-" + t
        }, a = function(t) {
            return t + "." + e
        }, t.each([n, o, a], function(t, i) {
            i.add = function(t) {
                t = t.split(" ");
                for (var s in t) i[t[s]] = i(t[s])
            }
        }), n.add("touch desktop scale-1 scale-2 scale-3 wrapper opened opening fixed inline hover slider slide loading noanimation fastanimation"), o.add("slide anchor"), a.add("open opening close closing prev next slideTo sliding click pinch scroll resize orientationchange load loading loaded transitionend webkitTransitionEnd"), r = {
            complObject: function(i, s) {
                return t.isPlainObject(i) || (i = s), i
            },
            complBoolean: function(t, i) {
                return "boolean" != typeof t && (t = i), t
            },
            complNumber: function(i, s) {
                return t.isNumeric(i) || (i = s), i
            },
            complString: function(t, i) {
                return "string" != typeof t && (t = i), t
            },
            isPercentage: function(t) {
                return "string" == typeof t && "%" == t.slice(-1)
            },
            getPercentage: function(t) {
                return parseInt(t.slice(0, -1))
            },
            resizeRatio: function(t, i, s, e, n) {
                if (i.is(":visible")) {
                    var o = i.width(),
                        a = i.height();
                    s && o > s && (o = s), e && a > e && (a = e), n > o / a ? a = o / n : o = a * n, t.width(o).height(a)
                }
            },
            transitionend: function(t, i, s) {
                var e = !1,
                    n = function() {
                        e || i.call(t[0]), e = !0
                    };
                t.one(a.transitionend, n), t.one(a.webkitTransitionEnd, n), setTimeout(n, 1.1 * s)
            },
            setViewportScale: function() {
                if (d.viewportScale) {
                    var t = d.viewportScale.getScale();
                    void 0 !== t && (t = 1 / t, d.$body.removeClass(n["scale-1"]).removeClass(n["scale-2"]).removeClass(n["scale-3"]).addClass(n["scale-" + Math.max(Math.min(Math.round(t), 3), 1)]))
                }
            }
        }, (d = {
            $wndw: t(window),
            $html: t("html"),
            $body: t("body"),
            scrollPosition: 0,
            viewportScale: null,
            viewportScaleInterval: null
        }).$body.addClass(t[s].support.touch ? n.touch : n.desktop), d.$wndw.on(a.scroll, function(t) {
            d.$body.hasClass(n.opened) && (window.scrollTo(0, d.scrollPosition), t.preventDefault(), t.stopPropagation(), t.stopImmediatePropagation())
        }), !d.viewportScale && t[s].support.touch && "undefined" != typeof FlameViewportScale && (d.viewportScale = new FlameViewportScale, r.setViewportScale(), d.$wndw.on(a.orientationchange + " " + a.resize, function(t) {
            d.viewportScaleInterval && (clearTimeout(d.viewportScaleInterval), d.viewportScaleInterval = null), d.viewportScaleInterval = setTimeout(function() {
                r.setViewportScale()
            }, 500)
        })), t[s]._c = n, t[s]._d = o, t[s]._e = a, t[s]._f = r, t[s]._g = d
    }
    var s = "tosrus",
        e = "tos";
    if (!t[s]) {
        var n = {},
            o = {},
            a = {},
            r = {},
            d = {};
        t[s] = function(t, i, s) {
            return this.$node = t, this.opts = i, this.conf = s, this.vars = {}, this.nodes = {}, this.slides = {}, this._init(), this
        }, t[s].prototype = {
            _init: function() {
                var i = this;
                this._complementOptions(), this.vars.fixed = "window" == this.opts.wrapper.target, this.nodes.$wrpr = t('<div class="' + n.wrapper + '" />'), this.nodes.$sldr = t('<div class="' + n.slider + '" />').appendTo(this.nodes.$wrpr), this.nodes.$wrpr.addClass(this.vars.fixed ? n.fixed : n.inline).addClass(n("fx-" + this.opts.effect)).addClass(n(this.opts.slides.scale)).addClass(this.opts.wrapper.classes), this.nodes.$wrpr.on(a.open + " " + a.close + " " + a.prev + " " + a.next + " " + a.slideTo, function(t) {
                    var s = (t = (arguments = Array.prototype.slice.call(arguments)).shift()).type;
                    t.stopPropagation(), "function" == typeof i[s] && i[s].apply(i, arguments)
                }).on(a.opening + " " + a.closing + " " + a.sliding + " " + a.loading + " " + a.loaded, function(t) {
                    t.stopPropagation()
                }).on(a.click, function(s) {
                    switch (s.stopPropagation(), i.opts.wrapper.onClick) {
                        case "toggleUI":
                            i.nodes.$wrpr.toggleClass(n.hover);
                            break;
                        case "close":
                            t(s.target).is("img") || i.close()
                    }
                }), this.nodes.$anchors = this._initAnchors(), this.nodes.$slides = this._initSlides(), this.slides.total = this.nodes.$slides.length, this.slides.visible = this.opts.slides.visible, this.slides.index = 0, this.vars.opened = !0;
                for (var e = 0; e < t[s].addons.length; e++) t.isFunction(this["_addon_" + t[s].addons[e]]) && this["_addon_" + t[s].addons[e]]();
                for (var o = 0; o < t[s].ui.length; o++) this.nodes.$wrpr.find("." + n[t[s].ui[o]]).length && this.nodes.$wrpr.addClass(n("has-" + t[s].ui[o]));
                "close" == this.opts.wrapper.onClick && (this.nodes.$uibg || t().add(this.nodes.$capt || t()).add(this.nodes.$pagr || t()).on(a.click, function(t) {
                    t.stopPropagation()
                })), this.vars.fixed ? (this.nodes.$wrpr.appendTo(d.$body), this.close(!0)) : (this.nodes.$wrpr.appendTo(this.opts.wrapper.target), this.opts.show ? (this.vars.opened = !1, this.open(0, !0)) : this.close(!0))
            },
            open: function(i, s) {
                var e = this;
                this.vars.opened || (this.vars.fixed && (d.scrollPosition = d.$wndw.scrollTop(), d.$body.addClass(n.opened), r.setViewportScale()), s ? this.nodes.$wrpr.addClass(n.opening).trigger(a.opening, [i, s]) : setTimeout(function() {
                    e.nodes.$wrpr.addClass(n.opening).trigger(a.opening, [i, s])
                }, 5), this.nodes.$wrpr.addClass(n.hover).addClass(n.opened)), this.vars.opened = !0, this._loadContents(), t.isNumeric(i) && (s = s || !this.vars.opened, this.slideTo(i, s))
            },
            close: function(i) {
                this.vars.opened && (this.vars.fixed && d.$body.removeClass(n.opened), i ? this.nodes.$wrpr.removeClass(n.opened) : r.transitionend(this.nodes.$wrpr, function() {
                    t(this).removeClass(n.opened)
                }, this.conf.transitionDuration), this.nodes.$wrpr.removeClass(n.hover).removeClass(n.opening).trigger(a.closing, [this.slides.index, i])), this.vars.opened = !1
            },
            prev: function(i, s) {
                t.isNumeric(i) || (i = this.opts.slides.slide), this.slideTo(this.slides.index - i, s)
            },
            next: function(i, s) {
                t.isNumeric(i) || (i = this.opts.slides.slide), this.slideTo(this.slides.index + i, s)
            },
            slideTo: function(i, e) {
                if (!this.vars.opened) return !1;
                if (!t.isNumeric(i)) return !1;
                var o = !0;
                if (0 > i) {
                    var d = 0 == this.slides.index;
                    this.opts.infinite ? i = d ? this.slides.total - this.slides.visible : 0 : (i = 0, d && (o = !1))
                }
                if (i + this.slides.visible > this.slides.total) {
                    var l = this.slides.index + this.slides.visible >= this.slides.total;
                    this.opts.infinite ? i = l ? 0 : this.slides.total - this.slides.visible : (i = this.slides.total - this.slides.visible, l && (o = !1))
                }
                if (this.slides.index = i, this._loadContents(), o) {
                    var p = 0 - this.slides.index * this.opts.slides.width + this.opts.slides.offset;
                    this.slides.widthPercentage && (p += "%"), e && (this.nodes.$sldr.addClass(n.noanimation), r.transitionend(this.nodes.$sldr, function() {
                        t(this).removeClass(n.noanimation)
                    }, 5));
                    for (var c in t[s].effects)
                        if (c == this.opts.effect) {
                            t[s].effects[c].call(this, p, e);
                            break
                        }
                    this.nodes.$wrpr.trigger(a.sliding, [i, e])
                }
            },
            _initAnchors: function() {
                var i = this,
                    e = t();
                if (this.$node.is("a"))
                    for (var n in t[s].media) e = e.add(this.$node.filter(function() {
                        if (i.opts.media[n] && i.opts.media[n].filterAnchors) {
                            var e = i.opts.media[n].filterAnchors.call(i, t(this));
                            if ("boolean" == typeof e) return e
                        }
                        return t[s].media[n].filterAnchors.call(i, t(this))
                    }));
                return e
            },
            _initSlides: function() {
                return this[this.$node.is("a") ? "_initSlidesFromAnchors" : "_initSlidesFromContent"](), this.nodes.$sldr.children().css("width", this.opts.slides.width + (this.slides.widthPercentage ? "%" : "px"))
            },
            _initSlidesFromAnchors: function() {
                var i = this;
                this.nodes.$anchors.each(function(s) {
                    var e = t(this),
                        r = t('<div class="' + n.slide + " " + n.loading + '" />').data(o.anchor, e).appendTo(i.nodes.$sldr);
                    e.data(o.slide, r).on(a.click, function(t) {
                        t.preventDefault(), i.open(s)
                    })
                })
            },
            _initSlidesFromContent: function() {
                var i = this;
                this.$node.children().each(function() {
                    var e = t(this);
                    t('<div class="' + n.slide + '" />').append(e).appendTo(i.nodes.$sldr);
                    for (var o in t[s].media) {
                        var a = null;
                        if (i.opts.media[o] && i.opts.media[o].filterSlides && (a = i.opts.media[o].filterSlides.call(i, e)), "boolean" != typeof a && (a = t[s].media[o].filterSlides.call(i, e)), a) {
                            t[s].media[o].initSlides.call(i, e), e.parent().addClass(n(o));
                            break
                        }
                    }
                })
            },
            _loadContents: function() {
                var t = this;
                switch (this.opts.slides.load) {
                    case "all":
                        this._loadContent(0, this.slides.total);
                        break;
                    case "visible":
                        this._loadContent(this.slides.index, this.slides.index + this.slides.visible);
                        break;
                    case "near-visible":
                    default:
                        this._loadContent(this.slides.index, this.slides.index + this.slides.visible), setTimeout(function() {
                            t._loadContent(t.slides.index - t.slides.visible, t.slides.index), t._loadContent(t.slides.index + t.slides.visible, t.slides.index + 2 * t.slides.visible)
                        }, this.conf.transitionDuration)
                }
            },
            _loadContent: function(i, e) {
                var r = this;
                this.nodes.$slides.slice(i, e).each(function() {
                    var i = t(this);
                    if (0 == i.children().length) {
                        var e = i.data(o.anchor),
                            d = e.attr("href");
                        for (var l in t[s].media) {
                            var p = null;
                            if (r.opts.media[l] && r.opts.media[l].filterAnchors && (p = r.opts.media[l].filterAnchors.call(r, e)), "boolean" != typeof p && (p = t[s].media[l].filterAnchors.call(r, e)), p) {
                                t[s].media[l].initAnchors.call(r, i, d), i.addClass(n(l));
                                break
                            }
                        }
                        i.trigger(a.loading, [i.data(o.anchor)])
                    }
                })
            },
            _complementOptions: function() {
                if (void 0 === this.opts.wrapper.target && (this.opts.wrapper.target = this.$node.is("a") ? "window" : this.$node), "window" != this.opts.wrapper.target && "string" == typeof this.opts.wrapper.target && (this.opts.wrapper.target = t(this.opts.wrapper.target)), this.opts.show = r.complBoolean(this.opts.show, "window" != this.opts.wrapper.target), t.isNumeric(this.opts.slides.width)) this.slides.widthPercentage = !1, this.opts.slides.visible = r.complNumber(this.opts.slides.visible, 1);
                else {
                    var i = !!r.isPercentage(this.opts.slides.width) && r.getPercentage(this.opts.slides.width);
                    this.slides.widthPercentage = !0, this.opts.slides.visible = r.complNumber(this.opts.slides.visible, i ? Math.floor(100 / i) : 1), this.opts.slides.width = i || Math.ceil(1e4 / this.opts.slides.visible) / 100
                }
                this.opts.slides.slide = r.complNumber(this.opts.slides.slide, this.opts.slides.visible), this.opts.slides.offset = r.isPercentage(this.opts.slides.offset) ? r.getPercentage(this.opts.slides.offset) : r.complNumber(this.opts.slides.offset, 0)
            },
            _uniqueID: function() {
                return this.__uniqueID || (this.__uniqueID = 0), this.__uniqueID++, n("uid-" + this.__uniqueID)
            }
        }, t.fn[s] = function(e, n, o, a) {
            d.$wndw || i(), e = t.extend(!0, {}, t[s].defaults, e), e = t.extend(!0, {}, e, t[s].support.touch ? o : n), a = t.extend(!0, {}, t[s].configuration, a);
            var r = new t[s](this, e, a);
            return this.data(s, r), r.nodes.$wrpr
        }, t[s].support = {
            touch: "ontouchstart" in window.document || navigator.msMaxTouchPoints
        }, t[s].defaults = {
            infinite: !1,
            effect: "slide",
            wrapper: {
                classes: "",
                onClick: "toggleUI"
            },
            slides: {
                offset: 0,
                scale: "fit",
                load: "near-visible",
                visible: 1
            },
            media: {}
        }, t[s].configuration = {
            transitionDuration: 400
        }, t[s].constants = {}, t[s].debug = function(t) {}, t[s].deprecated = function(t, i) {
            "undefined" != typeof console && void 0 !== console.warn && console.warn(s + ": " + t + " is deprecated, use " + i + " instead.")
        }, t[s].effects = {
            slide: function(t) {
                this.nodes.$sldr.css("left", t)
            },
            fade: function(i) {
                r.transitionend(this.nodes.$sldr, function() {
                    t(this).css("left", i).css("opacity", 1)
                }, this.conf.transitionDuration), this.nodes.$sldr.css("opacity", 0)
            }
        }, t[s].version = "2.5.0", t[s].media = {}, t[s].addons = [], t[s].ui = []
    }
}(jQuery),
function(t) {
    var i, s, e, n, o, a = "tosrus",
        r = "autoplay",
        d = !1;
    t[a].prototype["_addon_" + r] = function() {
        d || (i = t[a]._c, s = t[a]._d, e = t[a]._e, n = t[a]._f, o = t[a]._g, e.add("mouseover mouseout"), d = !0);
        var l = this,
            p = this.opts[r];
        p.play && (this.opts.infinite = !0, this.nodes.$wrpr.on(e.sliding, function(t) {
            l.autoplay()
        }), p.pauseOnHover && this.nodes.$wrpr.on(e.mouseover, function(t) {
            l.autostop()
        }).on(e.mouseout, function(t) {
            l.autoplay()
        }), this.autoplay())
    }, t[a].prototype.autoplay = function() {
        var t = this;
        this.autostop(), this.vars.autoplay = setTimeout(function() {
            t.next()
        }, this.opts[r].timeout)
    }, t[a].prototype.autostop = function() {
        this.vars.autoplay && clearTimeout(this.vars.autoplay)
    }, t[a].defaults[r] = {
        play: !1,
        timeout: 4e3,
        pauseOnHover: !1
    }, t[a].addons.push(r)
}(jQuery),
function(t) {
    function i(i, s) {
        return t('<a class="' + e[i] + s + '" href="#"><span></span></a>')
    }

    function s(t, i, s, e) {
        i.on(o.click, function(i) {
            i.preventDefault(), i.stopPropagation(), t.trigger(o[s], [e])
        })
    }
    var e, n, o, a, r, d = "tosrus",
        l = "buttons",
        p = !1;
    t[d].prototype["_addon_" + l] = function() {
        p || (e = t[d]._c, n = t[d]._d, o = t[d]._e, a = t[d]._f, r = t[d]._g, e.add("prev next close disabled"), p = !0);
        var c = this,
            h = this.opts[l];
        this.nodes.$prev = null, this.nodes.$next = null, this.nodes.$clse = null, ("boolean" == typeof h || "string" == typeof h && "inline" == h) && (h = {
            prev: h,
            next: h
        }), void 0 === h.close && (h.close = this.vars.fixed), this.nodes.$slides.length < 2 && (h.prev = !1, h.next = !1), t.each({
            prev: "prev",
            next: "next",
            close: "clse"
        }, function(n, a) {
            h[n] && ("string" == typeof h[n] && "inline" == h[n] ? c.vars.fixed && "close" != n && c.nodes.$slides.on(o.loading, function(o, a) {
                var r = i(n, " " + e.inline)["prev" == n ? "prependTo" : "appendTo"](this);
                s(c.nodes.$wrpr, r, n, 1), c.opts.infinite || ("prev" == n && t(this).is(":first-child") || "next" == n && t(this).is(":last-child")) && r.addClass(e.disabled)
            }) : ("string" == typeof h[n] && (h[n] = t(h[n])), c.nodes["$" + a] = h[n] instanceof t ? h[n] : i(n, "").appendTo(c.nodes.$wrpr), s(c.nodes.$wrpr, c.nodes["$" + a], n, null)))
        }), this.opts.infinite || (this.updateButtons(), this.nodes.$wrpr.on(o.sliding, function(t, i, s) {
            c.updateButtons()
        }))
    }, t[d].prototype.updateButtons = function() {
        this.nodes.$prev && this.nodes.$prev[(this.slides.index < 1 ? "add" : "remove") + "Class"](e.disabled), this.nodes.$next && this.nodes.$next[(this.slides.index >= this.slides.total - this.slides.visible ? "add" : "remove") + "Class"](e.disabled)
    }, t[d].defaults[l] = {
        prev: !t[d].support.touch,
        next: !t[d].support.touch
    }, t[d].addons.push(l), t[d].ui.push("prev"), t[d].ui.push("next"), t[d].ui.push("close")
}(jQuery),
function(t) {
    var i, s, e, n, o, a = "tosrus",
        r = "caption",
        d = !1;
    t[a].prototype["_addon_" + r] = function() {
        d || (i = t[a]._c, s = t[a]._d, e = t[a]._e, n = t[a]._f, o = t[a]._g, i.add("caption uibg"), s.add("caption"), d = !0);
        var l = this,
            p = this.opts[r];
        if (p.add) {
            p.attributes = p.attributes || [], "string" == typeof p.target && (p.target = t(p.target)), p.target instanceof t ? this.nodes.$capt = p.target : (this.nodes.$capt = t('<div class="' + i.caption + '" />').appendTo(this.nodes.$wrpr), this.nodes.$uibg || (this.nodes.$uibg = t('<div class="' + i.uibg + '" />').prependTo(this.nodes.$wrpr)));
            for (var c = 0, h = this.slides.visible; h > c; c++) t('<div class="' + i.caption + "-" + c + '" />').css("width", this.opts.slides.width + (this.slides.widthPercentage ? "%" : "px")).appendTo(this.nodes.$capt);
            this.nodes.$slides.each(function(i) {
                var e = t(this),
                    n = l.vars.fixed ? e.data(s.anchor) : e.children();
                e.data(s.caption, "");
                for (var o = 0, a = p.attributes.length; a > o; o++) {
                    var r = n.attr(p.attributes[o]);
                    if (r && r.length) {
                        e.data(s.caption, r);
                        break
                    }
                }
            }), this.nodes.$wrpr.on(e.sliding, function(t, i, e) {
                for (var n = 0, o = l.slides.visible; o > n; n++) l.nodes.$capt.children().eq(n).html(l.nodes.$sldr.children().eq(l.slides.index + n).data(s.caption) || "")
            })
        }
    }, t[a].defaults[r] = {
        add: !1,
        target: null,
        attributes: ["title", "alt", "rel"]
    }, t[a].addons.push(r), t[a].ui.push("caption")
}(jQuery),
function(t) {
    if ("function" == typeof Hammer) {
        var i, s, e, n, o, a = "tosrus",
            r = "drag",
            d = !1;
        t[a].prototype["_addon_" + r] = function() {
            d || (i = t[a]._c, s = t[a]._d, e = t[a]._e, n = t[a]._f, o = t[a]._g, d = !0);
            var l = this;
            if (this.opts[r] && "slide" == this.opts.effect) {
                if (Hammer.VERSION < 2) return void t[a].deprecated("Older version of the Hammer library", "version 2 or newer");
                if (this.nodes.$slides.length > 1) {
                    var p = 0,
                        c = !1,
                        h = !1;
                    new Hammer(this.nodes.$wrpr[0]).on("panstart panleft panright panend swipeleft swiperight", function(t) {
                        t.preventDefault()
                    }).on("panstart", function(t) {
                        l.nodes.$sldr.addClass(i.noanimation)
                    }).on("panleft panright", function(t) {
                        switch (p = t.deltaX, h = !1, t.direction) {
                            case 2:
                                c = "left";
                                break;
                            case 4:
                                c = "right";
                                break;
                            default:
                                c = !1
                        }("left" == c && l.slides.index + l.slides.visible >= l.slides.total || "right" == c && 0 == l.slides.index) && (p /= 2.5), l.nodes.$sldr.css("margin-left", Math.round(p))
                    }).on("swipeleft swiperight", function(t) {
                        h = !0
                    }).on("panend", function(t) {
                        if (l.nodes.$sldr.removeClass(i.noanimation).addClass(i.fastanimation), n.transitionend(l.nodes.$sldr, function() {
                                l.nodes.$sldr.removeClass(i.fastanimation)
                            }, l.conf.transitionDuration / 2), l.nodes.$sldr.css("margin-left", 0), "left" == c || "right" == c) {
                            if (h) o = l.slides.visible;
                            else var s = l.nodes.$slides.first().width(),
                                o = Math.floor((Math.abs(p) + s / 2) / s);
                            o > 0 && l.nodes.$wrpr.trigger(e["left" == c ? "next" : "prev"], [o])
                        }
                        c = !1
                    })
                }
            }
        }, t[a].defaults[r] = t[a].support.touch, t[a].addons.push(r)
    }
}(jQuery),
function(t) {
    var i, s, e, n, o, a = "tosrus",
        r = "keys",
        d = !1;
    t[a].prototype["_addon_" + r] = function() {
        d || (i = t[a]._c, s = t[a]._d, e = t[a]._e, n = t[a]._f, o = t[a]._g, e.add("keyup"), d = !0);
        var l = this,
            p = this.opts[r];
        if ("boolean" == typeof p && p && (p = {
                prev: !0,
                next: !0,
                close: !0
            }), t.isPlainObject(p)) {
            for (var c in t[a].constants[r]) "boolean" == typeof p[c] && p[c] && (p[c] = t[a].constants[r][c]);
            this.nodes.$slides.length < 2 && (p.prev = !1, p.next = !1), t(document).on(e.keyup, function(t) {
                if (l.vars.opened) {
                    var i = !1;
                    switch (t.keyCode) {
                        case p.prev:
                            i = e.prev;
                            break;
                        case p.next:
                            i = e.next;
                            break;
                        case p.close:
                            i = e.close
                    }
                    i && (t.preventDefault(), t.stopPropagation(), l.nodes.$wrpr.trigger(i))
                }
            })
        }
    }, t[a].defaults[r] = !1, t[a].constants[r] = {
        prev: 37,
        next: 39,
        close: 27
    }, t[a].addons.push(r)
}(jQuery),
function(t) {
    var i, s, e, n, o, a = "tosrus",
        r = "pagination",
        d = !1;
    t[a].prototype["_addon_" + r] = function() {
        d || (i = t[a]._c, s = t[a]._d, e = t[a]._e, n = t[a]._f, o = t[a]._g, i.add("pagination selected uibg bullets thumbnails"), d = !0);
        var l = this,
            p = this.opts[r];
        if (this.nodes.$slides.length < 2 && (p.add = !1), p.add) {
            if ("string" == typeof p.target && (p.target = t(p.target)), p.target instanceof t ? this.nodes.$pagr = p.target : (this.nodes.$pagr = t('<div class="' + i.pagination + " " + i[p.type] + '" />').appendTo(this.nodes.$wrpr), this.nodes.$uibg || (this.nodes.$uibg = t('<div class="' + i.uibg + '" />').prependTo(this.nodes.$wrpr))), "function" != typeof p.anchorBuilder) switch (p.type) {
                case "thumbnails":
                    var c = '<a href="#" style="background-image: url(\'',
                        h = "');\"></a>";
                    this.vars.fixed ? p.anchorBuilder = function(i) {
                        return c + t(this).data(s.anchor).attr("href") + h
                    } : p.anchorBuilder = function(i) {
                        return c + t(this).find("img").attr("src") + h
                    };
                    break;
                case "bullets":
                default:
                    p.anchorBuilder = function(t) {
                        return '<a href="#"></a>'
                    }
            }
            this.nodes.$slides.each(function(i) {
                t(p.anchorBuilder.call(this, i + 1)).appendTo(l.nodes.$pagr).on(e.click, function(t) {
                    t.preventDefault(), t.stopPropagation(), l.nodes.$wrpr.trigger(e.slideTo, [i])
                })
            }), this.updatePagination(), this.nodes.$wrpr.on(e.sliding, function(t, i, s) {
                l.updatePagination()
            })
        }
    }, t[a].prototype.updatePagination = function() {
        this.nodes.$pagr && this.nodes.$pagr.children().removeClass(i.selected).eq(this.slides.index).addClass(i.selected)
    }, t[a].defaults[r] = {
        add: !1,
        type: "bullets",
        target: null,
        anchorBuilder: null
    }, t[a].addons.push(r), t[a].ui.push("pagination"), t[a].ui.push("bullets"), t[a].ui.push("thumbnails")
}(jQuery),
function(t) {
    var i = "tosrus",
        s = "html";
    t[i].media[s] = {
        filterAnchors: function(i) {
            var s = i.attr("href");
            return "#" == s.slice(0, 1) && t(s).is("div")
        },
        initAnchors: function(s, e) {
            t('<div class="' + t[i]._c("html") + '" />').append(t(e)).appendTo(s), s.removeClass(t[i]._c.loading).trigger(t[i]._e.loaded)
        },
        filterSlides: function(t) {
            return t.is("div")
        },
        initSlides: function(t) {}
    }, t[i].defaults.media[s] = {}
}(jQuery),
function(t) {
    var i = "tosrus",
        s = "image";
    t[i].media[s] = {
        filterAnchors: function(i) {
            return t.inArray(i.attr("href").toLowerCase().split(".").pop().split("?")[0], ["jpg", "jpe", "jpeg", "gif", "png"]) > -1
        },
        initAnchors: function(s, e) {
            t('<img border="0" />').on(t[i]._e.load, function(e) {
                e.stopPropagation(), s.removeClass(t[i]._c.loading).trigger(t[i]._e.loaded)
            }).appendTo(s).attr("src", e)
        },
        filterSlides: function(t) {
            return t.is("img")
        },
        initSlides: function(t) {}
    }, t[i].defaults.media[s] = {}
}(jQuery),
function(t) {
    function i(i) {
        function p() {
            c.length && (c.attr("src", ""), c.attr("src", u))
        }
        l || (s = t[r]._c, e = t[r]._d, n = t[r]._e, o = t[r]._f, a = t[r]._g, e.add("ratio maxWidth maxHeight"), l = !0);
        var c = i.children(),
            h = i.data(t[r]._d.anchor) || t(),
            u = c.attr("src"),
            f = h.data(e.ratio) || this.opts[d].ratio,
            v = h.data(e.maxWidth) || this.opts[d].maxWidth,
            g = h.data(e.maxHeight) || this.opts[d].maxHeight;
        i.removeClass(s.loading).trigger(n.loaded).on(n.loading, function(t) {
            o.resizeRatio(c, i, v, g, f)
        }), this.nodes.$wrpr.on(n.sliding, function(t) {
            p()
        }).on(n.opening, function(t) {
            o.resizeRatio(c, i, v, g, f)
        }).on(n.closing, function(t) {
            p()
        }), a.$wndw.on(n.resize, function(t) {
            o.resizeRatio(c, i, v, g, f)
        })
    }
    var s, e, n, o, a, r = "tosrus",
        d = "vimeo",
        l = !1;
    t[r].media[d] = {
        filterAnchors: function(t) {
            return t.attr("href").toLowerCase().indexOf("vimeo.com/") > -1
        },
        initAnchors: function(s, e) {
            var n = this._uniqueID();
            e = e.split("vimeo.com/")[1].split("?")[0] + "?api=1&player_id=" + n, t('<iframe id="' + n + '" src="http://player.vimeo.com/video/' + e + '" frameborder="0" allowfullscreen />').appendTo(s), i.call(this, s)
        },
        filterSlides: function(t) {
            return !(!t.is("iframe") || !t.attr("src")) && t.attr("src").toLowerCase().indexOf("vimeo.com/video/") > -1
        },
        initSlides: function(t) {
            i.call(this, t)
        }
    }, t[r].defaults.media[d] = {}, t[r].defaults[d] = {
        ratio: 16 / 9,
        maxWidth: !1,
        maxHeight: !1
    }
}(jQuery),
function(t) {
    function i(i) {
        function p(t) {
            c.length && c[0].contentWindow.postMessage('{ "event": "command", "func": "' + t + 'Video" }', "*")
        }
        l || (s = t[r]._c, e = t[r]._d, n = t[r]._e, o = t[r]._f, a = t[r]._g, e.add("ratio maxWidth maxHeight"), l = !0);
        var c = i.children(),
            h = i.data(t[r]._d.anchor) || t(),
            u = h.data(e.ratio) || this.opts[d].ratio,
            f = h.data(e.maxWidth) || this.opts[d].maxWidth,
            v = h.data(e.maxHeight) || this.opts[d].maxHeight;
        i.removeClass(s.loading).trigger(n.loaded).on(n.loading, function(t) {
            o.resizeRatio(c, i, f, v, u)
        }), this.nodes.$wrpr.on(n.sliding, function(t) {
            p("pause")
        }).on(n.opening, function(t) {
            o.resizeRatio(c, i, f, v, u)
        }).on(n.closing, function(t) {
            p("stop")
        }), a.$wndw.on(n.resize, function(t) {
            o.resizeRatio(c, i, f, v, u)
        })
    }
    var s, e, n, o, a, r = "tosrus",
        d = "youtube",
        l = !1;
    t[r].media[d] = {
        filterAnchors: function(t) {
            return t.attr("href").toLowerCase().indexOf("youtube.com/watch?v=") > -1
        },
        initAnchors: function(s, e) {
            var n = e;
            e = e.split("?v=")[1].split("&")[0], this.opts[d].imageLink ? (e = "http://img.youtube.com/vi/" + e + "/0.jpg", t('<a href="' + n + '" class="' + t[r]._c("play") + '" target="_blank" />').appendTo(s), t('<img border="0" />').on(t[r]._e.load, function(i) {
                i.stopPropagation(), s.removeClass(t[r]._c.loading).trigger(t[r]._e.loaded)
            }).appendTo(s).attr("src", e)) : (t('<iframe src="http://www.youtube.com/embed/' + e + '?enablejsapi=1" frameborder="0" allowfullscreen />').appendTo(s), i.call(this, s))
        },
        filterSlides: function(t) {
            return !(!t.is("iframe") || !t.attr("src")) && t.attr("src").toLowerCase().indexOf("youtube.com/embed/") > -1
        },
        initSlides: function(t) {
            i.call(this, t)
        }
    }, t[r].defaults.media[d] = {}, t[r].defaults[d] = {
        ratio: 16 / 9,
        maxWidth: !1,
        maxHeight: !1,
        imageLink: t[r].support.touch
    }
}(jQuery);