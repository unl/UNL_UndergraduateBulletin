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
					"www/css/all.css": "www/less/all.less"
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

	grunt.registerTask('default', ['less']);
};
