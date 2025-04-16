var gulp = require('gulp');
const browserSync = require('browser-sync').create();
const reload = browserSync.reload;

var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');
const terser = require('gulp-terser');
const imagemin = require('gulp-imagemin');
const imagewebp = require('gulp-webp');

gulp.task('browser-sync', function () {
  browserSync.init({
    proxy: "localhost/bookingonline", // Ganti sesuai URL lokal project kamu
    notify: false,
    open: false,
    port: 3000
  });

  gulp.watch('./**/*.php').on('change', reload);
});

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

gulp.task('webpImage:uploads', function () {
  return gulp.src('./pages/uploads/pictures/**/*')
    .pipe(imagemin([
      imagemin.mozjpeg({quality: 80, progressive: true}),
      imagemin.optipng({optiminzationLevel: 2})
    ]))
    .pipe(imagewebp())
    .pipe(gulp.dest('./dist/pictures/'));
});

gulp.task('watch', function () {
  gulp.watch('./assets/js/main_plugins/*.js', gulp.series('js:plugins')).on('change', reload);
  gulp.watch('./assets/js/main_script/*.js', gulp.series('js:scripts')).on('change', reload);
  gulp.watch('./assets/js/main_pages/*.js', gulp.series('js:pages')).on('change', reload);
  gulp.watch('./assets/js/main_datatables/*.js', gulp.series('js:datatables')).on('change', reload);
  gulp.watch('./assets/css/style.css', gulp.series('css')).on('change', reload);
  gulp.watch('./assets/css/custom.css', gulp.series('css:custom')).on('change', reload);
  gulp.watch('./assets/css/plugins/*.css', gulp.series('css')).on('change', reload);
  gulp.watch('./assets/images/**/*', gulp.series('webpImage')).on('change', reload);
  gulp.watch('./pages/uploads/pictures/**/*', gulp.series('webpImage:uploads')).on('change', reload);
});


gulp.task('default', gulp.series(
  'js:plugins',
  'js:scripts',
  'js:pages',
  'js:datatables',
  'css',
  'css:custom',
  'webpImage',
  'webpImage:uploads',
  gulp.parallel('browser-sync', 'watch')
));
