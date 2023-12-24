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

class NhUploader extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    upload($wrapper, data, target, $obj, $el) {
        let that = this,
            ajaxRequests = this.ajaxRequests;
        let file = data.get('file');
        let file_name = that.renameFile(file.name);
        let $file = $(that.createAttachment(file_name, $wrapper.find(`.${KEY}-attachment-uploader`).attr('name')));

        ajaxRequests.attacmentHandlerUpload = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            beforeSend: function () {
                $el.fromParent.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.fromParent);

                // Reset Input before send
                $wrapper.find(`.${KEY}-single-attachment-wrapper`).remove();
                $(`input[data-target="${target}"]`).val("");
                $wrapper.append($file);

            },
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = evt.loaded / evt.total,
                            progress = $file.find(`.${KEY}-progress`);
                        percentComplete = percentComplete * 100;
                        progress.css('width',percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function (res) {
                if (res.success) {
                    // BLOCK UI
                    $el.fromParent.find('input, button').prop('disabled', false);
                    UiCtrl.beforeSendPrepare($el.fromParent);

                    $(`input[name="${target}"]`).val(res.data.attachment_ID);
                    // $file.find(`.${KEY}-remove-attachment`).attr('data-img', res.data.attachment_ID);
                    UiCtrl.blockUI($el.fromParent, false);
                    $obj.removeFront($el.removeAttachment);
                    $wrapper.find(`.${KEY}-error`).remove();
                } else {
                    UiCtrl.notices($wrapper.closest('form'), res.msg);
                    $el.fromParent.find('input, button').prop('disabled', false);
                    UiCtrl.blockUI($el.fromParent, false);

                    // Reset Input
                    $(`input[name="${target}"]`).val(""); // input that should hold the attachment ID
                    $(`input[data-target="${target}"]`).val(""); // file input type

                    $wrapper.find(`.${KEY}-single-attachment-wrapper`).remove();
                }

                // Remove progress bar after successfully upload the attachment
                $file.find(`.${KEY}-attachment-progress`).remove();

                that.createNewToken();
            },
            complete: function () {
                // $wrapper.find('input').prop('disabled', false);
            },
            error: function (xhr, status, error) {
                let errorMessage = xhr.status + ': ' + xhr.statusText;
                if (xhr.statusText !== 'abort') {
                    $file.remove();
                    $el.fromParent.find('input, button').prop('disabled', false);
                    $(`input[name="${target}"]`).val(""); // input that should hold the attachment ID
                    $(`input[data-target="${target}"]`).val(""); // file input type
                    // UiCtrl.notices($wrapper.closest('form'), res.msg);
                    UiCtrl.blockUI($el.fromParent, false);
                    console.error(errorMessage);
                }
            },
        });
    }

    remove($wrapper, data, $btn, $el) {
        let that = this,
            ajaxRequests = this.ajaxRequests;

        ajaxRequests.attacmentHandlerUploadRemove = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            beforeSend: function () {
                $el.fromParent.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.fromParent);
            },
            success: function (res) {
                if (res.success) {
                    // Remove attachment icon with it's parent
                    $btn.closest(`.${KEY}-single-attachment-wrapper`).fadeOut(200, function () {
                        $btn.closest(`.${KEY}-single-attachment-wrapper`).remove();
                    });


                    // TODO:: SHOULD BE ENHANCED
                    // ========================= //
                    let target = $btn.parent().parent().parent().find('input[type="file"]').attr('data-target');
                    $(`input[name="${target}"]`).val('');
                    $(`input[data-target="${target}"]`).val('');
                    let label_id = $(`input[data-target="${target}"]`).attr('id');
                    $(`label[for="${label_id}"]`).show();
                    // ========================= //


                    $wrapper.find(`.${KEY}-attachment-uploader`).val('');
                    $el.fromParent.find('input, button').prop('disabled', false);

                    UiCtrl.blockUI($el.fromParent, false);
                } else {
                    $el.fromParent.find('input, button').prop('disabled', false);
                    UiCtrl.notices($wrapper.closest('form'), res.msg);
                    UiCtrl.blockUI($el.fromParent, false);

                    // Scroll the page to the target element
                    $('html, body').animate({
                        scrollTop: $(`.${KEY}-form-notice.result`).offset().top - 200,
                    }, 500); // Adjust the duration as needed
                }

                that.createNewToken();
            },
            error: function (xhr, status, error) {
                let errorMessage = xhr.status + ': ' + xhr.statusText;
                if (xhr.statusText !== 'abort') {
                    $el.fromParent.find('input, button').prop('disabled', false);
                    // UiCtrl.notices($wrapper.closest('form'), res.msg);
                    UiCtrl.blockUI($el.fromParent, false);
                    console.error(errorMessage);
                }
            },
        });
    }

}

export default NhUploader;
