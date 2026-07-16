/**
 * Scroller horizontal section "Proses Baku".
 * Dipanggil dari resources/js/app.js -> initProsesBakuScroller()
 *
 * Ngurus 2 hal:
 * - Sinkronisasi lebar & posisi thumb scrollbar custom (.spkn-proses__scrollbar-thumb)
 *   dengan scrollLeft/scrollWidth asli dari .spkn-proses__scroller.
 * - Tombol panah kiri/kanan (data-proses-prev / data-proses-next) buat geser
 *   satu kartu per klik.
 */
export function initProsesBakuScroller(root = document) {
  const scroller = root.querySelector("[data-proses-scroller]");
  const thumb = root.querySelector("[data-proses-thumb]");
  const track = root.querySelector("[data-proses-track]");
  const prevBtn = root.querySelector("[data-proses-prev]");
  const nextBtn = root.querySelector("[data-proses-next]");

  if (!scroller || !thumb || !track) return;

  const updateThumb = () => {
    const { scrollLeft, scrollWidth, clientWidth } = scroller;
    const thumbWidthRatio = clientWidth / scrollWidth;
    const maxScroll = scrollWidth - clientWidth;
    const scrollRatio = maxScroll > 0 ? scrollLeft / maxScroll : 0;

    const trackWidth = track.clientWidth;
    const thumbWidth = Math.max(thumbWidthRatio * trackWidth, 32); // minimal 32px biar tetap keklik
    const maxThumbOffset = trackWidth - thumbWidth;

    thumb.style.width = `${thumbWidth}px`;
    thumb.style.transform = `translateX(${scrollRatio * maxThumbOffset}px)`;
  };

  const cardWidth = () => {
    const firstCard = scroller.querySelector(".spkn-proses__card");
    return firstCard ? firstCard.getBoundingClientRect().width + 18 : 200; // +gap
  };

  scroller.addEventListener("scroll", updateThumb, { passive: true });
  window.addEventListener("resize", updateThumb);
  updateThumb();

  // --- Drag-to-scroll pakai mouse: klik tahan di area scroller lalu geser ---
  let isDragging = false;
  let dragStartX = 0;
  let scrollStartLeft = 0;
  let hasMoved = false; // buat bedain "klik tahan lalu geser" vs "klik kartu biasa"

  scroller.addEventListener("mousedown", (e) => {
    isDragging = true;
    hasMoved = false;
    dragStartX = e.pageX;
    scrollStartLeft = scroller.scrollLeft;
    scroller.classList.add("is-dragging");
  });

  window.addEventListener("mousemove", (e) => {
    if (!isDragging) return;
    const delta = e.pageX - dragStartX;
    if (Math.abs(delta) > 4) hasMoved = true; // toleransi kecil biar klik biasa tidak ke-anggap drag
    scroller.scrollLeft = scrollStartLeft - delta;
  });

  const stopDragging = () => {
    if (!isDragging) return;
    isDragging = false;
    scroller.classList.remove("is-dragging");
  };

  window.addEventListener("mouseup", stopDragging);
  scroller.addEventListener("mouseleave", stopDragging);

  // Cegah link/kartu ke-klik tidak sengaja begitu selesai drag (mouse dilepas
  // setelah bergeser cukup jauh dianggap drag, bukan klik).
  scroller.addEventListener(
    "click",
    (e) => {
      if (hasMoved) {
        e.preventDefault();
        e.stopPropagation();
      }
    },
    { capture: true }
  );

  prevBtn?.addEventListener("click", () => {
    scroller.scrollBy({ left: -cardWidth(), behavior: "smooth" });
  });

  nextBtn?.addEventListener("click", () => {
    scroller.scrollBy({ left: cardWidth(), behavior: "smooth" });
  });

  // --- Drag-to-scroll di scrollbar custom: klik tahan thumb-nya lalu geser ---
  let isThumbDragging = false;
  let thumbStartX = 0;
  let scrollStartLeftForThumb = 0;

  thumb.addEventListener("mousedown", (e) => {
    isThumbDragging = true;
    thumbStartX = e.pageX;
    scrollStartLeftForThumb = scroller.scrollLeft;
    thumb.classList.add("is-dragging");
    scroller.classList.add("is-dragging"); // pinjam style scroll-behavior:auto biar ikut mouse pas
    e.preventDefault(); // cegah browser nge-drag thumb sebagai gambar/teks
  });

  window.addEventListener("mousemove", (e) => {
    if (!isThumbDragging) return;

    const trackWidth = track.clientWidth;
    const thumbWidth = thumb.offsetWidth;
    const maxThumbOffset = trackWidth - thumbWidth;
    const maxScroll = scroller.scrollWidth - scroller.clientWidth;

    if (maxThumbOffset <= 0 || maxScroll <= 0) return;

    const deltaX = e.pageX - thumbStartX;
    const scrollRatio = deltaX / maxThumbOffset;
    scroller.scrollLeft = scrollStartLeftForThumb + scrollRatio * maxScroll;
  });

  const stopThumbDragging = () => {
    if (!isThumbDragging) return;
    isThumbDragging = false;
    thumb.classList.remove("is-dragging");
    scroller.classList.remove("is-dragging");
  };

  window.addEventListener("mouseup", stopThumbDragging);

  // Klik langsung di track (bukan di thumb-nya) -> lompat ke posisi itu
  track.addEventListener("mousedown", (e) => {
    if (e.target === thumb || thumb.contains(e.target)) return; // biar tidak bentrok sama drag thumb

    const trackRect = track.getBoundingClientRect();
    const thumbWidth = thumb.offsetWidth;
    const maxThumbOffset = trackRect.width - thumbWidth;
    const maxScroll = scroller.scrollWidth - scroller.clientWidth;

    if (maxThumbOffset <= 0 || maxScroll <= 0) return;

    const clickX = e.clientX - trackRect.left - thumbWidth / 2;
    const clampedX = Math.min(Math.max(clickX, 0), maxThumbOffset);
    scroller.scrollTo({ left: (clampedX / maxThumbOffset) * maxScroll, behavior: "smooth" });
  });
}