/**
 * Navbar scroll-compact + tombol "Menu".
 * Dipanggil sekali dari resources/js/app.js -> initNavbarScroll()
 *
 * Perilaku (meniru atescape.id):
 * - Landing (scrollY <= SCROLL_THRESHOLD): navbar diam, transparan, semua
 *   menu tampil penuh.
 * - Discroll (scrollY > SCROLL_THRESHOLD): class .is-scrolled ditambah ke
 *   .spkn-navbar-wrap -> lewat CSS, navbar mengecil jadi pill kaca,
 *   nav-list & search disembunyikan, digantikan tombol "Menu".
 * - Tombol "Menu" diklik -> class .is-menu-open ditambah ke .spkn-navbar,
 *   CSS menampilkan lagi nav-list sebagai panel vertikal di bawah pill.
 *
 * Sengaja dipisah dari navbar-dropdown.js (yang mengurus dropdown/flyout)
 * supaya dua concern ini tidak saling tabrakan kalau salah satunya diubah.
 */
const SCROLL_THRESHOLD = 60; // px

export function initNavbarScroll(root = document) {
  const wrap = root.querySelector(".spkn-navbar-wrap");
  const navbar = root.querySelector(".spkn-navbar");
  const menuToggle = root.querySelector("[data-menu-toggle]");

  if (!wrap || !navbar) return;

  const closeMenuPanel = () => {
    navbar.classList.remove("is-menu-open");
    menuToggle?.setAttribute("aria-expanded", "false");
  };

  const updateScrollState = () => {
    const isScrolled = window.scrollY > SCROLL_THRESHOLD;
    wrap.classList.toggle("is-scrolled", isScrolled);

    // Balik ke atas (bukan mode ramping lagi di desktop) -> tutup panel
    // menu kalau kebetulan lagi kebuka, biar tidak nyangkut.
    if (!isScrolled) closeMenuPanel();
  };

  window.addEventListener("scroll", updateScrollState, { passive: true });
  updateScrollState(); // set state awal, mis. kalau halaman di-refresh sambil sudah discroll

  menuToggle?.addEventListener("click", (event) => {
    event.stopPropagation();
    const willOpen = !navbar.classList.contains("is-menu-open");
    navbar.classList.toggle("is-menu-open", willOpen);
    menuToggle.setAttribute("aria-expanded", String(willOpen));
  });

  document.addEventListener("click", (event) => {
    if (!navbar.contains(event.target)) closeMenuPanel();
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeMenuPanel();
  });
}