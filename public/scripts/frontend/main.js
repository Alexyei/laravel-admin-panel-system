const responsive = {
    0: {
        items: 1
    },
    320: {
        items: 1
    },
    560: {
        items: 2
    },
    960: {
        items: 3
    }
}

$(document).ready(function () {

    $nav = $('.nav');
    $toggleCollapse = $('.toggle-collapse');

    /** click event on toggle menu */
    // $toggleCollapse.click(function () {
    //     $nav.toggleClass('collapse');
    // })

    document.querySelector(".toggle-collapse").addEventListener('click',()=>{
        //бургер
        document.querySelector(".nav").classList.toggle('is-active');
        document.querySelector(".toggle-collapse").classList.toggle('is-active');
        //элементы меню
        document.querySelector(".nav-items").classList.toggle('active');
    });

    // owl-crousel for blog
    $('.owl-carousel').owlCarousel({
        loop: false,
        rewind: true,
        autoplay: false,
        autoplayTimeout: 3000,
        dots: false,
        nav: true,
        lazyLoad: true,
        navText: [$('.owl-navigation .owl-nav-prev'), $('.owl-navigation .owl-nav-next')],
        responsive: responsive
    });


    // click to scroll top
    $('.move-up span').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
    })

    // AOS Instance
    AOS.init();

});
