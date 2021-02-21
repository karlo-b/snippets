const slider = document.querySelectorAll('.keen-slider-wrap');

Array.prototype.forEach.call(slider, function (slider) {
	const sliderOptions = [];
	let json = slider.querySelector('.keen-slider').dataset.keen;
	let mobile = slider.querySelector('.keen-slider').dataset.mobile;
	let tablet = slider.querySelector('.keen-slider').dataset.tablet;
	if (json) {
		let jsonParsedArray = JSON.parse(json);
		for (key in jsonParsedArray) {
			if (jsonParsedArray.hasOwnProperty(key)) {
				sliderOptions[key] = jsonParsedArray[key];
			}
		}
	}
	sliderOptions.created = function (instance) {
		slider
			.querySelector(".arrow-prev")
			.addEventListener("click", function () {
				instance.prev();
			});

		slider
			.querySelector(".arrow-next")
			.addEventListener("click", function () {
				instance.next();
			});
		var dots_wrapper = slider.querySelector(".dots");
		var slides = slider.querySelectorAll(".keen-slider__slide");
		slides.forEach(function (t, idx) {
			var dot = document.createElement("button");
			dot.classList.add("dot");
			dots_wrapper.appendChild(dot);
			dot.addEventListener("click", function () {
				instance.moveToSlide(idx);
			});
		});
		updateClasses(instance, slider);
	};

	sliderOptions.slideChanged = function (instance) {
		updateClasses(instance, slider);
	};

	sliderOptions['breakpoints'] = {
		"(max-width: 768px)": {
			slidesPerView: tablet,
		},
		"(max-width: 480px)": {
			slidesPerView: mobile,
		},
	};
	console.log(sliderOptions);
	var keen = new KeenSlider(slider, sliderOptions);
});

function updateClasses(instance, slider) {
	var slide = instance.details().relativeSlide;
	console.log(slide);
	var arrowLeft = slider.querySelector(".arrow-prev");
	var arrowRight = slider.querySelector(".arrow-next");
	// Add disabled class on arrows on last or fistst slide
	// slide === 0 ?
	// 	arrowLeft.classList.add("arrow--disabled") :
	// 	arrowLeft.classList.remove("arrow--disabled");
	// slide === instance.details().size - 1 ?
	// 	arrowRight.classList.add("arrow--disabled") :
	// 	arrowRight.classList.remove("arrow--disabled");
	var dots = slider.querySelectorAll(".dot");
	dots.forEach(function (dot, idx) {
		idx === slide ?
			dot.classList.add("dot--active") :
			dot.classList.remove("dot--active");
	});

	var slides = slider.querySelectorAll(".keen-slider__slide");
	slides.forEach(function (slide_item, idx) {
		idx === slide ?
			slide_item.classList.add("active") :
			slide_item.classList.remove("active");
	});
}
