function Sliders() {
    let SlidersArray = []

    let sliders = document.querySelectorAll(".slider")
    sliders.forEach((slider,index) => {
        slider.setAttribute("data-slider-id",index)

        SlidersArray[index] = new Swiper(`.slider[data-slider-id="${index}"] .swiper-container`, {
            slidesPerView: "auto",
            spaceBetween: 0,
            watchSlidesProgress: true,
            preventClicks :true,
            a11y: false,
            observer: true,
            observeParents: true,
            observeSlideChildren: true,

            navigation: {
                nextEl: `.slider[data-slider-id="${index}"] .swiper-button-next`,
                prevEl: `.slider[data-slider-id="${index}"] .swiper-button-prev`,
            },
            pagination: {
                el: `.slider[data-slider-id="${index}"] .swiper-pagination`,
                type: 'bullets',
                clickable: true,
            },
        })
    })
}

function gallery() {
    let SlidersArray = []

    let sliders = document.querySelectorAll(".gallery")
    sliders.forEach((slider,index) => {
        slider.setAttribute("data-slider-id",index)
        let gallery = {
            mySwiper: {},
            mySwiper2: {}
        }

        gallery.mySwiper = new Swiper(`.gallery[data-slider-id="${index}"] .mySwiper`, {
            spaceBetween: 0,
            slidesPerView: "auto",
            freeMode: true,
            watchSlidesProgress: true,
            direction: "vertical",
            breakpoints: {
                320: {
                    direction: "horizontal",
                },
                992: {
                    direction: "vertical",
                }
            }
        });
        gallery.mySwiper2 = new Swiper(`.gallery[data-slider-id="${index}"] .mySwiper2`, {
            spaceBetween: 0,
            direction: "vertical",
            loop: true,
            navigation: {
                nextEl: `.gallery[data-slider-id="${index}"] .swiper-button-next`,
                prevEl: `.gallery[data-slider-id="${index}"] .swiper-button-prev`,
            },
            thumbs: {
                swiper:  gallery.mySwiper,
            },
            breakpoints: {
                320: {
                    direction: "horizontal",
                },
                992: {
                    direction: "vertical",
                }
            }
        });

        SlidersArray[index] = gallery
    })

}


Sliders()
gallery()
