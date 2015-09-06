/*jslint node: true */
module.exports = function (grunt) {
    'use strict';
    grunt.initConfig(
        {
            phpcs: {
                php: {
                    src: ['*.php', 'classes/*.php']
                },
                tests: {
                    src: ['tests/*.php']
                },
                Gruntfile: {
                    src: ['Gruntfile.js']
                }
            },
            phpunit: {
                classes: {
                }
            }
        }
    );

    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-phpunit');

    grunt.registerTask('lint', ['phpcs']);
    grunt.registerTask('test', ['phpunit']);
};
