'use strict';
module.exports = function ( grunt ) {

    // load all grunt tasks matching the `grunt-*` pattern
    // Ref. https://npmjs.org/package/load-grunt-tasks
    require( 'load-grunt-tasks' )( grunt );

    grunt.initConfig( {
        /*
         * CSS minify
         * Compress and Minify CSS files
         * Ref. https://github.com/gruntjs/grunt-contrib-cssmin
         */
        cssmin: {
            target: {
                options: {
                    shorthandCompacting: false,
                    roundingPrecision: -1,
                    sourceMap: true,
                },
                files: {
                    'css-compressed/main-desktop-rtl.css': 'css/main-desktop-rtl.css',
                    'css-compressed/main-desktop.css': 'css/main-desktop.css',
                    'css-compressed/main-global-rtl.css': 'css/main-global-rtl.css',
                    'css-compressed/main-global.css': 'css/main-global.css',
                    'css-compressed/main-mobile-rtl.css': 'css/main-mobile-rtl.css',
                    'css-compressed/main-mobile.css': 'css/main-mobile.css',
                    'css-compressed/events/events-desktop-rtl.css': 'css/events/events-desktop-rtl.css',
                    'css-compressed/events/events-desktop.css': 'css/events/events-desktop.css',
                    'css-compressed/events/events-global-rtl.css': 'css/events/events-global-rtl.css',
                    'css-compressed/events/events-global.css': 'css/events/events-global.css',
                    'css-compressed/events/events-mobile-rtl.css': 'css/events/events-mobile-rtl.css',
                    'css-compressed/events/events-mobile.css': 'css/events/events-mobile.css',
                    'css-compressed/badgeos/badgeos.css': 'css/badgeos/badgeos.css',
                    'css-compressed/badgeos/badgeos-rtl.css': 'css/badgeos/badgeos-rtl.css',
                    'css-compressed/social-learner-rtl.css': 'css/social-learner-rtl.css',
                    'css-compressed/social-learner.css': 'css/social-learner.css',
                    'css-compressed/header-style-2-rtl.css': 'css/header-style-2-rtl.css',
                    'css-compressed/header-style-2.css': 'css/header-style-2.css',
                    'css-compressed/style-login-rtl.css': 'css/style-login-rtl.css',
                    'css-compressed/style-login.css': 'css/style-login.css'
                }
            }
        },
        /*
         * Uglify
         * Compress and Minify JS files
         * Ref. https://npmjs.org/package/grunt-contrib-uglify
         */
        uglify: {
            options: {
                banner: '/*! \n * Boss Theme JavaScript Library \n * @package Boss Theme \n */'
            },
            frontend: {
                src: [
                    'js/modernizr.min.js',
                    'js/ui-scripts/selectboxes.js',
                    'js/ui-scripts/fitvids.js',
                    'js/ui-scripts/jquery.cookie.js',
                    'js/ui-scripts/superfish.js',
                    'js/ui-scripts/hoverIntent.js',
                    'js/ui-scripts/imagesloaded.pkgd.js',
                    'js/ui-scripts/resize.js',
                    'js/jquery.growl.js',
                    'js/slider/slick.min.js',
                    'js/buddyboss.js',
                    'js/social-learner.js',
                    'js/boss-events.js'
                ],
                dest: 'js/compressed/boss-main-min.js'
            }
        },
        /*
         * Check text domain
         * Check your code for missing or incorrect text-domain in gettext functions
         * Ref. https://github.com/stephenharris/grunt-checktextdomain
         */
        checktextdomain: {
            options: {
                text_domain: [ 'boss', 'buddypress', 'bbpress', 'bp-docs', 'bpge', 'buddyboss-inbox', 'social-learner', 'invite-anyone', 'pmpro' ], //Specify allowed domain(s)
                keywords: [ //List keyword specifications
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,4d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d'
                ]
            },
            target: {
                files: [ {
                        src: [
                            '*.php',
                            '**/*.php',
                            '!node_modules/**',
                            '!tests/**',
                            '!buddyboss-inc/buddyboss-framework/admin/**',
                            '!buddyboss-inc/buddyboss-framework/boss-extensions/**',
                            '!admin/tgm/**'
                        ], //all php
                        expand: true
                    } ]
            }
        },
        /*
         * Makepot
         * Generate a POT file for translators to use when translating your plugin or theme.
         * Ref. https://github.com/cedaro/grunt-wp-i18n/blob/develop/docs/makepot.md
         */
        makepot: {
            target: {
                options: {
                    cwd: '.', // Directory of files to internationalize.
                    domainPath: 'languages/', // Where to save the POT file.
                    exclude: [ 'node_modules/*', 'admin/ReduxFramework/*' ], // List of files or directories to ignore.
                    mainFile: 'index.php', // Main project file.
                    potFilename: 'boss.pot', // Name of the POT file.
                    potHeaders: { // Headers to add to the generated POT file.
                        poedit: true, // Includes common Poedit headers.
                        'Last-Translator': 'BuddyBoss <support@buddyboss.com>',
                        'Language-Team': 'BuddyBoss <support@buddyboss.com>',
                        'report-msgid-bugs-to': 'https://www.buddyboss.com/contact/',
                        'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                    },
                    type: 'wp-theme', // Type of project (wp-plugin or wp-theme).
                    updateTimestamp: true, // Whether the POT-Creation-Date should be updated without other changes.
                    updatePoFiles: true // Whether to update PO files in the same directory as the POT file.
                }
            }
        },
        /*
         * .Po to .Mo
         * Grunt plug-in to compile .po files into binary .mo files with msgfmt.
         * Ref. https://github.com/axisthemes/grunt-potomo
         */
        potomo: {
            dist: {
                options: {
                    poDel: false
                },
                files: [
                    {
                        expand: true,
                        cwd: 'languages/',
                        src: [ '*.po' ],
                        dest: 'languages/',
                        ext: '.mo',
                        nonull: true
                    }
                ]
            }
        }
    } );

    // register task
    grunt.registerTask( 'default', [ 'cssmin', 'uglify', 'checktextdomain', 'makepot', 'potomo' ] );
};