<?php
    /**
     * The template for displaying search results pages
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
     *
     * @package NinjaHub
     */

    use NH\APP\HELPERS\Nh_Forms;
    use NH\Nh;

    get_header();
?>

    <main id="" class="">


        <header class="page-header">

            <?= Nh_Forms::get_instance()
                         ->create_form([
                             'search' => [
                                 'class'       => 'ninjasearch-input-group',
                                 'type'        => 'text',
                                 'name'        => 's',
                                 'placeholder' => __('Search', 'ninja'),
                                 'before'      => '',
                                 'after'       => '<i class="fas fa-search ninjasearch-icon"></i>',
                                 'order'       => 0,
                             ]
                         ], [
                             'action' => apply_filters('nhml_permalink', home_url()),
                             'class'  => Nh::_DOMAIN_NAME . '-search-form',
                             'id'     => Nh::_DOMAIN_NAME . '_search_form'
                         ]); ?>

            <h1 class="page-title">
                <?php
                    /* translators: %s: search query. */
                    printf(esc_html__('Search Results for: %s', 'ninja'), '<span>' . get_search_query() . '</span>');
                ?>
            </h1>
        </header><!-- .page-header -->

        <?php
            if (have_posts()) :

                /* Start the Loop */
                while (have_posts()) :

                    the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part('app/Views/search');

                endwhile;

                the_posts_navigation();

            else :

                get_template_part('app/Views/none', 'search');

            endif;
        ?>

    </main><!-- #main -->

<?php
    get_footer();
