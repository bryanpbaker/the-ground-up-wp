module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		auto_install: {
			local: {},
			subdir: {
				options: {
					cwd: 'subdir',
					stdout: true,
					stderr: true,
					failOnError: true,
					npm: '--production',
					bower: true
				}
			}
		},

		watch: {
			js_scripts: {
				files: 'assets/js/scripts/*.js',
				tasks: 'dist-js-scripts'
			},
			js_vendors: {
				files: 'assets/js/vendors/*.js',
				tasks: 'dist-js-vendors'
			},
			js_admin: {
				files: 'assets/js/admin/*.js',
				tasks: 'dist-js-admin'
			},
			js_main: {
				files: ['assets/js/scripts.js', 'assets/js/vendors.js', 'assets/js/admin.js'],
				tasks: 'dist-js-main'
			},
			css_styles: {
				files: 'assets/css/styles/**/*.scss',
				tasks: 'dist-css-styles',
				options: {
					livereload: true,
				}
			},
			css_vendors: {
				files: 'assets/css/vendors/**/*.scss',
				tasks: 'dist-css-vendors',
				options: {
					livereload: true,
				}
			},
			css_admin: {
				files: 'assets/css/admin/**/*.scss',
				tasks: 'dist-css-admin',
				options: {
					livereload: true,
				}
			},
			css_main: {
				files: ['assets/css/admin.css', 'assets/css/vendors.css', 'assets/css/styles.css'],
				tasks: 'dist-css-main',
				options: {
					livereload: true,
				}
			}
		},

		clean: {
			css: {
				styles: ['assets/css/styles.css', 'assets/css/styles.min.css', 'assets/css/styles.css.map'],
				vendors: ['assets/css/vendors.css', 'assets/css/vendors.min.css', 'assets/css/vendors.css.map'],
				admin: ['assets/css/admin.css', 'assets/css/admin.min.css', 'assets/css/admin.css.map']
			},
			js: {
				scripts: ['assets/js/scripts.js', 'assets/js/scripts.min.js'],
				vendors: ['assets/js/vendors.js', 'assets/js/vendors.min.js'],
				admin: ['assets/js/admin.js', 'assets/js/admin.min.js']
			}
		},

		concat: {
			options: {
				separator: ';',
			},
			scripts: {
				src: 'assets/js/scripts/*.js',
				dest: 'assets/js/scripts.js'
			},
			vendors: {
				src: 'assets/js/vendors/*.js',
				dest: 'assets/js/vendors.js'
			},
			admin: {
				src: 'assets/js/admin/*.js',
				dest: 'assets/js/admin.js'
			},
			main: {
				src: ['assets/js/admin.js', 'assets/js/vendors.js', 'assets/js/scripts.js'],
				dest: 'assets/js/main.js'
			},
			css_main: {
				src: ['assets/css/admin.css', 'assets/css/styles.css', 'assets/css/vendors.css'],
				dest: 'assets/css/main.css'
			}
		},

		uglify: {
			scripts: {
				src: 'assets/js/scripts.js',
				dest: 'assets/js/scripts.min.js'
			},
			vendors: {
				src: 'assets/js/vendors.js',
				dest: 'assets/js/vendors.min.js'
			},
			admin: {
				src: 'assets/js/admin.js',
				dest: 'assets/js/admin.min.js'
			},
			main: {
				src: 'assets/js/main.js',
				dest: 'assets/js/main.min.js'
			}
		},

		sass: {
			styles: {
				options: {
					style: 'expanded'
				},
				files: {
					'assets/css/styles.css': 'assets/css/styles/styles.scss'
				}
			},
			vendors: {
				options: {
					style: 'expanded'
				},
				files: {
					'assets/css/vendors.css': 'assets/css/vendors/vendors.scss'
				}
			},
			admin: {
				options: {
					style: 'expanded'
				},
				files: {
					'assets/css/admin.css': 'assets/css/admin/admin.scss'
				}
			}
		},

		autoprefixer: {
			options: {
				browsers: ['last 2 version', 'ie 8', 'ie 9']
			},
			// styles: {
			// 	src: 'assets/css/styles.css'
			// },
			// admin: {
			// 	src: 'assets/css/admin.css'
			// },
			main: {
				src: 'assets/css/main.css'
			},
		},

		cssmin: {
			// styles: {
			// 	expand: true,
			// 	cwd: 'assets/css',
			// 	src: ['styles.css'],
			// 	dest: 'assets/css',
			// 	ext: '.min.css'
			// },
			// vendors: {
			// 	expand: true,
			// 	cwd: 'assets/css',
			// 	src: ['vendors.css'],
			// 	dest: 'assets/css',
			// 	ext: '.min.css'
			// },
			// admin: {
			// 	expand: true,
			// 	cwd: 'assets/css',
			// 	src: ['admin.css'],
			// 	dest: 'assets/css',
			// 	ext: '.min.css'
			// },
			main: {
				expand: true,
				cwd: 'assets/css',
				src: ['main.css'],
				dest: 'assets/css',
				ext: '.min.css'
			}
		},

	});

	// These plugins provide necessary tasks
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-csslint');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-auto-install');

	// JS distribution task
	grunt.registerTask('dist-js', ['dist-js-scripts', 'dist-js-vendors', 'dist-js-admin', 'dist-js-main']);

	// JS Scripts distribution task
	grunt.registerTask('dist-js-scripts', ['clean:js:scripts', 'concat:scripts']);

	// JS Vendors distribution task
	grunt.registerTask('dist-js-vendors', ['clean:js:vendors', 'concat:vendors']);

	// JS Admin distribution task
	grunt.registerTask('dist-js-admin', ['clean:js:admin', 'concat:admin']);

	// JS Main distribution task
	grunt.registerTask('dist-js-main', ['concat:main', 'uglify:main']);

	// CSS distribution task
	grunt.registerTask('dist-css', ['dist-css-styles', 'dist-css-vendors', 'dist-css-admin', 'dist-css-main']);

	// CSS Styles distribution task
	grunt.registerTask('dist-css-styles', ['clean:css:styles', 'sass:styles']);

	// CSS Vendors distribution task
	grunt.registerTask('dist-css-vendors', ['clean:css:vendors', 'sass:vendors']);

	// CSS Admin distribution task
	grunt.registerTask('dist-css-admin', ['clean:css:admin', 'sass:admin']);

	// CSS Main distribution task
	grunt.registerTask('dist-css-main', ['concat:css_main', 'autoprefixer:main', 'cssmin:main']);

	// Full distribution task
	grunt.registerTask('dist', ['dist-css', 'dist-js']);

	// Default task
	grunt.registerTask('default', ['dist', 'watch']);

};
