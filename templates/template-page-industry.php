<?php
    /**
     * @Filename: template-page-industry.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Industry Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\Nh;

    get_header();
    global $user_ID;
    $user            = Nh_User::get_current_user();
    $opportunity_obj = new Nh_Opportunity();
?>

    <main id="" class="">

        <h3><?= __('Choose which industry you are interested in:') ?></h3>
        <?php
            $terms = $opportunity_obj->get_taxonomy_terms('industry');

            $form_fields = [
                'custom-html-1'    => [
                    'type'    => 'html',
                    'content' => "<div class='d-flex justify-content-between align-items-center'><span class='available'>".sprintf(__('(%s Industry Available)', 'ninja'),count
                        ($terms))."</span><span class='industries-selected'>".sprintf(__('(%s Selected)', 'ninja'), '<span class="selected-number">0</span>')."</span></div>",
                    'order'   => 0
                ],
                'industries'       => [
                    'class'   => 'col-6',
                    'type'    => 'checkbox',
                    'choices' => [],
                    'order'   => 5,
                ],
                'industries_nonce' => [
                    'class' => '',
                    'type'  => 'nonce',
                    'name'  => 'industries_nonce',
                    'value' => Nh::_DOMAIN_NAME . "_industries_form",
                    'order' => 15
                ],
                'submit'           => [
                    'class'               => '',
                    'type'                => 'submit',
                    'value'               => __('Continue', 'ninja'),
                    'before'              => '',
                    'after'               => '',
                    'recaptcha_form_name' => 'frontend_industries',
                    'order'               => 20
                ],
            ];
            $form_tags   = [
                'class' => Nh::_DOMAIN_NAME . '-industries-form',
                'id'    => Nh::_DOMAIN_NAME . '_industries_form'
            ];


            foreach ($terms as $key => $term) {
                $hidden_class = $key > 4 ? 'hidden-tag' : '';
                $form_fields['industries']['choices'][] = [
                    'class' => 'industries-tags ' . $hidden_class,
                    'label' => $term->name,
                    'name'  => 'industries',
                    'value' => $term->term_id,
                    'order' => $key
                ];
                if (count($terms) > 4 && count($terms) -1 === $key ) {
                    $rest = count($terms) - 5;
                    $form_fields['custom-html-last'] = [
                        'type'    => 'html',
                        'content' => "<a href='javascript:(0);' class='show-tags'>".sprintf(__('%s more..', 'ninja'),$rest) ."</a>",
                        'order'   => 10
                    ];
                }
            }
            echo Nh_Forms::get_instance()
                          ->create_form($form_fields, $form_tags);
        ?>

    </main><!-- #main -->

<?php get_footer();

