/**
 * Critical CSS Quality Test View
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

jQuery(function($) {

    var currentView = 'split-h';
    var criticalCSS = '';

    // Create IE + others compatible event handler
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    // Listen to message from child window
    eventer(messageEvent, function(e) {
        if (e.data && e.data.action) {
            switch (e.data.action) {
                case "critical-css":
                    setCriticalCSS(e.data.css);
                    break;
            }
        }
    }, false);

    var criticalCSSCallbackQueue = [];
    var setCriticalCSS = function(css) {
        criticalCSS = css;

        if (cssEditor) {
            cssEditor.setValue(css);
        }

        if (criticalCSSCallbackQueue.length) {
            var q = criticalCSSCallbackQueue.splice(0);
            var cb = q.shift();
            while (cb) {
                cb(css);
                cb = q.shift();
            }
        }
    }

    var sendToIframe = function(data, frameTarget) {
        if (!frameTarget) {
            frameTarget = '#critical-css-view iframe';
        }
        var ifrmWin = $(frameTarget)[0].contentWindow;
        ifrmWin.postMessage(data, "*");
    }

    // Date.now polyfill
    if (!Date.now) {
        Date.now = function() {
            return new Date().getTime();
        }
    }

    var reloadCritical = function() {
        var link = $('#critical-css-view iframe').attr('src');
        if (link.indexOf('&t=') === -1) {
            link += '&t=' + Math.floor(Date.now() / 1000);
        } else {
            link = link.replace(/&t=([0-9]+)/, '&t=' + Math.floor(Date.now() / 1000));
        }
        return link;
    }

    var splitView = Split(['#critical-css-view', '#full-css-view'], {
        sizes: [50, 50]
    });

    var setCurrentView = function(view) {
        currentView = view;
        document.location.hash = '#' + view;

        switch (view) {
            case "editor":
                $('.syncscroll').hide();
                syncScroll(false);
                break;
            default:
                $('.syncscroll').show();
                syncScroll($('.syncscroll input[type="checkbox"]').is(':checked'));
                break;
        }
    }

    var viewSplitHorizontal = function() {
        if (splitView) {
            splitView.destroy();
            splitView = false;
        }
        $('#full-css-view').show();
        $('#critical-css-view').show();
        $('#css-editor-view').hide();

        $('.split').removeClass('split-vertical');
        $('.split').addClass('split-horizontal');

        splitView = Split(['#critical-css-view', '#full-css-view'], {
            sizes: [50, 50],
            direction: 'horizontal'
        });

        setCurrentView('split-h');

    };
    $('#btn_split_h').on('click', viewSplitHorizontal);

    var viewSplitVertical = function() {
        if (splitView) {
            splitView.destroy();
            splitView = false;
        }
        $('#full-css-view').show();
        $('#critical-css-view').show();
        $('#css-editor-view').hide();

        $('.split').removeClass('split-horizontal');
        $('.split').addClass('split-vertical');

        splitView = Split(['#critical-css-view', '#full-css-view'], {
            sizes: [50, 50],
            direction: 'vertical'
        });

        setCurrentView('split-v');
    };
    $('#btn_split_v').on('click', viewSplitVertical);

    var toggleSingleView = function() {

        if (splitView) {
            splitView.destroy();
            splitView = false;
        }

        $('#css-editor-view').hide();

        $('.split').removeClass('split-horizontal').removeClass('split-vertical');

        $('.split').css("width", "100%");

        var activeView = $('#btn_full_toggle').data('active-view');
        if (!activeView) {
            activeView = 'full';
        }

        if (activeView === 'critical-css') {
            activeView = 'full';
            $('#critical-css-view').hide();
            $('#full-css-view').show();
            $('#btn_full_toggle').data('active-view', 'full');
        } else {
            activeView = 'critical-css';
            $('#critical-css-view').show();
            $('#full-css-view').hide();
            $('#btn_full_toggle').data('active-view', 'critical-css');
        }

        setCurrentView('single-' + activeView);
    };
    $('#btn_full_toggle').on('click', toggleSingleView);

    var cssEditor;
    var loadEditorView = function(callback) {
        if (splitView) {
            splitView.destroy();
            splitView = false;
        }
        $('#full-css-view').hide();
        $('#critical-css-view').show();
        $('#css-editor-view').show();

        $('.split').removeClass('split-vertical');
        $('.split').addClass('split-horizontal');

        if (!$('abtfcss').data('editor')) {

            $('#abtfcss').prop('disabled', '');

            // codemirror
            cssEditor = CodeMirror.fromTextArea(
                $('#abtfcss')[0], {
                    lineWrapping: true,
                    lineNumbers: true,
                    gutters: ["CodeMirror-lint-markers"],
                    lint: true
                });
            cssEditor.on('change', function() {

                sendToIframe({
                    "action": "set",
                    "css": cssEditor.getValue()
                });
            });

            sendToIframe({
                "action": "get"
            });

            $('abtfcss').data('editor', cssEditor);
        }

        splitView = Split(['#critical-css-view', '#css-editor-view'], {
            sizes: [50, 50],
            direction: 'horizontal'
        });

        setCurrentView('editor');

        if (typeof callback === 'function') {
            callback();
        }
    };
    $('#btn_editor').on('click', loadEditorView);

    $('#btn_reload').on('click', function() {

        if (cssEditor) {
            $('#critical-css-view iframe').on('load', function() {
                sendToIframe({
                    "action": "get"
                });
                $('#critical-css-view iframe').off('load');
            });
        }
        $('#critical-css-view iframe').attr('src', reloadCritical());
    });

    $('#btn_open').on('click', function() {
        window.open(reloadCritical(), 'critical-css');
    });

    $('#btn_extract_critical_css').on('click', function() {

        var extract = function() {

            viewSplitHorizontal();

            criticalCSSCallbackQueue.push(function(css) {
                loadEditorView();
            });

            sendToIframe({
                "action": "extract",
                "type": "critical-css"
            }, '#full-css-view iframe');
        };
        if (currentView !== 'editor') {
            criticalCSSCallbackQueue.push(function(css) {
                setTimeout(function() {
                    extract();
                }, 100);
            });
            loadEditorView();
        } else {
            extract();
        }
    });
    $('#btn_extract_full_css').on('click', function() {

        $('#btn_full_toggle').data('active-view', 'critical-css');
        toggleSingleView();

        sendToIframe({
            "action": "extract",
            "type": "full-css"
        }, '#full-css-view iframe');
    });

    var syncScroll = function(enable) {
        var frm1 = $('#critical-css-view iframe');
        var frm2 = $('#full-css-view iframe');
        if (enable) {
            frm1.contents().scroll(function() {
                frm2.contents().scrollTop(frm1.contents().scrollTop());
            });

            frm2.contents().scroll(function() {
                frm1.contents().scrollTop(frm2.contents().scrollTop());
            });

            frm2.contents().scrollTop(frm1.contents().scrollTop());
        } else {
            frm1.contents().off('scroll');
            frm2.contents().off('scroll');
        }
    }

    $('.syncscroll input[type="checkbox"]').on('change', function() {
        syncScroll($(this).is(':checked'));
    });

    if (document.location.hash) {

        switch (document.location.hash) {
            case "#editor":
                loadEditorView();

                $('#critical-css-view iframe').on('load', function() {
                    sendToIframe({
                        "action": "get"
                    });
                    $('#critical-css-view iframe').off('load');
                });
                sendToIframe({
                    "action": "get"
                });
                break;
            case "#split-h":
                viewSplitHorizontal();
                break;
            case "#split-v":
                viewSplitVertical();
                break;
            case "#single-full":
                $('#btn_full_toggle').data('active-view', 'critical-css');
                toggleSingleView();
                break;
            case "#single-critical-css":
                $('#btn_full_toggle').data('active-view', 'full');
                toggleSingleView();
                break;
        }
    }
});