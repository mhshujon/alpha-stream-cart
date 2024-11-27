module.exports = function( grunt ) {
    'use strict';

    const fs = require( 'fs' ),
        pkgInfo = grunt.file.readJSON( 'package.json' );


    // Project configuration
    grunt.initConfig( {
        pkg: pkgInfo,
        copy: require( './.grunt-config/copy' ),
        clean: {
            main: ['build/']
        },
        //Compress build directory into <name>.zip and <name>-<version>.zip
        compress: {
            main: {
                options: {
                    mode: 'zip',
                        archive: './build/alpha-stream-cart-' + pkgInfo.version + '.zip'
                },
                expand: true,
                    cwd: 'build/',
                    src: ['**/*'],
                    dest: 'alpha-stream-cart'
            }
        },
        run: {
            options: {},
            removeDev: {
                cmd: 'composer',
                args: ['install', '--no-dev', '--ignore-platform-reqs', '--optimize-autoloader']
            },
            dumpautoload: {
                cmd: 'composer',
                args: ['dumpautoload', '-o']
            }
        }
    } );

    grunt.loadNpmTasks('grunt-run');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-compress');
    // grunt.loadNpmTasks('grunt-replace');
    // grunt.loadNpmTasks('grunt-text-replace');

    // Default task(s).
    grunt.registerTask( 'default', [
        'run:removeDev',
        'run:dumpautoload',
    ] );


    grunt.registerTask( 'copy-check', [
        'copy',
    ] );
    grunt.registerTask( 'build', [
        'default',
        'clean',
        'copy',
    ] );
    grunt.registerTask('zip', [
        'compress',
    ]);
};