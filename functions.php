<?php
    /**
     * nh functions and definitions
     *
     * @link https://developer.wordpress.org/themes/basics/theme-functions/
     *
     * @package NinjaHub
     */

    namespace NH;

    use NH\APP\CLASSES\Nh_Init;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\ADMIN\Nh_Admin;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NINJAHUB\APP\HELPERS\Ninjahub_Hooks;
    use NINJAHUB\Ninjahub;

    if (!defined('NH_lANG')) {
        define('NH_lANG', defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en');
    }

    if (!defined('THEME_PATH')) {
        define('THEME_PATH', get_stylesheet_directory());
    }

    if (!defined('THEME_URI')) {
        define('THEME_URI', get_stylesheet_directory_uri());
    }

    if (!defined('NH_CONFIGURATION')) {
        define('NH_CONFIGURATION', get_option('nh_configurations') ?: []);
    }

    if (class_exists('NINJAHUB\APP\CLASSES\Ninjahub_Init')) {

        locate_template("app/Classes/class-nh_init.php", TRUE);
        locate_template("app/Models/public/class-nh_public.php", TRUE);
        locate_template("app/Models/admin/class-nh_admin.php", TRUE);
        locate_template("inc/template-tags.php", TRUE);

        /**
         * Description...
         *
         * @class Nh
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        class Nh extends Ninjahub
        {
            public function __construct()
            {
                parent::__construct();
                $hooks = new Ninjahub_Hooks();
                $this->init_models($hooks);
                $this->actions($hooks);
                $this->filters($hooks);
                $hooks->run();
            }

            private function init_models($hooks): void
            {
                if (class_exists('NH\APP\MODELS\FRONT\Nh_Public') && (!is_admin()) || wp_doing_ajax()) {
                    $public = new Nh_Public($hooks);
                }

                if (class_exists('NH\APP\MODELS\ADMIN\Nh_Admin') && is_admin()) {
                    $admin = new Nh_Admin($hooks);
                }
            }

            protected function actions($hooks): void
            {

            }

            protected function filters($hooks): void
            {

            }
        }

        new Nh();
    }

    locate_template("inc/tgm-plugin-activation.php", TRUE);
    locate_template("inc/custom-functions.php", TRUE);