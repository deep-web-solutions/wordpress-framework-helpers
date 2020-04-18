module.exports = function( grunt ) {
    'use strict';

    // Load all grunt tasks matching the `grunt-*` pattern
    require( 'load-grunt-tasks' )( grunt );

    // Show elapsed time
    require( 'time-grunt' )( grunt );

    // Project configuration
    grunt.initConfig({
        package: grunt.file.readJSON( 'package.json' ),
        dirs: {
            lang: 'languages'
        },
        makepot: {
            framework: {
                options: {
                    cwd: '',
                    domainPath: 'languages',
                    exclude: [],
                    potFilename: 'dws-test-plugin.pot',
                    mainFile: 'bootstrap.php',
                    potHeaders: {
                        'report-msgid-bugs-to': 'https://github.com/Deep-Web-Solutions-GmbH/wordpress-framework-test-plugin/issues',
                        'project-id-version': '<%= package.title %> <%= package.version %>'
                    },
                    processPot: function( pot ) {
                        delete pot.headers['x-generator'];
                        return pot;
                    },
                    type: 'wp-plugin',
                    updateTimestamp: false,
                    updatePoFiles: true
                }
            }
        },
        potomo: {
            framework: {
                options: {
                    poDel: false
                },
                files: [{
                    expand: true,
                    cwd: '<%= dirs.lang %>',
                    src: ['*.po'],
                    dest: '<%= dirs.lang %>',
                    ext: '.mo',
                    nonull: true
                }]
            }
        }
    });

    grunt.registerTask( 'default', ['makepot', 'potomo'] );
}
