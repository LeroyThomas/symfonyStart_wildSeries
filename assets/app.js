/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import "node_modules/bootstrap/scss/bootstrap";

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
const $ = require('jquery');

require('bootstrap');
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

console.log('Hello Webpack Encore! Edit me in assets/app.js');
