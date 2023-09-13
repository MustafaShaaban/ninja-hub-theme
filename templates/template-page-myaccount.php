<?php
    /**
     * @Filename: template-page-myaccount.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: My Account Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\Nh;

    get_header();
    $user_obj     = new Nh_User();
    $user         = $user_obj::get_current_user();
?>

    <main id="" class="">
        <h1>MY ACCOUNT</h1>
        <?php
            $form_fields = [
                'custom-html-1'      => [
                    'type'    => 'html',
                    'content' => '<div class="row">',
                    'order'   => 0,
                ],
                'first_name'         => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('First name', 'ninja'),
                    'name'        => 'first_name',
                    'value'        => $user->first_name,
                    'required'    => TRUE,
                    'placeholder' => __('Enter your first name', 'ninja'),
                    'order'       => 5,
                ],
                'last_name'          => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Last name', 'ninja'),
                    'name'        => 'last_name',
                    'value'        => $user->last_name,
                    'required'    => TRUE,
                    'placeholder' => __('Enter your last name', 'ninja'),
                    'order'       => 10,
                ],
                'phone_number'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Phone number', 'ninja'),
                    'name'        => 'phone_number',
                    'value'        => $user->user_meta['phone_number'],
                    'required'    => TRUE,
                    'placeholder' => __('Enter your phone number', 'ninja'),
                    'extra_attr' => ['disabled' => 'disable'],
                    'order'       => 15,
                ],
                'user_email'         => [
                    'class'       => 'col-6',
                    'type'        => 'email',
                    'label'       => __('Email', 'ninja'),
                    'name'        => 'user_email',
                    'value'        => $user->email,
                    'required'    => TRUE,
                    'placeholder' => __('Enter your email', 'ninja'),
                    'order'       => 20,
                ],
                'site_language'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Profile language', 'ninja'),
                    'name'        => 'site_language',
                    'placeholder' => __('Select your language', 'ninja'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => [$user->user_meta['site_language']],
                    'before'      => '',
                    'order'       => 25,
                ],
                'widget_list'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Widget list categories', 'ninja'),
                    'name'        => 'widget_list',
                    'multiple'    => 'multiple',
                    'placeholder' => __('Select your widget', 'ninja'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => $user->profile->meta_data['widget_list'],
                    'before'      => '',
                    'order'       => 30,
                ],
                'preferred_opportunities_cat_list'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Preferred categories list for opportunities', 'ninja'),
                    'name'        => 'preferred_opportunities_cat_list',
                    'multiple'    => 'multiple',
                    'placeholder' => __('Select your preferred', 'ninja'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => $user->profile->meta_data['preferred_opportunities_cat_list'],
                    'before'      => '',
                    'order'       => 35,
                ],
                'preferred_articles_cat_list'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('preferred categories list for articles', 'ninja'),
                    'name'        => 'preferred_articles_cat_list',
                    'multiple'    => 'multiple',
                    'placeholder' => __('Select your preferred', 'ninja'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => $user->profile->meta_data['preferred_articles_cat_list'],
                    'before'      => '',
                    'order'       => 40,
                ],
                'custom-html-3'      => [
                    'type'    => 'html',
                    'content' => '</div>',
                    'order'   => 45,
                ],
                'edit_profile_nonce' => [
                    'class' => '',
                    'type'  => 'nonce',
                    'name'  => 'edit_profile_nonce',
                    'value' => Nh::_DOMAIN_NAME . "_edit_profile_form",
                    'order' => 50
                ],
                'submit'             => [
                    'class'               => '',
                    'type'                => 'submit',
                    'id'                => Nh::_DOMAIN_NAME . '_edit_profile_submit',
                    'value'               => __('Save', 'ninja'),
                    'before'              => '',
                    'after'               => '',
                    'recaptcha_form_name' => 'frontend_edit_profile',
                    'order'               => 55
                ],
            ];
            $form_tags   = [
                'class' => Nh::_DOMAIN_NAME . '-edit-profile-form',
                'id'    => Nh::_DOMAIN_NAME . '_edit_profile_form'
            ];

            $languages = Nh_Public::get_available_languages();

            foreach ($languages as $lang) {
                $form_fields['site_language']['options'][$lang['code']] = $lang['name'];
            }

            $opportunities_obj = new Nh_Opportunity();
            $opportunities_tax_terms = $opportunities_obj->get_taxonomy_terms('opportunity-category');

            foreach ($opportunities_tax_terms as $key => $term) {
                $form_fields['preferred_opportunities_cat_list']['options'][$term->term_id] = $term->name;
            }

            $blogs_obj = new Nh_Blog();
            $blogs_obj_tax_terms = $opportunities_obj->get_taxonomy_terms('category');

            foreach ($blogs_obj_tax_terms as $key => $term) {
                $form_fields['preferred_articles_cat_list']['options'][$term->term_id] = $term->name;
            }

            echo Nh_Forms::get_instance()
                          ->create_form($form_fields, $form_tags);

        ?>

        <?php
            echo Nh_Forms::get_instance()
                          ->create_form([
                              'current_password'      => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Current password', 'ninja'),
                                  'name'        => 'current_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your current password', 'ninja'),
                                  'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_current_password"></i>',
                                  'order'       => 5,
                              ],
                              'new_password'      => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('New password', 'ninja'),
                                  'name'        => 'new_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your new password', 'ninja'),
                                  'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_new_password"></i>',
                                  'order'       => 10,
                              ],
                              'confirm_new_password'   => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Confirm new password', 'ninja'),
                                  'name'        => 'confirm_new_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Re-enter your new password', 'ninja'),
                                  'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_confirm_new_password"></i>',
                                  'order'       => 15,
                              ],
                              'edit_password_nonce' => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'edit_password_nonce',
                                  'value' => Nh::_DOMAIN_NAME . "_edit_password_form",
                                  'order' => 20
                              ],
                              'submit'             => [
                                  'class'               => '',
                                  'type'                => 'submit',
                                  'id'                => Nh::_DOMAIN_NAME . '_edit_password_submit',
                                  'value'               => __('Save', 'ninja'),
                                  'before'              => '',
                                  'after'               => '',
                                  'recaptcha_form_name' => 'frontend_edit_profile',
                                  'order'               => 25
                              ],
                          ], [
                              'class' => Nh::_DOMAIN_NAME . '-edit-password-form',
                              'id'    => Nh::_DOMAIN_NAME . '_edit_password_form'
                          ]);
        ?>
    </main><!-- #main -->

<?php get_footer();
