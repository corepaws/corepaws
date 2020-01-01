var
    // the staging url
    stage = 'https://corepaws.test',

    // directory variables
    src = './src/',
    dest = './',
    scss = src + 'sass/**/*.scss',
    srcJs = src + 'js/**/*.js',
    srcImg = src + 'img/**/*.+(png|jpg|jpeg|gif|svg)',
    srcFnt = src + 'fonts/**/*.{eot,svg,ttf,woff,woff2}',
    srcPhp = './**/*.php',

    // send in the clowns
    gulp = require('gulp'),
    sass = require('gulp-sass'),
    bSync = require('browser-sync').create(),
    combo = require('gulp-useref'),
    ugly = require('gulp-uglify'),
    gIf = require('gulp-if'),
    nano = require('gulp-cssnano'),
    imgMin = require('gulp-imagemin'),
    casht = require('gulp-cache'),
    del = require('del'),
    rts = require('run-sequence');

// browsersink biniss
gulp.task('bSync', function () {
    bSync.init({proxy: stage})
});

// grab up sassets
// NO LONGER USING - to allow dynamic SASS variables we're compiling using PHP
// gulp.task('sass', function () {
//     return gulp.src(scss)
//         .pipe(sass())
//         .pipe(nano())
//         //.pipe(ugly())
//         .pipe(gulp.dest(dest + 'css'))
//         .pipe(bSync.reload({
//             stream: true
//         }))
// });

// make the javascrptz
gulp.task('js', function () {
    return gulp.src(srcJs)
        .pipe(ugly())
        .pipe(gulp.dest(dest + 'js'))
        .pipe(bSync.reload({
            stream: true
        }))
});

// reload on php change
gulp.task('php', function () {
    return bSync.reload({
        stream: true
    })
});

// I am the watcher on the wall
gulp.task('watch', function () {
    gulp.watch(srcPhp, ['php']);
    gulp.watch(scss, ['sass']);
    gulp.watch(srcJs, ['js']);
});

// image grab, squeeze + place
gulp.task('img', function () {
    return gulp.src(srcImg)
        .pipe(casht(imgMin({
            // settings
        })))
        .pipe(gulp.dest(dest + 'img'))
});

// font grab
gulp.task('fonts', function () {
    return gulp.src(srcFnt)
        .pipe(gulp.dest(dest + 'fonts'))
});

// file tidy tidy
gulp.task('clean:dist', function () {
    return del.sync(dest + 'fonts', {force: true})
        && del.sync(dest + 'img', {force: true})
        // && del.sync(dest + 'css', {force: true})
        && del.sync(dest + 'js', {force: true})
});

// basic ass Gulp
gulp.task('default', function (cb) {
    rts([/*'sass', */'bSync'], ['js', 'img', 'fonts'], 'watch')
});

// let's build a theme
gulp.task('build', function (cb) {
    rts(
        // 'clean:dist',
        // 'sass', // no longer used, compiled via PHP now
        ['js', 'img', 'fonts'],
        cb
    )
});
