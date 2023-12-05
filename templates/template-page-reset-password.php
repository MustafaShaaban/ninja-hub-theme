<?php
    /**
     * @Filename: template-page-reset-password.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Reset Password Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Forms;
    use NH\Nh;

    get_header();
?>

    <main id="" class="">
        <h1>Reset Password Page</h1>
        <?php
            if (isset($_GET['key'])) {
                $key = sanitize_text_field($_GET['key']);

                $validate = Nh_User::check_reset_code($key);

                if (!is_wp_error($validate)) {
                    echo Nh_Forms::get_instance()
                                 ->create_form([
                                     'user_password'         => [
                                         'class'       => '',
                                         'type'        => 'password',
                                         'label'       => __('Password', 'ninja'),
                                         'name'        => 'user_password',
                                         'required'    => TRUE,
                                         'placeholder' => __('Your Password', 'ninja'),
                                         'before'      => '',
                                         'after'       => '<i class="fa fa-eye showPassIcon resetCustom" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password"></i>',
                                         'order'       => 0,
                                     ],
                                     'user_password_confirm' => [
                                         'class'       => 'password-confirm',
                                         'type'        => 'password',
                                         'label'       => __('Confirm Password', 'ninja'),
                                         'name'        => 'user_password_confirm',
                                         'required'    => TRUE,
                                         'placeholder' => __('Confirm Your Password', 'ninja'),
                                         'before'      => '',
                                         'after'       => '<i class="fa fa-eye showPassIcon reset" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password_confirm"></i>',
                                         'order'       => 10,
                                     ],
                                     'user_key'              => [
                                         'class'    => '',
                                         'type'     => 'hidden',
                                         'name'     => 'user_key',
                                         'required' => TRUE,
                                         'value'    => $key,
                                         'order'    => 15,
                                     ],
                                     'forgot_nonce'          => [
                                         'class' => '',
                                         'type'  => 'nonce',
                                         'name'  => 'change_password_nonce',
                                         'value' => Nh::_DOMAIN_NAME . "_change_password_form",
                                         'order' => 15
                                     ],
                                     'submit'                => [
                                         'class'               => 'button_state',
                                         'type'                => 'submit',
                                         'value'               => __('Reset Password', 'ninja'),
                                         'before'              => '',
                                         'after'               => '',
                                         'recaptcha_form_name' => "platform_reset_password",
                                         'order'               => 20
                                     ]
                                 ], [
                                     'class' => Nh::_DOMAIN_NAME . '-change-password-form',
                                     'id'    => Nh::_DOMAIN_NAME . '_change_password_form'
                                 ]);

                } else {
                    ?>
                    <p class="invalid">
                        <?= $validate->get_error_message() ?>,
                        <?= __("please follow the link", "ninja") ?>
                        <a href="<?= get_permalink(get_page_by_path('account/forgot-password')) ?>"><?= __("Reset Password", "ninja") ?></a>
                        <?= __("to get the new code", "ninja") ?>
                    </p>

                    <?php
                }

            } else {
                // Set the HTTP status code to 404
                status_header(404);

                // Load the 404 template
                get_template_part('404');
            }
        ?>
    </main><!-- #main -->

<?php get_footer();

