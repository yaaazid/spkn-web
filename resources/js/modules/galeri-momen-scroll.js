/**
 * Scroller section "Galeri Momen" (beranda).
 * Dipanggil dari resources/js/app.js -> initGaleriMomenScroll()
 *
 * Track-nya cuma daftar foto yang digandakan 2x (lihat galeri-momen.blade.php)
 * dan digeser lewat scrollLeft ASLI dari .spkn-galeri__viewport -- bukan lagi
 * animasi CSS transform seperti sebelumnya. Alasannya: transform tidak bisa
 * discroll manual oleh user, sedangkan scrollLeft asli otomatis bisa (drag
 * mouse, geser trackpad/touch, scroll wheel horizontal) SEKALIGUS masih bisa
 * digeser otomatis pelan-pelan lewat JS waktu idle.
 *
 * Loop mulus: begitu scrollLeft sampai setengah dari scrollWidth (karena
 * kontennya dobel persis), langsung dikurangi setengah situ juga -- posisi
 * visualnya identik jadi tidak kelihatan "patah"/loncat.
 */
export function initGaleriMomenScroll(root = document) {
  const viewport = root.querySelector(".spkn-galeri__viewport");
  const track = root.querySelector(".spkn-galeri__track");

  if (!viewport || !track) return;

  const prefersReducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)"
  ).matches;

  const AUTO_SPEED = 0.3; // px per frame, kira-kira setara animasi lama (~pelan & tidak bikin pusing)
  const RESUME_DELAY = 800; // ms jeda sebelum auto-scroll jalan lagi setelah user selesai interaksi

  let autoPaused = false;
  let resumeTimer = null;

  const pauseAuto = () => {
    autoPaused = true;
    if (resumeTimer) clearTimeout(resumeTimer);
  };

  const scheduleResume = () => {
    if (resumeTimer) clearTimeout(resumeTimer);
    resumeTimer = setTimeout(() => {
      autoPaused = false;
    }, RESUME_DELAY);
  };

  // --- Loop mulus: reset scrollLeft begitu lewat setengah track ---
  const wrapIfNeeded = () => {
    const half = track.scrollWidth / 2;
    if (half > 0 && viewport.scrollLeft >= half) {
      viewport.scrollLeft -= half;
    }
  };

  viewport.addEventListener("scroll", wrapIfNeeded, { passive: true });

  // --- Auto-scroll pelan waktu idle (kalau user tidak minta motion dikurangi) ---
  if (!prefersReducedMotion) {
    const tick = () => {
      if (!autoPaused) {
        viewport.scrollLeft += AUTO_SPEED;
      }
      requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  }

  // --- Pause pas hover/fokus (mouse diam di atas galeri) ---
  viewport.addEventListener("mouseenter", pauseAuto);
  viewport.addEventListener("mouseleave", () => {
    if (!isDragging) scheduleResume();
  });
  viewport.addEventListener("focusin", pauseAuto);
  viewport.addEventListener("focusout", scheduleResume);

  // --- Drag-to-scroll pakai mouse: klik tahan lalu geser ---
  let isDragging = false;
  let dragStartX = 0;
  let scrollStartLeft = 0;

  viewport.addEventListener("mousedown", (e) => {
    e.preventDefault(); // cegah browser mulai "drag gambar" bawaan pas nge-drag di atas <img>
    isDragging = true;
    dragStartX = e.pageX;
    scrollStartLeft = viewport.scrollLeft;
    viewport.classList.add("is-dragging");
    pauseAuto();
  });

  viewport.addEventListener("dragstart", (e) => e.preventDefault());

  window.addEventListener("mousemove", (e) => {
    if (!isDragging) return;
    const delta = e.pageX - dragStartX;
    viewport.scrollLeft = scrollStartLeft - delta;
  });

  const stopDragging = () => {
    if (!isDragging) return;
    isDragging = false;
    viewport.classList.remove("is-dragging");
    scheduleResume();
  };

  window.addEventListener("mouseup", stopDragging);

  // --- Touch: biarkan browser yang urus scroll aslinya, kita cuma jeda auto-scroll ---
  viewport.addEventListener("touchstart", pauseAuto, { passive: true });
  viewport.addEventListener("touchend", scheduleResume);

  // --- Scroll wheel horizontal (shift+wheel atau trackpad) juga dianggap interaksi manual ---
  viewport.addEventListener(
    "wheel",
    () => {
      pauseAuto();
      scheduleResume();
    },
    { passive: true }
  );
}