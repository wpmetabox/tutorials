const thumbSlider = new Swiper( '.thumb-slider', {
	spaceBetween: 10,
	freeMode: true,
	watchSlidesProgress: true,
	breakpoints: {
		0: { slidesPerView: 3 },
		640: { slidesPerView: 4 },
		768: { slidesPerView: 4 },
		1024: { slidesPerView: 5 }
	}
} );

const mainSlider = new Swiper( '.main-slider', {
	spaceBetween: 10,
	autoHeight: true,
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
	},
	thumbs: {
		swiper: thumbSlider,
	},
} );
