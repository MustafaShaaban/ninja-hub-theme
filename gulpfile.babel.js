// Load Gulp plugins
const gulp         = require('gulp');
const sass         = require('gulp-sass')(require('sass'));
const sourcemaps   = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const rename       = require('gulp-rename');

const cleanCss = require('gulp-clean-css');
const rtlCss   = require('gulp-rtlcss');

const babel      = require('gulp-babel');
const uglify     = require('gulp-uglify');
const browserify = require('browserify');
const source     = require('vinyl-source-stream');
const babelify   = require('babelify');
const es         = require('event-stream');
const buffer     = require('vinyl-buffer');

const imagemin = require('gulp-imagemin');
const webp     = require('gulp-webp');

const sort  = require('gulp-sort');
const wpPot = require('gulp-wp-pot');

const notify = require('gulp-notify');

const paths = {
    styles: {
        admin: {
            watch: 'app/Models/admin/assets/sass/**/*.scss',
            src: 'app/Models/admin/assets/sass/style.scss',
            dest: 'app/Models/admin/css',
        },
        public: {
            watch: 'app/Models/public/assets/sass/**/*.scss',
            src: 'app/Models/public/assets/sass/style.scss',
            dest: './',
        },
    },
    scripts: {
        admin: {
            watch: 'app/Models/admin/assets/js/**/*.js',
            src: [
                'app/Models/admin/assets/js/**/*.js',
                '!app/Models/admin/assets/js/helpers/*.js',
                '!app/Models/admin/assets/js/inc/*.js',
                '!app/Models/admin/assets/js/modules/*.js',
            ],
            dest: 'app/Models/admin/js',
        },
        public: {
            watch: 'app/Models/public/assets/js/**/*.js',
            src: [
                'app/Models/public/assets/js/**/*.js',
                '!app/Models/public/assets/js/helpers/*.js',
                '!app/Models/public/assets/js/inc/*.js',
                '!app/Models/public/assets/js/modules/*.js',
            ],
            dest: 'app/Models/public/js',
        },
    },
    images: {
        admin: {
            watch: 'app/Models/admin/assets/images/**/*.{jpg,jpeg,png,gif,svg,webp}',
            src: 'app/Models/admin/assets/images/**/*.{jpg,jpeg,png,gif,svg,webp}',
            dest: 'app/Models/admin/img',
        },
        public: {
            watch: 'app/Models/public/assets/images/**/*.{jpg,jpeg,png,gif,svg,webp}',
            src: 'app/Models/public/assets/images/**/*.{jpg,jpeg,png,gif,svg,webp}',
            dest: 'app/Models/public/img',
        },
    },
    php: {
        watch: './**/*.php',
        src: './**/*.php',
        dest: './languages',
    },
};


/**==================================
 * Start compiling of public assets
 ==================================*/

gulp.task('publicStyles', () => {
    'use strict';

    return gulp.src(paths.styles.public.src)
               .pipe(sourcemaps.init())
               .pipe(sass()
                   .on('error', sass.logError))
               .pipe(autoprefixer())
               .pipe(gulp.dest(paths.styles.public.dest))
               .pipe(rename({ suffix: '.min' }))
               .pipe(cleanCss())
               .pipe(sourcemaps.write('.'))
               .pipe(gulp.dest(paths.styles.public.dest))
               .pipe(notify({
                   message: '\n\n=================================================\n====== STYLES PUBLIC RTL TASK — COMPLETED!' + ' ======\n=================================================\n',
                   onLast: true,
               }));
});

