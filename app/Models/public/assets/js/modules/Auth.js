/**
 * @Filename: Auth.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// Importing the required modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';
import _      from 'lodash';

// Defining the NhAuth class that extends the Nh class
class NhAuth extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    // Method for user registration
    registration(formData, $el)
    {
        let that                       = this;
        // Creating an AJAX request for registration
        this.ajaxRequests.registration = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_registration_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el, false);
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for user login
    login(formData, $el)
    {
        let that                = this;
        // Creating an AJAX request for login
        this.ajaxRequests.login = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_login_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el, false);
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for forgot password
    forgotPassword(formData, $el)
    {
        let that                 = this;
        // Creating an AJAX request for forgot password
        this.ajaxRequests.forgot = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_forgot_password_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    $el[0].reset();
                    // window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el, false);
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for changing password
    changePassword(formData, $el)
    {
        let that                         = this;
        // Creating an AJAX request for changing password
        this.ajaxRequests.changePassword = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_change_password_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    $el[0].reset();
                    // window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el, false);
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for creating a new token
    createNewToken()
    {
        grecaptcha.ready(function () {
            grecaptcha.execute(nhGlobals.publicKey).then(function (token) {
                $('input[name="g-recaptcha-response"]').val(token);
            });
        });
    }
}

export default NhAuth;
