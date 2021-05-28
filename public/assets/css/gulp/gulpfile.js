var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var minifyCSS = require('gulp-cssnano');

function swallowError (error) {
  console.log(error.toString())
  this.emit('end')
}

gulp.task('sass', function () {
    return gulp.src('./sass/*.scss')
        //.pipe(sourcemaps.init())
        .pipe(sass().on('error', swallowError))
        //.pipe(sourcemaps.write())
        .pipe(autoprefixer({
            overrideBrowserslist: [
                "> 1%",
                "last 2 versions",
                "iOS 8"
            ],
            cascade: false
        }))
        .pipe(gulp.dest('../'));
});

gulp.task('build', function() {
    return gulp.src('./sass/*.scss')
        .pipe(sass({
            style: 'compressed'
        }))
        .on('error', swallowError)
        .pipe(autoprefixer({
                overrideBrowserslist: [
                    "> 1%",
                    "last 2 versions",
                    "iOS 8"
                ],
                cascade: false
            }))
        .pipe(gulp.dest('../'))
        .pipe(minifyCSS())
        .pipe(gulp.dest('../'));;
})

gulp.task('watch', gulp.series('sass', function () {
    return gulp.watch('./**/*.scss', gulp.series('sass'));
}));
