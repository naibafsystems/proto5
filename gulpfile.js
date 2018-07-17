/*
* Dependencias
*/
var gulp = require('gulp'),
    sequence = require('gulp-sequence'),
    jshint = require('gulp-jshint'),
    csslint = require('gulp-csslint'),
    concat = require('gulp-concat'),
    plumber = require('gulp-plumber'),
    uglify = require('gulp-uglify'),
    uglifycss = require('gulp-uglifycss');

var paths = {
    scripts: 'assets-dev/js/**/*.js',
    styles: 'assets-dev/css/*.css',
    destjs: 'assets/js/',
    destcss: 'assets/css/'
}

// define la tarea por default a ejecutar
// gulp.task('default', ['uglify','watch',]);
gulp.task('default', ['watch','uglify', 'uglifycss']);

// configura que archivos va a revisar y las tareas que ejecuta con los archivos
gulp.task('watch', function() {
  gulp.watch(paths.scripts, ['uglify']);
  gulp.watch(paths.scripts, ['uglifycss']);
});

// Minificacion de archivos .js
gulp.task('uglify', ['jshint'], function(){
    gulp.src(paths.scripts)
    .pipe(plumber())
    // .pipe(concat('todo.js'))
    .pipe(uglify())
    .pipe(gulp.dest(paths.destjs));
});

// minificacion de hojas de estilo .css
gulp.task('uglifycss', [], function() {
    gulp.src(paths.styles)
    // .pipe(uglifycss({
    //   "maxLineLen": 80,
    //   "uglyComments": true
    // }))
    .pipe(uglifycss())
    .pipe(gulp.dest(paths.destcss));
});

// revisión de codigos javaScript
gulp.task('jshint', function() {
    return gulp.src(paths.scripts)
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});

// revision de hojas de estilos css
gulp.task('lintcss', function() {
    gulp.src(paths.styles)
    .pipe(csslint())
    .pipe(csslint.formatter());
});