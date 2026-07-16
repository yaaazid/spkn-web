/**
 * Navbar scroll-compact + tombol "Menu" (off-canvas ala atescape.id).
 * Dipanggil sekali dari resources/js/app.js -> initNavbarScroll()
 *
 * Perilaku:
 * - Landing (scrollY <= SCROLL_THRESHOLD): navbar diam, transparan, semua
 *   menu tampil penuh.
 * - Discroll (scrollY > SCROLL_THRESHOLD): class .is-scrolled ditambah ke
 *   .spkn-navbar-wrap -> lewat CSS, navbar mengecil jadi pill kaca,
 *   nav-list & search disembunyikan, digantikan tombol "Menu".
 * - Tombol "Menu" diklik -> class .is-menu-open ditambah ke .spkn-navbar-root
 *   -> off-canvas sidebar gelap slide dari kiri (CSS), ikon Menu berubah jadi X,
 *   body dikunci supaya tidak ikut scroll di belakang panel.
 * - Item dropdown di dalam off-canvas (mis. "Tentang Kami") jadi accordion,
 *   diklik buka/tutup submenu-nya sendiri.
 *
 * Sengaja dipisah dari navbar-dropdown.js (yang ngurus dropdown/flyout versi
 * desktop) supaya dua concern ini tidak saling tabrakan.
 */
const SCROLL_THRESHOLD = 60; // px

export function initNavbarScroll(root = document) {
  const wrap = root.querySelector(".spkn-navbar-wrap");
  const navRoot = root.querySelector("[data-navbar-root]");
  const menuToggle = root.querySelector("[data-menu-toggle]");
  const menuToggleIcon = root.querySelector("[data-menu-toggle-icon]");
  const backdrop = root.querySelector("[data-offcanvas-backdrop]");

  if (!wrap || !navRoot) return;

  const setMenuIcon = (isOpen) => {
    menuToggleIcon?.classList.toggle("bi-list", !isOpen);
    menuToggleIcon?.classList.toggle("bi-x-lg", isOpen);
  };

  const closeMenuPanel = () => {
    navRoot.classList.remove("is-menu-open");
    menuToggle?.setAttribute("aria-expanded", "false");
    document.body.style.overflow = "";
    setMenuIcon(false);
  };

  const openMenuPanel = () => {
    navRoot.classList.add("is-menu-open");
    menuToggle?.setAttribute("aria-expanded", "true");
    document.body.style.overflow = "hidden"; // kunci scroll belakang off-canvas
    setMenuIcon(true);
  };

  const updateScrollState = () => {
    const isScrolled = window.scrollY > SCROLL_THRESHOLD;
    wrap.classList.toggle("is-scrolled", isScrolled);

    // Balik ke atas (bukan mode ramping lagi di desktop) -> tutup off-canvas
    // kalau kebetulan lagi kebuka, biar tidak nyangkut.
    if (!isScrolled) closeMenuPanel();
  };

  window.addEventListener("scroll", updateScrollState, { passive: true });
  updateScrollState(); // set state awal, mis. kalau halaman di-refresh sambil sudah discroll

  menuToggle?.addEventListener("click", (event) => {
    event.stopPropagation();
    navRoot.classList.contains("is-menu-open") ? closeMenuPanel() : openMenuPanel();
  });

  backdrop?.addEventListener("click", closeMenuPanel);

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeMenuPanel();
  });

  // --- Accordion untuk item dropdown di dalam off-canvas ---
  root.querySelectorAll("[data-offcanvas-group-trigger]").forEach((trigger) => {
    trigger.addEventListener("click", () => {
      trigger.closest("[data-offcanvas-group]")?.classList.toggle("is-open");
    });
  });
}