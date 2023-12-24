/**
 * @Filename: Ajax.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $            from 'jquery';
import UiCtrl       from './UiCtrl';

class NhAjax extends UiCtrl
{
    static ajaxRequests = {};

    constructor()
    {
        super();
    }

    static createRequest($el, requestName, ajaxData = {}, customData = null, method = 'POST')
    {

        let that                         = this;

        // Abort any ongoing forgot password requests
        if (typeof this.ajaxRequests[requestName] !== 'undefined') {
            this.ajaxRequests[requestName].abort();
        }

        // Creating an AJAX request for changing password
        this.ajaxRequests[requestName] = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: method,
            data: ajaxData,
            beforeSend: function () {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
                $(document).trigger('on:beforeSend', [$el, requestName, customData]);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    $(document).trigger('on:resSuccess', [res, $el, requestName, customData]);
                } else {
                    UiCtrl.notices($el, res.msg);
                    $(document).trigger('on:resFailed', [res, $el, requestName, customData]);
                }
                that.createNewToken();
                $el.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el, false);
                $(document).trigger('on:success', [res, $el, requestName, customData]);
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
               that.createNewToken();
                $(document).trigger('on:resError', [xhr, $el, requestName, customData]);
            },
        });
    }

    static createNewToken()
    {
        grecaptcha.ready(function () {
            grecaptcha.execute(nhGlobals.publicKey).then(function (token) {
                $('input[name="g-recaptcha-response"]').val(token);
            });
        });
    }
}

export default NhAjax;
