module.exports = function(grunt) {
  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    uglify: {
      build: {
        files: {
          'public/scripts/<%= pkg.name %>.min.js': 'src/scripts/main.js',
        },
      },   
    },
  
    notify: {
      scripts: {
        options: {
          title: 'JS',
          message: 'Uglified!',
        },
      },
    },

    watch: {
      scripts: {
        files: ['src/scripts/**/*.js'],
        tasks: ['uglify:build', 'notify:scripts'],
      },
    },

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-notify');
  grunt.registerTask('default', ['watch']);
};
