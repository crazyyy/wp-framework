/*

Using Jquery for post snippet save button design

*/

jQuery(document).ready(function($){

    // editor code of css and js save button design
	if ($('#ps_option_meta_box').length) {
		$(".save-button-area").css({"display":"block",
			"margin-top":"-22px",
		});
	}
	// editor code save button functionality
	if( $('#pspro_snippet_shortcode').is(':checked') && $('.notice-error').length==0) {
		$('.save-button-area').css({'margin-top':'-2px'});
	}
	// change margin of save button on checkbox click
	$('#pspro_snippet_shortcode').on('click', function(){
		if( $(this).is(':checked') && $("#pspro_edit_shotcode_text").length!=0) {
			$(".save-button-area").css({"margin-top":"-2px"});
		}
		else if($(this).is(':checked')==false) {
			$(".save-button-area").css({"margin-top":"-48px"});
		}
	})

});




var post_snippets_editor_atts = {
	mode: "php-snippet",
	matchBrackets: true,
	extraKeys: { "Alt-F": "findPersistent" },
	gutters: ["CodeMirror-lint-markers"],
	lint: true,
	direction: "ltr",
	viewportMargin: 10,
	scrollbarStyle: 'native',
	theme: "default",
	indentWithTabs: true,
	tabSize: 4,
	indentUnit: 4,
	lineWrapping: true,
	lineNumbers: true,
	autoCloseBrackets: true,
	highlightSelectionMatches: true,
};

!(function e(t, r, n) {
	function o(c, d) {
		if (!r[c]) {
			if (!t[c]) {
				var a = "function" == typeof require && require;
				if (!d && a) return a(c, !0);
				if (i) return i(c, !0);
				var u = new Error("Cannot find module '" + c + "'");
				throw ((u.code = "MODULE_NOT_FOUND"), u);
			}
			var p = (r[c] = { exports: {} });
			t[c][0].call(
				p.exports,
				function (e) {
					return o(t[c][1][e] || e);
				},
				p,
				p.exports,
				e,
				t,
				r,
				n
			);
		}
		return r[c].exports;
	}
	for (
		var i = "function" == typeof require && require, c = 0;
		c < n.length;
		c++
	)
		o(n[c]);
	return o;
})(
	{
		1: [
			function (e, t, r) {
				"use strict";
				var n, o, i, c;
				(window.post_snippets_editor =
					((n = window.Code_Snippets_CodeMirror),
					(o = post_snippets_editor_atts),
					// (i = function (e) {
					// 	return document.getElementById("save_snippet").click();
					// }),
					// (o.extraKeys = window.navigator.platform.match("Mac")
					// 	? { "Cmd-Enter": i, "Cmd-S": i }
					// 	: { "Ctrl-Enter": i, "Ctrl-S": i }),
					// window.navigator.platform.match("Mac") &&
					// 	(document.querySelector(".editor-help-text").className +=
					// 		" platform-mac"),
					n.fromTextArea(document.getElementById("ps_code_editor"), o)))//,
					// (c = document.getElementById("snippet-code-direction")) &&
					// 	c.addEventListener("change", function () {
					// 		window.post_snippets_editor.setOption(
					// 			"direction",
					// 			"rtl" === c.value ? "rtl" : "ltr"
					// 		);
					// 	});
			},
			{},
		],
	},
	{},
	[1]
);



