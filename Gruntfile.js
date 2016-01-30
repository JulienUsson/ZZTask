module.exports = function(grunt) {

  grunt.initConfig({
    cssmin: {
      options: {
        sourceMap: true
      },
      target: {
        files: [{
          'src/assets/css/style.min.css': [
            'bower_components/bootswatch/lumen/bootstrap.css',
            'bower_components/angular-animate-css/build/nga.css',
            'src/assets/css/style.css'
          ]
        }]
      }
    },
    uglify: {
      options: {
        mangle: false,
        sourceMap: true
      },
      app: {
        files: {
          'src/assets/js/app.min.js': [
            'bower_components/angular/angular.js',
            'bower_components/angular-animate/angular-animate.js',
            'bower_components/angular-cookies/angular-cookies.js',
            'bower_components/angular-route/angular-route.js',
            'bower_components/angular-bootstrap/ui-bootstrap-tpls.js',
            'bower_components/markdown/lib/markdown.js',
            'src/assets/js/app.js'
          ]
        }
      }
    },
    watch: {
      css: {
        files: ['src/assets/css/style.css'],
        tasks: ['cssmin'],
      },
      js: {
        files: ['src/assets/js/app.js'],
        tasks: ['uglify'],
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['cssmin', 'uglify']);
};