gulp.task('publicStylesRtl', () => {
    'use strict';

    return gulp.src(paths.styles.public.src)
               .pipe(sourcemaps.init())
               .pipe(sass()
                   .on('error', sass.logError))
               .pipe(autoprefixer())
               .pipe(rtlCss())
               .pipe(rename({ suffix: '-rtl' }))
               .pipe(gulp.dest(paths.styles.public.dest))
               .pipe(rename({ suffix: '.min' }))
               .pipe(cleanCss())
               .pipe(sourcemaps.write('.'))
               .pipe(gulp.dest(paths.styles.public.dest))
               .pipe(notify({
                   message: '\n\n=============================================\n====== STYLES PUBLIC TASK — COMPLETED!' + ' ======\n=============================================\n',
                   onLast: true,
               }));
});

gulp.task('publicScripts', (done) => {
    'use strict';

    gulp.src(paths.scripts.public.src, { base: './app/' })
        .pipe(es.mapSync(function (file) {
            return file.path;
        }))
        .pipe(es.writeArray(function (err, array) {
            if (err) throw err;

            array.map(function (singlePath) {
                let explodePathNames = singlePath.includes('\\') ? singlePath.split('\\') : singlePath.split('/'),
                    scriptFileName   = explodePathNames[explodePathNames.length - 1];

                browserify({
                    entries: singlePath,
                    debug: true,
                })
                    .transform(babelify.configure({
                        presets: ['@babel/preset-env'],
                    }))
                    .bundle()
                    .pipe(source(scriptFileName))
                    .pipe(gulp.dest(paths.scripts.public.dest))
                    .pipe(buffer())
                    .pipe(sourcemaps.init({ loadMaps: true }))
                    .pipe(rename({ suffix: '.min' }))
                    .pipe(uglify())
                    .pipe(sourcemaps.write('./'))
                    .pipe(gulp.dest(paths.scripts.public.dest))
                    .pipe(notify({
                        message: '\n\n==============================================\n====== SCRIPTS PUBLIC TASK — COMPLETED!' + ' ======\n==============================================\n',
                        onLast: true,
                    }));
            });
        }));
    done();
});

gulp.task('publicImages', () => {
    'use strict';

    return gulp.src(paths.images.public.src)
               .pipe(imagemin([
                   imagemin.mozjpeg({ quality: 25 }),
                   imagemin.optipng({ optimizationLevel: 3 }),
                   imagemin.gifsicle({ optimizationLevel: 3 }),
                   imagemin.svgo(),
               ]))
               .pipe(webp())
               .pipe(gulp.dest(paths.images.public.dest))
               .pipe(notify({
                   message: '\n\n====================================================\n====== MINIFY PUBLIC IMAGES TASK — COMPLETED!' + ' ======\n====================================================\n',
                   onLast: true,
               }));

});


/**==================================
 * Start compiling of admin assets
 ==================================*/

gulp.task('adminStyles', () => {
    'use strict';

    return gulp.src(paths.styles.admin.src)
               .pipe(sourcemaps.init())
               .pipe(sass()
                   .on('error', sass.logError))
               .pipe(autoprefixer())
               .pipe(gulp.dest(paths.styles.admin.dest))
               .pipe(rename({ suffix: '.min' }))
               .pipe(cleanCss())
               .pipe(sourcemaps.write('.'))
               .pipe(gulp.dest(paths.styles.admin.dest))
               .pipe(notify({
                   message: '\n\n===========================================\n====== STYLES ADMIN TASK — COMPLETED!' + ' ======\n===========================================\n',
                   onLast: true,
               }));
});

gulp.task('adminStylesRtl', () => {
    'use strict';

    return gulp.src(paths.styles.admin.src)
               .pipe(sourcemaps.init())
               .pipe(sass()
                   .on('error', sass.logError))
               .pipe(autoprefixer())
               .pipe(rtlCss())
               .pipe(rename({ suffix: '-rtl' }))
               .pipe(gulp.dest(paths.styles.admin.dest))
               .pipe(rename({ suffix: '.min' }))
               .pipe(cleanCss())
               .pipe(sourcemaps.write('.'))
               .pipe(gulp.dest(paths.styles.admin.dest))
               .pipe(notify({
                   message: '\n\n================================================\n====== STYLES ADMIN RTL TASK — COMPLETED!' + ' ======\n================================================\n',
                   onLast: true,
               }));
});

