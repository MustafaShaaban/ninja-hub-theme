<?php
    /**
     * @Filename: template-page-verification.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Verification Page
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

    $user = Nh_User::get_current_user();
?>

    <main id="" class="">
        <h1>VERIFICATION</h1>
        <?php

            echo Nh_Forms::get_instance()
                          ->create_form([
                              'custom-html-1'      => [
                                  'type'    => 'html',
                                  'content' => '<div class="d-flex justify-content-center align-items-center">',
                                  'order'   => 0,
                              ],
                              'code1'              => [
                                  'class'       => 'otp-digit',
                                  'type'        => 'tel',
                                  'name'        => 'code1',
                                  'required'    => TRUE,
                                  'placeholder' => __('0', 'ninja'),
                                  'extra_attr'  => [
                                      'maxlength' => '1',
                                      'autofocus' => 'on',
                                  ],
                                  'order'       => 5,
                              ],
                              'code2'              => [
                                  'class'       => 'otp-digit',
                                  'type'        => 'tel',
                                  'name'        => 'code2',
                                  'required'    => TRUE,
                                  'placeholder' => __('0', 'ninja'),
                                  'extra_attr'  => [
                                      'maxlength' => '1',
                                  ],
                                  'order'       => 10,
                              ],
                              'code3'              => [
                                  'class'       => 'otp-digit',
                                  'type'        => 'tel',
                                  'name'        => 'code3',
                                  'required'    => TRUE,
                                  'placeholder' => __('0', 'ninja'),
                                  'extra_attr'  => [
                                      'maxlength' => '1',
                                  ],
                                  'order'       => 15,
                              ],
                              'code4'              => [
                                  'class'       => 'otp-digit',
                                  'type'        => 'tel',
                                  'name'        => 'code4',
                                  'required'    => TRUE,
                                  'placeholder' => __('0', 'ninja'),
                                  'extra_attr'  => [
                                      'maxlength' => '1',
                                  ],
                                  'order'       => 20,
                              ],
                              'custom-html-2'      => [
                                  'type'    => 'html',
                                  'content' => '</div>',
                                  'order'   => 25,
                              ],
                              'verification_nonce' => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'verification_nonce',
                                  'value' => Nh::_DOMAIN_NAME . "_verification_form",
                                  'order' => 30
                              ],
                              'custom-html-3'      => [
                                  'type'    => 'html',
                                  'content' => '<div class="d-flex justify-content-between align-items-center">',
                                  'order'   => 35,
                              ],
                              'custom-html-4'      => [
                                  'type'    => 'html',
                                  'content' => '<div class=""><p class="ninjaresend-code-patent" data-expire="'.$user->user_meta['verification_expire_date'].'">' . sprintf(__("It may take a minute to receive your code. <br> Haven't received it ? <button class='ninjaresend-code ninjahidden' type='button'>Resend a new code.</button> <span class='ninjacode-count-down'></span>"), $user->user_meta['verification_expire_date']) . '</p></div>',
                                  'order'   => 40,
                              ],
                              'submit'             => [
                                  'class'               => 'btn',
                                  'id'                => 'verificationSubmit',
                                  'type'                => 'submit',
                                  'value'               => __('Verify', 'ninja'),
                                  'recaptcha_form_name' => 'frontend_verification',
                                  'order'               => 45
                              ],
                              'custom-html-5'      => [
                                  'type'    => 'html',
                                  'content' => '</div>',
                                  'order'   => 50,
                              ],
                          ], [
                              'class' => Nh::_DOMAIN_NAME . '-verification-form',
                              'id'    => Nh::_DOMAIN_NAME . '_verification_form'
                          ]);

        ?>
    </main><!-- #main -->

<?php get_footer();

