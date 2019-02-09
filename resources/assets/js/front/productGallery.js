import Swiper from 'swiper';

if ($('.product-gallery').length) {

    var productGalleryIndex = 0;
    var productGallery = new Swiper('.product-gallery .swiper', {
        speed: 400,
        spaceBetween: 0,
        direction: 'vertical',
        slidesPerView: 4,
        releaseOnEdges: true,
        autoplay: false,
        loop: false,
        mousewheel: true,
    });

    $('.product-image').click(function(){
        $('body').addClass('overflow-hidden');
        $('.product-gallery').toggleClass('fixed hidden flex');
        productGallery.update();
        productGalleryShow(0);
    });
    $('.product-images .swiper-slide').click(function(){
        $('body').addClass('overflow-hidden');
        $('.product-gallery').toggleClass('fixed hidden flex');
        productGallery.update();
        productGalleryShow(1+$(this).index());
    });
    $('.product-gallery .close').click(function(){
        $('body').removeClass('overflow-hidden');
        $('.product-gallery').toggleClass('fixed hidden flex');
    });
    $('.product-gallery .prev').click(function(){
        if (productGalleryIndex > 0) {
            productGalleryShow(productGalleryIndex -1);
        }
    });
    $('.product-gallery .next').click(function(){
        if (productGalleryIndex < productGallery.slides.length-1){
            productGalleryShow(productGalleryIndex + 1);
        }
    });
    $('.product-gallery .swiper-slide').click(function(){
        productGalleryShow( $(this).index() );
    });

    function productGalleryShow(index){
        productGalleryIndex = index;
        productGallery.slideTo(index);
        $('.product-gallery .banner').html( $('.product-gallery .swiper img').clone()[index] );
    }
}