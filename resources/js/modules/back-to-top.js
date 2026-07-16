/**
 * Tombol "back to top". Dipanggil dari resources/js/app.js -> initBackToTop()
 * Muncul (fade+slide in) setelah discroll melewati SHOW_THRESHOLD, klik
 * scroll halus balik ke atas halaman.
 */
const SHOW_THRESHOLD = 400; // px

export function initBackToTop(root = document) {
  const button = root.querySelector("[data-back-to-top]");
  if (!button) return;

  const updateVisibility = () => {
    button.classList.toggle("is-visible", window.scrollY > SHOW_THRESHOLD);
  };

  window.addEventListener("scroll", updateVisibility, { passive: true });
  updateVisibility();

  button.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
}