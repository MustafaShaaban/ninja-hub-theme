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
        <?php
            echo do_shortcode('[nextend_social_login]');
            echo Nh_Forms::get_instance()
                          ->create_form([
                              'custom-html-1' => [
                                  'type'    => 'html',
                                  'content' => '<div class="row">',
                                  'order'   => 0,
                              ],
                              'user_login'    => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('Phone Number or Email', 'ninja'),
                                  'name'        => 'user_login',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter you phone or email', 'ninja'),
                                  'order'       => 5,
                              ],
                              'user_password' => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Password', 'ninja'),
                                  'name'        => 'user_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter you password', 'ninja'),
                                  'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password"></i>',
                                  'order'       => 10,
                              ],
                              'rememberme'    => [
                                  'class'   => 'col-6',
                                  'type'    => 'checkbox',
                                  'choices' => [
                                      [
                                          'class' => '',
                                          'label' => 'Remember me',
                                          'name'  => 'rememberme',
                                          'value' => '1',
                                          'order' => 0,
                                      ]
                                  ],
                                  'order'   => 15,
                              ],
                              'custom-html-3' => [
                                  'type'    => 'html',
                                  'content' => '<div class="form-group col-6" ><a href="' . get_permalink(get_page_by_path('my-account')) . 'forgot-password" class="main-color"> ' . __('Forget Password', 'ninja') . ' </a></div></div>',
                                  'order'   => 20,
                              ],
                              'login_nonce'   => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'login_nonce',
                                  'value' => Nh::_DOMAIN_NAME . "_login_form",
                                  'order' => 25
                              ],
                              'submit'        => [
                                  'class'               => '',
                                  'type'                => 'submit',
                                  'value'               => __('Login', 'ninja'),
                                  'before'              => '',
                                  'after'               => '',
                                  'recaptcha_form_name' => 'frontend_login',
                                  'order'               => 25
                              ],
                          ], [
                              'class' => Nh::_DOMAIN_NAME . '-login-form',
                              'id'    => Nh::_DOMAIN_NAME . '_login_form'
                          ]);
        ?>
    </main><!-- #main -->

<?php get_footer();

