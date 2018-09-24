/* global module:false */
module.exports = function(grunt) {

    var merge = require('merge'); // merge objects

    // config index
    var CONFIG_INDEX = {};
    var json_config_index = grunt.file.readJSON('public/js/src/config-index.json');
    var len = json_config_index.length;
    for (var i = 0; i < len; i++) {
        if (typeof json_config_index[i] === 'string') {
            CONFIG_INDEX['CONFIG.' + json_config_index[i].toUpperCase()] = i;
        } else {
            var key = Object.keys(json_config_index[i])[0];
            CONFIG_INDEX['CONFIG.' + key.toUpperCase()] = i;
            var sl = json_config_index[i][key].length;
            for (var si = 0; si < sl; si++) {

                if (typeof json_config_index[i][key][si] === 'string') {
                    CONFIG_INDEX['CONFIG.' + key.toUpperCase() + '_' + json_config_index[i][key][si].toUpperCase()] = si;
                } else {
                    var _key = Object.keys(json_config_index[i][key][si])[0];
                    CONFIG_INDEX['CONFIG.' + key.toUpperCase() + '_' + _key.toUpperCase()] = si;
                    var _sl = json_config_index[i][key][si][_key].length;
                    for (var _si = 0; _si < _sl; _si++) {
                        CONFIG_INDEX['CONFIG.' + key.toUpperCase() + '_' + _key.toUpperCase() + '_' + json_config_index[i][key][si][_key][_si].toUpperCase()] = _si;
                    }
                }

            }
        }
    }

    // closure compiler
    var CC = {}
    var CCfiles = {
        'public/js/abovethefold.min.js': 'public/js/min/abovethefold.js',
        'public/js/abovethefold-proxy.min.js': 'public/js/min/abovethefold-proxy.js',
        'public/js/abovethefold-jquery-stub.min.js': 'public/js/min/abovethefold-jquery-stub.js',
        'public/js/abovethefold-js-localstorage.min.js': 'public/js/min/abovethefold-js-localstorage.js',
        'public/js/abovethefold-js.min.js': 'public/js/min/abovethefold-js.js',
        'public/js/abovethefold-pwa-unregister.min.js': 'public/js/min/abovethefold-pwa-unregister.js',
        'public/js/abovethefold-css.min.js': 'public/js/min/abovethefold-css.js',
        'public/js/abovethefold-loadcss-enhanced.min.js': 'public/js/min/abovethefold-loadcss-enhanced.js',
        'public/js/abovethefold-loadcss.min.js': 'public/js/min/abovethefold-loadcss.js',
        'public/js/abovethefold-pwa.min.js': 'public/js/min/abovethefold-pwa.js',
        'public/js/pwa-serviceworker.js': 'public/js/min/pwa.serviceworker.js',
        'admin/js/css-extract-widget.min.js': 'public/js/min/css-extract-widget.js'
    };

    var srcfile;
    for (var file in CCfiles) {
        if (!CCfiles.hasOwnProperty(file)) {
            continue;
        }

        CC[file] = {
            closurePath: '../closure-compiler',
            js: CCfiles[file],
            jsOutputFile: file,
            //reportFile: 'public/js/closure-compiler/reports/pagespeed+' + keys.join('+') + '.txt',
            noreport: true,
            maxBuffer: 500,
            options: {
                compilation_level: 'ADVANCED_OPTIMIZATIONS',
                language_in: 'ECMASCRIPT5_STRICT',
                externs: ['public/js/closure-compiler/abtf-externs.js']
            }
        };

        // debug
        srcfile = CCfiles[file].replace('.js', '.debug.js');

        if (file.indexOf('admin/js/') !== -1) {
            continue;
        }

        if (file.indexOf('pwa-serviceworker') !== -1) {
            file = file.replace('.js', '.debug.js');
        } else {
            file = file.replace('.min.js', '.debug.min.js');
        }

        CC[file] = {
            closurePath: '../closure-compiler',
            js: srcfile,
            jsOutputFile: file,
            //reportFile: 'public/js/closure-compiler/reports/pagespeed+' + keys.join('+') + '.txt',
            noreport: true,
            maxBuffer: 500,
            options: {
                compilation_level: 'ADVANCED_OPTIMIZATIONS',
                language_in: 'ECMASCRIPT5_STRICT',
                externs: ['public/js/closure-compiler/abtf-externs.js']
            }
        };
    }

    // Project configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        meta: {
            banner: '/*! Above The Fold Optimization v<%= pkg.version %> */'
        },

        'closure-compiler': CC,

        uglify: {
            options: {
                banner: ''
            },

            build: {
                options: {
                    compress: {
                        global_defs: merge({
                            "ABTFDEBUG": false
                        }, CONFIG_INDEX)
                    }
                },
                files: {

                    // Above The Fold Javascript Controller
                    'public/js/min/abovethefold.js': [
                        'public/js/src/abovethefold.js'
                    ],

                    // Proxy
                    'public/js/min/abovethefold-proxy.js': [
                        'public/js/src/abovethefold.proxy.js'
                    ],

                    // jQuery Stub
                    'public/js/min/abovethefold-jquery-stub.js': [
                        'public/js/src/abovethefold.jquery-stub.js'
                    ],

                    // Javascript optimization
                    'public/js/min/abovethefold-js.js': [
                        'public/js/src/abovethefold.js.js',
                        'public/js/src/abovethefold.loadscript.js'
                    ],

                    // Javascript localstorage script loader
                    'public/js/min/abovethefold-js-localstorage.js': [
                        'public/js/src/abovethefold.loadscript-localstorage.js'
                    ],

                    // CSS optimization
                    'public/js/min/abovethefold-css.js': [
                        'public/js/src/abovethefold.css.js'
                    ],

                    // Enhanced loadCSS
                    'public/js/min/abovethefold-loadcss-enhanced.js': [
                        'public/js/src/abovethefold.loadcss-modified.js'
                    ],

                    // Original loadCSS
                    'public/js/min/abovethefold-loadcss.js': [
                        'public/js/src/loadcss.js',
                        'public/js/src/abovethefold.loadcss.js'
                    ],

                    // Critical CSS Editor
                    'public/js/critical-css-editor.min.js': [
                        'node_modules/jquery/dist/jquery.min.js',
                        'node_modules/split.js/split.min.js',
                        'admin/js/codemirror.min.js',
                        'public/js/src/critical-css-editor.js'
                    ],

                    // Critical CSS view
                    'public/js/critical-css-view.min.js': [
                        'admin/js/css-extract-widget.min.js',
                        'public/js/src/critical-css-view.js'
                    ],

                    // Extract full CSS view
                    'public/js/extractfull.min.js': [
                        'node_modules/jquery/dist/jquery.min.js',
                        'public/js/src/extractfull.js'
                    ],

                    // jQuery LazyLoad XT core
                    'public/js/jquery.lazyloadxt.min.js': [
                        'node_modules/lazyloadxt/dist/jquery.lazyloadxt.min.js'
                    ],

                    // jQuery LazyLoad XT widget module
                    'public/js/jquery.lazyloadxt.widget.min.js': [
                        'node_modules/lazyloadxt/dist/jquery.lazyloadxt.widget.min.js'
                    ],

                    // Extract full CSS view
                    'public/js/webfont.js': [
                        'node_modules/webfontloader/webfontloader.js',
                    ]
                }
            },

            // build debug client
            build_debug: {
                options: {
                    compress: {
                        global_defs: merge({
                            "ABTFDEBUG": true
                        }, CONFIG_INDEX)
                    }
                },
                files: {

                    // Above The Fold Javascript Controller
                    'public/js/min/abovethefold.debug.js': [
                        'public/js/src/abovethefold.js'
                    ],

                    // Proxy
                    'public/js/min/abovethefold-proxy.debug.js': [
                        'public/js/src/abovethefold.proxy.js'
                    ],

                    // Javascript optimization
                    'public/js/min/abovethefold-js.debug.js': [
                        'public/js/src/abovethefold.js.js',
                        'public/js/src/abovethefold.loadscript.js'
                    ],

                    // Javascript localstorage script loader
                    'public/js/min/abovethefold-js-localstorage.debug.js': [
                        'public/js/src/abovethefold.loadscript-localstorage.js'
                    ],

                    // jQuery Stub
                    'public/js/min/abovethefold-jquery-stub.debug.js': [
                        'public/js/src/abovethefold.jquery-stub.js'
                    ],

                    // CSS optimization
                    'public/js/min/abovethefold-css.debug.js': [
                        'public/js/src/abovethefold.css.js'
                    ],

                    // Enhanced loadCSS
                    'public/js/min/abovethefold-loadcss-enhanced.debug.js': [
                        'public/js/src/abovethefold.loadcss-modified.js'
                    ],

                    // Original loadCSS
                    'public/js/min/abovethefold-loadcss.debug.js': [
                        'public/js/src/loadcss.js',
                        'public/js/src/abovethefold.loadcss.js'
                    ]

                }
            },
            admin: {
                options: {
                    compress: {
                        global_defs: merge({
                            "ABTFDEBUG": false
                        }, CONFIG_INDEX)
                    }
                },
                files: {

                    // Original loadCSS
                    'admin/js/admincp.min.js': [
                        'admin/js/jquery.debounce.js',
                        'admin/js/admincp.js',
                        'admin/js/admincp.build-tool.js',
                        'admin/js/admincp.add-conditional.js',
                        'admin/js/admincp.criticalcss-editor.js',
                        'node_modules/selectize/dist/js/standalone/selectize.min.js'
                    ],

                    // admincp html
                    'admin/js/admincp-html.min.js': [
                        'admin/js/admincp-html.js'
                    ],

                    // admincp PWA
                    'admin/js/admincp-pwa.min.js': [
                        'admin/js/admincp-pwa.js'
                    ],

                    // admincp HTTP2
                    'admin/js/admincp-http2.min.js': [
                        'admin/js/admincp-http2.js'
                    ],

                    // Codemirror
                    'admin/js/codemirror.min.js': [
                        'node_modules/codemirror/lib/codemirror.js',
                        'node_modules/codemirror/mode/css/css.js',
                        'admin/js/csslint.js',
                        'node_modules/codemirror/addon/lint/lint.js',
                        'node_modules/codemirror/addon/lint/css-lint.js'
                    ],

                    // Critical CSS Extract widget
                    'public/js/min/css-extract-widget.js': [
                        'admin/js/css-extract-widget.js'
                    ],
                }
            },

            serviceworker: {
                options: {
                    compress: {
                        global_defs: merge({
                            "ABTFDEBUG": false
                        }, CONFIG_INDEX)
                    }
                },
                files: {

                    // Google PWA controller
                    'public/js/min/abovethefold-pwa.js': [
                        'public/js/src/abovethefold.pwa.js'
                    ],

                    // Google PWA `unregister controller
                    'public/js/min/abovethefold-pwa-unregister.js': [
                        'public/js/src/abovethefold.pwa-unregister.js'
                    ],

                    // Service Worker
                    'public/js/min/pwa.serviceworker.js': [
                        'public/js/src/pwa.serviceworker.js'
                    ]
                }
            },

            serviceworker_debug: {
                options: {
                    compress: {
                        global_defs: merge({
                            "ABTFDEBUG": true
                        }, CONFIG_INDEX)
                    }
                },
                files: {

                    // Google PWA controller
                    'public/js/min/abovethefold-pwa.debug.js': [
                        'public/js/src/abovethefold.pwa.js'
                    ],

                    // Google PWA `unregister controller
                    'public/js/min/abovethefold-pwa-unregister.debug.js': [
                        'public/js/src/abovethefold.pwa-unregister.js'
                    ],
                    // Service Worker
                    'public/js/min/pwa.serviceworker.debug.js': [
                        'public/js/src/pwa.serviceworker.js'
                    ]
                }
            }
        },

        cssmin: {

            admincp: {
                options: {
                    banner: '',
                    advanced: true,
                    aggressiveMerging: true,
                    processImport: true
                },
                files: {
                    'admin/css/admincp.min.css': [
                        'admin/css/admincp.css',
                        'admin/css/admincp-criticalcss.css',
                        'admin/css/admincp-mobile.css',
                        'node_modules/selectize/dist/css/selectize.default.css'
                    ],
                    'admin/css/admincp-global.min.css': [
                        'admin/css/admincp-global.css'
                    ],
                    'admin/css/admincp-jsoneditor.min.css': [
                        'admin/css/admincp-jsoneditor.css'
                    ],
                    'admin/css/codemirror.min.css': [
                        'node_modules/codemirror/lib/codemirror.css',
                        'node_modules/codemirror/addon/lint/lint.css'
                    ],
                    'public/css/critical-css-editor.min.css': [
                        'admin/css/codemirror.min.css',
                        'public/css/src/critical-css-editor.css'
                    ],
                    'public/css/extractfull.min.css': [
                        'public/css/src/extractfull.css'
                    ]
                }
            }
        },

        /**
         * Copy files
         */
        copy: {
            webfont_package: {
                src: 'node_modules/webfontloader/package.json',
                dest: 'public/js/src/webfontjs_package.json'
            },
            jquery_lazyxt_package: {
                src: 'node_modules/lazyloadxt/package.json',
                dest: 'public/js/src/lazyloadxt_package.json'
            },
            /*loadcss_package: {
                src: 'bower_components/loadcss/package.json',
                dest: 'public/js/src/loadcss_package.json'
            },*/
            serviceworker: {
                src: 'public/js/pwa-serviceworker.js',
                dest: '../test-blog/abtf-pwa.js'
            },
            serviceworker_debug: {
                src: 'public/js/pwa-serviceworker.debug.js',
                dest: '../test-blog/abtf-pwa.debug.js'
            },
            test_serviceworker: {
                src: 'public/js/min/pwa.serviceworker.js',
                dest: 'public/js/pwa-serviceworker.js'
            },
            test_serviceworker_debug: {
                src: 'public/js/min/pwa.serviceworker.debug.js',
                dest: 'public/js/pwa-serviceworker.debug.js'
            },
            test_serviceworkerx: {
                src: 'public/js/min/pwa.serviceworker.js',
                dest: '../test-blog/abtf-pwa.js'
            },
            test_serviceworkerx_debug: {
                src: 'public/js/min/pwa.serviceworker.debug.js',
                dest: '../test-blog/abtf-pwa.debug.js'
            }
        }
    });

    // Load Dependencies
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    grunt.registerTask('build', ['uglify', 'closure-compiler', 'cssmin',
        'copy:webfont_package',
        'copy:jquery_lazyxt_package',
        //'copy:loadcss_package',
        'copy:serviceworker',
        'copy:serviceworker_debug'
    ]);

    grunt.registerTask('sw', ['uglify:serviceworker', 'uglify:serviceworker_debug',
        'copy:test_serviceworker', 'copy:test_serviceworker_debug',
        'copy:test_serviceworkerx', 'copy:test_serviceworkerx_debug'
    ]);

    grunt.registerTask('default', ['uglify', 'cssmin']);
};