/* eslint-disable no-unused-vars */
import Swiper from "swiper";
import {
  Navigation,
  Pagination,
  EffectFade,
  Autoplay,
  Thumbs,
} from "swiper/modules";
// import Swiper and modules styles

export default function initSliders() {
  const imageSlider = new Swiper(".image-slider__slides-wrapper", {
    modules: [Autoplay],
    slidesPerView: 1,
    spaceBetween: 0,
    //centeredSlides: 0,
    loop: true,
    wrapperClass: "image-slider__slides",
    slideClass: "image-slider__slide",
    autoplay: {
      delay: 7500,
      disableOnInteraction: false,
    },
  });

  const quotesSwiper = new Swiper(".quotes-slider", {
    modules: [Navigation, Pagination],
    slidesPerView: 1,
    loop: true,
    spaceBetween: 20,
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
    wrapperClass: "quotes-slider__slides",
    slideClass: "quotes-slider__slide",
    pagination: {
      el: ".quotes-slider__pagination",
      clickable: true,
      type: "bullets",
      bulletActiveClass: "quotes-slider__pagination__bullet--active",
      bulletClass: "quotes-slider__pagination__bullet",
      bulletElement: "div",
    },
    navigation: false,
  });

  const propertyThumbsSwiper = new Swiper(".property-thumbs-slider", {
    modules: [Navigation, Pagination, Thumbs],
    spaceBetween: 10,
    slidesPerView: 4,
    centerInsufficientSlides: true,
    freeMode: true,
    lazy: true,
    watchSlidesProgress: true,
    wrapperClass: "property-thumbs-slider__slides-wrapper",
    slideClass: "property-thumbs-slider__slide",
    breakpoints: {
      640: {
        slidesPerView: 6,
      },
    },
  });

  const propertySwiper = new Swiper(".property-gallery-slider", {
    modules: [Navigation, Pagination, Thumbs],
    slidesPerView: 1,
    spaceBetween: 0,
    loop: false,
    lazy: true,
    wrapperClass: "property-gallery-slider__slides-wrapper",
    slideClass: "property-gallery-slider__slide",
    navigation: {
      nextEl: ".property-gallery-slider__nav-button--next",
      prevEl: ".property-gallery-slider__nav-button--prev",
    },
    thumbs: {
      swiper: propertyThumbsSwiper,
    },
  });
}
