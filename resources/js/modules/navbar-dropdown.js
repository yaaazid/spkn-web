/**
 * Navbar dropdown + flyout controller.
 * Dipanggil sekali dari resources/js/app.js -> initNavbarDropdown()
 *
 * Markup yang diharapkan (lihat partials/navbar/navbar.blade.php):
 *   <li class="spkn-nav-item" data-dropdown>
 *     <button data-dropdown-trigger>...</button>
 *     <div class="spkn-dropdown" data-dropdown-panel>
 *       <li class="spkn-dropdown__item" data-flyout>
 *         <a data-flyout-trigger>...</a>
 *         <div class="spkn-flyout" data-flyout-panel>...</div>
 *       </li>
 *     </div>
 *   </li>
 */
export function initNavbarDropdown(root = document) {
  const dropdownItems = root.querySelectorAll("[data-dropdown]");

  const closeAllDropdowns = (except = null) => {
    dropdownItems.forEach((item) => {
      if (item !== except) {
        item.classList.remove("is-open");
        item.querySelector("[data-dropdown-trigger]")?.classList.remove("is-open");
      }
    });
  };

  dropdownItems.forEach((item) => {
    const trigger = item.querySelector("[data-dropdown-trigger]");
    if (!trigger) return;

    trigger.addEventListener("click", (event) => {
      event.stopPropagation();
      const willOpen = !item.classList.contains("is-open");
      closeAllDropdowns();
      item.classList.toggle("is-open", willOpen);
      trigger.classList.toggle("is-open", willOpen);
      trigger.setAttribute("aria-expanded", String(willOpen));
    });

    // Flyout tingkat dua (mis. "Struktur Tim Teknis") — dibuka lewat hover,
    // dengan fallback klik untuk perangkat sentuh.
    const flyoutItems = item.querySelectorAll("[data-flyout]");
    flyoutItems.forEach((flyoutItem) => {
      const openFlyout = () => {
        flyoutItems.forEach((f) => f.classList.remove("is-flyout-open"));
        flyoutItem.classList.add("is-flyout-open");
      };

      flyoutItem.addEventListener("mouseenter", openFlyout);
      flyoutItem.addEventListener("focusin", openFlyout);

      const flyoutTrigger = flyoutItem.querySelector("[data-flyout-trigger]");
      flyoutTrigger?.addEventListener("click", (event) => {
        if (flyoutItem.querySelector("[data-flyout-panel]")) {
          event.preventDefault();
          openFlyout();
        }
      });
    });
  });

  document.addEventListener("click", () => closeAllDropdowns());
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeAllDropdowns();
  });
}