/**
 * @Filename: uploader-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY, nhUploadGlobals */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhUiCtrl   from './inc/UiCtrl';
import NhUploader from './modules/Uploader';

class NhUploaderFront extends NhUploader
{
    constructor()
    {
        // Call the constructor of the parent class (NhAuth)
        super();

        // Initialize the UiCtrl and $el properties
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            // Define selectors for various forms and elements
            attachments: {
                attachmentField: $(`.${KEY}-attachment-uploader`),
                fromParent: $(`.${KEY}-attachment-uploader`).closest('form'),
                removeAttachment: $(`.${KEY}-remove-attachment`),
            },
        };

        // Call the initialization method
        this.initialization();
    }

    // Perform necessary initializations
    initialization()
    {
        this.uploadFront();
        this.removeFront();
        this.setupValidations();
    }

    uploadFront()
    {
        let that         = this,
            $attachments = this.$el.attachments,
            ajaxRequests = this.ajaxRequests;

        $attachments.fromParent.validate({
            rules: {
                media_file: {
                    required: true,
                    extension: 'jpg|jpeg|png', // Allowed file extensions
                    maxFileSize: nhUploadGlobals.max_upload_size, // 5 MB in bytes (adjust as needed)
                }
            },
        });

        $attachments.attachmentField.on('change', $attachments.fromParent, function (e) {
                e.preventDefault();

                let $this      = $(e.currentTarget),
                    form_data  = new FormData(),
                    files      = $this[0].files,
                    target     = $this.attr('data-target'),
                    $recaptcha = $this.closest('form').find('#g-recaptcha-response').val();

                form_data.append('action', `${KEY}_upload_attachment`);
                form_data.append('g-recaptcha-response', $recaptcha);
                form_data.append('name', $this.attr('name'));

                if (typeof ajaxRequests.attacmentHandlerUpload !== 'undefined') {
                    ajaxRequests.attacmentHandlerUpload.abort();
                }

                if ($this.valid()) {
                    form_data.append('file', files[0]);
                    that.upload($this.parent(), form_data, target, that, $attachments);
                }

            });
    }

    removeFront($el = null)
    {
        let that         = this,
            $attachments = this.$el.attachments,
            ajaxRequests = this.ajaxRequests;

        $(`.${KEY}-remove-attachment`).on('click', $attachments.fromParent, function (e) {
            e.preventDefault();
            let $this      = $(e.currentTarget),
                form_data  = new FormData(),
                $recaptcha = $this.closest('form').find('#g-recaptcha-response').val(),
                target     = $this.parent().parent().parent().find('input[type="file"]').attr('data-target');
            form_data.append('action', `${KEY}_remove_attachment`);
            form_data.append('g-recaptcha-response', $recaptcha);

            form_data.append('attachment_id', $(`input[name="${target}"]`).val());

            if (typeof ajaxRequests.attacmentHandlerUploadRemove !== 'undefined') {
                ajaxRequests.attacmentHandlerUploadRemove.abort();
            }

            that.remove($this.parent(), form_data, $this, $attachments);
        });
    }

    createAttachment(filename, id)
    {
        return `
            <div class="col-sm-2 ${KEY}-single-attachment-wrapper">
                <div class="${KEY}-single-attachment">
                    <i class="bbc-file"></i>
                    <label class="${KEY}-attachment-name" for="${KEY}_${id}">${filename}</label>
                    <div class="${KEY}-attachment-progress">
                        <span class="${KEY}-progress"></span>
                    </div>
                    <a href="javascript:(0);" class="${KEY}-remove-attachment">x</a>
                </div>
            </div>`;
    };

    renameFile(filename)
    {
        let splice               = filename.split('.'),
            ext                  = splice[splice.length - 1],
            name                 = splice[0],
            subStringingFileName = name.substring(0, 5) + '...';
        return subStringingFileName + ext;
    };

    setupValidations() {
        $(document).on('nh:customValidations', function (e) {

        });
    }
}

new NhUploaderFront();
