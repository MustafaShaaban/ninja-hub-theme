/**
 * @Filename: authentication.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator from './helpers/Validator';
import NhUiCtrl    from './inc/UiCtrl';
import NhAuth      from './modules/Auth';
import intlTelInput from 'intl-tel-input';
import 'intl-tel-input/build/js/utils.js';
// import Choices      from 'choices.js';

// Define a class named NhAuthentication which extends NhAuth class
class NhAuthentication extends NhAuth {
    constructor() {
        // Call the constructor of the parent class (NhAuth)
        super();

        // Initialize the UiCtrl and $el properties
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            // Define selectors for various forms and elements
            registration: {
                form: $(`#${KEY}_registration_form`),
                parent: $(`#${KEY}_registration_form`).parent(),
                user_password: $(`#${KEY}_user_password`),
            },
            login: {
                form: $(`#${KEY}_login_form`),
                parent: $(`#${KEY}_login_form`).parent(),
            },
            verification: {
                form: $(`#${KEY}_verification_form`),
                parent: $(`#${KEY}_verification_form`).parent(),
                otpDigit: $(`#${KEY}_verification_form`).find('.otp-digit input'),
                resendCodeParent: $(`#${KEY}_verification_form`).find('.ninja-resend-code-patent'),
                resendCode: $(`#${KEY}_verification_form`).find('.ninja-resend-code'),
                CodeCountDown: $(`#${KEY}_verification_form`).find('.ninja-code-count-down'),
                verificationSubmit: $(`#${KEY}_verification_form`).find('#verificationSubmit'),
            },
            authentication: {
                form: $(`#${KEY}_authentication_form`),
                parent: $(`#${KEY}_authentication_form`).parent(),
                otpDigit: $(`#${KEY}_authentication_form`).find('.otp-digit input'),
                resendCodeParent: $(`#${KEY}_authentication_form`).find('.ninja-resend-code-patent'),
                resendCode: $(`#${KEY}_authentication_form`).find('.ninja-resend-code'),
                CodeCountDown: $(`#${KEY}_authentication_form`).find('.ninja-code-count-down'),
                authenticationSubmit: $(`#${KEY}_authentication_form`).find('#authenticationSubmit'),
            },
            codeForm: {
                resendCode: $('.ninja-resend-code'),
            },
            industries: {
                form: $(`#${KEY}_industries_form`),
                tags: $(`#${KEY}_industries_form`).find(`.industries-tags`),
                selectedNumbersSpan: $(`#${KEY}_industries_form`).find(`.selected-number`),
                showTags: $(`#${KEY}_industries_form`).find(`.show-tags`),
                parent: $(`#${KEY}_industries_form`).parent(),
            },
            forgot: {
                form: $(`#${KEY}_forgot_form`),
                parent: $(`#${KEY}_forgot_form`).parent(),
            },
            editProfile: {
                form: $(`#${KEY}_edit_profile_form`),
                parent: $(`#${KEY}_edit_profile_form`).parent(),
                selectBoxes: $('select'),
            },
            editPassword: {
                form: $(`#${KEY}_edit_password_form`),
                parent: $(`#${KEY}_edit_password_form`).parent(),
                new_password: $(`#${KEY}_new_password`),
            },
            change_password: {
                form: $(`#${KEY}_change_password_form`),
                parent: $(`#${KEY}_change_password_form`).parent(),
                user_password: $(`#${KEY}_user_password`),
            }
        };

        // Call the initialization method
        this.initialization();
    }

    // Perform necessary initializations
    initialization() {
        this.registrationFront();
        this.loginFront();
        this.verificationFront();
        this.authenticationFront();
        this.industriesFront();
        this.forgotPasswordFront();
        this.changePasswordFront();
        this.editProfileFront();
        this.editPasswordFront();
        this.showPassword();
        this.codeCountDown();
    }

    // Front-end code for the registration form
    registrationFront() {
        let that          = this,
            $registration = this.$el.registration,
            ajaxRequests  = this.ajaxRequests;

        // Initialize international telephone input for phone number
        if ($('#ninja_phone_number').length > 0) {
            const input = $('#ninja_phone_number')[0];

            window.ITIOBJ.registration = intlTelInput(input, {
                initialCountry: 'EG',
                separateDialCode: true,
                autoInsertDialCode: true,
                allowDropdown: true,
                utilsScript: 'node_modules/intl-tel-input/build/js/utils.js',
            });
        }

        // Initialize form validation
        NhValidator.initAuthValidation($registration, 'registration');

        // Handle form submission
        $registration.form.on('submit', $registration.parent, function (e) {
            e.preventDefault();
            let $this             = $(e.currentTarget),
                formData          = $this.serializeObject();
            formData.phone_number = window.ITIOBJ.registration.getNumber().replace('+', '');

            // Abort any ongoing registration requests
            if (typeof ajaxRequests.registration !== 'undefined') {
                ajaxRequests.registration.abort();
            }

            // Validate the form and perform registration if valid
            if ($this.valid()) {
                that.registration(formData, $this);
            }
        });
    }

    // Front-end code for the login form
    loginFront() {
        let that         = this,
            $login       = this.$el.login,
            ajaxRequests = this.ajaxRequests;

        // Initialize form validation
        NhValidator.initAuthValidation($login, 'login');

        // Handle form submission
        $login.form.on('submit', $login.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing login requests
            if (typeof ajaxRequests.login !== 'undefined') {
                ajaxRequests.login.abort();
            }

            // Validate the form and perform login if valid
            if ($this.valid()) {
                that.login(formData, $this);
            }
        });
    }

    // Front-end code for the verification form
    verificationFront() {
        let that          = this,
            $verification = this.$el.verification,
            ajaxRequests  = this.ajaxRequests;

        // Handle click on OTP digits
        $verification.otpDigit.on('click', $verification.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            $this.select();
        });

        // Handle keyup events on OTP digits
        $verification.otpDigit.on('keyup', $verification.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            // Move focus to the next OTP digit or submit the form if last digit is entered
            if ($this.val().length == $this.attr('maxlength')) {
                if ($this.closest('.otp-digit').next('.otp-digit').find('input').length > 0) {
                    $this.closest('.otp-digit').next('.otp-digit').find('input').focus().select();
                } else {
                    $verification.verificationSubmit.trigger('click');
                }
            } else {
                $this.closest('.otp-digit').prev('.otp-digit').find('input').focus().select();
            }
        });

        // Initialize form validation
        NhValidator.initAuthValidation($verification, 'verification');

        // Handle form submission
        $verification.form.on('submit', $verification.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing verification requests
            if (typeof ajaxRequests.verification !== 'undefined') {
                ajaxRequests.verification.abort();
            }

            // Validate the form and perform verification if valid
            if ($this.valid()) {
                that.verification(formData, $this);
            }
        });

        // Handle click on resend verification code button
        $verification.resendCode.on('click', $verification.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formObj  = $verification.form.serializeObject(),
                formData = {
                    'g-recaptcha-response': formObj['g-recaptcha-response'],
                };

            // Abort any ongoing resend verification code requests
            if (typeof ajaxRequests.resendVerCode !== 'undefined') {
                ajaxRequests.resendVerCode.abort();
            }

            // Perform resend verification code request
            that.resendVerCode(formData, $this);
        });
    }

    // Front-end code for the authentication form
    authenticationFront() {
        let that            = this,
            $authentication = this.$el.authentication,
            ajaxRequests    = this.ajaxRequests;

        // Handle click on OTP digits
        $authentication.otpDigit.on('click', $authentication.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            $this.select();
        });

        // Handle keyup events on OTP digits
        $authentication.otpDigit.on('keyup', $authentication.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            // Move focus to the next OTP digit or submit the form if last digit is entered
            if ($this.val().length == $this.attr('maxlength')) {
                if ($this.closest('.otp-digit').next('.otp-digit').find('input').length > 0) {
                    $this.closest('.otp-digit').next('.otp-digit').find('input').focus().select();
                } else {
                    $authentication.authenticationSubmit.trigger('click');
                }
            } else {
                $this.closest('.otp-digit').prev('.otp-digit').find('input').focus().select();
            }
        });

        // Initialize form validation
        NhValidator.initAuthValidation($authentication, 'authentication');

        // Handle form submission
        $authentication.form.on('submit', $authentication.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing authentication requests
            if (typeof ajaxRequests.authentication !== 'undefined') {
                ajaxRequests.authentication.abort();
            }

            // Validate the form and perform authentication if valid
            if ($this.valid()) {
                that.authentication(formData, $this);
            }
        });

        // Handle click on resend authentication code button
        $authentication.resendCode.on('click', $authentication.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formObj  = $authentication.form.serializeObject(),
                formData = {
                    'g-recaptcha-response': formObj['g-recaptcha-response'],
                };

            // Abort any ongoing resend authentication code requests
            if (typeof ajaxRequests.resendAuthCode !== 'undefined') {
                ajaxRequests.resendAuthCode.abort();
            }

            // Perform resend authentication code request
            that.resendAuthCode(formData, $this);
        });
    }

    // Front-end code for the industries form
    industriesFront() {
        let that         = this,
            $industries  = this.$el.industries,
            $tagsInputs  = $industries.tags.find('input'),
            $showTags    = $industries.showTags,
            ajaxRequests = this.ajaxRequests;

        // Handle change event on industry tags inputs
        $tagsInputs.on('change', $industries.form, function (e) {
            let $this        = $(e.currentTarget),
                checkedCount = $industries.tags.find(':checked').length;
            $industries.selectedNumbersSpan.html(checkedCount);
        });

        // Handle click on show tags button
        $showTags.on('click', $industries.form, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            $('.hidden-tag').removeClass('hidden-tag');
            $this.remove();
        });

        // Initialize form validation
        NhValidator.initAuthValidation($industries, 'industries');

        // Handle form submission
        $industries.form.on('submit', $industries.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing industries requests
            if (typeof ajaxRequests.industries !== 'undefined') {
                ajaxRequests.industries.abort();
            }

            // Validate the form and perform industries request if valid
            if ($this.valid()) {
                that.industries(formData, $this);
            }
        });
    }

    // Front-end code for the forgot password form
    forgotPasswordFront() {
        let that         = this,
            $forgot      = this.$el.forgot,
            ajaxRequests = this.ajaxRequests;

        // Initialize form validation
        NhValidator.initAuthValidation($forgot, 'forgotPassword');

        // Handle form submission
        $forgot.form.on('submit', $forgot.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing forgot password requests
            if (typeof ajaxRequests.forgot !== 'undefined') {
                ajaxRequests.forgot.abort();
            }

            // Validate the form and perform forgot password request if valid
            if ($this.valid()) {
                that.forgotPassword(formData, $this);
            }
        });
    }

    // Front-end code for the edit profile form
    editProfileFront() {
        let that         = this,
            $editProfile = this.$el.editProfile,
            $selectBoxes = $editProfile.selectBoxes,
            ajaxRequests = this.ajaxRequests;

        // TODO: Implement after design
        // Initialize select boxes (Choices.js)
        // $selectBoxes.each(function (i, v) {
        //     new Choices(v, {
        //         itemSelectText: nhGlobals.phrases.choices_select,
        //         noChoicesText: nhGlobals.phrases.noChoicesText,
        //         removeItemButton: true,
        //         allowHTML: true,
        //     });
        // });

        // Initialize international telephone input for phone number
        if ($('#ninja_phone_number').length > 0) {
            const input = $('#ninja_phone_number')[0];

            window.ITIOBJ.editProfile = intlTelInput(input, {
                initialCountry: 'EG',
                separateDialCode: true,
                autoInsertDialCode: true,
                allowDropdown: true,
                utilsScript: 'node_modules/intl-tel-input/build/js/utils.js',
            });
        }

        // Initialize form validation
        NhValidator.initAuthValidation($editProfile, 'editProfile');

        // Handle form submission
        $editProfile.form.on('submit', $editProfile.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();
            formData.phone_number = window.ITIOBJ.editProfile.getNumber().replace('+', '');

            // Abort any ongoing edit profile requests
            if (typeof ajaxRequests.editProfile !== 'undefined') {
                ajaxRequests.editProfile.abort();
            }

            // Validate the form and perform edit profile request if valid
            if ($this.valid()) {
                that.editProfile(formData, $this);
            }
        });
    }

    // Front-end code for the edit password form
    editPasswordFront() {
        let that          = this,
            $editPassword = this.$el.editPassword,
            ajaxRequests  = this.ajaxRequests;

        // Initialize form validation
        NhValidator.initAuthValidation($editPassword, 'editPassword');

        // Handle form submission
        $editPassword.form.on('submit', $editPassword.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing edit password requests
            if (typeof ajaxRequests.editPassword !== 'undefined') {
                ajaxRequests.editPassword.abort();
            }

            // Validate the form and perform edit password request if valid
            if ($this.valid()) {
                that.editPassword(formData, $this);
            }
        });
    }

    // Front-end code for the change password form
    changePasswordFront() {
        let that             = this,
            $change_password = this.$el.change_password,
            ajaxRequests     = this.ajaxRequests;

        // Initialize form validation
        NhValidator.initAuthValidation($change_password, 'change_password');

        // Handle form submission
        $change_password.form.on('submit', $change_password.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing change password requests
            if (typeof ajaxRequests.changePassword !== 'undefined') {
                ajaxRequests.changePassword.abort();
            }

            // Validate the form and perform change password request if valid
            if ($this.valid()) {
                that.changePassword(formData, $this);
            }
        });
    }

    // Show/hide password when the show password icon is clicked
    showPassword() {
        $('.showPassIcon').on('click', function (e) {
            let $this           = $(e.currentTarget),
                $target_element = $this.attr('data-target');
            $this.removeClass('fa-solid fa-eye');
            $this.addClass('fa-sharp fa-solid fa-eye-slash');
            if ($($target_element).attr('type') === 'password') {
                $($target_element).attr('type', 'text');
                $this.removeClass('fa-sharp fa-solid fa-eye-slash');
                $this.addClass('fa-solid fa-eye');
            } else {
                $($target_element).attr('type', 'password');
                $this.removeClass('fa-solid fa-eye');
                $this.addClass('fa-sharp fa-solid fa-eye-slash');
            }
        });
    }
}

// Create an instance of the NhAuthentication class
new NhAuthentication();
