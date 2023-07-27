<?php
    /**
     * The template for displaying archive pages
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package NinjaHub
     */

    get_header();
?>

    <main id="" class="">

        <?php if (have_posts()) : ?>

            <header class="page-header">
                <?php
                    the_archive_title('<h1 class="page-title">', '</h1>');
                    the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header><!-- .page-header -->

            <?php
            /* Start the Loop */
            while (have_posts()) :
                the_post();

                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
                if (empty(locate_template('app/Views/archive-' . get_post_type() . '.php'))) {
                    get_template_part('app/Views/archive');
                } else {
                    get_template_part('app/Views/archive', get_post_type());
                }

            endwhile;

            the_posts_navigation();

        else :

            if (empty(locate_template('app/Views/none-' . get_post_type() . '.php'))) {
                get_template_part('app/Views/none');
            } else {
                get_template_part('app/Views/none', get_post_type());
            }

        endif;
        ?>

    </main><!-- #main -->

<?php
    // get_sidebar();
    get_footer();