gulp.task('adminScripts', (done) => {
    'use strict';

    gulp.src(paths.scripts.admin.src, { base: './app/' })
        .pipe(es.mapSync(function (file) {
            return file.path;
        }))
        .pipe(es.writeArray(function (err, array) {
            if (err) throw err;

            array.map(function (singlePath) {
                let explodePathNames = singlePath.split('\\'),
                    scriptFileName   = explodePathNames[explodePathNames.length - 1];

                browserify({
                    entries: singlePath,
                    debug: true,
                })
                    .transform(babelify.configure({
                        presets: ['@babel/preset-env'],
                    }))
                    .bundle()
                    .pipe(source(scriptFileName))
                    .pipe(gulp.dest(paths.scripts.admin.dest))
                    .pipe(buffer())
                    .pipe(sourcemaps.init({ loadMaps: true }))
                    .pipe(rename({ suffix: '.min' }))
                    .pipe(uglify())
                    .pipe(sourcemaps.write('./'))
                    .pipe(gulp.dest(paths.scripts.admin.dest))
                    .pipe(notify({
                        message: '\n\n==============================================\n====== SCRIPTS ADMIN TASK — COMPLETED!' + ' ======\n==============================================\n',
                        onLast: true,
                    }));
            });
        }));

    done();
});

gulp.task('adminImages', () => {
    'use strict';

    return gulp.src(paths.images.admin.src)
               .pipe(imagemin([
                   imagemin.mozjpeg({ quality: 25 }),
                   imagemin.optipng({ optimizationLevel: 3 }),
                   imagemin.gifsicle({ optimizationLevel: 3 }),
                   imagemin.svgo(),
               ]))
               .pipe(webp())
               .pipe(gulp.dest(paths.images.admin.dest))
               .pipe(notify({
                   message: '\n\n=============================================\n====== MINIFY ADMIN IMAGES TASK — COMPLETED!' + ' ======\n=============================================\n',
                   onLast: true,
               }));

});


gulp.task('translate', () => {
    'use strict';

    return gulp.src(paths.php.src)
               .pipe(sort())
               .pipe(wpPot({
                   domain: 'ninja',
                   package: 'Medica Scope',
                   lastTranslator: 'Mustafa Shaaban <mushaaban@medicascopeco.com>',
                   team: 'Medica Scope Team',
               }))
               .pipe(gulp.dest(paths.php.dest + '/' + 'ninja.pot'))
               .pipe(notify({
                   message: '\n\n===========================================\n====== TRANSLATION TASK — COMPLETED!' + ' ======\n===========================================\n',
                   onLast: true,
               }));
});


gulp.task('default', gulp.parallel('publicStyles', 'publicStylesRtl', 'publicScripts', 'publicImages', 'adminStyles', 'adminStylesRtl', 'adminScripts', 'adminImages', 'translate', () => {
    'use strict';

    /**
     * Start watching public assets
     */
    gulp.watch(paths.styles.public.watch, gulp.parallel('publicStyles'));
    gulp.watch(paths.styles.public.watch, gulp.parallel('publicStylesRtl'));
    gulp.watch(paths.scripts.public.watch, gulp.parallel('publicScripts'));
    gulp.watch(paths.images.public.watch, gulp.parallel('publicImages'));

    /**
     * Start watching admin assets
     */
    gulp.watch(paths.styles.admin.watch, gulp.parallel('adminStyles'));
    gulp.watch(paths.styles.admin.watch, gulp.parallel('adminStylesRtl'));
    gulp.watch(paths.scripts.admin.watch, gulp.parallel('adminScripts'));
    gulp.watch(paths.images.admin.watch, gulp.parallel('adminImages'));

    // Translation
    gulp.watch(paths.php.watch, gulp.parallel('translate'));
}));