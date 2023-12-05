<?php
    /**
     * The header for our theme
     *
     * This is the template that displays all of the <head> section and everything up until <div id="content">
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package NinjaHub
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

        <?php wp_body_open(); ?>

        <main id="page" class="site">

            <?php
                $dashboard = [ 'dashboard' ];
                $account   = [
                    'account',
                    'login',
                    'registration-landing',
                    'registration',
                    'forgot-password',
                    'reset-password',
                    'verification'
                ];
                if (is_front_page()) {
                    get_template_part('app/Views/template-parts/headers/landing');
                } elseif (is_page($account)) {
                    get_template_part('app/Views/template-parts/headers/account');
                } elseif (is_page($dashboard)) {
                    get_template_part('app/Views/template-parts/headers/dashboard');
                } else {
                    get_template_part('app/Views/template-parts/headers/default');
                }
            ?>
