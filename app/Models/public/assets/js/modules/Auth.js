/**
 * @Filename: Auth.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// Importing the required modules
import $ from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';
import _      from 'lodash';

// Defining the NhAuth class that extends the Nh class
class NhAuth extends Nh {
    constructor() {
        super();
        this.ajaxRequests = {};
    }

    // Method for user registration
    registration(formData, $el) {
        let that = this;
        // Creating an AJAX request for registration
        this.ajaxRequests.registration = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_registration_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
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
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for user login
    login(formData, $el) {
        let that = this;
        // Creating an AJAX request for login
        this.ajaxRequests.login = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_login_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
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
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for verification
    verification(formData, $el) {
        let that = this;
        // Creating an AJAX request for verification
        this.ajaxRequests.verification = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_verification_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    $($el).append(_.template($('#ninja_modal_auth_verif').html())({
                        msg: res.msg,
                        redirect_text: res.data.redirect_text,
                        redirect_url: res.data.redirect_url,
                    }));
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el, false);
            },
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for authentication
    authentication(formData, $el) {
        let that = this;
        // Creating an AJAX request for authentication
        this.ajaxRequests.authentication = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_authentication_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
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
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for resending verification code
    resendVerCode(formData, $el) {
        let that = this;
        // Creating an AJAX request for resending verification code
        this.ajaxRequests.resendVerCode = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_resendVerCode_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.closest('form').find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.closest('form'));
            },
            success: function(res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el.closest('form'), res.msg, 'success');
                    $el.closest('form').find('.ninja-resend-code-patent').attr('data-expire', res.data.expire);
                    that.codeCountDown();
                } else {
                    $el.closest('form').find('.otp-digit').first().focus().select();
                    UiCtrl.notices($el.closest('form'), res.msg);
                }
                $el.hide();
                that.createNewToken();
                $el.closest('form').find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el.closest('form'), false);
            },
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for resending authentication code
    resendAuthCode(formData, $el) {
        let that = this;
        // Creating an AJAX request for resending authentication code
        this.ajaxRequests.resendAuthCode = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_resendAuthCode_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.closest('form').find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.closest('form'));
            },
            success: function(res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el.closest('form'), res.msg, 'success');
                    $el.closest('form').find('.ninja-resend-code-patent').attr('data-expire', res.data.expire);
                    that.codeCountDown();
                } else {
                    $el.closest('form').find('.otp-digit').first().focus().select();
                    UiCtrl.notices($el.closest('form'), res.msg);
                }
                $el.hide();
                that.createNewToken();
                $el.closest('form').find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el.closest('form'), false);
            },
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for selecting industries
    industries(formData, $el) {
        let that = this;
        // Creating an AJAX request for industries
        this.ajaxRequests.industries = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_industries_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
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
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for forgot password
    forgotPassword(formData, $el) {
        let that = this;
        // Creating an AJAX request for forgot password
        this.ajaxRequests.forgot = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_forgot_password_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
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
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for changing password
    changePassword(formData, $el) {
        let that = this;
        // Creating an AJAX request for changing password
        this.ajaxRequests.changePassword = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_change_password_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
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
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    editPassword(formData, $el)
    {
        let that                       = this;
        this.ajaxRequests.editPassword = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_edit_password_ajax`,
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
    
    // Method for creating a new token
    createNewToken() {
        grecaptcha.ready(function() {
            grecaptcha.execute(nhGlobals.publicKey).then(function(token) {
                $('#g-recaptcha-response').val(token);
            });
        });
    }

    // Method for the code countdown
    codeCountDown() {
        let that = this,
            $codeForm = this.$el.codeForm,
            $resendCodeParent = $('.ninja-resend-code-patent'),
            $CodeCountDown = $('<span class="ninjacode-count-down"></span>');

        $('.ninja-code-count-down').remove();
        $resendCodeParent.append($CodeCountDown);

        if ($CodeCountDown.length > 0) {
            // Given timestamp
            let givenTimestamp = $resendCodeParent.attr('data-expire'),

                // Get the current timestamp
                currentTimestamp = Math.floor(Date.now() / 1000),

                // Calculate the difference in seconds
                difference = givenTimestamp - currentTimestamp;

            if (difference <= 0) {
                $codeForm.resendCode.show();
                $CodeCountDown.hide();
            }

            // Update the countdown timer every second
            let countdownInterval = setInterval(function() {
                // Calculate minutes and seconds
                let minutes = Math.floor(difference / 60),
                    seconds = difference % 60;

                // Display the countdown
                $CodeCountDown.text(`${minutes}:${seconds}`);

                // Decrease the difference by 1 second
                difference--;

                // If the countdown is finished, clear the interval
                if (difference < 0) {
                    clearInterval(countdownInterval);
                    $codeForm.resendCode.show();
                    $CodeCountDown.hide();
                }
            }, 1000);
        }
    }
}

export default NhAuth;
