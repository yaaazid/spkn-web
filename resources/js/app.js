import "bootstrap/dist/js/bootstrap.bundle.min.js";
import { initNavbarDropdown } from "./modules/navbar-dropdown.js";
import { initNavbarScroll } from "./modules/navbar-scroll.js";
import { initProsesBakuScroller } from "./modules/proses-baku-scroll.js";

document.addEventListener("DOMContentLoaded", () => {
  initNavbarDropdown();
  initNavbarScroll();
  initProsesBakuScroller();
  // Modul fitur lain ditambahkan di sini, masing-masing di file terpisah:
  // import { initForumEditor } from "./modules/forum-editor.js";
  // initForumEditor();
});