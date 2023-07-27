<?php
    /**
     * @Filename: template-page-forgot-password.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Forgot Password Page
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
        <?php
            echo Nh_Forms::get_instance()
                          ->create_form([
                              'user_email_phone'   => [
                                  'class'       => 'has-header',
                                  'type'        => 'text',
                                  'label'       => __('Phone Number or Email', 'ninja'),
                                  'name'        => 'user_email_phone',
                                  'required'    => TRUE,
                                  'placeholder' => __('Ex. email@gmail.com', 'ninja'),
                                  'order'       => 0,
                              ],
                              'forgot_nonce' => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'forgot_nonce',
                                  'value' => Nh::_DOMAIN_NAME . "_forgot_form",
                                  'order' => 15
                              ],
                              'submit'       => [
                                  'class'               => 'button_state',
                                  'type'                => 'submit',
                                  'value'               => __('Send', 'ninja'),
                                  'before'              => '',
                                  'after'               => '',
                                  'recaptcha_form_name' => 'frontend_forgot_password',
                                  'order'               => 20
                              ]
                          ], [
                              'class' => Nh::_DOMAIN_NAME . '-forgot-form',
                              'id'    => Nh::_DOMAIN_NAME . '_forgot_form'
                          ]);

        ?>
    </main><!-- #main -->

<?php get_footer();

