<?php
    /**
     * @Filename: template-page-dashboard.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Dashboard Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;

    global $user_ID;

    get_header();
?>

    <main id="" class="site-home">

        <div id="test"></div>
        <h1>Dashboard</h1>

        <h3>Overview</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque illo laudantium magnam magni vel! Alias aliquam amet assumenda commodi consequatur corporis delectus dignissimos, eum facilis laboriosam maxime nostrum odit perferendis perspiciatis quasi quod ratione repellendus reprehenderit repudiandae sequi sit ullam vero. Blanditiis dolorum esse hic id ipsam officiis, sit veniam.</p>


        <h3>Latest Opportunities</h3>
        <?php

            $opportunities_obj = new Nh_Opportunity();
            $opportunities = $opportunities_obj->get_all();

            foreach ($opportunities as $opportunity) {
                echo "<p>".$opportunity->title."</p>";
            }
        ?>

        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard/create-opportunity'))) ?>"><?= __('Create New Opportunity', 'ninja') ?></a>
    </main><!-- #main -->

<?php get_footer();

