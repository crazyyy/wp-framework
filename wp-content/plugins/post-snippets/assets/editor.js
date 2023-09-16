!(function t(e, n, i) {
	function r(s, a) {
		if (!n[s]) {
			if (!e[s]) {
				var l = "function" == typeof require && require;
				if (!a && l) return l(s, !0);
				if (o) return o(s, !0);
				var c = new Error("Cannot find module '" + s + "'");
				throw ((c.code = "MODULE_NOT_FOUND"), c);
			}
			var h = (n[s] = { exports: {} });
			e[s][0].call(
				h.exports,
				function (t) {
					return r(e[s][1][t] || t);
				},
				h,
				h.exports,
				t,
				e,
				n,
				i
			);
		}
		return n[s].exports;
	}
	for (
		var o = "function" == typeof require && require, s = 0;
		s < i.length;
		s++
	)
		r(i[s]);
	return r;
})(
	{
		1: [
			function (t, e, n) {
				"use strict";
				var i,
					r =
						(i = t("codemirror/lib/codemirror")) && i.__esModule
							? i
							: { default: i };
					t("codemirror/mode/php/php"),
					t("codemirror/addon/edit/matchbrackets"),
					t("codemirror/addon/edit/closebrackets"),
					t("codemirror/addon/search/search"),
					t("codemirror/addon/search/match-highlighter"),
					t(
						"../node_modules/codemirror-colorpicker/dist/codemirror-colorpicker"
					),
					t("./php-lint"),
					(window.Code_Snippets_CodeMirror = r.default),
					r.default.defineMode("php-snippet", function (t) {
						return r.default.getMode(t, {
							name: "application/x-httpd-php",
							startOpen: !0,
						});
					});
			},
			{
				"../node_modules/codemirror-colorpicker/dist/codemirror-colorpicker": 3,
				"./php-lint": 2,
				"codemirror/addon/edit/closebrackets": 5,
				"codemirror/addon/edit/matchbrackets": 6,
				"codemirror/addon/search/match-highlighter": 9,
				"codemirror/addon/search/search": 11,
				"codemirror/lib/codemirror": 13,
				"codemirror/mode/php/php": 18,
			},
		],
		2: [
			function (t, e, n) {
				"use strict";
				var i = o(t("php-parser/src/index")),
					r = o(t("codemirror/lib/codemirror"));
				function o(t) {
					return t && t.__esModule ? t : { default: t };
				}
				function s(t, e) {
					var n =
						("undefined" != typeof Symbol && t[Symbol.iterator]) ||
						t["@@iterator"];
					if (!n) {
						if (
							Array.isArray(t) ||
							(n = (function (t, e) {
								if (!t) return;
								if ("string" == typeof t) return a(t, e);
								var n = Object.prototype.toString.call(t).slice(8, -1);
								"Object" === n && t.constructor && (n = t.constructor.name);
								if ("Map" === n || "Set" === n) return Array.from(t);
								if (
									"Arguments" === n ||
									/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
								)
									return a(t, e);
							})(t)) ||
							(e && t && "number" == typeof t.length)
						) {
							n && (t = n);
							var i = 0,
								r = function () {};
							return {
								s: r,
								n: function () {
									return i >= t.length
										? { done: !0 }
										: { done: !1, value: t[i++] };
								},
								e: function (t) {
									throw t;
								},
								f: r,
							};
						}
						throw new TypeError(
							"Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."
						);
					}
					var o,
						s = !0,
						l = !1;
					return {
						s: function () {
							n = n.call(t);
						},
						n: function () {
							var t = n.next();
							return (s = t.done), t;
						},
						e: function (t) {
							(l = !0), (o = t);
						},
						f: function () {
							try {
								s || null == n.return || n.return();
							} finally {
								if (l) throw o;
							}
						},
					};
				}
				function a(t, e) {
					(null == e || e > t.length) && (e = t.length);
					for (var n = 0, i = new Array(e); n < e; n++) i[n] = t[n];
					return i;
				}
				function l(t, e) {
					for (var n = 0; n < e.length; n++) {
						var i = e[n];
						(i.enumerable = i.enumerable || !1),
							(i.configurable = !0),
							"value" in i && (i.writable = !0),
							Object.defineProperty(t, i.key, i);
					}
				}
				t("codemirror/addon/lint/lint");
				var c = (function () {
					function t(e) {
						!(function (t, e) {
							if (!(t instanceof e))
								throw new TypeError("Cannot call a class as a function");
						})(this, t),
							(this.code = e),
							(this.annotations = []),
							(this.function_names = new Set()),
							(this.class_names = new Set());
					}
					var e, n, o;
					return (
						(e = t),
						(n = [
							{
								key: "lint",
								value: function () {
									var t = new i.default({
										parser: { suppressErrors: !0, version: 800 },
										ast: { withPositions: !0 },
									});
									try {
										var e = t.parseEval(this.code);
										if (e.errors && e.errors.length > 0)
											for (var n = 0; n < e.errors.length; n++)
												this.annotate(e.errors[n].message, e.errors[n].loc);
										this.visit(e);
									} catch (t) {
										this.annotate(t.message, t);
									}
								},
							},
							{
								key: "visit",
								value: function (t) {
									if (
										(t.hasOwnProperty("kind") && this.validate(t),
										t.hasOwnProperty("children"))
									) {
										var e,
											n = s(t.children);
										try {
											for (n.s(); !(e = n.n()).done; ) {
												var i = e.value;
												this.visit(i);
											}
										} catch (t) {
											n.e(t);
										} finally {
											n.f();
										}
									}
								},
							},
							{
								key: "validate",
								value: function (t) {
									("function" !== t.kind && "class" !== t.kind) ||
										!t.hasOwnProperty("name") ||
										"identifier" !== t.name.kind ||
										("function" === t.kind
											? this.function_names.has(t.name.name)
												? this.annotate(
														"Cannot redeclare function ".concat(
															t.name.name,
															"()"
														),
														t.name.loc
												  )
												: this.function_names.add(t.name.name)
											: "class" === t.kind &&
											  (this.class_names.has(t.name.name)
													? this.annotate(
															"Cannot redeclare class ".concat(t.name.name),
															t.name.loc
													  )
													: this.class_names.add(t.name.name)));
								},
							},
							{
								key: "annotate",
								value: function (t, e, n) {
									var i, o;
									e.lineNumber && e.columnNumber
										? ((i = r.default.Pos(
												e.lineNumber - 1,
												e.columnNumber - 1
										  )),
										  (o = r.default.Pos(e.lineNumber - 1, e.columnNumber)))
										: e.start &&
										  e.end &&
										  (e.end.offset < e.start.offset
												? ((o = r.default.Pos(
														e.start.line - 1,
														e.start.column
												  )),
												  (i = r.default.Pos(e.end.line - 1, e.end.column)))
												: ((i = r.default.Pos(
														e.start.line - 1,
														e.start.column
												  )),
												  (o = r.default.Pos(e.end.line - 1, e.end.column)))),
										i &&
											o &&
											((n = n || "error"),
											this.annotations.push({
												message: t,
												severity: n,
												from: i,
												to: o,
											}));
								},
							},
						]) && l(e.prototype, n),
						o && l(e, o),
						t
					);
				})();
				r.default.registerHelper("lint", "php", function (t, e) {
					var n = new c(t);
					return n.lint(), n.annotations;
				});
			},
			{
				"codemirror/addon/lint/lint": 7,
				"codemirror/lib/codemirror": 13,
				"php-parser/src/index": 132,
			},
		],
		3: [
			function (t, e, n) {
				var i, r;
				(i = this),
					(r = function () {
						"use strict";
						function e(t, e) {
							var o =
								arguments.length > 2 && void 0 !== arguments[2]
									? arguments[2]
									: "rgba(0, 0, 0, 0)";
							return (
								Array.isArray(t) &&
									(t = { r: t[0], g: t[1], b: t[2], a: t[3] }),
								"hex" == e ? n(t) : "rgb" == e ? i(t, o) : "hsl" == e ? r(t) : t
							);
						}
						function n(t) {
							Array.isArray(t) && (t = { r: t[0], g: t[1], b: t[2], a: t[3] });
							var e = t.r.toString(16);
							t.r < 16 && (e = "0" + e);
							var n = t.g.toString(16);
							t.g < 16 && (n = "0" + n);
							var i = t.b.toString(16);
							t.b < 16 && (i = "0" + i);
							var r = "";
							if (t.a < 1) {
								var o = Math.floor(255 * t.a);
								(r = o.toString(16)), o < 16 && (r = "0" + r);
							}
							return "#" + e + n + i + r;
						}
						function i(t) {
							var e =
								arguments.length > 1 && void 0 !== arguments[1]
									? arguments[1]
									: "rgba(0, 0, 0, 0)";
							if (
								(Array.isArray(t) &&
									(t = { r: t[0], g: t[1], b: t[2], a: t[3] }),
								void 0 !== t)
							)
								return 1 == t.a || void 0 === t.a
									? isNaN(t.r)
										? e
										: "rgb(" + t.r + "," + t.g + "," + t.b + ")"
									: "rgba(" + t.r + "," + t.g + "," + t.b + "," + t.a + ")";
						}
						function r(t) {
							return (
								Array.isArray(t) &&
									(t = { r: t[0], g: t[1], b: t[2], a: t[3] }),
								1 == t.a || void 0 === t.a
									? "hsl(" + t.h + "," + t.s + "%," + t.l + "%)"
									: "hsla(" + t.h + "," + t.s + "%," + t.l + "%," + t.a + ")"
							);
						}
						var o = { format: e, rgb: i, hsl: r, hex: n };
						function s(t, e) {
							return (e = void 0 === e ? 1 : e), Math.round(t * e) / e;
						}
						function a(t) {
							return (t * Math.PI) / 180;
						}
						function l(t) {
							var e = (180 * t) / Math.PI;
							return e < 0 && (e = 360 + e), e;
						}
						function c(t, e) {
							var n =
								arguments.length > 2 && void 0 !== arguments[2]
									? arguments[2]
									: 0;
							return n + e * Math.cos(a(t));
						}
						function h(t, e) {
							var n =
								arguments.length > 2 && void 0 !== arguments[2]
									? arguments[2]
									: 0;
							return n + e * Math.sin(a(t));
						}
						function u(t, e) {
							return l(Math.atan2(e, t));
						}
						var f = {
								round: s,
								radianToDegree: l,
								degreeToRadian: a,
								getXInCircle: c,
								getYInCircle: h,
								caculateAngle: u,
							},
							d = {
								aliceblue: "rgb(240, 248, 255)",
								antiquewhite: "rgb(250, 235, 215)",
								aqua: "rgb(0, 255, 255)",
								aquamarine: "rgb(127, 255, 212)",
								azure: "rgb(240, 255, 255)",
								beige: "rgb(245, 245, 220)",
								bisque: "rgb(255, 228, 196)",
								black: "rgb(0, 0, 0)",
								blanchedalmond: "rgb(255, 235, 205)",
								blue: "rgb(0, 0, 255)",
								blueviolet: "rgb(138, 43, 226)",
								brown: "rgb(165, 42, 42)",
								burlywood: "rgb(222, 184, 135)",
								cadetblue: "rgb(95, 158, 160)",
								chartreuse: "rgb(127, 255, 0)",
								chocolate: "rgb(210, 105, 30)",
								coral: "rgb(255, 127, 80)",
								cornflowerblue: "rgb(100, 149, 237)",
								cornsilk: "rgb(255, 248, 220)",
								crimson: "rgb(237, 20, 61)",
								cyan: "rgb(0, 255, 255)",
								darkblue: "rgb(0, 0, 139)",
								darkcyan: "rgb(0, 139, 139)",
								darkgoldenrod: "rgb(184, 134, 11)",
								darkgray: "rgb(169, 169, 169)",
								darkgrey: "rgb(169, 169, 169)",
								darkgreen: "rgb(0, 100, 0)",
								darkkhaki: "rgb(189, 183, 107)",
								darkmagenta: "rgb(139, 0, 139)",
								darkolivegreen: "rgb(85, 107, 47)",
								darkorange: "rgb(255, 140, 0)",
								darkorchid: "rgb(153, 50, 204)",
								darkred: "rgb(139, 0, 0)",
								darksalmon: "rgb(233, 150, 122)",
								darkseagreen: "rgb(143, 188, 143)",
								darkslateblue: "rgb(72, 61, 139)",
								darkslategray: "rgb(47, 79, 79)",
								darkslategrey: "rgb(47, 79, 79)",
								darkturquoise: "rgb(0, 206, 209)",
								darkviolet: "rgb(148, 0, 211)",
								deeppink: "rgb(255, 20, 147)",
								deepskyblue: "rgb(0, 191, 255)",
								dimgray: "rgb(105, 105, 105)",
								dimgrey: "rgb(105, 105, 105)",
								dodgerblue: "rgb(30, 144, 255)",
								firebrick: "rgb(178, 34, 34)",
								floralwhite: "rgb(255, 250, 240)",
								forestgreen: "rgb(34, 139, 34)",
								fuchsia: "rgb(255, 0, 255)",
								gainsboro: "rgb(220, 220, 220)",
								ghostwhite: "rgb(248, 248, 255)",
								gold: "rgb(255, 215, 0)",
								goldenrod: "rgb(218, 165, 32)",
								gray: "rgb(128, 128, 128)",
								grey: "rgb(128, 128, 128)",
								green: "rgb(0, 128, 0)",
								greenyellow: "rgb(173, 255, 47)",
								honeydew: "rgb(240, 255, 240)",
								hotpink: "rgb(255, 105, 180)",
								indianred: "rgb(205, 92, 92)",
								indigo: "rgb(75, 0, 130)",
								ivory: "rgb(255, 255, 240)",
								khaki: "rgb(240, 230, 140)",
								lavender: "rgb(230, 230, 250)",
								lavenderblush: "rgb(255, 240, 245)",
								lawngreen: "rgb(124, 252, 0)",
								lemonchiffon: "rgb(255, 250, 205)",
								lightblue: "rgb(173, 216, 230)",
								lightcoral: "rgb(240, 128, 128)",
								lightcyan: "rgb(224, 255, 255)",
								lightgoldenrodyellow: "rgb(250, 250, 210)",
								lightgreen: "rgb(144, 238, 144)",
								lightgray: "rgb(211, 211, 211)",
								lightgrey: "rgb(211, 211, 211)",
								lightpink: "rgb(255, 182, 193)",
								lightsalmon: "rgb(255, 160, 122)",
								lightseagreen: "rgb(32, 178, 170)",
								lightskyblue: "rgb(135, 206, 250)",
								lightslategray: "rgb(119, 136, 153)",
								lightslategrey: "rgb(119, 136, 153)",
								lightsteelblue: "rgb(176, 196, 222)",
								lightyellow: "rgb(255, 255, 224)",
								lime: "rgb(0, 255, 0)",
								limegreen: "rgb(50, 205, 50)",
								linen: "rgb(250, 240, 230)",
								magenta: "rgb(255, 0, 255)",
								maroon: "rgb(128, 0, 0)",
								mediumaquamarine: "rgb(102, 205, 170)",
								mediumblue: "rgb(0, 0, 205)",
								mediumorchid: "rgb(186, 85, 211)",
								mediumpurple: "rgb(147, 112, 219)",
								mediumseagreen: "rgb(60, 179, 113)",
								mediumslateblue: "rgb(123, 104, 238)",
								mediumspringgreen: "rgb(0, 250, 154)",
								mediumturquoise: "rgb(72, 209, 204)",
								mediumvioletred: "rgb(199, 21, 133)",
								midnightblue: "rgb(25, 25, 112)",
								mintcream: "rgb(245, 255, 250)",
								mistyrose: "rgb(255, 228, 225)",
								moccasin: "rgb(255, 228, 181)",
								navajowhite: "rgb(255, 222, 173)",
								navy: "rgb(0, 0, 128)",
								oldlace: "rgb(253, 245, 230)",
								olive: "rgb(128, 128, 0)",
								olivedrab: "rgb(107, 142, 35)",
								orange: "rgb(255, 165, 0)",
								orangered: "rgb(255, 69, 0)",
								orchid: "rgb(218, 112, 214)",
								palegoldenrod: "rgb(238, 232, 170)",
								palegreen: "rgb(152, 251, 152)",
								paleturquoise: "rgb(175, 238, 238)",
								palevioletred: "rgb(219, 112, 147)",
								papayawhip: "rgb(255, 239, 213)",
								peachpuff: "rgb(255, 218, 185)",
								peru: "rgb(205, 133, 63)",
								pink: "rgb(255, 192, 203)",
								plum: "rgb(221, 160, 221)",
								powderblue: "rgb(176, 224, 230)",
								purple: "rgb(128, 0, 128)",
								rebeccapurple: "rgb(102, 51, 153)",
								red: "rgb(255, 0, 0)",
								rosybrown: "rgb(188, 143, 143)",
								royalblue: "rgb(65, 105, 225)",
								saddlebrown: "rgb(139, 69, 19)",
								salmon: "rgb(250, 128, 114)",
								sandybrown: "rgb(244, 164, 96)",
								seagreen: "rgb(46, 139, 87)",
								seashell: "rgb(255, 245, 238)",
								sienna: "rgb(160, 82, 45)",
								silver: "rgb(192, 192, 192)",
								skyblue: "rgb(135, 206, 235)",
								slateblue: "rgb(106, 90, 205)",
								slategray: "rgb(112, 128, 144)",
								slategrey: "rgb(112, 128, 144)",
								snow: "rgb(255, 250, 250)",
								springgreen: "rgb(0, 255, 127)",
								steelblue: "rgb(70, 130, 180)",
								tan: "rgb(210, 180, 140)",
								teal: "rgb(0, 128, 128)",
								thistle: "rgb(216, 191, 216)",
								tomato: "rgb(255, 99, 71)",
								turquoise: "rgb(64, 224, 208)",
								violet: "rgb(238, 130, 238)",
								wheat: "rgb(245, 222, 179)",
								white: "rgb(255, 255, 255)",
								whitesmoke: "rgb(245, 245, 245)",
								yellow: "rgb(255, 255, 0)",
								yellowgreen: "rgb(154, 205, 50)",
								transparent: "rgba(0, 0, 0, 0)",
							},
							p = {
								isColorName: function (t) {
									return !!d[t];
								},
								getColorByName: function (t) {
									return d[t];
								},
							};
						function g(t, e, n) {
							return (
								n < 0 && (n += 1),
								n > 1 && (n -= 1),
								n < 1 / 6
									? t + 6 * (e - t) * n
									: n < 0.5
									? e
									: n < 2 / 3
									? t + (e - t) * (2 / 3 - n) * 6
									: t
							);
						}
						function m(t, e, n) {
							if (1 == arguments.length) {
								var i = arguments[0];
								(t = i.h), (e = i.s), (n = i.l);
							}
							var r, o, a;
							if (((t /= 360), (n /= 100), 0 == (e /= 100))) r = o = a = n;
							else {
								var l = n < 0.5 ? n * (1 + e) : n + e - n * e,
									c = 2 * n - l;
								(r = g(c, l, t + 1 / 3)),
									(o = g(c, l, t)),
									(a = g(c, l, t - 1 / 3));
							}
							return { r: s(255 * r), g: s(255 * o), b: s(255 * a) };
						}
						var v = {
								HUEtoRGB: g,
								HSLtoHSV: function (t, e, n) {
									if (1 == arguments.length) {
										var i = arguments[0];
										(t = i.h), (e = i.s), (n = i.l);
									}
									var r = m(t, e, n);
									return D(r.r, r.g, r.b);
								},
								HSLtoRGB: m,
							},
							_ = function (t, e) {
								if (!(t instanceof e))
									throw new TypeError("Cannot call a class as a function");
							},
							y = (function () {
								function t(t, e) {
									for (var n = 0; n < e.length; n++) {
										var i = e[n];
										(i.enumerable = i.enumerable || !1),
											(i.configurable = !0),
											"value" in i && (i.writable = !0),
											Object.defineProperty(t, i.key, i);
									}
								}
								return function (e, n, i) {
									return n && t(e.prototype, n), i && t(e, i), e;
								};
							})(),
							x = function (t, e, n) {
								return (
									e in t
										? Object.defineProperty(t, e, {
												value: n,
												enumerable: !0,
												configurable: !0,
												writable: !0,
										  })
										: (t[e] = n),
									t
								);
							},
							k =
								Object.assign ||
								function (t) {
									for (var e = 1; e < arguments.length; e++) {
										var n = arguments[e];
										for (var i in n)
											Object.prototype.hasOwnProperty.call(n, i) &&
												(t[i] = n[i]);
									}
									return t;
								},
							b = function t(e, n, i) {
								null === e && (e = Function.prototype);
								var r = Object.getOwnPropertyDescriptor(e, n);
								if (void 0 === r) {
									var o = Object.getPrototypeOf(e);
									return null === o ? void 0 : t(o, n, i);
								}
								if ("value" in r) return r.value;
								var s = r.get;
								return void 0 !== s ? s.call(i) : void 0;
							},
							T = function (t, e) {
								if ("function" != typeof e && null !== e)
									throw new TypeError(
										"Super expression must either be null or a function, not " +
											typeof e
									);
								(t.prototype = Object.create(e && e.prototype, {
									constructor: {
										value: t,
										enumerable: !1,
										writable: !0,
										configurable: !0,
									},
								})),
									e &&
										(Object.setPrototypeOf
											? Object.setPrototypeOf(t, e)
											: (t.__proto__ = e));
							},
							C = function (t, e) {
								if (!t)
									throw new ReferenceError(
										"this hasn't been initialised - super() hasn't been called"
									);
								return !e || ("object" != typeof e && "function" != typeof e)
									? t
									: e;
							},
							w = function (t, e) {
								if (Array.isArray(t)) return t;
								if (Symbol.iterator in Object(t))
									return (function (t, e) {
										var n = [],
											i = !0,
											r = !1,
											o = void 0;
										try {
											for (
												var s, a = t[Symbol.iterator]();
												!(i = (s = a.next()).done) &&
												(n.push(s.value), !e || n.length !== e);
												i = !0
											);
										} catch (t) {
											(r = !0), (o = t);
										} finally {
											try {
												!i && a.return && a.return();
											} finally {
												if (r) throw o;
											}
										}
										return n;
									})(t, e);
								throw new TypeError(
									"Invalid attempt to destructure non-iterable instance"
								);
							},
							E = function (t) {
								if (Array.isArray(t)) {
									for (var e = 0, n = Array(t.length); e < t.length; e++)
										n[e] = t[e];
									return n;
								}
								return Array.from(t);
							},
							S =
								/(#(?:[\da-f]{8})|#(?:[\da-f]{3}){1,2}|rgb\((?:\s*\d{1,3},\s*){2}\d{1,3}\s*\)|rgba\((?:\s*\d{1,3},\s*){3}\d*\.?\d+\s*\)|hsl\(\s*\d{1,3}(?:,\s*\d{1,3}%){2}\s*\)|hsla\(\s*\d{1,3}(?:,\s*\d{1,3}%){2},\s*\d*\.?\d+\s*\)|([\w_\-]+))/gi;
						function A(t) {
							var e = t.match(S),
								n = [];
							if (!e) return n;
							for (var i = 0, r = e.length; i < r; i++)
								if (
									e[i].indexOf("#") > -1 ||
									e[i].indexOf("rgb") > -1 ||
									e[i].indexOf("hsl") > -1
								)
									n.push({ color: e[i] });
								else {
									var o = p.getColorByName(e[i]);
									o && n.push({ color: e[i], nameColor: o });
								}
							var s = { next: 0 };
							return (
								n.forEach(function (e) {
									var n = t.indexOf(e.color, s.next);
									(e.startIndex = n),
										(e.endIndex = n + e.color.length),
										(s.next = e.endIndex);
								}),
								n
							);
						}
						function L(t) {
							var e = A(t);
							return (
								e.forEach(function (e, n) {
									t = t.replace(e.color, "@" + n);
								}),
								{ str: t, matches: e }
							);
						}
						function O(t) {
							var e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: ",",
								n = L(t);
							return n.str.split(e).map(function (t, e) {
								return (
									(t = I(t)),
									n.matches[e] && (t = t.replace("@" + e, n.matches[e].color)),
									t
								);
							});
						}
						function N(t, e) {
							return (
								e.forEach(function (e, n) {
									t = t.replace("@" + n, e.color);
								}),
								t
							);
						}
						function I(t) {
							return t.replace(/^\s+|\s+$/g, "");
						}
						function M(t) {
							if ("string" == typeof t) {
								if (
									(p.isColorName(t) && (t = p.getColorByName(t)),
									t.indexOf("rgb(") > -1)
								) {
									for (
										var e = 0,
											n = (r = t
												.replace("rgb(", "")
												.replace(")", "")
												.split(",")).length;
										e < n;
										e++
									)
										r[e] = parseInt(I(r[e]), 10);
									var i = { type: "rgb", r: r[0], g: r[1], b: r[2], a: 1 };
									return (i = Object.assign(i, P(i)));
								}
								if (t.indexOf("rgba(") > -1) {
									for (
										e = 0,
											n = (r = t
												.replace("rgba(", "")
												.replace(")", "")
												.split(",")).length;
										e < n;
										e++
									)
										r[e] =
											n - 1 == e ? parseFloat(I(r[e])) : parseInt(I(r[e]), 10);
									return (
										(i = { type: "rgb", r: r[0], g: r[1], b: r[2], a: r[3] }),
										(i = Object.assign(i, P(i)))
									);
								}
								if (t.indexOf("hsl(") > -1) {
									for (
										e = 0,
											n = (r = t
												.replace("hsl(", "")
												.replace(")", "")
												.split(",")).length;
										e < n;
										e++
									)
										r[e] = parseFloat(I(r[e]));
									return (
										(i = { type: "hsl", h: r[0], s: r[1], l: r[2], a: 1 }),
										(i = Object.assign(i, m(i)))
									);
								}
								if (t.indexOf("hsla(") > -1) {
									for (
										e = 0,
											n = (r = t
												.replace("hsla(", "")
												.replace(")", "")
												.split(",")).length;
										e < n;
										e++
									)
										r[e] =
											n - 1 == e ? parseFloat(I(r[e])) : parseInt(I(r[e]), 10);
									return (
										(i = { type: "hsl", h: r[0], s: r[1], l: r[2], a: r[3] }),
										(i = Object.assign(i, m(i)))
									);
								}
								if (0 == t.indexOf("#")) {
									var r = [],
										o = 1;
									if (3 == (t = t.replace("#", "")).length)
										for (e = 0, n = t.length; e < n; e++) {
											var s = t.substr(e, 1);
											r.push(parseInt(s + s, 16));
										}
									else if (8 === t.length) {
										for (e = 0, n = t.length; e < n; e += 2)
											r.push(parseInt(t.substr(e, 2), 16));
										o = r.pop() / 255;
									} else
										for (e = 0, n = t.length; e < n; e += 2)
											r.push(parseInt(t.substr(e, 2), 16));
									return (
										(i = { type: "hex", r: r[0], g: r[1], b: r[2], a: o }),
										(i = Object.assign(i, P(i)))
									);
								}
							} else if ("number" == typeof t) {
								if (0 <= t && t <= 16777215)
									return (
										(i = {
											type: "hex",
											r: (16711680 & t) >> 16,
											g: (65280 & t) >> 8,
											b: (255 & t) >> 0,
											a: 1,
										}),
										(i = Object.assign(i, P(i)))
									);
								if (0 <= t && t <= 4294967295)
									return (
										(i = {
											type: "hex",
											r: (4278190080 & t) >> 24,
											g: (16711680 & t) >> 16,
											b: (65280 & t) >> 8,
											a: (255 & t) / 255,
										}),
										(i = Object.assign(i, P(i)))
									);
							}
							return t;
						}
						function $(t) {
							"string" == typeof t && (t = O(t));
							var e = (t = t.map(function (t) {
								if ("string" == typeof t) {
									var e = L(t),
										n = I(e.str).split(" ");
									return (
										n[1]
											? n[1].includes("%")
												? (n[1] = parseFloat(n[1].replace(/%/, "")) / 100)
												: (n[1] = parseFloat(n[1]))
											: (n[1] = "*"),
										(n[0] = N(n[0], e.matches)),
										n
									);
								}
								if (Array.isArray(t))
									return (
										t[1]
											? "string" == typeof t[1] &&
											  (t[1].includes("%")
													? (t[1] = parseFloat(t[1].replace(/%/, "")) / 100)
													: (t[1] = +t[1]))
											: (t[1] = "*"),
										[].concat(E(t))
									);
							})).filter(function (t) {
								return "*" === t[1];
							}).length;
							if (e > 0) {
								var n =
									(1 -
										t
											.filter(function (t) {
												return "*" != t[1] && 1 != t[1];
											})
											.map(function (t) {
												return t[1];
											})
											.reduce(function (t, e) {
												return t + e;
											}, 0)) /
									e;
								t.forEach(function (e, i) {
									"*" == e[1] && i > 0 && (t.length - 1 == i || (e[1] = n));
								});
							}
							return t;
						}
						var R = {
							matches: A,
							convertMatches: L,
							convertMatchesArray: O,
							reverseMatches: N,
							parse: M,
							parseGradient: $,
							trim: I,
							color_regexp: S,
							color_split: ",",
						};
						function D(t, e, n) {
							if (1 == arguments.length) {
								var i = arguments[0];
								(t = i.r), (e = i.g), (n = i.b);
							}
							var r = t / 255,
								o = e / 255,
								s = n / 255,
								a = Math.max(r, o, s),
								l = Math.min(r, o, s),
								c = a - l,
								h = 0;
							return (
								0 == c
									? (h = 0)
									: a == r
									? (h = (((o - s) / c) % 6) * 60)
									: a == o
									? (h = 60 * ((s - r) / c + 2))
									: a == s && (h = 60 * ((r - o) / c + 4)),
								h < 0 && (h = 360 + h),
								{ h: h, s: 0 == a ? 0 : c / a, v: a }
							);
						}
						function P(t, e, n) {
							if (1 == arguments.length) {
								var i = arguments[0];
								(t = i.r), (e = i.g), (n = i.b);
							}
							(t /= 255), (e /= 255), (n /= 255);
							var r,
								o,
								a = Math.max(t, e, n),
								l = Math.min(t, e, n),
								c = (a + l) / 2;
							if (a == l) r = o = 0;
							else {
								var h = a - l;
								switch (((o = c > 0.5 ? h / (2 - a - l) : h / (a + l)), a)) {
									case t:
										r = (e - n) / h + (e < n ? 6 : 0);
										break;
									case e:
										r = (n - t) / h + 2;
										break;
									case n:
										r = (t - e) / h + 4;
								}
								r /= 6;
							}
							return { h: s(360 * r), s: s(100 * o), l: s(100 * c) };
						}
						function F(t) {
							return { r: t, g: t, b: t };
						}
						function B(t, e, n) {
							return Math.ceil(0.2126 * t + 0.7152 * e + 0.0722 * n);
						}
						function U(t, e, n) {
							if (1 == arguments.length) {
								var i = arguments[0];
								(t = i.r), (e = i.g), (n = i.b);
							}
							var r = B(t, e, n),
								o = 0.564 * (n - r),
								s = 0.713 * (t - r);
							return { y: r, cr: s, cb: o };
						}
						function H(t) {
							var e =
								arguments.length > 1 && void 0 !== arguments[1]
									? arguments[1]
									: 0.04045;
							return (
								100 * (t > e ? Math.pow((t + 0.055) / 1.055, 2.4) : t / 12.92)
							);
						}
						function z(t, e, n) {
							if (1 == arguments.length) {
								var i = arguments[0];
								(t = i.r), (e = i.g), (n = i.b);
							}
							var r = t / 255,
								o = e / 255,
								s = n / 255,
								a =
									0.4124 * (r = H(r)) +
									0.3576 * (o = H(o)) +
									0.1805 * (s = H(s)),
								l = 0.2126 * r + 0.7152 * o + 0.0722 * s,
								c = 0.0193 * r + 0.1192 * o + 0.9505 * s;
							return { x: a, y: l, z: c };
						}
						var W = {
								RGBtoCMYK: function (t, e, n) {
									if (1 == arguments.length) {
										var i = arguments[0];
										(t = i.r), (e = i.g), (n = i.b);
									}
									var r = t / 255,
										o = e / 255,
										s = n / 255,
										a = 1 - Math.max(r, o, s),
										l = (1 - r - a) / (1 - a),
										c = (1 - o - a) / (1 - a),
										h = (1 - s - a) / (1 - a);
									return { c: l, m: c, y: h, k: a };
								},
								RGBtoGray: function (t, e, n) {
									if (1 == arguments.length) {
										var i = arguments[0];
										(t = i.r), (e = i.g), (n = i.b);
									}
									return F(U(t, e, n).y);
								},
								RGBtoHSL: P,
								RGBtoHSV: D,
								RGBtoLAB: function (t, e, n) {
									if (1 == arguments.length) {
										var i = arguments[0];
										(t = i.r), (e = i.g), (n = i.b);
									}
									return XYZtoLAB(z(t, e, n));
								},
								RGBtoSimpleGray: function (t, e, n) {
									if (1 == arguments.length) {
										var i = arguments[0];
										(t = i.r), (e = i.g), (n = i.b);
									}
									return F(Math.ceil((t + e + n) / 3));
								},
								RGBtoXYZ: z,
								RGBtoYCrCb: U,
								c: function (t, e, n) {
									if (1 == arguments.length) {
										var i = arguments[0];
										(t = i.r), (e = i.g), (n = i.b);
									}
									return F((t + e + n) / 3 > 90 ? 0 : 255);
								},
								brightness: B,
								gray: F,
							},
							j = {
								CMYKtoRGB: function (t, e, n, i) {
									if (1 == arguments.length) {
										var r = arguments[0];
										(t = r.c), (e = r.m), (n = r.y), (i = r.k);
									}
									var o = 255 * (1 - t) * (1 - i),
										s = 255 * (1 - e) * (1 - i),
										a = 255 * (1 - n) * (1 - i);
									return { r: o, g: s, b: a };
								},
							};
						function G(t) {
							return Math.pow(t, 3) > 0.008856
								? Math.pow(t, 3)
								: (t - 16 / 116) / 7.787;
						}
						function q(t) {
							return t > 0.0031308
								? 1.055 * Math.pow(t, 1 / 2.4) - 0.055
								: 12.92 * t;
						}
						function V(t, e, n) {
							if (1 == arguments.length) {
								var i = arguments[0];
								(t = i.x), (e = i.y), (n = i.z);
							}
							var r = t / 100,
								o = e / 100,
								a = n / 100,
								l = 3.2406 * r + -1.5372 * o + -0.4986 * a,
								c = -0.9689 * r + 1.8758 * o + 0.0415 * a,
								h = 0.0557 * r + -0.204 * o + 1.057 * a;
							(l = q(l)), (c = q(c)), (h = q(h));
							var u = s(255 * l),
								f = s(255 * c),
								d = s(255 * h);
							return { r: u, g: f, b: d };
						}
						function Y(t, e, n) {
							if (1 == arguments.length) {
								var i = arguments[0];
								(t = i.l), (e = i.a), (n = i.b);
							}
							var r = (t + 16) / 116,
								o = e / 500 + r,
								s = r - n / 200;
							r = G(r);
							var a = 95.047 * (o = G(o)),
								l = 100 * r,
								c = 108.883 * (s = G(s));
							return { x: a, y: l, z: c };
						}
						var K = {
							XYZtoRGB: V,
							LABtoRGB: function (t, e, n) {
								if (1 == arguments.length) {
									var i = arguments[0];
									(t = i.l), (e = i.a), (n = i.b);
								}
								return V(Y(t, e, n));
							},
							LABtoXYZ: Y,
						};
						function X(t, e, n) {
							if (1 == arguments.length) {
								var i = arguments[0];
								(t = i.h), (e = i.s), (n = i.v);
							}
							var r = t,
								o = e,
								a = n;
							r >= 360 && (r = 0);
							var l = o * a,
								c = l * (1 - Math.abs(((r / 60) % 2) - 1)),
								h = a - l,
								u = [];
							return (
								0 <= r && r < 60
									? (u = [l, c, 0])
									: 60 <= r && r < 120
									? (u = [c, l, 0])
									: 120 <= r && r < 180
									? (u = [0, l, c])
									: 180 <= r && r < 240
									? (u = [0, c, l])
									: 240 <= r && r < 300
									? (u = [c, 0, l])
									: 300 <= r && r < 360 && (u = [l, 0, c]),
								{
									r: s(255 * (u[0] + h)),
									g: s(255 * (u[1] + h)),
									b: s(255 * (u[2] + h)),
								}
							);
						}
						var Q = {
								HSVtoHSL: function (t, e, n) {
									if (1 == arguments.length) {
										var i = arguments[0];
										(t = i.h), (e = i.s), (n = i.v);
									}
									var r = X(t, e, n);
									return P(r.r, r.g, r.b);
								},
								HSVtoRGB: X,
							},
							Z = {
								YCrCbtoRGB: function (t, e, n, i) {
									if (1 == arguments.length) {
										var r = arguments[0];
										(t = r.y), (e = r.cr), (n = r.cb), (i = (i = r.bit) || 0);
									}
									var o = t + 1.402 * (e - i),
										s = t - 0.344 * (n - i) - 0.714 * (e - i),
										a = t + 1.772 * (n - i);
									return { r: Math.ceil(o), g: Math.ceil(s), b: Math.ceil(a) };
								},
							};
						function J(t, n) {
							var i =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: 0.5,
								r =
									arguments.length > 3 && void 0 !== arguments[3]
										? arguments[3]
										: "hex",
								o = {
									r: s(t.r + (n.r - t.r) * i),
									g: s(t.g + (n.g - t.g) * i),
									b: s(t.b + (n.b - t.b) * i),
									a: s(t.a + (n.a - t.a) * i, 100),
								};
							return e(o, o.a < 1 ? "rgb" : r);
						}
						function tt(t) {
							var e =
								arguments.length > 1 && void 0 !== arguments[1]
									? arguments[1]
									: 5;
							if (!t) return [];
							"string" == typeof t && (t = O(t));
							for (var n = (t = t || []).length, i = [], r = 0; r < n - 1; r++)
								for (var o = 0; o < e; o++) i.push(et(t[r], t[r + 1], o / e));
							return i;
						}
						function et(t, e) {
							var n =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: 0.5,
								i =
									arguments.length > 3 && void 0 !== arguments[3]
										? arguments[3]
										: "hex",
								r = M(t),
								o = M(e);
							return J(r, o, n, i);
						}
						function nt(t) {
							return (
								(t = M(t)),
								(Math.round(299 * t.r) +
									Math.round(587 * t.g) +
									Math.round(114 * t.b)) /
									1e3
							);
						}
						function it(t) {
							for (
								var n =
										arguments.length > 1 && void 0 !== arguments[1]
											? arguments[1]
											: "h",
									i =
										arguments.length > 2 && void 0 !== arguments[2]
											? arguments[2]
											: 9,
									r =
										arguments.length > 3 && void 0 !== arguments[3]
											? arguments[3]
											: "rgb",
									o =
										arguments.length > 4 && void 0 !== arguments[4]
											? arguments[4]
											: 0,
									s =
										arguments.length > 5 && void 0 !== arguments[5]
											? arguments[5]
											: 1,
									a =
										arguments.length > 6 && void 0 !== arguments[6]
											? arguments[6]
											: 100,
									l = M(t),
									c = D(l),
									h = ((s - o) * a) / i,
									u = [],
									f = 1;
								f <= i;
								f++
							)
								(c[n] = Math.abs((a - h * f) / a)), u.push(e(X(c), r));
							return u;
						}
						(tt.parula = function (t) {
							return tt(
								["#352a87", "#0f5cdd", "#00b5a6", "#ffc337", "#fdff00"],
								t
							);
						}),
							(tt.jet = function (t) {
								return tt(
									[
										"#00008f",
										"#0020ff",
										"#00ffff",
										"#51ff77",
										"#fdff00",
										"#ff0000",
										"#800000",
									],
									t
								);
							}),
							(tt.hsv = function (t) {
								return tt(
									[
										"#ff0000",
										"#ffff00",
										"#00ff00",
										"#00ffff",
										"#0000ff",
										"#ff00ff",
										"#ff0000",
									],
									t
								);
							}),
							(tt.hot = function (t) {
								return tt(["#0b0000", "#ff0000", "#ffff00", "#ffffff"], t);
							}),
							(tt.pink = function (t) {
								return tt(["#1e0000", "#bd7b7b", "#e7e5b2", "#ffffff"], t);
							}),
							(tt.bone = function (t) {
								return tt(["#000000", "#4a4a68", "#a6c6c6", "#ffffff"], t);
							}),
							(tt.copper = function (t) {
								return tt(
									["#000000", "#3d2618", "#9d623e", "#ffa167", "#ffc77f"],
									t
								);
							});
						var rt = {
							interpolateRGB: J,
							blend: et,
							mix: function (t, e) {
								var n =
										arguments.length > 2 && void 0 !== arguments[2]
											? arguments[2]
											: 0.5,
									i =
										arguments.length > 3 && void 0 !== arguments[3]
											? arguments[3]
											: "hex";
								return et(t, e, n, i);
							},
							scale: tt,
							contrast: nt,
							contrastColor: function (t) {
								return nt(t) >= 128 ? "black" : "white";
							},
							gradient: function (t) {
								for (
									var e =
											arguments.length > 1 && void 0 !== arguments[1]
												? arguments[1]
												: 10,
										n = [],
										i = e - ((t = $(t)).length - 1),
										r = i,
										o = 1,
										s = t.length;
									o < s;
									o++
								) {
									var a = t[o - 1][0],
										l = t[o][0],
										c = 1 == o ? t[o][1] : t[o][1] - t[o - 1][1],
										h = o == t.length - 1 ? r : Math.floor(c * i);
									(n = n.concat(tt([a, l], h), [l])), (r -= h);
								}
								return n;
							},
							scaleHSV: it,
							scaleH: function (t) {
								var e =
										arguments.length > 1 && void 0 !== arguments[1]
											? arguments[1]
											: 9,
									n =
										arguments.length > 2 && void 0 !== arguments[2]
											? arguments[2]
											: "rgb",
									i =
										arguments.length > 3 && void 0 !== arguments[3]
											? arguments[3]
											: 0,
									r =
										arguments.length > 4 && void 0 !== arguments[4]
											? arguments[4]
											: 360;
								return it(t, "h", e, n, i, r, 1);
							},
							scaleS: function (t) {
								var e =
										arguments.length > 1 && void 0 !== arguments[1]
											? arguments[1]
											: 9,
									n =
										arguments.length > 2 && void 0 !== arguments[2]
											? arguments[2]
											: "rgb",
									i =
										arguments.length > 3 && void 0 !== arguments[3]
											? arguments[3]
											: 0,
									r =
										arguments.length > 4 && void 0 !== arguments[4]
											? arguments[4]
											: 1;
								return it(t, "s", e, n, i, r, 100);
							},
							scaleV: function (t) {
								var e =
										arguments.length > 1 && void 0 !== arguments[1]
											? arguments[1]
											: 9,
									n =
										arguments.length > 2 && void 0 !== arguments[2]
											? arguments[2]
											: "rgb",
									i =
										arguments.length > 3 && void 0 !== arguments[3]
											? arguments[3]
											: 0,
									r =
										arguments.length > 4 && void 0 !== arguments[4]
											? arguments[4]
											: 1;
								return it(t, "v", e, n, i, r, 100);
							},
						};
						function ot(t, e) {
							if (t.length !== e.length) return !1;
							for (var n = 0, i = t.length; n < i; ++n)
								if (t[n] !== e[n]) return !1;
							return !0;
						}
						var st = {
								euclidean: function (t, e) {
									for (var n = 0, i = 0, r = t.length; i < r; i++)
										n += Math.pow(e[i] - t[i], 2);
									return Math.sqrt(n);
								},
								manhattan: function (t, e) {
									for (var n = 0, i = 0, r = t.length; i < r; i++)
										n += Math.abs(e[i] - t[i]);
									return n;
								},
								max: function (t, e) {
									for (var n = 0, i = 0, r = t.length; i < r; i++)
										n = Math.max(n, Math.abs(e[i] - t[i]));
									return n;
								},
							},
							at = {
								linear: function (t, e) {
									var n = [],
										i = Math.round(Math.random() * t),
										r = Math.floor(t / e);
									do {
										n.push(i), (i = (i + r) % t);
									} while (n.length < e);
									return n;
								},
								shuffle: function (t, e) {
									for (var n = []; n.length < e; ) {
										var i = Math.round(Math.random() * t);
										-1 == n.indexOf(i) && n.push(i);
									}
									return n;
								},
							};
						function lt(t, e) {
							var n =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: "linear",
								i = at[n](t.length, e);
							return i.map(function (e) {
								return t[e];
							});
						}
						function ct(t, e, n) {
							var i = 1 / 0,
								r = 0;
							return (
								e.forEach(function (e, o) {
									var s = n(t, e);
									s < i && ((i = s), (r = o));
								}),
								r
							);
						}
						function ht(t) {
							if (!t.length) return [];
							for (
								var e = new Array(t[0].length), n = 0, i = e.length;
								n < i;
								n++
							)
								e[n] = 0;
							var r = 0;
							for (i = t.length; r < i; r++)
								for (var o = t[r], s = r + 1, a = 0, l = o.length; a < l; a++)
									e[a] += (o[a] - e[a]) / s;
							return (e = e.map(function (t) {
								return Math.floor(t);
							}));
						}
						function ut(t, e, n, i) {
							for (var r = new Array(t), o = 0; o < t; o++) r[o] = [];
							for (var s = 0, a = e.length; s < a; s++) {
								var l = e[s];
								r[ct(l, n, i)].push(l);
							}
							return r;
						}
						function ft(t, e, n, i, r, o) {
							for (var s = 0; s < t; s++) {
								var a = n[s],
									l = i[s],
									c = new Array(l.length);
								(c = a.length > 0 ? ht(a) : e[Math.floor(o() * e.length)]),
									(r = !ot(c, l)),
									(i[s] = c);
							}
							return r;
						}
						function dt(t, e, n) {
							var i =
									arguments.length > 3 && void 0 !== arguments[3]
										? arguments[3]
										: 10,
								r =
									arguments.length > 4 && void 0 !== arguments[4]
										? arguments[4]
										: "linear";
							(t = t),
								(e = e || Math.max(2, Math.ceil(Math.sqrt(t.length / 2))));
							var o = n || "euclidean";
							"string" == typeof o && (o = st[o]);
							for (
								var s = 0,
									a = function () {
										return (s = (9301 * s + 49297) % 233280) / 233280;
									},
									l = lt(t, e, r),
									c = !0,
									h = 0;
								c;

							) {
								var u = ut(e, t, l, o);
								if (((c = ft(e, t, u, l, !1, a)), ++h % i == 0)) break;
							}
							return l;
						}
						var pt = {
								create: function (t, e) {
									var n = document.createElement("canvas");
									return (n.width = t || 0), (n.height = e || 0), n;
								},
								drawPixels: function (t) {
									var e = this.create(t.width, t.height),
										n = e.getContext("2d"),
										i = n.getImageData(0, 0, e.width, e.height);
									return i.data.set(t.pixels), n.putImageData(i, 0, 0), e;
								},
								createHistogram: function (t, e, n, i) {
									var r =
											arguments.length > 4 && void 0 !== arguments[4]
												? arguments[4]
												: { black: !0, red: !1, green: !1, blue: !1 },
										o = this.create(t, e),
										s = o.getContext("2d");
									s.clearRect(0, 0, t, e),
										(s.fillStyle = "white"),
										s.fillRect(0, 0, t, e),
										(s.globalAlpha = 0.7);
									var a = { black: !1 };
									r.black ? (a.black = !1) : (a.black = !0),
										r.red ? (a.red = !1) : (a.red = !0),
										r.green ? (a.green = !1) : (a.green = !0),
										r.blue ? (a.blue = !1) : (a.blue = !0),
										Object.keys(n).forEach(function (i) {
											if (!a[i]) {
												var r = n[i],
													o = Math.max.apply(Math, r),
													l = t / r.length;
												(s.fillStyle = i),
													r.forEach(function (t, n) {
														var i = e * (t / o),
															r = n * l;
														s.fillRect(r, e - i, l, i);
													});
											}
										}),
										"function" == typeof i && i(o);
								},
								getHistogram: function (t) {
									for (
										var e = new Array(256),
											n = new Array(256),
											i = new Array(256),
											r = new Array(256),
											o = 0;
										o < 256;
										o++
									)
										(e[o] = 0), (n[o] = 0), (i[o] = 0), (r[o] = 0);
									return (
										(function (t, e) {
											!(function (t, e) {
												for (var n = 0; n < t; n += 4) e(n);
											})(t.pixels.length, function (n) {
												e(t.pixels, n);
											});
										})(t, function (t, o) {
											var s = Math.round(
												Ze.brightness(t[o], t[o + 1], t[o + 2])
											);
											e[s]++, n[t[o]]++, i[t[o + 1]]++, r[t[o + 2]]++;
										}),
										{ black: e, red: n, green: i, blue: r }
									);
								},
								getBitmap: function (t, e) {
									var n = this.drawPixels(t);
									return {
										pixels: n
											.getContext("2d")
											.getImageData(
												e.x || 0,
												e.y || 0,
												e.width || n.width,
												e.height || n.height
											).data,
										width: e.width,
										height: e.height,
									};
								},
								putBitmap: function (t, e, n) {
									var i = this.drawPixels(t),
										r = this.drawPixels(e),
										o = i.getContext("2d");
									return (
										o.drawImage(r, n.x, n.y),
										(t.pixels = o.getImageData(0, 0, t.width, t.height).data),
										t
									);
								},
							},
							gt = (function () {
								function t(e) {
									var n =
										arguments.length > 1 && void 0 !== arguments[1]
											? arguments[1]
											: {};
									_(this, t),
										(this.isLoaded = !1),
										(this.imageUrl = e),
										(this.opt = n),
										this.initialize();
								}
								return (
									y(t, [
										{
											key: "initialize",
											value: function () {
												(this.canvas = this.createCanvas()),
													(this.context = this.canvas.getContext("2d"));
											},
										},
										{
											key: "createCanvas",
											value: function () {
												return document.createElement("canvas");
											},
										},
										{
											key: "load",
											value: function (t) {
												this.loadImage(t);
											},
										},
										{
											key: "loadImage",
											value: function (t) {
												var e = this,
													n = this.context;
												this.newImage = new Image();
												var i = this.newImage;
												(i.onload = function () {
													var r = i.height / i.width;
													e.opt.canvasWidth && e.opt.canvasHeight
														? ((e.canvas.width = e.opt.canvasWidth),
														  (e.canvas.height = e.opt.canvasHeight))
														: ((e.canvas.width = e.opt.maxWidth
																? e.opt.maxWidth
																: i.width),
														  (e.canvas.height = e.canvas.width * r)),
														n.drawImage(
															i,
															0,
															0,
															i.width,
															i.height,
															0,
															0,
															e.canvas.width,
															e.canvas.height
														),
														(e.isLoaded = !0),
														t && t();
												}),
													this.getImageUrl(function (t) {
														i.src = t;
													});
											},
										},
										{
											key: "load",
											value: function (t) {
												var e = this;
												this.newImage = new Image();
												var n = this.newImage;
												(n.onload = function () {
													(e.isLoaded = !0), t && t();
												}),
													this.getImageUrl(function (t) {
														n.src = t;
													});
											},
										},
										{
											key: "getImageUrl",
											value: function (t) {
												if ("string" == typeof this.imageUrl)
													return t(this.imageUrl);
												if (this.imageUrl instanceof Blob) {
													var e = new FileReader();
													(e.onload = function (e) {
														t(e.target.result);
													}),
														e.readAsDataURL(this.imageUrl);
												}
											},
										},
										{
											key: "getRGBA",
											value: function (t, e, n, i) {
												return [t, e, n, i];
											},
										},
										{
											key: "toArray",
											value: function (t, e) {
												var n =
														arguments.length > 2 && void 0 !== arguments[2]
															? arguments[2]
															: {},
													i = this.context.getImageData(
														0,
														0,
														this.canvas.width,
														this.canvas.height
													),
													r = i.width,
													o = i.height,
													s = new Uint8ClampedArray(i.data),
													a = { pixels: s, width: r, height: o };
												t ||
													(t = function (t, e) {
														e(t);
													}),
													t(
														a,
														function (t) {
															var i = pt.drawPixels(t);
															"canvas" == n.returnTo
																? e(i)
																: e(i.toDataURL(n.outputFormat || "image/png"));
														},
														n
													);
											},
										},
										{
											key: "toHistogram",
											value: function (t) {
												var e = this.context.getImageData(
														0,
														0,
														this.canvas.width,
														this.canvas.height
													),
													n = e.width,
													i = e.height,
													r = {
														pixels: new Uint8ClampedArray(e.data),
														width: n,
														height: i,
													};
												return pt.getHistogram(r);
											},
										},
										{
											key: "toRGB",
											value: function () {
												for (
													var t = this.context.getImageData(
															0,
															0,
															this.canvas.width,
															this.canvas.height
														).data,
														e = [],
														n = 0,
														i = t.length;
													n < i;
													n += 4
												)
													e[e.length] = [
														t[n + 0],
														t[n + 1],
														t[n + 2],
														t[n + 3],
													];
												return e;
											},
										},
									]),
									t
								);
							})(),
							mt = {
								identity: function () {
									return [1, 0, 0, 0, 1, 0, 0, 0, 1];
								},
								stretching: function (t) {
									return [t, 0, 0, 0, 1, 0, 0, 0, 1];
								},
								squeezing: function (t) {
									return [t, 0, 0, 0, 1 / t, 0, 0, 0, 1];
								},
								scale: function () {
									var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 1,
										e =
											arguments.length > 1 && void 0 !== arguments[1]
												? arguments[1]
												: 1;
									return [
										(t = t || 0 === t ? t : 1),
										0,
										0,
										0,
										(e = e || 0 === e ? e : 1),
										0,
										0,
										0,
										1,
									];
								},
								scaleX: function (t) {
									return this.scale(t);
								},
								scaleY: function (t) {
									return this.scale(1, t);
								},
								translate: function (t, e) {
									return [1, 0, t, 0, 1, e, 0, 0, 1];
								},
								rotate: function (t) {
									var e = this.radian(t);
									return [
										Math.cos(e),
										-Math.sin(e),
										0,
										Math.sin(e),
										Math.cos(e),
										0,
										0,
										0,
										1,
									];
								},
								rotate90: function () {
									return [0, -1, 0, 1, 0, 0, 0, 0, 1];
								},
								rotate180: function () {
									return [-1, 0, 0, 0, -1, 0, 0, 0, 1];
								},
								rotate270: function () {
									return [0, 1, 0, -1, 0, 0, 0, 0, 1];
								},
								radian: function (t) {
									return (t * Math.PI) / 180;
								},
								skew: function (t, e) {
									var n = this.radian(t),
										i = this.radian(e);
									return [1, Math.tan(n), 0, Math.tan(i), 1, 0, 0, 0, 1];
								},
								skewX: function (t) {
									var e = this.radian(t);
									return [1, Math.tan(e), 0, 0, 1, 0, 0, 0, 1];
								},
								skewY: function (t) {
									var e = this.radian(t);
									return [1, 0, 0, Math.tan(e), 1, 0, 0, 0, 1];
								},
								shear1: function (t) {
									return [
										1,
										-Math.tan(this.radian(t) / 2),
										0,
										0,
										1,
										0,
										0,
										0,
										1,
									];
								},
								shear2: function (t) {
									return [1, 0, 0, Math.sin(this.radian(t)), 1, 0, 0, 0, 1];
								},
							},
							vt = {
								CONSTANT: mt,
								radian: function (t) {
									return mt.radian(t);
								},
								multiply: function (t, e) {
									return [
										t[0] * e[0] + t[1] * e[1] + t[2] * e[2],
										t[3] * e[0] + t[4] * e[1] + t[5] * e[2],
										t[6] * e[0] + t[7] * e[1] + t[8] * e[2],
									];
								},
								identity: function (t) {
									return this.multiply(mt.identity(), t);
								},
								translate: function (t, e, n) {
									return this.multiply(mt.translate(t, e), n);
								},
								rotate: function (t, e) {
									return this.multiply(mt.rotate(t), e);
								},
								shear1: function (t, e) {
									return this.multiply(mt.shear1(t), e);
								},
								shear2: function (t, e) {
									return this.multiply(mt.shear2(t), e);
								},
								rotateShear: function (t, e) {
									var n = e;
									return (
										(n = this.shear1(t, n)),
										(n = this.shear2(t, n)),
										(n = this.shear1(t, n))
									);
								},
							};
						function _t(t) {
							var e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: "center",
								n =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: "center";
							return function (i, r) {
								var o =
										arguments.length > 2 && void 0 !== arguments[2]
											? arguments[2]
											: {},
									s = Vt(i.pixels.length, i.width, i.height),
									a = i.width,
									l = i.height;
								"center" == e && (e = Math.floor(a / 2)),
									"center" == n && (n = Math.floor(l / 2));
								var c = vt.CONSTANT.translate(-e, -n),
									h = vt.CONSTANT.translate(e, n),
									u = vt.CONSTANT.shear1(t),
									f = vt.CONSTANT.shear2(t);
								ae(function (t, e, n, r) {
									var o = vt.multiply(c, [n, r, 1]);
									(o = vt.multiply(u, o).map(Math.round)),
										(o = vt.multiply(f, o).map(Math.round)),
										(o = vt.multiply(u, o).map(Math.round)),
										(o = vt.multiply(h, o));
									var s = w(o, 2),
										d = s[0],
										p = s[1];
									d < 0 ||
										p < 0 ||
										d > a - 1 ||
										p > l - 1 ||
										he(t, (p * a + d) << 2, i.pixels, e);
								})(
									s,
									function () {
										r(s);
									},
									o
								);
							};
						}
						function yt() {
							var t =
									arguments.length > 0 && void 0 !== arguments[0]
										? arguments[0]
										: 200,
								e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: 100,
								n =
									!(arguments.length > 2 && void 0 !== arguments[2]) ||
									arguments[2],
								i = Jt(t),
								r = (e = Jt(e)) / 100,
								o = n;
							return re(
								"\n        // refer to Color.brightness \n        const v = ($C * Math.ceil($r * 0.2126 + $g * 0.7152 + $b * 0.0722) ) >= $scale ? 255 : 0;\n\n        if ($hasColor) {\n\n            if (v == 0) {\n                $r = 0 \n                $g = 0 \n                $b = 0\n            }\n            \n        } else {\n            const value = Math.round(v)\n            $r = value \n            $g = value \n            $b = value \n        }\n        \n    ",
								{ $C: r, $scale: i, $hasColor: o }
							);
						}
						function xt() {
							var t =
									arguments.length > 0 && void 0 !== arguments[0]
										? arguments[0]
										: 100,
								e = (t = Jt(t)) / 100;
							return de(Ht([1, 2, 1, 2, 4, 2, 1, 2, 1], (1 / 16) * e));
						}
						function kt() {
							var t =
									arguments.length > 0 && void 0 !== arguments[0]
										? arguments[0]
										: 100,
								e = (t = Jt(t)) / 100;
							return de(
								Ht(
									[
										1, 4, 6, 4, 1, 4, 16, 24, 16, 4, 6, 24, 36, 24, 6, 4, 16,
										24, 16, 4, 1, 4, 6, 4, 1,
									],
									(1 / 256) * e
								)
							);
						}
						function bt() {
							var t =
								arguments.length > 0 && void 0 !== arguments[0]
									? arguments[0]
									: 1;
							return (t = Jt(t)), de([5, 5, 5, -3, 0, -3, -3, -3, -3]);
						}
						function Tt() {
							var t =
								arguments.length > 0 && void 0 !== arguments[0]
									? arguments[0]
									: 1;
							return (t = Jt(t)), de([5, -3, -3, 5, 0, -3, 5, -3, -3]);
						}
						function Ct() {
							var t =
								arguments.length > 0 && void 0 !== arguments[0]
									? arguments[0]
									: 100;
							return de(
								Ht(
									[
										-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 24, -1, -1,
										-1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
									],
									(t = Jt(t)) / 100
								)
							);
						}
						function wt() {
							return de(
								Ht(
									[
										1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0,
										1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0,
										1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0,
										1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0,
										1,
									],
									1 / 9
								)
							);
						}
						function Et() {
							return de(
								Ht(
									[
										1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0,
										1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0,
										1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0,
										1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0,
										1,
									],
									1 / 9
								)
							);
						}
						function St() {
							return de(
								Ht(
									[
										1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0,
										1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1,
										1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0,
										1, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0,
										1,
									],
									1 / 9
								)
							);
						}
						function At() {
							return de([-1, -2, -1, 0, 0, 0, 1, 2, 1]);
						}
						function Lt() {
							return de([-1, 0, 1, -2, 0, 2, -1, 0, 1]);
						}
						var Ot = [
								512, 512, 456, 512, 328, 456, 335, 512, 405, 328, 271, 456, 388,
								335, 292, 512, 454, 405, 364, 328, 298, 271, 496, 456, 420, 388,
								360, 335, 312, 292, 273, 512, 482, 454, 428, 405, 383, 364, 345,
								328, 312, 298, 284, 271, 259, 496, 475, 456, 437, 420, 404, 388,
								374, 360, 347, 335, 323, 312, 302, 292, 282, 273, 265, 512, 497,
								482, 468, 454, 441, 428, 417, 405, 394, 383, 373, 364, 354, 345,
								337, 328, 320, 312, 305, 298, 291, 284, 278, 271, 265, 259, 507,
								496, 485, 475, 465, 456, 446, 437, 428, 420, 412, 404, 396, 388,
								381, 374, 367, 360, 354, 347, 341, 335, 329, 323, 318, 312, 307,
								302, 297, 292, 287, 282, 278, 273, 269, 265, 261, 512, 505, 497,
								489, 482, 475, 468, 461, 454, 447, 441, 435, 428, 422, 417, 411,
								405, 399, 394, 389, 383, 378, 373, 368, 364, 359, 354, 350, 345,
								341, 337, 332, 328, 324, 320, 316, 312, 309, 305, 301, 298, 294,
								291, 287, 284, 281, 278, 274, 271, 268, 265, 262, 259, 257, 507,
								501, 496, 491, 485, 480, 475, 470, 465, 460, 456, 451, 446, 442,
								437, 433, 428, 424, 420, 416, 412, 408, 404, 400, 396, 392, 388,
								385, 381, 377, 374, 370, 367, 363, 360, 357, 354, 350, 347, 344,
								341, 338, 335, 332, 329, 326, 323, 320, 318, 315, 312, 310, 307,
								304, 302, 299, 297, 294, 292, 289, 287, 285, 282, 280, 278, 275,
								273, 271, 269, 267, 265, 263, 261, 259,
							],
							Nt = [
								9, 11, 12, 13, 13, 14, 14, 15, 15, 15, 15, 16, 16, 16, 16, 17,
								17, 17, 17, 17, 17, 17, 18, 18, 18, 18, 18, 18, 18, 18, 18, 19,
								19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 20, 20, 20,
								20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 21,
								21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21,
								21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 22, 22, 22, 22, 22, 22,
								22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22,
								22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 23,
								23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23,
								23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23,
								23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23,
								23, 23, 23, 23, 23, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24,
								24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24,
								24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24,
								24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24,
								24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24,
							];
						function It() {
							(this.r = 0),
								(this.g = 0),
								(this.b = 0),
								(this.a = 0),
								(this.next = null);
						}
						function Mt(t, e, n) {
							return n
								? (function (t, e, n, i) {
										if (isNaN(i) || i < 1) return t;
										i |= 0;
										var r,
											o,
											s,
											a,
											l,
											c,
											h,
											u,
											f,
											d,
											p,
											g,
											m,
											v,
											_,
											y,
											x,
											k,
											b,
											T,
											C = t.pixels,
											w = t.width,
											E = t.height,
											S = i + i + 1,
											A = w - 1,
											L = E - 1,
											O = i + 1,
											N = (O * (O + 1)) / 2,
											I = new It(),
											M = I;
										for (s = 1; s < S; s++)
											if (((M = M.next = new It()), s == O)) var $ = M;
										M.next = I;
										var R = null,
											D = null;
										h = c = 0;
										var P = Ot[i],
											F = Nt[i];
										for (o = 0; o < E; o++) {
											for (
												v = _ = y = u = f = d = 0,
													p = O * (x = C[c]),
													g = O * (k = C[c + 1]),
													m = O * (b = C[c + 2]),
													u += N * x,
													f += N * k,
													d += N * b,
													M = I,
													s = 0;
												s < O;
												s++
											)
												(M.r = x), (M.g = k), (M.b = b), (M = M.next);
											for (s = 1; s < O; s++)
												(a = c + ((A < s ? A : s) << 2)),
													(u += (M.r = x = C[a]) * (T = O - s)),
													(f += (M.g = k = C[a + 1]) * T),
													(d += (M.b = b = C[a + 2]) * T),
													(v += x),
													(_ += k),
													(y += b),
													(M = M.next);
											for (R = I, D = $, r = 0; r < w; r++)
												(C[c] = (u * P) >> F),
													(C[c + 1] = (f * P) >> F),
													(C[c + 2] = (d * P) >> F),
													(u -= p),
													(f -= g),
													(d -= m),
													(p -= R.r),
													(g -= R.g),
													(m -= R.b),
													(a = (h + ((a = r + i + 1) < A ? a : A)) << 2),
													(u += v += R.r = C[a]),
													(f += _ += R.g = C[a + 1]),
													(d += y += R.b = C[a + 2]),
													(R = R.next),
													(p += x = D.r),
													(g += k = D.g),
													(m += b = D.b),
													(v -= x),
													(_ -= k),
													(y -= b),
													(D = D.next),
													(c += 4);
											h += w;
										}
										for (r = 0; r < w; r++) {
											for (
												_ = y = v = f = d = u = 0,
													p = O * (x = C[(c = r << 2)]),
													g = O * (k = C[c + 1]),
													m = O * (b = C[c + 2]),
													u += N * x,
													f += N * k,
													d += N * b,
													M = I,
													s = 0;
												s < O;
												s++
											)
												(M.r = x), (M.g = k), (M.b = b), (M = M.next);
											for (l = w, s = 1; s <= i; s++)
												(c = (l + r) << 2),
													(u += (M.r = x = C[c]) * (T = O - s)),
													(f += (M.g = k = C[c + 1]) * T),
													(d += (M.b = b = C[c + 2]) * T),
													(v += x),
													(_ += k),
													(y += b),
													(M = M.next),
													s < L && (l += w);
											for (c = r, R = I, D = $, o = 0; o < E; o++)
												(C[(a = c << 2)] = (u * P) >> F),
													(C[a + 1] = (f * P) >> F),
													(C[a + 2] = (d * P) >> F),
													(u -= p),
													(f -= g),
													(d -= m),
													(p -= R.r),
													(g -= R.g),
													(m -= R.b),
													(a = (r + ((a = o + O) < L ? a : L) * w) << 2),
													(u += v += R.r = C[a]),
													(f += _ += R.g = C[a + 1]),
													(d += y += R.b = C[a + 2]),
													(R = R.next),
													(p += x = D.r),
													(g += k = D.g),
													(m += b = D.b),
													(v -= x),
													(_ -= k),
													(y -= b),
													(D = D.next),
													(c += w);
										}
										return t;
								  })(t, 0, 0, e)
								: stackBlurCanvasRGB(t, 0, 0, e);
						}
						function $t() {
							var t =
									arguments.length > 0 && void 0 !== arguments[0]
										? arguments[0]
										: 10,
								e =
									!(arguments.length > 1 && void 0 !== arguments[1]) ||
									arguments[1];
							return (
								(t = Jt(t)),
								function (n, i) {
									i(Mt(n, t, e));
								}
							);
						}
						function Rt() {
							var t =
								arguments.length > 0 && void 0 !== arguments[0]
									? arguments[0]
									: 256;
							return de(
								Ht(
									[
										1, 4, 6, 4, 1, 4, 16, 24, 16, 4, 6, 24, -476, 24, 6, 4, 16,
										24, 16, 4, 1, 4, 6, 4, 1,
									],
									-1 / (t = Jt(t))
								)
							);
						}
						var Dt,
							Pt = k(
								{},
								{
									crop: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 0,
											e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 0,
											n = arguments[2],
											i = arguments[3],
											r = Vt(n * i * 4, n, i);
										return function (o, s) {
											for (var a = e, l = 0; a < i; a++, l++)
												for (var c = t, h = 0; c < n; c++, h++)
													r.pixels[l * n * h] = o.pixels[a * n * c];
											s(r);
										};
									},
									resize: function (t, e) {
										return function (n, i) {
											var r = pt.drawPixels(n),
												o = r.getContext("2d");
											(r.width = t),
												(r.height = e),
												i({
													pixels: new Uint8ClampedArray(
														o.getImageData(0, 0, t, e).data
													),
													width: t,
													height: e,
												});
										};
									},
									flipH: function () {
										return function (t, e) {
											for (
												var n = t.width,
													i = t.height,
													r = n % 2 == 1 ? Math.floor(n / 2) : n / 2,
													o = 0;
												o < i;
												o++
											)
												for (var s = 0; s < r; s++) {
													var a = (o * n + s) << 2,
														l = (o * n + (n - 1 - s)) << 2;
													se(t.pixels, a, l);
												}
											e(t);
										};
									},
									flipV: function () {
										return function (t, e) {
											for (
												var n = t.width,
													i = t.height,
													r = i % 2 == 1 ? Math.floor(i / 2) : i / 2,
													o = 0;
												o < r;
												o++
											)
												for (var s = 0; s < n; s++) {
													var a = (o * n + s) << 2,
														l = ((i - 1 - o) * n + s) << 2;
													se(t.pixels, a, l);
												}
											e(t);
										};
									},
									rotate: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 0;
										return (
											(t = Jt(t)),
											(t %= 360),
											function (e, n) {
												var i =
													arguments.length > 2 && void 0 !== arguments[2]
														? arguments[2]
														: {};
												if (0 == t) return e;
												if (90 == t || 270 == t)
													var r = Vt(e.pixels.length, e.height, e.width);
												else {
													if (180 != t) return _t(t)(e, n, i);
													r = Vt(e.pixels.length, e.width, e.height);
												}
												ae(function (n, i, o, s) {
													if (90 == t)
														var a = (o * r.width + (r.width - 1 - s)) << 2;
													else
														270 == t
															? (a = ((r.height - 1 - o) * r.width + s) << 2)
															: 180 == t &&
															  (a =
																	((r.height - 1 - s) * r.width +
																		(r.width - 1 - o)) <<
																	2);
													he(r.pixels, a, e.pixels, i);
												})(
													e,
													function () {
														n(r);
													},
													i
												);
											}
										);
									},
									rotateDegree: _t,
									histogram: function () {
										for (
											var t =
													arguments.length > 0 && void 0 !== arguments[0]
														? arguments[0]
														: "gray",
												e =
													arguments.length > 1 && void 0 !== arguments[1]
														? arguments[1]
														: [],
												n = [],
												i = 0;
											i < e.length - 1;
											i++
										)
											for (
												var r = e[i],
													o = e[i + 1],
													s = o[0] - r[0],
													a = o[1] - r[1],
													l = a / s,
													c = 0,
													h = r[0];
												c < s;
												c++, h++
											)
												n[h] = r[1] + c * l;
										return (
											(n[255] = 255),
											re(
												"red" === t
													? function () {
															$r = n[$r];
													  }
													: "green" === t
													? function () {
															$g = n[$g];
													  }
													: "blue" === t
													? function () {
															$b = n[$b];
													  }
													: function () {
															var t = Color.RGBtoYCrCb($r, $g, $b),
																e = Color.YCrCbtoRGB(
																	clamp(n[clamp(t.y)]),
																	t.cr,
																	t.cb,
																	0
																);
															($r = e.r), ($g = e.g), ($b = e.b);
													  },
												{},
												{ $realPoints: n }
											)
										);
									},
									"rotate-degree": _t,
								},
								{
									bitonal: function (t, e) {
										var n =
												arguments.length > 2 && void 0 !== arguments[2]
													? arguments[2]
													: 100,
											i = Ze.parse(t),
											r = Ze.parse(e),
											o = n;
										return re(
											"\n        const thresholdColor = ( $r + $g + $b ) <= $threshold ? $darkColor : $lightColor\n\n        $r = thresholdColor.r\n        $g = thresholdColor.g \n        $b = thresholdColor.b \n    ",
											{ $threshold: o },
											{ $darkColor: i, $lightColor: r }
										);
									},
									brightness: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 1;
										t = Jt(t);
										var e = Math.floor((t / 100) * 255);
										return re(
											"\n        $r += $C \n        $g += $C \n        $b += $C \n    ",
											{ $C: e }
										);
									},
									brownie: function () {
										return re(
											"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a        \n    ",
											{
												$matrix: [
													0.5997023498159715, 0.34553243048391263,
													-0.2708298674538042, 0, -0.037703249837783157,
													0.8609577587992641, 0.15059552388459913, 0,
													0.24113635128153335, -0.07441037908422492,
													0.44972182064877153, 0, 0, 0, 0, 1,
												],
											}
										);
									},
									clip: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 0;
										t = Jt(t);
										var e = 2.55 * Math.abs(t);
										return re(
											"\n\n        $r = ($r > 255 - $C) ? 255 : 0\n        $g = ($g > 255 - $C) ? 255 : 0\n        $b = ($b > 255 - $C) ? 255 : 0\n\n    ",
											{ $C: e }
										);
									},
									contrast: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 0;
										t = Jt(t);
										var e = Math.max((128 + t) / 128, 0);
										return re(
											"\n        $r *= $C\n        $g *= $C\n        $b *= $C\n    ",
											{ $C: e }
										);
									},
									gamma: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Jt(t);
										return re(
											"\n        $r = Math.pow($r / 255, $C) * 255\n        $g = Math.pow($g / 255, $C) * 255\n        $b = Math.pow($b / 255, $C) * 255\n    ",
											{ $C: e }
										);
									},
									gradient: function () {
										var t = [].concat(Array.prototype.slice.call(arguments));
										1 === t.length &&
											"string" == typeof t[0] &&
											(t = Ze.convertMatchesArray(t[0]));
										var e = (t = t.map(function (t) {
											return Ze.matches(t).length
												? { type: "param", value: t }
												: { type: "scale", value: t };
										})).filter(function (t) {
											return "scale" == t.type;
										})[0];
										(e = e ? +e.value : 256),
											(t = t
												.filter(function (t) {
													return "param" == t.type;
												})
												.map(function (t) {
													return t.value;
												})
												.join(","));
										var n = Ze.gradient(t, e).map(function (t) {
											var e = Ze.parse(t);
											return { r: e.r, g: e.g, b: e.b, a: e.a };
										});
										return re(
											"\n        const colorIndex = clamp(Math.ceil($r * 0.2126 + $g * 0.7152 + $b * 0.0722))\n        const newColorIndex = clamp(Math.floor(colorIndex * ($scale / 256)))\n        const color = $colors[newColorIndex]\n\n        $r = color.r \n        $g = color.g \n        $b = color.b \n        $a = clamp(Math.floor(color.a * 256))\n    ",
											{},
											{ $colors: n, $scale: e }
										);
									},
									grayscale: function (t) {
										var e = (t = Jt(t)) / 100;
										return (
											e > 1 && (e = 1),
											re(
												"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a\n    ",
												{
													$matrix: [
														0.2126 + 0.7874 * (1 - e),
														0.7152 - 0.7152 * (1 - e),
														0.0722 - 0.0722 * (1 - e),
														0,
														0.2126 - 0.2126 * (1 - e),
														0.7152 + 0.2848 * (1 - e),
														0.0722 - 0.0722 * (1 - e),
														0,
														0.2126 - 0.2126 * (1 - e),
														0.7152 - 0.7152 * (1 - e),
														0.0722 + 0.9278 * (1 - e),
														0,
														0,
														0,
														0,
														1,
													],
												}
											)
										);
									},
									hue: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 360,
											e = Jt(t);
										return re(
											"\n        var hsv = Color.RGBtoHSV($r, $g, $b);\n\n        // 0 ~ 360 \n        var h = hsv.h;\n        h += Math.abs($C)\n        h = h % 360\n        hsv.h = h\n\n        var rgb = Color.HSVtoRGB(hsv);\n\n        $r = rgb.r\n        $g = rgb.g\n        $b = rgb.b\n    ",
											{ $C: e }
										);
									},
									invert: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 100,
											e = (t = Jt(t)) / 100;
										return re(
											"\n        $r = (255 - $r) * $C\n        $g = (255 - $g) * $C\n        $b = (255 - $b) * $C\n    ",
											{ $C: e }
										);
									},
									kodachrome: function () {
										return re(
											"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a        \n    ",
											{
												$matrix: [
													1.1285582396593525, -0.3967382283601348,
													-0.03992559172921793, 0, -0.16404339962244616,
													1.0835251566291304, -0.05498805115633132, 0,
													-0.16786010706155763, -0.5603416277695248,
													1.6014850761964943, 0, 0, 0, 0, 1,
												],
											}
										);
									},
									matrix: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 0,
											e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 0,
											n =
												arguments.length > 2 && void 0 !== arguments[2]
													? arguments[2]
													: 0,
											i =
												arguments.length > 3 && void 0 !== arguments[3]
													? arguments[3]
													: 0,
											r =
												arguments.length > 4 && void 0 !== arguments[4]
													? arguments[4]
													: 0,
											o =
												arguments.length > 5 && void 0 !== arguments[5]
													? arguments[5]
													: 0,
											s =
												arguments.length > 6 && void 0 !== arguments[6]
													? arguments[6]
													: 0,
											a =
												arguments.length > 7 && void 0 !== arguments[7]
													? arguments[7]
													: 0,
											l =
												arguments.length > 8 && void 0 !== arguments[8]
													? arguments[8]
													: 0,
											c =
												arguments.length > 9 && void 0 !== arguments[9]
													? arguments[9]
													: 0,
											h =
												arguments.length > 10 && void 0 !== arguments[10]
													? arguments[10]
													: 0,
											u =
												arguments.length > 11 && void 0 !== arguments[11]
													? arguments[11]
													: 0,
											f =
												arguments.length > 12 && void 0 !== arguments[12]
													? arguments[12]
													: 0,
											d =
												arguments.length > 13 && void 0 !== arguments[13]
													? arguments[13]
													: 0,
											p =
												arguments.length > 14 && void 0 !== arguments[14]
													? arguments[14]
													: 0,
											g =
												arguments.length > 15 && void 0 !== arguments[15]
													? arguments[15]
													: 0,
											m = [t, e, n, i, r, o, s, a, l, c, h, u, f, d, p, g];
										return re(
											"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a        \n    ",
											{ $matrix: m }
										);
									},
									noise: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Jt(t);
										return re(
											"\n        const C = Math.abs($C) * 5\n        const min = -C\n        const max = C \n        const noiseValue = Math.round(min + (Math.random() * (max - min)))\n\n        $r += noiseValue\n        $g += noiseValue\n        $b += noiseValue\n    ",
											{ $C: e }
										);
									},
									opacity: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 100,
											e = (t = Jt(t)) / 100;
										return re("\n        $a *= $C \n    ", { $C: e });
									},
									polaroid: function () {
										return re(
											"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a        \n    ",
											{
												$matrix: [
													1.438, -0.062, -0.062, 0, -0.122, 1.378, -0.122, 0,
													-0.016, -0.016, 1.483, 0, 0, 0, 0, 1,
												],
											}
										);
									},
									saturation: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 100,
											e = (t = Jt(t)) / 100,
											n = 1 - Math.abs(e),
											i = [n, 0, 0, 0, 0, n, 0, 0, 0, 0, n, 0, 0, 0, 0, n];
										return re(
											"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a        \n    ",
											{ $matrix: i }
										);
									},
									sepia: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Jt(t);
										e > 1 && (e = 1);
										var n = [
											0.393 + 0.607 * (1 - e),
											0.769 - 0.769 * (1 - e),
											0.189 - 0.189 * (1 - e),
											0,
											0.349 - 0.349 * (1 - e),
											0.686 + 0.314 * (1 - e),
											0.168 - 0.168 * (1 - e),
											0,
											0.272 - 0.272 * (1 - e),
											0.534 - 0.534 * (1 - e),
											0.131 + 0.869 * (1 - e),
											0,
											0,
											0,
											0,
											1,
										];
										return re(
											"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a        \n    ",
											{ $matrix: n }
										);
									},
									shade: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 1,
											n =
												arguments.length > 2 && void 0 !== arguments[2]
													? arguments[2]
													: 1,
											i = Jt(t),
											r = Jt(e),
											o = Jt(n);
										return re(
											"\n        $r *= $redValue\n        $g *= $greenValue\n        $b *= $blueValue\n    ",
											{ $redValue: i, $greenValue: r, $blueValue: o }
										);
									},
									shift: function () {
										return re(
											"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a        \n    ",
											{
												$matrix: [
													1.438, -0.062, -0.062, 0, -0.122, 1.378, -0.122, 0,
													-0.016, -0.016, 1.483, 0, 0, 0, 0, 1,
												],
											}
										);
									},
									solarize: function (t, e, n) {
										return re(
											"\n        $r = ($r < $redValue) ? 255 - $r: $r\n        $g = ($g < $greenValue) ? 255 - $g: $g\n        $b = ($b < $blueValue) ? 255 - $b: $b\n    ",
											{
												$redValue: Jt(t),
												$greenValue: Jt(e),
												$blueValue: Jt(n),
											}
										);
									},
									technicolor: function () {
										return re(
											"\n        $r = $matrix[0] * $r + $matrix[1] * $g + $matrix[2] * $b + $matrix[3] * $a\n        $g = $matrix[4] * $r + $matrix[5] * $g + $matrix[6] * $b + $matrix[7] * $a\n        $b = $matrix[8] * $r + $matrix[9] * $g + $matrix[10] * $b + $matrix[11] * $a\n        $a = $matrix[12] * $r + $matrix[13] * $g + $matrix[14] * $b + $matrix[15] * $a        \n    ",
											{
												$matrix: [
													1.9125277891456083, -0.8545344976951645,
													-0.09155508482755585, 0, -0.3087833385928097,
													1.7658908555458428, -0.10601743074722245, 0,
													-0.231103377548616, -0.7501899197440212,
													1.847597816108189, 0, 0, 0, 0, 1,
												],
											}
										);
									},
									threshold: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 200,
											e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 100;
										return yt(t, e, !1);
									},
									"threshold-color": yt,
									tint: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 1,
											n =
												arguments.length > 2 && void 0 !== arguments[2]
													? arguments[2]
													: 1,
											i = Jt(t),
											r = Jt(e),
											o = Jt(n);
										return re(
											"\n\n        $r += (255 - $r) * $redTint\n        $g += (255 - $g) * $greenTint\n        $b += (255 - $b) * $blueTint\n\n    ",
											{ $redTint: i, $greenTint: r, $blueTint: o }
										);
									},
								},
								{
									blur: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 3;
										return de(le((t = Jt(t))));
									},
									emboss: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 4;
										return de([-2 * (t = Jt(t)), -t, 0, -t, 1, t, 0, t, 2 * t]);
									},
									gaussianBlur: xt,
									"gaussian-blur": xt,
									gaussianBlur5x: kt,
									"gaussian-blur-5x": kt,
									grayscale2: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 100;
										return de(
											Ht(
												[
													0.3, 0.3, 0.3, 0, 0, 0.59, 0.59, 0.59, 0, 0, 0.11,
													0.11, 0.11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
												],
												(t = Jt(t)) / 100
											)
										);
									},
									normal: function () {
										return de([0, 0, 0, 0, 1, 0, 0, 0, 0]);
									},
									kirschHorizontal: bt,
									"kirsch-horizontal": bt,
									kirschVertical: Tt,
									"kirsch-vertical": Tt,
									laplacian: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 100;
										return de(
											Ht([-1, -1, -1, -1, 8, -1, -1, -1, -1], (t = Jt(t)) / 100)
										);
									},
									laplacian5x: Ct,
									"laplacian-5x": Ct,
									motionBlur: wt,
									"motion-blur": wt,
									motionBlur2: Et,
									"motion-blur-2": Et,
									motionBlur3: St,
									"motion-blur-3": St,
									negative: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 100;
										return de(
											Ht(
												[
													-1, 0, 0, 0, 0, 0, -1, 0, 0, 0, 0, 0, -1, 0, 0, 0, 0,
													0, 1, 0, 1, 1, 1, 1, 1,
												],
												(t = Jt(t)) / 100
											)
										);
									},
									sepia2: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 100;
										return de(
											Ht(
												[
													0.393, 0.349, 0.272, 0, 0, 0.769, 0.686, 0.534, 0, 0,
													0.189, 0.168, 0.131, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
													0,
												],
												(t = Jt(t)) / 100
											)
										);
									},
									sharpen: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 100;
										return de(
											Ht([0, -1, 0, -1, 5, -1, 0, -1, 0], (t = Jt(t)) / 100)
										);
									},
									sobelHorizontal: At,
									"sobel-horizontal": At,
									sobelVertical: Lt,
									"sobel-vertical": Lt,
									stackBlur: $t,
									"stack-blur": $t,
									transparency: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 100;
										return de(
											Ht(
												[
													1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0,
													0.3, 0, 0, 0, 0, 0, 1,
												],
												(t = Jt(t)) / 100
											)
										);
									},
									unsharpMasking: Rt,
									"unsharp-masking": Rt,
								},
								{
									kirsch: function () {
										return ve("kirsch-horizontal kirsch-vertical");
									},
									sobel: function () {
										return ve("sobel-horizontal sobel-vertical");
									},
									vintage: function () {
										return ve("brightness(15) saturation(-20) gamma(1.8)");
									},
								}
							),
							Ft = 0,
							Bt =
								(x(
									(Dt = {
										partial: ke,
										multi: ye,
										merge: xe,
										weight: Ht,
										repeat: zt,
										colorMatrix: function (t, e, n) {
											var i = t[e],
												r = t[e + 1],
												o = t[e + 2],
												s = t[e + 3];
											ce(
												t,
												e,
												n[0] * i + n[1] * r + n[2] * o + n[3] * s,
												n[4] * i + n[5] * r + n[6] * o + n[7] * s,
												n[8] * i + n[9] * r + n[10] * o + n[11] * s,
												n[12] * i + n[13] * r + n[14] * o + n[15] * s
											);
										},
										each: Gt,
										eachXY: qt,
										createRandomCount: function () {
											return [9, 16, 25, 36, 49, 64, 81, 100].sort(function (
												t,
												e
											) {
												return 0.5 - Math.random();
											})[0];
										},
										createRandRange: function (t, e, n) {
											for (var i = [], r = 1; r <= n; r++) {
												var o = Math.random() * (e - t) + t,
													s = Math.floor(10 * Math.random()) % 2 == 0 ? -1 : 1;
												i.push(s * o);
											}
											i.sort();
											var a = Math.floor(n >> 1),
												l = i[a];
											return (i[a] = i[0]), (i[0] = l), i;
										},
										createBitmap: Vt,
										createBlurMatrix: le,
										pack: function (t) {
											return function (e, n) {
												Gt(
													e.pixels.length,
													function (n, i) {
														t(
															e.pixels,
															n,
															i,
															e.pixels[n],
															e.pixels[n + 1],
															e.pixels[n + 2],
															e.pixels[n + 3]
														);
													},
													function () {
														n(e);
													}
												);
											};
										},
										packXY: ae,
										pixel: re,
										getBitmap: Qt,
										putBitmap: Zt,
										radian: function (t) {
											return vt.CONSTANT.radian(t);
										},
										convolution: de,
										parseParamNumber: Jt,
										filter: ve,
										clamp: me,
										fillColor: ce,
										fillPixelColor: he,
									}),
									"multi",
									ye
								),
								x(Dt, "merge", xe),
								x(Dt, "matches", pe),
								x(Dt, "parseFilter", ge),
								x(Dt, "partial", ke),
								Dt),
							Ut = Bt;
						function Ht(t) {
							var e =
								arguments.length > 1 && void 0 !== arguments[1]
									? arguments[1]
									: 1;
							return t.map(function (t) {
								return t * e;
							});
						}
						function zt(t, e) {
							for (var n = new Array(e), i = 0; i < e; i++) n[i] = t;
							return n;
						}
						function Wt(t) {
							if ("function" == typeof t) return t;
							"string" == typeof t && (t = [t]);
							var e = (t = t.slice(0)).shift();
							if ("function" == typeof e) return e;
							var n = t,
								i = Pt[e] || Ut[e];
							if (!i)
								throw new Error(
									e + " is not filter. please check filter name."
								);
							return i.apply(i, n);
						}
						function jt(t) {
							var e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: 0,
								n =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: 1,
								i = arguments[3],
								r = arguments[4],
								o =
									arguments.length > 5 && void 0 !== arguments[5]
										? arguments[5]
										: 1e4,
								s =
									arguments.length > 6 && void 0 !== arguments[6]
										? arguments[6]
										: "full",
								a =
									arguments.length > 7 && void 0 !== arguments[7]
										? arguments[7]
										: 50,
								l = e,
								c = function (t) {
									setTimeout(t, 0);
								};
							function h() {
								var t =
										arguments.length > 0 && void 0 !== arguments[0]
											? arguments[0]
											: 50,
									e = [].concat(E(Array(t))),
									n = e
										.map(function (t) {
											return "cri = ri + i * s; if (cri >= mx) return {currentRunIndex: cri, i: null}; c(cri); i++;";
										})
										.join("\n"),
									i = new Function(
										"ri",
										"i",
										"s",
										"mx",
										"c",
										"\n            let cri = ri;\n            \n            " +
											n +
											"\n            \n            return {currentRunIndex: cri, i: i} \n        "
									);
								return i;
							}
							function u() {
								for (var e = h(a), r = l, s = {}, c = 0; c < o; ) {
									if (null == (s = e(l, c, n, t, i)).i) {
										r = s.currentRunIndex;
										break;
									}
									(c = s.i), (r = s.currentRunIndex);
								}
								f(r);
							}
							function f(e) {
								e ? (l = e) : (l += n), l >= t ? r() : c ? c(u) : u();
							}
							"requestAnimationFrame" == s &&
								((c = requestAnimationFrame), (o = 1e3)),
								"full" == s && ((c = null), (o = t)),
								u();
						}
						function Gt(t, e, n) {
							var i =
								arguments.length > 3 && void 0 !== arguments[3]
									? arguments[3]
									: {};
							jt(
								t,
								0,
								4,
								function (t) {
									e(t, t >> 2);
								},
								function () {
									n();
								},
								i.functionDumpCount,
								i.frameTimer,
								i.loopCount
							);
						}
						function qt(t, e, n, i) {
							var r =
								arguments.length > 4 && void 0 !== arguments[4]
									? arguments[4]
									: {};
							jt(
								t,
								0,
								4,
								function (t) {
									var i = t >> 2;
									n(t, i % e, Math.floor(i / e));
								},
								function () {
									i();
								},
								r.functionDumpCount,
								r.frameTimer,
								r.loopCount
							);
						}
						function Vt(t, e, n) {
							return { pixels: new Uint8ClampedArray(t), width: e, height: n };
						}
						function Yt(t, e, n, i) {
							for (
								var r = e.pixels.length / 4,
									o = 0,
									s = 0,
									a = 0,
									l = 0,
									c = 0,
									h = 0,
									u = 0;
								u < r;
								u++
							)
								(a = u % e.width),
									(s = i + (l = Math.floor(u / e.width))),
									(o = n + a) > t.width ||
										s > t.height ||
										((c = (l * e.width + a) << 2),
										(h = (s * t.width + o) << 2),
										(t.pixels[h] = e.pixels[c]),
										(t.pixels[h + 1] = e.pixels[c + 1]),
										(t.pixels[h + 2] = e.pixels[c + 2]),
										(t.pixels[h + 3] = e.pixels[c + 3]));
						}
						function Kt(t, e, n, i) {
							for (
								var r = e.pixels.length >> 2,
									o = 0,
									s = 0,
									a = 0,
									l = 0,
									c = 0,
									h = 0,
									u = 0;
								u < r;
								u++
							)
								(a = u % e.width),
									(s = i + (l = Math.floor(u / e.width))),
									(o = n + a) > t.width ||
										s > t.height ||
										((c = (s * t.width + o) << 2),
										(h = (l * e.width + a) << 2),
										(e.pixels[h] = t.pixels[c]),
										(e.pixels[h + 1] = t.pixels[c + 1]),
										(e.pixels[h + 2] = t.pixels[c + 2]),
										(e.pixels[h + 3] = t.pixels[c + 3]));
						}
						function Xt(t) {
							var e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: 0,
								n = t.width + e,
								i = t.height + e,
								r = {
									pixels: new Uint8ClampedArray(n * i * 4),
									width: n,
									height: i,
								};
							return r;
						}
						function Qt(t, e) {
							return pt.getBitmap(t, e);
						}
						function Zt(t, e, n) {
							return pt.putBitmap(t, e, n);
						}
						function Jt(t) {
							return (
								"string" == typeof t &&
									(t = (t = t.replace(/deg/, "")).replace(/px/, "")),
								+t
							);
						}
						var te = /(([\w_\-]+)(\(([^\)]*)\))?)+/gi;
						function ee(t) {
							var e = t
									.map(function (t) {
										return (
											" \n            " +
											t.userFunction.$preContext +
											"\n\n            " +
											t.userFunction.$preCallbackString +
											"\n\n            $r = clamp($r); $g = clamp($g); $b = clamp($b); $a = clamp($a);\n        "
										);
									})
									.join("\n\n"),
								n = { clamp: me, Color: Ze };
							t.forEach(function (t) {
								Object.assign(n, t.userFunction.rootContextObject);
							});
							var i =
									"const " +
									Object.keys(n)
										.map(function (t) {
											return " " + t + " = $rc." + t + " ";
										})
										.join(","),
								r = new Function(
									"$p",
									"$pi",
									"$rc",
									" \n    let $r = $p[$pi], $g = $p[$pi+1], $b = $p[$pi+2], $a = $p[$pi+3];\n    \n    " +
										i +
										"\n\n    " +
										e +
										"\n    \n    $p[$pi] = $r; $p[$pi+1] = $g; $p[$pi+2] = $b; $p[$pi+3] = $a;\n    "
								);
							return function (t, e) {
								r(t, e, n);
							};
						}
						function ne(t) {
							var e = {},
								n = t.map(function (t) {
									var n = [];
									Object.keys(t.context).forEach(function (t, e) {
										n[t] = "n$" + Ft++ + t + "$";
									}),
										Object.keys(t.rootContext).forEach(function (i, r) {
											(n[i] = "r$" + Ft++ + i + "$"),
												(e[n[i]] = t.rootContext[i]);
										});
									var i = Object.keys(t.context)
											.filter(function (e) {
												return (
													"number" != typeof t.context[e] &&
													"string" != typeof t.context[e] &&
													(!Array.isArray(t.context[e]) ||
														("number" != typeof t.context[e][0] &&
															"string" != typeof t.context[e][0]))
												);
											})
											.map(function (e, i) {
												return [n[e], JSON.stringify(t.context[e])].join(" = ");
											}),
										r = t.callback;
									return (
										"function" == typeof t.callback &&
											((r = t.callback.toString().split("{")).shift(),
											(r = (r = r.join("{")).split("}")).pop(),
											(r = r.join("}"))),
										Object.keys(n).forEach(function (e) {
											var i = n[e];
											"number" == typeof t.context[e] ||
											"string" == typeof t.context[e]
												? (r = r.replace(
														new RegExp("\\" + e, "g"),
														t.context[e]
												  ))
												: !Array.isArray(t.context[e]) ||
												  ("number" != typeof t.context[e][0] &&
														"string" != typeof t.context[e][0])
												? (r = r.replace(new RegExp("\\" + e, "g"), i))
												: t.context[e].forEach(function (t, n) {
														r = r.replace(
															new RegExp("\\" + e + "\\[" + n + "\\]", "g"),
															t
														);
												  });
										}),
										{ preCallbackString: r, preContext: i }
									);
								}),
								i = n
									.map(function (t, e) {
										return t.preContext.length
											? "const " + t.preContext + ";"
											: "";
									})
									.join("\n\n"),
								r = n
									.map(function (t) {
										return t.preCallbackString;
									})
									.join("\n\n"),
								o = new Function(
									"$pixels",
									"$pixelIndex",
									"$clamp",
									"$Color",
									" \n    let $r = $pixels[$pixelIndex], $g = $pixels[$pixelIndex+1], $b = $pixels[$pixelIndex+2], $a = $pixels[$pixelIndex+3];\n\n    " +
										i +
										"\n\n    " +
										r +
										"\n    \n    $pixels[$pixelIndex] = $r\n    $pixels[$pixelIndex+1] = $g \n    $pixels[$pixelIndex+2] = $b   \n    $pixels[$pixelIndex+3] = $a   \n    "
								);
							return (
								(o.$preCallbackString = r),
								(o.$preContext = i),
								(o.rootContextObject = e),
								o
							);
						}
						function ie(t) {
							var e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: {},
								n =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: {};
							return ne([{ callback: t, context: e, rootContext: n }]);
						}
						function re(t) {
							var e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: {},
								n =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: {},
								i = ie(t, e, n),
								r = function (t, e) {};
							return (r.userFunction = i), r;
						}
						var oe = [0, 1, 2, 3];
						function se(t, e, n) {
							oe.forEach(function (i) {
								var r = t[e + i];
								(t[e + i] = t[n + i]), (t[n + i] = r);
							});
						}
						function ae(t) {
							return function (e, n) {
								var i =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: {};
								qt(
									e.pixels.length,
									e.width,
									function (n, i, r) {
										t(e.pixels, n, i, r);
									},
									function () {
										n(e);
									},
									i
								);
							};
						}
						function le() {
							var t =
									arguments.length > 0 && void 0 !== arguments[0]
										? arguments[0]
										: 3,
								e = Math.pow(t, 2),
								n = 1 / e;
							return zt(n, e);
						}
						function ce(t, e, n, i, r, o) {
							if (3 == arguments.length) {
								var s = arguments[2];
								(n = s.r), (i = s.g), (r = s.b), (o = s.a);
							}
							"number" == typeof n && (t[e] = n),
								"number" == typeof i && (t[e + 1] = i),
								"number" == typeof r && (t[e + 2] = r),
								"number" == typeof o && (t[e + 3] = o);
						}
						function he(t, e, n, i) {
							ce(t, e, n[i], n[i + 1], n[i + 2], n[i + 3]);
						}
						function ue(t) {
							var e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: 0,
								n =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: 255,
								i = [];
							return (
								(i = t.map(function (t, e) {
									return [];
								})),
								t.forEach(function (t, r) {
									if (0 != t) {
										var o = i[r];
										for (r = e; r <= n; r++) o[r] = t * r;
									}
								}),
								i
							);
						}
						function fe(t, e, n, i, r) {
							var o = Math.round(Math.sqrt(t.length)),
								s = Math.floor(o / 2),
								a = r ? 1 : 0,
								l = "let r = 0, g = 0, b = 0, a = 0, scy = 0, scx =0, si = 0; ",
								c = [],
								h = [],
								u = [],
								f = [];
							t.forEach(function (t, e) {
								var i = Math.floor(e / o) - s,
									r = (e % o) - s;
								0 != t &&
									(c.push(
										"$t[" +
											e +
											"][$sp[(($sy + (" +
											i +
											")) * " +
											n +
											" + ($sx + (" +
											r +
											"))) * 4]]"
									),
									h.push(
										"$t[" +
											e +
											"][$sp[(($sy + (" +
											i +
											")) * " +
											n +
											" + ($sx + (" +
											r +
											"))) * 4 + 1]]"
									),
									u.push(
										"$t[" +
											e +
											"][$sp[(($sy + (" +
											i +
											")) * " +
											n +
											" + ($sx + (" +
											r +
											"))) * 4 + 2]]"
									),
									f.push(
										"$t[" +
											e +
											"][$sp[(($sy + (" +
											i +
											")) * " +
											n +
											" + ($sx + (" +
											r +
											"))) * 4 + 3]]"
									));
							}),
								(l +=
									"r = " +
									c.join(" + ") +
									"; g = " +
									h.join(" + ") +
									"; b = " +
									u.join(" + ") +
									"; a = " +
									f.join(" + ") +
									";"),
								(l +=
									"$dp[$di] = r; $dp[$di+1] = g;$dp[$di+2] = b;$dp[$di+3] = a + (" +
									a +
									")*(255-a); ");
							var d = new Function("$dp", "$sp", "$di", "$sx", "$sy", "$t", l);
							return function (t, n, i, r, o) {
								d(t, n, i, r, o, e);
							};
						}
						function de(t) {
							var e =
									!(arguments.length > 1 && void 0 !== arguments[1]) ||
									arguments[1],
								n = ue(t);
							return function (i, r) {
								var o = Math.round(Math.sqrt(t.length)),
									s = Xt(i, 2 * o);
								Yt(s, i, o, o);
								for (
									var a = Vt(s.pixels.length, s.width, s.height),
										l = Vt(i.pixels.length, i.width, i.height),
										c = fe(t, n, s.width, s.height, e),
										h = i.pixels.length / 4,
										u = 0;
									u < h;
									u++
								) {
									var f = u,
										d = (f % i.width) + o,
										p = Math.floor(f / i.width) + o;
									c(a.pixels, s.pixels, 4 * (p * s.width + d), d, p);
								}
								Kt(a, l, o, o), r(l);
							};
						}
						function pe(t) {
							var e = Ze.convertMatches(t),
								n = e.str.match(te),
								i = [];
							if (!n) return i;
							i = n.map(function (t) {
								return { filter: t, origin: Ze.reverseMatches(t, e.matches) };
							});
							var r = { next: 0 };
							return (i = i
								.map(function (e) {
									var n = t.indexOf(e.origin, r.next);
									return (
										(e.startIndex = n),
										(e.endIndex = n + e.origin.length),
										(e.arr = ge(e.origin)),
										(r.next = e.endIndex),
										e
									);
								})
								.filter(function (t) {
									return !!t.arr.length;
								}));
						}
						function ge(t) {
							var e = Ze.convertMatches(t),
								n = e.str.match(te);
							if (!n[0]) return [];
							var i = n[0].split("("),
								r = i.shift(),
								o = [];
							return (
								i.length &&
									(o = i
										.shift()
										.split(")")[0]
										.split(",")
										.map(function (t) {
											return Ze.reverseMatches(t, e.matches);
										})),
								[r].concat(E(o)).map(Ze.trim)
							);
						}
						function me(t) {
							return Math.min(255, t);
						}
						function ve(t) {
							return xe(
								pe(t).map(function (t) {
									return t.arr;
								})
							);
						}
						function _e() {
							for (
								var t =
										arguments.length > 0 && void 0 !== arguments[0]
											? arguments[0]
											: [],
									e = [],
									n = [],
									i = 0,
									r = t.length;
								i < r;
								i++
							) {
								var o = t[i];
								o.userFunction
									? n.push(o)
									: (n.length && e.push([].concat(E(n))), e.push(o), (n = []));
							}
							return (
								n.length && e.push([].concat(E(n))),
								e.forEach(function (t, n) {
									var i;
									Array.isArray(t) &&
										(e[n] =
											((i = ee(t)),
											function (t, e) {
												for (var n = 0, r = t.pixels.length; n < r; n += 4)
													i(t.pixels, n);
												e(t);
											}));
								}),
								e
							);
						}
						function ye() {
							for (var t = arguments.length, e = Array(t), n = 0; n < t; n++)
								e[n] = arguments[n];
							var i = (e = _e(
								(e = e
									.map(function (t) {
										return Wt(t);
									})
									.filter(function (t) {
										return t;
									}))
							)).length;
							return function (t, n) {
								var r =
										arguments.length > 2 && void 0 !== arguments[2]
											? arguments[2]
											: {},
									o = t,
									s = 0;
								function a() {
									e[s].call(
										null,
										o,
										function (t) {
											(o = t), l();
										},
										r
									);
								}
								function l() {
									++s >= i ? n(o) : a();
								}
								a();
							};
						}
						function xe(t) {
							return ye.apply(void 0, E(t));
						}
						function ke(t) {
							for (
								var e = null,
									n = arguments.length,
									i = Array(n > 1 ? n - 1 : 0),
									r = 1;
								r < n;
								r++
							)
								i[r - 1] = arguments[r];
							return (
								(e =
									1 == i.length && "string" == typeof i[0] ? ve(i[0]) : xe(i)),
								function (n, i) {
									var r =
										arguments.length > 2 && void 0 !== arguments[2]
											? arguments[2]
											: {};
									e(
										Qt(n, t),
										function (e) {
											i(Zt(n, e, t));
										},
										r
									);
								}
							);
						}
						function be(t) {
							return (
								"string" == typeof t &&
									(t = (t = t.replace(/deg/, "")).replace(/px/, "")),
								+t
							);
						}
						function Te(t) {
							var e =
								arguments.length > 1 && void 0 !== arguments[1]
									? arguments[1]
									: 1;
							return t.map(function (t) {
								return t * e;
							});
						}
						var Ce = 0;
						function we(t) {
							return [].concat(Array.prototype.slice.call(arguments));
						}
						function Ee(t) {
							return { type: "convolution", length: t.length, content: t };
						}
						function Se(t, e) {
							return (
								"\n        if (u_filterIndex == " +
								e +
								".0) {\n            " +
								t +
								"\n        }\n    "
							);
						}
						function Ae(t, e) {
							return {
								type: "shader",
								index: Ce,
								options: e,
								content: Se(t, Ce++),
							};
						}
						function Le(t) {
							return (
								"\n    \n    if (u_kernelSelect == " +
								t +
								".0) {\n        vec4 colorSum = " +
								(function (t) {
									var e = Math.sqrt(t),
										n = Math.floor(e / 2);
									return []
										.concat(E(Array(t)))
										.map(function (i, r) {
											var o = Math.floor(r / e) - n;
											return (
												"texture(u_image, v_texCoord + onePixel * vec2(" +
												((r % e) - n) +
												", " +
												o +
												")) * u_kernel" +
												t +
												"[" +
												r +
												"]"
											);
										})
										.join(" + \n");
								})(t) +
								"; \n\n        outColor = vec4((colorSum / u_kernel" +
								t +
								"Weight).rgb, 1);\n        \n    }\n    "
							);
						}
						function Oe(t) {
							return (
								"vec4(" +
								(t = [t.r / 255, t.g / 255, t.b / 255, t.a || 0].map(Ne)) +
								")"
							);
						}
						function Ne(t) {
							return t == Math.floor(t) ? t + ".0" : t;
						}
						function Ie() {
							var t =
									arguments.length > 0 && void 0 !== arguments[0]
										? arguments[0]
										: 1,
								e = be(t) * (1 / 16);
							return Ee(Te([1, 2, 1, 2, 4, 2, 1, 2, 1], e));
						}
						function Me() {
							return Ee([
								1, 4, 6, 4, 1, 4, 16, 24, 16, 4, 6, 24, 36, 24, 6, 4, 16, 24,
								16, 4, 1, 4, 6, 4, 1,
							]);
						}
						function $e() {
							return Ee([5, 5, 5, -3, 0, -3, -3, -3, -3]);
						}
						function Re() {
							return Ee([5, -3, -3, 5, 0, -3, 5, -3, -3]);
						}
						function De() {
							return Ee([
								-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 24, -1, -1, -1,
								-1, -1, -1, -1, -1, -1, -1, -1, -1,
							]);
						}
						function Pe() {
							return Ee([
								1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1,
								0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0,
								0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0,
								0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1,
							]);
						}
						function Fe() {
							return Ee([
								1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1,
								0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0,
								0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0,
								0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1,
							]);
						}
						function Be() {
							return Ee([
								1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1,
								0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1,
								1, 1, 1, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0,
								0, 1, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1,
							]);
						}
						function Ue() {
							return Ee([-1, -2, -1, 0, 0, 0, 1, 2, 1]);
						}
						function He() {
							return Ee([-1, 0, 1, -2, 0, 2, -1, 0, 1]);
						}
						function ze() {
							return Ee(
								Te(
									[
										1, 4, 6, 4, 1, 4, 16, 24, 16, 4, 6, 24, -476, 24, 6, 4, 16,
										24, 16, 4, 1, 4, 6, 4, 1,
									],
									-1 / 256
								)
							);
						}
						function We() {
							var t =
									arguments.length > 0 && void 0 !== arguments[0]
										? arguments[0]
										: 0,
								e =
									arguments.length > 1 && void 0 !== arguments[1]
										? arguments[1]
										: 0,
								n =
									arguments.length > 2 && void 0 !== arguments[2]
										? arguments[2]
										: 0,
								i =
									arguments.length > 3 && void 0 !== arguments[3]
										? arguments[3]
										: 0,
								r =
									arguments.length > 4 && void 0 !== arguments[4]
										? arguments[4]
										: 0,
								o =
									arguments.length > 5 && void 0 !== arguments[5]
										? arguments[5]
										: 0,
								s =
									arguments.length > 6 && void 0 !== arguments[6]
										? arguments[6]
										: 0,
								a =
									arguments.length > 7 && void 0 !== arguments[7]
										? arguments[7]
										: 0,
								l =
									arguments.length > 8 && void 0 !== arguments[8]
										? arguments[8]
										: 0,
								c =
									arguments.length > 9 && void 0 !== arguments[9]
										? arguments[9]
										: 0,
								h =
									arguments.length > 10 && void 0 !== arguments[10]
										? arguments[10]
										: 0,
								u =
									arguments.length > 11 && void 0 !== arguments[11]
										? arguments[11]
										: 0,
								f =
									arguments.length > 12 && void 0 !== arguments[12]
										? arguments[12]
										: 0,
								d =
									arguments.length > 13 && void 0 !== arguments[13]
										? arguments[13]
										: 0,
								p =
									arguments.length > 14 && void 0 !== arguments[14]
										? arguments[14]
										: 0,
								g =
									arguments.length > 15 && void 0 !== arguments[15]
										? arguments[15]
										: 0,
								m = [t, e, n, i, r, o, s, a, l, c, h, u, f, d, p, g].map(Ne);
							return Ae(
								"\n\n        outColor = vec4(\n            " +
									m[0] +
									" * pixelColor.r + " +
									m[1] +
									" * pixelColor.g + " +
									m[2] +
									" * pixelColor.b + " +
									m[3] +
									" * pixelColor.a,\n            " +
									m[4] +
									" * pixelColor.r + " +
									m[5] +
									" * pixelColor.g + " +
									m[6] +
									" * pixelColor.b + " +
									m[7] +
									" * pixelColor.a,\n            " +
									m[8] +
									" * pixelColor.r + " +
									m[9] +
									" * pixelColor.g + " +
									m[10] +
									" * pixelColor.b + " +
									m[11] +
									" * pixelColor.a,\n            " +
									m[12] +
									" * pixelColor.r + " +
									m[13] +
									" * pixelColor.g + " +
									m[14] +
									" * pixelColor.b + " +
									m[15] +
									" * pixelColor.a\n        ); \n    "
							);
						}
						function je() {
							var t =
								arguments.length > 0 && void 0 !== arguments[0]
									? arguments[0]
									: 1;
							return Ae(
								"\n        float c = ( (pixelColor.r * 0.2126 + pixelColor.g * 0.7152 + pixelColor.b * 0.0722) ) >= " +
									(t = Ne(be(t))) +
									" ? 1.0 : 0.0;\n\n        outColor = vec4(c, c, c, pixelColor.a);\n    "
							);
						}
						var Ge = k(
								{},
								{
									blur: function () {
										return Ee([1, 1, 1, 1, 1, 1, 1, 1, 1]);
									},
									normal: function () {
										return Ee([0, 0, 0, 0, 1, 0, 0, 0, 0]);
									},
									emboss: function () {
										var t =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: 4;
										return Ee([-2 * (t = be(t)), -t, 0, -t, 1, t, 0, t, 2 * t]);
									},
									gaussianBlur: Ie,
									"gaussian-blur": Ie,
									gaussianBlur5x: Me,
									"gaussian-blur-5x": Me,
									grayscale2: function () {
										return Ee([
											0.3, 0.3, 0.3, 0, 0, 0.59, 0.59, 0.59, 0, 0, 0.11, 0.11,
											0.11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
										]);
									},
									kirschHorizontal: $e,
									"kirsch-horizontal": $e,
									kirschVertical: Re,
									"kirsch-vertical": Re,
									laplacian: function () {
										return Ee([-1, -1, -1, -1, 8, -1, -1, -1, -1]);
									},
									laplacian5x: De,
									"laplacian-5x": De,
									motionBlur: Pe,
									"motion-blur": Pe,
									motionBlur2: Fe,
									"motion-blur-2": Fe,
									motionBlur3: Be,
									"motion-blur-3": Be,
									negative: function () {
										return Ee([
											-1, 0, 0, 0, 0, 0, -1, 0, 0, 0, 0, 0, -1, 0, 0, 0, 0, 0,
											1, 0, 1, 1, 1, 1, 1,
										]);
									},
									sepia2: function () {
										return Ee([
											0.393, 0.349, 0.272, 0, 0, 0.769, 0.686, 0.534, 0, 0,
											0.189, 0.168, 0.131, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
										]);
									},
									sharpen: function () {
										return Ee([0, -1, 0, -1, 5, -1, 0, -1, 0]);
									},
									sobelHorizontal: Ue,
									"sobel-horizontal": Ue,
									sobelVertical: He,
									"sobel-vertical": He,
									transparency: function () {
										return Ee([
											1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0.3,
											0, 0, 0, 0, 0, 1,
										]);
									},
									unsharpMasking: ze,
									"unsharp-masking": ze,
								},
								{
									bitonal: function (t, e) {
										var n =
												arguments.length > 2 && void 0 !== arguments[2]
													? arguments[2]
													: 0.5,
											i = Ne(n),
											r = Oe(Ze.parse(t)),
											o = Oe(Ze.parse(e));
										return Ae(
											"\n        if ((pixelColor.r + pixelColor.g + pixelColor.b) > " +
												i +
												") {\n            outColor = vec4(" +
												o +
												".rgb, pixelColor.a);\n        } else {\n            outColor = vec4(" +
												r +
												".rgb, pixelColor.a);\n        }\n    "
										);
									},
									brightness: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Ne(be(t));
										return Ae(
											"\n        outColor = pixelColor + (" + e + ");\n    "
										);
									},
									brownie: function () {
										return We(
											0.5997023498159715,
											0.34553243048391263,
											-0.2708298674538042,
											0,
											-0.037703249837783157,
											0.8609577587992641,
											0.15059552388459913,
											0,
											0.24113635128153335,
											-0.07441037908422492,
											0.44972182064877153,
											0,
											0,
											0,
											0,
											1
										);
									},
									clip: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 0,
											e = Ne(be(t));
										return Ae(
											"\n        outColor = vec4(\n            (pixelColor.r > 1.0 - " +
												e +
												") ? 1.0 : 0.0,\n            (pixelColor.g > 1.0 - " +
												e +
												") ? 1.0 : 0.0,\n            (pixelColor.b > 1.0 - " +
												e +
												") ? 1.0 : 0.0,\n            pixelColor.a \n        );\n    "
										);
									},
									chaos: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 10,
											e = Ne(be(t));
										return Ae(
											"\n        vec2 st = pixelColor.st;\n        st *= " +
												e +
												";\n        \n        vec2 ipos = floor(st);  // get the integer coords\n\n        vec3 color = vec3(random( ipos ));\n\n        outColor = vec4(color, pixelColor.a);\n    "
										);
									},
									contrast: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Ne(be(t));
										return Ae(
											"\n        outColor = pixelColor * " + e + ";\n    "
										);
									},
									gamma: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Ne(be(t));
										return Ae(
											"\n        outColor = vec4(pow(pixelColor.r, " +
												e +
												"), pow(pixelColor.g, " +
												e +
												"), pow(pixelColor.b, " +
												e +
												"), pixelColor.a );\n    "
										);
									},
									gradient: function () {
										var t = [].concat(Array.prototype.slice.call(arguments));
										1 === t.length &&
											"string" == typeof t[0] &&
											(t = Ze.convertMatchesArray(t[0])),
											(t = t
												.map(function (t) {
													return t;
												})
												.join(", "));
										var e = Ze.parseGradient(t);
										(e[0][1] = 0), (e[e.length - 1][1] = 1);
										for (
											var n = [],
												i = 0,
												r = (e = e.map(function (t) {
													var e = Ze.parse(t[0]);
													return [{ r: e.r, g: e.g, b: e.b, a: e.a }, t[1]];
												})).length;
											i < r - 1;
											i++
										) {
											var o = e[i],
												s = e[i + 1],
												a = Oe(o[0]),
												l = Oe(s[0]),
												c = Ne(o[1]),
												h = Ne(s[1]);
											n.push(
												"\n            if (" +
													c +
													" <= rate && rate < " +
													h +
													") {\n                outColor = mix(" +
													a +
													", " +
													l +
													", (rate - " +
													c +
													")/(" +
													h +
													" - " +
													c +
													"));\n            }\n        "
											);
										}
										return Ae(
											"\n        float rate = (pixelColor.r * 0.2126 + pixelColor.g * 0.7152 + pixelColor.b * 0.0722); \n\n        " +
												n.join("\n") +
												"        \n    "
										);
									},
									grayscale: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = be(t);
										return (
											e > 1 && (e = 1),
											We(
												0.2126 + 0.7874 * (1 - e),
												0.7152 - 0.7152 * (1 - e),
												0.0722 - 0.0722 * (1 - e),
												0,
												0.2126 - 0.2126 * (1 - e),
												0.7152 + 0.2848 * (1 - e),
												0.0722 - 0.0722 * (1 - e),
												0,
												0.2126 - 0.2126 * (1 - e),
												0.7152 - 0.7152 * (1 - e),
												0.0722 + 0.9278 * (1 - e),
												0,
												0,
												0,
												0,
												1
											)
										);
									},
									hue: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Ne(be(t));
										return Ae(
											"\n        vec3 hsv = rgb2hsv(pixelColor.rgb);\n        hsv.x += " +
												e +
												";\n        outColor = vec4(hsv2rgb(hsv).rgb, pixelColor.a);\n    "
										);
									},
									invert: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Ne(be(t));
										return Ae(
											"\n        outColor = vec4(\n            (1.0 - pixelColor.r) * " +
												e +
												",\n            (1.0 - pixelColor.g) * " +
												e +
												",\n            (1.0 - pixelColor.b) * " +
												e +
												",\n            pixelColor.a\n        );\n    "
										);
									},
									kodachrome: function () {
										return We(
											1.1285582396593525,
											-0.3967382283601348,
											-0.03992559172921793,
											0,
											-0.16404339962244616,
											1.0835251566291304,
											-0.05498805115633132,
											0,
											-0.16786010706155763,
											-0.5603416277695248,
											1.6014850761964943,
											0,
											0,
											0,
											0,
											1
										);
									},
									matrix: We,
									noise: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Math.abs(be(t)),
											n = Ne(-e),
											i = Ne(e);
										return Ae(
											"\n        float rnd = " +
												n +
												" + random( pixelColor.st ) * (" +
												i +
												" - " +
												n +
												");\n\n        outColor = vec4(pixelColor.rgb + rnd, 1.0);\n    "
										);
									},
									opacity: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = Ne(be(t));
										return Ae(
											"\n        outColor = vec4(pixelColor.rgb, pixelColor.a * " +
												e +
												");\n    "
										);
									},
									polaroid: function () {
										return We(
											1.438,
											-0.062,
											-0.062,
											0,
											-0.122,
											1.378,
											-0.122,
											0,
											-0.016,
											-0.016,
											1.483,
											0,
											0,
											0,
											0,
											1
										);
									},
									saturation: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 0,
											e = 1 - Math.abs(be(t));
										return We(e, 0, 0, 0, 0, e, 0, 0, 0, 0, e, 0, 0, 0, 0, e);
									},
									sepia: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e = be(t);
										return (
											e > 1 && (e = 1),
											We(
												0.393 + 0.607 * (1 - e),
												0.769 - 0.769 * (1 - e),
												0.189 - 0.189 * (1 - e),
												0,
												0.349 - 0.349 * (1 - e),
												0.686 + 0.314 * (1 - e),
												0.168 - 0.168 * (1 - e),
												0,
												0.272 - 0.272 * (1 - e),
												0.534 - 0.534 * (1 - e),
												0.131 + 0.869 * (1 - e),
												0,
												0,
												0,
												0,
												1
											)
										);
									},
									shade: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 1,
											e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 1,
											n =
												arguments.length > 2 && void 0 !== arguments[2]
													? arguments[2]
													: 1,
											i = Ne(be(t) / 255),
											r = Ne(be(e) / 255),
											o = Ne(be(n) / 255);
										return Ae(
											"\n        outColor = vec4(\n            pixelColor.r * " +
												i +
												",\n            pixelColor.g * " +
												r +
												",\n            pixelColor.b * " +
												o +
												",\n            pixelColor.a\n        );\n    "
										);
									},
									shift: function () {
										return We(
											1.438,
											-0.062,
											-0.062,
											0,
											-0.122,
											1.378,
											-0.122,
											0,
											-0.016,
											-0.016,
											1.483,
											0,
											0,
											0,
											0,
											1
										);
									},
									solarize: function (t, e, n) {
										return Ae(
											"\n        outColor = vec4(\n            (pixelColor.r < " +
												Ne(be(t)) +
												") ? 1.0 - pixelColor.r: pixelColor.r,\n            (pixelColor.g < " +
												Ne(be(e)) +
												") ? 1.0 - pixelColor.g: pixelColor.g,\n            (pixelColor.b < " +
												Ne(be(n)) +
												") ? 1.0 - pixelColor.b: pixelColor.b,\n            pixelColor.a\n        );\n    "
										);
									},
									technicolor: function () {
										return We(
											1.9125277891456083,
											-0.8545344976951645,
											-0.09155508482755585,
											0,
											-0.3087833385928097,
											1.7658908555458428,
											-0.10601743074722245,
											0,
											-0.231103377548616,
											-0.7501899197440212,
											1.847597816108189,
											0,
											0,
											0,
											0,
											1
										);
									},
									threshold: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 200,
											e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 100;
										return je(t, e, !1);
									},
									"threshold-color": je,
									tint: function () {
										var t =
												arguments.length > 0 && void 0 !== arguments[0]
													? arguments[0]
													: 0,
											e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 0,
											n =
												arguments.length > 2 && void 0 !== arguments[2]
													? arguments[2]
													: 0,
											i = be(t),
											r = be(e),
											o = be(n);
										return Ae(
											"\n        outColor = vec4(\n            pixelColor.r += (1 - pixelColor.r) * " +
												i +
												",\n            pixelColor.g += (1 - pixelColor.g) * " +
												r +
												",\n            pixelColor.b += (1 - pixelColor.b) * " +
												o +
												",\n            pixelColor.a\n        );\n    "
										);
									},
								},
								{
									kirsch: function () {
										return we("kirsch-horizontal kirsch-vertical");
									},
									sobel: function () {
										return we("sobel-horizontal sobel-vertical");
									},
									vintage: function () {
										return we("brightness(0.15) saturation(-0.2) gamma(1.8)");
									},
								}
							),
							qe = 0,
							Ve = {
								GLCanvas: (function () {
									function t() {
										var e =
											arguments.length > 0 && void 0 !== arguments[0]
												? arguments[0]
												: { width: "400px", height: "300px" };
										_(this, t),
											(this.img = e.img),
											(this.width = parseFloat(
												this.img.width || e.width || "400px"
											)),
											(this.height = parseFloat(
												this.img.height || e.height || "300px"
											)),
											this.init();
									}
									return (
										y(t, [
											{
												key: "resize",
												value: function () {
													(this.canvas.width = this.width),
														(this.canvas.height = this.height),
														(this.canvas.style.width = this.width + "px"),
														(this.canvas.style.height = this.height + "px"),
														this.viewport();
												},
											},
											{
												key: "clear",
												value: function () {
													var t =
															arguments.length > 0 && void 0 !== arguments[0]
																? arguments[0]
																: 0,
														e =
															arguments.length > 1 && void 0 !== arguments[1]
																? arguments[1]
																: 0,
														n =
															arguments.length > 2 && void 0 !== arguments[2]
																? arguments[2]
																: 0,
														i =
															arguments.length > 3 && void 0 !== arguments[3]
																? arguments[3]
																: 0,
														r = this.gl;
													r.clearColor(t, e, n, i),
														r.clear(r.COLOR_BUFFER_BIT | r.DEPTH_BUFFER_BIT);
												},
											},
											{
												key: "viewport",
												value: function (t, e, n, i) {
													var r = this.gl;
													r.viewport(
														t || 0,
														e || 0,
														n || r.canvas.width,
														i || r.canvas.height
													);
												},
											},
											{
												key: "initCanvas",
												value: function (t, e) {
													if (
														((this.canvas = document.createElement("canvas")),
														(this.gl = this.canvas.getContext("webgl2")),
														!this.gl)
													)
														throw new Error("you need webgl2 support");
													(this.program = this.createProgram(t, e)),
														this.resize(),
														this.initBuffer();
												},
											},
											{
												key: "draw",
												value: function () {
													var t =
															arguments.length > 0 && void 0 !== arguments[0]
																? arguments[0]
																: "TRIANGLES",
														e =
															arguments.length > 1 && void 0 !== arguments[1]
																? arguments[1]
																: 0,
														n =
															arguments.length > 2 && void 0 !== arguments[2]
																? arguments[2]
																: 6,
														i = this.gl;
													i.drawArrays(i[t], e, n);
												},
											},
											{
												key: "triangles",
												value: function () {
													var t =
															arguments.length > 0 && void 0 !== arguments[0]
																? arguments[0]
																: 0,
														e =
															arguments.length > 1 && void 0 !== arguments[1]
																? arguments[1]
																: 6;
													this.draw("TRIANGLES", t, e);
												},
											},
											{
												key: "uniform2f",
												value: function () {
													for (
														var t, e = arguments.length, n = Array(e), i = 0;
														i < e;
														i++
													)
														n[i] = arguments[i];
													var r = n.shift();
													(t = this.gl).uniform2f.apply(
														t,
														[this.locations[r]].concat(n)
													);
												},
											},
											{
												key: "uniform1f",
												value: function () {
													for (
														var t, e = arguments.length, n = Array(e), i = 0;
														i < e;
														i++
													)
														n[i] = arguments[i];
													var r = n.shift();
													(t = this.gl).uniform1f.apply(
														t,
														[this.locations[r]].concat(n)
													);
												},
											},
											{
												key: "uniform1fv",
												value: function () {
													for (
														var t, e = arguments.length, n = Array(e), i = 0;
														i < e;
														i++
													)
														n[i] = arguments[i];
													var r = n.shift();
													(t = this.gl).uniform1fv.apply(
														t,
														[this.locations[r]].concat(n)
													);
												},
											},
											{
												key: "uniform1i",
												value: function () {
													for (
														var t, e = arguments.length, n = Array(e), i = 0;
														i < e;
														i++
													)
														n[i] = arguments[i];
													var r = n.shift();
													(t = this.gl).uniform1i.apply(
														t,
														[this.locations[r]].concat(n)
													);
												},
											},
											{
												key: "useProgram",
												value: function () {
													this.gl.useProgram(this.program);
												},
											},
											{
												key: "bindBuffer",
												value: function (t, e) {
													var n =
															arguments.length > 2 && void 0 !== arguments[2]
																? arguments[2]
																: "STATIC_DRAW",
														i = this.gl;
													this.buffers[t] ||
														(this.buffers[t] = i.createBuffer()),
														i.bindBuffer(i.ARRAY_BUFFER, this.buffers[t]),
														e &&
															i.bufferData(
																i.ARRAY_BUFFER,
																new Float32Array(e),
																i[n]
															);
												},
											},
											{
												key: "enable",
												value: function (t) {
													this.gl.enableVertexAttribArray(this.locations[t]);
												},
											},
											{
												key: "location",
												value: function (t) {
													var e =
														arguments.length > 1 && void 0 !== arguments[1]
															? arguments[1]
															: "attribute";
													"attribute" === e
														? (this.locations[t] = this.gl.getAttribLocation(
																this.program,
																t
														  ))
														: "uniform" === e &&
														  (this.locations[t] = this.gl.getUniformLocation(
																this.program,
																t
														  ));
												},
											},
											{
												key: "a",
												value: function (t) {
													return this.location(t);
												},
											},
											{
												key: "u",
												value: function (t) {
													return this.location(t, "uniform");
												},
											},
											{
												key: "pointer",
												value: function (t) {
													var e =
															arguments.length > 1 && void 0 !== arguments[1]
																? arguments[1]
																: "FLOAT",
														n =
															arguments.length > 2 && void 0 !== arguments[2]
																? arguments[2]
																: 2,
														i =
															arguments.length > 3 &&
															void 0 !== arguments[3] &&
															arguments[3],
														r =
															arguments.length > 4 && void 0 !== arguments[4]
																? arguments[4]
																: 0,
														o =
															arguments.length > 5 && void 0 !== arguments[5]
																? arguments[5]
																: 0,
														s = this.gl;
													s.vertexAttribPointer(
														this.locations[t],
														n,
														s[e],
														i,
														r,
														o
													);
												},
											},
											{
												key: "bufferData",
												value: function () {
													var t =
															arguments.length > 0 && void 0 !== arguments[0]
																? arguments[0]
																: [],
														e = this.gl;
													e.bufferData(
														e.ARRAY_BUFFER,
														new Float32Array(t),
														e.STATIC_DRAW
													);
												},
											},
											{
												key: "isPowerOf2",
												value: function (t) {
													return 0 == (t & (t - 1));
												},
											},
											{
												key: "bindTexture",
												value: function (t) {
													var e =
															arguments.length > 1 && void 0 !== arguments[1]
																? arguments[1]
																: void 0,
														n =
															arguments.length > 2 && void 0 !== arguments[2]
																? arguments[2]
																: 0,
														i =
															arguments.length > 3 && void 0 !== arguments[3]
																? arguments[3]
																: "RGBA",
														r =
															arguments.length > 4 && void 0 !== arguments[4]
																? arguments[4]
																: "RGBA",
														o =
															arguments.length > 5 && void 0 !== arguments[5]
																? arguments[5]
																: "UNSIGNED_BYTE",
														s = this.gl;
													1 != arguments.length
														? (this.textures[t] ||
																(this.textures[t] = s.createTexture()),
														  (this.textureIndex[t] = qe++),
														  s.bindTexture(s.TEXTURE_2D, this.textures[t]),
														  this.setTextureParameter(),
														  s.texImage2D(
																s.TEXTURE_2D,
																n,
																s[i],
																s[r],
																s[o],
																e.newImage || e
														  ))
														: s.bindTexture(s.TEXTURE_2D, this.textures[t]);
												},
											},
											{
												key: "bindColorTexture",
												value: function (t, e) {
													var n =
															arguments.length > 2 && void 0 !== arguments[2]
																? arguments[2]
																: 256,
														i =
															arguments.length > 3 && void 0 !== arguments[3]
																? arguments[3]
																: 1,
														r =
															arguments.length > 4 && void 0 !== arguments[4]
																? arguments[4]
																: 0,
														o =
															arguments.length > 5 && void 0 !== arguments[5]
																? arguments[5]
																: "RGBA",
														s =
															arguments.length > 6 && void 0 !== arguments[6]
																? arguments[6]
																: "RGBA",
														a =
															arguments.length > 7 && void 0 !== arguments[7]
																? arguments[7]
																: "UNSIGNED_BYTE",
														l = this.gl;
													this.textures[t] ||
														(this.textures[t] = l.createTexture()),
														(this.textureIndex[t] = qe++),
														l.bindTexture(l.TEXTURE_2D, this.textures[t]),
														this.setTextureParameter(),
														l.texImage2D(
															l.TEXTURE_2D,
															r,
															l[o],
															n,
															i,
															0,
															l[s],
															l[a],
															new Uint8Array(e)
														);
												},
											},
											{
												key: "bindEmptyTexture",
												value: function (t, e, n) {
													var i =
															arguments.length > 3 && void 0 !== arguments[3]
																? arguments[3]
																: 0,
														r =
															arguments.length > 4 && void 0 !== arguments[4]
																? arguments[4]
																: "RGBA",
														o =
															arguments.length > 5 && void 0 !== arguments[5]
																? arguments[5]
																: "RGBA",
														s =
															arguments.length > 6 && void 0 !== arguments[6]
																? arguments[6]
																: "UNSIGNED_BYTE",
														a = this.gl;
													this.textures[t] ||
														(this.textures[t] = a.createTexture()),
														(this.textureIndex[t] = qe++),
														a.bindTexture(a.TEXTURE_2D, this.textures[t]),
														this.setTextureParameter();
													var l = 0,
														c = null;
													a.texImage2D(
														a.TEXTURE_2D,
														i,
														a[r],
														e,
														n,
														l,
														a[o],
														a[s],
														c
													);
												},
											},
											{
												key: "setTextureParameter",
												value: function () {
													var t = this.gl;
													t.texParameteri(
														t.TEXTURE_2D,
														t.TEXTURE_WRAP_S,
														t.CLAMP_TO_EDGE
													),
														t.texParameteri(
															t.TEXTURE_2D,
															t.TEXTURE_WRAP_T,
															t.CLAMP_TO_EDGE
														),
														t.texParameteri(
															t.TEXTURE_2D,
															t.TEXTURE_MIN_FILTER,
															t.NEAREST
														),
														t.texParameteri(
															t.TEXTURE_2D,
															t.TEXTURE_MAG_FILTER,
															t.NEAREST
														);
												},
											},
											{
												key: "bindFrameBufferWithTexture",
												value: function (t, e, n, i) {
													this.bindEmptyTexture(e, n, i),
														this.bindFrameBuffer(t, e);
												},
											},
											{
												key: "enumToString",
												value: function (t) {
													var e = this.gl;
													if (0 === t) return "NONE";
													for (var n in e) if (e[n] === t) return n;
													return "0x" + t.toString(16);
												},
											},
											{
												key: "bindFrameBuffer",
												value: function (t) {
													var e =
															arguments.length > 1 && void 0 !== arguments[1]
																? arguments[1]
																: null,
														n = this.gl;
													if (1 !== arguments.length) {
														this.framebuffers[t] ||
															(this.framebuffers[t] = n.createFramebuffer()),
															n.bindFramebuffer(
																n.FRAMEBUFFER,
																this.framebuffers[t]
															);
														var i = 0,
															r = n.COLOR_ATTACHMENT0;
														n.framebufferTexture2D(
															n.FRAMEBUFFER,
															r,
															n.TEXTURE_2D,
															this.textures[e],
															i
														),
															n.checkFramebufferStatus(n.FRAMEBUFFER),
															n.FRAMEBUFFER_COMPLETE;
													} else
														n.bindFramebuffer(
															n.FRAMEBUFFER,
															null == t ? null : this.framebuffers[t]
														);
												},
											},
											{
												key: "bindVA",
												value: function () {
													var t = this.gl;
													this.vao || (this.vao = t.createVertexArray()),
														t.bindVertexArray(this.vao);
												},
											},
											{
												key: "bindAttr",
												value: function (t, e) {
													var n =
															arguments.length > 2 && void 0 !== arguments[2]
																? arguments[2]
																: "STATIC_DRAW",
														i =
															arguments.length > 3 && void 0 !== arguments[3]
																? arguments[3]
																: 2;
													this.bindBuffer(t, e, n),
														this.enable(t),
														this.pointer(t, "FLOAT", i);
												},
											},
											{
												key: "initBuffer",
												value: function () {
													var t = this.canvas,
														e = t.width,
														n = t.height;
													this.a("a_position"),
														this.a("a_texCoord"),
														this.u("u_resolution"),
														this.u("u_image"),
														this.u("u_flipY"),
														this.u("u_kernelSelect"),
														this.u("u_filterIndex"),
														this.u("u_kernel9[0]"),
														this.u("u_kernel9Weight"),
														this.u("u_kernel25[0]"),
														this.u("u_kernel25Weight"),
														this.u("u_kernel49[0]"),
														this.u("u_kernel49Weight"),
														this.u("u_kernel81[0]"),
														this.u("u_kernel81Weight"),
														this.bindVA(),
														this.bindAttr(
															"a_position",
															[0, 0, e, 0, 0, n, 0, n, e, 0, e, n],
															"STATIC_DRAW",
															2
														),
														this.bindAttr(
															"a_texCoord",
															[0, 0, 1, 0, 0, 1, 0, 1, 1, 0, 1, 1],
															"STATIC_DRAW",
															2
														),
														this.bindTexture("u_image", this.img),
														this.bindFrameBufferWithTexture(
															"frame_buffer_0",
															"img_texture_0",
															e,
															n
														),
														this.bindFrameBufferWithTexture(
															"frame_buffer_1",
															"img_texture_1",
															e,
															n
														);
												},
											},
											{
												key: "activeTexture",
												value: function () {
													var t =
															arguments.length > 0 && void 0 !== arguments[0]
																? arguments[0]
																: 0,
														e = this.gl;
													e.activeTexture(e.TEXTURE0 + t);
												},
											},
											{
												key: "drawFilter",
												value: function () {
													var t = this,
														e = this.gl;
													this.resize(),
														this.clear(),
														this.useProgram(),
														this.bindVA(),
														this.activeTexture(0),
														this.bindTexture("u_image"),
														this.uniform1i("u_image", 0),
														this.uniform1f("u_flipY", 1);
													var n = e.canvas,
														i = n.width,
														r = n.height;
													this.eachFilter(function (e, n) {
														t.bindFrameBuffer("frame_buffer_" + (n % 2)),
															t.uniform2f("u_resolution", i, r),
															t.viewport(0, 0, i, r),
															t.effectFilter(e),
															t.bindTexture("img_texture_" + (n % 2));
													}),
														this.uniform1f("u_flipY", -1),
														this.bindFrameBuffer(null),
														this.uniform2f("u_resolution", i, r),
														this.viewport(0, 0, i, r),
														this.clear(),
														this.effectFilter("normal");
												},
											},
											{
												key: "effectFilter",
												value: function (t) {
													"string" == typeof t &&
														(t = (Ge[t] || Ge.normal).call(Ge)),
														"convolution" == t.type
															? (this.uniform1f("u_kernelSelect", t.length),
															  this.uniform1f("u_filterIndex", -1),
															  this.uniform1fv(
																	"u_kernel" + t.length + "[0]",
																	t.content
															  ),
															  this.uniform1f(
																	"u_kernel" + t.length + "Weight",
																	this.computeKernelWeight(t.content)
															  ))
															: (this.uniform1f("u_kernelSelect", -1),
															  this.uniform1f("u_filterIndex", t.index)),
														this.triangles(0, 6);
												},
											},
											{
												key: "computeKernelWeight",
												value: function (t) {
													var e = t.reduce(function (t, e) {
														return t + e;
													});
													return e <= 0 ? 1 : e;
												},
											},
											{
												key: "createProgram",
												value: function (t, e) {
													var n = this.gl,
														i = n.createProgram();
													if (
														((this.vertexShader = this.createVertexShader(t)),
														(this.fragmentShader =
															this.createFragmentShader(e)),
														n.attachShader(i, this.vertexShader),
														n.attachShader(i, this.fragmentShader),
														n.linkProgram(i),
														n.getProgramParameter(i, n.LINK_STATUS))
													)
														return i;
													console.error(n.getProgramInfoLog(i)),
														n.deleteProgram(i);
												},
											},
											{
												key: "createShader",
												value: function (t, e) {
													var n = this.gl,
														i = n.createShader(t);
													if (
														(n.shaderSource(i, e),
														n.compileShader(i),
														n.getShaderParameter(i, n.COMPILE_STATUS))
													)
														return i;
													console.error(n.getShaderInfoLog(i)),
														n.deleteShader(i);
												},
											},
											{
												key: "createVertexShader",
												value: function (t) {
													var e = this.gl;
													return this.createShader(e.VERTEX_SHADER, t);
												},
											},
											{
												key: "createFragmentShader",
												value: function (t) {
													var e = this.gl;
													return this.createShader(e.FRAGMENT_SHADER, t);
												},
											},
											{
												key: "eachFilter",
												value: function (t) {
													this.filterList.forEach(t);
												},
											},
											{
												key: "init",
												value: function () {
													(this.locations = {}),
														(this.buffers = {}),
														(this.framebuffers = {}),
														(this.textures = {}),
														(this.textureIndex = {}),
														(this.hasTexParameter = {});
												},
											},
											{
												key: "destroy",
												value: function () {
													var t = this.gl;
													this.init(), t.deleteProgram(this.program);
												},
											},
											{
												key: "filter",
												value: function (t, e) {
													var n, i, r;
													(this.filterList = t),
														this.initCanvas(
															"#version 300 es \n\n        in vec2 a_position;\n        in vec2 a_texCoord; \n\n        uniform vec2 u_resolution;\n        uniform float u_flipY;\n\n        out vec2 v_texCoord; \n\n        void main() {\n            vec2 zeroToOne = a_position / u_resolution;\n\n            vec2 zeroToTwo = zeroToOne * 2.0;\n\n            vec2 clipSpace = zeroToTwo - 1.0;\n\n            gl_Position = vec4(clipSpace * vec2(1, u_flipY), 0, 1);\n\n            v_texCoord = a_texCoord;\n\n        }\n    ",
															((n = this.filterList),
															(i = n
																.filter(function (t) {
																	return "shader" == t.type;
																})
																.map(function (t) {
																	return t.content;
																})
																.join("\n\n")),
															(r = { 9: !0 }),
															n
																.filter(function (t) {
																	return "convolution" == t.type;
																})
																.forEach(function (t) {
																	r[t.length] = !0;
																}),
															"#version 300 es\n\n    precision highp int;\n    precision mediump float;\n    \n    uniform sampler2D u_image;\n\n    // 3 is 3x3 matrix kernel \n    uniform float u_kernelSelect;\n    uniform float u_filterIndex;\n\n    uniform float u_kernel9[9];\n    uniform float u_kernel9Weight;\n    uniform float u_kernel25[25];\n    uniform float u_kernel25Weight;\n    uniform float u_kernel49[49];\n    uniform float u_kernel49Weight;\n    uniform float u_kernel81[81];\n    uniform float u_kernel81Weight;    \n\n    in vec2 v_texCoord;\n    \n    out vec4 outColor;\n\n    float random (vec2 st) {\n        return fract(sin(dot(st.xy, vec2(12.9898,78.233)))* 43758.5453123);\n    } \n\n    // \n    vec3 rgb2hsv(vec3 c)\n    {\n        vec4 K = vec4(0.0, -1.0 / 3.0, 2.0 / 3.0, -1.0);\n        vec4 p = c.g < c.b ? vec4(c.bg, K.wz) : vec4(c.gb, K.xy);\n        vec4 q = c.r < p.x ? vec4(p.xyw, c.r) : vec4(c.r, p.yzx);\n\n        float d = q.x - min(q.w, q.y);\n        float e = 1.0e-10;\n        return vec3(abs(q.z + (q.w - q.y) / (6.0 * d + e)), d / (q.x + e), q.x);\n    }\n\n    vec3 hsv2rgb(vec3 c)\n    {\n        vec4 K = vec4(1.0, 2.0 / 3.0, 1.0 / 3.0, 3.0);\n        vec3 p = abs(fract(c.xxx + K.xyz) * 6.0 - K.www);\n        return c.z * mix(K.xxx, clamp(p - K.xxx, 0.0, 1.0), c.y);\n    }\n    \n    void main() {\n        vec4 pixelColor = texture(u_image, v_texCoord);\n        vec2 onePixel = vec2(1) / vec2(textureSize(u_image, 0));                \n\n        " +
																i +
																"\n\n        " +
																Object.keys(r)
																	.map(function (t) {
																		return Le(+t);
																	})
																	.join("\n") +
																"\n\n    }")
														),
														this.drawFilter(),
														"function" == typeof e && e(this);
												},
											},
										]),
										t
									);
								})(),
							},
							Ye = {
								filter: function (t, e, n, i) {
									var r = new Ve.GLCanvas({
										width: i.width || t.width,
										height: i.height || t.height,
										img: t,
									});
									r.filter(Ke(e), function () {
										"function" == typeof n && n(r);
									});
								},
							};
						function Ke(t) {
							var e = [];
							"string" == typeof t ? (e = pe(t)) : Array.isArray(t) && (e = t);
							var n = [];
							return (
								e.forEach(function (t) {
									var e = t.arr[0];
									if (Ge[e]) {
										var i = (function (t) {
											var e = t.arr[0],
												n = Ge[e],
												i = t.arr;
											return i.shift(), n.apply(this, i);
										})(t);
										"convolution" == i.type || "shader" == i.type
											? n.push(i)
											: i.forEach(function (t) {
													n = n.concat(Ke(t));
											  });
									}
								}),
								n
							);
						}
						var Xe = k({}, Ve, Ye);
						function Qe(t, e, n) {
							var i =
									arguments.length > 3 && void 0 !== arguments[3]
										? arguments[3]
										: { frameTimer: "full" },
								r = new gt(t);
							r.loadImage(function () {
								r.toArray(
									e,
									function (t) {
										"function" == typeof n && n(t);
									},
									i
								);
							});
						}
						var Ze = k({}, o, f, rt, R, Z, W, j, Q, v, K, {
								palette: function (t) {
									var n =
											arguments.length > 1 && void 0 !== arguments[1]
												? arguments[1]
												: 6,
										i =
											arguments.length > 2 && void 0 !== arguments[2]
												? arguments[2]
												: "hex";
									return (
										t.length > n && (t = dt(t, n)),
										t.map(function (t) {
											return e(t, i);
										})
									);
								},
								ImageToCanvas: function (t, e, n) {
									var i =
										arguments.length > 3 && void 0 !== arguments[3]
											? arguments[3]
											: { frameTimer: "full" };
									Qe(t, e, n, Object.assign({ returnTo: "canvas" }, i));
								},
								ImageToHistogram: function (t, e) {
									var n =
											arguments.length > 2 && void 0 !== arguments[2]
												? arguments[2]
												: { width: 200, height: 100 },
										i = new gt(t);
									i.loadImage(function () {
										pt.createHistogram(
											n.width || 200,
											n.height || 100,
											i.toHistogram(n),
											function (t) {
												"function" == typeof e && e(t.toDataURL("image/png"));
											},
											n
										);
									});
								},
								ImageToRGB: function (t) {
									var e =
											arguments.length > 1 && void 0 !== arguments[1]
												? arguments[1]
												: {},
										n = arguments[2];
									if (n) {
										if (n) {
											var i;
											(i = new gt(t, e)).loadImage(function () {
												"function" == typeof n && n(i.toRGB());
											});
										}
									} else
										(i = new gt(t)).loadImage(function () {
											"function" == typeof e && e(i.toRGB());
										});
								},
								ImageToURL: Qe,
								GLToCanvas: function (t, e, n) {
									var i =
											arguments.length > 3 && void 0 !== arguments[3]
												? arguments[3]
												: {},
										r = new gt(t);
									r.load(function () {
										Xe.filter(
											r.newImage,
											e,
											function (t) {
												"function" == typeof n && n(t);
											},
											i
										);
									});
								},
								histogram: function (t, e) {
									var n =
											arguments.length > 2 && void 0 !== arguments[2]
												? arguments[2]
												: {},
										i = new gt(t);
									i.loadImage(function () {
										"function" == typeof e && e(i.toHistogram(n));
									});
								},
								histogramToPoints: function (t) {
									for (
										var e =
												arguments.length > 1 && void 0 !== arguments[1]
													? arguments[1]
													: 0.2,
											n = [],
											i = 0;
										i < t.length;
										i++
									) {
										var r = t[i];
										if (0 != i)
											if (i != t.length - 1) {
												var o = t[i - 1],
													s = t[i + 1],
													a =
														(s[1],
														o[1],
														s[0],
														o[0],
														[
															o[0] + (s[0] - o[0]) * e,
															o[1] + (s[1] - o[1]) * e,
														]),
													l = [[].concat(E(o)), [].concat(a)],
													c = Math.sqrt(
														Math.pow(r[0] - o[0], 2) + Math.pow(r[1] - o[1], 2)
													),
													h = Math.sqrt(
														Math.pow(s[0] - r[0], 2) + Math.pow(s[1] - r[1], 2)
													),
													u = c / h,
													f = l[0][0] + (l[1][0] - l[0][0]) * u,
													d = l[0][1] + (l[1][1] - l[0][1]) * u;
												(l[0][0] += r[0] - f),
													(l[0][1] += r[1] - d),
													(l[1][0] += r[0] - f),
													(l[1][1] += r[1] - d),
													(n[i] = l);
											} else n[i] = [];
										else n[i] = [];
									}
									return n;
								},
							}),
							Je = [
								{ rgb: "#ff0000", start: 0 },
								{ rgb: "#ffff00", start: 0.17 },
								{ rgb: "#00ff00", start: 0.33 },
								{ rgb: "#00ffff", start: 0.5 },
								{ rgb: "#0000ff", start: 0.67 },
								{ rgb: "#ff00ff", start: 0.83 },
								{ rgb: "#ff0000", start: 1 },
							];
						!(function () {
							for (var t = 0, e = Je.length; t < e; t++) {
								var n = Je[t],
									i = Ze.parse(n.rgb);
								(n.r = i.r), (n.g = i.g), (n.b = i.b);
							}
						})();
						var tn = {
								colors: Je,
								checkHueColor: function (t) {
									for (var e, n, i = 0; i < Je.length; i++)
										if (Je[i].start >= t) {
											(e = Je[i - 1]), (n = Je[i]);
											break;
										}
									return e && n
										? Ze.interpolateRGB(
												e,
												n,
												(t - e.start) / (n.start - e.start)
										  )
										: Je[0].rgb;
								},
							},
							en = k({}, Pt, Bt),
							nn = {
								Color: Ze,
								HueColor: tn,
								ColorNames: p,
								ImageFilter: en,
								GL: Xe,
								Canvas: pt,
								ImageLoader: gt,
							},
							rn = (Ze.color, 0),
							on = [],
							sn = (function () {
								function t(e, n, i) {
									if ((_(this, t), "string" != typeof e)) this.el = e;
									else {
										var r = document.createElement(e);
										for (var o in ((this.uniqId = rn++),
										n && (r.className = n),
										(i = i || {})))
											r.setAttribute(o, i[o]);
										this.el = r;
									}
								}
								return (
									y(
										t,
										[
											{
												key: "attr",
												value: function (t, e) {
													return 1 == arguments.length
														? this.el.getAttribute(t)
														: (this.el.setAttribute(t, e), this);
												},
											},
											{
												key: "closest",
												value: function (e) {
													for (var n = this, i = !1; !(i = n.hasClass(e)); ) {
														if (!n.el.parentNode) return null;
														n = new t(n.el.parentNode);
													}
													return i ? n : null;
												},
											},
											{
												key: "checked",
												value: function () {
													return this.el.checked;
												},
											},
											{
												key: "removeClass",
												value: function (t) {
													return (
														(this.el.className = (" " + this.el.className + " ")
															.replace(" " + t + " ", " ")
															.trim()),
														this
													);
												},
											},
											{
												key: "hasClass",
												value: function (t) {
													return (
														!!this.el.className &&
														(" " + this.el.className + " ").indexOf(
															" " + t + " "
														) > -1
													);
												},
											},
											{
												key: "addClass",
												value: function (t) {
													return (
														this.hasClass(t) ||
															(this.el.className = this.el.className + " " + t),
														this
													);
												},
											},
											{
												key: "toggleClass",
												value: function (t) {
													this.hasClass(t)
														? this.removeClass(t)
														: this.addClass(t);
												},
											},
											{
												key: "html",
												value: function (t) {
													try {
														"string" == typeof t
															? (this.el.innerHTML = t)
															: this.empty().append(t);
													} catch (e) {
														console.log(t);
													}
													return this;
												},
											},
											{
												key: "find",
												value: function (t) {
													return this.el.querySelector(t);
												},
											},
											{
												key: "$",
												value: function (e) {
													return new t(this.find(e));
												},
											},
											{
												key: "findAll",
												value: function (t) {
													return this.el.querySelectorAll(t);
												},
											},
											{
												key: "$$",
												value: function (e) {
													return []
														.concat(E(this.findAll(e)))
														.map(function (e) {
															return new t(e);
														});
												},
											},
											{
												key: "empty",
												value: function () {
													return this.html("");
												},
											},
											{
												key: "append",
												value: function (t) {
													return (
														"string" == typeof t
															? this.el.appendChild(document.createTextNode(t))
															: this.el.appendChild(t.el || t),
														this
													);
												},
											},
											{
												key: "appendTo",
												value: function (t) {
													return (t.el ? t.el : t).appendChild(this.el), this;
												},
											},
											{
												key: "remove",
												value: function () {
													return (
														this.el.parentNode &&
															this.el.parentNode.removeChild(this.el),
														this
													);
												},
											},
											{
												key: "text",
												value: function () {
													return this.el.textContent;
												},
											},
											{
												key: "css",
												value: function (t, e) {
													var n = this;
													if (2 == arguments.length) this.el.style[t] = e;
													else if (1 == arguments.length) {
														if ("string" == typeof t)
															return getComputedStyle(this.el)[t];
														var i = t || {};
														Object.keys(i).forEach(function (t) {
															n.el.style[t] = i[t];
														});
													}
													return this;
												},
											},
											{
												key: "cssFloat",
												value: function (t) {
													return parseFloat(this.css(t));
												},
											},
											{
												key: "cssInt",
												value: function (t) {
													return parseInt(this.css(t));
												},
											},
											{
												key: "offset",
												value: function () {
													var e = this.el.getBoundingClientRect();
													return {
														top: e.top + t.getScrollTop(),
														left: e.left + t.getScrollLeft(),
													};
												},
											},
											{
												key: "rect",
												value: function () {
													return this.el.getBoundingClientRect();
												},
											},
											{
												key: "position",
												value: function () {
													return this.el.style.top
														? {
																top: parseFloat(this.css("top")),
																left: parseFloat(this.css("left")),
														  }
														: this.el.getBoundingClientRect();
												},
											},
											{
												key: "size",
												value: function () {
													return [this.width(), this.height()];
												},
											},
											{
												key: "width",
												value: function () {
													return (
														this.el.offsetWidth ||
														this.el.getBoundingClientRect().width
													);
												},
											},
											{
												key: "contentWidth",
												value: function () {
													return (
														this.width() -
														this.cssFloat("padding-left") -
														this.cssFloat("padding-right")
													);
												},
											},
											{
												key: "height",
												value: function () {
													return (
														this.el.offsetHeight ||
														this.el.getBoundingClientRect().height
													);
												},
											},
											{
												key: "contentHeight",
												value: function () {
													return (
														this.height() -
														this.cssFloat("padding-top") -
														this.cssFloat("padding-bottom")
													);
												},
											},
											{
												key: "dataKey",
												value: function (t) {
													return this.uniqId + "." + t;
												},
											},
											{
												key: "data",
												value: function (t, e) {
													if (2 != arguments.length) {
														if (1 == arguments.length)
															return on[this.dataKey(t)];
														var n = Object.keys(on),
															i = this.uniqId + ".";
														return n
															.filter(function (t) {
																return 0 == t.indexOf(i);
															})
															.map(function (t) {
																return on[t];
															});
													}
													return (on[this.dataKey(t)] = e), this;
												},
											},
											{
												key: "val",
												value: function (t) {
													return 0 == arguments.length
														? this.el.value
														: (1 == arguments.length && (this.el.value = t),
														  this);
												},
											},
											{
												key: "int",
												value: function () {
													return parseInt(this.val(), 10);
												},
											},
											{
												key: "float",
												value: function () {
													return parseFloat(this.val());
												},
											},
											{
												key: "show",
												value: function () {
													return this.css("display", "block");
												},
											},
											{
												key: "hide",
												value: function () {
													return this.css("display", "none");
												},
											},
											{
												key: "toggle",
												value: function () {
													return "none" == this.css("display")
														? this.show()
														: this.hide();
												},
											},
											{
												key: "scrollTop",
												value: function () {
													return this.el === document.body
														? t.getScrollTop()
														: this.el.scrollTop;
												},
											},
											{
												key: "scrollLeft",
												value: function () {
													return this.el === document.body
														? t.getScrollLeft()
														: this.el.scrollLeft;
												},
											},
											{
												key: "on",
												value: function (t, e, n, i) {
													return this.el.addEventListener(t, e, n, i), this;
												},
											},
											{
												key: "off",
												value: function (t, e) {
													return this.el.removeEventListener(t, e), this;
												},
											},
											{
												key: "getElement",
												value: function () {
													return this.el;
												},
											},
											{
												key: "createChild",
												value: function (e) {
													var n =
															arguments.length > 1 && void 0 !== arguments[1]
																? arguments[1]
																: "",
														i =
															arguments.length > 2 && void 0 !== arguments[2]
																? arguments[2]
																: {},
														r =
															arguments.length > 3 && void 0 !== arguments[3]
																? arguments[3]
																: {},
														o = new t(e, n, i);
													return o.css(r), this.append(o), o;
												},
											},
											{
												key: "firstChild",
												value: function () {
													return new t(this.el.firstElementChild);
												},
											},
											{
												key: "replace",
												value: function (t, e) {
													return this.el.replaceChild(e, t), this;
												},
											},
										],
										[
											{
												key: "getScrollTop",
												value: function () {
													return Math.max(
														window.pageYOffset,
														document.documentElement.scrollTop,
														document.body.scrollTop
													);
												},
											},
											{
												key: "getScrollLeft",
												value: function () {
													return Math.max(
														window.pageXOffset,
														document.documentElement.scrollLeft,
														document.body.scrollLeft
													);
												},
											},
										]
									),
									t
								);
							})(),
							an = (function () {
								function t(e) {
									_(this, t), (this.$store = e), this.initialize();
								}
								return (
									y(t, [
										{
											key: "initialize",
											value: function () {
												var t = this;
												this.filterProps().forEach(function (e) {
													t.$store.action(e, t);
												});
											},
										},
										{
											key: "filterProps",
											value: function () {
												var t =
													arguments.length > 0 && void 0 !== arguments[0]
														? arguments[0]
														: "/";
												return Object.getOwnPropertyNames(
													this.__proto__
												).filter(function (e) {
													return e.startsWith(t);
												});
											},
										},
									]),
									t
								);
							})(),
							ln = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "initialize",
											value: function () {
												b(
													e.prototype.__proto__ ||
														Object.getPrototypeOf(e.prototype),
													"initialize",
													this
												).call(this),
													(this.$store.colorSetsList = [
														{
															name: "Material",
															colors: [
																"#F44336",
																"#E91E63",
																"#9C27B0",
																"#673AB7",
																"#3F51B5",
																"#2196F3",
																"#03A9F4",
																"#00BCD4",
																"#009688",
																"#4CAF50",
																"#8BC34A",
																"#CDDC39",
																"#FFEB3B",
																"#FFC107",
																"#FF9800",
																"#FF5722",
																"#795548",
																"#9E9E9E",
																"#607D8B",
															],
														},
														{ name: "Custom", edit: !0, colors: [] },
														{
															name: "Color Scale",
															scale: ["red", "yellow", "black"],
															count: 5,
														},
													]),
													(this.$store.currentColorSets = {});
											},
										},
										{
											key: "/list",
											value: function (t) {
												return Array.isArray(t.userList) && t.userList.length
													? t.userList
													: t.colorSetsList;
											},
										},
										{
											key: "/setUserPalette",
											value: function (t, e) {
												(t.userList = e),
													t.dispatch("/resetUserPalette"),
													t.dispatch("/setCurrentColorSets");
											},
										},
										{
											key: "/resetUserPalette",
											value: function (t) {
												t.userList &&
													t.userList.length &&
													((t.userList = t.userList.map(function (e, n) {
														if ("function" == typeof e.colors) {
															var i = e.colors;
															(e.colors = i(t)), (e._colors = i);
														}
														return Object.assign(
															{ name: "color-" + n, colors: [] },
															e
														);
													})),
													t.emit("changeUserList"));
											},
										},
										{
											key: "/setCurrentColorSets",
											value: function (t, e) {
												var n = t.dispatch("/list");
												(t.currentColorSets =
													void 0 === e
														? n[0]
														: "number" == typeof e
														? n[e]
														: n.filter(function (t) {
																return t.name == e;
														  })[0]),
													t.emit("changeCurrentColorSets");
											},
										},
										{
											key: "/getCurrentColorSets",
											value: function (t) {
												return t.currentColorSets;
											},
										},
										{
											key: "/addCurrentColor",
											value: function (t, e) {
												Array.isArray(t.currentColorSets.colors) &&
													(t.currentColorSets.colors.push(e),
													t.emit("changeCurrentColorSets"));
											},
										},
										{
											key: "/setCurrentColorAll",
											value: function (t) {
												var e =
													arguments.length > 1 && void 0 !== arguments[1]
														? arguments[1]
														: [];
												(t.currentColorSets.colors = e),
													t.emit("changeCurrentColorSets");
											},
										},
										{
											key: "/removeCurrentColor",
											value: function (t, e) {
												t.currentColorSets.colors[e] &&
													(t.currentColorSets.colors.splice(e, 1),
													t.emit("changeCurrentColorSets"));
											},
										},
										{
											key: "/removeCurrentColorToTheRight",
											value: function (t, e) {
												t.currentColorSets.colors[e] &&
													(t.currentColorSets.colors.splice(
														e,
														Number.MAX_VALUE
													),
													t.emit("changeCurrentColorSets"));
											},
										},
										{
											key: "/clearPalette",
											value: function (t) {
												t.currentColorSets.colors &&
													((t.currentColorSets.colors = []),
													t.emit("changeCurrentColorSets"));
											},
										},
										{
											key: "/getCurrentColors",
											value: function (t) {
												return t.dispatch("/getColors", t.currentColorSets);
											},
										},
										{
											key: "/getColors",
											value: function (t, e) {
												return e.scale
													? Ze.scale(e.scale, e.count)
													: e.colors || [];
											},
										},
										{
											key: "/getColorSetsList",
											value: function (t) {
												return t.dispatch("/list").map(function (e) {
													return {
														name: e.name,
														edit: e.edit,
														colors: t.dispatch("/getColors", e),
													};
												});
											},
										},
									]),
									e
								);
							})(an),
							cn = {
								addEvent: function (t, e, n, i) {
									t && t.addEventListener(e, n, i);
								},
								removeEvent: function (t, e, n) {
									t && t.removeEventListener(e, n);
								},
								pos: function (t) {
									return t.touches && t.touches[0] ? t.touches[0] : t;
								},
								posXY: function (t) {
									var e = this.pos(t);
									return { x: e.pageX, y: e.pageY };
								},
							},
							hn = (function () {
								function t(e) {
									var n =
										arguments.length > 1 && void 0 !== arguments[1]
											? arguments[1]
											: {};
									_(this, t), (this.masterObj = e), (this.settingObj = n);
								}
								return (
									y(t, [
										{
											key: "set",
											value: function (t, e) {
												var n =
													arguments.length > 2 && void 0 !== arguments[2]
														? arguments[2]
														: void 0;
												this.settingObj[t] = e || n;
											},
										},
										{
											key: "init",
											value: function (t) {
												if (!this.has(t)) {
													var e = t.split("."),
														n =
															this.masterObj.refs[e[0]] ||
															this.masterObj[e[0]] ||
															this.masterObj,
														i = e.pop();
													if (n[i]) {
														for (
															var r = arguments.length,
																o = Array(r > 1 ? r - 1 : 0),
																s = 1;
															s < r;
															s++
														)
															o[s - 1] = arguments[s];
														var a = n[i].apply(n, o);
														this.set(t, a);
													}
												}
											},
										},
										{
											key: "get",
											value: function (t) {
												var e =
													arguments.length > 1 && void 0 !== arguments[1]
														? arguments[1]
														: "";
												return this.init(t, e), this.settingObj[t] || e;
											},
										},
										{
											key: "has",
											value: function (t) {
												return !!this.settingObj[t];
											},
										},
									]),
									t
								);
							})(),
							un =
								/^(click|mouse(down|up|move|enter|leave)|touch(start|move|end)|key(down|up|press)|contextmenu|change|input)/gi,
							fn = /^load (.*)/gi,
							dn = ["Control", "Shift", "Alt", "Meta"],
							pn = (function () {
								function t() {
									_(this, t),
										(this.state = new hn(this)),
										(this.refs = {}),
										(this.childComponents = this.components());
								}
								return (
									y(t, [
										{
											key: "newChildComponents",
											value: function () {
												var t = this;
												Object.keys(this.childComponents).forEach(function (e) {
													var n = t.childComponents[e];
													t[e] = new n(t);
												});
											},
										},
										{
											key: "render",
											value: function () {
												(this.$el = this.parseTemplate(this.template())),
													(this.refs.$el = this.$el),
													this.parseTarget(),
													this.load(),
													this.afterRender();
											},
										},
										{ key: "afterRender", value: function () {} },
										{
											key: "components",
											value: function () {
												return {};
											},
										},
										{
											key: "parseTemplate",
											value: function (t) {
												var e = this,
													n = new sn("div").html(t).firstChild(),
													i = n.findAll("[ref]");
												return (
													[].concat(E(i)).forEach(function (t) {
														var n = t.getAttribute("ref");
														e.refs[n] = new sn(t);
													}),
													n
												);
											},
										},
										{
											key: "parseTarget",
											value: function () {
												var t = this,
													e = this.$el.findAll("[target]");
												[].concat(E(e)).forEach(function (e) {
													var n = e.getAttribute("target"),
														i = e.getAttribute("ref") || n,
														r = new (0, t.childComponents[n])(t);
													(t[i] = r),
														(t.refs[i] = r.$el),
														r &&
															(r.render(),
															new sn(e.parentNode).replace(e, r.$el.el));
												});
											},
										},
										{
											key: "load",
											value: function () {
												var t = this;
												this.filterProps(fn).forEach(function (e) {
													var n = e.split("load ")[1];
													t.refs[n] &&
														t.refs[n].html(t.parseTemplate(t[e].call(t)));
												});
											},
										},
										{
											key: "template",
											value: function () {
												return "<div></div>";
											},
										},
										{ key: "initialize", value: function () {} },
										{
											key: "initializeEvent",
											value: function () {
												var t = this;
												this.initializeEventMachin(),
													Object.keys(this.childComponents).forEach(function (
														e
													) {
														t[e] && t[e].initializeEvent();
													});
											},
										},
										{
											key: "destroy",
											value: function () {
												var t = this;
												this.destroyEventMachin(),
													Object.keys(this.childComponents).forEach(function (
														e
													) {
														t[e] && t[e].destroy();
													});
											},
										},
										{
											key: "destroyEventMachin",
											value: function () {
												this.removeEventAll();
											},
										},
										{
											key: "initializeEventMachin",
											value: function () {
												this.filterProps(un).forEach(
													this.parseEvent.bind(this)
												);
											},
										},
										{
											key: "collectProps",
											value: function () {
												if (!this.collapsedProps) {
													var t = this.__proto__,
														e = [];
													do {
														e.push.apply(e, E(Object.getOwnPropertyNames(t))),
															(t = t.__proto__);
													} while (t);
													this.collapsedProps = e;
												}
												return this.collapsedProps;
											},
										},
										{
											key: "filterProps",
											value: function (t) {
												return this.collectProps().filter(function (e) {
													return e.match(t);
												});
											},
										},
										{
											key: "parseEvent",
											value: function (t) {
												var e = t.split(" ");
												this.bindingEvent(e, this[t].bind(this));
											},
										},
										{
											key: "getDefaultDomElement",
											value: function (t) {
												var e = void 0;
												return (e = t
													? this.refs[t] || this[t] || window[t]
													: this.el || this.$el || this.$root) instanceof sn
													? e.getElement()
													: e;
											},
										},
										{
											key: "getDefaultEventObject",
											value: function (t) {
												var e = this,
													n = t.split("."),
													i = n.shift(),
													r = n.includes("Control"),
													o = n.includes("Shift"),
													s = n.includes("Alt"),
													a = n.includes("Meta"),
													l = (n = n.filter(function (t) {
														return !1 === dn.includes(t);
													})).filter(function (t) {
														return !!e[t];
													});
												return {
													eventName: i,
													isControl: r,
													isShift: o,
													isAlt: s,
													isMeta: a,
													codes: (n = n
														.filter(function (t) {
															return !1 === l.includes(t);
														})
														.map(function (t) {
															return t.toLowerCase();
														})),
													checkMethodList: l,
												};
											},
										},
										{
											key: "bindingEvent",
											value: function (t, e) {
												var n,
													i = ((n = t), Array.isArray(n) ? n : Array.from(n)),
													r = i[0],
													o = i[1],
													s = i.slice(2);
												o = this.getDefaultDomElement(o);
												var a = this.getDefaultEventObject(r);
												(a.dom = o),
													(a.delegate = s.join(" ")),
													this.addEvent(a, e);
											},
										},
										{
											key: "matchPath",
											value: function (t, e) {
												return t
													? t.matches(e)
														? t
														: this.matchPath(t.parentElement, e)
													: null;
											},
										},
										{
											key: "getBindings",
											value: function () {
												return (
													this._bindings || this.initBindings(), this._bindings
												);
											},
										},
										{
											key: "addBinding",
											value: function (t) {
												this.getBindings().push(t);
											},
										},
										{
											key: "initBindings",
											value: function () {
												this._bindings = [];
											},
										},
										{
											key: "checkEventType",
											value: function (t, e) {
												var n = this,
													i = !e.isControl || t.ctrlKey,
													r = !e.isShift || t.shiftKey,
													o = !e.isAlt || t.altKey,
													s = !e.isMeta || t.metaKey,
													a = !0;
												e.codes.length &&
													(a =
														e.codes.includes(t.code.toLowerCase()) ||
														e.codes.includes(t.key.toLowerCase()));
												var l = !0;
												return (
													e.checkMethodList.length &&
														(l = e.checkMethodList.every(function (e) {
															return n[e].call(n, t);
														})),
													i && o && r && s && a && l
												);
											},
										},
										{
											key: "makeCallback",
											value: function (t, e) {
												var n = this;
												return t.delegate
													? function (i) {
															if (
																((i.xy = cn.posXY(i)), n.checkEventType(i, t))
															) {
																var r = n.matchPath(
																	i.target || i.srcElement,
																	t.delegate
																);
																if (r)
																	return (
																		(i.delegateTarget = r),
																		(i.$delegateTarget = new sn(r)),
																		e(i)
																	);
															}
													  }
													: function (i) {
															if (
																((i.xy = cn.posXY(i)), n.checkEventType(i, t))
															)
																return e(i);
													  };
											},
										},
										{
											key: "addEvent",
											value: function (t, e) {
												(t.callback = this.makeCallback(t, e)),
													this.addBinding(t);
												var n = !0;
												"touchstart" === t.eventName && (n = { passive: !0 }),
													cn.addEvent(t.dom, t.eventName, t.callback, n);
											},
										},
										{
											key: "removeEventAll",
											value: function () {
												var t = this;
												this.getBindings().forEach(function (e) {
													t.removeEvent(e);
												}),
													this.initBindings();
											},
										},
										{
											key: "removeEvent",
											value: function (t) {
												var e = t.eventName,
													n = t.dom,
													i = t.callback;
												cn.removeEvent(n, e, i);
											},
										},
									]),
									t
								);
							})(),
							gn = /^@/,
							mn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.opt = t || {}),
										t && t.$store && (n.$store = t.$store),
										n.initialize(),
										n.initializeStoreEvent(),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "initializeStoreEvent",
											value: function () {
												var t = this;
												(this.storeEvents = {}),
													this.filterProps(gn).forEach(function (e) {
														var n = e.split("@");
														n.shift();
														var i = n.join("@");
														(t.storeEvents[i] = t[e].bind(t)),
															t.$store.on(i, t.storeEvents[i]);
													});
											},
										},
										{
											key: "destoryStoreEvent",
											value: function () {
												var t = this;
												Object.keys(this.storeEvents).forEach(function (e) {
													t.$store.off(e, t.storeEvents[e]);
												});
											},
										},
									]),
									e
								);
							})(pn),
							vn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "initialize",
											value: function () {
												b(
													e.prototype.__proto__ ||
														Object.getPrototypeOf(e.prototype),
													"initialize",
													this
												).call(this),
													(this.$store.rgb = {}),
													(this.$store.hsl = {}),
													(this.$store.hsv = {}),
													(this.$store.alpha = 1),
													(this.$store.format = "hex");
											},
										},
										{
											key: "/changeFormat",
											value: function (t, e) {
												(t.format = e), t.emit("changeFormat");
											},
										},
										{
											key: "/initColor",
											value: function (t, e, n) {
												t.dispatch("/changeColor", e, n, !0),
													t.emit("initColor");
											},
										},
										{
											key: "/changeColor",
											value: function (t, e, n, i) {
												var r;
												"string" == typeof (e = e || "#FF0000") &&
													(e = Ze.parse(e)),
													(e.source = e.source || n),
													(t.alpha =
														void 0 === (r = e.a) || null == r ? t.alpha : e.a),
													(t.format = ("hsv" != e.type && e.type) || t.format),
													"hsl" == e.type
														? ((t.hsl = Object.assign(t.hsl, e)),
														  (t.rgb = Ze.HSLtoRGB(t.hsl)),
														  (t.hsv = Ze.HSLtoHSV(e)))
														: "hex" == e.type || "rgb" == e.type
														? ((t.rgb = Object.assign(t.rgb, e)),
														  (t.hsl = Ze.RGBtoHSL(t.rgb)),
														  (t.hsv = Ze.RGBtoHSV(e)))
														: "hsv" == e.type &&
														  ((t.hsv = Object.assign(t.hsv, e)),
														  (t.rgb = Ze.HSVtoRGB(t.hsv)),
														  (t.hsl = Ze.HSVtoHSL(t.hsv))),
													i || t.emit("changeColor", e.source);
											},
										},
										{
											key: "/getHueColor",
											value: function (t) {
												return tn.checkHueColor(t.hsv.h / 360);
											},
										},
										{
											key: "/toString",
											value: function (t, e) {
												var n = t[(e = e || t.format)] || t.rgb;
												return Ze.format(k({}, n, { a: t.alpha }), e);
											},
										},
										{
											key: "/toColor",
											value: function (t, e) {
												return "rgb" == (e = e || t.format)
													? t.dispatch("/toRGB")
													: "hsl" == e
													? t.dispatch("/toHSL")
													: "hex" == e
													? t.dispatch("/toHEX")
													: t.dispatch("/toString", e);
											},
										},
										{
											key: "/toRGB",
											value: function (t) {
												return t.dispatch("/toString", "rgb");
											},
										},
										{
											key: "/toHSL",
											value: function (t) {
												return t.dispatch("/toString", "hsl");
											},
										},
										{
											key: "/toHEX",
											value: function (t) {
												return t.dispatch("/toString", "hex").toUpperCase();
											},
										},
									]),
									e
								);
							})(an),
							_n = (function () {
								function t(e) {
									_(this, t),
										(this.callbacks = []),
										(this.actions = []),
										(this.modules = e.modules || []),
										this.initialize();
								}
								return (
									y(t, [
										{
											key: "initialize",
											value: function () {
												this.initializeModule();
											},
										},
										{
											key: "initializeModule",
											value: function () {
												var t = this;
												this.modules.forEach(function (e) {
													new e(t);
												});
											},
										},
										{
											key: "action",
											value: function (t, e) {
												this.actions[t] = { context: e, callback: e[t] };
											},
										},
										{
											key: "dispatch",
											value: function (t) {
												var e = [].concat(
														Array.prototype.slice.call(arguments)
													),
													n = ((t = e.shift()), this.actions[t]);
												if (n)
													return n.callback.apply(
														n.context,
														[this].concat(E(e))
													);
											},
										},
										{ key: "module", value: function (t) {} },
										{
											key: "on",
											value: function (t, e) {
												this.callbacks.push({ event: t, callback: e });
											},
										},
										{
											key: "off",
											value: function (t, e) {
												0 == arguments.length
													? (this.callbacks = [])
													: 1 == arguments.length
													? (this.callbacks = this.callbacks.filter(function (
															e
													  ) {
															return e.event != t;
													  }))
													: 2 == arguments.length &&
													  (this.callbacks = this.callbacks.filter(function (
															n
													  ) {
															return n.event != t && n.callback != e;
													  }));
											},
										},
										{
											key: "emit",
											value: function () {
												var t = [].concat(
														Array.prototype.slice.call(arguments)
													),
													e = t.shift();
												this.callbacks
													.filter(function (t) {
														return t.event == e;
													})
													.forEach(function (e) {
														e &&
															"function" == typeof e.callback &&
															e.callback.apply(e, E(t));
													});
											},
										},
									]),
									t
								);
							})(),
							yn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.isColorPickerShow = !1),
										(n.isShortCut = !1),
										(n.hideDelay = +(void 0 === n.opt.hideDeplay
											? 2e3
											: n.opt.hideDelay)),
										n.timerCloseColorPicker,
										(n.autoHide = n.opt.autoHide || !0),
										(n.outputFormat = n.opt.outputFormat),
										(n.$checkColorPickerClass =
											n.checkColorPickerClass.bind(n)),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "initialize",
											value: function () {
												var t = this;
												(this.$body = null),
													(this.$root = null),
													(this.$store = new _n({ modules: [vn, ln] })),
													(this.callbackChange = function () {
														t.callbackColorValue();
													}),
													(this.callbackLastUpdate = function () {
														t.callbackLastUpdateColorValue();
													}),
													(this.colorpickerShowCallback = function () {}),
													(this.colorpickerHideCallback = function () {}),
													(this.colorpickerLastUpdateCallback = function () {}),
													(this.$body = new sn(this.getContainer())),
													(this.$root = new sn(
														"div",
														"codemirror-colorpicker"
													)),
													"inline" == this.opt.position &&
														this.$body.append(this.$root),
													this.opt.type && this.$root.addClass(this.opt.type),
													this.opt.hideInformation &&
														this.$root.addClass("hide-information"),
													this.opt.hideColorsets &&
														this.$root.addClass("hide-colorsets"),
													(this.$arrow = new sn("div", "arrow")),
													this.$root.append(this.$arrow),
													this.$store.dispatch(
														"/setUserPalette",
														this.opt.colorSets
													),
													this.render(),
													this.$root.append(this.$el),
													this.initColorWithoutChangeEvent(this.opt.color),
													this.initializeEvent();
											},
										},
										{
											key: "initColorWithoutChangeEvent",
											value: function (t) {
												this.$store.dispatch("/initColor", t);
											},
										},
										{
											key: "show",
											value: function (t, e, n, i, r) {
												(this.colorpickerShowCallback = n),
													(this.colorpickerHideCallback = i),
													(this.colorpickerLastUpdateCallback = r),
													this.$root.css(this.getInitalizePosition()).show(),
													(this.isColorPickerShow = !0),
													(this.isShortCut = t.isShortCut || !1),
													(this.outputFormat = t.outputFormat),
													(this.hideDelay = +(void 0 === t.hideDelay
														? 2e3
														: t.hideDelay)),
													this.hideDelay > 0 &&
														this.setHideDelay(this.hideDelay),
													this.$root.appendTo(this.$body),
													this.definePosition(t),
													this.initColorWithoutChangeEvent(e);
											},
										},
										{
											key: "initColor",
											value: function (t, e) {
												this.$store.dispatch("/changeColor", t, e);
											},
										},
										{
											key: "hide",
											value: function () {
												this.isColorPickerShow &&
													(this.$root.hide(),
													this.$root.remove(),
													(this.isColorPickerShow = !1),
													this.callbackHideColorValue());
											},
										},
										{
											key: "setColorsInPalette",
											value: function () {
												var t =
													arguments.length > 0 && void 0 !== arguments[0]
														? arguments[0]
														: [];
												this.$store.dispatch("/setCurrentColorAll", t);
											},
										},
										{
											key: "setUserPalette",
											value: function () {
												var t =
													arguments.length > 0 && void 0 !== arguments[0]
														? arguments[0]
														: [];
												this.$store.dispatch("/setUserPalette", t);
											},
										},
										{
											key: "getOption",
											value: function (t) {
												return this.opt[t];
											},
										},
										{
											key: "setOption",
											value: function (t, e) {
												this.opt[t] = e;
											},
										},
										{
											key: "isType",
											value: function (t) {
												return this.getOption("type") == t;
											},
										},
										{
											key: "isPaletteType",
											value: function () {
												return this.isType("palette");
											},
										},
										{
											key: "isSketchType",
											value: function () {
												return this.isType("sketch");
											},
										},
										{
											key: "getContainer",
											value: function () {
												return this.opt.container || document.body;
											},
										},
										{
											key: "getColor",
											value: function (t) {
												return this.$store.dispatch("/toColor", t);
											},
										},
										{
											key: "definePositionForArrow",
											value: function (t, e, n) {},
										},
										{
											key: "definePosition",
											value: function (t) {
												var e = this.$root.width(),
													n = this.$root.height(),
													i = t.left - this.$body.scrollLeft();
												e + i > window.innerWidth &&
													(i -= e + i - window.innerWidth),
													i < 0 && (i = 0);
												var r = t.top - this.$body.scrollTop();
												n + r > window.innerHeight &&
													(r -= n + r - window.innerHeight),
													r < 0 && (r = 0),
													this.$root.css({ left: i + "px", top: r + "px" });
											},
										},
										{
											key: "getInitalizePosition",
											value: function () {
												return "inline" == this.opt.position
													? {
															position: "relative",
															left: "auto",
															top: "auto",
															display: "inline-block",
													  }
													: {
															position: "fixed",
															left: "-10000px",
															top: "-10000px",
													  };
											},
										},
										{
											key: "isAbsolute",
											value: function () {
												return "inline" !== this.opt.position;
											},
										},
										{
											key: "mouseup.isAbsolute document",
											value: function (t) {
												(this.__isMouseDown = !1),
													this.checkInHtml(t.target) ||
														(0 == this.checkColorPickerClass(t.target)
															? this.hide()
															: this.__isMouseIn ||
															  (clearTimeout(this.timerCloseColorPicker),
															  (this.timerCloseColorPicker = setTimeout(
																	this.hide.bind(this),
																	this.delayTime || this.hideDelay
															  ))));
											},
										},
										{
											key: "keyup.isAbsolute.escape $root",
											value: function (t) {
												this.hide();
											},
										},
										{
											key: "mouseover.isAbsolute $root",
											value: function (t) {
												clearTimeout(this.timerCloseColorPicker);
											},
										},
										{
											key: "mousemove.isAbsolute $root",
											value: function (t) {
												clearTimeout(this.timerCloseColorPicker);
											},
										},
										{
											key: "mouseenter.isAbsolute $root",
											value: function (t) {
												clearTimeout(this.timerCloseColorPicker),
													(this.__isMouseIn = !0);
											},
										},
										{
											key: "mouseleave.isAbsolute $root",
											value: function (t) {
												(this.__isMouseIn = !1),
													this.__isMouseDown ||
														(clearTimeout(this.timerCloseColorPicker),
														(this.timerCloseColorPicker = setTimeout(
															this.hide.bind(this),
															this.delayTime || this.hideDelay
														)));
											},
										},
										{
											key: "mousedown.isAbsolute $root",
											value: function (t) {
												this.__isMouseDown = !0;
											},
										},
										{
											key: "setHideDelay",
											value: function (t) {
												this.delayTime = t || 0;
											},
										},
										{
											key: "runHideDelay",
											value: function () {
												this.isColorPickerShow && this.setHideDelay();
											},
										},
										{
											key: "callbackColorValue",
											value: function (t) {
												(t = t || this.getCurrentColor()),
													"function" == typeof this.opt.onChange &&
														this.opt.onChange.call(this, t),
													"function" == typeof this.colorpickerShowCallback &&
														this.colorpickerShowCallback(t);
											},
										},
										{
											key: "callbackLastUpdateColorValue",
											value: function (t) {
												(t = t || this.getCurrentColor()),
													"function" == typeof this.opt.onLastUpdate &&
														this.opt.onLastUpdate.call(this, t),
													"function" ==
														typeof this.colorpickerLastUpdateCallback &&
														this.colorpickerLastUpdateCallback(t);
											},
										},
										{
											key: "callbackHideColorValue",
											value: function (t) {
												(t = t || this.getCurrentColor()),
													"function" == typeof this.opt.onHide &&
														this.opt.onHide.call(this, t),
													"function" == typeof this.colorpickerHideCallback &&
														this.colorpickerHideCallback(t);
											},
										},
										{
											key: "getCurrentColor",
											value: function () {
												return this.$store.dispatch(
													"/toColor",
													this.outputFormat
												);
											},
										},
										{
											key: "checkColorPickerClass",
											value: function (t) {
												var e = new sn(t).closest("codemirror-colorview"),
													n = new sn(t).closest("codemirror-colorpicker"),
													i = new sn(t).closest("CodeMirror");
												return t.nodeName, !!(n || e || i);
											},
										},
										{
											key: "checkInHtml",
											value: function (t) {
												return "HTML" == t.nodeName;
											},
										},
										{
											key: "initializeStoreEvent",
											value: function () {
												b(
													e.prototype.__proto__ ||
														Object.getPrototypeOf(e.prototype),
													"initializeStoreEvent",
													this
												).call(this),
													this.$store.on("changeColor", this.callbackChange),
													this.$store.on(
														"lastUpdateColor",
														this.callbackLastUpdate
													),
													this.$store.on("changeFormat", this.callbackChange);
											},
										},
										{
											key: "destroy",
											value: function () {
												b(
													e.prototype.__proto__ ||
														Object.getPrototypeOf(e.prototype),
													"destroy",
													this
												).call(this),
													this.$store.off("changeColor", this.callbackChange),
													this.$store.off(
														"lastUpdateColor",
														this.callbackLastUpdate
													),
													this.$store.off("changeFormat", this.callbackChange),
													(this.callbackChange = void 0),
													(this.callbackLastUpdate = void 0),
													(this.colorpickerShowCallback = void 0),
													(this.colorpickerHideCallback = void 0);
											},
										},
									]),
									e
								);
							})(mn),
							xn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.minValue = 0),
										(n.maxValue = 1),
										(n.source = "base-slider"),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "getMinMaxPosition",
											value: function () {
												var t = this.getMinPosition(),
													e = this.getMaxDist();
												return { min: t, max: t + e, width: e };
											},
										},
										{
											key: "getCurrent",
											value: function (t) {
												return min + this.getMaxDist() * t;
											},
										},
										{
											key: "getMinPosition",
											value: function () {
												return this.refs.$container.offset().left;
											},
										},
										{
											key: "getMaxDist",
											value: function () {
												return this.state.get("$container.width");
											},
										},
										{
											key: "getDist",
											value: function (t) {
												var e = this.getMinMaxPosition(),
													n = e.min,
													i = e.max;
												return t < n
													? 0
													: t > i
													? 100
													: ((t - n) / (i - n)) * 100;
											},
										},
										{
											key: "getCaculatedDist",
											value: function (t) {
												var e = t
													? this.getMousePosition(t)
													: this.getCurrent(
															this.getDefaultValue() / this.maxValue
													  );
												return this.getDist(e);
											},
										},
										{
											key: "getDefaultValue",
											value: function () {
												return 0;
											},
										},
										{
											key: "setMousePosition",
											value: function (t) {
												this.refs.$bar.css({ left: t + "px" });
											},
										},
										{
											key: "getMousePosition",
											value: function (t) {
												return cn.pos(t).pageX;
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI();
											},
										},
										{
											key: "setColorUI",
											value: function (t) {
												(t = t || this.getDefaultValue()) <= this.minValue
													? this.refs.$bar.addClass("first").removeClass("last")
													: t >= this.maxValue
													? this.refs.$bar.addClass("last").removeClass("first")
													: this.refs.$bar
															.removeClass("last")
															.removeClass("first"),
													this.setMousePosition(
														this.getMaxDist() * ((t || 0) / this.maxValue)
													);
											},
										},
									]),
									e
								);
							})(
								(function (t) {
									function e(t) {
										_(this, e);
										var n = C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
										);
										return (n.source = "base-box"), n;
									}
									return (
										T(e, t),
										y(e, [
											{ key: "refresh", value: function () {} },
											{ key: "refreshColorUI", value: function (t) {} },
											{
												key: "changeColor",
												value: function (t) {
													this.$store.dispatch(
														"/changeColor",
														Object.assign({ source: this.source }, t || {})
													);
												},
											},
											{
												key: "mouseup document",
												value: function (t) {
													this.onDragEnd(t);
												},
											},
											{
												key: "mousemove document",
												value: function (t) {
													this.onDragMove(t);
												},
											},
											{
												key: "mousedown $bar",
												value: function (t) {
													t.preventDefault(), (this.isDown = !0);
												},
											},
											{
												key: "mousedown $container",
												value: function (t) {
													(this.isDown = !0), this.onDragStart(t);
												},
											},
											{
												key: "touchend document",
												value: function (t) {
													this.onDragEnd(t);
												},
											},
											{
												key: "touchmove document",
												value: function (t) {
													this.onDragMove(t);
												},
											},
											{
												key: "touchstart $bar",
												value: function (t) {
													t.preventDefault(), (this.isDown = !0);
												},
											},
											{
												key: "touchstart $container",
												value: function (t) {
													this.onDragStart(t);
												},
											},
											{
												key: "onDragStart",
												value: function (t) {
													(this.isDown = !0), this.refreshColorUI(t);
												},
											},
											{
												key: "onDragMove",
												value: function (t) {
													this.isDown && this.refreshColorUI(t);
												},
											},
											{
												key: "onDragEnd",
												value: function (t) {
													this.isDown &&
														(this.$store.emit("lastUpdateColor"),
														(this.isDown = !1));
												},
											},
											{
												key: "@changeColor",
												value: function (t) {
													this.source != t && this.refresh();
												},
											},
											{
												key: "@initColor",
												value: function () {
													this.refresh();
												},
											},
										]),
										e
									);
								})(mn)
							),
							kn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.minValue = 0),
										(n.maxValue = 1),
										(n.source = "value-control"),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class="value">\n                <div ref="$container" class="value-container">\n                    <div ref="$bar" class="drag-bar"></div>\n                </div>\n            </div>\n        ';
											},
										},
										{
											key: "setBackgroundColor",
											value: function () {
												this.refs.$container.css(
													"background-color",
													this.$store.dispatch("/toRGB")
												);
											},
										},
										{
											key: "refresh",
											value: function () {
												b(
													e.prototype.__proto__ ||
														Object.getPrototypeOf(e.prototype),
													"refresh",
													this
												).call(this),
													this.setBackgroundColor();
											},
										},
										{
											key: "getDefaultValue",
											value: function () {
												return this.$store.hsv.v;
											},
										},
										{
											key: "refreshColorUI",
											value: function (t) {
												var e = this.getCaculatedDist(t);
												this.setColorUI((e / 100) * this.maxValue),
													this.changeColor({
														type: "hsv",
														v: (e / 100) * this.maxValue,
													});
											},
										},
									]),
									e
								);
							})(xn),
							bn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.minValue = 0),
										(n.maxValue = 1),
										(n.source = "opacity-control"),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n        <div class="opacity">\n            <div ref="$container" class="opacity-container">\n                <div ref="$colorbar" class="color-bar"></div>\n                <div ref="$bar" class="drag-bar"></div>\n            </div>\n        </div>\n        ';
											},
										},
										{
											key: "refresh",
											value: function () {
												b(
													e.prototype.__proto__ ||
														Object.getPrototypeOf(e.prototype),
													"refresh",
													this
												).call(this),
													this.setOpacityColorBar();
											},
										},
										{
											key: "setOpacityColorBar",
											value: function () {
												var t = Object.assign({}, this.$store.rgb);
												t.a = 0;
												var e = Ze.format(t, "rgb");
												t.a = 1;
												var n = Ze.format(t, "rgb");
												this.setOpacityColorBarBackground(e, n);
											},
										},
										{
											key: "setOpacityColorBarBackground",
											value: function (t, e) {
												this.refs.$colorbar.css(
													"background",
													"linear-gradient(to right, " + t + ", " + e + ")"
												);
											},
										},
										{
											key: "getDefaultValue",
											value: function () {
												return this.$store.alpha;
											},
										},
										{
											key: "refreshColorUI",
											value: function (t) {
												var e = this.getCaculatedDist(t);
												this.setColorUI((e / 100) * this.maxValue),
													this.changeColor({
														a: (Math.floor(e) / 100) * this.maxValue,
													});
											},
										},
									]),
									e
								);
							})(xn),
							Tn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "components",
											value: function () {
												return { Value: kn, Opacity: bn };
											},
										},
										{
											key: "template",
											value: function () {
												return '\n        <div class="control">\n            <div target="Value" ></div>\n            <div target="Opacity" ></div>\n            <div ref="$controlPattern" class="empty"></div>\n            <div ref="$controlColor" class="color"></div>\n        </div>\n        ';
											},
										},
										{
											key: "setBackgroundColor",
											value: function () {
												this.refs.$controlColor.css(
													"background-color",
													this.$store.dispatch("/toRGB")
												);
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI(), this.setBackgroundColor();
											},
										},
										{
											key: "setColorUI",
											value: function () {
												this.Value.setColorUI(), this.Opacity.setColorUI();
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												"macos-control" != t && this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
									]),
									e
								);
							})(mn),
							Cn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.width = 214),
										(n.height = 214),
										(n.thinkness = 0),
										(n.half_thinkness = 0),
										(n.source = "colorwheel"),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n        <div class="wheel">\n            <canvas class="wheel-canvas" ref="$colorwheel" ></canvas>\n            <div class="wheel-canvas" ref="$valuewheel" ></div>\n            <div class="drag-pointer" ref="$drag_pointer"></div>\n        </div>\n        ';
											},
										},
										{
											key: "refresh",
											value: function (t) {
												this.setColorUI(t);
											},
										},
										{
											key: "setColorUI",
											value: function (t) {
												this.renderCanvas(),
													this.renderValue(),
													this.setHueColor(null, t);
											},
										},
										{
											key: "renderValue",
											value: function () {
												var t = 1 - this.$store.hsv.v;
												this.refs.$valuewheel.css({
													"background-color": "rgba(0, 0, 0, " + t + ")",
												});
											},
										},
										{
											key: "renderWheel",
											value: function (t, e) {
												this.width && !t && (t = this.width),
													this.height && !e && (e = this.height);
												var n = new sn("canvas"),
													i = n.el.getContext("2d");
												(n.el.width = t),
													(n.el.height = e),
													n.css({ width: t + "px", height: e + "px" });
												for (
													var r = i.getImageData(0, 0, t, e),
														o = r.data,
														s = Math.floor(t / 2),
														a = Math.floor(e / 2),
														l = t > e ? a : s,
														c = s,
														h = a,
														f = 0;
													f < e;
													f++
												)
													for (var d = 0; d < t; d++) {
														var p = d - c + 1,
															g = f - h + 1,
															m = p * p + g * g,
															v = u(p, g),
															_ = Ze.HSVtoRGB(
																v,
																Math.min(Math.sqrt(m) / l, 1),
																1
															),
															y = 4 * (f * t + d);
														(o[y] = _.r),
															(o[y + 1] = _.g),
															(o[y + 2] = _.b),
															(o[y + 3] = 255);
													}
												return (
													i.putImageData(r, 0, 0),
													this.thinkness > 0 &&
														((i.globalCompositeOperation = "destination-out"),
														(i.fillStyle = "black"),
														i.beginPath(),
														i.arc(c, h, l - this.thinkness, 0, 2 * Math.PI),
														i.closePath(),
														i.fill()),
													n
												);
											},
										},
										{
											key: "renderCanvas",
											value: function () {
												if (!this.$store.createdWheelCanvas) {
													var t = this.refs.$colorwheel,
														e = t.el.getContext("2d"),
														n = t.size(),
														i = w(n, 2),
														r = i[0],
														o = i[1];
													this.width && !r && (r = this.width),
														this.height && !o && (o = this.height),
														(t.el.width = r),
														(t.el.height = o),
														t.css({ width: r + "px", height: o + "px" });
													var s = this.renderWheel(r, o);
													e.drawImage(s.el, 0, 0),
														(this.$store.createdWheelCanvas = !0);
												}
											},
										},
										{
											key: "getDefaultValue",
											value: function () {
												return this.$store.hsv.h;
											},
										},
										{
											key: "getDefaultSaturation",
											value: function () {
												return this.$store.hsv.s;
											},
										},
										{
											key: "getCurrentXY",
											value: function (t, e, n, i, r) {
												return t
													? cn.posXY(t)
													: (function (t, e) {
															var n =
																arguments.length > 3 && void 0 !== arguments[3]
																	? arguments[3]
																	: 0;
															return {
																x: c(
																	t,
																	e,
																	arguments.length > 2 &&
																		void 0 !== arguments[2]
																		? arguments[2]
																		: 0
																),
																y: h(t, e, n),
															};
													  })(e, n, i, r);
											},
										},
										{
											key: "getRectangle",
											value: function () {
												var t = this.state.get("$el.width"),
													e = this.state.get("$el.height"),
													n = this.state.get("$colorwheel.width") / 2,
													i = this.refs.$el.offset().left,
													r = i + t / 2,
													o = this.refs.$el.offset().top;
												return {
													minX: i,
													minY: o,
													width: t,
													height: e,
													radius: n,
													centerX: r,
													centerY: o + e / 2,
												};
											},
										},
										{
											key: "setHueColor",
											value: function (t, e) {
												if (this.state.get("$el.width")) {
													var n = this.getRectangle(),
														i = n.minX,
														r = n.minY,
														o = n.radius,
														s = n.centerX,
														a = n.centerY,
														l = this.getCurrentXY(
															t,
															this.getDefaultValue(),
															this.getDefaultSaturation() * o,
															s,
															a
														),
														c = (g = l.x) - s,
														h = (m = l.y) - a,
														f = c * c + h * h,
														d = u(c, h);
													if (f > o * o)
														var p = this.getCurrentXY(null, d, o, s, a),
															g = p.x,
															m = p.y;
													var v = Math.min(Math.sqrt(f) / o, 1);
													this.refs.$drag_pointer.css({
														left: g - i + "px",
														top: m - r + "px",
													}),
														e || this.changeColor({ type: "hsv", h: d, s: v });
												}
											},
										},
										{
											key: "changeColor",
											value: function (t) {
												this.$store.dispatch(
													"/changeColor",
													Object.assign({ source: this.source }, t || {})
												);
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												this.source != t && this.refresh(!0);
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh(!0);
											},
										},
										{
											key: "mouseup document",
											value: function (t) {
												this.isDown &&
													((this.isDown = !1),
													this.$store.emit("lastUpdateColor"));
											},
										},
										{
											key: "mousemove document",
											value: function (t) {
												this.isDown && this.setHueColor(t);
											},
										},
										{
											key: "mousedown $drag_pointer",
											value: function (t) {
												t.preventDefault(), (this.isDown = !0);
											},
										},
										{
											key: "mousedown $el",
											value: function (t) {
												(this.isDown = !0), this.setHueColor(t);
											},
										},
										{
											key: "touchend document",
											value: function (t) {
												this.isDown &&
													((this.isDown = !1),
													this.$store.emit("lastUpdateColor"));
											},
										},
										{
											key: "touchmove document",
											value: function (t) {
												this.isDown && this.setHueColor(t);
											},
										},
										{
											key: "touchstart $drag_pointer",
											value: function (t) {
												t.preventDefault(), (this.isDown = !0);
											},
										},
										{
											key: "touchstart $el",
											value: function (t) {
												t.preventDefault(),
													(this.isDown = !0),
													this.setHueColor(t);
											},
										},
									]),
									e
								);
							})(mn),
							wn = "chromedevtool-information",
							En = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n        <div class="information hex">\n            <div ref="$informationChange" class="information-change">\n                <button ref="$formatChangeButton" type="button" class="format-change-button arrow-button"></button>\n            </div>\n            <div class="information-item hex">\n                <div class="input-field hex">\n                    <input ref="$hexCode" class="input" type="text" />\n                    <div class="title">HEX</div>\n                </div>\n            </div>\n            <div class="information-item rgb">\n                <div class="input-field rgb-r">\n                    <input ref="$rgb_r" class="input" type="number" step="1" min="0" max="255" />\n                    <div class="title">R</div>\n                </div>\n                <div class="input-field rgb-g">\n                    <input ref="$rgb_g" class="input" type="number" step="1" min="0" max="255" />\n                    <div class="title">G</div>\n                </div>\n                <div class="input-field rgb-b">\n                    <input ref="$rgb_b" class="input" type="number" step="1" min="0" max="255" />\n                    <div class="title">B</div>\n                </div>          \n                <div class="input-field rgb-a">\n                    <input ref="$rgb_a" class="input" type="number" step="0.01" min="0" max="1" />\n                    <div class="title">A</div>\n                </div>                                                            \n            </div>\n            <div class="information-item hsl">\n                <div class="input-field hsl-h">\n                    <input ref="$hsl_h" class="input" type="number" step="1" min="0" max="360" />\n                    <div class="title">H</div>\n                </div>\n                <div class="input-field hsl-s">\n                    <input ref="$hsl_s" class="input" type="number" step="1" min="0" max="100" />\n                    <div class="postfix">%</div>\n                    <div class="title">S</div>\n                </div>\n                <div class="input-field hsl-l">\n                    <input ref="$hsl_l" class="input" type="number" step="1" min="0" max="100" />\n                    <div class="postfix">%</div>                        \n                    <div class="title">L</div>\n                </div>\n                <div class="input-field hsl-a">\n                    <input ref="$hsl_a" class="input" type="number" step="0.01" min="0" max="1" />\n                    <div class="title">A</div>\n                </div>\n            </div>\n        </div>\n        ';
											},
										},
										{
											key: "setCurrentFormat",
											value: function (t) {
												(this.format = t), this.initFormat();
											},
										},
										{
											key: "initFormat",
											value: function () {
												var t = this,
													e = this.format || "hex";
												["hex", "rgb", "hsl"]
													.filter(function (t) {
														return t !== e;
													})
													.forEach(function (e) {
														t.$el.removeClass(e);
													}),
													this.$el.addClass(e);
											},
										},
										{
											key: "nextFormat",
											value: function () {
												var t = this.$store.format || "hex",
													e = "hex";
												"hex" == t
													? (e = "rgb")
													: "rgb" == t
													? (e = "hsl")
													: "hsl" == t && (e = "hex"),
													(this.format = e),
													this.$store.dispatch("/changeFormat", e),
													this.$store.emit("lastUpdateColor"),
													this.initFormat();
											},
										},
										{
											key: "goToFormat",
											value: function (t) {
												(this.format = t),
													this.$store.dispatch("/changeFormat", this.format),
													this.$store.emit("lastUpdateColor"),
													this.initFormat();
											},
										},
										{
											key: "getFormat",
											value: function () {
												return this.format || "hex";
											},
										},
										{
											key: "checkNumberKey",
											value: function (t) {
												var e = t.which,
													n = !1;
												return (
													(37 != e && 39 != e && 8 != e && 46 != e && 9 != e) ||
														(n = !0),
													!(!n && (e < 48 || e > 57))
												);
											},
										},
										{
											key: "checkNotNumberKey",
											value: function (t) {
												return !this.checkNumberKey(t);
											},
										},
										{
											key: "changeRgbColor",
											value: function () {
												this.$store.dispatch("/changeColor", {
													type: "rgb",
													r: this.refs.$rgb_r.int(),
													g: this.refs.$rgb_g.int(),
													b: this.refs.$rgb_b.int(),
													a: this.refs.$rgb_a.float(),
													source: wn,
												}),
													this.$store.emit("lastUpdateColor");
											},
										},
										{
											key: "changeHslColor",
											value: function () {
												this.$store.dispatch("/changeColor", {
													type: "hsl",
													h: this.refs.$hsl_h.int(),
													s: this.refs.$hsl_s.int(),
													l: this.refs.$hsl_l.int(),
													a: this.refs.$hsl_a.float(),
													source: wn,
												}),
													this.$store.emit("lastUpdateColor");
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												wn != t && this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
										{
											key: "input $rgb_r",
											value: function (t) {
												this.changeRgbColor();
											},
										},
										{
											key: "input $rgb_g",
											value: function (t) {
												this.changeRgbColor();
											},
										},
										{
											key: "input $rgb_b",
											value: function (t) {
												this.changeRgbColor();
											},
										},
										{
											key: "input $rgb_a",
											value: function (t) {
												this.changeRgbColor();
											},
										},
										{
											key: "input $hsl_h",
											value: function (t) {
												this.changeHslColor();
											},
										},
										{
											key: "input $hsl_s",
											value: function (t) {
												this.changeHslColor();
											},
										},
										{
											key: "input $hsl_l",
											value: function (t) {
												this.changeHslColor();
											},
										},
										{
											key: "input $hsl_a",
											value: function (t) {
												this.changeHslColor();
											},
										},
										{
											key: "keyup $hexCode",
											value: function (t) {
												var e = this.refs.$hexCode.val();
												"#" != e.charAt(0) ||
													(7 != e.length && 9 !== e.length) ||
													(this.$store.dispatch("/changeColor", e, wn),
													this.$store.emit("lastUpdateColor"));
											},
										},
										{
											key: "click $formatChangeButton",
											value: function (t) {
												this.nextFormat();
											},
										},
										{
											key: "click $el .information-item.hex .input-field .title",
											value: function (t) {
												this.goToFormat("rgb");
											},
										},
										{
											key: "click $el .information-item.rgb .input-field .title",
											value: function (t) {
												this.goToFormat("hsl");
											},
										},
										{
											key: "click $el .information-item.hsl .input-field .title",
											value: function (t) {
												this.goToFormat("hex");
											},
										},
										{
											key: "setRGBInput",
											value: function () {
												this.refs.$rgb_r.val(this.$store.rgb.r),
													this.refs.$rgb_g.val(this.$store.rgb.g),
													this.refs.$rgb_b.val(this.$store.rgb.b),
													this.refs.$rgb_a.val(this.$store.alpha);
											},
										},
										{
											key: "setHSLInput",
											value: function () {
												this.refs.$hsl_h.val(this.$store.hsl.h),
													this.refs.$hsl_s.val(this.$store.hsl.s),
													this.refs.$hsl_l.val(this.$store.hsl.l),
													this.refs.$hsl_a.val(this.$store.alpha);
											},
										},
										{
											key: "setHexInput",
											value: function () {
												this.refs.$hexCode.val(this.$store.dispatch("/toHEX"));
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setCurrentFormat(this.$store.format),
													this.setRGBInput(),
													this.setHSLInput(),
													this.setHexInput();
											},
										},
									]),
									e
								);
							})(mn),
							Sn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class="color-chooser">\n                <div class="color-chooser-container">\n                    <div class="colorsets-item colorsets-item-header">\n                        <h1 class="title">Color Palettes</h1>\n                        <span ref="$toggleButton" class="items">&times;</span>\n                    </div>\n                    <div ref="$colorsetsList" class="colorsets-list"></div>\n                </div>\n            </div>\n        ';
											},
										},
										{
											key: "refresh",
											value: function () {
												this.load();
											},
										},
										{
											key: "@changeCurrentColorSets",
											value: function () {
												this.refresh();
											},
										},
										{
											key: "@toggleColorChooser",
											value: function () {
												this.toggle();
											},
										},
										{
											key: "load $colorsetsList",
											value: function () {
												return (
													"\n            <div>\n                " +
													this.$store
														.dispatch("/getColorSetsList")
														.map(function (t, e) {
															return (
																'\n                        <div class="colorsets-item" data-colorsets-index="' +
																e +
																'" >\n                            <h1 class="title">' +
																t.name +
																'</h1>\n                            <div class="items">\n                                <div>\n                                    ' +
																t.colors
																	.filter(function (t, e) {
																		return e < 5;
																	})
																	.map(function (t) {
																		return (
																			'<div class="color-item" title="' +
																			(t = t || "rgba(255, 255, 255, 1)") +
																			'">\n                                                <div class="color-view" style="background-color: ' +
																			t +
																			'"></div>\n                                            </div>'
																		);
																	})
																	.join("") +
																"\n                                </div>\n                            </div>\n                        </div>"
															);
														})
														.join("") +
													"\n            </div>\n        "
												);
											},
										},
										{
											key: "show",
											value: function () {
												this.$el.addClass("open");
											},
										},
										{
											key: "hide",
											value: function () {
												this.$el.removeClass("open");
											},
										},
										{
											key: "toggle",
											value: function () {
												this.$el.toggleClass("open");
											},
										},
										{
											key: "click $toggleButton",
											value: function (t) {
												this.toggle();
											},
										},
										{
											key: "click $colorsetsList .colorsets-item",
											value: function (t) {
												var e = t.$delegateTarget;
												if (e) {
													var n = parseInt(e.attr("data-colorsets-index"));
													this.$store.dispatch("/setCurrentColorSets", n),
														this.hide();
												}
											},
										},
										{
											key: "destroy",
											value: function () {
												b(
													e.prototype.__proto__ ||
														Object.getPrototypeOf(e.prototype),
													"destroy",
													this
												).call(this),
													this.hide();
											},
										},
									]),
									e
								);
							})(mn),
							An = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class="colorsets">\n                <div class="menu" title="Open Color Palettes">\n                    <button ref="$colorSetsChooseButton" type="button" class="color-sets-choose-btn arrow-button"></button>\n                </div>\n                <div ref="$colorSetsColorList" class="color-list"></div>\n            </div>\n        ';
											},
										},
										{
											key: "load $colorSetsColorList",
											value: function () {
												var t = this.$store.dispatch("/getCurrentColorSets");
												return (
													'\n            <div class="current-color-sets">\n            ' +
													this.$store
														.dispatch("/getCurrentColors")
														.map(function (t, e) {
															return (
																'<div class="color-item" title="' +
																t +
																'" data-index="' +
																e +
																'" data-color="' +
																t +
																'">\n                    <div class="empty"></div>\n                    <div class="color-view" style="background-color: ' +
																t +
																'"></div>\n                </div>'
															);
														})
														.join("") +
													"   \n            " +
													(t.edit
														? '<div class="add-color-item">+</div>'
														: "") +
													"         \n            </div>\n        "
												);
											},
										},
										{
											key: "refresh",
											value: function () {
												this.load();
											},
										},
										{
											key: "addColor",
											value: function (t) {
												this.$store.dispatch("/addCurrentColor", t);
											},
										},
										{
											key: "@changeCurrentColorSets",
											value: function () {
												this.refresh();
											},
										},
										{
											key: "click $colorSetsChooseButton",
											value: function (t) {
												this.$store.emit("toggleColorChooser");
											},
										},
										{
											key: "contextmenu $colorSetsColorList",
											value: function (t) {
												if (
													(t.preventDefault(),
													this.$store.dispatch("/getCurrentColorSets").edit)
												) {
													var e = new sn(t.target).closest("color-item");
													if (e) {
														var n = parseInt(e.attr("data-index"));
														this.$store.emit("showContextMenu", t, n);
													} else this.$store.emit("showContextMenu", t);
												}
											},
										},
										{
											key: "click $colorSetsColorList .add-color-item",
											value: function (t) {
												this.addColor(this.$store.dispatch("/toColor"));
											},
										},
										{
											key: "click $colorSetsColorList .color-item",
											value: function (t) {
												this.$store.dispatch(
													"/changeColor",
													t.$delegateTarget.attr("data-color")
												),
													this.$store.emit("lastUpdateColor");
											},
										},
									]),
									e
								);
							})(mn),
							Ln = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <ul class="colorsets-contextmenu">\n                <li class="menu-item small-hide" data-type="remove-color">Remove color</li>\n                <li class="menu-item small-hide" data-type="remove-all-to-the-right">Remove all to the right</li>\n                <li class="menu-item" data-type="clear-palette">Clear palette</li>\n            </ul>\n        ';
											},
										},
										{
											key: "show",
											value: function (t, e) {
												var n = cn.pos(t);
												this.$el.css({
													top: n.clientY - 10 + "px",
													left: n.clientX + "px",
												}),
													this.$el.addClass("show"),
													(this.selectedColorIndex = e),
													void 0 === this.selectedColorIndex
														? this.$el.addClass("small")
														: this.$el.removeClass("small");
											},
										},
										{
											key: "hide",
											value: function () {
												this.$el.removeClass("show");
											},
										},
										{
											key: "runCommand",
											value: function (t) {
												switch (t) {
													case "remove-color":
														this.$store.dispatch(
															"/removeCurrentColor",
															this.selectedColorIndex
														);
														break;
													case "remove-all-to-the-right":
														this.$store.dispatch(
															"/removeCurrentColorToTheRight",
															this.selectedColorIndex
														);
														break;
													case "clear-palette":
														this.$store.dispatch("/clearPalette");
												}
											},
										},
										{
											key: "@showContextMenu",
											value: function (t, e) {
												this.show(t, e);
											},
										},
										{
											key: "click $el .menu-item",
											value: function (t) {
												t.preventDefault(),
													this.runCommand(t.$delegateTarget.attr("data-type")),
													this.hide();
											},
										},
									]),
									e
								);
							})(mn),
							On = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class=\'colorpicker-body\'>\n                <div target="colorwheel"></div>\n                <div target="control"></div>\n                <div target="information"></div>\n                <div target="currentColorSets"></div>\n                <div target="colorSetsChooser"></div>\n                <div target="contextMenu"></div>                \n            </div>\n        ';
											},
										},
										{
											key: "components",
											value: function () {
												return {
													colorwheel: Cn,
													control: Tn,
													information: En,
													currentColorSets: An,
													colorSetsChooser: Sn,
													contextMenu: Ln,
												};
											},
										},
									]),
									e
								);
							})(yn),
							Nn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.minValue = 0),
										(n.maxValue = 360),
										(n.source = "hue-control"),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class="hue">\n                <div ref="$container" class="hue-container">\n                    <div ref="$bar" class="drag-bar"></div>\n                </div>\n            </div>\n        ';
											},
										},
										{
											key: "getDefaultValue",
											value: function () {
												return this.$store.hsv.h;
											},
										},
										{
											key: "refreshColorUI",
											value: function (t) {
												var e = this.getCaculatedDist(t);
												this.setColorUI((e / 100) * this.maxValue),
													this.changeColor({
														h: (e / 100) * this.maxValue,
														type: "hsv",
													});
											},
										},
									]),
									e
								);
							})(xn),
							In = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "components",
											value: function () {
												return { Hue: Nn, Opacity: bn };
											},
										},
										{
											key: "template",
											value: function () {
												return '\n        <div class="control">\n            <div target="Hue" ></div>\n            <div target="Opacity" ></div>\n            <div ref="$controlPattern" class="empty"></div>\n            <div ref="$controlColor" class="color"></div>\n        </div>\n        ';
											},
										},
										{
											key: "setBackgroundColor",
											value: function () {
												this.refs.$controlColor.css(
													"background-color",
													this.$store.dispatch("/toRGB")
												);
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI(), this.setBackgroundColor();
											},
										},
										{
											key: "setColorUI",
											value: function () {
												this.Hue.setColorUI(), this.Opacity.setColorUI();
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												"chromedevtool-control" != t && this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
									]),
									e
								);
							})(mn),
							Mn = "chromedevtool-palette",
							$n = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n        <div class="color">\n            <div ref="$saturation" class="saturation">\n                <div ref="$value" class="value">\n                    <div ref="$drag_pointer" class="drag-pointer"></div>\n                </div>\n            </div>        \n        </div>        \n        ';
											},
										},
										{
											key: "setBackgroundColor",
											value: function (t) {
												this.$el.css("background-color", t);
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI();
											},
										},
										{
											key: "caculateSV",
											value: function () {
												var t = this.drag_pointer_pos || { x: 0, y: 0 },
													e = this.state.get("$el.width"),
													n = this.state.get("$el.height"),
													i = t.x / e,
													r = (n - t.y) / n;
												this.$store.dispatch("/changeColor", {
													type: "hsv",
													s: i,
													v: r,
													source: Mn,
												});
											},
										},
										{
											key: "setColorUI",
											value: function () {
												var t = this.state.get("$el.width") * this.$store.hsv.s,
													e =
														this.state.get("$el.height") *
														(1 - this.$store.hsv.v);
												this.refs.$drag_pointer.css({
													left: t + "px",
													top: e + "px",
												}),
													(this.drag_pointer_pos = { x: t, y: e }),
													this.setBackgroundColor(
														this.$store.dispatch("/getHueColor")
													);
											},
										},
										{
											key: "setMainColor",
											value: function (t) {
												var e = this.$el.offset(),
													n = this.state.get("$el.contentWidth"),
													i = this.state.get("$el.contentHeight"),
													r = cn.pos(t).pageX - e.left,
													o = cn.pos(t).pageY - e.top;
												r < 0 ? (r = 0) : r > n && (r = n),
													o < 0 ? (o = 0) : o > i && (o = i),
													this.refs.$drag_pointer.css({
														left: r + "px",
														top: o + "px",
													}),
													(this.drag_pointer_pos = { x: r, y: o }),
													this.caculateSV();
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												Mn != t && this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
										{
											key: "mouseup document",
											value: function (t) {
												this.isDown &&
													((this.isDown = !1),
													this.$store.emit("lastUpdateColor"));
											},
										},
										{
											key: "mousemove document",
											value: function (t) {
												this.isDown && this.setMainColor(t);
											},
										},
										{
											key: "mousedown",
											value: function (t) {
												(this.isDown = !0), this.setMainColor(t);
											},
										},
										{
											key: "touchend document",
											value: function (t) {
												this.isDown &&
													((this.isDown = !1),
													this.$store.emit("lastUpdateColor"));
											},
										},
										{
											key: "touchmove document",
											value: function (t) {
												this.isDown && this.setMainColor(t);
											},
										},
										{
											key: "touchstart",
											value: function (t) {
												t.preventDefault(),
													(this.isDown = !0),
													this.setMainColor(t);
											},
										},
									]),
									e
								);
							})(mn),
							Rn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class=\'colorpicker-body\'>\n                <div target="palette"></div> \n                <div target="control"></div>\n                <div target="information"></div>\n                <div target="currentColorSets"></div>\n                <div target="colorSetsChooser"></div>\n                <div target="contextMenu"></div>\n            </div>\n        ';
											},
										},
										{
											key: "components",
											value: function () {
												return {
													palette: $n,
													control: In,
													information: En,
													currentColorSets: An,
													colorSetsChooser: Sn,
													contextMenu: Ln,
												};
											},
										},
									]),
									e
								);
							})(yn),
							Dn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "components",
											value: function () {
												return { Hue: Nn, Opacity: bn };
											},
										},
										{
											key: "template",
											value: function () {
												return '\n        <div class="control">\n            <div target="Hue" ></div>\n            <div target="Opacity" ></div>\n        </div>\n        ';
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI();
											},
										},
										{
											key: "setColorUI",
											value: function () {
												this.Hue.setColorUI(), this.Opacity.setColorUI();
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												"mini-control" != t && this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
									]),
									e
								);
							})(mn),
							Pn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class=\'colorpicker-body\'>\n                <div target="palette"></div>\n                <div target="control"></div>\n            </div>\n        ';
											},
										},
										{
											key: "components",
											value: function () {
												return { palette: $n, control: Dn };
											},
										},
									]),
									e
								);
							})(yn),
							Fn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (n.source = "vertical-slider"), n;
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "getMaxDist",
											value: function () {
												return this.state.get("$container.height");
											},
										},
										{
											key: "setMousePosition",
											value: function (t) {
												this.refs.$bar.css({ top: t + "px" });
											},
										},
										{
											key: "getMousePosition",
											value: function (t) {
												return cn.pos(t).pageY;
											},
										},
										{
											key: "getMinPosition",
											value: function () {
												return this.refs.$container.offset().top;
											},
										},
										{
											key: "getCaculatedDist",
											value: function (t) {
												var e = t
													? this.getMousePosition(t)
													: this.getCurrent(
															this.getDefaultValue() / this.maxValue
													  );
												return 100 - this.getDist(e);
											},
										},
										{
											key: "setColorUI",
											value: function (t) {
												(t = t || this.getDefaultValue()) <= this.minValue
													? this.refs.$bar.addClass("first").removeClass("last")
													: t >= this.maxValue
													? this.refs.$bar.addClass("last").removeClass("first")
													: this.refs.$bar
															.removeClass("last")
															.removeClass("first");
												var e = 1 - (t || 0) / this.maxValue;
												this.setMousePosition(this.getMaxDist() * e);
											},
										},
									]),
									e
								);
							})(xn),
							Bn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.minValue = 0),
										(n.maxValue = 360),
										(n.source = "vertical-hue-control"),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class="hue">\n                <div ref="$container" class="hue-container">\n                    <div ref="$bar" class="drag-bar"></div>\n                </div>\n            </div>\n        ';
											},
										},
										{
											key: "getDefaultValue",
											value: function () {
												return this.$store.hsv.h;
											},
										},
										{
											key: "refreshColorUI",
											value: function (t) {
												var e = this.getCaculatedDist(t);
												this.setColorUI((e / 100) * this.maxValue),
													this.changeColor({
														h: (e / 100) * this.maxValue,
														type: "hsv",
													});
											},
										},
									]),
									e
								);
							})(Fn),
							Un = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (n.source = "vertical-opacity-control"), n;
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n        <div class="opacity">\n            <div ref="$container" class="opacity-container">\n                <div ref="$colorbar" class="color-bar"></div>\n                <div ref="$bar" class="drag-bar2"></div>\n            </div>\n        </div>\n        ';
											},
										},
										{
											key: "refresh",
											value: function () {
												b(
													e.prototype.__proto__ ||
														Object.getPrototypeOf(e.prototype),
													"refresh",
													this
												).call(this),
													this.setOpacityColorBar();
											},
										},
										{
											key: "setOpacityColorBar",
											value: function () {
												var t = Object.assign({}, this.$store.rgb);
												t.a = 0;
												var e = Ze.format(t, "rgb");
												t.a = 1;
												var n = Ze.format(t, "rgb");
												this.refs.$colorbar.css(
													"background",
													"linear-gradient(to top, " + e + ", " + n + ")"
												);
											},
										},
										{
											key: "getDefaultValue",
											value: function () {
												return this.$store.alpha;
											},
										},
										{
											key: "refreshColorUI",
											value: function (t) {
												var e = this.getCaculatedDist(t);
												this.setColorUI((e / 100) * this.maxValue),
													this.changeColor({
														a: (Math.floor(e) / 100) * this.maxValue,
													});
											},
										},
									]),
									e
								);
							})(Fn),
							Hn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "components",
											value: function () {
												return { Hue: Bn, Opacity: Un };
											},
										},
										{
											key: "template",
											value: function () {
												return '<div class="control"><div target="Hue" ></div><div target="Opacity" ></div></div>';
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI();
											},
										},
										{
											key: "setColorUI",
											value: function () {
												this.Hue.setColorUI(), this.Opacity.setColorUI();
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												"mini-control" != t && this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
									]),
									e
								);
							})(mn),
							zn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class=\'colorpicker-body\'>\n                <div target="palette"></div><div target="control"></div>\n            </div>\n        ';
											},
										},
										{
											key: "components",
											value: function () {
												return { palette: $n, control: Hn };
											},
										},
									]),
									e
								);
							})(yn),
							Wn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "components",
											value: function () {
												return { Value: kn, Opacity: bn };
											},
										},
										{
											key: "template",
											value: function () {
												return '\n        <div class="control">\n            <div target="Value" ></div>\n            <div target="Opacity" ></div>\n            <div ref="$controlPattern" class="empty"></div>\n            <div ref="$controlColor" class="color"></div>\n        </div>\n        ';
											},
										},
										{
											key: "setBackgroundColor",
											value: function () {
												this.refs.$controlColor.css(
													"background-color",
													this.$store.dispatch("/toRGB")
												);
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI(), this.setBackgroundColor();
											},
										},
										{
											key: "setColorUI",
											value: function () {
												this.Value.setColorUI(), this.Opacity.setColorUI();
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												"macos-control" != t && this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
									]),
									e
								);
							})(mn),
							jn = (function (t) {
								function e(t) {
									_(this, e);
									var n = C(
										this,
										(e.__proto__ || Object.getPrototypeOf(e)).call(this, t)
									);
									return (
										(n.width = 214),
										(n.height = 214),
										(n.thinkness = 16),
										(n.half_thinkness = n.thinkness / 2),
										(n.source = "colorring"),
										n
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n        <div class="wheel" data-type="ring">\n            <canvas class="wheel-canvas" ref="$colorwheel" ></canvas>\n            <div class="drag-pointer" ref="$drag_pointer"></div>\n        </div>\n        ';
											},
										},
										{
											key: "setColorUI",
											value: function (t) {
												this.renderCanvas(), this.setHueColor(null, t);
											},
										},
										{
											key: "getDefaultValue",
											value: function () {
												return this.$store.hsv.h;
											},
										},
										{
											key: "setHueColor",
											value: function (t, e) {
												if (this.state.get("$el.width")) {
													var n = this.getRectangle(),
														i = n.minX,
														r = n.minY,
														o = n.radius,
														s = n.centerX,
														a = n.centerY,
														l = this.getCurrentXY(
															t,
															this.getDefaultValue(),
															o,
															s,
															a
														),
														c = u((f = l.x) - s, (d = l.y) - a),
														h = this.getCurrentXY(
															null,
															c,
															o - this.half_thinkness,
															s,
															a
														),
														f = h.x,
														d = h.y;
													this.refs.$drag_pointer.css({
														left: f - i + "px",
														top: d - r + "px",
													}),
														e || this.changeColor({ type: "hsv", h: c });
												}
											},
										},
									]),
									e
								);
							})(Cn),
							Gn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class=\'colorpicker-body\'>\n                <div target="colorring"></div>\n                <div target="palette"></div> \n                <div target="control"></div>\n                <div target="information"></div>\n                <div target="currentColorSets"></div>\n                <div target="colorSetsChooser"></div>\n                <div target="contextMenu"></div>\n            </div>\n        ';
											},
										},
										{
											key: "components",
											value: function () {
												return {
													colorring: jn,
													palette: $n,
													control: Wn,
													information: En,
													currentColorSets: An,
													colorSetsChooser: Sn,
													contextMenu: Ln,
												};
											},
										},
									]),
									e
								);
							})(yn),
							qn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "components",
											value: function () {
												return { Hue: Bn, Opacity: Un };
											},
										},
										{
											key: "template",
											value: function () {
												return '\n        <div class="control">\n            <div target="Hue" ></div>\n            <div target="Opacity" ></div>\n        </div>\n        ';
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI();
											},
										},
										{
											key: "setColorUI",
											value: function () {
												this.Hue.setColorUI(), this.Opacity.setColorUI();
											},
										},
										{
											key: "@changeColor",
											value: function () {
												this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
									]),
									e
								);
							})(mn),
							Vn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return '\n            <div class=\'colorpicker-body\'>\n                <div target="palette"></div> \n                <div target="control"></div>\n                <div target="information"></div>\n                <div target="currentColorSets"></div>\n                <div target="colorSetsChooser"></div>\n                <div target="contextMenu"></div>\n            </div>\n        ';
											},
										},
										{
											key: "components",
											value: function () {
												return {
													palette: $n,
													control: qn,
													information: En,
													currentColorSets: An,
													colorSetsChooser: Sn,
													contextMenu: Ln,
												};
											},
										},
									]),
									e
								);
							})(yn),
							Yn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "components",
											value: function () {
												return { Hue: Bn, Opacity: Un };
											},
										},
										{
											key: "template",
											value: function () {
												return '\n            <div class="control">\n                <div target="Opacity" ></div>            \n                <div target="Hue" ></div>\n            </div>\n        ';
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setColorUI();
											},
										},
										{
											key: "setColorUI",
											value: function () {
												this.Hue.setColorUI(), this.Opacity.setColorUI();
											},
										},
										{
											key: "@changeColor",
											value: function (t) {
												"mini-control" != t && this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
									]),
									e
								);
							})(mn),
							Kn = (function (t) {
								function e() {
									return (
										_(this, e),
										C(
											this,
											(e.__proto__ || Object.getPrototypeOf(e)).apply(
												this,
												arguments
											)
										)
									);
								}
								return (
									T(e, t),
									y(e, [
										{
											key: "template",
											value: function () {
												return "\n            <div class='colorpicker-body'>\n                <div class='color-view'>\n                    <div class='color-view-container'  ref=\"$colorview\"></div>\n                </div>\n                <div class='color-tool'>\n                    <div target=\"palette\"></div>\n                    <div target=\"control\"></div>\n                </div>\n            </div>\n        ";
											},
										},
										{
											key: "components",
											value: function () {
												return { palette: $n, control: Yn };
											},
										},
										{
											key: "initColorWithoutChangeEvent",
											value: function (t) {
												this.$store.dispatch("/initColor", t), this.refresh();
											},
										},
										{
											key: "setBackgroundColor",
											value: function () {
												var t = this.$store.dispatch("/toColor"),
													e = this.$store.rgb,
													n = Ze.brightness(e.r, e.g, e.b);
												this.refs.$colorview.css({
													"background-color": t,
													color: n > 127 ? "black" : "white",
												}),
													this.refs.$colorview.html(t);
											},
										},
										{
											key: "click $colorview",
											value: function (t) {
												this.nextFormat();
											},
										},
										{
											key: "nextFormat",
											value: function () {
												var t = this.$store.format || "hex",
													e = "hex";
												"hex" == t
													? (e = "rgb")
													: "rgb" == t
													? (e = "hsl")
													: "hsl" == t && (e = "hex"),
													this.$store.dispatch("/changeFormat", e),
													this.$store.emit("lastUpdateColor"),
													this.refresh();
											},
										},
										{
											key: "refresh",
											value: function () {
												this.setBackgroundColor();
											},
										},
										{
											key: "@changeColor",
											value: function () {
												this.refresh();
											},
										},
										{
											key: "@initColor",
											value: function () {
												this.refresh();
											},
										},
									]),
									e
								);
							})(yn),
							Xn = {
								create: function (t) {
									switch (t.type) {
										case "macos":
											return new On(t);
										case "xd":
											return new Vn(t);
										case "ring":
											return new Gn(t);
										case "mini":
											return new Pn(t);
										case "vscode":
											return new Kn(t);
										case "mini-vertical":
											return new zn(t);
										case "sketch":
										case "palette":
										default:
											return new Rn(t);
									}
								},
								ColorPicker: Rn,
								ChromeDevToolColorPicker: Rn,
								MacOSColorPicker: On,
								RingColorPicker: Gn,
								MiniColorPicker: Pn,
								VSCodePicker: Kn,
								MiniVerticalColorPicker: zn,
							},
							Qn = "codemirror-colorview",
							Zn = "codemirror-colorview-background",
							Jn = ["comment", "builtin", "qualifier"];
						function ti(t, e) {
							"setValue" == e.origin
								? (t.state.colorpicker.init_color_update(),
								  t.state.colorpicker.style_color_update())
								: t.state.colorpicker.style_color_update(t.getCursor().line);
						}
						function ei(t, e) {
							t.state.colorpicker.isUpdate ||
								((t.state.colorpicker.isUpdate = !0),
								t.state.colorpicker.close_color_picker(),
								t.state.colorpicker.init_color_update(),
								t.state.colorpicker.style_color_update());
						}
						function ni(t, e) {
							ti(t, { origin: "setValue" });
						}
						function ii(t, e) {
							t.state.colorpicker.keyup(e);
						}
						function ri(t, e) {
							t.state.colorpicker.is_edit_mode() &&
								t.state.colorpicker.check_mousedown(e);
						}
						function oi(t, e) {
							ti(t, { origin: "setValue" });
						}
						function si(t) {
							t.state.colorpicker.close_color_picker();
						}
						function ai(t) {
							t.state.colorpicker.hide_delay_color_picker(
								t.state.colorpicker.opt.hideDelay || 1e3
							);
						}
						var li = (function () {
							function t(e, n) {
								_(this, t),
									(n =
										"boolean" == typeof n
											? { mode: "edit" }
											: Object.assign({ mode: "edit" }, n || {})),
									(this.opt = n),
									(this.cm = e),
									(this.markers = {}),
									(this.excluded_token = this.opt.excluded_token || Jn),
									this.opt.colorpicker
										? (this.colorpicker = this.opt.colorpicker(this.opt))
										: (this.colorpicker = Xn.create(this.opt)),
									this.init_event();
							}
							return (
								y(t, [
									{
										key: "init_event",
										value: function () {
											var t, e;
											this.cm.on("mousedown", ri),
												this.cm.on("keyup", ii),
												this.cm.on("change", ti),
												this.cm.on("update", ei),
												this.cm.on("refresh", ni),
												this.cm.on("blur", ai),
												(this.onPasteCallback =
													((t = this.cm),
													(e = oi),
													function (n) {
														e.call(this, t, n);
													})),
												(this.onScrollEvent = (function (t, e) {
													var n = void 0;
													return function (i, r) {
														n && clearTimeout(n),
															(n = setTimeout(function () {
																t(i, r);
															}, e || 300));
													};
												})(si, 50)),
												this.cm
													.getWrapperElement()
													.addEventListener("paste", this.onPasteCallback),
												this.is_edit_mode() &&
													this.cm.on("scroll", this.onScrollEvent);
										},
									},
									{
										key: "is_edit_mode",
										value: function () {
											return "edit" == this.opt.mode;
										},
									},
									{
										key: "is_view_mode",
										value: function () {
											return "view" == this.opt.mode;
										},
									},
									{
										key: "destroy",
										value: function () {
											this.cm.off("mousedown", ri),
												this.cm.off("keyup", ii),
												this.cm.off("change", ti),
												this.cm.off("blur", ai),
												this.cm
													.getWrapperElement()
													.removeEventListener("paste", this.onPasteCallback),
												this.is_edit_mode() &&
													this.cm.off("scroll", this.onScrollEvent);
										},
									},
									{
										key: "hasClass",
										value: function (t, e) {
											return (
												!!t.className &&
												(" " + t.className + " ").indexOf(" " + e + " ") > -1
											);
										},
									},
									{
										key: "check_mousedown",
										value: function (t) {
											this.hasClass(t.target, Zn)
												? this.open_color_picker(t.target.parentNode)
												: this.close_color_picker();
										},
									},
									{
										key: "popup_color_picker",
										value: function (t) {
											var e = this.cm.getCursor(),
												n = this,
												i = {
													lineNo: e.line,
													ch: e.ch,
													color: t || "#FFFFFF",
													isShortCut: !0,
												};
											Object.keys(this.markers).forEach(function (t) {
												if (("#" + t).indexOf("#" + i.lineNo + ":") > -1) {
													var e = n.markers[t];
													e.ch <= i.ch &&
														i.ch <= e.ch + e.color.length &&
														((i.ch = e.ch),
														(i.color = e.color),
														(i.nameColor = e.nameColor));
												}
											}),
												this.open_color_picker(i);
										},
									},
									{
										key: "open_color_picker",
										value: function (t) {
											var e = this,
												n = t.lineNo,
												i = t.ch,
												r = t.nameColor,
												o = t.color;
											if (this.colorpicker) {
												var s = o,
													a = this.cm.charCoords({ line: n, ch: i });
												this.colorpicker.show(
													{
														left: a.left,
														top: a.bottom,
														isShortCut: t.isShortCut || !1,
														hideDelay: this.opt.hideDelay || 2e3,
													},
													r || o,
													function (t) {
														e.cm.replaceRange(
															t,
															{ line: n, ch: i },
															{ line: n, ch: i + s.length },
															"*colorpicker"
														),
															e.cm.focus(),
															(s = t);
													}
												);
											}
										},
									},
									{
										key: "close_color_picker",
										value: function () {
											this.colorpicker && this.colorpicker.hide();
										},
									},
									{
										key: "hide_delay_color_picker",
										value: function () {
											this.colorpicker && this.colorpicker.runHideDelay();
										},
									},
									{
										key: "key",
										value: function (t, e) {
											return [t, e].join(":");
										},
									},
									{
										key: "keyup",
										value: function (t) {
											this.colorpicker &&
												("Escape" == t.key ||
													0 == this.colorpicker.isShortCut) &&
												this.colorpicker.hide();
										},
									},
									{
										key: "init_color_update",
										value: function () {
											this.markers = {};
										},
									},
									{
										key: "style_color_update",
										value: function (t) {
											if (t) this.match(t);
											else
												for (var e = this.cm.lineCount(), n = 0; n < e; n++)
													this.match(n);
										},
									},
									{
										key: "empty_marker",
										value: function (t, e) {
											for (
												var n, i, r = e.markedSpans || [], o = 0, s = r.length;
												o < s;
												o++
											) {
												var a = this.key(t, r[o].from);
												a &&
													((n = r[o].marker.replacedWith),
													(i = Qn),
													n &&
														n.className &&
														(" " + n.className + " ").indexOf(" " + i + " ") >
															-1) &&
													(delete this.markers[a], r[o].marker.clear());
											}
										},
									},
									{
										key: "match_result",
										value: function (t) {
											return Ze.matches(t.text);
										},
									},
									{
										key: "submatch",
										value: function (t, e) {
											var n = this;
											this.empty_marker(t, e);
											var i = this.match_result(e),
												r = { next: 0 };
											i.forEach(function (i) {
												n.render(r, t, e, i.color, i.nameColor);
											});
										},
									},
									{
										key: "match",
										value: function (t) {
											var e = this.cm.getLineHandle(t),
												n = this;
											this.cm.operation(function () {
												n.submatch(t, e);
											});
										},
									},
									{
										key: "make_element",
										value: function () {
											var t = document.createElement("div");
											return (
												(t.className = Qn),
												this.is_edit_mode()
													? (t.title = "open color picker")
													: (t.title = ""),
												(t.back_element = this.make_background_element()),
												t.appendChild(t.back_element),
												t
											);
										},
									},
									{
										key: "make_background_element",
										value: function () {
											var t = document.createElement("div");
											return (t.className = Zn), t;
										},
									},
									{
										key: "set_state",
										value: function (t, e, n, i) {
											var r = this.create_marker(t, e);
											return (
												(r.lineNo = t),
												(r.ch = e),
												(r.color = n),
												(r.nameColor = i),
												r
											);
										},
									},
									{
										key: "create_marker",
										value: function (t, e) {
											return (
												this.has_marker(t, e) || this.init_marker(t, e),
												this.get_marker(t, e)
											);
										},
									},
									{
										key: "init_marker",
										value: function (t, e) {
											this.markers[this.key(t, e)] = this.make_element();
										},
									},
									{
										key: "has_marker",
										value: function (t, e) {
											return !!this.get_marker(t, e);
										},
									},
									{
										key: "get_marker",
										value: function (t, e) {
											var n = this.key(t, e);
											return this.markers[n];
										},
									},
									{
										key: "update_element",
										value: function (t, e) {
											t.back_element.style.backgroundColor = e;
										},
									},
									{
										key: "set_mark",
										value: function (t, e, n) {
											this.cm.setBookmark(
												{ line: t, ch: e },
												{ widget: n, handleMouseEvents: !0 }
											);
										},
									},
									{
										key: "is_excluded_token",
										value: function (t, e) {
											var n = this.cm.getTokenAt({ line: t, ch: e }, !0),
												i = n.type,
												r = n.state.state;
											if (null == i && "block" == r) return !0;
											if (null == i && "top" == r) return !0;
											for (
												var o = 0, s = 0, a = this.excluded_token.length;
												s < a;
												s++
											)
												if (i === this.excluded_token[s]) {
													o++;
													break;
												}
											return o > 0;
										},
									},
									{
										key: "render",
										value: function (t, e, n, i, r) {
											var o = n.text.indexOf(i, t.next);
											if (!0 !== this.is_excluded_token(e, o)) {
												if (((t.next = o + i.length), this.has_marker(e, o)))
													return (
														this.update_element(
															this.create_marker(e, o),
															r || i
														),
														void this.set_state(e, o, i, r)
													);
												var s = this.create_marker(e, o);
												this.update_element(s, r || i),
													this.set_state(e, o, i, r || i),
													this.set_mark(e, o, s);
											}
										},
									},
								]),
								t
							);
						})();
						try {
							var ci = t("codemirror");
						} catch (t) {}
						function hi() {
							var t = ci || window.CodeMirror;
							t &&
								t.defineOption("colorpicker", !1, function (e, n, i) {
									i &&
										i != t.Init &&
										e.state.colorpicker &&
										(e.state.colorpicker.destroy(),
										(e.state.colorpicker = null)),
										n && (e.state.colorpicker = new li(e, n));
								});
						}
						return hi(), k({}, nn, Xn, { load: hi });
					}),
					"object" == typeof n && void 0 !== e
						? (e.exports = r())
						: "function" == typeof define && define.amd
						? define(r)
						: (i["codemirror-colorpicker"] = r());
			},
			{ codemirror: 13 },
		],
		4: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					function e(e, n, i) {
						var r,
							o = e.getWrapperElement();
						return (
							((r = o.appendChild(document.createElement("div"))).className = i
								? "CodeMirror-dialog CodeMirror-dialog-bottom"
								: "CodeMirror-dialog CodeMirror-dialog-top"),
							"string" == typeof n ? (r.innerHTML = n) : r.appendChild(n),
							t.addClass(o, "dialog-opened"),
							r
						);
					}
					function n(t, e) {
						t.state.currentNotificationClose &&
							t.state.currentNotificationClose(),
							(t.state.currentNotificationClose = e);
					}
					t.defineExtension("openDialog", function (i, r, o) {
						o || (o = {}), n(this, null);
						var s = e(this, i, o.bottom),
							a = !1,
							l = this;
						function c(e) {
							if ("string" == typeof e) u.value = e;
							else {
								if (a) return;
								(a = !0),
									t.rmClass(s.parentNode, "dialog-opened"),
									s.parentNode.removeChild(s),
									l.focus(),
									o.onClose && o.onClose(s);
							}
						}
						var h,
							u = s.getElementsByTagName("input")[0];
						return (
							u
								? (u.focus(),
								  o.value &&
										((u.value = o.value),
										!1 !== o.selectValueOnOpen && u.select()),
								  o.onInput &&
										t.on(u, "input", function (t) {
											o.onInput(t, u.value, c);
										}),
								  o.onKeyUp &&
										t.on(u, "keyup", function (t) {
											o.onKeyUp(t, u.value, c);
										}),
								  t.on(u, "keydown", function (e) {
										(o && o.onKeyDown && o.onKeyDown(e, u.value, c)) ||
											((27 == e.keyCode ||
												(!1 !== o.closeOnEnter && 13 == e.keyCode)) &&
												(u.blur(), t.e_stop(e), c()),
											13 == e.keyCode && r(u.value, e));
								  }),
								  !1 !== o.closeOnBlur &&
										t.on(s, "focusout", function (t) {
											null !== t.relatedTarget && c();
										}))
								: (h = s.getElementsByTagName("button")[0]) &&
								  (t.on(h, "click", function () {
										c(), l.focus();
								  }),
								  !1 !== o.closeOnBlur && t.on(h, "blur", c),
								  h.focus()),
							c
						);
					}),
						t.defineExtension("openConfirm", function (i, r, o) {
							n(this, null);
							var s = e(this, i, o && o.bottom),
								a = s.getElementsByTagName("button"),
								l = !1,
								c = this,
								h = 1;
							function u() {
								l ||
									((l = !0),
									t.rmClass(s.parentNode, "dialog-opened"),
									s.parentNode.removeChild(s),
									c.focus());
							}
							a[0].focus();
							for (var f = 0; f < a.length; ++f) {
								var d = a[f];
								!(function (e) {
									t.on(d, "click", function (n) {
										t.e_preventDefault(n), u(), e && e(c);
									});
								})(r[f]),
									t.on(d, "blur", function () {
										--h,
											setTimeout(function () {
												h <= 0 && u();
											}, 200);
									}),
									t.on(d, "focus", function () {
										++h;
									});
							}
						}),
						t.defineExtension("openNotification", function (i, r) {
							n(this, c);
							var o,
								s = e(this, i, r && r.bottom),
								a = !1,
								l = r && void 0 !== r.duration ? r.duration : 5e3;
							function c() {
								a ||
									((a = !0),
									clearTimeout(o),
									t.rmClass(s.parentNode, "dialog-opened"),
									s.parentNode.removeChild(s));
							}
							return (
								t.on(s, "click", function (e) {
									t.e_preventDefault(e), c();
								}),
								l && (o = setTimeout(c, l)),
								c
							);
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		5: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					var e = {
							pairs: "()[]{}''\"\"",
							closeBefore: ")]}'\":;>",
							triples: "",
							explode: "[]{}",
						},
						n = t.Pos;
					function i(t, n) {
						return "pairs" == n && "string" == typeof t
							? t
							: "object" == typeof t && null != t[n]
							? t[n]
							: e[n];
					}
					t.defineOption("autoCloseBrackets", !1, function (e, n, s) {
						s &&
							s != t.Init &&
							(e.removeKeyMap(r), (e.state.closeBrackets = null)),
							n &&
								(o(i(n, "pairs")), (e.state.closeBrackets = n), e.addKeyMap(r));
					});
					var r = {
						Backspace: function (e) {
							var r = a(e);
							if (!r || e.getOption("disableInput")) return t.Pass;
							for (
								var o = i(r, "pairs"), s = e.listSelections(), l = 0;
								l < s.length;
								l++
							) {
								if (!s[l].empty()) return t.Pass;
								var c = h(e, s[l].head);
								if (!c || o.indexOf(c) % 2 != 0) return t.Pass;
							}
							for (l = s.length - 1; l >= 0; l--) {
								var u = s[l].head;
								e.replaceRange(
									"",
									n(u.line, u.ch - 1),
									n(u.line, u.ch + 1),
									"+delete"
								);
							}
						},
						Enter: function (e) {
							var n = a(e),
								r = n && i(n, "explode");
							if (!r || e.getOption("disableInput")) return t.Pass;
							for (var o = e.listSelections(), s = 0; s < o.length; s++) {
								if (!o[s].empty()) return t.Pass;
								var c = h(e, o[s].head);
								if (!c || r.indexOf(c) % 2 != 0) return t.Pass;
							}
							e.operation(function () {
								var t = e.lineSeparator() || "\n";
								e.replaceSelection(t + t, null),
									l(e, -1),
									(o = e.listSelections());
								for (var n = 0; n < o.length; n++) {
									var i = o[n].head.line;
									e.indentLine(i, null, !0), e.indentLine(i + 1, null, !0);
								}
							});
						},
					};
					function o(t) {
						for (var e = 0; e < t.length; e++) {
							var n = t.charAt(e),
								i = "'" + n + "'";
							r[i] || (r[i] = s(n));
						}
					}
					function s(e) {
						return function (r) {
							return (function (e, r) {
								var o = a(e);
								if (!o || e.getOption("disableInput")) return t.Pass;
								var s = i(o, "pairs"),
									h = s.indexOf(r);
								if (-1 == h) return t.Pass;
								for (
									var f,
										d = i(o, "closeBefore"),
										p = i(o, "triples"),
										g = s.charAt(h + 1) == r,
										m = e.listSelections(),
										v = h % 2 == 0,
										_ = 0;
									_ < m.length;
									_++
								) {
									var y,
										x = m[_],
										k = x.head,
										b = e.getRange(k, n(k.line, k.ch + 1));
									if (v && !x.empty()) y = "surround";
									else if ((!g && v) || b != r)
										if (
											g &&
											k.ch > 1 &&
											p.indexOf(r) >= 0 &&
											e.getRange(n(k.line, k.ch - 2), k) == r + r
										) {
											if (
												k.ch > 2 &&
												/\bstring/.test(e.getTokenTypeAt(n(k.line, k.ch - 2)))
											)
												return t.Pass;
											y = "addFour";
										} else if (g) {
											var T =
												0 == k.ch ? " " : e.getRange(n(k.line, k.ch - 1), k);
											if (t.isWordChar(b) || T == r || t.isWordChar(T))
												return t.Pass;
											y = "both";
										} else {
											if (
												!v ||
												!(0 === b.length || /\s/.test(b) || d.indexOf(b) > -1)
											)
												return t.Pass;
											y = "both";
										}
									else
										y =
											g && u(e, k)
												? "both"
												: p.indexOf(r) >= 0 &&
												  e.getRange(k, n(k.line, k.ch + 3)) == r + r + r
												? "skipThree"
												: "skip";
									if (f) {
										if (f != y) return t.Pass;
									} else f = y;
								}
								var C = h % 2 ? s.charAt(h - 1) : r,
									w = h % 2 ? r : s.charAt(h + 1);
								e.operation(function () {
									if ("skip" == f) l(e, 1);
									else if ("skipThree" == f) l(e, 3);
									else if ("surround" == f) {
										for (var t = e.getSelections(), n = 0; n < t.length; n++)
											t[n] = C + t[n] + w;
										for (
											e.replaceSelections(t, "around"),
												t = e.listSelections().slice(),
												n = 0;
											n < t.length;
											n++
										)
											t[n] = c(t[n]);
										e.setSelections(t);
									} else
										"both" == f
											? (e.replaceSelection(C + w, null),
											  e.triggerElectric(C + w),
											  l(e, -1))
											: "addFour" == f &&
											  (e.replaceSelection(C + C + C + C, "before"), l(e, 1));
								});
							})(r, e);
						};
					}
					function a(t) {
						var e = t.state.closeBrackets;
						return !e || e.override
							? e
							: t.getModeAt(t.getCursor()).closeBrackets || e;
					}
					function l(t, e) {
						for (
							var n = [], i = t.listSelections(), r = 0, o = 0;
							o < i.length;
							o++
						) {
							var s = i[o];
							s.head == t.getCursor() && (r = o);
							var a =
								s.head.ch || e > 0
									? { line: s.head.line, ch: s.head.ch + e }
									: { line: s.head.line - 1 };
							n.push({ anchor: a, head: a });
						}
						t.setSelections(n, r);
					}
					function c(e) {
						var i = t.cmpPos(e.anchor, e.head) > 0;
						return {
							anchor: new n(e.anchor.line, e.anchor.ch + (i ? -1 : 1)),
							head: new n(e.head.line, e.head.ch + (i ? 1 : -1)),
						};
					}
					function h(t, e) {
						var i = t.getRange(n(e.line, e.ch - 1), n(e.line, e.ch + 1));
						return 2 == i.length ? i : null;
					}
					function u(t, e) {
						var i = t.getTokenAt(n(e.line, e.ch + 1));
						return (
							/\bstring/.test(i.type) &&
							i.start == e.ch &&
							(0 == e.ch || !/\bstring/.test(t.getTokenTypeAt(e)))
						);
					}
					o(e.pairs + "`");
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		6: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					var e =
							/MSIE \d/.test(navigator.userAgent) &&
							(null == document.documentMode || document.documentMode < 8),
						n = t.Pos,
						i = {
							"(": ")>",
							")": "(<",
							"[": "]>",
							"]": "[<",
							"{": "}>",
							"}": "{<",
							"<": ">>",
							">": "<<",
						};
					function r(t) {
						return (t && t.bracketRegex) || /[(){}[\]]/;
					}
					function o(t, e, o) {
						var a = t.getLineHandle(e.line),
							l = e.ch - 1,
							c = o && o.afterCursor;
						null == c &&
							(c = /(^| )cm-fat-cursor($| )/.test(
								t.getWrapperElement().className
							));
						var h = r(o),
							u =
								(!c &&
									l >= 0 &&
									h.test(a.text.charAt(l)) &&
									i[a.text.charAt(l)]) ||
								(h.test(a.text.charAt(l + 1)) && i[a.text.charAt(++l)]);
						if (!u) return null;
						var f = ">" == u.charAt(1) ? 1 : -1;
						if (o && o.strict && f > 0 != (l == e.ch)) return null;
						var d = t.getTokenTypeAt(n(e.line, l + 1)),
							p = s(t, n(e.line, l + (f > 0 ? 1 : 0)), f, d, o);
						return null == p
							? null
							: {
									from: n(e.line, l),
									to: p && p.pos,
									match: p && p.ch == u.charAt(0),
									forward: f > 0,
							  };
					}
					function s(t, e, o, s, a) {
						for (
							var l = (a && a.maxScanLineLength) || 1e4,
								c = (a && a.maxScanLines) || 1e3,
								h = [],
								u = r(a),
								f =
									o > 0
										? Math.min(e.line + c, t.lastLine() + 1)
										: Math.max(t.firstLine() - 1, e.line - c),
								d = e.line;
							d != f;
							d += o
						) {
							var p = t.getLine(d);
							if (p) {
								var g = o > 0 ? 0 : p.length - 1,
									m = o > 0 ? p.length : -1;
								if (!(p.length > l))
									for (
										d == e.line && (g = e.ch - (o < 0 ? 1 : 0));
										g != m;
										g += o
									) {
										var v = p.charAt(g);
										if (
											u.test(v) &&
											(void 0 === s ||
												(t.getTokenTypeAt(n(d, g + 1)) || "") == (s || ""))
										) {
											var _ = i[v];
											if (_ && (">" == _.charAt(1)) == o > 0) h.push(v);
											else {
												if (!h.length) return { pos: n(d, g), ch: v };
												h.pop();
											}
										}
									}
							}
						}
						return d - o != (o > 0 ? t.lastLine() : t.firstLine()) && null;
					}
					function a(t, i, r) {
						for (
							var s = t.state.matchBrackets.maxHighlightLineLength || 1e3,
								a = r && r.highlightNonMatching,
								l = [],
								c = t.listSelections(),
								h = 0;
							h < c.length;
							h++
						) {
							var u = c[h].empty() && o(t, c[h].head, r);
							if (
								u &&
								(u.match || !1 !== a) &&
								t.getLine(u.from.line).length <= s
							) {
								var f = u.match
									? "CodeMirror-matchingbracket"
									: "CodeMirror-nonmatchingbracket";
								l.push(
									t.markText(u.from, n(u.from.line, u.from.ch + 1), {
										className: f,
									})
								),
									u.to &&
										t.getLine(u.to.line).length <= s &&
										l.push(
											t.markText(u.to, n(u.to.line, u.to.ch + 1), {
												className: f,
											})
										);
							}
						}
						if (l.length) {
							e && t.state.focused && t.focus();
							var d = function () {
								t.operation(function () {
									for (var t = 0; t < l.length; t++) l[t].clear();
								});
							};
							if (!i) return d;
							setTimeout(d, 800);
						}
					}
					function l(t) {
						t.operation(function () {
							t.state.matchBrackets.currentlyHighlighted &&
								(t.state.matchBrackets.currentlyHighlighted(),
								(t.state.matchBrackets.currentlyHighlighted = null)),
								(t.state.matchBrackets.currentlyHighlighted = a(
									t,
									!1,
									t.state.matchBrackets
								));
						});
					}
					function c(t) {
						t.state.matchBrackets &&
							t.state.matchBrackets.currentlyHighlighted &&
							(t.state.matchBrackets.currentlyHighlighted(),
							(t.state.matchBrackets.currentlyHighlighted = null));
					}
					t.defineOption("matchBrackets", !1, function (e, n, i) {
						i &&
							i != t.Init &&
							(e.off("cursorActivity", l),
							e.off("focus", l),
							e.off("blur", c),
							c(e)),
							n &&
								((e.state.matchBrackets = "object" == typeof n ? n : {}),
								e.on("cursorActivity", l),
								e.on("focus", l),
								e.on("blur", c));
					}),
						t.defineExtension("matchBrackets", function () {
							a(this, !0);
						}),
						t.defineExtension("findMatchingBracket", function (t, e, n) {
							return (
								(n || "boolean" == typeof e) &&
									(n
										? ((n.strict = e), (e = n))
										: (e = e ? { strict: !0 } : null)),
								o(this, t, e)
							);
						}),
						t.defineExtension("scanForBracket", function (t, e, n, i) {
							return s(this, t, e, n, i);
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		7: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					var e = "CodeMirror-lint-markers";
					function n(t) {
						t.parentNode && t.parentNode.removeChild(t);
					}
					function i(e, i, r, o) {
						var s = (function (e, n, i) {
							var r = document.createElement("div");
							function o(e) {
								if (!r.parentNode) return t.off(document, "mousemove", o);
								(r.style.top =
									Math.max(0, e.clientY - r.offsetHeight - 5) + "px"),
									(r.style.left = e.clientX + 5 + "px");
							}
							return (
								(r.className =
									"CodeMirror-lint-tooltip cm-s-" + e.options.theme),
								r.appendChild(i.cloneNode(!0)),
								e.state.lint.options.selfContain
									? e.getWrapperElement().appendChild(r)
									: document.body.appendChild(r),
								t.on(document, "mousemove", o),
								o(n),
								null != r.style.opacity && (r.style.opacity = 1),
								r
							);
						})(e, i, r);
						function a() {
							var e;
							t.off(o, "mouseout", a),
								s &&
									((e = s).parentNode &&
										(null == e.style.opacity && n(e),
										(e.style.opacity = 0),
										setTimeout(function () {
											n(e);
										}, 600)),
									(s = null));
						}
						var l = setInterval(function () {
							if (s)
								for (var t = o; ; t = t.parentNode) {
									if (
										(t && 11 == t.nodeType && (t = t.host), t == document.body)
									)
										return;
									if (!t) {
										a();
										break;
									}
								}
							if (!s) return clearInterval(l);
						}, 400);
						t.on(o, "mouseout", a);
					}
					function r(t, e, n) {
						for (var r in ((this.marked = []),
						e instanceof Function && (e = { getAnnotations: e }),
						(e && !0 !== e) || (e = {}),
						(this.options = {}),
						(this.linterOptions = e.options || {}),
						o))
							this.options[r] = o[r];
						for (var r in e)
							o.hasOwnProperty(r)
								? null != e[r] && (this.options[r] = e[r])
								: e.options || (this.linterOptions[r] = e[r]);
						(this.timeout = null),
							(this.hasGutter = n),
							(this.onMouseOver = function (e) {
								!(function (t, e) {
									var n = e.target || e.srcElement;
									if (/\bCodeMirror-lint-mark-/.test(n.className)) {
										for (
											var r = n.getBoundingClientRect(),
												o = (r.left + r.right) / 2,
												s = (r.top + r.bottom) / 2,
												a = t.findMarksAt(
													t.coordsChar({ left: o, top: s }, "client")
												),
												c = [],
												h = 0;
											h < a.length;
											++h
										) {
											var u = a[h].__annotation;
											u && c.push(u);
										}
										c.length &&
											(function (t, e, n) {
												for (
													var r = n.target || n.srcElement,
														o = document.createDocumentFragment(),
														s = 0;
													s < e.length;
													s++
												) {
													var a = e[s];
													o.appendChild(l(a));
												}
												i(t, n, o, r);
											})(t, c, e);
									}
								})(t, e);
							}),
							(this.waitingFor = 0);
					}
					var o = {
						highlightLines: !1,
						tooltips: !0,
						delay: 500,
						lintOnChange: !0,
						getAnnotations: null,
						async: !1,
						selfContain: null,
						formatAnnotation: null,
						onUpdateLinting: null,
					};
					function s(t) {
						var n = t.state.lint;
						n.hasGutter && t.clearGutter(e),
							n.options.highlightLines &&
								(function (t) {
									t.eachLine(function (e) {
										var n =
											e.wrapClass &&
											/\bCodeMirror-lint-line-\w+\b/.exec(e.wrapClass);
										n && t.removeLineClass(e, "wrap", n[0]);
									});
								})(t);
						for (var i = 0; i < n.marked.length; ++i) n.marked[i].clear();
						n.marked.length = 0;
					}
					function a(e, n, r, o, s) {
						var a = document.createElement("div"),
							l = a;
						return (
							(a.className =
								"CodeMirror-lint-marker CodeMirror-lint-marker-" + r),
							o &&
								((l = a.appendChild(document.createElement("div"))).className =
									"CodeMirror-lint-marker CodeMirror-lint-marker-multiple"),
							0 != s &&
								t.on(l, "mouseover", function (t) {
									i(e, t, n, l);
								}),
							a
						);
					}
					function l(t) {
						var e = t.severity;
						e || (e = "error");
						var n = document.createElement("div");
						return (
							(n.className =
								"CodeMirror-lint-message CodeMirror-lint-message-" + e),
							void 0 !== t.messageHTML
								? (n.innerHTML = t.messageHTML)
								: n.appendChild(document.createTextNode(t.message)),
							n
						);
					}
					function c(e) {
						var n = e.state.lint;
						if (n) {
							var i = n.options,
								r = i.getAnnotations || e.getHelper(t.Pos(0, 0), "lint");
							if (r)
								if (i.async || r.async)
									!(function (e, n) {
										var i = e.state.lint,
											r = ++i.waitingFor;
										function o() {
											(r = -1), e.off("change", o);
										}
										e.on("change", o),
											n(
												e.getValue(),
												function (n, s) {
													e.off("change", o),
														i.waitingFor == r &&
															(s && n instanceof t && (n = s),
															e.operation(function () {
																h(e, n);
															}));
												},
												i.linterOptions,
												e
											);
									})(e, r);
								else {
									var o = r(e.getValue(), n.linterOptions, e);
									if (!o) return;
									o.then
										? o.then(function (t) {
												e.operation(function () {
													h(e, t);
												});
										  })
										: e.operation(function () {
												h(e, o);
										  });
								}
						}
					}
					function h(t, n) {
						var i = t.state.lint;
						if (i) {
							var r = i.options;
							s(t);
							for (
								var o,
									c,
									h = (function (t) {
										for (var e = [], n = 0; n < t.length; ++n) {
											var i = t[n],
												r = i.from.line;
											(e[r] || (e[r] = [])).push(i);
										}
										return e;
									})(n),
									u = 0;
								u < h.length;
								++u
							) {
								var f = h[u];
								if (f) {
									var d = [];
									f = f.filter(function (t) {
										return !(d.indexOf(t.message) > -1) && d.push(t.message);
									});
									for (
										var p = null,
											g = i.hasGutter && document.createDocumentFragment(),
											m = 0;
										m < f.length;
										++m
									) {
										var v = f[m],
											_ = v.severity;
										_ || (_ = "error"),
											(c = _),
											(p = "error" == (o = p) ? o : c),
											r.formatAnnotation && (v = r.formatAnnotation(v)),
											i.hasGutter && g.appendChild(l(v)),
											v.to &&
												i.marked.push(
													t.markText(v.from, v.to, {
														className:
															"CodeMirror-lint-mark CodeMirror-lint-mark-" + _,
														__annotation: v,
													})
												);
									}
									i.hasGutter &&
										t.setGutterMarker(
											u,
											e,
											a(t, g, p, h[u].length > 1, r.tooltips)
										),
										r.highlightLines &&
											t.addLineClass(u, "wrap", "CodeMirror-lint-line-" + p);
								}
							}
							r.onUpdateLinting && r.onUpdateLinting(n, h, t);
						}
					}
					function u(t) {
						var e = t.state.lint;
						e &&
							(clearTimeout(e.timeout),
							(e.timeout = setTimeout(function () {
								c(t);
							}, e.options.delay)));
					}
					t.defineOption("lint", !1, function (n, i, o) {
						if (
							(o &&
								o != t.Init &&
								(s(n),
								!1 !== n.state.lint.options.lintOnChange && n.off("change", u),
								t.off(
									n.getWrapperElement(),
									"mouseover",
									n.state.lint.onMouseOver
								),
								clearTimeout(n.state.lint.timeout),
								delete n.state.lint),
							i)
						) {
							for (
								var a = n.getOption("gutters"), l = !1, h = 0;
								h < a.length;
								++h
							)
								a[h] == e && (l = !0);
							var f = (n.state.lint = new r(n, i, l));
							f.options.lintOnChange && n.on("change", u),
								0 != f.options.tooltips &&
									"gutter" != f.options.tooltips &&
									t.on(n.getWrapperElement(), "mouseover", f.onMouseOver),
								c(n);
						}
					}),
						t.defineExtension("performLint", function () {
							c(this);
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		8: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					function e(t, e) {
						function n(t) {
							clearTimeout(i.doRedraw),
								(i.doRedraw = setTimeout(function () {
									i.redraw();
								}, t));
						}
						(this.cm = t),
							(this.options = e),
							(this.buttonHeight =
								e.scrollButtonHeight || t.getOption("scrollButtonHeight")),
							(this.annotations = []),
							(this.doRedraw = this.doUpdate = null),
							(this.div = t
								.getWrapperElement()
								.appendChild(document.createElement("div"))),
							(this.div.style.cssText =
								"position: absolute; right: 0; top: 0; z-index: 7; pointer-events: none"),
							this.computeScale();
						var i = this;
						t.on(
							"refresh",
							(this.resizeHandler = function () {
								clearTimeout(i.doUpdate),
									(i.doUpdate = setTimeout(function () {
										i.computeScale() && n(20);
									}, 100));
							})
						),
							t.on("markerAdded", this.resizeHandler),
							t.on("markerCleared", this.resizeHandler),
							!1 !== e.listenForChanges &&
								t.on(
									"changes",
									(this.changeHandler = function () {
										n(250);
									})
								);
					}
					t.defineExtension("annotateScrollbar", function (t) {
						return (
							"string" == typeof t && (t = { className: t }), new e(this, t)
						);
					}),
						t.defineOption("scrollButtonHeight", 0),
						(e.prototype.computeScale = function () {
							var t = this.cm,
								e =
									(t.getWrapperElement().clientHeight -
										t.display.barHeight -
										2 * this.buttonHeight) /
									t.getScrollerElement().scrollHeight;
							if (e != this.hScale) return (this.hScale = e), !0;
						}),
						(e.prototype.update = function (t) {
							(this.annotations = t), this.redraw();
						}),
						(e.prototype.redraw = function (t) {
							!1 !== t && this.computeScale();
							var e = this.cm,
								n = this.hScale,
								i = document.createDocumentFragment(),
								r = this.annotations,
								o = e.getOption("lineWrapping"),
								s = o && 1.5 * e.defaultTextHeight(),
								a = null,
								l = null;
							function c(t, n) {
								if (a != t.line) {
									(a = t.line), (l = e.getLineHandle(t.line));
									var i = e.getLineHandleVisualStart(l);
									i != l && ((a = e.getLineNumber(i)), (l = i));
								}
								return (l.widgets && l.widgets.length) || (o && l.height > s)
									? e.charCoords(t, "local")[n ? "top" : "bottom"]
									: e.heightAtLine(l, "local") + (n ? 0 : l.height);
							}
							var h = e.lastLine();
							if (e.display.barWidth)
								for (var u, f = 0; f < r.length; f++) {
									var d = r[f];
									if (!(d.to.line > h)) {
										for (
											var p = u || c(d.from, !0) * n, g = c(d.to, !1) * n;
											f < r.length - 1 &&
											!(r[f + 1].to.line > h) &&
											!((u = c(r[f + 1].from, !0) * n) > g + 0.9);

										)
											g = c((d = r[++f]).to, !1) * n;
										if (g != p) {
											var m = Math.max(g - p, 3),
												v = i.appendChild(document.createElement("div"));
											(v.style.cssText =
												"position: absolute; right: 0px; width: " +
												Math.max(e.display.barWidth - 1, 2) +
												"px; top: " +
												(p + this.buttonHeight) +
												"px; height: " +
												m +
												"px"),
												(v.className = this.options.className),
												d.id && v.setAttribute("annotation-id", d.id);
										}
									}
								}
							(this.div.textContent = ""), this.div.appendChild(i);
						}),
						(e.prototype.clear = function () {
							this.cm.off("refresh", this.resizeHandler),
								this.cm.off("markerAdded", this.resizeHandler),
								this.cm.off("markerCleared", this.resizeHandler),
								this.changeHandler &&
									this.cm.off("changes", this.changeHandler),
								this.div.parentNode.removeChild(this.div);
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		9: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					var e = {
						style: "matchhighlight",
						minChars: 2,
						delay: 100,
						wordsOnly: !1,
						annotateScrollbar: !1,
						showToken: !1,
						trim: !0,
					};
					function n(t) {
						for (var n in ((this.options = {}), e))
							this.options[n] = (t && t.hasOwnProperty(n) ? t : e)[n];
						(this.overlay = this.timeout = null),
							(this.matchesonscroll = null),
							(this.active = !1);
					}
					function i(t) {
						var e = t.state.matchHighlighter;
						(e.active || t.hasFocus()) && o(t, e);
					}
					function r(t) {
						var e = t.state.matchHighlighter;
						e.active || ((e.active = !0), o(t, e));
					}
					function o(t, e) {
						clearTimeout(e.timeout),
							(e.timeout = setTimeout(function () {
								l(t);
							}, e.options.delay));
					}
					function s(t, e, n, i) {
						var r = t.state.matchHighlighter;
						if (
							(t.addOverlay(
								(r.overlay = (function (t, e, n) {
									return {
										token: function (i) {
											if (
												i.match(t) &&
												(!e ||
													(function (t, e) {
														return !(
															(t.start &&
																e.test(t.string.charAt(t.start - 1))) ||
															(t.pos != t.string.length &&
																e.test(t.string.charAt(t.pos)))
														);
													})(i, e))
											)
												return n;
											i.next(), i.skipTo(t.charAt(0)) || i.skipToEnd();
										},
									};
								})(e, n, i))
							),
							r.options.annotateScrollbar && t.showMatchesOnScrollbar)
						) {
							var o = n
								? new RegExp(
										(/\w/.test(e.charAt(0)) ? "\\b" : "") +
											e.replace(/[\\\[.+*?(){|^$]/g, "\\$&") +
											(/\w/.test(e.charAt(e.length - 1)) ? "\\b" : "")
								  )
								: e;
							r.matchesonscroll = t.showMatchesOnScrollbar(o, !1, {
								className: "CodeMirror-selection-highlight-scrollbar",
							});
						}
					}
					function a(t) {
						var e = t.state.matchHighlighter;
						e.overlay &&
							(t.removeOverlay(e.overlay),
							(e.overlay = null),
							e.matchesonscroll &&
								(e.matchesonscroll.clear(), (e.matchesonscroll = null)));
					}
					function l(t) {
						t.operation(function () {
							var e = t.state.matchHighlighter;
							if ((a(t), t.somethingSelected() || !e.options.showToken)) {
								var n = t.getCursor("from"),
									i = t.getCursor("to");
								if (
									n.line == i.line &&
									(!e.options.wordsOnly ||
										(function (t, e, n) {
											if (null !== t.getRange(e, n).match(/^\w+$/)) {
												if (e.ch > 0) {
													var i = { line: e.line, ch: e.ch - 1 };
													if (null === t.getRange(i, e).match(/\W/)) return !1;
												}
												return !(
													n.ch < t.getLine(e.line).length &&
													((i = { line: n.line, ch: n.ch + 1 }),
													null === t.getRange(n, i).match(/\W/))
												);
											}
											return !1;
										})(t, n, i))
								) {
									var r = t.getRange(n, i);
									e.options.trim && (r = r.replace(/^\s+|\s+$/g, "")),
										r.length >= e.options.minChars &&
											s(t, r, !1, e.options.style);
								}
							} else {
								for (
									var o =
											!0 === e.options.showToken
												? /[\w$]/
												: e.options.showToken,
										l = t.getCursor(),
										c = t.getLine(l.line),
										h = l.ch,
										u = h;
									h && o.test(c.charAt(h - 1));

								)
									--h;
								for (; u < c.length && o.test(c.charAt(u)); ) ++u;
								h < u && s(t, c.slice(h, u), o, e.options.style);
							}
						});
					}
					t.defineOption("highlightSelectionMatches", !1, function (e, o, s) {
						if (
							(s &&
								s != t.Init &&
								(a(e),
								clearTimeout(e.state.matchHighlighter.timeout),
								(e.state.matchHighlighter = null),
								e.off("cursorActivity", i),
								e.off("focus", r)),
							o)
						) {
							var c = (e.state.matchHighlighter = new n(o));
							e.hasFocus() ? ((c.active = !0), l(e)) : e.on("focus", r),
								e.on("cursorActivity", i);
						}
					});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"), t("./matchesonscrollbar"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror", "./matchesonscrollbar"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13, "./matchesonscrollbar": 10 },
		],
		10: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					function e(t, e, n, i) {
						(this.cm = t), (this.options = i);
						var r = { listenForChanges: !1 };
						for (var o in i) r[o] = i[o];
						r.className || (r.className = "CodeMirror-search-match"),
							(this.annotation = t.annotateScrollbar(r)),
							(this.query = e),
							(this.caseFold = n),
							(this.gap = { from: t.firstLine(), to: t.lastLine() + 1 }),
							(this.matches = []),
							(this.update = null),
							this.findMatches(),
							this.annotation.update(this.matches);
						var s = this;
						t.on(
							"change",
							(this.changeHandler = function (t, e) {
								s.onChange(e);
							})
						);
					}
					function n(t, e, n) {
						return t <= e ? t : Math.max(e, t + n);
					}
					t.defineExtension("showMatchesOnScrollbar", function (t, n, i) {
						return (
							"string" == typeof i && (i = { className: i }),
							i || (i = {}),
							new e(this, t, n, i)
						);
					}),
						(e.prototype.findMatches = function () {
							if (this.gap) {
								for (
									var e = 0;
									e < this.matches.length &&
									!((r = this.matches[e]).from.line >= this.gap.to);
									e++
								)
									r.to.line >= this.gap.from && this.matches.splice(e--, 1);
								for (
									var n = this.cm.getSearchCursor(
											this.query,
											t.Pos(this.gap.from, 0),
											{
												caseFold: this.caseFold,
												multiline: this.options.multiline,
											}
										),
										i = (this.options && this.options.maxMatches) || 1e3;
									n.findNext();

								) {
									var r;
									if (
										(r = { from: n.from(), to: n.to() }).from.line >=
										this.gap.to
									)
										break;
									if ((this.matches.splice(e++, 0, r), this.matches.length > i))
										break;
								}
								this.gap = null;
							}
						}),
						(e.prototype.onChange = function (e) {
							var i = e.from.line,
								r = t.changeEnd(e).line,
								o = r - e.to.line;
							if (
								(this.gap
									? ((this.gap.from = Math.min(
											n(this.gap.from, i, o),
											e.from.line
									  )),
									  (this.gap.to = Math.max(n(this.gap.to, i, o), e.from.line)))
									: (this.gap = { from: e.from.line, to: r + 1 }),
								o)
							)
								for (var s = 0; s < this.matches.length; s++) {
									var a = this.matches[s],
										l = n(a.from.line, i, o);
									l != a.from.line && (a.from = t.Pos(l, a.from.ch));
									var c = n(a.to.line, i, o);
									c != a.to.line && (a.to = t.Pos(c, a.to.ch));
								}
							clearTimeout(this.update);
							var h = this;
							this.update = setTimeout(function () {
								h.updateAfterChange();
							}, 250);
						}),
						(e.prototype.updateAfterChange = function () {
							this.findMatches(), this.annotation.update(this.matches);
						}),
						(e.prototype.clear = function () {
							this.cm.off("change", this.changeHandler),
								this.annotation.clear();
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(
								t("../../lib/codemirror"),
								t("./searchcursor"),
								t("../scroll/annotatescrollbar")
						  )
						: "function" == typeof define && define.amd
						? define(
								[
									"../../lib/codemirror",
									"./searchcursor",
									"../scroll/annotatescrollbar",
								],
								i
						  )
						: i(CodeMirror);
			},
			{
				"../../lib/codemirror": 13,
				"../scroll/annotatescrollbar": 8,
				"./searchcursor": 12,
			},
		],
		11: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					function e() {
						(this.posFrom = this.posTo = this.lastQuery = this.query = null),
							(this.overlay = null);
					}
					function n(t) {
						return t.state.search || (t.state.search = new e());
					}
					function i(t) {
						return "string" == typeof t && t == t.toLowerCase();
					}
					function r(t, e, n) {
						return t.getSearchCursor(e, n, { caseFold: i(e), multiline: !0 });
					}
					function o(t, e, n, i, r) {
						t.openDialog
							? t.openDialog(e, r, {
									value: i,
									selectValueOnOpen: !0,
									bottom: t.options.search.bottom,
							  })
							: r(prompt(n, i));
					}
					function s(t) {
						return t.replace(/\\([nrt\\])/g, function (t, e) {
							return "n" == e
								? "\n"
								: "r" == e
								? "\r"
								: "t" == e
								? "\t"
								: "\\" == e
								? "\\"
								: t;
						});
					}
					function a(t) {
						var e = t.match(/^\/(.*)\/([a-z]*)$/);
						if (e)
							try {
								t = new RegExp(e[1], -1 == e[2].indexOf("i") ? "" : "i");
							} catch (t) {}
						else t = s(t);
						return (
							("string" == typeof t ? "" == t : t.test("")) && (t = /x^/), t
						);
					}
					function l(t, e, n) {
						(e.queryText = n),
							(e.query = a(n)),
							t.removeOverlay(e.overlay, i(e.query)),
							(e.overlay = (function (t, e) {
								return (
									"string" == typeof t
										? (t = new RegExp(
												t.replace(
													/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,
													"\\$&"
												),
												e ? "gi" : "g"
										  ))
										: t.global ||
										  (t = new RegExp(t.source, t.ignoreCase ? "gi" : "g")),
									{
										token: function (e) {
											t.lastIndex = e.pos;
											var n = t.exec(e.string);
											if (n && n.index == e.pos)
												return (e.pos += n[0].length || 1), "searching";
											n ? (e.pos = n.index) : e.skipToEnd();
										},
									}
								);
							})(e.query, i(e.query))),
							t.addOverlay(e.overlay),
							t.showMatchesOnScrollbar &&
								(e.annotate && (e.annotate.clear(), (e.annotate = null)),
								(e.annotate = t.showMatchesOnScrollbar(e.query, i(e.query))));
					}
					function c(e, i, r, s) {
						var a = n(e);
						if (a.query) return h(e, i);
						var c = e.getSelection() || a.lastQuery;
						if (
							(c instanceof RegExp && "x^" == c.source && (c = null),
							r && e.openDialog)
						) {
							var f = null,
								p = function (n, i) {
									t.e_stop(i),
										n &&
											(n != a.queryText &&
												(l(e, a, n), (a.posFrom = a.posTo = e.getCursor())),
											f && (f.style.opacity = 1),
											h(e, i.shiftKey, function (t, n) {
												var i;
												n.line < 3 &&
													document.querySelector &&
													(i =
														e.display.wrapper.querySelector(
															".CodeMirror-dialog"
														)) &&
													i.getBoundingClientRect().bottom - 4 >
														e.cursorCoords(n, "window").top &&
													((f = i).style.opacity = 0.4);
											}));
								};
							!(function (t, e, n, i, r) {
								t.openDialog(e, i, {
									value: n,
									selectValueOnOpen: !0,
									closeOnEnter: !1,
									onClose: function () {
										u(t);
									},
									onKeyDown: r,
									bottom: t.options.search.bottom,
								});
							})(e, d(e), c, p, function (i, r) {
								var o = t.keyName(i),
									s = e.getOption("extraKeys"),
									a = (s && s[o]) || t.keyMap[e.getOption("keyMap")][o];
								"findNext" == a ||
								"findPrev" == a ||
								"findPersistentNext" == a ||
								"findPersistentPrev" == a
									? (t.e_stop(i), l(e, n(e), r), e.execCommand(a))
									: ("find" != a && "findPersistent" != a) ||
									  (t.e_stop(i), p(r, i));
							}),
								s && c && (l(e, a, c), h(e, i));
						} else
							o(e, d(e), "Search for:", c, function (t) {
								t &&
									!a.query &&
									e.operation(function () {
										l(e, a, t), (a.posFrom = a.posTo = e.getCursor()), h(e, i);
									});
							});
					}
					function h(e, i, o) {
						e.operation(function () {
							var s = n(e),
								a = r(e, s.query, i ? s.posFrom : s.posTo);
							(a.find(i) ||
								(a = r(
									e,
									s.query,
									i ? t.Pos(e.lastLine()) : t.Pos(e.firstLine(), 0)
								)).find(i)) &&
								(e.setSelection(a.from(), a.to()),
								e.scrollIntoView({ from: a.from(), to: a.to() }, 20),
								(s.posFrom = a.from()),
								(s.posTo = a.to()),
								o && o(a.from(), a.to()));
						});
					}
					function u(t) {
						t.operation(function () {
							var e = n(t);
							(e.lastQuery = e.query),
								e.query &&
									((e.query = e.queryText = null),
									t.removeOverlay(e.overlay),
									e.annotate && (e.annotate.clear(), (e.annotate = null)));
						});
					}
					function f(t, e) {
						var n = t
							? document.createElement(t)
							: document.createDocumentFragment();
						for (var i in e) n[i] = e[i];
						for (var r = 2; r < arguments.length; r++) {
							var o = arguments[r];
							n.appendChild(
								"string" == typeof o ? document.createTextNode(o) : o
							);
						}
						return n;
					}
					function d(t) {
						return f(
							"",
							null,
							f(
								"span",
								{ className: "CodeMirror-search-label" },
								t.phrase("Search:")
							),
							" ",
							f("input", {
								type: "text",
								style: "width: 10em",
								className: "CodeMirror-search-field",
							}),
							" ",
							f(
								"span",
								{ style: "color: #888", className: "CodeMirror-search-hint" },
								t.phrase("(Use /re/ syntax for regexp search)")
							)
						);
					}
					function p(t, e, n) {
						t.operation(function () {
							for (var i = r(t, e); i.findNext(); )
								if ("string" != typeof e) {
									var o = t.getRange(i.from(), i.to()).match(e);
									i.replace(
										n.replace(/\$(\d)/g, function (t, e) {
											return o[e];
										})
									);
								} else i.replace(n);
						});
					}
					function g(t, e) {
						if (!t.getOption("readOnly")) {
							var i = t.getSelection() || n(t).lastQuery,
								l = e ? t.phrase("Replace all:") : t.phrase("Replace:"),
								c = f(
									"",
									null,
									f("span", { className: "CodeMirror-search-label" }, l),
									(function (t) {
										return f(
											"",
											null,
											" ",
											f("input", {
												type: "text",
												style: "width: 10em",
												className: "CodeMirror-search-field",
											}),
											" ",
											f(
												"span",
												{
													style: "color: #888",
													className: "CodeMirror-search-hint",
												},
												t.phrase("(Use /re/ syntax for regexp search)")
											)
										);
									})(t)
								);
							o(t, c, l, i, function (n) {
								n &&
									((n = a(n)),
									o(
										t,
										(function (t) {
											return f(
												"",
												null,
												f(
													"span",
													{ className: "CodeMirror-search-label" },
													t.phrase("With:")
												),
												" ",
												f("input", {
													type: "text",
													style: "width: 10em",
													className: "CodeMirror-search-field",
												})
											);
										})(t),
										t.phrase("Replace with:"),
										"",
										function (i) {
											if (((i = s(i)), e)) p(t, n, i);
											else {
												u(t);
												var o = r(t, n, t.getCursor("from")),
													a = function () {
														var e,
															s = o.from();
														(!(e = o.findNext()) &&
															((o = r(t, n)),
															!(e = o.findNext()) ||
																(s &&
																	o.from().line == s.line &&
																	o.from().ch == s.ch))) ||
															(t.setSelection(o.from(), o.to()),
															t.scrollIntoView({ from: o.from(), to: o.to() }),
															(function (t, e, n, i) {
																t.openConfirm
																	? t.openConfirm(e, i)
																	: confirm(n) && i[0]();
															})(
																t,
																(function (t) {
																	return f(
																		"",
																		null,
																		f(
																			"span",
																			{ className: "CodeMirror-search-label" },
																			t.phrase("Replace?")
																		),
																		" ",
																		f("button", {}, t.phrase("Yes")),
																		" ",
																		f("button", {}, t.phrase("No")),
																		" ",
																		f("button", {}, t.phrase("All")),
																		" ",
																		f("button", {}, t.phrase("Stop"))
																	);
																})(t),
																t.phrase("Replace?"),
																[
																	function () {
																		l(e);
																	},
																	a,
																	function () {
																		p(t, n, i);
																	},
																]
															));
													},
													l = function (t) {
														o.replace(
															"string" == typeof n
																? i
																: i.replace(/\$(\d)/g, function (e, n) {
																		return t[n];
																  })
														),
															a();
													};
												a();
											}
										}
									));
							});
						}
					}
					t.defineOption("search", { bottom: !1 }),
						(t.commands.find = function (t) {
							u(t), c(t);
						}),
						(t.commands.findPersistent = function (t) {
							u(t), c(t, !1, !0);
						}),
						(t.commands.findPersistentNext = function (t) {
							c(t, !1, !0, !0);
						}),
						(t.commands.findPersistentPrev = function (t) {
							c(t, !0, !0, !0);
						}),
						(t.commands.findNext = c),
						(t.commands.findPrev = function (t) {
							c(t, !0);
						}),
						(t.commands.clearSearch = u),
						(t.commands.replace = g),
						(t.commands.replaceAll = function (t) {
							g(t, !0);
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(
								t("../../lib/codemirror"),
								t("./searchcursor"),
								t("../dialog/dialog")
						  )
						: "function" == typeof define && define.amd
						? define(
								["../../lib/codemirror", "./searchcursor", "../dialog/dialog"],
								i
						  )
						: i(CodeMirror);
			},
			{
				"../../lib/codemirror": 13,
				"../dialog/dialog": 4,
				"./searchcursor": 12,
			},
		],
		12: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					var e,
						n,
						i = t.Pos;
					function r(t, e) {
						for (
							var n = (function (t) {
									var e = t.flags;
									return null != e
										? e
										: (t.ignoreCase ? "i" : "") +
												(t.global ? "g" : "") +
												(t.multiline ? "m" : "");
								})(t),
								i = n,
								r = 0;
							r < e.length;
							r++
						)
							-1 == i.indexOf(e.charAt(r)) && (i += e.charAt(r));
						return n == i ? t : new RegExp(t.source, i);
					}
					function o(t) {
						return /\\s|\\n|\n|\\W|\\D|\[\^/.test(t.source);
					}
					function s(t, e, n) {
						e = r(e, "g");
						for (
							var o = n.line, s = n.ch, a = t.lastLine();
							o <= a;
							o++, s = 0
						) {
							e.lastIndex = s;
							var l = t.getLine(o),
								c = e.exec(l);
							if (c)
								return {
									from: i(o, c.index),
									to: i(o, c.index + c[0].length),
									match: c,
								};
						}
					}
					function a(t, e, n) {
						if (!o(e)) return s(t, e, n);
						e = r(e, "gm");
						for (var a, l = 1, c = n.line, h = t.lastLine(); c <= h; ) {
							for (var u = 0; u < l && !(c > h); u++) {
								var f = t.getLine(c++);
								a = null == a ? f : a + "\n" + f;
							}
							(l *= 2), (e.lastIndex = n.ch);
							var d = e.exec(a);
							if (d) {
								var p = a.slice(0, d.index).split("\n"),
									g = d[0].split("\n"),
									m = n.line + p.length - 1,
									v = p[p.length - 1].length;
								return {
									from: i(m, v),
									to: i(
										m + g.length - 1,
										1 == g.length ? v + g[0].length : g[g.length - 1].length
									),
									match: d,
								};
							}
						}
					}
					function l(t, e, n) {
						for (var i, r = 0; r <= t.length; ) {
							e.lastIndex = r;
							var o = e.exec(t);
							if (!o) break;
							var s = o.index + o[0].length;
							if (s > t.length - n) break;
							(!i || s > i.index + i[0].length) && (i = o), (r = o.index + 1);
						}
						return i;
					}
					function c(t, e, n) {
						e = r(e, "g");
						for (
							var o = n.line, s = n.ch, a = t.firstLine();
							o >= a;
							o--, s = -1
						) {
							var c = t.getLine(o),
								h = l(c, e, s < 0 ? 0 : c.length - s);
							if (h)
								return {
									from: i(o, h.index),
									to: i(o, h.index + h[0].length),
									match: h,
								};
						}
					}
					function h(t, e, n) {
						if (!o(e)) return c(t, e, n);
						e = r(e, "gm");
						for (
							var s,
								a = 1,
								h = t.getLine(n.line).length - n.ch,
								u = n.line,
								f = t.firstLine();
							u >= f;

						) {
							for (var d = 0; d < a && u >= f; d++) {
								var p = t.getLine(u--);
								s = null == s ? p : p + "\n" + s;
							}
							a *= 2;
							var g = l(s, e, h);
							if (g) {
								var m = s.slice(0, g.index).split("\n"),
									v = g[0].split("\n"),
									_ = u + m.length,
									y = m[m.length - 1].length;
								return {
									from: i(_, y),
									to: i(
										_ + v.length - 1,
										1 == v.length ? y + v[0].length : v[v.length - 1].length
									),
									match: g,
								};
							}
						}
					}
					function u(t, e, n, i) {
						if (t.length == e.length) return n;
						for (var r = 0, o = n + Math.max(0, t.length - e.length); ; ) {
							if (r == o) return r;
							var s = (r + o) >> 1,
								a = i(t.slice(0, s)).length;
							if (a == n) return s;
							a > n ? (o = s) : (r = s + 1);
						}
					}
					function f(t, r, o, s) {
						if (!r.length) return null;
						var a = s ? e : n,
							l = a(r).split(/\r|\n\r?/);
						t: for (
							var c = o.line, h = o.ch, f = t.lastLine() + 1 - l.length;
							c <= f;
							c++, h = 0
						) {
							var d = t.getLine(c).slice(h),
								p = a(d);
							if (1 == l.length) {
								var g = p.indexOf(l[0]);
								if (-1 == g) continue t;
								return (
									(o = u(d, p, g, a) + h),
									{
										from: i(c, u(d, p, g, a) + h),
										to: i(c, u(d, p, g + l[0].length, a) + h),
									}
								);
							}
							var m = p.length - l[0].length;
							if (p.slice(m) == l[0]) {
								for (var v = 1; v < l.length - 1; v++)
									if (a(t.getLine(c + v)) != l[v]) continue t;
								var _ = t.getLine(c + l.length - 1),
									y = a(_),
									x = l[l.length - 1];
								if (y.slice(0, x.length) == x)
									return {
										from: i(c, u(d, p, m, a) + h),
										to: i(c + l.length - 1, u(_, y, x.length, a)),
									};
							}
						}
					}
					function d(t, r, o, s) {
						if (!r.length) return null;
						var a = s ? e : n,
							l = a(r).split(/\r|\n\r?/);
						t: for (
							var c = o.line, h = o.ch, f = t.firstLine() - 1 + l.length;
							c >= f;
							c--, h = -1
						) {
							var d = t.getLine(c);
							h > -1 && (d = d.slice(0, h));
							var p = a(d);
							if (1 == l.length) {
								var g = p.lastIndexOf(l[0]);
								if (-1 == g) continue t;
								return {
									from: i(c, u(d, p, g, a)),
									to: i(c, u(d, p, g + l[0].length, a)),
								};
							}
							var m = l[l.length - 1];
							if (p.slice(0, m.length) == m) {
								var v = 1;
								for (o = c - l.length + 1; v < l.length - 1; v++)
									if (a(t.getLine(o + v)) != l[v]) continue t;
								var _ = t.getLine(c + 1 - l.length),
									y = a(_);
								if (y.slice(y.length - l[0].length) == l[0])
									return {
										from: i(
											c + 1 - l.length,
											u(_, y, _.length - l[0].length, a)
										),
										to: i(c, u(d, p, m.length, a)),
									};
							}
						}
					}
					function p(t, e, n, o) {
						var l;
						(this.atOccurrence = !1),
							(this.doc = t),
							(n = n ? t.clipPos(n) : i(0, 0)),
							(this.pos = { from: n, to: n }),
							"object" == typeof o ? (l = o.caseFold) : ((l = o), (o = null)),
							"string" == typeof e
								? (null == l && (l = !1),
								  (this.matches = function (n, i) {
										return (n ? d : f)(t, e, i, l);
								  }))
								: ((e = r(e, "gm")),
								  o && !1 === o.multiline
										? (this.matches = function (n, i) {
												return (n ? c : s)(t, e, i);
										  })
										: (this.matches = function (n, i) {
												return (n ? h : a)(t, e, i);
										  }));
					}
					String.prototype.normalize
						? ((e = function (t) {
								return t.normalize("NFD").toLowerCase();
						  }),
						  (n = function (t) {
								return t.normalize("NFD");
						  }))
						: ((e = function (t) {
								return t.toLowerCase();
						  }),
						  (n = function (t) {
								return t;
						  })),
						(p.prototype = {
							findNext: function () {
								return this.find(!1);
							},
							findPrevious: function () {
								return this.find(!0);
							},
							find: function (e) {
								for (
									var n = this.matches(
										e,
										this.doc.clipPos(e ? this.pos.from : this.pos.to)
									);
									n && 0 == t.cmpPos(n.from, n.to);

								)
									e
										? n.from.ch
											? (n.from = i(n.from.line, n.from.ch - 1))
											: (n =
													n.from.line == this.doc.firstLine()
														? null
														: this.matches(
																e,
																this.doc.clipPos(i(n.from.line - 1))
														  ))
										: n.to.ch < this.doc.getLine(n.to.line).length
										? (n.to = i(n.to.line, n.to.ch + 1))
										: (n =
												n.to.line == this.doc.lastLine()
													? null
													: this.matches(e, i(n.to.line + 1, 0)));
								if (n)
									return (
										(this.pos = n),
										(this.atOccurrence = !0),
										this.pos.match || !0
									);
								var r = i(
									e ? this.doc.firstLine() : this.doc.lastLine() + 1,
									0
								);
								return (
									(this.pos = { from: r, to: r }), (this.atOccurrence = !1)
								);
							},
							from: function () {
								if (this.atOccurrence) return this.pos.from;
							},
							to: function () {
								if (this.atOccurrence) return this.pos.to;
							},
							replace: function (e, n) {
								if (this.atOccurrence) {
									var r = t.splitLines(e);
									this.doc.replaceRange(r, this.pos.from, this.pos.to, n),
										(this.pos.to = i(
											this.pos.from.line + r.length - 1,
											r[r.length - 1].length +
												(1 == r.length ? this.pos.from.ch : 0)
										));
								}
							},
						}),
						t.defineExtension("getSearchCursor", function (t, e, n) {
							return new p(this.doc, t, e, n);
						}),
						t.defineDocExtension("getSearchCursor", function (t, e, n) {
							return new p(this, t, e, n);
						}),
						t.defineExtension("selectMatches", function (e, n) {
							for (
								var i = [],
									r = this.getSearchCursor(e, this.getCursor("from"), n);
								r.findNext() && !(t.cmpPos(r.to(), this.getCursor("to")) > 0);

							)
								i.push({ anchor: r.from(), head: r.to() });
							i.length && this.setSelections(i, 0);
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		13: [
			function (t, e, n) {
				var i, r;
				(i = this),
					(r = function () {
						"use strict";
						var t = navigator.userAgent,
							e = navigator.platform,
							n = /gecko\/\d/i.test(t),
							i = /MSIE \d/.test(t),
							r = /Trident\/(?:[7-9]|\d{2,})\..*rv:(\d+)/.exec(t),
							o = /Edge\/(\d+)/.exec(t),
							s = i || r || o,
							a = s && (i ? document.documentMode || 6 : +(o || r)[1]),
							l = !o && /WebKit\//.test(t),
							c = l && /Qt\/\d+\.\d+/.test(t),
							h = !o && /Chrome\//.test(t),
							u = /Opera\//.test(t),
							f = /Apple Computer/.test(navigator.vendor),
							d = /Mac OS X 1\d\D([8-9]|\d\d)\D/.test(t),
							p = /PhantomJS/.test(t),
							g = f && (/Mobile\/\w+/.test(t) || navigator.maxTouchPoints > 2),
							m = /Android/.test(t),
							v =
								g ||
								m ||
								/webOS|BlackBerry|Opera Mini|Opera Mobi|IEMobile/i.test(t),
							_ = g || /Mac/.test(e),
							y = /\bCrOS\b/.test(t),
							x = /win/i.test(e),
							k = u && t.match(/Version\/(\d*\.\d*)/);
						k && (k = Number(k[1])), k && k >= 15 && ((u = !1), (l = !0));
						var b = _ && (c || (u && (null == k || k < 12.11))),
							T = n || (s && a >= 9);
						function C(t) {
							return new RegExp("(^|\\s)" + t + "(?:$|\\s)\\s*");
						}
						var w,
							E = function (t, e) {
								var n = t.className,
									i = C(e).exec(n);
								if (i) {
									var r = n.slice(i.index + i[0].length);
									t.className = n.slice(0, i.index) + (r ? i[1] + r : "");
								}
							};
						function S(t) {
							for (var e = t.childNodes.length; e > 0; --e)
								t.removeChild(t.firstChild);
							return t;
						}
						function A(t, e) {
							return S(t).appendChild(e);
						}
						function L(t, e, n, i) {
							var r = document.createElement(t);
							if (
								(n && (r.className = n),
								i && (r.style.cssText = i),
								"string" == typeof e)
							)
								r.appendChild(document.createTextNode(e));
							else if (e)
								for (var o = 0; o < e.length; ++o) r.appendChild(e[o]);
							return r;
						}
						function O(t, e, n, i) {
							var r = L(t, e, n, i);
							return r.setAttribute("role", "presentation"), r;
						}
						function N(t, e) {
							if ((3 == e.nodeType && (e = e.parentNode), t.contains))
								return t.contains(e);
							do {
								if ((11 == e.nodeType && (e = e.host), e == t)) return !0;
							} while ((e = e.parentNode));
						}
						function I() {
							var t;
							try {
								t = document.activeElement;
							} catch (e) {
								t = document.body || null;
							}
							for (; t && t.shadowRoot && t.shadowRoot.activeElement; )
								t = t.shadowRoot.activeElement;
							return t;
						}
						function M(t, e) {
							var n = t.className;
							C(e).test(n) || (t.className += (n ? " " : "") + e);
						}
						function $(t, e) {
							for (var n = t.split(" "), i = 0; i < n.length; i++)
								n[i] && !C(n[i]).test(e) && (e += " " + n[i]);
							return e;
						}
						w = document.createRange
							? function (t, e, n, i) {
									var r = document.createRange();
									return r.setEnd(i || t, n), r.setStart(t, e), r;
							  }
							: function (t, e, n) {
									var i = document.body.createTextRange();
									try {
										i.moveToElementText(t.parentNode);
									} catch (t) {
										return i;
									}
									return (
										i.collapse(!0),
										i.moveEnd("character", n),
										i.moveStart("character", e),
										i
									);
							  };
						var R = function (t) {
							t.select();
						};
						function D(t) {
							var e = Array.prototype.slice.call(arguments, 1);
							return function () {
								return t.apply(null, e);
							};
						}
						function P(t, e, n) {
							for (var i in (e || (e = {}), t))
								!t.hasOwnProperty(i) ||
									(!1 === n && e.hasOwnProperty(i)) ||
									(e[i] = t[i]);
							return e;
						}
						function F(t, e, n, i, r) {
							null == e &&
								-1 == (e = t.search(/[^\s\u00a0]/)) &&
								(e = t.length);
							for (var o = i || 0, s = r || 0; ; ) {
								var a = t.indexOf("\t", o);
								if (a < 0 || a >= e) return s + (e - o);
								(s += a - o), (s += n - (s % n)), (o = a + 1);
							}
						}
						g
							? (R = function (t) {
									(t.selectionStart = 0), (t.selectionEnd = t.value.length);
							  })
							: s &&
							  (R = function (t) {
									try {
										t.select();
									} catch (t) {}
							  });
						var B = function () {
							(this.id = null),
								(this.f = null),
								(this.time = 0),
								(this.handler = D(this.onTimeout, this));
						};
						function U(t, e) {
							for (var n = 0; n < t.length; ++n) if (t[n] == e) return n;
							return -1;
						}
						(B.prototype.onTimeout = function (t) {
							(t.id = 0),
								t.time <= +new Date()
									? t.f()
									: setTimeout(t.handler, t.time - +new Date());
						}),
							(B.prototype.set = function (t, e) {
								this.f = e;
								var n = +new Date() + t;
								(!this.id || n < this.time) &&
									(clearTimeout(this.id),
									(this.id = setTimeout(this.handler, t)),
									(this.time = n));
							});
						var H = {
								toString: function () {
									return "CodeMirror.Pass";
								},
							},
							z = { scroll: !1 },
							W = { origin: "*mouse" },
							j = { origin: "+move" };
						function G(t, e, n) {
							for (var i = 0, r = 0; ; ) {
								var o = t.indexOf("\t", i);
								-1 == o && (o = t.length);
								var s = o - i;
								if (o == t.length || r + s >= e) return i + Math.min(s, e - r);
								if (((r += o - i), (i = o + 1), (r += n - (r % n)) >= e))
									return i;
							}
						}
						var q = [""];
						function V(t) {
							for (; q.length <= t; ) q.push(Y(q) + " ");
							return q[t];
						}
						function Y(t) {
							return t[t.length - 1];
						}
						function K(t, e) {
							for (var n = [], i = 0; i < t.length; i++) n[i] = e(t[i], i);
							return n;
						}
						function X() {}
						function Q(t, e) {
							var n;
							return (
								Object.create
									? (n = Object.create(t))
									: ((X.prototype = t), (n = new X())),
								e && P(e, n),
								n
							);
						}
						var Z =
							/[\u00df\u0587\u0590-\u05f4\u0600-\u06ff\u3040-\u309f\u30a0-\u30ff\u3400-\u4db5\u4e00-\u9fcc\uac00-\ud7af]/;
						function J(t) {
							return (
								/\w/.test(t) ||
								(t > "" && (t.toUpperCase() != t.toLowerCase() || Z.test(t)))
							);
						}
						function tt(t, e) {
							return e
								? !!(e.source.indexOf("\\w") > -1 && J(t)) || e.test(t)
								: J(t);
						}
						function et(t) {
							for (var e in t) if (t.hasOwnProperty(e) && t[e]) return !1;
							return !0;
						}
						var nt =
							/[\u0300-\u036f\u0483-\u0489\u0591-\u05bd\u05bf\u05c1\u05c2\u05c4\u05c5\u05c7\u0610-\u061a\u064b-\u065e\u0670\u06d6-\u06dc\u06de-\u06e4\u06e7\u06e8\u06ea-\u06ed\u0711\u0730-\u074a\u07a6-\u07b0\u07eb-\u07f3\u0816-\u0819\u081b-\u0823\u0825-\u0827\u0829-\u082d\u0900-\u0902\u093c\u0941-\u0948\u094d\u0951-\u0955\u0962\u0963\u0981\u09bc\u09be\u09c1-\u09c4\u09cd\u09d7\u09e2\u09e3\u0a01\u0a02\u0a3c\u0a41\u0a42\u0a47\u0a48\u0a4b-\u0a4d\u0a51\u0a70\u0a71\u0a75\u0a81\u0a82\u0abc\u0ac1-\u0ac5\u0ac7\u0ac8\u0acd\u0ae2\u0ae3\u0b01\u0b3c\u0b3e\u0b3f\u0b41-\u0b44\u0b4d\u0b56\u0b57\u0b62\u0b63\u0b82\u0bbe\u0bc0\u0bcd\u0bd7\u0c3e-\u0c40\u0c46-\u0c48\u0c4a-\u0c4d\u0c55\u0c56\u0c62\u0c63\u0cbc\u0cbf\u0cc2\u0cc6\u0ccc\u0ccd\u0cd5\u0cd6\u0ce2\u0ce3\u0d3e\u0d41-\u0d44\u0d4d\u0d57\u0d62\u0d63\u0dca\u0dcf\u0dd2-\u0dd4\u0dd6\u0ddf\u0e31\u0e34-\u0e3a\u0e47-\u0e4e\u0eb1\u0eb4-\u0eb9\u0ebb\u0ebc\u0ec8-\u0ecd\u0f18\u0f19\u0f35\u0f37\u0f39\u0f71-\u0f7e\u0f80-\u0f84\u0f86\u0f87\u0f90-\u0f97\u0f99-\u0fbc\u0fc6\u102d-\u1030\u1032-\u1037\u1039\u103a\u103d\u103e\u1058\u1059\u105e-\u1060\u1071-\u1074\u1082\u1085\u1086\u108d\u109d\u135f\u1712-\u1714\u1732-\u1734\u1752\u1753\u1772\u1773\u17b7-\u17bd\u17c6\u17c9-\u17d3\u17dd\u180b-\u180d\u18a9\u1920-\u1922\u1927\u1928\u1932\u1939-\u193b\u1a17\u1a18\u1a56\u1a58-\u1a5e\u1a60\u1a62\u1a65-\u1a6c\u1a73-\u1a7c\u1a7f\u1b00-\u1b03\u1b34\u1b36-\u1b3a\u1b3c\u1b42\u1b6b-\u1b73\u1b80\u1b81\u1ba2-\u1ba5\u1ba8\u1ba9\u1c2c-\u1c33\u1c36\u1c37\u1cd0-\u1cd2\u1cd4-\u1ce0\u1ce2-\u1ce8\u1ced\u1dc0-\u1de6\u1dfd-\u1dff\u200c\u200d\u20d0-\u20f0\u2cef-\u2cf1\u2de0-\u2dff\u302a-\u302f\u3099\u309a\ua66f-\ua672\ua67c\ua67d\ua6f0\ua6f1\ua802\ua806\ua80b\ua825\ua826\ua8c4\ua8e0-\ua8f1\ua926-\ua92d\ua947-\ua951\ua980-\ua982\ua9b3\ua9b6-\ua9b9\ua9bc\uaa29-\uaa2e\uaa31\uaa32\uaa35\uaa36\uaa43\uaa4c\uaab0\uaab2-\uaab4\uaab7\uaab8\uaabe\uaabf\uaac1\uabe5\uabe8\uabed\udc00-\udfff\ufb1e\ufe00-\ufe0f\ufe20-\ufe26\uff9e\uff9f]/;
						function it(t) {
							return t.charCodeAt(0) >= 768 && nt.test(t);
						}
						function rt(t, e, n) {
							for (; (n < 0 ? e > 0 : e < t.length) && it(t.charAt(e)); )
								e += n;
							return e;
						}
						function ot(t, e, n) {
							for (var i = e > n ? -1 : 1; ; ) {
								if (e == n) return e;
								var r = (e + n) / 2,
									o = i < 0 ? Math.ceil(r) : Math.floor(r);
								if (o == e) return t(o) ? e : n;
								t(o) ? (n = o) : (e = o + i);
							}
						}
						var st = null;
						function at(t, e, n) {
							var i;
							st = null;
							for (var r = 0; r < t.length; ++r) {
								var o = t[r];
								if (o.from < e && o.to > e) return r;
								o.to == e &&
									(o.from != o.to && "before" == n ? (i = r) : (st = r)),
									o.from == e &&
										(o.from != o.to && "before" != n ? (i = r) : (st = r));
							}
							return null != i ? i : st;
						}
						var lt = (function () {
							var t = /[\u0590-\u05f4\u0600-\u06ff\u0700-\u08ac]/,
								e = /[stwN]/,
								n = /[LRr]/,
								i = /[Lb1n]/,
								r = /[1n]/;
							function o(t, e, n) {
								(this.level = t), (this.from = e), (this.to = n);
							}
							return function (s, a) {
								var l = "ltr" == a ? "L" : "R";
								if (0 == s.length || ("ltr" == a && !t.test(s))) return !1;
								for (var c, h = s.length, u = [], f = 0; f < h; ++f)
									u.push(
										(c = s.charCodeAt(f)) <= 247
											? "bbbbbbbbbtstwsbbbbbbbbbbbbbbssstwNN%%%NNNNNN,N,N1111111111NNNNNNNLLLLLLLLLLLLLLLLLLLLLLLLLLNNNNNNLLLLLLLLLLLLLLLLLLLLLLLLLLNNNNbbbbbbsbbbbbbbbbbbbbbbbbbbbbbbbbb,N%%%%NNNNLNNNNN%%11NLNNN1LNNNNNLLLLLLLLLLLLLLLLLLLLLLLNLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLN".charAt(
													c
											  )
											: 1424 <= c && c <= 1524
											? "R"
											: 1536 <= c && c <= 1785
											? "nnnnnnNNr%%r,rNNmmmmmmmmmmmrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrmmmmmmmmmmmmmmmmmmmmmnnnnnnnnnn%nnrrrmrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrmmmmmmmnNmmmmmmrrmmNmmmmrr1111111111".charAt(
													c - 1536
											  )
											: 1774 <= c && c <= 2220
											? "r"
											: 8192 <= c && c <= 8203
											? "w"
											: 8204 == c
											? "b"
											: "L"
									);
								for (var d = 0, p = l; d < h; ++d) {
									var g = u[d];
									"m" == g ? (u[d] = p) : (p = g);
								}
								for (var m = 0, v = l; m < h; ++m) {
									var _ = u[m];
									"1" == _ && "r" == v
										? (u[m] = "n")
										: n.test(_) && ((v = _), "r" == _ && (u[m] = "R"));
								}
								for (var y = 1, x = u[0]; y < h - 1; ++y) {
									var k = u[y];
									"+" == k && "1" == x && "1" == u[y + 1]
										? (u[y] = "1")
										: "," != k ||
										  x != u[y + 1] ||
										  ("1" != x && "n" != x) ||
										  (u[y] = x),
										(x = k);
								}
								for (var b = 0; b < h; ++b) {
									var T = u[b];
									if ("," == T) u[b] = "N";
									else if ("%" == T) {
										var C = void 0;
										for (C = b + 1; C < h && "%" == u[C]; ++C);
										for (
											var w =
													(b && "!" == u[b - 1]) || (C < h && "1" == u[C])
														? "1"
														: "N",
												E = b;
											E < C;
											++E
										)
											u[E] = w;
										b = C - 1;
									}
								}
								for (var S = 0, A = l; S < h; ++S) {
									var L = u[S];
									"L" == A && "1" == L ? (u[S] = "L") : n.test(L) && (A = L);
								}
								for (var O = 0; O < h; ++O)
									if (e.test(u[O])) {
										var N = void 0;
										for (N = O + 1; N < h && e.test(u[N]); ++N);
										for (
											var I = "L" == (O ? u[O - 1] : l),
												M =
													I == ("L" == (N < h ? u[N] : l))
														? I
															? "L"
															: "R"
														: l,
												$ = O;
											$ < N;
											++$
										)
											u[$] = M;
										O = N - 1;
									}
								for (var R, D = [], P = 0; P < h; )
									if (i.test(u[P])) {
										var F = P;
										for (++P; P < h && i.test(u[P]); ++P);
										D.push(new o(0, F, P));
									} else {
										var B = P,
											U = D.length,
											H = "rtl" == a ? 1 : 0;
										for (++P; P < h && "L" != u[P]; ++P);
										for (var z = B; z < P; )
											if (r.test(u[z])) {
												B < z && (D.splice(U, 0, new o(1, B, z)), (U += H));
												var W = z;
												for (++z; z < P && r.test(u[z]); ++z);
												D.splice(U, 0, new o(2, W, z)), (U += H), (B = z);
											} else ++z;
										B < P && D.splice(U, 0, new o(1, B, P));
									}
								return (
									"ltr" == a &&
										(1 == D[0].level &&
											(R = s.match(/^\s+/)) &&
											((D[0].from = R[0].length),
											D.unshift(new o(0, 0, R[0].length))),
										1 == Y(D).level &&
											(R = s.match(/\s+$/)) &&
											((Y(D).to -= R[0].length),
											D.push(new o(0, h - R[0].length, h)))),
									"rtl" == a ? D.reverse() : D
								);
							};
						})();
						function ct(t, e) {
							var n = t.order;
							return null == n && (n = t.order = lt(t.text, e)), n;
						}
						var ht = [],
							ut = function (t, e, n) {
								if (t.addEventListener) t.addEventListener(e, n, !1);
								else if (t.attachEvent) t.attachEvent("on" + e, n);
								else {
									var i = t._handlers || (t._handlers = {});
									i[e] = (i[e] || ht).concat(n);
								}
							};
						function ft(t, e) {
							return (t._handlers && t._handlers[e]) || ht;
						}
						function dt(t, e, n) {
							if (t.removeEventListener) t.removeEventListener(e, n, !1);
							else if (t.detachEvent) t.detachEvent("on" + e, n);
							else {
								var i = t._handlers,
									r = i && i[e];
								if (r) {
									var o = U(r, n);
									o > -1 && (i[e] = r.slice(0, o).concat(r.slice(o + 1)));
								}
							}
						}
						function pt(t, e) {
							var n = ft(t, e);
							if (n.length)
								for (
									var i = Array.prototype.slice.call(arguments, 2), r = 0;
									r < n.length;
									++r
								)
									n[r].apply(null, i);
						}
						function gt(t, e, n) {
							return (
								"string" == typeof e &&
									(e = {
										type: e,
										preventDefault: function () {
											this.defaultPrevented = !0;
										},
									}),
								pt(t, n || e.type, t, e),
								kt(e) || e.codemirrorIgnore
							);
						}
						function mt(t) {
							var e = t._handlers && t._handlers.cursorActivity;
							if (e)
								for (
									var n =
											t.curOp.cursorActivityHandlers ||
											(t.curOp.cursorActivityHandlers = []),
										i = 0;
									i < e.length;
									++i
								)
									-1 == U(n, e[i]) && n.push(e[i]);
						}
						function vt(t, e) {
							return ft(t, e).length > 0;
						}
						function _t(t) {
							(t.prototype.on = function (t, e) {
								ut(this, t, e);
							}),
								(t.prototype.off = function (t, e) {
									dt(this, t, e);
								});
						}
						function yt(t) {
							t.preventDefault ? t.preventDefault() : (t.returnValue = !1);
						}
						function xt(t) {
							t.stopPropagation ? t.stopPropagation() : (t.cancelBubble = !0);
						}
						function kt(t) {
							return null != t.defaultPrevented
								? t.defaultPrevented
								: 0 == t.returnValue;
						}
						function bt(t) {
							yt(t), xt(t);
						}
						function Tt(t) {
							return t.target || t.srcElement;
						}
						function Ct(t) {
							var e = t.which;
							return (
								null == e &&
									(1 & t.button
										? (e = 1)
										: 2 & t.button
										? (e = 3)
										: 4 & t.button && (e = 2)),
								_ && t.ctrlKey && 1 == e && (e = 3),
								e
							);
						}
						var wt,
							Et,
							St = (function () {
								if (s && a < 9) return !1;
								var t = L("div");
								return "draggable" in t || "dragDrop" in t;
							})();
						function At(t) {
							if (null == wt) {
								var e = L("span", "​");
								A(t, L("span", [e, document.createTextNode("x")])),
									0 != t.firstChild.offsetHeight &&
										(wt =
											e.offsetWidth <= 1 &&
											e.offsetHeight > 2 &&
											!(s && a < 8));
							}
							var n = wt
								? L("span", "​")
								: L(
										"span",
										" ",
										null,
										"display: inline-block; width: 1px; margin-right: -1px"
								  );
							return n.setAttribute("cm-text", ""), n;
						}
						function Lt(t) {
							if (null != Et) return Et;
							var e = A(t, document.createTextNode("AخA")),
								n = w(e, 0, 1).getBoundingClientRect(),
								i = w(e, 1, 2).getBoundingClientRect();
							return (
								S(t), !(!n || n.left == n.right) && (Et = i.right - n.right < 3)
							);
						}
						var Ot,
							Nt =
								3 != "\n\nb".split(/\n/).length
									? function (t) {
											for (var e = 0, n = [], i = t.length; e <= i; ) {
												var r = t.indexOf("\n", e);
												-1 == r && (r = t.length);
												var o = t.slice(e, "\r" == t.charAt(r - 1) ? r - 1 : r),
													s = o.indexOf("\r");
												-1 != s
													? (n.push(o.slice(0, s)), (e += s + 1))
													: (n.push(o), (e = r + 1));
											}
											return n;
									  }
									: function (t) {
											return t.split(/\r\n?|\n/);
									  },
							It = window.getSelection
								? function (t) {
										try {
											return t.selectionStart != t.selectionEnd;
										} catch (t) {
											return !1;
										}
								  }
								: function (t) {
										var e;
										try {
											e = t.ownerDocument.selection.createRange();
										} catch (t) {}
										return (
											!(!e || e.parentElement() != t) &&
											0 != e.compareEndPoints("StartToEnd", e)
										);
								  },
							Mt =
								"oncopy" in (Ot = L("div")) ||
								(Ot.setAttribute("oncopy", "return;"),
								"function" == typeof Ot.oncopy),
							$t = null,
							Rt = {},
							Dt = {};
						function Pt(t, e) {
							arguments.length > 2 &&
								(e.dependencies = Array.prototype.slice.call(arguments, 2)),
								(Rt[t] = e);
						}
						function Ft(t) {
							if ("string" == typeof t && Dt.hasOwnProperty(t)) t = Dt[t];
							else if (
								t &&
								"string" == typeof t.name &&
								Dt.hasOwnProperty(t.name)
							) {
								var e = Dt[t.name];
								"string" == typeof e && (e = { name: e }),
									((t = Q(e, t)).name = e.name);
							} else {
								if ("string" == typeof t && /^[\w\-]+\/[\w\-]+\+xml$/.test(t))
									return Ft("application/xml");
								if ("string" == typeof t && /^[\w\-]+\/[\w\-]+\+json$/.test(t))
									return Ft("application/json");
							}
							return "string" == typeof t ? { name: t } : t || { name: "null" };
						}
						function Bt(t, e) {
							e = Ft(e);
							var n = Rt[e.name];
							if (!n) return Bt(t, "text/plain");
							var i = n(t, e);
							if (Ut.hasOwnProperty(e.name)) {
								var r = Ut[e.name];
								for (var o in r)
									r.hasOwnProperty(o) &&
										(i.hasOwnProperty(o) && (i["_" + o] = i[o]), (i[o] = r[o]));
							}
							if (
								((i.name = e.name),
								e.helperType && (i.helperType = e.helperType),
								e.modeProps)
							)
								for (var s in e.modeProps) i[s] = e.modeProps[s];
							return i;
						}
						var Ut = {};
						function Ht(t, e) {
							P(e, Ut.hasOwnProperty(t) ? Ut[t] : (Ut[t] = {}));
						}
						function zt(t, e) {
							if (!0 === e) return e;
							if (t.copyState) return t.copyState(e);
							var n = {};
							for (var i in e) {
								var r = e[i];
								r instanceof Array && (r = r.concat([])), (n[i] = r);
							}
							return n;
						}
						function Wt(t, e) {
							for (var n; t.innerMode && (n = t.innerMode(e)) && n.mode != t; )
								(e = n.state), (t = n.mode);
							return n || { mode: t, state: e };
						}
						function jt(t, e, n) {
							return !t.startState || t.startState(e, n);
						}
						var Gt = function (t, e, n) {
							(this.pos = this.start = 0),
								(this.string = t),
								(this.tabSize = e || 8),
								(this.lastColumnPos = this.lastColumnValue = 0),
								(this.lineStart = 0),
								(this.lineOracle = n);
						};
						function qt(t, e) {
							if ((e -= t.first) < 0 || e >= t.size)
								throw new Error(
									"There is no line " + (e + t.first) + " in the document."
								);
							for (var n = t; !n.lines; )
								for (var i = 0; ; ++i) {
									var r = n.children[i],
										o = r.chunkSize();
									if (e < o) {
										n = r;
										break;
									}
									e -= o;
								}
							return n.lines[e];
						}
						function Vt(t, e, n) {
							var i = [],
								r = e.line;
							return (
								t.iter(e.line, n.line + 1, function (t) {
									var o = t.text;
									r == n.line && (o = o.slice(0, n.ch)),
										r == e.line && (o = o.slice(e.ch)),
										i.push(o),
										++r;
								}),
								i
							);
						}
						function Yt(t, e, n) {
							var i = [];
							return (
								t.iter(e, n, function (t) {
									i.push(t.text);
								}),
								i
							);
						}
						function Kt(t, e) {
							var n = e - t.height;
							if (n) for (var i = t; i; i = i.parent) i.height += n;
						}
						function Xt(t) {
							if (null == t.parent) return null;
							for (
								var e = t.parent, n = U(e.lines, t), i = e.parent;
								i;
								e = i, i = i.parent
							)
								for (var r = 0; i.children[r] != e; ++r)
									n += i.children[r].chunkSize();
							return n + e.first;
						}
						function Qt(t, e) {
							var n = t.first;
							t: do {
								for (var i = 0; i < t.children.length; ++i) {
									var r = t.children[i],
										o = r.height;
									if (e < o) {
										t = r;
										continue t;
									}
									(e -= o), (n += r.chunkSize());
								}
								return n;
							} while (!t.lines);
							for (var s = 0; s < t.lines.length; ++s) {
								var a = t.lines[s].height;
								if (e < a) break;
								e -= a;
							}
							return n + s;
						}
						function Zt(t, e) {
							return e >= t.first && e < t.first + t.size;
						}
						function Jt(t, e) {
							return String(t.lineNumberFormatter(e + t.firstLineNumber));
						}
						function te(t, e, n) {
							if ((void 0 === n && (n = null), !(this instanceof te)))
								return new te(t, e, n);
							(this.line = t), (this.ch = e), (this.sticky = n);
						}
						function ee(t, e) {
							return t.line - e.line || t.ch - e.ch;
						}
						function ne(t, e) {
							return t.sticky == e.sticky && 0 == ee(t, e);
						}
						function ie(t) {
							return te(t.line, t.ch);
						}
						function re(t, e) {
							return ee(t, e) < 0 ? e : t;
						}
						function oe(t, e) {
							return ee(t, e) < 0 ? t : e;
						}
						function se(t, e) {
							return Math.max(t.first, Math.min(e, t.first + t.size - 1));
						}
						function ae(t, e) {
							if (e.line < t.first) return te(t.first, 0);
							var n = t.first + t.size - 1;
							return e.line > n
								? te(n, qt(t, n).text.length)
								: (function (t, e) {
										var n = t.ch;
										return null == n || n > e
											? te(t.line, e)
											: n < 0
											? te(t.line, 0)
											: t;
								  })(e, qt(t, e.line).text.length);
						}
						function le(t, e) {
							for (var n = [], i = 0; i < e.length; i++) n[i] = ae(t, e[i]);
							return n;
						}
						(Gt.prototype.eol = function () {
							return this.pos >= this.string.length;
						}),
							(Gt.prototype.sol = function () {
								return this.pos == this.lineStart;
							}),
							(Gt.prototype.peek = function () {
								return this.string.charAt(this.pos) || void 0;
							}),
							(Gt.prototype.next = function () {
								if (this.pos < this.string.length)
									return this.string.charAt(this.pos++);
							}),
							(Gt.prototype.eat = function (t) {
								var e = this.string.charAt(this.pos);
								if (
									"string" == typeof t
										? e == t
										: e && (t.test ? t.test(e) : t(e))
								)
									return ++this.pos, e;
							}),
							(Gt.prototype.eatWhile = function (t) {
								for (var e = this.pos; this.eat(t); );
								return this.pos > e;
							}),
							(Gt.prototype.eatSpace = function () {
								for (
									var t = this.pos;
									/[\s\u00a0]/.test(this.string.charAt(this.pos));

								)
									++this.pos;
								return this.pos > t;
							}),
							(Gt.prototype.skipToEnd = function () {
								this.pos = this.string.length;
							}),
							(Gt.prototype.skipTo = function (t) {
								var e = this.string.indexOf(t, this.pos);
								if (e > -1) return (this.pos = e), !0;
							}),
							(Gt.prototype.backUp = function (t) {
								this.pos -= t;
							}),
							(Gt.prototype.column = function () {
								return (
									this.lastColumnPos < this.start &&
										((this.lastColumnValue = F(
											this.string,
											this.start,
											this.tabSize,
											this.lastColumnPos,
											this.lastColumnValue
										)),
										(this.lastColumnPos = this.start)),
									this.lastColumnValue -
										(this.lineStart
											? F(this.string, this.lineStart, this.tabSize)
											: 0)
								);
							}),
							(Gt.prototype.indentation = function () {
								return (
									F(this.string, null, this.tabSize) -
									(this.lineStart
										? F(this.string, this.lineStart, this.tabSize)
										: 0)
								);
							}),
							(Gt.prototype.match = function (t, e, n) {
								if ("string" != typeof t) {
									var i = this.string.slice(this.pos).match(t);
									return i && i.index > 0
										? null
										: (i && !1 !== e && (this.pos += i[0].length), i);
								}
								var r = function (t) {
									return n ? t.toLowerCase() : t;
								};
								if (r(this.string.substr(this.pos, t.length)) == r(t))
									return !1 !== e && (this.pos += t.length), !0;
							}),
							(Gt.prototype.current = function () {
								return this.string.slice(this.start, this.pos);
							}),
							(Gt.prototype.hideFirstChars = function (t, e) {
								this.lineStart += t;
								try {
									return e();
								} finally {
									this.lineStart -= t;
								}
							}),
							(Gt.prototype.lookAhead = function (t) {
								var e = this.lineOracle;
								return e && e.lookAhead(t);
							}),
							(Gt.prototype.baseToken = function () {
								var t = this.lineOracle;
								return t && t.baseToken(this.pos);
							});
						var ce = function (t, e) {
								(this.state = t), (this.lookAhead = e);
							},
							he = function (t, e, n, i) {
								(this.state = e),
									(this.doc = t),
									(this.line = n),
									(this.maxLookAhead = i || 0),
									(this.baseTokens = null),
									(this.baseTokenPos = 1);
							};
						function ue(t, e, n, i) {
							var r = [t.state.modeGen],
								o = {};
							xe(
								t,
								e.text,
								t.doc.mode,
								n,
								function (t, e) {
									return r.push(t, e);
								},
								o,
								i
							);
							for (
								var s = n.state,
									a = function (i) {
										n.baseTokens = r;
										var a = t.state.overlays[i],
											l = 1,
											c = 0;
										(n.state = !0),
											xe(
												t,
												e.text,
												a.mode,
												n,
												function (t, e) {
													for (var n = l; c < t; ) {
														var i = r[l];
														i > t && r.splice(l, 1, t, r[l + 1], i),
															(l += 2),
															(c = Math.min(t, i));
													}
													if (e)
														if (a.opaque)
															r.splice(n, l - n, t, "overlay " + e),
																(l = n + 2);
														else
															for (; n < l; n += 2) {
																var o = r[n + 1];
																r[n + 1] = (o ? o + " " : "") + "overlay " + e;
															}
												},
												o
											),
											(n.state = s),
											(n.baseTokens = null),
											(n.baseTokenPos = 1);
									},
									l = 0;
								l < t.state.overlays.length;
								++l
							)
								a(l);
							return {
								styles: r,
								classes: o.bgClass || o.textClass ? o : null,
							};
						}
						function fe(t, e, n) {
							if (!e.styles || e.styles[0] != t.state.modeGen) {
								var i = de(t, Xt(e)),
									r =
										e.text.length > t.options.maxHighlightLength &&
										zt(t.doc.mode, i.state),
									o = ue(t, e, i);
								r && (i.state = r),
									(e.stateAfter = i.save(!r)),
									(e.styles = o.styles),
									o.classes
										? (e.styleClasses = o.classes)
										: e.styleClasses && (e.styleClasses = null),
									n === t.doc.highlightFrontier &&
										(t.doc.modeFrontier = Math.max(
											t.doc.modeFrontier,
											++t.doc.highlightFrontier
										));
							}
							return e.styles;
						}
						function de(t, e, n) {
							var i = t.doc,
								r = t.display;
							if (!i.mode.startState) return new he(i, !0, e);
							var o = (function (t, e, n) {
									for (
										var i,
											r,
											o = t.doc,
											s = n ? -1 : e - (t.doc.mode.innerMode ? 1e3 : 100),
											a = e;
										a > s;
										--a
									) {
										if (a <= o.first) return o.first;
										var l = qt(o, a - 1),
											c = l.stateAfter;
										if (
											c &&
											(!n ||
												a + (c instanceof ce ? c.lookAhead : 0) <=
													o.modeFrontier)
										)
											return a;
										var h = F(l.text, null, t.options.tabSize);
										(null == r || i > h) && ((r = a - 1), (i = h));
									}
									return r;
								})(t, e, n),
								s = o > i.first && qt(i, o - 1).stateAfter,
								a = s ? he.fromSaved(i, s, o) : new he(i, jt(i.mode), o);
							return (
								i.iter(o, e, function (n) {
									pe(t, n.text, a);
									var i = a.line;
									(n.stateAfter =
										i == e - 1 ||
										i % 5 == 0 ||
										(i >= r.viewFrom && i < r.viewTo)
											? a.save()
											: null),
										a.nextLine();
								}),
								n && (i.modeFrontier = a.line),
								a
							);
						}
						function pe(t, e, n, i) {
							var r = t.doc.mode,
								o = new Gt(e, t.options.tabSize, n);
							for (
								o.start = o.pos = i || 0, "" == e && ge(r, n.state);
								!o.eol();

							)
								me(r, o, n.state), (o.start = o.pos);
						}
						function ge(t, e) {
							if (t.blankLine) return t.blankLine(e);
							if (t.innerMode) {
								var n = Wt(t, e);
								return n.mode.blankLine ? n.mode.blankLine(n.state) : void 0;
							}
						}
						function me(t, e, n, i) {
							for (var r = 0; r < 10; r++) {
								i && (i[0] = Wt(t, n).mode);
								var o = t.token(e, n);
								if (e.pos > e.start) return o;
							}
							throw new Error("Mode " + t.name + " failed to advance stream.");
						}
						(he.prototype.lookAhead = function (t) {
							var e = this.doc.getLine(this.line + t);
							return (
								null != e && t > this.maxLookAhead && (this.maxLookAhead = t), e
							);
						}),
							(he.prototype.baseToken = function (t) {
								if (!this.baseTokens) return null;
								for (; this.baseTokens[this.baseTokenPos] <= t; )
									this.baseTokenPos += 2;
								var e = this.baseTokens[this.baseTokenPos + 1];
								return {
									type: e && e.replace(/( |^)overlay .*/, ""),
									size: this.baseTokens[this.baseTokenPos] - t,
								};
							}),
							(he.prototype.nextLine = function () {
								this.line++, this.maxLookAhead > 0 && this.maxLookAhead--;
							}),
							(he.fromSaved = function (t, e, n) {
								return e instanceof ce
									? new he(t, zt(t.mode, e.state), n, e.lookAhead)
									: new he(t, zt(t.mode, e), n);
							}),
							(he.prototype.save = function (t) {
								var e = !1 !== t ? zt(this.doc.mode, this.state) : this.state;
								return this.maxLookAhead > 0 ? new ce(e, this.maxLookAhead) : e;
							});
						var ve = function (t, e, n) {
							(this.start = t.start),
								(this.end = t.pos),
								(this.string = t.current()),
								(this.type = e || null),
								(this.state = n);
						};
						function _e(t, e, n, i) {
							var r,
								o,
								s = t.doc,
								a = s.mode,
								l = qt(s, (e = ae(s, e)).line),
								c = de(t, e.line, n),
								h = new Gt(l.text, t.options.tabSize, c);
							for (i && (o = []); (i || h.pos < e.ch) && !h.eol(); )
								(h.start = h.pos),
									(r = me(a, h, c.state)),
									i && o.push(new ve(h, r, zt(s.mode, c.state)));
							return i ? o : new ve(h, r, c.state);
						}
						function ye(t, e) {
							if (t)
								for (;;) {
									var n = t.match(/(?:^|\s+)line-(background-)?(\S+)/);
									if (!n) break;
									t = t.slice(0, n.index) + t.slice(n.index + n[0].length);
									var i = n[1] ? "bgClass" : "textClass";
									null == e[i]
										? (e[i] = n[2])
										: new RegExp("(?:^|\\s)" + n[2] + "(?:$|\\s)").test(e[i]) ||
										  (e[i] += " " + n[2]);
								}
							return t;
						}
						function xe(t, e, n, i, r, o, s) {
							var a = n.flattenSpans;
							null == a && (a = t.options.flattenSpans);
							var l,
								c = 0,
								h = null,
								u = new Gt(e, t.options.tabSize, i),
								f = t.options.addModeClass && [null];
							for ("" == e && ye(ge(n, i.state), o); !u.eol(); ) {
								if (
									(u.pos > t.options.maxHighlightLength
										? ((a = !1),
										  s && pe(t, e, i, u.pos),
										  (u.pos = e.length),
										  (l = null))
										: (l = ye(me(n, u, i.state, f), o)),
									f)
								) {
									var d = f[0].name;
									d && (l = "m-" + (l ? d + " " + l : d));
								}
								if (!a || h != l) {
									for (; c < u.start; ) r((c = Math.min(u.start, c + 5e3)), h);
									h = l;
								}
								u.start = u.pos;
							}
							for (; c < u.pos; ) {
								var p = Math.min(u.pos, c + 5e3);
								r(p, h), (c = p);
							}
						}
						var ke = !1,
							be = !1;
						function Te(t, e, n) {
							(this.marker = t), (this.from = e), (this.to = n);
						}
						function Ce(t, e) {
							if (t)
								for (var n = 0; n < t.length; ++n) {
									var i = t[n];
									if (i.marker == e) return i;
								}
						}
						function we(t, e) {
							for (var n, i = 0; i < t.length; ++i)
								t[i] != e && (n || (n = [])).push(t[i]);
							return n;
						}
						function Ee(t, e) {
							if (e.full) return null;
							var n = Zt(t, e.from.line) && qt(t, e.from.line).markedSpans,
								i = Zt(t, e.to.line) && qt(t, e.to.line).markedSpans;
							if (!n && !i) return null;
							var r = e.from.ch,
								o = e.to.ch,
								s = 0 == ee(e.from, e.to),
								a = (function (t, e, n) {
									var i;
									if (t)
										for (var r = 0; r < t.length; ++r) {
											var o = t[r],
												s = o.marker;
											if (
												null == o.from ||
												(s.inclusiveLeft ? o.from <= e : o.from < e) ||
												(o.from == e &&
													"bookmark" == s.type &&
													(!n || !o.marker.insertLeft))
											) {
												var a =
													null == o.to ||
													(s.inclusiveRight ? o.to >= e : o.to > e);
												(i || (i = [])).push(
													new Te(s, o.from, a ? null : o.to)
												);
											}
										}
									return i;
								})(n, r, s),
								l = (function (t, e, n) {
									var i;
									if (t)
										for (var r = 0; r < t.length; ++r) {
											var o = t[r],
												s = o.marker;
											if (
												null == o.to ||
												(s.inclusiveRight ? o.to >= e : o.to > e) ||
												(o.from == e &&
													"bookmark" == s.type &&
													(!n || o.marker.insertLeft))
											) {
												var a =
													null == o.from ||
													(s.inclusiveLeft ? o.from <= e : o.from < e);
												(i || (i = [])).push(
													new Te(
														s,
														a ? null : o.from - e,
														null == o.to ? null : o.to - e
													)
												);
											}
										}
									return i;
								})(i, o, s),
								c = 1 == e.text.length,
								h = Y(e.text).length + (c ? r : 0);
							if (a)
								for (var u = 0; u < a.length; ++u) {
									var f = a[u];
									if (null == f.to) {
										var d = Ce(l, f.marker);
										d
											? c && (f.to = null == d.to ? null : d.to + h)
											: (f.to = r);
									}
								}
							if (l)
								for (var p = 0; p < l.length; ++p) {
									var g = l[p];
									null != g.to && (g.to += h),
										null == g.from
											? Ce(a, g.marker) ||
											  ((g.from = h), c && (a || (a = [])).push(g))
											: ((g.from += h), c && (a || (a = [])).push(g));
								}
							a && (a = Se(a)), l && l != a && (l = Se(l));
							var m = [a];
							if (!c) {
								var v,
									_ = e.text.length - 2;
								if (_ > 0 && a)
									for (var y = 0; y < a.length; ++y)
										null == a[y].to &&
											(v || (v = [])).push(new Te(a[y].marker, null, null));
								for (var x = 0; x < _; ++x) m.push(v);
								m.push(l);
							}
							return m;
						}
						function Se(t) {
							for (var e = 0; e < t.length; ++e) {
								var n = t[e];
								null != n.from &&
									n.from == n.to &&
									!1 !== n.marker.clearWhenEmpty &&
									t.splice(e--, 1);
							}
							return t.length ? t : null;
						}
						function Ae(t) {
							var e = t.markedSpans;
							if (e) {
								for (var n = 0; n < e.length; ++n) e[n].marker.detachLine(t);
								t.markedSpans = null;
							}
						}
						function Le(t, e) {
							if (e) {
								for (var n = 0; n < e.length; ++n) e[n].marker.attachLine(t);
								t.markedSpans = e;
							}
						}
						function Oe(t) {
							return t.inclusiveLeft ? -1 : 0;
						}
						function Ne(t) {
							return t.inclusiveRight ? 1 : 0;
						}
						function Ie(t, e) {
							var n = t.lines.length - e.lines.length;
							if (0 != n) return n;
							var i = t.find(),
								r = e.find(),
								o = ee(i.from, r.from) || Oe(t) - Oe(e);
							if (o) return -o;
							var s = ee(i.to, r.to) || Ne(t) - Ne(e);
							return s || e.id - t.id;
						}
						function Me(t, e) {
							var n,
								i = be && t.markedSpans;
							if (i)
								for (var r = void 0, o = 0; o < i.length; ++o)
									(r = i[o]).marker.collapsed &&
										null == (e ? r.from : r.to) &&
										(!n || Ie(n, r.marker) < 0) &&
										(n = r.marker);
							return n;
						}
						function $e(t) {
							return Me(t, !0);
						}
						function Re(t) {
							return Me(t, !1);
						}
						function De(t, e) {
							var n,
								i = be && t.markedSpans;
							if (i)
								for (var r = 0; r < i.length; ++r) {
									var o = i[r];
									o.marker.collapsed &&
										(null == o.from || o.from < e) &&
										(null == o.to || o.to > e) &&
										(!n || Ie(n, o.marker) < 0) &&
										(n = o.marker);
								}
							return n;
						}
						function Pe(t, e, n, i, r) {
							var o = qt(t, e),
								s = be && o.markedSpans;
							if (s)
								for (var a = 0; a < s.length; ++a) {
									var l = s[a];
									if (l.marker.collapsed) {
										var c = l.marker.find(0),
											h = ee(c.from, n) || Oe(l.marker) - Oe(r),
											u = ee(c.to, i) || Ne(l.marker) - Ne(r);
										if (
											!((h >= 0 && u <= 0) || (h <= 0 && u >= 0)) &&
											((h <= 0 &&
												(l.marker.inclusiveRight && r.inclusiveLeft
													? ee(c.to, n) >= 0
													: ee(c.to, n) > 0)) ||
												(h >= 0 &&
													(l.marker.inclusiveRight && r.inclusiveLeft
														? ee(c.from, i) <= 0
														: ee(c.from, i) < 0)))
										)
											return !0;
									}
								}
						}
						function Fe(t) {
							for (var e; (e = $e(t)); ) t = e.find(-1, !0).line;
							return t;
						}
						function Be(t, e) {
							var n = qt(t, e),
								i = Fe(n);
							return n == i ? e : Xt(i);
						}
						function Ue(t, e) {
							if (e > t.lastLine()) return e;
							var n,
								i = qt(t, e);
							if (!He(t, i)) return e;
							for (; (n = Re(i)); ) i = n.find(1, !0).line;
							return Xt(i) + 1;
						}
						function He(t, e) {
							var n = be && e.markedSpans;
							if (n)
								for (var i = void 0, r = 0; r < n.length; ++r)
									if ((i = n[r]).marker.collapsed) {
										if (null == i.from) return !0;
										if (
											!i.marker.widgetNode &&
											0 == i.from &&
											i.marker.inclusiveLeft &&
											ze(t, e, i)
										)
											return !0;
									}
						}
						function ze(t, e, n) {
							if (null == n.to) {
								var i = n.marker.find(1, !0);
								return ze(t, i.line, Ce(i.line.markedSpans, n.marker));
							}
							if (n.marker.inclusiveRight && n.to == e.text.length) return !0;
							for (var r = void 0, o = 0; o < e.markedSpans.length; ++o)
								if (
									(r = e.markedSpans[o]).marker.collapsed &&
									!r.marker.widgetNode &&
									r.from == n.to &&
									(null == r.to || r.to != n.from) &&
									(r.marker.inclusiveLeft || n.marker.inclusiveRight) &&
									ze(t, e, r)
								)
									return !0;
						}
						function We(t) {
							for (
								var e = 0, n = (t = Fe(t)).parent, i = 0;
								i < n.lines.length;
								++i
							) {
								var r = n.lines[i];
								if (r == t) break;
								e += r.height;
							}
							for (var o = n.parent; o; o = (n = o).parent)
								for (var s = 0; s < o.children.length; ++s) {
									var a = o.children[s];
									if (a == n) break;
									e += a.height;
								}
							return e;
						}
						function je(t) {
							if (0 == t.height) return 0;
							for (var e, n = t.text.length, i = t; (e = $e(i)); ) {
								var r = e.find(0, !0);
								(i = r.from.line), (n += r.from.ch - r.to.ch);
							}
							for (i = t; (e = Re(i)); ) {
								var o = e.find(0, !0);
								(n -= i.text.length - o.from.ch),
									(n += (i = o.to.line).text.length - o.to.ch);
							}
							return n;
						}
						function Ge(t) {
							var e = t.display,
								n = t.doc;
							(e.maxLine = qt(n, n.first)),
								(e.maxLineLength = je(e.maxLine)),
								(e.maxLineChanged = !0),
								n.iter(function (t) {
									var n = je(t);
									n > e.maxLineLength &&
										((e.maxLineLength = n), (e.maxLine = t));
								});
						}
						var qe = function (t, e, n) {
							(this.text = t), Le(this, e), (this.height = n ? n(this) : 1);
						};
						function Ve(t) {
							(t.parent = null), Ae(t);
						}
						(qe.prototype.lineNo = function () {
							return Xt(this);
						}),
							_t(qe);
						var Ye = {},
							Ke = {};
						function Xe(t, e) {
							if (!t || /^\s*$/.test(t)) return null;
							var n = e.addModeClass ? Ke : Ye;
							return n[t] || (n[t] = t.replace(/\S+/g, "cm-$&"));
						}
						function Qe(t, e) {
							var n = O("span", null, null, l ? "padding-right: .1px" : null),
								i = {
									pre: O("pre", [n], "CodeMirror-line"),
									content: n,
									col: 0,
									pos: 0,
									cm: t,
									trailingSpace: !1,
									splitSpaces: t.getOption("lineWrapping"),
								};
							e.measure = {};
							for (var r = 0; r <= (e.rest ? e.rest.length : 0); r++) {
								var o = r ? e.rest[r - 1] : e.line,
									s = void 0;
								(i.pos = 0),
									(i.addToken = Je),
									Lt(t.display.measure) &&
										(s = ct(o, t.doc.direction)) &&
										(i.addToken = tn(i.addToken, s)),
									(i.map = []),
									nn(o, i, fe(t, o, e != t.display.externalMeasured && Xt(o))),
									o.styleClasses &&
										(o.styleClasses.bgClass &&
											(i.bgClass = $(o.styleClasses.bgClass, i.bgClass || "")),
										o.styleClasses.textClass &&
											(i.textClass = $(
												o.styleClasses.textClass,
												i.textClass || ""
											))),
									0 == i.map.length &&
										i.map.push(
											0,
											0,
											i.content.appendChild(At(t.display.measure))
										),
									0 == r
										? ((e.measure.map = i.map), (e.measure.cache = {}))
										: ((e.measure.maps || (e.measure.maps = [])).push(i.map),
										  (e.measure.caches || (e.measure.caches = [])).push({}));
							}
							if (l) {
								var a = i.content.lastChild;
								(/\bcm-tab\b/.test(a.className) ||
									(a.querySelector && a.querySelector(".cm-tab"))) &&
									(i.content.className = "cm-tab-wrap-hack");
							}
							return (
								pt(t, "renderLine", t, e.line, i.pre),
								i.pre.className &&
									(i.textClass = $(i.pre.className, i.textClass || "")),
								i
							);
						}
						function Ze(t) {
							var e = L("span", "•", "cm-invalidchar");
							return (
								(e.title = "\\u" + t.charCodeAt(0).toString(16)),
								e.setAttribute("aria-label", e.title),
								e
							);
						}
						function Je(t, e, n, i, r, o, l) {
							if (e) {
								var c,
									h = t.splitSpaces
										? (function (t, e) {
												if (t.length > 1 && !/  /.test(t)) return t;
												for (var n = e, i = "", r = 0; r < t.length; r++) {
													var o = t.charAt(r);
													" " != o ||
														!n ||
														(r != t.length - 1 && 32 != t.charCodeAt(r + 1)) ||
														(o = " "),
														(i += o),
														(n = " " == o);
												}
												return i;
										  })(e, t.trailingSpace)
										: e,
									u = t.cm.state.specialChars,
									f = !1;
								if (u.test(e)) {
									c = document.createDocumentFragment();
									for (var d = 0; ; ) {
										u.lastIndex = d;
										var p = u.exec(e),
											g = p ? p.index - d : e.length - d;
										if (g) {
											var m = document.createTextNode(h.slice(d, d + g));
											s && a < 9
												? c.appendChild(L("span", [m]))
												: c.appendChild(m),
												t.map.push(t.pos, t.pos + g, m),
												(t.col += g),
												(t.pos += g);
										}
										if (!p) break;
										d += g + 1;
										var v = void 0;
										if ("\t" == p[0]) {
											var _ = t.cm.options.tabSize,
												y = _ - (t.col % _);
											(v = c.appendChild(
												L("span", V(y), "cm-tab")
											)).setAttribute("role", "presentation"),
												v.setAttribute("cm-text", "\t"),
												(t.col += y);
										} else
											"\r" == p[0] || "\n" == p[0]
												? ((v = c.appendChild(
														L(
															"span",
															"\r" == p[0] ? "␍" : "␤",
															"cm-invalidchar"
														)
												  )).setAttribute("cm-text", p[0]),
												  (t.col += 1))
												: ((v = t.cm.options.specialCharPlaceholder(
														p[0]
												  )).setAttribute("cm-text", p[0]),
												  s && a < 9
														? c.appendChild(L("span", [v]))
														: c.appendChild(v),
												  (t.col += 1));
										t.map.push(t.pos, t.pos + 1, v), t.pos++;
									}
								} else
									(t.col += e.length),
										(c = document.createTextNode(h)),
										t.map.push(t.pos, t.pos + e.length, c),
										s && a < 9 && (f = !0),
										(t.pos += e.length);
								if (
									((t.trailingSpace = 32 == h.charCodeAt(e.length - 1)),
									n || i || r || f || o || l)
								) {
									var x = n || "";
									i && (x += i), r && (x += r);
									var k = L("span", [c], x, o);
									if (l)
										for (var b in l)
											l.hasOwnProperty(b) &&
												"style" != b &&
												"class" != b &&
												k.setAttribute(b, l[b]);
									return t.content.appendChild(k);
								}
								t.content.appendChild(c);
							}
						}
						function tn(t, e) {
							return function (n, i, r, o, s, a, l) {
								r = r ? r + " cm-force-border" : "cm-force-border";
								for (var c = n.pos, h = c + i.length; ; ) {
									for (
										var u = void 0, f = 0;
										f < e.length && !((u = e[f]).to > c && u.from <= c);
										f++
									);
									if (u.to >= h) return t(n, i, r, o, s, a, l);
									t(n, i.slice(0, u.to - c), r, o, null, a, l),
										(o = null),
										(i = i.slice(u.to - c)),
										(c = u.to);
								}
							};
						}
						function en(t, e, n, i) {
							var r = !i && n.widgetNode;
							r && t.map.push(t.pos, t.pos + e, r),
								!i &&
									t.cm.display.input.needsContentAttribute &&
									(r ||
										(r = t.content.appendChild(document.createElement("span"))),
									r.setAttribute("cm-marker", n.id)),
								r &&
									(t.cm.display.input.setUneditable(r),
									t.content.appendChild(r)),
								(t.pos += e),
								(t.trailingSpace = !1);
						}
						function nn(t, e, n) {
							var i = t.markedSpans,
								r = t.text,
								o = 0;
							if (i)
								for (
									var s,
										a,
										l,
										c,
										h,
										u,
										f,
										d = r.length,
										p = 0,
										g = 1,
										m = "",
										v = 0;
									;

								) {
									if (v == p) {
										(l = c = h = a = ""), (f = null), (u = null), (v = 1 / 0);
										for (var _ = [], y = void 0, x = 0; x < i.length; ++x) {
											var k = i[x],
												b = k.marker;
											if ("bookmark" == b.type && k.from == p && b.widgetNode)
												_.push(b);
											else if (
												k.from <= p &&
												(null == k.to ||
													k.to > p ||
													(b.collapsed && k.to == p && k.from == p))
											) {
												if (
													(null != k.to &&
														k.to != p &&
														v > k.to &&
														((v = k.to), (c = "")),
													b.className && (l += " " + b.className),
													b.css && (a = (a ? a + ";" : "") + b.css),
													b.startStyle &&
														k.from == p &&
														(h += " " + b.startStyle),
													b.endStyle &&
														k.to == v &&
														(y || (y = [])).push(b.endStyle, k.to),
													b.title && ((f || (f = {})).title = b.title),
													b.attributes)
												)
													for (var T in b.attributes)
														(f || (f = {}))[T] = b.attributes[T];
												b.collapsed && (!u || Ie(u.marker, b) < 0) && (u = k);
											} else k.from > p && v > k.from && (v = k.from);
										}
										if (y)
											for (var C = 0; C < y.length; C += 2)
												y[C + 1] == v && (c += " " + y[C]);
										if (!u || u.from == p)
											for (var w = 0; w < _.length; ++w) en(e, 0, _[w]);
										if (u && (u.from || 0) == p) {
											if (
												(en(
													e,
													(null == u.to ? d + 1 : u.to) - p,
													u.marker,
													null == u.from
												),
												null == u.to)
											)
												return;
											u.to == p && (u = !1);
										}
									}
									if (p >= d) break;
									for (var E = Math.min(d, v); ; ) {
										if (m) {
											var S = p + m.length;
											if (!u) {
												var A = S > E ? m.slice(0, E - p) : m;
												e.addToken(
													e,
													A,
													s ? s + l : l,
													h,
													p + A.length == v ? c : "",
													a,
													f
												);
											}
											if (S >= E) {
												(m = m.slice(E - p)), (p = E);
												break;
											}
											(p = S), (h = "");
										}
										(m = r.slice(o, (o = n[g++]))),
											(s = Xe(n[g++], e.cm.options));
									}
								}
							else
								for (var L = 1; L < n.length; L += 2)
									e.addToken(
										e,
										r.slice(o, (o = n[L])),
										Xe(n[L + 1], e.cm.options)
									);
						}
						function rn(t, e, n) {
							(this.line = e),
								(this.rest = (function (t) {
									for (var e, n; (e = Re(t)); )
										(t = e.find(1, !0).line), (n || (n = [])).push(t);
									return n;
								})(e)),
								(this.size = this.rest ? Xt(Y(this.rest)) - n + 1 : 1),
								(this.node = this.text = null),
								(this.hidden = He(t, e));
						}
						function on(t, e, n) {
							for (var i, r = [], o = e; o < n; o = i) {
								var s = new rn(t.doc, qt(t.doc, o), o);
								(i = o + s.size), r.push(s);
							}
							return r;
						}
						var sn = null,
							an = null;
						function ln(t, e) {
							var n = ft(t, e);
							if (n.length) {
								var i,
									r = Array.prototype.slice.call(arguments, 2);
								sn
									? (i = sn.delayedCallbacks)
									: an
									? (i = an)
									: ((i = an = []), setTimeout(cn, 0));
								for (
									var o = function (t) {
											i.push(function () {
												return n[t].apply(null, r);
											});
										},
										s = 0;
									s < n.length;
									++s
								)
									o(s);
							}
						}
						function cn() {
							var t = an;
							an = null;
							for (var e = 0; e < t.length; ++e) t[e]();
						}
						function hn(t, e, n, i) {
							for (var r = 0; r < e.changes.length; r++) {
								var o = e.changes[r];
								"text" == o
									? dn(t, e)
									: "gutter" == o
									? gn(t, e, n, i)
									: "class" == o
									? pn(t, e)
									: "widget" == o && mn(t, e, i);
							}
							e.changes = null;
						}
						function un(t) {
							return (
								t.node == t.text &&
									((t.node = L("div", null, null, "position: relative")),
									t.text.parentNode &&
										t.text.parentNode.replaceChild(t.node, t.text),
									t.node.appendChild(t.text),
									s && a < 8 && (t.node.style.zIndex = 2)),
								t.node
							);
						}
						function fn(t, e) {
							var n = t.display.externalMeasured;
							return n && n.line == e.line
								? ((t.display.externalMeasured = null),
								  (e.measure = n.measure),
								  n.built)
								: Qe(t, e);
						}
						function dn(t, e) {
							var n = e.text.className,
								i = fn(t, e);
							e.text == e.node && (e.node = i.pre),
								e.text.parentNode.replaceChild(i.pre, e.text),
								(e.text = i.pre),
								i.bgClass != e.bgClass || i.textClass != e.textClass
									? ((e.bgClass = i.bgClass),
									  (e.textClass = i.textClass),
									  pn(t, e))
									: n && (e.text.className = n);
						}
						function pn(t, e) {
							!(function (t, e) {
								var n = e.bgClass
									? e.bgClass + " " + (e.line.bgClass || "")
									: e.line.bgClass;
								if ((n && (n += " CodeMirror-linebackground"), e.background))
									n
										? (e.background.className = n)
										: (e.background.parentNode.removeChild(e.background),
										  (e.background = null));
								else if (n) {
									var i = un(e);
									(e.background = i.insertBefore(
										L("div", null, n),
										i.firstChild
									)),
										t.display.input.setUneditable(e.background);
								}
							})(t, e),
								e.line.wrapClass
									? (un(e).className = e.line.wrapClass)
									: e.node != e.text && (e.node.className = "");
							var n = e.textClass
								? e.textClass + " " + (e.line.textClass || "")
								: e.line.textClass;
							e.text.className = n || "";
						}
						function gn(t, e, n, i) {
							if (
								(e.gutter && (e.node.removeChild(e.gutter), (e.gutter = null)),
								e.gutterBackground &&
									(e.node.removeChild(e.gutterBackground),
									(e.gutterBackground = null)),
								e.line.gutterClass)
							) {
								var r = un(e);
								(e.gutterBackground = L(
									"div",
									null,
									"CodeMirror-gutter-background " + e.line.gutterClass,
									"left: " +
										(t.options.fixedGutter ? i.fixedPos : -i.gutterTotalWidth) +
										"px; width: " +
										i.gutterTotalWidth +
										"px"
								)),
									t.display.input.setUneditable(e.gutterBackground),
									r.insertBefore(e.gutterBackground, e.text);
							}
							var o = e.line.gutterMarkers;
							if (t.options.lineNumbers || o) {
								var s = un(e),
									a = (e.gutter = L(
										"div",
										null,
										"CodeMirror-gutter-wrapper",
										"left: " +
											(t.options.fixedGutter
												? i.fixedPos
												: -i.gutterTotalWidth) +
											"px"
									));
								if (
									(a.setAttribute("aria-hidden", "true"),
									t.display.input.setUneditable(a),
									s.insertBefore(a, e.text),
									e.line.gutterClass &&
										(a.className += " " + e.line.gutterClass),
									!t.options.lineNumbers ||
										(o && o["CodeMirror-linenumbers"]) ||
										(e.lineNumber = a.appendChild(
											L(
												"div",
												Jt(t.options, n),
												"CodeMirror-linenumber CodeMirror-gutter-elt",
												"left: " +
													i.gutterLeft["CodeMirror-linenumbers"] +
													"px; width: " +
													t.display.lineNumInnerWidth +
													"px"
											)
										)),
									o)
								)
									for (var l = 0; l < t.display.gutterSpecs.length; ++l) {
										var c = t.display.gutterSpecs[l].className,
											h = o.hasOwnProperty(c) && o[c];
										h &&
											a.appendChild(
												L(
													"div",
													[h],
													"CodeMirror-gutter-elt",
													"left: " +
														i.gutterLeft[c] +
														"px; width: " +
														i.gutterWidth[c] +
														"px"
												)
											);
									}
							}
						}
						function mn(t, e, n) {
							e.alignable && (e.alignable = null);
							for (
								var i = C("CodeMirror-linewidget"),
									r = e.node.firstChild,
									o = void 0;
								r;
								r = o
							)
								(o = r.nextSibling),
									i.test(r.className) && e.node.removeChild(r);
							_n(t, e, n);
						}
						function vn(t, e, n, i) {
							var r = fn(t, e);
							return (
								(e.text = e.node = r.pre),
								r.bgClass && (e.bgClass = r.bgClass),
								r.textClass && (e.textClass = r.textClass),
								pn(t, e),
								gn(t, e, n, i),
								_n(t, e, i),
								e.node
							);
						}
						function _n(t, e, n) {
							if ((yn(t, e.line, e, n, !0), e.rest))
								for (var i = 0; i < e.rest.length; i++)
									yn(t, e.rest[i], e, n, !1);
						}
						function yn(t, e, n, i, r) {
							if (e.widgets)
								for (var o = un(n), s = 0, a = e.widgets; s < a.length; ++s) {
									var l = a[s],
										c = L(
											"div",
											[l.node],
											"CodeMirror-linewidget" +
												(l.className ? " " + l.className : "")
										);
									l.handleMouseEvents ||
										c.setAttribute("cm-ignore-events", "true"),
										xn(l, c, n, i),
										t.display.input.setUneditable(c),
										r && l.above
											? o.insertBefore(c, n.gutter || n.text)
											: o.appendChild(c),
										ln(l, "redraw");
								}
						}
						function xn(t, e, n, i) {
							if (t.noHScroll) {
								(n.alignable || (n.alignable = [])).push(e);
								var r = i.wrapperWidth;
								(e.style.left = i.fixedPos + "px"),
									t.coverGutter ||
										((r -= i.gutterTotalWidth),
										(e.style.paddingLeft = i.gutterTotalWidth + "px")),
									(e.style.width = r + "px");
							}
							t.coverGutter &&
								((e.style.zIndex = 5),
								(e.style.position = "relative"),
								t.noHScroll ||
									(e.style.marginLeft = -i.gutterTotalWidth + "px"));
						}
						function kn(t) {
							if (null != t.height) return t.height;
							var e = t.doc.cm;
							if (!e) return 0;
							if (!N(document.body, t.node)) {
								var n = "position: relative;";
								t.coverGutter &&
									(n +=
										"margin-left: -" + e.display.gutters.offsetWidth + "px;"),
									t.noHScroll &&
										(n += "width: " + e.display.wrapper.clientWidth + "px;"),
									A(e.display.measure, L("div", [t.node], null, n));
							}
							return (t.height = t.node.parentNode.offsetHeight);
						}
						function bn(t, e) {
							for (var n = Tt(e); n != t.wrapper; n = n.parentNode)
								if (
									!n ||
									(1 == n.nodeType &&
										"true" == n.getAttribute("cm-ignore-events")) ||
									(n.parentNode == t.sizer && n != t.mover)
								)
									return !0;
						}
						function Tn(t) {
							return t.lineSpace.offsetTop;
						}
						function Cn(t) {
							return t.mover.offsetHeight - t.lineSpace.offsetHeight;
						}
						function wn(t) {
							if (t.cachedPaddingH) return t.cachedPaddingH;
							var e = A(t.measure, L("pre", "x", "CodeMirror-line-like")),
								n = window.getComputedStyle
									? window.getComputedStyle(e)
									: e.currentStyle,
								i = {
									left: parseInt(n.paddingLeft),
									right: parseInt(n.paddingRight),
								};
							return (
								isNaN(i.left) || isNaN(i.right) || (t.cachedPaddingH = i), i
							);
						}
						function En(t) {
							return 50 - t.display.nativeBarWidth;
						}
						function Sn(t) {
							return (
								t.display.scroller.clientWidth - En(t) - t.display.barWidth
							);
						}
						function An(t) {
							return (
								t.display.scroller.clientHeight - En(t) - t.display.barHeight
							);
						}
						function Ln(t, e, n) {
							if (t.line == e)
								return { map: t.measure.map, cache: t.measure.cache };
							for (var i = 0; i < t.rest.length; i++)
								if (t.rest[i] == e)
									return { map: t.measure.maps[i], cache: t.measure.caches[i] };
							for (var r = 0; r < t.rest.length; r++)
								if (Xt(t.rest[r]) > n)
									return {
										map: t.measure.maps[r],
										cache: t.measure.caches[r],
										before: !0,
									};
						}
						function On(t, e, n, i) {
							return Mn(t, In(t, e), n, i);
						}
						function Nn(t, e) {
							if (e >= t.display.viewFrom && e < t.display.viewTo)
								return t.display.view[hi(t, e)];
							var n = t.display.externalMeasured;
							return n && e >= n.lineN && e < n.lineN + n.size ? n : void 0;
						}
						function In(t, e) {
							var n = Xt(e),
								i = Nn(t, n);
							i && !i.text
								? (i = null)
								: i &&
								  i.changes &&
								  (hn(t, i, n, oi(t)), (t.curOp.forceUpdate = !0)),
								i ||
									(i = (function (t, e) {
										var n = Xt((e = Fe(e))),
											i = (t.display.externalMeasured = new rn(t.doc, e, n));
										i.lineN = n;
										var r = (i.built = Qe(t, i));
										return (i.text = r.pre), A(t.display.lineMeasure, r.pre), i;
									})(t, e));
							var r = Ln(i, e, n);
							return {
								line: e,
								view: i,
								rect: null,
								map: r.map,
								cache: r.cache,
								before: r.before,
								hasHeights: !1,
							};
						}
						function Mn(t, e, n, i, r) {
							e.before && (n = -1);
							var o,
								l = n + (i || "");
							return (
								e.cache.hasOwnProperty(l)
									? (o = e.cache[l])
									: (e.rect || (e.rect = e.view.text.getBoundingClientRect()),
									  e.hasHeights ||
											((function (t, e, n) {
												var i = t.options.lineWrapping,
													r = i && Sn(t);
												if (!e.measure.heights || (i && e.measure.width != r)) {
													var o = (e.measure.heights = []);
													if (i) {
														e.measure.width = r;
														for (
															var s = e.text.firstChild.getClientRects(), a = 0;
															a < s.length - 1;
															a++
														) {
															var l = s[a],
																c = s[a + 1];
															Math.abs(l.bottom - c.bottom) > 2 &&
																o.push((l.bottom + c.top) / 2 - n.top);
														}
													}
													o.push(n.bottom - n.top);
												}
											})(t, e.view, e.rect),
											(e.hasHeights = !0)),
									  (o = (function (t, e, n, i) {
											var r,
												o = Dn(e.map, n, i),
												l = o.node,
												c = o.start,
												h = o.end,
												u = o.collapse;
											if (3 == l.nodeType) {
												for (var f = 0; f < 4; f++) {
													for (
														;
														c && it(e.line.text.charAt(o.coverStart + c));

													)
														--c;
													for (
														;
														o.coverStart + h < o.coverEnd &&
														it(e.line.text.charAt(o.coverStart + h));

													)
														++h;
													if (
														(r =
															s &&
															a < 9 &&
															0 == c &&
															h == o.coverEnd - o.coverStart
																? l.parentNode.getBoundingClientRect()
																: Pn(w(l, c, h).getClientRects(), i)).left ||
														r.right ||
														0 == c
													)
														break;
													(h = c), (c -= 1), (u = "right");
												}
												s &&
													a < 11 &&
													(r = (function (t, e) {
														if (
															!window.screen ||
															null == screen.logicalXDPI ||
															screen.logicalXDPI == screen.deviceXDPI ||
															!(function (t) {
																if (null != $t) return $t;
																var e = A(t, L("span", "x")),
																	n = e.getBoundingClientRect(),
																	i = w(e, 0, 1).getBoundingClientRect();
																return ($t = Math.abs(n.left - i.left) > 1);
															})(t)
														)
															return e;
														var n = screen.logicalXDPI / screen.deviceXDPI,
															i = screen.logicalYDPI / screen.deviceYDPI;
														return {
															left: e.left * n,
															right: e.right * n,
															top: e.top * i,
															bottom: e.bottom * i,
														};
													})(t.display.measure, r));
											} else {
												var d;
												c > 0 && (u = i = "right"),
													(r =
														t.options.lineWrapping &&
														(d = l.getClientRects()).length > 1
															? d["right" == i ? d.length - 1 : 0]
															: l.getBoundingClientRect());
											}
											if (s && a < 9 && !c && (!r || (!r.left && !r.right))) {
												var p = l.parentNode.getClientRects()[0];
												r = p
													? {
															left: p.left,
															right: p.left + ri(t.display),
															top: p.top,
															bottom: p.bottom,
													  }
													: Rn;
											}
											for (
												var g = r.top - e.rect.top,
													m = r.bottom - e.rect.top,
													v = (g + m) / 2,
													_ = e.view.measure.heights,
													y = 0;
												y < _.length - 1 && !(v < _[y]);
												y++
											);
											var x = y ? _[y - 1] : 0,
												k = _[y],
												b = {
													left: ("right" == u ? r.right : r.left) - e.rect.left,
													right: ("left" == u ? r.left : r.right) - e.rect.left,
													top: x,
													bottom: k,
												};
											return (
												r.left || r.right || (b.bogus = !0),
												t.options.singleCursorHeightPerLine ||
													((b.rtop = g), (b.rbottom = m)),
												b
											);
									  })(t, e, n, i)).bogus || (e.cache[l] = o)),
								{
									left: o.left,
									right: o.right,
									top: r ? o.rtop : o.top,
									bottom: r ? o.rbottom : o.bottom,
								}
							);
						}
						var $n,
							Rn = { left: 0, right: 0, top: 0, bottom: 0 };
						function Dn(t, e, n) {
							for (var i, r, o, s, a, l, c = 0; c < t.length; c += 3)
								if (
									((a = t[c]),
									(l = t[c + 1]),
									e < a
										? ((r = 0), (o = 1), (s = "left"))
										: e < l
										? (o = 1 + (r = e - a))
										: (c == t.length - 3 || (e == l && t[c + 3] > e)) &&
										  ((r = (o = l - a) - 1), e >= l && (s = "right")),
									null != r)
								) {
									if (
										((i = t[c + 2]),
										a == l && n == (i.insertLeft ? "left" : "right") && (s = n),
										"left" == n && 0 == r)
									)
										for (; c && t[c - 2] == t[c - 3] && t[c - 1].insertLeft; )
											(i = t[2 + (c -= 3)]), (s = "left");
									if ("right" == n && r == l - a)
										for (
											;
											c < t.length - 3 &&
											t[c + 3] == t[c + 4] &&
											!t[c + 5].insertLeft;

										)
											(i = t[(c += 3) + 2]), (s = "right");
									break;
								}
							return {
								node: i,
								start: r,
								end: o,
								collapse: s,
								coverStart: a,
								coverEnd: l,
							};
						}
						function Pn(t, e) {
							var n = Rn;
							if ("left" == e)
								for (
									var i = 0;
									i < t.length && (n = t[i]).left == n.right;
									i++
								);
							else
								for (
									var r = t.length - 1;
									r >= 0 && (n = t[r]).left == n.right;
									r--
								);
							return n;
						}
						function Fn(t) {
							if (
								t.measure &&
								((t.measure.cache = {}), (t.measure.heights = null), t.rest)
							)
								for (var e = 0; e < t.rest.length; e++)
									t.measure.caches[e] = {};
						}
						function Bn(t) {
							(t.display.externalMeasure = null), S(t.display.lineMeasure);
							for (var e = 0; e < t.display.view.length; e++)
								Fn(t.display.view[e]);
						}
						function Un(t) {
							Bn(t),
								(t.display.cachedCharWidth =
									t.display.cachedTextHeight =
									t.display.cachedPaddingH =
										null),
								t.options.lineWrapping || (t.display.maxLineChanged = !0),
								(t.display.lineNumChars = null);
						}
						function Hn() {
							return h && m
								? -(
										document.body.getBoundingClientRect().left -
										parseInt(getComputedStyle(document.body).marginLeft)
								  )
								: window.pageXOffset ||
										(document.documentElement || document.body).scrollLeft;
						}
						function zn() {
							return h && m
								? -(
										document.body.getBoundingClientRect().top -
										parseInt(getComputedStyle(document.body).marginTop)
								  )
								: window.pageYOffset ||
										(document.documentElement || document.body).scrollTop;
						}
						function Wn(t) {
							var e = 0;
							if (t.widgets)
								for (var n = 0; n < t.widgets.length; ++n)
									t.widgets[n].above && (e += kn(t.widgets[n]));
							return e;
						}
						function jn(t, e, n, i, r) {
							if (!r) {
								var o = Wn(e);
								(n.top += o), (n.bottom += o);
							}
							if ("line" == i) return n;
							i || (i = "local");
							var s = We(e);
							if (
								("local" == i
									? (s += Tn(t.display))
									: (s -= t.display.viewOffset),
								"page" == i || "window" == i)
							) {
								var a = t.display.lineSpace.getBoundingClientRect();
								s += a.top + ("window" == i ? 0 : zn());
								var l = a.left + ("window" == i ? 0 : Hn());
								(n.left += l), (n.right += l);
							}
							return (n.top += s), (n.bottom += s), n;
						}
						function Gn(t, e, n) {
							if ("div" == n) return e;
							var i = e.left,
								r = e.top;
							if ("page" == n) (i -= Hn()), (r -= zn());
							else if ("local" == n || !n) {
								var o = t.display.sizer.getBoundingClientRect();
								(i += o.left), (r += o.top);
							}
							var s = t.display.lineSpace.getBoundingClientRect();
							return { left: i - s.left, top: r - s.top };
						}
						function qn(t, e, n, i, r) {
							return (
								i || (i = qt(t.doc, e.line)), jn(t, i, On(t, i, e.ch, r), n)
							);
						}
						function Vn(t, e, n, i, r, o) {
							function s(e, s) {
								var a = Mn(t, r, e, s ? "right" : "left", o);
								return (
									s ? (a.left = a.right) : (a.right = a.left), jn(t, i, a, n)
								);
							}
							(i = i || qt(t.doc, e.line)), r || (r = In(t, i));
							var a = ct(i, t.doc.direction),
								l = e.ch,
								c = e.sticky;
							if (
								(l >= i.text.length
									? ((l = i.text.length), (c = "before"))
									: l <= 0 && ((l = 0), (c = "after")),
								!a)
							)
								return s("before" == c ? l - 1 : l, "before" == c);
							function h(t, e, n) {
								return s(n ? t - 1 : t, (1 == a[e].level) != n);
							}
							var u = at(a, l, c),
								f = st,
								d = h(l, u, "before" == c);
							return null != f && (d.other = h(l, f, "before" != c)), d;
						}
						function Yn(t, e) {
							var n = 0;
							(e = ae(t.doc, e)),
								t.options.lineWrapping || (n = ri(t.display) * e.ch);
							var i = qt(t.doc, e.line),
								r = We(i) + Tn(t.display);
							return { left: n, right: n, top: r, bottom: r + i.height };
						}
						function Kn(t, e, n, i, r) {
							var o = te(t, e, n);
							return (o.xRel = r), i && (o.outside = i), o;
						}
						function Xn(t, e, n) {
							var i = t.doc;
							if ((n += t.display.viewOffset) < 0)
								return Kn(i.first, 0, null, -1, -1);
							var r = Qt(i, n),
								o = i.first + i.size - 1;
							if (r > o)
								return Kn(
									i.first + i.size - 1,
									qt(i, o).text.length,
									null,
									1,
									1
								);
							e < 0 && (e = 0);
							for (var s = qt(i, r); ; ) {
								var a = ti(t, s, r, e, n),
									l = De(s, a.ch + (a.xRel > 0 || a.outside > 0 ? 1 : 0));
								if (!l) return a;
								var c = l.find(1);
								if (c.line == r) return c;
								s = qt(i, (r = c.line));
							}
						}
						function Qn(t, e, n, i) {
							i -= Wn(e);
							var r = e.text.length,
								o = ot(
									function (e) {
										return Mn(t, n, e - 1).bottom <= i;
									},
									r,
									0
								);
							return {
								begin: o,
								end: (r = ot(
									function (e) {
										return Mn(t, n, e).top > i;
									},
									o,
									r
								)),
							};
						}
						function Zn(t, e, n, i) {
							return (
								n || (n = In(t, e)),
								Qn(t, e, n, jn(t, e, Mn(t, n, i), "line").top)
							);
						}
						function Jn(t, e, n, i) {
							return (
								!(t.bottom <= n) && (t.top > n || (i ? t.left : t.right) > e)
							);
						}
						function ti(t, e, n, i, r) {
							r -= We(e);
							var o = In(t, e),
								s = Wn(e),
								a = 0,
								l = e.text.length,
								c = !0,
								h = ct(e, t.doc.direction);
							if (h) {
								var u = (t.options.lineWrapping ? ni : ei)(t, e, n, o, h, i, r);
								(a = (c = 1 != u.level) ? u.from : u.to - 1),
									(l = c ? u.to : u.from - 1);
							}
							var f,
								d,
								p = null,
								g = null,
								m = ot(
									function (e) {
										var n = Mn(t, o, e);
										return (
											(n.top += s),
											(n.bottom += s),
											!!Jn(n, i, r, !1) &&
												(n.top <= r && n.left <= i && ((p = e), (g = n)), !0)
										);
									},
									a,
									l
								),
								v = !1;
							if (g) {
								var _ = i - g.left < g.right - i,
									y = _ == c;
								(m = p + (y ? 0 : 1)),
									(d = y ? "after" : "before"),
									(f = _ ? g.left : g.right);
							} else {
								c || (m != l && m != a) || m++,
									(d =
										0 == m
											? "after"
											: m == e.text.length
											? "before"
											: Mn(t, o, m - (c ? 1 : 0)).bottom + s <= r == c
											? "after"
											: "before");
								var x = Vn(t, te(n, m, d), "line", e, o);
								(f = x.left), (v = r < x.top ? -1 : r >= x.bottom ? 1 : 0);
							}
							return Kn(n, (m = rt(e.text, m, 1)), d, v, i - f);
						}
						function ei(t, e, n, i, r, o, s) {
							var a = ot(
									function (a) {
										var l = r[a],
											c = 1 != l.level;
										return Jn(
											Vn(
												t,
												te(n, c ? l.to : l.from, c ? "before" : "after"),
												"line",
												e,
												i
											),
											o,
											s,
											!0
										);
									},
									0,
									r.length - 1
								),
								l = r[a];
							if (a > 0) {
								var c = 1 != l.level,
									h = Vn(
										t,
										te(n, c ? l.from : l.to, c ? "after" : "before"),
										"line",
										e,
										i
									);
								Jn(h, o, s, !0) && h.top > s && (l = r[a - 1]);
							}
							return l;
						}
						function ni(t, e, n, i, r, o, s) {
							var a = Qn(t, e, i, s),
								l = a.begin,
								c = a.end;
							/\s/.test(e.text.charAt(c - 1)) && c--;
							for (var h = null, u = null, f = 0; f < r.length; f++) {
								var d = r[f];
								if (!(d.from >= c || d.to <= l)) {
									var p = Mn(
											t,
											i,
											1 != d.level ? Math.min(c, d.to) - 1 : Math.max(l, d.from)
										).right,
										g = p < o ? o - p + 1e9 : p - o;
									(!h || u > g) && ((h = d), (u = g));
								}
							}
							return (
								h || (h = r[r.length - 1]),
								h.from < l && (h = { from: l, to: h.to, level: h.level }),
								h.to > c && (h = { from: h.from, to: c, level: h.level }),
								h
							);
						}
						function ii(t) {
							if (null != t.cachedTextHeight) return t.cachedTextHeight;
							if (null == $n) {
								$n = L("pre", null, "CodeMirror-line-like");
								for (var e = 0; e < 49; ++e)
									$n.appendChild(document.createTextNode("x")),
										$n.appendChild(L("br"));
								$n.appendChild(document.createTextNode("x"));
							}
							A(t.measure, $n);
							var n = $n.offsetHeight / 50;
							return n > 3 && (t.cachedTextHeight = n), S(t.measure), n || 1;
						}
						function ri(t) {
							if (null != t.cachedCharWidth) return t.cachedCharWidth;
							var e = L("span", "xxxxxxxxxx"),
								n = L("pre", [e], "CodeMirror-line-like");
							A(t.measure, n);
							var i = e.getBoundingClientRect(),
								r = (i.right - i.left) / 10;
							return r > 2 && (t.cachedCharWidth = r), r || 10;
						}
						function oi(t) {
							for (
								var e = t.display,
									n = {},
									i = {},
									r = e.gutters.clientLeft,
									o = e.gutters.firstChild,
									s = 0;
								o;
								o = o.nextSibling, ++s
							) {
								var a = t.display.gutterSpecs[s].className;
								(n[a] = o.offsetLeft + o.clientLeft + r),
									(i[a] = o.clientWidth);
							}
							return {
								fixedPos: si(e),
								gutterTotalWidth: e.gutters.offsetWidth,
								gutterLeft: n,
								gutterWidth: i,
								wrapperWidth: e.wrapper.clientWidth,
							};
						}
						function si(t) {
							return (
								t.scroller.getBoundingClientRect().left -
								t.sizer.getBoundingClientRect().left
							);
						}
						function ai(t) {
							var e = ii(t.display),
								n = t.options.lineWrapping,
								i =
									n &&
									Math.max(
										5,
										t.display.scroller.clientWidth / ri(t.display) - 3
									);
							return function (r) {
								if (He(t.doc, r)) return 0;
								var o = 0;
								if (r.widgets)
									for (var s = 0; s < r.widgets.length; s++)
										r.widgets[s].height && (o += r.widgets[s].height);
								return n ? o + (Math.ceil(r.text.length / i) || 1) * e : o + e;
							};
						}
						function li(t) {
							var e = t.doc,
								n = ai(t);
							e.iter(function (t) {
								var e = n(t);
								e != t.height && Kt(t, e);
							});
						}
						function ci(t, e, n, i) {
							var r = t.display;
							if (!n && "true" == Tt(e).getAttribute("cm-not-content"))
								return null;
							var o,
								s,
								a = r.lineSpace.getBoundingClientRect();
							try {
								(o = e.clientX - a.left), (s = e.clientY - a.top);
							} catch (t) {
								return null;
							}
							var l,
								c = Xn(t, o, s);
							if (
								i &&
								c.xRel > 0 &&
								(l = qt(t.doc, c.line).text).length == c.ch
							) {
								var h = F(l, l.length, t.options.tabSize) - l.length;
								c = te(
									c.line,
									Math.max(
										0,
										Math.round((o - wn(t.display).left) / ri(t.display)) - h
									)
								);
							}
							return c;
						}
						function hi(t, e) {
							if (e >= t.display.viewTo) return null;
							if ((e -= t.display.viewFrom) < 0) return null;
							for (var n = t.display.view, i = 0; i < n.length; i++)
								if ((e -= n[i].size) < 0) return i;
						}
						function ui(t, e, n, i) {
							null == e && (e = t.doc.first),
								null == n && (n = t.doc.first + t.doc.size),
								i || (i = 0);
							var r = t.display;
							if (
								(i &&
									n < r.viewTo &&
									(null == r.updateLineNumbers || r.updateLineNumbers > e) &&
									(r.updateLineNumbers = e),
								(t.curOp.viewChanged = !0),
								e >= r.viewTo)
							)
								be && Be(t.doc, e) < r.viewTo && di(t);
							else if (n <= r.viewFrom)
								be && Ue(t.doc, n + i) > r.viewFrom
									? di(t)
									: ((r.viewFrom += i), (r.viewTo += i));
							else if (e <= r.viewFrom && n >= r.viewTo) di(t);
							else if (e <= r.viewFrom) {
								var o = pi(t, n, n + i, 1);
								o
									? ((r.view = r.view.slice(o.index)),
									  (r.viewFrom = o.lineN),
									  (r.viewTo += i))
									: di(t);
							} else if (n >= r.viewTo) {
								var s = pi(t, e, e, -1);
								s
									? ((r.view = r.view.slice(0, s.index)), (r.viewTo = s.lineN))
									: di(t);
							} else {
								var a = pi(t, e, e, -1),
									l = pi(t, n, n + i, 1);
								a && l
									? ((r.view = r.view
											.slice(0, a.index)
											.concat(on(t, a.lineN, l.lineN))
											.concat(r.view.slice(l.index))),
									  (r.viewTo += i))
									: di(t);
							}
							var c = r.externalMeasured;
							c &&
								(n < c.lineN
									? (c.lineN += i)
									: e < c.lineN + c.size && (r.externalMeasured = null));
						}
						function fi(t, e, n) {
							t.curOp.viewChanged = !0;
							var i = t.display,
								r = t.display.externalMeasured;
							if (
								(r &&
									e >= r.lineN &&
									e < r.lineN + r.size &&
									(i.externalMeasured = null),
								!(e < i.viewFrom || e >= i.viewTo))
							) {
								var o = i.view[hi(t, e)];
								if (null != o.node) {
									var s = o.changes || (o.changes = []);
									-1 == U(s, n) && s.push(n);
								}
							}
						}
						function di(t) {
							(t.display.viewFrom = t.display.viewTo = t.doc.first),
								(t.display.view = []),
								(t.display.viewOffset = 0);
						}
						function pi(t, e, n, i) {
							var r,
								o = hi(t, e),
								s = t.display.view;
							if (!be || n == t.doc.first + t.doc.size)
								return { index: o, lineN: n };
							for (var a = t.display.viewFrom, l = 0; l < o; l++)
								a += s[l].size;
							if (a != e) {
								if (i > 0) {
									if (o == s.length - 1) return null;
									(r = a + s[o].size - e), o++;
								} else r = a - e;
								(e += r), (n += r);
							}
							for (; Be(t.doc, n) != n; ) {
								if (o == (i < 0 ? 0 : s.length - 1)) return null;
								(n += i * s[o - (i < 0 ? 1 : 0)].size), (o += i);
							}
							return { index: o, lineN: n };
						}
						function gi(t) {
							for (var e = t.display.view, n = 0, i = 0; i < e.length; i++) {
								var r = e[i];
								r.hidden || (r.node && !r.changes) || ++n;
							}
							return n;
						}
						function mi(t) {
							t.display.input.showSelection(t.display.input.prepareSelection());
						}
						function vi(t, e) {
							void 0 === e && (e = !0);
							for (
								var n = t.doc,
									i = {},
									r = (i.cursors = document.createDocumentFragment()),
									o = (i.selection = document.createDocumentFragment()),
									s = 0;
								s < n.sel.ranges.length;
								s++
							)
								if (e || s != n.sel.primIndex) {
									var a = n.sel.ranges[s];
									if (
										!(
											a.from().line >= t.display.viewTo ||
											a.to().line < t.display.viewFrom
										)
									) {
										var l = a.empty();
										(l || t.options.showCursorWhenSelecting) &&
											_i(t, a.head, r),
											l || xi(t, a, o);
									}
								}
							return i;
						}
						function _i(t, e, n) {
							var i = Vn(
									t,
									e,
									"div",
									null,
									null,
									!t.options.singleCursorHeightPerLine
								),
								r = n.appendChild(L("div", " ", "CodeMirror-cursor"));
							if (
								((r.style.left = i.left + "px"),
								(r.style.top = i.top + "px"),
								(r.style.height =
									Math.max(0, i.bottom - i.top) * t.options.cursorHeight +
									"px"),
								/\bcm-fat-cursor\b/.test(t.getWrapperElement().className))
							) {
								var o = qn(t, e, "div", null, null);
								r.style.width = Math.max(0, o.right - o.left) + "px";
							}
							if (i.other) {
								var s = n.appendChild(
									L("div", " ", "CodeMirror-cursor CodeMirror-secondarycursor")
								);
								(s.style.display = ""),
									(s.style.left = i.other.left + "px"),
									(s.style.top = i.other.top + "px"),
									(s.style.height =
										0.85 * (i.other.bottom - i.other.top) + "px");
							}
						}
						function yi(t, e) {
							return t.top - e.top || t.left - e.left;
						}
						function xi(t, e, n) {
							var i = t.display,
								r = t.doc,
								o = document.createDocumentFragment(),
								s = wn(t.display),
								a = s.left,
								l =
									Math.max(i.sizerWidth, Sn(t) - i.sizer.offsetLeft) - s.right,
								c = "ltr" == r.direction;
							function h(t, e, n, i) {
								e < 0 && (e = 0),
									(e = Math.round(e)),
									(i = Math.round(i)),
									o.appendChild(
										L(
											"div",
											null,
											"CodeMirror-selected",
											"position: absolute; left: " +
												t +
												"px;\n                             top: " +
												e +
												"px; width: " +
												(null == n ? l - t : n) +
												"px;\n                             height: " +
												(i - e) +
												"px"
										)
									);
							}
							function u(e, n, i) {
								var o,
									s,
									u = qt(r, e),
									f = u.text.length;
								function d(n, i) {
									return qn(t, te(e, n), "div", u, i);
								}
								function p(e, n, i) {
									var r = Zn(t, u, null, e),
										o = ("ltr" == n) == ("after" == i) ? "left" : "right";
									return d(
										"after" == i
											? r.begin
											: r.end - (/\s/.test(u.text.charAt(r.end - 1)) ? 2 : 1),
										o
									)[o];
								}
								var g = ct(u, r.direction);
								return (
									(function (t, e, n, i) {
										if (!t) return i(e, n, "ltr", 0);
										for (var r = !1, o = 0; o < t.length; ++o) {
											var s = t[o];
											((s.from < n && s.to > e) || (e == n && s.to == e)) &&
												(i(
													Math.max(s.from, e),
													Math.min(s.to, n),
													1 == s.level ? "rtl" : "ltr",
													o
												),
												(r = !0));
										}
										r || i(e, n, "ltr");
									})(g, n || 0, null == i ? f : i, function (t, e, r, u) {
										var m = "ltr" == r,
											v = d(t, m ? "left" : "right"),
											_ = d(e - 1, m ? "right" : "left"),
											y = null == n && 0 == t,
											x = null == i && e == f,
											k = 0 == u,
											b = !g || u == g.length - 1;
										if (_.top - v.top <= 3) {
											var T = (c ? x : y) && b,
												C = (c ? y : x) && k ? a : (m ? v : _).left,
												w = T ? l : (m ? _ : v).right;
											h(C, v.top, w - C, v.bottom);
										} else {
											var E, S, A, L;
											m
												? ((E = c && y && k ? a : v.left),
												  (S = c ? l : p(t, r, "before")),
												  (A = c ? a : p(e, r, "after")),
												  (L = c && x && b ? l : _.right))
												: ((E = c ? p(t, r, "before") : a),
												  (S = !c && y && k ? l : v.right),
												  (A = !c && x && b ? a : _.left),
												  (L = c ? p(e, r, "after") : l)),
												h(E, v.top, S - E, v.bottom),
												v.bottom < _.top && h(a, v.bottom, null, _.top),
												h(A, _.top, L - A, _.bottom);
										}
										(!o || yi(v, o) < 0) && (o = v),
											yi(_, o) < 0 && (o = _),
											(!s || yi(v, s) < 0) && (s = v),
											yi(_, s) < 0 && (s = _);
									}),
									{ start: o, end: s }
								);
							}
							var f = e.from(),
								d = e.to();
							if (f.line == d.line) u(f.line, f.ch, d.ch);
							else {
								var p = qt(r, f.line),
									g = qt(r, d.line),
									m = Fe(p) == Fe(g),
									v = u(f.line, f.ch, m ? p.text.length + 1 : null).end,
									_ = u(d.line, m ? 0 : null, d.ch).start;
								m &&
									(v.top < _.top - 2
										? (h(v.right, v.top, null, v.bottom),
										  h(a, _.top, _.left, _.bottom))
										: h(v.right, v.top, _.left - v.right, v.bottom)),
									v.bottom < _.top && h(a, v.bottom, null, _.top);
							}
							n.appendChild(o);
						}
						function ki(t) {
							if (t.state.focused) {
								var e = t.display;
								clearInterval(e.blinker);
								var n = !0;
								(e.cursorDiv.style.visibility = ""),
									t.options.cursorBlinkRate > 0
										? (e.blinker = setInterval(function () {
												t.hasFocus() || wi(t),
													(e.cursorDiv.style.visibility = (n = !n)
														? ""
														: "hidden");
										  }, t.options.cursorBlinkRate))
										: t.options.cursorBlinkRate < 0 &&
										  (e.cursorDiv.style.visibility = "hidden");
							}
						}
						function bi(t) {
							t.hasFocus() ||
								(t.display.input.focus(), t.state.focused || Ci(t));
						}
						function Ti(t) {
							(t.state.delayingBlurEvent = !0),
								setTimeout(function () {
									t.state.delayingBlurEvent &&
										((t.state.delayingBlurEvent = !1),
										t.state.focused && wi(t));
								}, 100);
						}
						function Ci(t, e) {
							t.state.delayingBlurEvent &&
								!t.state.draggingText &&
								(t.state.delayingBlurEvent = !1),
								"nocursor" != t.options.readOnly &&
									(t.state.focused ||
										(pt(t, "focus", t, e),
										(t.state.focused = !0),
										M(t.display.wrapper, "CodeMirror-focused"),
										t.curOp ||
											t.display.selForContextMenu == t.doc.sel ||
											(t.display.input.reset(),
											l &&
												setTimeout(function () {
													return t.display.input.reset(!0);
												}, 20)),
										t.display.input.receivedFocus()),
									ki(t));
						}
						function wi(t, e) {
							t.state.delayingBlurEvent ||
								(t.state.focused &&
									(pt(t, "blur", t, e),
									(t.state.focused = !1),
									E(t.display.wrapper, "CodeMirror-focused")),
								clearInterval(t.display.blinker),
								setTimeout(function () {
									t.state.focused || (t.display.shift = !1);
								}, 150));
						}
						function Ei(t) {
							for (
								var e = t.display, n = e.lineDiv.offsetTop, i = 0;
								i < e.view.length;
								i++
							) {
								var r = e.view[i],
									o = t.options.lineWrapping,
									l = void 0,
									c = 0;
								if (!r.hidden) {
									if (s && a < 8) {
										var h = r.node.offsetTop + r.node.offsetHeight;
										(l = h - n), (n = h);
									} else {
										var u = r.node.getBoundingClientRect();
										(l = u.bottom - u.top),
											!o &&
												r.text.firstChild &&
												(c =
													r.text.firstChild.getBoundingClientRect().right -
													u.left -
													1);
									}
									var f = r.line.height - l;
									if (
										(f > 0.005 || f < -0.005) &&
										(Kt(r.line, l), Si(r.line), r.rest)
									)
										for (var d = 0; d < r.rest.length; d++) Si(r.rest[d]);
									if (c > t.display.sizerWidth) {
										var p = Math.ceil(c / ri(t.display));
										p > t.display.maxLineLength &&
											((t.display.maxLineLength = p),
											(t.display.maxLine = r.line),
											(t.display.maxLineChanged = !0));
									}
								}
							}
						}
						function Si(t) {
							if (t.widgets)
								for (var e = 0; e < t.widgets.length; ++e) {
									var n = t.widgets[e],
										i = n.node.parentNode;
									i && (n.height = i.offsetHeight);
								}
						}
						function Ai(t, e, n) {
							var i =
								n && null != n.top ? Math.max(0, n.top) : t.scroller.scrollTop;
							i = Math.floor(i - Tn(t));
							var r =
									n && null != n.bottom ? n.bottom : i + t.wrapper.clientHeight,
								o = Qt(e, i),
								s = Qt(e, r);
							if (n && n.ensure) {
								var a = n.ensure.from.line,
									l = n.ensure.to.line;
								a < o
									? ((o = a),
									  (s = Qt(e, We(qt(e, a)) + t.wrapper.clientHeight)))
									: Math.min(l, e.lastLine()) >= s &&
									  ((o = Qt(e, We(qt(e, l)) - t.wrapper.clientHeight)),
									  (s = l));
							}
							return { from: o, to: Math.max(s, o + 1) };
						}
						function Li(t, e) {
							var n = t.display,
								i = ii(t.display);
							e.top < 0 && (e.top = 0);
							var r =
									t.curOp && null != t.curOp.scrollTop
										? t.curOp.scrollTop
										: n.scroller.scrollTop,
								o = An(t),
								s = {};
							e.bottom - e.top > o && (e.bottom = e.top + o);
							var a = t.doc.height + Cn(n),
								l = e.top < i,
								c = e.bottom > a - i;
							if (e.top < r) s.scrollTop = l ? 0 : e.top;
							else if (e.bottom > r + o) {
								var h = Math.min(e.top, (c ? a : e.bottom) - o);
								h != r && (s.scrollTop = h);
							}
							var u = t.options.fixedGutter ? 0 : n.gutters.offsetWidth,
								f =
									t.curOp && null != t.curOp.scrollLeft
										? t.curOp.scrollLeft
										: n.scroller.scrollLeft - u,
								d = Sn(t) - n.gutters.offsetWidth,
								p = e.right - e.left > d;
							return (
								p && (e.right = e.left + d),
								e.left < 10
									? (s.scrollLeft = 0)
									: e.left < f
									? (s.scrollLeft = Math.max(0, e.left + u - (p ? 0 : 10)))
									: e.right > d + f - 3 &&
									  (s.scrollLeft = e.right + (p ? 0 : 10) - d),
								s
							);
						}
						function Oi(t, e) {
							null != e &&
								(Mi(t),
								(t.curOp.scrollTop =
									(null == t.curOp.scrollTop
										? t.doc.scrollTop
										: t.curOp.scrollTop) + e));
						}
						function Ni(t) {
							Mi(t);
							var e = t.getCursor();
							t.curOp.scrollToPos = {
								from: e,
								to: e,
								margin: t.options.cursorScrollMargin,
							};
						}
						function Ii(t, e, n) {
							(null == e && null == n) || Mi(t),
								null != e && (t.curOp.scrollLeft = e),
								null != n && (t.curOp.scrollTop = n);
						}
						function Mi(t) {
							var e = t.curOp.scrollToPos;
							e &&
								((t.curOp.scrollToPos = null),
								$i(t, Yn(t, e.from), Yn(t, e.to), e.margin));
						}
						function $i(t, e, n, i) {
							var r = Li(t, {
								left: Math.min(e.left, n.left),
								top: Math.min(e.top, n.top) - i,
								right: Math.max(e.right, n.right),
								bottom: Math.max(e.bottom, n.bottom) + i,
							});
							Ii(t, r.scrollLeft, r.scrollTop);
						}
						function Ri(t, e) {
							Math.abs(t.doc.scrollTop - e) < 2 ||
								(n || lr(t, { top: e }), Di(t, e, !0), n && lr(t), ir(t, 100));
						}
						function Di(t, e, n) {
							(e = Math.max(
								0,
								Math.min(
									t.display.scroller.scrollHeight -
										t.display.scroller.clientHeight,
									e
								)
							)),
								(t.display.scroller.scrollTop != e || n) &&
									((t.doc.scrollTop = e),
									t.display.scrollbars.setScrollTop(e),
									t.display.scroller.scrollTop != e &&
										(t.display.scroller.scrollTop = e));
						}
						function Pi(t, e, n, i) {
							(e = Math.max(
								0,
								Math.min(
									e,
									t.display.scroller.scrollWidth -
										t.display.scroller.clientWidth
								)
							)),
								((n
									? e == t.doc.scrollLeft
									: Math.abs(t.doc.scrollLeft - e) < 2) &&
									!i) ||
									((t.doc.scrollLeft = e),
									ur(t),
									t.display.scroller.scrollLeft != e &&
										(t.display.scroller.scrollLeft = e),
									t.display.scrollbars.setScrollLeft(e));
						}
						function Fi(t) {
							var e = t.display,
								n = e.gutters.offsetWidth,
								i = Math.round(t.doc.height + Cn(t.display));
							return {
								clientHeight: e.scroller.clientHeight,
								viewHeight: e.wrapper.clientHeight,
								scrollWidth: e.scroller.scrollWidth,
								clientWidth: e.scroller.clientWidth,
								viewWidth: e.wrapper.clientWidth,
								barLeft: t.options.fixedGutter ? n : 0,
								docHeight: i,
								scrollHeight: i + En(t) + e.barHeight,
								nativeBarWidth: e.nativeBarWidth,
								gutterWidth: n,
							};
						}
						var Bi = function (t, e, n) {
							this.cm = n;
							var i = (this.vert = L(
									"div",
									[L("div", null, null, "min-width: 1px")],
									"CodeMirror-vscrollbar"
								)),
								r = (this.horiz = L(
									"div",
									[L("div", null, null, "height: 100%; min-height: 1px")],
									"CodeMirror-hscrollbar"
								));
							(i.tabIndex = r.tabIndex = -1),
								t(i),
								t(r),
								ut(i, "scroll", function () {
									i.clientHeight && e(i.scrollTop, "vertical");
								}),
								ut(r, "scroll", function () {
									r.clientWidth && e(r.scrollLeft, "horizontal");
								}),
								(this.checkedZeroWidth = !1),
								s &&
									a < 8 &&
									(this.horiz.style.minHeight = this.vert.style.minWidth =
										"18px");
						};
						(Bi.prototype.update = function (t) {
							var e = t.scrollWidth > t.clientWidth + 1,
								n = t.scrollHeight > t.clientHeight + 1,
								i = t.nativeBarWidth;
							if (n) {
								(this.vert.style.display = "block"),
									(this.vert.style.bottom = e ? i + "px" : "0");
								var r = t.viewHeight - (e ? i : 0);
								this.vert.firstChild.style.height =
									Math.max(0, t.scrollHeight - t.clientHeight + r) + "px";
							} else
								(this.vert.style.display = ""),
									(this.vert.firstChild.style.height = "0");
							if (e) {
								(this.horiz.style.display = "block"),
									(this.horiz.style.right = n ? i + "px" : "0"),
									(this.horiz.style.left = t.barLeft + "px");
								var o = t.viewWidth - t.barLeft - (n ? i : 0);
								this.horiz.firstChild.style.width =
									Math.max(0, t.scrollWidth - t.clientWidth + o) + "px";
							} else
								(this.horiz.style.display = ""),
									(this.horiz.firstChild.style.width = "0");
							return (
								!this.checkedZeroWidth &&
									t.clientHeight > 0 &&
									(0 == i && this.zeroWidthHack(),
									(this.checkedZeroWidth = !0)),
								{ right: n ? i : 0, bottom: e ? i : 0 }
							);
						}),
							(Bi.prototype.setScrollLeft = function (t) {
								this.horiz.scrollLeft != t && (this.horiz.scrollLeft = t),
									this.disableHoriz &&
										this.enableZeroWidthBar(
											this.horiz,
											this.disableHoriz,
											"horiz"
										);
							}),
							(Bi.prototype.setScrollTop = function (t) {
								this.vert.scrollTop != t && (this.vert.scrollTop = t),
									this.disableVert &&
										this.enableZeroWidthBar(
											this.vert,
											this.disableVert,
											"vert"
										);
							}),
							(Bi.prototype.zeroWidthHack = function () {
								var t = _ && !d ? "12px" : "18px";
								(this.horiz.style.height = this.vert.style.width = t),
									(this.horiz.style.pointerEvents =
										this.vert.style.pointerEvents =
											"none"),
									(this.disableHoriz = new B()),
									(this.disableVert = new B());
							}),
							(Bi.prototype.enableZeroWidthBar = function (t, e, n) {
								(t.style.pointerEvents = "auto"),
									e.set(1e3, function i() {
										var r = t.getBoundingClientRect();
										("vert" == n
											? document.elementFromPoint(
													r.right - 1,
													(r.top + r.bottom) / 2
											  )
											: document.elementFromPoint(
													(r.right + r.left) / 2,
													r.bottom - 1
											  )) != t
											? (t.style.pointerEvents = "none")
											: e.set(1e3, i);
									});
							}),
							(Bi.prototype.clear = function () {
								var t = this.horiz.parentNode;
								t.removeChild(this.horiz), t.removeChild(this.vert);
							});
						var Ui = function () {};
						function Hi(t, e) {
							e || (e = Fi(t));
							var n = t.display.barWidth,
								i = t.display.barHeight;
							zi(t, e);
							for (
								var r = 0;
								(r < 4 && n != t.display.barWidth) || i != t.display.barHeight;
								r++
							)
								n != t.display.barWidth && t.options.lineWrapping && Ei(t),
									zi(t, Fi(t)),
									(n = t.display.barWidth),
									(i = t.display.barHeight);
						}
						function zi(t, e) {
							var n = t.display,
								i = n.scrollbars.update(e);
							(n.sizer.style.paddingRight = (n.barWidth = i.right) + "px"),
								(n.sizer.style.paddingBottom = (n.barHeight = i.bottom) + "px"),
								(n.heightForcer.style.borderBottom =
									i.bottom + "px solid transparent"),
								i.right && i.bottom
									? ((n.scrollbarFiller.style.display = "block"),
									  (n.scrollbarFiller.style.height = i.bottom + "px"),
									  (n.scrollbarFiller.style.width = i.right + "px"))
									: (n.scrollbarFiller.style.display = ""),
								i.bottom &&
								t.options.coverGutterNextToScrollbar &&
								t.options.fixedGutter
									? ((n.gutterFiller.style.display = "block"),
									  (n.gutterFiller.style.height = i.bottom + "px"),
									  (n.gutterFiller.style.width = e.gutterWidth + "px"))
									: (n.gutterFiller.style.display = "");
						}
						(Ui.prototype.update = function () {
							return { bottom: 0, right: 0 };
						}),
							(Ui.prototype.setScrollLeft = function () {}),
							(Ui.prototype.setScrollTop = function () {}),
							(Ui.prototype.clear = function () {});
						var Wi = { native: Bi, null: Ui };
						function ji(t) {
							t.display.scrollbars &&
								(t.display.scrollbars.clear(),
								t.display.scrollbars.addClass &&
									E(t.display.wrapper, t.display.scrollbars.addClass)),
								(t.display.scrollbars = new Wi[t.options.scrollbarStyle](
									function (e) {
										t.display.wrapper.insertBefore(
											e,
											t.display.scrollbarFiller
										),
											ut(e, "mousedown", function () {
												t.state.focused &&
													setTimeout(function () {
														return t.display.input.focus();
													}, 0);
											}),
											e.setAttribute("cm-not-content", "true");
									},
									function (e, n) {
										"horizontal" == n ? Pi(t, e) : Ri(t, e);
									},
									t
								)),
								t.display.scrollbars.addClass &&
									M(t.display.wrapper, t.display.scrollbars.addClass);
						}
						var Gi = 0;
						function qi(t) {
							var e;
							(t.curOp = {
								cm: t,
								viewChanged: !1,
								startHeight: t.doc.height,
								forceUpdate: !1,
								updateInput: 0,
								typing: !1,
								changeObjs: null,
								cursorActivityHandlers: null,
								cursorActivityCalled: 0,
								selectionChanged: !1,
								updateMaxLine: !1,
								scrollLeft: null,
								scrollTop: null,
								scrollToPos: null,
								focus: !1,
								id: ++Gi,
								markArrays: null,
							}),
								(e = t.curOp),
								sn
									? sn.ops.push(e)
									: (e.ownsGroup = sn = { ops: [e], delayedCallbacks: [] });
						}
						function Vi(t) {
							var e = t.curOp;
							e &&
								(function (t, e) {
									var n = t.ownsGroup;
									if (n)
										try {
											!(function (t) {
												var e = t.delayedCallbacks,
													n = 0;
												do {
													for (; n < e.length; n++) e[n].call(null);
													for (var i = 0; i < t.ops.length; i++) {
														var r = t.ops[i];
														if (r.cursorActivityHandlers)
															for (
																;
																r.cursorActivityCalled <
																r.cursorActivityHandlers.length;

															)
																r.cursorActivityHandlers[
																	r.cursorActivityCalled++
																].call(null, r.cm);
													}
												} while (n < e.length);
											})(n);
										} finally {
											(sn = null), e(n);
										}
								})(e, function (t) {
									for (var e = 0; e < t.ops.length; e++)
										t.ops[e].cm.curOp = null;
									!(function (t) {
										for (var e = t.ops, n = 0; n < e.length; n++) Yi(e[n]);
										for (var i = 0; i < e.length; i++) Ki(e[i]);
										for (var r = 0; r < e.length; r++) Xi(e[r]);
										for (var o = 0; o < e.length; o++) Qi(e[o]);
										for (var s = 0; s < e.length; s++) Zi(e[s]);
									})(t);
								});
						}
						function Yi(t) {
							var e = t.cm,
								n = e.display;
							!(function (t) {
								var e = t.display;
								!e.scrollbarsClipped &&
									e.scroller.offsetWidth &&
									((e.nativeBarWidth =
										e.scroller.offsetWidth - e.scroller.clientWidth),
									(e.heightForcer.style.height = En(t) + "px"),
									(e.sizer.style.marginBottom = -e.nativeBarWidth + "px"),
									(e.sizer.style.borderRightWidth = En(t) + "px"),
									(e.scrollbarsClipped = !0));
							})(e),
								t.updateMaxLine && Ge(e),
								(t.mustUpdate =
									t.viewChanged ||
									t.forceUpdate ||
									null != t.scrollTop ||
									(t.scrollToPos &&
										(t.scrollToPos.from.line < n.viewFrom ||
											t.scrollToPos.to.line >= n.viewTo)) ||
									(n.maxLineChanged && e.options.lineWrapping)),
								(t.update =
									t.mustUpdate &&
									new or(
										e,
										t.mustUpdate && { top: t.scrollTop, ensure: t.scrollToPos },
										t.forceUpdate
									));
						}
						function Ki(t) {
							t.updatedDisplay = t.mustUpdate && sr(t.cm, t.update);
						}
						function Xi(t) {
							var e = t.cm,
								n = e.display;
							t.updatedDisplay && Ei(e),
								(t.barMeasure = Fi(e)),
								n.maxLineChanged &&
									!e.options.lineWrapping &&
									((t.adjustWidthTo =
										On(e, n.maxLine, n.maxLine.text.length).left + 3),
									(e.display.sizerWidth = t.adjustWidthTo),
									(t.barMeasure.scrollWidth = Math.max(
										n.scroller.clientWidth,
										n.sizer.offsetLeft +
											t.adjustWidthTo +
											En(e) +
											e.display.barWidth
									)),
									(t.maxScrollLeft = Math.max(
										0,
										n.sizer.offsetLeft + t.adjustWidthTo - Sn(e)
									))),
								(t.updatedDisplay || t.selectionChanged) &&
									(t.preparedSelection = n.input.prepareSelection());
						}
						function Qi(t) {
							var e = t.cm;
							null != t.adjustWidthTo &&
								((e.display.sizer.style.minWidth = t.adjustWidthTo + "px"),
								t.maxScrollLeft < e.doc.scrollLeft &&
									Pi(
										e,
										Math.min(e.display.scroller.scrollLeft, t.maxScrollLeft),
										!0
									),
								(e.display.maxLineChanged = !1));
							var n = t.focus && t.focus == I();
							t.preparedSelection &&
								e.display.input.showSelection(t.preparedSelection, n),
								(t.updatedDisplay || t.startHeight != e.doc.height) &&
									Hi(e, t.barMeasure),
								t.updatedDisplay && hr(e, t.barMeasure),
								t.selectionChanged && ki(e),
								e.state.focused &&
									t.updateInput &&
									e.display.input.reset(t.typing),
								n && bi(t.cm);
						}
						function Zi(t) {
							var e = t.cm,
								n = e.display,
								i = e.doc;
							t.updatedDisplay && ar(e, t.update),
								null == n.wheelStartX ||
									(null == t.scrollTop &&
										null == t.scrollLeft &&
										!t.scrollToPos) ||
									(n.wheelStartX = n.wheelStartY = null),
								null != t.scrollTop && Di(e, t.scrollTop, t.forceScroll),
								null != t.scrollLeft && Pi(e, t.scrollLeft, !0, !0),
								t.scrollToPos &&
									(function (t, e) {
										if (!gt(t, "scrollCursorIntoView")) {
											var n = t.display,
												i = n.sizer.getBoundingClientRect(),
												r = null;
											if (
												(e.top + i.top < 0
													? (r = !0)
													: e.bottom + i.top >
															(window.innerHeight ||
																document.documentElement.clientHeight) &&
													  (r = !1),
												null != r && !p)
											) {
												var o = L(
													"div",
													"​",
													null,
													"position: absolute;\n                         top: " +
														(e.top - n.viewOffset - Tn(t.display)) +
														"px;\n                         height: " +
														(e.bottom - e.top + En(t) + n.barHeight) +
														"px;\n                         left: " +
														e.left +
														"px; width: " +
														Math.max(2, e.right - e.left) +
														"px;"
												);
												t.display.lineSpace.appendChild(o),
													o.scrollIntoView(r),
													t.display.lineSpace.removeChild(o);
											}
										}
									})(
										e,
										(function (t, e, n, i) {
											var r;
											null == i && (i = 0),
												t.options.lineWrapping ||
													e != n ||
													((n =
														"before" == e.sticky
															? te(e.line, e.ch + 1, "before")
															: e),
													(e = e.ch
														? te(
																e.line,
																"before" == e.sticky ? e.ch - 1 : e.ch,
																"after"
														  )
														: e));
											for (var o = 0; o < 5; o++) {
												var s = !1,
													a = Vn(t, e),
													l = n && n != e ? Vn(t, n) : a,
													c = Li(
														t,
														(r = {
															left: Math.min(a.left, l.left),
															top: Math.min(a.top, l.top) - i,
															right: Math.max(a.left, l.left),
															bottom: Math.max(a.bottom, l.bottom) + i,
														})
													),
													h = t.doc.scrollTop,
													u = t.doc.scrollLeft;
												if (
													(null != c.scrollTop &&
														(Ri(t, c.scrollTop),
														Math.abs(t.doc.scrollTop - h) > 1 && (s = !0)),
													null != c.scrollLeft &&
														(Pi(t, c.scrollLeft),
														Math.abs(t.doc.scrollLeft - u) > 1 && (s = !0)),
													!s)
												)
													break;
											}
											return r;
										})(
											e,
											ae(i, t.scrollToPos.from),
											ae(i, t.scrollToPos.to),
											t.scrollToPos.margin
										)
									);
							var r = t.maybeHiddenMarkers,
								o = t.maybeUnhiddenMarkers;
							if (r)
								for (var s = 0; s < r.length; ++s)
									r[s].lines.length || pt(r[s], "hide");
							if (o)
								for (var a = 0; a < o.length; ++a)
									o[a].lines.length && pt(o[a], "unhide");
							n.wrapper.offsetHeight &&
								(i.scrollTop = e.display.scroller.scrollTop),
								t.changeObjs && pt(e, "changes", e, t.changeObjs),
								t.update && t.update.finish();
						}
						function Ji(t, e) {
							if (t.curOp) return e();
							qi(t);
							try {
								return e();
							} finally {
								Vi(t);
							}
						}
						function tr(t, e) {
							return function () {
								if (t.curOp) return e.apply(t, arguments);
								qi(t);
								try {
									return e.apply(t, arguments);
								} finally {
									Vi(t);
								}
							};
						}
						function er(t) {
							return function () {
								if (this.curOp) return t.apply(this, arguments);
								qi(this);
								try {
									return t.apply(this, arguments);
								} finally {
									Vi(this);
								}
							};
						}
						function nr(t) {
							return function () {
								var e = this.cm;
								if (!e || e.curOp) return t.apply(this, arguments);
								qi(e);
								try {
									return t.apply(this, arguments);
								} finally {
									Vi(e);
								}
							};
						}
						function ir(t, e) {
							t.doc.highlightFrontier < t.display.viewTo &&
								t.state.highlight.set(e, D(rr, t));
						}
						function rr(t) {
							var e = t.doc;
							if (!(e.highlightFrontier >= t.display.viewTo)) {
								var n = +new Date() + t.options.workTime,
									i = de(t, e.highlightFrontier),
									r = [];
								e.iter(
									i.line,
									Math.min(e.first + e.size, t.display.viewTo + 500),
									function (o) {
										if (i.line >= t.display.viewFrom) {
											var s = o.styles,
												a =
													o.text.length > t.options.maxHighlightLength
														? zt(e.mode, i.state)
														: null,
												l = ue(t, o, i, !0);
											a && (i.state = a), (o.styles = l.styles);
											var c = o.styleClasses,
												h = l.classes;
											h ? (o.styleClasses = h) : c && (o.styleClasses = null);
											for (
												var u =
														!s ||
														s.length != o.styles.length ||
														(c != h &&
															(!c ||
																!h ||
																c.bgClass != h.bgClass ||
																c.textClass != h.textClass)),
													f = 0;
												!u && f < s.length;
												++f
											)
												u = s[f] != o.styles[f];
											u && r.push(i.line),
												(o.stateAfter = i.save()),
												i.nextLine();
										} else
											o.text.length <= t.options.maxHighlightLength &&
												pe(t, o.text, i),
												(o.stateAfter = i.line % 5 == 0 ? i.save() : null),
												i.nextLine();
										if (+new Date() > n) return ir(t, t.options.workDelay), !0;
									}
								),
									(e.highlightFrontier = i.line),
									(e.modeFrontier = Math.max(e.modeFrontier, i.line)),
									r.length &&
										Ji(t, function () {
											for (var e = 0; e < r.length; e++) fi(t, r[e], "text");
										});
							}
						}
						var or = function (t, e, n) {
							var i = t.display;
							(this.viewport = e),
								(this.visible = Ai(i, t.doc, e)),
								(this.editorIsHidden = !i.wrapper.offsetWidth),
								(this.wrapperHeight = i.wrapper.clientHeight),
								(this.wrapperWidth = i.wrapper.clientWidth),
								(this.oldDisplayWidth = Sn(t)),
								(this.force = n),
								(this.dims = oi(t)),
								(this.events = []);
						};
						function sr(t, e) {
							var n = t.display,
								i = t.doc;
							if (e.editorIsHidden) return di(t), !1;
							if (
								!e.force &&
								e.visible.from >= n.viewFrom &&
								e.visible.to <= n.viewTo &&
								(null == n.updateLineNumbers ||
									n.updateLineNumbers >= n.viewTo) &&
								n.renderedView == n.view &&
								0 == gi(t)
							)
								return !1;
							fr(t) && (di(t), (e.dims = oi(t)));
							var r = i.first + i.size,
								o = Math.max(
									e.visible.from - t.options.viewportMargin,
									i.first
								),
								s = Math.min(r, e.visible.to + t.options.viewportMargin);
							n.viewFrom < o &&
								o - n.viewFrom < 20 &&
								(o = Math.max(i.first, n.viewFrom)),
								n.viewTo > s &&
									n.viewTo - s < 20 &&
									(s = Math.min(r, n.viewTo)),
								be && ((o = Be(t.doc, o)), (s = Ue(t.doc, s)));
							var a =
								o != n.viewFrom ||
								s != n.viewTo ||
								n.lastWrapHeight != e.wrapperHeight ||
								n.lastWrapWidth != e.wrapperWidth;
							!(function (t, e, n) {
								var i = t.display;
								0 == i.view.length || e >= i.viewTo || n <= i.viewFrom
									? ((i.view = on(t, e, n)), (i.viewFrom = e))
									: (i.viewFrom > e
											? (i.view = on(t, e, i.viewFrom).concat(i.view))
											: i.viewFrom < e && (i.view = i.view.slice(hi(t, e))),
									  (i.viewFrom = e),
									  i.viewTo < n
											? (i.view = i.view.concat(on(t, i.viewTo, n)))
											: i.viewTo > n && (i.view = i.view.slice(0, hi(t, n)))),
									(i.viewTo = n);
							})(t, o, s),
								(n.viewOffset = We(qt(t.doc, n.viewFrom))),
								(t.display.mover.style.top = n.viewOffset + "px");
							var c = gi(t);
							if (
								!a &&
								0 == c &&
								!e.force &&
								n.renderedView == n.view &&
								(null == n.updateLineNumbers || n.updateLineNumbers >= n.viewTo)
							)
								return !1;
							var h = (function (t) {
								if (t.hasFocus()) return null;
								var e = I();
								if (!e || !N(t.display.lineDiv, e)) return null;
								var n = { activeElt: e };
								if (window.getSelection) {
									var i = window.getSelection();
									i.anchorNode &&
										i.extend &&
										N(t.display.lineDiv, i.anchorNode) &&
										((n.anchorNode = i.anchorNode),
										(n.anchorOffset = i.anchorOffset),
										(n.focusNode = i.focusNode),
										(n.focusOffset = i.focusOffset));
								}
								return n;
							})(t);
							return (
								c > 4 && (n.lineDiv.style.display = "none"),
								(function (t, e, n) {
									var i = t.display,
										r = t.options.lineNumbers,
										o = i.lineDiv,
										s = o.firstChild;
									function a(e) {
										var n = e.nextSibling;
										return (
											l && _ && t.display.currentWheelTarget == e
												? (e.style.display = "none")
												: e.parentNode.removeChild(e),
											n
										);
									}
									for (
										var c = i.view, h = i.viewFrom, u = 0;
										u < c.length;
										u++
									) {
										var f = c[u];
										if (f.hidden);
										else if (f.node && f.node.parentNode == o) {
											for (; s != f.node; ) s = a(s);
											var d = r && null != e && e <= h && f.lineNumber;
											f.changes &&
												(U(f.changes, "gutter") > -1 && (d = !1),
												hn(t, f, h, n)),
												d &&
													(S(f.lineNumber),
													f.lineNumber.appendChild(
														document.createTextNode(Jt(t.options, h))
													)),
												(s = f.node.nextSibling);
										} else {
											var p = vn(t, f, h, n);
											o.insertBefore(p, s);
										}
										h += f.size;
									}
									for (; s; ) s = a(s);
								})(t, n.updateLineNumbers, e.dims),
								c > 4 && (n.lineDiv.style.display = ""),
								(n.renderedView = n.view),
								(function (t) {
									if (
										t &&
										t.activeElt &&
										t.activeElt != I() &&
										(t.activeElt.focus(),
										!/^(INPUT|TEXTAREA)$/.test(t.activeElt.nodeName) &&
											t.anchorNode &&
											N(document.body, t.anchorNode) &&
											N(document.body, t.focusNode))
									) {
										var e = window.getSelection(),
											n = document.createRange();
										n.setEnd(t.anchorNode, t.anchorOffset),
											n.collapse(!1),
											e.removeAllRanges(),
											e.addRange(n),
											e.extend(t.focusNode, t.focusOffset);
									}
								})(h),
								S(n.cursorDiv),
								S(n.selectionDiv),
								(n.gutters.style.height = n.sizer.style.minHeight = 0),
								a &&
									((n.lastWrapHeight = e.wrapperHeight),
									(n.lastWrapWidth = e.wrapperWidth),
									ir(t, 400)),
								(n.updateLineNumbers = null),
								!0
							);
						}
						function ar(t, e) {
							for (var n = e.viewport, i = !0; ; i = !1) {
								if (i && t.options.lineWrapping && e.oldDisplayWidth != Sn(t))
									i && (e.visible = Ai(t.display, t.doc, n));
								else if (
									(n &&
										null != n.top &&
										(n = {
											top: Math.min(
												t.doc.height + Cn(t.display) - An(t),
												n.top
											),
										}),
									(e.visible = Ai(t.display, t.doc, n)),
									e.visible.from >= t.display.viewFrom &&
										e.visible.to <= t.display.viewTo)
								)
									break;
								if (!sr(t, e)) break;
								Ei(t);
								var r = Fi(t);
								mi(t), Hi(t, r), hr(t, r), (e.force = !1);
							}
							e.signal(t, "update", t),
								(t.display.viewFrom == t.display.reportedViewFrom &&
									t.display.viewTo == t.display.reportedViewTo) ||
									(e.signal(
										t,
										"viewportChange",
										t,
										t.display.viewFrom,
										t.display.viewTo
									),
									(t.display.reportedViewFrom = t.display.viewFrom),
									(t.display.reportedViewTo = t.display.viewTo));
						}
						function lr(t, e) {
							var n = new or(t, e);
							if (sr(t, n)) {
								Ei(t), ar(t, n);
								var i = Fi(t);
								mi(t), Hi(t, i), hr(t, i), n.finish();
							}
						}
						function cr(t) {
							var e = t.gutters.offsetWidth;
							(t.sizer.style.marginLeft = e + "px"), ln(t, "gutterChanged", t);
						}
						function hr(t, e) {
							(t.display.sizer.style.minHeight = e.docHeight + "px"),
								(t.display.heightForcer.style.top = e.docHeight + "px"),
								(t.display.gutters.style.height =
									e.docHeight + t.display.barHeight + En(t) + "px");
						}
						function ur(t) {
							var e = t.display,
								n = e.view;
							if (
								e.alignWidgets ||
								(e.gutters.firstChild && t.options.fixedGutter)
							) {
								for (
									var i = si(e) - e.scroller.scrollLeft + t.doc.scrollLeft,
										r = e.gutters.offsetWidth,
										o = i + "px",
										s = 0;
									s < n.length;
									s++
								)
									if (!n[s].hidden) {
										t.options.fixedGutter &&
											(n[s].gutter && (n[s].gutter.style.left = o),
											n[s].gutterBackground &&
												(n[s].gutterBackground.style.left = o));
										var a = n[s].alignable;
										if (a)
											for (var l = 0; l < a.length; l++) a[l].style.left = o;
									}
								t.options.fixedGutter && (e.gutters.style.left = i + r + "px");
							}
						}
						function fr(t) {
							if (!t.options.lineNumbers) return !1;
							var e = t.doc,
								n = Jt(t.options, e.first + e.size - 1),
								i = t.display;
							if (n.length != i.lineNumChars) {
								var r = i.measure.appendChild(
										L(
											"div",
											[L("div", n)],
											"CodeMirror-linenumber CodeMirror-gutter-elt"
										)
									),
									o = r.firstChild.offsetWidth,
									s = r.offsetWidth - o;
								return (
									(i.lineGutter.style.width = ""),
									(i.lineNumInnerWidth =
										Math.max(o, i.lineGutter.offsetWidth - s) + 1),
									(i.lineNumWidth = i.lineNumInnerWidth + s),
									(i.lineNumChars = i.lineNumInnerWidth ? n.length : -1),
									(i.lineGutter.style.width = i.lineNumWidth + "px"),
									cr(t.display),
									!0
								);
							}
							return !1;
						}
						function dr(t, e) {
							for (var n = [], i = !1, r = 0; r < t.length; r++) {
								var o = t[r],
									s = null;
								if (
									("string" != typeof o && ((s = o.style), (o = o.className)),
									"CodeMirror-linenumbers" == o)
								) {
									if (!e) continue;
									i = !0;
								}
								n.push({ className: o, style: s });
							}
							return (
								e &&
									!i &&
									n.push({ className: "CodeMirror-linenumbers", style: null }),
								n
							);
						}
						function pr(t) {
							var e = t.gutters,
								n = t.gutterSpecs;
							S(e), (t.lineGutter = null);
							for (var i = 0; i < n.length; ++i) {
								var r = n[i],
									o = r.className,
									s = r.style,
									a = e.appendChild(L("div", null, "CodeMirror-gutter " + o));
								s && (a.style.cssText = s),
									"CodeMirror-linenumbers" == o &&
										((t.lineGutter = a),
										(a.style.width = (t.lineNumWidth || 1) + "px"));
							}
							(e.style.display = n.length ? "" : "none"), cr(t);
						}
						function gr(t) {
							pr(t.display), ui(t), ur(t);
						}
						function mr(t, e, i, r) {
							var o = this;
							(this.input = i),
								(o.scrollbarFiller = L(
									"div",
									null,
									"CodeMirror-scrollbar-filler"
								)),
								o.scrollbarFiller.setAttribute("cm-not-content", "true"),
								(o.gutterFiller = L("div", null, "CodeMirror-gutter-filler")),
								o.gutterFiller.setAttribute("cm-not-content", "true"),
								(o.lineDiv = O("div", null, "CodeMirror-code")),
								(o.selectionDiv = L(
									"div",
									null,
									null,
									"position: relative; z-index: 1"
								)),
								(o.cursorDiv = L("div", null, "CodeMirror-cursors")),
								(o.measure = L("div", null, "CodeMirror-measure")),
								(o.lineMeasure = L("div", null, "CodeMirror-measure")),
								(o.lineSpace = O(
									"div",
									[
										o.measure,
										o.lineMeasure,
										o.selectionDiv,
										o.cursorDiv,
										o.lineDiv,
									],
									null,
									"position: relative; outline: none"
								));
							var c = O("div", [o.lineSpace], "CodeMirror-lines");
							(o.mover = L("div", [c], null, "position: relative")),
								(o.sizer = L("div", [o.mover], "CodeMirror-sizer")),
								(o.sizerWidth = null),
								(o.heightForcer = L(
									"div",
									null,
									null,
									"position: absolute; height: 50px; width: 1px;"
								)),
								(o.gutters = L("div", null, "CodeMirror-gutters")),
								(o.lineGutter = null),
								(o.scroller = L(
									"div",
									[o.sizer, o.heightForcer, o.gutters],
									"CodeMirror-scroll"
								)),
								o.scroller.setAttribute("tabIndex", "-1"),
								(o.wrapper = L(
									"div",
									[o.scrollbarFiller, o.gutterFiller, o.scroller],
									"CodeMirror"
								)),
								o.wrapper.setAttribute("translate", "no"),
								s &&
									a < 8 &&
									((o.gutters.style.zIndex = -1),
									(o.scroller.style.paddingRight = 0)),
								l || (n && v) || (o.scroller.draggable = !0),
								t && (t.appendChild ? t.appendChild(o.wrapper) : t(o.wrapper)),
								(o.viewFrom = o.viewTo = e.first),
								(o.reportedViewFrom = o.reportedViewTo = e.first),
								(o.view = []),
								(o.renderedView = null),
								(o.externalMeasured = null),
								(o.viewOffset = 0),
								(o.lastWrapHeight = o.lastWrapWidth = 0),
								(o.updateLineNumbers = null),
								(o.nativeBarWidth = o.barHeight = o.barWidth = 0),
								(o.scrollbarsClipped = !1),
								(o.lineNumWidth = o.lineNumInnerWidth = o.lineNumChars = null),
								(o.alignWidgets = !1),
								(o.cachedCharWidth =
									o.cachedTextHeight =
									o.cachedPaddingH =
										null),
								(o.maxLine = null),
								(o.maxLineLength = 0),
								(o.maxLineChanged = !1),
								(o.wheelDX = o.wheelDY = o.wheelStartX = o.wheelStartY = null),
								(o.shift = !1),
								(o.selForContextMenu = null),
								(o.activeTouch = null),
								(o.gutterSpecs = dr(r.gutters, r.lineNumbers)),
								pr(o),
								i.init(o);
						}
						(or.prototype.signal = function (t, e) {
							vt(t, e) && this.events.push(arguments);
						}),
							(or.prototype.finish = function () {
								for (var t = 0; t < this.events.length; t++)
									pt.apply(null, this.events[t]);
							});
						var vr = 0,
							_r = null;
						function yr(t) {
							var e = t.wheelDeltaX,
								n = t.wheelDeltaY;
							return (
								null == e &&
									t.detail &&
									t.axis == t.HORIZONTAL_AXIS &&
									(e = t.detail),
								null == n && t.detail && t.axis == t.VERTICAL_AXIS
									? (n = t.detail)
									: null == n && (n = t.wheelDelta),
								{ x: e, y: n }
							);
						}
						function xr(t) {
							var e = yr(t);
							return (e.x *= _r), (e.y *= _r), e;
						}
						function kr(t, e) {
							var i = yr(e),
								r = i.x,
								o = i.y,
								s = t.display,
								a = s.scroller,
								c = a.scrollWidth > a.clientWidth,
								h = a.scrollHeight > a.clientHeight;
							if ((r && c) || (o && h)) {
								if (o && _ && l)
									t: for (
										var f = e.target, d = s.view;
										f != a;
										f = f.parentNode
									)
										for (var p = 0; p < d.length; p++)
											if (d[p].node == f) {
												t.display.currentWheelTarget = f;
												break t;
											}
								if (r && !n && !u && null != _r)
									return (
										o && h && Ri(t, Math.max(0, a.scrollTop + o * _r)),
										Pi(t, Math.max(0, a.scrollLeft + r * _r)),
										(!o || (o && h)) && yt(e),
										void (s.wheelStartX = null)
									);
								if (o && null != _r) {
									var g = o * _r,
										m = t.doc.scrollTop,
										v = m + s.wrapper.clientHeight;
									g < 0
										? (m = Math.max(0, m + g - 50))
										: (v = Math.min(t.doc.height, v + g + 50)),
										lr(t, { top: m, bottom: v });
								}
								vr < 20 &&
									(null == s.wheelStartX
										? ((s.wheelStartX = a.scrollLeft),
										  (s.wheelStartY = a.scrollTop),
										  (s.wheelDX = r),
										  (s.wheelDY = o),
										  setTimeout(function () {
												if (null != s.wheelStartX) {
													var t = a.scrollLeft - s.wheelStartX,
														e = a.scrollTop - s.wheelStartY,
														n =
															(e && s.wheelDY && e / s.wheelDY) ||
															(t && s.wheelDX && t / s.wheelDX);
													(s.wheelStartX = s.wheelStartY = null),
														n && ((_r = (_r * vr + n) / (vr + 1)), ++vr);
												}
										  }, 200))
										: ((s.wheelDX += r), (s.wheelDY += o)));
							}
						}
						s
							? (_r = -0.53)
							: n
							? (_r = 15)
							: h
							? (_r = -0.7)
							: f && (_r = -1 / 3);
						var br = function (t, e) {
							(this.ranges = t), (this.primIndex = e);
						};
						(br.prototype.primary = function () {
							return this.ranges[this.primIndex];
						}),
							(br.prototype.equals = function (t) {
								if (t == this) return !0;
								if (
									t.primIndex != this.primIndex ||
									t.ranges.length != this.ranges.length
								)
									return !1;
								for (var e = 0; e < this.ranges.length; e++) {
									var n = this.ranges[e],
										i = t.ranges[e];
									if (!ne(n.anchor, i.anchor) || !ne(n.head, i.head)) return !1;
								}
								return !0;
							}),
							(br.prototype.deepCopy = function () {
								for (var t = [], e = 0; e < this.ranges.length; e++)
									t[e] = new Tr(
										ie(this.ranges[e].anchor),
										ie(this.ranges[e].head)
									);
								return new br(t, this.primIndex);
							}),
							(br.prototype.somethingSelected = function () {
								for (var t = 0; t < this.ranges.length; t++)
									if (!this.ranges[t].empty()) return !0;
								return !1;
							}),
							(br.prototype.contains = function (t, e) {
								e || (e = t);
								for (var n = 0; n < this.ranges.length; n++) {
									var i = this.ranges[n];
									if (ee(e, i.from()) >= 0 && ee(t, i.to()) <= 0) return n;
								}
								return -1;
							});
						var Tr = function (t, e) {
							(this.anchor = t), (this.head = e);
						};
						function Cr(t, e, n) {
							var i = t && t.options.selectionsMayTouch,
								r = e[n];
							e.sort(function (t, e) {
								return ee(t.from(), e.from());
							}),
								(n = U(e, r));
							for (var o = 1; o < e.length; o++) {
								var s = e[o],
									a = e[o - 1],
									l = ee(a.to(), s.from());
								if (i && !s.empty() ? l > 0 : l >= 0) {
									var c = oe(a.from(), s.from()),
										h = re(a.to(), s.to()),
										u = a.empty() ? s.from() == s.head : a.from() == a.head;
									o <= n && --n, e.splice(--o, 2, new Tr(u ? h : c, u ? c : h));
								}
							}
							return new br(e, n);
						}
						function wr(t, e) {
							return new br([new Tr(t, e || t)], 0);
						}
						function Er(t) {
							return t.text
								? te(
										t.from.line + t.text.length - 1,
										Y(t.text).length + (1 == t.text.length ? t.from.ch : 0)
								  )
								: t.to;
						}
						function Sr(t, e) {
							if (ee(t, e.from) < 0) return t;
							if (ee(t, e.to) <= 0) return Er(e);
							var n = t.line + e.text.length - (e.to.line - e.from.line) - 1,
								i = t.ch;
							return t.line == e.to.line && (i += Er(e).ch - e.to.ch), te(n, i);
						}
						function Ar(t, e) {
							for (var n = [], i = 0; i < t.sel.ranges.length; i++) {
								var r = t.sel.ranges[i];
								n.push(new Tr(Sr(r.anchor, e), Sr(r.head, e)));
							}
							return Cr(t.cm, n, t.sel.primIndex);
						}
						function Lr(t, e, n) {
							return t.line == e.line
								? te(n.line, t.ch - e.ch + n.ch)
								: te(n.line + (t.line - e.line), t.ch);
						}
						function Or(t) {
							(t.doc.mode = Bt(t.options, t.doc.modeOption)), Nr(t);
						}
						function Nr(t) {
							t.doc.iter(function (t) {
								t.stateAfter && (t.stateAfter = null),
									t.styles && (t.styles = null);
							}),
								(t.doc.modeFrontier = t.doc.highlightFrontier = t.doc.first),
								ir(t, 100),
								t.state.modeGen++,
								t.curOp && ui(t);
						}
						function Ir(t, e) {
							return (
								0 == e.from.ch &&
								0 == e.to.ch &&
								"" == Y(e.text) &&
								(!t.cm || t.cm.options.wholeLineUpdateBefore)
							);
						}
						function Mr(t, e, n, i) {
							function r(t) {
								return n ? n[t] : null;
							}
							function o(t, n, r) {
								!(function (t, e, n, i) {
									(t.text = e),
										t.stateAfter && (t.stateAfter = null),
										t.styles && (t.styles = null),
										null != t.order && (t.order = null),
										Ae(t),
										Le(t, n);
									var r = i ? i(t) : 1;
									r != t.height && Kt(t, r);
								})(t, n, r, i),
									ln(t, "change", t, e);
							}
							function s(t, e) {
								for (var n = [], o = t; o < e; ++o)
									n.push(new qe(c[o], r(o), i));
								return n;
							}
							var a = e.from,
								l = e.to,
								c = e.text,
								h = qt(t, a.line),
								u = qt(t, l.line),
								f = Y(c),
								d = r(c.length - 1),
								p = l.line - a.line;
							if (e.full)
								t.insert(0, s(0, c.length)),
									t.remove(c.length, t.size - c.length);
							else if (Ir(t, e)) {
								var g = s(0, c.length - 1);
								o(u, u.text, d),
									p && t.remove(a.line, p),
									g.length && t.insert(a.line, g);
							} else if (h == u)
								if (1 == c.length)
									o(h, h.text.slice(0, a.ch) + f + h.text.slice(l.ch), d);
								else {
									var m = s(1, c.length - 1);
									m.push(new qe(f + h.text.slice(l.ch), d, i)),
										o(h, h.text.slice(0, a.ch) + c[0], r(0)),
										t.insert(a.line + 1, m);
								}
							else if (1 == c.length)
								o(h, h.text.slice(0, a.ch) + c[0] + u.text.slice(l.ch), r(0)),
									t.remove(a.line + 1, p);
							else {
								o(h, h.text.slice(0, a.ch) + c[0], r(0)),
									o(u, f + u.text.slice(l.ch), d);
								var v = s(1, c.length - 1);
								p > 1 && t.remove(a.line + 1, p - 1), t.insert(a.line + 1, v);
							}
							ln(t, "change", t, e);
						}
						function $r(t, e, n) {
							!(function t(i, r, o) {
								if (i.linked)
									for (var s = 0; s < i.linked.length; ++s) {
										var a = i.linked[s];
										if (a.doc != r) {
											var l = o && a.sharedHist;
											(n && !l) || (e(a.doc, l), t(a.doc, i, l));
										}
									}
							})(t, null, !0);
						}
						function Rr(t, e) {
							if (e.cm) throw new Error("This document is already in use.");
							(t.doc = e),
								(e.cm = t),
								li(t),
								Or(t),
								Dr(t),
								(t.options.direction = e.direction),
								t.options.lineWrapping || Ge(t),
								(t.options.mode = e.modeOption),
								ui(t);
						}
						function Dr(t) {
							("rtl" == t.doc.direction ? M : E)(
								t.display.lineDiv,
								"CodeMirror-rtl"
							);
						}
						function Pr(t) {
							(this.done = []),
								(this.undone = []),
								(this.undoDepth = t ? t.undoDepth : 1 / 0),
								(this.lastModTime = this.lastSelTime = 0),
								(this.lastOp = this.lastSelOp = null),
								(this.lastOrigin = this.lastSelOrigin = null),
								(this.generation = this.maxGeneration =
									t ? t.maxGeneration : 1);
						}
						function Fr(t, e) {
							var n = {
								from: ie(e.from),
								to: Er(e),
								text: Vt(t, e.from, e.to),
							};
							return (
								Wr(t, n, e.from.line, e.to.line + 1),
								$r(
									t,
									function (t) {
										return Wr(t, n, e.from.line, e.to.line + 1);
									},
									!0
								),
								n
							);
						}
						function Br(t) {
							for (; t.length && Y(t).ranges; ) t.pop();
						}
						function Ur(t, e, n, i) {
							var r = t.history;
							r.undone.length = 0;
							var o,
								s,
								a = +new Date();
							if (
								(r.lastOp == i ||
									(r.lastOrigin == e.origin &&
										e.origin &&
										(("+" == e.origin.charAt(0) &&
											r.lastModTime >
												a - (t.cm ? t.cm.options.historyEventDelay : 500)) ||
											"*" == e.origin.charAt(0)))) &&
								(o = (function (t, e) {
									return e
										? (Br(t.done), Y(t.done))
										: t.done.length && !Y(t.done).ranges
										? Y(t.done)
										: t.done.length > 1 && !t.done[t.done.length - 2].ranges
										? (t.done.pop(), Y(t.done))
										: void 0;
								})(r, r.lastOp == i))
							)
								(s = Y(o.changes)),
									0 == ee(e.from, e.to) && 0 == ee(e.from, s.to)
										? (s.to = Er(e))
										: o.changes.push(Fr(t, e));
							else {
								var l = Y(r.done);
								for (
									(l && l.ranges) || zr(t.sel, r.done),
										o = { changes: [Fr(t, e)], generation: r.generation },
										r.done.push(o);
									r.done.length > r.undoDepth;

								)
									r.done.shift(), r.done[0].ranges || r.done.shift();
							}
							r.done.push(n),
								(r.generation = ++r.maxGeneration),
								(r.lastModTime = r.lastSelTime = a),
								(r.lastOp = r.lastSelOp = i),
								(r.lastOrigin = r.lastSelOrigin = e.origin),
								s || pt(t, "historyAdded");
						}
						function Hr(t, e, n, i) {
							var r = t.history,
								o = i && i.origin;
							n == r.lastSelOp ||
							(o &&
								r.lastSelOrigin == o &&
								((r.lastModTime == r.lastSelTime && r.lastOrigin == o) ||
									(function (t, e, n, i) {
										var r = e.charAt(0);
										return (
											"*" == r ||
											("+" == r &&
												n.ranges.length == i.ranges.length &&
												n.somethingSelected() == i.somethingSelected() &&
												new Date() - t.history.lastSelTime <=
													(t.cm ? t.cm.options.historyEventDelay : 500))
										);
									})(t, o, Y(r.done), e)))
								? (r.done[r.done.length - 1] = e)
								: zr(e, r.done),
								(r.lastSelTime = +new Date()),
								(r.lastSelOrigin = o),
								(r.lastSelOp = n),
								i && !1 !== i.clearRedo && Br(r.undone);
						}
						function zr(t, e) {
							var n = Y(e);
							(n && n.ranges && n.equals(t)) || e.push(t);
						}
						function Wr(t, e, n, i) {
							var r = e["spans_" + t.id],
								o = 0;
							t.iter(
								Math.max(t.first, n),
								Math.min(t.first + t.size, i),
								function (n) {
									n.markedSpans &&
										((r || (r = e["spans_" + t.id] = {}))[o] = n.markedSpans),
										++o;
								}
							);
						}
						function jr(t) {
							if (!t) return null;
							for (var e, n = 0; n < t.length; ++n)
								t[n].marker.explicitlyCleared
									? e || (e = t.slice(0, n))
									: e && e.push(t[n]);
							return e ? (e.length ? e : null) : t;
						}
						function Gr(t, e) {
							var n = (function (t, e) {
									var n = e["spans_" + t.id];
									if (!n) return null;
									for (var i = [], r = 0; r < e.text.length; ++r)
										i.push(jr(n[r]));
									return i;
								})(t, e),
								i = Ee(t, e);
							if (!n) return i;
							if (!i) return n;
							for (var r = 0; r < n.length; ++r) {
								var o = n[r],
									s = i[r];
								if (o && s)
									t: for (var a = 0; a < s.length; ++a) {
										for (var l = s[a], c = 0; c < o.length; ++c)
											if (o[c].marker == l.marker) continue t;
										o.push(l);
									}
								else s && (n[r] = s);
							}
							return n;
						}
						function qr(t, e, n) {
							for (var i = [], r = 0; r < t.length; ++r) {
								var o = t[r];
								if (o.ranges) i.push(n ? br.prototype.deepCopy.call(o) : o);
								else {
									var s = o.changes,
										a = [];
									i.push({ changes: a });
									for (var l = 0; l < s.length; ++l) {
										var c = s[l],
											h = void 0;
										if ((a.push({ from: c.from, to: c.to, text: c.text }), e))
											for (var u in c)
												(h = u.match(/^spans_(\d+)$/)) &&
													U(e, Number(h[1])) > -1 &&
													((Y(a)[u] = c[u]), delete c[u]);
									}
								}
							}
							return i;
						}
						function Vr(t, e, n, i) {
							if (i) {
								var r = t.anchor;
								if (n) {
									var o = ee(e, r) < 0;
									o != ee(n, r) < 0
										? ((r = e), (e = n))
										: o != ee(e, n) < 0 && (e = n);
								}
								return new Tr(r, e);
							}
							return new Tr(n || e, e);
						}
						function Yr(t, e, n, i, r) {
							null == r && (r = t.cm && (t.cm.display.shift || t.extend)),
								Jr(t, new br([Vr(t.sel.primary(), e, n, r)], 0), i);
						}
						function Kr(t, e, n) {
							for (
								var i = [], r = t.cm && (t.cm.display.shift || t.extend), o = 0;
								o < t.sel.ranges.length;
								o++
							)
								i[o] = Vr(t.sel.ranges[o], e[o], null, r);
							Jr(t, Cr(t.cm, i, t.sel.primIndex), n);
						}
						function Xr(t, e, n, i) {
							var r = t.sel.ranges.slice(0);
							(r[e] = n), Jr(t, Cr(t.cm, r, t.sel.primIndex), i);
						}
						function Qr(t, e, n, i) {
							Jr(t, wr(e, n), i);
						}
						function Zr(t, e, n) {
							var i = t.history.done,
								r = Y(i);
							r && r.ranges
								? ((i[i.length - 1] = e), to(t, e, n))
								: Jr(t, e, n);
						}
						function Jr(t, e, n) {
							to(t, e, n), Hr(t, t.sel, t.cm ? t.cm.curOp.id : NaN, n);
						}
						function to(t, e, n) {
							(vt(t, "beforeSelectionChange") ||
								(t.cm && vt(t.cm, "beforeSelectionChange"))) &&
								(e = (function (t, e, n) {
									var i = {
										ranges: e.ranges,
										update: function (e) {
											this.ranges = [];
											for (var n = 0; n < e.length; n++)
												this.ranges[n] = new Tr(
													ae(t, e[n].anchor),
													ae(t, e[n].head)
												);
										},
										origin: n && n.origin,
									};
									return (
										pt(t, "beforeSelectionChange", t, i),
										t.cm && pt(t.cm, "beforeSelectionChange", t.cm, i),
										i.ranges != e.ranges
											? Cr(t.cm, i.ranges, i.ranges.length - 1)
											: e
									);
								})(t, e, n));
							var i =
								(n && n.bias) ||
								(ee(e.primary().head, t.sel.primary().head) < 0 ? -1 : 1);
							eo(t, io(t, e, i, !0)),
								(n && !1 === n.scroll) ||
									!t.cm ||
									"nocursor" == t.cm.getOption("readOnly") ||
									Ni(t.cm);
						}
						function eo(t, e) {
							e.equals(t.sel) ||
								((t.sel = e),
								t.cm &&
									((t.cm.curOp.updateInput = 1),
									(t.cm.curOp.selectionChanged = !0),
									mt(t.cm)),
								ln(t, "cursorActivity", t));
						}
						function no(t) {
							eo(t, io(t, t.sel, null, !1));
						}
						function io(t, e, n, i) {
							for (var r, o = 0; o < e.ranges.length; o++) {
								var s = e.ranges[o],
									a = e.ranges.length == t.sel.ranges.length && t.sel.ranges[o],
									l = oo(t, s.anchor, a && a.anchor, n, i),
									c = oo(t, s.head, a && a.head, n, i);
								(r || l != s.anchor || c != s.head) &&
									(r || (r = e.ranges.slice(0, o)), (r[o] = new Tr(l, c)));
							}
							return r ? Cr(t.cm, r, e.primIndex) : e;
						}
						function ro(t, e, n, i, r) {
							var o = qt(t, e.line);
							if (o.markedSpans)
								for (var s = 0; s < o.markedSpans.length; ++s) {
									var a = o.markedSpans[s],
										l = a.marker,
										c = "selectLeft" in l ? !l.selectLeft : l.inclusiveLeft,
										h = "selectRight" in l ? !l.selectRight : l.inclusiveRight;
									if (
										(null == a.from || (c ? a.from <= e.ch : a.from < e.ch)) &&
										(null == a.to || (h ? a.to >= e.ch : a.to > e.ch))
									) {
										if (
											r &&
											(pt(l, "beforeCursorEnter"), l.explicitlyCleared)
										) {
											if (o.markedSpans) {
												--s;
												continue;
											}
											break;
										}
										if (!l.atomic) continue;
										if (n) {
											var u = l.find(i < 0 ? 1 : -1),
												f = void 0;
											if (
												((i < 0 ? h : c) &&
													(u = so(t, u, -i, u && u.line == e.line ? o : null)),
												u &&
													u.line == e.line &&
													(f = ee(u, n)) &&
													(i < 0 ? f < 0 : f > 0))
											)
												return ro(t, u, e, i, r);
										}
										var d = l.find(i < 0 ? -1 : 1);
										return (
											(i < 0 ? c : h) &&
												(d = so(t, d, i, d.line == e.line ? o : null)),
											d ? ro(t, d, e, i, r) : null
										);
									}
								}
							return e;
						}
						function oo(t, e, n, i, r) {
							var o = i || 1,
								s =
									ro(t, e, n, o, r) ||
									(!r && ro(t, e, n, o, !0)) ||
									ro(t, e, n, -o, r) ||
									(!r && ro(t, e, n, -o, !0));
							return s || ((t.cantEdit = !0), te(t.first, 0));
						}
						function so(t, e, n, i) {
							return n < 0 && 0 == e.ch
								? e.line > t.first
									? ae(t, te(e.line - 1))
									: null
								: n > 0 && e.ch == (i || qt(t, e.line)).text.length
								? e.line < t.first + t.size - 1
									? te(e.line + 1, 0)
									: null
								: new te(e.line, e.ch + n);
						}
						function ao(t) {
							t.setSelection(te(t.firstLine(), 0), te(t.lastLine()), z);
						}
						function lo(t, e, n) {
							var i = {
								canceled: !1,
								from: e.from,
								to: e.to,
								text: e.text,
								origin: e.origin,
								cancel: function () {
									return (i.canceled = !0);
								},
							};
							return (
								n &&
									(i.update = function (e, n, r, o) {
										e && (i.from = ae(t, e)),
											n && (i.to = ae(t, n)),
											r && (i.text = r),
											void 0 !== o && (i.origin = o);
									}),
								pt(t, "beforeChange", t, i),
								t.cm && pt(t.cm, "beforeChange", t.cm, i),
								i.canceled
									? (t.cm && (t.cm.curOp.updateInput = 2), null)
									: { from: i.from, to: i.to, text: i.text, origin: i.origin }
							);
						}
						function co(t, e, n) {
							if (t.cm) {
								if (!t.cm.curOp) return tr(t.cm, co)(t, e, n);
								if (t.cm.state.suppressEdits) return;
							}
							if (
								!(
									vt(t, "beforeChange") ||
									(t.cm && vt(t.cm, "beforeChange"))
								) ||
								(e = lo(t, e, !0))
							) {
								var i =
									ke &&
									!n &&
									(function (t, e, n) {
										var i = null;
										if (
											(t.iter(e.line, n.line + 1, function (t) {
												if (t.markedSpans)
													for (var e = 0; e < t.markedSpans.length; ++e) {
														var n = t.markedSpans[e].marker;
														!n.readOnly ||
															(i && -1 != U(i, n)) ||
															(i || (i = [])).push(n);
													}
											}),
											!i)
										)
											return null;
										for (var r = [{ from: e, to: n }], o = 0; o < i.length; ++o)
											for (
												var s = i[o], a = s.find(0), l = 0;
												l < r.length;
												++l
											) {
												var c = r[l];
												if (!(ee(c.to, a.from) < 0 || ee(c.from, a.to) > 0)) {
													var h = [l, 1],
														u = ee(c.from, a.from),
														f = ee(c.to, a.to);
													(u < 0 || (!s.inclusiveLeft && !u)) &&
														h.push({ from: c.from, to: a.from }),
														(f > 0 || (!s.inclusiveRight && !f)) &&
															h.push({ from: a.to, to: c.to }),
														r.splice.apply(r, h),
														(l += h.length - 3);
												}
											}
										return r;
									})(t, e.from, e.to);
								if (i)
									for (var r = i.length - 1; r >= 0; --r)
										ho(t, {
											from: i[r].from,
											to: i[r].to,
											text: r ? [""] : e.text,
											origin: e.origin,
										});
								else ho(t, e);
							}
						}
						function ho(t, e) {
							if (
								1 != e.text.length ||
								"" != e.text[0] ||
								0 != ee(e.from, e.to)
							) {
								var n = Ar(t, e);
								Ur(t, e, n, t.cm ? t.cm.curOp.id : NaN), po(t, e, n, Ee(t, e));
								var i = [];
								$r(t, function (t, n) {
									n ||
										-1 != U(i, t.history) ||
										(_o(t.history, e), i.push(t.history)),
										po(t, e, null, Ee(t, e));
								});
							}
						}
						function uo(t, e, n) {
							var i = t.cm && t.cm.state.suppressEdits;
							if (!i || n) {
								for (
									var r,
										o = t.history,
										s = t.sel,
										a = "undo" == e ? o.done : o.undone,
										l = "undo" == e ? o.undone : o.done,
										c = 0;
									c < a.length &&
									((r = a[c]), n ? !r.ranges || r.equals(t.sel) : r.ranges);
									c++
								);
								if (c != a.length) {
									for (o.lastOrigin = o.lastSelOrigin = null; ; ) {
										if (!(r = a.pop()).ranges) {
											if (i) return void a.push(r);
											break;
										}
										if ((zr(r, l), n && !r.equals(t.sel)))
											return void Jr(t, r, { clearRedo: !1 });
										s = r;
									}
									var h = [];
									zr(s, l),
										l.push({ changes: h, generation: o.generation }),
										(o.generation = r.generation || ++o.maxGeneration);
									for (
										var u =
												vt(t, "beforeChange") ||
												(t.cm && vt(t.cm, "beforeChange")),
											f = function (n) {
												var i = r.changes[n];
												if (((i.origin = e), u && !lo(t, i, !1)))
													return (a.length = 0), {};
												h.push(Fr(t, i));
												var o = n ? Ar(t, i) : Y(a);
												po(t, i, o, Gr(t, i)),
													!n &&
														t.cm &&
														t.cm.scrollIntoView({ from: i.from, to: Er(i) });
												var s = [];
												$r(t, function (t, e) {
													e ||
														-1 != U(s, t.history) ||
														(_o(t.history, i), s.push(t.history)),
														po(t, i, null, Gr(t, i));
												});
											},
											d = r.changes.length - 1;
										d >= 0;
										--d
									) {
										var p = f(d);
										if (p) return p.v;
									}
								}
							}
						}
						function fo(t, e) {
							if (
								0 != e &&
								((t.first += e),
								(t.sel = new br(
									K(t.sel.ranges, function (t) {
										return new Tr(
											te(t.anchor.line + e, t.anchor.ch),
											te(t.head.line + e, t.head.ch)
										);
									}),
									t.sel.primIndex
								)),
								t.cm)
							) {
								ui(t.cm, t.first, t.first - e, e);
								for (var n = t.cm.display, i = n.viewFrom; i < n.viewTo; i++)
									fi(t.cm, i, "gutter");
							}
						}
						function po(t, e, n, i) {
							if (t.cm && !t.cm.curOp) return tr(t.cm, po)(t, e, n, i);
							if (e.to.line < t.first)
								fo(t, e.text.length - 1 - (e.to.line - e.from.line));
							else if (!(e.from.line > t.lastLine())) {
								if (e.from.line < t.first) {
									var r = e.text.length - 1 - (t.first - e.from.line);
									fo(t, r),
										(e = {
											from: te(t.first, 0),
											to: te(e.to.line + r, e.to.ch),
											text: [Y(e.text)],
											origin: e.origin,
										});
								}
								var o = t.lastLine();
								e.to.line > o &&
									(e = {
										from: e.from,
										to: te(o, qt(t, o).text.length),
										text: [e.text[0]],
										origin: e.origin,
									}),
									(e.removed = Vt(t, e.from, e.to)),
									n || (n = Ar(t, e)),
									t.cm
										? (function (t, e, n) {
												var i = t.doc,
													r = t.display,
													o = e.from,
													s = e.to,
													a = !1,
													l = o.line;
												t.options.lineWrapping ||
													((l = Xt(Fe(qt(i, o.line)))),
													i.iter(l, s.line + 1, function (t) {
														if (t == r.maxLine) return (a = !0), !0;
													})),
													i.sel.contains(e.from, e.to) > -1 && mt(t),
													Mr(i, e, n, ai(t)),
													t.options.lineWrapping ||
														(i.iter(l, o.line + e.text.length, function (t) {
															var e = je(t);
															e > r.maxLineLength &&
																((r.maxLine = t),
																(r.maxLineLength = e),
																(r.maxLineChanged = !0),
																(a = !1));
														}),
														a && (t.curOp.updateMaxLine = !0)),
													(function (t, e) {
														if (
															((t.modeFrontier = Math.min(t.modeFrontier, e)),
															!(t.highlightFrontier < e - 10))
														) {
															for (var n = t.first, i = e - 1; i > n; i--) {
																var r = qt(t, i).stateAfter;
																if (
																	r &&
																	(!(r instanceof ce) || i + r.lookAhead < e)
																) {
																	n = i + 1;
																	break;
																}
															}
															t.highlightFrontier = Math.min(
																t.highlightFrontier,
																n
															);
														}
													})(i, o.line),
													ir(t, 400);
												var c = e.text.length - (s.line - o.line) - 1;
												e.full
													? ui(t)
													: o.line != s.line ||
													  1 != e.text.length ||
													  Ir(t.doc, e)
													? ui(t, o.line, s.line + 1, c)
													: fi(t, o.line, "text");
												var h = vt(t, "changes"),
													u = vt(t, "change");
												if (u || h) {
													var f = {
														from: o,
														to: s,
														text: e.text,
														removed: e.removed,
														origin: e.origin,
													};
													u && ln(t, "change", t, f),
														h &&
															(
																t.curOp.changeObjs || (t.curOp.changeObjs = [])
															).push(f);
												}
												t.display.selForContextMenu = null;
										  })(t.cm, e, i)
										: Mr(t, e, i),
									to(t, n, z),
									t.cantEdit &&
										oo(t, te(t.firstLine(), 0)) &&
										(t.cantEdit = !1);
							}
						}
						function go(t, e, n, i, r) {
							var o;
							i || (i = n),
								ee(i, n) < 0 && ((n = (o = [i, n])[0]), (i = o[1])),
								"string" == typeof e && (e = t.splitLines(e)),
								co(t, { from: n, to: i, text: e, origin: r });
						}
						function mo(t, e, n, i) {
							n < t.line
								? (t.line += i)
								: e < t.line && ((t.line = e), (t.ch = 0));
						}
						function vo(t, e, n, i) {
							for (var r = 0; r < t.length; ++r) {
								var o = t[r],
									s = !0;
								if (o.ranges) {
									o.copied || ((o = t[r] = o.deepCopy()).copied = !0);
									for (var a = 0; a < o.ranges.length; a++)
										mo(o.ranges[a].anchor, e, n, i),
											mo(o.ranges[a].head, e, n, i);
								} else {
									for (var l = 0; l < o.changes.length; ++l) {
										var c = o.changes[l];
										if (n < c.from.line)
											(c.from = te(c.from.line + i, c.from.ch)),
												(c.to = te(c.to.line + i, c.to.ch));
										else if (e <= c.to.line) {
											s = !1;
											break;
										}
									}
									s || (t.splice(0, r + 1), (r = 0));
								}
							}
						}
						function _o(t, e) {
							var n = e.from.line,
								i = e.to.line,
								r = e.text.length - (i - n) - 1;
							vo(t.done, n, i, r), vo(t.undone, n, i, r);
						}
						function yo(t, e, n, i) {
							var r = e,
								o = e;
							return (
								"number" == typeof e ? (o = qt(t, se(t, e))) : (r = Xt(e)),
								null == r ? null : (i(o, r) && t.cm && fi(t.cm, r, n), o)
							);
						}
						function xo(t) {
							(this.lines = t), (this.parent = null);
							for (var e = 0, n = 0; n < t.length; ++n)
								(t[n].parent = this), (e += t[n].height);
							this.height = e;
						}
						function ko(t) {
							this.children = t;
							for (var e = 0, n = 0, i = 0; i < t.length; ++i) {
								var r = t[i];
								(e += r.chunkSize()), (n += r.height), (r.parent = this);
							}
							(this.size = e), (this.height = n), (this.parent = null);
						}
						(Tr.prototype.from = function () {
							return oe(this.anchor, this.head);
						}),
							(Tr.prototype.to = function () {
								return re(this.anchor, this.head);
							}),
							(Tr.prototype.empty = function () {
								return (
									this.head.line == this.anchor.line &&
									this.head.ch == this.anchor.ch
								);
							}),
							(xo.prototype = {
								chunkSize: function () {
									return this.lines.length;
								},
								removeInner: function (t, e) {
									for (var n = t, i = t + e; n < i; ++n) {
										var r = this.lines[n];
										(this.height -= r.height), Ve(r), ln(r, "delete");
									}
									this.lines.splice(t, e);
								},
								collapse: function (t) {
									t.push.apply(t, this.lines);
								},
								insertInner: function (t, e, n) {
									(this.height += n),
										(this.lines = this.lines
											.slice(0, t)
											.concat(e)
											.concat(this.lines.slice(t)));
									for (var i = 0; i < e.length; ++i) e[i].parent = this;
								},
								iterN: function (t, e, n) {
									for (var i = t + e; t < i; ++t)
										if (n(this.lines[t])) return !0;
								},
							}),
							(ko.prototype = {
								chunkSize: function () {
									return this.size;
								},
								removeInner: function (t, e) {
									this.size -= e;
									for (var n = 0; n < this.children.length; ++n) {
										var i = this.children[n],
											r = i.chunkSize();
										if (t < r) {
											var o = Math.min(e, r - t),
												s = i.height;
											if (
												(i.removeInner(t, o),
												(this.height -= s - i.height),
												r == o &&
													(this.children.splice(n--, 1), (i.parent = null)),
												0 == (e -= o))
											)
												break;
											t = 0;
										} else t -= r;
									}
									if (
										this.size - e < 25 &&
										(this.children.length > 1 ||
											!(this.children[0] instanceof xo))
									) {
										var a = [];
										this.collapse(a),
											(this.children = [new xo(a)]),
											(this.children[0].parent = this);
									}
								},
								collapse: function (t) {
									for (var e = 0; e < this.children.length; ++e)
										this.children[e].collapse(t);
								},
								insertInner: function (t, e, n) {
									(this.size += e.length), (this.height += n);
									for (var i = 0; i < this.children.length; ++i) {
										var r = this.children[i],
											o = r.chunkSize();
										if (t <= o) {
											if (
												(r.insertInner(t, e, n), r.lines && r.lines.length > 50)
											) {
												for (
													var s = (r.lines.length % 25) + 25, a = s;
													a < r.lines.length;

												) {
													var l = new xo(r.lines.slice(a, (a += 25)));
													(r.height -= l.height),
														this.children.splice(++i, 0, l),
														(l.parent = this);
												}
												(r.lines = r.lines.slice(0, s)), this.maybeSpill();
											}
											break;
										}
										t -= o;
									}
								},
								maybeSpill: function () {
									if (!(this.children.length <= 10)) {
										var t = this;
										do {
											var e = new ko(
												t.children.splice(t.children.length - 5, 5)
											);
											if (t.parent) {
												(t.size -= e.size), (t.height -= e.height);
												var n = U(t.parent.children, t);
												t.parent.children.splice(n + 1, 0, e);
											} else {
												var i = new ko(t.children);
												(i.parent = t), (t.children = [i, e]), (t = i);
											}
											e.parent = t.parent;
										} while (t.children.length > 10);
										t.parent.maybeSpill();
									}
								},
								iterN: function (t, e, n) {
									for (var i = 0; i < this.children.length; ++i) {
										var r = this.children[i],
											o = r.chunkSize();
										if (t < o) {
											var s = Math.min(e, o - t);
											if (r.iterN(t, s, n)) return !0;
											if (0 == (e -= s)) break;
											t = 0;
										} else t -= o;
									}
								},
							});
						var bo = function (t, e, n) {
							if (n) for (var i in n) n.hasOwnProperty(i) && (this[i] = n[i]);
							(this.doc = t), (this.node = e);
						};
						function To(t, e, n) {
							We(e) < ((t.curOp && t.curOp.scrollTop) || t.doc.scrollTop) &&
								Oi(t, n);
						}
						(bo.prototype.clear = function () {
							var t = this.doc.cm,
								e = this.line.widgets,
								n = this.line,
								i = Xt(n);
							if (null != i && e) {
								for (var r = 0; r < e.length; ++r)
									e[r] == this && e.splice(r--, 1);
								e.length || (n.widgets = null);
								var o = kn(this);
								Kt(n, Math.max(0, n.height - o)),
									t &&
										(Ji(t, function () {
											To(t, n, -o), fi(t, i, "widget");
										}),
										ln(t, "lineWidgetCleared", t, this, i));
							}
						}),
							(bo.prototype.changed = function () {
								var t = this,
									e = this.height,
									n = this.doc.cm,
									i = this.line;
								this.height = null;
								var r = kn(this) - e;
								r &&
									(He(this.doc, i) || Kt(i, i.height + r),
									n &&
										Ji(n, function () {
											(n.curOp.forceUpdate = !0),
												To(n, i, r),
												ln(n, "lineWidgetChanged", n, t, Xt(i));
										}));
							}),
							_t(bo);
						var Co = 0,
							wo = function (t, e) {
								(this.lines = []),
									(this.type = e),
									(this.doc = t),
									(this.id = ++Co);
							};
						function Eo(t, e, n, i, r) {
							if (i && i.shared)
								return (function (t, e, n, i, r) {
									(i = P(i)).shared = !1;
									var o = [Eo(t, e, n, i, r)],
										s = o[0],
										a = i.widgetNode;
									return (
										$r(t, function (t) {
											a && (i.widgetNode = a.cloneNode(!0)),
												o.push(Eo(t, ae(t, e), ae(t, n), i, r));
											for (var l = 0; l < t.linked.length; ++l)
												if (t.linked[l].isParent) return;
											s = Y(o);
										}),
										new So(o, s)
									);
								})(t, e, n, i, r);
							if (t.cm && !t.cm.curOp) return tr(t.cm, Eo)(t, e, n, i, r);
							var o = new wo(t, r),
								s = ee(e, n);
							if (
								(i && P(i, o, !1), s > 0 || (0 == s && !1 !== o.clearWhenEmpty))
							)
								return o;
							if (
								(o.replacedWith &&
									((o.collapsed = !0),
									(o.widgetNode = O(
										"span",
										[o.replacedWith],
										"CodeMirror-widget"
									)),
									i.handleMouseEvents ||
										o.widgetNode.setAttribute("cm-ignore-events", "true"),
									i.insertLeft && (o.widgetNode.insertLeft = !0)),
								o.collapsed)
							) {
								if (
									Pe(t, e.line, e, n, o) ||
									(e.line != n.line && Pe(t, n.line, e, n, o))
								)
									throw new Error(
										"Inserting collapsed marker partially overlapping an existing one"
									);
								be = !0;
							}
							o.addToHistory &&
								Ur(t, { from: e, to: n, origin: "markText" }, t.sel, NaN);
							var a,
								l = e.line,
								c = t.cm;
							if (
								(t.iter(l, n.line + 1, function (i) {
									c &&
										o.collapsed &&
										!c.options.lineWrapping &&
										Fe(i) == c.display.maxLine &&
										(a = !0),
										o.collapsed && l != e.line && Kt(i, 0),
										(function (t, e, n) {
											var i =
												n &&
												window.WeakSet &&
												(n.markedSpans || (n.markedSpans = new WeakSet()));
											i && i.has(t.markedSpans)
												? t.markedSpans.push(e)
												: ((t.markedSpans = t.markedSpans
														? t.markedSpans.concat([e])
														: [e]),
												  i && i.add(t.markedSpans)),
												e.marker.attachLine(t);
										})(
											i,
											new Te(
												o,
												l == e.line ? e.ch : null,
												l == n.line ? n.ch : null
											),
											t.cm && t.cm.curOp
										),
										++l;
								}),
								o.collapsed &&
									t.iter(e.line, n.line + 1, function (e) {
										He(t, e) && Kt(e, 0);
									}),
								o.clearOnEnter &&
									ut(o, "beforeCursorEnter", function () {
										return o.clear();
									}),
								o.readOnly &&
									((ke = !0),
									(t.history.done.length || t.history.undone.length) &&
										t.clearHistory()),
								o.collapsed && ((o.id = ++Co), (o.atomic = !0)),
								c)
							) {
								if ((a && (c.curOp.updateMaxLine = !0), o.collapsed))
									ui(c, e.line, n.line + 1);
								else if (
									o.className ||
									o.startStyle ||
									o.endStyle ||
									o.css ||
									o.attributes ||
									o.title
								)
									for (var h = e.line; h <= n.line; h++) fi(c, h, "text");
								o.atomic && no(c.doc), ln(c, "markerAdded", c, o);
							}
							return o;
						}
						(wo.prototype.clear = function () {
							if (!this.explicitlyCleared) {
								var t = this.doc.cm,
									e = t && !t.curOp;
								if ((e && qi(t), vt(this, "clear"))) {
									var n = this.find();
									n && ln(this, "clear", n.from, n.to);
								}
								for (
									var i = null, r = null, o = 0;
									o < this.lines.length;
									++o
								) {
									var s = this.lines[o],
										a = Ce(s.markedSpans, this);
									t && !this.collapsed
										? fi(t, Xt(s), "text")
										: t &&
										  (null != a.to && (r = Xt(s)),
										  null != a.from && (i = Xt(s))),
										(s.markedSpans = we(s.markedSpans, a)),
										null == a.from &&
											this.collapsed &&
											!He(this.doc, s) &&
											t &&
											Kt(s, ii(t.display));
								}
								if (t && this.collapsed && !t.options.lineWrapping)
									for (var l = 0; l < this.lines.length; ++l) {
										var c = Fe(this.lines[l]),
											h = je(c);
										h > t.display.maxLineLength &&
											((t.display.maxLine = c),
											(t.display.maxLineLength = h),
											(t.display.maxLineChanged = !0));
									}
								null != i && t && this.collapsed && ui(t, i, r + 1),
									(this.lines.length = 0),
									(this.explicitlyCleared = !0),
									this.atomic &&
										this.doc.cantEdit &&
										((this.doc.cantEdit = !1), t && no(t.doc)),
									t && ln(t, "markerCleared", t, this, i, r),
									e && Vi(t),
									this.parent && this.parent.clear();
							}
						}),
							(wo.prototype.find = function (t, e) {
								var n, i;
								null == t && "bookmark" == this.type && (t = 1);
								for (var r = 0; r < this.lines.length; ++r) {
									var o = this.lines[r],
										s = Ce(o.markedSpans, this);
									if (
										null != s.from &&
										((n = te(e ? o : Xt(o), s.from)), -1 == t)
									)
										return n;
									if (null != s.to && ((i = te(e ? o : Xt(o), s.to)), 1 == t))
										return i;
								}
								return n && { from: n, to: i };
							}),
							(wo.prototype.changed = function () {
								var t = this,
									e = this.find(-1, !0),
									n = this,
									i = this.doc.cm;
								e &&
									i &&
									Ji(i, function () {
										var r = e.line,
											o = Xt(e.line),
											s = Nn(i, o);
										if (
											(s &&
												(Fn(s),
												(i.curOp.selectionChanged = i.curOp.forceUpdate = !0)),
											(i.curOp.updateMaxLine = !0),
											!He(n.doc, r) && null != n.height)
										) {
											var a = n.height;
											n.height = null;
											var l = kn(n) - a;
											l && Kt(r, r.height + l);
										}
										ln(i, "markerChanged", i, t);
									});
							}),
							(wo.prototype.attachLine = function (t) {
								if (!this.lines.length && this.doc.cm) {
									var e = this.doc.cm.curOp;
									(e.maybeHiddenMarkers &&
										-1 != U(e.maybeHiddenMarkers, this)) ||
										(
											e.maybeUnhiddenMarkers || (e.maybeUnhiddenMarkers = [])
										).push(this);
								}
								this.lines.push(t);
							}),
							(wo.prototype.detachLine = function (t) {
								if (
									(this.lines.splice(U(this.lines, t), 1),
									!this.lines.length && this.doc.cm)
								) {
									var e = this.doc.cm.curOp;
									(e.maybeHiddenMarkers || (e.maybeHiddenMarkers = [])).push(
										this
									);
								}
							}),
							_t(wo);
						var So = function (t, e) {
							(this.markers = t), (this.primary = e);
							for (var n = 0; n < t.length; ++n) t[n].parent = this;
						};
						function Ao(t) {
							return t.findMarks(
								te(t.first, 0),
								t.clipPos(te(t.lastLine())),
								function (t) {
									return t.parent;
								}
							);
						}
						function Lo(t) {
							for (
								var e = function (e) {
										var n = t[e],
											i = [n.primary.doc];
										$r(n.primary.doc, function (t) {
											return i.push(t);
										});
										for (var r = 0; r < n.markers.length; r++) {
											var o = n.markers[r];
											-1 == U(i, o.doc) &&
												((o.parent = null), n.markers.splice(r--, 1));
										}
									},
									n = 0;
								n < t.length;
								n++
							)
								e(n);
						}
						(So.prototype.clear = function () {
							if (!this.explicitlyCleared) {
								this.explicitlyCleared = !0;
								for (var t = 0; t < this.markers.length; ++t)
									this.markers[t].clear();
								ln(this, "clear");
							}
						}),
							(So.prototype.find = function (t, e) {
								return this.primary.find(t, e);
							}),
							_t(So);
						var Oo = 0,
							No = function (t, e, n, i, r) {
								if (!(this instanceof No)) return new No(t, e, n, i, r);
								null == n && (n = 0),
									ko.call(this, [new xo([new qe("", null)])]),
									(this.first = n),
									(this.scrollTop = this.scrollLeft = 0),
									(this.cantEdit = !1),
									(this.cleanGeneration = 1),
									(this.modeFrontier = this.highlightFrontier = n);
								var o = te(n, 0);
								(this.sel = wr(o)),
									(this.history = new Pr(null)),
									(this.id = ++Oo),
									(this.modeOption = e),
									(this.lineSep = i),
									(this.direction = "rtl" == r ? "rtl" : "ltr"),
									(this.extend = !1),
									"string" == typeof t && (t = this.splitLines(t)),
									Mr(this, { from: o, to: o, text: t }),
									Jr(this, wr(o), z);
							};
						(No.prototype = Q(ko.prototype, {
							constructor: No,
							iter: function (t, e, n) {
								n
									? this.iterN(t - this.first, e - t, n)
									: this.iterN(this.first, this.first + this.size, t);
							},
							insert: function (t, e) {
								for (var n = 0, i = 0; i < e.length; ++i) n += e[i].height;
								this.insertInner(t - this.first, e, n);
							},
							remove: function (t, e) {
								this.removeInner(t - this.first, e);
							},
							getValue: function (t) {
								var e = Yt(this, this.first, this.first + this.size);
								return !1 === t ? e : e.join(t || this.lineSeparator());
							},
							setValue: nr(function (t) {
								var e = te(this.first, 0),
									n = this.first + this.size - 1;
								co(
									this,
									{
										from: e,
										to: te(n, qt(this, n).text.length),
										text: this.splitLines(t),
										origin: "setValue",
										full: !0,
									},
									!0
								),
									this.cm && Ii(this.cm, 0, 0),
									Jr(this, wr(e), z);
							}),
							replaceRange: function (t, e, n, i) {
								go(this, t, (e = ae(this, e)), (n = n ? ae(this, n) : e), i);
							},
							getRange: function (t, e, n) {
								var i = Vt(this, ae(this, t), ae(this, e));
								return !1 === n
									? i
									: "" === n
									? i.join("")
									: i.join(n || this.lineSeparator());
							},
							getLine: function (t) {
								var e = this.getLineHandle(t);
								return e && e.text;
							},
							getLineHandle: function (t) {
								if (Zt(this, t)) return qt(this, t);
							},
							getLineNumber: function (t) {
								return Xt(t);
							},
							getLineHandleVisualStart: function (t) {
								return "number" == typeof t && (t = qt(this, t)), Fe(t);
							},
							lineCount: function () {
								return this.size;
							},
							firstLine: function () {
								return this.first;
							},
							lastLine: function () {
								return this.first + this.size - 1;
							},
							clipPos: function (t) {
								return ae(this, t);
							},
							getCursor: function (t) {
								var e = this.sel.primary();
								return null == t || "head" == t
									? e.head
									: "anchor" == t
									? e.anchor
									: "end" == t || "to" == t || !1 === t
									? e.to()
									: e.from();
							},
							listSelections: function () {
								return this.sel.ranges;
							},
							somethingSelected: function () {
								return this.sel.somethingSelected();
							},
							setCursor: nr(function (t, e, n) {
								Qr(
									this,
									ae(this, "number" == typeof t ? te(t, e || 0) : t),
									null,
									n
								);
							}),
							setSelection: nr(function (t, e, n) {
								Qr(this, ae(this, t), ae(this, e || t), n);
							}),
							extendSelection: nr(function (t, e, n) {
								Yr(this, ae(this, t), e && ae(this, e), n);
							}),
							extendSelections: nr(function (t, e) {
								Kr(this, le(this, t), e);
							}),
							extendSelectionsBy: nr(function (t, e) {
								Kr(this, le(this, K(this.sel.ranges, t)), e);
							}),
							setSelections: nr(function (t, e, n) {
								if (t.length) {
									for (var i = [], r = 0; r < t.length; r++)
										i[r] = new Tr(
											ae(this, t[r].anchor),
											ae(this, t[r].head || t[r].anchor)
										);
									null == e && (e = Math.min(t.length - 1, this.sel.primIndex)),
										Jr(this, Cr(this.cm, i, e), n);
								}
							}),
							addSelection: nr(function (t, e, n) {
								var i = this.sel.ranges.slice(0);
								i.push(new Tr(ae(this, t), ae(this, e || t))),
									Jr(this, Cr(this.cm, i, i.length - 1), n);
							}),
							getSelection: function (t) {
								for (var e, n = this.sel.ranges, i = 0; i < n.length; i++) {
									var r = Vt(this, n[i].from(), n[i].to());
									e = e ? e.concat(r) : r;
								}
								return !1 === t ? e : e.join(t || this.lineSeparator());
							},
							getSelections: function (t) {
								for (
									var e = [], n = this.sel.ranges, i = 0;
									i < n.length;
									i++
								) {
									var r = Vt(this, n[i].from(), n[i].to());
									!1 !== t && (r = r.join(t || this.lineSeparator())),
										(e[i] = r);
								}
								return e;
							},
							replaceSelection: function (t, e, n) {
								for (var i = [], r = 0; r < this.sel.ranges.length; r++)
									i[r] = t;
								this.replaceSelections(i, e, n || "+input");
							},
							replaceSelections: nr(function (t, e, n) {
								for (
									var i = [], r = this.sel, o = 0;
									o < r.ranges.length;
									o++
								) {
									var s = r.ranges[o];
									i[o] = {
										from: s.from(),
										to: s.to(),
										text: this.splitLines(t[o]),
										origin: n,
									};
								}
								for (
									var a =
											e &&
											"end" != e &&
											(function (t, e, n) {
												for (
													var i = [], r = te(t.first, 0), o = r, s = 0;
													s < e.length;
													s++
												) {
													var a = e[s],
														l = Lr(a.from, r, o),
														c = Lr(Er(a), r, o);
													if (((r = a.to), (o = c), "around" == n)) {
														var h = t.sel.ranges[s],
															u = ee(h.head, h.anchor) < 0;
														i[s] = new Tr(u ? c : l, u ? l : c);
													} else i[s] = new Tr(l, l);
												}
												return new br(i, t.sel.primIndex);
											})(this, i, e),
										l = i.length - 1;
									l >= 0;
									l--
								)
									co(this, i[l]);
								a ? Zr(this, a) : this.cm && Ni(this.cm);
							}),
							undo: nr(function () {
								uo(this, "undo");
							}),
							redo: nr(function () {
								uo(this, "redo");
							}),
							undoSelection: nr(function () {
								uo(this, "undo", !0);
							}),
							redoSelection: nr(function () {
								uo(this, "redo", !0);
							}),
							setExtending: function (t) {
								this.extend = t;
							},
							getExtending: function () {
								return this.extend;
							},
							historySize: function () {
								for (
									var t = this.history, e = 0, n = 0, i = 0;
									i < t.done.length;
									i++
								)
									t.done[i].ranges || ++e;
								for (var r = 0; r < t.undone.length; r++)
									t.undone[r].ranges || ++n;
								return { undo: e, redo: n };
							},
							clearHistory: function () {
								var t = this;
								(this.history = new Pr(this.history)),
									$r(
										this,
										function (e) {
											return (e.history = t.history);
										},
										!0
									);
							},
							markClean: function () {
								this.cleanGeneration = this.changeGeneration(!0);
							},
							changeGeneration: function (t) {
								return (
									t &&
										(this.history.lastOp =
											this.history.lastSelOp =
											this.history.lastOrigin =
												null),
									this.history.generation
								);
							},
							isClean: function (t) {
								return this.history.generation == (t || this.cleanGeneration);
							},
							getHistory: function () {
								return {
									done: qr(this.history.done),
									undone: qr(this.history.undone),
								};
							},
							setHistory: function (t) {
								var e = (this.history = new Pr(this.history));
								(e.done = qr(t.done.slice(0), null, !0)),
									(e.undone = qr(t.undone.slice(0), null, !0));
							},
							setGutterMarker: nr(function (t, e, n) {
								return yo(this, t, "gutter", function (t) {
									var i = t.gutterMarkers || (t.gutterMarkers = {});
									return (
										(i[e] = n), !n && et(i) && (t.gutterMarkers = null), !0
									);
								});
							}),
							clearGutter: nr(function (t) {
								var e = this;
								this.iter(function (n) {
									n.gutterMarkers &&
										n.gutterMarkers[t] &&
										yo(e, n, "gutter", function () {
											return (
												(n.gutterMarkers[t] = null),
												et(n.gutterMarkers) && (n.gutterMarkers = null),
												!0
											);
										});
								});
							}),
							lineInfo: function (t) {
								var e;
								if ("number" == typeof t) {
									if (!Zt(this, t)) return null;
									if (((e = t), !(t = qt(this, t)))) return null;
								} else if (null == (e = Xt(t))) return null;
								return {
									line: e,
									handle: t,
									text: t.text,
									gutterMarkers: t.gutterMarkers,
									textClass: t.textClass,
									bgClass: t.bgClass,
									wrapClass: t.wrapClass,
									widgets: t.widgets,
								};
							},
							addLineClass: nr(function (t, e, n) {
								return yo(
									this,
									t,
									"gutter" == e ? "gutter" : "class",
									function (t) {
										var i =
											"text" == e
												? "textClass"
												: "background" == e
												? "bgClass"
												: "gutter" == e
												? "gutterClass"
												: "wrapClass";
										if (t[i]) {
											if (C(n).test(t[i])) return !1;
											t[i] += " " + n;
										} else t[i] = n;
										return !0;
									}
								);
							}),
							removeLineClass: nr(function (t, e, n) {
								return yo(
									this,
									t,
									"gutter" == e ? "gutter" : "class",
									function (t) {
										var i =
												"text" == e
													? "textClass"
													: "background" == e
													? "bgClass"
													: "gutter" == e
													? "gutterClass"
													: "wrapClass",
											r = t[i];
										if (!r) return !1;
										if (null == n) t[i] = null;
										else {
											var o = r.match(C(n));
											if (!o) return !1;
											var s = o.index + o[0].length;
											t[i] =
												r.slice(0, o.index) +
													(o.index && s != r.length ? " " : "") +
													r.slice(s) || null;
										}
										return !0;
									}
								);
							}),
							addLineWidget: nr(function (t, e, n) {
								return (function (t, e, n, i) {
									var r = new bo(t, n, i),
										o = t.cm;
									return (
										o && r.noHScroll && (o.display.alignWidgets = !0),
										yo(t, e, "widget", function (e) {
											var n = e.widgets || (e.widgets = []);
											if (
												(null == r.insertAt
													? n.push(r)
													: n.splice(
															Math.min(n.length, Math.max(0, r.insertAt)),
															0,
															r
													  ),
												(r.line = e),
												o && !He(t, e))
											) {
												var i = We(e) < t.scrollTop;
												Kt(e, e.height + kn(r)),
													i && Oi(o, r.height),
													(o.curOp.forceUpdate = !0);
											}
											return !0;
										}),
										o &&
											ln(
												o,
												"lineWidgetAdded",
												o,
												r,
												"number" == typeof e ? e : Xt(e)
											),
										r
									);
								})(this, t, e, n);
							}),
							removeLineWidget: function (t) {
								t.clear();
							},
							markText: function (t, e, n) {
								return Eo(
									this,
									ae(this, t),
									ae(this, e),
									n,
									(n && n.type) || "range"
								);
							},
							setBookmark: function (t, e) {
								var n = {
									replacedWith: e && (null == e.nodeType ? e.widget : e),
									insertLeft: e && e.insertLeft,
									clearWhenEmpty: !1,
									shared: e && e.shared,
									handleMouseEvents: e && e.handleMouseEvents,
								};
								return Eo(this, (t = ae(this, t)), t, n, "bookmark");
							},
							findMarksAt: function (t) {
								var e = [],
									n = qt(this, (t = ae(this, t)).line).markedSpans;
								if (n)
									for (var i = 0; i < n.length; ++i) {
										var r = n[i];
										(null == r.from || r.from <= t.ch) &&
											(null == r.to || r.to >= t.ch) &&
											e.push(r.marker.parent || r.marker);
									}
								return e;
							},
							findMarks: function (t, e, n) {
								(t = ae(this, t)), (e = ae(this, e));
								var i = [],
									r = t.line;
								return (
									this.iter(t.line, e.line + 1, function (o) {
										var s = o.markedSpans;
										if (s)
											for (var a = 0; a < s.length; a++) {
												var l = s[a];
												(null != l.to && r == t.line && t.ch >= l.to) ||
													(null == l.from && r != t.line) ||
													(null != l.from && r == e.line && l.from >= e.ch) ||
													(n && !n(l.marker)) ||
													i.push(l.marker.parent || l.marker);
											}
										++r;
									}),
									i
								);
							},
							getAllMarks: function () {
								var t = [];
								return (
									this.iter(function (e) {
										var n = e.markedSpans;
										if (n)
											for (var i = 0; i < n.length; ++i)
												null != n[i].from && t.push(n[i].marker);
									}),
									t
								);
							},
							posFromIndex: function (t) {
								var e,
									n = this.first,
									i = this.lineSeparator().length;
								return (
									this.iter(function (r) {
										var o = r.text.length + i;
										if (o > t) return (e = t), !0;
										(t -= o), ++n;
									}),
									ae(this, te(n, e))
								);
							},
							indexFromPos: function (t) {
								var e = (t = ae(this, t)).ch;
								if (t.line < this.first || t.ch < 0) return 0;
								var n = this.lineSeparator().length;
								return (
									this.iter(this.first, t.line, function (t) {
										e += t.text.length + n;
									}),
									e
								);
							},
							copy: function (t) {
								var e = new No(
									Yt(this, this.first, this.first + this.size),
									this.modeOption,
									this.first,
									this.lineSep,
									this.direction
								);
								return (
									(e.scrollTop = this.scrollTop),
									(e.scrollLeft = this.scrollLeft),
									(e.sel = this.sel),
									(e.extend = !1),
									t &&
										((e.history.undoDepth = this.history.undoDepth),
										e.setHistory(this.getHistory())),
									e
								);
							},
							linkedDoc: function (t) {
								t || (t = {});
								var e = this.first,
									n = this.first + this.size;
								null != t.from && t.from > e && (e = t.from),
									null != t.to && t.to < n && (n = t.to);
								var i = new No(
									Yt(this, e, n),
									t.mode || this.modeOption,
									e,
									this.lineSep,
									this.direction
								);
								return (
									t.sharedHist && (i.history = this.history),
									(this.linked || (this.linked = [])).push({
										doc: i,
										sharedHist: t.sharedHist,
									}),
									(i.linked = [
										{ doc: this, isParent: !0, sharedHist: t.sharedHist },
									]),
									(function (t, e) {
										for (var n = 0; n < e.length; n++) {
											var i = e[n],
												r = i.find(),
												o = t.clipPos(r.from),
												s = t.clipPos(r.to);
											if (ee(o, s)) {
												var a = Eo(t, o, s, i.primary, i.primary.type);
												i.markers.push(a), (a.parent = i);
											}
										}
									})(i, Ao(this)),
									i
								);
							},
							unlinkDoc: function (t) {
								if ((t instanceof Ss && (t = t.doc), this.linked))
									for (var e = 0; e < this.linked.length; ++e)
										if (this.linked[e].doc == t) {
											this.linked.splice(e, 1), t.unlinkDoc(this), Lo(Ao(this));
											break;
										}
								if (t.history == this.history) {
									var n = [t.id];
									$r(
										t,
										function (t) {
											return n.push(t.id);
										},
										!0
									),
										(t.history = new Pr(null)),
										(t.history.done = qr(this.history.done, n)),
										(t.history.undone = qr(this.history.undone, n));
								}
							},
							iterLinkedDocs: function (t) {
								$r(this, t);
							},
							getMode: function () {
								return this.mode;
							},
							getEditor: function () {
								return this.cm;
							},
							splitLines: function (t) {
								return this.lineSep ? t.split(this.lineSep) : Nt(t);
							},
							lineSeparator: function () {
								return this.lineSep || "\n";
							},
							setDirection: nr(function (t) {
								var e;
								"rtl" != t && (t = "ltr"),
									t != this.direction &&
										((this.direction = t),
										this.iter(function (t) {
											return (t.order = null);
										}),
										this.cm &&
											Ji((e = this.cm), function () {
												Dr(e), ui(e);
											}));
							}),
						})),
							(No.prototype.eachLine = No.prototype.iter);
						var Io = 0;
						function Mo(t) {
							var e = this;
							if (($o(e), !gt(e, t) && !bn(e.display, t))) {
								yt(t), s && (Io = +new Date());
								var n = ci(e, t, !0),
									i = t.dataTransfer.files;
								if (n && !e.isReadOnly())
									if (i && i.length && window.FileReader && window.File)
										for (
											var r = i.length,
												o = Array(r),
												a = 0,
												l = function () {
													++a == r &&
														tr(e, function () {
															var t = {
																from: (n = ae(e.doc, n)),
																to: n,
																text: e.doc.splitLines(
																	o
																		.filter(function (t) {
																			return null != t;
																		})
																		.join(e.doc.lineSeparator())
																),
																origin: "paste",
															};
															co(e.doc, t),
																Zr(e.doc, wr(ae(e.doc, n), ae(e.doc, Er(t))));
														})();
												},
												c = function (t, n) {
													if (
														e.options.allowDropFileTypes &&
														-1 == U(e.options.allowDropFileTypes, t.type)
													)
														l();
													else {
														var i = new FileReader();
														(i.onerror = function () {
															return l();
														}),
															(i.onload = function () {
																var t = i.result;
																/[\x00-\x08\x0e-\x1f]{2}/.test(t) || (o[n] = t),
																	l();
															}),
															i.readAsText(t);
													}
												},
												h = 0;
											h < i.length;
											h++
										)
											c(i[h], h);
									else {
										if (e.state.draggingText && e.doc.sel.contains(n) > -1)
											return (
												e.state.draggingText(t),
												void setTimeout(function () {
													return e.display.input.focus();
												}, 20)
											);
										try {
											var u = t.dataTransfer.getData("Text");
											if (u) {
												var f;
												if (
													(e.state.draggingText &&
														!e.state.draggingText.copy &&
														(f = e.listSelections()),
													to(e.doc, wr(n, n)),
													f)
												)
													for (var d = 0; d < f.length; ++d)
														go(e.doc, "", f[d].anchor, f[d].head, "drag");
												e.replaceSelection(u, "around", "paste"),
													e.display.input.focus();
											}
										} catch (t) {}
									}
							}
						}
						function $o(t) {
							t.display.dragCursor &&
								(t.display.lineSpace.removeChild(t.display.dragCursor),
								(t.display.dragCursor = null));
						}
						function Ro(t) {
							if (document.getElementsByClassName) {
								for (
									var e = document.getElementsByClassName("CodeMirror"),
										n = [],
										i = 0;
									i < e.length;
									i++
								) {
									var r = e[i].CodeMirror;
									r && n.push(r);
								}
								n.length &&
									n[0].operation(function () {
										for (var e = 0; e < n.length; e++) t(n[e]);
									});
							}
						}
						var Do = !1;
						function Po() {
							var t;
							Do ||
								(ut(window, "resize", function () {
									null == t &&
										(t = setTimeout(function () {
											(t = null), Ro(Fo);
										}, 100));
								}),
								ut(window, "blur", function () {
									return Ro(wi);
								}),
								(Do = !0));
						}
						function Fo(t) {
							var e = t.display;
							(e.cachedCharWidth =
								e.cachedTextHeight =
								e.cachedPaddingH =
									null),
								(e.scrollbarsClipped = !1),
								t.setSize();
						}
						for (
							var Bo = {
									3: "Pause",
									8: "Backspace",
									9: "Tab",
									13: "Enter",
									16: "Shift",
									17: "Ctrl",
									18: "Alt",
									19: "Pause",
									20: "CapsLock",
									27: "Esc",
									32: "Space",
									33: "PageUp",
									34: "PageDown",
									35: "End",
									36: "Home",
									37: "Left",
									38: "Up",
									39: "Right",
									40: "Down",
									44: "PrintScrn",
									45: "Insert",
									46: "Delete",
									59: ";",
									61: "=",
									91: "Mod",
									92: "Mod",
									93: "Mod",
									106: "*",
									107: "=",
									109: "-",
									110: ".",
									111: "/",
									145: "ScrollLock",
									173: "-",
									186: ";",
									187: "=",
									188: ",",
									189: "-",
									190: ".",
									191: "/",
									192: "`",
									219: "[",
									220: "\\",
									221: "]",
									222: "'",
									224: "Mod",
									63232: "Up",
									63233: "Down",
									63234: "Left",
									63235: "Right",
									63272: "Delete",
									63273: "Home",
									63275: "End",
									63276: "PageUp",
									63277: "PageDown",
									63302: "Insert",
								},
								Uo = 0;
							Uo < 10;
							Uo++
						)
							Bo[Uo + 48] = Bo[Uo + 96] = String(Uo);
						for (var Ho = 65; Ho <= 90; Ho++) Bo[Ho] = String.fromCharCode(Ho);
						for (var zo = 1; zo <= 12; zo++)
							Bo[zo + 111] = Bo[zo + 63235] = "F" + zo;
						var Wo = {};
						function jo(t) {
							var e,
								n,
								i,
								r,
								o = t.split(/-(?!$)/);
							t = o[o.length - 1];
							for (var s = 0; s < o.length - 1; s++) {
								var a = o[s];
								if (/^(cmd|meta|m)$/i.test(a)) r = !0;
								else if (/^a(lt)?$/i.test(a)) e = !0;
								else if (/^(c|ctrl|control)$/i.test(a)) n = !0;
								else {
									if (!/^s(hift)?$/i.test(a))
										throw new Error("Unrecognized modifier name: " + a);
									i = !0;
								}
							}
							return (
								e && (t = "Alt-" + t),
								n && (t = "Ctrl-" + t),
								r && (t = "Cmd-" + t),
								i && (t = "Shift-" + t),
								t
							);
						}
						function Go(t) {
							var e = {};
							for (var n in t)
								if (t.hasOwnProperty(n)) {
									var i = t[n];
									if (/^(name|fallthrough|(de|at)tach)$/.test(n)) continue;
									if ("..." == i) {
										delete t[n];
										continue;
									}
									for (var r = K(n.split(" "), jo), o = 0; o < r.length; o++) {
										var s = void 0,
											a = void 0;
										o == r.length - 1
											? ((a = r.join(" ")), (s = i))
											: ((a = r.slice(0, o + 1).join(" ")), (s = "..."));
										var l = e[a];
										if (l) {
											if (l != s)
												throw new Error("Inconsistent bindings for " + a);
										} else e[a] = s;
									}
									delete t[n];
								}
							for (var c in e) t[c] = e[c];
							return t;
						}
						function qo(t, e, n, i) {
							var r = (e = Xo(e)).call ? e.call(t, i) : e[t];
							if (!1 === r) return "nothing";
							if ("..." === r) return "multi";
							if (null != r && n(r)) return "handled";
							if (e.fallthrough) {
								if (
									"[object Array]" !=
									Object.prototype.toString.call(e.fallthrough)
								)
									return qo(t, e.fallthrough, n, i);
								for (var o = 0; o < e.fallthrough.length; o++) {
									var s = qo(t, e.fallthrough[o], n, i);
									if (s) return s;
								}
							}
						}
						function Vo(t) {
							var e = "string" == typeof t ? t : Bo[t.keyCode];
							return "Ctrl" == e || "Alt" == e || "Shift" == e || "Mod" == e;
						}
						function Yo(t, e, n) {
							var i = t;
							return (
								e.altKey && "Alt" != i && (t = "Alt-" + t),
								(b ? e.metaKey : e.ctrlKey) && "Ctrl" != i && (t = "Ctrl-" + t),
								(b ? e.ctrlKey : e.metaKey) && "Mod" != i && (t = "Cmd-" + t),
								!n && e.shiftKey && "Shift" != i && (t = "Shift-" + t),
								t
							);
						}
						function Ko(t, e) {
							if (u && 34 == t.keyCode && t.char) return !1;
							var n = Bo[t.keyCode];
							return (
								null != n &&
								!t.altGraphKey &&
								(3 == t.keyCode && t.code && (n = t.code), Yo(n, t, e))
							);
						}
						function Xo(t) {
							return "string" == typeof t ? Wo[t] : t;
						}
						function Qo(t, e) {
							for (var n = t.doc.sel.ranges, i = [], r = 0; r < n.length; r++) {
								for (var o = e(n[r]); i.length && ee(o.from, Y(i).to) <= 0; ) {
									var s = i.pop();
									if (ee(s.from, o.from) < 0) {
										o.from = s.from;
										break;
									}
								}
								i.push(o);
							}
							Ji(t, function () {
								for (var e = i.length - 1; e >= 0; e--)
									go(t.doc, "", i[e].from, i[e].to, "+delete");
								Ni(t);
							});
						}
						function Zo(t, e, n) {
							var i = rt(t.text, e + n, n);
							return i < 0 || i > t.text.length ? null : i;
						}
						function Jo(t, e, n) {
							var i = Zo(t, e.ch, n);
							return null == i
								? null
								: new te(e.line, i, n < 0 ? "after" : "before");
						}
						function ts(t, e, n, i, r) {
							if (t) {
								"rtl" == e.doc.direction && (r = -r);
								var o = ct(n, e.doc.direction);
								if (o) {
									var s,
										a = r < 0 ? Y(o) : o[0],
										l = r < 0 == (1 == a.level) ? "after" : "before";
									if (a.level > 0 || "rtl" == e.doc.direction) {
										var c = In(e, n);
										s = r < 0 ? n.text.length - 1 : 0;
										var h = Mn(e, c, s).top;
										(s = ot(
											function (t) {
												return Mn(e, c, t).top == h;
											},
											r < 0 == (1 == a.level) ? a.from : a.to - 1,
											s
										)),
											"before" == l && (s = Zo(n, s, 1));
									} else s = r < 0 ? a.to : a.from;
									return new te(i, s, l);
								}
							}
							return new te(
								i,
								r < 0 ? n.text.length : 0,
								r < 0 ? "before" : "after"
							);
						}
						(Wo.basic = {
							Left: "goCharLeft",
							Right: "goCharRight",
							Up: "goLineUp",
							Down: "goLineDown",
							End: "goLineEnd",
							Home: "goLineStartSmart",
							PageUp: "goPageUp",
							PageDown: "goPageDown",
							Delete: "delCharAfter",
							Backspace: "delCharBefore",
							"Shift-Backspace": "delCharBefore",
							Tab: "defaultTab",
							"Shift-Tab": "indentAuto",
							Enter: "newlineAndIndent",
							Insert: "toggleOverwrite",
							Esc: "singleSelection",
						}),
							(Wo.pcDefault = {
								"Ctrl-A": "selectAll",
								"Ctrl-D": "deleteLine",
								"Ctrl-Z": "undo",
								"Shift-Ctrl-Z": "redo",
								"Ctrl-Y": "redo",
								"Ctrl-Home": "goDocStart",
								"Ctrl-End": "goDocEnd",
								"Ctrl-Up": "goLineUp",
								"Ctrl-Down": "goLineDown",
								"Ctrl-Left": "goGroupLeft",
								"Ctrl-Right": "goGroupRight",
								"Alt-Left": "goLineStart",
								"Alt-Right": "goLineEnd",
								"Ctrl-Backspace": "delGroupBefore",
								"Ctrl-Delete": "delGroupAfter",
								"Ctrl-S": "save",
								"Ctrl-F": "find",
								"Ctrl-G": "findNext",
								"Shift-Ctrl-G": "findPrev",
								"Shift-Ctrl-F": "replace",
								"Shift-Ctrl-R": "replaceAll",
								"Ctrl-[": "indentLess",
								"Ctrl-]": "indentMore",
								"Ctrl-U": "undoSelection",
								"Shift-Ctrl-U": "redoSelection",
								"Alt-U": "redoSelection",
								fallthrough: "basic",
							}),
							(Wo.emacsy = {
								"Ctrl-F": "goCharRight",
								"Ctrl-B": "goCharLeft",
								"Ctrl-P": "goLineUp",
								"Ctrl-N": "goLineDown",
								"Ctrl-A": "goLineStart",
								"Ctrl-E": "goLineEnd",
								"Ctrl-V": "goPageDown",
								"Shift-Ctrl-V": "goPageUp",
								"Ctrl-D": "delCharAfter",
								"Ctrl-H": "delCharBefore",
								"Alt-Backspace": "delWordBefore",
								"Ctrl-K": "killLine",
								"Ctrl-T": "transposeChars",
								"Ctrl-O": "openLine",
							}),
							(Wo.macDefault = {
								"Cmd-A": "selectAll",
								"Cmd-D": "deleteLine",
								"Cmd-Z": "undo",
								"Shift-Cmd-Z": "redo",
								"Cmd-Y": "redo",
								"Cmd-Home": "goDocStart",
								"Cmd-Up": "goDocStart",
								"Cmd-End": "goDocEnd",
								"Cmd-Down": "goDocEnd",
								"Alt-Left": "goGroupLeft",
								"Alt-Right": "goGroupRight",
								"Cmd-Left": "goLineLeft",
								"Cmd-Right": "goLineRight",
								"Alt-Backspace": "delGroupBefore",
								"Ctrl-Alt-Backspace": "delGroupAfter",
								"Alt-Delete": "delGroupAfter",
								"Cmd-S": "save",
								"Cmd-F": "find",
								"Cmd-G": "findNext",
								"Shift-Cmd-G": "findPrev",
								"Cmd-Alt-F": "replace",
								"Shift-Cmd-Alt-F": "replaceAll",
								"Cmd-[": "indentLess",
								"Cmd-]": "indentMore",
								"Cmd-Backspace": "delWrappedLineLeft",
								"Cmd-Delete": "delWrappedLineRight",
								"Cmd-U": "undoSelection",
								"Shift-Cmd-U": "redoSelection",
								"Ctrl-Up": "goDocStart",
								"Ctrl-Down": "goDocEnd",
								fallthrough: ["basic", "emacsy"],
							}),
							(Wo.default = _ ? Wo.macDefault : Wo.pcDefault);
						var es = {
							selectAll: ao,
							singleSelection: function (t) {
								return t.setSelection(
									t.getCursor("anchor"),
									t.getCursor("head"),
									z
								);
							},
							killLine: function (t) {
								return Qo(t, function (e) {
									if (e.empty()) {
										var n = qt(t.doc, e.head.line).text.length;
										return e.head.ch == n && e.head.line < t.lastLine()
											? { from: e.head, to: te(e.head.line + 1, 0) }
											: { from: e.head, to: te(e.head.line, n) };
									}
									return { from: e.from(), to: e.to() };
								});
							},
							deleteLine: function (t) {
								return Qo(t, function (e) {
									return {
										from: te(e.from().line, 0),
										to: ae(t.doc, te(e.to().line + 1, 0)),
									};
								});
							},
							delLineLeft: function (t) {
								return Qo(t, function (t) {
									return { from: te(t.from().line, 0), to: t.from() };
								});
							},
							delWrappedLineLeft: function (t) {
								return Qo(t, function (e) {
									var n = t.charCoords(e.head, "div").top + 5;
									return {
										from: t.coordsChar({ left: 0, top: n }, "div"),
										to: e.from(),
									};
								});
							},
							delWrappedLineRight: function (t) {
								return Qo(t, function (e) {
									var n = t.charCoords(e.head, "div").top + 5,
										i = t.coordsChar(
											{ left: t.display.lineDiv.offsetWidth + 100, top: n },
											"div"
										);
									return { from: e.from(), to: i };
								});
							},
							undo: function (t) {
								return t.undo();
							},
							redo: function (t) {
								return t.redo();
							},
							undoSelection: function (t) {
								return t.undoSelection();
							},
							redoSelection: function (t) {
								return t.redoSelection();
							},
							goDocStart: function (t) {
								return t.extendSelection(te(t.firstLine(), 0));
							},
							goDocEnd: function (t) {
								return t.extendSelection(te(t.lastLine()));
							},
							goLineStart: function (t) {
								return t.extendSelectionsBy(
									function (e) {
										return ns(t, e.head.line);
									},
									{ origin: "+move", bias: 1 }
								);
							},
							goLineStartSmart: function (t) {
								return t.extendSelectionsBy(
									function (e) {
										return is(t, e.head);
									},
									{ origin: "+move", bias: 1 }
								);
							},
							goLineEnd: function (t) {
								return t.extendSelectionsBy(
									function (e) {
										return (function (t, e) {
											var n = qt(t.doc, e),
												i = (function (t) {
													for (var e; (e = Re(t)); ) t = e.find(1, !0).line;
													return t;
												})(n);
											return i != n && (e = Xt(i)), ts(!0, t, n, e, -1);
										})(t, e.head.line);
									},
									{ origin: "+move", bias: -1 }
								);
							},
							goLineRight: function (t) {
								return t.extendSelectionsBy(function (e) {
									var n = t.cursorCoords(e.head, "div").top + 5;
									return t.coordsChar(
										{ left: t.display.lineDiv.offsetWidth + 100, top: n },
										"div"
									);
								}, j);
							},
							goLineLeft: function (t) {
								return t.extendSelectionsBy(function (e) {
									var n = t.cursorCoords(e.head, "div").top + 5;
									return t.coordsChar({ left: 0, top: n }, "div");
								}, j);
							},
							goLineLeftSmart: function (t) {
								return t.extendSelectionsBy(function (e) {
									var n = t.cursorCoords(e.head, "div").top + 5,
										i = t.coordsChar({ left: 0, top: n }, "div");
									return i.ch < t.getLine(i.line).search(/\S/)
										? is(t, e.head)
										: i;
								}, j);
							},
							goLineUp: function (t) {
								return t.moveV(-1, "line");
							},
							goLineDown: function (t) {
								return t.moveV(1, "line");
							},
							goPageUp: function (t) {
								return t.moveV(-1, "page");
							},
							goPageDown: function (t) {
								return t.moveV(1, "page");
							},
							goCharLeft: function (t) {
								return t.moveH(-1, "char");
							},
							goCharRight: function (t) {
								return t.moveH(1, "char");
							},
							goColumnLeft: function (t) {
								return t.moveH(-1, "column");
							},
							goColumnRight: function (t) {
								return t.moveH(1, "column");
							},
							goWordLeft: function (t) {
								return t.moveH(-1, "word");
							},
							goGroupRight: function (t) {
								return t.moveH(1, "group");
							},
							goGroupLeft: function (t) {
								return t.moveH(-1, "group");
							},
							goWordRight: function (t) {
								return t.moveH(1, "word");
							},
							delCharBefore: function (t) {
								return t.deleteH(-1, "codepoint");
							},
							delCharAfter: function (t) {
								return t.deleteH(1, "char");
							},
							delWordBefore: function (t) {
								return t.deleteH(-1, "word");
							},
							delWordAfter: function (t) {
								return t.deleteH(1, "word");
							},
							delGroupBefore: function (t) {
								return t.deleteH(-1, "group");
							},
							delGroupAfter: function (t) {
								return t.deleteH(1, "group");
							},
							indentAuto: function (t) {
								return t.indentSelection("smart");
							},
							indentMore: function (t) {
								return t.indentSelection("add");
							},
							indentLess: function (t) {
								return t.indentSelection("subtract");
							},
							insertTab: function (t) {
								return t.replaceSelection("\t");
							},
							insertSoftTab: function (t) {
								for (
									var e = [],
										n = t.listSelections(),
										i = t.options.tabSize,
										r = 0;
									r < n.length;
									r++
								) {
									var o = n[r].from(),
										s = F(t.getLine(o.line), o.ch, i);
									e.push(V(i - (s % i)));
								}
								t.replaceSelections(e);
							},
							defaultTab: function (t) {
								t.somethingSelected()
									? t.indentSelection("add")
									: t.execCommand("insertTab");
							},
							transposeChars: function (t) {
								return Ji(t, function () {
									for (
										var e = t.listSelections(), n = [], i = 0;
										i < e.length;
										i++
									)
										if (e[i].empty()) {
											var r = e[i].head,
												o = qt(t.doc, r.line).text;
											if (o)
												if (
													(r.ch == o.length && (r = new te(r.line, r.ch - 1)),
													r.ch > 0)
												)
													(r = new te(r.line, r.ch + 1)),
														t.replaceRange(
															o.charAt(r.ch - 1) + o.charAt(r.ch - 2),
															te(r.line, r.ch - 2),
															r,
															"+transpose"
														);
												else if (r.line > t.doc.first) {
													var s = qt(t.doc, r.line - 1).text;
													s &&
														((r = new te(r.line, 1)),
														t.replaceRange(
															o.charAt(0) +
																t.doc.lineSeparator() +
																s.charAt(s.length - 1),
															te(r.line - 1, s.length - 1),
															r,
															"+transpose"
														));
												}
											n.push(new Tr(r, r));
										}
									t.setSelections(n);
								});
							},
							newlineAndIndent: function (t) {
								return Ji(t, function () {
									for (
										var e = t.listSelections(), n = e.length - 1;
										n >= 0;
										n--
									)
										t.replaceRange(
											t.doc.lineSeparator(),
											e[n].anchor,
											e[n].head,
											"+input"
										);
									e = t.listSelections();
									for (var i = 0; i < e.length; i++)
										t.indentLine(e[i].from().line, null, !0);
									Ni(t);
								});
							},
							openLine: function (t) {
								return t.replaceSelection("\n", "start");
							},
							toggleOverwrite: function (t) {
								return t.toggleOverwrite();
							},
						};
						function ns(t, e) {
							var n = qt(t.doc, e),
								i = Fe(n);
							return i != n && (e = Xt(i)), ts(!0, t, i, e, 1);
						}
						function is(t, e) {
							var n = ns(t, e.line),
								i = qt(t.doc, n.line),
								r = ct(i, t.doc.direction);
							if (!r || 0 == r[0].level) {
								var o = Math.max(n.ch, i.text.search(/\S/)),
									s = e.line == n.line && e.ch <= o && e.ch;
								return te(n.line, s ? 0 : o, n.sticky);
							}
							return n;
						}
						function rs(t, e, n) {
							if ("string" == typeof e && !(e = es[e])) return !1;
							t.display.input.ensurePolled();
							var i = t.display.shift,
								r = !1;
							try {
								t.isReadOnly() && (t.state.suppressEdits = !0),
									n && (t.display.shift = !1),
									(r = e(t) != H);
							} finally {
								(t.display.shift = i), (t.state.suppressEdits = !1);
							}
							return r;
						}
						var os = new B();
						function ss(t, e, n, i) {
							var r = t.state.keySeq;
							if (r) {
								if (Vo(e)) return "handled";
								if (
									(/\'$/.test(e)
										? (t.state.keySeq = null)
										: os.set(50, function () {
												t.state.keySeq == r &&
													((t.state.keySeq = null), t.display.input.reset());
										  }),
									as(t, r + " " + e, n, i))
								)
									return !0;
							}
							return as(t, e, n, i);
						}
						function as(t, e, n, i) {
							var r = (function (t, e, n) {
								for (var i = 0; i < t.state.keyMaps.length; i++) {
									var r = qo(e, t.state.keyMaps[i], n, t);
									if (r) return r;
								}
								return (
									(t.options.extraKeys && qo(e, t.options.extraKeys, n, t)) ||
									qo(e, t.options.keyMap, n, t)
								);
							})(t, e, i);
							return (
								"multi" == r && (t.state.keySeq = e),
								"handled" == r && ln(t, "keyHandled", t, e, n),
								("handled" != r && "multi" != r) || (yt(n), ki(t)),
								!!r
							);
						}
						function ls(t, e) {
							var n = Ko(e, !0);
							return (
								!!n &&
								(e.shiftKey && !t.state.keySeq
									? ss(t, "Shift-" + n, e, function (e) {
											return rs(t, e, !0);
									  }) ||
									  ss(t, n, e, function (e) {
											if ("string" == typeof e ? /^go[A-Z]/.test(e) : e.motion)
												return rs(t, e);
									  })
									: ss(t, n, e, function (e) {
											return rs(t, e);
									  }))
							);
						}
						var cs = null;
						function hs(t) {
							var e = this;
							if (
								!(
									(t.target && t.target != e.display.input.getField()) ||
									((e.curOp.focus = I()), gt(e, t))
								)
							) {
								s && a < 11 && 27 == t.keyCode && (t.returnValue = !1);
								var i = t.keyCode;
								e.display.shift = 16 == i || t.shiftKey;
								var r = ls(e, t);
								u &&
									((cs = r ? i : null),
									r ||
										88 != i ||
										Mt ||
										!(_ ? t.metaKey : t.ctrlKey) ||
										e.replaceSelection("", null, "cut")),
									n &&
										!_ &&
										!r &&
										46 == i &&
										t.shiftKey &&
										!t.ctrlKey &&
										document.execCommand &&
										document.execCommand("cut"),
									18 != i ||
										/\bCodeMirror-crosshair\b/.test(
											e.display.lineDiv.className
										) ||
										(function (t) {
											var e = t.display.lineDiv;
											function n(t) {
												(18 != t.keyCode && t.altKey) ||
													(E(e, "CodeMirror-crosshair"),
													dt(document, "keyup", n),
													dt(document, "mouseover", n));
											}
											M(e, "CodeMirror-crosshair"),
												ut(document, "keyup", n),
												ut(document, "mouseover", n);
										})(e);
							}
						}
						function us(t) {
							16 == t.keyCode && (this.doc.sel.shift = !1), gt(this, t);
						}
						function fs(t) {
							var e = this;
							if (
								!(
									(t.target && t.target != e.display.input.getField()) ||
									bn(e.display, t) ||
									gt(e, t) ||
									(t.ctrlKey && !t.altKey) ||
									(_ && t.metaKey)
								)
							) {
								var n = t.keyCode,
									i = t.charCode;
								if (u && n == cs) return (cs = null), void yt(t);
								if (!u || (t.which && !(t.which < 10)) || !ls(e, t)) {
									var r = String.fromCharCode(null == i ? n : i);
									"\b" != r &&
										((function (t, e, n) {
											return ss(t, "'" + n + "'", e, function (e) {
												return rs(t, e, !0);
											});
										})(e, t, r) ||
											e.display.input.onKeyPress(t));
								}
							}
						}
						var ds,
							ps,
							gs = function (t, e, n) {
								(this.time = t), (this.pos = e), (this.button = n);
							};
						function ms(t) {
							var e = this,
								n = e.display;
							if (!(gt(e, t) || (n.activeTouch && n.input.supportsTouch())))
								if ((n.input.ensurePolled(), (n.shift = t.shiftKey), bn(n, t)))
									l ||
										((n.scroller.draggable = !1),
										setTimeout(function () {
											return (n.scroller.draggable = !0);
										}, 100));
								else if (!ys(e, t)) {
									var i = ci(e, t),
										r = Ct(t),
										o = i
											? (function (t, e) {
													var n = +new Date();
													return ps && ps.compare(n, t, e)
														? ((ds = ps = null), "triple")
														: ds && ds.compare(n, t, e)
														? ((ps = new gs(n, t, e)), (ds = null), "double")
														: ((ds = new gs(n, t, e)), (ps = null), "single");
											  })(i, r)
											: "single";
									window.focus(),
										1 == r && e.state.selectingText && e.state.selectingText(t),
										(i &&
											(function (t, e, n, i, r) {
												var o = "Click";
												return (
													"double" == i
														? (o = "Double" + o)
														: "triple" == i && (o = "Triple" + o),
													ss(
														t,
														Yo(
															(o =
																(1 == e
																	? "Left"
																	: 2 == e
																	? "Middle"
																	: "Right") + o),
															r
														),
														r,
														function (e) {
															if (("string" == typeof e && (e = es[e]), !e))
																return !1;
															var i = !1;
															try {
																t.isReadOnly() && (t.state.suppressEdits = !0),
																	(i = e(t, n) != H);
															} finally {
																t.state.suppressEdits = !1;
															}
															return i;
														}
													)
												);
											})(e, r, i, o, t)) ||
											(1 == r
												? i
													? (function (t, e, n, i) {
															s
																? setTimeout(D(bi, t), 0)
																: (t.curOp.focus = I());
															var r,
																o = (function (t, e, n) {
																	var i = t.getOption("configureMouse"),
																		r = i ? i(t, e, n) : {};
																	if (null == r.unit) {
																		var o = y
																			? n.shiftKey && n.metaKey
																			: n.altKey;
																		r.unit = o
																			? "rectangle"
																			: "single" == e
																			? "char"
																			: "double" == e
																			? "word"
																			: "line";
																	}
																	return (
																		(null == r.extend || t.doc.extend) &&
																			(r.extend = t.doc.extend || n.shiftKey),
																		null == r.addNew &&
																			(r.addNew = _ ? n.metaKey : n.ctrlKey),
																		null == r.moveOnDrag &&
																			(r.moveOnDrag = !(_
																				? n.altKey
																				: n.ctrlKey)),
																		r
																	);
																})(t, n, i),
																c = t.doc.sel;
															t.options.dragDrop &&
															St &&
															!t.isReadOnly() &&
															"single" == n &&
															(r = c.contains(e)) > -1 &&
															(ee((r = c.ranges[r]).from(), e) < 0 ||
																e.xRel > 0) &&
															(ee(r.to(), e) > 0 || e.xRel < 0)
																? (function (t, e, n, i) {
																		var r = t.display,
																			o = !1,
																			c = tr(t, function (e) {
																				l && (r.scroller.draggable = !1),
																					(t.state.draggingText = !1),
																					t.state.delayingBlurEvent &&
																						(t.hasFocus()
																							? (t.state.delayingBlurEvent = !1)
																							: Ti(t)),
																					dt(
																						r.wrapper.ownerDocument,
																						"mouseup",
																						c
																					),
																					dt(
																						r.wrapper.ownerDocument,
																						"mousemove",
																						h
																					),
																					dt(r.scroller, "dragstart", u),
																					dt(r.scroller, "drop", c),
																					o ||
																						(yt(e),
																						i.addNew ||
																							Yr(
																								t.doc,
																								n,
																								null,
																								null,
																								i.extend
																							),
																						(l && !f) || (s && 9 == a)
																							? setTimeout(function () {
																									r.wrapper.ownerDocument.body.focus(
																										{ preventScroll: !0 }
																									),
																										r.input.focus();
																							  }, 20)
																							: r.input.focus());
																			}),
																			h = function (t) {
																				o =
																					o ||
																					Math.abs(e.clientX - t.clientX) +
																						Math.abs(e.clientY - t.clientY) >=
																						10;
																			},
																			u = function () {
																				return (o = !0);
																			};
																		l && (r.scroller.draggable = !0),
																			(t.state.draggingText = c),
																			(c.copy = !i.moveOnDrag),
																			ut(r.wrapper.ownerDocument, "mouseup", c),
																			ut(
																				r.wrapper.ownerDocument,
																				"mousemove",
																				h
																			),
																			ut(r.scroller, "dragstart", u),
																			ut(r.scroller, "drop", c),
																			(t.state.delayingBlurEvent = !0),
																			setTimeout(function () {
																				return r.input.focus();
																			}, 20),
																			r.scroller.dragDrop &&
																				r.scroller.dragDrop();
																  })(t, i, e, o)
																: (function (t, e, n, i) {
																		s && Ti(t);
																		var r = t.display,
																			o = t.doc;
																		yt(e);
																		var a,
																			l,
																			c = o.sel,
																			h = c.ranges;
																		if (
																			(i.addNew && !i.extend
																				? ((l = o.sel.contains(n)),
																				  (a = l > -1 ? h[l] : new Tr(n, n)))
																				: ((a = o.sel.primary()),
																				  (l = o.sel.primIndex)),
																			"rectangle" == i.unit)
																		)
																			i.addNew || (a = new Tr(n, n)),
																				(n = ci(t, e, !0, !0)),
																				(l = -1);
																		else {
																			var u = vs(t, n, i.unit);
																			a = i.extend
																				? Vr(a, u.anchor, u.head, i.extend)
																				: u;
																		}
																		i.addNew
																			? -1 == l
																				? ((l = h.length),
																				  Jr(o, Cr(t, h.concat([a]), l), {
																						scroll: !1,
																						origin: "*mouse",
																				  }))
																				: h.length > 1 &&
																				  h[l].empty() &&
																				  "char" == i.unit &&
																				  !i.extend
																				? (Jr(
																						o,
																						Cr(
																							t,
																							h
																								.slice(0, l)
																								.concat(h.slice(l + 1)),
																							0
																						),
																						{ scroll: !1, origin: "*mouse" }
																				  ),
																				  (c = o.sel))
																				: Xr(o, l, a, W)
																			: ((l = 0),
																			  Jr(o, new br([a], 0), W),
																			  (c = o.sel));
																		var f = n;
																		function d(e) {
																			if (0 != ee(f, e))
																				if (((f = e), "rectangle" == i.unit)) {
																					for (
																						var r = [],
																							s = t.options.tabSize,
																							h = F(
																								qt(o, n.line).text,
																								n.ch,
																								s
																							),
																							u = F(
																								qt(o, e.line).text,
																								e.ch,
																								s
																							),
																							d = Math.min(h, u),
																							p = Math.max(h, u),
																							g = Math.min(n.line, e.line),
																							m = Math.min(
																								t.lastLine(),
																								Math.max(n.line, e.line)
																							);
																						g <= m;
																						g++
																					) {
																						var v = qt(o, g).text,
																							_ = G(v, d, s);
																						d == p
																							? r.push(
																									new Tr(te(g, _), te(g, _))
																							  )
																							: v.length > _ &&
																							  r.push(
																									new Tr(
																										te(g, _),
																										te(g, G(v, p, s))
																									)
																							  );
																					}
																					r.length || r.push(new Tr(n, n)),
																						Jr(
																							o,
																							Cr(
																								t,
																								c.ranges.slice(0, l).concat(r),
																								l
																							),
																							{ origin: "*mouse", scroll: !1 }
																						),
																						t.scrollIntoView(e);
																				} else {
																					var y,
																						x = a,
																						k = vs(t, e, i.unit),
																						b = x.anchor;
																					ee(k.anchor, b) > 0
																						? ((y = k.head),
																						  (b = oe(x.from(), k.anchor)))
																						: ((y = k.anchor),
																						  (b = re(x.to(), k.head)));
																					var T = c.ranges.slice(0);
																					(T[l] = (function (t, e) {
																						var n = e.anchor,
																							i = e.head,
																							r = qt(t.doc, n.line);
																						if (
																							0 == ee(n, i) &&
																							n.sticky == i.sticky
																						)
																							return e;
																						var o = ct(r);
																						if (!o) return e;
																						var s = at(o, n.ch, n.sticky),
																							a = o[s];
																						if (a.from != n.ch && a.to != n.ch)
																							return e;
																						var l,
																							c =
																								s +
																								((a.from == n.ch) ==
																								(1 != a.level)
																									? 0
																									: 1);
																						if (0 == c || c == o.length)
																							return e;
																						if (i.line != n.line)
																							l =
																								(i.line - n.line) *
																									("ltr" == t.doc.direction
																										? 1
																										: -1) >
																								0;
																						else {
																							var h = at(o, i.ch, i.sticky),
																								u =
																									h - s ||
																									(i.ch - n.ch) *
																										(1 == a.level ? -1 : 1);
																							l =
																								h == c - 1 || h == c
																									? u < 0
																									: u > 0;
																						}
																						var f = o[c + (l ? -1 : 0)],
																							d = l == (1 == f.level),
																							p = d ? f.from : f.to,
																							g = d ? "after" : "before";
																						return n.ch == p && n.sticky == g
																							? e
																							: new Tr(new te(n.line, p, g), i);
																					})(t, new Tr(ae(o, b), y))),
																						Jr(o, Cr(t, T, l), W);
																				}
																		}
																		var p = r.wrapper.getBoundingClientRect(),
																			g = 0;
																		function m(e) {
																			var n = ++g,
																				s = ci(t, e, !0, "rectangle" == i.unit);
																			if (s)
																				if (0 != ee(s, f)) {
																					(t.curOp.focus = I()), d(s);
																					var a = Ai(r, o);
																					(s.line >= a.to || s.line < a.from) &&
																						setTimeout(
																							tr(t, function () {
																								g == n && m(e);
																							}),
																							150
																						);
																				} else {
																					var l =
																						e.clientY < p.top
																							? -20
																							: e.clientY > p.bottom
																							? 20
																							: 0;
																					l &&
																						setTimeout(
																							tr(t, function () {
																								g == n &&
																									((r.scroller.scrollTop += l),
																									m(e));
																							}),
																							50
																						);
																				}
																		}
																		function v(e) {
																			(t.state.selectingText = !1),
																				(g = 1 / 0),
																				e && (yt(e), r.input.focus()),
																				dt(
																					r.wrapper.ownerDocument,
																					"mousemove",
																					_
																				),
																				dt(
																					r.wrapper.ownerDocument,
																					"mouseup",
																					y
																				),
																				(o.history.lastSelOrigin = null);
																		}
																		var _ = tr(t, function (t) {
																				0 !== t.buttons && Ct(t) ? m(t) : v(t);
																			}),
																			y = tr(t, v);
																		(t.state.selectingText = y),
																			ut(
																				r.wrapper.ownerDocument,
																				"mousemove",
																				_
																			),
																			ut(r.wrapper.ownerDocument, "mouseup", y);
																  })(t, i, e, o);
													  })(e, i, o, t)
													: Tt(t) == n.scroller && yt(t)
												: 2 == r
												? (i && Yr(e.doc, i),
												  setTimeout(function () {
														return n.input.focus();
												  }, 20))
												: 3 == r &&
												  (T ? e.display.input.onContextMenu(t) : Ti(e)));
								}
						}
						function vs(t, e, n) {
							if ("char" == n) return new Tr(e, e);
							if ("word" == n) return t.findWordAt(e);
							if ("line" == n)
								return new Tr(te(e.line, 0), ae(t.doc, te(e.line + 1, 0)));
							var i = n(t, e);
							return new Tr(i.from, i.to);
						}
						function _s(t, e, n, i) {
							var r, o;
							if (e.touches)
								(r = e.touches[0].clientX), (o = e.touches[0].clientY);
							else
								try {
									(r = e.clientX), (o = e.clientY);
								} catch (t) {
									return !1;
								}
							if (
								r >= Math.floor(t.display.gutters.getBoundingClientRect().right)
							)
								return !1;
							i && yt(e);
							var s = t.display,
								a = s.lineDiv.getBoundingClientRect();
							if (o > a.bottom || !vt(t, n)) return kt(e);
							o -= a.top - s.viewOffset;
							for (var l = 0; l < t.display.gutterSpecs.length; ++l) {
								var c = s.gutters.childNodes[l];
								if (c && c.getBoundingClientRect().right >= r)
									return (
										pt(
											t,
											n,
											t,
											Qt(t.doc, o),
											t.display.gutterSpecs[l].className,
											e
										),
										kt(e)
									);
							}
						}
						function ys(t, e) {
							return _s(t, e, "gutterClick", !0);
						}
						function xs(t, e) {
							bn(t.display, e) ||
								(function (t, e) {
									return (
										!!vt(t, "gutterContextMenu") &&
										_s(t, e, "gutterContextMenu", !1)
									);
								})(t, e) ||
								gt(t, e, "contextmenu") ||
								T ||
								t.display.input.onContextMenu(e);
						}
						function ks(t) {
							(t.display.wrapper.className =
								t.display.wrapper.className.replace(/\s*cm-s-\S+/g, "") +
								t.options.theme.replace(/(^|\s)\s*/g, " cm-s-")),
								Un(t);
						}
						gs.prototype.compare = function (t, e, n) {
							return (
								this.time + 400 > t && 0 == ee(e, this.pos) && n == this.button
							);
						};
						var bs = {
								toString: function () {
									return "CodeMirror.Init";
								},
							},
							Ts = {},
							Cs = {};
						function ws(t, e, n) {
							if (!e != !(n && n != bs)) {
								var i = t.display.dragFunctions,
									r = e ? ut : dt;
								r(t.display.scroller, "dragstart", i.start),
									r(t.display.scroller, "dragenter", i.enter),
									r(t.display.scroller, "dragover", i.over),
									r(t.display.scroller, "dragleave", i.leave),
									r(t.display.scroller, "drop", i.drop);
							}
						}
						function Es(t) {
							t.options.lineWrapping
								? (M(t.display.wrapper, "CodeMirror-wrap"),
								  (t.display.sizer.style.minWidth = ""),
								  (t.display.sizerWidth = null))
								: (E(t.display.wrapper, "CodeMirror-wrap"), Ge(t)),
								li(t),
								ui(t),
								Un(t),
								setTimeout(function () {
									return Hi(t);
								}, 100);
						}
						function Ss(t, e) {
							var n = this;
							if (!(this instanceof Ss)) return new Ss(t, e);
							(this.options = e = e ? P(e) : {}), P(Ts, e, !1);
							var i = e.value;
							"string" == typeof i
								? (i = new No(i, e.mode, null, e.lineSeparator, e.direction))
								: e.mode && (i.modeOption = e.mode),
								(this.doc = i);
							var r = new Ss.inputStyles[e.inputStyle](this),
								o = (this.display = new mr(t, i, r, e));
							for (var c in ((o.wrapper.CodeMirror = this),
							ks(this),
							e.lineWrapping &&
								(this.display.wrapper.className += " CodeMirror-wrap"),
							ji(this),
							(this.state = {
								keyMaps: [],
								overlays: [],
								modeGen: 0,
								overwrite: !1,
								delayingBlurEvent: !1,
								focused: !1,
								suppressEdits: !1,
								pasteIncoming: -1,
								cutIncoming: -1,
								selectingText: !1,
								draggingText: !1,
								highlight: new B(),
								keySeq: null,
								specialChars: null,
							}),
							e.autofocus && !v && o.input.focus(),
							s &&
								a < 11 &&
								setTimeout(function () {
									return n.display.input.reset(!0);
								}, 20),
							(function (t) {
								var e = t.display;
								ut(e.scroller, "mousedown", tr(t, ms)),
									ut(
										e.scroller,
										"dblclick",
										s && a < 11
											? tr(t, function (e) {
													if (!gt(t, e)) {
														var n = ci(t, e);
														if (n && !ys(t, e) && !bn(t.display, e)) {
															yt(e);
															var i = t.findWordAt(n);
															Yr(t.doc, i.anchor, i.head);
														}
													}
											  })
											: function (e) {
													return gt(t, e) || yt(e);
											  }
									),
									ut(e.scroller, "contextmenu", function (e) {
										return xs(t, e);
									}),
									ut(e.input.getField(), "contextmenu", function (n) {
										e.scroller.contains(n.target) || xs(t, n);
									});
								var n,
									i = { end: 0 };
								function r() {
									e.activeTouch &&
										((n = setTimeout(function () {
											return (e.activeTouch = null);
										}, 1e3)),
										((i = e.activeTouch).end = +new Date()));
								}
								function o(t) {
									if (1 != t.touches.length) return !1;
									var e = t.touches[0];
									return e.radiusX <= 1 && e.radiusY <= 1;
								}
								function l(t, e) {
									if (null == e.left) return !0;
									var n = e.left - t.left,
										i = e.top - t.top;
									return n * n + i * i > 400;
								}
								ut(e.scroller, "touchstart", function (r) {
									if (!gt(t, r) && !o(r) && !ys(t, r)) {
										e.input.ensurePolled(), clearTimeout(n);
										var s = +new Date();
										(e.activeTouch = {
											start: s,
											moved: !1,
											prev: s - i.end <= 300 ? i : null,
										}),
											1 == r.touches.length &&
												((e.activeTouch.left = r.touches[0].pageX),
												(e.activeTouch.top = r.touches[0].pageY));
									}
								}),
									ut(e.scroller, "touchmove", function () {
										e.activeTouch && (e.activeTouch.moved = !0);
									}),
									ut(e.scroller, "touchend", function (n) {
										var i = e.activeTouch;
										if (
											i &&
											!bn(e, n) &&
											null != i.left &&
											!i.moved &&
											new Date() - i.start < 300
										) {
											var o,
												s = t.coordsChar(e.activeTouch, "page");
											(o =
												!i.prev || l(i, i.prev)
													? new Tr(s, s)
													: !i.prev.prev || l(i, i.prev.prev)
													? t.findWordAt(s)
													: new Tr(
															te(s.line, 0),
															ae(t.doc, te(s.line + 1, 0))
													  )),
												t.setSelection(o.anchor, o.head),
												t.focus(),
												yt(n);
										}
										r();
									}),
									ut(e.scroller, "touchcancel", r),
									ut(e.scroller, "scroll", function () {
										e.scroller.clientHeight &&
											(Ri(t, e.scroller.scrollTop),
											Pi(t, e.scroller.scrollLeft, !0),
											pt(t, "scroll", t));
									}),
									ut(e.scroller, "mousewheel", function (e) {
										return kr(t, e);
									}),
									ut(e.scroller, "DOMMouseScroll", function (e) {
										return kr(t, e);
									}),
									ut(e.wrapper, "scroll", function () {
										return (e.wrapper.scrollTop = e.wrapper.scrollLeft = 0);
									}),
									(e.dragFunctions = {
										enter: function (e) {
											gt(t, e) || bt(e);
										},
										over: function (e) {
											gt(t, e) ||
												((function (t, e) {
													var n = ci(t, e);
													if (n) {
														var i = document.createDocumentFragment();
														_i(t, n, i),
															t.display.dragCursor ||
																((t.display.dragCursor = L(
																	"div",
																	null,
																	"CodeMirror-cursors CodeMirror-dragcursors"
																)),
																t.display.lineSpace.insertBefore(
																	t.display.dragCursor,
																	t.display.cursorDiv
																)),
															A(t.display.dragCursor, i);
													}
												})(t, e),
												bt(e));
										},
										start: function (e) {
											return (function (t, e) {
												if (
													s &&
													(!t.state.draggingText || +new Date() - Io < 100)
												)
													bt(e);
												else if (
													!gt(t, e) &&
													!bn(t.display, e) &&
													(e.dataTransfer.setData("Text", t.getSelection()),
													(e.dataTransfer.effectAllowed = "copyMove"),
													e.dataTransfer.setDragImage && !f)
												) {
													var n = L(
														"img",
														null,
														null,
														"position: fixed; left: 0; top: 0;"
													);
													(n.src =
														"data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="),
														u &&
															((n.width = n.height = 1),
															t.display.wrapper.appendChild(n),
															(n._top = n.offsetTop)),
														e.dataTransfer.setDragImage(n, 0, 0),
														u && n.parentNode.removeChild(n);
												}
											})(t, e);
										},
										drop: tr(t, Mo),
										leave: function (e) {
											gt(t, e) || $o(t);
										},
									});
								var c = e.input.getField();
								ut(c, "keyup", function (e) {
									return us.call(t, e);
								}),
									ut(c, "keydown", tr(t, hs)),
									ut(c, "keypress", tr(t, fs)),
									ut(c, "focus", function (e) {
										return Ci(t, e);
									}),
									ut(c, "blur", function (e) {
										return wi(t, e);
									});
							})(this),
							Po(),
							qi(this),
							(this.curOp.forceUpdate = !0),
							Rr(this, i),
							(e.autofocus && !v) || this.hasFocus()
								? setTimeout(function () {
										n.hasFocus() && !n.state.focused && Ci(n);
								  }, 20)
								: wi(this),
							Cs))
								Cs.hasOwnProperty(c) && Cs[c](this, e[c], bs);
							fr(this), e.finishInit && e.finishInit(this);
							for (var h = 0; h < As.length; ++h) As[h](this);
							Vi(this),
								l &&
									e.lineWrapping &&
									"optimizelegibility" ==
										getComputedStyle(o.lineDiv).textRendering &&
									(o.lineDiv.style.textRendering = "auto");
						}
						(Ss.defaults = Ts), (Ss.optionHandlers = Cs);
						var As = [];
						function Ls(t, e, n, i) {
							var r,
								o = t.doc;
							null == n && (n = "add"),
								"smart" == n &&
									(o.mode.indent ? (r = de(t, e).state) : (n = "prev"));
							var s = t.options.tabSize,
								a = qt(o, e),
								l = F(a.text, null, s);
							a.stateAfter && (a.stateAfter = null);
							var c,
								h = a.text.match(/^\s*/)[0];
							if (i || /\S/.test(a.text)) {
								if (
									"smart" == n &&
									((c = o.mode.indent(r, a.text.slice(h.length), a.text)) ==
										H ||
										c > 150)
								) {
									if (!i) return;
									n = "prev";
								}
							} else (c = 0), (n = "not");
							"prev" == n
								? (c = e > o.first ? F(qt(o, e - 1).text, null, s) : 0)
								: "add" == n
								? (c = l + t.options.indentUnit)
								: "subtract" == n
								? (c = l - t.options.indentUnit)
								: "number" == typeof n && (c = l + n),
								(c = Math.max(0, c));
							var u = "",
								f = 0;
							if (t.options.indentWithTabs)
								for (var d = Math.floor(c / s); d; --d) (f += s), (u += "\t");
							if ((f < c && (u += V(c - f)), u != h))
								return (
									go(o, u, te(e, 0), te(e, h.length), "+input"),
									(a.stateAfter = null),
									!0
								);
							for (var p = 0; p < o.sel.ranges.length; p++) {
								var g = o.sel.ranges[p];
								if (g.head.line == e && g.head.ch < h.length) {
									var m = te(e, h.length);
									Xr(o, p, new Tr(m, m));
									break;
								}
							}
						}
						Ss.defineInitHook = function (t) {
							return As.push(t);
						};
						var Os = null;
						function Ns(t) {
							Os = t;
						}
						function Is(t, e, n, i, r) {
							var o = t.doc;
							(t.display.shift = !1), i || (i = o.sel);
							var s = +new Date() - 200,
								a = "paste" == r || t.state.pasteIncoming > s,
								l = Nt(e),
								c = null;
							if (a && i.ranges.length > 1)
								if (Os && Os.text.join("\n") == e) {
									if (i.ranges.length % Os.text.length == 0) {
										c = [];
										for (var h = 0; h < Os.text.length; h++)
											c.push(o.splitLines(Os.text[h]));
									}
								} else
									l.length == i.ranges.length &&
										t.options.pasteLinesPerSelection &&
										(c = K(l, function (t) {
											return [t];
										}));
							for (
								var u = t.curOp.updateInput, f = i.ranges.length - 1;
								f >= 0;
								f--
							) {
								var d = i.ranges[f],
									p = d.from(),
									g = d.to();
								d.empty() &&
									(n && n > 0
										? (p = te(p.line, p.ch - n))
										: t.state.overwrite && !a
										? (g = te(
												g.line,
												Math.min(qt(o, g.line).text.length, g.ch + Y(l).length)
										  ))
										: a &&
										  Os &&
										  Os.lineWise &&
										  Os.text.join("\n") == l.join("\n") &&
										  (p = g = te(p.line, 0)));
								var m = {
									from: p,
									to: g,
									text: c ? c[f % c.length] : l,
									origin:
										r ||
										(a ? "paste" : t.state.cutIncoming > s ? "cut" : "+input"),
								};
								co(t.doc, m), ln(t, "inputRead", t, m);
							}
							e && !a && $s(t, e),
								Ni(t),
								t.curOp.updateInput < 2 && (t.curOp.updateInput = u),
								(t.curOp.typing = !0),
								(t.state.pasteIncoming = t.state.cutIncoming = -1);
						}
						function Ms(t, e) {
							var n = t.clipboardData && t.clipboardData.getData("Text");
							if (n)
								return (
									t.preventDefault(),
									e.isReadOnly() ||
										e.options.disableInput ||
										Ji(e, function () {
											return Is(e, n, 0, null, "paste");
										}),
									!0
								);
						}
						function $s(t, e) {
							if (t.options.electricChars && t.options.smartIndent)
								for (var n = t.doc.sel, i = n.ranges.length - 1; i >= 0; i--) {
									var r = n.ranges[i];
									if (
										!(
											r.head.ch > 100 ||
											(i && n.ranges[i - 1].head.line == r.head.line)
										)
									) {
										var o = t.getModeAt(r.head),
											s = !1;
										if (o.electricChars) {
											for (var a = 0; a < o.electricChars.length; a++)
												if (e.indexOf(o.electricChars.charAt(a)) > -1) {
													s = Ls(t, r.head.line, "smart");
													break;
												}
										} else
											o.electricInput &&
												o.electricInput.test(
													qt(t.doc, r.head.line).text.slice(0, r.head.ch)
												) &&
												(s = Ls(t, r.head.line, "smart"));
										s && ln(t, "electricInput", t, r.head.line);
									}
								}
						}
						function Rs(t) {
							for (
								var e = [], n = [], i = 0;
								i < t.doc.sel.ranges.length;
								i++
							) {
								var r = t.doc.sel.ranges[i].head.line,
									o = { anchor: te(r, 0), head: te(r + 1, 0) };
								n.push(o), e.push(t.getRange(o.anchor, o.head));
							}
							return { text: e, ranges: n };
						}
						function Ds(t, e, n, i) {
							t.setAttribute("autocorrect", n ? "" : "off"),
								t.setAttribute("autocapitalize", i ? "" : "off"),
								t.setAttribute("spellcheck", !!e);
						}
						function Ps() {
							var t = L(
									"textarea",
									null,
									null,
									"position: absolute; bottom: -1em; padding: 0; width: 1px; height: 1em; outline: none"
								),
								e = L(
									"div",
									[t],
									null,
									"overflow: hidden; position: relative; width: 3px; height: 0px;"
								);
							return (
								l ? (t.style.width = "1000px") : t.setAttribute("wrap", "off"),
								g && (t.style.border = "1px solid black"),
								Ds(t),
								e
							);
						}
						function Fs(t, e, n, i, r) {
							var o = e,
								s = n,
								a = qt(t, e.line),
								l = r && "rtl" == t.direction ? -n : n;
							function c(o) {
								var s, c;
								if ("codepoint" == i) {
									var h = a.text.charCodeAt(e.ch + (n > 0 ? 0 : -1));
									if (isNaN(h)) s = null;
									else {
										var u =
											n > 0 ? h >= 55296 && h < 56320 : h >= 56320 && h < 57343;
										s = new te(
											e.line,
											Math.max(
												0,
												Math.min(a.text.length, e.ch + n * (u ? 2 : 1))
											),
											-n
										);
									}
								} else
									s = r
										? (function (t, e, n, i) {
												var r = ct(e, t.doc.direction);
												if (!r) return Jo(e, n, i);
												n.ch >= e.text.length
													? ((n.ch = e.text.length), (n.sticky = "before"))
													: n.ch <= 0 && ((n.ch = 0), (n.sticky = "after"));
												var o = at(r, n.ch, n.sticky),
													s = r[o];
												if (
													"ltr" == t.doc.direction &&
													s.level % 2 == 0 &&
													(i > 0 ? s.to > n.ch : s.from < n.ch)
												)
													return Jo(e, n, i);
												var a,
													l = function (t, n) {
														return Zo(e, t instanceof te ? t.ch : t, n);
													},
													c = function (n) {
														return t.options.lineWrapping
															? ((a = a || In(t, e)), Zn(t, e, a, n))
															: { begin: 0, end: e.text.length };
													},
													h = c("before" == n.sticky ? l(n, -1) : n.ch);
												if ("rtl" == t.doc.direction || 1 == s.level) {
													var u = (1 == s.level) == i < 0,
														f = l(n, u ? 1 : -1);
													if (
														null != f &&
														(u
															? f <= s.to && f <= h.end
															: f >= s.from && f >= h.begin)
													) {
														var d = u ? "before" : "after";
														return new te(n.line, f, d);
													}
												}
												var p = function (t, e, i) {
														for (
															var o = function (t, e) {
																return e
																	? new te(n.line, l(t, 1), "before")
																	: new te(n.line, t, "after");
															};
															t >= 0 && t < r.length;
															t += e
														) {
															var s = r[t],
																a = e > 0 == (1 != s.level),
																c = a ? i.begin : l(i.end, -1);
															if (s.from <= c && c < s.to) return o(c, a);
															if (
																((c = a ? s.from : l(s.to, -1)),
																i.begin <= c && c < i.end)
															)
																return o(c, a);
														}
													},
													g = p(o + i, i, h);
												if (g) return g;
												var m = i > 0 ? h.end : l(h.begin, -1);
												return null == m ||
													(i > 0 && m == e.text.length) ||
													!(g = p(i > 0 ? 0 : r.length - 1, i, c(m)))
													? null
													: g;
										  })(t.cm, a, e, n)
										: Jo(a, e, n);
								if (null == s) {
									if (
										o ||
										(c = e.line + l) < t.first ||
										c >= t.first + t.size ||
										((e = new te(c, e.ch, e.sticky)), !(a = qt(t, c)))
									)
										return !1;
									e = ts(r, t.cm, a, e.line, l);
								} else e = s;
								return !0;
							}
							if ("char" == i || "codepoint" == i) c();
							else if ("column" == i) c(!0);
							else if ("word" == i || "group" == i)
								for (
									var h = null,
										u = "group" == i,
										f = t.cm && t.cm.getHelper(e, "wordChars"),
										d = !0;
									!(n < 0) || c(!d);
									d = !1
								) {
									var p = a.text.charAt(e.ch) || "\n",
										g = tt(p, f)
											? "w"
											: u && "\n" == p
											? "n"
											: !u || /\s/.test(p)
											? null
											: "p";
									if ((!u || d || g || (g = "s"), h && h != g)) {
										n < 0 && ((n = 1), c(), (e.sticky = "after"));
										break;
									}
									if ((g && (h = g), n > 0 && !c(!d))) break;
								}
							var m = oo(t, e, o, s, !0);
							return ne(o, m) && (m.hitSide = !0), m;
						}
						function Bs(t, e, n, i) {
							var r,
								o,
								s = t.doc,
								a = e.left;
							if ("page" == i) {
								var l = Math.min(
										t.display.wrapper.clientHeight,
										window.innerHeight || document.documentElement.clientHeight
									),
									c = Math.max(l - 0.5 * ii(t.display), 3);
								r = (n > 0 ? e.bottom : e.top) + n * c;
							} else "line" == i && (r = n > 0 ? e.bottom + 3 : e.top - 3);
							for (; (o = Xn(t, a, r)).outside; ) {
								if (n < 0 ? r <= 0 : r >= s.height) {
									o.hitSide = !0;
									break;
								}
								r += 5 * n;
							}
							return o;
						}
						var Us = function (t) {
							(this.cm = t),
								(this.lastAnchorNode =
									this.lastAnchorOffset =
									this.lastFocusNode =
									this.lastFocusOffset =
										null),
								(this.polling = new B()),
								(this.composing = null),
								(this.gracePeriod = !1),
								(this.readDOMTimeout = null);
						};
						function Hs(t, e) {
							var n = Nn(t, e.line);
							if (!n || n.hidden) return null;
							var i = qt(t.doc, e.line),
								r = Ln(n, i, e.line),
								o = ct(i, t.doc.direction),
								s = "left";
							o && (s = at(o, e.ch) % 2 ? "right" : "left");
							var a = Dn(r.map, e.ch, s);
							return (a.offset = "right" == a.collapse ? a.end : a.start), a;
						}
						function zs(t, e) {
							return e && (t.bad = !0), t;
						}
						function Ws(t, e, n) {
							var i;
							if (e == t.display.lineDiv) {
								if (!(i = t.display.lineDiv.childNodes[n]))
									return zs(t.clipPos(te(t.display.viewTo - 1)), !0);
								(e = null), (n = 0);
							} else
								for (i = e; ; i = i.parentNode) {
									if (!i || i == t.display.lineDiv) return null;
									if (i.parentNode && i.parentNode == t.display.lineDiv) break;
								}
							for (var r = 0; r < t.display.view.length; r++) {
								var o = t.display.view[r];
								if (o.node == i) return js(o, e, n);
							}
						}
						function js(t, e, n) {
							var i = t.text.firstChild,
								r = !1;
							if (!e || !N(i, e)) return zs(te(Xt(t.line), 0), !0);
							if (e == i && ((r = !0), (e = i.childNodes[n]), (n = 0), !e)) {
								var o = t.rest ? Y(t.rest) : t.line;
								return zs(te(Xt(o), o.text.length), r);
							}
							var s = 3 == e.nodeType ? e : null,
								a = e;
							for (
								s ||
								1 != e.childNodes.length ||
								3 != e.firstChild.nodeType ||
								((s = e.firstChild), n && (n = s.nodeValue.length));
								a.parentNode != i;

							)
								a = a.parentNode;
							var l = t.measure,
								c = l.maps;
							function h(e, n, i) {
								for (var r = -1; r < (c ? c.length : 0); r++)
									for (
										var o = r < 0 ? l.map : c[r], s = 0;
										s < o.length;
										s += 3
									) {
										var a = o[s + 2];
										if (a == e || a == n) {
											var h = Xt(r < 0 ? t.line : t.rest[r]),
												u = o[s] + i;
											return (
												(i < 0 || a != e) && (u = o[s + (i ? 1 : 0)]), te(h, u)
											);
										}
									}
							}
							var u = h(s, a, n);
							if (u) return zs(u, r);
							for (
								var f = a.nextSibling, d = s ? s.nodeValue.length - n : 0;
								f;
								f = f.nextSibling
							) {
								if ((u = h(f, f.firstChild, 0)))
									return zs(te(u.line, u.ch - d), r);
								d += f.textContent.length;
							}
							for (var p = a.previousSibling, g = n; p; p = p.previousSibling) {
								if ((u = h(p, p.firstChild, -1)))
									return zs(te(u.line, u.ch + g), r);
								g += p.textContent.length;
							}
						}
						(Us.prototype.init = function (t) {
							var e = this,
								n = this,
								i = n.cm,
								r = (n.div = t.lineDiv);
							function o(t) {
								for (var e = t.target; e; e = e.parentNode) {
									if (e == r) return !0;
									if (/\bCodeMirror-(?:line)?widget\b/.test(e.className)) break;
								}
								return !1;
							}
							function s(t) {
								if (o(t) && !gt(i, t)) {
									if (i.somethingSelected())
										Ns({ lineWise: !1, text: i.getSelections() }),
											"cut" == t.type && i.replaceSelection("", null, "cut");
									else {
										if (!i.options.lineWiseCopyCut) return;
										var e = Rs(i);
										Ns({ lineWise: !0, text: e.text }),
											"cut" == t.type &&
												i.operation(function () {
													i.setSelections(e.ranges, 0, z),
														i.replaceSelection("", null, "cut");
												});
									}
									if (t.clipboardData) {
										t.clipboardData.clearData();
										var s = Os.text.join("\n");
										if (
											(t.clipboardData.setData("Text", s),
											t.clipboardData.getData("Text") == s)
										)
											return void t.preventDefault();
									}
									var a = Ps(),
										l = a.firstChild;
									i.display.lineSpace.insertBefore(
										a,
										i.display.lineSpace.firstChild
									),
										(l.value = Os.text.join("\n"));
									var c = I();
									R(l),
										setTimeout(function () {
											i.display.lineSpace.removeChild(a),
												c.focus(),
												c == r && n.showPrimarySelection();
										}, 50);
								}
							}
							(r.contentEditable = !0),
								Ds(
									r,
									i.options.spellcheck,
									i.options.autocorrect,
									i.options.autocapitalize
								),
								ut(r, "paste", function (t) {
									!o(t) ||
										gt(i, t) ||
										Ms(t, i) ||
										(a <= 11 &&
											setTimeout(
												tr(i, function () {
													return e.updateFromDOM();
												}),
												20
											));
								}),
								ut(r, "compositionstart", function (t) {
									e.composing = { data: t.data, done: !1 };
								}),
								ut(r, "compositionupdate", function (t) {
									e.composing || (e.composing = { data: t.data, done: !1 });
								}),
								ut(r, "compositionend", function (t) {
									e.composing &&
										(t.data != e.composing.data && e.readFromDOMSoon(),
										(e.composing.done = !0));
								}),
								ut(r, "touchstart", function () {
									return n.forceCompositionEnd();
								}),
								ut(r, "input", function () {
									e.composing || e.readFromDOMSoon();
								}),
								ut(r, "copy", s),
								ut(r, "cut", s);
						}),
							(Us.prototype.screenReaderLabelChanged = function (t) {
								t
									? this.div.setAttribute("aria-label", t)
									: this.div.removeAttribute("aria-label");
							}),
							(Us.prototype.prepareSelection = function () {
								var t = vi(this.cm, !1);
								return (t.focus = I() == this.div), t;
							}),
							(Us.prototype.showSelection = function (t, e) {
								t &&
									this.cm.display.view.length &&
									((t.focus || e) && this.showPrimarySelection(),
									this.showMultipleSelections(t));
							}),
							(Us.prototype.getSelection = function () {
								return this.cm.display.wrapper.ownerDocument.getSelection();
							}),
							(Us.prototype.showPrimarySelection = function () {
								var t = this.getSelection(),
									e = this.cm,
									i = e.doc.sel.primary(),
									r = i.from(),
									o = i.to();
								if (
									e.display.viewTo == e.display.viewFrom ||
									r.line >= e.display.viewTo ||
									o.line < e.display.viewFrom
								)
									t.removeAllRanges();
								else {
									var s = Ws(e, t.anchorNode, t.anchorOffset),
										a = Ws(e, t.focusNode, t.focusOffset);
									if (
										!s ||
										s.bad ||
										!a ||
										a.bad ||
										0 != ee(oe(s, a), r) ||
										0 != ee(re(s, a), o)
									) {
										var l = e.display.view,
											c = (r.line >= e.display.viewFrom && Hs(e, r)) || {
												node: l[0].measure.map[2],
												offset: 0,
											},
											h = o.line < e.display.viewTo && Hs(e, o);
										if (!h) {
											var u = l[l.length - 1].measure,
												f = u.maps ? u.maps[u.maps.length - 1] : u.map;
											h = {
												node: f[f.length - 1],
												offset: f[f.length - 2] - f[f.length - 3],
											};
										}
										if (c && h) {
											var d,
												p = t.rangeCount && t.getRangeAt(0);
											try {
												d = w(c.node, c.offset, h.offset, h.node);
											} catch (t) {}
											d &&
												(!n && e.state.focused
													? (t.collapse(c.node, c.offset),
													  d.collapsed || (t.removeAllRanges(), t.addRange(d)))
													: (t.removeAllRanges(), t.addRange(d)),
												p && null == t.anchorNode
													? t.addRange(p)
													: n && this.startGracePeriod()),
												this.rememberSelection();
										} else t.removeAllRanges();
									}
								}
							}),
							(Us.prototype.startGracePeriod = function () {
								var t = this;
								clearTimeout(this.gracePeriod),
									(this.gracePeriod = setTimeout(function () {
										(t.gracePeriod = !1),
											t.selectionChanged() &&
												t.cm.operation(function () {
													return (t.cm.curOp.selectionChanged = !0);
												});
									}, 20));
							}),
							(Us.prototype.showMultipleSelections = function (t) {
								A(this.cm.display.cursorDiv, t.cursors),
									A(this.cm.display.selectionDiv, t.selection);
							}),
							(Us.prototype.rememberSelection = function () {
								var t = this.getSelection();
								(this.lastAnchorNode = t.anchorNode),
									(this.lastAnchorOffset = t.anchorOffset),
									(this.lastFocusNode = t.focusNode),
									(this.lastFocusOffset = t.focusOffset);
							}),
							(Us.prototype.selectionInEditor = function () {
								var t = this.getSelection();
								if (!t.rangeCount) return !1;
								var e = t.getRangeAt(0).commonAncestorContainer;
								return N(this.div, e);
							}),
							(Us.prototype.focus = function () {
								"nocursor" != this.cm.options.readOnly &&
									((this.selectionInEditor() && I() == this.div) ||
										this.showSelection(this.prepareSelection(), !0),
									this.div.focus());
							}),
							(Us.prototype.blur = function () {
								this.div.blur();
							}),
							(Us.prototype.getField = function () {
								return this.div;
							}),
							(Us.prototype.supportsTouch = function () {
								return !0;
							}),
							(Us.prototype.receivedFocus = function () {
								var t = this;
								this.selectionInEditor()
									? this.pollSelection()
									: Ji(this.cm, function () {
											return (t.cm.curOp.selectionChanged = !0);
									  }),
									this.polling.set(this.cm.options.pollInterval, function e() {
										t.cm.state.focused &&
											(t.pollSelection(),
											t.polling.set(t.cm.options.pollInterval, e));
									});
							}),
							(Us.prototype.selectionChanged = function () {
								var t = this.getSelection();
								return (
									t.anchorNode != this.lastAnchorNode ||
									t.anchorOffset != this.lastAnchorOffset ||
									t.focusNode != this.lastFocusNode ||
									t.focusOffset != this.lastFocusOffset
								);
							}),
							(Us.prototype.pollSelection = function () {
								if (
									null == this.readDOMTimeout &&
									!this.gracePeriod &&
									this.selectionChanged()
								) {
									var t = this.getSelection(),
										e = this.cm;
									if (
										m &&
										h &&
										this.cm.display.gutterSpecs.length &&
										(function (t) {
											for (var e = t; e; e = e.parentNode)
												if (/CodeMirror-gutter-wrapper/.test(e.className))
													return !0;
											return !1;
										})(t.anchorNode)
									)
										return (
											this.cm.triggerOnKeyDown({
												type: "keydown",
												keyCode: 8,
												preventDefault: Math.abs,
											}),
											this.blur(),
											void this.focus()
										);
									if (!this.composing) {
										this.rememberSelection();
										var n = Ws(e, t.anchorNode, t.anchorOffset),
											i = Ws(e, t.focusNode, t.focusOffset);
										n &&
											i &&
											Ji(e, function () {
												Jr(e.doc, wr(n, i), z),
													(n.bad || i.bad) && (e.curOp.selectionChanged = !0);
											});
									}
								}
							}),
							(Us.prototype.pollContent = function () {
								null != this.readDOMTimeout &&
									(clearTimeout(this.readDOMTimeout),
									(this.readDOMTimeout = null));
								var t,
									e,
									n,
									i = this.cm,
									r = i.display,
									o = i.doc.sel.primary(),
									s = o.from(),
									a = o.to();
								if (
									(0 == s.ch &&
										s.line > i.firstLine() &&
										(s = te(s.line - 1, qt(i.doc, s.line - 1).length)),
									a.ch == qt(i.doc, a.line).text.length &&
										a.line < i.lastLine() &&
										(a = te(a.line + 1, 0)),
									s.line < r.viewFrom || a.line > r.viewTo - 1)
								)
									return !1;
								s.line == r.viewFrom || 0 == (t = hi(i, s.line))
									? ((e = Xt(r.view[0].line)), (n = r.view[0].node))
									: ((e = Xt(r.view[t].line)),
									  (n = r.view[t - 1].node.nextSibling));
								var l,
									c,
									h = hi(i, a.line);
								if (
									(h == r.view.length - 1
										? ((l = r.viewTo - 1), (c = r.lineDiv.lastChild))
										: ((l = Xt(r.view[h + 1].line) - 1),
										  (c = r.view[h + 1].node.previousSibling)),
									!n)
								)
									return !1;
								for (
									var u = i.doc.splitLines(
											(function (t, e, n, i, r) {
												var o = "",
													s = !1,
													a = t.doc.lineSeparator(),
													l = !1;
												function c(t) {
													return function (e) {
														return e.id == t;
													};
												}
												function h() {
													s && ((o += a), l && (o += a), (s = l = !1));
												}
												function u(t) {
													t && (h(), (o += t));
												}
												function f(e) {
													if (1 == e.nodeType) {
														var n = e.getAttribute("cm-text");
														if (n) return void u(n);
														var o,
															d = e.getAttribute("cm-marker");
														if (d) {
															var p = t.findMarks(
																te(i, 0),
																te(r + 1, 0),
																c(+d)
															);
															return void (
																p.length &&
																(o = p[0].find(0)) &&
																u(Vt(t.doc, o.from, o.to).join(a))
															);
														}
														if ("false" == e.getAttribute("contenteditable"))
															return;
														var g = /^(pre|div|p|li|table|br)$/i.test(
															e.nodeName
														);
														if (
															!/^br$/i.test(e.nodeName) &&
															0 == e.textContent.length
														)
															return;
														g && h();
														for (var m = 0; m < e.childNodes.length; m++)
															f(e.childNodes[m]);
														/^(pre|p)$/i.test(e.nodeName) && (l = !0),
															g && (s = !0);
													} else
														3 == e.nodeType &&
															u(
																e.nodeValue
																	.replace(/\u200b/g, "")
																	.replace(/\u00a0/g, " ")
															);
												}
												for (; f(e), e != n; ) (e = e.nextSibling), (l = !1);
												return o;
											})(i, n, c, e, l)
										),
										f = Vt(i.doc, te(e, 0), te(l, qt(i.doc, l).text.length));
									u.length > 1 && f.length > 1;

								)
									if (Y(u) == Y(f)) u.pop(), f.pop(), l--;
									else {
										if (u[0] != f[0]) break;
										u.shift(), f.shift(), e++;
									}
								for (
									var d = 0,
										p = 0,
										g = u[0],
										m = f[0],
										v = Math.min(g.length, m.length);
									d < v && g.charCodeAt(d) == m.charCodeAt(d);

								)
									++d;
								for (
									var _ = Y(u),
										y = Y(f),
										x = Math.min(
											_.length - (1 == u.length ? d : 0),
											y.length - (1 == f.length ? d : 0)
										);
									p < x &&
									_.charCodeAt(_.length - p - 1) ==
										y.charCodeAt(y.length - p - 1);

								)
									++p;
								if (1 == u.length && 1 == f.length && e == s.line)
									for (
										;
										d &&
										d > s.ch &&
										_.charCodeAt(_.length - p - 1) ==
											y.charCodeAt(y.length - p - 1);

									)
										d--, p++;
								(u[u.length - 1] = _.slice(0, _.length - p).replace(
									/^\u200b+/,
									""
								)),
									(u[0] = u[0].slice(d).replace(/\u200b+$/, ""));
								var k = te(e, d),
									b = te(l, f.length ? Y(f).length - p : 0);
								return u.length > 1 || u[0] || ee(k, b)
									? (go(i.doc, u, k, b, "+input"), !0)
									: void 0;
							}),
							(Us.prototype.ensurePolled = function () {
								this.forceCompositionEnd();
							}),
							(Us.prototype.reset = function () {
								this.forceCompositionEnd();
							}),
							(Us.prototype.forceCompositionEnd = function () {
								this.composing &&
									(clearTimeout(this.readDOMTimeout),
									(this.composing = null),
									this.updateFromDOM(),
									this.div.blur(),
									this.div.focus());
							}),
							(Us.prototype.readFromDOMSoon = function () {
								var t = this;
								null == this.readDOMTimeout &&
									(this.readDOMTimeout = setTimeout(function () {
										if (((t.readDOMTimeout = null), t.composing)) {
											if (!t.composing.done) return;
											t.composing = null;
										}
										t.updateFromDOM();
									}, 80));
							}),
							(Us.prototype.updateFromDOM = function () {
								var t = this;
								(!this.cm.isReadOnly() && this.pollContent()) ||
									Ji(this.cm, function () {
										return ui(t.cm);
									});
							}),
							(Us.prototype.setUneditable = function (t) {
								t.contentEditable = "false";
							}),
							(Us.prototype.onKeyPress = function (t) {
								0 == t.charCode ||
									this.composing ||
									(t.preventDefault(),
									this.cm.isReadOnly() ||
										tr(this.cm, Is)(
											this.cm,
											String.fromCharCode(
												null == t.charCode ? t.keyCode : t.charCode
											),
											0
										));
							}),
							(Us.prototype.readOnlyChanged = function (t) {
								this.div.contentEditable = String("nocursor" != t);
							}),
							(Us.prototype.onContextMenu = function () {}),
							(Us.prototype.resetPosition = function () {}),
							(Us.prototype.needsContentAttribute = !0);
						var Gs = function (t) {
							(this.cm = t),
								(this.prevInput = ""),
								(this.pollingFast = !1),
								(this.polling = new B()),
								(this.hasSelection = !1),
								(this.composing = null);
						};
						(Gs.prototype.init = function (t) {
							var e = this,
								n = this,
								i = this.cm;
							this.createField(t);
							var r = this.textarea;
							function o(t) {
								if (!gt(i, t)) {
									if (i.somethingSelected())
										Ns({ lineWise: !1, text: i.getSelections() });
									else {
										if (!i.options.lineWiseCopyCut) return;
										var e = Rs(i);
										Ns({ lineWise: !0, text: e.text }),
											"cut" == t.type
												? i.setSelections(e.ranges, null, z)
												: ((n.prevInput = ""),
												  (r.value = e.text.join("\n")),
												  R(r));
									}
									"cut" == t.type && (i.state.cutIncoming = +new Date());
								}
							}
							t.wrapper.insertBefore(this.wrapper, t.wrapper.firstChild),
								g && (r.style.width = "0px"),
								ut(r, "input", function () {
									s && a >= 9 && e.hasSelection && (e.hasSelection = null),
										n.poll();
								}),
								ut(r, "paste", function (t) {
									gt(i, t) ||
										Ms(t, i) ||
										((i.state.pasteIncoming = +new Date()), n.fastPoll());
								}),
								ut(r, "cut", o),
								ut(r, "copy", o),
								ut(t.scroller, "paste", function (e) {
									if (!bn(t, e) && !gt(i, e)) {
										if (!r.dispatchEvent)
											return (
												(i.state.pasteIncoming = +new Date()), void n.focus()
											);
										var o = new Event("paste");
										(o.clipboardData = e.clipboardData), r.dispatchEvent(o);
									}
								}),
								ut(t.lineSpace, "selectstart", function (e) {
									bn(t, e) || yt(e);
								}),
								ut(r, "compositionstart", function () {
									var t = i.getCursor("from");
									n.composing && n.composing.range.clear(),
										(n.composing = {
											start: t,
											range: i.markText(t, i.getCursor("to"), {
												className: "CodeMirror-composing",
											}),
										});
								}),
								ut(r, "compositionend", function () {
									n.composing &&
										(n.poll(), n.composing.range.clear(), (n.composing = null));
								});
						}),
							(Gs.prototype.createField = function (t) {
								(this.wrapper = Ps()),
									(this.textarea = this.wrapper.firstChild);
							}),
							(Gs.prototype.screenReaderLabelChanged = function (t) {
								t
									? this.textarea.setAttribute("aria-label", t)
									: this.textarea.removeAttribute("aria-label");
							}),
							(Gs.prototype.prepareSelection = function () {
								var t = this.cm,
									e = t.display,
									n = t.doc,
									i = vi(t);
								if (t.options.moveInputWithCursor) {
									var r = Vn(t, n.sel.primary().head, "div"),
										o = e.wrapper.getBoundingClientRect(),
										s = e.lineDiv.getBoundingClientRect();
									(i.teTop = Math.max(
										0,
										Math.min(e.wrapper.clientHeight - 10, r.top + s.top - o.top)
									)),
										(i.teLeft = Math.max(
											0,
											Math.min(
												e.wrapper.clientWidth - 10,
												r.left + s.left - o.left
											)
										));
								}
								return i;
							}),
							(Gs.prototype.showSelection = function (t) {
								var e = this.cm.display;
								A(e.cursorDiv, t.cursors),
									A(e.selectionDiv, t.selection),
									null != t.teTop &&
										((this.wrapper.style.top = t.teTop + "px"),
										(this.wrapper.style.left = t.teLeft + "px"));
							}),
							(Gs.prototype.reset = function (t) {
								if (!this.contextMenuPending && !this.composing) {
									var e = this.cm;
									if (e.somethingSelected()) {
										this.prevInput = "";
										var n = e.getSelection();
										(this.textarea.value = n),
											e.state.focused && R(this.textarea),
											s && a >= 9 && (this.hasSelection = n);
									} else
										t ||
											((this.prevInput = this.textarea.value = ""),
											s && a >= 9 && (this.hasSelection = null));
								}
							}),
							(Gs.prototype.getField = function () {
								return this.textarea;
							}),
							(Gs.prototype.supportsTouch = function () {
								return !1;
							}),
							(Gs.prototype.focus = function () {
								if (
									"nocursor" != this.cm.options.readOnly &&
									(!v || I() != this.textarea)
								)
									try {
										this.textarea.focus();
									} catch (t) {}
							}),
							(Gs.prototype.blur = function () {
								this.textarea.blur();
							}),
							(Gs.prototype.resetPosition = function () {
								this.wrapper.style.top = this.wrapper.style.left = 0;
							}),
							(Gs.prototype.receivedFocus = function () {
								this.slowPoll();
							}),
							(Gs.prototype.slowPoll = function () {
								var t = this;
								this.pollingFast ||
									this.polling.set(this.cm.options.pollInterval, function () {
										t.poll(), t.cm.state.focused && t.slowPoll();
									});
							}),
							(Gs.prototype.fastPoll = function () {
								var t = !1,
									e = this;
								(e.pollingFast = !0),
									e.polling.set(20, function n() {
										e.poll() || t
											? ((e.pollingFast = !1), e.slowPoll())
											: ((t = !0), e.polling.set(60, n));
									});
							}),
							(Gs.prototype.poll = function () {
								var t = this,
									e = this.cm,
									n = this.textarea,
									i = this.prevInput;
								if (
									this.contextMenuPending ||
									!e.state.focused ||
									(It(n) && !i && !this.composing) ||
									e.isReadOnly() ||
									e.options.disableInput ||
									e.state.keySeq
								)
									return !1;
								var r = n.value;
								if (r == i && !e.somethingSelected()) return !1;
								if (
									(s && a >= 9 && this.hasSelection === r) ||
									(_ && /[\uf700-\uf7ff]/.test(r))
								)
									return e.display.input.reset(), !1;
								if (e.doc.sel == e.display.selForContextMenu) {
									var o = r.charCodeAt(0);
									if ((8203 != o || i || (i = "​"), 8666 == o))
										return this.reset(), this.cm.execCommand("undo");
								}
								for (
									var l = 0, c = Math.min(i.length, r.length);
									l < c && i.charCodeAt(l) == r.charCodeAt(l);

								)
									++l;
								return (
									Ji(e, function () {
										Is(
											e,
											r.slice(l),
											i.length - l,
											null,
											t.composing ? "*compose" : null
										),
											r.length > 1e3 || r.indexOf("\n") > -1
												? (n.value = t.prevInput = "")
												: (t.prevInput = r),
											t.composing &&
												(t.composing.range.clear(),
												(t.composing.range = e.markText(
													t.composing.start,
													e.getCursor("to"),
													{ className: "CodeMirror-composing" }
												)));
									}),
									!0
								);
							}),
							(Gs.prototype.ensurePolled = function () {
								this.pollingFast && this.poll() && (this.pollingFast = !1);
							}),
							(Gs.prototype.onKeyPress = function () {
								s && a >= 9 && (this.hasSelection = null), this.fastPoll();
							}),
							(Gs.prototype.onContextMenu = function (t) {
								var e = this,
									n = e.cm,
									i = n.display,
									r = e.textarea;
								e.contextMenuPending && e.contextMenuPending();
								var o = ci(n, t),
									c = i.scroller.scrollTop;
								if (o && !u) {
									n.options.resetSelectionOnContextMenu &&
										-1 == n.doc.sel.contains(o) &&
										tr(n, Jr)(n.doc, wr(o), z);
									var h,
										f = r.style.cssText,
										d = e.wrapper.style.cssText,
										p = e.wrapper.offsetParent.getBoundingClientRect();
									if (
										((e.wrapper.style.cssText = "position: static"),
										(r.style.cssText =
											"position: absolute; width: 30px; height: 30px;\n      top: " +
											(t.clientY - p.top - 5) +
											"px; left: " +
											(t.clientX - p.left - 5) +
											"px;\n      z-index: 1000; background: " +
											(s ? "rgba(255, 255, 255, .05)" : "transparent") +
											";\n      outline: none; border-width: 0; outline: none; overflow: hidden; opacity: .05; filter: alpha(opacity=5);"),
										l && (h = window.scrollY),
										i.input.focus(),
										l && window.scrollTo(null, h),
										i.input.reset(),
										n.somethingSelected() || (r.value = e.prevInput = " "),
										(e.contextMenuPending = v),
										(i.selForContextMenu = n.doc.sel),
										clearTimeout(i.detectingSelectAll),
										s && a >= 9 && m(),
										T)
									) {
										bt(t);
										var g = function () {
											dt(window, "mouseup", g), setTimeout(v, 20);
										};
										ut(window, "mouseup", g);
									} else setTimeout(v, 50);
								}
								function m() {
									if (null != r.selectionStart) {
										var t = n.somethingSelected(),
											o = "​" + (t ? r.value : "");
										(r.value = "⇚"),
											(r.value = o),
											(e.prevInput = t ? "" : "​"),
											(r.selectionStart = 1),
											(r.selectionEnd = o.length),
											(i.selForContextMenu = n.doc.sel);
									}
								}
								function v() {
									if (
										e.contextMenuPending == v &&
										((e.contextMenuPending = !1),
										(e.wrapper.style.cssText = d),
										(r.style.cssText = f),
										s &&
											a < 9 &&
											i.scrollbars.setScrollTop((i.scroller.scrollTop = c)),
										null != r.selectionStart)
									) {
										(!s || (s && a < 9)) && m();
										var t = 0,
											o = function () {
												i.selForContextMenu == n.doc.sel &&
												0 == r.selectionStart &&
												r.selectionEnd > 0 &&
												"​" == e.prevInput
													? tr(n, ao)(n)
													: t++ < 10
													? (i.detectingSelectAll = setTimeout(o, 500))
													: ((i.selForContextMenu = null), i.input.reset());
											};
										i.detectingSelectAll = setTimeout(o, 200);
									}
								}
							}),
							(Gs.prototype.readOnlyChanged = function (t) {
								t || this.reset(),
									(this.textarea.disabled = "nocursor" == t),
									(this.textarea.readOnly = !!t);
							}),
							(Gs.prototype.setUneditable = function () {}),
							(Gs.prototype.needsContentAttribute = !1),
							(function (t) {
								var e = t.optionHandlers;
								function n(n, i, r, o) {
									(t.defaults[n] = i),
										r &&
											(e[n] = o
												? function (t, e, n) {
														n != bs && r(t, e, n);
												  }
												: r);
								}
								(t.defineOption = n),
									(t.Init = bs),
									n(
										"value",
										"",
										function (t, e) {
											return t.setValue(e);
										},
										!0
									),
									n(
										"mode",
										null,
										function (t, e) {
											(t.doc.modeOption = e), Or(t);
										},
										!0
									),
									n("indentUnit", 2, Or, !0),
									n("indentWithTabs", !1),
									n("smartIndent", !0),
									n(
										"tabSize",
										4,
										function (t) {
											Nr(t), Un(t), ui(t);
										},
										!0
									),
									n("lineSeparator", null, function (t, e) {
										if (((t.doc.lineSep = e), e)) {
											var n = [],
												i = t.doc.first;
											t.doc.iter(function (t) {
												for (var r = 0; ; ) {
													var o = t.text.indexOf(e, r);
													if (-1 == o) break;
													(r = o + e.length), n.push(te(i, o));
												}
												i++;
											});
											for (var r = n.length - 1; r >= 0; r--)
												go(t.doc, e, n[r], te(n[r].line, n[r].ch + e.length));
										}
									}),
									n(
										"specialChars",
										/[\u0000-\u001f\u007f-\u009f\u00ad\u061c\u200b\u200e\u200f\u2028\u2029\ufeff\ufff9-\ufffc]/g,
										function (t, e, n) {
											(t.state.specialChars = new RegExp(
												e.source + (e.test("\t") ? "" : "|\t"),
												"g"
											)),
												n != bs && t.refresh();
										}
									),
									n(
										"specialCharPlaceholder",
										Ze,
										function (t) {
											return t.refresh();
										},
										!0
									),
									n("electricChars", !0),
									n(
										"inputStyle",
										v ? "contenteditable" : "textarea",
										function () {
											throw new Error(
												"inputStyle can not (yet) be changed in a running editor"
											);
										},
										!0
									),
									n(
										"spellcheck",
										!1,
										function (t, e) {
											return (t.getInputField().spellcheck = e);
										},
										!0
									),
									n(
										"autocorrect",
										!1,
										function (t, e) {
											return (t.getInputField().autocorrect = e);
										},
										!0
									),
									n(
										"autocapitalize",
										!1,
										function (t, e) {
											return (t.getInputField().autocapitalize = e);
										},
										!0
									),
									n("rtlMoveVisually", !x),
									n("wholeLineUpdateBefore", !0),
									n(
										"theme",
										"default",
										function (t) {
											ks(t), gr(t);
										},
										!0
									),
									n("keyMap", "default", function (t, e, n) {
										var i = Xo(e),
											r = n != bs && Xo(n);
										r && r.detach && r.detach(t, i),
											i.attach && i.attach(t, r || null);
									}),
									n("extraKeys", null),
									n("configureMouse", null),
									n("lineWrapping", !1, Es, !0),
									n(
										"gutters",
										[],
										function (t, e) {
											(t.display.gutterSpecs = dr(e, t.options.lineNumbers)),
												gr(t);
										},
										!0
									),
									n(
										"fixedGutter",
										!0,
										function (t, e) {
											(t.display.gutters.style.left = e
												? si(t.display) + "px"
												: "0"),
												t.refresh();
										},
										!0
									),
									n(
										"coverGutterNextToScrollbar",
										!1,
										function (t) {
											return Hi(t);
										},
										!0
									),
									n(
										"scrollbarStyle",
										"native",
										function (t) {
											ji(t),
												Hi(t),
												t.display.scrollbars.setScrollTop(t.doc.scrollTop),
												t.display.scrollbars.setScrollLeft(t.doc.scrollLeft);
										},
										!0
									),
									n(
										"lineNumbers",
										!1,
										function (t, e) {
											(t.display.gutterSpecs = dr(t.options.gutters, e)), gr(t);
										},
										!0
									),
									n("firstLineNumber", 1, gr, !0),
									n(
										"lineNumberFormatter",
										function (t) {
											return t;
										},
										gr,
										!0
									),
									n("showCursorWhenSelecting", !1, mi, !0),
									n("resetSelectionOnContextMenu", !0),
									n("lineWiseCopyCut", !0),
									n("pasteLinesPerSelection", !0),
									n("selectionsMayTouch", !1),
									n("readOnly", !1, function (t, e) {
										"nocursor" == e && (wi(t), t.display.input.blur()),
											t.display.input.readOnlyChanged(e);
									}),
									n("screenReaderLabel", null, function (t, e) {
										(e = "" === e ? null : e),
											t.display.input.screenReaderLabelChanged(e);
									}),
									n(
										"disableInput",
										!1,
										function (t, e) {
											e || t.display.input.reset();
										},
										!0
									),
									n("dragDrop", !0, ws),
									n("allowDropFileTypes", null),
									n("cursorBlinkRate", 530),
									n("cursorScrollMargin", 0),
									n("cursorHeight", 1, mi, !0),
									n("singleCursorHeightPerLine", !0, mi, !0),
									n("workTime", 100),
									n("workDelay", 100),
									n("flattenSpans", !0, Nr, !0),
									n("addModeClass", !1, Nr, !0),
									n("pollInterval", 100),
									n("undoDepth", 200, function (t, e) {
										return (t.doc.history.undoDepth = e);
									}),
									n("historyEventDelay", 1250),
									n(
										"viewportMargin",
										10,
										function (t) {
											return t.refresh();
										},
										!0
									),
									n("maxHighlightLength", 1e4, Nr, !0),
									n("moveInputWithCursor", !0, function (t, e) {
										e || t.display.input.resetPosition();
									}),
									n("tabindex", null, function (t, e) {
										return (t.display.input.getField().tabIndex = e || "");
									}),
									n("autofocus", null),
									n(
										"direction",
										"ltr",
										function (t, e) {
											return t.doc.setDirection(e);
										},
										!0
									),
									n("phrases", null);
							})(Ss),
							(function (t) {
								var e = t.optionHandlers,
									n = (t.helpers = {});
								(t.prototype = {
									constructor: t,
									focus: function () {
										window.focus(), this.display.input.focus();
									},
									setOption: function (t, n) {
										var i = this.options,
											r = i[t];
										(i[t] == n && "mode" != t) ||
											((i[t] = n),
											e.hasOwnProperty(t) && tr(this, e[t])(this, n, r),
											pt(this, "optionChange", this, t));
									},
									getOption: function (t) {
										return this.options[t];
									},
									getDoc: function () {
										return this.doc;
									},
									addKeyMap: function (t, e) {
										this.state.keyMaps[e ? "push" : "unshift"](Xo(t));
									},
									removeKeyMap: function (t) {
										for (var e = this.state.keyMaps, n = 0; n < e.length; ++n)
											if (e[n] == t || e[n].name == t)
												return e.splice(n, 1), !0;
									},
									addOverlay: er(function (e, n) {
										var i = e.token ? e : t.getMode(this.options, e);
										if (i.startState)
											throw new Error("Overlays may not be stateful.");
										!(function (t, e, n) {
											for (var i = 0, r = n(e); i < t.length && n(t[i]) <= r; )
												i++;
											t.splice(i, 0, e);
										})(
											this.state.overlays,
											{
												mode: i,
												modeSpec: e,
												opaque: n && n.opaque,
												priority: (n && n.priority) || 0,
											},
											function (t) {
												return t.priority;
											}
										),
											this.state.modeGen++,
											ui(this);
									}),
									removeOverlay: er(function (t) {
										for (
											var e = this.state.overlays, n = 0;
											n < e.length;
											++n
										) {
											var i = e[n].modeSpec;
											if (i == t || ("string" == typeof t && i.name == t))
												return (
													e.splice(n, 1), this.state.modeGen++, void ui(this)
												);
										}
									}),
									indentLine: er(function (t, e, n) {
										"string" != typeof e &&
											"number" != typeof e &&
											(e =
												null == e
													? this.options.smartIndent
														? "smart"
														: "prev"
													: e
													? "add"
													: "subtract"),
											Zt(this.doc, t) && Ls(this, t, e, n);
									}),
									indentSelection: er(function (t) {
										for (
											var e = this.doc.sel.ranges, n = -1, i = 0;
											i < e.length;
											i++
										) {
											var r = e[i];
											if (r.empty())
												r.head.line > n &&
													(Ls(this, r.head.line, t, !0),
													(n = r.head.line),
													i == this.doc.sel.primIndex && Ni(this));
											else {
												var o = r.from(),
													s = r.to(),
													a = Math.max(n, o.line);
												n =
													Math.min(this.lastLine(), s.line - (s.ch ? 0 : 1)) +
													1;
												for (var l = a; l < n; ++l) Ls(this, l, t);
												var c = this.doc.sel.ranges;
												0 == o.ch &&
													e.length == c.length &&
													c[i].from().ch > 0 &&
													Xr(this.doc, i, new Tr(o, c[i].to()), z);
											}
										}
									}),
									getTokenAt: function (t, e) {
										return _e(this, t, e);
									},
									getLineTokens: function (t, e) {
										return _e(this, te(t), e, !0);
									},
									getTokenTypeAt: function (t) {
										t = ae(this.doc, t);
										var e,
											n = fe(this, qt(this.doc, t.line)),
											i = 0,
											r = (n.length - 1) / 2,
											o = t.ch;
										if (0 == o) e = n[2];
										else
											for (;;) {
												var s = (i + r) >> 1;
												if ((s ? n[2 * s - 1] : 0) >= o) r = s;
												else {
													if (!(n[2 * s + 1] < o)) {
														e = n[2 * s + 2];
														break;
													}
													i = s + 1;
												}
											}
										var a = e ? e.indexOf("overlay ") : -1;
										return a < 0 ? e : 0 == a ? null : e.slice(0, a - 1);
									},
									getModeAt: function (e) {
										var n = this.doc.mode;
										return n.innerMode
											? t.innerMode(n, this.getTokenAt(e).state).mode
											: n;
									},
									getHelper: function (t, e) {
										return this.getHelpers(t, e)[0];
									},
									getHelpers: function (t, e) {
										var i = [];
										if (!n.hasOwnProperty(e)) return i;
										var r = n[e],
											o = this.getModeAt(t);
										if ("string" == typeof o[e]) r[o[e]] && i.push(r[o[e]]);
										else if (o[e])
											for (var s = 0; s < o[e].length; s++) {
												var a = r[o[e][s]];
												a && i.push(a);
											}
										else
											o.helperType && r[o.helperType]
												? i.push(r[o.helperType])
												: r[o.name] && i.push(r[o.name]);
										for (var l = 0; l < r._global.length; l++) {
											var c = r._global[l];
											c.pred(o, this) && -1 == U(i, c.val) && i.push(c.val);
										}
										return i;
									},
									getStateAfter: function (t, e) {
										var n = this.doc;
										return de(
											this,
											(t = se(n, null == t ? n.first + n.size - 1 : t)) + 1,
											e
										).state;
									},
									cursorCoords: function (t, e) {
										var n = this.doc.sel.primary();
										return Vn(
											this,
											null == t
												? n.head
												: "object" == typeof t
												? ae(this.doc, t)
												: t
												? n.from()
												: n.to(),
											e || "page"
										);
									},
									charCoords: function (t, e) {
										return qn(this, ae(this.doc, t), e || "page");
									},
									coordsChar: function (t, e) {
										return Xn(this, (t = Gn(this, t, e || "page")).left, t.top);
									},
									lineAtHeight: function (t, e) {
										return (
											(t = Gn(this, { top: t, left: 0 }, e || "page").top),
											Qt(this.doc, t + this.display.viewOffset)
										);
									},
									heightAtLine: function (t, e, n) {
										var i,
											r = !1;
										if ("number" == typeof t) {
											var o = this.doc.first + this.doc.size - 1;
											t < this.doc.first
												? (t = this.doc.first)
												: t > o && ((t = o), (r = !0)),
												(i = qt(this.doc, t));
										} else i = t;
										return (
											jn(this, i, { top: 0, left: 0 }, e || "page", n || r)
												.top + (r ? this.doc.height - We(i) : 0)
										);
									},
									defaultTextHeight: function () {
										return ii(this.display);
									},
									defaultCharWidth: function () {
										return ri(this.display);
									},
									getViewport: function () {
										return {
											from: this.display.viewFrom,
											to: this.display.viewTo,
										};
									},
									addWidget: function (t, e, n, i, r) {
										var o,
											s,
											a,
											l = this.display,
											c = (t = Vn(this, ae(this.doc, t))).bottom,
											h = t.left;
										if (
											((e.style.position = "absolute"),
											e.setAttribute("cm-ignore-events", "true"),
											this.display.input.setUneditable(e),
											l.sizer.appendChild(e),
											"over" == i)
										)
											c = t.top;
										else if ("above" == i || "near" == i) {
											var u = Math.max(l.wrapper.clientHeight, this.doc.height),
												f = Math.max(
													l.sizer.clientWidth,
													l.lineSpace.clientWidth
												);
											("above" == i || t.bottom + e.offsetHeight > u) &&
											t.top > e.offsetHeight
												? (c = t.top - e.offsetHeight)
												: t.bottom + e.offsetHeight <= u && (c = t.bottom),
												h + e.offsetWidth > f && (h = f - e.offsetWidth);
										}
										(e.style.top = c + "px"),
											(e.style.left = e.style.right = ""),
											"right" == r
												? ((h = l.sizer.clientWidth - e.offsetWidth),
												  (e.style.right = "0px"))
												: ("left" == r
														? (h = 0)
														: "middle" == r &&
														  (h = (l.sizer.clientWidth - e.offsetWidth) / 2),
												  (e.style.left = h + "px")),
											n &&
												((o = this),
												(s = {
													left: h,
													top: c,
													right: h + e.offsetWidth,
													bottom: c + e.offsetHeight,
												}),
												null != (a = Li(o, s)).scrollTop && Ri(o, a.scrollTop),
												null != a.scrollLeft && Pi(o, a.scrollLeft));
									},
									triggerOnKeyDown: er(hs),
									triggerOnKeyPress: er(fs),
									triggerOnKeyUp: us,
									triggerOnMouseDown: er(ms),
									execCommand: function (t) {
										if (es.hasOwnProperty(t)) return es[t].call(null, this);
									},
									triggerElectric: er(function (t) {
										$s(this, t);
									}),
									findPosH: function (t, e, n, i) {
										var r = 1;
										e < 0 && ((r = -1), (e = -e));
										for (
											var o = ae(this.doc, t), s = 0;
											s < e && !(o = Fs(this.doc, o, r, n, i)).hitSide;
											++s
										);
										return o;
									},
									moveH: er(function (t, e) {
										var n = this;
										this.extendSelectionsBy(function (i) {
											return n.display.shift || n.doc.extend || i.empty()
												? Fs(n.doc, i.head, t, e, n.options.rtlMoveVisually)
												: t < 0
												? i.from()
												: i.to();
										}, j);
									}),
									deleteH: er(function (t, e) {
										var n = this.doc.sel,
											i = this.doc;
										n.somethingSelected()
											? i.replaceSelection("", null, "+delete")
											: Qo(this, function (n) {
													var r = Fs(i, n.head, t, e, !1);
													return t < 0
														? { from: r, to: n.head }
														: { from: n.head, to: r };
											  });
									}),
									findPosV: function (t, e, n, i) {
										var r = 1,
											o = i;
										e < 0 && ((r = -1), (e = -e));
										for (var s = ae(this.doc, t), a = 0; a < e; ++a) {
											var l = Vn(this, s, "div");
											if (
												(null == o ? (o = l.left) : (l.left = o),
												(s = Bs(this, l, r, n)).hitSide)
											)
												break;
										}
										return s;
									},
									moveV: er(function (t, e) {
										var n = this,
											i = this.doc,
											r = [],
											o =
												!this.display.shift &&
												!i.extend &&
												i.sel.somethingSelected();
										if (
											(i.extendSelectionsBy(function (s) {
												if (o) return t < 0 ? s.from() : s.to();
												var a = Vn(n, s.head, "div");
												null != s.goalColumn && (a.left = s.goalColumn),
													r.push(a.left);
												var l = Bs(n, a, t, e);
												return (
													"page" == e &&
														s == i.sel.primary() &&
														Oi(n, qn(n, l, "div").top - a.top),
													l
												);
											}, j),
											r.length)
										)
											for (var s = 0; s < i.sel.ranges.length; s++)
												i.sel.ranges[s].goalColumn = r[s];
									}),
									findWordAt: function (t) {
										var e = qt(this.doc, t.line).text,
											n = t.ch,
											i = t.ch;
										if (e) {
											var r = this.getHelper(t, "wordChars");
											("before" != t.sticky && i != e.length) || !n ? ++i : --n;
											for (
												var o = e.charAt(n),
													s = tt(o, r)
														? function (t) {
																return tt(t, r);
														  }
														: /\s/.test(o)
														? function (t) {
																return /\s/.test(t);
														  }
														: function (t) {
																return !/\s/.test(t) && !tt(t);
														  };
												n > 0 && s(e.charAt(n - 1));

											)
												--n;
											for (; i < e.length && s(e.charAt(i)); ) ++i;
										}
										return new Tr(te(t.line, n), te(t.line, i));
									},
									toggleOverwrite: function (t) {
										(null != t && t == this.state.overwrite) ||
											((this.state.overwrite = !this.state.overwrite)
												? M(this.display.cursorDiv, "CodeMirror-overwrite")
												: E(this.display.cursorDiv, "CodeMirror-overwrite"),
											pt(this, "overwriteToggle", this, this.state.overwrite));
									},
									hasFocus: function () {
										return this.display.input.getField() == I();
									},
									isReadOnly: function () {
										return !(!this.options.readOnly && !this.doc.cantEdit);
									},
									scrollTo: er(function (t, e) {
										Ii(this, t, e);
									}),
									getScrollInfo: function () {
										var t = this.display.scroller;
										return {
											left: t.scrollLeft,
											top: t.scrollTop,
											height:
												t.scrollHeight - En(this) - this.display.barHeight,
											width: t.scrollWidth - En(this) - this.display.barWidth,
											clientHeight: An(this),
											clientWidth: Sn(this),
										};
									},
									scrollIntoView: er(function (t, e) {
										null == t
											? ((t = { from: this.doc.sel.primary().head, to: null }),
											  null == e && (e = this.options.cursorScrollMargin))
											: "number" == typeof t
											? (t = { from: te(t, 0), to: null })
											: null == t.from && (t = { from: t, to: null }),
											t.to || (t.to = t.from),
											(t.margin = e || 0),
											null != t.from.line
												? (function (t, e) {
														Mi(t), (t.curOp.scrollToPos = e);
												  })(this, t)
												: $i(this, t.from, t.to, t.margin);
									}),
									setSize: er(function (t, e) {
										var n = this,
											i = function (t) {
												return "number" == typeof t || /^\d+$/.test(String(t))
													? t + "px"
													: t;
											};
										null != t && (this.display.wrapper.style.width = i(t)),
											null != e && (this.display.wrapper.style.height = i(e)),
											this.options.lineWrapping && Bn(this);
										var r = this.display.viewFrom;
										this.doc.iter(r, this.display.viewTo, function (t) {
											if (t.widgets)
												for (var e = 0; e < t.widgets.length; e++)
													if (t.widgets[e].noHScroll) {
														fi(n, r, "widget");
														break;
													}
											++r;
										}),
											(this.curOp.forceUpdate = !0),
											pt(this, "refresh", this);
									}),
									operation: function (t) {
										return Ji(this, t);
									},
									startOperation: function () {
										return qi(this);
									},
									endOperation: function () {
										return Vi(this);
									},
									refresh: er(function () {
										var t = this.display.cachedTextHeight;
										ui(this),
											(this.curOp.forceUpdate = !0),
											Un(this),
											Ii(this, this.doc.scrollLeft, this.doc.scrollTop),
											cr(this.display),
											(null == t ||
												Math.abs(t - ii(this.display)) > 0.5 ||
												this.options.lineWrapping) &&
												li(this),
											pt(this, "refresh", this);
									}),
									swapDoc: er(function (t) {
										var e = this.doc;
										return (
											(e.cm = null),
											this.state.selectingText && this.state.selectingText(),
											Rr(this, t),
											Un(this),
											this.display.input.reset(),
											Ii(this, t.scrollLeft, t.scrollTop),
											(this.curOp.forceScroll = !0),
											ln(this, "swapDoc", this, e),
											e
										);
									}),
									phrase: function (t) {
										var e = this.options.phrases;
										return e && Object.prototype.hasOwnProperty.call(e, t)
											? e[t]
											: t;
									},
									getInputField: function () {
										return this.display.input.getField();
									},
									getWrapperElement: function () {
										return this.display.wrapper;
									},
									getScrollerElement: function () {
										return this.display.scroller;
									},
									getGutterElement: function () {
										return this.display.gutters;
									},
								}),
									_t(t),
									(t.registerHelper = function (e, i, r) {
										n.hasOwnProperty(e) || (n[e] = t[e] = { _global: [] }),
											(n[e][i] = r);
									}),
									(t.registerGlobalHelper = function (e, i, r, o) {
										t.registerHelper(e, i, o),
											n[e]._global.push({ pred: r, val: o });
									});
							})(Ss);
						var qs = "iter insert remove copy getEditor constructor".split(" ");
						for (var Vs in No.prototype)
							No.prototype.hasOwnProperty(Vs) &&
								U(qs, Vs) < 0 &&
								(Ss.prototype[Vs] = (function (t) {
									return function () {
										return t.apply(this.doc, arguments);
									};
								})(No.prototype[Vs]));
						return (
							_t(No),
							(Ss.inputStyles = { textarea: Gs, contenteditable: Us }),
							(Ss.defineMode = function (t) {
								Ss.defaults.mode || "null" == t || (Ss.defaults.mode = t),
									Pt.apply(this, arguments);
							}),
							(Ss.defineMIME = function (t, e) {
								Dt[t] = e;
							}),
							Ss.defineMode("null", function () {
								return {
									token: function (t) {
										return t.skipToEnd();
									},
								};
							}),
							Ss.defineMIME("text/plain", "null"),
							(Ss.defineExtension = function (t, e) {
								Ss.prototype[t] = e;
							}),
							(Ss.defineDocExtension = function (t, e) {
								No.prototype[t] = e;
							}),
							(Ss.fromTextArea = function (t, e) {
								if (
									(((e = e ? P(e) : {}).value = t.value),
									!e.tabindex && t.tabIndex && (e.tabindex = t.tabIndex),
									!e.placeholder &&
										t.placeholder &&
										(e.placeholder = t.placeholder),
									null == e.autofocus)
								) {
									var n = I();
									e.autofocus =
										n == t ||
										(null != t.getAttribute("autofocus") && n == document.body);
								}
								function i() {
									t.value = a.getValue();
								}
								var r;
								if (
									t.form &&
									(ut(t.form, "submit", i), !e.leaveSubmitMethodAlone)
								) {
									var o = t.form;
									r = o.submit;
									try {
										var s = (o.submit = function () {
											i(), (o.submit = r), o.submit(), (o.submit = s);
										});
									} catch (t) {}
								}
								(e.finishInit = function (n) {
									(n.save = i),
										(n.getTextArea = function () {
											return t;
										}),
										(n.toTextArea = function () {
											(n.toTextArea = isNaN),
												i(),
												t.parentNode.removeChild(n.getWrapperElement()),
												(t.style.display = ""),
												t.form &&
													(dt(t.form, "submit", i),
													e.leaveSubmitMethodAlone ||
														"function" != typeof t.form.submit ||
														(t.form.submit = r));
										});
								}),
									(t.style.display = "none");
								var a = Ss(function (e) {
									return t.parentNode.insertBefore(e, t.nextSibling);
								}, e);
								return a;
							}),
							(function (t) {
								(t.off = dt),
									(t.on = ut),
									(t.wheelEventPixels = xr),
									(t.Doc = No),
									(t.splitLines = Nt),
									(t.countColumn = F),
									(t.findColumn = G),
									(t.isWordChar = J),
									(t.Pass = H),
									(t.signal = pt),
									(t.Line = qe),
									(t.changeEnd = Er),
									(t.scrollbarModel = Wi),
									(t.Pos = te),
									(t.cmpPos = ee),
									(t.modes = Rt),
									(t.mimeModes = Dt),
									(t.resolveMode = Ft),
									(t.getMode = Bt),
									(t.modeExtensions = Ut),
									(t.extendMode = Ht),
									(t.copyState = zt),
									(t.startState = jt),
									(t.innerMode = Wt),
									(t.commands = es),
									(t.keyMap = Wo),
									(t.keyName = Ko),
									(t.isModifierKey = Vo),
									(t.lookupKey = qo),
									(t.normalizeKeyMap = Go),
									(t.StringStream = Gt),
									(t.SharedTextMarker = So),
									(t.TextMarker = wo),
									(t.LineWidget = bo),
									(t.e_preventDefault = yt),
									(t.e_stopPropagation = xt),
									(t.e_stop = bt),
									(t.addClass = M),
									(t.contains = N),
									(t.rmClass = E),
									(t.keyNames = Bo);
							})(Ss),
							(Ss.version = "5.62.3"),
							Ss
						);
					}),
					"object" == typeof n && void 0 !== e
						? (e.exports = r())
						: "function" == typeof define && define.amd
						? define(r)
						: ((i = i || self).CodeMirror = r());
			},
			{},
		],
		14: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					function e(t, e, n, i, r, o) {
						(this.indented = t),
							(this.column = e),
							(this.type = n),
							(this.info = i),
							(this.align = r),
							(this.prev = o);
					}
					function n(t, n, i, r) {
						var o = t.indented;
						return (
							t.context &&
								"statement" == t.context.type &&
								"statement" != i &&
								(o = t.context.indented),
							(t.context = new e(o, n, i, r, null, t.context))
						);
					}
					function i(t) {
						var e = t.context.type;
						return (
							(")" != e && "]" != e && "}" != e) ||
								(t.indented = t.context.indented),
							(t.context = t.context.prev)
						);
					}
					function r(t, e, n) {
						return (
							"variable" == e.prevToken ||
							"type" == e.prevToken ||
							!!/\S(?:[^- ]>|[*\]])\s*$|\*$/.test(t.string.slice(0, n)) ||
							!(!e.typeAtEndOfLine || t.column() != t.indentation()) ||
							void 0
						);
					}
					function o(t) {
						for (;;) {
							if (!t || "top" == t.type) return !0;
							if ("}" == t.type && "namespace" != t.prev.info) return !1;
							t = t.prev;
						}
					}
					function s(t) {
						for (var e = {}, n = t.split(" "), i = 0; i < n.length; ++i)
							e[n[i]] = !0;
						return e;
					}
					function a(t, e) {
						return "function" == typeof t ? t(e) : t.propertyIsEnumerable(e);
					}
					t.defineMode("clike", function (s, l) {
						var c,
							h,
							u = s.indentUnit,
							f = l.statementIndentUnit || u,
							d = l.dontAlignCalls,
							p = l.keywords || {},
							g = l.types || {},
							m = l.builtin || {},
							v = l.blockKeywords || {},
							_ = l.defKeywords || {},
							y = l.atoms || {},
							x = l.hooks || {},
							k = l.multiLineStrings,
							b = !1 !== l.indentStatements,
							T = !1 !== l.indentSwitch,
							C = l.namespaceSeparator,
							w = l.isPunctuationChar || /[\[\]{}\(\),;\:\.]/,
							E = l.numberStart || /[\d\.]/,
							S =
								l.number ||
								/^(?:0x[a-f\d]+|0b[01]+|(?:\d+\.?\d*|\.\d+)(?:e[-+]?\d+)?)(u|ll?|l|f)?/i,
							A = l.isOperatorChar || /[+\-*&%=<>!?|\/]/,
							L = l.isIdentifierChar || /[\w\$_\xa1-\uffff]/,
							O = l.isReservedIdentifier || !1;
						function N(t, e) {
							var n,
								i = t.next();
							if (x[i]) {
								var r = x[i](t, e);
								if (!1 !== r) return r;
							}
							if ('"' == i || "'" == i)
								return (
									(e.tokenize =
										((n = i),
										function (t, e) {
											for (var i, r = !1, o = !1; null != (i = t.next()); ) {
												if (i == n && !r) {
													o = !0;
													break;
												}
												r = !r && "\\" == i;
											}
											return (o || (!r && !k)) && (e.tokenize = null), "string";
										})),
									e.tokenize(t, e)
								);
							if (E.test(i)) {
								if ((t.backUp(1), t.match(S))) return "number";
								t.next();
							}
							if (w.test(i)) return (c = i), null;
							if ("/" == i) {
								if (t.eat("*")) return (e.tokenize = I), I(t, e);
								if (t.eat("/")) return t.skipToEnd(), "comment";
							}
							if (A.test(i)) {
								for (; !t.match(/^\/[\/*]/, !1) && t.eat(A); );
								return "operator";
							}
							if ((t.eatWhile(L), C)) for (; t.match(C); ) t.eatWhile(L);
							var o = t.current();
							return a(p, o)
								? (a(v, o) && (c = "newstatement"),
								  a(_, o) && (h = !0),
								  "keyword")
								: a(g, o)
								? "type"
								: a(m, o) || (O && O(o))
								? (a(v, o) && (c = "newstatement"), "builtin")
								: a(y, o)
								? "atom"
								: "variable";
						}
						function I(t, e) {
							for (var n, i = !1; (n = t.next()); ) {
								if ("/" == n && i) {
									e.tokenize = null;
									break;
								}
								i = "*" == n;
							}
							return "comment";
						}
						function M(t, e) {
							l.typeFirstDefinitions &&
								t.eol() &&
								o(e.context) &&
								(e.typeAtEndOfLine = r(t, e, t.pos));
						}
						return {
							startState: function (t) {
								return {
									tokenize: null,
									context: new e((t || 0) - u, 0, "top", null, !1),
									indented: 0,
									startOfLine: !0,
									prevToken: null,
								};
							},
							token: function (t, e) {
								var s = e.context;
								if (
									(t.sol() &&
										(null == s.align && (s.align = !1),
										(e.indented = t.indentation()),
										(e.startOfLine = !0)),
									t.eatSpace())
								)
									return M(t, e), null;
								c = h = null;
								var a = (e.tokenize || N)(t, e);
								if ("comment" == a || "meta" == a) return a;
								if (
									(null == s.align && (s.align = !0),
									";" == c ||
										":" == c ||
										("," == c && t.match(/^\s*(?:\/\/.*)?$/, !1)))
								)
									for (; "statement" == e.context.type; ) i(e);
								else if ("{" == c) n(e, t.column(), "}");
								else if ("[" == c) n(e, t.column(), "]");
								else if ("(" == c) n(e, t.column(), ")");
								else if ("}" == c) {
									for (; "statement" == s.type; ) s = i(e);
									for ("}" == s.type && (s = i(e)); "statement" == s.type; )
										s = i(e);
								} else
									c == s.type
										? i(e)
										: b &&
										  ((("}" == s.type || "top" == s.type) && ";" != c) ||
												("statement" == s.type && "newstatement" == c)) &&
										  n(e, t.column(), "statement", t.current());
								if (
									("variable" == a &&
										("def" == e.prevToken ||
											(l.typeFirstDefinitions &&
												r(t, e, t.start) &&
												o(e.context) &&
												t.match(/^\s*\(/, !1))) &&
										(a = "def"),
									x.token)
								) {
									var u = x.token(t, e, a);
									void 0 !== u && (a = u);
								}
								return (
									"def" == a && !1 === l.styleDefs && (a = "variable"),
									(e.startOfLine = !1),
									(e.prevToken = h ? "def" : a || c),
									M(t, e),
									a
								);
							},
							indent: function (e, n) {
								if (
									(e.tokenize != N && null != e.tokenize) ||
									e.typeAtEndOfLine
								)
									return t.Pass;
								var i = e.context,
									r = n && n.charAt(0),
									o = r == i.type;
								if (
									("statement" == i.type && "}" == r && (i = i.prev),
									l.dontIndentStatements)
								)
									for (
										;
										"statement" == i.type &&
										l.dontIndentStatements.test(i.info);

									)
										i = i.prev;
								if (x.indent) {
									var s = x.indent(e, i, n, u);
									if ("number" == typeof s) return s;
								}
								var a = i.prev && "switch" == i.prev.info;
								if (l.allmanIndentation && /[{(]/.test(r)) {
									for (; "top" != i.type && "}" != i.type; ) i = i.prev;
									return i.indented;
								}
								return "statement" == i.type
									? i.indented + ("{" == r ? 0 : f)
									: !i.align || (d && ")" == i.type)
									? ")" != i.type || o
										? i.indented +
										  (o ? 0 : u) +
										  (o || !a || /^(?:case|default)\b/.test(n) ? 0 : u)
										: i.indented + f
									: i.column + (o ? 0 : 1);
							},
							electricInput: T
								? /^\s*(?:case .*?:|default:|\{\}?|\})$/
								: /^\s*[{}]$/,
							blockCommentStart: "/*",
							blockCommentEnd: "*/",
							blockCommentContinue: " * ",
							lineComment: "//",
							fold: "brace",
						};
					});
					var l =
							"auto if break case register continue return default do sizeof static else struct switch extern typedef union for goto while enum const volatile inline restrict asm fortran",
						c =
							"alignas alignof and and_eq audit axiom bitand bitor catch class compl concept constexpr const_cast decltype delete dynamic_cast explicit export final friend import module mutable namespace new noexcept not not_eq operator or or_eq override private protected public reinterpret_cast requires static_assert static_cast template this thread_local throw try typeid typename using virtual xor xor_eq",
						h =
							"bycopy byref in inout oneway out self super atomic nonatomic retain copy readwrite readonly strong weak assign typeof nullable nonnull null_resettable _cmd @interface @implementation @end @protocol @encode @property @synthesize @dynamic @class @public @package @private @protected @required @optional @try @catch @finally @import @selector @encode @defs @synchronized @autoreleasepool @compatibility_alias @available",
						u =
							"FOUNDATION_EXPORT FOUNDATION_EXTERN NS_INLINE NS_FORMAT_FUNCTION  NS_RETURNS_RETAINEDNS_ERROR_ENUM NS_RETURNS_NOT_RETAINED NS_RETURNS_INNER_POINTER NS_DESIGNATED_INITIALIZER NS_ENUM NS_OPTIONS NS_REQUIRES_NIL_TERMINATION NS_ASSUME_NONNULL_BEGIN NS_ASSUME_NONNULL_END NS_SWIFT_NAME NS_REFINED_FOR_SWIFT",
						f = s("int long char short double float unsigned signed void bool"),
						d = s("SEL instancetype id Class Protocol BOOL");
					function p(t) {
						return a(f, t) || /.+_t$/.test(t);
					}
					function g(t) {
						return p(t) || a(d, t);
					}
					var m = "case do else for if switch while struct enum union",
						v = "struct enum union";
					function _(t, e) {
						if (!e.startOfLine) return !1;
						for (var n, i = null; (n = t.peek()); ) {
							if ("\\" == n && t.match(/^.$/)) {
								i = _;
								break;
							}
							if ("/" == n && t.match(/^\/[\/\*]/, !1)) break;
							t.next();
						}
						return (e.tokenize = i), "meta";
					}
					function y(t, e) {
						return "type" == e.prevToken && "type";
					}
					function x(t) {
						return !(
							!t ||
							t.length < 2 ||
							"_" != t[0] ||
							("_" != t[1] && t[1] === t[1].toLowerCase())
						);
					}
					function k(t) {
						return t.eatWhile(/[\w\.']/), "number";
					}
					function b(t, e) {
						if ((t.backUp(1), t.match(/^(?:R|u8R|uR|UR|LR)/))) {
							var n = t.match(/^"([^\s\\()]{0,16})\(/);
							return (
								!!n &&
								((e.cpp11RawStringDelim = n[1]), (e.tokenize = w), w(t, e))
							);
						}
						return t.match(/^(?:u8|u|U|L)/)
							? !!t.match(/^["']/, !1) && "string"
							: (t.next(), !1);
					}
					function T(t) {
						var e = /(\w+)::~?(\w+)$/.exec(t);
						return e && e[1] == e[2];
					}
					function C(t, e) {
						for (var n; null != (n = t.next()); )
							if ('"' == n && !t.eat('"')) {
								e.tokenize = null;
								break;
							}
						return "string";
					}
					function w(t, e) {
						var n = e.cpp11RawStringDelim.replace(/[^\w\s]/g, "\\$&");
						return (
							t.match(new RegExp(".*?\\)" + n + '"'))
								? (e.tokenize = null)
								: t.skipToEnd(),
							"string"
						);
					}
					function E(e, n) {
						"string" == typeof e && (e = [e]);
						var i = [];
						function r(t) {
							if (t) for (var e in t) t.hasOwnProperty(e) && i.push(e);
						}
						r(n.keywords),
							r(n.types),
							r(n.builtin),
							r(n.atoms),
							i.length &&
								((n.helperType = e[0]), t.registerHelper("hintWords", e[0], i));
						for (var o = 0; o < e.length; ++o) t.defineMIME(e[o], n);
					}
					function S(t, e) {
						for (var n = !1; !t.eol(); ) {
							if (!n && t.match('"""')) {
								e.tokenize = null;
								break;
							}
							n = "\\" == t.next() && !n;
						}
						return "string";
					}
					function A(t) {
						return function (e, n) {
							for (var i; (i = e.next()); ) {
								if ("*" == i && e.eat("/")) {
									if (1 == t) {
										n.tokenize = null;
										break;
									}
									return (n.tokenize = A(t - 1)), n.tokenize(e, n);
								}
								if ("/" == i && e.eat("*"))
									return (n.tokenize = A(t + 1)), n.tokenize(e, n);
							}
							return "comment";
						};
					}
					E(["text/x-csrc", "text/x-c", "text/x-chdr"], {
						name: "clike",
						keywords: s(l),
						types: p,
						blockKeywords: s(m),
						defKeywords: s(v),
						typeFirstDefinitions: !0,
						atoms: s("NULL true false"),
						isReservedIdentifier: x,
						hooks: { "#": _, "*": y },
						modeProps: { fold: ["brace", "include"] },
					}),
						E(["text/x-c++src", "text/x-c++hdr"], {
							name: "clike",
							keywords: s(l + " " + c),
							types: p,
							blockKeywords: s(m + " class try catch"),
							defKeywords: s(v + " class namespace"),
							typeFirstDefinitions: !0,
							atoms: s("true false NULL nullptr"),
							dontIndentStatements: /^template$/,
							isIdentifierChar: /[\w\$_~\xa1-\uffff]/,
							isReservedIdentifier: x,
							hooks: {
								"#": _,
								"*": y,
								u: b,
								U: b,
								L: b,
								R: b,
								0: k,
								1: k,
								2: k,
								3: k,
								4: k,
								5: k,
								6: k,
								7: k,
								8: k,
								9: k,
								token: function (t, e, n) {
									if (
										"variable" == n &&
										"(" == t.peek() &&
										(";" == e.prevToken ||
											null == e.prevToken ||
											"}" == e.prevToken) &&
										T(t.current())
									)
										return "def";
								},
							},
							namespaceSeparator: "::",
							modeProps: { fold: ["brace", "include"] },
						}),
						E("text/x-java", {
							name: "clike",
							keywords: s(
								"abstract assert break case catch class const continue default do else enum extends final finally for goto if implements import instanceof interface native new package private protected public return static strictfp super switch synchronized this throw throws transient try volatile while @interface"
							),
							types: s(
								"var byte short int long float double boolean char void Boolean Byte Character Double Float Integer Long Number Object Short String StringBuffer StringBuilder Void"
							),
							blockKeywords: s(
								"catch class do else finally for if switch try while"
							),
							defKeywords: s("class interface enum @interface"),
							typeFirstDefinitions: !0,
							atoms: s("true false null"),
							number:
								/^(?:0x[a-f\d_]+|0b[01_]+|(?:[\d_]+\.?\d*|\.\d+)(?:e[-+]?[\d_]+)?)(u|ll?|l|f)?/i,
							hooks: {
								"@": function (t) {
									return (
										!t.match("interface", !1) && (t.eatWhile(/[\w\$_]/), "meta")
									);
								},
							},
							modeProps: { fold: ["brace", "import"] },
						}),
						E("text/x-csharp", {
							name: "clike",
							keywords: s(
								"abstract as async await base break case catch checked class const continue default delegate do else enum event explicit extern finally fixed for foreach goto if implicit in interface internal is lock namespace new operator out override params private protected public readonly ref return sealed sizeof stackalloc static struct switch this throw try typeof unchecked unsafe using virtual void volatile while add alias ascending descending dynamic from get global group into join let orderby partial remove select set value var yield"
							),
							types: s(
								"Action Boolean Byte Char DateTime DateTimeOffset Decimal Double Func Guid Int16 Int32 Int64 Object SByte Single String Task TimeSpan UInt16 UInt32 UInt64 bool byte char decimal double short int long object sbyte float string ushort uint ulong"
							),
							blockKeywords: s(
								"catch class do else finally for foreach if struct switch try while"
							),
							defKeywords: s("class interface namespace struct var"),
							typeFirstDefinitions: !0,
							atoms: s("true false null"),
							hooks: {
								"@": function (t, e) {
									return t.eat('"')
										? ((e.tokenize = C), C(t, e))
										: (t.eatWhile(/[\w\$_]/), "meta");
								},
							},
						}),
						E("text/x-scala", {
							name: "clike",
							keywords: s(
								"abstract case catch class def do else extends final finally for forSome if implicit import lazy match new null object override package private protected return sealed super this throw trait try type val var while with yield _ assert assume require print println printf readLine readBoolean readByte readShort readChar readInt readLong readFloat readDouble"
							),
							types: s(
								"AnyVal App Application Array BufferedIterator BigDecimal BigInt Char Console Either Enumeration Equiv Error Exception Fractional Function IndexedSeq Int Integral Iterable Iterator List Map Numeric Nil NotNull Option Ordered Ordering PartialFunction PartialOrdering Product Proxy Range Responder Seq Serializable Set Specializable Stream StringBuilder StringContext Symbol Throwable Traversable TraversableOnce Tuple Unit Vector Boolean Byte Character CharSequence Class ClassLoader Cloneable Comparable Compiler Double Exception Float Integer Long Math Number Object Package Pair Process Runtime Runnable SecurityManager Short StackTraceElement StrictMath String StringBuffer System Thread ThreadGroup ThreadLocal Throwable Triple Void"
							),
							multiLineStrings: !0,
							blockKeywords: s(
								"catch class enum do else finally for forSome if match switch try while"
							),
							defKeywords: s(
								"class enum def object package trait type val var"
							),
							atoms: s("true false null"),
							indentStatements: !1,
							indentSwitch: !1,
							isOperatorChar: /[+\-*&%=<>!?|\/#:@]/,
							hooks: {
								"@": function (t) {
									return t.eatWhile(/[\w\$_]/), "meta";
								},
								'"': function (t, e) {
									return (
										!!t.match('""') && ((e.tokenize = S), e.tokenize(t, e))
									);
								},
								"'": function (t) {
									return t.eatWhile(/[\w\$_\xa1-\uffff]/), "atom";
								},
								"=": function (t, n) {
									var i = n.context;
									return (
										!("}" != i.type || !i.align || !t.eat(">")) &&
										((n.context = new e(
											i.indented,
											i.column,
											i.type,
											i.info,
											null,
											i.prev
										)),
										"operator")
									);
								},
								"/": function (t, e) {
									return (
										!!t.eat("*") && ((e.tokenize = A(1)), e.tokenize(t, e))
									);
								},
							},
							modeProps: { closeBrackets: { pairs: '()[]{}""', triples: '"' } },
						}),
						E("text/x-kotlin", {
							name: "clike",
							keywords: s(
								"package as typealias class interface this super val operator var fun for is in This throw return annotation break continue object if else while do try when !in !is as? file import where by get set abstract enum open inner override private public internal protected catch finally out final vararg reified dynamic companion constructor init sealed field property receiver param sparam lateinit data inline noinline tailrec external annotation crossinline const operator infix suspend actual expect setparam value"
							),
							types: s(
								"Boolean Byte Character CharSequence Class ClassLoader Cloneable Comparable Compiler Double Exception Float Integer Long Math Number Object Package Pair Process Runtime Runnable SecurityManager Short StackTraceElement StrictMath String StringBuffer System Thread ThreadGroup ThreadLocal Throwable Triple Void Annotation Any BooleanArray ByteArray Char CharArray DeprecationLevel DoubleArray Enum FloatArray Function Int IntArray Lazy LazyThreadSafetyMode LongArray Nothing ShortArray Unit"
							),
							intendSwitch: !1,
							indentStatements: !1,
							multiLineStrings: !0,
							number:
								/^(?:0x[a-f\d_]+|0b[01_]+|(?:[\d_]+(\.\d+)?|\.\d+)(?:e[-+]?[\d_]+)?)(u|ll?|l|f)?/i,
							blockKeywords: s(
								"catch class do else finally for if where try while enum"
							),
							defKeywords: s("class val var object interface fun"),
							atoms: s("true false null this"),
							hooks: {
								"@": function (t) {
									return t.eatWhile(/[\w\$_]/), "meta";
								},
								"*": function (t, e) {
									return "." == e.prevToken ? "variable" : "operator";
								},
								'"': function (t, e) {
									var n;
									return (
										(e.tokenize =
											((n = t.match('""')),
											function (t, e) {
												for (var i, r = !1, o = !1; !t.eol(); ) {
													if (!n && !r && t.match('"')) {
														o = !0;
														break;
													}
													if (n && t.match('"""')) {
														o = !0;
														break;
													}
													(i = t.next()),
														!r && "$" == i && t.match("{") && t.skipTo("}"),
														(r = !r && "\\" == i && !n);
												}
												return (!o && n) || (e.tokenize = null), "string";
											})),
										e.tokenize(t, e)
									);
								},
								"/": function (t, e) {
									return (
										!!t.eat("*") && ((e.tokenize = A(1)), e.tokenize(t, e))
									);
								},
								indent: function (t, e, n, i) {
									var r = n && n.charAt(0);
									return ("}" != t.prevToken && ")" != t.prevToken) || "" != n
										? ("operator" == t.prevToken &&
												"}" != n &&
												"}" != t.context.type) ||
										  ("variable" == t.prevToken && "." == r) ||
										  (("}" == t.prevToken || ")" == t.prevToken) && "." == r)
											? 2 * i + e.indented
											: e.align && "}" == e.type
											? e.indented +
											  (t.context.type == (n || "").charAt(0) ? 0 : i)
											: void 0
										: t.indented;
								},
							},
							modeProps: { closeBrackets: { triples: '"' } },
						}),
						E(["x-shader/x-vertex", "x-shader/x-fragment"], {
							name: "clike",
							keywords: s(
								"sampler1D sampler2D sampler3D samplerCube sampler1DShadow sampler2DShadow const attribute uniform varying break continue discard return for while do if else struct in out inout"
							),
							types: s(
								"float int bool void vec2 vec3 vec4 ivec2 ivec3 ivec4 bvec2 bvec3 bvec4 mat2 mat3 mat4"
							),
							blockKeywords: s("for while do if else struct"),
							builtin: s(
								"radians degrees sin cos tan asin acos atan pow exp log exp2 sqrt inversesqrt abs sign floor ceil fract mod min max clamp mix step smoothstep length distance dot cross normalize ftransform faceforward reflect refract matrixCompMult lessThan lessThanEqual greaterThan greaterThanEqual equal notEqual any all not texture1D texture1DProj texture1DLod texture1DProjLod texture2D texture2DProj texture2DLod texture2DProjLod texture3D texture3DProj texture3DLod texture3DProjLod textureCube textureCubeLod shadow1D shadow2D shadow1DProj shadow2DProj shadow1DLod shadow2DLod shadow1DProjLod shadow2DProjLod dFdx dFdy fwidth noise1 noise2 noise3 noise4"
							),
							atoms: s(
								"true false gl_FragColor gl_SecondaryColor gl_Normal gl_Vertex gl_MultiTexCoord0 gl_MultiTexCoord1 gl_MultiTexCoord2 gl_MultiTexCoord3 gl_MultiTexCoord4 gl_MultiTexCoord5 gl_MultiTexCoord6 gl_MultiTexCoord7 gl_FogCoord gl_PointCoord gl_Position gl_PointSize gl_ClipVertex gl_FrontColor gl_BackColor gl_FrontSecondaryColor gl_BackSecondaryColor gl_TexCoord gl_FogFragCoord gl_FragCoord gl_FrontFacing gl_FragData gl_FragDepth gl_ModelViewMatrix gl_ProjectionMatrix gl_ModelViewProjectionMatrix gl_TextureMatrix gl_NormalMatrix gl_ModelViewMatrixInverse gl_ProjectionMatrixInverse gl_ModelViewProjectionMatrixInverse gl_TextureMatrixTranspose gl_ModelViewMatrixInverseTranspose gl_ProjectionMatrixInverseTranspose gl_ModelViewProjectionMatrixInverseTranspose gl_TextureMatrixInverseTranspose gl_NormalScale gl_DepthRange gl_ClipPlane gl_Point gl_FrontMaterial gl_BackMaterial gl_LightSource gl_LightModel gl_FrontLightModelProduct gl_BackLightModelProduct gl_TextureColor gl_EyePlaneS gl_EyePlaneT gl_EyePlaneR gl_EyePlaneQ gl_FogParameters gl_MaxLights gl_MaxClipPlanes gl_MaxTextureUnits gl_MaxTextureCoords gl_MaxVertexAttribs gl_MaxVertexUniformComponents gl_MaxVaryingFloats gl_MaxVertexTextureImageUnits gl_MaxTextureImageUnits gl_MaxFragmentUniformComponents gl_MaxCombineTextureImageUnits gl_MaxDrawBuffers"
							),
							indentSwitch: !1,
							hooks: { "#": _ },
							modeProps: { fold: ["brace", "include"] },
						}),
						E("text/x-nesc", {
							name: "clike",
							keywords: s(
								l +
									" as atomic async call command component components configuration event generic implementation includes interface module new norace nx_struct nx_union post provides signal task uses abstract extends"
							),
							types: p,
							blockKeywords: s(m),
							atoms: s("null true false"),
							hooks: { "#": _ },
							modeProps: { fold: ["brace", "include"] },
						}),
						E("text/x-objectivec", {
							name: "clike",
							keywords: s(l + " " + h),
							types: g,
							builtin: s(u),
							blockKeywords: s(
								m +
									" @synthesize @try @catch @finally @autoreleasepool @synchronized"
							),
							defKeywords: s(
								v + " @interface @implementation @protocol @class"
							),
							dontIndentStatements: /^@.*$/,
							typeFirstDefinitions: !0,
							atoms: s("YES NO NULL Nil nil true false nullptr"),
							isReservedIdentifier: x,
							hooks: { "#": _, "*": y },
							modeProps: { fold: ["brace", "include"] },
						}),
						E("text/x-objectivec++", {
							name: "clike",
							keywords: s(l + " " + h + " " + c),
							types: g,
							builtin: s(u),
							blockKeywords: s(
								m +
									" @synthesize @try @catch @finally @autoreleasepool @synchronized class try catch"
							),
							defKeywords: s(
								v +
									" @interface @implementation @protocol @class class namespace"
							),
							dontIndentStatements: /^@.*$|^template$/,
							typeFirstDefinitions: !0,
							atoms: s("YES NO NULL Nil nil true false nullptr"),
							isReservedIdentifier: x,
							hooks: {
								"#": _,
								"*": y,
								u: b,
								U: b,
								L: b,
								R: b,
								0: k,
								1: k,
								2: k,
								3: k,
								4: k,
								5: k,
								6: k,
								7: k,
								8: k,
								9: k,
								token: function (t, e, n) {
									if (
										"variable" == n &&
										"(" == t.peek() &&
										(";" == e.prevToken ||
											null == e.prevToken ||
											"}" == e.prevToken) &&
										T(t.current())
									)
										return "def";
								},
							},
							namespaceSeparator: "::",
							modeProps: { fold: ["brace", "include"] },
						}),
						E("text/x-squirrel", {
							name: "clike",
							keywords: s(
								"base break clone continue const default delete enum extends function in class foreach local resume return this throw typeof yield constructor instanceof static"
							),
							types: p,
							blockKeywords: s(
								"case catch class else for foreach if switch try while"
							),
							defKeywords: s("function local class"),
							typeFirstDefinitions: !0,
							atoms: s("true false null"),
							hooks: { "#": _ },
							modeProps: { fold: ["brace", "include"] },
						});
					var L = null;
					function O(t) {
						return function (e, n) {
							for (var i, r = !1, o = !1; !e.eol(); ) {
								if (!r && e.match('"') && ("single" == t || e.match('""'))) {
									o = !0;
									break;
								}
								if (!r && e.match("``")) {
									(L = O(t)), (o = !0);
									break;
								}
								(i = e.next()), (r = "single" == t && !r && "\\" == i);
							}
							return o && (n.tokenize = null), "string";
						};
					}
					E("text/x-ceylon", {
						name: "clike",
						keywords: s(
							"abstracts alias assembly assert assign break case catch class continue dynamic else exists extends finally for function given if import in interface is let module new nonempty object of out outer package return satisfies super switch then this throw try value void while"
						),
						types: function (t) {
							var e = t.charAt(0);
							return e === e.toUpperCase() && e !== e.toLowerCase();
						},
						blockKeywords: s(
							"case catch class dynamic else finally for function if interface module new object switch try while"
						),
						defKeywords: s(
							"class dynamic function interface module object package value"
						),
						builtin: s(
							"abstract actual aliased annotation by default deprecated doc final formal late license native optional sealed see serializable shared suppressWarnings tagged throws variable"
						),
						isPunctuationChar: /[\[\]{}\(\),;\:\.`]/,
						isOperatorChar: /[+\-*&%=<>!?|^~:\/]/,
						numberStart: /[\d#$]/,
						number:
							/^(?:#[\da-fA-F_]+|\$[01_]+|[\d_]+[kMGTPmunpf]?|[\d_]+\.[\d_]+(?:[eE][-+]?\d+|[kMGTPmunpf]|)|)/i,
						multiLineStrings: !0,
						typeFirstDefinitions: !0,
						atoms: s("true false null larger smaller equal empty finished"),
						indentSwitch: !1,
						styleDefs: !1,
						hooks: {
							"@": function (t) {
								return t.eatWhile(/[\w\$_]/), "meta";
							},
							'"': function (t, e) {
								return (
									(e.tokenize = O(t.match('""') ? "triple" : "single")),
									e.tokenize(t, e)
								);
							},
							"`": function (t, e) {
								return (
									!(!L || !t.match("`")) &&
									((e.tokenize = L), (L = null), e.tokenize(t, e))
								);
							},
							"'": function (t) {
								return t.eatWhile(/[\w\$_\xa1-\uffff]/), "atom";
							},
							token: function (t, e, n) {
								if (("variable" == n || "type" == n) && "." == e.prevToken)
									return "variable-2";
							},
						},
						modeProps: {
							fold: ["brace", "import"],
							closeBrackets: { triples: '"' },
						},
					});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		15: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					function e(t) {
						for (var e = {}, n = 0; n < t.length; ++n)
							e[t[n].toLowerCase()] = !0;
						return e;
					}
					t.defineMode("css", function (e, n) {
						var i = n.inline;
						n.propertyKeywords || (n = t.resolveMode("text/css"));
						var r,
							o,
							s = e.indentUnit,
							a = n.tokenHooks,
							l = n.documentTypes || {},
							c = n.mediaTypes || {},
							h = n.mediaFeatures || {},
							u = n.mediaValueKeywords || {},
							f = n.propertyKeywords || {},
							d = n.nonStandardPropertyKeywords || {},
							p = n.fontProperties || {},
							g = n.counterDescriptors || {},
							m = n.colorKeywords || {},
							v = n.valueKeywords || {},
							_ = n.allowNested,
							y = n.lineComment,
							x = !0 === n.supportsAtComponent,
							k = !1 !== e.highlightNonStandardPropertyKeywords;
						function b(t, e) {
							return (r = e), t;
						}
						function T(t, e) {
							var n = t.next();
							if (a[n]) {
								var i = a[n](t, e);
								if (!1 !== i) return i;
							}
							return "@" == n
								? (t.eatWhile(/[\w\\\-]/), b("def", t.current()))
								: "=" == n || (("~" == n || "|" == n) && t.eat("="))
								? b(null, "compare")
								: '"' == n || "'" == n
								? ((e.tokenize = C(n)), e.tokenize(t, e))
								: "#" == n
								? (t.eatWhile(/[\w\\\-]/), b("atom", "hash"))
								: "!" == n
								? (t.match(/^\s*\w*/), b("keyword", "important"))
								: /\d/.test(n) || ("." == n && t.eat(/\d/))
								? (t.eatWhile(/[\w.%]/), b("number", "unit"))
								: "-" !== n
								? /[,+>*\/]/.test(n)
									? b(null, "select-op")
									: "." == n && t.match(/^-?[_a-z][_a-z0-9-]*/i)
									? b("qualifier", "qualifier")
									: /[:;{}\[\]\(\)]/.test(n)
									? b(null, n)
									: t.match(/^[\w-.]+(?=\()/)
									? (/^(url(-prefix)?|domain|regexp)$/i.test(t.current()) &&
											(e.tokenize = w),
									  b("variable callee", "variable"))
									: /[\w\\\-]/.test(n)
									? (t.eatWhile(/[\w\\\-]/), b("property", "word"))
									: b(null, null)
								: /[\d.]/.test(t.peek())
								? (t.eatWhile(/[\w.%]/), b("number", "unit"))
								: t.match(/^-[\w\\\-]*/)
								? (t.eatWhile(/[\w\\\-]/),
								  t.match(/^\s*:/, !1)
										? b("variable-2", "variable-definition")
										: b("variable-2", "variable"))
								: t.match(/^\w+-/)
								? b("meta", "meta")
								: void 0;
						}
						function C(t) {
							return function (e, n) {
								for (var i, r = !1; null != (i = e.next()); ) {
									if (i == t && !r) {
										")" == t && e.backUp(1);
										break;
									}
									r = !r && "\\" == i;
								}
								return (
									(i == t || (!r && ")" != t)) && (n.tokenize = null),
									b("string", "string")
								);
							};
						}
						function w(t, e) {
							return (
								t.next(),
								t.match(/^\s*[\"\')]/, !1)
									? (e.tokenize = null)
									: (e.tokenize = C(")")),
								b(null, "(")
							);
						}
						function E(t, e, n) {
							(this.type = t), (this.indent = e), (this.prev = n);
						}
						function S(t, e, n, i) {
							return (
								(t.context = new E(
									n,
									e.indentation() + (!1 === i ? 0 : s),
									t.context
								)),
								n
							);
						}
						function A(t) {
							return (
								t.context.prev && (t.context = t.context.prev), t.context.type
							);
						}
						function L(t, e, n) {
							return I[n.context.type](t, e, n);
						}
						function O(t, e, n, i) {
							for (var r = i || 1; r > 0; r--) n.context = n.context.prev;
							return L(t, e, n);
						}
						function N(t) {
							var e = t.current().toLowerCase();
							o = v.hasOwnProperty(e)
								? "atom"
								: m.hasOwnProperty(e)
								? "keyword"
								: "variable";
						}
						var I = {
							top: function (t, e, n) {
								if ("{" == t) return S(n, e, "block");
								if ("}" == t && n.context.prev) return A(n);
								if (x && /@component/i.test(t))
									return S(n, e, "atComponentBlock");
								if (/^@(-moz-)?document$/i.test(t))
									return S(n, e, "documentTypes");
								if (/^@(media|supports|(-moz-)?document|import)$/i.test(t))
									return S(n, e, "atBlock");
								if (/^@(font-face|counter-style)/i.test(t))
									return (n.stateArg = t), "restricted_atBlock_before";
								if (/^@(-(moz|ms|o|webkit)-)?keyframes$/i.test(t))
									return "keyframes";
								if (t && "@" == t.charAt(0)) return S(n, e, "at");
								if ("hash" == t) o = "builtin";
								else if ("word" == t) o = "tag";
								else {
									if ("variable-definition" == t) return "maybeprop";
									if ("interpolation" == t) return S(n, e, "interpolation");
									if (":" == t) return "pseudo";
									if (_ && "(" == t) return S(n, e, "parens");
								}
								return n.context.type;
							},
							block: function (t, e, n) {
								if ("word" == t) {
									var i = e.current().toLowerCase();
									return f.hasOwnProperty(i)
										? ((o = "property"), "maybeprop")
										: d.hasOwnProperty(i)
										? ((o = k ? "string-2" : "property"), "maybeprop")
										: _
										? ((o = e.match(/^\s*:(?:\s|$)/, !1) ? "property" : "tag"),
										  "block")
										: ((o += " error"), "maybeprop");
								}
								return "meta" == t
									? "block"
									: _ || ("hash" != t && "qualifier" != t)
									? I.top(t, e, n)
									: ((o = "error"), "block");
							},
							maybeprop: function (t, e, n) {
								return ":" == t ? S(n, e, "prop") : L(t, e, n);
							},
							prop: function (t, e, n) {
								if (";" == t) return A(n);
								if ("{" == t && _) return S(n, e, "propBlock");
								if ("}" == t || "{" == t) return O(t, e, n);
								if ("(" == t) return S(n, e, "parens");
								if (
									"hash" != t ||
									/^#([0-9a-fA-f]{3,4}|[0-9a-fA-f]{6}|[0-9a-fA-f]{8})$/.test(
										e.current()
									)
								) {
									if ("word" == t) N(e);
									else if ("interpolation" == t)
										return S(n, e, "interpolation");
								} else o += " error";
								return "prop";
							},
							propBlock: function (t, e, n) {
								return "}" == t
									? A(n)
									: "word" == t
									? ((o = "property"), "maybeprop")
									: n.context.type;
							},
							parens: function (t, e, n) {
								return "{" == t || "}" == t
									? O(t, e, n)
									: ")" == t
									? A(n)
									: "(" == t
									? S(n, e, "parens")
									: "interpolation" == t
									? S(n, e, "interpolation")
									: ("word" == t && N(e), "parens");
							},
							pseudo: function (t, e, n) {
								return "meta" == t
									? "pseudo"
									: "word" == t
									? ((o = "variable-3"), n.context.type)
									: L(t, e, n);
							},
							documentTypes: function (t, e, n) {
								return "word" == t && l.hasOwnProperty(e.current())
									? ((o = "tag"), n.context.type)
									: I.atBlock(t, e, n);
							},
							atBlock: function (t, e, n) {
								if ("(" == t) return S(n, e, "atBlock_parens");
								if ("}" == t || ";" == t) return O(t, e, n);
								if ("{" == t) return A(n) && S(n, e, _ ? "block" : "top");
								if ("interpolation" == t) return S(n, e, "interpolation");
								if ("word" == t) {
									var i = e.current().toLowerCase();
									o =
										"only" == i || "not" == i || "and" == i || "or" == i
											? "keyword"
											: c.hasOwnProperty(i)
											? "attribute"
											: h.hasOwnProperty(i)
											? "property"
											: u.hasOwnProperty(i)
											? "keyword"
											: f.hasOwnProperty(i)
											? "property"
											: d.hasOwnProperty(i)
											? k
												? "string-2"
												: "property"
											: v.hasOwnProperty(i)
											? "atom"
											: m.hasOwnProperty(i)
											? "keyword"
											: "error";
								}
								return n.context.type;
							},
							atComponentBlock: function (t, e, n) {
								return "}" == t
									? O(t, e, n)
									: "{" == t
									? A(n) && S(n, e, _ ? "block" : "top", !1)
									: ("word" == t && (o = "error"), n.context.type);
							},
							atBlock_parens: function (t, e, n) {
								return ")" == t
									? A(n)
									: "{" == t || "}" == t
									? O(t, e, n, 2)
									: I.atBlock(t, e, n);
							},
							restricted_atBlock_before: function (t, e, n) {
								return "{" == t
									? S(n, e, "restricted_atBlock")
									: "word" == t && "@counter-style" == n.stateArg
									? ((o = "variable"), "restricted_atBlock_before")
									: L(t, e, n);
							},
							restricted_atBlock: function (t, e, n) {
								return "}" == t
									? ((n.stateArg = null), A(n))
									: "word" == t
									? ((o =
											("@font-face" == n.stateArg &&
												!p.hasOwnProperty(e.current().toLowerCase())) ||
											("@counter-style" == n.stateArg &&
												!g.hasOwnProperty(e.current().toLowerCase()))
												? "error"
												: "property"),
									  "maybeprop")
									: "restricted_atBlock";
							},
							keyframes: function (t, e, n) {
								return "word" == t
									? ((o = "variable"), "keyframes")
									: "{" == t
									? S(n, e, "top")
									: L(t, e, n);
							},
							at: function (t, e, n) {
								return ";" == t
									? A(n)
									: "{" == t || "}" == t
									? O(t, e, n)
									: ("word" == t ? (o = "tag") : "hash" == t && (o = "builtin"),
									  "at");
							},
							interpolation: function (t, e, n) {
								return "}" == t
									? A(n)
									: "{" == t || ";" == t
									? O(t, e, n)
									: ("word" == t
											? (o = "variable")
											: "variable" != t &&
											  "(" != t &&
											  ")" != t &&
											  (o = "error"),
									  "interpolation");
							},
						};
						return {
							startState: function (t) {
								return {
									tokenize: null,
									state: i ? "block" : "top",
									stateArg: null,
									context: new E(i ? "block" : "top", t || 0, null),
								};
							},
							token: function (t, e) {
								if (!e.tokenize && t.eatSpace()) return null;
								var n = (e.tokenize || T)(t, e);
								return (
									n && "object" == typeof n && ((r = n[1]), (n = n[0])),
									(o = n),
									"comment" != r && (e.state = I[e.state](r, t, e)),
									o
								);
							},
							indent: function (t, e) {
								var n = t.context,
									i = e && e.charAt(0),
									r = n.indent;
								return (
									"prop" != n.type || ("}" != i && ")" != i) || (n = n.prev),
									n.prev &&
										("}" != i ||
										("block" != n.type &&
											"top" != n.type &&
											"interpolation" != n.type &&
											"restricted_atBlock" != n.type)
											? ((")" != i ||
													("parens" != n.type && "atBlock_parens" != n.type)) &&
													("{" != i ||
														("at" != n.type && "atBlock" != n.type))) ||
											  (r = Math.max(0, n.indent - s))
											: (r = (n = n.prev).indent)),
									r
								);
							},
							electricChars: "}",
							blockCommentStart: "/*",
							blockCommentEnd: "*/",
							blockCommentContinue: " * ",
							lineComment: y,
							fold: "brace",
						};
					});
					var n = ["domain", "regexp", "url", "url-prefix"],
						i = e(n),
						r = [
							"all",
							"aural",
							"braille",
							"handheld",
							"print",
							"projection",
							"screen",
							"tty",
							"tv",
							"embossed",
						],
						o = e(r),
						s = [
							"width",
							"min-width",
							"max-width",
							"height",
							"min-height",
							"max-height",
							"device-width",
							"min-device-width",
							"max-device-width",
							"device-height",
							"min-device-height",
							"max-device-height",
							"aspect-ratio",
							"min-aspect-ratio",
							"max-aspect-ratio",
							"device-aspect-ratio",
							"min-device-aspect-ratio",
							"max-device-aspect-ratio",
							"color",
							"min-color",
							"max-color",
							"color-index",
							"min-color-index",
							"max-color-index",
							"monochrome",
							"min-monochrome",
							"max-monochrome",
							"resolution",
							"min-resolution",
							"max-resolution",
							"scan",
							"grid",
							"orientation",
							"device-pixel-ratio",
							"min-device-pixel-ratio",
							"max-device-pixel-ratio",
							"pointer",
							"any-pointer",
							"hover",
							"any-hover",
							"prefers-color-scheme",
						],
						a = e(s),
						l = [
							"landscape",
							"portrait",
							"none",
							"coarse",
							"fine",
							"on-demand",
							"hover",
							"interlace",
							"progressive",
							"dark",
							"light",
						],
						c = e(l),
						h = [
							"align-content",
							"align-items",
							"align-self",
							"alignment-adjust",
							"alignment-baseline",
							"all",
							"anchor-point",
							"animation",
							"animation-delay",
							"animation-direction",
							"animation-duration",
							"animation-fill-mode",
							"animation-iteration-count",
							"animation-name",
							"animation-play-state",
							"animation-timing-function",
							"appearance",
							"azimuth",
							"backdrop-filter",
							"backface-visibility",
							"background",
							"background-attachment",
							"background-blend-mode",
							"background-clip",
							"background-color",
							"background-image",
							"background-origin",
							"background-position",
							"background-position-x",
							"background-position-y",
							"background-repeat",
							"background-size",
							"baseline-shift",
							"binding",
							"bleed",
							"block-size",
							"bookmark-label",
							"bookmark-level",
							"bookmark-state",
							"bookmark-target",
							"border",
							"border-bottom",
							"border-bottom-color",
							"border-bottom-left-radius",
							"border-bottom-right-radius",
							"border-bottom-style",
							"border-bottom-width",
							"border-collapse",
							"border-color",
							"border-image",
							"border-image-outset",
							"border-image-repeat",
							"border-image-slice",
							"border-image-source",
							"border-image-width",
							"border-left",
							"border-left-color",
							"border-left-style",
							"border-left-width",
							"border-radius",
							"border-right",
							"border-right-color",
							"border-right-style",
							"border-right-width",
							"border-spacing",
							"border-style",
							"border-top",
							"border-top-color",
							"border-top-left-radius",
							"border-top-right-radius",
							"border-top-style",
							"border-top-width",
							"border-width",
							"bottom",
							"box-decoration-break",
							"box-shadow",
							"box-sizing",
							"break-after",
							"break-before",
							"break-inside",
							"caption-side",
							"caret-color",
							"clear",
							"clip",
							"color",
							"color-profile",
							"column-count",
							"column-fill",
							"column-gap",
							"column-rule",
							"column-rule-color",
							"column-rule-style",
							"column-rule-width",
							"column-span",
							"column-width",
							"columns",
							"contain",
							"content",
							"counter-increment",
							"counter-reset",
							"crop",
							"cue",
							"cue-after",
							"cue-before",
							"cursor",
							"direction",
							"display",
							"dominant-baseline",
							"drop-initial-after-adjust",
							"drop-initial-after-align",
							"drop-initial-before-adjust",
							"drop-initial-before-align",
							"drop-initial-size",
							"drop-initial-value",
							"elevation",
							"empty-cells",
							"fit",
							"fit-content",
							"fit-position",
							"flex",
							"flex-basis",
							"flex-direction",
							"flex-flow",
							"flex-grow",
							"flex-shrink",
							"flex-wrap",
							"float",
							"float-offset",
							"flow-from",
							"flow-into",
							"font",
							"font-family",
							"font-feature-settings",
							"font-kerning",
							"font-language-override",
							"font-optical-sizing",
							"font-size",
							"font-size-adjust",
							"font-stretch",
							"font-style",
							"font-synthesis",
							"font-variant",
							"font-variant-alternates",
							"font-variant-caps",
							"font-variant-east-asian",
							"font-variant-ligatures",
							"font-variant-numeric",
							"font-variant-position",
							"font-variation-settings",
							"font-weight",
							"gap",
							"grid",
							"grid-area",
							"grid-auto-columns",
							"grid-auto-flow",
							"grid-auto-rows",
							"grid-column",
							"grid-column-end",
							"grid-column-gap",
							"grid-column-start",
							"grid-gap",
							"grid-row",
							"grid-row-end",
							"grid-row-gap",
							"grid-row-start",
							"grid-template",
							"grid-template-areas",
							"grid-template-columns",
							"grid-template-rows",
							"hanging-punctuation",
							"height",
							"hyphens",
							"icon",
							"image-orientation",
							"image-rendering",
							"image-resolution",
							"inline-box-align",
							"inset",
							"inset-block",
							"inset-block-end",
							"inset-block-start",
							"inset-inline",
							"inset-inline-end",
							"inset-inline-start",
							"isolation",
							"justify-content",
							"justify-items",
							"justify-self",
							"left",
							"letter-spacing",
							"line-break",
							"line-height",
							"line-height-step",
							"line-stacking",
							"line-stacking-ruby",
							"line-stacking-shift",
							"line-stacking-strategy",
							"list-style",
							"list-style-image",
							"list-style-position",
							"list-style-type",
							"margin",
							"margin-bottom",
							"margin-left",
							"margin-right",
							"margin-top",
							"marks",
							"marquee-direction",
							"marquee-loop",
							"marquee-play-count",
							"marquee-speed",
							"marquee-style",
							"mask-clip",
							"mask-composite",
							"mask-image",
							"mask-mode",
							"mask-origin",
							"mask-position",
							"mask-repeat",
							"mask-size",
							"mask-type",
							"max-block-size",
							"max-height",
							"max-inline-size",
							"max-width",
							"min-block-size",
							"min-height",
							"min-inline-size",
							"min-width",
							"mix-blend-mode",
							"move-to",
							"nav-down",
							"nav-index",
							"nav-left",
							"nav-right",
							"nav-up",
							"object-fit",
							"object-position",
							"offset",
							"offset-anchor",
							"offset-distance",
							"offset-path",
							"offset-position",
							"offset-rotate",
							"opacity",
							"order",
							"orphans",
							"outline",
							"outline-color",
							"outline-offset",
							"outline-style",
							"outline-width",
							"overflow",
							"overflow-style",
							"overflow-wrap",
							"overflow-x",
							"overflow-y",
							"padding",
							"padding-bottom",
							"padding-left",
							"padding-right",
							"padding-top",
							"page",
							"page-break-after",
							"page-break-before",
							"page-break-inside",
							"page-policy",
							"pause",
							"pause-after",
							"pause-before",
							"perspective",
							"perspective-origin",
							"pitch",
							"pitch-range",
							"place-content",
							"place-items",
							"place-self",
							"play-during",
							"position",
							"presentation-level",
							"punctuation-trim",
							"quotes",
							"region-break-after",
							"region-break-before",
							"region-break-inside",
							"region-fragment",
							"rendering-intent",
							"resize",
							"rest",
							"rest-after",
							"rest-before",
							"richness",
							"right",
							"rotate",
							"rotation",
							"rotation-point",
							"row-gap",
							"ruby-align",
							"ruby-overhang",
							"ruby-position",
							"ruby-span",
							"scale",
							"scroll-behavior",
							"scroll-margin",
							"scroll-margin-block",
							"scroll-margin-block-end",
							"scroll-margin-block-start",
							"scroll-margin-bottom",
							"scroll-margin-inline",
							"scroll-margin-inline-end",
							"scroll-margin-inline-start",
							"scroll-margin-left",
							"scroll-margin-right",
							"scroll-margin-top",
							"scroll-padding",
							"scroll-padding-block",
							"scroll-padding-block-end",
							"scroll-padding-block-start",
							"scroll-padding-bottom",
							"scroll-padding-inline",
							"scroll-padding-inline-end",
							"scroll-padding-inline-start",
							"scroll-padding-left",
							"scroll-padding-right",
							"scroll-padding-top",
							"scroll-snap-align",
							"scroll-snap-type",
							"shape-image-threshold",
							"shape-inside",
							"shape-margin",
							"shape-outside",
							"size",
							"speak",
							"speak-as",
							"speak-header",
							"speak-numeral",
							"speak-punctuation",
							"speech-rate",
							"stress",
							"string-set",
							"tab-size",
							"table-layout",
							"target",
							"target-name",
							"target-new",
							"target-position",
							"text-align",
							"text-align-last",
							"text-combine-upright",
							"text-decoration",
							"text-decoration-color",
							"text-decoration-line",
							"text-decoration-skip",
							"text-decoration-skip-ink",
							"text-decoration-style",
							"text-emphasis",
							"text-emphasis-color",
							"text-emphasis-position",
							"text-emphasis-style",
							"text-height",
							"text-indent",
							"text-justify",
							"text-orientation",
							"text-outline",
							"text-overflow",
							"text-rendering",
							"text-shadow",
							"text-size-adjust",
							"text-space-collapse",
							"text-transform",
							"text-underline-position",
							"text-wrap",
							"top",
							"touch-action",
							"transform",
							"transform-origin",
							"transform-style",
							"transition",
							"transition-delay",
							"transition-duration",
							"transition-property",
							"transition-timing-function",
							"translate",
							"unicode-bidi",
							"user-select",
							"vertical-align",
							"visibility",
							"voice-balance",
							"voice-duration",
							"voice-family",
							"voice-pitch",
							"voice-range",
							"voice-rate",
							"voice-stress",
							"voice-volume",
							"volume",
							"white-space",
							"widows",
							"width",
							"will-change",
							"word-break",
							"word-spacing",
							"word-wrap",
							"writing-mode",
							"z-index",
							"clip-path",
							"clip-rule",
							"mask",
							"enable-background",
							"filter",
							"flood-color",
							"flood-opacity",
							"lighting-color",
							"stop-color",
							"stop-opacity",
							"pointer-events",
							"color-interpolation",
							"color-interpolation-filters",
							"color-rendering",
							"fill",
							"fill-opacity",
							"fill-rule",
							"image-rendering",
							"marker",
							"marker-end",
							"marker-mid",
							"marker-start",
							"paint-order",
							"shape-rendering",
							"stroke",
							"stroke-dasharray",
							"stroke-dashoffset",
							"stroke-linecap",
							"stroke-linejoin",
							"stroke-miterlimit",
							"stroke-opacity",
							"stroke-width",
							"text-rendering",
							"baseline-shift",
							"dominant-baseline",
							"glyph-orientation-horizontal",
							"glyph-orientation-vertical",
							"text-anchor",
							"writing-mode",
						],
						u = e(h),
						f = [
							"accent-color",
							"aspect-ratio",
							"border-block",
							"border-block-color",
							"border-block-end",
							"border-block-end-color",
							"border-block-end-style",
							"border-block-end-width",
							"border-block-start",
							"border-block-start-color",
							"border-block-start-style",
							"border-block-start-width",
							"border-block-style",
							"border-block-width",
							"border-inline",
							"border-inline-color",
							"border-inline-end",
							"border-inline-end-color",
							"border-inline-end-style",
							"border-inline-end-width",
							"border-inline-start",
							"border-inline-start-color",
							"border-inline-start-style",
							"border-inline-start-width",
							"border-inline-style",
							"border-inline-width",
							"content-visibility",
							"margin-block",
							"margin-block-end",
							"margin-block-start",
							"margin-inline",
							"margin-inline-end",
							"margin-inline-start",
							"overflow-anchor",
							"overscroll-behavior",
							"padding-block",
							"padding-block-end",
							"padding-block-start",
							"padding-inline",
							"padding-inline-end",
							"padding-inline-start",
							"scroll-snap-stop",
							"scrollbar-3d-light-color",
							"scrollbar-arrow-color",
							"scrollbar-base-color",
							"scrollbar-dark-shadow-color",
							"scrollbar-face-color",
							"scrollbar-highlight-color",
							"scrollbar-shadow-color",
							"scrollbar-track-color",
							"searchfield-cancel-button",
							"searchfield-decoration",
							"searchfield-results-button",
							"searchfield-results-decoration",
							"shape-inside",
							"zoom",
						],
						d = e(f),
						p = e([
							"font-display",
							"font-family",
							"src",
							"unicode-range",
							"font-variant",
							"font-feature-settings",
							"font-stretch",
							"font-weight",
							"font-style",
						]),
						g = e([
							"additive-symbols",
							"fallback",
							"negative",
							"pad",
							"prefix",
							"range",
							"speak-as",
							"suffix",
							"symbols",
							"system",
						]),
						m = [
							"aliceblue",
							"antiquewhite",
							"aqua",
							"aquamarine",
							"azure",
							"beige",
							"bisque",
							"black",
							"blanchedalmond",
							"blue",
							"blueviolet",
							"brown",
							"burlywood",
							"cadetblue",
							"chartreuse",
							"chocolate",
							"coral",
							"cornflowerblue",
							"cornsilk",
							"crimson",
							"cyan",
							"darkblue",
							"darkcyan",
							"darkgoldenrod",
							"darkgray",
							"darkgreen",
							"darkgrey",
							"darkkhaki",
							"darkmagenta",
							"darkolivegreen",
							"darkorange",
							"darkorchid",
							"darkred",
							"darksalmon",
							"darkseagreen",
							"darkslateblue",
							"darkslategray",
							"darkslategrey",
							"darkturquoise",
							"darkviolet",
							"deeppink",
							"deepskyblue",
							"dimgray",
							"dimgrey",
							"dodgerblue",
							"firebrick",
							"floralwhite",
							"forestgreen",
							"fuchsia",
							"gainsboro",
							"ghostwhite",
							"gold",
							"goldenrod",
							"gray",
							"grey",
							"green",
							"greenyellow",
							"honeydew",
							"hotpink",
							"indianred",
							"indigo",
							"ivory",
							"khaki",
							"lavender",
							"lavenderblush",
							"lawngreen",
							"lemonchiffon",
							"lightblue",
							"lightcoral",
							"lightcyan",
							"lightgoldenrodyellow",
							"lightgray",
							"lightgreen",
							"lightgrey",
							"lightpink",
							"lightsalmon",
							"lightseagreen",
							"lightskyblue",
							"lightslategray",
							"lightslategrey",
							"lightsteelblue",
							"lightyellow",
							"lime",
							"limegreen",
							"linen",
							"magenta",
							"maroon",
							"mediumaquamarine",
							"mediumblue",
							"mediumorchid",
							"mediumpurple",
							"mediumseagreen",
							"mediumslateblue",
							"mediumspringgreen",
							"mediumturquoise",
							"mediumvioletred",
							"midnightblue",
							"mintcream",
							"mistyrose",
							"moccasin",
							"navajowhite",
							"navy",
							"oldlace",
							"olive",
							"olivedrab",
							"orange",
							"orangered",
							"orchid",
							"palegoldenrod",
							"palegreen",
							"paleturquoise",
							"palevioletred",
							"papayawhip",
							"peachpuff",
							"peru",
							"pink",
							"plum",
							"powderblue",
							"purple",
							"rebeccapurple",
							"red",
							"rosybrown",
							"royalblue",
							"saddlebrown",
							"salmon",
							"sandybrown",
							"seagreen",
							"seashell",
							"sienna",
							"silver",
							"skyblue",
							"slateblue",
							"slategray",
							"slategrey",
							"snow",
							"springgreen",
							"steelblue",
							"tan",
							"teal",
							"thistle",
							"tomato",
							"turquoise",
							"violet",
							"wheat",
							"white",
							"whitesmoke",
							"yellow",
							"yellowgreen",
						],
						v = e(m),
						_ = [
							"above",
							"absolute",
							"activeborder",
							"additive",
							"activecaption",
							"afar",
							"after-white-space",
							"ahead",
							"alias",
							"all",
							"all-scroll",
							"alphabetic",
							"alternate",
							"always",
							"amharic",
							"amharic-abegede",
							"antialiased",
							"appworkspace",
							"arabic-indic",
							"armenian",
							"asterisks",
							"attr",
							"auto",
							"auto-flow",
							"avoid",
							"avoid-column",
							"avoid-page",
							"avoid-region",
							"axis-pan",
							"background",
							"backwards",
							"baseline",
							"below",
							"bidi-override",
							"binary",
							"bengali",
							"blink",
							"block",
							"block-axis",
							"blur",
							"bold",
							"bolder",
							"border",
							"border-box",
							"both",
							"bottom",
							"break",
							"break-all",
							"break-word",
							"brightness",
							"bullets",
							"button",
							"button-bevel",
							"buttonface",
							"buttonhighlight",
							"buttonshadow",
							"buttontext",
							"calc",
							"cambodian",
							"capitalize",
							"caps-lock-indicator",
							"caption",
							"captiontext",
							"caret",
							"cell",
							"center",
							"checkbox",
							"circle",
							"cjk-decimal",
							"cjk-earthly-branch",
							"cjk-heavenly-stem",
							"cjk-ideographic",
							"clear",
							"clip",
							"close-quote",
							"col-resize",
							"collapse",
							"color",
							"color-burn",
							"color-dodge",
							"column",
							"column-reverse",
							"compact",
							"condensed",
							"contain",
							"content",
							"contents",
							"content-box",
							"context-menu",
							"continuous",
							"contrast",
							"copy",
							"counter",
							"counters",
							"cover",
							"crop",
							"cross",
							"crosshair",
							"cubic-bezier",
							"currentcolor",
							"cursive",
							"cyclic",
							"darken",
							"dashed",
							"decimal",
							"decimal-leading-zero",
							"default",
							"default-button",
							"dense",
							"destination-atop",
							"destination-in",
							"destination-out",
							"destination-over",
							"devanagari",
							"difference",
							"disc",
							"discard",
							"disclosure-closed",
							"disclosure-open",
							"document",
							"dot-dash",
							"dot-dot-dash",
							"dotted",
							"double",
							"down",
							"drop-shadow",
							"e-resize",
							"ease",
							"ease-in",
							"ease-in-out",
							"ease-out",
							"element",
							"ellipse",
							"ellipsis",
							"embed",
							"end",
							"ethiopic",
							"ethiopic-abegede",
							"ethiopic-abegede-am-et",
							"ethiopic-abegede-gez",
							"ethiopic-abegede-ti-er",
							"ethiopic-abegede-ti-et",
							"ethiopic-halehame-aa-er",
							"ethiopic-halehame-aa-et",
							"ethiopic-halehame-am-et",
							"ethiopic-halehame-gez",
							"ethiopic-halehame-om-et",
							"ethiopic-halehame-sid-et",
							"ethiopic-halehame-so-et",
							"ethiopic-halehame-ti-er",
							"ethiopic-halehame-ti-et",
							"ethiopic-halehame-tig",
							"ethiopic-numeric",
							"ew-resize",
							"exclusion",
							"expanded",
							"extends",
							"extra-condensed",
							"extra-expanded",
							"fantasy",
							"fast",
							"fill",
							"fill-box",
							"fixed",
							"flat",
							"flex",
							"flex-end",
							"flex-start",
							"footnotes",
							"forwards",
							"from",
							"geometricPrecision",
							"georgian",
							"grayscale",
							"graytext",
							"grid",
							"groove",
							"gujarati",
							"gurmukhi",
							"hand",
							"hangul",
							"hangul-consonant",
							"hard-light",
							"hebrew",
							"help",
							"hidden",
							"hide",
							"higher",
							"highlight",
							"highlighttext",
							"hiragana",
							"hiragana-iroha",
							"horizontal",
							"hsl",
							"hsla",
							"hue",
							"hue-rotate",
							"icon",
							"ignore",
							"inactiveborder",
							"inactivecaption",
							"inactivecaptiontext",
							"infinite",
							"infobackground",
							"infotext",
							"inherit",
							"initial",
							"inline",
							"inline-axis",
							"inline-block",
							"inline-flex",
							"inline-grid",
							"inline-table",
							"inset",
							"inside",
							"intrinsic",
							"invert",
							"italic",
							"japanese-formal",
							"japanese-informal",
							"justify",
							"kannada",
							"katakana",
							"katakana-iroha",
							"keep-all",
							"khmer",
							"korean-hangul-formal",
							"korean-hanja-formal",
							"korean-hanja-informal",
							"landscape",
							"lao",
							"large",
							"larger",
							"left",
							"level",
							"lighter",
							"lighten",
							"line-through",
							"linear",
							"linear-gradient",
							"lines",
							"list-item",
							"listbox",
							"listitem",
							"local",
							"logical",
							"loud",
							"lower",
							"lower-alpha",
							"lower-armenian",
							"lower-greek",
							"lower-hexadecimal",
							"lower-latin",
							"lower-norwegian",
							"lower-roman",
							"lowercase",
							"ltr",
							"luminosity",
							"malayalam",
							"manipulation",
							"match",
							"matrix",
							"matrix3d",
							"media-controls-background",
							"media-current-time-display",
							"media-fullscreen-button",
							"media-mute-button",
							"media-play-button",
							"media-return-to-realtime-button",
							"media-rewind-button",
							"media-seek-back-button",
							"media-seek-forward-button",
							"media-slider",
							"media-sliderthumb",
							"media-time-remaining-display",
							"media-volume-slider",
							"media-volume-slider-container",
							"media-volume-sliderthumb",
							"medium",
							"menu",
							"menulist",
							"menulist-button",
							"menulist-text",
							"menulist-textfield",
							"menutext",
							"message-box",
							"middle",
							"min-intrinsic",
							"mix",
							"mongolian",
							"monospace",
							"move",
							"multiple",
							"multiple_mask_images",
							"multiply",
							"myanmar",
							"n-resize",
							"narrower",
							"ne-resize",
							"nesw-resize",
							"no-close-quote",
							"no-drop",
							"no-open-quote",
							"no-repeat",
							"none",
							"normal",
							"not-allowed",
							"nowrap",
							"ns-resize",
							"numbers",
							"numeric",
							"nw-resize",
							"nwse-resize",
							"oblique",
							"octal",
							"opacity",
							"open-quote",
							"optimizeLegibility",
							"optimizeSpeed",
							"oriya",
							"oromo",
							"outset",
							"outside",
							"outside-shape",
							"overlay",
							"overline",
							"padding",
							"padding-box",
							"painted",
							"page",
							"paused",
							"persian",
							"perspective",
							"pinch-zoom",
							"plus-darker",
							"plus-lighter",
							"pointer",
							"polygon",
							"portrait",
							"pre",
							"pre-line",
							"pre-wrap",
							"preserve-3d",
							"progress",
							"push-button",
							"radial-gradient",
							"radio",
							"read-only",
							"read-write",
							"read-write-plaintext-only",
							"rectangle",
							"region",
							"relative",
							"repeat",
							"repeating-linear-gradient",
							"repeating-radial-gradient",
							"repeat-x",
							"repeat-y",
							"reset",
							"reverse",
							"rgb",
							"rgba",
							"ridge",
							"right",
							"rotate",
							"rotate3d",
							"rotateX",
							"rotateY",
							"rotateZ",
							"round",
							"row",
							"row-resize",
							"row-reverse",
							"rtl",
							"run-in",
							"running",
							"s-resize",
							"sans-serif",
							"saturate",
							"saturation",
							"scale",
							"scale3d",
							"scaleX",
							"scaleY",
							"scaleZ",
							"screen",
							"scroll",
							"scrollbar",
							"scroll-position",
							"se-resize",
							"searchfield",
							"searchfield-cancel-button",
							"searchfield-decoration",
							"searchfield-results-button",
							"searchfield-results-decoration",
							"self-start",
							"self-end",
							"semi-condensed",
							"semi-expanded",
							"separate",
							"sepia",
							"serif",
							"show",
							"sidama",
							"simp-chinese-formal",
							"simp-chinese-informal",
							"single",
							"skew",
							"skewX",
							"skewY",
							"skip-white-space",
							"slide",
							"slider-horizontal",
							"slider-vertical",
							"sliderthumb-horizontal",
							"sliderthumb-vertical",
							"slow",
							"small",
							"small-caps",
							"small-caption",
							"smaller",
							"soft-light",
							"solid",
							"somali",
							"source-atop",
							"source-in",
							"source-out",
							"source-over",
							"space",
							"space-around",
							"space-between",
							"space-evenly",
							"spell-out",
							"square",
							"square-button",
							"start",
							"static",
							"status-bar",
							"stretch",
							"stroke",
							"stroke-box",
							"sub",
							"subpixel-antialiased",
							"svg_masks",
							"super",
							"sw-resize",
							"symbolic",
							"symbols",
							"system-ui",
							"table",
							"table-caption",
							"table-cell",
							"table-column",
							"table-column-group",
							"table-footer-group",
							"table-header-group",
							"table-row",
							"table-row-group",
							"tamil",
							"telugu",
							"text",
							"text-bottom",
							"text-top",
							"textarea",
							"textfield",
							"thai",
							"thick",
							"thin",
							"threeddarkshadow",
							"threedface",
							"threedhighlight",
							"threedlightshadow",
							"threedshadow",
							"tibetan",
							"tigre",
							"tigrinya-er",
							"tigrinya-er-abegede",
							"tigrinya-et",
							"tigrinya-et-abegede",
							"to",
							"top",
							"trad-chinese-formal",
							"trad-chinese-informal",
							"transform",
							"translate",
							"translate3d",
							"translateX",
							"translateY",
							"translateZ",
							"transparent",
							"ultra-condensed",
							"ultra-expanded",
							"underline",
							"unidirectional-pan",
							"unset",
							"up",
							"upper-alpha",
							"upper-armenian",
							"upper-greek",
							"upper-hexadecimal",
							"upper-latin",
							"upper-norwegian",
							"upper-roman",
							"uppercase",
							"urdu",
							"url",
							"var",
							"vertical",
							"vertical-text",
							"view-box",
							"visible",
							"visibleFill",
							"visiblePainted",
							"visibleStroke",
							"visual",
							"w-resize",
							"wait",
							"wave",
							"wider",
							"window",
							"windowframe",
							"windowtext",
							"words",
							"wrap",
							"wrap-reverse",
							"x-large",
							"x-small",
							"xor",
							"xx-large",
							"xx-small",
						],
						y = e(_),
						x = n
							.concat(r)
							.concat(s)
							.concat(l)
							.concat(h)
							.concat(f)
							.concat(m)
							.concat(_);
					function k(t, e) {
						for (var n, i = !1; null != (n = t.next()); ) {
							if (i && "/" == n) {
								e.tokenize = null;
								break;
							}
							i = "*" == n;
						}
						return ["comment", "comment"];
					}
					t.registerHelper("hintWords", "css", x),
						t.defineMIME("text/css", {
							documentTypes: i,
							mediaTypes: o,
							mediaFeatures: a,
							mediaValueKeywords: c,
							propertyKeywords: u,
							nonStandardPropertyKeywords: d,
							fontProperties: p,
							counterDescriptors: g,
							colorKeywords: v,
							valueKeywords: y,
							tokenHooks: {
								"/": function (t, e) {
									return !!t.eat("*") && ((e.tokenize = k), k(t, e));
								},
							},
							name: "css",
						}),
						t.defineMIME("text/x-scss", {
							mediaTypes: o,
							mediaFeatures: a,
							mediaValueKeywords: c,
							propertyKeywords: u,
							nonStandardPropertyKeywords: d,
							colorKeywords: v,
							valueKeywords: y,
							fontProperties: p,
							allowNested: !0,
							lineComment: "//",
							tokenHooks: {
								"/": function (t, e) {
									return t.eat("/")
										? (t.skipToEnd(), ["comment", "comment"])
										: t.eat("*")
										? ((e.tokenize = k), k(t, e))
										: ["operator", "operator"];
								},
								":": function (t) {
									return !!t.match(/^\s*\{/, !1) && [null, null];
								},
								$: function (t) {
									return (
										t.match(/^[\w-]+/),
										t.match(/^\s*:/, !1)
											? ["variable-2", "variable-definition"]
											: ["variable-2", "variable"]
									);
								},
								"#": function (t) {
									return !!t.eat("{") && [null, "interpolation"];
								},
							},
							name: "css",
							helperType: "scss",
						}),
						t.defineMIME("text/x-less", {
							mediaTypes: o,
							mediaFeatures: a,
							mediaValueKeywords: c,
							propertyKeywords: u,
							nonStandardPropertyKeywords: d,
							colorKeywords: v,
							valueKeywords: y,
							fontProperties: p,
							allowNested: !0,
							lineComment: "//",
							tokenHooks: {
								"/": function (t, e) {
									return t.eat("/")
										? (t.skipToEnd(), ["comment", "comment"])
										: t.eat("*")
										? ((e.tokenize = k), k(t, e))
										: ["operator", "operator"];
								},
								"@": function (t) {
									return t.eat("{")
										? [null, "interpolation"]
										: !t.match(
												/^(charset|document|font-face|import|(-(moz|ms|o|webkit)-)?keyframes|media|namespace|page|supports)\b/i,
												!1
										  ) &&
												(t.eatWhile(/[\w\\\-]/),
												t.match(/^\s*:/, !1)
													? ["variable-2", "variable-definition"]
													: ["variable-2", "variable"]);
								},
								"&": function () {
									return ["atom", "atom"];
								},
							},
							name: "css",
							helperType: "less",
						}),
						t.defineMIME("text/x-gss", {
							documentTypes: i,
							mediaTypes: o,
							mediaFeatures: a,
							propertyKeywords: u,
							nonStandardPropertyKeywords: d,
							fontProperties: p,
							counterDescriptors: g,
							colorKeywords: v,
							valueKeywords: y,
							supportsAtComponent: !0,
							tokenHooks: {
								"/": function (t, e) {
									return !!t.eat("*") && ((e.tokenize = k), k(t, e));
								},
							},
							name: "css",
							helperType: "gss",
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		16: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					var e = {
							script: [
								["lang", /(javascript|babel)/i, "javascript"],
								[
									"type",
									/^(?:text|application)\/(?:x-)?(?:java|ecma)script$|^module$|^$/i,
									"javascript",
								],
								["type", /./, "text/plain"],
								[null, null, "javascript"],
							],
							style: [
								["lang", /^css$/i, "css"],
								["type", /^(text\/)?(x-)?(stylesheet|css)$/i, "css"],
								["type", /./, "text/plain"],
								[null, null, "css"],
							],
						},
						n = {};
					function i(t, e) {
						var i = t.match(
							(function (t) {
								return (
									n[t] ||
									(n[t] = new RegExp(
										"\\s+" + t + "\\s*=\\s*('|\")?([^'\"]+)('|\")?\\s*"
									))
								);
							})(e)
						);
						return i ? /^\s*(.*?)\s*$/.exec(i[2])[1] : "";
					}
					function r(t, e) {
						return new RegExp((e ? "^" : "") + "</s*" + t + "s*>", "i");
					}
					function o(t, e) {
						for (var n in t)
							for (
								var i = e[n] || (e[n] = []), r = t[n], o = r.length - 1;
								o >= 0;
								o--
							)
								i.unshift(r[o]);
					}
					t.defineMode(
						"htmlmixed",
						function (n, s) {
							var a = t.getMode(n, {
									name: "xml",
									htmlMode: !0,
									multilineTagIndentFactor: s.multilineTagIndentFactor,
									multilineTagIndentPastTag: s.multilineTagIndentPastTag,
									allowMissingTagName: s.allowMissingTagName,
								}),
								l = {},
								c = s && s.tags,
								h = s && s.scriptTypes;
							if ((o(e, l), c && o(c, l), h))
								for (var u = h.length - 1; u >= 0; u--)
									l.script.unshift(["type", h[u].matches, h[u].mode]);
							function f(e, o) {
								var s,
									c = a.token(e, o.htmlState),
									h = /\btag\b/.test(c);
								if (
									h &&
									!/[<>\s\/]/.test(e.current()) &&
									(s =
										o.htmlState.tagName && o.htmlState.tagName.toLowerCase()) &&
									l.hasOwnProperty(s)
								)
									o.inTag = s + " ";
								else if (o.inTag && h && />$/.test(e.current())) {
									var u = /^([\S]+) (.*)/.exec(o.inTag);
									o.inTag = null;
									var d =
											">" == e.current() &&
											(function (t, e) {
												for (var n = 0; n < t.length; n++) {
													var r = t[n];
													if (!r[0] || r[1].test(i(e, r[0]))) return r[2];
												}
											})(l[u[1]], u[2]),
										p = t.getMode(n, d),
										g = r(u[1], !0),
										m = r(u[1], !1);
									(o.token = function (t, e) {
										return t.match(g, !1)
											? ((e.token = f),
											  (e.localState = e.localMode = null),
											  null)
											: (function (t, e, n) {
													var i = t.current(),
														r = i.search(e);
													return (
														r > -1
															? t.backUp(i.length - r)
															: i.match(/<\/?$/) &&
															  (t.backUp(i.length),
															  t.match(e, !1) || t.match(i)),
														n
													);
											  })(t, m, e.localMode.token(t, e.localState));
									}),
										(o.localMode = p),
										(o.localState = t.startState(
											p,
											a.indent(o.htmlState, "", "")
										));
								} else
									o.inTag &&
										((o.inTag += e.current()), e.eol() && (o.inTag += " "));
								return c;
							}
							return {
								startState: function () {
									return {
										token: f,
										inTag: null,
										localMode: null,
										localState: null,
										htmlState: t.startState(a),
									};
								},
								copyState: function (e) {
									var n;
									return (
										e.localState &&
											(n = t.copyState(e.localMode, e.localState)),
										{
											token: e.token,
											inTag: e.inTag,
											localMode: e.localMode,
											localState: n,
											htmlState: t.copyState(a, e.htmlState),
										}
									);
								},
								token: function (t, e) {
									return e.token(t, e);
								},
								indent: function (e, n, i) {
									return !e.localMode || /^\s*<\//.test(n)
										? a.indent(e.htmlState, n, i)
										: e.localMode.indent
										? e.localMode.indent(e.localState, n, i)
										: t.Pass;
								},
								innerMode: function (t) {
									return {
										state: t.localState || t.htmlState,
										mode: t.localMode || a,
									};
								},
							};
						},
						"xml",
						"javascript",
						"css"
					),
						t.defineMIME("text/html", "htmlmixed");
				}),
					"object" == typeof n && "object" == typeof e
						? i(
								t("../../lib/codemirror"),
								t("../xml/xml"),
								t("../javascript/javascript"),
								t("../css/css")
						  )
						: "function" == typeof define && define.amd
						? define(
								[
									"../../lib/codemirror",
									"../xml/xml",
									"../javascript/javascript",
									"../css/css",
								],
								i
						  )
						: i(CodeMirror);
			},
			{
				"../../lib/codemirror": 13,
				"../css/css": 15,
				"../javascript/javascript": 17,
				"../xml/xml": 19,
			},
		],
		17: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					t.defineMode("javascript", function (e, n) {
						var i,
							r,
							o = e.indentUnit,
							s = n.statementIndent,
							a = n.jsonld,
							l = n.json || a,
							c = !1 !== n.trackScope,
							h = n.typescript,
							u = n.wordCharacters || /[\w$\xa1-\uffff]/,
							f = (function () {
								function t(t) {
									return { type: t, style: "keyword" };
								}
								var e = t("keyword a"),
									n = t("keyword b"),
									i = t("keyword c"),
									r = t("keyword d"),
									o = t("operator"),
									s = { type: "atom", style: "atom" };
								return {
									if: t("if"),
									while: e,
									with: e,
									else: n,
									do: n,
									try: n,
									finally: n,
									return: r,
									break: r,
									continue: r,
									new: t("new"),
									delete: i,
									void: i,
									throw: i,
									debugger: t("debugger"),
									var: t("var"),
									const: t("var"),
									let: t("var"),
									function: t("function"),
									catch: t("catch"),
									for: t("for"),
									switch: t("switch"),
									case: t("case"),
									default: t("default"),
									in: o,
									typeof: o,
									instanceof: o,
									true: s,
									false: s,
									null: s,
									undefined: s,
									NaN: s,
									Infinity: s,
									this: t("this"),
									class: t("class"),
									super: t("atom"),
									yield: i,
									export: t("export"),
									import: t("import"),
									extends: i,
									await: i,
								};
							})(),
							d = /[+\-*&%=<>!?|~^@]/,
							p =
								/^@(context|id|value|language|type|container|list|set|reverse|index|base|vocab|graph)"/;
						function g(t, e, n) {
							return (i = t), (r = n), e;
						}
						function m(t, e) {
							var n,
								i = t.next();
							if ('"' == i || "'" == i)
								return (
									(e.tokenize =
										((n = i),
										function (t, e) {
											var i,
												r = !1;
											if (a && "@" == t.peek() && t.match(p))
												return (e.tokenize = m), g("jsonld-keyword", "meta");
											for (; null != (i = t.next()) && (i != n || r); )
												r = !r && "\\" == i;
											return r || (e.tokenize = m), g("string", "string");
										})),
									e.tokenize(t, e)
								);
							if ("." == i && t.match(/^\d[\d_]*(?:[eE][+\-]?[\d_]+)?/))
								return g("number", "number");
							if ("." == i && t.match("..")) return g("spread", "meta");
							if (/[\[\]{}\(\),;\:\.]/.test(i)) return g(i);
							if ("=" == i && t.eat(">")) return g("=>", "operator");
							if ("0" == i && t.match(/^(?:x[\dA-Fa-f_]+|o[0-7_]+|b[01_]+)n?/))
								return g("number", "number");
							if (/\d/.test(i))
								return (
									t.match(/^[\d_]*(?:n|(?:\.[\d_]*)?(?:[eE][+\-]?[\d_]+)?)?/),
									g("number", "number")
								);
							if ("/" == i)
								return t.eat("*")
									? ((e.tokenize = v), v(t, e))
									: t.eat("/")
									? (t.skipToEnd(), g("comment", "comment"))
									: Jt(t, e, 1)
									? ((function (t) {
											for (var e, n = !1, i = !1; null != (e = t.next()); ) {
												if (!n) {
													if ("/" == e && !i) return;
													"[" == e ? (i = !0) : i && "]" == e && (i = !1);
												}
												n = !n && "\\" == e;
											}
									  })(t),
									  t.match(/^\b(([gimyus])(?![gimyus]*\2))+\b/),
									  g("regexp", "string-2"))
									: (t.eat("="), g("operator", "operator", t.current()));
							if ("`" == i) return (e.tokenize = _), _(t, e);
							if ("#" == i && "!" == t.peek())
								return t.skipToEnd(), g("meta", "meta");
							if ("#" == i && t.eatWhile(u)) return g("variable", "property");
							if (
								("<" == i && t.match("!--")) ||
								("-" == i &&
									t.match("->") &&
									!/\S/.test(t.string.slice(0, t.start)))
							)
								return t.skipToEnd(), g("comment", "comment");
							if (d.test(i))
								return (
									(">" == i && e.lexical && ">" == e.lexical.type) ||
										(t.eat("=")
											? ("!" != i && "=" != i) || t.eat("=")
											: /[<>*+\-|&?]/.test(i) &&
											  (t.eat(i), ">" == i && t.eat(i))),
									"?" == i && t.eat(".")
										? g(".")
										: g("operator", "operator", t.current())
								);
							if (u.test(i)) {
								t.eatWhile(u);
								var r = t.current();
								if ("." != e.lastType) {
									if (f.propertyIsEnumerable(r)) {
										var o = f[r];
										return g(o.type, o.style, r);
									}
									if (
										"async" == r &&
										t.match(/^(\s|\/\*([^*]|\*(?!\/))*?\*\/)*[\[\(\w]/, !1)
									)
										return g("async", "keyword", r);
								}
								return g("variable", "variable", r);
							}
						}
						function v(t, e) {
							for (var n, i = !1; (n = t.next()); ) {
								if ("/" == n && i) {
									e.tokenize = m;
									break;
								}
								i = "*" == n;
							}
							return g("comment", "comment");
						}
						function _(t, e) {
							for (var n, i = !1; null != (n = t.next()); ) {
								if (!i && ("`" == n || ("$" == n && t.eat("{")))) {
									e.tokenize = m;
									break;
								}
								i = !i && "\\" == n;
							}
							return g("quasi", "string-2", t.current());
						}
						function y(t, e) {
							e.fatArrowAt && (e.fatArrowAt = null);
							var n = t.string.indexOf("=>", t.start);
							if (!(n < 0)) {
								if (h) {
									var i = /:\s*(?:\w+(?:<[^>]*>|\[\])?|\{[^}]*\})\s*$/.exec(
										t.string.slice(t.start, n)
									);
									i && (n = i.index);
								}
								for (var r = 0, o = !1, s = n - 1; s >= 0; --s) {
									var a = t.string.charAt(s),
										l = "([{}])".indexOf(a);
									if (l >= 0 && l < 3) {
										if (!r) {
											++s;
											break;
										}
										if (0 == --r) {
											"(" == a && (o = !0);
											break;
										}
									} else if (l >= 3 && l < 6) ++r;
									else if (u.test(a)) o = !0;
									else if (/["'\/`]/.test(a))
										for (; ; --s) {
											if (0 == s) return;
											if (
												t.string.charAt(s - 1) == a &&
												"\\" != t.string.charAt(s - 2)
											) {
												s--;
												break;
											}
										}
									else if (o && !r) {
										++s;
										break;
									}
								}
								o && !r && (e.fatArrowAt = s);
							}
						}
						var x = {
							atom: !0,
							number: !0,
							variable: !0,
							string: !0,
							regexp: !0,
							this: !0,
							import: !0,
							"jsonld-keyword": !0,
						};
						function k(t, e, n, i, r, o) {
							(this.indented = t),
								(this.column = e),
								(this.type = n),
								(this.prev = r),
								(this.info = o),
								null != i && (this.align = i);
						}
						function b(t, e) {
							if (!c) return !1;
							for (var n = t.localVars; n; n = n.next)
								if (n.name == e) return !0;
							for (var i = t.context; i; i = i.prev)
								for (n = i.vars; n; n = n.next) if (n.name == e) return !0;
						}
						function T(t, e, n, i, r) {
							var o = t.cc;
							for (
								C.state = t,
									C.stream = r,
									C.marked = null,
									C.cc = o,
									C.style = e,
									t.lexical.hasOwnProperty("align") || (t.lexical.align = !0);
								;

							)
								if ((o.length ? o.pop() : l ? z : U)(n, i)) {
									for (; o.length && o[o.length - 1].lex; ) o.pop()();
									return C.marked
										? C.marked
										: "variable" == n && b(t, i)
										? "variable-2"
										: e;
								}
						}
						var C = { state: null, column: null, marked: null, cc: null };
						function w() {
							for (var t = arguments.length - 1; t >= 0; t--)
								C.cc.push(arguments[t]);
						}
						function E() {
							return w.apply(null, arguments), !0;
						}
						function S(t, e) {
							for (var n = e; n; n = n.next) if (n.name == t) return !0;
							return !1;
						}
						function A(t) {
							var e = C.state;
							if (((C.marked = "def"), c)) {
								if (e.context)
									if ("var" == e.lexical.info && e.context && e.context.block) {
										var i = L(t, e.context);
										if (null != i) return void (e.context = i);
									} else if (!S(t, e.localVars))
										return void (e.localVars = new I(t, e.localVars));
								n.globalVars &&
									!S(t, e.globalVars) &&
									(e.globalVars = new I(t, e.globalVars));
							}
						}
						function L(t, e) {
							if (e) {
								if (e.block) {
									var n = L(t, e.prev);
									return n ? (n == e.prev ? e : new N(n, e.vars, !0)) : null;
								}
								return S(t, e.vars) ? e : new N(e.prev, new I(t, e.vars), !1);
							}
							return null;
						}
						function O(t) {
							return (
								"public" == t ||
								"private" == t ||
								"protected" == t ||
								"abstract" == t ||
								"readonly" == t
							);
						}
						function N(t, e, n) {
							(this.prev = t), (this.vars = e), (this.block = n);
						}
						function I(t, e) {
							(this.name = t), (this.next = e);
						}
						var M = new I("this", new I("arguments", null));
						function $() {
							(C.state.context = new N(C.state.context, C.state.localVars, !1)),
								(C.state.localVars = M);
						}
						function R() {
							(C.state.context = new N(C.state.context, C.state.localVars, !0)),
								(C.state.localVars = null);
						}
						function D() {
							(C.state.localVars = C.state.context.vars),
								(C.state.context = C.state.context.prev);
						}
						function P(t, e) {
							var n = function () {
								var n = C.state,
									i = n.indented;
								if ("stat" == n.lexical.type) i = n.lexical.indented;
								else
									for (
										var r = n.lexical;
										r && ")" == r.type && r.align;
										r = r.prev
									)
										i = r.indented;
								n.lexical = new k(i, C.stream.column(), t, null, n.lexical, e);
							};
							return (n.lex = !0), n;
						}
						function F() {
							var t = C.state;
							t.lexical.prev &&
								(")" == t.lexical.type && (t.indented = t.lexical.indented),
								(t.lexical = t.lexical.prev));
						}
						function B(t) {
							return function e(n) {
								return n == t
									? E()
									: ";" == t || "}" == n || ")" == n || "]" == n
									? w()
									: E(e);
							};
						}
						function U(t, e) {
							return "var" == t
								? E(P("vardef", e), Ct, B(";"), F)
								: "keyword a" == t
								? E(P("form"), j, U, F)
								: "keyword b" == t
								? E(P("form"), U, F)
								: "keyword d" == t
								? C.stream.match(/^\s*$/, !1)
									? E()
									: E(P("stat"), q, B(";"), F)
								: "debugger" == t
								? E(B(";"))
								: "{" == t
								? E(P("}"), R, lt, F, D)
								: ";" == t
								? E()
								: "if" == t
								? ("else" == C.state.lexical.info &&
										C.state.cc[C.state.cc.length - 1] == F &&
										C.state.cc.pop()(),
								  E(P("form"), j, U, F, Ot))
								: "function" == t
								? E($t)
								: "for" == t
								? E(P("form"), R, Nt, U, D, F)
								: "class" == t || (h && "interface" == e)
								? ((C.marked = "keyword"),
								  E(P("form", "class" == t ? t : e), Bt, F))
								: "variable" == t
								? h && "declare" == e
									? ((C.marked = "keyword"), E(U))
									: h &&
									  ("module" == e || "enum" == e || "type" == e) &&
									  C.stream.match(/^\s*\w/, !1)
									? ((C.marked = "keyword"),
									  "enum" == e
											? E(Qt)
											: "type" == e
											? E(Dt, B("operator"), dt, B(";"))
											: E(P("form"), wt, B("{"), P("}"), lt, F, F))
									: h && "namespace" == e
									? ((C.marked = "keyword"), E(P("form"), z, U, F))
									: h && "abstract" == e
									? ((C.marked = "keyword"), E(U))
									: E(P("stat"), et)
								: "switch" == t
								? E(P("form"), j, B("{"), P("}", "switch"), R, lt, F, F, D)
								: "case" == t
								? E(z, B(":"))
								: "default" == t
								? E(B(":"))
								: "catch" == t
								? E(P("form"), $, H, U, F, D)
								: "export" == t
								? E(P("stat"), Wt, F)
								: "import" == t
								? E(P("stat"), Gt, F)
								: "async" == t
								? E(U)
								: "@" == e
								? E(z, U)
								: w(P("stat"), z, B(";"), F);
						}
						function H(t) {
							if ("(" == t) return E(Pt, B(")"));
						}
						function z(t, e) {
							return G(t, e, !1);
						}
						function W(t, e) {
							return G(t, e, !0);
						}
						function j(t) {
							return "(" != t ? w() : E(P(")"), q, B(")"), F);
						}
						function G(t, e, n) {
							if (C.state.fatArrowAt == C.stream.start) {
								var i = n ? Z : Q;
								if ("(" == t)
									return E($, P(")"), st(Pt, ")"), F, B("=>"), i, D);
								if ("variable" == t) return w($, wt, B("=>"), i, D);
							}
							var r = n ? Y : V;
							return x.hasOwnProperty(t)
								? E(r)
								: "function" == t
								? E($t, r)
								: "class" == t || (h && "interface" == e)
								? ((C.marked = "keyword"), E(P("form"), Ft, F))
								: "keyword c" == t || "async" == t
								? E(n ? W : z)
								: "(" == t
								? E(P(")"), q, B(")"), F, r)
								: "operator" == t || "spread" == t
								? E(n ? W : z)
								: "[" == t
								? E(P("]"), Xt, F, r)
								: "{" == t
								? at(it, "}", null, r)
								: "quasi" == t
								? w(K, r)
								: "new" == t
								? E(
										(function (t) {
											return function (e) {
												return "." == e
													? E(t ? tt : J)
													: "variable" == e && h
													? E(kt, t ? Y : V)
													: w(t ? W : z);
											};
										})(n)
								  )
								: E();
						}
						function q(t) {
							return t.match(/[;\}\)\],]/) ? w() : w(z);
						}
						function V(t, e) {
							return "," == t ? E(q) : Y(t, e, !1);
						}
						function Y(t, e, n) {
							var i = 0 == n ? V : Y,
								r = 0 == n ? z : W;
							return "=>" == t
								? E($, n ? Z : Q, D)
								: "operator" == t
								? /\+\+|--/.test(e) || (h && "!" == e)
									? E(i)
									: h &&
									  "<" == e &&
									  C.stream.match(/^([^<>]|<[^<>]*>)*>\s*\(/, !1)
									? E(P(">"), st(dt, ">"), F, i)
									: "?" == e
									? E(z, B(":"), r)
									: E(r)
								: "quasi" == t
								? w(K, i)
								: ";" != t
								? "(" == t
									? at(W, ")", "call", i)
									: "." == t
									? E(nt, i)
									: "[" == t
									? E(P("]"), q, B("]"), F, i)
									: h && "as" == e
									? ((C.marked = "keyword"), E(dt, i))
									: "regexp" == t
									? ((C.state.lastType = C.marked = "operator"),
									  C.stream.backUp(C.stream.pos - C.stream.start - 1),
									  E(r))
									: void 0
								: void 0;
						}
						function K(t, e) {
							return "quasi" != t
								? w()
								: "${" != e.slice(e.length - 2)
								? E(K)
								: E(q, X);
						}
						function X(t) {
							if ("}" == t)
								return (C.marked = "string-2"), (C.state.tokenize = _), E(K);
						}
						function Q(t) {
							return y(C.stream, C.state), w("{" == t ? U : z);
						}
						function Z(t) {
							return y(C.stream, C.state), w("{" == t ? U : W);
						}
						function J(t, e) {
							if ("target" == e) return (C.marked = "keyword"), E(V);
						}
						function tt(t, e) {
							if ("target" == e) return (C.marked = "keyword"), E(Y);
						}
						function et(t) {
							return ":" == t ? E(F, U) : w(V, B(";"), F);
						}
						function nt(t) {
							if ("variable" == t) return (C.marked = "property"), E();
						}
						function it(t, e) {
							return "async" == t
								? ((C.marked = "property"), E(it))
								: "variable" == t || "keyword" == C.style
								? ((C.marked = "property"),
								  "get" == e || "set" == e
										? E(rt)
										: (h &&
												C.state.fatArrowAt == C.stream.start &&
												(n = C.stream.match(/^\s*:\s*/, !1)) &&
												(C.state.fatArrowAt = C.stream.pos + n[0].length),
										  E(ot)))
								: "number" == t || "string" == t
								? ((C.marked = a ? "property" : C.style + " property"), E(ot))
								: "jsonld-keyword" == t
								? E(ot)
								: h && O(e)
								? ((C.marked = "keyword"), E(it))
								: "[" == t
								? E(z, ct, B("]"), ot)
								: "spread" == t
								? E(W, ot)
								: "*" == e
								? ((C.marked = "keyword"), E(it))
								: ":" == t
								? w(ot)
								: void 0;
							var n;
						}
						function rt(t) {
							return "variable" != t ? w(ot) : ((C.marked = "property"), E($t));
						}
						function ot(t) {
							return ":" == t ? E(W) : "(" == t ? w($t) : void 0;
						}
						function st(t, e, n) {
							function i(r, o) {
								if (n ? n.indexOf(r) > -1 : "," == r) {
									var s = C.state.lexical;
									return (
										"call" == s.info && (s.pos = (s.pos || 0) + 1),
										E(function (n, i) {
											return n == e || i == e ? w() : w(t);
										}, i)
									);
								}
								return r == e || o == e
									? E()
									: n && n.indexOf(";") > -1
									? w(t)
									: E(B(e));
							}
							return function (n, r) {
								return n == e || r == e ? E() : w(t, i);
							};
						}
						function at(t, e, n) {
							for (var i = 3; i < arguments.length; i++)
								C.cc.push(arguments[i]);
							return E(P(e, n), st(t, e), F);
						}
						function lt(t) {
							return "}" == t ? E() : w(U, lt);
						}
						function ct(t, e) {
							if (h) {
								if (":" == t) return E(dt);
								if ("?" == e) return E(ct);
							}
						}
						function ht(t, e) {
							if (h && (":" == t || "in" == e)) return E(dt);
						}
						function ut(t) {
							if (h && ":" == t)
								return C.stream.match(/^\s*\w+\s+is\b/, !1)
									? E(z, ft, dt)
									: E(dt);
						}
						function ft(t, e) {
							if ("is" == e) return (C.marked = "keyword"), E();
						}
						function dt(t, e) {
							return "keyof" == e ||
								"typeof" == e ||
								"infer" == e ||
								"readonly" == e
								? ((C.marked = "keyword"), E("typeof" == e ? W : dt))
								: "variable" == t || "void" == e
								? ((C.marked = "type"), E(xt))
								: "|" == e || "&" == e
								? E(dt)
								: "string" == t || "number" == t || "atom" == t
								? E(xt)
								: "[" == t
								? E(P("]"), st(dt, "]", ","), F, xt)
								: "{" == t
								? E(P("}"), gt, F, xt)
								: "(" == t
								? E(st(yt, ")"), pt, xt)
								: "<" == t
								? E(st(dt, ">"), dt)
								: "quasi" == t
								? w(vt, xt)
								: void 0;
						}
						function pt(t) {
							if ("=>" == t) return E(dt);
						}
						function gt(t) {
							return t.match(/[\}\)\]]/)
								? E()
								: "," == t || ";" == t
								? E(gt)
								: w(mt, gt);
						}
						function mt(t, e) {
							return "variable" == t || "keyword" == C.style
								? ((C.marked = "property"), E(mt))
								: "?" == e || "number" == t || "string" == t
								? E(mt)
								: ":" == t
								? E(dt)
								: "[" == t
								? E(B("variable"), ht, B("]"), mt)
								: "(" == t
								? w(Rt, mt)
								: t.match(/[;\}\)\],]/)
								? void 0
								: E();
						}
						function vt(t, e) {
							return "quasi" != t
								? w()
								: "${" != e.slice(e.length - 2)
								? E(vt)
								: E(dt, _t);
						}
						function _t(t) {
							if ("}" == t)
								return (C.marked = "string-2"), (C.state.tokenize = _), E(vt);
						}
						function yt(t, e) {
							return ("variable" == t && C.stream.match(/^\s*[?:]/, !1)) ||
								"?" == e
								? E(yt)
								: ":" == t
								? E(dt)
								: "spread" == t
								? E(yt)
								: w(dt);
						}
						function xt(t, e) {
							return "<" == e
								? E(P(">"), st(dt, ">"), F, xt)
								: "|" == e || "." == t || "&" == e
								? E(dt)
								: "[" == t
								? E(dt, B("]"), xt)
								: "extends" == e || "implements" == e
								? ((C.marked = "keyword"), E(dt))
								: "?" == e
								? E(dt, B(":"), dt)
								: void 0;
						}
						function kt(t, e) {
							if ("<" == e) return E(P(">"), st(dt, ">"), F, xt);
						}
						function bt() {
							return w(dt, Tt);
						}
						function Tt(t, e) {
							if ("=" == e) return E(dt);
						}
						function Ct(t, e) {
							return "enum" == e
								? ((C.marked = "keyword"), E(Qt))
								: w(wt, ct, At, Lt);
						}
						function wt(t, e) {
							return h && O(e)
								? ((C.marked = "keyword"), E(wt))
								: "variable" == t
								? (A(e), E())
								: "spread" == t
								? E(wt)
								: "[" == t
								? at(St, "]")
								: "{" == t
								? at(Et, "}")
								: void 0;
						}
						function Et(t, e) {
							return "variable" != t || C.stream.match(/^\s*:/, !1)
								? ("variable" == t && (C.marked = "property"),
								  "spread" == t
										? E(wt)
										: "}" == t
										? w()
										: "[" == t
										? E(z, B("]"), B(":"), Et)
										: E(B(":"), wt, At))
								: (A(e), E(At));
						}
						function St() {
							return w(wt, At);
						}
						function At(t, e) {
							if ("=" == e) return E(W);
						}
						function Lt(t) {
							if ("," == t) return E(Ct);
						}
						function Ot(t, e) {
							if ("keyword b" == t && "else" == e)
								return E(P("form", "else"), U, F);
						}
						function Nt(t, e) {
							return "await" == e
								? E(Nt)
								: "(" == t
								? E(P(")"), It, F)
								: void 0;
						}
						function It(t) {
							return "var" == t ? E(Ct, Mt) : "variable" == t ? E(Mt) : w(Mt);
						}
						function Mt(t, e) {
							return ")" == t
								? E()
								: ";" == t
								? E(Mt)
								: "in" == e || "of" == e
								? ((C.marked = "keyword"), E(z, Mt))
								: w(z, Mt);
						}
						function $t(t, e) {
							return "*" == e
								? ((C.marked = "keyword"), E($t))
								: "variable" == t
								? (A(e), E($t))
								: "(" == t
								? E($, P(")"), st(Pt, ")"), F, ut, U, D)
								: h && "<" == e
								? E(P(">"), st(bt, ">"), F, $t)
								: void 0;
						}
						function Rt(t, e) {
							return "*" == e
								? ((C.marked = "keyword"), E(Rt))
								: "variable" == t
								? (A(e), E(Rt))
								: "(" == t
								? E($, P(")"), st(Pt, ")"), F, ut, D)
								: h && "<" == e
								? E(P(">"), st(bt, ">"), F, Rt)
								: void 0;
						}
						function Dt(t, e) {
							return "keyword" == t || "variable" == t
								? ((C.marked = "type"), E(Dt))
								: "<" == e
								? E(P(">"), st(bt, ">"), F)
								: void 0;
						}
						function Pt(t, e) {
							return (
								"@" == e && E(z, Pt),
								"spread" == t
									? E(Pt)
									: h && O(e)
									? ((C.marked = "keyword"), E(Pt))
									: h && "this" == t
									? E(ct, At)
									: w(wt, ct, At)
							);
						}
						function Ft(t, e) {
							return "variable" == t ? Bt(t, e) : Ut(t, e);
						}
						function Bt(t, e) {
							if ("variable" == t) return A(e), E(Ut);
						}
						function Ut(t, e) {
							return "<" == e
								? E(P(">"), st(bt, ">"), F, Ut)
								: "extends" == e || "implements" == e || (h && "," == t)
								? ("implements" == e && (C.marked = "keyword"),
								  E(h ? dt : z, Ut))
								: "{" == t
								? E(P("}"), Ht, F)
								: void 0;
						}
						function Ht(t, e) {
							return "async" == t ||
								("variable" == t &&
									("static" == e || "get" == e || "set" == e || (h && O(e))) &&
									C.stream.match(/^\s+[\w$\xa1-\uffff]/, !1))
								? ((C.marked = "keyword"), E(Ht))
								: "variable" == t || "keyword" == C.style
								? ((C.marked = "property"), E(zt, Ht))
								: "number" == t || "string" == t
								? E(zt, Ht)
								: "[" == t
								? E(z, ct, B("]"), zt, Ht)
								: "*" == e
								? ((C.marked = "keyword"), E(Ht))
								: h && "(" == t
								? w(Rt, Ht)
								: ";" == t || "," == t
								? E(Ht)
								: "}" == t
								? E()
								: "@" == e
								? E(z, Ht)
								: void 0;
						}
						function zt(t, e) {
							if ("!" == e) return E(zt);
							if ("?" == e) return E(zt);
							if (":" == t) return E(dt, At);
							if ("=" == e) return E(W);
							var n = C.state.lexical.prev;
							return w(n && "interface" == n.info ? Rt : $t);
						}
						function Wt(t, e) {
							return "*" == e
								? ((C.marked = "keyword"), E(Kt, B(";")))
								: "default" == e
								? ((C.marked = "keyword"), E(z, B(";")))
								: "{" == t
								? E(st(jt, "}"), Kt, B(";"))
								: w(U);
						}
						function jt(t, e) {
							return "as" == e
								? ((C.marked = "keyword"), E(B("variable")))
								: "variable" == t
								? w(W, jt)
								: void 0;
						}
						function Gt(t) {
							return "string" == t
								? E()
								: "(" == t
								? w(z)
								: "." == t
								? w(V)
								: w(qt, Vt, Kt);
						}
						function qt(t, e) {
							return "{" == t
								? at(qt, "}")
								: ("variable" == t && A(e),
								  "*" == e && (C.marked = "keyword"),
								  E(Yt));
						}
						function Vt(t) {
							if ("," == t) return E(qt, Vt);
						}
						function Yt(t, e) {
							if ("as" == e) return (C.marked = "keyword"), E(qt);
						}
						function Kt(t, e) {
							if ("from" == e) return (C.marked = "keyword"), E(z);
						}
						function Xt(t) {
							return "]" == t ? E() : w(st(W, "]"));
						}
						function Qt() {
							return w(P("form"), wt, B("{"), P("}"), st(Zt, "}"), F, F);
						}
						function Zt() {
							return w(wt, At);
						}
						function Jt(t, e, n) {
							return (
								(e.tokenize == m &&
									/^(?:operator|sof|keyword [bcd]|case|new|export|default|spread|[\[{}\(,;:]|=>)$/.test(
										e.lastType
									)) ||
								("quasi" == e.lastType &&
									/\{\s*$/.test(t.string.slice(0, t.pos - (n || 0))))
							);
						}
						return (
							(D.lex = !0),
							(F.lex = !0),
							{
								startState: function (t) {
									var e = {
										tokenize: m,
										lastType: "sof",
										cc: [],
										lexical: new k((t || 0) - o, 0, "block", !1),
										localVars: n.localVars,
										context: n.localVars && new N(null, null, !1),
										indented: t || 0,
									};
									return (
										n.globalVars &&
											"object" == typeof n.globalVars &&
											(e.globalVars = n.globalVars),
										e
									);
								},
								token: function (t, e) {
									if (
										(t.sol() &&
											(e.lexical.hasOwnProperty("align") ||
												(e.lexical.align = !1),
											(e.indented = t.indentation()),
											y(t, e)),
										e.tokenize != v && t.eatSpace())
									)
										return null;
									var n = e.tokenize(t, e);
									return "comment" == i
										? n
										: ((e.lastType =
												"operator" != i || ("++" != r && "--" != r)
													? i
													: "incdec"),
										  T(e, n, i, r, t));
								},
								indent: function (e, i) {
									if (e.tokenize == v || e.tokenize == _) return t.Pass;
									if (e.tokenize != m) return 0;
									var r,
										a = i && i.charAt(0),
										l = e.lexical;
									if (!/^\s*else\b/.test(i))
										for (var c = e.cc.length - 1; c >= 0; --c) {
											var h = e.cc[c];
											if (h == F) l = l.prev;
											else if (h != Ot && h != D) break;
										}
									for (
										;
										("stat" == l.type || "form" == l.type) &&
										("}" == a ||
											((r = e.cc[e.cc.length - 1]) &&
												(r == V || r == Y) &&
												!/^[,\.=+\-*:?[\(]/.test(i)));

									)
										l = l.prev;
									s && ")" == l.type && "stat" == l.prev.type && (l = l.prev);
									var u = l.type,
										f = a == u;
									return "vardef" == u
										? l.indented +
												("operator" == e.lastType || "," == e.lastType
													? l.info.length + 1
													: 0)
										: "form" == u && "{" == a
										? l.indented
										: "form" == u
										? l.indented + o
										: "stat" == u
										? l.indented +
										  ((function (t, e) {
												return (
													"operator" == t.lastType ||
													"," == t.lastType ||
													d.test(e.charAt(0)) ||
													/[,.]/.test(e.charAt(0))
												);
										  })(e, i)
												? s || o
												: 0)
										: "switch" != l.info || f || 0 == n.doubleIndentSwitch
										? l.align
											? l.column + (f ? 0 : 1)
											: l.indented + (f ? 0 : o)
										: l.indented + (/^(?:case|default)\b/.test(i) ? o : 2 * o);
								},
								electricInput: /^\s*(?:case .*?:|default:|\{|\})$/,
								blockCommentStart: l ? null : "/*",
								blockCommentEnd: l ? null : "*/",
								blockCommentContinue: l ? null : " * ",
								lineComment: l ? null : "//",
								fold: "brace",
								closeBrackets: "()[]{}''\"\"``",
								helperType: l ? "json" : "javascript",
								jsonldMode: a,
								jsonMode: l,
								expressionAllowed: Jt,
								skipExpression: function (e) {
									T(e, "atom", "atom", "true", new t.StringStream("", 2, null));
								},
							}
						);
					}),
						t.registerHelper("wordChars", "javascript", /[\w$]/),
						t.defineMIME("text/javascript", "javascript"),
						t.defineMIME("text/ecmascript", "javascript"),
						t.defineMIME("application/javascript", "javascript"),
						t.defineMIME("application/x-javascript", "javascript"),
						t.defineMIME("application/ecmascript", "javascript"),
						t.defineMIME("application/json", { name: "javascript", json: !0 }),
						t.defineMIME("application/x-json", {
							name: "javascript",
							json: !0,
						}),
						t.defineMIME("application/manifest+json", {
							name: "javascript",
							json: !0,
						}),
						t.defineMIME("application/ld+json", {
							name: "javascript",
							jsonld: !0,
						}),
						t.defineMIME("text/typescript", {
							name: "javascript",
							typescript: !0,
						}),
						t.defineMIME("application/typescript", {
							name: "javascript",
							typescript: !0,
						});
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		18: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					function e(t) {
						for (var e = {}, n = t.split(" "), i = 0; i < n.length; ++i)
							e[n[i]] = !0;
						return e;
					}
					function n(t, e, r) {
						return 0 == t.length
							? i(e)
							: function (o, s) {
									for (var a = t[0], l = 0; l < a.length; l++)
										if (o.match(a[l][0]))
											return (s.tokenize = n(t.slice(1), e)), a[l][1];
									return (s.tokenize = i(e, r)), "string";
							  };
					}
					function i(t, e) {
						return function (i, r) {
							return (function (t, e, i, r) {
								if ((!1 !== r && t.match("${", !1)) || t.match("{$", !1))
									return (e.tokenize = null), "string";
								if (!1 !== r && t.match(/^\$[a-zA-Z_][a-zA-Z0-9_]*/))
									return (
										t.match("[", !1) &&
											(e.tokenize = n(
												[
													[["[", null]],
													[
														[/\d[\w\.]*/, "number"],
														[/\$[a-zA-Z_][a-zA-Z0-9_]*/, "variable-2"],
														[/[\w\$]+/, "variable"],
													],
													[["]", null]],
												],
												i,
												r
											)),
										t.match(/^->\w/, !1) &&
											(e.tokenize = n(
												[[["->", null]], [[/[\w]+/, "variable"]]],
												i,
												r
											)),
										"variable-2"
									);
								for (
									var o = !1;
									!t.eol() &&
									(o ||
										!1 === r ||
										(!t.match("{$", !1) &&
											!t.match(/^(\$[a-zA-Z_][a-zA-Z0-9_]*|\$\{)/, !1)));

								) {
									if (!o && t.match(i)) {
										(e.tokenize = null), e.tokStack.pop(), e.tokStack.pop();
										break;
									}
									o = "\\" == t.next() && !o;
								}
								return "string";
							})(i, r, t, e);
						};
					}
					var r =
							"abstract and array as break case catch class clone const continue declare default do else elseif enddeclare endfor endforeach endif endswitch endwhile extends final for foreach function global goto if implements interface instanceof namespace new or private protected public static switch throw trait try use var while xor die echo empty exit eval include include_once isset list require require_once return print unset __halt_compiler self static parent yield insteadof finally",
						o =
							"true false null TRUE FALSE NULL __CLASS__ __DIR__ __FILE__ __LINE__ __METHOD__ __FUNCTION__ __NAMESPACE__ __TRAIT__",
						s =
							"func_num_args func_get_arg func_get_args strlen strcmp strncmp strcasecmp strncasecmp each error_reporting define defined trigger_error user_error set_error_handler restore_error_handler get_declared_classes get_loaded_extensions extension_loaded get_extension_funcs debug_backtrace constant bin2hex hex2bin sleep usleep time mktime gmmktime strftime gmstrftime strtotime date gmdate getdate localtime checkdate flush wordwrap htmlspecialchars htmlentities html_entity_decode md5 md5_file crc32 getimagesize image_type_to_mime_type phpinfo phpversion phpcredits strnatcmp strnatcasecmp substr_count strspn strcspn strtok strtoupper strtolower strpos strrpos strrev hebrev hebrevc nl2br basename dirname pathinfo stripslashes stripcslashes strstr stristr strrchr str_shuffle str_word_count strcoll substr substr_replace quotemeta ucfirst ucwords strtr addslashes addcslashes rtrim str_replace str_repeat count_chars chunk_split trim ltrim strip_tags similar_text explode implode setlocale localeconv parse_str str_pad chop strchr sprintf printf vprintf vsprintf sscanf fscanf parse_url urlencode urldecode rawurlencode rawurldecode readlink linkinfo link unlink exec system escapeshellcmd escapeshellarg passthru shell_exec proc_open proc_close rand srand getrandmax mt_rand mt_srand mt_getrandmax base64_decode base64_encode abs ceil floor round is_finite is_nan is_infinite bindec hexdec octdec decbin decoct dechex base_convert number_format fmod ip2long long2ip getenv putenv getopt microtime gettimeofday getrusage uniqid quoted_printable_decode set_time_limit get_cfg_var magic_quotes_runtime set_magic_quotes_runtime get_magic_quotes_gpc get_magic_quotes_runtime import_request_variables error_log serialize unserialize memory_get_usage memory_get_peak_usage var_dump var_export debug_zval_dump print_r highlight_file show_source highlight_string ini_get ini_get_all ini_set ini_alter ini_restore get_include_path set_include_path restore_include_path setcookie header headers_sent connection_aborted connection_status ignore_user_abort parse_ini_file is_uploaded_file move_uploaded_file intval floatval doubleval strval gettype settype is_null is_resource is_bool is_long is_float is_int is_integer is_double is_real is_numeric is_string is_array is_object is_scalar ereg ereg_replace eregi eregi_replace split spliti join sql_regcase dl pclose popen readfile rewind rmdir umask fclose feof fgetc fgets fgetss fread fopen fpassthru ftruncate fstat fseek ftell fflush fwrite fputs mkdir rename copy tempnam tmpfile file file_get_contents file_put_contents stream_select stream_context_create stream_context_set_params stream_context_set_option stream_context_get_options stream_filter_prepend stream_filter_append fgetcsv flock get_meta_tags stream_set_write_buffer set_file_buffer set_socket_blocking stream_set_blocking socket_set_blocking stream_get_meta_data stream_register_wrapper stream_wrapper_register stream_set_timeout socket_set_timeout socket_get_status realpath fnmatch fsockopen pfsockopen pack unpack get_browser crypt opendir closedir chdir getcwd rewinddir readdir dir glob fileatime filectime filegroup fileinode filemtime fileowner fileperms filesize filetype file_exists is_writable is_writeable is_readable is_executable is_file is_dir is_link stat lstat chown touch clearstatcache mail ob_start ob_flush ob_clean ob_end_flush ob_end_clean ob_get_flush ob_get_clean ob_get_length ob_get_level ob_get_status ob_get_contents ob_implicit_flush ob_list_handlers ksort krsort natsort natcasesort asort arsort sort rsort usort uasort uksort shuffle array_walk count end prev next reset current key min max in_array array_search extract compact array_fill range array_multisort array_push array_pop array_shift array_unshift array_splice array_slice array_merge array_merge_recursive array_keys array_values array_count_values array_reverse array_reduce array_pad array_flip array_change_key_case array_rand array_unique array_intersect array_intersect_assoc array_diff array_diff_assoc array_sum array_filter array_map array_chunk array_key_exists array_intersect_key array_combine array_column pos sizeof key_exists assert assert_options version_compare ftok str_rot13 aggregate session_name session_module_name session_save_path session_id session_regenerate_id session_decode session_register session_unregister session_is_registered session_encode session_start session_destroy session_unset session_set_save_handler session_cache_limiter session_cache_expire session_set_cookie_params session_get_cookie_params session_write_close preg_match preg_match_all preg_replace preg_replace_callback preg_split preg_quote preg_grep overload ctype_alnum ctype_alpha ctype_cntrl ctype_digit ctype_lower ctype_graph ctype_print ctype_punct ctype_space ctype_upper ctype_xdigit virtual apache_request_headers apache_note apache_lookup_uri apache_child_terminate apache_setenv apache_response_headers apache_get_version getallheaders mysql_connect mysql_pconnect mysql_close mysql_select_db mysql_create_db mysql_drop_db mysql_query mysql_unbuffered_query mysql_db_query mysql_list_dbs mysql_list_tables mysql_list_fields mysql_list_processes mysql_error mysql_errno mysql_affected_rows mysql_insert_id mysql_result mysql_num_rows mysql_num_fields mysql_fetch_row mysql_fetch_array mysql_fetch_assoc mysql_fetch_object mysql_data_seek mysql_fetch_lengths mysql_fetch_field mysql_field_seek mysql_free_result mysql_field_name mysql_field_table mysql_field_len mysql_field_type mysql_field_flags mysql_escape_string mysql_real_escape_string mysql_stat mysql_thread_id mysql_client_encoding mysql_get_client_info mysql_get_host_info mysql_get_proto_info mysql_get_server_info mysql_info mysql mysql_fieldname mysql_fieldtable mysql_fieldlen mysql_fieldtype mysql_fieldflags mysql_selectdb mysql_createdb mysql_dropdb mysql_freeresult mysql_numfields mysql_numrows mysql_listdbs mysql_listtables mysql_listfields mysql_db_name mysql_dbname mysql_tablename mysql_table_name pg_connect pg_pconnect pg_close pg_connection_status pg_connection_busy pg_connection_reset pg_host pg_dbname pg_port pg_tty pg_options pg_ping pg_query pg_send_query pg_cancel_query pg_fetch_result pg_fetch_row pg_fetch_assoc pg_fetch_array pg_fetch_object pg_fetch_all pg_affected_rows pg_get_result pg_result_seek pg_result_status pg_free_result pg_last_oid pg_num_rows pg_num_fields pg_field_name pg_field_num pg_field_size pg_field_type pg_field_prtlen pg_field_is_null pg_get_notify pg_get_pid pg_result_error pg_last_error pg_last_notice pg_put_line pg_end_copy pg_copy_to pg_copy_from pg_trace pg_untrace pg_lo_create pg_lo_unlink pg_lo_open pg_lo_close pg_lo_read pg_lo_write pg_lo_read_all pg_lo_import pg_lo_export pg_lo_seek pg_lo_tell pg_escape_string pg_escape_bytea pg_unescape_bytea pg_client_encoding pg_set_client_encoding pg_meta_data pg_convert pg_insert pg_update pg_delete pg_select pg_exec pg_getlastoid pg_cmdtuples pg_errormessage pg_numrows pg_numfields pg_fieldname pg_fieldsize pg_fieldtype pg_fieldnum pg_fieldprtlen pg_fieldisnull pg_freeresult pg_result pg_loreadall pg_locreate pg_lounlink pg_loopen pg_loclose pg_loread pg_lowrite pg_loimport pg_loexport http_response_code get_declared_traits getimagesizefromstring socket_import_stream stream_set_chunk_size trait_exists header_register_callback class_uses session_status session_register_shutdown echo print global static exit array empty eval isset unset die include require include_once require_once json_decode json_encode json_last_error json_last_error_msg curl_close curl_copy_handle curl_errno curl_error curl_escape curl_exec curl_file_create curl_getinfo curl_init curl_multi_add_handle curl_multi_close curl_multi_exec curl_multi_getcontent curl_multi_info_read curl_multi_init curl_multi_remove_handle curl_multi_select curl_multi_setopt curl_multi_strerror curl_pause curl_reset curl_setopt_array curl_setopt curl_share_close curl_share_init curl_share_setopt curl_strerror curl_unescape curl_version mysqli_affected_rows mysqli_autocommit mysqli_change_user mysqli_character_set_name mysqli_close mysqli_commit mysqli_connect_errno mysqli_connect_error mysqli_connect mysqli_data_seek mysqli_debug mysqli_dump_debug_info mysqli_errno mysqli_error_list mysqli_error mysqli_fetch_all mysqli_fetch_array mysqli_fetch_assoc mysqli_fetch_field_direct mysqli_fetch_field mysqli_fetch_fields mysqli_fetch_lengths mysqli_fetch_object mysqli_fetch_row mysqli_field_count mysqli_field_seek mysqli_field_tell mysqli_free_result mysqli_get_charset mysqli_get_client_info mysqli_get_client_stats mysqli_get_client_version mysqli_get_connection_stats mysqli_get_host_info mysqli_get_proto_info mysqli_get_server_info mysqli_get_server_version mysqli_info mysqli_init mysqli_insert_id mysqli_kill mysqli_more_results mysqli_multi_query mysqli_next_result mysqli_num_fields mysqli_num_rows mysqli_options mysqli_ping mysqli_prepare mysqli_query mysqli_real_connect mysqli_real_escape_string mysqli_real_query mysqli_reap_async_query mysqli_refresh mysqli_rollback mysqli_select_db mysqli_set_charset mysqli_set_local_infile_default mysqli_set_local_infile_handler mysqli_sqlstate mysqli_ssl_set mysqli_stat mysqli_stmt_init mysqli_store_result mysqli_thread_id mysqli_thread_safe mysqli_use_result mysqli_warning_count";
					t.registerHelper("hintWords", "php", [r, o, s].join(" ").split(" ")),
						t.registerHelper("wordChars", "php", /[\w$]/);
					var a = {
						name: "clike",
						helperType: "php",
						keywords: e(r),
						blockKeywords: e(
							"catch do else elseif for foreach if switch try while finally"
						),
						defKeywords: e("class function interface namespace trait"),
						atoms: e(o),
						builtin: e(s),
						multiLineStrings: !0,
						hooks: {
							$: function (t) {
								return t.eatWhile(/[\w\$_]/), "variable-2";
							},
							"<": function (t, e) {
								var n;
								if ((n = t.match(/^<<\s*/))) {
									var r = t.eat(/['"]/);
									t.eatWhile(/[\w\.]/);
									var o = t.current().slice(n[0].length + (r ? 2 : 1));
									if ((r && t.eat(r), o))
										return (
											(e.tokStack || (e.tokStack = [])).push(o, 0),
											(e.tokenize = i(o, "'" != r)),
											"string"
										);
								}
								return !1;
							},
							"#": function (t) {
								for (; !t.eol() && !t.match("?>", !1); ) t.next();
								return "comment";
							},
							"/": function (t) {
								if (t.eat("/")) {
									for (; !t.eol() && !t.match("?>", !1); ) t.next();
									return "comment";
								}
								return !1;
							},
							'"': function (t, e) {
								return (
									(e.tokStack || (e.tokStack = [])).push('"', 0),
									(e.tokenize = i('"')),
									"string"
								);
							},
							"{": function (t, e) {
								return (
									e.tokStack &&
										e.tokStack.length &&
										e.tokStack[e.tokStack.length - 1]++,
									!1
								);
							},
							"}": function (t, e) {
								return (
									e.tokStack &&
										e.tokStack.length > 0 &&
										!--e.tokStack[e.tokStack.length - 1] &&
										(e.tokenize = i(e.tokStack[e.tokStack.length - 2])),
									!1
								);
							},
						},
					};
					t.defineMode(
						"php",
						function (e, n) {
							var i = t.getMode(e, (n && n.htmlMode) || "text/html"),
								r = t.getMode(e, a);
							return {
								startState: function () {
									var e = t.startState(i),
										o = n.startOpen ? t.startState(r) : null;
									return {
										html: e,
										php: o,
										curMode: n.startOpen ? r : i,
										curState: n.startOpen ? o : e,
										pending: null,
									};
								},
								copyState: function (e) {
									var n,
										o = e.html,
										s = t.copyState(i, o),
										a = e.php,
										l = a && t.copyState(r, a);
									return (
										(n = e.curMode == i ? s : l),
										{
											html: s,
											php: l,
											curMode: e.curMode,
											curState: n,
											pending: e.pending,
										}
									);
								},
								token: function (e, n) {
									var o = n.curMode == r;
									if (
										(e.sol() &&
											n.pending &&
											'"' != n.pending &&
											"'" != n.pending &&
											(n.pending = null),
										o)
									)
										return o && null == n.php.tokenize && e.match("?>")
											? ((n.curMode = i),
											  (n.curState = n.html),
											  n.php.context.prev || (n.php = null),
											  "meta")
											: r.token(e, n.curState);
									if (e.match(/^<\?\w*/))
										return (
											(n.curMode = r),
											n.php ||
												(n.php = t.startState(r, i.indent(n.html, "", ""))),
											(n.curState = n.php),
											"meta"
										);
									if ('"' == n.pending || "'" == n.pending) {
										for (; !e.eol() && e.next() != n.pending; );
										var s = "string";
									} else
										n.pending && e.pos < n.pending.end
											? ((e.pos = n.pending.end), (s = n.pending.style))
											: (s = i.token(e, n.curState));
									n.pending && (n.pending = null);
									var a,
										l = e.current(),
										c = l.search(/<\?/);
									return (
										-1 != c &&
											("string" == s &&
											(a = l.match(/[\'\"]$/)) &&
											!/\?>/.test(l)
												? (n.pending = a[0])
												: (n.pending = { end: e.pos, style: s }),
											e.backUp(l.length - c)),
										s
									);
								},
								indent: function (t, e, n) {
									return (t.curMode != r && /^\s*<\//.test(e)) ||
										(t.curMode == r && /^\?>/.test(e))
										? i.indent(t.html, e, n)
										: t.curMode.indent(t.curState, e, n);
								},
								blockCommentStart: "/*",
								blockCommentEnd: "*/",
								lineComment: "//",
								innerMode: function (t) {
									return { state: t.curState, mode: t.curMode };
								},
							};
						},
						"htmlmixed",
						"clike"
					),
						t.defineMIME("application/x-httpd-php", "php"),
						t.defineMIME("application/x-httpd-php-open", {
							name: "php",
							startOpen: !0,
						}),
						t.defineMIME("text/x-php", a);
				}),
					"object" == typeof n && "object" == typeof e
						? i(
								t("../../lib/codemirror"),
								t("../htmlmixed/htmlmixed"),
								t("../clike/clike")
						  )
						: "function" == typeof define && define.amd
						? define(
								[
									"../../lib/codemirror",
									"../htmlmixed/htmlmixed",
									"../clike/clike",
								],
								i
						  )
						: i(CodeMirror);
			},
			{
				"../../lib/codemirror": 13,
				"../clike/clike": 14,
				"../htmlmixed/htmlmixed": 16,
			},
		],
		19: [
			function (t, e, n) {
				var i;
				(i = function (t) {
					"use strict";
					var e = {
							autoSelfClosers: {
								area: !0,
								base: !0,
								br: !0,
								col: !0,
								command: !0,
								embed: !0,
								frame: !0,
								hr: !0,
								img: !0,
								input: !0,
								keygen: !0,
								link: !0,
								meta: !0,
								param: !0,
								source: !0,
								track: !0,
								wbr: !0,
								menuitem: !0,
							},
							implicitlyClosed: {
								dd: !0,
								li: !0,
								optgroup: !0,
								option: !0,
								p: !0,
								rp: !0,
								rt: !0,
								tbody: !0,
								td: !0,
								tfoot: !0,
								th: !0,
								tr: !0,
							},
							contextGrabbers: {
								dd: { dd: !0, dt: !0 },
								dt: { dd: !0, dt: !0 },
								li: { li: !0 },
								option: { option: !0, optgroup: !0 },
								optgroup: { optgroup: !0 },
								p: {
									address: !0,
									article: !0,
									aside: !0,
									blockquote: !0,
									dir: !0,
									div: !0,
									dl: !0,
									fieldset: !0,
									footer: !0,
									form: !0,
									h1: !0,
									h2: !0,
									h3: !0,
									h4: !0,
									h5: !0,
									h6: !0,
									header: !0,
									hgroup: !0,
									hr: !0,
									menu: !0,
									nav: !0,
									ol: !0,
									p: !0,
									pre: !0,
									section: !0,
									table: !0,
									ul: !0,
								},
								rp: { rp: !0, rt: !0 },
								rt: { rp: !0, rt: !0 },
								tbody: { tbody: !0, tfoot: !0 },
								td: { td: !0, th: !0 },
								tfoot: { tbody: !0 },
								th: { td: !0, th: !0 },
								thead: { tbody: !0, tfoot: !0 },
								tr: { tr: !0 },
							},
							doNotIndent: { pre: !0 },
							allowUnquoted: !0,
							allowMissing: !0,
							caseFold: !0,
						},
						n = {
							autoSelfClosers: {},
							implicitlyClosed: {},
							contextGrabbers: {},
							doNotIndent: {},
							allowUnquoted: !1,
							allowMissing: !1,
							allowMissingTagName: !1,
							caseFold: !1,
						};
					t.defineMode("xml", function (i, r) {
						var o,
							s,
							a = i.indentUnit,
							l = {},
							c = r.htmlMode ? e : n;
						for (var h in c) l[h] = c[h];
						for (var h in r) l[h] = r[h];
						function u(t, e) {
							function n(n) {
								return (e.tokenize = n), n(t, e);
							}
							var i = t.next();
							return "<" == i
								? t.eat("!")
									? t.eat("[")
										? t.match("CDATA[")
											? n(d("atom", "]]>"))
											: null
										: t.match("--")
										? n(d("comment", "--\x3e"))
										: t.match("DOCTYPE", !0, !0)
										? (t.eatWhile(/[\w\._\-]/), n(p(1)))
										: null
									: t.eat("?")
									? (t.eatWhile(/[\w\._\-]/),
									  (e.tokenize = d("meta", "?>")),
									  "meta")
									: ((o = t.eat("/") ? "closeTag" : "openTag"),
									  (e.tokenize = f),
									  "tag bracket")
								: "&" == i
								? (
										t.eat("#")
											? t.eat("x")
												? t.eatWhile(/[a-fA-F\d]/) && t.eat(";")
												: t.eatWhile(/[\d]/) && t.eat(";")
											: t.eatWhile(/[\w\.\-:]/) && t.eat(";")
								  )
									? "atom"
									: "error"
								: (t.eatWhile(/[^&<]/), null);
						}
						function f(t, e) {
							var n,
								i,
								r = t.next();
							if (">" == r || ("/" == r && t.eat(">")))
								return (
									(e.tokenize = u),
									(o = ">" == r ? "endTag" : "selfcloseTag"),
									"tag bracket"
								);
							if ("=" == r) return (o = "equals"), null;
							if ("<" == r) {
								(e.tokenize = u),
									(e.state = _),
									(e.tagName = e.tagStart = null);
								var s = e.tokenize(t, e);
								return s ? s + " tag error" : "tag error";
							}
							return /[\'\"]/.test(r)
								? ((e.tokenize =
										((n = r),
										((i = function (t, e) {
											for (; !t.eol(); )
												if (t.next() == n) {
													e.tokenize = f;
													break;
												}
											return "string";
										}).isInAttribute = !0),
										i)),
								  (e.stringStartCol = t.column()),
								  e.tokenize(t, e))
								: (t.match(/^[^\s\u00a0=<>\"\']*[^\s\u00a0=<>\"\'\/]/), "word");
						}
						function d(t, e) {
							return function (n, i) {
								for (; !n.eol(); ) {
									if (n.match(e)) {
										i.tokenize = u;
										break;
									}
									n.next();
								}
								return t;
							};
						}
						function p(t) {
							return function (e, n) {
								for (var i; null != (i = e.next()); ) {
									if ("<" == i)
										return (n.tokenize = p(t + 1)), n.tokenize(e, n);
									if (">" == i) {
										if (1 == t) {
											n.tokenize = u;
											break;
										}
										return (n.tokenize = p(t - 1)), n.tokenize(e, n);
									}
								}
								return "meta";
							};
						}
						function g(t, e, n) {
							(this.prev = t.context),
								(this.tagName = e || ""),
								(this.indent = t.indented),
								(this.startOfLine = n),
								(l.doNotIndent.hasOwnProperty(e) ||
									(t.context && t.context.noIndent)) &&
									(this.noIndent = !0);
						}
						function m(t) {
							t.context && (t.context = t.context.prev);
						}
						function v(t, e) {
							for (var n; ; ) {
								if (!t.context) return;
								if (
									((n = t.context.tagName),
									!l.contextGrabbers.hasOwnProperty(n) ||
										!l.contextGrabbers[n].hasOwnProperty(e))
								)
									return;
								m(t);
							}
						}
						function _(t, e, n) {
							return "openTag" == t
								? ((n.tagStart = e.column()), y)
								: "closeTag" == t
								? x
								: _;
						}
						function y(t, e, n) {
							return "word" == t
								? ((n.tagName = e.current()), (s = "tag"), T)
								: l.allowMissingTagName && "endTag" == t
								? ((s = "tag bracket"), T(t, 0, n))
								: ((s = "error"), y);
						}
						function x(t, e, n) {
							if ("word" == t) {
								var i = e.current();
								return (
									n.context &&
										n.context.tagName != i &&
										l.implicitlyClosed.hasOwnProperty(n.context.tagName) &&
										m(n),
									(n.context && n.context.tagName == i) || !1 === l.matchClosing
										? ((s = "tag"), k)
										: ((s = "tag error"), b)
								);
							}
							return l.allowMissingTagName && "endTag" == t
								? ((s = "tag bracket"), k(t, 0, n))
								: ((s = "error"), b);
						}
						function k(t, e, n) {
							return "endTag" != t ? ((s = "error"), k) : (m(n), _);
						}
						function b(t, e, n) {
							return (s = "error"), k(t, 0, n);
						}
						function T(t, e, n) {
							if ("word" == t) return (s = "attribute"), C;
							if ("endTag" == t || "selfcloseTag" == t) {
								var i = n.tagName,
									r = n.tagStart;
								return (
									(n.tagName = n.tagStart = null),
									"selfcloseTag" == t || l.autoSelfClosers.hasOwnProperty(i)
										? v(n, i)
										: (v(n, i), (n.context = new g(n, i, r == n.indented))),
									_
								);
							}
							return (s = "error"), T;
						}
						function C(t, e, n) {
							return "equals" == t
								? w
								: (l.allowMissing || (s = "error"), T(t, 0, n));
						}
						function w(t, e, n) {
							return "string" == t
								? E
								: "word" == t && l.allowUnquoted
								? ((s = "string"), T)
								: ((s = "error"), T(t, 0, n));
						}
						function E(t, e, n) {
							return "string" == t ? E : T(t, 0, n);
						}
						return (
							(u.isInText = !0),
							{
								startState: function (t) {
									var e = {
										tokenize: u,
										state: _,
										indented: t || 0,
										tagName: null,
										tagStart: null,
										context: null,
									};
									return null != t && (e.baseIndent = t), e;
								},
								token: function (t, e) {
									if (
										(!e.tagName && t.sol() && (e.indented = t.indentation()),
										t.eatSpace())
									)
										return null;
									o = null;
									var n = e.tokenize(t, e);
									return (
										(n || o) &&
											"comment" != n &&
											((s = null),
											(e.state = e.state(o || n, t, e)),
											s && (n = "error" == s ? n + " error" : s)),
										n
									);
								},
								indent: function (e, n, i) {
									var r = e.context;
									if (e.tokenize.isInAttribute)
										return e.tagStart == e.indented
											? e.stringStartCol + 1
											: e.indented + a;
									if (r && r.noIndent) return t.Pass;
									if (e.tokenize != f && e.tokenize != u)
										return i ? i.match(/^(\s*)/)[0].length : 0;
									if (e.tagName)
										return !1 !== l.multilineTagIndentPastTag
											? e.tagStart + e.tagName.length + 2
											: e.tagStart + a * (l.multilineTagIndentFactor || 1);
									if (l.alignCDATA && /<!\[CDATA\[/.test(n)) return 0;
									var o = n && /^<(\/)?([\w_:\.-]*)/.exec(n);
									if (o && o[1])
										for (; r; ) {
											if (r.tagName == o[2]) {
												r = r.prev;
												break;
											}
											if (!l.implicitlyClosed.hasOwnProperty(r.tagName)) break;
											r = r.prev;
										}
									else if (o)
										for (; r; ) {
											var s = l.contextGrabbers[r.tagName];
											if (!s || !s.hasOwnProperty(o[2])) break;
											r = r.prev;
										}
									for (; r && r.prev && !r.startOfLine; ) r = r.prev;
									return r ? r.indent + a : e.baseIndent || 0;
								},
								electricInput: /<\/[\s\w:]+>$/,
								blockCommentStart: "\x3c!--",
								blockCommentEnd: "--\x3e",
								configuration: l.htmlMode ? "html" : "xml",
								helperType: l.htmlMode ? "html" : "xml",
								skipAttribute: function (t) {
									t.state == w && (t.state = T);
								},
								xmlCurrentTag: function (t) {
									return t.tagName
										? { name: t.tagName, close: "closeTag" == t.type }
										: null;
								},
								xmlCurrentContext: function (t) {
									for (var e = [], n = t.context; n; n = n.prev)
										e.push(n.tagName);
									return e.reverse();
								},
							}
						);
					}),
						t.defineMIME("text/xml", "xml"),
						t.defineMIME("application/xml", "xml"),
						t.mimeModes.hasOwnProperty("text/html") ||
							t.defineMIME("text/html", { name: "xml", htmlMode: !0 });
				}),
					"object" == typeof n && "object" == typeof e
						? i(t("../../lib/codemirror"))
						: "function" == typeof define && define.amd
						? define(["../../lib/codemirror"], i)
						: i(CodeMirror);
			},
			{ "../../lib/codemirror": 13 },
		],
		20: [
			function (t, e, n) {
				"use strict";
				const i = t("./ast/location"),
					r = t("./ast/position"),
					o = function (t, e) {
						(this.withPositions = t), (this.withSource = e);
					};
				(o.prototype.position = function (t) {
					return new r(
						t.lexer.yylloc.first_line,
						t.lexer.yylloc.first_column,
						t.lexer.yylloc.first_offset
					);
				}),
					(o.precedence = {}),
					[
						["or"],
						["xor"],
						["and"],
						["="],
						["?"],
						["??"],
						["||"],
						["&&"],
						["|"],
						["^"],
						["&"],
						["==", "!=", "===", "!==", "<=>"],
						["<", "<=", ">", ">="],
						["<<", ">>"],
						["+", "-", "."],
						["*", "/", "%"],
						["!"],
						["instanceof"],
						["cast", "silent"],
						["**"],
					].forEach(function (t, e) {
						t.forEach(function (t) {
							o.precedence[t] = e + 1;
						});
					}),
					(o.prototype.isRightAssociative = function (t) {
						return "**" === t || "??" === t;
					}),
					(o.prototype.swapLocations = function (t, e, n, i) {
						this.withPositions &&
							((t.loc.start = e.loc.start),
							(t.loc.end = n.loc.end),
							this.withSource &&
								(t.loc.source = i.lexer._input.substring(
									t.loc.start.offset,
									t.loc.end.offset
								)));
					}),
					(o.prototype.resolveLocations = function (t, e, n, i) {
						this.withPositions &&
							(t.loc.start.offset > e.loc.start.offset &&
								(t.loc.start = e.loc.start),
							t.loc.end.offset < n.loc.end.offset && (t.loc.end = n.loc.end),
							this.withSource &&
								(t.loc.source = i.lexer._input.substring(
									t.loc.start.offset,
									t.loc.end.offset
								)));
					}),
					(o.prototype.resolvePrecedence = function (t, e) {
						let n, i, r;
						return (
							"call" === t.kind
								? this.resolveLocations(t, t.what, t, e)
								: "propertylookup" === t.kind ||
								  "staticlookup" === t.kind ||
								  ("offsetlookup" === t.kind && t.offset)
								? this.resolveLocations(t, t.what, t.offset, e)
								: "bin" === t.kind
								? t.right &&
								  !t.right.parenthesizedExpression &&
								  ("bin" === t.right.kind
										? ((i = o.precedence[t.type]),
										  (r = o.precedence[t.right.type]),
										  i &&
												r &&
												r <= i &&
												(t.type !== t.right.type ||
													!this.isRightAssociative(t.type)) &&
												((n = t.right),
												(t.right = t.right.left),
												this.swapLocations(t, t.left, t.right, e),
												(n.left = this.resolvePrecedence(t, e)),
												this.swapLocations(n, n.left, n.right, e),
												(t = n)))
										: "retif" === t.right.kind &&
										  ((i = o.precedence[t.type]),
										  (r = o.precedence["?"]),
										  i &&
												r &&
												r <= i &&
												((n = t.right),
												(t.right = t.right.test),
												this.swapLocations(t, t.left, t.right, e),
												(n.test = this.resolvePrecedence(t, e)),
												this.swapLocations(n, n.test, n.falseExpr, e),
												(t = n))))
								: ("silent" !== t.kind && "cast" !== t.kind) ||
								  !t.expr ||
								  t.expr.parenthesizedExpression
								? "unary" === t.kind
									? t.what &&
									  !t.what.parenthesizedExpression &&
									  ("bin" === t.what.kind
											? ((n = t.what),
											  (t.what = t.what.left),
											  this.swapLocations(t, t, t.what, e),
											  (n.left = this.resolvePrecedence(t, e)),
											  this.swapLocations(n, n.left, n.right, e),
											  (t = n))
											: "retif" === t.what.kind &&
											  ((n = t.what),
											  (t.what = t.what.test),
											  this.swapLocations(t, t, t.what, e),
											  (n.test = this.resolvePrecedence(t, e)),
											  this.swapLocations(n, n.test, n.falseExpr, e),
											  (t = n)))
									: "retif" === t.kind
									? t.falseExpr &&
									  "retif" === t.falseExpr.kind &&
									  !t.falseExpr.parenthesizedExpression &&
									  ((n = t.falseExpr),
									  (t.falseExpr = n.test),
									  this.swapLocations(t, t.test, t.falseExpr, e),
									  (n.test = this.resolvePrecedence(t, e)),
									  this.swapLocations(n, n.test, n.falseExpr, e),
									  (t = n))
									: "assign" === t.kind
									? t.right &&
									  "bin" === t.right.kind &&
									  !t.right.parenthesizedExpression &&
									  ((i = o.precedence["="]),
									  (r = o.precedence[t.right.type]),
									  i &&
											r &&
											r < i &&
											((n = t.right),
											(t.right = t.right.left),
											(n.left = t),
											this.swapLocations(n, n.left, t.right, e),
											(t = n)))
									: "expressionstatement" === t.kind &&
									  this.swapLocations(t, t.expression, t, e)
								: "bin" === t.expr.kind
								? ((n = t.expr),
								  (t.expr = t.expr.left),
								  this.swapLocations(t, t, t.expr, e),
								  (n.left = this.resolvePrecedence(t, e)),
								  this.swapLocations(n, n.left, n.right, e),
								  (t = n))
								: "retif" === t.expr.kind &&
								  ((n = t.expr),
								  (t.expr = t.expr.test),
								  this.swapLocations(t, t, t.expr, e),
								  (n.test = this.resolvePrecedence(t, e)),
								  this.swapLocations(n, n.test, n.falseExpr, e),
								  (t = n)),
							t
						);
					}),
					(o.prototype.prepare = function (t, e, n) {
						let s = null;
						(this.withPositions || this.withSource) && (s = this.position(n));
						const a = this,
							l = function () {
								let c = null;
								const h = Array.prototype.slice.call(arguments);
								if ((h.push(e), a.withPositions || a.withSource)) {
									let t = null;
									a.withSource &&
										(t = n.lexer._input.substring(s.offset, n.prev[2])),
										(c = new i(t, s, new r(n.prev[0], n.prev[1], n.prev[2]))),
										h.push(c);
								}
								t || (t = h.shift());
								const u = a[t];
								if ("function" != typeof u)
									throw new Error('Undefined node "' + t + '"');
								const f = Object.create(u.prototype);
								return (
									u.apply(f, h),
									(l.instance = f),
									l.trailingComments &&
										(f.trailingComments = l.trailingComments),
									"function" == typeof l.postBuild && l.postBuild(f),
									n.debug && delete o.stack[l.stackUid],
									a.resolvePrecedence(f, n)
								);
							};
						return (
							n.debug &&
								(o.stack || ((o.stack = {}), (o.stackUid = 1)),
								(o.stack[++o.stackUid] = {
									position: s,
									stack: new Error().stack.split("\n").slice(3, 5),
								}),
								(l.stackUid = o.stackUid)),
							(l.setTrailingComments = function (t) {
								l.instance
									? l.instance.setTrailingComments(t)
									: (l.trailingComments = t);
							}),
							(l.destroy = function (t) {
								e &&
									(t
										? t.leadingComments
											? (t.leadingComments = e.concat(t.leadingComments))
											: (t.leadingComments = e)
										: (n._docIndex = n._docs.length - e.length)),
									n.debug && delete o.stack[l.stackUid];
							}),
							l
						);
					}),
					(o.prototype.checkNodes = function () {
						const t = [];
						for (const e in o.stack)
							o.stack.hasOwnProperty(e) && t.push(o.stack[e]);
						return (o.stack = {}), t;
					}),
					[
						t("./ast/array"),
						t("./ast/arrowfunc"),
						t("./ast/assign"),
						t("./ast/assignref"),
						t("./ast/attribute"),
						t("./ast/attrgroup"),
						t("./ast/bin"),
						t("./ast/block"),
						t("./ast/boolean"),
						t("./ast/break"),
						t("./ast/byref"),
						t("./ast/call"),
						t("./ast/case"),
						t("./ast/cast"),
						t("./ast/catch"),
						t("./ast/class"),
						t("./ast/classconstant"),
						t("./ast/clone"),
						t("./ast/closure"),
						t("./ast/comment"),
						t("./ast/commentblock"),
						t("./ast/commentline"),
						t("./ast/constant"),
						t("./ast/constantstatement"),
						t("./ast/continue"),
						t("./ast/declaration"),
						t("./ast/declare"),
						t("./ast/declaredirective"),
						t("./ast/do"),
						t("./ast/echo"),
						t("./ast/empty"),
						t("./ast/encapsed"),
						t("./ast/encapsedpart"),
						t("./ast/entry"),
						t("./ast/error"),
						t("./ast/eval"),
						t("./ast/exit"),
						t("./ast/expression"),
						t("./ast/expressionstatement"),
						t("./ast/for"),
						t("./ast/foreach"),
						t("./ast/function"),
						t("./ast/global"),
						t("./ast/goto"),
						t("./ast/halt"),
						t("./ast/identifier"),
						t("./ast/if"),
						t("./ast/include"),
						t("./ast/inline"),
						t("./ast/interface"),
						t("./ast/isset"),
						t("./ast/label"),
						t("./ast/list"),
						t("./ast/literal"),
						t("./ast/lookup"),
						t("./ast/magic"),
						t("./ast/match"),
						t("./ast/matcharm"),
						t("./ast/method"),
						t("./ast/name"),
						t("./ast/namespace"),
						t("./ast/namedargument"),
						t("./ast/new"),
						t("./ast/node"),
						t("./ast/noop"),
						t("./ast/nowdoc"),
						t("./ast/nullkeyword"),
						t("./ast/nullsafepropertylookup"),
						t("./ast/number"),
						t("./ast/offsetlookup"),
						t("./ast/operation"),
						t("./ast/parameter"),
						t("./ast/parentreference"),
						t("./ast/post"),
						t("./ast/pre"),
						t("./ast/print"),
						t("./ast/program"),
						t("./ast/property"),
						t("./ast/propertylookup"),
						t("./ast/propertystatement"),
						t("./ast/reference"),
						t("./ast/retif"),
						t("./ast/return"),
						t("./ast/selfreference"),
						t("./ast/silent"),
						t("./ast/statement"),
						t("./ast/static"),
						t("./ast/staticvariable"),
						t("./ast/staticlookup"),
						t("./ast/staticreference"),
						t("./ast/string"),
						t("./ast/switch"),
						t("./ast/throw"),
						t("./ast/trait"),
						t("./ast/traitalias"),
						t("./ast/traitprecedence"),
						t("./ast/traituse"),
						t("./ast/try"),
						t("./ast/typereference"),
						t("./ast/unary"),
						t("./ast/uniontype"),
						t("./ast/unset"),
						t("./ast/usegroup"),
						t("./ast/useitem"),
						t("./ast/variable"),
						t("./ast/variadic"),
						t("./ast/while"),
						t("./ast/yield"),
						t("./ast/yieldfrom"),
					].forEach(function (t) {
						o.prototype[t.kind] = t;
					}),
					(e.exports = o);
			},
			{
				"./ast/array": 21,
				"./ast/arrowfunc": 22,
				"./ast/assign": 23,
				"./ast/assignref": 24,
				"./ast/attrgroup": 25,
				"./ast/attribute": 26,
				"./ast/bin": 27,
				"./ast/block": 28,
				"./ast/boolean": 29,
				"./ast/break": 30,
				"./ast/byref": 31,
				"./ast/call": 32,
				"./ast/case": 33,
				"./ast/cast": 34,
				"./ast/catch": 35,
				"./ast/class": 36,
				"./ast/classconstant": 37,
				"./ast/clone": 38,
				"./ast/closure": 39,
				"./ast/comment": 40,
				"./ast/commentblock": 41,
				"./ast/commentline": 42,
				"./ast/constant": 43,
				"./ast/constantstatement": 44,
				"./ast/continue": 45,
				"./ast/declaration": 46,
				"./ast/declare": 47,
				"./ast/declaredirective": 48,
				"./ast/do": 49,
				"./ast/echo": 50,
				"./ast/empty": 51,
				"./ast/encapsed": 52,
				"./ast/encapsedpart": 53,
				"./ast/entry": 54,
				"./ast/error": 55,
				"./ast/eval": 56,
				"./ast/exit": 57,
				"./ast/expression": 58,
				"./ast/expressionstatement": 59,
				"./ast/for": 60,
				"./ast/foreach": 61,
				"./ast/function": 62,
				"./ast/global": 63,
				"./ast/goto": 64,
				"./ast/halt": 65,
				"./ast/identifier": 66,
				"./ast/if": 67,
				"./ast/include": 68,
				"./ast/inline": 69,
				"./ast/interface": 70,
				"./ast/isset": 71,
				"./ast/label": 72,
				"./ast/list": 73,
				"./ast/literal": 74,
				"./ast/location": 75,
				"./ast/lookup": 76,
				"./ast/magic": 77,
				"./ast/match": 78,
				"./ast/matcharm": 79,
				"./ast/method": 80,
				"./ast/name": 81,
				"./ast/namedargument": 82,
				"./ast/namespace": 83,
				"./ast/new": 84,
				"./ast/node": 85,
				"./ast/noop": 86,
				"./ast/nowdoc": 87,
				"./ast/nullkeyword": 88,
				"./ast/nullsafepropertylookup": 89,
				"./ast/number": 90,
				"./ast/offsetlookup": 91,
				"./ast/operation": 92,
				"./ast/parameter": 93,
				"./ast/parentreference": 94,
				"./ast/position": 95,
				"./ast/post": 96,
				"./ast/pre": 97,
				"./ast/print": 98,
				"./ast/program": 99,
				"./ast/property": 100,
				"./ast/propertylookup": 101,
				"./ast/propertystatement": 102,
				"./ast/reference": 103,
				"./ast/retif": 104,
				"./ast/return": 105,
				"./ast/selfreference": 106,
				"./ast/silent": 107,
				"./ast/statement": 108,
				"./ast/static": 109,
				"./ast/staticlookup": 110,
				"./ast/staticreference": 111,
				"./ast/staticvariable": 112,
				"./ast/string": 113,
				"./ast/switch": 114,
				"./ast/throw": 115,
				"./ast/trait": 116,
				"./ast/traitalias": 117,
				"./ast/traitprecedence": 118,
				"./ast/traituse": 119,
				"./ast/try": 120,
				"./ast/typereference": 121,
				"./ast/unary": 122,
				"./ast/uniontype": 123,
				"./ast/unset": 124,
				"./ast/usegroup": 125,
				"./ast/useitem": 126,
				"./ast/variable": 127,
				"./ast/variadic": 128,
				"./ast/while": 129,
				"./ast/yield": 130,
				"./ast/yieldfrom": 131,
			},
		],
		21: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "array";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.items = e), (this.shortForm = t);
				});
			},
			{ "./expression": 58 },
		],
		22: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "arrowfunc";
				e.exports = i.extends(r, function (t, e, n, o, s, a, l, c) {
					i.apply(this, [r, l, c]),
						(this.arguments = t),
						(this.byref = e),
						(this.body = n),
						(this.type = o),
						(this.nullable = s),
						(this.isStatic = a || !1);
				});
			},
			{ "./expression": 58 },
		],
		23: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "assign";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.left = t),
						(this.right = e),
						(this.operator = n);
				});
			},
			{ "./expression": 58 },
		],
		24: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "assignref";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.left = t), (this.right = e);
				});
			},
			{ "./expression": 58 },
		],
		25: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "attrgroup";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.attrs = t || []);
				});
			},
			{ "./node": 85 },
		],
		26: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "attribute";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.name = t), (this.args = e);
				});
			},
			{ "./node": 85 },
		],
		27: [
			function (t, e, n) {
				"use strict";
				const i = t("./operation");
				e.exports = i.extends("bin", function (t, e, n, r, o) {
					i.apply(this, ["bin", r, o]),
						(this.type = t),
						(this.left = e),
						(this.right = n);
				});
			},
			{ "./operation": 92 },
		],
		28: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "block";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [t || r, n, o]), (this.children = e.filter(Boolean));
				});
			},
			{ "./statement": 108 },
		],
		29: [
			function (t, e, n) {
				"use strict";
				const i = t("./literal"),
					r = "boolean";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, e, n, o]);
				});
			},
			{ "./literal": 74 },
		],
		30: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "break";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.level = t);
				});
			},
			{ "./statement": 108 },
		],
		31: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "byref";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.what = t);
				});
			},
			{ "./expression": 58 },
		],
		32: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "call";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.what = t), (this.arguments = e);
				});
			},
			{ "./expression": 58 },
		],
		33: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "case";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.test = t), (this.body = e);
				});
			},
			{ "./statement": 108 },
		],
		34: [
			function (t, e, n) {
				"use strict";
				const i = t("./operation"),
					r = "cast";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.type = t),
						(this.raw = e),
						(this.expr = n);
				});
			},
			{ "./operation": 92 },
		],
		35: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "catch";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.body = t),
						(this.what = e),
						(this.variable = n);
				});
			},
			{ "./statement": 108 },
		],
		36: [
			function (t, e, n) {
				"use strict";
				const i = t("./declaration"),
					r = "class";
				e.exports = i.extends(r, function (t, e, n, o, s, a, l) {
					i.apply(this, [r, t, a, l]),
						(this.isAnonymous = !t),
						(this.extends = e),
						(this.implements = n),
						(this.body = o),
						(this.attrGroups = []),
						this.parseFlags(s);
				});
			},
			{ "./declaration": 46 },
		],
		37: [
			function (t, e, n) {
				"use strict";
				const i = t("./constantstatement"),
					r = "classconstant",
					o = i.extends(r, function (t, e, n, o, s, a) {
						i.apply(this, [t || r, e, s, a]),
							this.parseFlags(n),
							(this.attrGroups = o);
					});
				(o.prototype.parseFlags = function (t) {
					-1 === t[0]
						? (this.visibility = "")
						: null === t[0]
						? (this.visibility = null)
						: 0 === t[0]
						? (this.visibility = "public")
						: 1 === t[0]
						? (this.visibility = "protected")
						: 2 === t[0] && (this.visibility = "private");
				}),
					(e.exports = o);
			},
			{ "./constantstatement": 44 },
		],
		38: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "clone";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.what = t);
				});
			},
			{ "./expression": 58 },
		],
		39: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "closure";
				e.exports = i.extends(r, function (t, e, n, o, s, a, l, c) {
					i.apply(this, [r, l, c]),
						(this.uses = n),
						(this.arguments = t),
						(this.byref = e),
						(this.type = o),
						(this.nullable = s),
						(this.isStatic = a || !1),
						(this.body = null),
						(this.attrGroups = []);
				});
			},
			{ "./expression": 58 },
		],
		40: [
			function (t, e, n) {
				"use strict";
				const i = t("./node");
				e.exports = i.extends("comment", function (t, e, n, r) {
					i.apply(this, [t, n, r]), (this.value = e);
				});
			},
			{ "./node": 85 },
		],
		41: [
			function (t, e, n) {
				"use strict";
				const i = t("./comment"),
					r = "commentblock";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, t, e, n]);
				});
			},
			{ "./comment": 40 },
		],
		42: [
			function (t, e, n) {
				"use strict";
				const i = t("./comment"),
					r = "commentline";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, t, e, n]);
				});
			},
			{ "./comment": 40 },
		],
		43: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "constant";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.name = t), (this.value = e);
				});
			},
			{ "./node": 85 },
		],
		44: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "constantstatement";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [t || r, n, o]), (this.constants = e);
				});
			},
			{ "./statement": 108 },
		],
		45: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "continue";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.level = t);
				});
			},
			{ "./statement": 108 },
		],
		46: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "declaration",
					o = i.extends(r, function (t, e, n, o) {
						i.apply(this, [t || r, n, o]), (this.name = e);
					});
				(o.prototype.parseFlags = function (t) {
					(this.isAbstract = 1 === t[2]),
						(this.isFinal = 2 === t[2]),
						"class" !== this.kind &&
							(-1 === t[0]
								? (this.visibility = "")
								: null === t[0]
								? (this.visibility = null)
								: 0 === t[0]
								? (this.visibility = "public")
								: 1 === t[0]
								? (this.visibility = "protected")
								: 2 === t[0] && (this.visibility = "private"),
							(this.isStatic = 1 === t[1]));
				}),
					(e.exports = o);
			},
			{ "./statement": 108 },
		],
		47: [
			function (t, e, n) {
				"use strict";
				const i = t("./block"),
					r = "declare",
					o = i.extends(r, function (t, e, n, o, s) {
						i.apply(this, [r, e, o, s]), (this.directives = t), (this.mode = n);
					});
				(o.MODE_SHORT = "short"),
					(o.MODE_BLOCK = "block"),
					(o.MODE_NONE = "none"),
					(e.exports = o);
			},
			{ "./block": 28 },
		],
		48: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "declaredirective";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.key = t), (this.value = e);
				});
			},
			{ "./node": 85 },
		],
		49: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement");
				e.exports = i.extends("do", function (t, e, n, r) {
					i.apply(this, ["do", n, r]), (this.test = t), (this.body = e);
				});
			},
			{ "./statement": 108 },
		],
		50: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "echo";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]),
						(this.shortForm = e),
						(this.expressions = t);
				});
			},
			{ "./statement": 108 },
		],
		51: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "empty";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.expression = t);
				});
			},
			{ "./expression": 58 },
		],
		52: [
			function (t, e, n) {
				"use strict";
				const i = t("./literal"),
					r = "encapsed",
					o = i.extends(r, function (t, e, n, o, s) {
						i.apply(this, [r, t, e, o, s]), (this.type = n);
					});
				(o.TYPE_STRING = "string"),
					(o.TYPE_SHELL = "shell"),
					(o.TYPE_HEREDOC = "heredoc"),
					(o.TYPE_OFFSET = "offset"),
					(e.exports = o);
			},
			{ "./literal": 74 },
		],
		53: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "encapsedpart";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.expression = t),
						(this.syntax = e),
						(this.curly = n);
				});
			},
			{ "./expression": 58 },
		],
		54: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "entry";
				e.exports = i.extends(r, function (t, e, n, o, s, a) {
					i.apply(this, [r, s, a]),
						(this.key = t),
						(this.value = e),
						(this.byRef = n),
						(this.unpack = o);
				});
			},
			{ "./expression": 58 },
		],
		55: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "error";
				e.exports = i.extends(r, function (t, e, n, o, s, a) {
					i.apply(this, [r, s, a]),
						(this.message = t),
						(this.token = e),
						(this.line = n),
						(this.expected = o);
				});
			},
			{ "./node": 85 },
		],
		56: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "eval";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.source = t);
				});
			},
			{ "./expression": 58 },
		],
		57: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "exit";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.expression = t), (this.useDie = e);
				});
			},
			{ "./expression": 58 },
		],
		58: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "expression";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [t || r, e, n]);
				});
			},
			{ "./node": 85 },
		],
		59: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "expressionstatement";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.expression = t);
				});
			},
			{ "./statement": 108 },
		],
		60: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement");
				e.exports = i.extends("for", function (t, e, n, r, o, s, a) {
					i.apply(this, ["for", s, a]),
						(this.init = t),
						(this.test = e),
						(this.increment = n),
						(this.shortForm = o),
						(this.body = r);
				});
			},
			{ "./statement": 108 },
		],
		61: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "foreach";
				e.exports = i.extends(r, function (t, e, n, o, s, a, l) {
					i.apply(this, [r, a, l]),
						(this.source = t),
						(this.key = e),
						(this.value = n),
						(this.shortForm = s),
						(this.body = o);
				});
			},
			{ "./statement": 108 },
		],
		62: [
			function (t, e, n) {
				"use strict";
				const i = t("./declaration"),
					r = "function";
				e.exports = i.extends(r, function (t, e, n, o, s, a, l) {
					i.apply(this, [r, t, a, l]),
						(this.arguments = e),
						(this.byref = n),
						(this.type = o),
						(this.nullable = s),
						(this.body = null),
						(this.attrGroups = []);
				});
			},
			{ "./declaration": 46 },
		],
		63: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "global";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.items = t);
				});
			},
			{ "./statement": 108 },
		],
		64: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "goto";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.label = t);
				});
			},
			{ "./statement": 108 },
		],
		65: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "halt";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.after = t);
				});
			},
			{ "./statement": 108 },
		],
		66: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "identifier",
					o = i.extends(r, function (t, e, n) {
						i.apply(this, [r, e, n]), (this.name = t);
					});
				e.exports = o;
			},
			{ "./node": 85 },
		],
		67: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement");
				e.exports = i.extends("if", function (t, e, n, r, o, s) {
					i.apply(this, ["if", o, s]),
						(this.test = t),
						(this.body = e),
						(this.alternate = n),
						(this.shortForm = r);
				});
			},
			{ "./statement": 108 },
		],
		68: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "include";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.once = t),
						(this.require = e),
						(this.target = n);
				});
			},
			{ "./expression": 58 },
		],
		69: [
			function (t, e, n) {
				"use strict";
				const i = t("./literal"),
					r = "inline";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, e, n, o]);
				});
			},
			{ "./literal": 74 },
		],
		70: [
			function (t, e, n) {
				"use strict";
				const i = t("./declaration"),
					r = "interface";
				e.exports = i.extends(r, function (t, e, n, o, s, a) {
					i.apply(this, [r, t, s, a]),
						(this.extends = e),
						(this.body = n),
						(this.attrGroups = o);
				});
			},
			{ "./declaration": 46 },
		],
		71: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "isset";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.variables = t);
				});
			},
			{ "./expression": 58 },
		],
		72: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "label";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.name = t);
				});
			},
			{ "./statement": 108 },
		],
		73: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "list";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.items = t), (this.shortForm = e);
				});
			},
			{ "./expression": 58 },
		],
		74: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "literal";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [t || r, o, s]), (this.value = e), n && (this.raw = n);
				});
			},
			{ "./expression": 58 },
		],
		75: [
			function (t, e, n) {
				"use strict";
				e.exports = function (t, e, n) {
					(this.source = t), (this.start = e), (this.end = n);
				};
			},
			{},
		],
		76: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "lookup";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [t || r, o, s]), (this.what = e), (this.offset = n);
				});
			},
			{ "./expression": 58 },
		],
		77: [
			function (t, e, n) {
				"use strict";
				const i = t("./literal"),
					r = "magic";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, e, n, o]);
				});
			},
			{ "./literal": 74 },
		],
		78: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "match";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.cond = t), (this.arms = e);
				});
			},
			{ "./expression": 58 },
		],
		79: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "matcharm";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.conds = t), (this.body = e);
				});
			},
			{ "./expression": 58 },
		],
		80: [
			function (t, e, n) {
				"use strict";
				const i = t("./function"),
					r = "method";
				e.exports = i.extends(r, function () {
					i.apply(this, arguments), (this.kind = r);
				});
			},
			{ "./function": 62 },
		],
		81: [
			function (t, e, n) {
				"use strict";
				const i = t("./reference"),
					r = "name",
					o = i.extends(r, function t(e, n, o, s) {
						i.apply(this, [r, o, s]),
							n
								? (this.resolution = t.RELATIVE_NAME)
								: 1 === e.length
								? (this.resolution = t.UNQUALIFIED_NAME)
								: e[0]
								? (this.resolution = t.QUALIFIED_NAME)
								: (this.resolution = t.FULL_QUALIFIED_NAME),
							(this.name = e.join("\\"));
					});
				(o.UNQUALIFIED_NAME = "uqn"),
					(o.QUALIFIED_NAME = "qn"),
					(o.FULL_QUALIFIED_NAME = "fqn"),
					(o.RELATIVE_NAME = "rn"),
					(e.exports = o);
			},
			{ "./reference": 103 },
		],
		82: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "namedargument";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.name = t), (this.value = e);
				});
			},
			{ "./expression": 58 },
		],
		83: [
			function (t, e, n) {
				"use strict";
				const i = t("./block"),
					r = "namespace";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, e, o, s]),
						(this.name = t),
						(this.withBrackets = n || !1);
				});
			},
			{ "./block": 28 },
		],
		84: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression");
				e.exports = i.extends("new", function (t, e, n, r) {
					i.apply(this, ["new", n, r]), (this.what = t), (this.arguments = e);
				});
			},
			{ "./expression": 58 },
		],
		85: [
			function (t, e, n) {
				"use strict";
				const i = function (t, e, n) {
					(this.kind = t), e && (this.leadingComments = e), n && (this.loc = n);
				};
				(i.prototype.setTrailingComments = function (t) {
					this.trailingComments = t;
				}),
					(i.prototype.destroy = function (t) {
						if (!t)
							throw new Error(
								"Node already initialized, you must swap with another node"
							);
						return (
							this.leadingComments &&
								(t.leadingComments
									? (t.leadingComments = Array.concat(
											this.leadingComments,
											t.leadingComments
									  ))
									: (t.leadingComments = this.leadingComments)),
							this.trailingComments &&
								(t.trailingComments
									? (t.trailingComments = Array.concat(
											this.trailingComments,
											t.trailingComments
									  ))
									: (t.trailingComments = this.trailingComments)),
							t
						);
					}),
					(i.prototype.includeToken = function (t) {
						return (
							this.loc &&
								(this.loc.end &&
									((this.loc.end.line = t.lexer.yylloc.last_line),
									(this.loc.end.column = t.lexer.yylloc.last_column),
									(this.loc.end.offset = t.lexer.offset)),
								t.ast.withSource &&
									(this.loc.source = t.lexer._input.substring(
										this.loc.start.offset,
										t.lexer.offset
									))),
							this
						);
					}),
					(i.extends = function (t, e) {
						return (
							(e.prototype = Object.create(this.prototype)),
							(e.extends = this.extends),
							(e.prototype.constructor = e),
							(e.kind = t),
							e
						);
					}),
					(e.exports = i);
			},
			{},
		],
		86: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "noop";
				e.exports = i.extends(r, function (t, e) {
					i.apply(this, [r, t, e]);
				});
			},
			{ "./node": 85 },
		],
		87: [
			function (t, e, n) {
				"use strict";
				const i = t("./literal"),
					r = "nowdoc";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, t, e, o, s]), (this.label = n);
				});
			},
			{ "./literal": 74 },
		],
		88: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "nullkeyword";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.raw = t);
				});
			},
			{ "./node": 85 },
		],
		89: [
			function (t, e, n) {
				"use strict";
				const i = t("./lookup"),
					r = "nullsafepropertylookup";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, e, n, o]);
				});
			},
			{ "./lookup": 76 },
		],
		90: [
			function (t, e, n) {
				"use strict";
				const i = t("./literal"),
					r = "number";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, e, n, o]);
				});
			},
			{ "./literal": 74 },
		],
		91: [
			function (t, e, n) {
				"use strict";
				const i = t("./lookup"),
					r = "offsetlookup";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, e, n, o]);
				});
			},
			{ "./lookup": 76 },
		],
		92: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "operation";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [t || r, e, n]);
				});
			},
			{ "./expression": 58 },
		],
		93: [
			function (t, e, n) {
				"use strict";
				const i = t("./declaration"),
					r = "parameter";
				e.exports = i.extends(r, function (t, e, n, o, s, a, l, c, h) {
					i.apply(this, [r, t, c, h]),
						(this.value = n),
						(this.type = e),
						(this.byref = o),
						(this.variadic = s),
						(this.nullable = a),
						(this.flags = l || 0),
						(this.attrGroups = []);
				});
			},
			{ "./declaration": 46 },
		],
		94: [
			function (t, e, n) {
				"use strict";
				const i = t("./reference"),
					r = "parentreference",
					o = i.extends(r, function (t, e, n) {
						i.apply(this, [r, e, n]), (this.raw = t);
					});
				e.exports = o;
			},
			{ "./reference": 103 },
		],
		95: [
			function (t, e, n) {
				"use strict";
				e.exports = function (t, e, n) {
					(this.line = t), (this.column = e), (this.offset = n);
				};
			},
			{},
		],
		96: [
			function (t, e, n) {
				"use strict";
				const i = t("./operation"),
					r = "post";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.type = t), (this.what = e);
				});
			},
			{ "./operation": 92 },
		],
		97: [
			function (t, e, n) {
				"use strict";
				const i = t("./operation");
				e.exports = i.extends("pre", function (t, e, n, r) {
					i.apply(this, ["pre", n, r]), (this.type = t), (this.what = e);
				});
			},
			{ "./operation": 92 },
		],
		98: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "print";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.expression = t);
				});
			},
			{ "./expression": 58 },
		],
		99: [
			function (t, e, n) {
				"use strict";
				const i = t("./block"),
					r = "program";
				e.exports = i.extends(r, function (t, e, n, o, s, a) {
					i.apply(this, [r, t, s, a]),
						(this.errors = e),
						n && (this.comments = n),
						o && (this.tokens = o);
				});
			},
			{ "./block": 28 },
		],
		100: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "property";
				e.exports = i.extends(r, function (t, e, n, o, s, a, l) {
					i.apply(this, [r, a, l]),
						(this.name = t),
						(this.value = e),
						(this.nullable = n),
						(this.type = o),
						(this.attrGroups = s);
				});
			},
			{ "./statement": 108 },
		],
		101: [
			function (t, e, n) {
				"use strict";
				const i = t("./lookup"),
					r = "propertylookup";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, e, n, o]);
				});
			},
			{ "./lookup": 76 },
		],
		102: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "propertystatement",
					o = i.extends(r, function (t, e, n, o, s) {
						i.apply(this, [r, o, s]), (this.properties = e), this.parseFlags(n);
					});
				(o.prototype.parseFlags = function (t) {
					-1 === t[0]
						? (this.visibility = "")
						: null === t[0]
						? (this.visibility = null)
						: 0 === t[0]
						? (this.visibility = "public")
						: 1 === t[0]
						? (this.visibility = "protected")
						: 2 === t[0] && (this.visibility = "private"),
						(this.isStatic = 1 === t[1]);
				}),
					(e.exports = o);
			},
			{ "./statement": 108 },
		],
		103: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "reference",
					o = i.extends(r, function (t, e, n) {
						i.apply(this, [t || r, e, n]);
					});
				e.exports = o;
			},
			{ "./node": 85 },
		],
		104: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "retif";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.test = t),
						(this.trueExpr = e),
						(this.falseExpr = n);
				});
			},
			{ "./expression": 58 },
		],
		105: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "return";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.expr = t);
				});
			},
			{ "./statement": 108 },
		],
		106: [
			function (t, e, n) {
				"use strict";
				const i = t("./reference"),
					r = "selfreference",
					o = i.extends(r, function (t, e, n) {
						i.apply(this, [r, e, n]), (this.raw = t);
					});
				e.exports = o;
			},
			{ "./reference": 103 },
		],
		107: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "silent";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.expr = t);
				});
			},
			{ "./expression": 58 },
		],
		108: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "statement";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [t || r, e, n]);
				});
			},
			{ "./node": 85 },
		],
		109: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "static";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.variables = t);
				});
			},
			{ "./statement": 108 },
		],
		110: [
			function (t, e, n) {
				"use strict";
				const i = t("./lookup"),
					r = "staticlookup";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, e, n, o]);
				});
			},
			{ "./lookup": 76 },
		],
		111: [
			function (t, e, n) {
				"use strict";
				const i = t("./reference"),
					r = "staticreference",
					o = i.extends(r, function (t, e, n) {
						i.apply(this, [r, e, n]), (this.raw = t);
					});
				e.exports = o;
			},
			{ "./reference": 103 },
		],
		112: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "staticvariable";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]),
						(this.variable = t),
						(this.defaultValue = e);
				});
			},
			{ "./node": 85 },
		],
		113: [
			function (t, e, n) {
				"use strict";
				const i = t("./literal"),
					r = "string";
				e.exports = i.extends(r, function (t, e, n, o, s, a) {
					i.apply(this, [r, e, o, s, a]),
						(this.unicode = n),
						(this.isDoubleQuote = t);
				});
			},
			{ "./literal": 74 },
		],
		114: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "switch";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.test = t),
						(this.body = e),
						(this.shortForm = n);
				});
			},
			{ "./statement": 108 },
		],
		115: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "throw";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.what = t);
				});
			},
			{ "./statement": 108 },
		],
		116: [
			function (t, e, n) {
				"use strict";
				const i = t("./declaration"),
					r = "trait";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, t, n, o]), (this.body = e);
				});
			},
			{ "./declaration": 46 },
		],
		117: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "traitalias";
				e.exports = i.extends(r, function (t, e, n, o, s, a) {
					i.apply(this, [r, s, a]),
						(this.trait = t),
						(this.method = e),
						(this.as = n),
						(this.visibility = ""),
						o &&
							(0 === o[0]
								? (this.visibility = "public")
								: 1 === o[0]
								? (this.visibility = "protected")
								: 2 === o[0] && (this.visibility = "private"));
				});
			},
			{ "./node": 85 },
		],
		118: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "traitprecedence";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.trait = t),
						(this.method = e),
						(this.instead = n);
				});
			},
			{ "./node": 85 },
		],
		119: [
			function (t, e, n) {
				"use strict";
				const i = t("./node"),
					r = "traituse";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.traits = t), (this.adaptations = e);
				});
			},
			{ "./node": 85 },
		],
		120: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement");
				e.exports = i.extends("try", function (t, e, n, r, o) {
					i.apply(this, ["try", r, o]),
						(this.body = t),
						(this.catches = e),
						(this.always = n);
				});
			},
			{ "./statement": 108 },
		],
		121: [
			function (t, e, n) {
				"use strict";
				const i = t("./reference"),
					r = "typereference",
					o = i.extends(r, function (t, e, n, o) {
						i.apply(this, [r, n, o]), (this.name = t), (this.raw = e);
					});
				(o.types = [
					"int",
					"float",
					"string",
					"bool",
					"object",
					"array",
					"callable",
					"iterable",
					"void",
				]),
					(e.exports = o);
			},
			{ "./reference": 103 },
		],
		122: [
			function (t, e, n) {
				"use strict";
				const i = t("./operation"),
					r = "unary";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.type = t), (this.what = e);
				});
			},
			{ "./operation": 92 },
		],
		123: [
			function (t, e, n) {
				"use strict";
				const i = t("./declaration"),
					r = "uniontype";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, null, e, n]), (this.types = t);
				});
			},
			{ "./declaration": 46 },
		],
		124: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "unset";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.variables = t);
				});
			},
			{ "./statement": 108 },
		],
		125: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "usegroup";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.name = t),
						(this.type = e),
						(this.items = n);
				});
			},
			{ "./statement": 108 },
		],
		126: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "useitem",
					o = i.extends(r, function (t, e, n, o, s) {
						i.apply(this, [r, o, s]),
							(this.name = t),
							(this.alias = e),
							(this.type = n);
					});
				(o.TYPE_CONST = "const"),
					(o.TYPE_FUNCTION = "function"),
					(e.exports = o);
			},
			{ "./statement": 108 },
		],
		127: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "variable";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.name = t), (this.curly = e || !1);
				});
			},
			{ "./expression": 58 },
		],
		128: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "variadic";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.what = t);
				});
			},
			{ "./expression": 58 },
		],
		129: [
			function (t, e, n) {
				"use strict";
				const i = t("./statement"),
					r = "while";
				e.exports = i.extends(r, function (t, e, n, o, s) {
					i.apply(this, [r, o, s]),
						(this.test = t),
						(this.body = e),
						(this.shortForm = n);
				});
			},
			{ "./statement": 108 },
		],
		130: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "yield";
				e.exports = i.extends(r, function (t, e, n, o) {
					i.apply(this, [r, n, o]), (this.value = t), (this.key = e);
				});
			},
			{ "./expression": 58 },
		],
		131: [
			function (t, e, n) {
				"use strict";
				const i = t("./expression"),
					r = "yieldfrom";
				e.exports = i.extends(r, function (t, e, n) {
					i.apply(this, [r, e, n]), (this.value = t);
				});
			},
			{ "./expression": 58 },
		],
		132: [
			function (t, e, n) {
				"use strict";
				const i = t("./lexer"),
					r = t("./parser"),
					o = t("./tokens"),
					s = t("./ast");
				function a(t, e) {
					const n = Object.keys(t);
					let i = n.length;
					for (; i--; ) {
						const r = n[i],
							o = t[r];
						null === o
							? delete e[r]
							: "function" == typeof o
							? (e[r] = o.bind(e))
							: Array.isArray(o)
							? (e[r] = Array.isArray(e[r]) ? e[r].concat(o) : o)
							: (e[r] =
									"object" == typeof o && "object" == typeof e[r]
										? a(o, e[r])
										: o);
					}
					return e;
				}
				const l = function (t) {
						if ("function" == typeof this) return new this(t);
						if (
							((this.tokens = o),
							(this.lexer = new i(this)),
							(this.ast = new s()),
							(this.parser = new r(this.lexer, this.ast)),
							t && "object" == typeof t)
						) {
							if (t.parser && (t.lexer || (t.lexer = {}), t.parser.version)) {
								if ("string" == typeof t.parser.version) {
									let e = t.parser.version.split(".");
									if (((e = 100 * parseInt(e[0]) + parseInt(e[1])), isNaN(e)))
										throw new Error("Bad version number : " + t.parser.version);
									t.parser.version = e;
								} else if ("number" != typeof t.parser.version)
									throw new Error("Expecting a number for version");
								if (t.parser.version < 500 || t.parser.version > 900)
									throw new Error(
										"Can only handle versions between 5.x to 8.x"
									);
							}
							a(t, this), (this.lexer.version = this.parser.version);
						}
					},
					c = function (t) {
						return "function" == typeof t.write ? t.toString() : t;
					};
				(l.create = function (t) {
					return new l(t);
				}),
					(l.parseEval = function (t, e) {
						return new l(e).parseEval(t);
					}),
					(l.prototype.parseEval = function (t) {
						return (
							(this.lexer.mode_eval = !0),
							(this.lexer.all_tokens = !1),
							(t = c(t)),
							this.parser.parse(t, "eval")
						);
					}),
					(l.parseCode = function (t, e, n) {
						"object" != typeof e || n || ((n = e), (e = "unknown"));
						return new l(n).parseCode(t, e);
					}),
					(l.prototype.parseCode = function (t, e) {
						return (
							(this.lexer.mode_eval = !1),
							(this.lexer.all_tokens = !1),
							(t = c(t)),
							this.parser.parse(t, e)
						);
					}),
					(l.tokenGetAll = function (t, e) {
						return new l(e).tokenGetAll(t);
					}),
					(l.prototype.tokenGetAll = function (t) {
						(this.lexer.mode_eval = !1),
							(this.lexer.all_tokens = !0),
							(t = c(t));
						const e = this.lexer.EOF,
							n = this.tokens.values;
						this.lexer.setInput(t);
						let i = this.lexer.lex() || e;
						const r = [];
						for (; i != e; ) {
							let t = this.lexer.yytext;
							n.hasOwnProperty(i) &&
								(t = [n[i], t, this.lexer.yylloc.first_line]),
								r.push(t),
								(i = this.lexer.lex() || e);
						}
						return r;
					}),
					(e.exports = l),
					(e.exports.tokens = o),
					(e.exports.lexer = i),
					(e.exports.AST = s),
					(e.exports.parser = r),
					(e.exports.combine = a),
					(e.exports.default = l);
			},
			{ "./ast": 20, "./lexer": 133, "./parser": 143, "./tokens": 159 },
		],
		133: [
			function (t, e, n) {
				"use strict";
				const i = function (t) {
					(this.engine = t),
						(this.tok = this.engine.tokens.names),
						(this.EOF = 1),
						(this.debug = !1),
						(this.all_tokens = !0),
						(this.comment_tokens = !1),
						(this.mode_eval = !1),
						(this.asp_tags = !1),
						(this.short_tags = !1),
						(this.version = 800),
						(this.yyprevcol = 0),
						(this.keywords = {
							__class__: this.tok.T_CLASS_C,
							__trait__: this.tok.T_TRAIT_C,
							__function__: this.tok.T_FUNC_C,
							__method__: this.tok.T_METHOD_C,
							__line__: this.tok.T_LINE,
							__file__: this.tok.T_FILE,
							__dir__: this.tok.T_DIR,
							__namespace__: this.tok.T_NS_C,
							exit: this.tok.T_EXIT,
							die: this.tok.T_EXIT,
							function: this.tok.T_FUNCTION,
							const: this.tok.T_CONST,
							return: this.tok.T_RETURN,
							try: this.tok.T_TRY,
							catch: this.tok.T_CATCH,
							finally: this.tok.T_FINALLY,
							throw: this.tok.T_THROW,
							if: this.tok.T_IF,
							elseif: this.tok.T_ELSEIF,
							endif: this.tok.T_ENDIF,
							else: this.tok.T_ELSE,
							while: this.tok.T_WHILE,
							endwhile: this.tok.T_ENDWHILE,
							do: this.tok.T_DO,
							for: this.tok.T_FOR,
							endfor: this.tok.T_ENDFOR,
							foreach: this.tok.T_FOREACH,
							endforeach: this.tok.T_ENDFOREACH,
							declare: this.tok.T_DECLARE,
							enddeclare: this.tok.T_ENDDECLARE,
							instanceof: this.tok.T_INSTANCEOF,
							as: this.tok.T_AS,
							switch: this.tok.T_SWITCH,
							endswitch: this.tok.T_ENDSWITCH,
							case: this.tok.T_CASE,
							default: this.tok.T_DEFAULT,
							break: this.tok.T_BREAK,
							continue: this.tok.T_CONTINUE,
							goto: this.tok.T_GOTO,
							echo: this.tok.T_ECHO,
							print: this.tok.T_PRINT,
							class: this.tok.T_CLASS,
							interface: this.tok.T_INTERFACE,
							trait: this.tok.T_TRAIT,
							extends: this.tok.T_EXTENDS,
							implements: this.tok.T_IMPLEMENTS,
							new: this.tok.T_NEW,
							clone: this.tok.T_CLONE,
							var: this.tok.T_VAR,
							eval: this.tok.T_EVAL,
							include: this.tok.T_INCLUDE,
							include_once: this.tok.T_INCLUDE_ONCE,
							require: this.tok.T_REQUIRE,
							require_once: this.tok.T_REQUIRE_ONCE,
							namespace: this.tok.T_NAMESPACE,
							use: this.tok.T_USE,
							insteadof: this.tok.T_INSTEADOF,
							global: this.tok.T_GLOBAL,
							isset: this.tok.T_ISSET,
							empty: this.tok.T_EMPTY,
							__halt_compiler: this.tok.T_HALT_COMPILER,
							static: this.tok.T_STATIC,
							abstract: this.tok.T_ABSTRACT,
							final: this.tok.T_FINAL,
							private: this.tok.T_PRIVATE,
							protected: this.tok.T_PROTECTED,
							public: this.tok.T_PUBLIC,
							unset: this.tok.T_UNSET,
							list: this.tok.T_LIST,
							array: this.tok.T_ARRAY,
							callable: this.tok.T_CALLABLE,
							or: this.tok.T_LOGICAL_OR,
							and: this.tok.T_LOGICAL_AND,
							xor: this.tok.T_LOGICAL_XOR,
							match: this.tok.T_MATCH,
						}),
						(this.castKeywords = {
							int: this.tok.T_INT_CAST,
							integer: this.tok.T_INT_CAST,
							real: this.tok.T_DOUBLE_CAST,
							double: this.tok.T_DOUBLE_CAST,
							float: this.tok.T_DOUBLE_CAST,
							string: this.tok.T_STRING_CAST,
							binary: this.tok.T_STRING_CAST,
							array: this.tok.T_ARRAY_CAST,
							object: this.tok.T_OBJECT_CAST,
							bool: this.tok.T_BOOL_CAST,
							boolean: this.tok.T_BOOL_CAST,
							unset: this.tok.T_UNSET_CAST,
						});
				};
				(i.prototype.setInput = function (t) {
					return (
						(this._input = t),
						(this.size = t.length),
						(this.yylineno = 1),
						(this.offset = 0),
						(this.yyprevcol = 0),
						(this.yytext = ""),
						(this.yylloc = {
							first_offset: 0,
							first_line: 1,
							first_column: 0,
							prev_offset: 0,
							prev_line: 1,
							prev_column: 0,
							last_line: 1,
							last_column: 0,
						}),
						(this.tokens = []),
						this.version > 703
							? (this.keywords.fn = this.tok.T_FN)
							: delete this.keywords.fn,
						(this.done = this.offset >= this.size),
						!this.all_tokens && this.mode_eval
							? ((this.conditionStack = ["INITIAL"]),
							  this.begin("ST_IN_SCRIPTING"))
							: ((this.conditionStack = []), this.begin("INITIAL")),
						(this.heredoc_label = {
							label: "",
							length: 0,
							indentation: 0,
							indentation_uses_spaces: !1,
							finished: !1,
							first_encaps_node: !1,
							toString: function () {
								this.label;
							},
						}),
						this
					);
				}),
					(i.prototype.input = function () {
						const t = this._input[this.offset];
						return t
							? ((this.yytext += t),
							  this.offset++,
							  "\r" === t &&
									"\n" === this._input[this.offset] &&
									((this.yytext += "\n"), this.offset++),
							  "\n" === t || "\r" === t
									? ((this.yylloc.last_line = ++this.yylineno),
									  (this.yyprevcol = this.yylloc.last_column),
									  (this.yylloc.last_column = 0))
									: this.yylloc.last_column++,
							  t)
							: "";
					}),
					(i.prototype.unput = function (t) {
						if (1 === t)
							this.offset--,
								"\n" === this._input[this.offset] &&
									"\r" === this._input[this.offset - 1] &&
									(this.offset--, t++),
								"\r" === this._input[this.offset] ||
								"\n" === this._input[this.offset]
									? (this.yylloc.last_line--,
									  this.yylineno--,
									  (this.yylloc.last_column = this.yyprevcol))
									: this.yylloc.last_column--,
								(this.yytext = this.yytext.substring(
									0,
									this.yytext.length - t
								));
						else if (t > 0)
							if (((this.offset -= t), t < this.yytext.length)) {
								(this.yytext = this.yytext.substring(
									0,
									this.yytext.length - t
								)),
									(this.yylloc.last_line = this.yylloc.first_line),
									(this.yylloc.last_column = this.yyprevcol =
										this.yylloc.first_column);
								for (let t = 0; t < this.yytext.length; t++) {
									let e = this.yytext[t];
									"\r" === e
										? ((e = this.yytext[++t]),
										  (this.yyprevcol = this.yylloc.last_column),
										  this.yylloc.last_line++,
										  (this.yylloc.last_column = 0),
										  "\n" !== e &&
												("\r" === e
													? this.yylloc.last_line++
													: this.yylloc.last_column++))
										: "\n" === e
										? ((this.yyprevcol = this.yylloc.last_column),
										  this.yylloc.last_line++,
										  (this.yylloc.last_column = 0))
										: this.yylloc.last_column++;
								}
								this.yylineno = this.yylloc.last_line;
							} else
								(this.yytext = ""),
									(this.yylloc.last_line = this.yylineno =
										this.yylloc.first_line),
									(this.yylloc.last_column = this.yylloc.first_column);
						return this;
					}),
					(i.prototype.tryMatch = function (t) {
						return t === this.ahead(t.length);
					}),
					(i.prototype.tryMatchCaseless = function (t) {
						return t === this.ahead(t.length).toLowerCase();
					}),
					(i.prototype.ahead = function (t) {
						let e = this._input.substring(this.offset, this.offset + t);
						return (
							"\r" === e[e.length - 1] &&
								"\n" === this._input[this.offset + t + 1] &&
								(e += "\n"),
							e
						);
					}),
					(i.prototype.consume = function (t) {
						for (let e = 0; e < t; e++) {
							const t = this._input[this.offset];
							if (!t) break;
							(this.yytext += t),
								this.offset++,
								"\r" === t &&
									"\n" === this._input[this.offset] &&
									((this.yytext += "\n"), this.offset++, e++),
								"\n" === t || "\r" === t
									? ((this.yylloc.last_line = ++this.yylineno),
									  (this.yyprevcol = this.yylloc.last_column),
									  (this.yylloc.last_column = 0))
									: this.yylloc.last_column++;
						}
						return this;
					}),
					(i.prototype.getState = function () {
						return {
							yytext: this.yytext,
							offset: this.offset,
							yylineno: this.yylineno,
							yyprevcol: this.yyprevcol,
							yylloc: {
								first_offset: this.yylloc.first_offset,
								first_line: this.yylloc.first_line,
								first_column: this.yylloc.first_column,
								last_line: this.yylloc.last_line,
								last_column: this.yylloc.last_column,
							},
							heredoc_label: this.heredoc_label,
						};
					}),
					(i.prototype.setState = function (t) {
						return (
							(this.yytext = t.yytext),
							(this.offset = t.offset),
							(this.yylineno = t.yylineno),
							(this.yyprevcol = t.yyprevcol),
							(this.yylloc = t.yylloc),
							t.heredoc_label && (this.heredoc_label = t.heredoc_label),
							this
						);
					}),
					(i.prototype.appendToken = function (t, e) {
						return this.tokens.push([t, e]), this;
					}),
					(i.prototype.lex = function () {
						(this.yylloc.prev_offset = this.offset),
							(this.yylloc.prev_line = this.yylloc.last_line),
							(this.yylloc.prev_column = this.yylloc.last_column);
						let t = this.next() || this.lex();
						if (!this.all_tokens) {
							for (
								;
								t === this.tok.T_WHITESPACE ||
								(!this.comment_tokens &&
									(t === this.tok.T_COMMENT || t === this.tok.T_DOC_COMMENT)) ||
								t === this.tok.T_OPEN_TAG;

							)
								t = this.next() || this.lex();
							if (t == this.tok.T_OPEN_TAG_WITH_ECHO) return this.tok.T_ECHO;
							if (t === this.tok.T_CLOSE_TAG) return ";";
						}
						return (
							this.yylloc.prev_offset ||
								((this.yylloc.prev_offset = this.yylloc.first_offset),
								(this.yylloc.prev_line = this.yylloc.first_line),
								(this.yylloc.prev_column = this.yylloc.first_column)),
							t
						);
					}),
					(i.prototype.begin = function (t) {
						if (
							(this.conditionStack.push(t),
							(this.curCondition = t),
							(this.stateCb = this["match" + t]),
							"function" != typeof this.stateCb)
						)
							throw new Error('Undefined condition state "' + t + '"');
						return this;
					}),
					(i.prototype.popState = function () {
						const t =
							this.conditionStack.length - 1 > 0
								? this.conditionStack.pop()
								: this.conditionStack[0];
						if (
							((this.curCondition =
								this.conditionStack[this.conditionStack.length - 1]),
							(this.stateCb = this["match" + this.curCondition]),
							"function" != typeof this.stateCb)
						)
							throw new Error(
								'Undefined condition state "' + this.curCondition + '"'
							);
						return t;
					}),
					(i.prototype.next = function () {
						let t;
						if (
							(this._input || (this.done = !0),
							(this.yylloc.first_offset = this.offset),
							(this.yylloc.first_line = this.yylloc.last_line),
							(this.yylloc.first_column = this.yylloc.last_column),
							(this.yytext = ""),
							this.done)
						)
							return (
								(this.yylloc.prev_offset = this.yylloc.first_offset),
								(this.yylloc.prev_line = this.yylloc.first_line),
								(this.yylloc.prev_column = this.yylloc.first_column),
								this.EOF
							);
						if (
							(this.tokens.length > 0
								? ((t = this.tokens.shift()),
								  "object" == typeof t[1]
										? this.setState(t[1])
										: this.consume(t[1]),
								  (t = t[0]))
								: (t = this.stateCb.apply(this, [])),
							this.offset >= this.size &&
								0 === this.tokens.length &&
								(this.done = !0),
							this.debug)
						) {
							let e = t;
							e =
								"number" == typeof e
									? this.engine.tokens.values[e]
									: '"' + e + '"';
							const n = new Error(
								e +
									"\tfrom " +
									this.yylloc.first_line +
									"," +
									this.yylloc.first_column +
									"\t - to " +
									this.yylloc.last_line +
									"," +
									this.yylloc.last_column +
									'\t"' +
									this.yytext +
									'"'
							);
							console.error(n.stack);
						}
						return t;
					}),
					[
						t("./lexer/attribute.js"),
						t("./lexer/comments.js"),
						t("./lexer/initial.js"),
						t("./lexer/numbers.js"),
						t("./lexer/property.js"),
						t("./lexer/scripting.js"),
						t("./lexer/strings.js"),
						t("./lexer/tokens.js"),
						t("./lexer/utils.js"),
					].forEach(function (t) {
						for (const e in t) i.prototype[e] = t[e];
					}),
					(e.exports = i);
			},
			{
				"./lexer/attribute.js": 134,
				"./lexer/comments.js": 135,
				"./lexer/initial.js": 136,
				"./lexer/numbers.js": 137,
				"./lexer/property.js": 138,
				"./lexer/scripting.js": 139,
				"./lexer/strings.js": 140,
				"./lexer/tokens.js": 141,
				"./lexer/utils.js": 142,
			},
		],
		134: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					matchST_ATTRIBUTE: function () {
						let t = 0,
							e = this.input();
						if (this.is_WHITESPACE()) {
							do {
								e = this.input();
							} while (this.is_WHITESPACE());
							return this.unput(1), null;
						}
						switch (e) {
							case "]":
								return 0 === t ? this.popState() : t--, "]";
							case "(":
							case ")":
							case ":":
							case "=":
								return this.consume_TOKEN();
							case "[":
								return t++, "[";
							case ",":
								return ",";
							case '"':
								return this.ST_DOUBLE_QUOTES();
							case "'":
								return this.T_CONSTANT_ENCAPSED_STRING();
							case "/":
								if ("/" === this._input[this.offset]) return this.T_COMMENT();
								if ("*" === this._input[this.offset])
									return this.input(), this.T_DOC_COMMENT();
						}
						if (this.is_LABEL_START() || "\\" === e) {
							for (; this.offset < this.size; ) {
								const t = this.input();
								if (!this.is_LABEL() && "\\" !== t) {
									t && this.unput(1);
									break;
								}
							}
							return this.tok.T_STRING;
						}
						if (this.is_NUM()) return this.consume_NUM();
						throw new Error(
							`Bad terminal sequence "${e}" at line ${this.yylineno} (offset ${this.offset})`
						);
					},
				};
			},
			{},
		],
		135: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					T_COMMENT: function () {
						for (; this.offset < this.size; ) {
							const t = this.input();
							if ("\n" === t || "\r" === t) return this.tok.T_COMMENT;
							if (
								"?" === t &&
								!this.aspTagMode &&
								">" === this._input[this.offset]
							)
								return this.unput(1), this.tok.T_COMMENT;
							if (
								"%" === t &&
								this.aspTagMode &&
								">" === this._input[this.offset]
							)
								return this.unput(1), this.tok.T_COMMENT;
						}
						return this.tok.T_COMMENT;
					},
					T_DOC_COMMENT: function () {
						let t = this.input(),
							e = this.tok.T_COMMENT;
						if ("*" === t) {
							if (
								((t = this.input()),
								this.is_WHITESPACE() && (e = this.tok.T_DOC_COMMENT),
								"/" === t)
							)
								return e;
							this.unput(1);
						}
						for (; this.offset < this.size; )
							if (
								((t = this.input()),
								"*" === t && "/" === this._input[this.offset])
							) {
								this.input();
								break;
							}
						return e;
					},
				};
			},
			{},
		],
		136: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					nextINITIAL: function () {
						return (
							this.conditionStack.length > 1 &&
							"INITIAL" === this.conditionStack[this.conditionStack.length - 1]
								? this.popState()
								: this.begin("ST_IN_SCRIPTING"),
							this
						);
					},
					matchINITIAL: function () {
						for (; this.offset < this.size; ) {
							let t = this.input();
							if ("<" == t)
								if (((t = this.ahead(1)), "?" == t)) {
									if (this.tryMatch("?=")) {
										this.unput(1)
											.appendToken(this.tok.T_OPEN_TAG_WITH_ECHO, 3)
											.nextINITIAL();
										break;
									}
									if (
										this.tryMatchCaseless("?php") &&
										((t = this._input[this.offset + 4]),
										" " === t || "\t" === t || "\n" === t || "\r" === t)
									) {
										this.unput(1)
											.appendToken(this.tok.T_OPEN_TAG, 6)
											.nextINITIAL();
										break;
									}
									if (this.short_tags) {
										this.unput(1)
											.appendToken(this.tok.T_OPEN_TAG, 2)
											.nextINITIAL();
										break;
									}
								} else if (this.asp_tags && "%" == t) {
									if (this.tryMatch("%=")) {
										(this.aspTagMode = !0),
											this.unput(1)
												.appendToken(this.tok.T_OPEN_TAG_WITH_ECHO, 3)
												.nextINITIAL();
										break;
									}
									(this.aspTagMode = !0),
										this.unput(1)
											.appendToken(this.tok.T_OPEN_TAG, 2)
											.nextINITIAL();
									break;
								}
						}
						return this.yytext.length > 0 && this.tok.T_INLINE_HTML;
					},
				};
			},
			{},
		],
		137: [
			function (t, e, n) {
				(function (t) {
					(function () {
						"use strict";
						let n = 10,
							i = "2147483648";
						"x64" == t.arch && ((n = 19), (i = "9223372036854775808")),
							(e.exports = {
								consume_NUM: function () {
									let t = this.yytext[0],
										e = "." === t;
									if ("0" === t)
										if (((t = this.input()), "x" === t || "X" === t)) {
											if (((t = this.input()), "_" !== t && this.is_HEX()))
												return this.consume_HNUM();
											this.unput(t ? 2 : 1);
										} else if ("b" === t || "B" === t) {
											if (
												((t = this.input()),
												("_" !== t && "0" === t) || "1" === t)
											)
												return this.consume_BNUM();
											this.unput(t ? 2 : 1);
										} else this.is_NUM() || (t && this.unput(1));
									for (; this.offset < this.size; ) {
										const n = t;
										if (((t = this.input()), "_" === t)) {
											if ("_" === n) {
												this.unput(2);
												break;
											}
											if ("." === n) {
												this.unput(1);
												break;
											}
											if ("e" === n || "E" === n) {
												this.unput(2);
												break;
											}
										} else {
											if ("." === t) {
												if (e) {
													this.unput(1);
													break;
												}
												if ("_" === n) {
													this.unput(2);
													break;
												}
												e = !0;
												continue;
											}
											if ("e" === t || "E" === t) {
												if ("_" === n) {
													this.unput(1);
													break;
												}
												let e = 2;
												if (
													((t = this.input()),
													("+" !== t && "-" !== t) ||
														((e = 3), (t = this.input())),
													this.is_NUM_START())
												)
													return this.consume_LNUM(), this.tok.T_DNUMBER;
												this.unput(t ? e : e - 1);
												break;
											}
										}
										if (!this.is_NUM()) {
											t && this.unput(1);
											break;
										}
									}
									return e
										? this.tok.T_DNUMBER
										: this.yytext.length < n - 1 ||
										  this.yytext.length < n ||
										  (this.yytext.length == n && this.yytext < i)
										? this.tok.T_LNUMBER
										: this.tok.T_DNUMBER;
								},
								consume_HNUM: function () {
									for (; this.offset < this.size; ) {
										const t = this.input();
										if (!this.is_HEX()) {
											t && this.unput(1);
											break;
										}
									}
									return this.tok.T_LNUMBER;
								},
								consume_LNUM: function () {
									for (; this.offset < this.size; ) {
										const t = this.input();
										if (!this.is_NUM()) {
											t && this.unput(1);
											break;
										}
									}
									return this.tok.T_LNUMBER;
								},
								consume_BNUM: function () {
									let t;
									for (; this.offset < this.size; )
										if (
											((t = this.input()), "0" !== t && "1" !== t && "_" !== t)
										) {
											t && this.unput(1);
											break;
										}
									return this.tok.T_LNUMBER;
								},
							});
					}.call(this));
				}.call(this, t("_process")));
			},
			{ _process: 160 },
		],
		138: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					matchST_LOOKING_FOR_PROPERTY: function () {
						let t = this.input();
						if ("-" === t) {
							if (((t = this.input()), ">" === t))
								return this.tok.T_OBJECT_OPERATOR;
							t && this.unput(1);
						} else {
							if (this.is_WHITESPACE()) return this.tok.T_WHITESPACE;
							if (this.is_LABEL_START())
								return this.consume_LABEL(), this.popState(), this.tok.T_STRING;
						}
						return this.popState(), t && this.unput(1), !1;
					},
					matchST_LOOKING_FOR_VARNAME: function () {
						let t = this.input();
						if (
							(this.popState(),
							this.begin("ST_IN_SCRIPTING"),
							this.is_LABEL_START())
						) {
							if (
								(this.consume_LABEL(),
								(t = this.input()),
								"[" === t || "}" === t)
							)
								return this.unput(1), this.tok.T_STRING_VARNAME;
							this.unput(this.yytext.length);
						} else t && this.unput(1);
						return !1;
					},
					matchST_VAR_OFFSET: function () {
						const t = this.input();
						if (this.is_NUM_START())
							return this.consume_NUM(), this.tok.T_NUM_STRING;
						if ("]" === t) return this.popState(), "]";
						if ("$" === t) {
							if ((this.input(), this.is_LABEL_START()))
								return this.consume_LABEL(), this.tok.T_VARIABLE;
							throw new Error("Unexpected terminal");
						}
						if (this.is_LABEL_START())
							return this.consume_LABEL(), this.tok.T_STRING;
						if (this.is_WHITESPACE() || "\\" === t || "'" === t || "#" === t)
							return this.tok.T_ENCAPSED_AND_WHITESPACE;
						if (
							"[" === t ||
							"{" === t ||
							"}" === t ||
							'"' === t ||
							"`" === t ||
							this.is_TOKEN()
						)
							return t;
						throw new Error("Unexpected terminal");
					},
				};
			},
			{},
		],
		139: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					matchST_IN_SCRIPTING: function () {
						let t = this.input();
						switch (t) {
							case " ":
							case "\t":
							case "\n":
							case "\r":
							case "\r\n":
								return this.T_WHITESPACE();
							case "#":
								return "[" === this._input[this.offset]
									? (this.input(),
									  this.begin("ST_ATTRIBUTE"),
									  this.tok.T_ATTRIBUTE)
									: this.T_COMMENT();
							case "/":
								return "/" === this._input[this.offset]
									? this.T_COMMENT()
									: "*" === this._input[this.offset]
									? (this.input(), this.T_DOC_COMMENT())
									: this.consume_TOKEN();
							case "'":
								return this.T_CONSTANT_ENCAPSED_STRING();
							case '"':
								return this.ST_DOUBLE_QUOTES();
							case "`":
								return this.begin("ST_BACKQUOTE"), "`";
							case "?":
								if (!this.aspTagMode && this.tryMatch(">")) {
									this.input();
									const t = this._input[this.offset];
									return (
										("\n" !== t && "\r" !== t) || this.input(),
										this.conditionStack.length > 1 && this.begin("INITIAL"),
										this.tok.T_CLOSE_TAG
									);
								}
								return this.consume_TOKEN();
							case "%":
								return this.aspTagMode && ">" === this._input[this.offset]
									? (this.input(),
									  (t = this._input[this.offset]),
									  ("\n" !== t && "\r" !== t) || this.input(),
									  (this.aspTagMode = !1),
									  this.conditionStack.length > 1 && this.begin("INITIAL"),
									  this.tok.T_CLOSE_TAG)
									: this.consume_TOKEN();
							case "{":
								return this.begin("ST_IN_SCRIPTING"), "{";
							case "}":
								return this.conditionStack.length > 2 && this.popState(), "}";
							default:
								if ("." === t) {
									if (((t = this.input()), this.is_NUM_START()))
										return this.consume_NUM();
									t && this.unput(1);
								}
								if (this.is_NUM_START()) return this.consume_NUM();
								if (this.is_LABEL_START())
									return this.consume_LABEL().T_STRING();
								if (this.is_TOKEN()) return this.consume_TOKEN();
						}
						throw new Error(
							'Bad terminal sequence "' +
								t +
								'" at line ' +
								this.yylineno +
								" (offset " +
								this.offset +
								")"
						);
					},
					T_WHITESPACE: function () {
						for (; this.offset < this.size; ) {
							const t = this.input();
							if (" " !== t && "\t" !== t && "\n" !== t && "\r" !== t) {
								t && this.unput(1);
								break;
							}
						}
						return this.tok.T_WHITESPACE;
					},
				};
			},
			{},
		],
		140: [
			function (t, e, n) {
				"use strict";
				const i = ["\n", "\r"],
					r = ["\n", "\r", ";"],
					o = r.concat(["\t", " ", ",", "]", ")", "/", "=", "!"]);
				e.exports = {
					T_CONSTANT_ENCAPSED_STRING: function () {
						let t;
						for (; this.offset < this.size; )
							if (((t = this.input()), "\\" == t)) this.input();
							else if ("'" == t) break;
						return this.tok.T_CONSTANT_ENCAPSED_STRING;
					},
					is_HEREDOC: function () {
						const t = this.offset;
						if (
							"<" === this._input[this.offset - 1] &&
							"<" === this._input[this.offset] &&
							"<" === this._input[this.offset + 1]
						) {
							if (((this.offset += 3), this.is_TABSPACE()))
								for (
									;
									this.offset < this.size &&
									(this.offset++, this.is_TABSPACE());

								);
							let e = this._input[this.offset - 1];
							if (
								("'" === e || '"' === e ? this.offset++ : (e = null),
								this.is_LABEL_START())
							) {
								let n = this.offset - 1;
								for (
									;
									this.offset < this.size && (this.offset++, this.is_LABEL());

								);
								const r = this._input.substring(n, this.offset - 1);
								if (
									(!e || e === this._input[this.offset - 1]) &&
									(e && this.offset++, i.includes(this._input[this.offset - 1]))
								)
									return (
										(this.heredoc_label.label = r),
										(this.heredoc_label.length = r.length),
										(this.heredoc_label.finished = !1),
										(n = this.offset - t),
										(this.offset = t),
										this.consume(n),
										"'" === e
											? this.begin("ST_NOWDOC")
											: this.begin("ST_HEREDOC"),
										this.prematch_ENDOFDOC(),
										this.tok.T_START_HEREDOC
									);
							}
						}
						return (this.offset = t), !1;
					},
					ST_DOUBLE_QUOTES: function () {
						let t;
						for (; this.offset < this.size; )
							if (((t = this.input()), "\\" == t)) this.input();
							else {
								if ('"' == t) break;
								if ("$" == t) {
									if (((t = this.input()), "{" == t || this.is_LABEL_START())) {
										this.unput(2);
										break;
									}
									t && this.unput(1);
								} else if ("{" == t) {
									if (((t = this.input()), "$" == t)) {
										this.unput(2);
										break;
									}
									t && this.unput(1);
								}
							}
						if ('"' == t) return this.tok.T_CONSTANT_ENCAPSED_STRING;
						{
							let t = 1;
							return (
								("b" !== this.yytext[0] && "B" !== this.yytext[0]) || (t = 2),
								this.yytext.length > 2 &&
									this.appendToken(
										this.tok.T_ENCAPSED_AND_WHITESPACE,
										this.yytext.length - t
									),
								this.unput(this.yytext.length - t),
								this.begin("ST_DOUBLE_QUOTES"),
								this.yytext
							);
						}
					},
					isDOC_MATCH: function (t, e) {
						const n = this._input[t - 2];
						if (!i.includes(n)) return !1;
						let s = !1,
							a = !1,
							l = 0,
							c = this._input[t - 1];
						if (this.version >= 703) {
							for (; "\t" === c || " " === c; )
								" " === c ? (s = !0) : "\t" === c && (a = !0),
									(c = this._input[t + l]),
									l++;
							if (((t += l), i.includes(this._input[t - 1]))) return !1;
						}
						if (
							this._input.substring(
								t - 1,
								t - 1 + this.heredoc_label.length
							) === this.heredoc_label.label
						) {
							const n = this._input[t - 1 + this.heredoc_label.length];
							if ((this.version >= 703 ? o : r).includes(n)) {
								if (e) {
									if ((this.consume(l), s && a))
										throw new Error(
											"Parse error:  mixing spaces and tabs in ending marker at line " +
												this.yylineno +
												" (offset " +
												this.offset +
												")"
										);
								} else
									(this.heredoc_label.indentation = l),
										(this.heredoc_label.indentation_uses_spaces = s),
										(this.heredoc_label.first_encaps_node = !0);
								return !0;
							}
						}
						return !1;
					},
					prematch_ENDOFDOC: function () {
						(this.heredoc_label.indentation_uses_spaces = !1),
							(this.heredoc_label.indentation = 0),
							(this.heredoc_label.first_encaps_node = !0);
						let t = this.offset + 1;
						for (; t < this._input.length; ) {
							if (this.isDOC_MATCH(t, !1)) return;
							if (!i.includes(this._input[t - 1]))
								for (
									;
									!i.includes(this._input[t++]) && t < this._input.length;

								);
							t++;
						}
					},
					matchST_NOWDOC: function () {
						if (this.isDOC_MATCH(this.offset, !0))
							return (
								this.consume(this.heredoc_label.length),
								this.popState(),
								this.tok.T_END_HEREDOC
							);
						let t = this._input[this.offset - 1];
						for (; this.offset < this.size; )
							if (i.includes(t)) {
								if (((t = this.input()), this.isDOC_MATCH(this.offset, !0)))
									return (
										this.unput(1).popState(),
										this.appendToken(
											this.tok.T_END_HEREDOC,
											this.heredoc_label.length
										),
										this.tok.T_ENCAPSED_AND_WHITESPACE
									);
							} else t = this.input();
						return this.tok.T_ENCAPSED_AND_WHITESPACE;
					},
					matchST_HEREDOC: function () {
						let t = this.input();
						if (this.isDOC_MATCH(this.offset, !0))
							return (
								this.consume(this.heredoc_label.length - 1),
								this.popState(),
								this.tok.T_END_HEREDOC
							);
						for (; this.offset < this.size; )
							if (
								("\\" === t &&
									((t = this.input()), i.includes(t) || (t = this.input())),
								i.includes(t))
							) {
								if (((t = this.input()), this.isDOC_MATCH(this.offset, !0)))
									return (
										this.unput(1).popState(),
										this.appendToken(
											this.tok.T_END_HEREDOC,
											this.heredoc_label.length
										),
										this.tok.T_ENCAPSED_AND_WHITESPACE
									);
							} else if ("$" === t) {
								if (((t = this.input()), "{" === t))
									return (
										this.begin("ST_LOOKING_FOR_VARNAME"),
										this.yytext.length > 2
											? (this.appendToken(
													this.tok.T_DOLLAR_OPEN_CURLY_BRACES,
													2
											  ),
											  this.unput(2),
											  this.tok.T_ENCAPSED_AND_WHITESPACE)
											: this.tok.T_DOLLAR_OPEN_CURLY_BRACES
									);
								if (this.is_LABEL_START()) {
									const t = this.offset,
										e = this.consume_VARIABLE();
									return this.yytext.length > this.offset - t + 2
										? (this.appendToken(e, this.offset - t + 2),
										  this.unput(this.offset - t + 2),
										  this.tok.T_ENCAPSED_AND_WHITESPACE)
										: e;
								}
							} else if ("{" === t) {
								if (((t = this.input()), "$" === t))
									return (
										this.begin("ST_IN_SCRIPTING"),
										this.yytext.length > 2
											? (this.appendToken(this.tok.T_CURLY_OPEN, 1),
											  this.unput(2),
											  this.tok.T_ENCAPSED_AND_WHITESPACE)
											: (this.unput(1), this.tok.T_CURLY_OPEN)
									);
							} else t = this.input();
						return this.tok.T_ENCAPSED_AND_WHITESPACE;
					},
					consume_VARIABLE: function () {
						this.consume_LABEL();
						const t = this.input();
						if ("[" == t)
							return (
								this.unput(1), this.begin("ST_VAR_OFFSET"), this.tok.T_VARIABLE
							);
						if ("-" === t) {
							if (">" === this.input())
								return (
									this.input(),
									this.is_LABEL_START() &&
										this.begin("ST_LOOKING_FOR_PROPERTY"),
									this.unput(3),
									this.tok.T_VARIABLE
								);
							this.unput(2);
						} else t && this.unput(1);
						return this.tok.T_VARIABLE;
					},
					matchST_BACKQUOTE: function () {
						let t = this.input();
						if ("$" === t) {
							if (((t = this.input()), "{" === t))
								return (
									this.begin("ST_LOOKING_FOR_VARNAME"),
									this.tok.T_DOLLAR_OPEN_CURLY_BRACES
								);
							if (this.is_LABEL_START()) {
								return this.consume_VARIABLE();
							}
						} else if ("{" === t) {
							if ("$" === this._input[this.offset])
								return this.begin("ST_IN_SCRIPTING"), this.tok.T_CURLY_OPEN;
						} else if ("`" === t) return this.popState(), "`";
						for (; this.offset < this.size; ) {
							if ("\\" === t) this.input();
							else {
								if ("`" === t) {
									this.unput(1), this.popState(), this.appendToken("`", 1);
									break;
								}
								if ("$" === t) {
									if (((t = this.input()), "{" === t))
										return (
											this.begin("ST_LOOKING_FOR_VARNAME"),
											this.yytext.length > 2
												? (this.appendToken(
														this.tok.T_DOLLAR_OPEN_CURLY_BRACES,
														2
												  ),
												  this.unput(2),
												  this.tok.T_ENCAPSED_AND_WHITESPACE)
												: this.tok.T_DOLLAR_OPEN_CURLY_BRACES
										);
									if (this.is_LABEL_START()) {
										const t = this.offset,
											e = this.consume_VARIABLE();
										return this.yytext.length > this.offset - t + 2
											? (this.appendToken(e, this.offset - t + 2),
											  this.unput(this.offset - t + 2),
											  this.tok.T_ENCAPSED_AND_WHITESPACE)
											: e;
									}
									continue;
								}
								if ("{" === t) {
									if (((t = this.input()), "$" === t))
										return (
											this.begin("ST_IN_SCRIPTING"),
											this.yytext.length > 2
												? (this.appendToken(this.tok.T_CURLY_OPEN, 1),
												  this.unput(2),
												  this.tok.T_ENCAPSED_AND_WHITESPACE)
												: (this.unput(1), this.tok.T_CURLY_OPEN)
										);
									continue;
								}
							}
							t = this.input();
						}
						return this.tok.T_ENCAPSED_AND_WHITESPACE;
					},
					matchST_DOUBLE_QUOTES: function () {
						let t = this.input();
						if ("$" === t) {
							if (((t = this.input()), "{" === t))
								return (
									this.begin("ST_LOOKING_FOR_VARNAME"),
									this.tok.T_DOLLAR_OPEN_CURLY_BRACES
								);
							if (this.is_LABEL_START()) {
								return this.consume_VARIABLE();
							}
						} else if ("{" === t) {
							if ("$" === this._input[this.offset])
								return this.begin("ST_IN_SCRIPTING"), this.tok.T_CURLY_OPEN;
						} else if ('"' === t) return this.popState(), '"';
						for (; this.offset < this.size; ) {
							if ("\\" === t) this.input();
							else {
								if ('"' === t) {
									this.unput(1), this.popState(), this.appendToken('"', 1);
									break;
								}
								if ("$" === t) {
									if (((t = this.input()), "{" === t))
										return (
											this.begin("ST_LOOKING_FOR_VARNAME"),
											this.yytext.length > 2
												? (this.appendToken(
														this.tok.T_DOLLAR_OPEN_CURLY_BRACES,
														2
												  ),
												  this.unput(2),
												  this.tok.T_ENCAPSED_AND_WHITESPACE)
												: this.tok.T_DOLLAR_OPEN_CURLY_BRACES
										);
									if (this.is_LABEL_START()) {
										const t = this.offset,
											e = this.consume_VARIABLE();
										return this.yytext.length > this.offset - t + 2
											? (this.appendToken(e, this.offset - t + 2),
											  this.unput(this.offset - t + 2),
											  this.tok.T_ENCAPSED_AND_WHITESPACE)
											: e;
									}
									t && this.unput(1);
								} else if ("{" === t) {
									if (((t = this.input()), "$" === t))
										return (
											this.begin("ST_IN_SCRIPTING"),
											this.yytext.length > 2
												? (this.appendToken(this.tok.T_CURLY_OPEN, 1),
												  this.unput(2),
												  this.tok.T_ENCAPSED_AND_WHITESPACE)
												: (this.unput(1), this.tok.T_CURLY_OPEN)
										);
									t && this.unput(1);
								}
							}
							t = this.input();
						}
						return this.tok.T_ENCAPSED_AND_WHITESPACE;
					},
				};
			},
			{},
		],
		141: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					T_STRING: function () {
						const t = this.yytext.toLowerCase();
						let e = this.keywords[t];
						if ("number" != typeof e)
							if ("yield" === t)
								this.version >= 700 && this.tryMatch(" from")
									? (this.consume(5), (e = this.tok.T_YIELD_FROM))
									: (e = this.tok.T_YIELD);
							else if (((e = this.tok.T_STRING), "b" === t || "B" === t)) {
								const t = this.input(1);
								if ('"' === t) return this.ST_DOUBLE_QUOTES();
								if ("'" === t) return this.T_CONSTANT_ENCAPSED_STRING();
								t && this.unput(1);
							}
						return e;
					},
					consume_TOKEN: function () {
						const t = this._input[this.offset - 1],
							e = this.tokenTerminals[t];
						return e ? e.apply(this, []) : this.yytext;
					},
					tokenTerminals: {
						$: function () {
							return (
								this.offset++,
								this.is_LABEL_START()
									? (this.offset--, this.consume_LABEL(), this.tok.T_VARIABLE)
									: (this.offset--, "$")
							);
						},
						"-": function () {
							const t = this._input[this.offset];
							return ">" === t
								? (this.begin("ST_LOOKING_FOR_PROPERTY").input(),
								  this.tok.T_OBJECT_OPERATOR)
								: "-" === t
								? (this.input(), this.tok.T_DEC)
								: "=" === t
								? (this.input(), this.tok.T_MINUS_EQUAL)
								: "-";
						},
						"\\": function () {
							return this.tok.T_NS_SEPARATOR;
						},
						"/": function () {
							return "=" === this._input[this.offset]
								? (this.input(), this.tok.T_DIV_EQUAL)
								: "/";
						},
						":": function () {
							return ":" === this._input[this.offset]
								? (this.input(), this.tok.T_DOUBLE_COLON)
								: ":";
						},
						"(": function () {
							const t = this.offset;
							if (
								(this.input(),
								this.is_TABSPACE() && this.consume_TABSPACE().input(),
								this.is_LABEL_START())
							) {
								const t = this.yytext.length;
								this.consume_LABEL();
								const e = this.yytext.substring(t - 1).toLowerCase(),
									n = this.castKeywords[e];
								if (
									"number" == typeof n &&
									(this.input(),
									this.is_TABSPACE() && this.consume_TABSPACE().input(),
									")" === this._input[this.offset - 1])
								)
									return n;
							}
							return this.unput(this.offset - t), "(";
						},
						"=": function () {
							const t = this._input[this.offset];
							return ">" === t
								? (this.input(), this.tok.T_DOUBLE_ARROW)
								: "=" === t
								? "=" === this._input[this.offset + 1]
									? (this.consume(2), this.tok.T_IS_IDENTICAL)
									: (this.input(), this.tok.T_IS_EQUAL)
								: "=";
						},
						"+": function () {
							const t = this._input[this.offset];
							return "+" === t
								? (this.input(), this.tok.T_INC)
								: "=" === t
								? (this.input(), this.tok.T_PLUS_EQUAL)
								: "+";
						},
						"!": function () {
							return "=" === this._input[this.offset]
								? "=" === this._input[this.offset + 1]
									? (this.consume(2), this.tok.T_IS_NOT_IDENTICAL)
									: (this.input(), this.tok.T_IS_NOT_EQUAL)
								: "!";
						},
						"?": function () {
							return this.version >= 700 && "?" === this._input[this.offset]
								? this.version >= 704 && "=" === this._input[this.offset + 1]
									? (this.consume(2), this.tok.T_COALESCE_EQUAL)
									: (this.input(), this.tok.T_COALESCE)
								: this.version >= 800 &&
								  "-" === this._input[this.offset] &&
								  ">" === this._input[this.offset + 1]
								? (this.consume(2), this.tok.T_NULLSAFE_OBJECT_OPERATOR)
								: "?";
						},
						"<": function () {
							let t = this._input[this.offset];
							return "<" === t
								? ((t = this._input[this.offset + 1]),
								  "=" === t
										? (this.consume(2), this.tok.T_SL_EQUAL)
										: "<" === t && this.is_HEREDOC()
										? this.tok.T_START_HEREDOC
										: (this.input(), this.tok.T_SL))
								: "=" === t
								? (this.input(),
								  this.version >= 700 && ">" === this._input[this.offset]
										? (this.input(), this.tok.T_SPACESHIP)
										: this.tok.T_IS_SMALLER_OR_EQUAL)
								: ">" === t
								? (this.input(), this.tok.T_IS_NOT_EQUAL)
								: "<";
						},
						">": function () {
							let t = this._input[this.offset];
							return "=" === t
								? (this.input(), this.tok.T_IS_GREATER_OR_EQUAL)
								: ">" === t
								? ((t = this._input[this.offset + 1]),
								  "=" === t
										? (this.consume(2), this.tok.T_SR_EQUAL)
										: (this.input(), this.tok.T_SR))
								: ">";
						},
						"*": function () {
							const t = this._input[this.offset];
							return "=" === t
								? (this.input(), this.tok.T_MUL_EQUAL)
								: "*" === t
								? (this.input(),
								  "=" === this._input[this.offset]
										? (this.input(), this.tok.T_POW_EQUAL)
										: this.tok.T_POW)
								: "*";
						},
						".": function () {
							const t = this._input[this.offset];
							return "=" === t
								? (this.input(), this.tok.T_CONCAT_EQUAL)
								: "." === t && "." === this._input[this.offset + 1]
								? (this.consume(2), this.tok.T_ELLIPSIS)
								: ".";
						},
						"%": function () {
							return "=" === this._input[this.offset]
								? (this.input(), this.tok.T_MOD_EQUAL)
								: "%";
						},
						"&": function () {
							const t = this._input[this.offset];
							return "=" === t
								? (this.input(), this.tok.T_AND_EQUAL)
								: "&" === t
								? (this.input(), this.tok.T_BOOLEAN_AND)
								: "&";
						},
						"|": function () {
							const t = this._input[this.offset];
							return "=" === t
								? (this.input(), this.tok.T_OR_EQUAL)
								: "|" === t
								? (this.input(), this.tok.T_BOOLEAN_OR)
								: "|";
						},
						"^": function () {
							return "=" === this._input[this.offset]
								? (this.input(), this.tok.T_XOR_EQUAL)
								: "^";
						},
					},
				};
			},
			{},
		],
		142: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					is_NUM: function () {
						const t = this._input.charCodeAt(this.offset - 1);
						return (t > 47 && t < 58) || 95 === t;
					},
					is_NUM_START: function () {
						const t = this._input.charCodeAt(this.offset - 1);
						return t > 47 && t < 58;
					},
					is_LABEL: function () {
						const t = this._input.charCodeAt(this.offset - 1);
						return (
							(t > 96 && t < 123) ||
							(t > 64 && t < 91) ||
							95 === t ||
							(t > 47 && t < 58) ||
							t > 126
						);
					},
					is_LABEL_START: function () {
						const t = this._input.charCodeAt(this.offset - 1);
						return (
							(t > 64 && t < 91) || (t > 96 && t < 123) || 95 === t || t > 126
						);
					},
					consume_LABEL: function () {
						for (; this.offset < this.size; ) {
							const t = this.input();
							if (!this.is_LABEL()) {
								t && this.unput(1);
								break;
							}
						}
						return this;
					},
					is_TOKEN: function () {
						const t = this._input[this.offset - 1];
						return -1 !== ";:,.\\[]()|^&+-/*=%!~$<>?@".indexOf(t);
					},
					is_WHITESPACE: function () {
						const t = this._input[this.offset - 1];
						return " " === t || "\t" === t || "\n" === t || "\r" === t;
					},
					is_TABSPACE: function () {
						const t = this._input[this.offset - 1];
						return " " === t || "\t" === t;
					},
					consume_TABSPACE: function () {
						for (; this.offset < this.size; ) {
							const t = this.input();
							if (!this.is_TABSPACE()) {
								t && this.unput(1);
								break;
							}
						}
						return this;
					},
					is_HEX: function () {
						const t = this._input.charCodeAt(this.offset - 1);
						return (
							(t > 47 && t < 58) ||
							(t > 64 && t < 71) ||
							(t > 96 && t < 103) ||
							95 === t
						);
					},
				};
			},
			{},
		],
		143: [
			function (t, e, n) {
				"use strict";
				function i(t) {
					return "." != t && "," != t && !isNaN(parseFloat(t)) && isFinite(t);
				}
				const r = function (t, e) {
					(this.lexer = t),
						(this.ast = e),
						(this.tok = t.tok),
						(this.EOF = t.EOF),
						(this.token = null),
						(this.prev = null),
						(this.debug = !1),
						(this.version = 800),
						(this.extractDoc = !1),
						(this.extractTokens = !1),
						(this.suppressErrors = !1);
					const n = function (t) {
						return [t, null];
					};
					this.entries = {
						IDENTIFIER: new Map(
							[
								this.tok.T_ABSTRACT,
								this.tok.T_ARRAY,
								this.tok.T_AS,
								this.tok.T_BREAK,
								this.tok.T_CALLABLE,
								this.tok.T_CASE,
								this.tok.T_CATCH,
								this.tok.T_CLASS,
								this.tok.T_CLASS_C,
								this.tok.T_CLONE,
								this.tok.T_CONST,
								this.tok.T_CONTINUE,
								this.tok.T_DECLARE,
								this.tok.T_DEFAULT,
								this.tok.T_DIR,
								this.tok.T_DO,
								this.tok.T_ECHO,
								this.tok.T_ELSE,
								this.tok.T_ELSEIF,
								this.tok.T_EMPTY,
								this.tok.T_ENDDECLARE,
								this.tok.T_ENDFOR,
								this.tok.T_ENDFOREACH,
								this.tok.T_ENDIF,
								this.tok.T_ENDSWITCH,
								this.tok.T_ENDWHILE,
								this.tok.T_EVAL,
								this.tok.T_EXIT,
								this.tok.T_EXTENDS,
								this.tok.T_FILE,
								this.tok.T_FINAL,
								this.tok.T_FINALLY,
								this.tok.T_FN,
								this.tok.T_FOR,
								this.tok.T_FOREACH,
								this.tok.T_FUNC_C,
								this.tok.T_FUNCTION,
								this.tok.T_GLOBAL,
								this.tok.T_GOTO,
								this.tok.T_IF,
								this.tok.T_IMPLEMENTS,
								this.tok.T_INCLUDE,
								this.tok.T_INCLUDE_ONCE,
								this.tok.T_INSTANCEOF,
								this.tok.T_INSTEADOF,
								this.tok.T_INTERFACE,
								this.tok.T_ISSET,
								this.tok.T_LINE,
								this.tok.T_LIST,
								this.tok.T_LOGICAL_AND,
								this.tok.T_LOGICAL_OR,
								this.tok.T_LOGICAL_XOR,
								this.tok.T_MATCH,
								this.tok.T_METHOD_C,
								this.tok.T_NAMESPACE,
								this.tok.T_NEW,
								this.tok.T_NS_C,
								this.tok.T_PRINT,
								this.tok.T_PRIVATE,
								this.tok.T_PROTECTED,
								this.tok.T_PUBLIC,
								this.tok.T_REQUIRE,
								this.tok.T_REQUIRE_ONCE,
								this.tok.T_RETURN,
								this.tok.T_STATIC,
								this.tok.T_SWITCH,
								this.tok.T_THROW,
								this.tok.T_TRAIT,
								this.tok.T_TRY,
								this.tok.T_UNSET,
								this.tok.T_USE,
								this.tok.T_VAR,
								this.tok.T_WHILE,
								this.tok.T_YIELD,
							].map(n)
						),
						VARIABLE: new Map(
							[
								this.tok.T_VARIABLE,
								"$",
								"&",
								this.tok.T_NS_SEPARATOR,
								this.tok.T_STRING,
								this.tok.T_NAMESPACE,
								this.tok.T_STATIC,
							].map(n)
						),
						SCALAR: new Map(
							[
								this.tok.T_CONSTANT_ENCAPSED_STRING,
								this.tok.T_START_HEREDOC,
								this.tok.T_LNUMBER,
								this.tok.T_DNUMBER,
								this.tok.T_ARRAY,
								"[",
								this.tok.T_CLASS_C,
								this.tok.T_TRAIT_C,
								this.tok.T_FUNC_C,
								this.tok.T_METHOD_C,
								this.tok.T_LINE,
								this.tok.T_FILE,
								this.tok.T_DIR,
								this.tok.T_NS_C,
								'"',
								'b"',
								'B"',
								"-",
								this.tok.T_NS_SEPARATOR,
							].map(n)
						),
						T_MAGIC_CONST: new Map(
							[
								this.tok.T_CLASS_C,
								this.tok.T_TRAIT_C,
								this.tok.T_FUNC_C,
								this.tok.T_METHOD_C,
								this.tok.T_LINE,
								this.tok.T_FILE,
								this.tok.T_DIR,
								this.tok.T_NS_C,
							].map(n)
						),
						T_MEMBER_FLAGS: new Map(
							[
								this.tok.T_PUBLIC,
								this.tok.T_PRIVATE,
								this.tok.T_PROTECTED,
								this.tok.T_STATIC,
								this.tok.T_ABSTRACT,
								this.tok.T_FINAL,
							].map(n)
						),
						EOS: new Map([";", this.EOF, this.tok.T_INLINE_HTML].map(n)),
						EXPR: new Map(
							[
								"@",
								"-",
								"+",
								"!",
								"~",
								"(",
								"`",
								this.tok.T_LIST,
								this.tok.T_CLONE,
								this.tok.T_INC,
								this.tok.T_DEC,
								this.tok.T_NEW,
								this.tok.T_ISSET,
								this.tok.T_EMPTY,
								this.tok.T_MATCH,
								this.tok.T_INCLUDE,
								this.tok.T_INCLUDE_ONCE,
								this.tok.T_REQUIRE,
								this.tok.T_REQUIRE_ONCE,
								this.tok.T_EVAL,
								this.tok.T_INT_CAST,
								this.tok.T_DOUBLE_CAST,
								this.tok.T_STRING_CAST,
								this.tok.T_ARRAY_CAST,
								this.tok.T_OBJECT_CAST,
								this.tok.T_BOOL_CAST,
								this.tok.T_UNSET_CAST,
								this.tok.T_EXIT,
								this.tok.T_PRINT,
								this.tok.T_YIELD,
								this.tok.T_STATIC,
								this.tok.T_FUNCTION,
								this.tok.T_FN,
								this.tok.T_VARIABLE,
								"$",
								this.tok.T_NS_SEPARATOR,
								this.tok.T_STRING,
								this.tok.T_STRING,
								this.tok.T_CONSTANT_ENCAPSED_STRING,
								this.tok.T_START_HEREDOC,
								this.tok.T_LNUMBER,
								this.tok.T_DNUMBER,
								this.tok.T_ARRAY,
								"[",
								this.tok.T_CLASS_C,
								this.tok.T_TRAIT_C,
								this.tok.T_FUNC_C,
								this.tok.T_METHOD_C,
								this.tok.T_LINE,
								this.tok.T_FILE,
								this.tok.T_DIR,
								this.tok.T_NS_C,
								'"',
								'b"',
								'B"',
								"-",
								this.tok.T_NS_SEPARATOR,
							].map(n)
						),
					};
				};
				(r.prototype.getTokenName = function (t) {
					return i(t)
						? t == this.EOF
							? "the end of file (EOF)"
							: this.lexer.engine.tokens.values[t]
						: "'" + t + "'";
				}),
					(r.prototype.parse = function (t, e) {
						(this._errors = []),
							(this.filename = e || "eval"),
							(this.currentNamespace = [""]),
							this.extractDoc ? (this._docs = []) : (this._docs = null),
							this.extractTokens ? (this._tokens = []) : (this._tokens = null),
							(this._docIndex = 0),
							(this._lastNode = null),
							this.lexer.setInput(t),
							(this.lexer.all_tokens = this.extractTokens),
							(this.lexer.comment_tokens = this.extractDoc),
							(this.length = this.lexer._input.length),
							(this.innerList = !1),
							(this.innerListForm = !1);
						const n = this.node("program"),
							i = [];
						for (this.next(); this.token != this.EOF; )
							i.push(this.read_start());
						0 === i.length &&
							this.extractDoc &&
							this._docs.length > this._docIndex &&
							i.push(this.node("noop")()),
							(this.prev = [
								this.lexer.yylloc.last_line,
								this.lexer.yylloc.last_column,
								this.lexer.offset,
							]);
						const r = n(i, this._errors, this._docs, this._tokens);
						if (this.debug) {
							const t = this.ast.checkNodes();
							if (t.length > 0)
								throw (
									(t.forEach(function (t) {
										t.position &&
											console.log(
												"Node at line " +
													t.position.line +
													", column " +
													t.position.column
											),
											console.log(t.stack.join("\n"));
									}),
									new Error("Some nodes are not closed"))
								);
						}
						return r;
					}),
					(r.prototype.raiseError = function (t, e, n, i) {
						if (
							((t += " on line " + this.lexer.yylloc.first_line),
							!this.suppressErrors)
						) {
							const e = new SyntaxError(
								t,
								this.filename,
								this.lexer.yylloc.first_line
							);
							throw (
								((e.lineNumber = this.lexer.yylloc.first_line),
								(e.fileName = this.filename),
								(e.columnNumber = this.lexer.yylloc.first_column),
								e)
							);
						}
						const r = this.ast.prepare("error", null, this)(
							t,
							i,
							this.lexer.yylloc.first_line,
							n
						);
						return this._errors.push(r), r;
					}),
					(r.prototype.error = function (t) {
						let e = "Parse Error : syntax error",
							n = this.getTokenName(this.token),
							r = "";
						if (this.token !== this.EOF) {
							if (i(this.token)) {
								let t = this.text();
								t.length > 10 && (t = t.substring(0, 7) + "..."),
									(n = "'" + t + "' (" + n + ")");
							}
							e += ", unexpected " + n;
						}
						return (
							t &&
								!Array.isArray(t) &&
								((i(t) || 1 === t.length) &&
									(r = ", expecting " + this.getTokenName(t)),
								(e += r)),
							this.raiseError(e, r, t, n)
						);
					}),
					(r.prototype.node = function (t) {
						if (this.extractDoc) {
							let e = null;
							this._docIndex < this._docs.length &&
								((e = this._docs.slice(this._docIndex)),
								(this._docIndex = this._docs.length),
								this.debug &&
									(console.log(new Error("Append docs on " + t)),
									console.log(e)));
							const n = this.ast.prepare(t, e, this);
							return (
								(n.postBuild = function (t) {
									if (this._docIndex < this._docs.length)
										if (this._lastNode) {
											const t = this.prev[2];
											let e = this._docIndex;
											for (
												;
												e < this._docs.length && !(this._docs[e].offset > t);
												e++
											);
											e > this._docIndex &&
												(this._lastNode.setTrailingComments(
													this._docs.slice(this._docIndex, e)
												),
												(this._docIndex = e));
										} else
											this.token === this.EOF &&
												(t.setTrailingComments(
													this._docs.slice(this._docIndex)
												),
												(this._docIndex = this._docs.length));
									this._lastNode = t;
								}.bind(this)),
								n
							);
						}
						return this.ast.prepare(t, null, this);
					}),
					(r.prototype.expectEndOfStatement = function (t) {
						if (";" === this.token)
							t && ";" === this.lexer.yytext && t.includeToken(this);
						else if (
							this.token !== this.tok.T_INLINE_HTML &&
							this.token !== this.EOF
						)
							return this.error(";"), !1;
						return this.next(), !0;
					});
				const o = ["parser.next", "parser.node", "parser.showlog"];
				(r.prototype.showlog = function () {
					const t = new Error().stack.split("\n");
					let e;
					for (let n = 2; n < t.length; n++) {
						e = t[n].trim();
						let i = !1;
						for (let t = 0; t < o.length; t++)
							if (e.substring(3, 3 + o[t].length) === o[t]) {
								i = !0;
								break;
							}
						if (!i) break;
					}
					return (
						console.log(
							"Line " +
								this.lexer.yylloc.first_line +
								" : " +
								this.getTokenName(this.token) +
								">" +
								this.lexer.yytext +
								"< @--\x3e" +
								e
						),
						this
					);
				}),
					(r.prototype.expect = function (t) {
						if (Array.isArray(t)) {
							if (-1 === t.indexOf(this.token)) return this.error(t), !1;
						} else if (this.token != t) return this.error(t), !1;
						return !0;
					}),
					(r.prototype.text = function () {
						return this.lexer.yytext;
					}),
					(r.prototype.next = function () {
						if (
							((";" === this.token && ";" !== this.lexer.yytext) ||
								(this.prev = [
									this.lexer.yylloc.last_line,
									this.lexer.yylloc.last_column,
									this.lexer.offset,
								]),
							this.lex(),
							this.debug && this.showlog(),
							this.extractDoc)
						)
							for (
								;
								this.token === this.tok.T_COMMENT ||
								this.token === this.tok.T_DOC_COMMENT;

							)
								this.token === this.tok.T_COMMENT
									? this._docs.push(this.read_comment())
									: this._docs.push(this.read_doc_comment());
						return this;
					}),
					(r.prototype.lex = function () {
						if (this.extractTokens)
							do {
								if (
									((this.token = this.lexer.lex() || this.EOF),
									this.token === this.EOF)
								)
									return this;
								let t = this.lexer.yytext;
								if (
									((t = this.lexer.engine.tokens.values.hasOwnProperty(
										this.token
									)
										? [
												this.lexer.engine.tokens.values[this.token],
												t,
												this.lexer.yylloc.first_line,
												this.lexer.yylloc.first_offset,
												this.lexer.offset,
										  ]
										: [
												null,
												t,
												this.lexer.yylloc.first_line,
												this.lexer.yylloc.first_offset,
												this.lexer.offset,
										  ]),
									this._tokens.push(t),
									this.token === this.tok.T_CLOSE_TAG)
								)
									return (this.token = ";"), this;
								if (this.token === this.tok.T_OPEN_TAG_WITH_ECHO)
									return (this.token = this.tok.T_ECHO), this;
							} while (
								this.token === this.tok.T_WHITESPACE ||
								(!this.extractDoc &&
									(this.token === this.tok.T_COMMENT ||
										this.token === this.tok.T_DOC_COMMENT)) ||
								this.token === this.tok.T_OPEN_TAG
							);
						else this.token = this.lexer.lex() || this.EOF;
						return this;
					}),
					(r.prototype.is = function (t) {
						return Array.isArray(t)
							? -1 !== t.indexOf(this.token)
							: this.entries[t].has(this.token);
					}),
					[
						t("./parser/array.js"),
						t("./parser/class.js"),
						t("./parser/comment.js"),
						t("./parser/expr.js"),
						t("./parser/function.js"),
						t("./parser/if.js"),
						t("./parser/loops.js"),
						t("./parser/main.js"),
						t("./parser/namespace.js"),
						t("./parser/scalar.js"),
						t("./parser/statement.js"),
						t("./parser/switch.js"),
						t("./parser/try.js"),
						t("./parser/utils.js"),
						t("./parser/variable.js"),
					].forEach(function (t) {
						for (const e in t) {
							if (r.prototype.hasOwnProperty(e))
								throw new Error(
									"Function " + e + " is already defined - collision"
								);
							r.prototype[e] = t[e];
						}
					}),
					(e.exports = r);
			},
			{
				"./parser/array.js": 144,
				"./parser/class.js": 145,
				"./parser/comment.js": 146,
				"./parser/expr.js": 147,
				"./parser/function.js": 148,
				"./parser/if.js": 149,
				"./parser/loops.js": 150,
				"./parser/main.js": 151,
				"./parser/namespace.js": 152,
				"./parser/scalar.js": 153,
				"./parser/statement.js": 154,
				"./parser/switch.js": 155,
				"./parser/try.js": 156,
				"./parser/utils.js": 157,
				"./parser/variable.js": 158,
			},
		],
		144: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_array: function () {
						let t = null,
							e = !1;
						const n = this.node("array");
						this.token === this.tok.T_ARRAY
							? (this.next().expect("("), (t = ")"))
							: ((e = !0), (t = "]"));
						let i = [];
						return (
							this.next().token !== t && (i = this.read_array_pair_list(e)),
							this.expect(t),
							this.next(),
							n(e, i)
						);
					},
					read_array_pair_list: function (t) {
						const e = this;
						return this.read_list(
							function () {
								return e.read_array_pair(t);
							},
							",",
							!0
						);
					},
					read_array_pair: function (t) {
						if ((!t && ")" === this.token) || (t && "]" === this.token)) return;
						if ("," === this.token) return this.node("noop")();
						const e = this.node("entry");
						let n = null,
							i = null,
							r = !1,
							o = !1;
						if ("&" === this.token)
							this.next(), (r = !0), (i = this.read_variable(!0, !1));
						else if (this.token === this.tok.T_ELLIPSIS && this.version >= 704)
							this.next(),
								"&" === this.token && this.error(),
								(o = !0),
								(i = this.read_expr());
						else {
							const t = this.read_expr();
							this.token === this.tok.T_DOUBLE_ARROW
								? (this.next(),
								  (n = t),
								  "&" === this.token
										? (this.next(), (r = !0), (i = this.read_variable(!0, !1)))
										: (i = this.read_expr()))
								: (i = t);
						}
						return e(n, i, r, o);
					},
				};
			},
			{},
		],
		145: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_class_declaration_statement: function (t) {
						const e = this.node("class"),
							n = this.read_class_modifiers();
						if (this.token !== this.tok.T_CLASS)
							return this.error(this.tok.T_CLASS), this.next(), null;
						this.next().expect(this.tok.T_STRING);
						let i = this.node("identifier");
						const r = this.text();
						this.next(), (i = i(r));
						const o = this.read_extends_from(),
							s = this.read_implements_list();
						this.expect("{");
						const a = e(i, o, s, this.next().read_class_body(), n);
						return t && (a.attrGroups = t), a;
					},
					read_class_modifiers: function () {
						return [0, 0, this.read_class_modifier()];
					},
					read_class_modifier: function () {
						return this.token === this.tok.T_ABSTRACT
							? (this.next(), 1)
							: this.token === this.tok.T_FINAL
							? (this.next(), 2)
							: 0;
					},
					read_class_body: function () {
						let t = [],
							e = [];
						for (; this.token !== this.EOF && "}" !== this.token; ) {
							if (this.token === this.tok.T_COMMENT) {
								t.push(this.read_comment());
								continue;
							}
							if (this.token === this.tok.T_DOC_COMMENT) {
								t.push(this.read_doc_comment());
								continue;
							}
							if (this.token === this.tok.T_USE) {
								t = t.concat(this.read_trait_use_statement());
								continue;
							}
							this.token === this.tok.T_ATTRIBUTE &&
								(e = this.read_attr_list());
							const n = this.read_member_flags(!1);
							if (this.token !== this.tok.T_CONST)
								if (
									(this.token === this.tok.T_VAR &&
										(this.next().expect(this.tok.T_VARIABLE),
										(n[0] = null),
										(n[1] = 0)),
									this.token === this.tok.T_FUNCTION)
								)
									t.push(this.read_function(!1, n, e)), (e = []);
								else if (
									this.token === this.tok.T_VARIABLE ||
									(this.version >= 704 &&
										("?" === this.token ||
											this.token === this.tok.T_CALLABLE ||
											this.token === this.tok.T_ARRAY ||
											this.token === this.tok.T_NS_SEPARATOR ||
											this.token === this.tok.T_STRING ||
											this.token === this.tok.T_NAMESPACE))
								) {
									const i = this.read_variable_list(n, e);
									(e = []), this.expect(";"), this.next(), (t = t.concat(i));
								} else
									this.error([
										this.tok.T_CONST,
										this.tok.T_VARIABLE,
										this.tok.T_FUNCTION,
									]),
										this.next();
							else {
								const i = this.read_constant_list(n, e);
								this.expect(";") && this.next(), (t = t.concat(i));
							}
						}
						return this.expect("}"), this.next(), t;
					},
					read_variable_list: function (t, e) {
						const n = this.node("propertystatement"),
							i = this.read_list(function () {
								const t = this.node("property"),
									[n, i] = this.read_optional_type();
								this.expect(this.tok.T_VARIABLE);
								let r = this.node("identifier");
								const o = this.text().substring(1);
								return (
									this.next(),
									(r = r(o)),
									";" === this.token || "," === this.token
										? t(r, null, n, i, e || [])
										: "=" === this.token
										? t(r, this.next().read_expr(), n, i, e || [])
										: (this.expect([",", ";", "="]), t(r, null, n, i, e || []))
								);
							}, ",");
						return n(null, i, t);
					},
					read_constant_list: function (t, e) {
						this.expect(this.tok.T_CONST) && this.next();
						const n = this.node("classconstant"),
							i = this.read_list(function () {
								const t = this.node("constant");
								let e = null,
									n = null;
								if (
									this.token === this.tok.T_STRING ||
									(this.version >= 700 && this.is("IDENTIFIER"))
								) {
									e = this.node("identifier");
									const t = this.text();
									this.next(), (e = e(t));
								} else this.expect("IDENTIFIER");
								return (
									this.expect("=") && (n = this.next().read_expr()), t(e, n)
								);
							}, ",");
						return n(null, i, t, e || []);
					},
					read_member_flags: function (t) {
						const e = [-1, -1, -1];
						if (this.is("T_MEMBER_FLAGS")) {
							let n = 0,
								i = 0;
							do {
								switch (this.token) {
									case this.tok.T_PUBLIC:
										(n = 0), (i = 0);
										break;
									case this.tok.T_PROTECTED:
										(n = 0), (i = 1);
										break;
									case this.tok.T_PRIVATE:
										(n = 0), (i = 2);
										break;
									case this.tok.T_STATIC:
										(n = 1), (i = 1);
										break;
									case this.tok.T_ABSTRACT:
										(n = 2), (i = 1);
										break;
									case this.tok.T_FINAL:
										(n = 2), (i = 2);
								}
								t &&
									(0 == n && 2 == i
										? (this.expect([this.tok.T_PUBLIC, this.tok.T_PROTECTED]),
										  (i = -1))
										: 2 == n && 1 == i && (this.error(), (i = -1))),
									-1 !== e[n] ? this.error() : -1 !== i && (e[n] = i);
							} while (this.next().is("T_MEMBER_FLAGS"));
						}
						return -1 == e[1] && (e[1] = 0), -1 == e[2] && (e[2] = 0), e;
					},
					read_optional_type: function () {
						let t = !1;
						"?" === this.token && ((t = !0), this.next());
						let e = this.read_types();
						if (
							(t &&
								!e &&
								this.raiseError(
									"Expecting a type definition combined with nullable operator"
								),
							!t && !e)
						)
							return [!1, null];
						if ("|" === this.token) {
							e = [e];
							do {
								this.next();
								const t = this.read_type();
								if (!t) {
									this.raiseError("Expecting a type definition");
									break;
								}
								e.push(t);
							} while ("|" === this.token);
						}
						return [t, e];
					},
					read_interface_declaration_statement: function (t) {
						const e = this.node("interface");
						if (this.token !== this.tok.T_INTERFACE)
							return this.error(this.tok.T_INTERFACE), this.next(), null;
						this.next().expect(this.tok.T_STRING);
						let n = this.node("identifier");
						const i = this.text();
						this.next(), (n = n(i));
						const r = this.read_interface_extends_list();
						this.expect("{");
						return e(n, r, this.next().read_interface_body(), t || []);
					},
					read_interface_body: function () {
						let t = [],
							e = [];
						for (; this.token !== this.EOF && "}" !== this.token; ) {
							if (this.token === this.tok.T_COMMENT) {
								t.push(this.read_comment());
								continue;
							}
							if (this.token === this.tok.T_DOC_COMMENT) {
								t.push(this.read_doc_comment());
								continue;
							}
							e = this.read_attr_list();
							const n = this.read_member_flags(!0);
							if (this.token == this.tok.T_CONST) {
								const i = this.read_constant_list(n, e);
								this.expect(";") && this.next(), (t = t.concat(i)), (e = []);
							} else if (this.token === this.tok.T_FUNCTION) {
								const i = this.read_function_declaration(2, n, e);
								i.parseFlags(n),
									t.push(i),
									this.expect(";") && this.next(),
									(e = []);
							} else
								this.error([this.tok.T_CONST, this.tok.T_FUNCTION]),
									this.next();
						}
						return this.expect("}") && this.next(), t;
					},
					read_trait_declaration_statement: function () {
						const t = this.node("trait");
						if (this.token !== this.tok.T_TRAIT)
							return this.error(this.tok.T_TRAIT), this.next(), null;
						this.next().expect(this.tok.T_STRING);
						let e = this.node("identifier");
						const n = this.text();
						this.next(), (e = e(n)), this.expect("{");
						return t(e, this.next().read_class_body());
					},
					read_trait_use_statement: function () {
						const t = this.node("traituse");
						this.expect(this.tok.T_USE) && this.next();
						const e = [this.read_namespace_name()];
						let n = null;
						for (; "," === this.token; )
							e.push(this.next().read_namespace_name());
						if ("{" === this.token) {
							for (
								n = [];
								this.next().token !== this.EOF && "}" !== this.token;

							)
								n.push(this.read_trait_use_alias()), this.expect(";");
							this.expect("}") && this.next();
						} else this.expect(";") && this.next();
						return t(e, n);
					},
					read_trait_use_alias: function () {
						const t = this.node();
						let e,
							n = null;
						if (this.is("IDENTIFIER")) {
							e = this.node("identifier");
							const t = this.text();
							this.next(), (e = e(t));
						} else if (
							((e = this.read_namespace_name()),
							this.token === this.tok.T_DOUBLE_COLON)
						)
							if (
								(this.next(),
								this.token === this.tok.T_STRING ||
									(this.version >= 700 && this.is("IDENTIFIER")))
							) {
								(n = e), (e = this.node("identifier"));
								const t = this.text();
								this.next(), (e = e(t));
							} else this.expect(this.tok.T_STRING);
						else e = e.name;
						if (this.token === this.tok.T_INSTEADOF)
							return t("traitprecedence", n, e, this.next().read_name_list());
						if (this.token === this.tok.T_AS) {
							let i = null,
								r = null;
							if (
								(this.next().is("T_MEMBER_FLAGS") &&
									(i = this.read_member_flags()),
								this.token === this.tok.T_STRING ||
									(this.version >= 700 && this.is("IDENTIFIER")))
							) {
								r = this.node("identifier");
								const t = this.text();
								this.next(), (r = r(t));
							} else !1 === i && this.expect(this.tok.T_STRING);
							return t("traitalias", n, e, r, i);
						}
						return (
							this.expect([this.tok.T_AS, this.tok.T_INSTEADOF]),
							t("traitalias", n, e, null, null)
						);
					},
				};
			},
			{},
		],
		146: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_comment: function () {
						const t = this.text();
						let e = this.ast.prepare(
							"/*" === t.substring(0, 2) ? "commentblock" : "commentline",
							null,
							this
						);
						const n = this.lexer.yylloc.first_offset,
							i = this.prev;
						return (
							(this.prev = [
								this.lexer.yylloc.last_line,
								this.lexer.yylloc.last_column,
								this.lexer.offset,
							]),
							this.lex(),
							(e = e(t)),
							(e.offset = n),
							(this.prev = i),
							e
						);
					},
					read_doc_comment: function () {
						let t = this.ast.prepare("commentblock", null, this);
						const e = this.lexer.yylloc.first_offset,
							n = this.text(),
							i = this.prev;
						return (
							(this.prev = [
								this.lexer.yylloc.last_line,
								this.lexer.yylloc.last_column,
								this.lexer.offset,
							]),
							this.lex(),
							(t = t(n)),
							(t.offset = e),
							(this.prev = i),
							t
						);
					},
				};
			},
			{},
		],
		147: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_expr: function (t) {
						const e = this.node();
						if ("@" === this.token)
							return t || (t = this.next().read_expr()), e("silent", t);
						if ((t || (t = this.read_expr_item()), "|" === this.token))
							return e("bin", "|", t, this.next().read_expr());
						if ("&" === this.token)
							return e("bin", "&", t, this.next().read_expr());
						if ("^" === this.token)
							return e("bin", "^", t, this.next().read_expr());
						if ("." === this.token)
							return e("bin", ".", t, this.next().read_expr());
						if ("+" === this.token)
							return e("bin", "+", t, this.next().read_expr());
						if ("-" === this.token)
							return e("bin", "-", t, this.next().read_expr());
						if ("*" === this.token)
							return e("bin", "*", t, this.next().read_expr());
						if ("/" === this.token)
							return e("bin", "/", t, this.next().read_expr());
						if ("%" === this.token)
							return e("bin", "%", t, this.next().read_expr());
						if (this.token === this.tok.T_POW)
							return e("bin", "**", t, this.next().read_expr());
						if (this.token === this.tok.T_SL)
							return e("bin", "<<", t, this.next().read_expr());
						if (this.token === this.tok.T_SR)
							return e("bin", ">>", t, this.next().read_expr());
						if (this.token === this.tok.T_BOOLEAN_OR)
							return e("bin", "||", t, this.next().read_expr());
						if (this.token === this.tok.T_LOGICAL_OR)
							return e("bin", "or", t, this.next().read_expr());
						if (this.token === this.tok.T_BOOLEAN_AND)
							return e("bin", "&&", t, this.next().read_expr());
						if (this.token === this.tok.T_LOGICAL_AND)
							return e("bin", "and", t, this.next().read_expr());
						if (this.token === this.tok.T_LOGICAL_XOR)
							return e("bin", "xor", t, this.next().read_expr());
						if (this.token === this.tok.T_IS_IDENTICAL)
							return e("bin", "===", t, this.next().read_expr());
						if (this.token === this.tok.T_IS_NOT_IDENTICAL)
							return e("bin", "!==", t, this.next().read_expr());
						if (this.token === this.tok.T_IS_EQUAL)
							return e("bin", "==", t, this.next().read_expr());
						if (this.token === this.tok.T_IS_NOT_EQUAL)
							return e("bin", "!=", t, this.next().read_expr());
						if ("<" === this.token)
							return e("bin", "<", t, this.next().read_expr());
						if (">" === this.token)
							return e("bin", ">", t, this.next().read_expr());
						if (this.token === this.tok.T_IS_SMALLER_OR_EQUAL)
							return e("bin", "<=", t, this.next().read_expr());
						if (this.token === this.tok.T_IS_GREATER_OR_EQUAL)
							return e("bin", ">=", t, this.next().read_expr());
						if (this.token === this.tok.T_SPACESHIP)
							return e("bin", "<=>", t, this.next().read_expr());
						if (
							(this.token === this.tok.T_INSTANCEOF &&
								((t = e(
									"bin",
									"instanceof",
									t,
									this.next().read_class_name_reference()
								)),
								";" !== this.token &&
									this.token !== this.tok.T_INLINE_HTML &&
									this.token !== this.EOF &&
									(t = this.read_expr(t))),
							this.token === this.tok.T_COALESCE)
						)
							return e("bin", "??", t, this.next().read_expr());
						if ("?" === this.token) {
							let n = null;
							return (
								":" !== this.next().token && (n = this.read_expr()),
								this.expect(":") && this.next(),
								e("retif", t, n, this.read_expr())
							);
						}
						return e.destroy(t), t;
					},
					read_expr_cast: function (t) {
						return this.node("cast")(t, this.text(), this.next().read_expr());
					},
					read_isset_variable: function () {
						return this.read_expr();
					},
					read_isset_variables: function () {
						return this.read_function_list(this.read_isset_variable, ",");
					},
					read_internal_functions_in_yacc: function () {
						let t = null;
						switch (this.token) {
							case this.tok.T_ISSET:
								{
									(t = this.node("isset")),
										this.next().expect("(") && this.next();
									const e = this.read_isset_variables();
									this.expect(")") && this.next(), (t = t(e));
								}
								break;
							case this.tok.T_EMPTY:
								{
									(t = this.node("empty")),
										this.next().expect("(") && this.next();
									const e = this.read_expr();
									this.expect(")") && this.next(), (t = t(e));
								}
								break;
							case this.tok.T_INCLUDE:
								t = this.node("include")(!1, !1, this.next().read_expr());
								break;
							case this.tok.T_INCLUDE_ONCE:
								t = this.node("include")(!0, !1, this.next().read_expr());
								break;
							case this.tok.T_EVAL:
								{
									(t = this.node("eval")),
										this.next().expect("(") && this.next();
									const e = this.read_expr();
									this.expect(")") && this.next(), (t = t(e));
								}
								break;
							case this.tok.T_REQUIRE:
								t = this.node("include")(!1, !0, this.next().read_expr());
								break;
							case this.tok.T_REQUIRE_ONCE:
								t = this.node("include")(!0, !0, this.next().read_expr());
						}
						return t;
					},
					read_optional_expr: function (t) {
						return this.token !== t ? this.read_expr() : null;
					},
					read_exit_expr: function () {
						let t = null;
						return (
							"(" === this.token &&
								(this.next(),
								(t = this.read_optional_expr(")")),
								this.expect(")") && this.next()),
							t
						);
					},
					read_expr_item: function () {
						let t,
							e,
							n = [];
						if ("+" === this.token)
							return this.node("unary")("+", this.next().read_expr());
						if ("-" === this.token)
							return this.node("unary")("-", this.next().read_expr());
						if ("!" === this.token)
							return this.node("unary")("!", this.next().read_expr());
						if ("~" === this.token)
							return this.node("unary")("~", this.next().read_expr());
						if ("(" === this.token)
							return (
								(e = this.next().read_expr()),
								(e.parenthesizedExpression = !0),
								this.expect(")") && this.next(),
								this.handleDereferencable(e)
							);
						if ("`" === this.token) return this.read_encapsed_string("`");
						if (this.token === this.tok.T_LIST) {
							let e = null;
							const n = this.innerList;
							(t = this.node("list")),
								n || (e = this.node("assign")),
								this.next().expect("(") && this.next(),
								this.innerList || (this.innerList = !0);
							const i = this.read_array_pair_list(!1);
							this.expect(")") && this.next();
							let r = !1;
							for (let t = 0; t < i.length; t++)
								if (null !== i[t] && "noop" !== i[t].kind) {
									r = !0;
									break;
								}
							return (
								r ||
									this.raiseError(
										"Fatal Error :  Cannot use empty list on line " +
											this.lexer.yylloc.first_line
									),
								n
									? t(i, !1)
									: ((this.innerList = !1),
									  this.expect("=")
											? e(t(i, !1), this.next().read_expr(), "=")
											: t(i, !1))
							);
						}
						if (
							(this.token === this.tok.T_ATTRIBUTE &&
								(n = this.read_attr_list()),
							this.token === this.tok.T_CLONE)
						)
							return this.node("clone")(this.next().read_expr());
						switch (this.token) {
							case this.tok.T_INC:
								return this.node("pre")("+", this.next().read_variable(!1, !1));
							case this.tok.T_DEC:
								return this.node("pre")("-", this.next().read_variable(!1, !1));
							case this.tok.T_NEW:
								return this.read_new_expr();
							case this.tok.T_ISSET:
							case this.tok.T_EMPTY:
							case this.tok.T_INCLUDE:
							case this.tok.T_INCLUDE_ONCE:
							case this.tok.T_EVAL:
							case this.tok.T_REQUIRE:
							case this.tok.T_REQUIRE_ONCE:
								return this.read_internal_functions_in_yacc();
							case this.tok.T_MATCH:
								return this.read_match_expression();
							case this.tok.T_INT_CAST:
								return this.read_expr_cast("int");
							case this.tok.T_DOUBLE_CAST:
								return this.read_expr_cast("float");
							case this.tok.T_STRING_CAST:
								return this.read_expr_cast(
									-1 !== this.text().indexOf("binary") ? "binary" : "string"
								);
							case this.tok.T_ARRAY_CAST:
								return this.read_expr_cast("array");
							case this.tok.T_OBJECT_CAST:
								return this.read_expr_cast("object");
							case this.tok.T_BOOL_CAST:
								return this.read_expr_cast("bool");
							case this.tok.T_UNSET_CAST:
								return this.read_expr_cast("unset");
							case this.tok.T_THROW:
								this.version < 800 &&
									this.raiseError(
										"PHP 8+ is required to use throw as an expression"
									);
								return this.node("throw")(this.next().read_expr());
							case this.tok.T_EXIT: {
								const e = "die" === this.lexer.yytext.toLowerCase();
								(t = this.node("exit")), this.next();
								return t(this.read_exit_expr(), e);
							}
							case this.tok.T_PRINT:
								return this.node("print")(this.next().read_expr());
							case this.tok.T_YIELD: {
								let e = null,
									n = null;
								return (
									(t = this.node("yield")),
									this.next().is("EXPR") &&
										((e = this.read_expr()),
										this.token === this.tok.T_DOUBLE_ARROW &&
											((n = e), (e = this.next().read_expr()))),
									t(e, n)
								);
							}
							case this.tok.T_YIELD_FROM:
								return (
									(t = this.node("yieldfrom")),
									(e = this.next().read_expr()),
									t(e)
								);
							case this.tok.T_FN:
							case this.tok.T_FUNCTION:
								return this.read_inline_function(void 0, n);
							case this.tok.T_STATIC: {
								const t = [this.token, this.lexer.getState()];
								if (
									(this.next(),
									this.token === this.tok.T_FUNCTION ||
										(this.version >= 704 && this.token === this.tok.T_FN))
								)
									return this.read_inline_function([0, 1, 0], n);
								this.lexer.tokens.push(t), this.next();
							}
						}
						if (this.is("VARIABLE")) {
							(t = this.node()), (e = this.read_variable(!1, !1));
							const n =
								"identifier" === e.kind ||
								("staticlookup" === e.kind && "identifier" === e.offset.kind);
							switch (this.token) {
								case "=":
									return (
										n && this.error("VARIABLE"),
										"&" == this.next().token
											? this.read_assignref(t, e)
											: t("assign", e, this.read_expr(), "=")
									);
								case this.tok.T_PLUS_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "+=")
									);
								case this.tok.T_MINUS_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "-=")
									);
								case this.tok.T_MUL_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "*=")
									);
								case this.tok.T_POW_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "**=")
									);
								case this.tok.T_DIV_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "/=")
									);
								case this.tok.T_CONCAT_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), ".=")
									);
								case this.tok.T_MOD_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "%=")
									);
								case this.tok.T_AND_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "&=")
									);
								case this.tok.T_OR_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "|=")
									);
								case this.tok.T_XOR_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "^=")
									);
								case this.tok.T_SL_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "<<=")
									);
								case this.tok.T_SR_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), ">>=")
									);
								case this.tok.T_COALESCE_EQUAL:
									return (
										n && this.error("VARIABLE"),
										t("assign", e, this.next().read_expr(), "??=")
									);
								case this.tok.T_INC:
									return (
										n && this.error("VARIABLE"), this.next(), t("post", "+", e)
									);
								case this.tok.T_DEC:
									return (
										n && this.error("VARIABLE"), this.next(), t("post", "-", e)
									);
								default:
									t.destroy(e);
							}
						} else {
							if (this.is("SCALAR")) {
								if (
									((t = this.node()),
									(e = this.read_scalar()),
									"array" === e.kind && e.shortForm && "=" === this.token)
								) {
									const n = this.convertToList(e);
									e.loc && (n.loc = e.loc);
									return t("assign", n, this.next().read_expr(), "=");
								}
								return t.destroy(e), this.handleDereferencable(e);
							}
							this.error("EXPR"), this.next();
						}
						return e;
					},
					convertToList: function (t) {
						const e = t.items.map(
								(t) => (
									t.value &&
										"array" === t.value.kind &&
										t.value.shortForm &&
										(t.value = this.convertToList(t.value)),
									t
								)
							),
							n = this.node("list")(e, !0);
						return (
							t.loc && (n.loc = t.loc),
							t.leadingComments && (n.leadingComments = t.leadingComments),
							t.trailingComments && (n.trailingComments = t.trailingComments),
							n
						);
					},
					read_assignref: function (t, e) {
						let n;
						return (
							this.next(),
							this.token === this.tok.T_NEW
								? (this.version >= 700 && this.error(),
								  (n = this.read_new_expr()))
								: (n = this.read_variable(!1, !1)),
							t("assignref", e, n)
						);
					},
					read_inline_function: function (t, e) {
						if (this.token === this.tok.T_FUNCTION) {
							const n = this.read_function(!0, t, e);
							return (n.attrGroups = e), n;
						}
						!this.version >= 704 &&
							this.raiseError("Arrow Functions are not allowed");
						const n = this.node("arrowfunc");
						this.expect(this.tok.T_FN) && this.next();
						const i = this.is_reference();
						this.expect("(") && this.next();
						const r = this.read_parameter_list();
						this.expect(")") && this.next();
						let o = !1,
							s = null;
						":" === this.token &&
							("?" === this.next().token && ((o = !0), this.next()),
							(s = this.read_types())),
							this.expect(this.tok.T_DOUBLE_ARROW) && this.next();
						const a = n(r, i, this.read_expr(), s, o, !!t);
						return (a.attrGroups = e), a;
					},
					read_match_expression: function () {
						const t = this.node("match");
						this.expect(this.tok.T_MATCH) && this.next(),
							this.version < 800 &&
								this.raiseError(
									"Match statements are not allowed before PHP 8"
								);
						let e = null,
							n = [];
						return (
							this.expect("(") && this.next(),
							(e = this.read_expr()),
							this.expect(")") && this.next(),
							this.expect("{") && this.next(),
							(n = this.read_match_arms()),
							this.expect("}") && this.next(),
							t(e, n)
						);
					},
					read_match_arms: function () {
						return this.read_list(() => this.read_match_arm(), ",", !0);
					},
					read_match_arm: function () {
						if ("}" !== this.token)
							return this.node("matcharm")(
								this.read_match_arm_conds(),
								this.read_expr()
							);
					},
					read_match_arm_conds: function () {
						let t = [];
						if (this.token === this.tok.T_DEFAULT) (t = null), this.next();
						else
							for (t.push(this.read_expr()); "," === this.token; ) {
								if ((this.next(), this.token === this.tok.T_DOUBLE_ARROW))
									return this.next(), t;
								t.push(this.read_expr());
							}
						return this.expect(this.tok.T_DOUBLE_ARROW) && this.next(), t;
					},
					read_attribute() {
						const t = this.text();
						let e = [];
						return (
							this.next(),
							"(" === this.token && (e = this.read_argument_list()),
							this.node("attribute")(t, e)
						);
					},
					read_attr_list() {
						const t = [];
						if (this.token === this.tok.T_ATTRIBUTE)
							do {
								const e = this.node("attrgroup")([]);
								for (
									this.next(), e.attrs.push(this.read_attribute());
									"," === this.token;

								)
									this.next(),
										"]" !== this.token && e.attrs.push(this.read_attribute());
								t.push(e), this.expect("]"), this.next();
							} while (this.token === this.tok.T_ATTRIBUTE);
						return t;
					},
					read_new_expr: function () {
						const t = this.node("new");
						this.expect(this.tok.T_NEW) && this.next();
						let e = [];
						const n = this.read_attr_list();
						if (this.token === this.tok.T_CLASS) {
							const i = this.node("class");
							"(" === this.next().token && (e = this.read_argument_list());
							const r = this.read_extends_from(),
								o = this.read_implements_list();
							let s = null;
							this.expect("{") && (s = this.next().read_class_body());
							const a = i(null, r, o, s, [0, 0, 0]);
							return (a.attrGroups = n), t(a, e);
						}
						const i = this.read_new_class_name();
						return (
							"(" === this.token && (e = this.read_argument_list()), t(i, e)
						);
					},
					read_new_class_name: function () {
						if (
							this.token === this.tok.T_NS_SEPARATOR ||
							this.token === this.tok.T_STRING ||
							this.token === this.tok.T_NAMESPACE
						) {
							let t = this.read_namespace_name(!0);
							return (
								this.token === this.tok.T_DOUBLE_COLON &&
									(t = this.read_static_getter(t)),
								t
							);
						}
						if (this.is("VARIABLE")) return this.read_variable(!0, !1);
						this.expect([this.tok.T_STRING, "VARIABLE"]);
					},
					handleDereferencable: function (t) {
						for (; this.token !== this.EOF; )
							if (
								this.token === this.tok.T_OBJECT_OPERATOR ||
								this.token === this.tok.T_DOUBLE_COLON
							)
								t = this.recursive_variable_chain_scan(t, !1, !1, !0);
							else if (
								this.token === this.tok.T_CURLY_OPEN ||
								"[" === this.token
							)
								t = this.read_dereferencable(t);
							else {
								if ("(" !== this.token) return t;
								t = this.node("call")(t, this.read_argument_list());
							}
						return t;
					},
				};
			},
			{},
		],
		148: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					is_reference: function () {
						return "&" == this.token && (this.next(), !0);
					},
					is_variadic: function () {
						return this.token === this.tok.T_ELLIPSIS && (this.next(), !0);
					},
					read_function: function (t, e, n) {
						const i = this.read_function_declaration(
							t ? 1 : e ? 2 : 0,
							e && 1 === e[1],
							n || []
						);
						return (
							e && 1 == e[2]
								? (i.parseFlags(e), this.expect(";") && this.next())
								: (this.expect("{") &&
										((i.body = this.read_code_block(!1)),
										i.loc && i.body.loc && (i.loc.end = i.body.loc.end)),
								  !t && e && i.parseFlags(e)),
							i
						);
					},
					read_function_declaration: function (t, e, n) {
						let i = "function";
						1 === t ? (i = "closure") : 2 === t && (i = "method");
						const r = this.node(i);
						this.expect(this.tok.T_FUNCTION) && this.next();
						const o = this.is_reference();
						let s = !1,
							a = [],
							l = null,
							c = !1;
						if (1 !== t) {
							const e = this.node("identifier");
							2 === t
								? this.version >= 700
									? this.token === this.tok.T_STRING || this.is("IDENTIFIER")
										? ((s = this.text()), this.next())
										: this.version < 704 && this.error("IDENTIFIER")
									: this.token === this.tok.T_STRING
									? ((s = this.text()), this.next())
									: this.error("IDENTIFIER")
								: this.version >= 700
								? this.token === this.tok.T_STRING
									? ((s = this.text()), this.next())
									: this.version >= 704
									? this.expect("(") || this.next()
									: (this.error(this.tok.T_STRING), this.next())
								: (this.expect(this.tok.T_STRING) && (s = this.text()),
								  this.next()),
								(s = e(s));
						}
						this.expect("(") && this.next();
						const h = this.read_parameter_list();
						if (
							(this.expect(")") && this.next(),
							1 === t && (a = this.read_lexical_vars()),
							":" === this.token &&
								("?" === this.next().token && ((c = !0), this.next()),
								(l = this.read_types())),
							1 === t)
						) {
							const t = r(h, o, a, l, c, e);
							return (t.attrGroups = n || []), t;
						}
						const u = r(s, h, o, l, c);
						return (u.attrGroups = n || []), u;
					},
					read_lexical_vars: function () {
						let t = [];
						return (
							this.token === this.tok.T_USE &&
								(this.next(),
								this.expect("(") && this.next(),
								(t = this.read_lexical_var_list()),
								this.expect(")") && this.next()),
							t
						);
					},
					read_list_with_dangling_comma: function (t) {
						const e = [];
						for (; this.token != this.EOF; ) {
							if ((e.push(t()), "," != this.token)) {
								if (")" == this.token) break;
								this.error([",", ")"]);
								break;
							}
							if ((this.next(), this.version >= 800 && ")" === this.token))
								return e;
						}
						return e;
					},
					read_lexical_var_list: function () {
						return this.read_list_with_dangling_comma(
							this.read_lexical_var.bind(this)
						);
					},
					read_lexical_var: function () {
						if ("&" === this.token)
							return this.read_byref(this.read_lexical_var.bind(this));
						const t = this.node("variable");
						this.expect(this.tok.T_VARIABLE);
						const e = this.text().substring(1);
						return this.next(), t(e, !1);
					},
					read_parameter_list: function () {
						return ")" != this.token
							? this.read_list_with_dangling_comma(
									this.read_parameter.bind(this)
							  )
							: [];
					},
					read_parameter: function () {
						const t = this.node("parameter");
						let e = null,
							n = null,
							i = null,
							r = !1,
							o = [];
						this.token === this.tok.T_ATTRIBUTE && (o = this.read_attr_list());
						const s = this.read_promoted();
						"?" === this.token && (this.next(), (r = !0)),
							(i = this.read_types()),
							r &&
								!i &&
								this.raiseError(
									"Expecting a type definition combined with nullable operator"
								);
						const a = this.is_reference(),
							l = this.is_variadic();
						if (this.expect(this.tok.T_VARIABLE)) {
							e = this.node("identifier");
							const t = this.text().substring(1);
							this.next(), (e = e(t));
						}
						"=" == this.token && (n = this.next().read_expr());
						const c = t(e, i, n, a, l, r, s);
						return o && (c.attrGroups = o), c;
					},
					read_types() {
						const t = [],
							e = this.node("uniontype");
						let n = this.read_type();
						if (!n) return null;
						for (t.push(n); "|" === this.token; )
							this.next(), (n = this.read_type()), t.push(n);
						return 1 === t.length ? t[0] : e(t);
					},
					read_promoted() {
						return this.token === this.tok.T_PUBLIC
							? (this.next(), 1)
							: this.token === this.tok.T_PROTECTED
							? (this.next(), 2)
							: this.token === this.tok.T_PRIVATE
							? (this.next(), 4)
							: 0;
					},
					read_argument_list: function () {
						let t = [];
						return (
							this.expect("(") && this.next(),
							")" !== this.token && (t = this.read_non_empty_argument_list()),
							this.expect(")") && this.next(),
							t
						);
					},
					read_non_empty_argument_list: function () {
						let t = !1;
						return this.read_function_list(
							function () {
								const e = this.read_argument();
								return (
									e &&
										(t &&
											this.raiseError(
												"Unexpected argument after a variadic argument"
											),
										"variadic" === e.kind && (t = !0)),
									e
								);
							}.bind(this),
							","
						);
					},
					read_argument: function () {
						if (this.token === this.tok.T_ELLIPSIS)
							return this.node("variadic")(this.next().read_expr());
						if (
							this.token === this.tok.T_STRING ||
							Object.values(this.lexer.keywords).includes(this.token)
						) {
							const t = this.lexer.getState(),
								e = this.lexer.lex();
							if ((this.lexer.setState(t), ":" === e))
								return (
									this.version < 800 &&
										this.raiseError(
											"PHP 8+ is required to use named arguments"
										),
									this.node("namedargument")(
										this.text(),
										this.next().next().read_expr()
									)
								);
						}
						return this.read_expr();
					},
					read_type: function () {
						const t = this.node();
						if (
							this.token === this.tok.T_ARRAY ||
							this.token === this.tok.T_CALLABLE
						) {
							const e = this.text();
							return this.next(), t("typereference", e.toLowerCase(), e);
						}
						if (this.token === this.tok.T_STRING) {
							const e = this.text(),
								n = [this.token, this.lexer.getState()];
							return (
								this.next(),
								this.token !== this.tok.T_NS_SEPARATOR &&
								this.ast.typereference.types.indexOf(e.toLowerCase()) > -1
									? t("typereference", e.toLowerCase(), e)
									: (this.lexer.tokens.push(n),
									  this.next(),
									  t.destroy(),
									  this.read_namespace_name())
							);
						}
						return this.token === this.tok.T_NAMESPACE ||
							this.token === this.tok.T_NS_SEPARATOR
							? (t.destroy(), this.read_namespace_name())
							: (t.destroy(), null);
					},
				};
			},
			{},
		],
		149: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_if: function () {
						const t = this.node("if"),
							e = this.next().read_if_expr();
						let n = null,
							i = null,
							r = !1;
						if (":" === this.token) {
							(r = !0), this.next(), (n = this.node("block"));
							const t = [];
							for (
								;
								this.token !== this.EOF && this.token !== this.tok.T_ENDIF;

							) {
								if (this.token === this.tok.T_ELSEIF) {
									i = this.read_elseif_short();
									break;
								}
								if (this.token === this.tok.T_ELSE) {
									i = this.read_else_short();
									break;
								}
								t.push(this.read_inner_statement());
							}
							(n = n(null, t)),
								this.expect(this.tok.T_ENDIF) && this.next(),
								this.expectEndOfStatement();
						} else
							(n = this.read_statement()),
								this.token === this.tok.T_ELSEIF
									? (i = this.read_if())
									: this.token === this.tok.T_ELSE &&
									  (i = this.next().read_statement());
						return t(e, n, i, r);
					},
					read_if_expr: function () {
						this.expect("(") && this.next();
						const t = this.read_expr();
						return this.expect(")") && this.next(), t;
					},
					read_elseif_short: function () {
						let t = null;
						const e = this.node("if"),
							n = this.next().read_if_expr();
						this.expect(":") && this.next();
						const i = this.node("block"),
							r = [];
						for (
							;
							this.token != this.EOF && this.token !== this.tok.T_ENDIF;

						) {
							if (this.token === this.tok.T_ELSEIF) {
								t = this.read_elseif_short();
								break;
							}
							if (this.token === this.tok.T_ELSE) {
								t = this.read_else_short();
								break;
							}
							r.push(this.read_inner_statement());
						}
						return e(n, i(null, r), t, !0);
					},
					read_else_short: function () {
						this.next().expect(":") && this.next();
						const t = this.node("block"),
							e = [];
						for (; this.token != this.EOF && this.token !== this.tok.T_ENDIF; )
							e.push(this.read_inner_statement());
						return t(null, e);
					},
				};
			},
			{},
		],
		150: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_while: function () {
						const t = this.node("while");
						this.expect(this.tok.T_WHILE) && this.next();
						let e = null,
							n = null,
							i = !1;
						return (
							this.expect("(") && this.next(),
							(e = this.read_expr()),
							this.expect(")") && this.next(),
							":" === this.token
								? ((i = !0), (n = this.read_short_form(this.tok.T_ENDWHILE)))
								: (n = this.read_statement()),
							t(e, n, i)
						);
					},
					read_do: function () {
						const t = this.node("do");
						this.expect(this.tok.T_DO) && this.next();
						let e = null,
							n = null;
						return (
							(n = this.read_statement()),
							this.expect(this.tok.T_WHILE) &&
								(this.next().expect("(") && this.next(),
								(e = this.read_expr()),
								this.expect(")") && this.next(),
								this.expect(";") && this.next()),
							t(e, n)
						);
					},
					read_for: function () {
						const t = this.node("for");
						this.expect(this.tok.T_FOR) && this.next();
						let e = [],
							n = [],
							i = [],
							r = null,
							o = !1;
						return (
							this.expect("(") && this.next(),
							";" !== this.token
								? ((e = this.read_list(this.read_expr, ",")),
								  this.expect(";") && this.next())
								: this.next(),
							";" !== this.token
								? ((n = this.read_list(this.read_expr, ",")),
								  this.expect(";") && this.next())
								: this.next(),
							")" !== this.token
								? ((i = this.read_list(this.read_expr, ",")),
								  this.expect(")") && this.next())
								: this.next(),
							":" === this.token
								? ((o = !0), (r = this.read_short_form(this.tok.T_ENDFOR)))
								: (r = this.read_statement()),
							t(e, n, i, r, o)
						);
					},
					read_foreach: function () {
						const t = this.node("foreach");
						this.expect(this.tok.T_FOREACH) && this.next();
						let e = null,
							n = null,
							i = null,
							r = null,
							o = !1;
						return (
							this.expect("(") && this.next(),
							(e = this.read_expr()),
							this.expect(this.tok.T_AS) &&
								(this.next(),
								(i = this.read_foreach_variable()),
								this.token === this.tok.T_DOUBLE_ARROW &&
									((n = i), (i = this.next().read_foreach_variable()))),
							n &&
								"list" === n.kind &&
								this.raiseError("Fatal Error : Cannot use list as key element"),
							this.expect(")") && this.next(),
							":" === this.token
								? ((o = !0), (r = this.read_short_form(this.tok.T_ENDFOREACH)))
								: (r = this.read_statement()),
							t(e, n, i, r, o)
						);
					},
					read_foreach_variable: function () {
						if (this.token === this.tok.T_LIST || "[" === this.token) {
							const t = "[" === this.token,
								e = this.node("list");
							this.next(), !t && this.expect("(") && this.next();
							const n = this.read_array_pair_list(t);
							return this.expect(t ? "]" : ")") && this.next(), e(n, t);
						}
						return this.read_variable(!1, !1);
					},
				};
			},
			{},
		],
		151: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_start: function () {
						return this.token == this.tok.T_NAMESPACE
							? this.read_namespace()
							: this.read_top_statement();
					},
				};
			},
			{},
		],
		152: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_namespace: function () {
						const t = this.node("namespace");
						let e, n;
						return (
							this.expect(this.tok.T_NAMESPACE) && this.next(),
							(n =
								"{" == this.token
									? { name: [""] }
									: this.read_namespace_name()),
							(this.currentNamespace = n),
							";" == this.token
								? ((this.currentNamespace = n),
								  (e = this.next().read_top_statements()),
								  this.expect(this.EOF),
								  t(n.name, e, !1))
								: "{" == this.token
								? ((this.currentNamespace = n),
								  (e = this.next().read_top_statements()),
								  this.expect("}") && this.next(),
								  0 === e.length &&
										this.extractDoc &&
										this._docs.length > this._docIndex &&
										e.push(this.node("noop")()),
								  t(n.name, e, !0))
								: "(" === this.token
								? ((n.resolution = this.ast.reference.RELATIVE_NAME),
								  (n.name = n.name.substring(1)),
								  t.destroy(),
								  this.node("call")(n, this.read_argument_list()))
								: (this.error(["{", ";"]),
								  (this.currentNamespace = n),
								  (e = this.read_top_statements()),
								  this.expect(this.EOF),
								  t(n, e, !1))
						);
					},
					read_namespace_name: function (t) {
						const e = this.node();
						let n = !1;
						this.token === this.tok.T_NAMESPACE &&
							(this.next().expect(this.tok.T_NS_SEPARATOR) && this.next(),
							(n = !0));
						const i = this.read_list(
							this.tok.T_STRING,
							this.tok.T_NS_SEPARATOR,
							!0
						);
						if (!n && 1 === i.length && (t || "(" !== this.token)) {
							if ("parent" === i[0].toLowerCase())
								return e("parentreference", i[0]);
							if ("self" === i[0].toLowerCase())
								return e("selfreference", i[0]);
						}
						return e("name", i, n);
					},
					read_use_statement: function () {
						let t = this.node("usegroup"),
							e = [],
							n = null;
						this.expect(this.tok.T_USE) && this.next();
						const i = this.read_use_type();
						return (
							e.push(this.read_use_declaration(!1)),
							"," === this.token
								? (e = e.concat(this.next().read_use_declarations(!1)))
								: "{" === this.token &&
								  ((n = e[0].name),
								  (e = this.next().read_use_declarations(null === i)),
								  this.expect("}") && this.next()),
							(t = t(n, i, e)),
							this.expect(";") && this.next(),
							t
						);
					},
					read_class_name_reference: function () {
						return this.read_variable(!0, !1);
					},
					read_use_declaration: function (t) {
						const e = this.node("useitem");
						let n = null;
						t && (n = this.read_use_type());
						const i = this.read_namespace_name(),
							r = this.read_use_alias();
						return e(i.name, r, n);
					},
					read_use_declarations: function (t) {
						const e = [this.read_use_declaration(t)];
						for (; "," === this.token; ) {
							if ((this.next(), t)) {
								if (
									this.token !== this.tok.T_FUNCTION &&
									this.token !== this.tok.T_CONST &&
									this.token !== this.tok.T_STRING
								)
									break;
							} else if (
								this.token !== this.tok.T_STRING &&
								this.token !== this.tok.T_NS_SEPARATOR
							)
								break;
							e.push(this.read_use_declaration(t));
						}
						return e;
					},
					read_use_alias: function () {
						let t = null;
						if (
							this.token === this.tok.T_AS &&
							this.next().expect(this.tok.T_STRING)
						) {
							const e = this.node("identifier"),
								n = this.text();
							this.next(), (t = e(n));
						}
						return t;
					},
					read_use_type: function () {
						return this.token === this.tok.T_FUNCTION
							? (this.next(), this.ast.useitem.TYPE_FUNCTION)
							: this.token === this.tok.T_CONST
							? (this.next(), this.ast.useitem.TYPE_CONST)
							: null;
					},
				};
			},
			{},
		],
		153: [
			function (t, e, n) {
				"use strict";
				const i = {
					"\\": "\\",
					$: "$",
					n: "\n",
					r: "\r",
					t: "\t",
					f: String.fromCharCode(12),
					v: String.fromCharCode(11),
					e: String.fromCharCode(27),
				};
				e.exports = {
					resolve_special_chars: function (t, e) {
						return e
							? t
									.replace(/\\"/, '"')
									.replace(
										/\\([\\$nrtfve]|[xX][0-9a-fA-F]{1,2}|[0-7]{1,3}|u{([0-9a-fA-F]+)})/g,
										(t, e, n) =>
											i[e]
												? i[e]
												: "x" === e[0] || "X" === e[0]
												? String.fromCodePoint(parseInt(e.substr(1), 16))
												: "u" === e[0]
												? String.fromCodePoint(parseInt(n, 16))
												: String.fromCodePoint(parseInt(e, 8))
									)
							: t.replace(/\\\\/g, "\\").replace(/\\'/g, "'");
					},
					remove_heredoc_leading_whitespace_chars: function (t, e, n, i) {
						if (0 === e) return t;
						this.check_heredoc_indentation_level(t, e, n, i);
						const r = n ? " " : "\t",
							o = new RegExp(`\\n${r}{${e}}`, "g"),
							s = new RegExp(`^${r}{${e}}`);
						return i && (t = t.replace(s, "")), t.replace(o, "\n");
					},
					check_heredoc_indentation_level: function (t, e, n, i) {
						const r = t.length;
						let o = 0,
							s = 0,
							a = !0;
						const l = n ? " " : "\t";
						let c = !1;
						if (!i) {
							if (((o = t.indexOf("\n")), -1 === o)) return;
							o++;
						}
						for (; o < r; )
							a ? (t[o] === l ? s++ : (c = !0)) : (a = !1),
								"\n" !== t[o] && c && s < e
									? this.raiseError(
											`Invalid body indentation level (expecting an indentation at least ${e})`
									  )
									: (c = !1),
								"\n" === t[o] && ((a = !0), (s = 0)),
								o++;
					},
					read_dereferencable_scalar: function () {
						let t = null;
						switch (this.token) {
							case this.tok.T_CONSTANT_ENCAPSED_STRING:
								{
									let e = this.node("string");
									const n = this.text();
									let i = 0;
									("b" !== n[0] && "B" !== n[0]) || (i = 1);
									const r = '"' === n[i];
									this.next();
									(e = e(
										r,
										this.resolve_special_chars(
											n.substring(i + 1, n.length - 1),
											r
										),
										1 === i,
										n
									)),
										(t =
											this.token === this.tok.T_DOUBLE_COLON
												? this.read_static_getter(e)
												: e);
								}
								break;
							case this.tok.T_ARRAY:
							case "[":
								t = this.read_array();
						}
						return t;
					},
					read_scalar: function () {
						if (this.is("T_MAGIC_CONST")) return this.get_magic_constant();
						{
							let t, e;
							switch (this.token) {
								case this.tok.T_LNUMBER:
								case this.tok.T_DNUMBER: {
									const e = this.node("number");
									return (t = this.text()), this.next(), e(t, null);
								}
								case this.tok.T_START_HEREDOC:
									if ("ST_NOWDOC" === this.lexer.curCondition) {
										const n = this.lexer.yylloc.first_offset;
										(e = this.node("nowdoc")),
											(t = this.next().text()),
											this.lexer.heredoc_label.indentation > 0 &&
												(t = t.substring(
													0,
													t.length - this.lexer.heredoc_label.indentation
												));
										const i = t[t.length - 1];
										"\n" === i
											? (t =
													"\r" === t[t.length - 2]
														? t.substring(0, t.length - 2)
														: t.substring(0, t.length - 1))
											: "\r" === i && (t = t.substring(0, t.length - 1)),
											this.expect(this.tok.T_ENCAPSED_AND_WHITESPACE) &&
												this.next(),
											this.expect(this.tok.T_END_HEREDOC) && this.next();
										const r = this.lexer._input.substring(
											n,
											this.lexer.yylloc.first_offset
										);
										return (
											(e = e(
												this.remove_heredoc_leading_whitespace_chars(
													t,
													this.lexer.heredoc_label.indentation,
													this.lexer.heredoc_label.indentation_uses_spaces,
													this.lexer.heredoc_label.first_encaps_node
												),
												r,
												this.lexer.heredoc_label.label
											)),
											e
										);
									}
									return this.read_encapsed_string(this.tok.T_END_HEREDOC);
								case '"':
									return this.read_encapsed_string('"');
								case 'b"':
								case 'B"':
									return this.read_encapsed_string('"', !0);
								case this.tok.T_CONSTANT_ENCAPSED_STRING:
								case this.tok.T_ARRAY:
								case "[":
									return this.read_dereferencable_scalar();
								default: {
									const t = this.error("SCALAR");
									return this.next(), t;
								}
							}
						}
					},
					read_dereferencable: function (t) {
						let e, n;
						const i = this.node("offsetlookup");
						return (
							"[" === this.token
								? ((n = this.next().read_expr()),
								  this.expect("]") && this.next(),
								  (e = i(t, n)))
								: this.token === this.tok.T_DOLLAR_OPEN_CURLY_BRACES &&
								  ((n = this.read_encapsed_string_item(!1)), (e = i(t, n))),
							e
						);
					},
					read_encapsed_string_item: function (t) {
						const e = this.node("encapsedpart");
						let n,
							i,
							r,
							o = null,
							s = !1,
							a = this.node();
						if (this.token === this.tok.T_ENCAPSED_AND_WHITESPACE) {
							const e = this.text();
							this.next(),
								(a = a(
									"string",
									!1,
									this.version >= 703 && !this.lexer.heredoc_label.finished
										? this.remove_heredoc_leading_whitespace_chars(
												this.resolve_special_chars(e, t),
												this.lexer.heredoc_label.indentation,
												this.lexer.heredoc_label.indentation_uses_spaces,
												this.lexer.heredoc_label.first_encaps_node
										  )
										: e,
									!1,
									e
								));
						} else if (this.token === this.tok.T_DOLLAR_OPEN_CURLY_BRACES) {
							if (
								((o = "simple"),
								(s = !0),
								(r = null),
								this.next().token === this.tok.T_STRING_VARNAME)
							) {
								r = this.node("variable");
								const t = this.text();
								this.next(),
									"[" === this.token
										? ((r = r(t, !1)),
										  (i = this.node("offsetlookup")),
										  (n = this.next().read_expr()),
										  this.expect("]") && this.next(),
										  (a = i(r, n)))
										: (a = r(t, !1));
							} else a = a("variable", this.read_expr(), !1);
							this.expect("}") && this.next();
						} else if (this.token === this.tok.T_CURLY_OPEN)
							(o = "complex"),
								a.destroy(),
								(a = this.next().read_variable(!1, !1)),
								this.expect("}") && this.next();
						else if (this.token === this.tok.T_VARIABLE) {
							if (
								((o = "simple"),
								a.destroy(),
								(a = this.read_simple_variable()),
								"[" === this.token &&
									((i = this.node("offsetlookup")),
									(n = this.next().read_encaps_var_offset()),
									this.expect("]") && this.next(),
									(a = i(a, n))),
								this.token === this.tok.T_OBJECT_OPERATOR)
							) {
								(i = this.node("propertylookup")),
									this.next().expect(this.tok.T_STRING);
								const t = this.node("identifier");
								(r = this.text()), this.next(), (a = i(a, t(r)));
							}
						} else {
							this.expect(this.tok.T_ENCAPSED_AND_WHITESPACE);
							const t = this.text();
							this.next(), a.destroy(), (a = a("string", !1, t, !1, t));
						}
						return (
							(this.lexer.heredoc_label.first_encaps_node = !1), e(a, o, s)
						);
					},
					read_encapsed_string: function (t, e = !1) {
						const n = this.lexer.yylloc.first_offset;
						let i = this.node("encapsed");
						this.next();
						const r = this.lexer.yylloc.prev_offset - (e ? 1 : 0),
							o = [];
						let s = null;
						for (
							s =
								"`" === t
									? this.ast.encapsed.TYPE_SHELL
									: '"' === t
									? this.ast.encapsed.TYPE_STRING
									: this.ast.encapsed.TYPE_HEREDOC;
							this.token !== t && this.token !== this.EOF;

						)
							o.push(this.read_encapsed_string_item(!0));
						if (
							o.length > 0 &&
							"encapsedpart" === o[o.length - 1].kind &&
							"string" === o[o.length - 1].expression.kind
						) {
							const t = o[o.length - 1].expression,
								e = t.value[t.value.length - 1];
							"\n" === e
								? "\r" === t.value[t.value.length - 2]
									? (t.value = t.value.substring(0, t.value.length - 2))
									: (t.value = t.value.substring(0, t.value.length - 1))
								: "\r" === e &&
								  (t.value = t.value.substring(0, t.value.length - 1));
						}
						this.expect(t) && this.next();
						return (
							(i = i(
								o,
								this.lexer._input.substring(
									"heredoc" === s ? n : r - 1,
									this.lexer.yylloc.first_offset
								),
								s
							)),
							t === this.tok.T_END_HEREDOC &&
								((i.label = this.lexer.heredoc_label.label),
								(this.lexer.heredoc_label.finished = !0)),
							i
						);
					},
					get_magic_constant: function () {
						const t = this.node("magic"),
							e = this.text();
						return this.next(), t(e.toUpperCase(), e);
					},
				};
			},
			{},
		],
		154: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_top_statements: function () {
						let t = [];
						for (; this.token !== this.EOF && "}" !== this.token; ) {
							const e = this.read_top_statement();
							e && (Array.isArray(e) ? (t = t.concat(e)) : t.push(e));
						}
						return t;
					},
					read_top_statement: function () {
						let t = [];
						switch (
							(this.token === this.tok.T_ATTRIBUTE &&
								(t = this.read_attr_list()),
							this.token)
						) {
							case this.tok.T_FUNCTION:
								return this.read_function(!1, !1, t);
							case this.tok.T_ABSTRACT:
							case this.tok.T_FINAL:
							case this.tok.T_CLASS:
								return this.read_class_declaration_statement(t);
							case this.tok.T_INTERFACE:
								return this.read_interface_declaration_statement(t);
							case this.tok.T_TRAIT:
								return this.read_trait_declaration_statement();
							case this.tok.T_USE:
								return this.read_use_statement();
							case this.tok.T_CONST: {
								const t = this.node("constantstatement"),
									e = this.next().read_const_list();
								return this.expectEndOfStatement(), t(null, e);
							}
							case this.tok.T_NAMESPACE:
								return this.read_namespace();
							case this.tok.T_HALT_COMPILER: {
								const t = this.node("halt");
								return (
									this.next().expect("(") && this.next(),
									this.expect(")") && this.next(),
									this.expect(";"),
									(this.lexer.done = !0),
									t(this.lexer._input.substring(this.lexer.offset))
								);
							}
							default:
								return this.read_statement();
						}
					},
					read_inner_statements: function () {
						let t = [];
						for (; this.token != this.EOF && "}" !== this.token; ) {
							const e = this.read_inner_statement();
							e && (Array.isArray(e) ? (t = t.concat(e)) : t.push(e));
						}
						return t;
					},
					read_const_list: function () {
						return this.read_list(
							function () {
								this.expect(this.tok.T_STRING);
								const t = this.node("constant");
								let e = this.node("identifier");
								const n = this.text();
								return (
									this.next(),
									(e = e(n)),
									this.expect("=") ? t(e, this.next().read_expr()) : t(e, null)
								);
							},
							",",
							!1
						);
					},
					read_declare_list: function () {
						const t = [];
						for (; this.token != this.EOF && ")" !== this.token; ) {
							this.expect(this.tok.T_STRING);
							const e = this.node("declaredirective");
							let n = this.node("identifier");
							const i = this.text();
							this.next(), (n = n(i));
							let r = null;
							if (
								(this.expect("=") && (r = this.next().read_expr()),
								t.push(e(n, r)),
								"," !== this.token)
							)
								break;
							this.next();
						}
						return t;
					},
					read_inner_statement: function () {
						let t = [];
						switch (
							(this.token === this.tok.T_ATTRIBUTE &&
								(t = this.read_attr_list()),
							this.token)
						) {
							case this.tok.T_FUNCTION: {
								const e = this.read_function(!1, !1);
								return (e.attrGroups = t), e;
							}
							case this.tok.T_ABSTRACT:
							case this.tok.T_FINAL:
							case this.tok.T_CLASS:
								return this.read_class_declaration_statement();
							case this.tok.T_INTERFACE:
								return this.read_interface_declaration_statement();
							case this.tok.T_TRAIT:
								return this.read_trait_declaration_statement();
							case this.tok.T_HALT_COMPILER: {
								this.raiseError(
									"__HALT_COMPILER() can only be used from the outermost scope"
								);
								let t = this.node("halt");
								return (
									this.next().expect("(") && this.next(),
									this.expect(")") && this.next(),
									(t = t(this.lexer._input.substring(this.lexer.offset))),
									this.expect(";") && this.next(),
									t
								);
							}
							default:
								return this.read_statement();
						}
					},
					read_statement: function () {
						switch (this.token) {
							case "{":
								return this.read_code_block(!1);
							case this.tok.T_IF:
								return this.read_if();
							case this.tok.T_SWITCH:
								return this.read_switch();
							case this.tok.T_FOR:
								return this.read_for();
							case this.tok.T_FOREACH:
								return this.read_foreach();
							case this.tok.T_WHILE:
								return this.read_while();
							case this.tok.T_DO:
								return this.read_do();
							case this.tok.T_COMMENT:
								return this.read_comment();
							case this.tok.T_DOC_COMMENT:
								return this.read_doc_comment();
							case this.tok.T_RETURN: {
								const t = this.node("return");
								this.next();
								const e = this.read_optional_expr(";");
								return this.expectEndOfStatement(), t(e);
							}
							case this.tok.T_BREAK:
							case this.tok.T_CONTINUE: {
								const t = this.node(
									this.token === this.tok.T_CONTINUE ? "continue" : "break"
								);
								this.next();
								const e = this.read_optional_expr(";");
								return this.expectEndOfStatement(), t(e);
							}
							case this.tok.T_GLOBAL: {
								const t = this.node("global"),
									e = this.next().read_list(this.read_simple_variable, ",");
								return this.expectEndOfStatement(), t(e);
							}
							case this.tok.T_STATIC: {
								const t = [this.token, this.lexer.getState()],
									e = this.node();
								if (this.next().token === this.tok.T_DOUBLE_COLON) {
									this.lexer.tokens.push(t);
									const n = this.next().read_expr();
									return (
										this.expectEndOfStatement(n), e("expressionstatement", n)
									);
								}
								if (this.token === this.tok.T_FUNCTION)
									return this.read_function(!0, [0, 1, 0]);
								const n = this.read_variable_declarations();
								return this.expectEndOfStatement(), e("static", n);
							}
							case this.tok.T_ECHO: {
								const t = this.node("echo"),
									e = this.text(),
									n = "<?=" === e || "<%=" === e,
									i = this.next().read_function_list(this.read_expr, ",");
								return this.expectEndOfStatement(), t(i, n);
							}
							case this.tok.T_INLINE_HTML: {
								const t = this.text();
								let e =
									this.lexer.yylloc.first_offset > 0
										? this.lexer._input[this.lexer.yylloc.first_offset - 1]
										: null;
								const n = "\r" === e || "\n" === e;
								n &&
									"\n" === e &&
									this.lexer.yylloc.first_offset > 1 &&
									"\r" ===
										this.lexer._input[this.lexer.yylloc.first_offset - 2] &&
									(e = "\r\n");
								const i = this.node("inline");
								return this.next(), i(t, n ? e + t : t);
							}
							case this.tok.T_UNSET: {
								const t = this.node("unset");
								this.next().expect("(") && this.next();
								const e = this.read_function_list(this.read_variable, ",");
								return (
									this.expect(")") && this.next(),
									this.expect(";") && this.next(),
									t(e)
								);
							}
							case this.tok.T_DECLARE: {
								const t = this.node("declare"),
									e = [];
								let n;
								this.next().expect("(") && this.next();
								const i = this.read_declare_list();
								if ((this.expect(")") && this.next(), ":" === this.token)) {
									for (
										this.next();
										this.token != this.EOF &&
										this.token !== this.tok.T_ENDDECLARE;

									)
										e.push(this.read_top_statement());
									0 === e.length &&
										this.extractDoc &&
										this._docs.length > this._docIndex &&
										e.push(this.node("noop")()),
										this.expect(this.tok.T_ENDDECLARE) && this.next(),
										this.expectEndOfStatement(),
										(n = this.ast.declare.MODE_SHORT);
								} else if ("{" === this.token) {
									for (
										this.next();
										this.token != this.EOF && "}" !== this.token;

									)
										e.push(this.read_top_statement());
									0 === e.length &&
										this.extractDoc &&
										this._docs.length > this._docIndex &&
										e.push(this.node("noop")()),
										this.expect("}") && this.next(),
										(n = this.ast.declare.MODE_BLOCK);
								} else
									this.expect(";") && this.next(),
										(n = this.ast.declare.MODE_NONE);
								return t(i, e, n);
							}
							case this.tok.T_TRY:
								return this.read_try();
							case this.tok.T_THROW: {
								const t = this.node("throw"),
									e = this.next().read_expr();
								return this.expectEndOfStatement(), t(e);
							}
							case ";":
								return this.next(), null;
							case this.tok.T_STRING: {
								const t = this.node(),
									e = [this.token, this.lexer.getState()],
									n = this.text();
								let i = this.node("identifier");
								if (":" === this.next().token)
									return (i = i(n)), this.next(), t("label", i);
								i.destroy(), t.destroy(), this.lexer.tokens.push(e);
								const r = this.node("expressionstatement"),
									o = this.next().read_expr();
								return this.expectEndOfStatement(o), r(o);
							}
							case this.tok.T_GOTO: {
								const t = this.node("goto");
								let e = null;
								if (this.next().expect(this.tok.T_STRING)) {
									e = this.node("identifier");
									const t = this.text();
									this.next(), (e = e(t)), this.expectEndOfStatement();
								}
								return t(e);
							}
							default: {
								const t = this.node("expressionstatement"),
									e = this.read_expr();
								return this.expectEndOfStatement(e), t(e);
							}
						}
					},
					read_code_block: function (t) {
						const e = this.node("block");
						this.expect("{") && this.next();
						const n = t
							? this.read_top_statements()
							: this.read_inner_statements();
						return (
							0 === n.length &&
								this.extractDoc &&
								this._docs.length > this._docIndex &&
								n.push(this.node("noop")()),
							this.expect("}") && this.next(),
							e(null, n)
						);
					},
				};
			},
			{},
		],
		155: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_switch: function () {
						const t = this.node("switch");
						this.expect(this.tok.T_SWITCH) && this.next(),
							this.expect("(") && this.next();
						const e = this.read_expr();
						this.expect(")") && this.next();
						const n = ":" === this.token;
						return t(e, this.read_switch_case_list(), n);
					},
					read_switch_case_list: function () {
						let t = null;
						const e = this.node("block"),
							n = [];
						for (
							"{" === this.token
								? (t = "}")
								: ":" === this.token
								? (t = this.tok.T_ENDSWITCH)
								: this.expect(["{", ":"]),
								this.next(),
								";" === this.token && this.next();
							this.token !== this.EOF && this.token !== t;

						)
							n.push(this.read_case_list(t));
						return (
							0 === n.length &&
								this.extractDoc &&
								this._docs.length > this._docIndex &&
								n.push(this.node("noop")()),
							this.expect(t) && this.next(),
							t === this.tok.T_ENDSWITCH && this.expectEndOfStatement(),
							e(null, n)
						);
					},
					read_case_list: function (t) {
						const e = this.node("case");
						let n = null;
						this.token === this.tok.T_CASE
							? (n = this.next().read_expr())
							: this.token === this.tok.T_DEFAULT
							? this.next()
							: this.expect([this.tok.T_CASE, this.tok.T_DEFAULT]),
							this.expect([":", ";"]) && this.next();
						const i = this.node("block"),
							r = [];
						for (
							;
							this.token !== this.EOF &&
							this.token !== t &&
							this.token !== this.tok.T_CASE &&
							this.token !== this.tok.T_DEFAULT;

						)
							r.push(this.read_inner_statement());
						return e(n, i(null, r));
					},
				};
			},
			{},
		],
		156: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_try: function () {
						this.expect(this.tok.T_TRY);
						const t = this.node("try");
						let e = null;
						const n = [],
							i = this.next().read_statement();
						for (; this.token === this.tok.T_CATCH; ) {
							const t = this.node("catch");
							this.next().expect("(") && this.next();
							const e = this.read_list(this.read_namespace_name, "|", !1);
							let i = null;
							this.token === this.tok.T_VARIABLE &&
								(i = this.read_variable(!0, !1)),
								this.expect(")"),
								n.push(t(this.next().read_statement(), e, i));
						}
						return (
							this.token === this.tok.T_FINALLY &&
								(e = this.next().read_statement()),
							t(i, n, e)
						);
					},
				};
			},
			{},
		],
		157: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_short_form: function (t) {
						const e = this.node("block"),
							n = [];
						for (
							this.expect(":") && this.next();
							this.token != this.EOF && this.token !== t;

						)
							n.push(this.read_inner_statement());
						return (
							0 === n.length &&
								this.extractDoc &&
								this._docs.length > this._docIndex &&
								n.push(this.node("noop")()),
							this.expect(t) && this.next(),
							this.expectEndOfStatement(),
							e(null, n)
						);
					},
					read_function_list: function (t, e) {
						const n = [];
						do {
							if (this.token == e && this.version >= 703 && n.length > 0) {
								n.push(this.node("noop")());
								break;
							}
							if ((n.push(t.apply(this, [])), this.token != e)) break;
							if (")" == this.next().token && this.version >= 703) break;
						} while (this.token != this.EOF);
						return n;
					},
					read_list: function (t, e, n) {
						const i = [];
						if (
							(this.token == e &&
								(n &&
									i.push("function" == typeof t ? this.node("noop")() : null),
								this.next()),
							"function" == typeof t)
						)
							do {
								const n = t.apply(this, []);
								if ((n && i.push(n), this.token != e)) break;
							} while (this.next().token != this.EOF);
						else {
							if (!this.expect(t)) return [];
							for (
								i.push(this.text());
								this.next().token != this.EOF &&
								this.token == e &&
								this.next().token == t;

							)
								i.push(this.text());
						}
						return i;
					},
					read_name_list: function () {
						return this.read_list(this.read_namespace_name, ",", !1);
					},
					read_byref: function (t) {
						let e = this.node("byref");
						this.next(), (e = e(null));
						const n = t();
						return (
							n && (this.ast.swapLocations(n, e, n, this), (n.byref = !0)), n
						);
					},
					read_variable_declarations: function () {
						return this.read_list(function () {
							const t = this.node("staticvariable");
							let e = this.node("variable");
							if (this.expect(this.tok.T_VARIABLE)) {
								const t = this.text().substring(1);
								this.next(), (e = e(t, !1));
							} else e = e("#ERR", !1);
							return "=" === this.token ? t(e, this.next().read_expr()) : e;
						}, ",");
					},
					read_extends_from: function () {
						return this.token === this.tok.T_EXTENDS
							? this.next().read_namespace_name()
							: null;
					},
					read_interface_extends_list: function () {
						return this.token === this.tok.T_EXTENDS
							? this.next().read_name_list()
							: null;
					},
					read_implements_list: function () {
						return this.token === this.tok.T_IMPLEMENTS
							? this.next().read_name_list()
							: null;
					},
				};
			},
			{},
		],
		158: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					read_variable: function (t, e) {
						let n;
						if ("&" === this.token)
							return this.read_byref(this.read_variable.bind(this, t, e));
						if (this.is([this.tok.T_VARIABLE, "$"]))
							n = this.read_reference_variable(e);
						else if (
							this.is([
								this.tok.T_NS_SEPARATOR,
								this.tok.T_STRING,
								this.tok.T_NAMESPACE,
							])
						) {
							n = this.node();
							const t = this.read_namespace_name();
							if (
								this.token != this.tok.T_DOUBLE_COLON &&
								"(" != this.token &&
								-1 === ["parentreference", "selfreference"].indexOf(t.kind)
							) {
								const e = t.name.toLowerCase();
								"true" === e
									? (n = t.destroy(n("boolean", !0, t.name)))
									: "false" === e
									? (n = t.destroy(n("boolean", !1, t.name)))
									: "null" === e
									? (n = t.destroy(n("nullkeyword", t.name)))
									: (n.destroy(t), (n = t));
							} else n.destroy(t), (n = t);
						} else if (this.token === this.tok.T_STATIC) {
							n = this.node("staticreference");
							const t = this.text();
							this.next(), (n = n(t));
						} else this.expect("VARIABLE");
						return (
							this.token === this.tok.T_DOUBLE_COLON &&
								(n = this.read_static_getter(n, e)),
							this.recursive_variable_chain_scan(n, t, e)
						);
					},
					read_static_getter: function (t, e) {
						const n = this.node("staticlookup");
						let i, r;
						return (
							this.next().is([this.tok.T_VARIABLE, "$"])
								? (i = this.read_reference_variable(e))
								: this.token === this.tok.T_STRING ||
								  this.token === this.tok.T_CLASS ||
								  (this.version >= 700 && this.is("IDENTIFIER"))
								? ((i = this.node("identifier")),
								  (r = this.text()),
								  this.next(),
								  (i = i(r)))
								: "{" === this.token
								? ((i = this.node("literal")),
								  (r = this.next().read_expr()),
								  this.expect("}") && this.next(),
								  (i = i("literal", r, null)),
								  this.expect("("))
								: (this.error([this.tok.T_VARIABLE, this.tok.T_STRING]),
								  (i = this.node("identifier")),
								  (r = this.text()),
								  this.next(),
								  (i = i(r))),
							n(t, i)
						);
					},
					read_what: function (t = !1) {
						let e = null,
							n = null;
						switch (this.next().token) {
							case this.tok.T_STRING:
								(e = this.node("identifier")),
									(n = this.text()),
									this.next(),
									(e = e(n)),
									t &&
										this.token === this.tok.T_OBJECT_OPERATOR &&
										this.error();
								break;
							case this.tok.T_VARIABLE:
								(e = this.node("variable")),
									(n = this.text().substring(1)),
									this.next(),
									(e = e(n, !1));
								break;
							case "$":
								(e = this.node()),
									this.next().expect(["$", "{", this.tok.T_VARIABLE]),
									"{" === this.token
										? ((n = this.next().read_expr()),
										  this.expect("}") && this.next(),
										  (e = e("variable", n, !0)))
										: ((n = this.read_expr()), (e = e("variable", n, !1)));
								break;
							case "{":
								(e = this.node("encapsedpart")),
									(n = this.next().read_expr()),
									this.expect("}") && this.next(),
									(e = e(n, "complex", !1));
								break;
							default:
								this.error([this.tok.T_STRING, this.tok.T_VARIABLE, "$", "{"]),
									(e = this.node("identifier")),
									(n = this.text()),
									this.next(),
									(e = e(n));
						}
						return e;
					},
					recursive_variable_chain_scan: function (t, e, n) {
						let i, r;
						t: for (; this.token != this.EOF; )
							switch (this.token) {
								case "(":
									if (e) return t;
									t = this.node("call")(t, this.read_argument_list());
									break;
								case "[":
								case "{": {
									const e = "[" === this.token;
									if (
										((i = this.node("offsetlookup")), this.next(), (r = !1), n)
									)
										(r = this.read_encaps_var_offset()),
											this.expect(e ? "]" : "}") && this.next();
									else {
										(e ? "]" !== this.token : "}" !== this.token)
											? ((r = this.read_expr()),
											  this.expect(e ? "]" : "}") && this.next())
											: this.next();
									}
									t = i(t, r);
									break;
								}
								case this.tok.T_DOUBLE_COLON:
									"staticlookup" === t.kind &&
										"identifier" === t.offset.kind &&
										this.error(),
										(i = this.node("staticlookup")),
										(t = i(t, this.read_what(!0)));
									break;
								case this.tok.T_OBJECT_OPERATOR:
									(i = this.node("propertylookup")),
										(t = i(t, this.read_what()));
									break;
								case this.tok.T_NULLSAFE_OBJECT_OPERATOR:
									(i = this.node("nullsafepropertylookup")),
										(t = i(t, this.read_what()));
									break;
								default:
									break t;
							}
						return t;
					},
					read_encaps_var_offset: function () {
						let t = this.node();
						if (this.token === this.tok.T_STRING) {
							const e = this.text();
							this.next(), (t = t("identifier", e));
						} else if (this.token === this.tok.T_NUM_STRING) {
							const e = this.text();
							this.next(), (t = t("number", e, null));
						} else if ("-" === this.token) {
							this.next();
							const e = -1 * this.text();
							this.expect(this.tok.T_NUM_STRING) && this.next(),
								(t = t("number", e, null));
						} else if (this.token === this.tok.T_VARIABLE) {
							const e = this.text().substring(1);
							this.next(), (t = t("variable", e, !1));
						} else {
							this.expect([
								this.tok.T_STRING,
								this.tok.T_NUM_STRING,
								"-",
								this.tok.T_VARIABLE,
							]);
							const e = this.text();
							this.next(), (t = t("identifier", e));
						}
						return t;
					},
					read_reference_variable: function (t) {
						let e,
							n = this.read_simple_variable();
						for (; this.token != this.EOF; ) {
							const i = this.node();
							if ("{" != this.token || t) {
								i.destroy();
								break;
							}
							(e = this.next().read_expr()),
								this.expect("}") && this.next(),
								(n = i("offsetlookup", n, e));
						}
						return n;
					},
					read_simple_variable: function () {
						let t,
							e = this.node("variable");
						if (
							this.expect([this.tok.T_VARIABLE, "$"]) &&
							this.token === this.tok.T_VARIABLE
						)
							(t = this.text().substring(1)), this.next(), (e = e(t, !1));
						else
							switch (("$" === this.token && this.next(), this.token)) {
								case "{": {
									const t = this.next().read_expr();
									this.expect("}") && this.next(), (e = e(t, !0));
									break;
								}
								case "$":
									e = e(this.read_simple_variable(), !1);
									break;
								case this.tok.T_VARIABLE: {
									t = this.text().substring(1);
									const n = this.node("variable");
									this.next(), (e = e(n(t, !1), !1));
									break;
								}
								default:
									this.error(["{", "$", this.tok.T_VARIABLE]),
										(t = this.text()),
										this.next(),
										(e = e(t, !1));
							}
						return e;
					},
				};
			},
			{},
		],
		159: [
			function (t, e, n) {
				"use strict";
				e.exports = {
					values: {
						101: "T_HALT_COMPILER",
						102: "T_USE",
						103: "T_ENCAPSED_AND_WHITESPACE",
						104: "T_OBJECT_OPERATOR",
						105: "T_STRING",
						106: "T_DOLLAR_OPEN_CURLY_BRACES",
						107: "T_STRING_VARNAME",
						108: "T_CURLY_OPEN",
						109: "T_NUM_STRING",
						110: "T_ISSET",
						111: "T_EMPTY",
						112: "T_INCLUDE",
						113: "T_INCLUDE_ONCE",
						114: "T_EVAL",
						115: "T_REQUIRE",
						116: "T_REQUIRE_ONCE",
						117: "T_NAMESPACE",
						118: "T_NS_SEPARATOR",
						119: "T_AS",
						120: "T_IF",
						121: "T_ENDIF",
						122: "T_WHILE",
						123: "T_DO",
						124: "T_FOR",
						125: "T_SWITCH",
						126: "T_BREAK",
						127: "T_CONTINUE",
						128: "T_RETURN",
						129: "T_GLOBAL",
						130: "T_STATIC",
						131: "T_ECHO",
						132: "T_INLINE_HTML",
						133: "T_UNSET",
						134: "T_FOREACH",
						135: "T_DECLARE",
						136: "T_TRY",
						137: "T_THROW",
						138: "T_GOTO",
						139: "T_FINALLY",
						140: "T_CATCH",
						141: "T_ENDDECLARE",
						142: "T_LIST",
						143: "T_CLONE",
						144: "T_PLUS_EQUAL",
						145: "T_MINUS_EQUAL",
						146: "T_MUL_EQUAL",
						147: "T_DIV_EQUAL",
						148: "T_CONCAT_EQUAL",
						149: "T_MOD_EQUAL",
						150: "T_AND_EQUAL",
						151: "T_OR_EQUAL",
						152: "T_XOR_EQUAL",
						153: "T_SL_EQUAL",
						154: "T_SR_EQUAL",
						155: "T_INC",
						156: "T_DEC",
						157: "T_BOOLEAN_OR",
						158: "T_BOOLEAN_AND",
						159: "T_LOGICAL_OR",
						160: "T_LOGICAL_AND",
						161: "T_LOGICAL_XOR",
						162: "T_SL",
						163: "T_SR",
						164: "T_IS_IDENTICAL",
						165: "T_IS_NOT_IDENTICAL",
						166: "T_IS_EQUAL",
						167: "T_IS_NOT_EQUAL",
						168: "T_IS_SMALLER_OR_EQUAL",
						169: "T_IS_GREATER_OR_EQUAL",
						170: "T_INSTANCEOF",
						171: "T_INT_CAST",
						172: "T_DOUBLE_CAST",
						173: "T_STRING_CAST",
						174: "T_ARRAY_CAST",
						175: "T_OBJECT_CAST",
						176: "T_BOOL_CAST",
						177: "T_UNSET_CAST",
						178: "T_EXIT",
						179: "T_PRINT",
						180: "T_YIELD",
						181: "T_YIELD_FROM",
						182: "T_FUNCTION",
						183: "T_DOUBLE_ARROW",
						184: "T_DOUBLE_COLON",
						185: "T_ARRAY",
						186: "T_CALLABLE",
						187: "T_CLASS",
						188: "T_ABSTRACT",
						189: "T_TRAIT",
						190: "T_FINAL",
						191: "T_EXTENDS",
						192: "T_INTERFACE",
						193: "T_IMPLEMENTS",
						194: "T_VAR",
						195: "T_PUBLIC",
						196: "T_PROTECTED",
						197: "T_PRIVATE",
						198: "T_CONST",
						199: "T_NEW",
						200: "T_INSTEADOF",
						201: "T_ELSEIF",
						202: "T_ELSE",
						203: "T_ENDSWITCH",
						204: "T_CASE",
						205: "T_DEFAULT",
						206: "T_ENDFOR",
						207: "T_ENDFOREACH",
						208: "T_ENDWHILE",
						209: "T_CONSTANT_ENCAPSED_STRING",
						210: "T_LNUMBER",
						211: "T_DNUMBER",
						212: "T_LINE",
						213: "T_FILE",
						214: "T_DIR",
						215: "T_TRAIT_C",
						216: "T_METHOD_C",
						217: "T_FUNC_C",
						218: "T_NS_C",
						219: "T_START_HEREDOC",
						220: "T_END_HEREDOC",
						221: "T_CLASS_C",
						222: "T_VARIABLE",
						223: "T_OPEN_TAG",
						224: "T_OPEN_TAG_WITH_ECHO",
						225: "T_CLOSE_TAG",
						226: "T_WHITESPACE",
						227: "T_COMMENT",
						228: "T_DOC_COMMENT",
						229: "T_ELLIPSIS",
						230: "T_COALESCE",
						231: "T_POW",
						232: "T_POW_EQUAL",
						233: "T_SPACESHIP",
						234: "T_COALESCE_EQUAL",
						235: "T_FN",
						236: "T_NULLSAFE_OBJECT_OPERATOR",
						237: "T_MATCH",
						238: "T_ATTRIBUTE",
					},
					names: {
						T_HALT_COMPILER: 101,
						T_USE: 102,
						T_ENCAPSED_AND_WHITESPACE: 103,
						T_OBJECT_OPERATOR: 104,
						T_STRING: 105,
						T_DOLLAR_OPEN_CURLY_BRACES: 106,
						T_STRING_VARNAME: 107,
						T_CURLY_OPEN: 108,
						T_NUM_STRING: 109,
						T_ISSET: 110,
						T_EMPTY: 111,
						T_INCLUDE: 112,
						T_INCLUDE_ONCE: 113,
						T_EVAL: 114,
						T_REQUIRE: 115,
						T_REQUIRE_ONCE: 116,
						T_NAMESPACE: 117,
						T_NS_SEPARATOR: 118,
						T_AS: 119,
						T_IF: 120,
						T_ENDIF: 121,
						T_WHILE: 122,
						T_DO: 123,
						T_FOR: 124,
						T_SWITCH: 125,
						T_BREAK: 126,
						T_CONTINUE: 127,
						T_RETURN: 128,
						T_GLOBAL: 129,
						T_STATIC: 130,
						T_ECHO: 131,
						T_INLINE_HTML: 132,
						T_UNSET: 133,
						T_FOREACH: 134,
						T_DECLARE: 135,
						T_TRY: 136,
						T_THROW: 137,
						T_GOTO: 138,
						T_FINALLY: 139,
						T_CATCH: 140,
						T_ENDDECLARE: 141,
						T_LIST: 142,
						T_CLONE: 143,
						T_PLUS_EQUAL: 144,
						T_MINUS_EQUAL: 145,
						T_MUL_EQUAL: 146,
						T_DIV_EQUAL: 147,
						T_CONCAT_EQUAL: 148,
						T_MOD_EQUAL: 149,
						T_AND_EQUAL: 150,
						T_OR_EQUAL: 151,
						T_XOR_EQUAL: 152,
						T_SL_EQUAL: 153,
						T_SR_EQUAL: 154,
						T_INC: 155,
						T_DEC: 156,
						T_BOOLEAN_OR: 157,
						T_BOOLEAN_AND: 158,
						T_LOGICAL_OR: 159,
						T_LOGICAL_AND: 160,
						T_LOGICAL_XOR: 161,
						T_SL: 162,
						T_SR: 163,
						T_IS_IDENTICAL: 164,
						T_IS_NOT_IDENTICAL: 165,
						T_IS_EQUAL: 166,
						T_IS_NOT_EQUAL: 167,
						T_IS_SMALLER_OR_EQUAL: 168,
						T_IS_GREATER_OR_EQUAL: 169,
						T_INSTANCEOF: 170,
						T_INT_CAST: 171,
						T_DOUBLE_CAST: 172,
						T_STRING_CAST: 173,
						T_ARRAY_CAST: 174,
						T_OBJECT_CAST: 175,
						T_BOOL_CAST: 176,
						T_UNSET_CAST: 177,
						T_EXIT: 178,
						T_PRINT: 179,
						T_YIELD: 180,
						T_YIELD_FROM: 181,
						T_FUNCTION: 182,
						T_DOUBLE_ARROW: 183,
						T_DOUBLE_COLON: 184,
						T_ARRAY: 185,
						T_CALLABLE: 186,
						T_CLASS: 187,
						T_ABSTRACT: 188,
						T_TRAIT: 189,
						T_FINAL: 190,
						T_EXTENDS: 191,
						T_INTERFACE: 192,
						T_IMPLEMENTS: 193,
						T_VAR: 194,
						T_PUBLIC: 195,
						T_PROTECTED: 196,
						T_PRIVATE: 197,
						T_CONST: 198,
						T_NEW: 199,
						T_INSTEADOF: 200,
						T_ELSEIF: 201,
						T_ELSE: 202,
						T_ENDSWITCH: 203,
						T_CASE: 204,
						T_DEFAULT: 205,
						T_ENDFOR: 206,
						T_ENDFOREACH: 207,
						T_ENDWHILE: 208,
						T_CONSTANT_ENCAPSED_STRING: 209,
						T_LNUMBER: 210,
						T_DNUMBER: 211,
						T_LINE: 212,
						T_FILE: 213,
						T_DIR: 214,
						T_TRAIT_C: 215,
						T_METHOD_C: 216,
						T_FUNC_C: 217,
						T_NS_C: 218,
						T_START_HEREDOC: 219,
						T_END_HEREDOC: 220,
						T_CLASS_C: 221,
						T_VARIABLE: 222,
						T_OPEN_TAG: 223,
						T_OPEN_TAG_WITH_ECHO: 224,
						T_CLOSE_TAG: 225,
						T_WHITESPACE: 226,
						T_COMMENT: 227,
						T_DOC_COMMENT: 228,
						T_ELLIPSIS: 229,
						T_COALESCE: 230,
						T_POW: 231,
						T_POW_EQUAL: 232,
						T_SPACESHIP: 233,
						T_COALESCE_EQUAL: 234,
						T_FN: 235,
						T_NULLSAFE_OBJECT_OPERATOR: 236,
						T_MATCH: 237,
						T_ATTRIBUTE: 238,
					},
				};
			},
			{},
		],
		160: [
			function (t, e, n) {
				var i,
					r,
					o = (e.exports = {});
				function s() {
					throw new Error("setTimeout has not been defined");
				}
				function a() {
					throw new Error("clearTimeout has not been defined");
				}
				function l(t) {
					if (i === setTimeout) return setTimeout(t, 0);
					if ((i === s || !i) && setTimeout)
						return (i = setTimeout), setTimeout(t, 0);
					try {
						return i(t, 0);
					} catch (e) {
						try {
							return i.call(null, t, 0);
						} catch (e) {
							return i.call(this, t, 0);
						}
					}
				}
				!(function () {
					try {
						i = "function" == typeof setTimeout ? setTimeout : s;
					} catch (t) {
						i = s;
					}
					try {
						r = "function" == typeof clearTimeout ? clearTimeout : a;
					} catch (t) {
						r = a;
					}
				})();
				var c,
					h = [],
					u = !1,
					f = -1;
				function d() {
					u &&
						c &&
						((u = !1),
						c.length ? (h = c.concat(h)) : (f = -1),
						h.length && p());
				}
				function p() {
					if (!u) {
						var t = l(d);
						u = !0;
						for (var e = h.length; e; ) {
							for (c = h, h = []; ++f < e; ) c && c[f].run();
							(f = -1), (e = h.length);
						}
						(c = null),
							(u = !1),
							(function (t) {
								if (r === clearTimeout) return clearTimeout(t);
								if ((r === a || !r) && clearTimeout)
									return (r = clearTimeout), clearTimeout(t);
								try {
									r(t);
								} catch (e) {
									try {
										return r.call(null, t);
									} catch (e) {
										return r.call(this, t);
									}
								}
							})(t);
					}
				}
				function g(t, e) {
					(this.fun = t), (this.array = e);
				}
				function m() {}
				(o.nextTick = function (t) {
					var e = new Array(arguments.length - 1);
					if (arguments.length > 1)
						for (var n = 1; n < arguments.length; n++) e[n - 1] = arguments[n];
					h.push(new g(t, e)), 1 !== h.length || u || l(p);
				}),
					(g.prototype.run = function () {
						this.fun.apply(null, this.array);
					}),
					(o.title = "browser"),
					(o.browser = !0),
					(o.env = {}),
					(o.argv = []),
					(o.version = ""),
					(o.versions = {}),
					(o.on = m),
					(o.addListener = m),
					(o.once = m),
					(o.off = m),
					(o.removeListener = m),
					(o.removeAllListeners = m),
					(o.emit = m),
					(o.prependListener = m),
					(o.prependOnceListener = m),
					(o.listeners = function (t) {
						return [];
					}),
					(o.binding = function (t) {
						throw new Error("process.binding is not supported");
					}),
					(o.cwd = function () {
						return "/";
					}),
					(o.chdir = function (t) {
						throw new Error("process.chdir is not supported");
					}),
					(o.umask = function () {
						return 0;
					});
			},
			{},
		],
	},
	{},
	[1]
);
