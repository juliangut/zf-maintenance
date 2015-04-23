module.exports = function(grunt) {
    require('time-grunt')(grunt);
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        dirs: {
            bin: 'vendor/bin',
            source: 'src',
            tests: 'tests',
            api: 'build/api',
            browse: 'build/browse',
            coverage: 'build/coverage',
            logs: 'build/logs'
        },

        mkdir: {
            reports: {
                options: {
                    create: ['<%= dirs.logs %>']
                }
            }
        },
        touch: {
            reports: {
                src: [
                    '<%= dirs.logs %>/pmd.xml',
                    '<%= dirs.logs %>/pmd-cpd.xml'
                ],
            }
        },

        phplint: {
            options: {
                swapPath: '/tmp'
            },
            application: [
                '<%= dirs.source %>/**/*.php',
                '<%= dirs.tests %>/**/*.php'
            ]
        },
        phpcs: {
            options: {
                bin: '<%= dirs.bin %>/phpcs',
                extensions: ['php'],
                standard: 'PSR2'
            },
            reports: {
                options: {
                    report: 'checkstyle',
                    reportFile: '<%= dirs.logs %>/checkstyle.xml',
                    ignoreExitCode: true
                },
                dir: [
                    '<%= dirs.source %>',
                    '<%= dirs.tests %>'
                ]
            },
            stdout: {
                dir: [
                    '<%= dirs.source %>',
                    '<%= dirs.tests %>'
                ]
            }
        },
        phpmd: {
            options: {
                bin: '<%= dirs.bin %>/phpmd',
                rulesets: 'phpmd.xml.dist'
            },
            reports: {
                options: {
                    reportFormat: 'xml',
                    reportFile: '<%= dirs.logs %>/pmd.xml'
                },
                dir: '<%= dirs.source %>'
            },
            stdout: {
                options: {
                    reportFormat: 'text'
                },
                dir: '<%= dirs.source %>'
            }
        },
        phpcpd: {
            options: {
                bin: '<%= dirs.bin %>/phpcpd',
                ignoreExitCode: true
            },
            reports: {
                options: {
                    reportFile: '<%= dirs.logs %>/pmd-cpd.xml'
                },
                dir: '<%= dirs.source %>'
            },
            stdout: {
                dir: '<%= dirs.source %>'
            }
        },
        shell: {
            phploc: {
                command: [
                    'php <%= dirs.bin %>/phploc',
                    '--count-tests',
                    '--log-xml <%= dirs.logs %>/phploc.xml',
                    '--log-csv <%= dirs.logs %>/phploc.cvs',
                    '--quiet',
                    '<%= dirs.source %>',
                    '<%= dirs.tests %>'
                ].join(' ')
            },
            pdepend: {
                command: [
                    'php <%= dirs.bin %>/pdepend',
                    '--jdepend-xml=<%= dirs.logs %>/jdepend.xml',
                    '--jdepend-chart=<%= dirs.logs %>/dependencies.svg',
                    '--overview-pyramid=<%= dirs.logs %>/overview-pyramid.svg',
                    '<%= dirs.source %>'
                ].join(' ')
            },
            phpcb: {
                command: [
                    'php <%= dirs.bin %>/phpcb',
                    '--log=<%= dirs.logs %>',
                    '--source=<%= dirs.source %>',
                    '--output=<%= dirs.browse %>'
                ].join(' ')
            }
        },
        phpdocumentor: {
            reports: {
                options: {
                    bin: '<%= dirs.bin %>/phpdoc.php',
                    directory : '<%= dirs.source %>',
                    target : '<%= dirs.api %>'
                }
            }
        },
        phpunit: {
            options: {
                bin: '<%= dirs.bin %>/phpunit',
                configuration: 'phpunit.xml.dist'
            },
            reports: {
                options: {
                    logJunit: '<%= dirs.logs %>/junit.xml',
                    coverageClover: '<%= dirs.logs %>/clover.xml',
                    coverageCrap4j: '<%= dirs.logs %>/crap4j.xml',
                    coverageHtml: '<%= dirs.coverage %>'
                }
            },
            stdout: {
                options: {
                    coverage: true
                }
            }
        },

        watch: {
            options: {
                spawn: false,
                event: ['added', 'changed'],
                atBegin: true
            },
            application: {
                files: [
                    '<%= dirs.source %>/**/*.php',
                    '<%= dirs.tests %>/**/*.php'
                ],
                tasks: ['check']
            },
        },
    });

    grunt.registerTask('check', ['phplint', 'phpcs:stdout', 'phpmd:stdout', 'phpcpd:stdout']);
    grunt.registerTask('test', ['phplint', 'phpunit:stdout']);
    grunt.registerTask('report', ['phplint', 'mkdir:reports', 'touch:reports', 'phpcs:reports', 'phpmd:reports', 'phpcpd:reports', 'shell:phploc', 'shell:pdepend', 'phpunit:reports', 'shell:phpcb', 'phpdocumentor:reports']);

    grunt.registerTask('default', ['check', 'phpunit:stdout']);
};
