module.exports = function(grunt) {
  grunt.initConfig({

	remotePath: "/var/www/html/btest/",
	testDir : "test/",
	pkg: grunt.file.readJSON('package.json'),
	
	
	rsync: {
		
		build:{

			options:{
				src: "../05/",
				dest: "~/Desktop/Builder/sources/proyectos/smartcycles/",
				recursive: true,
				exclude: [ "package.json", "vendor" , "node_modules" , "Gruntfile.js"]
			}
		}
	  },
	shell: {
		options: {
			stderr: false
		},
		test: {
			command: 'php <%= testDir %>bootstrap.php'
		}
		
	  },
	watch: {
		
	  	phpTest:{
	  		files: ['**/*.php'],
	  		tasks: [ 'shell:test' ] ,
	  		options: {
				livereload: false,
				reload: true,
				interrupt: true,
				livereloadOnError:false,
				dateFormat: function(time) {
	      					grunt.log.writeln('The watch finished in ' + time + 'ms at' + (new Date()).toString());
	      					grunt.log.writeln('Waiting for more changes...');
	    		}
		  }


	  	}
		
	}
	
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-rsync');
  grunt.loadNpmTasks('grunt-shell');
  
  grunt.registerTask('ver', ['watch:phpTest']);
  grunt.registerTask('build', ['shell:mountBuild', 'shell:mountBuild2' , 'rsync:build' ]);

  grunt.registerTask('default', [ 'shell:test']);
};