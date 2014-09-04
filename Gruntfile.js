module.exports = function( grunt ) {

    // Project configuration.
    grunt.initConfig({

        // grunt metadata
        pkg : grunt.file.readJSON( 'package.json' ),

        // directory variables
        dir : {
            output : 'ui/compressed',
            scripts : 'ui/scripts',
            stylesheets : 'ui/stylesheets',
            vendor : 'ui/vendor',
        },

        // assets configs
        assets : {
            stylesheets : grunt.file.readJSON( 'config/stylesheets.json' ),
            scripts : grunt.file.readJSON( 'config/scripts.json' ),
        },

        // tasks

        // clean task to clear out files and folders
        clean : {
            release : [
                '<%= dir.output %>'
            ]
        },

        // concat task to concat all css & js files
        concat : {
            css : {
                // this comes from a json file
                src : '<%= assets.stylesheets.files %>',
                // output here should be the apw-portfolio.v0.2.2
                dest : '<%= dir.output %>/<%= pkg.name %>.v<%= pkg.version %>.css'
            },
            js : {
                // this comes from a json file
                src : '<%= assets.scripts.files %>',
                dest : '<%= dir.output %>/<%= pkg.name %>.v<%= pkg.version %>.js'
            }
        },

        // cssmin task to minifiy the css files
        cssmin: {
            add_banner : {
                options: {
                     banner : '/*! <%= pkg.name %>: version <%= pkg.version %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
                },
                files: {
                    '<%= dir.output %>/<%= pkg.name %>.v<%= pkg.version %>.min.css' : ['<%= dir.output %>/<%= pkg.name %>.v<%= pkg.version %>.css']
                }
            }
        },

        // clean task to clear out files and folders
        jshint : {
            grunt : 'Gruntfile.js',
            scripts : [
                '<%= dir.scripts %>/**/*.js'
            ]
        },

        // uglify task to minify js
        uglify : {
            options : {
                 banner : '/*! <%= pkg.name %>: version <%= pkg.version %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build : {
                files: {
                    '<%= dir.output %>/<%= pkg.name %>.v<%= pkg.version %>.min.js' : ['<%= dir.output %>/<%= pkg.name %>.v<%= pkg.version %>.js']
                }
            }
        }

    });

    // Load the plugin that provides the "clean" task.
    grunt.loadNpmTasks( 'grunt-contrib-clean' );
    // Load the plugin that provides the "concat" task.
    grunt.loadNpmTasks( 'grunt-contrib-concat' );
    // Load the plugin that provides the "cssmin" task.
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
    // Load the plugin that provides the "jshint" task.
    grunt.loadNpmTasks( 'grunt-contrib-jshint' );
    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    // Load the plugin that provides the "watch" task.
    grunt.loadNpmTasks( 'grunt-contrib-watch' );

    // Default task(s).
    grunt.registerTask( 'default', '' );
    grunt.registerTask( 'dev', ['jshint', 'watch'] );
    grunt.registerTask( 'prod', ['clean:release', 'concat', 'uglify', 'cssmin'] );

};
