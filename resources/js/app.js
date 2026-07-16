import "bootstrap/dist/js/bootstrap.bundle.min.js";
import { initNavbarDropdown } from "./modules/navbar-dropdown.js";
import { initNavbarScroll } from "./modules/navbar-scroll.js";
import { initProsesBakuScroller } from "./modules/proses-baku-scroll.js";
import { initBackToTop } from "./modules/back-to-top.js";
import { initKalenderSpkn } from "./modules/kalender-spkn.js";
import { initStrukturDownload } from "./modules/struktur-download.js";
import { initScrollReveal } from "./modules/scroll-reveal.js";
import { initRincianTugasTabs } from "./modules/rincian-tugas-tabs.js";

document.addEventListener("DOMContentLoaded", () => {
  initNavbarDropdown();
  initNavbarScroll();
  initProsesBakuScroller();
  initBackToTop();
  initKalenderSpkn();
  initStrukturDownload();
  initScrollReveal();
  initRincianTugasTabs();
  // Modul fitur lain ditambahkan di sini, masing-masing di file terpisah:
  // import { initForumEditor } from "./modules/forum-editor.js";
  // initForumEditor();
});