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

    locate_template("app/Classes/class-nh_init.php", TRUE);
    locate_template("app/Models/public/class-nh_public.php", TRUE);
    locate_template("app/Models/admin/class-nh_admin.php", TRUE);
    locate_template("inc/tgm-plugin-activation.php", TRUE);
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
//            Nh_Init::get_instance()->run('core');
        }

    }

    new Nh();

    locate_template("inc/custom-functions.php", TRUE);