<?php
    /**
     * @Filename: landing.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 12/4/2023
     */

    use NH\Nh;

?>

<header class="new-header">
    <div class="header-container d-flex">
        <div class="logo">
            <a href="<?= home_url() ?>"><img src="<?= Nh::get_site_logo(); ?>" alt="<?= __('Site Logo', 'ninja') ?>"></a>
        </div>
        <?php
            if(is_user_logged_in()) {
                ?>
                <div class="login">
                    <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard'))); ?>" class="login-btn">لوحة التحكم</a>
                </div>
                <div class="login">
                    <a href="<?= home_url() ?>/nh-account/nh-logout" class="login-btn">تسجيل خروج</a>
                </div>
                <?php
            } else {
                ?>
                <div class="login">
                    <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('account/login'))); ?>" class="login-btn">سجل دخول</a>
                </div>
                <div class="login">
                    <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('account/registration-landing'))); ?>" class="login-btn">تسجبل</a>
                </div>
                <?php
            }
        ?>
    </div>
</header>
