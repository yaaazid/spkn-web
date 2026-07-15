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
const WIDTH_TRANSITION_MS = 320; // durasi animasi resize pill, sinkron dgn CSS .is-animating-width

export function initNavbarScroll(root = document) {
  const wrap = root.querySelector(".spkn-navbar-wrap");
  const navbar = root.querySelector(".spkn-navbar");
  const menuToggle = root.querySelector("[data-menu-toggle]");

  if (!wrap || !navbar) return;

  const prefersReducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)"
  ).matches;

  const closeMenuPanel = () => {
    navbar.classList.remove("is-menu-open");
    menuToggle?.setAttribute("aria-expanded", "false");
  };

  /**
   * Animasi lebar pill navbar pakai teknik FLIP (measure sebelum & sesudah,
   * lalu tween lewat inline style `width`).
   *
   * Ini diperlukan karena `applyStateChange` mengubah class .is-scrolled,
   * yang lewat CSS mengganti `max-width` pill dari nilai px tetap ke
   * keyword `fit-content` (dan sebaliknya). Browser TIDAK menganimasikan
   * transisi ke/dari keyword seperti `fit-content`/`auto` secara mulus —
   * nilainya langsung "melompat" ke ukuran akhir. Makanya lebar awal &
   * akhir diukur manual di sini, lalu di-tween lewat `width` (angka px
   * murni) yang bisa dianimasikan browser mana pun.
   */
  const animateWidthChange = (applyStateChange) => {
    if (prefersReducedMotion) {
      applyStateChange();
      return;
    }

    const startWidth = navbar.getBoundingClientRect().width;

    applyStateChange();

    const endWidth = navbar.getBoundingClientRect().width;

    if (Math.abs(endWidth - startWidth) < 1) return;

    // Kunci ke lebar awal dulu tanpa transisi...
    navbar.classList.remove("is-animating-width");
    navbar.style.width = `${startWidth}px`;
    void navbar.offsetWidth; // paksa reflow supaya lebar awal ke-"commit"

    // ...baru nyalakan transisi & tuju ke lebar akhir di frame berikutnya.
    requestAnimationFrame(() => {
      navbar.classList.add("is-animating-width");
      navbar.style.width = `${endWidth}px`;
    });

    const cleanup = (event) => {
      if (event && (event.target !== navbar || event.propertyName !== "width")) {
        return;
      }
      navbar.style.width = "";
      navbar.classList.remove("is-animating-width");
      navbar.removeEventListener("transitionend", cleanup);
    };

    navbar.addEventListener("transitionend", cleanup);
    // Jaring pengaman kalau transitionend tidak pernah ke-trigger.
    window.setTimeout(cleanup, WIDTH_TRANSITION_MS + 80);
  };

  const updateScrollState = () => {
    const isScrolled = window.scrollY > SCROLL_THRESHOLD;

    // Tidak ada perubahan state -> jangan animasikan (mis. tiap event scroll biasa)
    if (wrap.classList.contains("is-scrolled") === isScrolled) return;

    animateWidthChange(() => {
      wrap.classList.toggle("is-scrolled", isScrolled);
    });

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