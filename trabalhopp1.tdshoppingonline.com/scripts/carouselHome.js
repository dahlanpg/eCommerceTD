var carousel = document.querySelector('.carousel');
var carouselTrack = document.querySelector('carousel-track');
var slides = document.getElementsByClassName('carousel-slide');
var carouselLength = slides.length;
var currentSlideIndex = 0;
var nextButton = document.querySelector('.next');
var prevButton = document.querySelector('.prev');
var indicators = document.getElementsByClassName('hover_indicator');
var indicatorsLength = indicators.length;
var startTime = true;

function nextSlide(){
	var nextSlideIndex = currentSlideIndex + 1;
	$(".current-slide").fadeOut();
	slides[currentSlideIndex].classList.remove('current-slide');
	indicators[currentSlideIndex].classList.remove('current-indicator');
	if(nextSlideIndex < carouselLength){
		slides[nextSlideIndex].classList.add('current-slide');
		indicators[nextSlideIndex].classList.add('current-indicator');
		++currentSlideIndex;
	}
	else{
		currentSlideIndex = 0; //primeiro slide
		slides[currentSlideIndex].classList.add('current-slide');
		indicators[currentSlideIndex].classList.add('current-indicator');
	}
	$(".current-slide").fadeIn();
}

function prevSlide(){
	var prevSlideIndex = currentSlideIndex - 1;
	$(".current-slide").fadeOut();
	slides[currentSlideIndex].classList.remove('current-slide');
	indicators[currentSlideIndex].classList.remove('current-indicator');
	if(prevSlideIndex >= 0){
		slides[prevSlideIndex].classList.add('current-slide');
		indicators[prevSlideIndex].classList.add('current-indicator');
		--currentSlideIndex;
	}
	else{
		currentSlideIndex = carouselLength - 1; //ultimo slide
		slides[currentSlideIndex].classList.add('current-slide');
		indicators[currentSlideIndex].classList.add('current-indicator');
	}
	$(".current-slide").fadeIn();
}

carousel.onmouseover = e => startTime = false;
carousel.onmouseout = e => startTime = true; //indica que o slide já pode começar a avançar automaticamente

var autoNextCarousel = setInterval(e => {
	if(startTime){
		nextSlide();
	}
}, 5000);



nextButton.addEventListener('click', nextSlide);
prevButton.addEventListener('click', prevSlide);




