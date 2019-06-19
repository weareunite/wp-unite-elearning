var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');
var gutil = require('gulp-util');
var sass = require('gulp-sass');
var pump = require('pump');
var dateFormat = require('dateformat');
var zip = require('gulp-zip');
var del = require('del');
var gulpFilter = require('gulp-filter');
var mainBowerFiles = require('gulp-main-bower-files');

var paths = {
    css: ['css/*.css', '!css/*.min.css'],
    js: ['js/*.js', '!js/*.min.js'],
    sass: ['scss/*.scss']
};

gulp.task("bower-files", gulp.series(function (cb) {

    pump([
            gulp.src('./bower.json'),
            mainBowerFiles({
                overrides: {
                    'jquery': {
                        main: []
                    }
                }

            }),
            gulpFilter('**/*.js'),
            gulp.dest('./js/vendor')
        ],
        pump([
            gulp.src('./bower.json'),
            mainBowerFiles(),
            gulpFilter('**/*.css'),
            gulp.dest('./css/vendor')
        ]), cb
    );

}));

gulp.task('sass', gulp.series(function (cb) {

    pump([
        gulp.src('./scss/*.scss'),
        sass().on('error', sass.logError),
        gulp.dest('./css')
    ], cb);

}));

gulp.task('copy', gulp.series(function (cb) {

    // cb();
    // return;

    // pump([
    //     gulp.src([]),
    //     gulp.dest('js')
    // ]);

    pump([
        gulp.src([
            'bower_components/flexboxgrid/dist/flexboxgrid.min.css',
            'bower_components/components-font-awesome/css/fontawesome-all.min.css'
        ]),
        gulp.dest('css')
    ]);

    pump([
        gulp.src([
            'bower_components/components-font-awesome/webfonts/*'
        ]),
        gulp.dest('webfonts')
    ], cb);

    // pump([
    //     gulp.src([]),
    //     gulp.dest('images')
    // ], cb);

}));

gulp.task('minify-css', gulp.series('sass', function (cb) {

    pump([
        gulp.src(paths.css),
        cleanCSS({compatibility: 'ie8'}),
        rename({
            suffix: '.min'
        }),
        gulp.dest('css')
    ], cb);

}));

gulp.task('minify-js', gulp.series(function (cb) {

    pump([
        gulp.src(paths.js),
        uglify(),
        rename({
            suffix: '.min'
        }),
        gulp.dest('js')
    ], cb);

}));

gulp.task('build', gulp.series('copy', 'minify-css', 'minify-js', function (cb) {

    pump([
        gulp.src([
            '**/*',
            '!node_modules',
            '!node_modules/**',
            '!bower_components',
            '!bower_components/**',
            '!scss',
            '!scss**',
            '!dist',
            '!dist/**',
            '!packaged',
            '!packaged/**',
            '!bower.json',
            '!gulpfile.js',
            '!package.json',
            '!package-lock.json',
            '!codesniffer.ruleset.xml',
            '!composer.*',
            '!*.md',
            '!**/*.scss'
        ]),
        gulp.dest('dist')
    ], cb);

}));

gulp.task('watch', gulp.series('build', function () {

    gulp.watch(paths.js, gulp.series('minify-js')).on('change', function (path, stats) {
        return path;
    });

    gulp.watch(paths.sass, gulp.series('sass', 'minify-css')).on('change', function (path, stats) {
        return path;
    });

    gutil.log(gutil.colors.green('Watching files ...'));

}));

gulp.task('package', gulp.series('build', function (cb) {

    var fs = require('fs');
    var time = dateFormat(new Date(), "yyyy-mm-dd_HH-MM");
    var pkg = JSON.parse(fs.readFileSync('./package.json'));
    var filename = pkg.name + '-' + pkg.version + '-' + time + '.zip';

    pump([
        gulp.src([
            './dist/**/*'
        ]),
        zip(filename),
        gulp.dest('packaged')
    ], cb);

}));

gulp.task('clean', gulp.series(function () {

    return del([
        'dist',
        'packaged'
    ]);

}));

gulp.task('default', gulp.series('build'));
