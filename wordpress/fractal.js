'use strict';

/*
* Require the path module
*/
const path = require('path');

/*
 * Require the Fractal module
 */
const fractal = module.exports = require('@frctl/fractal').create();

/*
 * Give your project a title.
 */
fractal.set('project.title', 'Tap Guide');

/*
 * Tell Fractal where to look for components.
 */
fractal.components.set('path', path.join(__dirname, './workspace/style_guide/components'));

/*
 * Tell Fractal where to look for documentation pages.
 */
fractal.docs.set('path', path.join(__dirname, './workspace/style_guide/docs'));

/*
 * Tell the Fractal web preview plugin where to look for static assets.
 */
fractal.web.set('static.path', path.join(__dirname, './workspace/style_guide/public'));


const myPath = __dirname + './workspace/components';