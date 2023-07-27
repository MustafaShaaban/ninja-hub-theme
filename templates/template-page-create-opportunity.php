<?php
    /**
     * @Filename: template-page-create-opportunity.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Create Opportunity Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\Nh;

    get_header();
?>

    <main id="" class="site-home">
        <h1>Create a New Opportunity</h1>

        <?php
            $form_fields = [
                'custom-html-1'      => [
                    'type'    => 'html',
                    'content' => '<div class="row">',
                    'order'   => 0,
                ],
                'project_name'         => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Project Name', 'ninja'),
                    'name'        => 'project_name',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project name', 'ninja'),
                    'order'       => 5,
                ],
                'category'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Category', 'ninja'),
                    'name'        => 'category',
                    'placeholder' => __('Enter your category', 'ninja'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => [],
                    'before'      => '',
                    'order'       => 25,
                ],
                'opportunity_type'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Opportunity Type', 'ninja'),
                    'name'        => 'category',
                    'placeholder' => __('Enter your opportunity type', 'ninja'),
                    'options'        => [
                            'regular' => __('Regular', 'ninja'),
                            'bidding' => __('Bidding', 'ninja'),
                            'acquisition' => __('Acquisition', 'ninja'),
                    ],
                    'default_option' => '',
                    'select_option'  => [],
                    'before'      => '',
                    'order'       => 25,
                ],
                'description'          => [
                    'class'       => 'col-6',
                    'type'        => 'textarea',
                    'label'       => __('Description', 'ninja'),
                    'name'        => 'description',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project description', 'ninja'),
                    'rows'         => '4',
                    'order'       => 10,
                ],
                'short_description'          => [
                    'class'       => 'col-6',
                    'type'        => 'textarea',
                    'label'       => __('Short Description', 'ninja'),
                    'name'        => 'short_description',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project short description', 'ninja'),
                    'rows'         => '4',
                    'order'       => 10,
                ],
                'start_bidding_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Start Bidding Amount', 'ninja'),
                    'name'        => 'start_bidding_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your start bidding amount', 'ninja'),
                    'order'       => 15,
                ],
                'target_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Target Amount', 'ninja'),
                    'name'        => 'target_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your start bidding amount', 'ninja'),
                    'order'       => 15,
                ],
                'project_phase'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Project Phase', 'ninja'),
                    'name'        => 'project_phase',
                    'placeholder' => __('Select your project phase', 'ninja'),
                    'options'        => [
                        'preparation' => __('Preparation', 'ninja'),
                        'created' => __('Created', 'ninja'),
                        'started' => __('Started', 'ninja'),
                        'running' => __('Running', 'ninja'),
                        'paused' => __('Paused', 'ninja'),
                    ],
                    'default_option' => '',
                    'select_option'  => [],
                    'before'      => '',
                    'order'       => 25,
                ],
                'project_start_date'       => [
                    'class'       => 'col-6',
                    'type'        => 'date',
                    'label'       => __('Project Start Date', 'ninja'),
                    'name'        => 'project_start_date',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project start date', 'ninja'),
                    'order'       => 15,
                ],
                'project_assets_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Project Assets Amount', 'ninja'),
                    'name'        => 'project_assets_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project assets amount', 'ninja'),
                    'order'       => 15,
                ],
                'project_yearly_cashflow_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Project Yearly Cashflow Amount', 'ninja'),
                    'name'        => 'project_yearly_cashflow_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project yearly cashflow amount', 'ninja'),
                    'order'       => 15,
                ],
                'project_yearly_new_profit_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Project Yearly Net Profit Amount', 'ninja'),
                    'name'        => 'project_yearly_new_profit_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project yearly cashflow amount', 'ninja'),
                    'order'       => 15,
                ],
                'custom-html-3'      => [
                    'type'    => 'html',
                    'content' => '</div>',
                    'order'   => 45,
                ],
                'create_opportunity_nonce' => [
                    'class' => '',
                    'type'  => 'nonce',
                    'name'  => 'create_opportunity_nonce',
                    'value' => Nh::_DOMAIN_NAME . "_create_opportunity_form",
                    'order' => 50
                ],
                'submit'             => [
                    'class'               => '',
                    'type'                => 'submit',
                    'id'                => Nh::_DOMAIN_NAME . '_create_opportunity_submit',
                    'value'               => __('Save', 'ninja'),
                    'before'              => '',
                    'after'               => '',
                    'recaptcha_form_name' => 'frontend_create_opportunity',
                    'order'               => 55
                ],
            ];
            $form_tags   = [
                'class' => Nh::_DOMAIN_NAME . '-create-opportunity-form',
                'id'    => Nh::_DOMAIN_NAME . '_create_opportunity_form'
            ];
            echo Nh_Forms::get_instance()
                          ->create_form($form_fields, $form_tags);
        ?>
    </main><!-- #main -->

<?php get_footer();

