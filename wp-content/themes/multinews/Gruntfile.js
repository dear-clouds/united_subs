module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    
     /*
      concat: {
           dist: {
                   src: [
                       'js/all/*.js',
                   ],
                   dest: 'js/plugins.js',
               }
            },
*/
 uglify: {
      build: {
        src: 'js/plugins.js',
        dest: 'js/plugins.min.js',
      }
    },

        concat: {
            dist: {
                   src: [
                       'css/all/*.css',
                   ],
                   dest: 'css/plugins.css',
               }
            },               
   
    'cssmin': {
    'dist': {
        /* Plugins */
        'src': ['css/plugins.css'],
        'dest': 'css/plugins.min.css'

    }
    },
  
  });

  

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-yui-compressor');
  grunt.loadNpmTasks('grunt-sync');
  grunt.loadNpmTasks('grunt-contrib-copy');
  // Default task(s).
  grunt.registerTask('default', ['uglify']);
  grunt.registerTask('js', ['concat', 'uglify']);
  grunt.registerTask('css', ['concat', 'cssmin']);

};