
/* ======================================
 *              必要なプラグインの読み込み
 * ====================================== */


var gulp = require('gulp');
var $ = require('gulp-load-plugins')({
  pattern: ['gulp-*', 'postcss-cssnext', 'cssnano', 'postcss-assets', 'imagemin-pngquant', 'imagemin-jpegtran']
});

var del = require('del');


const fractal = require('./fractal.js');
const logger = fractal.cli.console; // keep a reference to the fractal CLI console utility


const packageImporter = require("node-sass-package-importer");

/* ======================================
 *              デフォルトのパス
 * ====================================== */



// デフォルトのパス
var paths = {
	'source': './src/',
	'json'  : './src/common/',
	'deploy': './dist/',
};




/* ======================================
 *              タスク
 * ====================================== */

gulp.task('default', ['watch']);

// 通常の監視状態を作り出す
gulp.task('watch', function() {
	gulp.watch([paths.source + 'sass/**/*.scss'], ['sass']);
	gulp.watch([paths.source + '**/*.pug'], ['pug']);
	gulp.watch([paths.source + 'js/**/*.js'], ['js']);
});

gulp.task('clean', function() {
  return del([paths.deploy+'**/*']);
});

gulp.task('dist', ['pug','sass','js','imgmin']);



/* ======================================
 *              便利系タスク
 * ====================================== */


// Webサーバー、ユーティリティ 確認用サーバー立ち上げ
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;

gulp.task('webserver', function() {
	browserSync.init({
		server: {
			baseDir: paths.deploy,
		}
	});
	gulp.watch([paths.source + 'sass/**/*.scss'], ['sass']);
	gulp.watch([paths.source + '**/*.pug'], ['pug',reload]);
	gulp.watch([paths.source + 'js/**/*.js'], ['js']);
	gulp.watch([paths.deploy + 'css/**/*.css', paths.deploy + 'js/**/*.js'], reload);
});



// plumber実行時ゾンビタスクになるのを防ぐ .pipe(plumber(plumberOption))こう書く
const plumberOption = {
	errorHandler(error) {
		console.log(error.message);
		this.emit('end');
	},
};


// 指定ディレクトリの子階層のディレクトリ名を取得する
var fs   = require('fs');
var path = require('path');
var getFolders = function(dir_path) {
  return fs.readdirSync(dir_path).filter(function(file) {
    return fs.statSync(path.join(dir_path, file)).isDirectory();
  });
};


gulp.task('guide', function(){
    const server = fractal.web.server({
        sync: true
    });
    server.on('error', err => logger.error(err.message));
    return server.start().then(() => {
        logger.success(`Fractal server is now running at ${server.url}`);
    });
});

/* ======================================
 *              コンパイル系タスク
 * ====================================== */



//htmlテンプレートエンジンpug
gulp.task('pug', function() {
		var locals = {
			'site': JSON.parse(fs.readFileSync(paths.json + 'site.json'))
		}
		gulp.src(paths.source + '**/!(_)*.pug')
		.pipe($.data(function(file) {
		  locals.relativePath = path.relative( path.dirname( file.path ) , file.base ) + '/';
		  locals.dirname = path.relative( file.base , path.dirname( file.path ));
		  if(locals.relativePath == "/"){
			  locals.relativePath = "";
		  }
		    return locals;
		}))
		.pipe($.plumber(plumberOption)) /*エラー時に終了させない*/
		.pipe($.pug({
			locals: locals,
			basedir: 'src',
			pretty: true,
		}))
		.pipe(gulp.dest(paths.deploy));
});


