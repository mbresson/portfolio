module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    csslint: {
      strict: {
        src: ['../../css/main.css']
      }
    },

    cssmin: {
      all: {
        files: [{
          expand: false,
          src: ['node_modules/normalize.css/normalize.css', '../../css/main.css'],
          dest: '../../css/main.min.css'
        }]
      }
    },

    less: {
      dev: {
        files: {
          '../../css/main.css': '../less/*.less'
        }
      }
    },

    jshint: {
      all: ['../js/*.js']
    },

    uglify: {
      all: {
        files: {
          '../../js/script.min.js': ['../js/*.js']
        }
      }
    },

    watch: {
      css: {
        files: ['../less/*.less'],

        tasks: ['css']
      },

      js: {
        files: ['../js/*.js'],

        tasks: ['js']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-csslint');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('css', ['less', 'csslint', 'cssmin']);
  grunt.registerTask('js', ['jshint', 'uglify']);
}
