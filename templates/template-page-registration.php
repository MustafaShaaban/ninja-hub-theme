<?php
    /**
     * @Filename: template-page-registration.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Regisration Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    get_header();

    $type = isset($_GET['type']) && in_array($_GET['type'], [ 'official', 'individual', 'entrepreneur']) ? $_GET['type'] : 'official';
?>

    <main id="" class="">
        <h1>Registration Page</h1>

        <?php
            get_template_part('app/Views/template-parts/registration/'.$type);
        ?>

    </main><!-- #main -->

<?php get_footer();

