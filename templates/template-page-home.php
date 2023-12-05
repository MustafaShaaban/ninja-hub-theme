<?php
    /**
     * @Filename: template-page-home.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Home Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    use NH\APP\HELPERS\Nh_Hooks;

    get_header();
?>

    <div id="" class="site-home">
        <!-- start section hero -->
        <section class="hero-new">
            <div class="hero-container">
                <div class="bg-video">
                    <video autoplay loop muted>
                        <source src="<?= Nh_Hooks::PATHS['public']['videos'] . '/hero.mp4' ?>" type="video/mp4">
                    </video>
                </div>
                <div class="photos d-flex">
                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/card-two.webp' ?>" alt="" class="first-image">


                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/card-three.webp' ?>" alt="" class="second-image">


                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/card-one.webp' ?>" alt="" class="third-image">
                </div>
                <div class="description">
                    <h2 class="hero-title">دوري ريادة الاعمال</h2>
                    <div class="team-idea-reward">
                        <div class="main-holder">
                            <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/clock.webp' ?>" alt="">
                            <h3>كون فرقتك</h3>
                        </div>
                        <div class="main-holder">
                            <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/light.webp' ?>" alt="">
                            <h3>قدم فكرتك</h3>
                        </div>
                        <div class="main-holder">
                            <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/tag.webp' ?>" alt="">
                            <h3>استنى جايزتك</h3>
                        </div>
                    </div>
                    <div class="buttons">
                        <div class="idea">
                            <a href="">قدم فكرتك</a>
                        </div>
                        <div class="condition">
                            <a href="">اعرف الشروط</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section hero -->

        <!-- start section cards slider -->
        <section class="projects-cards">
            <div class="my-cards">
                <div class="the-card 4">
                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/card-four.webp' ?>" alt="" class="img-fluid">
                    <div class="content-holder">
                        <div class="desc">
                            <h4>احصل على الجائزه</h4>
                            <p>اشتزك في دوري ريادة الاعمال وورينا احسن شغل عملته وبين موهبتك</p>
                        </div>
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/four.webp' ?>" alt="" class="num">
                    </div>
                </div>

                <div class="the-card 3">
                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/slide-one.webp' ?>" alt="" class="img-fluid">
                    <div class="content-holder">
                        <div class="desc">
                            <h4>شارك بفكرتك</h4>
                            <p>اشتزك في دوري ريادة الاعمال وورينا احسن شغل عملته وبين موهبتك</p>
                        </div>
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/three.webp' ?>" alt="" class="num">
                    </div>
                </div>

                <div class="the-card 2">
                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/slide-two.webp' ?>" alt="" class="img-fluid">
                    <div class="content-holder">
                        <div class="desc">
                            <h4>ابحث عن مشاريع تناسبك</h4>
                            <p>اشتزك في دوري ريادة الاعمال وورينا احسن شغل عملته وبين موهبتك</p>
                        </div>
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/two.webp' ?>" alt="" class="num">
                    </div>
                </div>

                <div class="the-card 1">
                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/slide-three.webp' ?>" alt="" class="img-fluid">
                    <div class="content-holder">
                        <div class="desc">
                            <h4>اضف اعمالك السابقة</h4>
                            <p>اشتزك في دوري ريادة الاعمال وورينا احسن شغل عملته وبين موهبتك</p>
                        </div>
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/one.webp' ?>" alt="" class="num">
                    </div>
                </div>
            </div>
        </section>
        <!-- end section cards slider -->

        <!-- gallery -->
        <section class="gallery">
            <h2>مسابقة ٢٠٢٢</h2>
            <div class="gallery_slider">
                <div class="gallery-iteam smallCard">
                    <div class="row">
                        <div class="col-md-12"><img src="<?= Nh_Hooks::PATHS['public']['img'] . '/gallery1.webp' ?>" alt="">
                        </div>
                        <div class="col-md-12"><img src="<?= Nh_Hooks::PATHS['public']['img'] . '/gallery2.webp' ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="gallery-iteam smallCard">
                    <div class="row">
                        <div class="col-md-12"><img src="<?= Nh_Hooks::PATHS['public']['img'] . '/gallery3.webp' ?>" alt="">
                        </div>
                        <div class="col-md-12"><img src="<?= Nh_Hooks::PATHS['public']['img'] . '/gallery4.webp' ?>" alt="">
                        </div>
                    </div>
                </div>

                <div class="gallery-iteam largCard">
                    <div class="col-md-12"><img src="<?= Nh_Hooks::PATHS['public']['img'] . '/gallery5.webp' ?>" alt=""></div>
                </div>
                <div class="gallery-iteam smallCard">
                    <div class="row">
                        <div class="col-md-12"><img src="<?= Nh_Hooks::PATHS['public']['img'] . '/gallery3.webp' ?>" alt="">
                        </div>
                        <div class="col-md-12"><img src="<?= Nh_Hooks::PATHS['public']['img'] . '/gallery4.webp' ?>" alt="">
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- teams -->
        <section class="teams">
            <div class="row">
                <div class="col-md-6 card-left">
                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/team1.webp' ?>" alt="">
                    <div class="teamContent">
                        <h2>رائد اعمال:</h2>
                        <p>قدم مشروعك او فكرتك</p>
                    </div>
                </div>
                <div class="col-md-6 card-right">
                    <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/team2.webp' ?>" alt="">
                    <div class="teamContent">
                        <h2>فريق و ستارت آب</h2>
                        <p>قدم فكرتك مع فريق</p>
                    </div>
                </div>
            </div>

        </section>

        <!-- start section availiable projects -->
        <section class="avaliable-projects">
            <div class="avaliable-projects-container">
                <h2>مشروعات متاحة للتقديم</h2>
                <div class="projects-slider">
                    <div class="project">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/Baby.webp' ?>" alt="" class="img-fluid">
                        <div class="project-title">
                            <h3>اعمال ابداعية</h3>
                        </div>
                    </div>
                    <div class="project">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/Baby.webp' ?>" alt="" class="img-fluid">
                        <div class="project-title">
                            <h3>اعمال ابداعية</h3>
                        </div>
                    </div>
                    <div class="project">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/Baby.webp' ?>" alt="" class="img-fluid">
                        <div class="project-title">
                            <h3>اعمال ابداعية</h3>
                        </div>
                    </div>
                    <div class="project">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/Baby.webp' ?>" alt="" class="img-fluid">
                        <div class="project-title">
                            <h3>اعمال ابداعية</h3>
                        </div>
                    </div>
                    <div class="project">
                        <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/Baby.webp' ?>" alt="" class="img-fluid">
                        <div class="project-title">
                            <h3>اعمال ابداعية</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section availiable projects -->

        <!-- Who is the winner -->
        <section class="hero-new sectionWinner">
            <div class="hero-container">
                <div class="bg-video">
                    <video autoplay loop muted>
                        <source src="<?= Nh_Hooks::PATHS['public']['videos'] . '/hero.mp4' ?>" type="video/mp4">
                    </video>
                </div>
                <div class="row d-flex align-items-center justify-content-around">
                    <div class="col-md-4">
                        <div class="description">
                            <h2 class="hero-title">مين كسبان؟</h2>
                            <p>في مسابقة دوري المدارس لريادة الاعمال</p>
                            <p>احمد سمير . ١٤ سنة. القاهرة </p>
                            <span>مدرسة النقراشي الثانوية بنين الحديثة</span>
                            <div class="buttons">
                                <div class="condition">
                                    <a href="">اعرف اكتر</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="photos d-flex">

                            <img src="<?= Nh_Hooks::PATHS['public']['img'] . '/winner.webp' ?>" alt="" class="third-image">
                        </div>
                    </div>


                </div>
            </div>
        </section>
    </div><!-- #main -->

<?php get_footer();

