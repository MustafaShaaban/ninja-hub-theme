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
            $forms['frontend_login']           = [ "form_name" => "Front End Login" ];
            return $forms;
        }

    }
