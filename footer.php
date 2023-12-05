<?php
    /**
     * The template for displaying the footer
     *
     * Contains the closing of the #content div and all content after.
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package NinjaHub
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

?>

<?php
    $dashboard = [ 'dashboard' ];
    $account   = [
        'account',
        'login',
        'registration',
        'registration-landing',
        'forgot-password',
        'reset-password',
        'verification',
    ];
    if (is_front_page()) {
        get_template_part('app/Views/template-parts/footers/landing');
    } elseif (is_page($account)) {
        get_template_part('app/Views/template-parts/footers/account');
    } elseif (is_page($dashboard)) {
        get_template_part('app/Views/template-parts/footers/dashboard');
    } else {
        get_template_part('app/Views/template-parts/footers/default');
    }
?>

<?php wp_body_close(); ?>

</main><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
