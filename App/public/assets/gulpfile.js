const { src, dest, watch, series } = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const purgecss = require('gulp-purgecss')

function buildStyles() {
    return src('scss/main.scss')
      .pipe(sass())
      .pipe(purgecss({ content: ['../../**/*.php', '../**/*.js'] }))
      .pipe(dest('css/'))
}

function watchTask() {
    watch(['scss/main.scss'], buildStyles)
}

exports.default = series(buildStyles, watchTask)