<?php
    /**
     * The template for displaying all pages
     *
     * This is the template that displays all pages by default.
     * Please note that this is the WordPress construct of pages
     * and that other 'pages' on your WordPress site may use a
     * different template.
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package NinjaHub
     */

    get_header();
?>

    <main id="" class="">

        <?php
            while (have_posts()) :
                the_post();

                if (empty(locate_template('app/Views/page-' . get_post_type() . '.php'))) {
                    get_template_part('app/Views/page');
                } else {
                    get_template_part('app/Views/page', get_post_type());
                }

            endwhile; // End of the loop.
        ?>

    </main><!-- #main -->

<?php
    get_sidebar();
    get_footer();
