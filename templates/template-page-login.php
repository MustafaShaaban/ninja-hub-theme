<?php
    /**
     * @Filename: template-page-login.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Login Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    use NH\APP\HELPERS\Nh_Forms;
    use NH\Nh;

    get_header();
?>

    <main id="" class="">
        <h1>Login Page</h1>
        <?php
            echo Nh_Forms::get_instance()
                         ->create_form([
                             'custom-html-1' => [
                                 'type'    => 'html',
                                 'content' => '<div class="d-flex flex-row flex-wrap col-12">',
                                 'order'   => 0,
                             ],
                             'user_login'    => [
                                 'class'       => 'col-12 col-md-6',
                                 'type'        => 'text',
                                 'label'       => __('Email or phone number', 'ninja'),
                                 'name'        => 'user_login',
                                 'required'    => TRUE,
                                 'placeholder' => __('Enter your email or phone number', 'ninja'),
                                 'order'       => 5,
                             ],
                             'user_password' => [
                                 'class'       => 'col-12 col-md-6 ',
                                 'type'        => 'password',
                                 'label'       => __('Password', 'ninja'),
                                 'name'        => 'user_password',
                                 'required'    => TRUE,
                                 'placeholder' => __('Enter your password', 'ninja'),
                                 'after'       => '<i class="showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password"></i>',
                                 'order'       => 10,
                             ],
                             'rememberme'    => [
                                 'class'   => 'form-field col-6 align-items-start pt-3 m-0',
                                 'type'    => 'checkbox',
                                 'choices' => [
                                     [
                                         'class' => ' ',
                                         'label' => 'Remember me',
                                         'name'  => 'rememberme',
                                         'value' => '1',
                                         'order' => 0,
                                     ],
                                 ],
                                 'order'   => 15,
                             ],
                             'custom-html-3' => [
                                 'type'    => 'html',
                                 'content' => '<div class="form-field col-6 align-items-end pe-3 m-0 mt-3" ><a href="' . apply_filters('nhml_permalink', get_permalink(get_page_by_path('account/forgot-password'))) . '" class="btn-link text-accent forgot_password"> ' . __('Forgot your Password?', 'ninja') . ' </a></div></div>',
                                 'order'   => 20,
                             ],
                             'login_nonce'   => [
                                 'class' => '',
                                 'type'  => 'nonce',
                                 'name'  => 'login_nonce',
                                 'value' => Nh::_DOMAIN_NAME . "_login_form",
                                 'order' => 25,
                             ],
                             'submit'        => [
                                 'class'               => '',
                                 'type'                => 'submit',
                                 'value'               => __('Login', 'ninja'),
                                 'before'              => '',
                                 'after'               => '',
                                 'recaptcha_form_name' => 'platform_login',
                                 'order'               => 25,
                             ],
                         ], [
                             'class' => Nh::_DOMAIN_NAME . '-login-form',
                             'id'    => Nh::_DOMAIN_NAME . '_login_form',
                         ]);
        ?>
    </main><!-- #main -->

<?php get_footer();

