<?php
    /**
     * @Filename: template-page-registration-landing.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Registration Landing Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    get_header();
?>

    <main id="" class="">
        <h1>Registration Landing Page</h1>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('account/registration'))); ?>?type=official">فريق رسمي</a>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('account/registration'))); ?>?type=individual">فرق مستقلة</a>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('account/registration'))); ?>?type=entrepreneur">رائد أعمال</a>
    </main><!-- #main -->

<?php get_footer();

