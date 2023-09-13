`<?php
    /**
     * @Filename: dashboard.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
    use NH\Nh;

?>

<header id="masthead" class="site-header">
    <nav id="site-navigation" class="main-navigation d-flex justify-content-around align-items-center">
        <div class="site-branding">
            <a href="<?= home_url() ?>"><img src="<?= Nh::get_site_logo(); ?>" alt="Nh Site Logo"/></a>
        </div>

        <?php
            if (Nh_User::get_user_role() == Nh_User::INVESTOR) {
                wp_nav_menu([
                    'theme_location' => 'dashboard-investor-menu',
                    'menu_id'        => 'investor-menu',
                ]);
            } elseif (Nh_User::get_user_role() == Nh_User::OWNER) {
                wp_nav_menu([
                    'theme_location' => 'dashboard-owner-menu',
                    'menu_id'        => 'owner-menu',
                ]);
            } else {
                wp_nav_menu([
                    'theme_location' => 'dashboard-owner-menu',
                    'menu_id'        => 'owner-menu',
                ]);
            }
        ?>

        <div>
            <?= Nh_Forms::get_instance()
                         ->create_form([
                             'search' => [
                                 'class'       => 'ninjas',
                                 'type'        => 'text',
                                 'name'        => 's',
                                 'placeholder' => __('Search', 'ninja'),
                                 'before'      => '',
                                 'after'       => '<i class="fas fa-search ninjaheader-search-icon"></i>',
                                 'order'       => 0,
                             ]
                         ], [
                             'action' => apply_filters('nhml_permalink', home_url()),
                             'class' => Nh::_DOMAIN_NAME . '-header-search-form',
                             'id'    => Nh::_DOMAIN_NAME . '_header_search_form'
                         ]); ?>
        </div>


        <div>
            <?php get_template_part('app/Views/template-parts/notifications/notification'); ?>
        </div>


        <div>
            Welcome, <?= Nh_User::get_current_user()->display_name ?> !
            Standard dummy Since the 1500s,
        </div>
    </nav><!-- #site-navigation -->
</header><!-- #masthead -->
`