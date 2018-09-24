/* global module:false */
module.exports = function(grunt) {

    var jpegtran = require('imagemin-jpegtran');

	// Project configuration
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		meta: {
			banner:
				'/*!\n' +
				' * Domain.com <%= pkg.version %>\n' +
				' * Optimized by https://optimalisatie.nl\n' +
				' */'
		},

        clean: {
            abovethefold: [
                'css/abovethefold/',
                'css/inline.raw.css'
            ]
        },

        /**
         * Manually optimize the CSS code (replace strings, rename paths etc)
         */
        replace: {
            globalcss: {
                src: ['css/global.min.css','css/inline.min.css'],
                overwrite: true,                 // overwrite matched source files
                replacements: [{
                    from: 'xxxCSS{...}',
                    to: ''
                },{
                    from: 'yyyCSS{...}',
                    to: ''
                }]
            },
            globalcssafterdata: {
                src: ['css/global.min.css','css/inline.min.css'],
                overwrite: true,                 // overwrite matched source files
                replacements: [{
                    from: 'xxxCSS{...}',
                    to: ''
                },{
                    from: 'yyyCSS{...}',
                    to: ''
                }]
            },
            inlinecss: {
                src: ['css/inline.min.css'],
                overwrite: true,                 // overwrite matched source files
                replacements: [{
                    from: 'xxxCSS{...}',
                    to: ''
                }]
            }
        },

        /**
         * Transform images to data-uri
         */
        dataUri: {
            dist: {
                // src file
                src: [
                    //'css/inline.min.css',
                    'css/global.min.css'
                ],
                // output dir
                dest: 'css/',
                options: {
                    target: ['css/fonts/*.*','images/*.*','images/icons/*.*',' woocommerce/images/*.*'],
                    baseDir: './',

                    // Do not inline any images larger
                    // than this size. 2048 is a size
                    // recommended by Google's mod_pagespeed.
                    maxBytes : 222048

                }
            }
        },

		cssmin: {

            /**
             * Optimize output of above the fold generator (use advanced options of CleanCSS for tuning)
             */
            inline_raw: {
                options: {
                    banner: '<%= meta.banner %>\n',
                    keepSpecialComments: false,
                    advanced: true,
                    aggressiveMerging: true
                },
                files: {
                    'css/inline.raw.css': [
                        'css/inline.raw.css'
                    ]
                }
            },

            /**
             * Compress above the fold CSS (inline.min.css contains the critical path CSS code to include in the <head> of the page)
             */
            inline: {
                options: {
                    banner: '<%= meta.banner %>\n',
                    keepSpecialComments: false
                },
                files: {
                    'css/inline.min.css': [
                        'css/inline.raw.css', // output of above the fold generator
                        'css/inline-ext.css' // extended CSS, included in the Above the fold CSS, useful to include small modifications
                    ]
                }
            }
		},

        /**
         * Critical Path CSS generator (above the fold)
         *
         * Create above the fold CSS for multiple pages and dimensions, then combine and compress the resulting CSS.
         */
        penthouse: {
            frontpage : {
                outfile : 'css/abovethefold/frontpage.css',
                css : 'css/full.css',
                url : 'https://WWW.WEBSITE.COM/',
                width : 1600,
                height : 1200
            },
            frontpage_mid : {
                outfile : 'css/abovethefold/frontpage_mid.css',
                css : 'css/full.css',
                url : 'https://WWW.WEBSITE.COM/',
                width : 1200,
                height : 800
            },
            frontpage_small : {
                outfile : 'css/abovethefold/frontpage_small2.css',
                css : 'css/full.css',
                url : 'https://www.dermarolling.nl/',
                width : 640,
                height : 400
            },
            product: {
                outfile : 'css/abovethefold/product.css',
                css : 'css/full.css',
                url : 'https://WWW.WEBSITE.COM/product/titanium/',
                width : 1600,
                height : 1200
            },
            product_mid: {
                outfile : 'css/abovethefold/product_mid.css',
                css : 'css/full.css',
                url : 'https://WWW.WEBSITE.COM/product/titanium/',
                width : 1200,
                height : 800
            },
            product_small: {
                outfile : 'css/abovethefold/product_small.css',
                css : 'css/full.css',
                url : 'https://WWW.WEBSITE.COM/product/titanium/',
                width : 640,
                height : 400
            },
            category: {
                outfile : 'css/abovethefold/category.css',
                css : 'css/full.css',
                url : 'https://WWW.WEBSITE.COM/product-category/w7-cosmetics/',
                width : 1600,
                height : 1200
            },
            category_mid: {
                outfile : 'css/abovethefold/category_mid.css',
                css : 'css/full.css',
                url : 'https://WWW.WEBSITE.COM/product-category/w7-cosmetics/',
                width : 1200,
                height : 800
            },
            category_small: {
                outfile : 'css/abovethefold/category_small.css',
                css : 'css/full.css',
                url : 'https://WWW.WEBSITE.COM/product-category/w7-cosmetics/',
                width : 640,
                height : 400
            }
        },

        /**
         * Combine above the fold CSS
         */
        concat: {
            options: {
                separator: ';',
            },
            dist: {
                src: [
                    'css/abovethefold/*.css'
                ],
                dest: 'css/inline.raw.css',
            },
        },

        /**
         * Beautify full CSS, this sometimes fixes malformed CSS
         */
        cssbeautifier : {
            files: ['css/full.css'],
            options: {
                indent: '  ',
                openbrace: 'end-of-line',
                autosemicolon: false
            }
        },

        /**
         * Split images from inline CSS to separate file to include in global CSS (via a functions.php include)
         */
        split_images: {
            inline: {
                options: {
                    output: 'css/inline.images.css'
                },
                files: {
                    'css/inline.raw.css': ['css/inline.raw.css']
                }
            }
        }
	});

	// Load Dependencies
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    /**
     * Task abovefold
     */
    grunt.registerTask( 'abovefold', [
        'clean:abovethefold',
        'cssmin:full',
        'penthouse',
        'concat',
        'cssmin:inline_raw',
        'cssmin:inline',
        'replace:inlinecss'
    ] );

    grunt.registerTask( 'default', [ 'abovefold' ] );
};
