<?php
    /**
     * @Filename: class-nh_admin.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */


    namespace NH\APP\MODELS\ADMIN;

    use NH\APP\CLASSES\Nh_Init;
    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

    /**
     * Description...
     *
     * @class Nh_Admin
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Admin
    {

        /**
         * @var \NH\APP\HELPERS\Nh_Hooks
         */
        private Nh_Hooks $hooks;


        /**
         * @param \NH\APP\HELPERS\Nh_Hooks $hooks
         */
        public function __construct(Nh_Hooks $hooks)
        {
            $this->hooks = $hooks;
            $this->actions();
            $this->filters();
            Nh_Init::get_instance()
                   ->run('admin');
        }

        public function actions(): void
        {
            $this->hooks->add_action('admin_enqueue_scripts', $this, 'enqueue_styles');
            $this->hooks->add_action('admin_enqueue_scripts', $this, 'enqueue_scripts');
            $this->hooks->run();
        }

        public function filters()
        {
            $this->hooks->add_filter('gglcptch_add_custom_form', $this, 'add_custom_recaptcha_forms', 10, 1);
            $this->hooks->run();
        }

        public function enqueue_styles(): void
        {
            $this->hooks->add_style(Nh::_DOMAIN_NAME . '-admin-style-main', Nh_Hooks::PATHS['admin']['css'] . '/style');
        }

        public function enqueue_scripts(): void
        {
            $this->hooks->add_script(Nh::_DOMAIN_NAME . '-admin-script-main', Nh_Hooks::PATHS['admin']['js'] . '/main', [ 'jquery' ]);
            $this->hooks->add_localization(Nh::_DOMAIN_NAME . '-admin-script-main', 'nhGlobals', [
                'domain_key' => Nh::_DOMAIN_NAME,
                'ajaxUrl'    => admin_url('admin-ajax.php'),
                'phrases'     => [
                    'default'        => __("This field is required.", "nh"),
                    'email'          => __("Please enter a valid email address.", "nh"),
                    'number'         => __("Please enter a valid number.", "nh"),
                    'equalTo'        => __("Please enter the same value again.", "nh"),
                    'maxlength'      => __("Please enter no more than {0} characters.", "nh"),
                    'minlength'      => __("Please enter at least {0} characters.", "nh"),
                    'max'            => __("Please enter a value less than or equal to {0}.", "nh"),
                    'min'            => __("Please enter a value greater than or equal to {0}.", "nh"),
                    'pass_regex'     => __("Your password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character from the following: ! @ # $ % ^ & *.", "ninja"),
                    'phone_regex'    => __("Please enter a valid Phone number.", "ninja"),
                    'intlTelNumber'  => __("Please enter a valid International Telephone Number.", "ninja"),
                    'email_regex'    => __("Please enter a valid email address.", "ninja"),
                    'file_extension' => __("Please upload a file with a valid extension.", "ninja"),
                    'file_max_size'  => __("File size must be less than {0} KB", "ninja"),
                    'choices_select' => __("Press to select", "ninja"),
                    'noChoicesText'  => __("'No choices to choose from'", "ninja"),
                    'time_regex'     => __("Invalid time range format. Please use HH:mm AM/PM - HH:mm AM/PM", "ninja"),
                    'englishOnly'   => __("Only English text is allowed.", "ninja"),
                    'arabicOnly'   => __("Only Arabic text is allowed.", "ninja"),
                ]
            ]);
            $this->hooks->run();

        }

        /**
         * Description...
         *
         * @param $forms
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function add_custom_recaptcha_forms($forms)
        {
            $forms['platform_login']           = [ "form_name" => "Platform Login" ];
            $forms['platform_registration']    = [ "form_name" => "Platform Registration" ];
            $forms['platform_reset_password']  = [ "form_name" => "Platform Reset Password" ];
            $forms['platform_forgot_password'] = [ "form_name" => "Platform Forgot Password" ];
            $forms['attachment_handler']       = [ "form_name" => "Attachments Handler" ];
            return $forms;
        }

    }
