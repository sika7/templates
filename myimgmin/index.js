const imagemin = require('imagemin-keep-folder');
const imageminMozjpeg = require('imagemin-mozjpeg');
const imageminPngquant = require('imagemin-pngquant');
const imageminGifsicle = require('imagemin-gifsicle');
const imageminSvgo = require('imagemin-svgo');


module.exports = min

function min() {
  let imgPath = process.argv[2];
  if(!imgPath) imgPath = 'dist/**';
  imgPath = `${imgPath}/*.{jpg,png,gif,svg}`;

  console.log('実行パス ' + imgPath);

  imagemin([imgPath], {
    plugins: [
      imageminMozjpeg({ quality: 80 }),
      imageminPngquant({ quality: [0.65, 0.8] }),
      imageminGifsicle(),
      imageminSvgo()
    ]
  }).then(() => {
    console.log('Images optimized');
  });
}

