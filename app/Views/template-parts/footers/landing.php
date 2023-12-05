<?php
    /**
     * @Filename: landing.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 12/4/2023
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

?>

<footer>
    <div class="footer-content">
        <div class="top-footer">
            <div class="logo">
                <a href="<?= home_url() ?>"><img src="<?= Nh::get_site_logo(); ?>" alt="<?= __('Site Logo', 'ninja') ?>"></a>
            </div>
            <div class="social">
                <p>تابعنا على مواقع التواصل الاجتماعي</p>
                <div class="icons">
                    <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_tw'] ?>">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/twitter.svg' ?>" alt="<?= __('twitter logo', 'ninja') ?>">
                    </a>
                    <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_tk'] ?>">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/tiktok.svg' ?>" alt="<?= __('tiktok logo', 'ninja') ?>">
                    </a>
                    <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_wa'] ?>">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/whatsapp.svg' ?>" alt="<?= __('whatsapp logo', 'ninja') ?>">
                    </a>
                    <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_ig'] ?>">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/instagram.svg' ?>" alt="<?= __('instagram logo', 'ninja') ?>">
                    </a>
                    <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_fb'] ?>">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/facebook.svg' ?>" alt="<?= __('facebook logo', 'ninja') ?>">
                    </a>
                </div>
            </div>
        </div>
        <div class="lower-footer">
            <div class="lower-holder">
                <h2>قدم في دوري المدارس لريادة الاعمال</h2>
                <div class="reg-link">
                    <a href="#">قدم فكرتك</a>
                </div>
                <span>جميع الحقوق محفوظ</span>
            </div>
        </div>
    </div>
</footer>
