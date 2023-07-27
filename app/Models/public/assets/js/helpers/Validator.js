/**
 * @Filename: Validator.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';
import _ from 'lodash';
import 'jquery-validation';
import intlTelInput from 'intl-tel-input';
import 'intl-tel-input/build/js/utils.js';

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
        $.validator.addMethod("intlTelNumber", function(value, element, param) {
            let iti = window.ITIOBJ[param.itiObj];
            return this.optional(element) || iti.isValidNumber();
        }, this.phrases.intlTelNumber);
        $.validator.addMethod('password_regex', function (value, element, regexp) {
            let re = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/);
            return this.optional(element) || re.test(value);
        }, this.phrases.pass_regex);
        $.validator.addMethod('extension', function (value, element, param) {
            if (typeof param === 'string') {
                param = param.replace(/,/g, '|');
            } else {
                let substr = value.split('.')[1];
                param      = substr;
            }
            return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
        }, this.phrases.file_extension);
    }

    static initAuthValidation($el, type)
    {

        let that = this;

        const forms = {
            login: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            user_login: 'required',
                            user_password: {
                                required: true,
                                maxlength: 26
                            },
                        },
                    });
                }
            },
            industries: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            'industries': {
                                required: true,
                                minlength: 1
                            },
                        }
                    });
                }
            },
            registration: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            first_name: {
                                required: true,
                                minlength: 2,
                                maxlength: 150
                            },
                            last_name: {
                                required: true,
                                minlength: 2,
                                maxlength: 150
                            },
                            phone_number: {
                                required: true,
                                intlTelNumber: {itiObj: 'registration'},
                                maxlength: 50
                            },
                            user_email: {
                                required: true,
                                email_regex: true,
                                minlength: 10,
                                maxlength: 125
                            },
                            user_password: {
                                required: true,
                                password_regex: true
                            },
                            confirm_password: {
                                required: true,
                                equalTo: $el.user_password,
                            },
                            user_type: {
                                required: true
                            },
                            verification_type: {
                                required: true
                            }
                        },
                    });
                }
            },
            verification: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            code1: {
                                required: true,
                                maxlength: 1
                            },
                            code2: {
                                required: true,
                                maxlength: 1
                            },
                            code3: {
                                required: true,
                                maxlength: 1
                            },
                            code4: {
                                required: true,
                                maxlength: 1
                            },
                        },
                    });
                }
            },
            forgotPassword: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            user_email_phone: {
                                required: true
                            },
                        },
                    });
                }
            },
            change_password: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            user_password: {
                                required: true,
                                password_regex: true,
                            },
                            user_password_confirm: {
                                required: true,
                                equalTo: $el.user_password,
                            },
                        },
                    });
                }
            },
            editProfile: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        ignore: ":hidden:not(select)",
                        rules: {
                            first_name: {
                                required: true,
                                minlength: 2,
                                maxlength: 150
                            },
                            last_name: {
                                required: true,
                                minlength: 2,
                                maxlength: 150
                            },
                            phone_number: {
                                required: true,
                                intlTelNumber: {itiObj: 'editProfile'},
                                maxlength: 50
                            },
                            user_email: {
                                required: true,
                                email_regex: true,
                                minlength: 10,
                                maxlength: 125
                            },
                            site_language: {
                                required: true,
                            },
                            widget_list: {
                                required: true,
                            },
                            preferred_opportunities_cat_list: {
                                required: true,
                            },
                            preferred_articles_cat_list: {
                                required: true,
                            }
                        },
                    });
                }
            },
            editPassword: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            current_password: {
                                required: true,
                            },
                            new_password: {
                                required: true,
                                password_regex: true,
                            },
                            confirm_new_password: {
                                required: true,
                                equalTo: $el.new_password,
                            },
                        },
                    });
                }
            },
        };

        if (_.has(forms, type)) {
            _.invoke(forms, type);
        }
    }

    static initCompetitionValidation($el, type)
    {

        let that = this;

        const forms = {
            competition: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            team_leader_name: {
                                required: true,
                            },
                            team_leader_email: {
                                required: true,
                                email_regex: true,
                            },
                            team_leader_mobile: {
                                required: true,
                                phone_regex: true,
                            },
                            country: {
                                required: true,
                            },
                            city: {
                                required: true,
                            },
                            university: {
                                required: true,
                            },
                            faculty: {
                                required: true,
                            },
                            team_name: {
                                required: true,
                            },
                            team_member1_name: {
                                required: true,
                            },
                            team_member1_email: {
                                required: true,
                                email_regex: true,
                            },
                            team_member2_email: {
                                email_regex: true,
                            },
                            team_member3_email: {
                                email_regex: true,
                            },
                            team_member4_email: {
                                email_regex: true,
                            },
                            project_description: {
                                required: true,
                                maxlength: 1000,
                            },
                            advisory_contact_name: {
                                required: true,
                            },
                            advisory_contact_email: {
                                required: true,
                                email_regex: true,
                            },
                            advisory_contact_mobile: {
                                required: true,
                                phone_regex: true,
                            },
                        },
                    });
                }
            },
        };

        if (_.has(forms, type)) {
            _.invoke(forms, type);
        }
    }


}

export default NhValidator;
