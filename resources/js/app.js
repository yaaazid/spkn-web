//
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import { initNavbarDropdown } from "./modules/navbar-dropdown.js";

document.addEventListener("DOMContentLoaded", () => {
  initNavbarDropdown();
  // Modul fitur lain ditambahkan di sini, masing-masing di file terpisah:
  // import { initForumEditor } from "./modules/forum-editor.js";
  // initForumEditor();
});