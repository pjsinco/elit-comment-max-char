var sass = require('node-sass');

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
  
    sass: {
      options: {
        sourceMap: false,
        implementation: sass,
      },
      dev: {
        files: {
          'public/styles/<%= pkg.name %>.css': 'src/styles/style.scss',
        },
      },
    },

    notify: {
      sass: {
        options: {
          title: 'Sass',
          message: 'Sassed!',
        },
      },
      scripts: {
        options: {
          title: 'JS',
          message: 'Uglified!',
        },
      },
    },

    autoprefixer: {
      css: {
        src: 'public/styles/<%= pkg.name %>.css',
        options: {
          browsers: [
            '> 1%',
            'last 2 versions',
            'Firefox ESR',
            'iOS >= 7',
            'ie >= 10'
          ],
        },
      },
    },

    watch: {
      sass: {
        files: ['src/sass/**/*.scss'],
        tasks: ['sass:dev', 'notify:sass', 'autoprefixer:css' ],
      },
      scripts: {
        files: ['src/scripts/**/*.js'],
        tasks: ['uglify:build', 'notify:scripts'],
      },
    },

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-notify');
  grunt.loadNpmTasks("grunt-autoprefixer");
  grunt.registerTask('compile-sass', ['sass:dev', 'notify:sass']);
  grunt.registerTask('default', ['watch']);
};
