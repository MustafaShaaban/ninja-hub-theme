<?php
    /**
     * The template for displaying the footer
     *
     * Contains the closing of the #content div and all content after.
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package NinjaHub
     */

    use NH\Nh;

?>

<footer class="site-top-footer">
    <div class="top-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <img src="<?= Nh::get_site_logo() ?>" alt="Nh Logo">
                    <div class="social-links">
                        <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_in'] ?>">LinkedIn</a>
                        <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_fb'] ?>">Facebook</a>
                        <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_ig'] ?>">Instagram</a>
                        <a href="<?= NH_CONFIGURATION['social'][Nh::_DOMAIN_NAME . '_social_tw'] ?>">Twitter</a>
                    </div>
                </div>
                <div class="col-2"><?= __('Articles', 'ninja') ?>
                    <ul>
                        <li><a href="#">Authors</a></li>
                        <li><a href="#">Icons</a></li>
                        <li><a href="#">Stickers</a></li>
                        <li><a href="#">Interface icons</a></li>
                        <li><a href="#">Animated icons</a></li>
                        <li><a href="#">Icon tags</a></li>
                    </ul>
                </div>
                <div class="col-2"><?= __('As Investor', 'ninja') ?>
                    <ul>
                        <li><a href="#">Authors</a></li>
                        <li><a href="#">Icons</a></li>
                        <li><a href="#">Stickers</a></li>
                        <li><a href="#">Interface icons</a></li>
                        <li><a href="#">Animated icons</a></li>
                        <li><a href="#">Icon tags</a></li>
                    </ul>
                </div>
                <div class="col-2"><?= __('As Owner', 'ninja') ?>
                    <ul>
                        <li><a href="#">Authors</a></li>
                        <li><a href="#">Icons</a></li>
                        <li><a href="#">Stickers</a></li>
                        <li><a href="#">Interface icons</a></li>
                        <li><a href="#">Animated icons</a></li>
                        <li><a href="#">Icon tags</a></li>
                    </ul>
                </div>
                <div class="col-2">
                    <?= __('Reach US', 'ninja') ?>
                    <a href="javascript:(0);"><?= NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_contact_address_en'] ?></a>
                    <a href="mailto:<?= NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_contact_email'] ?>"><?= NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_contact_email'] ?></a>
                    <a href="tel:<?= NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_contact_phone'] ?>"><?= NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_contact_phone'] ?></a>
                    <a href="tel:<?= NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_contact_mobile'] ?>"><?= NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_contact_mobile'] ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom-footer">
        <div class="container-fluid">
            <div class="row">
            <div class="site-info col-6">
                <p><?= __('Copyright © 2023 NH All rights reserved') ?></p>
            </div><!-- .site-info -->

            <div class="bottom-footer-menu col-6">
                <?php
                    wp_nav_menu([
                        'theme_location' => 'bottom-footer-menu',
                        'menu_id'        => 'bottom-footer',
                    ]);
                ?>
            </div>
            </div>
        </div>
    </div>


</footer>

<?php wp_body_close(); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
