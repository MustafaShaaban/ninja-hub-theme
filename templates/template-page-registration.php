<?php
    /**
     * @Filename: template-page-registration.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Registration Page
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
        <?php
            echo do_shortcode('[nextend_social_login]');
            echo Nh_Forms::get_instance()
                          ->create_form([
                              'custom-html-1'      => [
                                  'type'    => 'html',
                                  'content' => '<div class="row">',
                                  'order'   => 0,
                              ],
                              'first_name'         => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('First Name', 'ninja'),
                                  'name'        => 'first_name',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your first name', 'ninja'),
                                  'order'       => 5,
                              ],
                              'last_name'          => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('Last Name', 'ninja'),
                                  'name'        => 'last_name',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your last name', 'ninja'),
                                  'order'       => 10,
                              ],
                              'phone_number'       => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('Phone Number', 'ninja'),
                                  'name'        => 'phone_number',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your phone number', 'ninja'),
                                  'order'       => 15,
                              ],
                              'user_email'         => [
                                  'class'       => 'col-6',
                                  'type'        => 'email',
                                  'label'       => __('Email', 'ninja'),
                                  'name'        => 'user_email',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your email', 'ninja'),
                                  'order'       => 20,
                              ],
                              'user_password'      => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Password', 'ninja'),
                                  'name'        => 'user_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your password', 'ninja'),
                                  'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password"></i>',
                                  'order'       => 25,
                              ],
                              'confirm_password'   => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Confirm Password', 'ninja'),
                                  'name'        => 'confirm_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your confirm password', 'ninja'),
                                  'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_confirm_password"></i>',
                                  'order'       => 30,
                              ],
                              'user_type'          => [
                                  'type'           => 'select',
                                  'label'          => __('User Type', 'ninja'),
                                  'name'           => 'user_type',
                                  'required'       => TRUE,
                                  'placeholder'    => __('Enter your user type', 'ninja'),
                                  'options'        => [
                                      'owner'    => __('I am Owner', 'ninja'),
                                      'investor' => __('I am Investor', 'ninja'),
                                  ],
                                  'default_option' => '',
                                  'select_option'  => '',
                                  'class'          => 'col-6',
                                  'order'          => 35,
                              ],
                              'verification_type'  => [
                                  'type'           => 'select',
                                  'label'          => __('Account Verification Type', 'ninja'),
                                  'name'           => 'verification_type',
                                  'required'       => TRUE,
                                  'placeholder'    => __('Enter your verification type', 'ninja'),
                                  'options'        => [
                                      Nh_User::VERIFICATION_TYPES['email']    => __('Email', 'ninja'),
                                      Nh_User::VERIFICATION_TYPES['mobile']   => __('Phone Number', 'ninja'),
                                      Nh_User::VERIFICATION_TYPES['whatsapp'] => __('Whatsapp', 'ninja'),
                                  ],
                                  'default_option' => '',
                                  'select_option'  => '',
                                  'class'          => 'col-6',
                                  'order'          => 40,
                              ],
                              'custom-html-3'      => [
                                  'type'    => 'html',
                                  'content' => '</div>',
                                  'order'   => 45,
                              ],
                              'registration_nonce' => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'registration_nonce',
                                  'value' => Nh::_DOMAIN_NAME . "_registration_form",
                                  'order' => 50
                              ],
                              'submit'             => [
                                  'class'               => '',
                                  'type'                => 'submit',
                                  'value'               => __('Create Account', 'ninja'),
                                  'before'              => '',
                                  'after'               => '',
                                  'recaptcha_form_name' => 'frontend_registration',
                                  'order'               => 55
                              ],
                          ], [
                              'class' => Nh::_DOMAIN_NAME . '-registration-form',
                              'id'    => Nh::_DOMAIN_NAME . '_registration_form'
                          ]);
        ?>
    </main><!-- #main -->

<?php get_footer();

