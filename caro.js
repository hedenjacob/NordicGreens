const track = document.querySelector('.carousel-track');
const items = document.querySelectorAll('.carousel-item');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const itemWidth = items[0].offsetWidth;
let position = 0;
let timer;

// addEventListener der tjekker for clicks til forrige billede
prevBtn.addEventListener('click', () => {
  position += itemWidth;
  if (position > 0) {
    position = 0;
  }
  setPosition();
});
// addEventListener der tjekker for clicks til næste billede
nextBtn.addEventListener('click', () => {
  position -= itemWidth;
  if (position < -((items.length - 1) * itemWidth)) {
    position = -((items.length - 1) * itemWidth);
  }
  setPosition();
});

function setPosition() {
  track.style.transform = `translateX(${position}px)`;
}

function startTimer() {
  timer = setInterval(() => {
    position -= itemWidth;
    if (position < -((items.length - 1) * itemWidth)) {
      position = 0;
    }
    setPosition();
  }, 5000); // Skift billede hvert 3. sekund (justér tiden efter behov)
}

function stopTimer() {
  clearInterval(timer);
}

// Start automatisk skift af billeder ved indlæsning
startTimer();

// Stop automatisk skift, når der er musemarkøren over karusellen
track.addEventListener('mouseover', stopTimer);

// Genstart automatisk skift, når musemarkøren forlader karusellen
track.addEventListener('mouseout', startTimer);
