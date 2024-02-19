// resources/js/app.js
import jQuery from 'jquery';
window.$ = jQuery;

import './bootstrap';

import '../sass/app.scss';
// import './bootstrap';

window.$(document).ready(function () {
    window.$('input:file').change(function () {
        if (window.$(this).val()) {
            window.$('input:submit').removeAttr('disabled');
        } else {
            window.$('input:submit').attr('disabled', true);
        }
    });
    window.$('#csvupform:submit').change(function() {
        if(window.$('#excelfile').val()) {
            window.$('input:submit').attr('disabled', true);
        }else{
            window.$('input:submit').removeAttr('disabled');
        }
    });
});
