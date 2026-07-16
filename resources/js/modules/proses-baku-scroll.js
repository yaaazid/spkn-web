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

  prevBtn?.addEventListener("click", () => {
    scroller.scrollBy({ left: -cardWidth(), behavior: "smooth" });
  });

  nextBtn?.addEventListener("click", () => {
    scroller.scrollBy({ left: cardWidth(), behavior: "smooth" });
  });
}