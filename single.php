<?php
    /**
     * The template for displaying all single posts
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
     *
     * @package NinjaHub
     */

    get_header();
?>

    <main id="" class="">

        <?php
            while (have_posts()) :
                the_post();

                if (empty(locate_template('app/Views/single-' . get_post_type() . '.php'))) {
                    get_template_part('app/Views/single');
                } else {
                    get_template_part('app/Views/single', get_post_type());
                }

            endwhile; // End of the loop.
        ?>

    </main><!-- #main -->

<?php
    get_sidebar();
    get_footer();
