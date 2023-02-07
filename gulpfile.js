var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');
const terser = require('gulp-terser');
const imagemin = require('gulp-imagemin');
const imagewebp = require('gulp-webp');

gulp.task('js:plugins', function () {
  return gulp.src(['./assets/js/main_plugins/*.js'])
    .pipe(concat('plugins.min.js'))
    .pipe(uglify())
	  .pipe(terser())
    .pipe(gulp.dest('./dist/js/'));
});

gulp.task('js:scripts', function () {
  return gulp.src(['./assets/js/main_scripts/*.js'])
    .pipe(concat('scripts.min.js'))
    .pipe(uglify())
	  .pipe(terser())
    .pipe(gulp.dest('./dist/js/'));
});

gulp.task('js:pages', function () {
  return gulp.src([
    './assets/js/main_pages/*.js',
    ])
    .pipe(concat('pages.min.js'))
    .pipe(uglify())
	  .pipe(terser())
    .pipe(gulp.dest('./dist/js/'));
});

gulp.task('js:datatables', function () {
  return gulp.src([
    './assets/js/main_datatables/*.js',
    ])
    .pipe(concat('datatables.min.js'))
    .pipe(uglify())
	  .pipe(terser())
    .pipe(gulp.dest('./dist/js/'));
});

gulp.task('css', function () {
  return gulp.src([
      './assets/css/style.css',
      './assets/css/plugins/*.css',
    ])
    .pipe(concat('vendor-all.min.css'))
    .pipe(cleanCSS({ compatibility: 'ie8' }))
    .pipe(gulp.dest('./dist/css/'));
});

gulp.task('css:custom', function () {
  return gulp.src([
      './assets/css/custom.css',
    ])
    .pipe(concat('custom.min.css'))
    .pipe(cleanCSS({ compatibility: 'ie8' }))
    .pipe(gulp.dest('./dist/css/'));
});

gulp.task('webpImage', function () {
  return gulp.src('./assets/images/**/*')
    .pipe(imagemin([
        imagemin.mozjpeg({quality: 80, progressive: true}),
        imagemin.optipng({optiminzationLevel: 2})
    ]))
    .pipe(imagewebp())
    .pipe(gulp.dest('./dist/images/'));
});

// gulp.task('webpImage:uploads', function () {
//   return gulp.src('./pages/uploads/pictures/**/*')
//     .pipe(imagemin([
//       imagemin.mozjpeg({quality: 80, progressive: true}),
//       imagemin.optipng({optiminzationLevel: 2})
//     ]))
//     .pipe(imagewebp())
//     .pipe(gulp.dest('./dist/pictures/'));
// });

gulp.task('webpImage:uploads', function () {
  return gulp.src('./pages/uploads/pictures/**/*')
    .pipe(gulpif(
      function(file) {
        // Membandingkan antara file asli dan file yang sudah di-optimize
        return !fs.existsSync('./dist/pictures/' + file.relative);
      },
      // Proses file yang belum di-optimize
      imagemin([
        imagemin.mozjpeg({quality: 80, progressive: true}),
        imagemin.optipng({optimizationLevel: 2})
      ]),
      // Membiarkan file yang sudah di-optimize tidak terproses ulang
      gulp.src('./dist/pictures/**/*')
    ))
    .pipe(imagewebp())
    .pipe(gulp.dest('./dist/pictures/'));
});


gulp.task('watch', function () {
  gulp.watch('./assets/js/main_plugins/*.js', gulp.series('js:plugins'));
  gulp.watch('./assets/js/main_script/*.js', gulp.series('js:scripts'));
  gulp.watch('./assets/js/main_pages/*.js', gulp.series('js:pages'));
  gulp.watch('./assets/js/main_datatables/*.js', gulp.series('js:datatables'));
  gulp.watch('./assets/css/style.css', gulp.series('css'));
  gulp.watch('./assets/css/custom.css', gulp.series('css:custom'));
  gulp.watch('./assets/css/plugins/*.css', gulp.series('css'));
  gulp.watch('./assets/images/**/*', gulp.series('webpImage'));
  gulp.watch('./pages/uploads/pictures/**/*', gulp.series('webpImage:uploads'));
});

gulp.task('default', gulp.series('js:plugins','js:scripts', 'js:pages', 'js:datatables',  'css', 'css:custom', 'webpImage','webpImage:uploads', 'watch'));