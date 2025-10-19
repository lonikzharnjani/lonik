(function(){
  const sliders = document.querySelectorAll('.news-slider');
  sliders.forEach((slider) => initSlider(slider));

  function initSlider(root) {
    const track = root.querySelector('.slider-track');
    const slides = Array.from(track.children);
    const prevBtn = root.querySelector('.nav.prev');
    const nextBtn = root.querySelector('.nav.next');
    const dotsEl = root.querySelector('.dots');

    let currentIndex = 0;
    let autoplayTimer = null;
    const autoplay = root.getAttribute('data-autoplay') === 'true';
    const intervalMs = Number(root.getAttribute('data-interval') || 4500);
    const pauseOnHover = root.getAttribute('data-pause-on-hover') === 'true';

    // Create dots
    const dots = slides.map((_, idx) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.setAttribute('aria-label', `Go to slide ${idx+1}`);
      b.addEventListener('click', () => goTo(idx, true));
      dotsEl.appendChild(b);
      return b;
    });

    function update() {
      const width = root.clientWidth;
      const visible = getVisibleCount();
      const translateX = -currentIndex * (width / visible);
      track.style.transform = `translateX(${translateX}px)`;
      dots.forEach((d, i) => d.setAttribute('aria-current', i === currentIndex ? 'true' : 'false'));
      prevBtn.disabled = currentIndex === 0;
      nextBtn.disabled = currentIndex >= slides.length - visible;
    }

    function getVisibleCount() {
      const w = window.innerWidth;
      if (w >= 1024) return 3;
      if (w >= 640) return 2;
      return 1;
    }

    function goTo(index, userInitiated) {
      const maxIndex = Math.max(0, slides.length - getVisibleCount());
      currentIndex = Math.max(0, Math.min(index, maxIndex));
      update();
      if (userInitiated) restartAutoplay();
    }

    function next() { goTo(currentIndex + 1, false); }
    function prev() { goTo(currentIndex - 1, false); }

    function startAutoplay() {
      if (!autoplay || autoplayTimer) return;
      autoplayTimer = setInterval(() => {
        const maxIndex = Math.max(0, slides.length - getVisibleCount());
        if (currentIndex >= maxIndex) {
          goTo(0, false);
        } else {
          next();
        }
      }, intervalMs);
    }
    function stopAutoplay() {
      if (autoplayTimer) { clearInterval(autoplayTimer); autoplayTimer = null; }
    }
    function restartAutoplay() { stopAutoplay(); startAutoplay(); }

    // Hover pause
    if (pauseOnHover) {
      root.addEventListener('mouseenter', stopAutoplay);
      root.addEventListener('mouseleave', startAutoplay);
    }

    // Buttons
    nextBtn.addEventListener('click', () => goTo(currentIndex + 1, true));
    prevBtn.addEventListener('click', () => goTo(currentIndex - 1, true));

    // Keyboard
    root.setAttribute('tabindex', '0');
    root.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowRight') { e.preventDefault(); goTo(currentIndex + 1, true); }
      if (e.key === 'ArrowLeft')  { e.preventDefault(); goTo(currentIndex - 1, true); }
    });

    // Resize
    window.addEventListener('resize', update);

    // Drag support
    let isDown = false;
    let startX = 0;
    let deltaX = 0;
    let startIndex = 0;

    function onPointerDown(clientX) {
      isDown = true;
      startX = clientX;
      deltaX = 0;
      startIndex = currentIndex;
      root.classList.add('dragging');
      stopAutoplay();
    }
    function onPointerMove(clientX) {
      if (!isDown) return;
      deltaX = clientX - startX;
      const width = root.clientWidth;
      const visible = getVisibleCount();
      const base = -startIndex * (width / visible);
      track.style.transform = `translateX(${base + deltaX}px)`;
    }
    function onPointerUp() {
      if (!isDown) return;
      isDown = false;
      root.classList.remove('dragging');
      const threshold = root.clientWidth * 0.1;
      if (Math.abs(deltaX) > threshold) {
        if (deltaX < 0) goTo(startIndex + 1, true);
        else goTo(startIndex - 1, true);
      } else {
        goTo(startIndex, true);
      }
      startAutoplay();
    }

    // Mouse events
    root.addEventListener('mousedown', (e) => onPointerDown(e.clientX));
    window.addEventListener('mousemove', (e) => onPointerMove(e.clientX));
    window.addEventListener('mouseup', onPointerUp);

    // Touch events
    root.addEventListener('touchstart', (e) => onPointerDown(e.touches[0].clientX), { passive: true });
    root.addEventListener('touchmove', (e) => onPointerMove(e.touches[0].clientX), { passive: true });
    root.addEventListener('touchend', onPointerUp);

    // Init
    update();
    startAutoplay();
  }
})();
