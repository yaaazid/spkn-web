/**
 * Reveal-on-scroll ("popup" halus saat elemen masuk viewport).
 * Dipanggil dari resources/js/app.js -> initScrollReveal()
 *
 * Markup yang diharapkan: elemen apa pun dengan class "reveal" (lihat
 * partials/_animations.css untuk transition-nya). Begitu elemen terlihat
 * >=15%, class "is-visible" ditambahkan lalu observer berhenti mengamati
 * elemen itu (animasi hanya jalan sekali).
 *
 * Kalau browser tidak dukung IntersectionObserver, semua elemen langsung
 * ditampilkan tanpa animasi supaya konten tetap terbaca.
 */
export function initScrollReveal(root = document) {
  const items = root.querySelectorAll(".reveal");

  if (!("IntersectionObserver" in window) || items.length === 0) {
    items.forEach((item) => item.classList.add("is-visible"));
    return;
  }

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          obs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15, rootMargin: "0px 0px -40px 0px" }
  );

  items.forEach((item) => observer.observe(item));
}