// sassコンパイル
gulp.task('sass', function() {
	var options = {
		outputStyle: 'expanded', //圧縮して出力 expanded, nested, compact, compressed
		sourceComments: false,
		importer: packageImporter({extensions: ['.scss', '.css'],packagePrefix: '~'})
	};
	return gulp.src(paths.source + 'sass/!(_)*.scss')
		.pipe($.sassGlob({
	        ignorePaths: [
		        '_bass.scss'
	        ]
	    }))
		.pipe($.sourcemaps.init())
		.pipe($.plumber(plumberOption)) /*エラー時に終了させない*/
		.pipe($.sass(options))
		.pipe($.sourcemaps.write( /*'../maps'*/ ))
		.pipe(gulp.dest(paths.deploy + 'css/'));
});

gulp.task('css', function() {
	return gulp.src(paths.source + 'sass/!(_)*.styl')
		.pipe($.plumber(plumberOption)) /*エラー時に終了させない*/
		.pipe($.sourcemaps.init())
		.pipe($.stylus({
			compress: true, // cssのmin化
			linenos: false,   // line番号の出力
			'include css': true
		}))
		.pipe($.sourcemaps.write())
		.pipe(gulp.dest(paths.deploy + 'css/'));
});



// <svg class="icon">
//   <use xlink:href="/images/svg/src.svg#logo" />
// </svg>
gulp.task('svg', function () {
	return gulp
	.src(paths.source + '/images/svg/**/*.svg')
	.pipe($.svgmin(function (file) {
		var prefix = path.basename(file.relative, path.extname(file.relative));
		return {
			plugins: [{
				cleanupIDs: {
					prefix: prefix + '-',
					minify: true
				}
			}]
		};
	}))
	.pipe($.svgstore({ inlineSvg: true }))

	.pipe($.cheerio({
		run: function ($) {
			$('[fill]').removeAttr('fill');
			$('[stroke]').removeAttr('stroke');
			$('svg').attr('style','display:none');
		},
		parserOptions: { xmlMode: true }
	}))
	.pipe(gulp.dest(paths.deploy + '/images/svg/'));
});



/* ======================================
 *              デプロイ系タスク
 * ====================================== */





// css圧縮
gulp.task('cssmini', function() {
	var processors = [
		$.postcssCssnext({ browsers: ['last 3 version', 'ie >= 6', 'Android 4.0'] }),
		$.cssnano({ autoprefixer: false }),
	];
	return gulp.src(paths.deploy + 'css/*.css')
		// .pipe(cmq(beautify: false))
		// .pipe(csscomb()) // 設定ファイルをプロジェクトフォルダに入れる
		.pipe($.postcss(processors))
		.pipe(gulp.dest(paths.deploy + 'css/'));
});


// 画像の圧縮
gulp.task('imgmin', function() {
	return gulp.src([paths.source + 'images/**/*.+(jpg|jpeg|png|gif|svg)'])
	.pipe($.imagemin([
		$.imageminPngquant({ quality: '65-80', speed: 1 }),
		$.imageminJpegtran({ quality: 80 }),
		$.imagemin.svgo(),
		$.imagemin.optipng(),
		$.imagemin.gifsicle()
	]))
	.pipe(gulp.dest(paths.deploy + 'images/'));
});


gulp.task('sitemap', function() {
	var locals = {
    'site': JSON.parse(fs.readFileSync(paths.json + 'site.json'))
    };
	 gulp.src(paths.deploy + '**/*.html', {
			read: false
		})
		.pipe($.sitemap({
			siteUrl: locals.site.rootUrl
		}))
		.pipe(gulp.dest(paths.deploy));
});


/* ======================================
 *              コピー系タスク
 * ====================================== */


// jsの処理
gulp.task('js', function() {
	return gulp.src([paths.source + 'js/**/*.js'])
		.pipe(gulp.dest(paths.deploy + 'js/'));
});


gulp.task('imgcopy', function() {
	gulp.src([paths.source + '/images/*'])
		.pipe(gulp.dest(paths.deploy + 'images/'));
});

gulp.task('php', function() {
	return gulp.src([paths.source + '**/*.php'])
		.pipe(gulp.dest(paths.deploy));
});

