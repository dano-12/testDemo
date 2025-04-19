// carousel.js
const track        = document.querySelector('.carousel-track');
const slides       = Array.from(track.children);
const prevButton   = document.querySelector('.carousel-button.prev');
const nextButton   = document.querySelector('.carousel-button.next');
let   currentIndex = 0;

// 2) move to the slide
function moveToSlide(index) {
  const slideWidth = slides[0].getBoundingClientRect().width;
  track.style.transform = `translateX(-${slideWidth * index}px)`;
  currentIndex = index;
}

// 3) wire up the buttons
prevButton.addEventListener('click', () => {
  const newIndex = currentIndex === 0 ? slides.length - 1 : currentIndex - 1;
  moveToSlide(newIndex);
});
nextButton.addEventListener('click', () => {
  const newIndex = currentIndex === slides.length - 1 ? 0 : currentIndex + 1;
  moveToSlide(newIndex);
});

// 4) recalc on load & resize
window.addEventListener('load',   () => { moveToSlide(0); });
window.addEventListener('resize', () => { moveToSlide(currentIndex); });