/**
 * @Filename: home.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';
import 'slick-carousel/slick/slick';

// import theme modules

class NhHome
{
    constructor()
    {
        window.KEY = nhGlobals.domain_key;
        this.initialization();
    }

    initialization()
    {
        this.slickSlides();
    }

    slickSlides()
    {
        $('.gallery_slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            responsive: [
                {
                    breakpoint: 980,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 2,
                        centerMode:true
                    }
                }
            ]
        });
        $('.my-cards').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,

            responsive: [
                {
                    breakpoint: 991,
                    settings: {

                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {

                        slidesToShow: 1
                    }
                }
            ]
        });
        $('.projects-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,

            responsive: [
                {
                    breakpoint: 991,
                    settings: {

                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {

                        slidesToShow: 1
                    }
                }
            ]
        });

    }

}

new NhHome();

