module.exports = function(grunt) {
    require('time-grunt')(grunt);
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        dirs: {
            bin: 'vendor/bin',
            source: 'src',
            tests: 'tests',
            browse: 'build/browse',
            coverage: 'build/coverage',
            reports: 'build/reports'
        },

        mkdir: {
            reports: {
                options: {
                    create: ['<%= dirs.reports %>']
                }
            }
        },
        touch: {
            reports: {
                src: [
                    '<%= dirs.reports %>/phpmd.xml',
                    '<%= dirs.reports %>/phpcpd.xml'
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
                standard: 'PSR2'
            },
            reports: {
                options: {
                    report: 'checkstyle',
                    reportFile: '<%= dirs.reports %>/checkstyle.xml',
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
                    reportFile: '<%= dirs.reports %>/phpmd.xml'
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
                    reportFile: '<%= dirs.reports %>/phpcpd.xml',
                    resultFile: '<%= dirs.reports %>/phpcpd.xml'
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
                    '--log-xml <%= dirs.reports %>/phploc.xml',
                    '--log-csv <%= dirs.reports %>/phploc.cvs',
                    '--quiet',
                    '<%= dirs.source %>'
                ].join(' ')
            },
            pdepend: {
                command: [
                    'php <%= dirs.bin %>/pdepend',
                    '--summary-xml=<%= dirs.reports %>/pdepend.xml',
                    '--jdepend-chart=<%= dirs.reports %>/chart.svg',
                    '--overview-pyramid=<%= dirs.reports %>/pyramid.svg',
                    '<%= dirs.source %>'
                ].join(' ')
            },
            phpcb: {
                command: [
                    'php <%= dirs.bin %>/phpcb',
                    '--log=<%= dirs.reports %>',
                    '--source=<%= dirs.source %>',
                    '--output=<%= dirs.browse %>'
                ].join(' ')
            }
        },
        phpunit: {
            options: {
                bin: '<%= dirs.bin %>/phpunit',
                configuration: 'phpunit.xml.dist'
            },
            reports: {
                options: {
                    logJunit: '<%= dirs.reports %>/junit.xml',
                    coverageClover: '<%= dirs.reports %>/clover.xml',
                    coverageCrap4j: '<%= dirs.reports %>/crap4j.xml',
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
    grunt.registerTask('report', ['phplint', 'mkdir:reports', 'touch:reports', 'phpcs:reports', 'phpmd:reports', 'phpcpd:reports', 'shell:phploc', 'shell:pdepend', 'phpunit:reports', 'shell:phpcb']);

    grunt.registerTask('default', ['check', 'phpunit:stdout']);
};
