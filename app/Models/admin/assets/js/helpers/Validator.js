/**
 * @Filename: Validator.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';
import 'jquery-validation';

class NhValidator
{
    constructor()
    {
        this.phrases = nhGlobals.phrases;
        this.setDefaults();
        this.addMethods();
    }

    setDefaults()
    {
        $.extend($.validator.messages, {
            required: this.phrases.default,
            email: this.phrases.email,
            number: this.phrases.number,
            equalTo: this.phrases.equalTo,
            maxlength: $.validator.format(this.phrases.maxlength),
            minlength: $.validator.format(this.phrases.minlength),
            max: $.validator.format(this.phrases.max),
            min: $.validator.format(this.phrases.min),
        });

        $.validator.setDefaults({
            errorPlacement: function (label, element) {
                label.addClass(`${KEY}-error`);
                if (element.hasClass('btn-check')) {
                    label.insertBefore(element);
                } else {
                    label.insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass(`${KEY}-error-input`);
            },
            unhighlight: function (element) {
                $(element).removeClass(`${KEY}-error-input`);
            },
        });


    }

    addMethods()
    {
        $.validator.addMethod('email_regex', function (value, element, regexp) {
            let re = new RegExp(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
            // let re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, this.phrases.email_regex);
        $.validator.addMethod('phone_regex', function (value, element, regexp) {
            let re = new RegExp(/^(01)[0125][0-9]{8}$/);
            // let re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, this.phrases.phone_regex);
        $.validator.addMethod('password_regex', function (value, element, regexp) {
            let re = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/);
            return this.optional(element) || re.test(value);
        }, this.phrases.pass_regex);
        $.validator.addMethod('time_regex', function (value, element, regexp) {
            let re = new RegExp(/^((1[0-2]|0?[1-9]):[0-5][0-9] (AM|PM) - (1[0-2]|0?[1-9]):[0-5][0-9] (AM|PM))$/);
            return this.optional(element) || re.test(value);
        }, this.phrases.time_regex);
        $.validator.addMethod('extension', function (value, element, param) {
            if (typeof param === 'string') {
                param = param.replace(/,/g, '|');
            } else {
                param      = value.split('.')[1];
            }
            return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
        }, this.phrases.file_extension);
        $.validator.addMethod('maxFileSize', function (value, element, param) {
            var maxSize = param * 1024; // Convert param (in KB) to bytes
            if (element.files && element.files.length > 0) {
                return element.files[0].size <= maxSize;
            }
            return true;
        }, this.phrases.file_max_size);
        $.validator.addMethod("englishTextOnly", function(value, element) {
            return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
        }, this.phrases.englishOnly);
        $.validator.addMethod("arabicOnly", function(value, element) {
            return this.optional(element) || /^[\u0600-\u06FF\s]+$/i.test(value);
        }, this.phrases.arabicOnly);
        $.validator.addMethod('fileRequired', function (value, element, param) {
            return $(`input[name="${$(element).attr('data-target')}"]`).length > 0 && $(`input[name="${$(element).attr('data-target')}"]`).val() !== '';

        }, this.phrases.default);

        $(document).trigger('nh:customValidations');
    }
}

export default NhValidator;
