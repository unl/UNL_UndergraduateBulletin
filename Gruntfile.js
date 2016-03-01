module.exports = function (grunt) {
	var autoprefixPlugin = new (require('less-plugin-autoprefix'))({browsers: ["last 2 versions"]});
	var lessPluginCleanCss = new (require('less-plugin-clean-css'))();

	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		less: {
			all: {
				options: {
					paths: ['www/less'],
					plugins: [
						autoprefixPlugin,
						lessPluginCleanCss
					]
				},
				files: {
					"www/css/all.css": "www/less/all.less",
					"www/css/print.css": "www/less/print.less",
					"www/css/print_book.css": "www/less/print_book.less",
					"www/css/editions/2016.css": "www/less/editions/2016.less",
					"www/css/editions/2011.css": "www/less/editions/2011.less"
				}
			}
		},

		uglify: {
			options: {
				sourceMap: true
			},
			all: {
				files: {
					"www/scripts/bulletin.functions.min.js": "www/scripts/bulletin.functions.js"
				}
			}
		},

		watch: {
			less: {
				files: ['www/less/**/*.less'],
				tasks: ['less']
			}
		}
	});

	grunt.registerTask('default', ['less', 'uglify']);
};
