/**
 * @Filename: Notification.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';

class NhNotification extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    read(formData, $el)
    {
        let that                      = this;
        this.ajaxRequests.notifications = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_read_notifications_ajax`,
                data: formData,
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    $(`.${KEY}-notification-bell`).attr('data-count', res.data.count);
                    $(`.${KEY}-notification-count`).html(res.data.count);
                    UiCtrl.blockUI($el, false);
                }

            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }

    clear($el)
    {
        let that                      = this;
        this.ajaxRequests.clear_notifications = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_clear_notifications_ajax`
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    $(`.${KEY}-notification-bell`).attr('data-count', 0);
                    $(`.${KEY}-notification-count`).html(0);
                    $el.html(res.data.html);
                    UiCtrl.blockUI($el, false);
                }
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }

    loadMoreNotification(formData, $el)
    {
        let that                      = this;
        this.ajaxRequests.notificationsLoadMore = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_loadmore_notifications_ajax`,
                data: formData,
            },
            beforeSend: function () {
                let $temp = $(`<div class="${KEY}-notification-item ${KEY}-notification-item-load"> <div class="row"> <div class="col-sm-2"> <div class="${KEY}-notification-image"> <span></span> </div> </div> <div class="col-sm-10"> <div class="${KEY}-notification-content"> <h6></h6> <p></p> <span></span> </div> </div> </div> </div>`)
                $(`.${KEY}-notification-item-load`).remove();
                $el.append($temp);
                $('.ninja-notification-list').animate({ scrollTop: $('.ninja-notification-list')[0].scrollHeight - 450 }, 250);
            },
            success: function (res) {
                if (res.success) {
                    $(`.${KEY}-notification-list`).attr('data-page', res.data.page);
                    $(`.${KEY}-notification-list`).attr('data-last', res.data.last);
                    $(`.${KEY}-notification-item-load`).remove();
                    $(`.${KEY}-notification-bell`).attr('data-count', res.data.count);
                    $(`.${KEY}-notification-count`).html(res.data.count);
                    $(`.${KEY}-notifications-group`).append(res.data.html);
                }
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }

    /**
     * NOT IN USE
     * @param formData
     */
    changeNewNotificationsStatus(formData)
    {
        let that                      = this;
        this.ajaxRequests.notifications = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_read_new_notifications_ajax`,
                data: formData,
            },
            beforeSend: function () {
            },
            success: function (res) {
                if (res.success) {
                    $(`.${KEY}-notification-bell`).attr('data-count', res.data.count);
                    $(`.${KEY}-notification-count`).html(res.data.count);
                }

            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }
}

export default NhNotification;
